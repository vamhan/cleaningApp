<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class __ps_equipment extends Admin_Controller {

	function __construct(){
		parent::__construct();

        $this->permission_check('equipment_return');

		//TODO :: Move this to admin controller later 

		#CMS
		$this->pageSize = PAGESIZE;
		$this->table = 'tbt_equipment_return_document';
		$this->page_id = 'ps_generation';
		$this->page_title = freetext('equipment_return');
		$this->page_object = 'API';
		$this->page_controller = '__ps_equipment';

		//set lang
		$this->session->set_userdata('lang', 'th');
		
		#END_CMS
		
		$this->load->model('__ps_project_query');
		$this->load->model('__equipment_model');
		$this->load->model('__equipment_requisition_model');
		// $this->load->config('backend_navigation');
		// $this->navigation = $this->config->item('backend_navigation');
		// var_dump($this->navigation);
	}//end constructor;


	 public function permission_trace(){
        $this->trace($this->session->userdata('permission_set'));
    }


	//Default
	function index($id=''){
		
		//GET :: project id
		$this->project_id  = $id;
		//echo $this->project_id;	

		//TODO :: redirecting to listview
		redirect(site_url($this->page_controlle.'/listview/list/'.$this->project_id), 'refresh');
	}

	function changePageSize( $newPageSize = PAGESIZE ){
		$newValue = array('current_page'=> $newPageSize);
		$this->session->set_userdata($newValue);
		// $this->trace($newValue);

		$callback_url = $this->session->userdata('current_url');
		
		// $this->trace($callback_url);
		if(!empty($callback_url))
			redirect($callback_url,'refresh');
	}


	//function com_listview : act / id 
	function listview($act='',$id ='',$object_category_id='',$object_id='',$page=1, $keyword=''){
		
		$data = array();
		$list = array();	
				
		
		// var_dump($this->session->userdata('permission_set'));
		switch ($act) { // to tbt_proto_item


			case 'list':
					//TODO :: select list of equipment return
					//echo $this->page_controller.'<br>';
					 $this->project_id  = urldecode($id);
					//exit();	
					$list = $this->__equipment_model->getContentList($page,$id);
					//get date abort
					$quotation = $this->__ps_project_query->getObj('tbt_quotation', array('id' => $id));
					$this->is_abort = $quotation['is_abort_date'];
					//echo 'isabort : '.$quotation['is_abort'].' '.$quotation['is_abort_date'];


					$list['AllClearJob'] = $this->__equipment_model->getClearJob($id);
					$list['FullTimeJob'] = $this->__equipment_model->getFullTimeJob($id);
					$list['PartTimeJob'] = $this->__equipment_model->getPartTimeJob($id);

					$menuConfig['page_title'] = 'PS Generation';
					$menuConfig['page_id'] 	  = 'ps_generation';

					//Load top menu
					$menuConfig = array('page_id'=>1,'pid'=>$id);
					$data['top_menu'] = $this->load->view('__project/include/top',$menuConfig,true);

					$input = array(	 
									array("IMPORT","I_CONTRACT", $list['result']['project']['contract_id']),
									/*array("IMPORT","I_FROM", "20141001"),
									array("IMPORT","I_TO", "20141101"),*/
									array("TABLE","ET_VBAK",array()),
									array("TABLE","ET_BREAKDOWN",array())
							);
					$list['sale_order_list'] = $this->callSAPFunction("ZRFC_SD_GET_BREAKDOWN", $input);

					//Load side menu
					$data['side_menu'] = $this->load->view('__project/include/side',$menuConfig,true);


					$list['max_part'] = $this->__equipment_model->getMaxPart($this->project_id);

					//Load top project
					$this->load->model('__ps_project_query');
					$info['result']['id'] = $id;
					$contentInfo = $this->__ps_project_query->getContentById($id);
					$info['detail'] = $contentInfo['result'][0];	
					$projectContact = $this->__ps_project_query->getProjectContacts($id);
					$info['contact_list'] = $projectContact['result'];
					$attachDocument = $this->__ps_project_query->getAttachDocumentList($id);
			        $info['ducument_list'] = $attachDocument['result'];
					$info['result']['view'] = $this->load->view('__project/page/detail_bodycfg_all',$info,true);


					$data['top_project'] = $this->load->view('__equipment/include/top_project',$info,true);


					$list['contentInfo'] = $contentInfo['result'][0];
					$data['modal'] = $this->load->view('__equipment/page/list_modal',$list,true);//return view as data

					$list['permission'] = $this->permission[$this->cat_id];
					//Load body
					$data['body'] = $this->load->view('__equipment/page/list_bodycfg',$list,true);

					// //Load footage script
					$data['footage_script'] = '';


					$this->load->view('__equipment/layout/list',$data);

					//exit();
				break;	

		}

	}

	function detail($act='',$project_id='',$id=0 ){
		$data = array();
		$body = array();		
		
		$this->page_title = freetext('equipment_return').' - ['.$id.']';
		switch ($act) { // to tbt_proto_item

			case 'edit':
			//TODO :: insert fix claim	

				// $this->status  = $status;
				$this->project_id  = $project_id;
				// $this->track_doc_id  = $id;

				$menuConfig['page_title'] = 'API Manager';
				$menuConfig['page_id'] 	  = 'api_manager';


				//#############  Query #########################################################################
				//Assign parameter for modal

				$list['equipment_doc'] = $this->__equipment_model->getContentById($this->table,$id);

				$permission = $this->permission[$this->cat_id];
				if (!array_key_exists('edit', $permission) || $list['equipment_doc']['submit_date_sap'] != '0000-00-00') {
					redirect(site_url('__ps_equipment/listview/list/'.$project_id), 'refresh');
				}

				$list['equipment_items'] = $this->__equipment_model->getEquipmentItems($id);
				$list['query_owner'] = $this->__ps_project_query->get_project_owner($this->project_id);
				$list['AllClearJob'] = $this->__equipment_model->getClearJob($project_id);
				//####################################################################################################				

				$menuConfig = array('page_id'=>1,'pid'=>$project_id);
				$data['top_menu'] = $this->load->view('__project/include/top',$menuConfig,true);

				// //Load side menu
				 $this->load->model('__ps_project_query');
				 $data['side_menu'] = $this->load->view('__project/include/side',$menuConfig,true);

				//Load top project
				$info['result']['id'] = $project_id;
				$contentInfo = $this->__ps_project_query->getContentById($project_id);
				$info['detail'] = $contentInfo['result'][0];	
				$projectContact = $this->__ps_project_query->getProjectContacts($project_id);
				$info['contact_list'] = $projectContact['result'];
				$attachDocument = $this->__ps_project_query->getAttachDocumentList($project_id);
		        $info['ducument_list'] = $attachDocument['result'];
				$info['result']['view'] = $this->load->view('__project/page/detail_bodycfg_all',$info,true);

				$data['top_project'] = $this->load->view('__equipment/include/top_project',$info,true);

				//Update zsd_ship_to
				$ship_to_input = array(	 
								array("IMPORT","I_SHIP_TO", $list['equipment_doc']['ship_to_id']),
								array("TABLE","ET_ZSD_SHIP_TO",array()),
						);
				$zsd_ship_to = $this->callSAPFunction("ZRFC_GET_SHIP_TO", $ship_to_input);

				$this->__equipment_requisition_model->updateZSDShipto($zsd_ship_to, $list['equipment_doc']['ship_to_id']);

				$input = array(	 
								array("IMPORT","I_CONTRACT", $list['equipment_doc']['contract_id']),
								/*array("IMPORT","I_FROM", "20141001"),
								array("IMPORT","I_TO", "20141101"),*/
								array("TABLE","ET_VBAK",array()),
								array("TABLE","ET_BREAKDOWN",array())
						);
				$list['sale_order_list'] = $this->callSAPFunction("ZRFC_SD_GET_BREAKDOWN", $input);

				$list['project_material_list']  = $this->__equipment_model->getProjectMaterial($list['equipment_doc']['ship_to_id']);

				$list['project_asset_material_list']  = $this->__equipment_model->getProjectAssetMaterial($list['equipment_doc']['ship_to_id']);

				//Load body
				$data['body'] = $this->load->view('__equipment/page/detail_bodycfg',$list,true);

				$data['modal'] = $this->load->view('__equipment/page/detail_modal',$list,true);//return view as data
				// //Load footage script
				// $data['footage_script'] ='';//$this->load->view('__cms/script/api/api_manager_js','',true);				

				$this->load->view('__equipment/layout/detail',$data);

				
			break;

			case 'view':
				
				// $this->status  = $status;
				$this->project_id  = $project_id;
				// $this->track_doc_id  = $id;

				$menuConfig['page_title'] = 'API Manager';
				$menuConfig['page_id'] 	  = 'api_manager';


				//#############  Query #########################################################################
				//Assign parameter for modal

				$list['equipment_doc'] = $this->__equipment_model->getContentById($this->table,$id);
				$list['equipment_items'] = $this->__equipment_model->getEquipmentItems($id);
				$list['query_owner'] = $this->__ps_project_query->get_project_owner($this->project_id);
				$list['AllClearJob'] = $this->__equipment_model->getClearJob($project_id);

				$permission = $this->permission[$this->cat_id];
				if (!array_key_exists('view', $permission) || empty($list['equipment_doc'])) {
					redirect(site_url('__ps_equipment/listview/list/'.$project_id), 'refresh');
				}
				//####################################################################################################				

				$menuConfig = array('page_id'=>1,'pid'=>$project_id);
				$data['top_menu'] = $this->load->view('__project/include/top',$menuConfig,true);

				// //Load side menu
				 $this->load->model('__ps_project_query');
				 $data['side_menu'] = $this->load->view('__project/include/side',$menuConfig,true);

				//Load top project
				$info['result']['id'] = $project_id;
				$contentInfo = $this->__ps_project_query->getContentById($project_id);
				$info['detail'] = $contentInfo['result'][0];	
				$projectContact = $this->__ps_project_query->getProjectContacts($project_id);
				$info['contact_list'] = $projectContact['result'];
				$attachDocument = $this->__ps_project_query->getAttachDocumentList($project_id);
		        $info['ducument_list'] = $attachDocument['result'];
				$info['result']['view'] = $this->load->view('__project/page/detail_bodycfg_all',$info,true);

				$data['top_project'] = $this->load->view('__equipment/include/top_project',$info,true);

				$input = array(	 
								array("IMPORT","I_CONTRACT", $list['equipment_doc']['contract_id']),
								/*array("IMPORT","I_FROM", "20141001"),
								array("IMPORT","I_TO", "20141101"),*/
								array("TABLE","ET_VBAK",array()),
								array("TABLE","ET_BREAKDOWN",array())
						);
				$list['sale_order_list'] = $this->callSAPFunction("ZRFC_SD_GET_BREAKDOWN", $input);

				$list['project_material_list']  = $this->__equipment_model->getProjectMaterial($project_id);
				$list['project_asset_material_list']  = $this->__equipment_model->getProjectAssetMaterial($project_id);

				//Load body
				$data['body'] = $this->load->view('__equipment/page/view_bodycfg',$list,true);

				$data['modal'] = $this->load->view('__equipment/page/detail_modal',$list,true);//return view as data
				// //Load footage script
				// $data['footage_script'] ='';//$this->load->view('__cms/script/api/api_manager_js','',true);				

				$this->load->view('__equipment/layout/view',$data);

				
			break;
			
			default:			

				break;
		}

			
	}

	function create_List_equipment_return(){

		$p = $this->input->post();

		if(!empty($p)){

			//echo $p['project_id'];
			//exit();
			$project_id = $p['project_id'];		

			$this->__equipment_model->insert_list_equipment_return($p); 
		}

		redirect(site_url('__ps_equipment/listview/list/'.$project_id), 'refresh');

		//echo $msg;

	}

	function update_return_document () {
		$p = $this->input->post();

		$this->updateDocLog('tbt_equipment_return_document', $p['id']);
		
		$project = $this->__ps_project_query->getObj('tbt_quotation', array('id' => $p['project_id']));
		$doc = $this->__ps_project_query->getObj('tbt_equipment_return_document', array('equipment_doc_id' => $p['id']));

		$map_item_category = array(
			'ZTAA' => 'ZREA',
			'ZTAB' => 'ZREB',
			'ZTA1' => 'ZRE1',
			'ZTA2' => 'ZRE2',
			'ZTA3' => 'ZRE3',
			'ZTA4' => 'ZRE4',
			'ZTA5' => 'ZRE5'
		);

		$item_category = $map_item_category[$p['job_cat_id']];

		$doc_data = array(
			'equipment_doc_id' 	=> $p['id'],
			'order_type' 		=> $p['job_type_id'],
			'item_category'		=> $item_category,
			'return_date' 		=> $p['return_date'],
			'actual_date' 		=> $p['actual_date'],
			'inspector_id'		=> $p['actor_id'],
			'remark' 			=> $p['remark'],
			'quotation_id' 		=> $p['project_id'],
			'ship_to_id' 		=> $p['ship_to_id'],
			'contract_id'		=> $doc['contract_id'],
			'equipment_sale_order_id' => $p['equipment_sale_order_id'],
			'asset_sale_order_id'	  => $p['asset_sale_order_id']
		);

		$this->__ps_project_query->updateObj('tbt_equipment_return_document', array('equipment_doc_id' => $p['id']), $doc_data);

		$sap_equipment_remark_text = array();
		$sap_asset_remark_text = array();

		$doc_remark = array(
			"DOC_NUMBER" 	=> $p['id'],
			"TEXT_ID" 		=> "9001",
			"LANGU"			=> "2",
			"TEXT_LINE"		=> iconv("UTF-8", "TIS-620",$p['remark'])
		);

		array_push($sap_equipment_remark_text, $doc_remark);
		array_push($sap_asset_remark_text, $doc_remark);

		$quantity_list = preg_grep("/^quantity_/",array_keys($p));      

        $this->__ps_project_query->deleteObj('tbt_equipment_return', array('equipment_return_document_id' => $p['id']));

		$this->db->where('equipment_doc_id', $p['id']);
		$query = $this->db->get('tbt_equipment_return_document');
		$doc_obj = $query->row_array();
		$asset_doc_id = $doc_obj['asset_doc_id'];

		$sap_equipment_items = array();
		$item_equipment_schedules  = array();
		$sap_asset_items = array();
		$item_asset_schedules  = array();

		$items  = array();
		$sap_eq_item_no = 10;
		$sap_asset_item_no = 10;
		$has_asset = 0;
		foreach ($quantity_list as $key) {
			$parts = explode('_', $key);
			$type  = $parts[1];
			$code  = $parts[2];
			$padd_code  = $this->_padZero($code, 18);

			if ($type == 'Z018' || $type == 'Z019') {

				$padd_code = str_replace('-', '.', $code);
				$has_asset = 1;
		        if ($p['job_type_id'] == "ZORZ") { 
					$item_category = "ZKAO";
		        } else {
					$item_category = "ZKAN";
		        }

				if (!empty($doc_obj) && empty($asset_doc_id)) {
			        if ($p['job_type_id'] == "ZORZ") {
			      		$asset_doc_id = '5220000000';
			      		$this->db->select_max('asset_doc_id');
			            $this->db->where('order_type', 'ZORZ');
			            $this->db->where('asset_doc_id IS NOT NULL');
			            $this->db->order_by('asset_doc_id desc');
			            $query_last_asset_doc_id=$this->db->get('tbt_equipment_return_document'); 
			            $row = $query_last_asset_doc_id->row_array();
						if (!empty($row['asset_doc_id'])){               
				           $last_doc_id =  $row['asset_doc_id'];
				           $asset_doc_id = $last_doc_id + 1;
				        }
			        } else {
			      		$asset_doc_id = '5210000000';  
			      		$this->db->select_max('asset_doc_id');
			            $this->db->where('order_type !=', 'ZORZ');
			            $this->db->where('asset_doc_id IS NOT NULL');
			            $query_last_asset_doc_id=$this->db->get('tbt_equipment_return_document'); 
			            $row = $query_last_asset_doc_id->row_array();
			            if (!empty($row['asset_doc_id'])){               
				           $last_doc_id =  $row['asset_doc_id'];
				           $asset_doc_id = $last_doc_id + 1;
				        }
			        }

			        $asset_data = array (
			        	'asset_doc_id' => $asset_doc_id
			        );
					$this->__ps_project_query->updateObj('tbt_equipment_return_document', array('equipment_doc_id' => $p['id']), $asset_data);
				}

				// START : SAP AREA
				$item_remark = array(
					"DOC_NUMBER" 	=> $p['id'],
					"ITM_NUMBER" 	=> $this->_padZero($sap_asset_item_no, 6),
					"TEXT_ID" 		=> "0001",
					"LANGU"			=> "2",
					"TEXT_LINE"		=> iconv("UTF-8", "TIS-620",$p['remark_'.$type.'_'.$code])
				);
				array_push($sap_asset_remark_text, $item_remark);

				$sap_item = array(
					"ITM_NUMBER" => $this->_padZero($sap_asset_item_no, 6),
					"MATERIAL" 	 => $padd_code,
					"ITEM_CATEG" => $item_category
				);

				array_push($sap_asset_items, $sap_item);

				//$quantity = number_format($p['quantity_'.$type.'_'.$code]);

				$schedule = array (
					"ITM_NUMBER" => $this->_padZero($sap_asset_item_no, 6),
					"REQ_QTY"	 => $p['quantity_'.$type.'_'.$code] 
				);	
				array_push($item_asset_schedules, $schedule);
				// END : SAP AREA
				$sap_asset_item_no+=10;

			} else {
				// START : SAP AREA
				$item_remark = array(
					"DOC_NUMBER" 	=> $p['id'],
					"ITM_NUMBER" 	=> $this->_padZero($sap_eq_item_no, 6),
					"TEXT_ID" 		=> "0001",
					"LANGU"			=> "2",
					"TEXT_LINE"		=> iconv("UTF-8", "TIS-620",$p['remark_'.$type.'_'.$code])
				);
				array_push($sap_equipment_remark_text, $item_remark);

				$item_padd_code = $padd_code;
				if ($type == 'Z002' || $type == 'Z014') {
					$c = defill($padd_code);
					$c = "1".$c;
					$item_padd_code = $this->_padZero($c, 18);
				}

				$sap_item = array(
					"ITM_NUMBER" => $this->_padZero($sap_eq_item_no, 6),
					"MATERIAL" 	 => $item_padd_code,
					"ITEM_CATEG" => $item_category
				);

				array_push($sap_equipment_items, $sap_item);

				//$quantity = number_format($p['quantity_'.$type.'_'.$code]);

				$schedule = array (
					"ITM_NUMBER" => $this->_padZero($sap_eq_item_no, 6),
					"REQ_QTY"	 => $p['quantity_'.$type.'_'.$code] 
				);	
				array_push($item_equipment_schedules, $schedule);
				// END : SAP AREA
				$sap_eq_item_no+=10;
			}

			$item = array(
				'equipment_return_document_id' 	=> $p['id'],
				'material_no'			  		=> $padd_code,
				'material_description'	 	 	=> $p['desc_'.$type.'_'.$code],
				'material_type'			  		=> $type,
				'quantity'				  		=> $p['quantity_'.$type.'_'.$code],
				'unit_code'				  		=> $p['unit_code_'.$type.'_'.$code],
				'unit_text'				  		=> $p['unit_text_'.$type.'_'.$code],
				'remark'	  			  		=> $p['remark_'.$type.'_'.$code]
			);

			$this->__ps_project_query->insertObj('tbt_equipment_return', $item);
			
		}

		if ($has_asset == 0) {
	        $asset_data = array (
	        	'asset_doc_id' => ''
	        );
			$this->__ps_project_query->updateObj('tbt_equipment_return_document', array('equipment_doc_id' => $p['id']), $asset_data);
		}

		$partners = array();

		$partner1 = array(
			"PARTN_ROLE" => "AG",
			"PARTN_NUMB" => $project['sold_to_id']
		);

		$partner2 = array(
			"PARTN_ROLE" => "WE",
			"PARTN_NUMB" => $project['ship_to_id']
		);

		array_push($partners, $partner1);
		array_push($partners, $partner2);

		$map_type = array(
			"ZORX" => "ZREX",
			"ZORY" => "ZREY",
			"ZORZ" => "ZREZ"
		);

		$ship_to_data = $this->__ps_project_query->getObj('sap_tbm_ship_to', array('id' => $project['ship_to_id']));

		$return_header_in = array(
			"DOC_TYPE" 			=> $map_type[$p['job_type_id']],
			"SALES_ORG" 		=> "1000",
			"DISTR_CHAN" 		=> $ship_to_data['ship_to_distribution_channel'],
			"DIVISION" 			=> "11",
			"REF_DOC" 			=> $p['equipment_sale_order_id'],
			"REQ_DATE_H" 		=> $this->_dateFormat($p['return_date']),
			"DOC_DATE"	 		=> $this->_dateFormat(date('Y-m-d')),
			'REFDOC_CAT'		=> 'C'
		);

		$return_header_inx = array(
			"DOC_TYPE" 			=> 'X',
			"SALES_ORG" 		=> 'X',
			"DISTR_CHAN" 		=> 'X',
			"DIVISION" 			=> 'X',
			"PURCH_NO_C" 		=> 'X',
			"REF_DOC" 			=> 'X',
			"REQ_DATE_H" 		=> 'X',
			"DOC_DATE"	 		=> 'X',
			'REFDOC_CAT'		=> 'X'
		);

		$equipment_input = array(	
			array("IMPORT","SALESDOCUMENTIN",$p['id']),
			array("IMPORT","RETURN_HEADER_IN", $return_header_in),
			array("IMPORT","RETURN_HEADER_INX", $return_header_inx),
			array("TABLE","RETURN_ITEMS_IN", $sap_equipment_items),
			array("TABLE","RETURN_PARTNERS", $partners),
			array("TABLE","RETURN_SCHEDULES_IN", $item_equipment_schedules),
			array("TABLE","RETURN_TEXT", $sap_equipment_remark_text),
			array("TABLE","RETURN", array())
		);

		if (!empty($p['submit']) && $p['submit'] == 1) {

			$result = $this->callSAPFunction("BAPI_CUSTOMERRETURN_CREATE", $equipment_input);

			if (!empty($result['RETURN'])) {
				foreach ($result['RETURN'] as $key => $value) {
					if ($value['TYPE'] == "E") {
						// echo "<pre>";
						// print_r($equipment_input);
						// echo "</pre>";
						echo $value['MESSAGE'];
						echo "<br><a href='".site_url("__ps_equipment/detail/edit/".$p['project_id']."/".$p['id'])."'><button>Back</button></a>";
						die();
					}
				}
			}
			
			$this->callSAPFunction("BAPI_TRANSACTION_COMMIT", array());

	        $update_submit_data = array (
	        	'submit_date_sap' => date('Y-m-d')
	        );
			$this->__ps_project_query->updateObj('tbt_equipment_return_document', array('equipment_doc_id' => $p['id']), $update_submit_data);
		}


		if ($has_asset == 1) {

			if ($p['job_type_id'] == "ZORZ") {
				$doc_type = "ZSP2";
			} else {
				$doc_type = "ZSP1";
			}

			$asset_return_header_in = array(
				"DOC_TYPE" 			=> $doc_type,
				"SALES_ORG" 		=> "1000",
				"DISTR_CHAN" 		=> $ship_to_data['ship_to_distribution_channel'],
				"DIVISION" 			=> "11",
				"REF_DOC" 			=> $p['asset_sale_order_id'],
				"REQ_DATE_H" 		=> $this->_dateFormat($p['return_date']),
				"DOC_DATE"	 		=> $this->_dateFormat(date('Y-m-d')),
				'REFDOC_CAT'		=> 'C'
			);

			$asset_return_header_inx = array(
				"DOC_TYPE" 			=> 'X',
				"SALES_ORG" 		=> 'X',
				"DISTR_CHAN" 		=> 'X',
				"DIVISION" 			=> 'X',
				"PURCH_NO_C" 		=> 'X',
				"REF_DOC" 			=> 'X',
				"REQ_DATE_H" 		=> 'X',
				"DOC_DATE"	 		=> 'X',
				'REFDOC_CAT'		=> 'X'
			);

			$asset_input = array(	
				array("IMPORT","SALESDOCUMENTIN",$asset_doc_id),
				array("IMPORT","RETURN_HEADER_IN", $asset_return_header_in),
				array("IMPORT","RETURN_HEADER_INX", $asset_return_header_inx),
				array("TABLE","RETURN_ITEMS_IN", $sap_asset_items),
				array("TABLE","RETURN_PARTNERS", $partners),
				array("TABLE","RETURN_TEXT", $sap_asset_remark_text),
				array("TABLE","RETURN_SCHEDULES_IN", $item_asset_schedules),
				array("TABLE","RETURN", array())
			);

			if (!empty($p['submit']) && $p['submit'] == 1) {

				$result = $this->callSAPFunction("BAPI_CUSTOMERRETURN_CREATE", $asset_input);	
				if (!empty($result['RETURN'])) {
					foreach ($result['RETURN'] as $key => $value) {
						if ($value['TYPE'] == "E") {
							echo $value['MESSAGE'];
							echo "<br><a href='".site_url("__ps_equipment/detail/edit/".$p['project_id']."/".$p['id'])."'><button>Back</button></a>";
							die();
						}
					}
				}					
				$this->callSAPFunction("BAPI_TRANSACTION_COMMIT", array());
			}

		}

        if (!empty($p['submit']) && $p['submit'] == 1) {
         	echo '<script> window.location="'.site_url('__ps_equipment/listview/list/'.$p['project_id']).'"; </script>';
        } else {				 
         	echo '<script> window.location="'.site_url('__ps_equipment/detail/edit/'.$p['project_id'].'/'.$p['id']).'"; </script>';
        }
        
	}

	function delete($id,$project_id){
		//exit();

		$doc = $this->__ps_project_query->getObj('tbt_equipment_return_document', array('equipment_doc_id' => $id));
		
		$emp_id = $this->session->userdata('id');
		$permission = $this->permission[$this->cat_id];

		if (!array_key_exists('delete', $permission) || empty($doc) || $doc['submit_date_sap'] != '0000-00-00' || $doc['inspector_id'] != $emp_id) {
			redirect(site_url('__ps_equipment/listview/list/'.$project_id), 'refresh');
		} else {
			//remove from database 
			 $this->__equipment_model->delete($id);

			redirect(site_url('__ps_equipment/listview/list/'.$project_id), 'refresh');
		}
	}
}
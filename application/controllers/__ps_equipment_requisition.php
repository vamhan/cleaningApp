<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class __ps_equipment_requisition extends Admin_Controller {

	function __construct() {
		parent::__construct();

		$this->permission_check('equipment_requisition');
        //$this->permission_check('equipment_requisition');

		//TODO :: Move this to admin controller later 

		$this->load->model('__equipment_model');
		$this->load->model('__equipment_requisition_model');
		$this->load->model('__ps_project_query');

		#CMS
		$this->pageSize = PAGESIZE;
		$this->table = 'tbt_equipment_requisition_document';
		$this->page_id = 'ps_generation';
		$this->page_title = freetext('equipment_requisition');
		$this->page_object = 'API';
		$this->page_controller = '__ps_equipment_requisition';

		//set lang
		$this->session->set_userdata('lang', 'th');
		
		#END_CMS

		
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
		redirect(site_url($this->page_controller.'/listview/list/'.$this->project_id), 'refresh');
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

		// $position_list = $this->session->userdata('position');
		// $children = array();
  //       foreach ($position_list as $key => $position) {
  //           $children = $this->getPositionChild($children, $position);
  //       }
  //       $children = array_merge($position_list, $children);
		
		// var_dump($this->session->userdata('permission_set'));
		switch ($act) { // to tbt_proto_item


			case 'list':
					//TODO :: select list of equipment return
					//echo $this->page_controller.'<br>';
			$this->project_id  = urldecode($id);
					//exit();	
			$list = $this->__equipment_requisition_model->getContentList($page,$id);
					//get date abort
			$quotation = $this->__ps_project_query->getObj('tbt_quotation', array('id' => $id));
			$this->is_abort = $quotation['is_abort_date'];
					//echo 'isabort : '.$quotation['is_abort'].' '.$quotation['is_abort_date'];


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

					// echo "<pre>";
					// print_r($list['sale_order_list']['ET_BREAKDOWN']);
					// echo "</pre>";
					// die();
					//Load side menu
			$this->load->model('__ps_project_query');
			$data['side_menu'] = $this->load->view('__project/include/side',$menuConfig,true);

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

			$data['top_project'] = $this->load->view('__equipment_requisition/include/top_project',$info,true);

			$list['contentInfo'] = $contentInfo['result'][0];
					$data['modal'] = $this->load->view('__equipment_requisition/page/list_modal',$list,true);//return view as data

					$list['permission'] = $this->permission[$this->cat_id];
					//Load body
					$data['body'] = $this->load->view('__equipment_requisition/page/list_bodycfg',$list,true);

					// //Load footage script
					$data['footage_script'] = '';


					$this->load->view('__equipment_requisition/layout/list',$data);

					//exit();
					break;	

				}

			}

			function detail($act='',$project_id='',$id=0 ){



				$data = array();
				$body = array();		

				$this->page_title = freetext('equipment_requisition').' - ['.$id.']';
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

			$list['equipment_doc'] = $this->__equipment_requisition_model->getContentById($this->table,$id);

			$emp_id = $this->session->userdata('id');
			$permission = $this->permission[$this->cat_id];
			if ($list['equipment_doc']['status'] == 'approved' || (!array_key_exists('approve', $permission) && $list['equipment_doc']['status'] == 'submit') ) {
				redirect(site_url('__ps_equipment_requisition/listview/list/'.$project_id), 'refresh');
			}

			$list['equipment_items'] = $this->__equipment_requisition_model->getEquipmentItems($id, $list['equipment_doc']['sale_order_id'], $list['equipment_doc']['quotation_id']);
				// echo "<pre>";
				// print_r($list['equipment_items']);
				// echo "</pre>";
			$list['last_equipment'] = $this->__equipment_requisition_model->getLastRequisition($id, $project_id);
			$list['last_id'] = $this->__equipment_requisition_model->getLastId();

			$list['query_owner'] = $this->__ps_project_query->get_project_owner($this->project_id);

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

			$data['top_project'] = $this->load->view('__equipment_requisition/include/top_project',$info,true);

				//Update zsd_ship_to
			$ship_to_input = array(	 
				array("IMPORT","I_SHIP_TO", $list['equipment_doc']['ship_to_id']),
				array("TABLE","ET_ZSD_SHIP_TO",array()),
				);
			$zsd_ship_to = $this->callSAPFunction("ZRFC_GET_SHIP_TO", $ship_to_input);
			

			// $this->__equipment_requisition_model->updateZSDShipto($zsd_ship_to, $list['equipment_doc']['ship_to_id']);

			$input = array(	 
				array("IMPORT","I_CONTRACT", $list['equipment_doc']['contract_id']),
								/*array("IMPORT","I_FROM", "20141001"),
								array("IMPORT","I_TO", "20141101"),*/
								array("TABLE","ET_VBAK",array()),
								array("TABLE","ET_BREAKDOWN",array())
								);
			$list['sale_order_list'] = $this->callSAPFunction("ZRFC_SD_GET_BREAKDOWN", $input);

			$list['budget_info'] = array();
			$list['mat_price_info'] = array();
			$list['mat_peak_info'] = array();
			$list['customer_request_list'] = array();
			$in_type = array('ZORX', 'ZORY', 'ZORW', 'ZORZ');
			foreach ($list['sale_order_list']['ET_BREAKDOWN'] as $key => $material) {
				if ($list['equipment_doc']['sale_order_id'] == $material['VBELN']) {
					if (!in_array($material['AUART'], $in_type)) {

						if ($material['MTART'] == 'Z001' || $material['MTART'] == 'Z002') {
							$list['budget_info'][$material['MATNR']]['Budget'] = intval($material['KWMENG']);
						} else if ($material['MTART'] == 'Z013' || $material['MTART'] == 'Z014') {
							if (!array_key_exists($material['MTART'], $list['budget_info'])) {
								$list['budget_info'][$material['MTART']]['Budget'] = 0;
							}
							$list['budget_info'][$material['MTART']]['Budget'] += floatval($material['KWERT']);
							$list['mat_price_info'][$material['MATNR']] = floatval($material['KBETR']);
							$list['mat_peak_info'][$material['MATNR']] = floatval($material['KWMENG']);
						} 

						if ($material['PSTYV'] == 'ZTAC' && !in_array($material['MATNR'], $list['customer_request_list'])) {
							array_push($list['customer_request_list'], $material['MATNR']);
						}	

					}
				}
			}

			$list['project_material_list']  = $this->__equipment_requisition_model->getProjectMaterial($list['equipment_doc']['ship_to_id'], $list['equipment_doc']['sale_order_id'], $list['equipment_doc']['id']);


			$list['permission'] = $this->permission[$this->cat_id];
				//Load body
			$data['body'] = $this->load->view('__equipment_requisition/page/detail_bodycfg',$list,true);

				$data['modal'] = $this->load->view('__equipment_requisition/page/detail_modal',$list,true);//return view as data
				// //Load footage script
				// $data['footage_script'] ='';//$this->load->view('__cms/script/api/api_manager_js','',true);				

				$this->load->view('__equipment_requisition/layout/detail',$data);

				
				break;

				case 'view':
				
				// $this->status  = $status;
				$this->project_id  = $project_id;
				// $this->track_doc_id  = $id;

				$menuConfig['page_title'] = 'API Manager';
				$menuConfig['page_id'] 	  = 'api_manager';

				$permission = $this->permission[$this->cat_id];
				if (!array_key_exists('view', $permission)) {
					redirect(site_url('__ps_equipment_requisition/listview/list/'.$project_id), 'refresh');
				}

				//#############  Query #########################################################################
				//Assign parameter for modal

				$list['equipment_doc'] = $this->__equipment_requisition_model->getContentById($this->table,$id);
				$list['equipment_items'] = $this->__equipment_requisition_model->getEquipmentItems($id, $list['equipment_doc']['sale_order_id']);
				$list['last_equipment'] = $this->__equipment_requisition_model->getLastRequisition($id, $project_id);
				$list['last_id'] = $this->__equipment_requisition_model->getLastId();
				
				$list['query_owner'] = $this->__ps_project_query->get_project_owner($this->project_id);

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

				$data['top_project'] = $this->load->view('__equipment_requisition/include/top_project',$info,true);

				$input = array(	 
					array("IMPORT","I_CONTRACT", $list['equipment_doc']['contract_id']),
								/*array("IMPORT","I_FROM", "20141001"),
								array("IMPORT","I_TO", "20141101"),*/
								array("TABLE","ET_VBAK",array()),
								array("TABLE","ET_BREAKDOWN",array())
								);
				$list['sale_order_list'] = $this->callSAPFunction("ZRFC_SD_GET_BREAKDOWN", $input);

				$list['budget_info'] = array();
				$list['mat_price_info'] = array();
				$list['mat_peak_info'] = array();
				$in_type = array('ZORX', 'ZORY', 'ZORW', 'ZORZ');
				foreach ($list['sale_order_list']['ET_BREAKDOWN'] as $key => $material) {
					if ($list['equipment_doc']['sale_order_id'] == $material['VBELN']) {
						if (!in_array($material['AUART'], $in_type)) {

							if ($material['MTART'] == 'Z001' || $material['MTART'] == 'Z002') {
								$list['budget_info'][$material['MATNR']]['Budget'] = intval($material['KWMENG']);
							} else if ($material['MTART'] == 'Z013' || $material['MTART'] == 'Z014') {
								if (!array_key_exists($material['MTART'], $list['budget_info'])) {
									$list['budget_info'][$material['MTART']]['Budget'] = 0;
								}
								$list['budget_info'][$material['MTART']]['Budget'] += floatval($material['KWERT']);
								$list['mat_price_info'][$material['MATNR']] = floatval($material['KBETR']);
								$list['mat_peak_info'][$material['MATNR']] = floatval($material['KWMENG']);
							} 
						}
					}
				}

				$data['body'] = $this->load->view('__equipment_requisition/page/view_bodycfg',$list,true);
				$data['modal'] = $this->load->view('__equipment_requisition/page/detail_modal',$list,true);//return view as data
				// //Load footage script
				// $data['footage_script'] ='';//$this->load->view('__cms/script/api/api_manager_js','',true);		
				$this->load->view('__equipment_requisition/layout/view',$data);

				
				break;

				default:			

				break;
			}

			
		}

		function create_List_equipment_requisition(){

			$p = $this->input->post();

			if(!empty($p)){

			//echo $p['project_id'];
			//exit();
				$project_id = $p['quotation_id'];		

				$this->__equipment_requisition_model->insert_list_equipment_requisition($p); 
			}

			redirect(site_url('__ps_equipment_requisition/listview/list/'.$project_id), 'refresh');

		//echo $msg;

		}

		function update_requisition_document () {
			$p = $this->input->post();

			$permission = $this->permission[$this->cat_id];

			$this->updateDocLog('tbt_equipment_requisition_document', $p['id']);

			$project = $this->__ps_project_query->getObj('tbt_quotation', array('id' => $p['project_id']));
			$doc = $this->__ps_project_query->getObj('tbt_equipment_requisition_document', array('id' => $p['id']));

			$status = "being";
			if (!empty($p['submit']) && $p['submit'] == 1) {
				$status = "submit";
			}

			$sap_remark_text = array();

			$doc_data = array(
				'id' 				=> $p['id'],
			// 'status' 			=> $status,
				'order_type' 		=> $p['job_type_id'],
				'item_category'		=> $p['job_cat_id'],
				'sale_order_id' 	=> $p['sale_order_id'],
				'require_date' 		=> $p['required_date'],
				'actual_date' 		=> $p['actual_date'],
				'inspector_id'		=> (empty($doc['inspector_id'])) ? $p['actor_id'] : $doc['inspector_id'],
				'remark' 			=> $p['remark'],
				'quotation_id' 		=> $p['project_id'],
				'ship_to_id' 		=> $p['ship_to_id'],
				'contract_id'		=> $doc['contract_id']
				);

			$this->__ps_project_query->updateObj('tbt_equipment_requisition_document', array('id' => $p['id']), $doc_data);

			$doc_remark = array(
				"DOC_NUMBER" 	=> $p['id'],
				"TEXT_ID" 		=> "9001",
				"LANGU"			=> "2",
				"TEXT_LINE"		=> iconv("UTF-8", "TIS-620",$p['remark'])
				);

			array_push($sap_remark_text, $doc_remark);

			$input = array(	
				array("IMPORT","I_CONTRACT",$doc['contract_id']),
						/*array("IMPORT","I_FROM", "20141001"),
						array("IMPORT","I_TO", "20141101"),*/
						array("TABLE","ET_BREAKDOWN",array())
						);

			$checkType = array('Z001', 'Z002', 'Z013', 'Z014');

			$sap_order_list = $this->callSAPFunction("ZRFC_SD_GET_BREAKDOWN", $input);

			$in_type = array('ZORX', 'ZORY', 'ZORW', 'ZORZ');
			$budget_info = array();
			$mat_price_info = array();
			$mat_peak_info = array();

			foreach ($sap_order_list['ET_BREAKDOWN'] as $key => $material) {
				if ($p['sale_order_id'] == $material['VBELN']) {
					if (!in_array($material['AUART'], $in_type)) {

						if ($material['MTART'] == 'Z001' || $material['MTART'] == 'Z002') {
							$budget_info[$material['MATNR']]['Budget'] = intval($material['KWMENG']);
						} else if ($material['MTART'] == 'Z013' || $material['MTART'] == 'Z014') {
							if (!array_key_exists($material['MTART'], $budget_info)) {
								$budget_info[$material['MTART']]['Budget'] = 0;
							}
							$budget_info[$material['MTART']]['Budget'] += floatval($material['KWERT']);
							$mat_price_info[$material['MATNR']] = floatval($material['KBETR']);
							$mat_peak_info[$material['MATNR']] = floatval($material['KWMENG']);
						} 
					}
				}
			}

			$tmp_Z013_budget = $budget_info['Z013']['Budget'];
			$this_month_list = $this->__equipment_requisition_model->getThisMonthItemsbyType('Z013', $p['sale_order_id'], $p['id']);
			foreach ($this_month_list as $eq) {
				if (empty($mat_price_info[$eq['material_no']])) {
					$mat_price = $this->__ps_project_query->getObj('sap_tbm_mat_price', array('material_no' => $eq['material_no']));
					if (!empty($mat_price)) {
						$mat_price_info[$eq['material_no']] = floatval($mat_price['price']);
					}
				}
				$tmp_Z013_budget -= floatval($eq['add_quantity'])*floatval($mat_price_info[$eq['material_no']]);
			}

			$tmp_Z014_budget = $budget_info['Z014']['Budget'];
			$this_month_list = $this->__equipment_requisition_model->getThisMonthItemsbyType('Z014', $p['sale_order_id'], $p['id']);
			foreach ($this_month_list as $eq) {
				if (empty($mat_price_info[$eq['material_no']])) {
					$mat_price = $this->__ps_project_query->getObj('sap_tbm_mat_price', array('material_no' => $eq['material_no']));
					if (!empty($mat_price)) {
						$mat_price_info[$eq['material_no']] = floatval($mat_price['price']);
					}
				}
				$tmp_Z014_budget -= floatval($eq['add_quantity'])*floatval($mat_price_info[$eq['material_no']]);
			}

			$chemical_val =
			$master_order_item = array();
			if (!empty($sap_order_list['ET_BREAKDOWN'])) {
				foreach ($sap_order_list['ET_BREAKDOWN'] as $order) {

					if ($order['MATKL'] == '1399') {
						$dummy_chemical = $order;
					}

					if ($order['MATKL'] == '1499') {
						$dummy_tool = $order;
					}

					if (in_array($order['MTART'], $checkType)) {
						$master_order_item[$order['VBELN']][$order['MTART']][$order['MATNR']] = $order;
					}
				}
			}

			$quantity_list = preg_grep("/^quantity_/",array_keys($p));

			$this->db->select('require_date');
			$this->db->from('tbt_equipment_requisition_document');    
			$this->db->where('tbt_equipment_requisition_document.id',$p['id']);  
			$query = $this->db->get();
			$doc = $query->row_array();

			$last_month = date('m', strtotime($doc['require_date']." -1 month"));
			$this_month = date('m', strtotime($doc['require_date']));

			$is_approve = true;

			$this->__ps_project_query->deleteObj('tbt_equipment_requisition', array('requisition_document_id' => $p['id']));

			$sap_items 	     = array();
			$item_schedules  = array();
			$item_conditions = array();

			$items  = array();
			$sap_item_no = 10;

			$map_item_category = array(
				'ZTAA' => 'ZTIA',
				'ZTAB' => 'ZTIB',
				'ZTAE' => 'ZTI',
				'ZTA1' => 'ZTI1',
				'ZTA2' => 'ZTI2',
				'ZTA3' => 'ZTI3',
				'ZTA4' => 'ZTI4',
				'ZTA5' => 'ZTI5'
				);

			foreach ($quantity_list as $key) {
				$parts = explode('_', $key);
				$type  = $parts[1];
				$code  = $parts[2];
				$padd_code  = $this->_padZero($code, 18);

				$last_count_item = $this->__equipment_requisition_model->getLastMonthItems($padd_code, $p['sale_order_id'], $p['id'], $last_month);
				$this_count_item = $this->__equipment_requisition_model->getThisMonthItems($padd_code, $p['sale_order_id'], $p['id'], $this_month);

				$is_allow = 1;
				if ( ($type=="Z001" || $type=="Z002") && (!array_key_exists($type, $master_order_item[$p['sale_order_id']]) || !array_key_exists($padd_code, $master_order_item[$p['sale_order_id']][$type])) ) {
					$is_allow = 0;
				} else if ( ($type=="Z013" || $type=="Z014") && (!array_key_exists($type, $master_order_item[$p['sale_order_id']]) || !array_key_exists($padd_code, $master_order_item[$p['sale_order_id']][$type])) ) {
					if ($type=="Z013") {
						foreach ($sap_order_list['ET_BREAKDOWN'] as $key => $value) {
							if ($value['MATKL'] == '1399') {
								$master_order_item[$p['sale_order_id']][$type][$padd_code] = $value;
							}
						}

						if (!array_key_exists($type, $master_order_item[$p['sale_order_id']]) || !array_key_exists($padd_code, $master_order_item[$p['sale_order_id']][$type])) {
						//$is_allow = 0;
						}
					} else if ($type=="Z014") {
						foreach ($sap_order_list['ET_BREAKDOWN'] as $key => $value) {
							if ($value['MATKL'] == '1499') {
								$master_order_item[$p['sale_order_id']][$type][$padd_code] = $value;
							}
						}

						if (!array_key_exists($type, $master_order_item[$p['sale_order_id']]) || !array_key_exists($padd_code, $master_order_item[$p['sale_order_id']][$type])) {
						//$is_allow = 0;
						}
					}
				}

				$item = array(
					'requisition_document_id' => $p['id'],
					'material_no'			  => $padd_code,
					'material_description'	  => $p['desc_'.$type.'_'.$code],
					'material_type'			  => $type,
					'last_month'			  => $last_count_item,
					'this_month'			  => $this_count_item,
					'add_quantity'			  => $p['quantity_'.$type.'_'.$code],
					'unit_code'				  => $p['unit_code_'.$type.'_'.$code],
					'unit_text'				  => $p['unit_text_'.$type.'_'.$code],
					'is_customer_request'	  => $p['request_'.$type.'_'.$code],
					'remark'	  			  => $p['remark_'.$type.'_'.$code],
					'budget'				  => $p['budget_'.$type.'_'.$code],
					'is_allow'				  => $is_allow
					);


			// START : SAP AREA
				if ($is_allow) {

					if (!empty($p['submit']) && $p['submit'] == 1) {
						if ($type == 'Z001' || $type == 'Z002') {
							$sum = floatval($this_count_item) + floatval($p['quantity_'.$type.'_'.$code]);
							if ($sum > $p['budget_'.$type.'_'.$code]) {
								$is_approve = false;
							}
						} else if ($type == 'Z013') {

							if (empty($mat_price_info[$padd_code])) {
								$mat_price = $this->__ps_project_query->getObj('sap_tbm_mat_price', array('material_no' => $padd_code));
								if (!empty($mat_price)) {
									$mat_price_info[$padd_code] = floatval($mat_price['price']);
								}
							}
							$tmp_Z013_budget -= (floatval($p['quantity_'.$type.'_'.$code])*floatval($mat_price_info[$padd_code])); 
							if ($tmp_Z013_budget < 0) {
								$is_approve = false;
							}

						} else if ($type == 'Z014') {

							if (empty($mat_price_info[$padd_code])) {
								$mat_price = $this->__ps_project_query->getObj('sap_tbm_mat_price', array('material_no' => $padd_code));
								if (!empty($mat_price)) {
									$mat_price_info[$padd_code] = floatval($mat_price['price']);
								}
							}
							$tmp_Z014_budget -= (floatval($p['quantity_'.$type.'_'.$code])*floatval($mat_price_info[$padd_code])); 
							if ($tmp_Z014_budget < 0) {
								$is_approve = false;
							}

						}
					}

					$item_remark = array(
						"DOC_NUMBER" 	=> $p['id'],
						"ITM_NUMBER" 	=> $this->_padZero($sap_item_no, 6),
						"TEXT_ID" 		=> "0001",
						"LANGU"			=> "2",
						"TEXT_LINE"		=> iconv("UTF-8", "TIS-620",$p['remark_'.$type.'_'.$code])
						);

					array_push($sap_remark_text, $item_remark);

					$sap_item = array(
						"ITM_NUMBER" => $this->_padZero($sap_item_no, 6),
						"MATERIAL" 	 => $padd_code,
						"ITEM_CATEG" => $map_item_category[$p['job_cat_id']],
						"REF_DOC"	 => $p['sale_order_id'],
						'REF_DOC_CA' => 'C',
						'ORDERID'	 => $project['ship_to_id']
						);

					array_push($sap_items, $sap_item);

				//$quantity = number_format($p['quantity_'.$type.'_'.$code]);

					$schedule = array (
						"ITM_NUMBER" => $this->_padZero($sap_item_no, 6),
						"REQ_QTY"	 => $p['quantity_'.$type.'_'.$code] 
						);	
					array_push($item_schedules, $schedule);

					$sap_item_no+=10;
				}
			// END : SAP AREA

				$this->__ps_project_query->insertObj('tbt_equipment_requisition', $item);

			}

		//Update status

			if (!empty($p['submit']) && $p['submit'] == 1 && !$is_approve && !array_key_exists('approve', $permission)) {

				$this->__ps_project_query->updateObj('tbt_equipment_requisition_document', array('id' => $p['id']), array('status' => 'submit'));

			} else if (!empty($p['submit']) && $p['submit'] == 1 && ($is_approve || array_key_exists('approve', $permission) )) {

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

				$ship_to_data = $this->__ps_project_query->getObj('sap_tbm_ship_to', array('id' => $project['ship_to_id']));

				$order_header_in = array(
					"DOC_TYPE" => $p['job_type_id'],
					"SALES_ORG" => "1000",
					"DISTR_CHAN" => $ship_to_data['ship_to_distribution_channel'],
					"DIVISION" => "11",
					"PURCH_NO_C" => $p['sale_order_id'],
					"REQ_DATE_H" => $this->_dateFormat($p['required_date']),
					"DOC_DATE"	 => $this->_dateFormat(date('Y-m-d'))
					);

				$input = array(	
					array("IMPORT","SALESDOCUMENTIN",$p['id']),
					array("IMPORT","ORDER_HEADER_IN", $order_header_in),
					array("TABLE","ORDER_ITEMS_IN", $sap_items),
					array("TABLE","ORDER_PARTNERS", $partners),
					array("TABLE","ORDER_SCHEDULES_IN", $item_schedules),
					array("TABLE","ORDER_CONDITIONS_IN", $item_conditions),
					array("TABLE","ORDER_TEXT", $sap_remark_text),
					array("TABLE","RETURN", array())
					);

				$result = $this->callSAPFunction("BAPI_SALESORDER_CREATEFROMDAT2", $input);

				if (!empty($result['RETURN'])) {
					foreach ($result['RETURN'] as $key => $value) {
						if ($value['TYPE'] == "E") {
							if (array_key_exists('edit', $permission)) {

								$this->__ps_project_query->updateObj('tbt_equipment_requisition_document', array('id' => $p['id']), array('status' => 'being'));

							}
							echo $value['MESSAGE'];
							echo "<br><a href='".site_url("__ps_equipment_requisition/detail/edit/".$p['project_id']."/".$p['id'])."'><button>Back</button></a>";
							die();
						}
					}
				}



				$this->callSAPFunction("BAPI_TRANSACTION_COMMIT", array());

				$status_data = array(
					'submit_date_sap' => date('Y-m-d'),
					'status' => 'approved'
					);
				$this->__ps_project_query->updateObj('tbt_equipment_requisition_document', array('id' => $p['id']), $status_data);
			}

			if (!empty($p['submit']) && $p['submit'] == 1 ) {
				echo '<script> window.location="'.site_url('__ps_equipment_requisition/listview/list/'.$p['project_id']).'"; </script>';
			} else {				 
				echo '<script> window.location="'.site_url('__ps_equipment_requisition/detail/edit/'.$p['project_id'].'/'.$p['id']).'"; </script>';
			}
		}

		function delete($id,$project_id){
		//exit();
			$doc = $this->__ps_project_query->getObj('tbt_equipment_requisition_document', array('id' => $id));

			$emp_id = $this->session->userdata('id');
			$permission = $this->permission[$this->cat_id];
			if (empty($doc) || $doc['status'] == 'approved' || !array_key_exists('delete', $permission) || $doc['site_inspector_id'] != $emp_id) {
				redirect(site_url('__ps_equipment_requisition/listview/list/'.$project_id), 'refresh');
			} else {
			//remove from database 
				$this->__equipment_requisition_model->delete($id);
				redirect(site_url('__ps_equipment_requisition/listview/list/'.$project_id), 'refresh');
			}


		}

	}
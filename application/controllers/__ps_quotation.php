<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class __ps_quotation extends Admin_Controller {

	function __construct(){
		parent::__construct();

		$this->permission_check('project_quotation');

		//TODO :: Move this to admin controller later 

		#CMS
		$this->pageSize = PAGESIZE;
		$this->table = 'tbt_quotation';
		$this->page_id = 'ps_quotation';
		$this->page_title = freetext('quotation_top');
		$this->page_object = 'Page';
		$this->page_controller = '__ps_quotation';
		$this->function ='';

		//$this->untrack = 0;
		//set lang
		$this->session->set_userdata('lang', 'th');
		
		#END_CMS

		
		// $this->load->config('backend_navigation');
		// $this->navigation = $this->config->item('backend_navigation');
		// var_dump($this->navigation);
	}//end constructor;


	 // public function permission_trace(){
  //       $this->trace($this->session->userdata('permission_set'));
  //   }


	//Default
	function index($act='',$id=''){
		//TODO :: redirecting to listview
		redirect(site_url('__ps_quotation/listview_quotation'), 'refresh');
	}



	function changePageSize($function,$newPageSize = PAGESIZE){
		$newValue = array('current_page'=> $newPageSize);
		$this->session->set_userdata($newValue);

		redirect(site_url('__ps_quotation/'.$function),'refresh');		
		// $callback_url = $this->session->userdata('current_url');
		// if(!empty($callback_url))
		// 	redirect($callback_url,'refresh');
	}



	
	function listview_prospect($page=1,$tempMatch=''){
		
		$newValue = array('current_url'=> site_url($this->uri->uri_string()) );
		$this->session->set_userdata($newValue);
		
		$this->load->model('__quotation_model');

		$this->tab = 1;
		$this->function = 'listview_prospect';
		$data = array();
		$list = array();
		$modal_data = array();
		//$list_project = array();		

		$list = $this->__quotation_model->getContentList_prospect($page,$tempMatch);
		$modal_data['bapi_sold_to'] = $this->__quotation_model->sap_tbm_sold_to();
		$modal_data['bapi_distribution'] = $this->__quotation_model->sap_tbm_distribution_channel();	

		$menuConfig = array('page_id'=>1);

		
		$data['modal'] = $this->load->view('__quotation/page/list_modal',$modal_data,true);//return view as data

		//Load top menu
		$data['top_menu'] = $this->load->view('__projects/include/top',$menuConfig,true);

		//Load side menu

		$user_department_id = $this->session->userdata('department');

		$side_data['module_list'] = array();
		$module_list = $this->module_model->getModuleList();
		if (!empty($module_list)) {
			foreach ($module_list as $key => $module) {
				if ($module['is_main_menu'] == 1 && array_key_exists($module['id'], $this->permission) && array_key_exists('view', $this->permission[$module['id']])) {
					$side_data['module_list'][$module['id']] = $module;
				}
			}
		}        

		$data['side_menu'] = $this->load->view('__projects/include/side',$side_data,true);

		$info = '';
		//$data['top_project'] = $this->load->view('__quotation/include/top_project',$info,true);

		$list['permission'] = $this->permission[$this->cat_id];

		//Load body
		$data['body'] = $this->load->view('__quotation/page/list_bodycfg',$list,true);

		//Load footage script
		$data['footage_script'] = '';


		$this->load->view('__quotation/layout/list',$data);
	}

	//function com_listview : act / id 
	function listview_quotation($page=1,$tempMatch=''){

		$newValue = array('current_url'=> site_url($this->uri->uri_string()) );
		$this->session->set_userdata($newValue);
		
		$this->load->model('__quotation_model');

		$this->tab = 2;
		$this->function = 'listview_quotation';
		$data = array();
		$list = array();
		$modal_data = array();
		//$list_project = array();		

		$list = $this->__quotation_model->getContentList($page,$tempMatch);
		$modal_data['bapi_sold_to'] = $this->__quotation_model->sap_tbm_sold_to();
		$modal_data['bapi_distribution'] = $this->__quotation_model->sap_tbm_distribution_channel();	

		$menuConfig = array('page_id'=>1);

		
		$data['modal'] = $this->load->view('__quotation/page/list_modal',$modal_data,true);//return view as data

		//Load top menu
		$data['top_menu'] = $this->load->view('__projects/include/top',$menuConfig,true);

		//Load side menu
		$side_data['module_list'] = array();
		$module_list = $this->module_model->getModuleList();
		if (!empty($module_list)) {
			foreach ($module_list as $key => $module) {
				if ($module['is_main_menu'] == 1 && array_key_exists($module['id'], $this->permission) && array_key_exists('view', $this->permission[$module['id']])) {
					$side_data['module_list'][$module['id']] = $module;
				}
			}
		}        

		$data['side_menu'] = $this->load->view('__projects/include/side',$side_data,true);

		$info = '';
		//$data['top_project'] = $this->load->view('__quotation/include/top_project',$info,true);

		$list['permission'] = $this->permission[$this->cat_id];

		//Load body
		$data['body'] = $this->load->view('__quotation/page/list_bodycfg',$list,true);

		//Load footage script
		$data['footage_script'] = '';


		$this->load->view('__quotation/layout/list',$data);
	}


	function detail_quotation($act='',$id=0,$status='0',$tab_qt=1){

		//get job_type ====
		$emp_id = $this->session->userdata('id');
		$this->load->model('__quotation_model','quotation');
		$query_quotation = $this->quotation->get_quotationByid($id);
		$data_job_type = $query_quotation->row_array();
		if(!empty($data_job_type)){      
			$job_type  = $data_job_type['job_type'];  			
			$acc_gr  = $data_job_type['account_group'];
			$this->job_type  = $job_type;  
		}else{
			$job_type ='';
			$this->job_type  = '';  
			$acc_gr ='';
		}
		//end : get job_type ======
		
		$data = array();
		$body = array();

		//$this->page_title = freetext('asset_tracker_top').' - ['.$id.']';

		switch ($act) { // to tbt_proto_item

			case 'view_quotation':
			 	//TODO ::  EDIT DATA QUOTATION
			$this->quotation_id  = $id;
			$this->act = $act;
			$this->tab_qt = $tab_qt;

				// $this->status  = $status;				
				// $this->track_doc_id  = $id;
				// $this->untrack  = $untrack;

			$menuConfig['page_title'] = 'API Manager';
			$menuConfig['page_id'] 	  = 'api_manager';


				//#############  Query #########################################################################
				//Assign parameter for modal
			$this->load->model('__quotation_model','quotation');				
				//$list='';				
			$list['query_other_service'] = $this->quotation->get_other_service_Byqt_id($this->quotation_id);
			$list['query_quotation'] = $this->quotation->get_quotationByid($this->quotation_id);
			$list['query_contact'] = $this->quotation->get_contact_quotation($this->quotation_id);
				//$list['query_main_contract'] = $this->quotation->get_main_contract_Byid('quotation',$this->quotation_id);

			$quotation = $list['query_quotation']->row_array();
			$permission = $this->permission[$this->cat_id];

			if (empty($quotation) || !array_key_exists('view', $permission)) {
				redirect('__ps_quotation/listview_quotation');
			}

			$list['bapi_contact_title'] = $this->quotation->bapi_contact_title();
			$list['bapi_distribution'] = $this->quotation->sap_tbm_distribution_channel();
			$list['bapi_other_function'] = $this->quotation->sap_tbm_function();
			$list['bapi_department'] = $this->quotation->sap_tbm_department();
			$list['query_contact'] = $this->quotation->get_contact_quotation($this->quotation_id);
			$list['query_doc_importance'] = $this->quotation->get_document_importance('quotation',$this->quotation_id);
			$list['query_doc_other'] = $this->quotation->get_document_other('quotation',$this->quotation_id);
			$list['get_prospect'] = $this->quotation->get_prospect();
			$list['get_building_Byid'] = $this->quotation->get_building_Byid($this->quotation_id);
			$list['get_floor_Byid'] = $this->quotation->get_floor_Byid($this->quotation_id);
			$list['get_area'] = $this->quotation->get_area_Byid($this->quotation_id);		
			
			$list['get_staff'] = $this->quotation->get_staff_Byid($this->quotation_id);
			$list['get_required_doc'] = $this->quotation->get_required_doc();
			$list['get_requiredByid'] = $this->quotation->get_requiredByid($this->quotation_id);

			$list['summary_data'] = $this->__ps_project_query->getObj('tbt_summary', array('quotation_id' => $this->quotation_id));
				//=== get Bapi sap tbm ===
			$list['bapi_competitor'] = $this->quotation->sap_tbm_competitor();
			$list['bapi_region'] = $this->quotation->sap_tbm_region();
			$list['bapi_country'] = $this->quotation->sap_tbm_country();
			$list['bapi_industry'] = $this->quotation->sap_tbm_industry();
			$list['bapi_business_scale'] = $this->quotation->sap_tbm_business_scale();
			$list['bapi_sold_to'] = $this->quotation->sap_tbm_sold_to();
			$list['bapi_ship_to'] = $this->quotation->sap_tbm_ship_to();
				// === get bpi area ===
			$list['bapi_area'] = $this->quotation->sap_tbm_industry_room();
			$list['bapi_texture'] = $this->quotation->bapi_texture();

			$list['bapi_level_staff'] = $this->quotation->sap_tbm_employee_level();
			$list['bapi_position'] = $this->quotation->sap_tbm_position($quotation['ship_to_id']);
			$list['bapi_unifrom'] = $this->quotation->get_uniform();
			$list['bapi_other_type'] = $this->quotation->sap_tbm_other();

				//== get sa_tbm_bomb  ===
			$list['bapi_bomb'] = $this->quotation->get_bomb();
				//== get bapi checmical  ===
			$list['bapi_mat_group'] = $this->quotation->get_sap_tbm_mat_group($this->job_type);
			$list['bapi_chemical_Z001'] = $this->quotation->bapi_chemical_Z001($this->job_type);
			$list['bapi_chemical_Z013'] = $this->quotation->bapi_chemical_Z013($this->job_type);
			$list['bapi_machine'] = $this->quotation->bapi_machine();
			$list['bapi_tool_Z002'] = $this->quotation->bapi_tool_Z002($this->job_type);
			$list['bapi_tool_Z014'] = $this->quotation->bapi_tool_Z014($this->job_type);
				//get data to db get_customer_request
			if($job_type!='ZQT3' && $acc_gr!='Z16'){
				$list['get_customer_request'] = $this->quotation->get_tbt_equipment($this->quotation_id,1);
			}else{
				$list['get_customer_request'] = $this->quotation->get_tbt_equipment($this->quotation_id,0);
			}

				//get data to db chemical no request
			$list['get_db_chemical'] = $this->quotation->get_tbt_equipment($this->quotation_id,0);

				//== get get_tbt_equipment_clearjob ==
			$list['get_clearing_job'] = $this->quotation->get_tbt_equipment_clearjob($this->quotation_id);

				//== get oterh service ==
			$list['bapi_other_service'] = $this->quotation->get_other_service();


			$list['staffExist'] = $this->quotation->isStaffExist($this->quotation_id);
			$list['summary_data'] = $this->__ps_project_query->getObj('tbt_summary', array('quotation_id' => $this->quotation_id));
				//####################################################################################################				
				//$list['bapi_customer1'] = $this->quotation->bapi_customer1($quotation['ship_to_id']);
				// report doc quotation TH, EN
			$list['bapi_customer_Z005'] =  $this->__ps_project_query->getObj('sap_tbm_contact', array('ship_to_id' => $quotation['ship_to_id'],'department' => 'Z005'));
			$list['bapi_customer1'] =  $this->__ps_project_query->getObj('sap_tbm_contact', array('ship_to_id' => $quotation['ship_to_id'],'department' => 'Z002'));
			$list['bapi_customer2'] =  $this->__ps_project_query->getObj('sap_tbm_contact', array('ship_to_id' => $quotation['ship_to_id'],'department' => 'Z003'));
			$list['bapi_customer3'] =  $this->__ps_project_query->getObj('sap_tbm_contact', array('ship_to_id' => $quotation['ship_to_id'],'department' => 'Z004'));

				//customer psgen
			$temp_position =  $this->session->userdata('position');
				//print_r($temp_position);
			$list['bapi_parnet_id'] =  $this->__ps_project_query->getObj('tbm_position', array('id' => $temp_position[0]));
			$parent_id =  $list['bapi_parnet_id']['parent_id'];
			$list['query_emp_id'] =  $this->__ps_project_query->getObj('tbt_user_position', array('position_id' => $parent_id));
			$Employ_id =  $list['query_emp_id']['employee_id'];
			$list['query_nameEmp'] =  $this->__ps_project_query->getObj('tbt_user', array('employee_id' => $Employ_id));
				//get position customer head
			$list['temp_position_Emp'] =  $this->__ps_project_query->getObj('tbt_user_position', array('employee_id' => $Employ_id));
			$temp_user_positionID = $list['temp_position_Emp']['position_id'];
			$list['temp_position_des'] =  $this->__ps_project_query->getObj('tbm_position', array('id' => $temp_user_positionID));

				// echo $list['query_nameEmp']['user_firstname']."<br>";
				// echo $list['query_nameEmp']['user_lastname']."<br>";
				// echo $parent_id."<br>";
				// echo $Employ_id."<br>";
				// print_r($temp_position);	



				//===========================================================================================		
				//Load top menu
			$data['top_menu'] = $this->load->view('__projects/include/top',$menuConfig,true);

				//Load side menu

			$user_department_id = $this->session->userdata('department');

			$side_data['module_list'] = array();
			$module_list = $this->module_model->getModuleList();
			if (!empty($module_list)) {
				foreach ($module_list as $key => $module) {
					if ($module['is_main_menu'] == 1 && array_key_exists($module['id'], $this->permission) && array_key_exists('view', $this->permission[$module['id']])) {
						$side_data['module_list'][$module['id']] = $module;
					}
				}
			}        		        

			$data['side_menu'] = $this->load->view('__projects/include/side',$side_data,true);

			$info = '';
			$data['top_project'] = $this->load->view('__quotation/include/top_project',$info,true);

				//Load body
			$data['body'] = $this->load->view('__quotation/page/detail_bodycfg',$list,true);

				$data['modal'] = $this->load->view('__quotation/page/detail_modal',$list,true);//return view as data
				// //Load footage script
				$data['footage_script'] = $this->load->view('__quotation/script/contract_download_js',$list,true);				

				$this->load->view('__quotation/layout/detail',$data);

				break;

				case 'edit_quotation':
			 	//TODO ::  EDIT DATA QUOTATION
				$this->quotation_id  = $id;
				$this->act = $act;
				$this->tab_qt = $tab_qt;

				// $this->status  = $status;				
				// $this->track_doc_id  = $id;
				// $this->untrack  = $untrack;

				$menuConfig['page_title'] = 'API Manager';
				$menuConfig['page_id'] 	  = 'api_manager';


				//#############  Query #########################################################################
				//Assign parameter for modal
				$this->load->model('__quotation_model','quotation');				
				//$list='';				
				$list['query_other_service'] = $this->quotation->get_other_service_Byqt_id($this->quotation_id);
				$list['query_quotation'] = $this->quotation->get_quotationByid($this->quotation_id);
				$list['query_contact'] = $this->quotation->get_contact_quotation($this->quotation_id);
				//$list['query_main_contract'] = $this->quotation->get_main_contract_Byid('quotation',$this->quotation_id);


				$quotation = $list['query_quotation']->row_array();
				$permission = $this->permission[$this->cat_id];

				if (empty($quotation) || !array_key_exists('edit', $permission) || $quotation['project_owner_id'] != $emp_id) {
					redirect('__ps_quotation/listview_quotation');
				}
				
				$list['bapi_contact_title'] = $this->quotation->bapi_contact_title();
				$list['bapi_distribution'] = $this->quotation->sap_tbm_distribution_channel();
				$list['bapi_other_function'] = $this->quotation->sap_tbm_function();
				$list['bapi_department'] = $this->quotation->sap_tbm_department();
				$list['query_contact'] = $this->quotation->get_contact_quotation($this->quotation_id);
				$list['query_doc_importance'] = $this->quotation->get_document_importance('quotation',$this->quotation_id);
				$list['query_doc_other'] = $this->quotation->get_document_other('quotation',$this->quotation_id);
				$list['get_prospect'] = $this->quotation->get_prospect();
				$list['get_building_Byid'] = $this->quotation->get_building_Byid($this->quotation_id);
				$list['get_floor_Byid'] = $this->quotation->get_floor_Byid($this->quotation_id);
				$list['get_area'] = $this->quotation->get_area_Byid($this->quotation_id);				
				


				$list['get_staff'] = $this->quotation->get_staff_Byid($this->quotation_id);
				$list['get_required_doc'] = $this->quotation->get_required_doc();
				$list['get_requiredByid'] = $this->quotation->get_requiredByid($this->quotation_id);

				$list['staffExist'] = $this->quotation->isStaffExist($this->quotation_id);
				$list['summary_data'] = $this->__ps_project_query->getObj('tbt_summary', array('quotation_id' => $this->quotation_id));
				//=== get Bapi sap tbm ===
				$list['bapi_competitor'] = $this->quotation->sap_tbm_competitor();
				$list['bapi_region'] = $this->quotation->sap_tbm_region();
				$list['bapi_country'] = $this->quotation->sap_tbm_country();
				$list['bapi_industry'] = $this->quotation->sap_tbm_industry();
				$list['bapi_business_scale'] = $this->quotation->sap_tbm_business_scale();
				$list['bapi_sold_to'] = $this->quotation->sap_tbm_sold_to();
				$list['bapi_ship_to'] = $this->quotation->sap_tbm_ship_to();
				// === get bpi area ===
				$list['bapi_area'] = $this->quotation->sap_tbm_industry_room();
				$list['bapi_texture'] = $this->quotation->bapi_texture();

				$list['bapi_level_staff'] = $this->quotation->sap_tbm_employee_level();
				$list['bapi_position'] = $this->quotation->sap_tbm_position($quotation['ship_to_id']);
				$list['bapi_unifrom'] = $this->quotation->get_uniform();
				$list['bapi_other_type'] = $this->quotation->sap_tbm_other();

				//== get sa_tbm_bomb  ===
				$list['bapi_bomb'] = $this->quotation->get_bomb();

				//== get bapi checmical  ===
				$list['bapi_mat_group'] = $this->quotation->get_sap_tbm_mat_group($this->job_type);
				$list['bapi_chemical_Z001'] = $this->quotation->bapi_chemical_Z001($this->job_type);
				$list['bapi_chemical_Z013'] = $this->quotation->bapi_chemical_Z013($this->job_type);
				$list['bapi_machine'] = $this->quotation->bapi_machine();
				$list['bapi_tool_Z002'] = $this->quotation->bapi_tool_Z002($this->job_type);
				$list['bapi_tool_Z014'] = $this->quotation->bapi_tool_Z014($this->job_type);
				//get data to db get_customer_request
				if($job_type!='ZQT3' && $acc_gr!='Z16'){
					$list['get_customer_request'] = $this->quotation->get_tbt_equipment($this->quotation_id,1);
				}else{
					$list['get_customer_request'] = $this->quotation->get_tbt_equipment($this->quotation_id,0);	
				}
				
				//get data to db chemical no request
				$list['get_db_chemical'] = $this->quotation->get_tbt_equipment($this->quotation_id,0);
				
				//== get get_tbt_equipment_clearjob ==
				$list['get_clearing_job'] = $this->quotation->get_tbt_equipment_clearjob($this->quotation_id);

				//== get oterh service ==
				$list['bapi_other_service'] = $this->quotation->get_other_service();
				

				//####################################################################################################


				//Load top menu
				$data['top_menu'] = $this->load->view('__projects/include/top',$menuConfig,true);

				//Load side menu

				$user_department_id = $this->session->userdata('department');

				$side_data['module_list'] = array();
				$module_list = $this->module_model->getModuleList();
				if (!empty($module_list)) {
					foreach ($module_list as $key => $module) {
						if ($module['is_main_menu'] == 1 && array_key_exists($module['id'], $this->permission) && array_key_exists('view', $this->permission[$module['id']])) {
							$side_data['module_list'][$module['id']] = $module;
						}
					}
				}        

				$data['side_menu'] = $this->load->view('__projects/include/side',$side_data,true);


				$info = '';
				$data['top_project'] = $this->load->view('__quotation/include/top_project',$info,true);

				//Load body
				$data['body'] = $this->load->view('__quotation/page/detail_bodycfg',$list,true);

				$data['modal'] = $this->load->view('__quotation/page/detail_modal',$list,true);//return view as data
				// //Load footage script
				$data['footage_script'] = $this->load->view('__quotation/script/summary_js',$list,true);				

				$this->load->view('__quotation/layout/detail',$data);

				break;

				case 'edit_prospect':
			 	//TODO ::  EDIT DATA QUOTATION
				$this->prospect_id  = $id;
				$this->act = $act;


				// $this->status  = $status;				
				// $this->track_doc_id  = $id;
				// $this->untrack  = $untrack;

				$menuConfig['page_title'] = 'API Manager';
				$menuConfig['page_id'] 	  = 'api_manager';


				//#############  Query #########################################################################
				//Assign parameter for modal
				$this->load->model('__quotation_model','quotation');				
				//$list='';
				$list['get_prospect'] = $this->quotation->get_prospect();
				$list['query_prospect'] = $this->quotation->get_prospectByid($this->prospect_id);
				//$list['query_main_contract'] = $this->quotation->get_main_contract_Byid('prospect',$this->prospect_id);
				$list['bapi_contact_title'] = $this->quotation->bapi_contact_title();
				$list['bapi_distribution'] = $this->quotation->sap_tbm_distribution_channel();
				$list['bapi_other_function'] = $this->quotation->sap_tbm_function();
				$list['bapi_department'] = $this->quotation->sap_tbm_department();				
				$list['query_contact'] = $this->quotation->get_contact_prospect($this->prospect_id);
				$list['query_doc_importance'] = $this->quotation->get_document_importance('prospect',$this->prospect_id);
				$list['query_doc_other'] = $this->quotation->get_document_other('prospect',$this->prospect_id);

				//=== get Bapi sap tbm ===
				$list['bapi_competitor'] = $this->quotation->sap_tbm_competitor();
				$list['bapi_region'] = $this->quotation->sap_tbm_region();
				$list['bapi_country'] = $this->quotation->sap_tbm_country();
				$list['bapi_industry'] = $this->quotation->sap_tbm_industry();
				$list['bapi_business_scale'] = $this->quotation->sap_tbm_business_scale();
				
				$list['bapi_sold_to'] = $this->quotation->sap_tbm_sold_to();
				$list['bapi_ship_to'] = $this->quotation->sap_tbm_ship_to();

				

				//####################################################################################################				

				//Load top menu
				$data['top_menu'] = $this->load->view('__projects/include/top',$menuConfig,true);

				//Load side menu

				$user_department_id = $this->session->userdata('department');

				$side_data['module_list'] = array();
				$module_list = $this->module_model->getModuleList();
				if (!empty($module_list)) {
					foreach ($module_list as $key => $module) {
						if ($module['is_main_menu'] == 1 && array_key_exists($module['id'], $this->permission) && array_key_exists('view', $this->permission[$module['id']])) {
							$side_data['module_list'][$module['id']] = $module;
						}
					}
				}     

				$data['side_menu'] = $this->load->view('__projects/include/side',$side_data,true);


				$info = '';
				$data['top_project'] = $this->load->view('__quotation/include/top_project',$info,true);

				//Load body
				$data['body'] = $this->load->view('__quotation/page/detail_bodycfg',$list,true);

				$data['modal'] = $this->load->view('__quotation/page/detail_modal',$list,true);//return view as data
				// //Load footage script
				// $data['footage_script'] ='';//$this->load->view('__cms/script/api/api_manager_js','',true);				

				$this->load->view('__quotation/layout/detail',$data);

				break;



				case 'view_prospect':
			 	//TODO ::  EDIT DATA QUOTATION
				$this->prospect_id  = $id;
				$this->act = $act;


				// $this->status  = $status;				
				// $this->track_doc_id  = $id;
				// $this->untrack  = $untrack;

				$menuConfig['page_title'] = 'API Manager';
				$menuConfig['page_id'] 	  = 'api_manager';


				//#############  Query #########################################################################
				//Assign parameter for modal
				$this->load->model('__quotation_model','quotation');				
				//$list='';
				$list['get_prospect'] = $this->quotation->get_prospect();
				$list['query_prospect'] = $this->quotation->get_prospectByid($this->prospect_id);
				//$list['query_main_contract'] = $this->quotation->get_main_contract_Byid('prospect',$this->prospect_id);
				$list['bapi_contact_title'] = $this->quotation->bapi_contact_title();
				$list['bapi_distribution'] = $this->quotation->sap_tbm_distribution_channel();		
				$list['bapi_other_function'] = $this->quotation->sap_tbm_function();	
				$list['bapi_department'] = $this->quotation->sap_tbm_department();	

				$list['query_contact'] = $this->quotation->get_contact_prospect($this->prospect_id);
				$list['query_doc_importance'] = $this->quotation->get_document_importance('prospect',$this->prospect_id);
				$list['query_doc_other'] = $this->quotation->get_document_other('prospect',$this->prospect_id);

				//=== get Bapi sap tbm ===
				$list['bapi_competitor'] = $this->quotation->sap_tbm_competitor();
				$list['bapi_region'] = $this->quotation->sap_tbm_region();
				$list['bapi_country'] = $this->quotation->sap_tbm_country();
				$list['bapi_industry'] = $this->quotation->sap_tbm_industry();
				$list['bapi_business_scale'] = $this->quotation->sap_tbm_business_scale();
				
				$list['bapi_sold_to'] = $this->quotation->sap_tbm_sold_to();
				$list['bapi_ship_to'] = $this->quotation->sap_tbm_ship_to();

				

				//####################################################################################################				

				//Load top menu
				$data['top_menu'] = $this->load->view('__projects/include/top',$menuConfig,true);

				//Load side menu

				$user_department_id = $this->session->userdata('department');

				$side_data['module_list'] = array();
				$module_list = $this->module_model->getModuleList();
				if (!empty($module_list)) {
					foreach ($module_list as $key => $module) {
						if ($module['is_main_menu'] == 1 && array_key_exists($module['id'], $this->permission) && array_key_exists('view', $this->permission[$module['id']])) {
							$side_data['module_list'][$module['id']] = $module;
						}
					}
				}    

				$data['side_menu'] = $this->load->view('__projects/include/side',$side_data,true);


				$info = '';
				$data['top_project'] = $this->load->view('__quotation/include/top_project',$info,true);

				//Load body
				$data['body'] = $this->load->view('__quotation/page/detail_bodycfg',$list,true);

				$data['modal'] = $this->load->view('__quotation/page/detail_modal',$list,true);//return view as data
				// //Load footage script
				// $data['footage_script'] ='';//$this->load->view('__cms/script/api/api_manager_js','',true);				

				$this->load->view('__quotation/layout/detail',$data);

				break;			

				default:			

				break;
			}

			
		}


//#################################################
//=========== GET AJAX sold to ====================
//#################################################	

		public function get_ajax_position($id, $quotation_id=0){
			$id = urldecode($id);
        //$id = str_replace("----","/",$id);        

			$quotation = $this->__ps_project_query->getObj('tbt_quotation', array('id' => $quotation_id));
			$this->load->model('__quotation_model');     
			$output = $this->__quotation_model->get_ajax_position($id, $quotation['ship_to_id']);
			$output = $output['result'];
			echo json_encode($output);
		} 


		public function get_ajax_uniform($id){
			$id = urldecode($id);
        //$id = str_replace("----","/",$id); 
			if($id=='1702'){
        	//head
				$id = '0698';
			}else{
        	//staff
				$id = '0699';
			}

			$this->load->model('__quotation_model');     
			$output = $this->__quotation_model->get_ajax_uniform($id);
			$output = $output['result'];

			echo json_encode($output);
		} 

		public function get_ajax_sap_tbm_mat_group($group_machines,$job_type){
		//echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
			$group_machines = urldecode($group_machines);
			$job_type = urldecode($job_type);
        //$id = str_replace("----","/",$id);  

			$this->load->model('__quotation_model');     
			$output = $this->__quotation_model->get_ajax_sap_tbm_mat_group($group_machines,$job_type);
			$output = $output['result'];

			echo json_encode($output);
		} 


		public function get_area_clearing($frequency,$qt_id){
			$frequency = urldecode($frequency);
			$qt_id = urldecode($qt_id);
        //$id = str_replace("----","/",$id);  

			$this->load->model('__quotation_model');     
			$output = $this->__quotation_model->get_area_clearing($frequency,$qt_id);
			$output = $output['result'];

			echo json_encode($output);
		} 

		public function get_chemical_and_other($id,$type,$job_type){
			$id = urldecode($id);
			$type = urldecode($type);
			$job_type = urldecode($job_type);

        // echo $type;
        // exit();

        //$id = str_replace("----","/",$id);  

			$this->load->model('__quotation_model');     
			$output = $this->__quotation_model->get_chemical_and_other_byID($id,$type,$job_type);

			$output = $output['result'];

			echo json_encode($output);
		} 


		public function get_chemical_and_other_clearing($id,$type){
			$id = urldecode($id);
			$type = urldecode($type);
        //$job_type = urldecode($job_type);

        // echo $type;
        // exit();

        //$id = str_replace("----","/",$id);  

			$this->load->model('__quotation_model');     
			$output = $this->__quotation_model->get_chemical_and_other_byID_clearing($id,$type);

			$output = $output['result'];

			echo json_encode($output);
		} 

		public function get_texture_by_id($id){
			$id = urldecode($id);
        //$id = str_replace("----","/",$id);  

			$this->load->model('__quotation_model');     
			$output = $this->__quotation_model->get_texture_by_id_ajax($id);
			$output = $output['result'];

			echo json_encode($output);
		} 


		public function get_industry_room_by_id($id){
			$id = urldecode($id);
        //$id = str_replace("----","/",$id);  

			$this->load->model('__quotation_model');     
			$output = $this->__quotation_model->get_industry_room_by_id_ajax($id);
			$output = $output['result'];

			echo json_encode($output);
		} 



		public function get_other_service_by_id($id){
			$id = urldecode($id);
        //$id = str_replace("----","/",$id);  

			$this->load->model('__quotation_model');     
			$output = $this->__quotation_model->get_ohter_serviceByid_ajax($id);
			$output = $output['result'];

			echo json_encode($output);
		} 


		public function get_sap_region($id){
        // $size = urldecode($size);
        //$id = str_replace("----","/",$id);  
			$id = urldecode($id);

			$this->load->model('__quotation_model');     
			$output = $this->__quotation_model->get_sap_region_Byid_ajax($id);
			$output = $output['result'];

			echo json_encode($output);
		} 


		public function get_prospect_by_id($id){
        // $size = urldecode($size);
			$id = str_replace("----","/",$id);  

			$this->load->model('__quotation_model');     
			$output = $this->__quotation_model->get_prospectByid_ajax($id);
			$output = $output['result'];

			echo json_encode($output);
		} 

		public function get_sold_to_by_id($id){
        // $size = urldecode($size);
			$id = str_replace("----","/",$id);  

			$this->load->model('__quotation_model');     
			$output = $this->__quotation_model->get_sold_to_Byid_ajax($id);
			$output = $output['result'];

			echo json_encode($output);
		} 


		public function get_ship_to_by_id($id){
        // $size = urldecode($size);
			$id = str_replace("----","/",$id);  

			$this->load->model('__quotation_model');     
			$output = $this->__quotation_model->get_ship_to_Byid_ajax($id);
			$output = $output['result'];

			echo json_encode($output);
		} 


		public function get_ship_to_by_id_reset($id,$type,$distribution_channel){
        // $size = urldecode($size);
			$id = str_replace("----","/",$id);  
			$distribution_channel = urldecode($distribution_channel);
			$type = urldecode($type);

			$this->load->model('__quotation_model');     
			$output = $this->__quotation_model->get_ship_to_Byid_ajax_reset($id,$type,$distribution_channel);
			$output = $output['result'];

			echo json_encode($output);
		} 

		public function get_sap_sold_to($job_type,$distribution_channel){
			$job_type = urldecode($job_type);
			$distribution_channel = urldecode($distribution_channel);
        //$job_type = str_replace("----","/",$job_type); 

			$this->load->model('__quotation_model');   
			$output = $this->__quotation_model->get_sold_to_ajax($job_type,$distribution_channel);
			$output = $output['result'];
			echo json_encode($output);

		} 

//#################################################
//=========== UPload file prospect=================
//#################################################
		public function upload_file_prospect(){

	//echo "function upload <br>";
			$post = $this->input->post();
			$this->load->model('__quotation_model');

			if(!empty($post)){
				$is_importance = $post['is_importance'];
				$prospect_id =  $post['prospect_id'];
				$path ='';
				$upload_path ='';
				$description='';
				if($is_importance==1){
					$upload_path = 'assets/upload/doc_importance';
				}else{
					$upload_path = 'assets/upload/doc_other';
				}	
				$description = $_FILES['image']['name'];


		//==== start : upload file ==========
				$config['upload_path'] = $upload_path;
				$config['allowed_types'] = 'xls|xlsx|pdf|doc|docx|gif|jpg|png';
				$config['max_size']    = '10000000';
	    // $config['max_width']  = '1024';
	    // $config['max_height']  = '768';   
				$rand = rand(1111,9999);
				$date= date("Y-m-d ");
				$config['file_name']  = $date.$rand;

				$this->load->library('upload', $config);        
				if ( ! $this->upload->do_upload('image')){
					$msg_error = $this->upload->display_errors();
					$error = 'ผิดพลาด: ไม่สามารถอัพโหลดไฟล์ได้ ';
	        //$fname='';
					echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
					echo '<script type="text/javascript">  alert("'.$error.$msg_error.'"); setTimeout(function(){window.location="'.site_url('__ps_quotation/detail_quotation/edit_prospect/'.$prospect_id).'"},1200);</script>';
					echo '<script> window.location="'.site_url('__ps_quotation/detail_quotation/edit_prospect/'.$prospect_id).'"; </script>';  
				}else{
					$data_upload= $this->upload->data();
	        //echo  '<br>'.$fname=$data_upload['file_name'];	    	
					$path = $upload_path.'/'.$data_upload['file_name'];

					$result = $this->__quotation_model->upload_file_prospect($description,$is_importance,$path,$prospect_id);
	        // echo  $result['msg']; 	

					echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";	     
					echo '<script type="text/javascript">  alert("'.$result['msg'].'"); setTimeout(function(){window.location="'.site_url('__ps_quotation/detail_quotation/edit_prospect/'.$prospect_id).'"},1200);</script>';
					echo '<script> window.location="'.site_url('__ps_quotation/detail_quotation/edit_prospect/'.$prospect_id).'"; </script>';        
				}  

	 //echo 'prospect_id: '.$prospect_id.'<br>';
	 //echo 'is_importance: '.$is_importance.'<br>';
	// echo 'upload_path: '.$upload_path.'<br>';
	// echo 'path: '.$path.'<br>';      



	}// end if post

}



public function upload_file_quotation(){

	//echo "function upload quotation <br>";

	$post = $this->input->post();
	$this->load->model('__quotation_model');

	if(!empty($post)){

		$is_importance = $post['is_importance'];
		$quotation_id =  $post['quotation_id'];
		$path ='';
		$upload_path ='';
		$description='';
		if($is_importance==1){
			$upload_path = 'assets/upload/doc_importance';
		}else{
			$upload_path = 'assets/upload/doc_other';
		}	
		$description = $_FILES['image']['name'];


		//==== start : upload file ==========
		$config['upload_path'] = $upload_path;
		$config['allowed_types'] = 'xls|xlsx|pdf|doc|docx|gif|jpg|png';
		$config['max_size']    = '10000000';
	    // $config['max_width']  = '1024';
	    // $config['max_height']  = '768';   
		$rand = rand(1111,9999);
		$date= date("Y-m-d ");
		$config['file_name']  = $date.$rand;

		$this->load->library('upload', $config);        
		if ( ! $this->upload->do_upload('image')){
			$msg_error = $this->upload->display_errors();
			$error = 'ผิดพลาด: ไม่สามารถอัพโหลดไฟล์ได้ <br>';
	        //$fname='';
			echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
			echo '<script type="text/javascript">  alert("'.$error.$msg_error.'"); setTimeout(function(){window.location="'.site_url('__ps_quotation/detail_quotation/edit_quotation/'.$quotation_id).'"},1200);</script>';
			echo '<script> window.location="'.site_url('__ps_quotation/detail_quotation/edit_quotation/'.$quotation_id).'"; </script>';  
		}else{
			$data_upload= $this->upload->data();
	        //echo  '<br>'.$fname=$data_upload['file_name'];	    	
			$path = $upload_path.'/'.$data_upload['file_name'];

			$result = $this->__quotation_model->upload_file_quotation($description,$is_importance,$path,$quotation_id);
	        // echo  $result['msg']; 	

			echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";	     
			echo '<script type="text/javascript">  alert("'.$result['msg'].'"); setTimeout(function(){window.location="'.site_url('__ps_quotation/detail_quotation/edit_quotation/'.$quotation_id).'"},1200);</script>';
			echo '<script> window.location="'.site_url('__ps_quotation/detail_quotation/edit_quotation/'.$quotation_id).'"; </script>';        
		}  

	 //echo 'prospect_id: '.$prospect_id.'<br>';
	 //echo 'is_importance: '.$is_importance.'<br>';
	// echo 'upload_path: '.$upload_path.'<br>';
	// echo 'path: '.$path.'<br>';      



	}// end if post
	
}

//#################################################
//=========== convert to quotation  ===============
//#################################################
function create_to_quotation($id){
	echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
	//echo "create_to_quotation";

	$this->load->model('__quotation_model','quotation');				
	
	$query_prospect = $this->quotation->get_prospectByid($id);

	foreach($query_prospect->result_array() as $value){ 

		$id_prospect = $value['id'];
		$title = $value['title'];
		$distribution_channel = $value['distribution_channel'];
		$job_type = $value['job_type'];
		$time = $value['time'];
		$unit_time = $value['unit_time'];
		$project_owner_id = $this->session->userdata('id');
		$competitor_id = $value['competitor_id'];
		$replaced_by = $value['replaced_by'];
		$create_date = date('Y-m-d');
		$sold_to_name1 = $value['sold_to_name1'];
			// $sold_to_name2 = $value['sold_to_name2'];
		$sold_to_address1 = $value['sold_to_address1'];
		$sold_to_address2 = $value['sold_to_address2'];
		$sold_to_address3 = $value['sold_to_address3'];
		$sold_to_address4 = $value['sold_to_address4'];
		$sold_to_district = $value['sold_to_district'];
		$sold_to_city = $value['sold_to_city'];
		$sold_to_postal_code = $value['sold_to_postal_code'];
		$sold_to_country = $value['sold_to_country'];
		$sold_to_region = $value['sold_to_region'];
		$sold_to_business_scale = $value['sold_to_business_scale'];

		$sold_to_customer_group = $value['sold_to_customer_group'];
		$sold_to_industry = $value['sold_to_industry'];
		$sold_to_tel = $value['sold_to_tel'];
		$sold_to_tel_ext = $value['sold_to_tel_ext'];
		$sold_to_fax = $value['sold_to_fax'];
		$sold_to_fax_ext = $value['sold_to_fax_ext'];
		$sold_to_mobile = $value['sold_to_mobile'];
		$sold_to_email = $value['sold_to_email'];	
		$plan_code_prospect = $value['plan_code_prospect'];	


		}//end foreach

			//get laster id qoutation
		$id_quotation = $this->__quotation_model->getLastQuotationId($job_type);	


		//get last id getLastQuotationId
		if($id_quotation ==1 ){		
			
			$id_quotation = (round(floor(($id_quotation/100)))+1)*100;

			if($job_type == 'ZQT1' ){
					//$id_quotation += 1115000000;
				$id_quotation += 1115060000;					

			}else if($job_type == 'ZQT2'){
					//$id_quotation += 1125000000;
				$id_quotation += 1125060000; 
			}else{ 
					//$id_quotation += 1135000000;
				$id_quotation += 1135060000;  
			}
		}else{
			$id_quotation = (round(floor(($id_quotation/100)))+1)*100;				
		}

		$id_quotation = $id_quotation;			

			 //==== indsert qt =======
		$result = $this->__quotation_model->insert_create_to_quotation($id_quotation,$id_prospect,$title,$job_type,$time,$distribution_channel
			,$unit_time,$project_owner_id,$competitor_id,$replaced_by,$create_date
			,$sold_to_name1,$sold_to_address1,$sold_to_address2,$sold_to_address3,$sold_to_address4
			,$sold_to_district,$sold_to_city,$sold_to_postal_code,$sold_to_country,$sold_to_region
			,$sold_to_business_scale,$sold_to_customer_group,$sold_to_industry,$sold_to_tel,$sold_to_tel_ext
			,$sold_to_mobile,$sold_to_email,$sold_to_fax,$sold_to_fax_ext,$plan_code_prospect 
			); 

			 // $result = $this->__quotation_model->insert_create_to_quotation($id_quotation,$id_prospect,$title,$job_type,$time,$distribution_channel
			 // 													,$unit_time,$project_owner_id,$competitor_id,$replaced_by,$create_date
			 // 													,$sold_to_name1,$sold_to_name2,$sold_to_address1,$sold_to_address2,$sold_to_address3,$sold_to_address4
			 // 													,$sold_to_district,$sold_to_city,$sold_to_postal_code,$sold_to_country,$sold_to_region
			 // 													,$sold_to_business_scale,$sold_to_customer_group,$sold_to_industry,$sold_to_tel,$sold_to_tel_ext
			 // 													,$sold_to_mobile,$sold_to_email,$sold_to_fax,$sold_to_fax_ext
			 // 													); 

		$last_id = $result['last_id'];
		$result_msg = $result['msg'];
			// echo "<br>".$result_msg ;

			//==  get contact ==
		$query_contact = $this->quotation->get_contact_prospect($id);
		$temp_query_contact = $query_contact->result_array();
		if(!empty($temp_query_contact)){
			foreach($query_contact->result_array() as $value){ 

				$title = $value['title'];
				$firstname = $value['firstname'];
				$lastname  = $value['lastname'];
					 //$position = $value['position'];
				$function = $value['function'];
				$department = $value['department'];
				$tel = $value['tel'];
				$tel_ext = $value['tel_ext'];
				$mobile_no = $value['mobile_no'];
				$fax = $value['fax'];
				$fax_ext = $value['fax_ext'];
				$email = $value['email'];
				$is_main_contact = $value['is_main_contact'];
				$quotation_id =  $last_id;
				$ship_to_id = $id_prospect;

					// echo '////////////////';
					// echo '<br>'.$firstname ;
				 // 	echo '<br>'.$lastname  ;
					// echo '<br>'.$position ;
					// echo '<br>'.$function ;
					// echo '<br>'.$department ; 
					// echo '<br>'.$tel;
					// echo '<br>'.$tel_ext;
					// echo '<br>'.$mobile_no;
					// echo '<br>'.$fax;
					// echo '<br>'.$fax_ext;
					// echo '<br>'.$email;
					// echo '<br>'.$is_main_contact;
					// echo '<br>'.$quotation_id;
					// echo '<br>'.$ship_to_id;

					 //==== indsert qt =======
				$result_contract = $this->__quotation_model->insert_create_to_quotation_contact($title,$firstname,$lastname
					,$function,$department,$tel,$tel_ext,$mobile_no,$fax,$fax_ext,$email,$is_main_contact
					,$quotation_id,$ship_to_id
					); 
				$result_contract_msg = $result_contract['msg'];
			 		 //echo "<br>".$result_contract_msg ;

				}//end foreach
			}//end if


			//==  get query_doc_importance ==
			$query_doc_importance = $this->quotation->get_document_importance('prospect',$id);
			$temp_query_doc_importance = $query_doc_importance->result_array();
			if(!empty($temp_query_doc_importance)){
				foreach($query_doc_importance->result_array() as $value){ 
					//echo "<br>=== doc ===";

					$description = $value['description'];
					$own_by = $value['own_by'];
					$is_approve = $value['is_approve'];
					$project_id = $value['project_id'];
					$delete_flag = $value['delete_flag'];
					$path = $value['path'];
					$contract_id = '';
					$is_importance = $value['is_importance'];
					$quotation_id =  $last_id;
					

					//echo '<br>description :'.$description;

					//==== indsert doc =======
					$result_doc = $this->__quotation_model->insert_create_to_quotation_doc($description,$own_by,$is_approve
						,$delete_flag,$path,$contract_id,$is_importance,$quotation_id
						); 
					$result_doc_msg = $result_doc['msg'];
			 		 //echo "<br>".$result_doc_msg;

				}// end foreach
			}//end if


			//== get_document_other ==
			$query_doc_other = $this->quotation->get_document_other('prospect',$id);
			$temp_query_doc_other = $query_doc_other->result_array();
			if(!empty($temp_query_doc_other)){
				foreach($query_doc_other->result_array() as $value){ 

					//echo "<br>=== other doc ===";


					$description = $value['description'];
					$own_by = $value['own_by'];
					$is_approve = $value['is_approve'];
					$project_id = $value['project_id'];
					$delete_flag = $value['delete_flag'];
					$path = $value['path'];
					$contract_id = '';
					$is_importance = $value['is_importance'];
					$quotation_id =  $last_id;
					

					//echo '<br>description :'.$description;

					//==== indsert doc other=======
					$result_doc = $this->__quotation_model->insert_create_to_quotation_doc($description,$own_by,$is_approve
						,$delete_flag,$path,$contract_id,$is_importance,$quotation_id
						); 
					$result_doc_msg = $result_doc['msg'];
			 		 //echo "<br>".$result_doc_msg ;

				}// end foreach
			}//end if

			echo '<script type="text/javascript">  alert("เพิ่มข้อมูลเรียบร้อยแล้ว"); setTimeout(function(){window.location="'.site_url('__ps_quotation/detail_quotation/edit_quotation/'.$last_id).'"},1200);</script>';
			echo '<script> window.location="'.site_url('__ps_quotation/detail_quotation/edit_quotation/'.$last_id).'"; </script>';

}//end function

//#################################################
//=========== insert quotation======================
//#################################################

function insert_quotation(){

	$p = $this->input->post();
	if(!empty($p)){


		if (empty($p['customer_source'])) {
			$p['customer_source'] = '0';
		}

		if (empty($p['prospect_customer'])){
			$p['prospect_customer'] = '0';
		}

		if (empty($p['sold_to'])) {
			$p['sold_to'] = '0';
		}	

		if($p['job_type']=='ZQT1'){
			$accountGroup = 'Z10';
		}else if($p['job_type']=='ZQT2'){
			$accountGroup = 'Z11';
		}else if($p['job_type']=='ZQT2_extra'){
			$accountGroup = 'Z16';
		}else{
			$accountGroup = 'Z12';
		}  

		if ($p['job_type'] == 'ZQT2_extra') {
			$p['job_type'] = 'ZQT2';
		}

			// echo  'title '.$p['title'].'<br>';
			// echo  'job_type '.$p['job_type'].'<br>';
			// echo  'doc_type '.$p['doc_type'].'<br>';
			// echo  'time '.$p['time'].'<br>';	
			// echo  'unit_time '.$p['unit_time'].'<br>';		

			// echo  'project_start_date '.$p['project_start_date'].'<br>';
			// echo  'project_end_date '.$p['project_end_date'].'<br>';
			//echo  'competitor_id '.$p['competitor_id'].'<br>';

		 //    echo  'customer_source '.$p['customer_source'].'<br>';
			// echo  'sold_to '.$p['sold_to'].'<br>';
			// echo  'prospect_customer '.$p['prospect_customer'].'<br>';        	



		
		$row = $this->__ps_project_query->getObj('tbt_prospect', array('id' => 1125000000));

		 //exit();

		$this->load->model('__quotation_model');

		if($p['doc_type']!=1){
					//get last id getLastQuotationId
			$id = $this->__quotation_model->getLastQuotationId($p['job_type']);							
			if($id ==1 ){			
				$id = (round(floor(($id/100)))+1)*100;	

				if($p['job_type'] == 'ZQT1' ){
								//$id += 1115000000; 
					$id += 1115060000;

				}else if($p['job_type'] == 'ZQT2'){
								//$id += 1125000000; 
					$id += 1125060000;

				}else{ 
								//$id += 1135000000; 
					$id += 1135060000; 

				}
			}
			else{
				$id = (round(floor(($id/100)))+1)*100;				
			}

			$last_id_db = $id;

						//echo '<br>last_id_db :'.$last_id_db;

		}else{				

						//get laster id getLastProspectId
			$id = $this->__quotation_model->getLastProspectId();
						//$id = (round(floor(($id/100)))+1)*100;
			if($id ==1 ){
				$id = 9000000000;
			}

			$last_id_db = $id;
						//echo '<br>Prospect xx :'.$last_id_db;
		}



//echo  $id.' : job_type :'.$p['job_type'];
// echo "<pre>";
// echo print_r($p);
// die();
//exit();


		$result = $this->__quotation_model->insert_quotation($p,$last_id_db,$accountGroup); 	

		$last_id_redirect = $result['last_id'];
			//======= submit to sap =====================
			//self::insert_fixclaim_toSap($p,$project_id);
		}//end post	    	

		if($p['doc_type']==1){			
			echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
			echo '<script type="text/javascript">  alert("เพิ่มข้อมูลเรียบร้อยแล้ว"); setTimeout(function(){window.location="'.site_url('__ps_quotation/detail_quotation/edit_prospect/'.$last_id_redirect).'"},1200);</script>';
			echo '<script> window.location="'.site_url('__ps_quotation/detail_quotation/edit_prospect/'.$last_id_redirect).'"; </script>';

			// echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
			// echo '<script type="text/javascript">  alert("'.$result['msg'].'"); setTimeout(function(){window.location="'.site_url('__ps_quotation/listview_prospect').'"},1200);</script>';
		 //    echo '<script> window.location="'.site_url('__ps_quotation/listview_prospect').'"; </script>';
		}else{

			echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
			echo '<script type="text/javascript">  alert("เพิ่มข้อมูลเรียบร้อยแล้ว"); setTimeout(function(){window.location="'.site_url('__ps_quotation/detail_quotation/edit_quotation/'.$last_id_redirect).'"},1200);</script>';
			echo '<script> window.location="'.site_url('__ps_quotation/detail_quotation/edit_quotation/'.$last_id_redirect).'"; </script>';

			// echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
			// echo '<script type="text/javascript">  alert("'.$result['msg'].'"); setTimeout(function(){window.location="'.site_url('__ps_quotation/listview_quotation').'"},1200);</script>';
		 //    echo '<script> window.location="'.site_url('__ps_quotation/listview_quotation').'"; </script>';
		}
		

	}



//#################################################
//==================== UPDATE =====================
//#################################################

	function update_quotation_clearing($quotation_id){
//echo "update_quotation_clearing";
		echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
		$this->load->model('__quotation_model','quotation');
		$get_area =  $this->quotation->get_area_Byid($quotation_id);


//TODO : DLETE buding floor and area of qt
		$result_delete = $this->__quotation_model->delete_clearing_chemical($quotation_id);	
//echo $result_delete['msg'];
//End: ========================================


//TODO :  updata summary
		$result_summary = $this->__quotation_model->update_summary($quotation_id);	
	//echo $result_summary['msg'];


		$p = $this->input->post();
		if(!empty($p)){


//================== start :: get data row chemical =============================
//== count_row_frequency row data chemical ==
			$count_row_frequency = $p['count_row_frequency'];
//echo "<br> count_row_frequency :: ".$count_row_frequency;

			for ($a = 1; $a <= $count_row_frequency; $a++){
//echo "<br>========== CHEMICAL ".$a." =============";	


				if (!array_key_exists('mach_mat_group_des_'.$a, $p)) {
					$p['mach_mat_group_des_'.$a] = '';
				}

				if (!array_key_exists('material_no_'.$a, $p)) {
					$p['material_no_'.$a] = '0';
				}
				if (!array_key_exists('mat_type_'.$a, $p)) {
					$p['mat_type_'.$a] = '0';
				}
				if (!array_key_exists('mat_group_'.$a, $p)) {
					$p['mat_group_'.$a] = '0';
				}
				if (!array_key_exists('frequency_'.$a, $p)) {
					$p['frequency_'.$a] = '0';
				}
				if (!array_key_exists('quantity_'.$a, $p)) {
					$p['quantity_'.$a] = '0';
				}
				if (!array_key_exists('unit_code_'.$a, $p)) {
					$p['unit_code_'.$a] = '0';
				}
				if (!array_key_exists('price_'.$a, $p)) {
					$p['price_'.$a] = '0';
				}
				if (!array_key_exists('total_price_'.$a, $p)) {
					$p['total_price_'.$a] = '0';
				}
				if (!array_key_exists('clearing_type_'.$a, $p)) {
					$p['clearing_type_'.$a] = '0';
				}

				if($mat_type!='Z005'){
					$mat_group_des = '';
				}else{
					$mat_group_des = $p['mach_mat_group_des_'.$a];
				}

				$material_no = $p['material_no_'.$a];
				$mat_type    = $p['mat_type_'.$a];
				$mat_group   = $p['mat_group_'.$a];
				$frequency   = $p['frequency_'.$a];
				$quantity    = $p['quantity_'.$a];
				$quantity_unit   = $p['unit_code_'.$a];		
				$price       = $p['price_'.$a];
				$total_price = $p['total_price_'.$a];		
				$clearing_type = $p['clearing_type_'.$a];	


		// echo "<br> material_no 	::".$material_no;
		// echo "<br> mat_type 	::".$mat_type;
		// echo "<br> mat_group 	::".$mat_group;
		// echo "<br> mat_group_des 	::".$mat_group_des;
		// echo "<br> frequency 	::".$frequency;
		// echo "<br> quantity 	::".$quantity;
		// echo "<br> quantity_unit 	::".$quantity_unit;
		// echo "<br> price 		::".$price;
		// echo "<br> total_price  ::".$total_price;
		// echo "<br> clearing_type  ::".$clearing_type;

	//=== save to database ===
				$result_chemical = $this->__quotation_model->insert_clearing($quotation_id,$material_no
					,$mat_type,$mat_group,$mat_group_des
					,$quantity,$quantity_unit,$price,$total_price,$frequency,$clearing_type); 

				$result_chemical_msg = $result_chemical['msg'];
	//echo "<br> result_chemical_msg :: ".$result_chemical_msg;

}//end for chemical


//================== start :: get data row machine =================================
// //== count_clearing_machine ==
// $count_clearing_machine = $p['count_clearing_machine'];
// //echo "<br> count_clearing_machine :: ".$count_clearing_machine;

// for ($b = 1; $b <= $count_clearing_machine; $b++){
// //echo "<br>========== MACHINE ".$b." =============";

// 	if (!array_key_exists('mach_mat_group_des_'.$b, $p)) {
//         $p['mach_mat_group_des_'.$b] = '0';
//  	}
//  	if (!array_key_exists('mach_material_no_'.$b, $p)) {
//         $p['mach_material_no_'.$b] = '0';
//  	}
//  	if (!array_key_exists('mach_mat_type_'.$b, $p)) {
//         $p['mach_mat_type_'.$b] = '0';
//  	}
//  	if (!array_key_exists('mach_mat_group_'.$b, $p)) {
//         $p['mach_mat_group_'.$b] = '0';
//  	}
//  	if (!array_key_exists('mach_frequency_'.$b, $p)) {
//         $p['mach_frequency_'.$b] = '0';
//  	}
//  	if (!array_key_exists('mach_quantity_'.$b, $p)) {
//         $p['mach_quantity_'.$b] = '0';
//  	}
//  	if (!array_key_exists('mach_unit_code_'.$b, $p)) {
//         $p['mach_unit_code_'.$b] = '0';
//  	}
//  	if (!array_key_exists('mach_price_'.$b, $p)) {
//         $p['mach_price_'.$b] = '0';
//  	}
//  	if (!array_key_exists('mach_total_price_'.$b, $p)) {
//         $p['mach_total_price_'.$b] = '0';
//  	}

// 	$mat_group_des = $p['mach_mat_group_des_'.$b];
// 	$material_no = $p['mach_material_no_'.$b];
// 	$mat_type    = $p['mach_mat_type_'.$b];
// 	$mat_group   = $p['mach_mat_group_'.$b];
// 	$frequency   = $p['mach_frequency_'.$b];
// 	$quantity    = $p['mach_quantity_'.$b];
// 	$quantity_unit   = $p['mach_unit_code_'.$b];		
// 	$price       = $p['mach_price_'.$b];
// 	$total_price = $p['mach_total_price_'.$b];
// 	$clearing_type = '';	

// 	// echo "<br> mat_group_des 	::".$mat_group_des;
// 	// echo "<br> material_no 	::".$material_no;
// 	// echo "<br> mat_type 	::".$mat_type;
// 	// echo "<br> mat_group 	::".$mat_group;
// 	// echo "<br> frequency 	::".$frequency;
// 	// echo "<br> quantity 	::".$quantity;
// 	// echo "<br> quantity_unit 	::".$quantity_unit;
// 	// echo "<br> price 		::".$price;
// 	// echo "<br> total_price  ::".$total_price;
// 	// echo "<br> clearing_type  ::".$clearing_type;

// 	//=== save to database ===
// 	$result_machine = $this->__quotation_model->insert_clearing($quotation_id,$material_no
// 												,$mat_type,$mat_group,$mat_group_des
//     	                   						,$quantity,$quantity_unit,$price,$total_price,$frequency,$clearing_type); 

// 	$result_machine_msg = $result_machine['msg'];
// 	//echo "<br> result_machine_msg :: ".$result_machine_msg;


// }//end for chemical



//================== start :: get data row TOOL =================================
// //== count_clearing_tool ==
// $count_clearing_tool = $p['count_clearing_tool'];
// //echo "<br> count_clearing_tool :: ".$count_clearing_tool;

// for ($c = 1; $c <= $count_clearing_tool; $c++){
// //echo "<br>========== TOOL ".$c." =============";

// 	if (!array_key_exists('tool_material_no_'.$c, $p)) {
//         $p['tool_material_no_'.$c] = '0';
//  	}
//  	if (!array_key_exists('tool_mat_type_'.$c, $p)) {
//         $p['tool_mat_type_'.$c] = '0';
//  	}
//  	if (!array_key_exists('tool_mat_group_'.$c, $p)) {
//         $p['tool_mat_group_'.$c] = '0';
//  	}
//  	if (!array_key_exists('tool_frequency_'.$c, $p)) {
//         $p['tool_frequency_'.$c] = '0';
//  	}
//  	if (!array_key_exists('tool_quantity_'.$c, $p)) {
//         $p['tool_quantity_'.$c] = '0';
//  	}
//  	if (!array_key_exists('tool_unit_code_'.$c, $p)) {
//         $p['tool_unit_code_'.$c] = '0';
//  	}
//  	if (!array_key_exists('tool_price_'.$c, $p)) {
//         $p['tool_price_'.$c] = '0';
//  	}
//  	if (!array_key_exists('tool_total_price_'.$c, $p)) {
//         $p['tool_total_price_'.$c] = '0';
//  	}


// 	$mat_group_des = '';
// 	$material_no = $p['tool_material_no_'.$c];
// 	$mat_type    = $p['tool_mat_type_'.$c];
// 	$mat_group   = $p['tool_mat_group_'.$c];
// 	$frequency   = $p['tool_frequency_'.$c];
// 	$quantity    = $p['tool_quantity_'.$c];
// 	$quantity_unit   = $p['tool_unit_code_'.$c];		
// 	$price       = $p['tool_price_'.$c];
// 	$total_price = $p['tool_total_price_'.$c];
// 	$clearing_type = '';			

// 	// echo "<br> mat_group_des 	::".$mat_group_des;
// 	// echo "<br> material_no 	::".$material_no;
// 	// echo "<br> mat_type 	::".$mat_type;
// 	// echo "<br> mat_group 	::".$mat_group;
// 	// echo "<br> frequency 	::".$frequency;
// 	// echo "<br> quantity 	::".$quantity;
// 	// echo "<br> quantity_unit 	::".$quantity_unit;
// 	// echo "<br> price 		::".$price;
// 	// echo "<br> total_price  ::".$total_price;
// 	// echo "<br> clearing_type  ::".$clearing_type;

// 	//=== save to database ===
// 	$result_tool = $this->__quotation_model->insert_clearing($quotation_id,$material_no
// 												,$mat_type,$mat_group,$mat_group_des
//     	                   						,$quantity,$quantity_unit,$price,$total_price,$frequency,$clearing_type); 

// 	$result_tool_msg = $result_tool['msg'];
// 	//echo "<br> result_machine_msg :: ".$result_tool_msg;


// }//end for chemical






//////////////////// START : ADD data staff to tbt_area /////////////////////////
$count_clearing_number =0;
		//== TODO :: get frequency area =======================
$temp_area_clearing = $get_area->row_array();
$array_frequency =array('');
if(!empty($temp_area_clearing)){ 
	foreach($get_area->result_array() as $value){ 
		if($value['is_on_clearjob']==1){
			if (in_array( $value['frequency'], $array_frequency, TRUE)){                
		                //echo "have";
			}else{
		            //echo "nohave";
				array_push($array_frequency,$value['frequency']);            
		        }//end else 
		      }//end if check clearing
		   }//end foreach
		}//end if
		// prine 
		// print_r($array_frequency);
		// echo "<br>";
		//== TODO :: get  area clearing =======================
		$temp_clearing_type =array('');
		$temp_clearing_name =array();
		$temp_frequen= $array_frequency;
		if(!empty($temp_frequen)){
			foreach($array_frequency as $fre => $fre_value) { 
				if($fre != 0){
					foreach($get_area->result_array() as $value){ 
						if($value['is_on_clearjob']==1 && $value['frequency']==$fre_value){                 
							if (in_array( $value['clear_job_type_id'], $temp_clearing_type, TRUE)){                
		                        //echo "have";
							}else{
		                    //echo "nohave";
								array_push($temp_clearing_type,$value['clear_job_type_id']);  
								$temp_clearing_name[$value['clear_job_type_id']] = $value['clearing_des'];          
		                }//end else 
		                //set : $count_space_for_clearing =0;               
		              }//end if check clearing
		           }//end foreach          

		           $count_array_clering = count($temp_clearing_name); 

		           $count_clearing_frequency =  $p['count_clearing_frequency_'.$fre_value];
		            //echo '<br><br>///////////////////////// frequency : '.$fre_value.'///////////////////////////////';
		            //echo "<br >count_clearing_frequency :".$count_clearing_frequency;

		      }//end if

		      $temp_count_clearing = 0;
		      foreach($temp_clearing_name as $clear_id => $clear_value) { 
		      	$count_clearing_number++;
		      	$temp_count_clearing++;     

		      	$staff_clearing =  $p['staff_clearing_'.$clear_id.'_'.$temp_count_clearing.'_'.$count_clearing_number];
		      	$job_rate =  $p['rate_job_'.$clear_id.'_'.$temp_count_clearing.'_'.$count_clearing_number];
		      	$price_job =  $p['price_job_'.$clear_id.'_'.$temp_count_clearing.'_'.$count_clearing_number];
		      	$other =  $p['other_'.$clear_id.'_'.$temp_count_clearing.'_'.$count_clearing_number];
		      	$other_price =  $p['other_price_'.$clear_id.'_'.$temp_count_clearing.'_'.$count_clearing_number];
		      	$total_price =  $p['total_price_'.$clear_id.'_'.$temp_count_clearing.'_'.$count_clearing_number];
		      	$frequency_clearing_type = $fre_value;
		      	$clearing_type_id = $clear_id;

		      	$job_rate = str_replace(',', '', $job_rate);
		      	$price_job = str_replace(',', '', $price_job);
		      	$other_price = str_replace(',', '', $other_price);
		      	$total_price = str_replace(',', '', $total_price);

		            // echo '<br>/////////  clearin_type :  '.$clear_id.' | NO : '.$temp_count_clearing.'/////////////';
		            // echo "<br>frequency_clearing_type :".$frequency_clearing_type;
		            // echo "<br>clearing_type_id :".$clearing_type_id;
		            // echo "<br>staff_clearing :".$staff_clearing;
		            // echo "<br>job_rate :".$job_rate;
		            // echo "<br>price_job :".$price_job;
		            // echo "<br>other :".$other;
		            // echo "<br>other_price :".$other_price;
		            // echo "<br>total_price :".$total_price;
//exit();
		            //=== save to database ===
		      	$result_staff = $this->__quotation_model->update_staff_clearing($quotation_id,$frequency_clearing_type
		      		,$clearing_type_id,$staff_clearing,$job_rate
		      		,$price_job,$other,$other_price,$total_price); 

		      	$result_staff_msg = $result_staff['msg'];
					//echo "<br> result_staff_msg :: ".$result_staff_msg;

		      	$count_space =0;
	       }//end foreach temp_clearing_name
	      //set : array annd count space          
	       $temp_clearing_type =array();
	       $temp_clearing_name =array();

	  }//end foreach
	}//end if empty

//////////////////// END : ADD data staff to tbt_area /////////////////////////




	}//end post


	 //exit();
	echo '<script type="text/javascript">  alert("เพิ่มข้อมูลเรียบร้อยแล้ว"); setTimeout(function(){window.location="'.site_url('__ps_quotation/detail_quotation/edit_quotation/'.$quotation_id.'/0/5').'"},1200);</script>';
	echo '<script> window.location="'.site_url('__ps_quotation/detail_quotation/edit_quotation/'.$quotation_id.'/0/5').'"; </script>';


}//end function





function update_quotation_chemical($quotation_id){

//echo "update_quotation_chemical";
	echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
	$this->load->model('__quotation_model');

////////////////////// TODO : DLETE CHEMICAL AND OTHERs /////////////////
	$result_delete = $this->__quotation_model->delete_chemical($quotation_id);	
	//echo "<br> DLETE : ".$result_delete['msg'];
//=========================================================================


//TODO :  updata summary
	$result_summary = $this->__quotation_model->update_summary($quotation_id);	
		//echo $result_summary['msg'];

	$p = $this->input->post();

// echo "<pre>";
// print_r($p);
// echo "</pre>";

// die();
	if(!empty($p)){

	///== $job_type ===
		//echo "job_type_chemical :".$p['job_type_chemical'].'<br>';
		//die();

	//== count space ==
		$temp_count_space_Z001 = $p['temp_count_space_Z001'];
	//echo "<br> temp_count_space_Z001 :: ".$temp_count_space_Z001;


	//======== start :: get chemical =====================
		for ($a = 1; $a <= $temp_count_space_Z001; $a++){

			$temp_count_chemical = $p['temp_count_chemical_'.$a];
	//echo "<br>============= TEMP COUNT CHEMICAL ".$a." ::".$temp_count_chemical." ============";

			for ($b = 1; $b <= $temp_count_chemical; $b++){

	//echo "<br>========= temp_count_chemical :: ".$b." ==========";

				if (!array_key_exists('texture_id_'.$a.'_'.$b, $p)) {
					$p['texture_id_'.$a.'_'.$b] = '0';
				}
				if (!array_key_exists('material_no_'.$a.'_'.$b, $p)) {
					$p['material_no_'.$a.'_'.$b] = '0';
				}
				if (!array_key_exists('mat_type_'.$a.'_'.$b, $p)) {
					$p['mat_type_'.$a.'_'.$b] = '0';
				}
				if (!array_key_exists('mat_group_'.$a.'_'.$b, $p)) {
					$p['mat_group_'.$a.'_'.$b] = '0';
				}
				if (!array_key_exists('quantity_'.$a.'_'.$b, $p)) {
					$p['quantity_'.$a.'_'.$b] = '0';
				}
				if (!array_key_exists('unit_code_'.$a.'_'.$b, $p)) {
					$p['unit_code_'.$a.'_'.$b] = '0';
				}
				if (!array_key_exists('space_'.$a.'_'.$b, $p)) {
					$p['space_'.$a.'_'.$b] = '0';
				}
				if (!array_key_exists('price_'.$a.'_'.$b, $p)) {
					$p['price_'.$a.'_'.$b] = '0';
				}

				if (!array_key_exists('total_price_'.$a.'_'.$b, $p)) {
					$p['total_price_'.$a.'_'.$b] = '0';
				}

				$mat_group_des  = '';
				$texture_id  = $p['texture_id_'.$a.'_'.$b];
				$material_no = $p['material_no_'.$a.'_'.$b];
				$mat_type    = $p['mat_type_'.$a.'_'.$b];
				$mat_group   = $p['mat_group_'.$a.'_'.$b];
				$quantity    = $p['quantity_'.$a.'_'.$b];
				$quantity_unit   = $p['unit_code_'.$a.'_'.$b];
				$space       = $p['space_'.$a.'_'.$b];
				$price       = $p['price_'.$a.'_'.$b];
				$total_price = $p['total_price_'.$a.'_'.$b];
				$is_customer_request       = 0;		


		// if($mat_type=='Z013'){
  //             $quantity = -1;
  //             $quantity_unit = -1;
  //             $price = -1;
  //             $space = -1;

  //       }//end if

			// echo "<br> texture_id 	::".$texture_id;
			// echo "<br> material_no 	::".$material_no;
			// echo "<br> mat_type 	::".$mat_type;
			// echo "<br> mat_group 	::".$mat_group;
			// echo "<br> quantity 	::".$quantity;
			// echo "<br> quantity_unit 	::".$quantity_unit;
			// echo "<br> space 		::".$space;
			// echo "<br> price 		::".$price;
			// echo "<br> total_price  ::".$total_price;
			// echo "<br> is_customer_request 		::".$is_customer_request;


			//=== save to database ===
				$result_chemical = $this->__quotation_model->insert_chemical($quotation_id,$mat_group_des,$texture_id,$material_no,$mat_type,$mat_group,$space
					,$quantity,$quantity_unit,$price,$total_price,$is_customer_request); 

				$result_chemical_msg = $result_chemical['msg'];
			//echo "<br> result_chemical_msg :: ".$result_chemical_msg;

		}//end for temp_count_chemical


	}//enf for temp_count_space_Z001
	//======== end :: get chemical =====================

	
//echo "<br>==================== MACHINE ========================";

	//== count machine ==
	$temp_count_machine = $p['temp_count_machine'];
	//echo "<br> temp_count_machine :: ".$temp_count_machine;

	for ($c = 1; $c <= $temp_count_machine; $c++){

	//echo "<br>======== temp_count_machine :: ".$c." =========";

		if (!array_key_exists('mach_texture_id_'.$c, $p)) {
			$p['mach_texture_id_'.$c] = '0';
		}
		if (!array_key_exists('mach_material_no_'.$c, $p)) {
			$p['mach_material_no_'.$c] = '0';
		}
		if (!array_key_exists('mach_mat_type_'.$c, $p)) {
			$p['mach_mat_type_'.$c] = '0';
		}
		if (!array_key_exists('mach_mat_group_'.$c, $p)) {
			$p['mach_mat_group_'.$c] = '0';
		}
		if (!array_key_exists('mach_quantity_'.$c, $p)) {
			$p['mach_quantity_'.$c] = '0';
		}
		if (!array_key_exists('mach_unit_code_'.$c, $p)) {
			$p['mach_unit_code_'.$c] = '0';
		}
		if (!array_key_exists('mach_space_'.$c, $p)) {
			$p['mach_space_'.$c] = '0';
		}
		if (!array_key_exists('mach_price_'.$c, $p)) {
			$p['mach_price_'.$c] = '0';
		}

		if (!array_key_exists('mach_total_price_'.$c, $p)) {
			$p['mach_total_price_'.$c] = '0';
		}

		if (!array_key_exists('mach_mat_group_des_'.$c, $p)) {
			$p['mach_mat_group_des_'.$c] = '0';
		}


		$mat_group_des  = $p['mach_mat_group_des_'.$c];
		$texture_id  = $p['mach_texture_id_'.$c];
		$material_no = $p['mach_material_no_'.$c];
		$mat_type    = $p['mach_mat_type_'.$c];
		$mat_group   = $p['mach_mat_group_'.$c];
		$quantity    = $p['mach_quantity_'.$c];
		$quantity_unit   = $p['mach_unit_code_'.$c];
		$space       = $p['mach_space_'.$c];
		$price       = $p['mach_price_'.$c];
		$total_price = $p['mach_total_price_'.$c];
		$is_customer_request       = 0;

		// echo "<br> mat_group_des 	::".$mat_group_des;
		// echo "<br> texture_id 	::".$texture_id;
		// echo "<br> material_no 	::".$material_no;
		// echo "<br> mat_type 	::".$mat_type;
		// echo "<br> mat_group 	::".$mat_group;
		// echo "<br> quantity 	::".$quantity;
		// echo "<br> quantity_unit 	::".$quantity_unit;
		// echo "<br> space 		::".$space;
		// echo "<br> price 		::".$price;
		// echo "<br> total_price 		::".$total_price;
		// echo "<br> is_customer_request 		::".$is_customer_request;

		//=== save to database ===
		$result_machine = $this->__quotation_model->insert_chemical($quotation_id,$mat_group_des,$texture_id,$material_no,$mat_type,$mat_group,$space
			,$quantity,$quantity_unit,$price,$total_price,$is_customer_request); 

		$result_machine_msg = $result_machine['msg'];
			//echo "<br> result_chemical_msg :: ".$result_machine_msg;

	}//end for machine


//echo "<br>==================== TOOL type : Z002 ========================";

	//== count TOOL type : Z002 ==
	$temp_count_tool_Z002 = $p['temp_count_tool_Z002'];
	//echo "<br> temp_count_tool_Z002 :: ".$temp_count_tool_Z002;

	for ($d = 1; $d <= $temp_count_tool_Z002; $d++){

	//echo "<br>======== temp_count_tool_Z002 :: ".$d." =========";

		if (!array_key_exists('texture_id_'.$d.'_Z002', $p)) {
			$p['texture_id_'.$d.'_Z002'] = '0';
		}
		if (!array_key_exists('material_no_'.$d.'_Z002', $p)) {
			$p['material_no_'.$d.'_Z002'] = '0';
		}
		if (!array_key_exists('mat_type_'.$d.'_Z002', $p)) {
			$p['mat_type_'.$d.'_Z002'] = '0';
		}
		if (!array_key_exists('mat_group_'.$d.'_Z002', $p)) {
			$p['mat_group_'.$d.'_Z002'] = '0';
		}
		if (!array_key_exists('quantity_'.$d.'_Z002', $p)) {
			$p['quantity_'.$d.'_Z002'] = '0';
		}
		if (!array_key_exists('unit_code_'.$d.'_Z002', $p)) {
			$p['unit_code_'.$d.'_Z002'] = '0';
		}
		if (!array_key_exists('space_'.$d.'_Z002', $p)) {
			$p['space_'.$d.'_Z002'] = '0';
		}
		if (!array_key_exists('price_'.$d.'_Z002', $p)) {
			$p['price_'.$d.'_Z002'] = '0';
		}

		if (!array_key_exists('total_price_'.$d.'_Z002', $p)) {
			$p['total_price_'.$d.'_Z002'] = '0';
		}

		$mat_group_des  = '';
		$texture_id  = $p['texture_id_'.$d.'_Z002'];
		$material_no = $p['material_no_'.$d.'_Z002'];
		$mat_type    = $p['mat_type_'.$d.'_Z002'];
		$mat_group   = $p['mat_group_'.$d.'_Z002'];
		$quantity    = $p['quantity_'.$d.'_Z002'];
		$quantity_unit   = $p['unit_code_'.$d.'_Z002'];
		$space       = $p['space_'.$d.'_Z002'];
		$price       = $p['price_'.$d.'_Z002'];
		$total_price       = $p['total_price_'.$d.'_Z002'];
		$is_customer_request       = 0;

		// echo "<br> texture_id 	::".$texture_id;
		// echo "<br> material_no 	::".$material_no;
		// echo "<br> mat_type 	::".$mat_type;
		// echo "<br> mat_group 	::".$mat_group;
		// echo "<br> quantity 	::".$quantity;
		// echo "<br> quantity_unit 	::".$quantity_unit;
		// echo "<br> space 		::".$space;
		// echo "<br> price 		::".$price;
		// echo "<br> total_price 		::".$total_price;
		// echo "<br> is_customer_request 		::".$is_customer_request;

		//=== save to database ===
		$result_tool_Z002 = $this->__quotation_model->insert_chemical($quotation_id,$mat_group_des,$texture_id,$material_no,$mat_type,$mat_group,$space
			,$quantity,$quantity_unit,$price,$total_price,$is_customer_request); 

		$result_tool_Z002_msg = $result_tool_Z002['msg'];
			//echo "<br> result_chemical_msg :: ".$result_tool_Z002_msg;

	}//end for TOOL type : Z002


//echo "<br>==================== TOOL type : Z014 ========================";

	//== count TOOL type : Z002 ==
	$temp_count_tool_Z014 = $p['temp_count_tool_Z014'];
	//echo "<br> temp_count_tool_Z014 :: ".$temp_count_tool_Z014;

	for ($e = 1; $e <= $temp_count_tool_Z014; $e++){

		if (!array_key_exists('texture_id_'.$e.'_Z014', $p)) {
			$p['texture_id_'.$e.'_Z014'] = '0';
		}
		if (!array_key_exists('material_no_'.$e.'_Z014', $p)) {
			$p['material_no_'.$e.'_Z014'] = '0';
		}
		if (!array_key_exists('mat_type_'.$e.'_Z014', $p)) {
			$p['mat_type_'.$e.'_Z014'] = '0';
		}
		if (!array_key_exists('mat_group_'.$e.'_Z014', $p)) {
			$p['mat_group_'.$e.'_Z014'] = '0';
		}

		if (!array_key_exists('quantity_'.$e.'_Z014', $p)) {
			$p['quantity_'.$e.'_Z014'] = '0';
		}
		if (!array_key_exists('unit_code_'.$e.'_Z014', $p)) {
			$p['unit_code_'.$e.'_Z014'] = '0';
		}
		if (!array_key_exists('space_'.$e.'_Z014', $p)) {
			$p['space_'.$e.'_Z014'] = '0';
		}
		if (!array_key_exists('price_'.$e.'_Z014', $p)) {
			$p['price_'.$e.'_Z014'] = '0';
		}

		if (!array_key_exists('total_price_'.$e.'_Z014', $p)) {
			$p['total_price_'.$e.'_Z014'] = '0';
		}

	//echo "<br>======== temp_count_tool_Z014 :: ".$e." =========";

		$mat_group_des  = '';
		$texture_id  = $p['texture_id_'.$e.'_Z014'];
		$material_no = $p['material_no_'.$e.'_Z014'];
		$mat_type    = $p['mat_type_'.$e.'_Z014'];
		$mat_group   = $p['mat_group_'.$e.'_Z014'];
		$quantity    = $p['quantity_'.$e.'_Z014'];
		$quantity_unit   = $p['unit_code_'.$e.'_Z014'];
		$space       = $p['space_'.$e.'_Z014'];
		$price       = $p['price_'.$e.'_Z014'];
		$total_price       = $p['total_price_'.$e.'_Z014'];
		$is_customer_request       = 0;

		// if($mat_type=='Z014'){
  //             $quantity = -1;
  //             $quantity_unit = -1;
  //             $price = -1;
  //             $space = -1;

  //       }//end if


		// echo "<br> texture_id 	::".$texture_id;
		// echo "<br> material_no 	::".$material_no;
		// echo "<br> mat_type 	::".$mat_type;
		// echo "<br> mat_group 	::".$mat_group;
		// echo "<br> quantity 	::".$quantity;
		// echo "<br> quantity_unit 	::".$quantity_unit;
		// echo "<br> space 		::".$space;
		// echo "<br> price 		::".$price;
		// echo "<br> total_price 		::".$total_price;
		// echo "<br> is_customer_request 		::".$is_customer_request;

		//exit();

		//=== save to database ===
		$result_tool_Z014 = $this->__quotation_model->insert_chemical($quotation_id,$mat_group_des,$texture_id,$material_no,$mat_type,$mat_group,$space
			,$quantity,$quantity_unit,$price,$total_price,$is_customer_request); 

		$result_tool_Z014_msg = $result_tool_Z014['msg'];
			//echo "<br> result_chemical_msg :: ".$result_tool_Z014_msg;

	}//end for TOOL type : Z014



//echo "<br>==================== CUSTOMER REQUEST ========================";

	//== count request
	$count_request = $p['count_request'];
	//echo "<br> count_request :: ".$count_request;

	for ($req = 1; $req <= $count_request; $req++){

		// if (!array_key_exists('mexture_id_'.$c, $p)) {
  //           $p['texture_id_'.$c] = '0';
  //    	}
		if (!array_key_exists('material_no_'.$req, $p)) {
			$p['material_no_'.$req] = '0';
		}
		if (!array_key_exists('mat_type_'.$req, $p)) {
			$p['mat_type_'.$req] = '0';
		}
		if (!array_key_exists('mat_group_'.$req, $p)) {
			$p['mat_group_'.$req] = '0';
		}
		if (!array_key_exists('quantity_'.$req, $p)) {
			$p['quantity_'.$req] = '0';
		}
		if (!array_key_exists('unit_code_'.$req, $p)) {
			$p['unit_code_'.$req] = '0';
		}
     	// if (!array_key_exists('space_'.$c, $p)) {
      //   	 $p['space_'.$c] = '0';
     	// }
		if (!array_key_exists('price_'.$req, $p)) {
			$p['price_'.$req] = '0';
		}

		if (!array_key_exists('total_price_'.$req, $p)) {
			$p['total_price_'.$req] = '0';
		}



	//echo "<br>======== count_request :: ".$req." =========";

		
		$texture_id  = '';
		$space       = '';

		$material_no = $p['material_no_'.$req];
		$mat_type    = $p['mat_type_'.$req];
		$mat_group   = $p['mat_group_'.$req];
		$quantity    = $p['quantity_'.$req];
		$quantity_unit   = $p['unit_code_'.$req];		
		$price       = $p['price_'.$req];
		$total_price       = $p['total_price_'.$req];
		
		if($p['job_type_chemical']!='ZQT3' && $p['acc_gr']!='Z16' ){
			$is_customer_request       = 1;
		}else{
			$is_customer_request       = 0;
		}
		
		if($mat_type =='Z005' ){
			if (!array_key_exists('mat_group_des_'.$req, $p)) {
				$p['mat_group_des_'.$req] = '0';
     		}//endif

     		$mat_group_des  = $p['mat_group_des_'.$req];

			//echo "<br>test mat_group_des";

     	}else{
     		$mat_group_des  = '';
		}// end else

		// echo "<br> texture_id 	::".$texture_id;
		// echo "<br> space 		::".$space;

		// echo "<br> material_no 	::".$material_no;
		// echo "<br> mat_type 	::".$mat_type;
		// echo "<br> mat_group 	::".$mat_group;
		// echo "<br> quantity 	::".$quantity;
		// echo "<br> quantity_unit 	::".$quantity_unit;		
		// echo "<br> price 		::".$price;
		// echo "<br> total_price 		::".$total_price;
		// echo "<br> is_customer_request 		::".$is_customer_request;
		// echo "<br> mat_group_des 		::".$mat_group_des;

		//=== save to database ===
		$result_request = $this->__quotation_model->insert_chemical($quotation_id,$mat_group_des,$texture_id,$material_no,$mat_type,$mat_group,$space
			,$quantity,$quantity_unit,$price,$total_price,$is_customer_request); 

		$result_request_msg = $result_request['msg'];
			//echo "<br> result_chemical_msg :: ".$result_request_msg;

	}//end for request




}//end if $p



 //exit();
echo '<script type="text/javascript">  alert("เพิ่มข้อมูลเรียบร้อยแล้ว"); setTimeout(function(){window.location="'.site_url('__ps_quotation/detail_quotation/edit_quotation/'.$quotation_id.'/0/3').'"},1200);</script>';
echo '<script> window.location="'.site_url('__ps_quotation/detail_quotation/edit_quotation/'.$quotation_id.'/0/3').'"; </script>';

}







function update_qt_other_service($quotation_id){
	echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";

 	//TODO :  updata summary
	$result_summary = $this->__quotation_model->update_summary($quotation_id);	
	//echo $result_summary['msg'];

	//echo "update_qt_other_service";
	$p = $this->input->post();
	if(!empty($p)){
		//====add other contract person ======
		// echo 'count_other_service : '.$p['count_other_service'].'<br>';
		// echo 'first_conut_other_service : '.$p['first_conut_other_service'].'<br>';
		$first_conut_other_service = $p['first_conut_other_service'];
		$count_other_service = $p['count_other_service'];
		
		if(!empty($count_other_service) || $count_other_service!=0 ){
			for ($i = $first_conut_other_service+1; $i <= $count_other_service; $i++) {

			  // echo $i."<br/>";					  			 
			  // echo $p['service_'.$i.'_serviceID']."<br/>";
			  // echo $p['service_'.$i.'_unit']."<br/>";
			  // echo $p['service_'.$i.'_quantity']."<br/>";

				if (!array_key_exists('service_'.$i.'_serviceID', $p)) {
					$p['service_'.$i.'_serviceID'] = '0';
				}

				if (!array_key_exists('service_'.$i.'_quantity', $p)) {
					$p['service_'.$i.'_quantity'] = '0';
				}

				if (!array_key_exists('service_'.$i.'_unit', $p)) {
					$p['service_'.$i.'_unit'] = '0';
				}

				if (!array_key_exists('service_'.$i.'_total', $p)) {
					$p['service_'.$i.'_total'] = '0';
				}

				if (!array_key_exists('service_'.$i.'_price', $p)) {
					$p['service_'.$i.'_price'] = '0';
				}




				$service_ID = $p['service_'.$i.'_serviceID'];
				$service_quantity = $p['service_'.$i.'_quantity'];    
				$service_unit = $p['service_'.$i.'_unit'];
				$service_price = $p['service_'.$i.'_price'];
				$service_total = $p['service_'.$i.'_total'];

              // echo '<br>========== : '.$i.'=============';	
              // echo '<br>service_ID : '.$service_ID;
              // echo '<br>service_quantity : '.$service_quantity;
              // echo '<br>service_unit : '.$service_unit;
              // echo '<br>service_price : '.$service_price;
              // echo '<br>service_total : '.$service_total;


				$this->load->model('__quotation_model');
				$result_other = $this->__quotation_model->insert_other_service($service_ID,$service_unit,$service_quantity,$service_price,$service_total,$quotation_id); 
			  //echo  '<br> msg :'.$result_other['msg'];

			}//end for
		}//end if

	}//end if p

//exit();
	
	echo '<script type="text/javascript">  alert("เพิ่มข้อมูลเรียบร้อยแล้ว"); setTimeout(function(){window.location="'.site_url('__ps_quotation/detail_quotation/edit_quotation/'.$quotation_id.'/0/6').'"},1200);</script>';
	echo '<script> window.location="'.site_url('__ps_quotation/detail_quotation/edit_quotation/'.$quotation_id.'/0/6').'"; </script>';


}


function update_quotation_area($quotation_id,$ship_to_id){
	//echo "update_quotation_area <br>";
	//echo 'ship_to_id: '.$ship_to_id.'<br>';
	echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";

	$this->load->model('__quotation_model');
	//TODO : DLETE buding floor and area of qt
	$result_delete = $this->__quotation_model->delete_area($quotation_id);	
		//echo $result_delete['msg'];
	//End: ========================================

	//TODO :  updata summary
	$result_summary = $this->__quotation_model->update_summary($quotation_id);	
		//echo $result_summary['msg'];

	$p = $this->input->post();

	if(!empty($p)){	

		$job_type = $p['job_type'];

		//==== Add BUILDING ==================================================
		// echo 'count_add_building : '.$p['count_add_building'].'<br>';
		// echo 'first_conut_building : '.$p['first_conut_building'].'<br>';
		
		$first_conut_building = $p['first_conut_building'];
		$count_add_building = $p['count_add_building'];
		$building_name ='';
		if(!empty($count_add_building) || $count_add_building!=0 ){				

			for ($i = 1; $i <= $count_add_building; $i++){	//$first_conut_building+1
			//echo "=============== BUNDIGNG :". $i." ====================<br>";	

				if (!array_key_exists('total_floor_bu_'.$i, $p)) {
					$p['total_floor_bu_'.$i] = '0';
				}

				if (!array_key_exists('building_'.$i, $p)) {
					$p['building_'.$i] = '';
				}

				if (!array_key_exists('total_of_building_'.$i, $p)) {
					$p['total_of_building_'.$i] = '0';
				}

				
				$total_floor_building = $p['total_floor_bu_'.$i];
				//echo 'total_floor_building : '.$p['total_floor_bu_'.$i].'<br>';

				$building_name =  $p['building_'.$i];
				//echo  'building name :'.$building_name.'<br>';

				$total_of_building =  $p['total_of_building_'.$i];
				//echo  'total_of_building :'.$total_of_building.'<br>';
				

				$result_add_building = $this->__quotation_model->insert_building($quotation_id,$ship_to_id,$building_name,$total_of_building);				 
				$last_building_id = $result_add_building['last_id'];
				//echo "=============== last_building_id ====================<br>";
				//echo  'last_id of building : '.$last_building_id.'<br>';
				//echo  'building msg : '. $result_add_building['msg'].'<br>';

				for ($j = 1; $j <= $total_floor_building; $j++){

				 	//echo "=============== BUNDIGNG :". $i." || FLOOR ::".$j." ====================<br>";

					if (!array_key_exists('total_area_bu_'.$i.'_fl_'.$j, $p)) {
						$p['total_area_bu_'.$i.'_fl_'.$j] = '0';
					}

					if (!array_key_exists('building_'.$i.'_floor_'.$j, $p)) {
						$p['building_'.$i.'_floor_'.$j] = '0';
					}

					$total_area_of_floor = $p['total_area_bu_'.$i.'_fl_'.$j];	
					$total_area_of_floor = $total_area_of_floor -1;
					//echo '===============  total_area_bu_'.$i.'_fl_'.$j.'=======================<br>';//total_area_bu_1_fl_1
					// echo 'total_area_of_floor : '.$total_area_of_floor.'<br>';


					$building_id = $last_building_id;				 	
				 	$floor_name = $p['building_'.$i.'_floor_'.$j];//building_1_floor_1			 	
				 	//echo 'floor_name of building '.$i.'||'.$floor_name.'<br>';


				 	if (array_key_exists('total_of_floor_'.$j.'_'.$i, $p)) {

			 			$total_of_floor = $p['total_of_floor_'.$j.'_'.$i];//building_1_floor_1			 	
				 	//echo 'total_of_floor_'.$j.'_'.$i.'||'.$floor_name.'<br>';



			 			$result_add_floor = $this->__quotation_model->insert_floor($quotation_id,$ship_to_id,$building_id,$floor_name,$total_of_floor);				 	
			 			$last_floor_id = $result_add_floor['last_id'];
				 	// echo "=============== last_floor_id ====================<br>";
				 	//echo  'last_id of floor : '.$last_floor_id.'<br>';
				 	//echo  'floor msg :: '.$result_add_floor['msg'].'<br>';

			 			for ($k = 1; $k <= $total_area_of_floor; $k++){	

			 				if (!array_key_exists('area_'.$k.'_cloneFloor'.$j.'_clonedInputBuilding'.$i.'_title', $p)) {
			 					$p['area_'.$k.'_cloneFloor'.$j.'_clonedInputBuilding'.$i.'_title'] = '0';
			 				}

			 				if (!array_key_exists('area_'.$k.'_cloneFloor'.$j.'_clonedInputBuilding'.$i.'_roomID', $p)) {
			 					$p['area_'.$k.'_cloneFloor'.$j.'_clonedInputBuilding'.$i.'_roomID'] = '0';
			 				}

			 				if (!array_key_exists('area_'.$k.'_cloneFloor'.$j.'_clonedInputBuilding'.$i.'_roomName', $p)) {
			 					$p['area_'.$k.'_cloneFloor'.$j.'_clonedInputBuilding'.$i.'_roomName'] = '0';
			 				}

			 				if (!array_key_exists('area_'.$k.'_cloneFloor'.$j.'_clonedInputBuilding'.$i.'_textureID', $p)) {
			 					$p['area_'.$k.'_cloneFloor'.$j.'_clonedInputBuilding'.$i.'_textureID'] = '0';
			 				}

			 				if (!array_key_exists('area_'.$k.'_cloneFloor'.$j.'_clonedInputBuilding'.$i.'_textureName', $p)) {
			 					$p['area_'.$k.'_cloneFloor'.$j.'_clonedInputBuilding'.$i.'_textureName'] = '0';
			 				}

			 				if (!array_key_exists('area_'.$k.'_cloneFloor'.$j.'_clonedInputBuilding'.$i.'_space', $p)) {
			 					$p['area_'.$k.'_cloneFloor'.$j.'_clonedInputBuilding'.$i.'_space'] = '0';
			 				}

			 				if (!array_key_exists('area_'.$k.'_cloneFloor'.$j.'_clonedInputBuilding'.$i.'_clearJobID', $p)) {
			 					$p['area_'.$k.'_cloneFloor'.$j.'_clonedInputBuilding'.$i.'_clearJobID'] = '0';
			 				}

			 				if (!array_key_exists('area_'.$k.'_cloneFloor'.$j.'_clonedInputBuilding'.$i.'_frequency', $p)) {
			 					$p['area_'.$k.'_cloneFloor'.$j.'_clonedInputBuilding'.$i.'_frequency'] = '0';
			 				}


			 				$floor_id = $last_floor_id;	

				 		$area_title = $p['area_'.$k.'_cloneFloor'.$j.'_clonedInputBuilding'.$i.'_title'];//area_2_cloneFloor1_clonedInputBuilding1_title
				 		
				 		$industry_room_id = $p['area_'.$k.'_cloneFloor'.$j.'_clonedInputBuilding'.$i.'_roomID'];//area_2_cloneFloor1_clonedInputBuilding1_roomID
				 		
				 		$industry_room_description = $p['area_'.$k.'_cloneFloor'.$j.'_clonedInputBuilding'.$i.'_roomName'];//area_2_cloneFloor1_clonedInputBuilding1_roomName

				 		$texture_id = $p['area_'.$k.'_cloneFloor'.$j.'_clonedInputBuilding'.$i.'_textureID'];//area_2_cloneFloor1_clonedInputBuilding1_textureID
				 		
				 		$texture_description = $p['area_'.$k.'_cloneFloor'.$j.'_clonedInputBuilding'.$i.'_textureName'];//area_2_cloneFloor1_clonedInputBuilding1_textureName
				 		
				 		$area_space = $p['area_'.$k.'_cloneFloor'.$j.'_clonedInputBuilding'.$i.'_space'];//area_2_cloneFloor1_clonedInputBuilding1_space
				 		
				 		$clear_job_type_id = $p['area_'.$k.'_cloneFloor'.$j.'_clonedInputBuilding'.$i.'_clearJobID'];//area_2_cloneFloor1_clonedInputBuilding1_clearJobID

				 		if($job_type=='ZQT1'){
				 			$area_frequency = $p['area_'.$k.'_cloneFloor'.$j.'_clonedInputBuilding'.$i.'_frequency'];//area_2_cloneFloor1_clonedInputBuilding1_frequency
				 		}else{
				 			$area_frequency =0;
				 		}		 		
				 		

				 		// echo "============ Area :: ".$k."floor".$j." building ".$i." =================<br>";
				 		// echo 'building_id ||'.$building_id.'<br>';
				 		// echo 'floor_id ||'.$floor_id.'<br>';
				 		// echo 'area_title ||'.$area_title.'<br>';
				 		// echo 'industry_room_id  ||'.$industry_room_id.'<br>';
				 		// echo 'industry_room_description  ||'.$industry_room_description.'<br>';
				 		// echo 'texture_id ||'.$texture_id.'<br>';
				 		// echo 'texture_description  ||'.$texture_description.'<br>';
				 		// echo 'area_space ||'.$area_space.'<br>';
				 		// echo 'clear_job_type_id  ||'.$clear_job_type_id.'<br>';	
				 		// echo 'area_frequency  ||'.$area_frequency.'<br>';	

				 		$result_add_area = $this->__quotation_model->insert_area($quotation_id,$ship_to_id,$building_id,$floor_id,
				 			$area_title,$industry_room_id,$industry_room_description,
				 			$texture_id,$texture_description,$area_space,
				 			$clear_job_type_id,$area_frequency);	
						//echo 'area msg :'.$result_add_area['msg'].'<br>';

				 	}//end for	

         		}//end checkout exists ttal_of_floor

			 }//end for

			}//end for
			$building_name ='';

		}//end if count_add_building



	/////////////////// START : RECALCULATE  CHECK AREA FROME DB CHEMCAL /////////////////////	
		$get_area = $this->__quotation_model->get_area_Byid($quotation_id);
		$get_db_chemical = $this->__quotation_model->get_tbt_equipment($quotation_id,0);
		$bapi_bomb = $this->__quotation_model->get_bomb();


		//################### start : GET TEXTURE ##################################
		$texture = array();
		$temp_texture = $get_area->row_array();
		if(!empty($temp_texture)){   

			foreach($get_area->result_array() as $value){          
				if (in_array( $value['texture_id'], $texture, TRUE)){                
		                //echo "have";
				}else{
		                //echo "nohave";
					array_push($texture,$value['texture_id']);
		                //$building_name[$value['building_id']] = $value['building_title'];
				}   

		       }//end foreach


		}//end temparea


		$total_space = 0;//set total_space_texture
		$space_of_texture = array();
		foreach($texture as $a => $a_value) {
		//echo "<br>====== GET SPACT OF TEXTURE ========================================";
		//echo "<br>====== index : = " . $a . ", textureid_value = ".$a_value." =========<br>";           
			foreach($get_area->result_array() as $value){ 
				if($a_value == $value['texture_id']){
		                    //echo "texture space ".$value['area_id']." ::".$value['space']."<br>";
					$total_space =  $total_space + $value['space'];
				}
		            }//end foreach

		            //set double 2
		            $total_space =   number_format($total_space, 2, '.', '');
		            //echo "TOTAL SPACE ::".$total_space."<br>";

		            //== set push arra space of texture ===
		            $space_of_texture[$a_value] = $total_space; 
		            //reset total_sapace
		            $total_space=0;
		}//end foreach texture

		// echo "space_of_texture_area ||";
		// print_r($space_of_texture);
		// echo "<br>";
		//print_r($texture);
		//################### end : GET TEXTURE ##################################

		$total_area_texture  =0;
		$temp_chemical_equipment = $get_db_chemical->result_array();
		if(!empty($temp_chemical_equipment)){


			foreach($get_db_chemical->result_array() as $value){  
						//echo '<br>=============='.$value['id'].'===================';

				foreach($space_of_texture as $b => $b_space) {
					if($b == $value['texture_id']){
						$total_area_texture = $b_space;
								//echo '<br> total area texture : '.$total_area_texture;
							}//end if
						}//end foreach texture
						
						// echo '<br>texture_id : '.$value['texture_id'];
						// echo '<br>material_no : '.$value['material_no'];
						// echo '<br>space : '.$value['space'];
						// echo '<br>quantity : '.$value['quantity'];
						// echo '<br>price : '.$value['price'];
						// echo '<br>total_price : '.$value['total_price'];

						foreach($bapi_bomb->result_array() as $value_bome){  
							if($value['texture_id'] ==  $value_bome['texture_id'] && $value['material_no'] ==  $value_bome['material_no'] ){
								 //echo '<br>** volumn : '.$value_bome['volumn'];
								 //echo '<br>** quantity_bome : '.$value_bome['quantity'];

								$total_quantity = self::calculate_quantity_temp($total_area_texture,$value_bome['volumn'],$value_bome['quantity']);
								 //echo "<br>////////// calculate ///////////////////////";
								// echo "<br> total_quantity :: ".$total_quantity; 

								$total_price = self::calculate_price_temp($total_quantity,$value['price']);
					             //echo "<br> total_price :: ".$total_price; 

								$result_update_chemical = $this->__quotation_model->update_tbt_equipment($value['id'],$total_area_texture,$total_quantity,$total_price);
					            //echo '<br> msg :'.$result_update_chemical['msg'];

							}//end if
						}//end foreach bombe
					}//end foreach chemical
			}//end if


	//exit();


	}//end if post

	//echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
	echo '<script type="text/javascript">  alert("แก้ไขเรียบร้อยแล้ว"); setTimeout(function(){window.location="'.site_url('__ps_quotation/detail_quotation/edit_quotation/'.$quotation_id.'/0/2').'"},1200);</script>';
	echo '<script> window.location="'.site_url('__ps_quotation/detail_quotation/edit_quotation/'.$quotation_id.'/0/2').'"; </script>';



}

//////////////////////// calculate_quantity and calculate_price ////////////////////////////////////////

function calculate_quantity_temp($space,$volumn,$quantity){
//echo '<br>'.$space.' '.$volumn.' '.$quantity.'<br>';
	$total_quantity = ($space/$volumn)*$quantity;
	$total_quantity = number_format($total_quantity, 2, '.', '');
	$total_quantity = ceil( $total_quantity);

    //check $total_quantity < 1
	if($total_quantity<1){
		$total_quantity = 1;
    }//end if

    return $total_quantity;
}//end function



function calculate_price_temp($quantity,$price){
    //echo '<br>'.$quantity.' '.$price.'<br>';
	$total_price = $quantity*$price;
        //$total_price = number_format($total_quantity, 2, '.', '');
	return $total_price;

}//end function



/////////////////////////////////////////////////////////////////////////////////////



function update_quotation_staff($quotation_id){
//echo "update_quotation_staff";

	$p = $this->input->post();
// echo "<pre>";
// print_r($p);
// echo "</pre>";

// die();

	echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
	$this->load->model('__quotation_model');
//TODO : DLETE buding floor and area of qt
	$result_delete = $this->__quotation_model->delete_man_staff($quotation_id);	
	//echo $result_delete['msg'];
//End: ========================================


//TODO :  updata summary
	$result_summary = $this->__ps_project_query->deleteObj('tbt_summary', array('quotation_id' => $quotation_id));	
	//echo $result_summary['msg'];



///== updata filde total_staff_quotation db tbt_quotation 
	$result_update_staff = $this->__quotation_model->update_staff_quotation($p['qt_staff'],$quotation_id);	

	if(!empty($p)){	
	//==== Add MAN GROUP ==================================================
	// echo '**count_add_group : '.$p['count_add_group'].'<br>';
	// echo 'first_conut_group : '.$p['first_conut_group'].'<br>';
	// echo 'qt staff : '.$p['qt_staff'].'<br>';

		$first_conut_group = $p['first_conut_group'];
		$count_add_group = $p['count_add_group'];
		$qt_staff = $p['qt_staff'];

		if(!empty($count_add_group) || $count_add_group!=0 ){

			$summary_variant = 0;

			for ($i = 1; $i <= $count_add_group; $i++){

				if(!array_key_exists('group_title_gr'.$i, $p)){
					$p['group_title_gr'.$i] = '0';
				}
				if(!array_key_exists('total_man_gr'.$i, $p)){
					$p['total_man_gr'.$i] = '0';
				}
				if(!array_key_exists('overtime_gr'.$i, $p)){
					$p['overtime_gr'.$i] = '0';
				}
				if(!array_key_exists('incentive_gr'.$i, $p)){
					$p['incentive_gr'.$i] = '0';
				}
				if(!array_key_exists('transport_exp_gr'.$i, $p)){
					$p['transport_exp_gr'.$i] = '0';
				}
				if(!array_key_exists('daily_pay_rate_gr'.$i, $p)){
					$p['daily_pay_rate_gr'.$i] = '0';
				}
				if(!array_key_exists('holiday_gr'.$i, $p)){
					$p['holiday_gr'.$i] = '0';
				}
				if(!array_key_exists('bonus_gr'.$i, $p)){
					$p['bonus_gr'.$i] = '0';
				}
				if(!array_key_exists('other_title_gr'.$i, $p)){
					$p['other_title_gr'.$i] = '0';
				}
				if(!array_key_exists('other_value_gr'.$i, $p)){
					$p['other_value_gr'.$i] = '0';
				}
				if(!array_key_exists('count_other_group_'.$i, $p)){
					$p['count_other_group_'.$i] = '0';
				}


				if(!array_key_exists('level_staff_gr'.$i, $p)){
					$p['level_staff_gr'.$i] = '0';
				}
				if(!array_key_exists('position_gr'.$i, $p)){
					$p['position_gr'.$i] = '0';
				}
				if(!array_key_exists('uniform_gr'.$i, $p)){
					$p['uniform_gr'.$i] = '0';
				}


				if(!array_key_exists('waege_gr'.$i, $p)){
					$p['waege_gr'.$i] = '0';
				}
				if(!array_key_exists('benefit_gr'.$i, $p)){
					$p['benefit_gr'.$i] = '0';
				}
				if(!array_key_exists('wage_benefit_gr'.$i, $p)){
					$p['wage_benefit_gr'.$i] = '0';
				}
				if(!array_key_exists('sub_total_gr'.$i, $p)){
					$p['sub_total_gr'.$i] = '0';
				}



				if(!array_key_exists('daily_pay_rate_type_gr'.$i, $p)){
					$p['daily_pay_rate_type_gr'.$i] = '0';
				}
				if(!array_key_exists('daily_pay_rate_id_gr'.$i, $p)){
					$p['daily_pay_rate_id_gr'.$i] = '0';
				}
				if(!array_key_exists('is_auto_ot_gr'.$i, $p)){
					$p['is_auto_ot_gr'.$i] = '0';
				}
				if(!array_key_exists('overtime_id_gr'.$i, $p)){
					$p['overtime_id_gr'.$i] = '0';
				}

				if(!array_key_exists('charge_ot_gr'.$i, $p)){
					$p['charge_ot_gr'.$i] = '0';
				}

				if(!array_key_exists('holiday_id_gr'.$i, $p)){
					$p['holiday_id_gr'.$i] = '0';
				}
				if(!array_key_exists('is_auto_transport_gr'.$i, $p)){
					$p['is_auto_transport_gr'.$i] = '0';
				}
				if(!array_key_exists('transport_exp_id_gr'.$i, $p)){
					$p['transport_exp_id_gr'.$i] = '0';
				}
				if(!array_key_exists('incentive_id_gr'.$i, $p)){
					$p['incentive_id_gr'.$i] = '0';
				}
				if(!array_key_exists('bonus_id_gr'.$i, $p)){
					$p['bonus_id_gr'.$i] = '0';
				}
     		//**     		
     		// if(!array_key_exists('is_auto_position_gr'.$i, $p)){
       //  	 $p['is_auto_position_gr'.$i] = '0';
     		// }

				if(!array_key_exists('is_auto_special_gr'.$i, $p)){
					$p['is_auto_special_gr'.$i] = '0';
				}

				if(!array_key_exists('rate_position_id_gr'.$i, $p)){
					$p['rate_position_id_gr'.$i] = '0';
				}
				if(!array_key_exists('special_id_gr'.$i, $p)){
					$p['special_id_gr'.$i] = '0';
				}
				if(!array_key_exists('other_id_gr'.$i, $p)){
					$p['other_id_gr'.$i] = '0';
				}   
				if(!array_key_exists('rate_position_gr'.$i, $p)){
					$p['rate_position_gr'.$i] = '0';
				}   
				if(!array_key_exists('special_gr'.$i, $p)){
					$p['special_gr'.$i] = '0';
				}   

				if(!array_key_exists('pay_sunday_gr'.$i, $p)){
					$p['pay_sunday_gr'.$i] = '0';
				}    		

				$daily_pay_rate_type =  $p['daily_pay_rate_type_gr'.$i];
				$daily_pay_rate_id =  $p['daily_pay_rate_id_gr'.$i];
				$is_auto_ot =  $p['is_auto_ot_gr'.$i];
				$overtime_id =  $p['overtime_id_gr'.$i];
				$charge_ot =  $p['charge_ot_gr'.$i];     		
				$holiday_id=  $p['holiday_id_gr'.$i];
				$is_auto_transport =  $p['is_auto_transport_gr'.$i];
				$transport_exp_id =  $p['transport_exp_id_gr'.$i];
				$incentive_id =  $p['incentive_id_gr'.$i];
				$bonus_id =  $p['bonus_id_gr'.$i];
     		//**
     		//$is_auto_position =  $p['is_auto_position_gr'.$i];
				$is_auto_spacial =  $p['is_auto_special_gr'.$i];

				$rate_position_id =  $p['rate_position_id_gr'.$i];
				$special_id =  $p['special_id_gr'.$i];
				$other_id =  $p['other_id_gr'.$i];
				$rate_position =  $p['rate_position_gr'.$i];
				$special =  $p['special_gr'.$i];
				$pay_sunday =  $p['pay_sunday_gr'.$i];

			//$sub_total = $p['sub_total_group_gr'.$i];
				$sub_total = $p['sub_total_gr'.$i];
				$wage = $p['waege_gr'.$i];
				$benefit = $p['benefit_gr'.$i];
				$wage_benefit = $p['wage_benefit_gr'.$i];

				$level_staff = $p['level_staff_gr'.$i];
				$position = $this->_padZero($p['position_gr'.$i],4);
				$uniform_id = $p['uniform_gr'.$i];			

				$group_title = $p['group_title_gr'.$i];
				$total_man = $p['total_man_gr'.$i];
				$overtime = $p['overtime_gr'.$i];
				$incentive = $p['incentive_gr'.$i];
				$transport_exp = $p['transport_exp_gr'.$i];
				$daily_pay_rate = $p['daily_pay_rate_gr'.$i];
				$holiday = $p['holiday_gr'.$i];
				$bonus = $p['bonus_gr'.$i];
				$other_title = $p['other_title_gr'.$i];
				$other_value = $p['other_value_gr'.$i];	

				$count_other_group = $p['count_other_group_'.$i];

				$other_type1_id = ''; $other_type2_id = ''; $other_type3_id = '';
				$other_type4_id = ''; $other_type5_id = ''; $other_type6_id = '';
				$other_type7_id = ''; $other_type8_id = ''; $other_type9_id = '';
				$other_type10_id = '';

				$other_1 = ''; $other_2 = ''; $other_3 = '';
				$other_4 = ''; $other_5 = ''; $other_6 = '';
				$other_7 = ''; $other_8 = ''; $other_9 = '';
				$other_10 = '';

				for ($j = 1; $j <= $count_other_group; $j++){

					if($j==1){
						if(!array_key_exists('other_'.$j.'_group_'.$i, $p)){
							$p['other_'.$j.'_group_'.$i] = '0';
						}
						if(!array_key_exists('other_typeID_'.$j.'_group_'.$i, $p)){
							$p['other_typeID_'.$j.'_group_'.$i] = '0';
						}
						$other_1 = $p['other_'.$j.'_group_'.$i];
						$other_type1_id = $p['other_typeID_'.$j.'_group_'.$i];

					}else if($j==2){
						if(!array_key_exists('other_'.$j.'_group_'.$i, $p)){
							$p['other_'.$j.'_group_'.$i] = '0';
						}
						if(!array_key_exists('other_typeID_'.$j.'_group_'.$i, $p)){
							$p['other_typeID_'.$j.'_group_'.$i] = '0';
						}
						$other_2 = $p['other_'.$j.'_group_'.$i];
						$other_type2_id = $p['other_typeID_'.$j.'_group_'.$i];

					}else if($j==3){
						if(!array_key_exists('other_'.$j.'_group_'.$i, $p)){
							$p['other_'.$j.'_group_'.$i] = '0';
						}
						if(!array_key_exists('other_typeID_'.$j.'_group_'.$i, $p)){
							$p['other_typeID_'.$j.'_group_'.$i] = '0';
						}
						$other_3 = $p['other_'.$j.'_group_'.$i];
						$other_type3_id = $p['other_typeID_'.$j.'_group_'.$i];

					}else if($j==4){
						if(!array_key_exists('other_'.$j.'_group_'.$i, $p)){
							$p['other_'.$j.'_group_'.$i] = '0';
						}
						if(!array_key_exists('other_typeID_'.$j.'_group_'.$i, $p)){
							$p['other_typeID_'.$j.'_group_'.$i] = '0';
						}
						$other_4 = $p['other_'.$j.'_group_'.$i];
						$other_type4_id = $p['other_typeID_'.$j.'_group_'.$i];

					}else if($j==5){
						if(!array_key_exists('other_'.$j.'_group_'.$i, $p)){
							$p['other_'.$j.'_group_'.$i] = '0';
						}
						if(!array_key_exists('other_typeID_'.$j.'_group_'.$i, $p)){
							$p['other_typeID_'.$j.'_group_'.$i] = '0';
						}
						$other_5 = $p['other_'.$j.'_group_'.$i];
						$other_type5_id = $p['other_typeID_'.$j.'_group_'.$i];

					}else if($j==6){
						if(!array_key_exists('other_'.$j.'_group_'.$i, $p)){
							$p['other_'.$j.'_group_'.$i] = '0';
						}
						if(!array_key_exists('other_typeID_'.$j.'_group_'.$i, $p)){
							$p['other_typeID_'.$j.'_group_'.$i] = '0';
						}
						$other_6 = $p['other_'.$j.'_group_'.$i];
						$other_type6_id = $p['other_typeID_'.$j.'_group_'.$i];

					}else if($j==7){
						if(!array_key_exists('other_'.$j.'_group_'.$i, $p)){
							$p['other_'.$j.'_group_'.$i] = '0';
						}
						if(!array_key_exists('other_typeID_'.$j.'_group_'.$i, $p)){
							$p['other_typeID_'.$j.'_group_'.$i] = '0';
						}
						$other_7 = $p['other_'.$j.'_group_'.$i];
						$other_type7_id = $p['other_typeID_'.$j.'_group_'.$i];

					}else if($j==8){
						if(!array_key_exists('other_'.$j.'_group_'.$i, $p)){
							$p['other_'.$j.'_group_'.$i] = '0';
						}
						if(!array_key_exists('other_typeID_'.$j.'_group_'.$i, $p)){
							$p['other_typeID_'.$j.'_group_'.$i] = '0';
						}
						$other_8 = $p['other_'.$j.'_group_'.$i];
						$other_type8_id = $p['other_typeID_'.$j.'_group_'.$i];

					}else if($j==9){
						if(!array_key_exists('other_'.$j.'_group_'.$i, $p)){
							$p['other_'.$j.'_group_'.$i] = '0';
						}
						if(!array_key_exists('other_typeID_'.$j.'_group_'.$i, $p)){
							$p['other_typeID_'.$j.'_group_'.$i] = '0';
						}
						$other_9 = $p['other_'.$j.'_group_'.$i];
						$other_type9_id = $p['other_typeID_'.$j.'_group_'.$i];

					}else if($j==10){
						if(!array_key_exists('other_'.$j.'_group_'.$i, $p)){
							$p['other_'.$j.'_group_'.$i] = '0';
						}
						if(!array_key_exists('other_typeID_'.$j.'_group_'.$i, $p)){
							$p['other_typeID_'.$j.'_group_'.$i] = '0';
						}
						$other_10 = $p['other_'.$j.'_group_'.$i];
						$other_type10_id = $p['other_typeID_'.$j.'_group_'.$i];

					}					 

			}//end for other

			// echo "////////////////////////////////////////<br>";
			// echo "is_auto_spacial:".$is_auto_spacial."<br>";
			// echo "special_id:".$special_id."<br>";
			// echo "special:".$special."<br>";
			// //echo "is_auto_transport::".$is_auto_transport."<br>";
			// exit();

			//=====  ADD MAN GROUP TO DB ==========================
			$result_add_group = $this->__quotation_model->insert_man_group($quotation_id,$qt_staff,$sub_total,$group_title,$total_man
				,$overtime,$incentive,$transport_exp,$daily_pay_rate,$holiday,$bonus
				,$level_staff,$uniform_id,$position,$wage,$benefit,$wage_benefit                                                       
				,$other_type1_id,$other_type2_id,$other_type3_id,$other_type4_id,$other_type5_id,$other_type6_id
				,$other_type7_id,$other_type8_id,$other_type9_id,$other_type10_id
				,$other_1,$other_2,$other_3,$other_4,$other_5,$other_6
				,$other_7,$other_8,$other_9,$other_10,$other_title,$other_value
				,$daily_pay_rate_type,$daily_pay_rate_id,$is_auto_ot,$overtime_id
				,$holiday_id,$is_auto_transport,$transport_exp_id,$incentive_id
				,$bonus_id,$is_auto_spacial,$rate_position_id,$special_id,$other_id
				,$rate_position,$special,$charge_ot,$pay_sunday
				);


			$last_group_id = $result_add_group['last_id'];

			//set sub group
			$count_sub_group = $p['count_sub_group_'.$i];
			for ($k = 1; $k <= $count_sub_group; $k++){	

				if(!array_key_exists('sub_group_staff_subg'.$k.'_gr'.$i, $p)){
					$p['sub_group_staff_subg'.$k.'_gr'.$i] = '0';
				}
				if(!array_key_exists('gender_subg'.$k.'_gr'.$i, $p)){
					$p['gender_subg'.$k.'_gr'.$i] = '0';
				}
				if(!array_key_exists('day_radio_subg'.$k.'_gr'.$i, $p)){
					$p['day_radio_subg'.$k.'_gr'.$i] = array();
				}
				if(!array_key_exists('time_start_subg'.$k.'_gr'.$i, $p)){
					$p['time_start_subg'.$k.'_gr'.$i] = '0';
				}
				if(!array_key_exists('time_end_subg'.$k.'_gr'.$i, $p)){
					$p['time_end_subg'.$k.'_gr'.$i] = '0';
				}
				
				if(!array_key_exists('work_hrs_subg'.$k.'_gr'.$i, $p)){
					$p['work_hrs_subg'.$k.'_gr'.$i] = '0';
				}
				if(!array_key_exists('overtime_hrs_subg'.$k.'_gr'.$i, $p)){
					$p['overtime_hrs_subg'.$k.'_gr'.$i] = '0';
				}
				if(!array_key_exists('work_day_subg'.$k.'_gr'.$i, $p)){
					$p['work_day_subg'.$k.'_gr'.$i] = '0';
				}
				if(!array_key_exists('work_holiday_subg'.$k.'_gr'.$i, $p)){
					$p['work_holiday_subg'.$k.'_gr'.$i] = '0';
				}
		     	// if(!array_key_exists('charge_ot_subg'.$k.'_gr'.$i, $p)){
		      //   	 $p['charge_ot_subg'.$k.'_gr'.$i] = '0';
		     	// }
				if(!array_key_exists('remark_subg'.$k.'_gr'.$i, $p)){
					$p['remark_subg'.$k.'_gr'.$i] = '0';
				}
				if(!array_key_exists('per_person_subg'.$k.'_gr'.$i, $p)){
					$p['per_person_subg'.$k.'_gr'.$i] = '0';
				}
				if(!array_key_exists('per_group_subg'.$k.'_gr'.$i, $p)){
					$p['per_group_subg'.$k.'_gr'.$i] = '0';
				}		     		

				//== set man_group_id ==
				$man_group_id = $last_group_id;

				$sub_group_staff_subg = $p['sub_group_staff_subg'.$k.'_gr'.$i];
				$gender_subg = $p['gender_subg'.$k.'_gr'.$i];
				$day_radio_subg = serialize($p['day_radio_subg'.$k.'_gr'.$i]);
				$time_start_subg = $p['time_start_subg'.$k.'_gr'.$i];
				$time_end_subg = $p['time_end_subg'.$k.'_gr'.$i];
				//$position_subg = $p['position_subg'.$k.'_gr'.$i];
				//$uniform_subg = $p['uniform_subg'.$k.'_gr'.$i];
				$work_hrs_subg = $p['work_hrs_subg'.$k.'_gr'.$i];
				$overtime_hrs_subg = $p['overtime_hrs_subg'.$k.'_gr'.$i];
				$work_day_subg = $p['work_day_subg'.$k.'_gr'.$i];
				$work_holiday_subg = $p['work_holiday_subg'.$k.'_gr'.$i];
				//$charge_ot_subg = $p['charge_ot_subg'.$k.'_gr'.$i];
				$remark_subg = $p['remark_subg'.$k.'_gr'.$i];			
				$per_person_subg = $p['per_person_subg'.$k.'_gr'.$i];
				$per_group_subg = $p['per_group_subg'.$k.'_gr'.$i];

				// echo "sub_group_staff_subg:".$sub_group_staff_subg."<br>";
				// echo "gender_subg:".$gender_subg."<br>";
				// echo "day_radio_subg:".$day_radio_subg."<br>";
				// echo "time_start_subg:".$time_start_subg."<br>";
				// echo "time_end_subg:".$time_end_subg."<br>";
				// echo "work_hrs_subg:".$work_hrs_subg."<br>";
				// echo "overtime_hrs_subg:".$overtime_hrs_subg."<br>";
				// echo "work_day_subg:".$work_day_subg."<br>";
				// echo "work_holiday_subg:".$work_holiday_subg."<br>";
				// echo "remark_subg:".$remark_subg."<br>";			
				// echo "per_person_subg:".$per_person_subg."<br>";
				// echo "per_group_subg:".$per_group_subg."<br>";
				// echo "/////////////////////////////////////<br>";



				$summary_variant += ($charge_ot*$overtime_hrs_subg*$sub_group_staff_subg);


			//=====  ADD SUB MAN GROUP TO DB =============
			// $result_add_subgroup = $this->__quotation_model->insert_man_subgroup($quotation_id,$last_group_id,$sub_group_staff_subg
			// 									,$gender_subg,$day_radio_subg,$time_start_subg,$time_end_subg
			// 									,$work_hrs_subg,$overtime_hrs_subg,$work_day_subg,$work_holiday_subg
			// 									,$charge_ot_subg,$remark_subg,$per_person_subg,$per_group_subg
			// 									);

			//edit case ot 15july 
				$result_add_subgroup = $this->__quotation_model->insert_man_subgroup($quotation_id,$last_group_id,$sub_group_staff_subg
					,$gender_subg,$day_radio_subg,$time_start_subg,$time_end_subg
					,$work_hrs_subg,$overtime_hrs_subg,$work_day_subg,$work_holiday_subg
					,$remark_subg,$per_person_subg,$per_group_subg
					);
				$add_subgroup_msg = $result_add_subgroup['msg'];
			//echo "msg : ".$add_subgroup_msg."<br>";
			//===================================================
			}//end for sub group
			//die();

		}//end for
		
	}//end if



}//end if $p

$quotation = $this->__ps_project_query->getObj('tbt_quotation', array('id' => $quotation_id));

if ($quotation['job_type'] == 'ZQT3') {
	$data = array(
		'quotation_id' => $quotation_id,
		'total_variant_price' => $summary_variant
		);
	$this->__ps_project_query->insertObj('tbt_summary', $data);
}

	//exit();

echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
echo '<script type="text/javascript">  alert("แก้ไขเรียบร้อยแล้ว"); setTimeout(function(){window.location="'.site_url('__ps_quotation/detail_quotation/edit_quotation/'.$quotation_id.'/0/4').'"},1200);</script>';
echo '<script> window.location="'.site_url('__ps_quotation/detail_quotation/edit_quotation/'.$quotation_id.'/0/4').'"; </script>';

}




function update_prospect($prospect_id){

	$this->load->model('__quotation_model');

	$p = $this->input->post();	

	if(!empty($p)){			

		$result_prospect = $this->__quotation_model->update_prospect($p,$prospect_id); 

		$first_conut_other = $p['first_conut_other'];
		$count_ohter = $p['count_other_contract'];
		
		if(!empty($count_ohter) || $count_ohter!=0 ){
			
			for ($i = $first_conut_other+1; $i <= $count_ohter; $i++) {

				  // echo $p['contract_'.$i.'_tel']."<br/>";
				  // echo $p['contract_'.$i.'_tel_ext']."<br/>";
				  // echo $p['contract_'.$i.'_fax']."<br/>";
				  // echo $p['contract_'.$i.'_fax_ext']."<br/>";

				  // echo $p['contract_'.$i.'_mobile']."<br/>";
				  // echo $p['contract_'.$i.'_email']."<br/>";	
				$title = $p['contract_'.$i.'_title'];
				$other_fistname = $p['contract_'.$i.'_fistname'];
				$other_lastname = $p['contract_'.$i.'_lastname'];
				$other_function = $p['contract_'.$i.'_function'];
				$other_department = $p['contract_'.$i.'_department'];

				$other_tel = $p['contract_'.$i.'_tel'];
				$other_tel_ext = $p['contract_'.$i.'_tel_ext'];
				$other_fax = $p['contract_'.$i.'_fax'];
				$other_fax_ext = $p['contract_'.$i.'_fax_ext'];

				$other_mobile = $p['contract_'.$i.'_mobile'];
				$other_email =  $p['contract_'.$i.'_email'];		 

				$result_other = $this->__quotation_model->insert_otherperson($title,$other_fistname,$other_lastname,
					$other_function,$other_department,$other_tel,$other_tel_ext,$other_fax,$other_fax_ext,
					$other_mobile,$other_email,$prospect_id); 

			}

		}//end if

		if ($p['submit_val'] == 1) {
			$this->submit_prospect($prospect_id);
			echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
			echo '<script type="text/javascript">  alert("ส่งไปยัง SAP รียบร้อยแล้ว"); setTimeout(function(){window.location="'.site_url('__ps_quotation/detail_quotation/edit_prospect/'.$prospect_id).'"},1200);</script>';
			echo '<script> window.location="'.site_url('__ps_quotation/detail_quotation/edit_prospect/'.$prospect_id).'"; </script>';

		} else {

			echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
			echo '<script type="text/javascript">  alert("แก้ไขเรียบร้อยแล้ว"); setTimeout(function(){window.location="'.site_url('__ps_quotation/detail_quotation/edit_prospect/'.$prospect_id).'"},1200);</script>';
			echo '<script> window.location="'.site_url('__ps_quotation/listview_prospect').'"; </script>';

		}

	}
}




function update_quotation($quotation_id){

 	//echo 'id : '.$quotation_id.'<br>';
	$this->load->model('__quotation_model');

	$p = $this->input->post();	

	if(!empty($p)){
		//== start : add contracts person ====	
		if (!array_key_exists('required_doc', $p)) {
			$p['required_doc'] = '0';
		}

		if (!array_key_exists('is_cal_vat', $p)) {
			$p['is_cal_vat'] = '0';
		}

		// echo "<pre>";
		// print_r($p);
		// die();

		$result_quotation = $this->__quotation_model->update_quotation($p,$quotation_id); 
		$result_summary = $this->__quotation_model->update_summary($quotation_id);

		//==END : add contracts person ====


		//== start : required doc  =======	
			//== delete required tbt_required_document
		$this->db->where('quotation_id', $quotation_id);
		$this->db->delete('tbt_required_document'); 		

	    	//insert required
		$result_quotation = $this->__quotation_model->insert_required_doc($p,$quotation_id); 

		//==END :required doc =============

		// //==start : add contracts person ====
		// 	echo 'contrack_main_id : '.$p['contrack_main_id'].'<br>';
		// 	if($p['contrack_main_id']==0){

		// 		$result_main_contract = $this->__quotation_model->insert_main_contact('quotation',$p,$quotation_id); 

		// 	}else{
		// 		//echo 'update main contract';
		// 		$this->__quotation_model->update_main_contact('quotation',$p,$quotation_id);
		// 	}
		// //==end : add contracts person ====	

		//====start: add other contract person ======
			// echo 'count_other_contract : '.$p['count_other_contract'].'<br>';
			// echo 'first_conut_other : '.$p['first_conut_other'].'<br>';
		$first_conut_other = $p['first_conut_other'];
		$count_ohter = $p['count_other_contract'];

		if(!empty($count_ohter) || $count_ohter!=0 ){

			for ($i = $first_conut_other+1; $i <= $count_ohter; $i++) {
				  //echo $i;					  			 
				  // echo $p['contract_'.$i.'_fistname']."<br/>";
				  // echo $p['contract_'.$i.'_lastname']."<br/>";
				  // echo $p['contract_'.$i.'_function']."<br/>";
				  // //echo $p['contract_'.$i.'_position']."<br/>";
				  // echo $p['contract_'.$i.'_mobile']."<br/>";
				  // echo $p['contract_'.$i.'_email']."<br/>";	

				  // $other_fistname = $p['contract_'.$i.'_fistname'];
	     //          $other_lastname = $p['contract_'.$i.'_lastname'];
	     //          $other_function = $p['contract_'.$i.'_function'];
	     //          //$other_position = $p['contract_'.$i.'_position'];
	     //          $other_mobile = $p['contract_'.$i.'_mobile'];
	     //          $other_email =  $p['contract_'.$i.'_email'];	

				$title = $p['contract_'.$i.'_title'];
				$other_fistname = $p['contract_'.$i.'_fistname'];
				$other_lastname = $p['contract_'.$i.'_lastname'];
				$other_function = $p['contract_'.$i.'_function'];
				$other_department = $p['contract_'.$i.'_department'];

				$other_tel = $p['contract_'.$i.'_tel'];
				$other_tel_ext = $p['contract_'.$i.'_tel_ext'];
				$other_fax = $p['contract_'.$i.'_fax'];
				$other_fax_ext = $p['contract_'.$i.'_fax_ext'];

				$other_mobile = $p['contract_'.$i.'_mobile'];
				$other_email =  $p['contract_'.$i.'_email'];			 

				$result_other = $this->__quotation_model->insert_otherperson_quotation($title,$other_fistname,$other_lastname,
					$other_function,$other_department,$other_tel,$other_tel_ext,$other_fax,$other_fax_ext,
					$other_mobile,$other_email,$quotation_id); 

			}

			}//end if
		//====end: add other contract person ======
//exit();
			echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
			echo '<script type="text/javascript">  alert("แก้ไขเรียบร้อยแล้ว"); setTimeout(function(){window.location="'.site_url('__ps_quotation/detail_quotation/edit_quotation/'.$quotation_id).'"},1200);</script>';
			echo '<script> window.location="'.site_url('__ps_quotation/detail_quotation/edit_quotation/'.$quotation_id).'"; </script>';

		}//end !empty post
	}


//#################################################
//==================== DLETE ======================
//#################################################

	function delete($doc_type,$id){

		$this->load->model('__quotation_model');
		$emp_id = $this->session->userdata('id');
		$permission = $this->permission[$this->cat_id];

		$obj = array();
		if ($doc_type == 'quotation') {
			$obj = $this->__ps_project_query->getObj('tbt_quotation', array('id' => $id));
		} else {
			$obj = $this->__ps_project_query->getObj('tbt_prospect', array('id' => $id));
		}

		if (!array_key_exists('delete', $permission) || empty($obj) || $obj['project_owner_id'] != $emp_id) {
			redirect('__ps_quotation/listview_quotation');
			return false;
		}

		$result = $this->__quotation_model->delete($doc_type,$id); 	

		if($doc_type=='prospect'){

			$prospect = $obj;

			$customer = array(
				'KUNNR' => $id,
				'VTWEG'	=> $prospect['distribution_channel']
				);
			$input = array(	
				array("TABLE","T_CUSTOMER", array($customer))
				);

			$result = $this->callSAPFunction('ZRFC_BLOCK_CUSTOMER', $input);

			echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
			echo '<script type="text/javascript"> setTimeout(function(){window.location="'.site_url('__ps_quotation/listview_prospect').'"},1200);</script>';
			echo '<script> window.location="'.site_url('__ps_quotation/listview_prospect').'"; </script>';
		}else{

			echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
			echo '<script type="text/javascript">setTimeout(function(){window.location="'.site_url('__ps_quotation/listview_quotation').'"},1200);</script>';
			echo '<script> window.location="'.site_url('__ps_quotation/listview_quotation').'"; </script>';
		}
		

	}




	function delete_file_importance($id,$doc_id,$doc_type){

	//echo 'importance'.$id.''.$doc_id.''.$doc_type;   
		if($doc_type=='prospect'){   	
			$condition = array(   
				'id' => $id,
				'prospect_id' => $doc_id,                                   
				);

		}else{
			$condition = array(   
				'id' => $id,
				'quotation_id' => $doc_id,                                   
				);
		}

		$path = $this->db->get_where('tbt_project_document',$condition);
		$path = $path->result_array();
    //echo $path[0]['path'];


		if($doc_type=='prospect'){ 

			if($this->db->delete('tbt_project_document',$condition)){
				unlink($path[0]['path']);
		       //echo "succses";
				echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
				echo '<script type="text/javascript">  alert("ลบไฟล์เรียบร้อยแล้ว"); setTimeout(function(){window.location="'.site_url('__ps_quotation/detail_quotation/edit_prospect/'.$doc_id).'"},1200);</script>';
				echo '<script> window.location="'.site_url('__ps_quotation/detail_quotation/edit_prospect/'.$doc_id).'"; </script>';

			}else{

		    	//echo "fail";
				echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
				echo '<script type="text/javascript">  alert("ผิดพลาด: ไม่สามารถลบไฟล์ได้"); setTimeout(function(){window.location="'.site_url('__ps_quotation/detail_quotation/edit_prospect/'.$doc_id).'"},1200);</script>';
				echo '<script> window.location="'.site_url('__ps_quotation/detail_quotation/edit_prospect/'.$doc_id).'"; </script>';
			}
	}//end if prospect
	else{

		if($this->db->delete('tbt_project_document',$condition)){
			unlink($path[0]['path']);
	       //echo "succses";
			echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
			echo '<script type="text/javascript">  alert("ลบไฟล์เรียบร้อยแล้ว"); setTimeout(function(){window.location="'.site_url('__ps_quotation/detail_quotation/edit_quotation/'.$doc_id).'"},1200);</script>';
			echo '<script> window.location="'.site_url('__ps_quotation/detail_quotation/edit_quotation/'.$doc_id).'"; </script>';

		}else{

	    	//echo "fail";
			echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
			echo '<script type="text/javascript">  alert("ผิดพลาด: ไม่สามารถลบไฟล์ได้"); setTimeout(function(){window.location="'.site_url('__ps_quotation/detail_quotation/edit_quotation/'.$doc_id).'"},1200);</script>';
			echo '<script> window.location="'.site_url('__ps_quotation/detail_quotation/edit_quotation/'.$doc_id).'"; </script>';
		}
    }//end else

}

function delete_file_other($id,$doc_id,$doc_type){

	//echo 'other'.$id.''.$doc_id.''.$doc_type;
	if($doc_type=='prospect'){   	
		$condition = array(   
			'id' => $id,
			'prospect_id' => $doc_id,                                   
			);

	}else{
		$condition = array(   
			'id' => $id,
			'quotation_id' => $doc_id,                                   
			);
	}

	$path = $this->db->get_where('tbt_project_document',$condition);
	$path = $path->result_array();
    //echo $path[0]['path'];

	if($doc_type=='prospect'){
		if($this->db->delete('tbt_project_document',$condition)){
			unlink($path[0]['path']);
		       //echo "succses";
			echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
			echo '<script type="text/javascript">  alert("ลบไฟล์เรียบร้อยแล้ว"); setTimeout(function(){window.location="'.site_url('__ps_quotation/detail_quotation/edit_prospect/'.$doc_id).'"},1200);</script>';
			echo '<script> window.location="'.site_url('__ps_quotation/detail_quotation/edit_prospect/'.$doc_id).'"; </script>';

		}else{

		    	//echo "fail";
			echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
			echo '<script type="text/javascript">  alert("ผิดพลาด: ไม่สามารถลบไฟล์ได้"); setTimeout(function(){window.location="'.site_url('__ps_quotation/detail_quotation/edit_prospect/'.$doc_id).'"},1200);</script>';
			echo '<script> window.location="'.site_url('__ps_quotation/detail_quotation/edit_prospect/'.$doc_id).'"; </script>';
		}
	}//end if prospect
	else{
		if($this->db->delete('tbt_project_document',$condition)){
			unlink($path[0]['path']);
		       //echo "succses";
			echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
			echo '<script type="text/javascript">  alert("ลบไฟล์เรียบร้อยแล้ว"); setTimeout(function(){window.location="'.site_url('__ps_quotation/detail_quotation/edit_quotation/'.$doc_id).'"},1200);</script>';
			echo '<script> window.location="'.site_url('__ps_quotation/detail_quotation/edit_quotation/'.$doc_id).'"; </script>';

		}else{

		    	//echo "fail";
			echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
			echo '<script type="text/javascript">  alert("ผิดพลาด: ไม่สามารถลบไฟล์ได้"); setTimeout(function(){window.location="'.site_url('__ps_quotation/detail_quotation/edit_quotation/'.$doc_id).'"},1200);</script>';
			echo '<script> window.location="'.site_url('__ps_quotation/detail_quotation/edit_quotation/'.$doc_id).'"; </script>';
		}
	}//end else 

}

function delete_contact($id,$doc_id,$type){
	//echo 'other'.$id.''.$doc_id;

	$this->load->model('__quotation_model');
	$result = $this->__quotation_model->delete_contact_model($id); 	

	if($type=='prospect'){
		echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
		echo '<script type="text/javascript">  alert("'.$result['msg'].'"); setTimeout(function(){window.location="'.site_url('__ps_quotation/detail_quotation/edit_prospect/'.$doc_id).'"},1200);</script>';
		echo '<script> window.location="'.site_url('__ps_quotation/detail_quotation/edit_prospect/'.$doc_id).'"; </script>';

	}else{

		echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
		echo '<script type="text/javascript">  alert("'.$result['msg'].'"); setTimeout(function(){window.location="'.site_url('__ps_quotation/detail_quotation/edit_quotation/'.$doc_id).'"},1200);</script>';
		echo '<script> window.location="'.site_url('__ps_quotation/detail_quotation/edit_quotation/'.$doc_id).'"; </script>';

	}

}



function delete_contact_service($id,$doc_id){
	//echo 'other'.$id.''.$doc_id;

	$this->load->model('__quotation_model');
	$result = $this->__quotation_model->delete_service_model($id); 	


	echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
	echo '<script type="text/javascript">  alert("'.$result['msg'].'"); setTimeout(function(){window.location="'.site_url('__ps_quotation/detail_quotation/edit_quotation/'.$doc_id.'/0/6').'"},1200);</script>';
	echo '<script> window.location="'.site_url('__ps_quotation/detail_quotation/edit_quotation/'.$doc_id.'/0/6').'"; </script>';

}



	//#################################################
	//==================== SYNC  ======================
	//#################################################
function checkComplete () {

	$quotation_list = $this->__ps_project_query->getObj('tbt_quotation', array('project_end' => date('Y-m-d'), 'contract_id !=' => '', 'is_go_live' => 1), true);

	$count = 0;
	foreach ($quotation_list as $quotation) {
		$this->__ps_project_query->updateObj('tbt_quotation', array('id' => $quotation['id']), array('status' => 'COMPLETE'));
		$count++;
	}

	echo json_encode(array('status' => true, 'number of complete' => $count));

}

function sync_bapi_quotation ($function='') {

	ini_get('max_execution_time');
	ini_set('memory_limit', '5000M');
	set_time_limit (0);

	$active_function = array(
		'ZAC_EVENTC'					=> 0,
		'ZTBM_VISIT' 					=> 0,
		'ZTBM_NOTVISIT' 				=> 0,
		'ZTB_CONNECT_TYPE' 				=> 0,
		'ZRFC_GET_COMPETITOR' 			=> 0,
		'ZRFC_GET_CUSTOMER02' 		  	=> 0,
		'ZRFC_GET_SHIP_TO_UD_SOLD_TO'	=> 0,
		'ZRFC_GET_COUNTRY' 				=> 0,
		'ZRFC_GET_REGION' 				=> 0,
		'ZRFC_GET_BUSSINESS_SCALE' 		=> 0,
		'ZRFC_GET_MATERIAL' 			=> 0,
		'ZRFC_GET_BRSCH' 				=> 0,
		'ZRFC_GET_ROOM' 				=> 0,
		'ZRFC_GET_BOM' 					=> 0,
		'ZRFC_GET_MAT_PRICE01' 			=> 0,
		'ZRFC_GET_PARTNER_FUNCTION' 	=> 0,
		'ZRFC_GET_CONTACT_PERSON' 		=> 0,
		'ZRFC_GET_DISTR_C' 				=> 0,
		'ZRFC_GET_ZTERM' 				=> 0,
		'ZRFC_QUOTATION' 				=> 0,
		'ZRFC_GET_MATERIAL_GROUP'		=> 0
		);

	if ( !empty($function) ) {
		$active_function[$function] = 1;
	}

	$sap_department = $this->setup_item['sap_department'];

	if ($active_function['ZAC_EVENTC'] == 1) {
		$input = array( 
			array("IMPORT","I_MODE","R"),
			array("IMPORT","I_TABLE", "ZAC_EVENTC"),
			array("TABLE","IT_ZAC_EVENTC", array())
			);

		$result = $this->callSAPFunction("ZRFC_MASS_TABLE", $input);

		$this->db->truncate('tbm_event_category');
		if (!empty($result)) {
			foreach ($result['IT_ZAC_EVENTC'] as $key => $value) {
				$data = array (
					'id'   				=> $value['CODE'],
					'module'			=> iconv("TIS-620", "UTF-8", $value['NAME'] ),
					'function'   		=> $value['DEP']
					);

				$this->__ps_project_query->insertObj('tbm_event_category', $data);
			}
		}
			//echo "ZAC_EVENTC DONE <br>";
	}

	if ($active_function['ZTBM_VISIT'] == 1) {
		$input = array( 
			array("IMPORT","I_MODE","R"),
			array("IMPORT","I_TABLE", "ZTBM_VISIT"),
			array("TABLE","IT_ZTBM_VISIT", array())
			);

		$result = $this->callSAPFunction("ZRFC_MASS_TABLE", $input);

		$this->db->truncate('tbm_visitation_reason');

		if (!empty($result)) {
			foreach ($result['IT_ZTBM_VISIT'] as $key => $value) {
				$data = array (
					'id'   				=> $value['CODE'],
					'title' 			=> iconv("TIS-620", "UTF-8", $value['DESCRP'] ),
					'function'   		=> $value['DEPT'],
					'is_active'			=> 1
						// 'is_active'			=> $value['IS_ACTIVE']
					);

				$this->__ps_project_query->insertObj('tbm_visitation_reason', $data);
			}
		}
			//echo "ZTBM_VISIT DONE <br>";
	}

	if ($active_function['ZTBM_NOTVISIT'] == 1) {
		$input = array( 
			array("IMPORT","I_MODE","R"),
			array("IMPORT","I_TABLE", "ZTBM_NOTVISIT"),
			array("TABLE","IT_ZTBM_NOTVISIT", array())
			);

		$result = $this->callSAPFunction("ZRFC_MASS_TABLE", $input);
		$this->db->truncate('tbm_not_visit_reason');
		if (!empty($result)) {
			foreach ($result['IT_ZTBM_NOTVISIT'] as $key => $value) {
				$data = array (
					'id'   				=> $value['CODE'],
					'title' 			=> iconv("TIS-620", "UTF-8", $value['DESCRP'] ),
					'function'   		=> $value['DEPT'],
					'is_active'			=> 1
						// 'is_active'			=> $value['IS_ACTIVE']
					);

				$this->__ps_project_query->insertObj('tbm_not_visit_reason', $data);
			}
		}
			//echo "ZTBM_NOTVISIT DONE <br>";
	}

	if ($active_function['ZTB_CONNECT_TYPE'] == 1) {
		$input = array( 
			array("IMPORT","I_MODE","R"),
			array("IMPORT","I_TABLE", "ZTB_CONNECT_TYPE"),
			array("TABLE","IT_ZTB_CONNECT_TYPE", array())
			);

		$result = $this->callSAPFunction("ZRFC_MASS_TABLE", $input);
		$this->db->truncate('tbm_connect_type');
		if (!empty($result)) {
			foreach ($result['IT_ZTB_CONNECT_TYPE'] as $key => $value) {
				$data = array (
					'id'   				=> $value['CODE'],
					'title' 			=> iconv("TIS-620", "UTF-8", $value['DESCT'] ),
					'is_active'			=> 1
						// 'is_active'			=> $value['ACTIVE']
					);

				$this->__ps_project_query->insertObj('tbm_connect_type', $data);
			}
		}
			//echo "ZTB_CONNECT_TYPE <br>";
	}

	if ($active_function['ZRFC_GET_COMPETITOR'] == 1) {
		$input = array(	 
			array("TABLE","ET_COMPETITOR",array())
			);

		$result = $this->callSAPFunction("ZRFC_GET_COMPETITOR", $input);
		$this->db->truncate('sap_tbm_competitor');
		if (!empty($result)) {
			foreach ($result['ET_COMPETITOR'] as $key => $value) {
				$data = array (
					'account_group'   => $value['KTOKD'],
					'competitor_name' => iconv("TIS-620", "UTF-8", $value['NAME1'] ),
					'competitor_id'   => $value['KUNNR']
					);

				$this->__ps_project_query->insertObj('sap_tbm_competitor', $data);
			}
		}

			//echo "ZRFC_GET_COMPETITOR DONE <br>";
	}

	if ($active_function['ZRFC_GET_CUSTOMER02'] == 1) {

		$input = array(	 
			array("IMPORT", "I_LANGU", "2"),
			array("TABLE","ET_OUTPUT",array())
			);

		$result = $this->callSAPFunction("ZRFC_GET_CUSTOMER02", $input);
		$this->db->truncate('sap_tbm_sold_to');
		if (!empty($result)) {
			foreach ($result['ET_OUTPUT'] as $key => $value) {
				$data = array(
					'id' 				 		   => $value['KUNNR'],
					'sold_to_name' 			  	   => iconv("TIS-620", "UTF-8", $value['FULL_NAME'] ),
					'sold_to_name1' 			   => iconv("TIS-620", "UTF-8", $value['NAME1'] ),
					'sold_to_name2' 			   => iconv("TIS-620", "UTF-8", $value['NAME2'] ),
					'sold_to_name3' 			   => iconv("TIS-620", "UTF-8", $value['NAME3'] ),
					'sold_to_name4' 			   => iconv("TIS-620", "UTF-8", $value['NAME4'] ),
					'sold_to_account_group' 	   => $value['KTOKD'],
					'sold_to_search_term' 	       => iconv("TIS-620", "UTF-8", $value['SORTL'] ),
					'sold_to_business_scale' 	   => $value['KUKLA'],
					'sold_to_industry' 			   => $value['BRSCH'],
					'sold_to_address_no' 		   => $value['ADRNR'],
					'sold_to_division' 		       => $value['SPART'], 
					'sold_to_sale_org' 		       => $value['VKORG'],
					'sold_to_distribution_channel' => $value['VTWEG'],
					'sold_to_address1' 			   => iconv("TIS-620", "UTF-8", $value['STR_SUPPL1'] ),
					'sold_to_address2' 			   => iconv("TIS-620", "UTF-8", $value['STR_SUPPL2'] ),
					'sold_to_address3' 			   => iconv("TIS-620", "UTF-8", $value['STR_SUPPL3'] ),
					'sold_to_address4' 			   => iconv("TIS-620", "UTF-8", $value['LOCATION'] ),
					'sold_to_postal_code' 		   => $value['POST_CODE1'],
					'sold_to_district' 			   => iconv("TIS-620", "UTF-8", $value['CITY2'] ),
					'sold_to_city' 				   => iconv("TIS-620", "UTF-8", $value['CITY1'] ),
					'sold_to_country' 			   => iconv("TIS-620", "UTF-8", $value['COUNTRY'] ),
					'sold_to_region' 			   => iconv("TIS-620", "UTF-8", $value['REGION'] ),
					'sold_to_tel' 				   => $value['TEL_NUMBER'],
					'sold_to_tel_ext' 		       => $value['TEL_EXTENS'],
					'sold_to_fax'		 		   => $value['FAX_NUMBER'],
					'sold_to_fax_ext' 			   => $value['FAX_EXTENS'],
					'sold_to_mobile' 			   => $value['TELF2'],
					'sold_to_email' 			   => $value['SMTP_ADDR'],
					'sold_to_tax_id'			   => $value['STCD3']

					);

$exist = $this->__ps_project_query->getObj('sap_tbm_sold_to', array('id' => $data['id'], 'sold_to_distribution_channel' => $data['sold_to_distribution_channel']));

if (empty($exist)) {
	$this->__ps_project_query->insertObj('sap_tbm_sold_to', $data);
}
}
}

$input = array(	 
	array("IMPORT", "I_LANGU", "E"),
	array("TABLE","ET_OUTPUT",array())
	);

$result = $this->callSAPFunction("ZRFC_GET_CUSTOMER02", $input);
$this->db->truncate('sap_tbm_sold_to_en');
if (!empty($result)) {
	foreach ($result['ET_OUTPUT'] as $key => $value) {
		$data = array(
			'id' 				 		   => $value['KUNNR'],
			'sold_to_name' 			  	   => iconv("TIS-620", "UTF-8", $value['FULL_NAME'] ),
			'sold_to_name1' 			   => iconv("TIS-620", "UTF-8", $value['NAME1'] ),
			'sold_to_name2' 			   => iconv("TIS-620", "UTF-8", $value['NAME2'] ),
			'sold_to_name3' 			   => iconv("TIS-620", "UTF-8", $value['NAME3'] ),
			'sold_to_name4' 			   => iconv("TIS-620", "UTF-8", $value['NAME4'] ),
			'sold_to_account_group' 	   => $value['KTOKD'],
			'sold_to_search_term' 	       => iconv("TIS-620", "UTF-8", $value['SORTL'] ),
			'sold_to_business_scale' 	   => $value['KUKLA'],
			'sold_to_industry' 			   => $value['BRSCH'],
			'sold_to_address_no' 		   => $value['ADRNR'],
			'sold_to_division' 		       => $value['SPART'], 
			'sold_to_sale_org' 		       => $value['VKORG'],
			'sold_to_distribution_channel' => $value['VTWEG'],
			'sold_to_address1' 			   => iconv("TIS-620", "UTF-8", $value['STR_SUPPL1'] ),
			'sold_to_address2' 			   => iconv("TIS-620", "UTF-8", $value['STR_SUPPL2'] ),
			'sold_to_address3' 			   => iconv("TIS-620", "UTF-8", $value['STR_SUPPL3'] ),
			'sold_to_address4' 			   => iconv("TIS-620", "UTF-8", $value['LOCATION'] ),
			'sold_to_postal_code' 		   => $value['POST_CODE1'],
			'sold_to_district' 			   => iconv("TIS-620", "UTF-8", $value['CITY2'] ),
			'sold_to_city' 				   => iconv("TIS-620", "UTF-8", $value['CITY1'] ),
			'sold_to_country' 			   => iconv("TIS-620", "UTF-8", $value['COUNTRY'] ),
			'sold_to_region' 			   => iconv("TIS-620", "UTF-8", $value['REGION'] ),
			'sold_to_tel' 				   => $value['TEL_NUMBER'],
			'sold_to_tel_ext' 		       => $value['TEL_EXTENS'],
			'sold_to_fax'		 		   => $value['FAX_NUMBER'],
			'sold_to_fax_ext' 			   => $value['FAX_EXTENS'],
			'sold_to_mobile' 			   => $value['TELF2'],
			'sold_to_email' 			   => $value['SMTP_ADDR'],
			'sold_to_tax_id'			   => $value['STCD3']

			);

$exist = $this->__ps_project_query->getObj('sap_tbm_sold_to_en', array('id' => $data['id'], 'sold_to_distribution_channel' => $data['sold_to_distribution_channel']));

if (empty($exist)) {
	$this->__ps_project_query->insertObj('sap_tbm_sold_to_en', $data);
}
}
}

			//echo "ZRFC_GET_CUSTOMER02 DONE <br>";
}

if ($active_function['ZRFC_GET_SHIP_TO_UD_SOLD_TO'] == 1) {
	$input = array(	 
		array("IMPORT", "I_LANGU", "2"),
		array("TABLE","ET_SHIP_TO",array())
		);

	$result = $this->callSAPFunction("ZRFC_GET_SHIP_TO_UD_SOLD_TO", $input);
	$this->db->truncate('sap_tbm_ship_to');
	if (!empty($result)) {
		$plant_list = array();
		foreach ($result['ET_SHIP_TO'] as $key => $value) {
			$data = array(
				'id' 				 		   => $value['KUNN2'],
				'ship_to_name' 			  	   => iconv("TIS-620", "UTF-8", $value['FULL_NAME'] ),
				'ship_to_name1' 			   => iconv("TIS-620", "UTF-8", $value['NAME1'] ),
				'ship_to_name2' 			   => iconv("TIS-620", "UTF-8", $value['NAME2'] ),
				'ship_to_name3' 			   => iconv("TIS-620", "UTF-8", $value['NAME3'] ),
				'ship_to_name4' 			   => iconv("TIS-620", "UTF-8", $value['NAME4'] ),
				'ship_to_address1' 			   => iconv("TIS-620", "UTF-8", $value['STR_SUPPL1'] ),
				'ship_to_address2' 			   => iconv("TIS-620", "UTF-8", $value['STR_SUPPL2'] ),
				'ship_to_address3' 			   => iconv("TIS-620", "UTF-8", $value['STR_SUPPL3'] ),
				'ship_to_address4' 			   => iconv("TIS-620", "UTF-8", $value['LOCATION'] ),
				'ship_to_district' 			   => iconv("TIS-620", "UTF-8", $value['CITY2'] ),
				'ship_to_city' 				   => iconv("TIS-620", "UTF-8", $value['CITY1'] ),
				'ship_to_postal_code' 		   => $value['POST_CODE1'],
				'ship_to_country' 			   => iconv("TIS-620", "UTF-8", $value['COUNTRY'] ),
				'ship_to_region' 			   => iconv("TIS-620", "UTF-8", $value['REGION'] ),
				'ship_to_industry' 			   => $value['BRSCH'],
				'sold_to_id'			       => $value['KUNNR'],
				'ship_to_account_group' 	   => $value['KTOKD'],
				'ship_to_search_term' 	       => iconv("TIS-620", "UTF-8", $value['SORTL'] ),
				'ship_to_business_scale' 	   => $value['KUKLA'],
				'ship_to_address_no' 		   => $value['ADRNR'],
				'ship_to_sale_org' 		       => $value['VKORG'],
				'ship_to_distribution_channel' => $value['VTWEG'],
				'ship_to_tel' 				   => $value['TEL_NUMBER'],
				'ship_to_tel_ext' 		       => $value['TEL_EXTENS'],
				'ship_to_fax'		 		   => $value['FAX_NUMBER'],
				'ship_to_fax_ext' 			   => $value['FAX_EXTENS'],
				'ship_to_mobile' 			   => $value['TELF2'],
				'ship_to_email' 			   => $value['SMTP_ADDR'],
				'ship_to_branch_id'			   => $value['BCODE'],
				'ship_to_branch_des'		   => iconv("TIS-620", "UTF-8", $value['FITH_DESC'] ),
				'ins_id'					   => iconv("TIS-620", "UTF-8", $value['INS_ID'] ),
				'ins_name'					   => iconv("TIS-620", "UTF-8", $value['INS_NAME'] ),
				'plant_code'				   => iconv("TIS-620", "UTF-8", $value['VWERK'] ),
				'plant_name'				   => iconv("TIS-620", "UTF-8", $value['NAME1_VWERK'] ),
				'ship_to_tax_id'			   => $value['STCD3']
				);

$exist = $this->__ps_project_query->getObj('sap_tbm_ship_to', array('id' => $data['id'], 'ship_to_distribution_channel' => $data['ship_to_distribution_channel']));

if (empty($exist)) {
	$this->__ps_project_query->insertObj('sap_tbm_ship_to', $data);
}

$plant_exist = $this->__ps_project_query->getObj('sap_tbm_plant', array('plant_code' => $data['plant_code']));

if (empty($plant_exist)) {
	$this->__ps_project_query->insertObj('sap_tbm_plant', array('plant_code' => $data['plant_code'], 'plant_name' => $data['plant_name']));
}

if (!in_array($data['plant_code'], $plant_list)) {
	array_push($plant_list, $data['plant_code']);
}

}

if (!empty($plant_list)) {

	$this->db->where_not_in('plant_code', $plant_list);
	$this->db->delete('sap_tbm_plant');

}
}

$input = array(	 
	array("IMPORT", "I_LANGU", "E"),
	array("TABLE","ET_SHIP_TO",array())
	);

$result = $this->callSAPFunction("ZRFC_GET_SHIP_TO_UD_SOLD_TO", $input);
$this->db->truncate('sap_tbm_ship_to_en');
if (!empty($result)) {
	foreach ($result['ET_SHIP_TO'] as $key => $value) {
		$data = array(
			'id' 				 		   => $value['KUNN2'],
			'ship_to_name' 			  	   => iconv("TIS-620", "UTF-8", $value['FULL_NAME'] ),
			'ship_to_name1' 			   => iconv("TIS-620", "UTF-8", $value['NAME1'] ),
			'ship_to_name2' 			   => iconv("TIS-620", "UTF-8", $value['NAME2'] ),
			'ship_to_name3' 			   => iconv("TIS-620", "UTF-8", $value['NAME3'] ),
			'ship_to_name4' 			   => iconv("TIS-620", "UTF-8", $value['NAME4'] ),
			'ship_to_address1' 			   => iconv("TIS-620", "UTF-8", $value['STR_SUPPL1'] ),
			'ship_to_address2' 			   => iconv("TIS-620", "UTF-8", $value['STR_SUPPL2'] ),
			'ship_to_address3' 			   => iconv("TIS-620", "UTF-8", $value['STR_SUPPL3'] ),
			'ship_to_address4' 			   => iconv("TIS-620", "UTF-8", $value['LOCATION'] ),
			'ship_to_district' 			   => iconv("TIS-620", "UTF-8", $value['CITY2'] ),
			'ship_to_city' 				   => iconv("TIS-620", "UTF-8", $value['CITY1'] ),
			'ship_to_postal_code' 		   => $value['POST_CODE1'],
			'ship_to_country' 			   => iconv("TIS-620", "UTF-8", $value['COUNTRY'] ),
			'ship_to_region' 			   => iconv("TIS-620", "UTF-8", $value['REGION'] ),
			'ship_to_industry' 			   => $value['BRSCH'],
			'sold_to_id'			       => $value['KUNNR'],
			'ship_to_account_group' 	   => $value['KTOKD'],
			'ship_to_search_term' 	       => iconv("TIS-620", "UTF-8", $value['SORTL'] ),
			'ship_to_business_scale' 	   => $value['KUKLA'],
			'ship_to_address_no' 		   => $value['ADRNR'],
			'ship_to_sale_org' 		       => $value['VKORG'],
			'ship_to_distribution_channel' => $value['VTWEG'],
			'ship_to_tel' 				   => $value['TEL_NUMBER'],
			'ship_to_tel_ext' 		       => $value['TEL_EXTENS'],
			'ship_to_fax'		 		   => $value['FAX_NUMBER'],
			'ship_to_fax_ext' 			   => $value['FAX_EXTENS'],
			'ship_to_mobile' 			   => $value['TELF2'],
			'ship_to_email' 			   => $value['SMTP_ADDR'],
			'ship_to_branch_id'			   => $value['BCODE'],
			'ship_to_branch_des'		   => iconv("TIS-620", "UTF-8", $value['FITH_DESC'] ),
			'ins_id'					   => iconv("TIS-620", "UTF-8", $value['INS_ID'] ),
			'ins_name'					   => iconv("TIS-620", "UTF-8", $value['INS_NAME'] ),
			'plant_code'				   => iconv("TIS-620", "UTF-8", $value['VWERK'] ),
			'plant_name'				   => iconv("TIS-620", "UTF-8", $value['NAME1_VWERK'] ),
			'ship_to_tax_id'			   => $value['STCD3']
			);

$exist = $this->__ps_project_query->getObj('sap_tbm_ship_to_en', array('id' => $data['id'], 'ship_to_distribution_channel' => $data['ship_to_distribution_channel']));

if (empty($exist)) {
	$this->__ps_project_query->insertObj('sap_tbm_ship_to_en', $data);
}
}
}
			//echo "ZRFC_GET_SHIP_TO_UD_SOLD_TO DONE <br>";
}

if ($active_function['ZRFC_GET_COUNTRY'] == 1) {
	$input = array(	 
		array("TABLE","ET_OUTPUT",array())
		);

	$result = $this->callSAPFunction("ZRFC_GET_COUNTRY", $input);
	$this->db->truncate('sap_tbm_country');
	if (!empty($result)) {
		foreach ($result['ET_OUTPUT'] as $key => $value) {
			$data = array(
				'id'    => $value['LAND1'],
				'title' => iconv("TIS-620", "UTF-8", $value['LANDX'])
				);

			$this->__ps_project_query->insertObj('sap_tbm_country', $data);
		}
	}

			//echo "ZRFC_GET_COUNTRY DONE <br>";
}

if ($active_function['ZRFC_GET_REGION'] == 1) {
	$input = array(	 
		array("TABLE","ET_OUTPUT",array())
		);

	$result = $this->callSAPFunction("ZRFC_GET_REGION", $input);
	$this->db->truncate('sap_tbm_region');
	$this->db->truncate('sap_tbm_region_en');
	if (!empty($result)) {
		foreach ($result['ET_OUTPUT'] as $key => $value) {
			$data = array(
				'id'         => $value['BLAND'],
				'title'      => iconv("TIS-620", "UTF-8", $value['BEZEI'])
						// 'country_id' => $value['LAND1']
				);
			if ($value['SPRAS'] == '2') {
				$this->__ps_project_query->insertObj('sap_tbm_region', $data);
			} else {
				$this->__ps_project_query->insertObj('sap_tbm_region_en', $data);
			}
		}
	}

			//echo "ZRFC_GET_REGION DONE <br>";
}

if ($active_function['ZRFC_GET_BUSSINESS_SCALE'] == 1) {
	$input = array(	 
		array("TABLE","ET_OUTPUT",array())
		);

	$result = $this->callSAPFunction("ZRFC_GET_BUSSINESS_SCALE", $input);
	$this->db->truncate('sap_tbm_business_scale');
	if (!empty($result)) {
		foreach ($result['ET_OUTPUT'] as $key => $value) {
			$data = array(
				'id'    => $value['KUKLA'],
				'title' => iconv("TIS-620", "UTF-8", $value['VTEXT']),
				'index' => $value['SHNAM']
				);

			$this->__ps_project_query->insertObj('sap_tbm_business_scale', $data);
		}
	}

			//echo "ZRFC_GET_BUSSINESS_SCALE DONE <br>";
}

if ($active_function['ZRFC_GET_MATERIAL'] == 1) {
	$input = array(	 
		array("IMPORT","I_LANGU", '2'),
		array("TABLE","ET_MATERIAL",array())
		);

	$result = $this->callSAPFunction("ZRFC_GET_MATERIAL", $input);
	$this->db->truncate('sap_tbm_clear_map');
	$this->db->truncate('sap_tbm_clear_type');
	$this->db->truncate('sap_tbm_material');

	$clear_type_list = array();

	if (!empty($result)) {
		foreach ($result['ET_MATERIAL'] as $key => $value) {
			$data = array(
				'material_no'    	   => $value['MATNR'],
				'material_description' => iconv("TIS-620", "UTF-8", $value['MAKTX']),
				'unit_code'            => $value['MEINS'],
				'mat_type'             => $value['MTART'],
				'mat_group'            => $value['MATKL'],
				'mat_type_des'         => iconv("TIS-620", "UTF-8", $value['MTBEZ']),
				'mat_group_des'        => iconv("TIS-620", "UTF-8", $value['WGBEZ']),
				'account_assignment_group' => $value['KTGRM']
				);

			$this->__ps_project_query->insertObj('sap_tbm_material', $data);

			if ($data['mat_type'] == 'Z016') {

				$clear_obj = $this->__ps_project_query->getObj('sap_tbm_clear_map', array('texture_id' => $data['material_no']));
				if (empty($clear_obj)) {

					$clear_map_data = array(
						'texture_id' => $data['material_no'],
						'texture_des' => $data['material_description'],
						'clear_type_id' => $data['mat_group'],
						'clear_type_des' => $data['mat_group_des'],
						);
					$this->__ps_project_query->insertObj('sap_tbm_clear_map', $clear_map_data);

					if (!array_key_exists($data['mat_group'], $clear_type_list)) {
						$clear_type_list[$data['mat_group']] = $data['mat_group_des'];
					}
				}
			}
		}

		if (!empty($clear_type_list)) {
			foreach ($clear_type_list as $id => $desc) {
				$clear_data = array(
					'id' 			=> $id,
					'description' 	=> $desc
					);
				$this->__ps_project_query->insertObj('sap_tbm_clear_type', $clear_data);
			}
		}
	}

			//echo "ZRFC_GET_MATERIAL DONE <br>";
}

if ($active_function['ZRFC_GET_BRSCH'] == 1) {
	$input = array(	 
		array("TABLE","ET_BRSCH",array())
		);

	$result = $this->callSAPFunction("ZRFC_GET_BRSCH", $input);
	$this->db->truncate('sap_tbm_industry');
	$this->db->truncate('sap_tbm_industry_en');
	if (!empty($result)) {
		foreach ($result['ET_BRSCH'] as $key => $value) {
			$data = array(
				'id'    => $value['BRSCH'],
				'title' => iconv("TIS-620", "UTF-8", $value['BRTXT']),
				);

			if ($value['SPRAS'] == '2') {
				$this->__ps_project_query->insertObj('sap_tbm_industry', $data);
			} else {
				$this->__ps_project_query->insertObj('sap_tbm_industry_en', $data);
			}
		}
	}

			//echo "ZRFC_GET_BRSCH DONE <br>";
}

if ($active_function['ZRFC_GET_ROOM'] == 1) {
	$input = array(	 
		array("TABLE","ET_BRSCH_ROOM",array())
		);

	$result = $this->callSAPFunction("ZRFC_GET_ROOM", $input);

	$this->db->truncate('sap_tbm_industry_room');
	$this->db->truncate('sap_tbm_industry_room_en');
	if (!empty($result)) {
		foreach ($result['ET_BRSCH_ROOM'] as $key => $value) {
			$lang = $value['LANGU'];

			if ($lang == '2') {
				$data = array(
					'industry_id'    => $value['BRSCH'],
					'id'    		 => $value['RCODE'],
					'title' 		 => iconv("TIS-620", "UTF-8", $value['DESCT']),
					);

				$this->__ps_project_query->insertObj('sap_tbm_industry_room', $data);
			} else {
				$data = array(
					'industry_id'    => $value['BRSCH'],
					'id'    		 => $value['RCODE'],
					'title' 		 => iconv("TIS-620", "UTF-8", $value['DESCT']),
					);

				$this->__ps_project_query->insertObj('sap_tbm_industry_room_en', $data);					
			}
		}
	}

			//echo "ZRFC_GET_ROOM DONE <br>";
}

if ($active_function['ZRFC_GET_BOM'] == 1) {
	$input = array(	 
		array("IMPORT","I_STLAN", 5),
		array("IMPORT","I_LANGU", '2'),
		array("TABLE","ET_OUTPUT",array())
		);

	$result = $this->callSAPFunction("ZRFC_GET_BOM", $input);

	$this->db->truncate('sap_tbm_bomb');
	if (!empty($result)) {
		foreach ($result['ET_OUTPUT'] as $key => $value) {
			$data = array(
				'texture_id'	 		=> $value['BOMAT'],
				'material_no'    		=> $value['MATNR'],
				'material_description'  => iconv("TIS-620", "UTF-8", $value['MAKTX']),
				'volumn' 		 		=> $value['VOLUM'],
				'unit_volumn' 		 	=> $value['VOLEH'],
				'unit_code'	 		 	=> $value['MEINS'],
				'quantity' 		 	  	=> $value['MENGE'],
				'mat_type'              => $value['MTART'],
				'mat_group'             => $value['MATKL'],
				'mat_type_des'          => iconv("TIS-620", "UTF-8", $value['MTBEZ']),
				'mat_group_des'         => iconv("TIS-620", "UTF-8", $value['WGBEZ']),
				'texture_des'			=> iconv("TIS-620", "UTF-8", $value['BDESC'])
				);

			$obj = $this->__ps_project_query->getObj('sap_tbm_bomb', array('texture_id' => $data['texture_id'], 'material_no' => $data['material_no']));

			if (empty($obj)) {
				$this->__ps_project_query->insertObj('sap_tbm_bomb', $data);
			}
		}
	}

	$input = array(	 
		array("IMPORT","I_STLAN", 5),
		array("IMPORT","I_LANGU", 'E'),
		array("TABLE","ET_OUTPUT",array())
		);

	$result = $this->callSAPFunction("ZRFC_GET_BOM", $input);

	$this->db->truncate('sap_tbm_bomb_en');
	if (!empty($result)) {
		foreach ($result['ET_OUTPUT'] as $key => $value) {
			$data = array(
				'texture_id'	 		=> $value['BOMAT'],
				'material_no'    		=> $value['MATNR'],
				'material_description'  => iconv("TIS-620", "UTF-8", $value['MAKTX']),
				'volumn' 		 		=> $value['VOLUM'],
				'unit_volumn' 		 	=> $value['VOLEH'],
				'unit_code'	 		 	=> $value['MEINS'],
				'quantity' 		 	  	=> $value['MENGE'],
				'mat_type'              => $value['MTART'],
				'mat_group'             => $value['MATKL'],
				'mat_type_des'          => iconv("TIS-620", "UTF-8", $value['MTBEZ']),
				'mat_group_des'         => iconv("TIS-620", "UTF-8", $value['WGBEZ']),
				'texture_des'			=> iconv("TIS-620", "UTF-8", $value['BDESC'])
				);

			$obj = $this->__ps_project_query->getObj('sap_tbm_bomb_en', array('texture_id' => $data['texture_id'], 'material_no' => $data['material_no']));

			if (empty($obj)) {
				$this->__ps_project_query->insertObj('sap_tbm_bomb_en', $data);
			}
		}
	}
			//echo "ZRFC_GET_BOM DONE <br>";
}

if ($active_function['ZRFC_GET_MAT_PRICE01'] == 1) {
	$input = array(	 
		array("TABLE","ET_OUTPUT",array())
		);

	$result = $this->callSAPFunction("ZRFC_GET_MAT_PRICE01", $input);
	$this->db->truncate('sap_tbm_mat_price');
	if (!empty($result)) {

		foreach ($result['ET_OUTPUT'] as $key => $value) {
			$data = array(
				'material_no'    => $value['MATNR'],
				'condition_type' => iconv("TIS-620", "UTF-8", $value['KSCHL']),
				'sale_org' 		 => $value['VKORG'],
				'KFRST' 		 => $value['KFRST'],
				'valid_from'	 => $value['DATAB'],
				'valid_to' 		 => $value['DATBI'],
				'price' 		 => $value['KBETR'],
				'doc_type'		 => $value['AUART_SD']
				);

			$obj = $this->__ps_project_query->getObj('sap_tbm_mat_price', array('material_no' => $value['MATNR'], 'doc_type' => $value['AUART_SD']));
			if (empty($obj)) {
				$this->__ps_project_query->insertObj('sap_tbm_mat_price', $data);
			}
		}
	}

			//echo "ZRFC_GET_MAT_PRICE01 DONE <br>";
}

if ($active_function['ZRFC_GET_PARTNER_FUNCTION'] == 1) {	
	$input = array(	 
		array("TABLE","ET_PARTNER_FUNCTION",array())
		);

	$result = $this->callSAPFunction("ZRFC_GET_PARTNER_FUNCTION", $input);
	$this->db->truncate('sap_tbm_partner_function');
	if (!empty($result)) {
		foreach ($result['ET_PARTNER_FUNCTION'] as $key => $value) {
			$data = array(
				'partner_function_type'    	 => $value['PARVW'],
				'partner_function_id' 		 => $value['KUNN2'],
				'customer_id' 		 		 => $value['KUNNR'],
				'division' 		 			 => $value['SPART'],
				'distribution_channel'	 	 => $value['VTWEG'],
				'partner_function_type_name' => $value['VTEXT'],
				'partner_function_name' 	 => $value['NAME1'],
				'employee_id'				 => $value['NAME4']
				);

			$this->__ps_project_query->insertObj('sap_tbm_partner_function', $data);
		}
	}

			//echo "ZRFC_GET_PARTNER_FUNCTION DONE <br>";
}

if ($active_function['ZRFC_GET_CONTACT_PERSON'] == 1) {	
	$input = array(	 
		array("TABLE","ET_OUTPUT",array()),						
		array("TABLE","ET_TITLE",array())
		);

	$result = $this->callSAPFunction("ZRFC_GET_CONTACT_PERSON", $input);

	$this->db->truncate('sap_tbm_contact_title');
	$this->db->truncate('sap_tbm_contact');
	if (!empty($result['ET_TITLE'])) {
		foreach ($result['ET_TITLE'] as $key => $value) {
			$data = array(
				'id'    	 			=> $value['TITLE'],
				'lang'					=> $value['LANGU'],
				'title' 		 		=> iconv("TIS-620", "UTF-8",$value['TITLE_MEDI'])
				);

			$this->__ps_project_query->insertObj('sap_tbm_contact_title', $data);
		}
	}

	if (!empty($result['ET_OUTPUT'])) {
		foreach ($result['ET_OUTPUT'] as $key => $value) {
			$data = array(
				'title'    	 				=> $value['ANRED'],
				'firstname'    	 			=> $value['NAMEV'],
				'lastname' 		 			=> $value['NAME1'],
				'function' 		 			=> $value['PAFKT'],
				'function_des' 				=> $value['PAFKT_TXT'],
				'department'	 	 		=> $value['ABTNR'],
				'department_des' 			=> $value['ABTNR_TXT'],
				'tel' 	 					=> $value['TEL_NUMBER'],
				'tel_ext'					=> $value['TEL_EXTENS'],
				'fax'				 		=> $value['FAX_NUMBER'],
				'fax_ext'				 	=> $value['FAX_EXTENS'],
				'email'				 		=> $value['SMTP_ADDR'],
				'mobile'				 	=> $value['TELNR_CALL'],
				'ship_to_id'				=> $value['KUNNR']
				);

			$this->__ps_project_query->insertObj('sap_tbm_contact', $data);
		}
	}

			//echo "ZRFC_GET_CONTACT_PERSON DONE <br>";
}

if ($active_function['ZRFC_GET_DISTR_C'] == 1) {
	$input = array(	 
		array("TABLE","ET_DISTR",array())
		);

	$result = $this->callSAPFunction("ZRFC_GET_DISTR_C", $input);
	$this->db->truncate('sap_tbm_distribution_channel');
	if (!empty($result)) {
		foreach ($result['ET_DISTR'] as $key => $value) {
			$data = array(
				'id'				     			=> $value['VTWEG'],
				'distribution_channel_description'	=> iconv("TIS-620", "UTF-8",$value['VTEXT'])
				);

			$this->__ps_project_query->insertObj('sap_tbm_distribution_channel', $data);
		}
	}

			//echo "ZRFC_GET_DISTR_C DONE <br>";
}

if ($active_function['ZRFC_GET_ZTERM'] == 1) {
	$input = array(	 
		array("TABLE","ET_ZTERM",array())
		);

	$result = $this->callSAPFunction("ZRFC_GET_ZTERM", $input);
	$this->db->truncate('sap_tbm_term_of_payment');
	if (!empty($result)) {
		foreach ($result['ET_ZTERM'] as $key => $value) {
			$data = array(
				'id'		 			=> $value['ZTERM'],
				'payment_description'	=> iconv("TIS-620", "UTF-8",$value['VTEXT'])
				);

			$this->__ps_project_query->insertObj('sap_tbm_term_of_payment', $data);
		}
	}

			//echo "ZRFC_GET_ZTERM DONE <br>";
}

if ($active_function['ZRFC_QUOTATION'] == 1) {
	$input = array(	 
		array("TABLE","ET_FUNC",array()),
		array("TABLE","ET_DEPART",array()),
		array("TABLE","ET_OTHER_STAFF",array()),
		array("TABLE","ET_POSITION_P",array()),
		array("TABLE","ET_OLD_MAT",array()),
							// array("TABLE","ET_LEVEL",array()),
							// array("TABLE","ET_POSITION",array())
		);

	$result = $this->callSAPFunction("ZRFC_QUOTATION", $input);
	$this->db->truncate('sap_tbm_function');
	$this->db->truncate('sap_tbm_department');
	$this->db->truncate('sap_tbm_other');
	$this->db->truncate('sap_tbm_employee_level');
	$this->db->truncate('sap_tbm_position');
	$this->db->truncate('sap_tbm_position_price');	
	$this->db->truncate('sap_tbm_map_code');			

	if (!empty($result['ET_OLD_MAT'])) {
		foreach ($result['ET_OLD_MAT'] as $key => $value) {
			$data = array(
				'sap_code' 			=> $value['MATNR'],
				'hr_code'			=> $value['BISMT']
				);

			$this->__ps_project_query->insertObj('sap_tbm_map_code', $data);
		}
	}

	if (!empty($result['ET_FUNC'])) {
		foreach ($result['ET_FUNC'] as $key => $value) {
			$data = array(
				'id' 			=> $value['PAFKT'],
				'description'	=> iconv("TIS-620", "UTF-8",$value['VTEXT'])
				);

			$this->__ps_project_query->insertObj('sap_tbm_function', $data);
		}
	}
	if (!empty($result['ET_DEPART'])) {
		foreach ($result['ET_DEPART'] as $key => $value) {
			$data = array(
				'id' 			=> $value['ABTNR'],
				'title'			=> iconv("TIS-620", "UTF-8",$value['VTEXT'])
				);

			$this->__ps_project_query->insertObj('sap_tbm_department', $data);
		}
	}
	if (!empty($result['ET_OTHER_STAFF'])) {
		foreach ($result['ET_OTHER_STAFF'] as $key => $value) {
			$data = array(
				'id' 			=> $value['ID'],
				'description'	=> iconv("TIS-620", "UTF-8",$value['DESCRIPTION'])
				);

			$this->__ps_project_query->insertObj('sap_tbm_other', $data);
		}
	}

	if (!empty($result['ET_POSITION_P'])) {
		foreach ($result['ET_POSITION_P'] as $key => $value) {

			$level_exist = $this->__ps_project_query->getObj('sap_tbm_employee_level', array('id' => $value['MATKL']));
			if (empty($level_exist)) {

				$mat_group = $this->__ps_project_query->getObj('sap_tbm_mat_group', array('id' => $value['MATKL']));
				if (!empty($mat_group)) {

					$data = array(
						'id' 			=> $value['MATKL'],
						'description'	=> $mat_group['description']
								//'description'	=> iconv("TIS-620", "UTF-8",$mat_group['description'])
						);

					$this->__ps_project_query->insertObj('sap_tbm_employee_level', $data);

				}
			}

			$position_exist = $this->__ps_project_query->getObj('sap_tbm_position', array('id' => $value['MATNR'], 'level' => $value['MATKL']));
			if (empty($position_exist)) {

				$mat = $this->__ps_project_query->getObj('sap_tbm_material', array('material_no' => $value['MATNR']));
				if (!empty($mat)) {
					$data = array(
						'id' 			=> $value['MATNR'],
						'title'			=> $mat['material_description'],
								//'title'			=> iconv("TIS-620", "UTF-8",$mat['material_description']),
						'level'			=> $value['MATKL']
						);

					$this->__ps_project_query->insertObj('sap_tbm_position', $data);
				}

			}

			$position_price_exist = $this->__ps_project_query->getObj('sap_tbm_position_price', array('position_id' => $value['MATNR'], 'ship_to_id' => $value['KUNNR']));
			if (empty($position_price_exist)) {

				$data = array(
					'position_id' 	=> $value['MATNR'],
					'ship_to_id'	=> $value['KUNNR'],
					'price'			=> $value['KBETR']
					);

				$this->__ps_project_query->insertObj('sap_tbm_position_price', $data);


			}

		}
	}

			// if (!empty($result['ET_LEVEL'])) {
			// 	foreach ($result['ET_LEVEL'] as $key => $value) {
			// 		$data = array(
			// 			'id' 			=> $value['ID'],
			// 			'description'	=> iconv("TIS-620", "UTF-8",$value['DESCRIPTION'])
			// 		);

			// 		$this->__ps_project_query->insertObj('sap_tbm_employee_level', $data);
			// 	}
			// }
			// if (!empty($result['ET_POSITION'])) {
			// 	foreach ($result['ET_POSITION'] as $key => $value) {
			// 		$data = array(
			// 			'id' 			=> $value['ID'],
			// 			'title'			=> iconv("TIS-620", "UTF-8",$value['DESCRIPTION']),
			// 			'level'			=> $value['LEVEL_ID']
			// 		);

			// 		$this->__ps_project_query->insertObj('sap_tbm_position', $data);
			// 	}
			// }

			//echo "ZRFC_QUOTATION DONE <br>";
}

if ($active_function['ZRFC_GET_MATERIAL_GROUP'] == 1) {
	$input = array(	 
		array("TABLE","ET_MAT_GROUP2",array())
		);

	$result = $this->callSAPFunction("ZRFC_GET_MATERIAL_GROUP", $input);
	$this->db->truncate('sap_tbm_mat_group');
	if (!empty($result)) {
		foreach ($result['ET_MAT_GROUP2'] as $key => $value) {
			$data = array(
				'id'    	   => $value['MATKL'],
				'description'  => iconv("TIS-620", "UTF-8", $value['WGBEZ']),
				'mat_type'	   => $value['MTART']
						// 'description'  => $value['WGBEZ']
				);

			$exist = $this->__ps_project_query->getObj('sap_tbm_mat_group', array('id' => $data['id'], 'mat_type' => $value['MTART']));

			if (empty($exist)) {
				$this->__ps_project_query->insertObj('sap_tbm_mat_group', $data);
			} else {
				$this->__ps_project_query->updateObj('sap_tbm_mat_group', array('id' => $data['id'], 'mat_type' => $value['MTART']), $data);
			}
		}
	}

			//echo "ZRFC_GET_MATERIAL_GROUP DONE <br>";
}

echo json_encode(array('status' => true, 'function' => $function));
}

function duplicate_quotation ($quotation_id, $replace=0) {

	$emp_id = $this->session->userdata('id');
	$quotation = $this->__ps_project_query->getObj('tbt_quotation', array('id' => $quotation_id));
	if (!empty($quotation)) {

		/* #### Create New Quotation #### */
		if ($replace == 1) {
			$this->__ps_project_query->updateObj('tbt_quotation', array('id' => $quotation_id), array('status' => 'deleted'));
			$id = $quotation_id+1;
			$quotation['id'] = $id;
		} else {
			$id = $this->__quotation_model->getLastQuotationId($quotation['job_type']);
			$id = (round(floor(($id/100)))+1)*100;
			$quotation['id'] = $id;
		}


		$quotation['project_owner_id'] 	= $emp_id;
		$quotation['is_go_live'] 	= 0;
		$quotation['contract_id'] 	= '';
		$quotation['project_start'] = '';
		$quotation['project_end'] 	= '';
		$quotation['is_submit_to_sap'] 	= 0;
		$quotation['submit_date_to_sap'] = "";
		$quotation['status'] 		= 'open';
		$quotation['title'] 		= 'Copy of '.$quotation['title'];
		$quotation['create_date'] = date('Y-m-d');
		$this->__ps_project_query->insertObj('tbt_quotation', $quotation);

		/* #### Duplicate : tbt_required_document #### */
		$data_list = $this->__ps_project_query->getObj('tbt_required_document', array('quotation_id' => $quotation_id), true);
		if (!empty($data_list)) {
			foreach ($data_list as $data_val) {
				$data_val['quotation_id'] = $id;
				$this->__ps_project_query->insertObj('tbt_required_document', $data_val);
			}
		}

		/* #### Duplicate : tbt_building #### */
		$data_list = $this->__ps_project_query->getObj('tbt_building', array('quotation_id' => $quotation_id), true);
		if (!empty($data_list)) {
			foreach ($data_list as $data_val) {
				$old_building_id = $data_val['id'];
				$data_val['quotation_id'] = $id;
				unset($data_val['id']);
				unset($data_val['contract_id']);
				$building_id = $this->__ps_project_query->insertObj('tbt_building', $data_val);

				/* #### Duplicate : tbt_floor #### */
				$floor_data_list = $this->__ps_project_query->getObj('tbt_floor', array('quotation_id' => $quotation_id, 'building_id' => $old_building_id), true);					
				if (!empty($floor_data_list)) {
					foreach ($floor_data_list as $floor_data_val) {
						$old_floor_id = $floor_data_val['id'];
						$floor_data_val['quotation_id'] = $id;
						$floor_data_val['building_id'] = $building_id;
						unset($floor_data_val['id']);
						unset($floor_data_val['contract_id']);
						$floor_id = $this->__ps_project_query->insertObj('tbt_floor', $floor_data_val);

						/* #### Duplicate : tbt_area #### */
						$area_data_list = $this->__ps_project_query->getObj('tbt_area', array('quotation_id' => $quotation_id, 'floor_id' => $old_floor_id, 'building_id' => $old_building_id), true);
						if (!empty($area_data_list)) {
							foreach ($area_data_list as $area_data_val) {
								$area_data_val['quotation_id'] = $id;
								$area_data_val['building_id'] = $building_id;
								$area_data_val['floor_id'] = $floor_id;
								unset($area_data_val['id']);
								unset($area_data_val['contract_id']);
								$this->__ps_project_query->insertObj('tbt_area', $area_data_val);
							}
						}
					}
				}
			}
		}		

		/* #### Duplicate : tbt_equipment #### */
		$data_list = $this->__ps_project_query->getObj('tbt_equipment', array('quotation_id' => $quotation_id), true);
		if (!empty($data_list)) {
			foreach ($data_list as $data_val) {
				$data_val['quotation_id'] = $id;
				unset($data_val['id']);
				$this->__ps_project_query->insertObj('tbt_equipment', $data_val);
			}
		}

		/* #### Duplicate : tbt_equipment_clearjob #### */
		$data_list = $this->__ps_project_query->getObj('tbt_equipment_clearjob', array('quotation_id' => $quotation_id), true);
		if (!empty($data_list)) {
			foreach ($data_list as $data_val) {
				$data_val['quotation_id'] = $id;
				unset($data_val['id']);
				$this->__ps_project_query->insertObj('tbt_equipment_clearjob', $data_val);
			}
		}
		/////////////////////////////////////////////////////////////////////////////

		/* #### Duplicate : tbt_man_group #### */
		$data_list = $this->__ps_project_query->getObj('tbt_man_group', array('quotation_id' => $quotation_id), true);
		if (!empty($data_list)) {
			foreach ($data_list as $data_val) {
				$old_man_group_id = $data_val['id'];
				$data_val['quotation_id'] = $id;
				unset($data_val['id']);
				$man_group_id = $this->__ps_project_query->insertObj('tbt_man_group', $data_val);

				/* #### Duplicate : tbt_man_subgroup #### */
				$mansub_data_list = $this->__ps_project_query->getObj('tbt_man_subgroup', array('quotation_id' => $quotation_id, 'man_group_id' => $old_man_group_id), true);
				if (!empty($mansub_data_list)) {
					foreach ($mansub_data_list as $mansub_data_val) {
						$mansub_data_val['man_group_id'] = $man_group_id;
						$mansub_data_val['quotation_id'] = $id;
						unset($mansub_data_val['id']);
						$this->__ps_project_query->insertObj('tbt_man_subgroup', $mansub_data_val);
					}
				}

			}		
		}
		//// *****************************
		// /* #### Duplicate : tbt_man_group #### */
		// $data_list = $this->__ps_project_query->getObj('tbt_man_group', array('quotation_id' => $quotation_id), true);
		// if (!empty($data_list)) {
		// 	foreach ($data_list as $data_val) {
		// 		$data_val['quotation_id'] = $id;
		// 		unset($data_val['id']);
		// 		$this->__ps_project_query->insertObj('tbt_man_group', $data_val);
		// 	}
		// }

		//  #### Duplicate : tbt_man_subgroup #### 
		// $data_list = $this->__ps_project_query->getObj('tbt_man_subgroup', array('quotation_id' => $quotation_id), true);
		// if (!empty($data_list)) {
		// 	foreach ($data_list as $data_val) {
		// 		$data_val['quotation_id'] = $id;
		// 		unset($data_val['id']);
		// 		$this->__ps_project_query->insertObj('tbt_man_subgroup', $data_val);
		// 	}
		// }
		/////////////////////////////////////////////////////////////////////////////////////////////////

		/* #### Duplicate : tbt_contact #### */
		$data_list = $this->__ps_project_query->getObj('tbt_contact', array('quotation_id' => $quotation_id), true);
		if (!empty($data_list)) {
			foreach ($data_list as $data_val) {
				$data_val['quotation_id'] = $id;
				unset($data_val['id']);
				$this->__ps_project_query->insertObj('tbt_contact', $data_val);
			}
		}

		/* #### Duplicate : tbt_other_service #### */
		$data_list = $this->__ps_project_query->getObj('tbt_other_service', array('quotation_id' => $quotation_id), true);
		if (!empty($data_list)) {
			foreach ($data_list as $data_val) {
				$data_val['quotation_id'] = $id;
				unset($data_val['id']);
				$this->__ps_project_query->insertObj('tbt_other_service', $data_val);
			}
		}

		if ($replace == 1) {
			$this->__ps_project_query->updateObj('tbt_quotation', array('id' => $quotation_id), array('replaced_by' => $id));				
		}
	}

	redirect(site_url('__ps_quotation/listview_quotation'));
}

function save_summary ($quotation_id) {

	$p = $this->input->post();
	$p = str_replace(',', '', $p);

	$submit = $p['submit_to_papyrus'];
	unset($p['submit_to_papyrus']);

	if (!empty($p)) {
		$summary = $this->__ps_project_query->getObj('tbt_summary', array('quotation_id' => $quotation_id));
		if (empty($summary)) {
			$p['quotation_id'] = $quotation_id;
			$this->__ps_project_query->insertObj('tbt_summary', $p);
		} else {
			$this->__ps_project_query->updateObj('tbt_summary', array('quotation_id' => $quotation_id), $p);
		}
	}

	if ($submit != 1) {
		redirect(site_url('__ps_quotation/detail_quotation/edit_quotation/'.$quotation_id.'/0/7'));
	} else {
		$this->submit_to_papyrus($quotation_id);
	}	
}

function submit_to_papyrus ($quotation_id) {

	$ip = $this->papyrus['ip'];
	$pingresult = exec("ping -n 3 $ip", $outcome, $status);

	if (empty($status)) {

		if (!empty($quotation_id)) {

			$quotation 		   = $this->__ps_project_query->getObj('tbt_quotation', array('id' => $quotation_id));
			$quotation_summary = $this->__ps_project_query->getObj('tbt_summary', array('quotation_id' => $quotation_id));

			if (!empty($quotation) && !empty($quotation_summary)) {

				//echo $quotation['title']." || is :".$quotation['is_prospect'];
				if($quotation['is_prospect']==1){
					$customerName = $quotation['title'];
				}else{
					$customerName = "";
				}
				// echo "<br>*** ".$customerName;
				// die();

				$emp_id = $this->session->userdata('id');
				$emp_name  = $this->session->userdata('actual_name');

				$user = $this->__ps_project_query->getObj('tbt_user', array('employee_id' => $emp_id));

				$margin = $quotation_summary['mpercent_margin'];
				if (!empty($quotation_summary['percent_margin'])) {
					$margin = $quotation_summary['percent_margin'];
				}

				$data = array(
					'quotation_id' 	=> $quotation_id,
					'distribution_channel' => $quotation['distribution_channel'],
					'final_price'  	=> $quotation_summary['total'],
					'userId'  		=> $user['user_id'],
					'userCode'		=> $emp_id,
					'employee_name' => $emp_name,
					'margin'        => $margin
					);


				$this->load->library("nusoap_lib");
				$this->webservice_url = $this->papyrus['getOperAreaUrl'];

				error_reporting(0);

				$this->nusoap_client = new nusoap_client($this->webservice_url,true);
				$this->nusoap_client->soap_defencoding = 'UTF-8';
				$this->nusoap_client->decode_utf8 = false;

				$soap_result = array();
				$params = array(
					'docNo' 		=> $data['quotation_id'],
					'projectBudget' => $data['final_price'],
					'userId'		=> $data['userId'],
					'empCode'		=> $data['userCode'],
					'initName'		=> $data['employee_name'],
					'saleArea'		=> $data['distribution_channel'],
					'margin'		=> $data['margin'],
					'url'			=> site_url('__ps_quotation/detail_quotation/view_quotation/'.$quotation_id),
					'customerId'	=> $quotation['ship_to_id'],
					'customerName'	=> $customerName,

					);

		            // echo "<pre>";
		            // print_r($params);
		            // echo "</pre>";
				if($this->nusoap_client->fault)
				{
					$err_msg = 'Error: '.$this->nusoap_client->fault;
				}
				else
				{
					if ($this->nusoap_client->getError())
					{
						$err_msg = 'Error: '.$this->nusoap_client->getError();
					}
					else
					{
						$soap_result = $this->nusoap_client->call(
							$this->papyrus['submitQuotation'],
							$params
							);

					}   
				}   

				if ($err_msg=="" && $soap_result['InitQuotationFormResult'] == 'OK') {
					$msg = "Submit completed";
					$state = true;
					$code = '000';
					$output = array();
				} else {
					$state = false;
					$msg = $soap_result['InitQuotationFormResult'];
					$output = array();
				} 

				$result = self::response($state,$code,$msg,$output); 

				if ($result['status']) {
					$this->__ps_project_query->updateObj('tbt_quotation', array('id' => $quotation_id), array('status' => 'WAIT FOR APPROVE'));		            	
					redirect(site_url('__ps_quotation/listview_quotation'), 'refresh');
				} else {

					echo 'Papyrus Error: '.$result['message'].'<hr>';
					echo "<pre>";
					print_r($params);
					echo "</pre>";
				}


			} else {

				echo "Summary for this quotation does not exist.";
			}
		} else {

			echo "Quotation ID does not exist.";
		}
	}

}

function submit_prospect ($id=0) {

	if (!empty($id)) {

		$prospect = $this->__ps_project_query->getObj('tbt_prospect', array( 'id' => $id));

		if (!empty($prospect)) {

			$name = $prospect['sold_to_name1'];
			$name1 = iconv_substr($name, 0, 40, "UTF-8");
			$name2 = iconv_substr($name, 40, 40, "UTF-8");
			$name3 = iconv_substr($name, 80, 40, "UTF-8");
			$name4 = iconv_substr($name, 120, 40, "UTF-8");

			$sap_customer = array(
				'KTOKD'			=> 'Z60',
				'KUNNR'			=> $prospect['id'],
				'BUKRS'			=> '1000',
				'VKORG'			=> '1000',
					'VTWEG'			=> $prospect['distribution_channel'], // Distribution Channel : Default: 11
					'SPART'			=> '11',
					'NAME1' 		=> iconv("UTF-8", "TIS-620",$name1),
					'NAME2' 		=> iconv("UTF-8", "TIS-620",$name2),
					'NAME3' 		=> iconv("UTF-8", "TIS-620",$name3),
					'NAME4' 		=> iconv("UTF-8", "TIS-620",$name4),
					'STR_SUPPL1' 	=> iconv("UTF-8", "TIS-620",$prospect['sold_to_address1']),
					'STR_SUPPL2' 	=> iconv("UTF-8", "TIS-620",$prospect['sold_to_address2']),
					'STR_SUPPL3' 	=> iconv("UTF-8", "TIS-620",$prospect['sold_to_address3']),
					'LOCATION' 		=> iconv("UTF-8", "TIS-620",$prospect['sold_to_address4']),
					'CITY2'			=> iconv("UTF-8", "TIS-620",$prospect['sold_to_district']),
					'POST_CODE1'	=> $prospect['sold_to_postal_code'],
					'CITY1'			=> iconv("UTF-8", "TIS-620",$prospect['sold_to_city']),
					'COUNTRY'		=> $prospect['sold_to_country'],
					'REGION'		=> $prospect['sold_to_region'],
					'LANGU'			=> '2',
					'TEL_NUMBER'	=> $prospect['sold_to_tel'],
					'TEL_EXTENS'    => $prospect['sold_to_tel_ext'],
					'MOB_NUMBER'	=> $prospect['sold_to_mobile'],
					'FAX_NUMBER'	=> $prospect['sold_to_fax'],
					'FAX_EXTENS'	=> $prospect['sold_to_fax_ext'],
					'SMTP_ADDR'		=> $prospect['sold_to_email'],
					'KUKLA'			=> $prospect['sold_to_business_scale'],
					'BRSCH'			=> $prospect['sold_to_industry'],
					'KALKS'			=> '1',
					'VERSG'			=> '1',
					'KZAZU'			=> 'X',
					'VSBED'			=> '01',
					'ANTLF'			=> '2',
					'ZTERM'			=> 'C030', //Term of Payment : Default: Z030
					'KTGRD'			=> 'Z1',
					'TAXKD_01'		=> '1'
					);

$this->db->where('prospect_id', $prospect['id']);
$query = $this->db->get('tbt_contact');
$contact_list = $query->result_array();

$sap_contact_list = array();
if (!empty($contact_list)) {
	foreach ($contact_list as $key => $contact) {

		$sap_contact = array(
			'NAMEV_01'		=> iconv("UTF-8", "TIS-620",$contact['firstname']),
			'NAME1_01'		=> iconv("UTF-8", "TIS-620",$contact['lastname']),
			'ABTNR_01'		=> $contact['department'],
			'PAFKT_01'		=> $contact['function'],
			'TEL_NUMBER'	=> $contact['tel'],
			'TEL_EXTENS'	=> $contact['tel_ext'],
			'MOB_NUMBER'	=> $contact['mobile_no'],
			'FAX_NUMBER'	=> $contact['fax'],
			'FAX_EXTENS'	=> $contact['fax_ext'],
			'SMTP_ADDR'		=> $contact['email']
			);

		array_push($sap_contact_list, $sap_contact);
	}
}	

$partners = array();

if (!empty($prospect['competitor_id'])) {
	$partner1 = array (
		"PARVW" => "ZC",
		"KUNNR"	=> $this->_padZero($prospect['competitor_id'], 10)
		);
	array_push($partners, $partner1);
}

if (!empty($prospect['project_owner_id'])) {
	$partner2 = array(
		"PARVW" => "ZS",
		"KUNNR"	=> $this->_padZero($prospect['project_owner_id'],10)
						// 'KUNNR'		=> $this->_padZero(157,10)
		);
	array_push($partners, $partner2);
}

$input = array(	
	array("TABLE","GT_MESSTAB", array()),
	array("TABLE","T_CUSTOMER", array($sap_customer)),
	array("TABLE","T_CONTACT", $sap_contact_list),
	array("TABLE","T_PARTNER", $partners)
	);

$function = 'ZRFC_CREATE_CUSTOMER';
if (!empty($prospect['submit_date_sap']) && $prospect['submit_date_sap'] != '0000-00-00') {
	$function = 'ZRFC_CHANGE_CUSTOMER';
}

$result = $this->callSAPFunction($function, $input);

				// echo "<pre>";
				// print_r($result);
				// die();

if (!empty($result['GT_MESSTAB'])) {
	foreach ($result['GT_MESSTAB'] as $key => $msg) {
		if ($msg['MSGTYP'] == 'E') {
			echo "Function name : ".$function."<hr>";
			echo "ERROR MSG FROM SAP<Br>";
			echo "<pre>";
			print_r($msg);
			echo "</pre><hr>";
			echo "INPUT<Br>";
			echo "<pre>";
			print_r($input);
			echo "</pre>";

			die();
		}
	}
}

$prospect_data = array(
	'ID' 						=> $prospect['id'],
	'TITLE' 					=> iconv("UTF-8", "TIS-620",$prospect['title']),
	'DISTRIBUTION_CHANNEL' 		=> $prospect['distribution_channel'],
	'JOB_TYPE' 					=> $prospect['job_type'],
	'COMPETITOR_ID' 			=> $prospect['competitor_id'],
	'PROJECT_OWNER_ID' 			=> $prospect['project_owner_id'],
	'CREATE_DATE' 				=> $this->_dateFormat($prospect['create_date']),
	'TIME' 						=> $prospect['time'],
	'UNIT_TIME' 				=> $prospect['unit_time'],
	'REPLACED_BY' 				=> $prospect['replaced_by'],
	'SOLD_TO_NAME1' 			=> iconv("UTF-8", "TIS-620",$name1),
	'SOLD_TO_NAME2' 			=> iconv("UTF-8", "TIS-620",$name2),
	'SOLD_TO_NAME3' 			=> iconv("UTF-8", "TIS-620",$name3),
	'SOLD_TO_NAME4' 			=> iconv("UTF-8", "TIS-620",$name4),
	'SOLD_TO_ADDRESS1' 			=> iconv("UTF-8", "TIS-620",$prospect['sold_to_address1']),
	'SOLD_TO_ADDRESS2' 			=> iconv("UTF-8", "TIS-620",$prospect['sold_to_address2']),
	'SOLD_TO_ADDRESS3' 			=> iconv("UTF-8", "TIS-620",$prospect['sold_to_address3']),
	'SOLD_TO_ADDRESS4' 			=> iconv("UTF-8", "TIS-620",$prospect['sold_to_address4']),
	'SOLD_TO_DISTRICT' 			=> iconv("UTF-8", "TIS-620",$prospect['sold_to_district']),
	'SOLD_TO_CITY' 				=> iconv("UTF-8", "TIS-620",$prospect['sold_to_city']),
	'SOLD_TO_POSTAL_CODE' 		=> $prospect['sold_to_postal_code'],
	'SOLD_TO_COUNTRY' 			=> $prospect['sold_to_country'],
	'SOLD_TO_REGION' 			=> $prospect['sold_to_region'],
	'SOLD_TO_BUSINESS_SCALE' 	=> $prospect['sold_to_business_scale'],
	'SOLD_TO_CUSTOMER_GROUP' 	=> $prospect['sold_to_customer_group'],
	'SOLD_TO_INDUSTRY' 			=> $prospect['sold_to_industry'],
	'SOLD_TO_TELEPHONE' 		=> $prospect['sold_to_tel'],
	'SOLD_TO_TEL_EXT' 			=> $prospect['sold_to_tel_ext'],
	'SOLD_TO_MOBILE' 			=> $prospect['sold_to_mobile'],
	'SOLD_TO_FAX' 				=> $prospect['sold_to_fax'],
	'SOLD_TO_FAX_EXT' 			=> $prospect['sold_to_fax_ext'],
	'SOLD_TO_EMAIL' 			=> $prospect['sold_to_email'],
	);

$contact_data = array();
$contact_list = $this->__ps_project_query->getObj('tbt_contact', array('prospect_id' => $prospect['id']), true);
if (!empty($contact_list)) {
	foreach ($contact_list as $key => $contact) {
		$sap_contact = array(
			'ID'				=> $contact['id'],
			'FIRSTNAME' 		=> iconv("UTF-8", "TIS-620",$contact['firstname']),
			'LASTNAME' 			=> iconv("UTF-8", "TIS-620",$contact['lastname']),
			'DEPARTMENT' 		=> $contact['department'],
			'PHONE_NO' 			=> $contact['phone_no'],
			'PHONE_NO_EXT' 		=> $contact['phone_no_ext'],
			'MOBILE_NO' 		=> $contact['mobile_no'],
			'FAX' 				=> $contact['fax'],
			'FAX_EXT' 			=> $contact['fax_ext'],
			'EMAIL' 			=> $contact['email'],
			'QUOTATION_ID' 		=> $contact['quotation_id'],
			'IS_MAIN_CONTACT'	=> $contact['is_main_contact'],
			'CONTRACT_ID' 		=> $contact['contract_id']
			);	

		array_push($contact_data, $sap_contact);
	}
}

$input = array(	
	array("TABLE","IT_PROSPECT", array($prospect_data)),
	array("TABLE","IT_CONTACT", $contact_data)
	);

$result = $this->callSAPFunction("ZRFC_QUOTATION", $input);

$this->__ps_project_query->updateObj('tbt_prospect', array('id' => $prospect['id']), array('submit_date_sap' => date('Y-m-d')));
}
}

redirect('__ps_quotation/listview_prospect');
}

function del_mass_table () {

	ini_get('max_execution_time');
	ini_set('memory_limit', '5000M');
	set_time_limit (0);

	echo "ZTBT_AS_TRCK<br>";
	$input = array( 
		array("IMPORT","I_MODE","R"),
		array("IMPORT","I_TABLE", "ZTBT_AS_TRCK"),
		array("IMPORT","I_DATE", "20141231"),
		array("TABLE","IT_ZTBT_AS_TRCK", array())
		);

	$result = $this->callSAPFunction("ZRFC_MASS_TABLE", $input);
	if (!empty($result)) {
		$count = 0;
		foreach ($result['IT_ZTBT_AS_TRCK'] as $key => $value) {
			$input = array( 
				array("IMPORT","I_MODE","D"),
				array("IMPORT","I_TABLE", "ZTBT_AS_TRCK"),
				array("TABLE","IT_ZTBT_AS_TRCK", array($value))
				);

			$this->callSAPFunction("ZRFC_MASS_TABLE", $input);

			if ($count == 10) {
				break;
			}
			$count++;
		}
	}

	echo "ZTBT_AS_TRCK_DOC<br>";
	$input = array( 
		array("IMPORT","I_MODE","R"),
		array("IMPORT","I_TABLE", "ZTBT_AS_TRCK_DOC"),
		array("IMPORT","I_DATE", "20141231"),
		array("TABLE","IT_ZTBT_AS_TRCK_DOC", array())
		);

	$result = $this->callSAPFunction("ZRFC_MASS_TABLE", $input);
	if (!empty($result)) {
		$count = 0;
		foreach ($result['IT_ZTBT_AS_TRCK_DOC'] as $key => $value) {
			$input = array( 
				array("IMPORT","I_MODE","D"),
				array("IMPORT","I_TABLE", "ZTBT_AS_TRCK_DOC"),
				array("TABLE","IT_ZTBT_AS_TRCK_DOC", array($value))
				);

			$this->callSAPFunction("ZRFC_MASS_TABLE", $input);

			if ($count == 10) {
				break;
			}
			$count++;
		}
	}

	echo "ZTBT_AS_TRCK_DOC<br>";
	$input = array( 
		array("IMPORT","I_MODE","R"),
		array("IMPORT","I_TABLE", "ZTBT_AS_TRCK_DOC"),
		array("IMPORT","I_DATE", "20141231"),
		array("TABLE","IT_ZTBT_AS_TRCK_DOC", array())
		);

	$result = $this->callSAPFunction("ZRFC_MASS_TABLE", $input);
	if (!empty($result)) {
		$count = 0;
		foreach ($result['IT_ZTBT_AS_TRCK_DOC'] as $key => $value) {
			$input = array( 
				array("IMPORT","I_MODE","D"),
				array("IMPORT","I_TABLE", "ZTBT_AS_TRCK_DOC"),
				array("TABLE","IT_ZTBT_AS_TRCK_DOC", array($value))
				);

			$this->callSAPFunction("ZRFC_MASS_TABLE", $input);

			if ($count == 10) {
				break;
			}
			$count++;
		}
	}

	echo "ZTBT_UNTRCK_AS<br>";
	$input = array( 
		array("IMPORT","I_MODE","R"),
		array("IMPORT","I_TABLE", "ZTBT_UNTRCK_AS"),
		array("IMPORT","I_DATE", "20141231"),
		array("TABLE","IT_ZTBT_UNTRCK_AS", array())
		);

	$result = $this->callSAPFunction("ZRFC_MASS_TABLE", $input);
	if (!empty($result)) {
		$count = 0;
		foreach ($result['IT_ZTBT_UNTRCK_AS'] as $key => $value) {
			$input = array( 
				array("IMPORT","I_MODE","D"),
				array("IMPORT","I_TABLE", "ZTBT_UNTRCK_AS"),
				array("TABLE","IT_ZTBT_UNTRCK_AS", array($value))
				);

			$this->callSAPFunction("ZRFC_MASS_TABLE", $input);

			if ($count == 10) {
				break;
			}
			$count++;
		}
	}

	echo "ZTBT_FIX_CLAIM<br>";
	$input = array( 
		array("IMPORT","I_MODE","R"),
		array("IMPORT","I_TABLE", "ZTBT_FIX_CLAIM"),
		array("IMPORT","I_DATE", "20141231"),
		array("TABLE","IT_ZTBT_FIX_CLAIM", array())
		);

	$result = $this->callSAPFunction("ZRFC_MASS_TABLE", $input);
	if (!empty($result)) {
		$count = 0;
		foreach ($result['IT_ZTBT_FIX_CLAIM'] as $key => $value) {
			$input = array( 
				array("IMPORT","I_MODE","D"),
				array("IMPORT","I_TABLE", "ZTBT_FIX_CLAIM"),
				array("TABLE","IT_ZTBT_FIX_CLAIM", array($value))
				);

			$this->callSAPFunction("ZRFC_MASS_TABLE", $input);

			if ($count == 10) {
				break;
			}
			$count++;
		}
	}

	echo "ZTBT_EMP_TR_DOC<br>";
	$input = array( 
		array("IMPORT","I_MODE","R"),
		array("IMPORT","I_TABLE", "ZTBT_EMP_TR_DOC"),
		array("IMPORT","I_DATE", "20141231"),
		array("TABLE","IT_TBT_EMP_TR_DOC", array())
		);

	$result = $this->callSAPFunction("ZRFC_MASS_TABLE", $input);
	if (!empty($result)) {
		$count = 0;
		foreach ($result['IT_TBT_EMP_TR_DOC'] as $key => $value) {
			$input = array( 
				array("IMPORT","I_MODE","D"),
				array("IMPORT","I_TABLE", "ZTBT_EMP_TR_DOC"),
				array("TABLE","IT_TBT_EMP_TR_DOC", array($value))
				);

			$this->callSAPFunction("ZRFC_MASS_TABLE", $input);

			if ($count == 10) {
				break;
			}
			$count++;
		}
	}

	echo "ZTBT_EMP_TR_STA<br>";
	$input = array( 
		array("IMPORT","I_MODE","R"),
		array("IMPORT","I_TABLE", "ZTBT_EMP_TR_STA"),
		array("IMPORT","I_DATE", "20141231"),
		array("TABLE","IT_TBT_EMP_TR_STA", array())
		);

	$result = $this->callSAPFunction("ZRFC_MASS_TABLE", $input);
	if (!empty($result)) {
		$count = 0;
		foreach ($result['IT_TBT_EMP_TR_STA'] as $key => $value) {
			$input = array( 
				array("IMPORT","I_MODE","D"),
				array("IMPORT","I_TABLE", "ZTBT_EMP_TR_STA"),
				array("TABLE","IT_TBT_EMP_TR_STA", array($value))
				);

			$this->callSAPFunction("ZRFC_MASS_TABLE", $input);

			if ($count == 10) {
				break;
			}
			$count++;
		}
	}

	echo "ZTBT_EMP_TR_RS<br>";
	$input = array( 
		array("IMPORT","I_MODE","R"),
		array("IMPORT","I_TABLE", "ZTBT_EMP_TR_RS"),
		array("IMPORT","I_DATE", "20141231"),
		array("TABLE","IT_TBT_EMP_TR_RS", array())
		);

	$result = $this->callSAPFunction("ZRFC_MASS_TABLE", $input);
	if (!empty($result)) {
		$count = 0;
		foreach ($result['IT_TBT_EMP_TR_RS'] as $key => $value) {
			$input = array( 
				array("IMPORT","I_MODE","D"),
				array("IMPORT","I_TABLE", "ZTBT_EMP_TR_RS"),
				array("TABLE","IT_TBT_EMP_TR_RS", array($value))
				);

			$this->callSAPFunction("ZRFC_MASS_TABLE", $input);

			if ($count == 10) {
				break;
			}
			$count++;
		}
	}

	echo "ZTBT_EMP_TR_S_RE<br>";
	$input = array( 
		array("IMPORT","I_MODE","R"),
		array("IMPORT","I_TABLE", "ZTBT_EMP_TR_S_RE"),
		array("IMPORT","I_DATE", "20141231"),
		array("TABLE","IT_TBT_EMP_TR_S_RE", array())
		);

	$result = $this->callSAPFunction("ZRFC_MASS_TABLE", $input);
	if (!empty($result)) {
		$count = 0;
		foreach ($result['IT_TBT_EMP_TR_S_RE'] as $key => $value) {
			$input = array( 
				array("IMPORT","I_MODE","D"),
				array("IMPORT","I_TABLE", "ZTBT_EMP_TR_S_RE"),
				array("TABLE","IT_TBT_EMP_TR_S_RE", array($value))
				);

			$this->callSAPFunction("ZRFC_MASS_TABLE", $input);

			if ($count == 10) {
				break;
			}
			$count++;
		}
	}

	echo "ZTBT_EMP_TR_Q<br>";
	$input = array( 
		array("IMPORT","I_MODE","R"),
		array("IMPORT","I_TABLE", "ZTBT_EMP_TR_Q"),
		array("IMPORT","I_DATE", "20141231"),
		array("TABLE","IT_TBT_EMP_TR_Q", array())
		);

	$result = $this->callSAPFunction("ZRFC_MASS_TABLE", $input);
	if (!empty($result)) {
		$count = 0;
		foreach ($result['IT_TBT_EMP_TR_Q'] as $key => $value) {
			$input = array( 
				array("IMPORT","I_MODE","D"),
				array("IMPORT","I_TABLE", "ZTBT_EMP_TR_Q"),
				array("TABLE","IT_TBT_EMP_TR_Q", array($value))
				);

			$this->callSAPFunction("ZRFC_MASS_TABLE", $input);

			if ($count == 10) {
				break;
			}
			$count++;
		}
	}

	echo "ZTBT_EMP_TR_S_QS<br>";
	$input = array( 
		array("IMPORT","I_MODE","R"),
		array("IMPORT","I_TABLE", "ZTBT_EMP_TR_S_QS"),
		array("IMPORT","I_DATE", "20141231"),
		array("TABLE","IT_TBT_EMP_TR_S_QS", array())
		);

	$result = $this->callSAPFunction("ZRFC_MASS_TABLE", $input);
	if (!empty($result)) {
		$count = 0;
		foreach ($result['IT_TBT_EMP_TR_S_QS'] as $key => $value) {
			$input = array( 
				array("IMPORT","I_MODE","D"),
				array("IMPORT","I_TABLE", "ZTBT_EMP_TR_S_QS"),
				array("TABLE","IT_TBT_EMP_TR_S_QS", array($value))
				);

			$this->callSAPFunction("ZRFC_MASS_TABLE", $input);

			if ($count == 10) {
				break;
			}
			$count++;
		}
	}

	echo "ZTBM_QTY_S_AREQ<br>";
	$input = array( 
		array("IMPORT","I_MODE","R"),
		array("IMPORT","I_TABLE", "ZTBM_QTY_S_AREQ"),
		array("IMPORT","I_DATE", "20141231"),
		array("TABLE","IT_ZTBM_QTY_S_AREQ", array())
		);

	$result = $this->callSAPFunction("ZRFC_MASS_TABLE", $input);
	if (!empty($result)) {
		$count = 0;
		foreach ($result['IT_ZTBM_QTY_S_AREQ'] as $key => $value) {
			$input = array( 
				array("IMPORT","I_MODE","D"),
				array("IMPORT","I_TABLE", "ZTBM_QTY_S_AREQ"),
				array("TABLE","IT_ZTBM_QTY_S_AREQ", array($value))
				);

			$this->callSAPFunction("ZRFC_MASS_TABLE", $input);

			if ($count == 10) {
				break;
			}
			$count++;
		}
	}

	echo "ZTBM_QTY_S_ARER<br>";
	$input = array( 
		array("IMPORT","I_MODE","R"),
		array("IMPORT","I_TABLE", "ZTBM_QTY_S_ARER"),
		array("IMPORT","I_DATE", "20141231"),
		array("TABLE","IT_ZTBM_QTY_S_ARER", array())
		);

	$result = $this->callSAPFunction("ZRFC_MASS_TABLE", $input);
	if (!empty($result)) {
		$count = 0;
		foreach ($result['IT_ZTBM_QTY_S_ARER'] as $key => $value) {
			$input = array( 
				array("IMPORT","I_MODE","D"),
				array("IMPORT","I_TABLE", "ZTBM_QTY_S_ARER"),
				array("TABLE","IT_ZTBM_QTY_S_ARER", array($value))
				);

			$this->callSAPFunction("ZRFC_MASS_TABLE", $input);

			if ($count == 10) {
				break;
			}
			$count++;
		}
	}

	echo "ZTBM_QTY_S_KPIQ<br>";
	$input = array( 
		array("IMPORT","I_MODE","R"),
		array("IMPORT","I_TABLE", "ZTBM_QTY_S_KPIQ"),
		array("IMPORT","I_DATE", "20141231"),
		array("TABLE","IT_ZTBM_QTY_S_KPIQ", array())
		);

	$result = $this->callSAPFunction("ZRFC_MASS_TABLE", $input);
	if (!empty($result)) {
		$count = 0;
		foreach ($result['IT_ZTBM_QTY_S_KPIQ'] as $key => $value) {
			$input = array( 
				array("IMPORT","I_MODE","D"),
				array("IMPORT","I_TABLE", "ZTBM_QTY_S_KPIQ"),
				array("TABLE","IT_ZTBM_QTY_S_KPIQ", array($value))
				);

			$this->callSAPFunction("ZRFC_MASS_TABLE", $input);

			if ($count == 10) {
				break;
			}
			$count++;
		}
	}

	echo "ZTBM_QTY_S_KPIR<br>";
	$input = array( 
		array("IMPORT","I_MODE","R"),
		array("IMPORT","I_TABLE", "ZTBM_QTY_S_KPIR"),
		array("IMPORT","I_DATE", "20141231"),
		array("TABLE","IT_ZTBM_QTY_S_KPIR", array())
		);

	$result = $this->callSAPFunction("ZRFC_MASS_TABLE", $input);
	if (!empty($result)) {
		$count = 0;
		foreach ($result['IT_ZTBM_QTY_S_KPIR'] as $key => $value) {
			$input = array( 
				array("IMPORT","I_MODE","D"),
				array("IMPORT","I_TABLE", "ZTBM_QTY_S_KPIR"),
				array("TABLE","IT_ZTBM_QTY_S_KPIR", array($value))
				);

			$this->callSAPFunction("ZRFC_MASS_TABLE", $input);

			if ($count == 10) {
				break;
			}
			$count++;
		}
	}

	echo "ZTBM_QTY_S_POLQ<br>";
	$input = array( 
		array("IMPORT","I_MODE","R"),
		array("IMPORT","I_TABLE", "ZTBM_QTY_S_POLQ"),
		array("IMPORT","I_DATE", "20141231"),
		array("TABLE","IT_ZTBM_QTY_S_POLQ", array())
		);

	$result = $this->callSAPFunction("ZRFC_MASS_TABLE", $input);
	if (!empty($result)) {
		$count = 0;
		foreach ($result['IT_ZTBM_QTY_S_POLQ'] as $key => $value) {
			$input = array( 
				array("IMPORT","I_MODE","D"),
				array("IMPORT","I_TABLE", "ZTBM_QTY_S_POLQ"),
				array("TABLE","IT_ZTBM_QTY_S_POLQ", array($value))
				);

			$this->callSAPFunction("ZRFC_MASS_TABLE", $input);

			if ($count == 10) {
				break;
			}
			$count++;
		}
	}

	echo "ZTBM_QTY_S_POLR<br>";
	$input = array( 
		array("IMPORT","I_MODE","R"),
		array("IMPORT","I_TABLE", "ZTBM_QTY_S_POLR"),
		array("IMPORT","I_DATE", "20141231"),
		array("TABLE","IT_ZTBM_QTY_S_POLR", array())
		);

	$result = $this->callSAPFunction("ZRFC_MASS_TABLE", $input);
	if (!empty($result)) {
		$count = 0;
		foreach ($result['IT_ZTBM_QTY_S_POLR'] as $key => $value) {
			$input = array( 
				array("IMPORT","I_MODE","D"),
				array("IMPORT","I_TABLE", "ZTBM_QTY_S_POLR"),
				array("TABLE","IT_ZTBM_QTY_S_POLR", array($value))
				);

			$this->callSAPFunction("ZRFC_MASS_TABLE", $input);

			if ($count == 10) {
				break;
			}
			$count++;
		}
	}

	echo "ZTBM_QTY_S_DOCQ<br>";
	$input = array( 
		array("IMPORT","I_MODE","R"),
		array("IMPORT","I_TABLE", "ZTBM_QTY_S_DOCQ"),
		array("IMPORT","I_DATE", "20141231"),
		array("TABLE","IT_ZTBM_QTY_S_DOCQ", array())
		);

	$result = $this->callSAPFunction("ZRFC_MASS_TABLE", $input);
	if (!empty($result)) {
		$count = 0;
		foreach ($result['IT_ZTBM_QTY_S_DOCQ'] as $key => $value) {
			$input = array( 
				array("IMPORT","I_MODE","D"),
				array("IMPORT","I_TABLE", "ZTBM_QTY_S_DOCQ"),
				array("TABLE","IT_ZTBM_QTY_S_DOCQ", array($value))
				);

			$this->callSAPFunction("ZRFC_MASS_TABLE", $input);

			if ($count == 10) {
				break;
			}
			$count++;
		}
	}

	echo "ZTBM_QTY_S_DOCR<br>";
	$input = array( 
		array("IMPORT","I_MODE","R"),
		array("IMPORT","I_TABLE", "ZTBM_QTY_S_DOCR"),
		array("IMPORT","I_DATE", "20141231"),
		array("TABLE","IT_ZTBM_QTY_S_DOCR", array())
		);

	$result = $this->callSAPFunction("ZRFC_MASS_TABLE", $input);
	if (!empty($result)) {
		$count = 0;
		foreach ($result['IT_ZTBM_QTY_S_DOCR'] as $key => $value) {
			$input = array( 
				array("IMPORT","I_MODE","D"),
				array("IMPORT","I_TABLE", "ZTBM_QTY_S_DOCR"),
				array("TABLE","IT_ZTBM_QTY_S_DOCR", array($value))
				);

			$this->callSAPFunction("ZRFC_MASS_TABLE", $input);

			if ($count == 10) {
				break;
			}
			$count++;
		}
	}

	echo "ZTBM_QTY_S_CUSQ<br>";
	$input = array( 
		array("IMPORT","I_MODE","R"),
		array("IMPORT","I_TABLE", "ZTBM_QTY_S_CUSQ"),
		array("IMPORT","I_DATE", "20141231"),
		array("TABLE","IT_ZTBM_QTY_S_CUSQ", array())
		);

	$result = $this->callSAPFunction("ZRFC_MASS_TABLE", $input);
	if (!empty($result)) {
		$count = 0;
		foreach ($result['IT_ZTBM_QTY_S_CUSQ'] as $key => $value) {
			$input = array( 
				array("IMPORT","I_MODE","D"),
				array("IMPORT","I_TABLE", "ZTBM_QTY_S_CUSQ"),
				array("TABLE","IT_ZTBM_QTY_S_CUSQ", array($value))
				);

			$this->callSAPFunction("ZRFC_MASS_TABLE", $input);

			if ($count == 10) {
				break;
			}
			$count++;
		}
	}

	echo "ZTBM_QTY_S_CUSR<br>";
	$input = array( 
		array("IMPORT","I_MODE","R"),
		array("IMPORT","I_TABLE", "ZTBM_QTY_S_CUSR"),
		array("IMPORT","I_DATE", "20141231"),
		array("TABLE","IT_ZTBM_QTY_S_CUSR", array())
		);

	$result = $this->callSAPFunction("ZRFC_MASS_TABLE", $input);
	if (!empty($result)) {
		$count = 0;
		foreach ($result['IT_ZTBM_QTY_S_CUSR'] as $key => $value) {
			$input = array( 
				array("IMPORT","I_MODE","D"),
				array("IMPORT","I_TABLE", "ZTBM_QTY_S_CUSR"),
				array("TABLE","IT_ZTBM_QTY_S_CUSR", array($value))
				);

			$this->callSAPFunction("ZRFC_MASS_TABLE", $input);

			if ($count == 10) {
				break;
			}
			$count++;
		}
	}

	echo "ZTBM_QTY_S_AREA<br>";
	$input = array( 
		array("IMPORT","I_MODE","R"),
		array("IMPORT","I_TABLE", "ZTBM_QTY_S_AREA"),
		array("IMPORT","I_DATE", "20141231"),
		array("TABLE","IT_ZTBM_QTY_S_AREA", array())
		);

	$result = $this->callSAPFunction("ZRFC_MASS_TABLE", $input);
	if (!empty($result)) {
		$count = 0;
		foreach ($result['IT_ZTBM_QTY_S_AREA'] as $key => $value) {
			$input = array( 
				array("IMPORT","I_MODE","D"),
				array("IMPORT","I_TABLE", "ZTBM_QTY_S_AREA"),
				array("TABLE","IT_ZTBM_QTY_S_AREA", array($value))
				);

			$this->callSAPFunction("ZRFC_MASS_TABLE", $input);

			if ($count == 10) {
				break;
			}
			$count++;
		}
	}

	echo "ZTBM_QTY_S<br>";
	$input = array( 
		array("IMPORT","I_MODE","R"),
		array("IMPORT","I_TABLE", "ZTBM_QTY_S"),
		array("IMPORT","I_DATE", "20141231"),
		array("TABLE","IT_ZTBM_QTY_S", array())
		);

	$result = $this->callSAPFunction("ZRFC_MASS_TABLE", $input);
	if (!empty($result)) {
		$count = 0;
		foreach ($result['IT_ZTBM_QTY_S'] as $key => $value) {
			$input = array( 
				array("IMPORT","I_MODE","D"),
				array("IMPORT","I_TABLE", "ZTBM_QTY_S"),
				array("TABLE","IT_ZTBM_QTY_S", array($value))
				);

			$this->callSAPFunction("ZRFC_MASS_TABLE", $input);

			if ($count == 10) {
				break;
			}
			$count++;
		}
	}

	echo "ZTBT_VISITATION<br>";
	$input = array( 
		array("IMPORT","I_MODE","R"),
		array("IMPORT","I_TABLE", "ZTBT_VISITATION"),
		array("IMPORT","I_DATE", "20141231"),
		array("TABLE","IT_ZTBT_VISITATION", array())
		);

	$result = $this->callSAPFunction("ZRFC_MASS_TABLE", $input);
	if (!empty($result)) {
		$count = 0;
		foreach ($result['IT_ZTBT_VISITATION'] as $key => $value) {
			$input = array( 
				array("IMPORT","I_MODE","D"),
				array("IMPORT","I_TABLE", "ZTBT_VISITATION"),
				array("TABLE","IT_ZTBT_VISITATION", array($value))
				);

			$this->callSAPFunction("ZRFC_MASS_TABLE", $input);

			if ($count == 10) {
				break;
			}
			$count++;
		}
	}

}

function autoSubmit () {

	$log_date_format = $this->config->item('log_date_format');

	$error_directory = "c:\\SumbitToSAP\\Auto";
	$error_logFilename = "LogSAP_".date('Ymd', time()).'.txt';
	$filename = $error_directory.$error_logFilename; 

	if (!file_exists($error_directory)) {
		mkdir($error_directory, 0777, true);
	}

	if(!file_exists($filename)){
		$myfile = fopen($filename, "w") or die("Unable to open file!");
		fwrite($myfile, 'Log file submit quotation to SAP', "\n");
		fclose($myfile);
	}
	$where_arr = array(
		'status' 		   => 'EFFECTIVE',
		'is_submit_to_sap' => 0
		);

	$this->db->where($where_arr);
	$query = $this->db->get('tbt_quotation');
	$quotation_list = $query->result_array();

	if (!empty($quotation_list)) {
		foreach ($quotation_list as $key => $quotation) {
			$is_submit = 0;
				//Run submit_to_sap function; return is_submit
			$result = $this->_submitSap($quotation['id']);
			if(!empty($result)){
				$msg = date($log_date_format, time())." ".$quotation['id']." ".$result."\n" ;
				file_put_contents($filename, $msg, FILE_APPEND | LOCK_EX);
			}
		}
	}
}


public function loadAreaDoc($quotation_id, $lang='th'){

	$filename = "QuotationArea.csv";

	header('Content-Encoding: UTF-8');
	header("Content-type: application/csv");
	header('Content-Disposition: attachment; filename='.$filename);
	header("Pragma: no-cache");
	header("Expires: 0");

	$list = array();

	if ($lang == 'th') {

		$txt = 'อาคาร,ชั้น,พื้นที่บริการ,ชื่อพื้นที่บริการ,ลักษณะพื้น,จำนวน ตรม.';
		array_push($list, $txt);

		$result = $this->__quotation_model->getAreaDetail($quotation_id);

		if (!empty($result)) {
			$texture_arr = array();

			foreach ($result as $key => $value) {

				$building 					= (!empty($value['building'])) ? ''.$value['building'].'' : '';
				$floor 						= (!empty($value['floor'])) ? ''.$value['floor'].'' : '';
				$industry_room_description  = (!empty($value['industry_room_description'])) ? ''.$value['industry_room_description'].'' : '';
				$title 						= (!empty($value['title'])) ? ''.$value['title'].'' : '';
				$texture_description 		= (!empty($value['texture_description'])) ? ''.$value['texture_description'].'' : '';
				$space 						= $value['space'];

				$txt = $building;
				$txt .= ",".$floor;
				$txt .= ",".$industry_room_description;
				$txt .= ",".$title;
				$txt .= ",".$texture_description;
				$txt .= ",".$space;

				array_push($list, $txt);

				if (!array_key_exists($value['texture_id'], $texture_arr)) {
					$texture_arr[$value['texture_id']]['texture_description'] = $value['texture_description'];
					$texture_arr[$value['texture_id']]['space'] = 0;
				}

				$texture_arr[$value['texture_id']]['space'] += floatval($value['space']);
			}

			$txt = 'พื้นที่บริการแบ่งตามลักษณะพื้น';
			array_push($list, $txt);
			$sum_space = 0;
			foreach ($texture_arr as $texture_id => $value) {
				$txt = $value['texture_description'];
				$txt .= ',=';
				$txt .= ','.$value['space'];
				$txt .= ',ตรม.';
				array_push($list, $txt);

				$sum_space += floatval($value['space']);
			}

			$txt = 'รวมพื้นทั้งหมด,=';
			$txt .= ','.$sum_space;
			$txt .= ',ตรม.';
			array_push($list, $txt);
		}

	} else {

		$txt = 'Building,Floor,Area to be Serviced,Floor Surface,Sqm.';
		array_push($list, $txt);

		$result = $this->__quotation_model->getAreaDetail($quotation_id);

		if (!empty($result)) {
			$texture_arr = array();

			foreach ($result as $key => $value) {

				$industry_room = $this->__ps_project_query->getObj('sap_tbm_industry_room_en', array('id' => $value['industry_room_id']));
				$texture = $this->__ps_project_query->getObj('sap_tbm_bomb_en', array('texture_id' => $value['texture_id']));

				$building 					= (!empty($value['building'])) ? ''.$value['building'].'' : '';
				$floor 						= (!empty($value['floor'])) ? ''.$value['floor'].'' : '';
				$industry_room_description  = (!empty($industry_room['title'])) ? ''.$industry_room['title'].'' : '';
				$texture_description 		= (!empty($texture['texture_des'])) ? ''.$texture['texture_des'].'' : '';
				$space 						= $value['space'];

				$txt = $building;
				$txt .= ",".$floor;
				$txt .= ",".$industry_room_description;
				$txt .= ",".$texture_description;
				$txt .= ",".$space;

				array_push($list, $txt);

				if (!array_key_exists($value['texture_id'], $texture_arr)) {
					$texture_arr[$value['texture_id']]['texture_description'] = (!empty($texture['texture_des'])) ? ''.$texture['texture_des'].'' : '';
					$texture_arr[$value['texture_id']]['space'] = 0;
				}

				$texture_arr[$value['texture_id']]['space'] += floatval($value['space']);
			}

			array_push($list, $txt);
			$sum_space = 0;
			foreach ($texture_arr as $texture_id => $value) {
				$txt = $value['texture_description'];
				$txt .= ',=';
				$txt .= ','.$value['space'];
				$txt .= ',sqm.';
				array_push($list, $txt);

				$sum_space += floatval($value['space']);
			}

			$txt = 'Grand total,=';
			$txt .= ','.$sum_space;
			$txt .= ',sqm.';
			array_push($list, $txt);
		}
	}

        echo "\xEF\xBB\xBF"; // UTF-8 BOM
        $file = fopen('php://output', 'w');
        foreach ($list as $line)
        {
        	fputcsv($file, explode(",", $line));
        }

        fclose($file);

    }


    public function loadStaffDoc($quotation_id, $lang='th'){ 

    	$filename = "QuotationStaff.csv";

    	header('Content-Encoding: UTF-8');
    	header("Content-type: application/csv");
    	header('Content-Disposition: attachment; filename='.$filename);
    	header("Pragma: no-cache");
    	header("Expires: 0");

    	$list = array();

    	if ($lang == 'th') {

    		$txt = 'วันทำงาน,เวลาปฏิบัติงาน,จำนวนพนักงาน';
    		array_push($list, $txt);

    		$day_map = array(
    			'MON' => 'จันทร์',
    			'TUE' => 'อังคาร',
    			'WED' => 'พุธ',
    			'THU' => 'พฤหัส',
    			'FRI' => 'ศุกร์',
    			'SAT' => 'เสาร์',
    			'SUN' => 'อาทิตย์',
    			'HOL' => 'นักขัตฤกษ์'
    			);

    		$result = $this->__ps_project_query->getObj('tbt_man_subgroup', array('quotation_id' => $quotation_id), true);

    		if (!empty($result)) {
    			foreach ($result as $key => $value) {
    				$day = '';
    				$day_arr = array();

    				if (!empty($value['day'])) {
    					$day_arr = unserialize($value['day']);
    				}

    				if (!empty($day_arr)) {
    					foreach ($day_arr as $day_val) {
    						if (empty($day)) {
    							$day = $day_map[$day_val];
    						} else {
    							$day .= ' | '.$day_map[$day_val];
    						}
    					}
    				}

    				$txt = $day.','.substr($value['time_in'], 0, 5).' - '.substr($value['time_out'], 0, 5).','.$value['total'];
    				array_push($list, $txt);
	        		// echo $day;
    			}
    		}

    	} else {

    		$txt = 'Working Day,Workind Time,Amount of Employee';
    		array_push($list, $txt);

    		$day_map = array(
    			'MON' => 'Monday',
    			'TUE' => 'Tuesday',
    			'WED' => 'Wednesday',
    			'THU' => 'Thursday',
    			'FRI' => 'Friday',
    			'SAT' => 'Saturday',
    			'SUN' => 'Sunday',
    			'HOL' => 'Holiday'
    			);

    		$result = $this->__ps_project_query->getObj('tbt_man_subgroup', array('quotation_id' => $quotation_id), true);

    		if (!empty($result)) {
    			foreach ($result as $key => $value) {
    				$day = '';
    				$day_arr = array();

    				if (!empty($value['day'])) {
    					$day_arr = unserialize($value['day']);
    				}

    				if (!empty($day_arr)) {
    					foreach ($day_arr as $day_val) {
    						if (empty($day)) {
    							$day = $day_map[$day_val];
    						} else {
    							$day .= ' | '.$day_map[$day_val];
    						}
    					}
    				}

    				$txt = $day.','.substr($value['time_in'], 0, 5).' - '.substr($value['time_out'], 0, 5).','.$value['total'];
    				array_push($list, $txt);
	        		// echo $day;
    			}
    		}

    	}

        echo "\xEF\xBB\xBF"; // UTF-8 BOM
        $file = fopen('php://output', 'w');
        foreach ($list as $line)
        {
        	fputcsv($file, explode(",", $line));
        }

        fclose($file);
    }

    function downloadDetailDoc ($quotation_id) {


    	$quotation = $this->__ps_project_query->getObj('tbt_quotation', array('id' => $quotation_id));
    	$doc       = $this->__ps_project_query->getObj('cms_document_other', array('industry_id' => $quotation['ship_to_industry']));

    	if (!empty($doc)) {
    		$file = $doc['path'];
    		header("Cache-Control: public");
    		header("Content-Description: File Transfer");
    		header("Content-Disposition: attachment; filename=".$doc['description']);
    		header("Content-Type: application/zip");
    		header("Content-Transfer-Encoding: binary");
    		readfile($file);
    	} else {
    		redirect(site_url('__ps_quotation/detail_quotation/view_quotation/'.$quotation_id));
    	}
    }

    function downloadDetailDocEn ($quotation_id) {


    	$quotation = $this->__ps_project_query->getObj('tbt_quotation', array('id' => $quotation_id));
    	$doc       = $this->__ps_project_query->getObj('cms_document_other_en', array('industry_id' => $quotation['ship_to_industry']));

    	if (!empty($doc)) {
    		$file = $doc['path'];
    		header("Cache-Control: public");
    		header("Content-Description: File Transfer");
    		header("Content-Disposition: attachment; filename=".$doc['description']);
    		header("Content-Type: application/zip");
    		header("Content-Transfer-Encoding: binary");
    		readfile($file);
    	} else {
    		redirect(site_url('__ps_quotation/detail_quotation/view_quotation/'.$quotation_id));
    	}
    }

    function ext_open_1qt ($strQuotations= '') {
    	if(time()>1443571200)die('Function has expired');
    	$quotation_list = explode('-', $strQuotations) ;
    	if (!empty($quotation_list)) {
    		foreach ($quotation_list as $key => $quotation) {
    			$quotation_id = '';
    			if(is_array($quotation)){
    				$quotation_id = $quotation['id'];
    			}else{
    				$quotation_id = $quotation;
    			}

    			$sqlx = "UPDATE  `psgen_2014_900`.`tbt_quotation` SET  `is_approve` =  '0', `is_submit_to_sap` =  '0', `status` =  'OPEN', `is_go_live` =  '0' WHERE  `tbt_quotation`.`id` in ('".$quotation_id."');";
    			$res = $this->db->query($sqlx);

    			if($res){
    				echo $quotation_id.' >> Open success <br>';
    			}
    		}
    	}
    }


    function ext_submit_1qt ($strQuotations= '') {
    	if(time()>1443571200)die('Function has expired');
    	$log_date_format = $this->config->item('log_date_format');
    	
    	$error_directory = "c:\\SumbitToSAP\\";
    	$error_logFilename = "ext_LogSAP_".date('Ymd', time()).'.txt';
    	$filename = $error_directory.$error_logFilename; 

    	if (!file_exists($error_directory)) {
    		mkdir($error_directory, 0777, true);
    	}

    	if(!file_exists($filename)){
    		$myfile = fopen($filename, "w") or die("Unable to open file!");
    		fwrite($myfile, 'Log file submit quotation to SAP', "\r\n");
    		fclose($myfile);
    	}
     //$strQuotations = "1115119800|1115119700|1115119600|1115119200|1115121100|1115106900|1115062200|1115061300|1115087600|1115098900|1115091800|1115075800|1115118300|1115097100|1115094500|1115109200|1115094400|1115072700|1115096400|1115072600|1115089500";
    	$quotation_list = explode('-', $strQuotations) ;
     // $quotation_list = array("0" => array("id"=>"1115033400"));

     // $msg = date($log_date_format, time())." "."\n" ;
     // file_put_contents($filename, $msg, FILE_APPEND | LOCK_EX);

    	if (!empty($quotation_list)) {
    		foreach ($quotation_list as $key => $quotation) {
    			$quotation_id = '';
    			if(is_array($quotation)){
    				$quotation_id = $quotation['id'];
    			}else{
    				$quotation_id = $quotation;
    			}
       // echo $quotation_id."<br>";
    			$sqlx = "update tbt_quotation qt INNER JOIN (SELECT sap_tbm_ship_to.id,sap_tbm_ship_to.ship_to_distribution_channel ,subq_shipto.qid,subq_shipto.qtitle FROM sap_tbm_ship_to LEFT JOIN (SELECT tbt_quotation.id as qid,tbt_quotation.title as qtitle,tbt_quotation.ship_to_id FROM `tbt_quotation`) subq_shipto ON subq_shipto.ship_to_id = sap_tbm_ship_to.id WHERE subq_shipto.qid in ('".$quotation_id."'))shipx ON shipx.id = qt.ship_to_id set qt.distribution_channel = shipx.ship_to_distribution_channel WHERE qt.id in ('".$quotation_id."');";
    			$this->db->query($sqlx);

    			$is_submit = 0;
    			$result = $this->_submitSap($quotation_id);
    			if(!empty($result)){
    				if($result == "1" || strpos(trim($result), 'already exists') > 0){
    					$this->db->where('id', $quotation_id);
    					$this->db->update('tbt_quotation', array('is_approve'=> 1, 'is_go_live'=>1, 'status' => 'EFFECTIVE'));
    				}
    				$msg = date($log_date_format, time())." ".$quotation_id." ".$result."\r\n" ;        
    				echo $quotation_id.' >> '.$msg."<br>";
    				file_put_contents($filename, $msg, FILE_APPEND | LOCK_EX);
    			}
    		}
    	}
    }//end ext function

    function SubmitQuotationListToSAP ($strQuotations= '') {
    	$log_date_format = $this->config->item('log_date_format');
    	
    	$error_directory = "c:\\SumbitToSAP\\";
    	$error_logFilename = "LogSAP_".date('Ymd', time()).'.txt';
    	$filename = $error_directory.$error_logFilename; 

    	if (!file_exists($error_directory)) {
    		mkdir($error_directory, 0777, true);
    	}

    	if(!file_exists($filename)){
    		$myfile = fopen($filename, "w") or die("Unable to open file!");
    		fwrite($myfile, 'Log file submit quotation to SAP', "\r\n");
    		fclose($myfile);
    	}
    	$strQuotations = "1115087200|1115087600|1115090800|1115072300|1115069700|1115073200|1115077701|1115108300|1115073800|1115068400|1115085700|1115063400|1115083000|1115066000|1115105100|1115062700|1115115000|1115103600|1115071000|1115097000|1115095500|1115102000|1115088100|1115078900|1115080100|1115075700|1115099400|1115105900|1115098700|1115080800|1115080900|1115079600|1115078400|1115104800|1115104400|1115066700|1115065200|1115106600|1115066900|1115098300|1115068200|1115065700|1115068100|1115084000|1115089700|1115061000|1115064700|1115105600|1115090200|1115104900|1115062500|1115097900|1115104100|1115065300|1115104000|1115077300|1115086700|1115101700|1115108000|1115108800|1115096300|1115107600|1115107400|1115095300|1115107000|1115082600|1115106400|1115109300|1115116800|1115079000|1115106100|1115105200|1115102400|1115077000|1115072900|1115065200|1115080000|1115073400|1115083100|1115097200|1115076800|1115106800|1115094700|1115081500|1115077200|1115101800|1115073500|1115092100|1115073600|1115088200|1115091000|1115080300|1115105500|1115085600|1115082300|1115064900|1115061700|1115061600";
    	$quotation_list = explode('|', $strQuotations) ;
    	// $quotation_list = array("0" => array("id"=>"1115033400"));

    	// $msg = date($log_date_format, time())." "."\n" ;
    	// file_put_contents($filename, $msg, FILE_APPEND | LOCK_EX);

    	if (!empty($quotation_list)) {
    		foreach ($quotation_list as $key => $quotation) {
    			$quotation_id = '';
    			if(is_array($quotation)){
    				$quotation_id = $quotation['id'];
    			}else{
    				$quotation_id = $quotation;
    			}
    			echo $quotation_id."<br>";
    			$is_submit = 0;
    			$result = $this->_submitSap($quotation_id);
    			if(!empty($result)){
    				if($result == "1" || strpos(trim($result), 'already exists') > 0){
    					$this->db->where('id', $quotation_id);
    					$this->db->update('tbt_quotation', array('is_approve'=> 1, 'is_go_live'=>1, 'status' => 'EFFECTIVE'));
    				}
    				$msg = date($log_date_format, time())." ".$quotation_id." ".$result."\r\n" ;    				
    				file_put_contents($filename, $msg, FILE_APPEND | LOCK_EX);
    			}
    		}
    	}
    }
}//end __ps_asset_Track
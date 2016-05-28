<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Base_url extends Admin_Controller {

	function __construct(){
		parent::__construct();

        $this->permission_check('complain');

		//TODO :: Move this to admin controller later 

		#CMS
		$this->pageSize = PAGESIZE;
		$this->table = '';
		$this->page_id = 'ps_generation';
		$this->page_title = freetext('base');
		$this->page_object = 'Page';
		$this->page_controller = 'Base_url';

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
	function index($id=''){
		
		//GET :: project id
		$this->project_id  = $id;
		//echo $this->project_id;	

		//TODO :: redirecting to listview
		//redirect(site_url('__ps_fix_claim/listview/list/'.$this->project_id), 'refresh');
		redirect(site_url('__ps_complain/listview/'.$id=0), 'refresh');
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



	function listview($id){
		$this->quotation_id  = $id;
		
		$newValue = array('current_url'=> site_url($this->uri->uri_string()) );
		$this->session->set_userdata($newValue);
		
		//$this->load->model('__complain_model');

		// $this->tab = 1;
		// $this->function = 'listview_prospect';
		$data = array();
		$list = array();
		 $this->load->model('__quotation_model','quotation');
		 $list['query_quotation'] = $this->quotation->get_quotationByid($this->quotation_id);
		//$modal_data = array();
		//$list_project = array();		

			//$list = $this->__complain_model->getContentList_complain($page);
			//$modal_data['bapi_sold_to'] = $this->__complain_model->sap_tbm_sold_to();
			//$modal_data['bapi_distribution'] = $this->__complain_model->sap_tbm_distribution_channel();	



		$menuConfig = array('page_id'=>1);

		
		//$data['modal'] = $this->load->view('__baseurl/page/list_modal',$modal_data,true);//return view as data

		//Load top menu
		$data['top_menu'] = $this->load->view('__projects/include/top',$menuConfig,true);

		//Load side menu
	    $user_department = $this->session->userdata('department');
	    $user_department_id = array_keys($user_department);
        $side_data['module_list'] = array();
        $module_list = $this->module_model->getModuleList();
        if (!empty($module_list)) {
          foreach ($module_list as $key => $module) {
            $dept_list = $this->__ps_project_query->getObj('tbm_department_module', array('module_id' => $module['id']), true);
            if (!empty($dept_list)) {
              foreach ($dept_list as $dept) {
                if (in_array($dept['department_id'], $user_department_id) && $module['is_active'] == 1 && $module['is_main_menu'] == 1) {
                  $side_data['module_list'][$module['id']] = $module;
                }
              }
            }
          }
        }
		//$data['side_menu'] = $this->load->view('__projects/include/side',$side_data,true);

		$info = '';
		//$data['top_project'] = $this->load->view('__quotation/include/top_project',$info,true);

		//Load body
		$data['body'] = $this->load->view('__baseurl/page/list_bodycfg',$list,true);

		//Load footage script
		$data['footage_script'] = '';


		$this->load->view('__baseurl/layout/list',$data);
	}








	function detail_url($act='',$id=0){

		//get job_type ====
		$this->load->model('__quotation_model','quotation');
		 $query_quotation = $this->quotation->get_quotationByid($id);
		 $data_job_type = $query_quotation->row_array();
		 if(!empty($data_job_type)){      
		     $job_type  = $data_job_type['job_type'];  
		     $this->job_type  = $job_type;
		  }else{
		     $job_type ='';
		     $this->job_type  = '';  
		 }
		//end : get job_type ======


	switch ($act) { // to tbt_proto_item
		case 'data_customer':
		//TODO ::  QEURY DATA QUOTATION
		 $this->quotation_id  = $id;
		 $this->act = $act;
		 //#############  Query #########################################################################
		 $this->load->model('__complain_model','complain');
		 $this->load->model('__quotation_model','quotation');
		 $list['query_quotation'] = $this->quotation->get_quotationByid($this->quotation_id);
		 $list['bapi_competitor'] = $this->quotation->sap_tbm_competitor();
		 $list['query_contact'] = $this->quotation->get_contact_quotation($this->quotation_id);
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
		    $user_department = $this->session->userdata('department');
		    $user_department_id = array_keys($user_department);
	        $side_data['module_list'] = array();
	        $module_list = $this->module_model->getModuleList();
	        if (!empty($module_list)) {
	          foreach ($module_list as $key => $module) {
	            $dept_list = $this->__ps_project_query->getObj('tbm_department_module', array('module_id' => $module['id']), true);
	            if (!empty($dept_list)) {
	              foreach ($dept_list as $dept) {
	                if (in_array($dept['department_id'], $user_department_id) && $module['is_active'] == 1 && $module['is_main_menu'] == 1) {
	                  $side_data['module_list'][$module['id']] = $module;
	                }
	              }
	            }
	          }
	        }
			//$data['side_menu'] = $this->load->view('__projects/include/side',$side_data,true);
			$info = '';
			$data['top_project'] = $this->load->view('__baseurl/include/top_project',$info,true);

			//Load body
			$data['body'] = $this->load->view('__baseurl/page/customer_bodycfg',$list,true);			

			$this->load->view('__baseurl/layout/detail',$data);
		break;

		case 'data_wage':
		//TODO ::  QEURY DATA data_wage
		 $this->quotation_id  = $id;
		 $this->act = $act;
		 // //#############  Query #########################################################################
		 // $this->load->model('__complain_model','complain');
		 // $this->load->model('__quotation_model','quotation');
		 // $list['query_quotation'] = $this->quotation->get_quotationByid($this->quotation_id);
		 // $list['bapi_level_staff'] = $this->quotation->sap_tbm_employee_level();
		 // $list['bapi_position'] = $this->quotation->sap_tbm_position();
		 // $list['bapi_unifrom'] = $this->quotation->get_uniform();
		 // //####################################################################################################
		 //#############  Query #########################################################################
				//Assign parameter for modal
				$this->load->model('__quotation_model','quotation');				
				//$list='';				
				$list['query_other_service'] = $this->quotation->get_other_service_Byqt_id($this->quotation_id);
				$list['query_quotation'] = $this->quotation->get_quotationByid($this->quotation_id);
				$list['query_contact'] = $this->quotation->get_contact_quotation($this->quotation_id);
				//$list['query_main_contract'] = $this->quotation->get_main_contract_Byid('quotation',$this->quotation_id);


				$quotation = $list['query_quotation']->row_array();
				if (empty($quotation)) {
					redirect('__ps_quotation/listview_quotation');
				}
				
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
				$list['bapi_position'] = $this->quotation->sap_tbm_position();
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
				$list['get_customer_request'] = $this->quotation->get_tbt_equipment($this->quotation_id,1);
				
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
		    $user_department = $this->session->userdata('department');
		    $user_department_id = array_keys($user_department);
	        $side_data['module_list'] = array();
	        $module_list = $this->module_model->getModuleList();
	        if (!empty($module_list)) {
	          foreach ($module_list as $key => $module) {
	            $dept_list = $this->__ps_project_query->getObj('tbm_department_module', array('module_id' => $module['id']), true);
	            if (!empty($dept_list)) {
	              foreach ($dept_list as $dept) {
	                if (in_array($dept['department_id'], $user_department_id) && $module['is_active'] == 1 && $module['is_main_menu'] == 1) {
	                  $side_data['module_list'][$module['id']] = $module;
	                }
	              }
	            }
	          }
	        }
			//$data['side_menu'] = $this->load->view('__projects/include/side',$side_data,true);
			$info = '';
			$data['top_project'] = $this->load->view('__baseurl/include/top_project',$info,true);

			//Load body
			$data['body'] = $this->load->view('__baseurl/page/wage_bodycfg',$list,true);			

			$this->load->view('__baseurl/layout/list',$data);
		break;

		case 'data_staff':
		//TODO ::  QEURY DATA QUOTATION
		 $this->quotation_id  = $id;
		 $this->act = $act;
		 //#############  Query #########################################################################
		 $this->load->model('__complain_model','complain');
		 $this->load->model('__quotation_model','quotation');

		 $quotation = $this->__ps_project_query->getObj('tbt_quotation', array('id' => $id));

		 $list['query_quotation'] = $this->quotation->get_quotationByid($this->quotation_id);
		 $list['bapi_level_staff'] = $this->quotation->sap_tbm_employee_level();
		 $list['bapi_position'] = $this->quotation->sap_tbm_position($quotation['ship_to_id']);
		 $list['bapi_unifrom'] = $this->quotation->get_uniform();
		 //== get get_tbt_equipment_clearjob ==
		$list['get_clearing_job'] = $this->quotation->get_tbt_equipment_clearjob($this->quotation_id);
		$list['get_area'] = $this->quotation->get_area_Byid($this->quotation_id);
		$list['bapi_chemical_Z001'] = $this->quotation->bapi_chemical_Z001($this->job_type);	
		$list['bapi_chemical_Z013'] = $this->quotation->bapi_chemical_Z013($this->job_type);
		 //####################################################################################################		

			//Load top menu
			$data['top_menu'] = $this->load->view('__projects/include/top',$menuConfig,true);

			//Load side menu
		    $user_department = $this->session->userdata('department');
		    $user_department_id = array_keys($user_department);
	        $side_data['module_list'] = array();
	        $module_list = $this->module_model->getModuleList();
	        if (!empty($module_list)) {
	          foreach ($module_list as $key => $module) {
	            $dept_list = $this->__ps_project_query->getObj('tbm_department_module', array('module_id' => $module['id']), true);
	            if (!empty($dept_list)) {
	              foreach ($dept_list as $dept) {
	                if (in_array($dept['department_id'], $user_department_id) && $module['is_active'] == 1 && $module['is_main_menu'] == 1) {
	                  $side_data['module_list'][$module['id']] = $module;
	                }
	              }
	            }
	          }
	        }
			//$data['side_menu'] = $this->load->view('__projects/include/side',$side_data,true);
			$info = '';
			$data['top_project'] = $this->load->view('__baseurl/include/top_project',$info,true);

			//Load body
			$data['body'] = $this->load->view('__baseurl/page/staff_bodycfg',$list,true);			

			$this->load->view('__baseurl/layout/detail',$data);
		break;

		case 'data_chemical':
		//TODO ::  QEURY DATA QUOTATION
		 $this->quotation_id  = $id;
		 $this->act = $act;
		 //#############  Query #########################################################################
		 $this->load->model('__quotation_model','quotation');
		 $list['query_quotation'] = $this->quotation->get_quotationByid($this->quotation_id);
		 //get data to db chemical no request
		 $list['get_db_chemical'] = $this->quotation->get_tbt_equipment($this->quotation_id,0);

		 //get data to db get_customer_request
		 $list['get_customer_request'] = $this->quotation->get_tbt_equipment($this->quotation_id,1);
		
		 //== get get_tbt_equipment_clearjob ==
		 $list['get_clearing_job'] = $this->quotation->get_tbt_equipment_clearjob($this->quotation_id);

		 // === get bpi area ===
		$list['bapi_area'] = $this->quotation->sap_tbm_industry_room();
		$list['bapi_texture'] = $this->quotation->bapi_texture();
		$list['get_area'] = $this->quotation->get_area_Byid($this->quotation_id);

		//== get bapi checmical  ===
		$list['bapi_mat_group'] = $this->quotation->get_sap_tbm_mat_group($this->job_type);
		$list['bapi_chemical_Z001'] = $this->quotation->bapi_chemical_Z001($this->job_type);
		$list['bapi_chemical_Z013'] = $this->quotation->bapi_chemical_Z013($this->job_type);
		$list['bapi_machine'] = $this->quotation->bapi_machine();
		$list['bapi_tool_Z002'] = $this->quotation->bapi_tool_Z002($this->job_type);
		$list['bapi_tool_Z014'] = $this->quotation->bapi_tool_Z014($this->job_type);
		 //####################################################################################################				

			//Load top menu
			$data['top_menu'] = $this->load->view('__projects/include/top',$menuConfig,true);

			//Load side menu
		    $user_department = $this->session->userdata('department');
		    $user_department_id = array_keys($user_department);
	        $side_data['module_list'] = array();
	        $module_list = $this->module_model->getModuleList();
	        if (!empty($module_list)) {
	          foreach ($module_list as $key => $module) {
	            $dept_list = $this->__ps_project_query->getObj('tbm_department_module', array('module_id' => $module['id']), true);
	            if (!empty($dept_list)) {
	              foreach ($dept_list as $dept) {
	                if (in_array($dept['department_id'], $user_department_id) && $module['is_active'] == 1 && $module['is_main_menu'] == 1) {
	                  $side_data['module_list'][$module['id']] = $module;
	                }
	              }
	            }
	          }
	        }
			//$data['side_menu'] = $this->load->view('__projects/include/side',$side_data,true);
			$info = '';
			$data['top_project'] = $this->load->view('__baseurl/include/top_project',$info,true);

			//Load body
			$data['body'] = $this->load->view('__baseurl/page/chemical_bodycfg',$list,true);			

			$this->load->view('__baseurl/layout/detail',$data);
		break;

		case 'data_tool':
		//TODO ::  QEURY DATA QUOTATION
		 $this->quotation_id  = $id;
		 $this->act = $act;
		 //#############  Query #########################################################################
		 $this->load->model('__quotation_model','quotation');
		 $list['query_quotation'] = $this->quotation->get_quotationByid($this->quotation_id);
		 //get data to db chemical no request
		 $list['get_db_chemical'] = $this->quotation->get_tbt_equipment($this->quotation_id,0);

		 //get data to db get_customer_request
		 $list['get_customer_request'] = $this->quotation->get_tbt_equipment($this->quotation_id,1);
		
		 //== get get_tbt_equipment_clearjob ==
		 $list['get_clearing_job'] = $this->quotation->get_tbt_equipment_clearjob($this->quotation_id);

		 // === get bpi area ===
		$list['bapi_area'] = $this->quotation->sap_tbm_industry_room();
		$list['bapi_texture'] = $this->quotation->bapi_texture();
		$list['get_area'] = $this->quotation->get_area_Byid($this->quotation_id);

		//== get bapi checmical  ===
		$list['bapi_mat_group'] = $this->quotation->get_sap_tbm_mat_group($this->job_type);
		$list['bapi_chemical_Z001'] = $this->quotation->bapi_chemical_Z001($this->job_type);
		$list['bapi_chemical_Z013'] = $this->quotation->bapi_chemical_Z013($this->job_type);
		$list['bapi_machine'] = $this->quotation->bapi_machine();
		$list['bapi_tool_Z002'] = $this->quotation->bapi_tool_Z002($this->job_type);
		$list['bapi_tool_Z014'] = $this->quotation->bapi_tool_Z014($this->job_type);
		 //####################################################################################################				

			//Load top menu
			$data['top_menu'] = $this->load->view('__projects/include/top',$menuConfig,true);

			//Load side menu
		    $user_department = $this->session->userdata('department');
		    $user_department_id = array_keys($user_department);
	        $side_data['module_list'] = array();
	        $module_list = $this->module_model->getModuleList();
	        if (!empty($module_list)) {
	          foreach ($module_list as $key => $module) {
	            $dept_list = $this->__ps_project_query->getObj('tbm_department_module', array('module_id' => $module['id']), true);
	            if (!empty($dept_list)) {
	              foreach ($dept_list as $dept) {
	                if (in_array($dept['department_id'], $user_department_id) && $module['is_active'] == 1 && $module['is_main_menu'] == 1) {
	                  $side_data['module_list'][$module['id']] = $module;
	                }
	              }
	            }
	          }
	        }
			//$data['side_menu'] = $this->load->view('__projects/include/side',$side_data,true);
			$info = '';
			$data['top_project'] = $this->load->view('__baseurl/include/top_project',$info,true);

			//Load body
			$data['body'] = $this->load->view('__baseurl/page/tool_bodycfg',$list,true);			

			$this->load->view('__baseurl/layout/detail',$data);
		break;

		case 'data_asset':
		//TODO ::  QEURY DATA QUOTATION
		 $this->quotation_id  = $id;
		 $this->act = $act;
		  //#############  Query #########################################################################
		 $this->load->model('__quotation_model','quotation');
		 $list['query_quotation'] = $this->quotation->get_quotationByid($this->quotation_id);
		 //get data to db chemical no request
		 $list['get_db_chemical'] = $this->quotation->get_tbt_equipment($this->quotation_id,0);

		 //get data to db get_customer_request
		 $list['get_customer_request'] = $this->quotation->get_tbt_equipment($this->quotation_id,1);
		
		 //== get get_tbt_equipment_clearjob ==
		 $list['get_clearing_job'] = $this->quotation->get_tbt_equipment_clearjob($this->quotation_id);

		 // === get bpi area ===
		$list['bapi_area'] = $this->quotation->sap_tbm_industry_room();
		$list['bapi_texture'] = $this->quotation->bapi_texture();
		$list['get_area'] = $this->quotation->get_area_Byid($this->quotation_id);

		//== get bapi checmical  ===
		$list['bapi_mat_group'] = $this->quotation->get_sap_tbm_mat_group($this->job_type);
		$list['bapi_chemical_Z001'] = $this->quotation->bapi_chemical_Z001($this->job_type);
		$list['bapi_chemical_Z013'] = $this->quotation->bapi_chemical_Z013($this->job_type);
		$list['bapi_machine'] = $this->quotation->bapi_machine();
		$list['bapi_tool_Z002'] = $this->quotation->bapi_tool_Z002($this->job_type);
		$list['bapi_tool_Z014'] = $this->quotation->bapi_tool_Z014($this->job_type);
		 //####################################################################################################				

			//Load top menu
			$data['top_menu'] = $this->load->view('__projects/include/top',$menuConfig,true);

			//Load side menu
		    $user_department = $this->session->userdata('department');
		    $user_department_id = array_keys($user_department);
	        $side_data['module_list'] = array();
	        $module_list = $this->module_model->getModuleList();
	        if (!empty($module_list)) {
	          foreach ($module_list as $key => $module) {
	            $dept_list = $this->__ps_project_query->getObj('tbm_department_module', array('module_id' => $module['id']), true);
	            if (!empty($dept_list)) {
	              foreach ($dept_list as $dept) {
	                if (in_array($dept['department_id'], $user_department_id) && $module['is_active'] == 1 && $module['is_main_menu'] == 1) {
	                  $side_data['module_list'][$module['id']] = $module;
	                }
	              }
	            }
	          }
	        }
			//$data['side_menu'] = $this->load->view('__projects/include/side',$side_data,true);
			$info = '';
			$data['top_project'] = $this->load->view('__baseurl/include/top_project',$info,true);

			//Load body
			$data['body'] = $this->load->view('__baseurl/page/asset_bodycfg',$list,true);			

			$this->load->view('__baseurl/layout/detail',$data);
		break;


		case 'data_consumable':
		//TODO ::  QEURY DATA QUOTATION
		 $this->quotation_id  = $id;
		 $this->act = $act;
		   //#############  Query #########################################################################
		 $this->load->model('__quotation_model','quotation');
		 $list['query_quotation'] = $this->quotation->get_quotationByid($this->quotation_id);
		 //get data to db chemical no request
		 $list['get_db_chemical'] = $this->quotation->get_tbt_equipment($this->quotation_id,0);

		 //get data to db get_customer_request
		$list['get_customer_request'] = $this->quotation->get_tbt_equipment($this->quotation_id,1);
		
		 //== get get_tbt_equipment_clearjob ==
		 $list['get_clearing_job'] = $this->quotation->get_tbt_equipment_clearjob($this->quotation_id);

		 // === get bpi area ===
		$list['bapi_area'] = $this->quotation->sap_tbm_industry_room();
		$list['bapi_texture'] = $this->quotation->bapi_texture();
		$list['get_area'] = $this->quotation->get_area_Byid($this->quotation_id);

		//== get bapi checmical  ===
		$list['bapi_mat_group'] = $this->quotation->get_sap_tbm_mat_group($this->job_type);
		$list['bapi_chemical_Z001'] = $this->quotation->bapi_chemical_Z001($this->job_type);
		$list['bapi_chemical_Z013'] = $this->quotation->bapi_chemical_Z013($this->job_type);
		$list['bapi_machine'] = $this->quotation->bapi_machine();
		$list['bapi_tool_Z002'] = $this->quotation->bapi_tool_Z002($this->job_type);
		$list['bapi_tool_Z014'] = $this->quotation->bapi_tool_Z014($this->job_type);
		 //####################################################################################################					

			//Load top menu
			$data['top_menu'] = $this->load->view('__projects/include/top',$menuConfig,true);

			//Load side menu
		    $user_department = $this->session->userdata('department');
		    $user_department_id = array_keys($user_department);
	        $side_data['module_list'] = array();
	        $module_list = $this->module_model->getModuleList();
	        if (!empty($module_list)) {
	          foreach ($module_list as $key => $module) {
	            $dept_list = $this->__ps_project_query->getObj('tbm_department_module', array('module_id' => $module['id']), true);
	            if (!empty($dept_list)) {
	              foreach ($dept_list as $dept) {
	                if (in_array($dept['department_id'], $user_department_id) && $module['is_active'] == 1 && $module['is_main_menu'] == 1) {
	                  $side_data['module_list'][$module['id']] = $module;
	                }
	              }
	            }
	          }
	        }
			//$data['side_menu'] = $this->load->view('__projects/include/side',$side_data,true);
			$info = '';
			$data['top_project'] = $this->load->view('__baseurl/include/top_project',$info,true);

			//Load body
			$data['body'] = $this->load->view('__baseurl/page/consumable_bodycfg',$list,true);			

			$this->load->view('__baseurl/layout/detail',$data);
		break;

		case 'data_consumable':
		//TODO ::  QEURY DATA QUOTATION
		 $this->quotation_id  = $id;
		 $this->act = $act;
		 //#############  Query #########################################################################
		 $this->load->model('__complain_model','complain');
		 $this->load->model('__quotation_model','quotation');
		 $list['query_quotation'] = $this->quotation->get_quotationByid($this->quotation_id);
		 //####################################################################################################				

			//Load top menu
			$data['top_menu'] = $this->load->view('__projects/include/top',$menuConfig,true);

			//Load side menu
		    $user_department = $this->session->userdata('department');
		    $user_department_id = array_keys($user_department);
	        $side_data['module_list'] = array();
	        $module_list = $this->module_model->getModuleList();
	        if (!empty($module_list)) {
	          foreach ($module_list as $key => $module) {
	            $dept_list = $this->__ps_project_query->getObj('tbm_department_module', array('module_id' => $module['id']), true);
	            if (!empty($dept_list)) {
	              foreach ($dept_list as $dept) {
	                if (in_array($dept['department_id'], $user_department_id) && $module['is_active'] == 1 && $module['is_main_menu'] == 1) {
	                  $side_data['module_list'][$module['id']] = $module;
	                }
	              }
	            }
	          }
	        }
			//$data['side_menu'] = $this->load->view('__projects/include/side',$side_data,true);
			$info = '';
			$data['top_project'] = $this->load->view('__baseurl/include/top_project',$info,true);

			//Load body
			$data['body'] = $this->load->view('__baseurl/page/consumable_bodycfg',$list,true);			

			$this->load->view('__baseurl/layout/detail',$data);
		break;


		case 'data_detailService':
		//TODO ::  QEURY DATA QUOTATION
		 $this->quotation_id  = $id;
		 $this->act = $act;
		 //#############  Query #########################################################################
		 $this->load->model('__quotation_model','quotation');
		 $this->load->model('__cms_docother','docother');
		 $list['doc_list'] = $this->docother->getAlldoc();
		 $list['query_quotation'] = $this->quotation->get_quotationByid($this->quotation_id);
		 //####################################################################################################				

			//Load top menu
			$data['top_menu'] = $this->load->view('__projects/include/top',$menuConfig,true);

			//Load side menu
		    $user_department = $this->session->userdata('department');
		    $user_department_id = array_keys($user_department);
	        $side_data['module_list'] = array();
	        $module_list = $this->module_model->getModuleList();
	        if (!empty($module_list)) {
	          foreach ($module_list as $key => $module) {
	            $dept_list = $this->__ps_project_query->getObj('tbm_department_module', array('module_id' => $module['id']), true);
	            if (!empty($dept_list)) {
	              foreach ($dept_list as $dept) {
	                if (in_array($dept['department_id'], $user_department_id) && $module['is_active'] == 1 && $module['is_main_menu'] == 1) {
	                  $side_data['module_list'][$module['id']] = $module;
	                }
	              }
	            }
	          }
	        }
			//$data['side_menu'] = $this->load->view('__projects/include/side',$side_data,true);
			$info = '';
			$data['top_project'] = $this->load->view('__baseurl/include/top_project',$info,true);

			//Load body
			$data['body'] = $this->load->view('__baseurl/page/detailService_bodycfg',$list,true);			

			$this->load->view('__baseurl/layout/detail',$data);
		break;

		case 'data_circulation':
		//TODO ::  QEURY DATA QUOTATION
		 $this->quotation_id  = $id;
		 $this->act = $act;
		 //#############  Query #########################################################################
				//Assign parameter for modal
				$this->load->model('__quotation_model','quotation');				
				//$list='';				
				$list['query_other_service'] = $this->quotation->get_other_service_Byqt_id($this->quotation_id);
				$list['query_quotation'] = $this->quotation->get_quotationByid($this->quotation_id);
				$list['query_contact'] = $this->quotation->get_contact_quotation($this->quotation_id);
				//$list['query_main_contract'] = $this->quotation->get_main_contract_Byid('quotation',$this->quotation_id);


				$quotation = $list['query_quotation']->row_array();
				if (empty($quotation)) {
					redirect('__ps_quotation/listview_quotation');
				}
				
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
				$list['get_customer_request'] = $this->quotation->get_tbt_equipment($this->quotation_id,1);
				
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
		    $user_department = $this->session->userdata('department');
		    $user_department_id = array_keys($user_department);
	        $side_data['module_list'] = array();
	        $module_list = $this->module_model->getModuleList();
	        if (!empty($module_list)) {
	          foreach ($module_list as $key => $module) {
	            $dept_list = $this->__ps_project_query->getObj('tbm_department_module', array('module_id' => $module['id']), true);
	            if (!empty($dept_list)) {
	              foreach ($dept_list as $dept) {
	                if (in_array($dept['department_id'], $user_department_id) && $module['is_active'] == 1 && $module['is_main_menu'] == 1) {
	                  $side_data['module_list'][$module['id']] = $module;
	                }
	              }
	            }
	          }
	        }
			//$data['side_menu'] = $this->load->view('__projects/include/side',$side_data,true);
			$info = '';
			$data['top_project'] = $this->load->view('__baseurl/include/top_project',$info,true);

			//Load body
			$data['body'] = $this->load->view('__baseurl/page/circulation_bodycfg',$list,true);			

			$this->load->view('__baseurl/layout/list',$data);
		break;

		case 'data_contract':
		//TODO ::  QEURY DATA QUOTATION
		 $this->quotation_id  = $id;
		 $this->act = $act;
		 //#############  Query #########################################################################
		 $this->load->model('__complain_model','complain');
		 $this->load->model('__quotation_model','quotation');
		 $list['query_quotation'] = $this->quotation->get_quotationByid($this->quotation_id);
		 //####################################################################################################				

			//Load top menu
			$data['top_menu'] = $this->load->view('__projects/include/top',$menuConfig,true);

			//Load side menu
		    $user_department = $this->session->userdata('department');
		    $user_department_id = array_keys($user_department);
	        $side_data['module_list'] = array();
	        $module_list = $this->module_model->getModuleList();
	        if (!empty($module_list)) {
	          foreach ($module_list as $key => $module) {
	            $dept_list = $this->__ps_project_query->getObj('tbm_department_module', array('module_id' => $module['id']), true);
	            if (!empty($dept_list)) {
	              foreach ($dept_list as $dept) {
	                if (in_array($dept['department_id'], $user_department_id) && $module['is_active'] == 1 && $module['is_main_menu'] == 1) {
	                  $side_data['module_list'][$module['id']] = $module;
	                }
	              }
	            }
	          }
	        }
			//$data['side_menu'] = $this->load->view('__projects/include/side',$side_data,true);
			$info = '';
			$data['top_project'] = $this->load->view('__baseurl/include/top_project',$info,true);

			//Load body
			$data['body'] = $this->load->view('__baseurl/page/contract_bodycfg',$list,true);			

			$this->load->view('__baseurl/layout/detail',$data);
		break;


		case 'data_file_docservice':
		//TODO ::  QEURY DATA QUOTATION
		 $this->quotation_id  = $id;
		 $this->act = $act;
		 //#############  Query #########################################################################
		 $this->load->model('__complain_model','complain');
		 $this->load->model('__quotation_model','quotation');
		 $list['query_quotation'] = $this->quotation->get_quotationByid($this->quotation_id);
		 $list['query_doc_other'] = $this->quotation->get_document_other('quotation',$this->quotation_id);
		 //####################################################################################################				

			//Load top menu
			$data['top_menu'] = $this->load->view('__projects/include/top',$menuConfig,true);

			//Load side menu
		    $user_department = $this->session->userdata('department');
		    $user_department_id = array_keys($user_department);
	        $side_data['module_list'] = array();
	        $module_list = $this->module_model->getModuleList();
	        if (!empty($module_list)) {
	          foreach ($module_list as $key => $module) {
	            $dept_list = $this->__ps_project_query->getObj('tbm_department_module', array('module_id' => $module['id']), true);
	            if (!empty($dept_list)) {
	              foreach ($dept_list as $dept) {
	                if (in_array($dept['department_id'], $user_department_id) && $module['is_active'] == 1 && $module['is_main_menu'] == 1) {
	                  $side_data['module_list'][$module['id']] = $module;
	                }
	              }
	            }
	          }
	        }
			//$data['side_menu'] = $this->load->view('__projects/include/side',$side_data,true);
			$info = '';
			$data['top_project'] = $this->load->view('__baseurl/include/top_project',$info,true);

			//Load body
			$data['body'] = $this->load->view('__baseurl/page/file_docservice_body',$list,true);			

			$this->load->view('__baseurl/layout/detail',$data);
		break;


		case 'data_file_doccustomer':
		//TODO ::  QEURY DATA QUOTATION
		 $this->quotation_id  = $id;
		 $this->act = $act;
		 //#############  Query #########################################################################
		 $this->load->model('__complain_model','complain');
		 $this->load->model('__quotation_model','quotation');
		 $list['query_quotation'] = $this->quotation->get_quotationByid($this->quotation_id);
		 $list['query_doc_importance'] = $this->quotation->get_document_importance('quotation',$this->quotation_id);
		 //####################################################################################################				

			//Load top menu
			$data['top_menu'] = $this->load->view('__projects/include/top',$menuConfig,true);

			//Load side menu
		    $user_department = $this->session->userdata('department');
		    $user_department_id = array_keys($user_department);
	        $side_data['module_list'] = array();
	        $module_list = $this->module_model->getModuleList();
	        if (!empty($module_list)) {
	          foreach ($module_list as $key => $module) {
	            $dept_list = $this->__ps_project_query->getObj('tbm_department_module', array('module_id' => $module['id']), true);
	            if (!empty($dept_list)) {
	              foreach ($dept_list as $dept) {
	                if (in_array($dept['department_id'], $user_department_id) && $module['is_active'] == 1 && $module['is_main_menu'] == 1) {
	                  $side_data['module_list'][$module['id']] = $module;
	                }
	              }
	            }
	          }
	        }
			//$data['side_menu'] = $this->load->view('__projects/include/side',$side_data,true);
			$info = '';
			$data['top_project'] = $this->load->view('__baseurl/include/top_project',$info,true);

			//Load body
			$data['body'] = $this->load->view('__baseurl/page/file_doccustomer_body',$list,true);			

			$this->load->view('__baseurl/layout/detail',$data);
		break;



		case 'data_doc_contract':
		//TODO ::  QEURY DATA QUOTATION
		 $this->quotation_id  = $id;
		 $this->act = $act;
		 //#############  Query #########################################################################
				//Assign parameter for modal
				$this->load->model('__quotation_model','quotation');				
				//$list='';				
				$list['query_other_service'] = $this->quotation->get_other_service_Byqt_id($this->quotation_id);
				$list['query_quotation'] = $this->quotation->get_quotationByid($this->quotation_id);
				$list['query_contact'] = $this->quotation->get_contact_quotation($this->quotation_id);
				//$list['query_main_contract'] = $this->quotation->get_main_contract_Byid('quotation',$this->quotation_id);

				$quotation = $list['query_quotation']->row_array();
				if (empty($quotation)) {
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
				$list['get_customer_request'] = $this->quotation->get_tbt_equipment($this->quotation_id,1);
				
				//get data to db chemical no request
				$list['get_db_chemical'] = $this->quotation->get_tbt_equipment($this->quotation_id,0);
				
				//== get get_tbt_equipment_clearjob ==
				$list['get_clearing_job'] = $this->quotation->get_tbt_equipment_clearjob($this->quotation_id);

				//== get oterh service ==
				$list['bapi_other_service'] = $this->quotation->get_other_service();
				

				$list['staffExist'] = $this->quotation->isStaffExist($this->quotation_id);
				$list['summary_data'] = $this->__ps_project_query->getObj('tbt_summary', array('quotation_id' => $this->quotation_id));
				//####################################################################################################			

			//Load top menu
			$data['top_menu'] = $this->load->view('__projects/include/top',$menuConfig,true);

			//Load side menu
		    $user_department = $this->session->userdata('department');
		    $user_department_id = array_keys($user_department);
	        $side_data['module_list'] = array();
	        $module_list = $this->module_model->getModuleList();
	        if (!empty($module_list)) {
	          foreach ($module_list as $key => $module) {
	            $dept_list = $this->__ps_project_query->getObj('tbm_department_module', array('module_id' => $module['id']), true);
	            if (!empty($dept_list)) {
	              foreach ($dept_list as $dept) {
	                if (in_array($dept['department_id'], $user_department_id) && $module['is_active'] == 1 && $module['is_main_menu'] == 1) {
	                  $side_data['module_list'][$module['id']] = $module;
	                }
	              }
	            }
	          }
	        }
			//$data['side_menu'] = $this->load->view('__projects/include/side',$side_data,true);
			$info = '';
			$data['top_project'] = $this->load->view('__baseurl/include/top_project',$info,true);

			//Load body
			$data['body'] = $this->load->view('__baseurl/page/doc_contract_bodycfg',$list,true);

			//Load footage script
			$data['footage_script'] = $this->load->view('__quotation/script/contract_download_js',$list,true);			

			$this->load->view('__baseurl/layout/detail',$data);
		break;



		
		default:			

		break;
		}
	}



}//end ps_complain
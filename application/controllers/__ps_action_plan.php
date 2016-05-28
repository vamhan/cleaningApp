<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class __ps_action_plan extends Admin_Controller {

	function __construct(){
		parent::__construct();

		$this->permission_check('action_plan');

		//TODO :: Move this to admin controller later 

		$this->load->model('__cms_module', 'module');	
		$this->load->model('__action_plan_model', 'action_plan');	

		#CMS
		$this->pageSize = PAGESIZE;
		$this->table = 'tbt_action_plan';
		$this->page_id = 'ps_generation';
		$this->page_title = 'Action Plan Calendar : PSWEB';
		$this->page_object = 'API';
		$this->page_controller = '__ps_action_plan';

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
	function index(){

		//$list = $this->__action_plan_model->getContentList($page,$id);
		$list = array();

		$list['shipto_list'] = $this->action_plan->allShipTo();

		$list['action_list'] = $this->action_plan->allActionPlan();

		$emp_id = $this->session->userdata('id');
		$department = $this->session->userdata('department');

		// $bapi_distribution_list = $this->__quotation_model->sap_tbm_distribution_channel()->result_array();
		// $child_distribution_channel_list = $this->__ps_project_query->get_child_distribution_channel($this->session->userdata('position'));

		$bapi_distribution_list = $this->__quotation_model->sap_tbm_distribution_channel()->result_array();
		$distribution_channel_list =  $this->session->userdata('distribution_channel');
		$child_distribution_channel_list = $this->__ps_project_query->get_child_distribution_channel($this->session->userdata('position'));
		
		foreach ($child_distribution_channel_list as $key => $child_distribution_channel) {
			if(! in_array($child_distribution_channel['area_id'], $distribution_channel_list)){
				array_push($distribution_channel_list, $child_distribution_channel['area_id']);
			}
		}

		sort($distribution_channel_list);		

		$permission = $this->permission;
		$list['isAllowToCreateVisitation'] = 0;
		if (!empty($permission) && array_key_exists('4', $permission)) {
			$list['isAllowToCreateVisitation'] = 1;
		}

		$list['employee_list'] 	    = $this->action_plan->allEmployee();
		$list['department_list'] 	= $this->action_plan->allDepartment();
		$list['event_category'] 	= $this->action_plan->allEventCategory();
		$list['visit_reason_list']  = $this->action_plan->allVisitReason();		
		$list['visit_connect_list']  = $this->action_plan->allVisitConnect();		
		$list['clear_job_category_list']  = $this->action_plan->allClearCategory();		
		$list['clear_job_type_list']  = $this->action_plan->allClearType();		
		$list['holiday_list']       = $this->holiday->getAllHoliday();
		$list['bapi_distribution_list'] = $bapi_distribution_list;
		$list['distribution_channel_list'] = $distribution_channel_list;

		$menuConfig['page_title'] = 'PS Generation';
		$menuConfig['page_id'] 	  = 'ps_generation';

		$data['modal'] = $this->load->view('__action_plan/page/modal',$list,true);//return view as data

		//Load top menu
		$menuConfig = array('page_id'=>1,'pid'=>$emp_id);
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

		//Load body
		$data['body'] = $this->load->view('__action_plan/page/body',$list,true);

		// //Load footage script
		$data['footage_script'] = $this->load->view('__action_plan/script/calendar_js',$list,true);

		$this->load->view('__action_plan/layout/view',$data);

	}

	function create_action_plan () {
		$p = $this->input->post();		
		if (!empty($p)) {

			$clear_job_type_id = 0;
			$clearjob_frequency = 0;

			if (!empty($p['clear_job_type_id'])) {
				$clear_job_type_id = $p['clear_job_type_id'];
				$clearjob_frequency = $p['frequency'];
			}

			if (empty($p['clear_job_category_id'])) {
				$p['clear_job_category_id'] = 0;
			}
			if (empty($p['total_staff'])) {
				$p['total_staff'] = 0;
			}
			if (empty($p['actual_date'])) {
				$p['actual_date'] = null;
			}
			if (empty($p['prospect_id'])) {
				$p['prospect_id'] = 0;
			}
			if (empty($p['visitation_reason_id'])) {
				$p['visitation_reason_id'] = 0;
			}
			if (empty($p['contact_type'])) {
				$p['contact_type'] = 0;
			}
			if (empty($p['sequence'])) {
				$p['sequence'] = 0;
			}
			if (!array_key_exists('distribution_channel', $p)) {
				$p['distribution_channel'] = '';
			}
			$action_plan_id = $this->createActionPlan($p['plan_date'], $p['event_category_id'], $p['contract_id'], 0, $p['sequence'], $p['title'], $p['remark'], $clear_job_type_id, $clearjob_frequency, $p['clear_job_category_id'], $p['total_staff'], $p['actual_date'], $p['visitation_reason_id'], $p['prospect_id'], $p['contact_type'], $p['distribution_channel']);		
			
		}

		if (!empty($p['url'])) {
			redirect($p['url'], 'refresh');
		} else {
			redirect(site_url('__ps_action_plan/index/', 'refresh'));
		}
	}

	function update_manager_action_plan() {

		$p = $this->input->post();
		if (!empty($p)) {

			$emp_id = $this->session->userdata('id');
			$project = $this->__ps_project_query->getObj('tbt_quotation', array('contract_id' => $p['contract_id']));
			$action_plan = array(
				'title' 		    => $p['title'],
				'event_category_id' => 0,
				'actor_id'			=> $emp_id,
				'plan_date'		 	=> $p['plan_date'],
				'project_id'	 	=> $project['id'],
				'contract_id'		=> $project['contract_id'],
				'ship_to_id'	 	=> $project['ship_to_id'],
				'sold_to_id'	 	=> $project['sold_to_id'],
				'status'			=> 'plan',
				'remark'			=> $p['remark'],
				'is_manager'		=> 1
				);

			$this->__ps_project_query->updateObj('tbt_action_plan', array('id' => $p['id']),  $action_plan);
		}

		redirect(site_url('__ps_action_plan/index/', 'refresh'));
	}

	function manager_create_action_plan () {

		$p = $this->input->post();
		if (!empty($p)) {

			$emp_id = $this->session->userdata('id');
			$project = $this->__ps_project_query->getObj('tbt_quotation', array('contract_id' => $p['contract_id']));

			$action_plan_id = 400;
			$this->db->order_by('id desc');
			$this->db->limit(1);
			$query = $this->db->get('tbt_action_plan');
			$last_action_plan = $query->row_array();
			if (!empty($last_action_plan)) {
				$action_plan_id = intval($last_action_plan['id'])+1;
			}

			$action_plan_data = array(
				'id'				=> $action_plan_id,
				'title' 		    => $p['title'],
				'event_category_id' => 0,
				'actor_id'			=> $emp_id,
				'plan_date'		 	=> $p['plan_date'],
				'quotation_id'	 	=> $project['id'],
				'contract_id'		=> $project['contract_id'],
				'ship_to_id'	 	=> $project['ship_to_id'],
				'sold_to_id'	 	=> $project['sold_to_id'],
				'status'			=> 'plan',
				'remark'			=> $p['remark'],
				'is_manager'		=> 1
				);

			$this->__ps_project_query->insertObj('tbt_action_plan', $action_plan_data);

			$action_plan = $this->__ps_project_query->getObj('tbt_action_plan', array('id' => $action_plan_id));
			$sap_action_plan = array(
				'ID' 			=> $this->_padZero($action_plan_id, 10),
				'TITLE' 		=> iconv("UTF-8", "TIS-620",$action_plan['title']),
				'EVENT_CATEGORY_ID' => $action_plan['event_category_id'],
				'ACTOR_ID' 		=> $action_plan['actor_id'],
				'PLAN_DATE' 	=> $this->_dateFormat($action_plan['plan_date']),
				'ACTUAL_DATE' 	=> (!empty($actual_date)) ? $this->_dateFormat($actual_date) : "" ,
				'REMARK1' 		=> iconv("UTF-8", "TIS-620", substr($action_plan['remark'], 0, 512)),
				'REMARK2' 		=> iconv("UTF-8", "TIS-620", substr($action_plan['remark'], 512)),
				'STATUS' 		=> $action_plan['status'],
				'QUOTATION_ID' 	=> $action_plan['quotation_id'],
				'SHIP_TO_ID' 	=> $action_plan['ship_to_id'],
				'SOLD_TO_ID' 	=> $action_plan['sold_to_id'],
				'CREATE_DATE' 	=> date('Ymd'),
				'CREATE_TIME' 	=> date('His'),
				'OBJECT_TABLE' 	=> $action_plan['object_table']
				);

			if (!empty($action_plan['object_table'])) {
				if ($action_plan['object_table'] == 'tbt_area') {

					$clearjob_obj = $this->__ps_project_query->getObj('tbt_area', array('clear_job_type_id' => $action_plan['clear_job_type_id'], 'clearjob_frequency' => $action_plan['clearjob_frequency']));

					if (!empty($clearjob_obj)) {

						$sap_action_plan['CLEAR_JOB_CATEGORY_ID'] = $action_plan['clear_job_category_id'];	
						$sap_action_plan['CLEAR_JOB_TYPE_ID'] = $action_plan['clear_job_type_id'];	
						$sap_action_plan['STAFF'] = $clearjob_data['staff'];	
					}

				} 
				if ($action_plan['object_table'] != 'tbt_area') {
					$sap_action_plan['OBJECT_ID'] = $doc_id;					
				}
			}

			$input = array( 
				array("IMPORT","I_MODE","M"),
				array("IMPORT","I_TABLE", "ZTBT_ACTION_PLAN"),
				array("IMPORT","I_DATE", $this->_dateFormat($action_plan['plan_date'])),
				array("IMPORT","I_COMMIT", "X"),
				array("TABLE","IT_ZTBT_ACTION_PLAN", array($sap_action_plan))
				);

			$result = $this->callSAPFunction("ZRFC_MASS_TABLE", $input);
		}

		redirect(site_url('__ps_action_plan/index/', 'refresh'));
	}

	function update_action_plan () {

		$p = $this->input->post();

		// echo "<pre>";
		// print_r($p);
		// echo "</pre>";

		// die();

		if (!empty($p)) {

			$clear_job_type_id = 0;
			$clearjob_frequency = 0;

			if (!empty($p['clear_job_type_id'])) {
				$clear_job_type_id = $p['clear_job_type_id'];
				$clearjob_frequency = $p['frequency'];
			}

			if (empty($p['clear_job_category_id'])) {
				$p['clear_job_category_id'] = 0;
			}
			if (empty($p['total_staff'])) {
				$p['total_staff'] = 0;
			}
			if (empty($p['actual_date'])) {
				$p['actual_date'] = null;
			}
			if (empty($p['prospect_id'])) {
				$p['prospect_id'] = 0;
			}
			if (empty($p['visitation_reason_id'])) {
				$p['visitation_reason_id'] = 0;
			}
			if (empty($p['contact_type'])) {
				$p['contact_type'] = 0;
			}
			if (empty($p['sequence'])) {
				$p['sequence'] = 0;
			}
			if (empty($p['actual_date'])) {
				$p['actual_date'] = '0000-00-00';
			}

			$this->createActionPlan($p['plan_date'], 0, 0, $p['id'], $p['sequence'], $p['title'], $p['remark'], $clear_job_type_id, $clearjob_frequency, $p['clear_job_category_id'], $p['total_staff'], $p['actual_date'], $p['visitation_reason_id'], $p['prospect_id'], $p['contact_type'], $p['department_id']);
		}

		redirect(site_url('__ps_action_plan/index/', 'refresh'));
	}

	function get_action_info () {

		$emp_id = $this->session->userdata('id');
		$p = $this->input->post();

		if (array_key_exists('id', $p)) {
			$action_plan = $this->action_plan->allActionPlan(array('tbt_action_plan.id' => $p['id']), false);

			if (!empty($action_plan['clear_job_type_id']) && !empty($action_plan['clearjob_frequency'])) {
				$action_plan['clear_type_title'] = '';
				$clear_type = $this->__ps_project_query->getObj('sap_tbm_clear_type', array('id' => $action_plan['clear_job_type_id']));
				if (!empty($clear_type)) {
					$action_plan['clear_type_title'] = $clear_type['description'];
				}
			}

			if ($action_plan['ship_to_id'] == 0) {
				$visit_doc = $this->__ps_project_query->getObj('tbt_visitation_document', array('action_plan_id' => $action_plan['id']));
				if (!empty($visit_doc)) {
					if (!empty($visit_doc['prospect_id'])) {
						$action_plan['prospect_id'] = $visit_doc['prospect_id'];
						$prospect = $this->__ps_project_query->getObj('tbt_prospect', array('id' => $visit_doc['prospect_id']));
						if (!empty($prospect)) {
							$action_plan['prospect_name'] = $prospect['title'];
						}
					}
				}
			}

			if ($action_plan['object_table'] == 'tbt_visitation_document') {
				$visit_doc = $this->__ps_project_query->getObj('tbt_visitation_document', array('id' => $action_plan['object_id']));
				$action_plan['contact_type']   = $visit_doc['contact_type'];
			}			

			if ($action_plan['object_table'] == 'tbt_quality_survey') {
				$quality_doc = $this->__ps_project_query->getObj('tbt_quality_survey', array('id' => $action_plan['object_id']));
				$action_plan['doc_status']   = $quality_doc['status'];
				$action_plan['manager_btn_disabled'] = $this->__quality_assurance_model->checkManagerApprove($action_plan['object_id'], $action_plan['quotation_id']);
			}
			
			if ($action_plan['object_table'] == 'tbt_fix_claim') {
				$fix_cliam = $this->__ps_project_query->getObj('tbt_fix_claim', array('id' => $action_plan['object_id']));
				$action_plan['fix_claim_is_close']   = $fix_cliam['is_close'];
			}
			

			$all_user_marked = $this->__ps_project_query->getObj('tbt_user_marked', array('contract_id' => $action_plan['contract_id'], 'module_id' => $action_plan['event_category_id'], 'emp_id' => $emp_id), true);
			$user_marked = $this->__ps_project_query->getObj('tbt_user_marked', array('contract_id' => $action_plan['contract_id'], 'module_id' => $action_plan['event_category_id'], 'action_plan_id' => 0, 'emp_id' => $emp_id), true);

			if (empty($user_marked)) {
				$all_user_marked = 0;
			} else {
				$all_user_marked = sizeof($all_user_marked);
			}
			if (empty($user_marked)) {
				$user_marked = 0;
			}
			echo json_encode(array('action_plan' => $action_plan,'user_marked' => $user_marked, 'all_user_marked' => $all_user_marked));
		}
	}


	function fetch_category() {
		$p = $this->input->post();

		if (!empty($p['contract_id'])) {

			$module_list = $this->__action_plan_model->allEventCategory(array('tbt_user_marked.contract_id' => $p['contract_id'], 'cms_module.module_name !=' => 'customer_visitation'));

			if (!empty($module_list)) {
				foreach ($module_list as $key => $module) {
					$module_list[$key]['name'] = freetext($module['module_name']);
				}
			}

			$event_list = array();
			$function = $this->session->userdata('function');
			if (!empty($function)) {      
				$this->db->select('tbm_event_category.id, tbm_event_category.module as name');
				$this->db->where_in('function', $function);
				$query = $this->db->get('tbm_event_category');
				$event_list = $query->result_array();             
			}

			echo json_encode(array('module_list' => $module_list, 'event_list' => $event_list));
			return;
		}

		echo 0;
		return;
	}

	function fetch_clearjob_slot () {
		$p = $this->input->post();

		if (!empty($p['contract_id']) && !empty($p['module_id']) && !empty($p['clear_job_type_id']) && !empty($p['frequency'])) {

			$project = $this->__ps_project_query->getObj('tbt_quotation', array('contract_id' => $p['contract_id']));
			$clearjob = $this->__ps_project_query->getObj('tbt_area', array('contract_id' => $p['contract_id'], 'clear_job_type_id' => $p['clear_job_type_id'], 'frequency' => $p['frequency']));
			$all_user_marked = $this->__ps_project_query->getObj('tbt_user_marked', array('contract_id' => $p['contract_id'], 'module_id' => $p['module_id'], 'clear_job_type_id' => $p['clear_job_type_id'], 'frequency' => $p['frequency']), true);
			$user_marked = $this->__ps_project_query->getObj('tbt_user_marked', array('contract_id' => $p['contract_id'], 'module_id' => $p['module_id'], 'action_plan_id' => 0, 'clear_job_type_id' => $p['clear_job_type_id'], 'frequency' => $p['frequency']), true);

			if (empty($all_user_marked)) {
				$all_user_marked = 0;
			} else {
				$all_user_marked = sizeof($all_user_marked);
			}

			if (empty($user_marked)) {
				$user_marked = 0;
			}
			echo json_encode(array('user_marked' => $user_marked, 'all_user_marked' => $all_user_marked, 'staff' => $clearjob['staff']));
			return;
		}

		echo 0;
		return;
	}

	function fetch_clearjob_area () {

		$p = $this->input->post();
		if (!empty($p['contract_id'])) {
			$area_list = $this->__ps_project_query->getObj('tbt_keyuser_marked_assign', array('contract_id' => $p['contract_id'], 'module_id' => 12), true);

			$output = array();

			if (!empty($area_list)) {
				foreach ($area_list as $key => $area) {

					$area_slot = $this->__ps_project_query->getObj('tbt_user_marked', array('assign_id' => $area['id'], 'action_plan_id' => 0), true);

					$area_list[$key]['clearjob_title'] = '';
					$clearjob = $this->__ps_project_query->getObj('sap_tbm_clear_type', array('id' => $area['clear_job_type_id']));
					if (!empty($clearjob)) {
						$area_list[$key]['clearjob_title'] = $clearjob['description'];
					}

					if (!empty($area_slot)) {
						array_push($output, $area_list[$key]);
					}
				}
			}
			echo json_encode($output);
			return;
		}

		echo 0;
		return;
	}

	function fetch_slot() {
		$p = $this->input->post();

		if (!empty($p['contract_id']) && !empty($p['module_id'])) {

			$emp_id = $this->session->userdata('id');
			$all_user_marked = $this->__ps_project_query->getObj('tbt_user_marked', array('contract_id' => $p['contract_id'], 'module_id' => $p['module_id'], 'emp_id' => $emp_id), true);
			$user_marked = $this->__ps_project_query->getObj('tbt_user_marked', array('contract_id' => $p['contract_id'], 'module_id' => $p['module_id'], 'action_plan_id' => 0, 'emp_id' => $emp_id), true);

			if (empty($all_user_marked)) {
				$all_user_marked = 0;
			} else {
				$all_user_marked = sizeof($all_user_marked);
			}

			if (empty($user_marked)) {
				$user_marked = 0;
			}
			echo json_encode(array('user_marked' => $user_marked, 'all_user_marked' => $all_user_marked));
			return;
		}

		echo 0;
		return;
	}

	function fetch_prospect () {
		$p = $this->input->post();

		if (!empty($p['prospect_id'])) {

			$prospect = $this->action_plan->allProspect($p['prospect_id'], $p['distribution_channel']);			

			echo json_encode(array('prospect' => $prospect));
			return;
		}

		echo 0;
		return;
	}

	function fetch_visit_project () {
		$p = $this->input->post();

		if (!empty($p['ship_to_id'])) {

			$project = $this->action_plan->allVisitShipTo($p['ship_to_id'], $p['distribution_channel']);		
			echo json_encode(array('project' => $project));
			return;
		}

		echo 0;
		return;
	}

	function fetch_project () {
		$p = $this->input->post();

		if (!empty($p['ship_to_id'])) {

			$module_id = 'general';
			if (!empty($p['module_id'])) {
				$module_id = $p['module_id'];
			}

			$project = $this->action_plan->allShipTo($p['ship_to_id'], $module_id);		
			echo json_encode(array('project' => $project));
			return;
		}

		echo 0;
		return;
	}

	function updateMonthSession () {

		$p = $this->input->post();
		if (!empty($p['month']) && !empty($p['year'])) {
			$this->session->set_userdata('calendar_month', $p['month']);
			$this->session->set_userdata('calendar_year', $p['year']);
		}
	}

	function delete_action_plan ($id=null) {

		$p = $this->input->post();

		if (!empty($id)) {
			$p['id'] = $id;
		}

		if (!empty($p['id'])) {

			$action_plan = $this->__ps_project_query->getObj('tbt_action_plan', array('id' => $p['id']));		

			if ($action_plan['is_manager'] == 0) {
				if ($action_plan['object_table'] == 'tbt_visitation_document') {	

				} else if ($action_plan['object_table'] == 'tbt_quality_survey') {

					$this->__ps_project_query->deleteObj('tbt_quality_survey_area', array('quality_survey_id' => $action_plan['object_id']));

				} else if($action_plan['object_table'] == 'tbt_employee_track_document') {

					$this->__ps_project_query->deleteObj('tbt_employee_track', array('employee_track_document_id' => $action_plan['object_id']));

				} else if($action_plan['object_table'] == 'tbt_asset_track_document') {

					$this->__ps_project_query->deleteObj('tbt_asset_track', array('asset_track_document_id' => $action_plan['object_id']));
					$this->__ps_project_query->deleteObj('tbt_untracked_asset', array('asset_track_document_id' => $action_plan['object_id']));

				}

				$this->__ps_project_query->updateObj('tbt_user_marked', array('action_plan_id' => $action_plan['id']), array('action_plan_id' => 0));

				if ($action_plan['object_table'] != 'tbt_area') {
					$this->__ps_project_query->deleteObj($action_plan['object_table'], array('id' => $action_plan['object_id']));
				}
			}

			$items_actionplan = array();
			$item1 = array(
	            //"EVENT_CATEGORY_ID" => $this->_padZero("1", 5),s
				"ID"  => $this->_padZero($action_plan['id'], 10)

				);
	        //var_dump($item1);     
			array_push($items_actionplan, $item1);
			$input_actionplan = array(  
				array("IMPORT","I_MODE","D"),
				array("IMPORT","I_TABLE", "ZTBT_ACTION_PLAN"),
				array("IMPORT","I_DATE", $this->_dateFormat($action_plan['plan_date'])),
				array("IMPORT","I_COMMIT", "X"),
				array("TABLE","IT_ZTBT_ACTION_PLAN", $items_actionplan)
				);      

			$result = $this->callSAPFunction("ZRFC_MASS_TABLE", $input_actionplan);

			$this->__ps_project_query->deleteObj('tbt_action_plan', array('id' => $action_plan['id']));

			if (!empty($action_plan['pre_id']) && $action_plan['pre_id'] != 0) {
				$this->delete_action_plan($action_plan['pre_id']);
			} else {
				redirect(site_url('__ps_action_plan/index/', 'refresh'));
			}
			
		} else {
			redirect(site_url('__ps_action_plan/index/', 'refresh'));
		}

	}

	public function sync_project_quotation () {

		$query = $this->db->get('tbt_quotation');
		$project_list = $query->result_array();
		if (!empty($project_list)) {
			foreach ($project_list as $key => $project) {

				$this->db->where('id', $project['ship_to_id']);
				$query = $this->db->get('sap_tbm_ship_to');
				$ship_to = $query->row_array();

				$this->db->where('id', $project['sold_to_id']);
				$query = $this->db->get('sap_tbm_sold_to');
				$sold_to = $query->row_array();

				$quotation = array (
					'title' 				        => $project['title'],
					'previous_quotation_id'			=> 0,
					'job_type' 				        => $project['order_type'],
					'sold_to_id' 			        => $project['sold_to_id'],
					'ship_to_id' 			        => $project['ship_to_id'],
					'project_start' 		        => $project['project_start'],
					'project_end' 			        => $project['project_end'],
					'project_owner_id' 		        => $project['project_owner_id'],
					'competitor_id' 		        => $project['competitor_id'],
					'contract_id'   		        => $project['contract_id'],
					'ship_to_address_no' 	        => '',
					'ship_to_name1' 		        => $ship_to['ship_to_name1'],
					'ship_to_name2'			        => $ship_to['ship_to_name2'],
					'ship_to_search_term'	        => '',
					'ship_to_division'		        => '',
					'ship_to_address1'		        => $ship_to['ship_to_address1'],
					'ship_to_address2' 		        => $ship_to['ship_to_address2'],
					'ship_to_address3' 		        => $ship_to['ship_to_address3'],
					'ship_to_address4' 		        => '',
					'ship_to_district'		        => $ship_to['ship_to_district'],
					'ship_to_city'			        => $ship_to['ship_to_city'],
					'ship_to_postal_code'	        => $ship_to['ship_to_postal_code'],
					'ship_to_country'		        => $ship_to['ship_to_country'],
					'ship_to_region'		        => $ship_to['ship_to_region'],
					'ship_to_business_scale' 	    => '',
					'ship_to_customer_group'  	    => '',
					'ship_to_industry'				=> $ship_to['ship_to_industry'],
					'ship_to_distrubution_channel'	=> '',
					'ship_to_tel'					=> '',
					'ship_to_tel_ext'				=> '',
					'ship_to_fax'					=> '',
					'ship_to_fax_ext'				=> '',
					'ship_to_mobile'				=> '',
					'ship_to_email'					=> '',
					'sold_to_address_no' 			=> '',
					'sold_to_name1' 				=> $sold_to['sold_to_name1'],
					'sold_to_name2'					=> $sold_to['sold_to_name2'],
					'sold_to_search_term'			=> '',
					'sold_to_division'				=> '',
					'sold_to_address1'				=> $sold_to['sold_to_address1'],
					'sold_to_address2' 				=> $sold_to['sold_to_address2'],
					'sold_to_address3' 				=> $sold_to['sold_to_address3'],
					'sold_to_address4' 				=> '',
					'sold_to_district'				=> $sold_to['sold_to_district'],
					'sold_to_city'					=> $sold_to['sold_to_city'],
					'sold_to_postal_code'			=> $sold_to['sold_to_postal_code'],
					'sold_to_country'				=> $sold_to['sold_to_country'],
					'sold_to_region'				=> $sold_to['sold_to_region'],
					'sold_to_business_scale' 		=> '',
					'sold_to_customer_group'  		=> '',
					'sold_to_industry'				=> $sold_to['sold_to_industry'],
					'sold_to_distribution_channel'	=> '',
					'sold_to_tel'					=> '',
					'sold_to_tel_ext'				=> '',
					'sold_to_fax'					=> '',
					'sold_to_fax_ext'				=> '',
					'sold_to_mobile'				=> '',
					'sold_to_email'					=> ''
					);

				$this->db->where('title', $project['title']);
				$query = $this->db->get('tbt_quotation');
				$exist = $query->row_array();
				if (empty($exist)) {
					$this->db->insert('tbt_quotation', $quotation);
				} else {

					$this->db->where('id', $exist['id']);
					$this->db->update('tbt_quotation', $quotation);
				}
			}
		}

		echo "DONE";
	}
}
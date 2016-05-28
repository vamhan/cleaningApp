<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class __ps_visitation extends Admin_Controller {

	function __construct(){
		parent::__construct();

		$this->permission_check('customer_visitation');

		//TODO :: Move this to admin controller later 

		#CMS
		$this->pageSize = PAGESIZE;
		$this->table = 'tbt_visitation_document';
		$this->page_id = '__ps_visitation';
		$this->page_title = freetext('customer_visitation');
		$this->page_object = 'Page';
		$this->page_controller = '__ps_visitation';
		$this->function ='';

		//$this->untrack = 0;
		//set lang
		$this->session->set_userdata('lang', 'th');
		
		#END_CMS
	}//end constructor;

	//Default
	function index($act='',$id=''){
		//TODO :: redirecting to listview
		redirect(site_url('__ps_visitation/listview_quotation'), 'refresh');
	}



	function changePageSize($function,$newPageSize = PAGESIZE){
		$newValue = array('current_page'=> $newPageSize);
		$this->session->set_userdata($newValue);

		redirect(site_url('__ps_visitation/'.$function),'refresh');		
	}


	function listview_prospect($page=1){
		$this->load->model("__department_model");

		$newValue = array('current_url'=> site_url($this->uri->uri_string()) );
		$this->session->set_userdata($newValue);

		$this->tab = 1;
		$this->function = 'listview_prospect';
		$data = array();
		$list = array();
		//$list_project = array();		
		$user_department_id = $this->session->userdata('department');

		$bapi_distribution_list = $this->__quotation_model->sap_tbm_distribution_channel()->result_array();
		$distribution_channel_list =  $this->session->userdata('distribution_channel');
		$child_distribution_channel_list = $this->__ps_project_query->get_child_distribution_channel($this->session->userdata('position'));
		
		foreach ($child_distribution_channel_list as $key => $child_distribution_channel) {
			if(! in_array($child_distribution_channel['area_id'], $distribution_channel_list)){
				array_push($distribution_channel_list, $child_distribution_channel['area_id']);
			}
		}

		sort($distribution_channel_list);
		

		$list = $this->__visitation_model->getContentList_prospect($page);
		$list['event_category'] = $this->__action_plan_model->allEventCategory();
		$list['visit_reason_list']  = $this->__action_plan_model->allVisitReason();		
		$list['visit_connect_list']  = $this->__action_plan_model->allVisitConnect();	
		$list['bapi_distribution_list'] = $bapi_distribution_list;
		$list['distribution_channel_list'] = $distribution_channel_list;

		$list['isAllowToCreate'] = 0;
		$emp_id = $this->session->userdata('id');
		$where = array(
			'emp_id' => $emp_id,
			'module_id' => $this->cat_id
			);

		$this->db->where($where);
		$query = $this->db->get('tbt_user_marked');
		$result = $query->row_array();

		if (!empty($result)) {
			$list['isAllowToCreate'] = 1;
		} 
		
		$menuConfig = array('page_id'=>1);
		
		$data['modal'] = $this->load->view('__visitation/page/list_modal',$list,true);//return view as data

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
		$data['top_project'] = $this->load->view('__visitation/include/top_project',$info,true);

		$list['permission'] = $this->permission[$this->cat_id];
		//Load body
		$data['body'] = $this->load->view('__visitation/page/list_bodycfg',$list,true);

		//Load footage script
		$data['footage_script'] = '';


		$this->load->view('__visitation/layout/list',$data);
	}



	//function com_listview : act / id 
	function listview_quotation($page=1){
		$this->load->model("__department_model");

		$newValue = array('current_url'=> site_url($this->uri->uri_string()) );
		$this->session->set_userdata($newValue);
		
		

		$this->tab = 2;
		$this->function = 'listview_quotation';
		$data = array();
		$list = array();
		//$list_project = array();		
		$user_department_id = $this->session->userdata('department');

		$bapi_distribution_list = $this->__quotation_model->sap_tbm_distribution_channel()->result_array();
		$distribution_channel_list =  $this->session->userdata('distribution_channel');
		$child_distribution_channel_list = $this->__ps_project_query->get_child_distribution_channel($this->session->userdata('position'));
		
		foreach ($child_distribution_channel_list as $key => $child_distribution_channel) {
			if(! in_array($child_distribution_channel['area_id'], $distribution_channel_list)){
				array_push($distribution_channel_list, $child_distribution_channel['area_id']);
			}
		}

		sort($distribution_channel_list);

		

		$list = $this->__visitation_model->getContentList($page);
		$list['event_category'] = $this->__action_plan_model->allEventCategory();
		$list['visit_reason_list']  = $this->__action_plan_model->allVisitReason();	
		$list['visit_connect_list']  = $this->__action_plan_model->allVisitConnect();		
			//$list_project = $this->__visitation_model->getContentList_prospect($page);
		$list['bapi_distribution_list'] = $bapi_distribution_list;
		$list['distribution_channel_list'] = $distribution_channel_list;

		$list['isAllowToCreate'] = 0;
		$emp_id = $this->session->userdata('id');
		$group = $this->session->userdata('group');
		if (!empty($group)) {
			if (in_array('member', $group)) {
				$where = array(
					'emp_id' => $emp_id,
					'module_id' => 4
					);
				$this->db->where($where);
				$query = $this->db->get('tbt_user_marked');
				$result = $query->row_array();

				if (!empty($result)) {
					$list['isAllowToCreate'] = 1;
				} 

			} 
		}

		$menuConfig = array('page_id'=>1);
		
		$data['modal'] = $this->load->view('__visitation/page/list_modal',$list,true);//return view as data

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
		$data['top_project'] = $this->load->view('__visitation/include/top_project',$info,true);

		$list['permission'] = $this->permission[$this->cat_id];
		//Load body
		$data['body'] = $this->load->view('__visitation/page/list_bodycfg',$list,true);

		//Load footage script
		$data['footage_script'] = '';


		$this->load->view('__visitation/layout/list',$data);
	}

	function detail_quotation($act='',$id=0,$tab=1){

		
		$data = array();
		$body = array();	

		$data['tab'] = $tab;

		$emp_id = $this->session->userdata('id');
		$permission = $this->permission[$this->cat_id];

		switch ($act) { // to tbt_proto_item

			case 'edit_quotation':
			 	//TODO ::  EDIT DATA QUOTATION
			$this->track_doc_id  = $id;

				// $this->status  = $status;				
				// $this->track_doc_id  = $id;
				// $this->untrack  = $untrack;

			$menuConfig['page_title'] = 'API Manager';
			$menuConfig['page_id'] 	  = 'api_manager';

			$position_list = $this->session->userdata('position');

			$children = array();
			foreach ($position_list as $key => $position) {
				$children = $this->__ps_project_query->getPositionChild($children, $position);
			}

				//#############  Query #########################################################################
			$list = array();
			$list['user_list']     = $this->__visitation_model->getFunctionMember();
			$list['data_document'] = $this->__visitation_model->getDocument($this->track_doc_id);

			if ( !empty($list['data_document']) ) {
				if (!array_key_exists('edit', $permission) || (empty($children) && $list['data_document']['submit_date_sap'] != '0000-00-00')) {
					redirect(site_url('__ps_visitation/listview_quotation'), 'refresh');
				}

				if (empty($list['data_document']['in_time']) || $list['data_document']['in_time'] == '0000-00-00 00:00:00') {
					$this->__ps_project_query->updateObj('tbt_visitation_document', array('id' => $this->track_doc_id), array('in_time' => date('Y-m-d h:i:s')));
					$list['data_document']['in_time'] = date('Y-m-d h:i:s');
				}
			}

			$list['bapi_region'] = $this->__quotation_model->sap_tbm_region();
			$list['bapi_country'] = $this->__quotation_model->sap_tbm_country();
			$list['bapi_industry'] = $this->__quotation_model->sap_tbm_industry();
			$list['bapi_business_scale'] = $this->__quotation_model->sap_tbm_business_scale();			
			$list['image_list'] = $this->__visitation_model->getImageList($id);
				//####################################################################################################				

			$list['not_visit_reason'] = $this->__visitation_model->getNotVisitReason();

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
			$data['top_project'] = $this->load->view('__visitation/include/top_project',$info,true);

				//Load body
			$list['tab'] = $tab;
			$data['body'] = $this->load->view('__visitation/page/detail_bodycfg',$list,true);

				// $data['modal'] = $this->load->view('__visitation/page/detail_modal',$list,true);//return view as data
				// //Load footage script
				// $data['footage_script'] ='';//$this->load->view('__cms/script/api/api_manager_js','',true);	
				$data['modal'] = $this->load->view('__visitation/page/detail_modal', null ,true);//return view as data			

				$this->load->view('__visitation/layout/detail',$data);

				break;

				case 'edit_prospect':
			 	//TODO ::  EDIT DATA QUOTATION
				$this->track_doc_id  = $id;

				// $this->status  = $status;				
				// $this->track_doc_id  = $id;
				// $this->untrack  = $untrack;

				$menuConfig['page_title'] = 'API Manager';
				$menuConfig['page_id'] 	  = 'api_manager';


				//#############  Query #########################################################################
				$list = array();
				$list['data_document'] = $this->__visitation_model->getDocument($this->track_doc_id);		

				if ( !empty($list['data_document']) ) {
					if (!array_key_exists('edit', $permission) || $emp_id != $list['data_document']['visitor_id'] || $list['data_document']['submit_date_sap'] != '0000-00-00') {
						redirect(site_url('__ps_visitation/listview_prospect'), 'refresh');
					}

					if (empty($list['data_document']['in_time']) || $list['data_document']['in_time'] == '0000-00-00 00:00:00') {
						$this->__ps_project_query->updateObj('tbt_visitation_document', array('id' => $this->track_doc_id), array('in_time' => date('Y-m-d h:i:s')));
						$list['data_document']['in_time'] = date('Y-m-d h:i:s');
					}
				}

				$list['bapi_region'] = $this->__quotation_model->sap_tbm_region();
				$list['bapi_country'] = $this->__quotation_model->sap_tbm_country();
				$list['bapi_industry'] = $this->__quotation_model->sap_tbm_industry();
				$list['bapi_business_scale'] = $this->__quotation_model->sap_tbm_business_scale();		
				$list['image_list'] = $this->__visitation_model->getImageList($id);			

				//####################################################################################################				

				$list['not_visit_reason'] = $this->__visitation_model->getNotVisitReason();
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
				$data['top_project'] = $this->load->view('__visitation/include/top_project',$info,true);

				//Load body
				$data['body'] = $this->load->view('__visitation/page/detail_bodycfg',$list,true);

				$data['modal'] = $this->load->view('__visitation/page/detail_modal', null ,true);//return view as data
				// //Load footage script
				// $data['footage_script'] ='';//$this->load->view('__cms/script/api/api_manager_js','',true);				

				$this->load->view('__visitation/layout/detail',$data);

				break;

				
				case 'view':				

				break;
				
				default:			

				break;
			}

			
		}

		function view_quotation($act='',$id=0,$tab=1){

			
			$data = array();
			$body = array();	

			$data['tab'] = $tab;
		//$this->page_title = freetext('asset_tracker_top').' - ['.$id.']';

			$permission = $this->permission[$this->cat_id];

		switch ($act) { // to tbt_proto_item

			case 'edit_quotation':
			 	//TODO ::  EDIT DATA QUOTATION
			$this->track_doc_id  = $id;

				// $this->status  = $status;				
				// $this->track_doc_id  = $id;
				// $this->untrack  = $untrack;

			$menuConfig['page_title'] = 'API Manager';
			$menuConfig['page_id'] 	  = 'api_manager';

			if (!array_key_exists('view', $permission)) {
				redirect(site_url('__ps_visitation/listview_quotation'), 'refresh');
			}

				//#############  Query #########################################################################
			$list = array();
			$list['tab']= $tab;
			$list['data_document'] = $this->__visitation_model->getDocument($this->track_doc_id);	
			$list['bapi_region'] = $this->__quotation_model->sap_tbm_region();
			$list['bapi_country'] = $this->__quotation_model->sap_tbm_country();
			$list['bapi_industry'] = $this->__quotation_model->sap_tbm_industry();
			$list['bapi_business_scale'] = $this->__quotation_model->sap_tbm_business_scale();			
			$list['image_list'] = $this->__visitation_model->getImageList($id);
			$list['not_visit_reason'] = $this->__visitation_model->getNotVisitReason();
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
			$data['top_project'] = $this->load->view('__visitation/include/top_project',$info,true);

				//Load body
			$data['body'] = $this->load->view('__visitation/page/detail_bodycfg',$list,true);

				// $data['modal'] = $this->load->view('__visitation/page/detail_modal',$list,true);//return view as data
				// //Load footage script
				// $data['footage_script'] ='';//$this->load->view('__cms/script/api/api_manager_js','',true);	
				$data['modal'] = $this->load->view('__visitation/page/detail_modal', null ,true);//return view as data			

				$this->load->view('__visitation/layout/view',$data);

				break;

				case 'edit_prospect':
			 	//TODO ::  EDIT DATA QUOTATION
				$this->track_doc_id  = $id;

				// $this->status  = $status;				
				// $this->track_doc_id  = $id;
				// $this->untrack  = $untrack;

				$menuConfig['page_title'] = 'API Manager';
				$menuConfig['page_id'] 	  = 'api_manager';

				if (!array_key_exists('view', $permission)) {
					redirect(site_url('__ps_visitation/listview_prospect'), 'refresh');
				}

				//#############  Query #########################################################################
				$list = array();
				$list['data_document'] = $this->__visitation_model->getDocument($this->track_doc_id);	
				$list['bapi_region'] = $this->__quotation_model->sap_tbm_region();
				$list['bapi_country'] = $this->__quotation_model->sap_tbm_country();
				$list['bapi_industry'] = $this->__quotation_model->sap_tbm_industry();
				$list['bapi_business_scale'] = $this->__quotation_model->sap_tbm_business_scale();		
				$list['image_list'] = $this->__visitation_model->getImageList($id);			

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
				$data['top_project'] = $this->load->view('__visitation/include/top_project',$info,true);

				//Load body
				$data['body'] = $this->load->view('__visitation/page/detail_bodycfg',$list,true);

				$data['modal'] = $this->load->view('__visitation/page/detail_modal', null ,true);//return view as data
				// //Load footage script
				// $data['footage_script'] ='';//$this->load->view('__cms/script/api/api_manager_js','',true);				

				$this->load->view('__visitation/layout/view',$data);

				break;

				
				case 'view':				

				break;
				
				default:			

				break;
			}

			
		}

		function update_visitation($id=0){

			$p = $this->input->post();	
			$position_list = $this->session->userdata('position');

			$children = array();
			foreach ($position_list as $key => $position) {
				$children = $this->__ps_project_query->getPositionChild($children, $position);
			}

			if(!empty($p) && !empty($id)	){
			// echo "<pre>";
			// print_r($p);
			// echo "</pre>";

			// die();

				$this->updateDocLog('tbt_visitation_document', $id);
			// die();
				$doc_data = $this->__ps_project_query->getObj('tbt_visitation_document', array('id' => $id));

			// if (empty($children)) {
				
			// 	$data = array(
			// 		'not_visit_reason_id' 	=> $p['not_visit_reason_id'],
			// 		'not_visit_reason_other' => $p['not_visit_reason_other'],
			// 		'contact_id' 			=> $p['contact_id'],
			// 		'conclusion' 			=> $p['conclusion'],
			// 		'detail' 				=> $p['detail'],
			// 		'comment' 				=> $p['comment'],
			// 		'cpt_time' 				=> $p['cpt_time'],
			// 		'cpt_unit_time' 		=> $p['cpt_unit_time'],
			// 		'cpt_start' 			=> $p['cpt_start'],
			// 		'cpt_end' 				=> $p['cpt_end'],
			// 		'cpt_price' 			=> str_replace(',', '', $p['cpt_price']),
			// 		'cpt_comment' 			=> $p['cpt_comment'],
			// 		'notice_to_cr' 			=> $p['notice_to_cr'],
			// 		'notice_to_oper' 		=> $p['notice_to_oper'],
			// 		'notice_to_hr' 			=> $p['notice_to_hr'],
			// 		'notice_to_training' 	=> $p['notice_to_training'],
			// 		'notice_to_store' 		=> $p['notice_to_store'],
			// 		'notice_to_sale' 		=> $p['notice_to_sale']
			// 	);

			// } else {
			// 	$data = array(
			// 		'comment_before' 		=> $p['comment_before'],
			// 		'comment_after' 		=> $p['comment_after']
			// 	);
			// }

				$data = array(
					'not_visit_reason_id' 	=> $p['not_visit_reason_id'],
					'not_visit_reason_other' => $p['not_visit_reason_other'],
					'contact_id' 			=> $p['contact_id'],
					'conclusion' 			=> $p['conclusion'],
					'detail' 				=> $p['detail'],
					'comment' 				=> $p['comment'],
					'cpt_time' 				=> $p['cpt_time'],
					'cpt_unit_time' 		=> $p['cpt_unit_time'],
					'cpt_start' 			=> $p['cpt_start'],
					'cpt_end' 				=> $p['cpt_end'],
					'cpt_price' 			=> str_replace(',', '', $p['cpt_price']),
					'cpt_comment' 			=> $p['cpt_comment'],
					'notice_to_cr' 			=> $p['notice_to_cr'],
					'notice_to_oper' 		=> $p['notice_to_oper'],
					'notice_to_hr' 			=> $p['notice_to_hr'],
					'notice_to_training' 	=> $p['notice_to_training'],
					'notice_to_store' 		=> $p['notice_to_store'],
					'notice_to_sale' 		=> $p['notice_to_sale']
					);

				if (!empty($p['comment_before'])) {
					$data['is_manager_comment'] = 1;
				}
				if (!empty($p['comment'])) {
					$data['is_visitor_comment'] = 1;
				}


				$title = $doc_data['title'];

				if ($doc_data['is_visitor_comment'] == 0 && $data['is_visitor_comment'] == 1) {
					$title = '# '.$title;
				}

				if ($doc_data['is_manager_comment'] == 0 && $data['is_manager_comment'] == 1) {
					if (empty($data['is_visitor_comment'])) {
						$title = '* '.$title;
					} else {
						$title = '*'.$title;
					}
				}

				$data['title'] = $title;

				$this->__ps_project_query->updateObj('tbt_visitation_document', array('id' => $id), $data);
				$this->__ps_project_query->updateObj('tbt_action_plan', array('id' => $doc_data['action_plan_id']), array('title' => $title));

				if (!empty($p['submit_sap']) && $p['submit_sap'] == 1) {

					$this->__ps_project_query->updateObj('tbt_visitation_document', array('id' => $id), array('submit_date_sap' => date('Y-m-d'), 'out_time' => date('Y-m-d h:i:s')));
					$updated_doc = $this->__ps_project_query->getObj('tbt_visitation_document', array('id' => $id));

					$sap_doc = array(
						'ID' 					=> $this->_padZero($id, 10),
						'TITLE' 				=> iconv("UTF-8", "TIS-620",$updated_doc['title']),
						'PROJECT_ID' 			=> $updated_doc['project_id'],
						'CONTRACT_ID' 			=> $updated_doc['contract_id'],
						'CONTACT_ID' 			=> $updated_doc['contact_id'],
						'VISITOR_ID' 			=> $updated_doc['visitor_id'],
						'VISIT_REASON_ID' 		=> $updated_doc['visit_reason_id'],
						'PROSPECT_ID' 			=> $updated_doc['prospect_id'],
						'QUOTATION_ID' 			=> $updated_doc['quotation_id'],
						'ACTION_PLAN_ID' 		=> $updated_doc['action_plan_id'],
						'CPT_TIME' 				=> $updated_doc['cpt_time'],
						'CPT_UNIT_TIME' 		=> $updated_doc['cpt_unit_time'],
						'CPT_START' 			=> $this->_dateFormat($updated_doc['cpt_start']),
						'CPT_END' 				=> $this->_dateFormat($updated_doc['cpt_end']),
						'CPT_PRICE' 			=> $updated_doc['cpt_price'],
						'CONCLUSION' 			=> iconv("UTF-8", "TIS-620",$updated_doc['conclusion']),
						'NOTVISIT_REASON_ID' 	=> $updated_doc['not_visit_reason_id'],
						'SUBMIT_DATE_SAP' 		=> $this->_dateFormat($updated_doc['submit_date_sap']),
						'IS_MANAGER_COMMENT' 	=> $updated_doc['is_manager_comment'],
						'IS_VISITOR_COMMENT' 	=> $updated_doc['is_visitor_comment'],
						'CPT_COMMENT' 			=> iconv("UTF-8", "TIS-620",$updated_doc['cpt_comment']),
						'COMMENT_BEFORE' 		=> iconv("UTF-8", "TIS-620",$updated_doc['comment_before']),
						'COMMENT_AFTER' 		=> iconv("UTF-8", "TIS-620",$updated_doc['comment_after']),
						'DETAIL' 				=> iconv("UTF-8", "TIS-620",$updated_doc['detail']),
						'COMMENT1' 				=> iconv("UTF-8", "TIS-620",$updated_doc['comment']),
						'NOTICE_TO_CR' 			=> iconv("UTF-8", "TIS-620",$updated_doc['notice_to_cr']),
						'NOTICE_TO_OPER' 		=> iconv("UTF-8", "TIS-620",$updated_doc['notice_to_oper']),
						'NOTICE_TO_HR' 			=> iconv("UTF-8", "TIS-620",$updated_doc['notice_to_hr']),
						'NOTICE_TO_SALE' 		=> iconv("UTF-8", "TIS-620",$updated_doc['notice_to_sale']),
						'NOTICE_TO_TRAINING' 	=> iconv("UTF-8", "TIS-620",$updated_doc['notice_to_training']),
						'NOTICE_TO_STORE' 	 	=> iconv("UTF-8", "TIS-620",$updated_doc['notice_to_store'])
						);				

$input 	=	array(	
	array("IMPORT","I_MODE","M"),
	array("IMPORT","I_TABLE", "ZTBT_VISITATION"),
	array("IMPORT","I_DATE", $this->_dateFormat($updated_doc['submit_date_sap'])),
	array("IMPORT","I_COMMIT", "X"),
	array("TABLE","IT_ZTBT_VISITATION", array($sap_doc))
	);		

$result = $this->callSAPFunction("ZRFC_MASS_TABLE", $input);

$sap_doc2 = array(
	'ID' 					=> $this->_padZero($id, 10),
	'EMAIL_NOTICE_CR' 		=> iconv("UTF-8", "TIS-620",$updated_doc['email_notice_cr']),
	'EMAIL_NOTICE_OP' 		=> iconv("UTF-8", "TIS-620",$updated_doc['email_notice_op']),
	'EMAIL_NOTICE_HR' 		=> iconv("UTF-8", "TIS-620",$updated_doc['email_notice_hr']),
	'EMAIL_NOTICE_SALES' 	=> iconv("UTF-8", "TIS-620",$updated_doc['email_notice_sales']),
	'EMAIL_NOTICE_TRAING' 	=> iconv("UTF-8", "TIS-620",$updated_doc['email_notice_training']),
	'EMAIL_NOTICE_STORE' 	=> iconv("UTF-8", "TIS-620",$updated_doc['email_notice_store']),
	'IN_DATE'				=> (!empty($updated_doc['in_time']) && $updated_doc['in_time'] != '0000-00-00 00:00:00') ? date('Ymd', strtotime($updated_doc['in_time'])) : "",
	'IN_TIME'				=> (!empty($updated_doc['in_time']) && $updated_doc['in_time'] != '0000-00-00 00:00:00') ? date('His', strtotime($updated_doc['in_time'])) : "",
	'OUT_DATE'				=> (!empty($updated_doc['out_time']) && $updated_doc['out_time'] != '0000-00-00 00:00:00') ? date('Ymd', strtotime($updated_doc['out_time'])) : "",
	'OUT_TIME'				=> (!empty($updated_doc['out_time']) && $updated_doc['out_time'] != '0000-00-00 00:00:00') ? date('His', strtotime($updated_doc['out_time'])) : "",
	'NOT_VISIT_OTHER'		=> iconv("UTF-8", "TIS-620",$updated_doc['not_visit_reason_other'])
	);		

$input 	=	array(	
	array("IMPORT","I_MODE","M"),
	array("IMPORT","I_TABLE", "ZTBT_VISITATION2"),
	array("IMPORT","I_DATE", $this->_dateFormat($updated_doc['submit_date_sap'])),
	array("IMPORT","I_COMMIT", "X"),
	array("TABLE","IT_ZTBT_VISITATION2", array($sap_doc2))
	);		

				// echo "<pre>";
				// print_r($input);
				// echo "</pre>";

				// die();

$result = $this->callSAPFunction("ZRFC_MASS_TABLE", $input);

$action_plan = $this->__ps_project_query->getObj('tbt_action_plan', array('id' => $updated_doc['action_plan_id']));
$this->__ps_project_query->updateObj('tbt_action_plan', array('id' => $action_plan['id']), array('submit_date_sap' => date('Y-m-d')));

$sap_action_plan = array(
	'ID' 			=> $this->_padZero($action_plan['id'],10),
	'TITLE' 		=> iconv("UTF-8", "TIS-620",$action_plan['title']),
	'EVENT_CATEGORY_ID' => $action_plan['event_category_id'],
	'ACTOR_ID' 		=> $action_plan['actor_id'],
	'PLAN_DATE' 	=> $this->_dateFormat($action_plan['plan_date']),
	'ACTUAL_DATE' 	=> $this->_dateFormat(date('Y-m-d')) ,
	'ACTUAL_TIME' 	=> date('His') ,
	'REMARK1' 		=> iconv("UTF-8", "TIS-620", substr($action_plan['remark'], 0, 512)),
	'REMARK2' 		=> iconv("UTF-8", "TIS-620", substr($action_plan['remark'], 512)),
					//'CLEAR_JOB_AREA_ID' => $action_plan['clear_job_area_id'],
	'CLEAR_JOB_CATEGORY_ID' => $action_plan['clear_job_category_id'],
	'CLEAR_JOB_TYPE_ID' => $action_plan['clear_job_type_id'],
	'STAFF'			=> $action_plan['staff'],
	'TOTAL_STAFF'	=> $action_plan['total_staff'],
	'STATUS' 		=> 'shift',
	'QUOTATION_ID' 	=> $action_plan['quotation_id'],
	'SHIP_TO_ID' 	=> $action_plan['ship_to_id'],
	'SOLD_TO_ID' 	=> $action_plan['sold_to_id'],
	'CREATE_DATE' 	=> date('Ymd'),
	'CREATE_TIME' 	=> date('His'),
	'OBJECT_TABLE' 	=> $action_plan['object_table'],
	'OBJECT_ID'		=> $$action_plan['object_id']
	);

$input = array( 
	array("IMPORT","I_MODE","M"),
	array("IMPORT","I_TABLE", "ZTBT_ACTION_PLAN"),
	array("IMPORT","I_DATE", $this->_dateFormat($action_plan['plan_date'])),
	array("IMPORT","I_COMMIT", "X"),
	array("TABLE","IT_ZTBT_ACTION_PLAN", array($sap_action_plan))
	);

$result = $this->callSAPFunction("ZRFC_MASS_TABLE", $input);

$default_name = 'ZTBT_VISITATION'.$this->_padZero($id, 10);

				/////////////// COMMENT BEFORE ///////////////
$comment_before_lines = array();
$comment_before       = iconv("UTF-8", "TIS-620",$updated_doc['comment_before']);
while (strlen($comment_before) > 0) {
	$sub_text = substr($comment_before, 0, 130);
	$comment_before = substr($comment_before, 130);


	$text_line = array(
		'TDOBJECT' => 'TEXT',
		'TDNAME'   => $default_name.'COMMENT_BEFORE',
		'TDID'     => 'ST',
		'TDSPRAS'  => '2',
		'TDFORMAT' => '*',
		'TDLINE'   => $sub_text
		);

	array_push($comment_before_lines, $text_line);
}		
$comment_before_sap = array(	
	array("TABLE","TEXT_LINES", $comment_before_lines)
	);	
$result = $this->callSAPFunction("RFC_SAVE_TEXT", $comment_before_sap);

				/////////////// COMMENT AFTER ///////////////
$comment_after_lines = array();
$comment_after       = iconv("UTF-8", "TIS-620",$updated_doc['comment_after']);
while (strlen($comment_after) > 0) {
	$sub_text = substr($comment_after, 0, 130);
	$comment_after = substr($comment_after, 130);

	$text_line = array(
		'TDOBJECT' => 'TEXT',
		'TDNAME'   => $default_name.'COMMENT_AFTER',
		'TDID'     => 'ST',
		'TDSPRAS'  => '2',
		'TDFORMAT' => '*',
		'TDLINE'   => $sub_text
		);

	array_push($comment_after_lines, $text_line);
}		
$comment_after_sap = array(	
	array("TABLE","TEXT_LINES", $comment_after_lines)
	);	
$result = $this->callSAPFunction("RFC_SAVE_TEXT", $comment_after_sap);

				/////////////// CONCLUSION ///////////////
$conclusion_lines = array();
$conclusion       = iconv("UTF-8", "TIS-620",$updated_doc['conclusion']);
while (strlen($conclusion) > 0) {
	$sub_text = substr($conclusion, 0, 130);
	$conclusion = substr($conclusion, 130);

	$text_line = array(
		'TDOBJECT' => 'TEXT',
		'TDNAME'   => $default_name.'CONCLUSION',
		'TDID'     => 'ST',
		'TDSPRAS'  => '2',
		'TDFORMAT' => '*',
		'TDLINE'   => $sub_text
		);

	array_push($conclusion_lines, $text_line);
}		
$conclusion_sap = array(	
	array("TABLE","TEXT_LINES", $conclusion_lines)
	);	
$result = $this->callSAPFunction("RFC_SAVE_TEXT", $conclusion_sap);

				/////////////// DETAIL ///////////////
$detail_lines = array();
$detail       = iconv("UTF-8", "TIS-620",$updated_doc['detail']);
$count = 1;
while (strlen($detail) > 0) {
	$sub_text = substr($detail, 0, 130);
	$detail = substr($detail, 130);

	$text_line = array(
		'TDOBJECT' => 'TEXT',
		'TDNAME'   => $default_name.'DETAIL',
		'TDID'     => 'ST',
		'TDSPRAS'  => '2',
		'TDFORMAT' => '*',
		'TDLINE'   => $sub_text
		);

	array_push($detail_lines, $text_line);
}		
$detail_sap = array(	
	array("TABLE","TEXT_LINES", $detail_lines)
	);	
$result = $this->callSAPFunction("RFC_SAVE_TEXT", $detail_sap);

				/////////////// COMMENT_T ///////////////
$comment_lines = array();
$comment       = iconv("UTF-8", "TIS-620",$updated_doc['comment']);
$count = 1;
while (strlen($comment) > 0) {
	$sub_text = substr($comment, 0, 130);
	$comment = substr($comment, 130);

	$text_line = array(
		'TDOBJECT' => 'TEXT',
		'TDNAME'   => $default_name.'COMMENT',
		'TDID'     => 'ST',
		'TDSPRAS'  => '2',
		'TDFORMAT' => '*',
		'TDLINE'   => $sub_text
		);

	array_push($comment_lines, $text_line);
}		
$comment_sap = array(	
	array("TABLE","TEXT_LINES", $comment_lines)
	);	
$result = $this->callSAPFunction("RFC_SAVE_TEXT", $comment_sap);

				/////////////// CPT_COMMENT ///////////////
$cpt_comment_lines = array();
$cpt_comment       = iconv("UTF-8", "TIS-620",$updated_doc['cpt_comment']);
$count = 1;
while (strlen($cpt_comment) > 0) {
	$sub_text = substr($cpt_comment, 0, 130);
	$cpt_comment = substr($cpt_comment, 130);

	$text_line = array(
		'TDOBJECT' => 'TEXT',
		'TDNAME'   => $default_name.'CPT_COMMENT',
		'TDID'     => 'ST',
		'TDSPRAS'  => '2',
		'TDFORMAT' => '*',
		'TDLINE'   => $sub_text
		);

	array_push($cpt_comment_lines, $text_line);
}		
$cpt_comment_sap = array(	
	array("TABLE","TEXT_LINES", $cpt_comment_lines)
	);	
$result = $this->callSAPFunction("RFC_SAVE_TEXT", $cpt_comment_sap);

				/////////////// NOTICE_TO_CR ///////////////
$notice_to_cr_lines = array();
$notice_to_cr       = iconv("UTF-8", "TIS-620",$updated_doc['notice_to_cr']);
$count = 1;
while (strlen($notice_to_cr) > 0) {
	$sub_text = substr($notice_to_cr, 0, 130);
	$notice_to_cr = substr($notice_to_cr, 130);

	$text_line = array(
		'TDOBJECT' => 'TEXT',
		'TDNAME'   => $default_name.'NOTICE_TO_CR',
		'TDID'     => 'ST',
		'TDSPRAS'  => '2',
		'TDFORMAT' => '*',
		'TDLINE'   => $sub_text
		);

	array_push($notice_to_cr_lines, $text_line);
}		
$notice_to_cr_sap = array(	
	array("TABLE","TEXT_LINES", $notice_to_cr_lines)
	);	
$result = $this->callSAPFunction("RFC_SAVE_TEXT", $notice_to_cr_sap);

				/////////////// NOTICE_TO_OPER ///////////////
$notice_to_oper_lines = array();
$notice_to_oper       = iconv("UTF-8", "TIS-620",$updated_doc['notice_to_oper']);
$count = 1;
while (strlen($notice_to_oper) > 0) {
	$sub_text = substr($notice_to_oper, 0, 130);
	$notice_to_oper = substr($notice_to_oper, 130);

	$text_line = array(
		'TDOBJECT' => 'TEXT',
		'TDNAME'   => $default_name.'NOTICE_TO_OPER',
		'TDID'     => 'ST',
		'TDSPRAS'  => '2',
		'TDFORMAT' => '*',
		'TDLINE'   => $sub_text
		);

	array_push($notice_to_oper_lines, $text_line);
}		
$notice_to_oper_sap = array(	
	array("TABLE","TEXT_LINES", $notice_to_oper_lines)
	);	
$result = $this->callSAPFunction("RFC_SAVE_TEXT", $notice_to_oper_sap);

				/////////////// NOTICE_TO_HR ///////////////
$notice_to_hr_lines = array();
$notice_to_hr       = iconv("UTF-8", "TIS-620",$updated_doc['notice_to_hr']);
$count = 1;
while (strlen($notice_to_hr) > 0) {
	$sub_text = substr($notice_to_hr, 0, 130);
	$notice_to_hr = substr($notice_to_hr, 130);

	$text_line = array(
		'TDOBJECT' => 'TEXT',
		'TDNAME'   => $default_name.'NOTICE_TO_HR',
		'TDID'     => 'ST',
		'TDSPRAS'  => '2',
		'TDFORMAT' => '*',
		'TDLINE'   => $sub_text
		);

	array_push($notice_to_hr_lines, $text_line);
}		
$notice_to_hr_sap = array(	
	array("TABLE","TEXT_LINES", $notice_to_hr_lines)
	);	
$result = $this->callSAPFunction("RFC_SAVE_TEXT", $notice_to_hr_sap);

				/////////////// NOTICE_TO_SALE ///////////////
$notice_to_sale_lines = array();
$notice_to_sale       = iconv("UTF-8", "TIS-620",$updated_doc['notice_to_sale']);
$count = 1;
while (strlen($notice_to_sale) > 0) {
	$sub_text = substr($notice_to_sale, 0, 130);
	$notice_to_sale = substr($notice_to_sale, 130);

	$text_line = array(
		'TDOBJECT' => 'TEXT',
		'TDNAME'   => $default_name.'NOTICE_TO_SALE'.$this->_padZero($count, 3),
		'TDID'     => 'ST',
		'TDSPRAS'  => '2',
		'TDFORMAT' => '*',
		'TDLINE'   => $sub_text
		);

	array_push($notice_to_sale_lines, $text_line);
}		
$notice_to_sale_sap = array(	
	array("TABLE","TEXT_LINES", $notice_to_sale_lines)
	);	
$result = $this->callSAPFunction("RFC_SAVE_TEXT", $notice_to_sale_sap);

				/////////////// NOTICE_TO_STORE ///////////////
$notice_to_store_lines = array();
$notice_to_store       = iconv("UTF-8", "TIS-620",$updated_doc['notice_to_store']);
$count = 1;
while (strlen($notice_to_store) > 0) {
	$sub_text = substr($notice_to_store, 0, 130);
	$notice_to_store = substr($notice_to_store, 130);

	$text_line = array(
		'TDOBJECT' => 'TEXT',
		'TDNAME'   => $default_name.'NOTICE_TO_STORE',
		'TDID'     => 'ST',
		'TDSPRAS'  => '2',
		'TDFORMAT' => '*',
		'TDLINE'   => $sub_text
		);

	array_push($notice_to_store_lines, $text_line);
}		
$notice_to_store_sap = array(	
	array("TABLE","TEXT_LINES", $notice_to_store_lines)
	);	
$result = $this->callSAPFunction("RFC_SAVE_TEXT", $notice_to_store_sap);

				/////////////// NOTICE_TO_TRAINING ///////////////
$notice_to_training_lines = array();
$notice_to_training       = iconv("UTF-8", "TIS-620",$updated_doc['notice_to_training']);
$count = 1;
while (strlen($notice_to_training) > 0) {
	$sub_text = substr($notice_to_training, 0, 130);
	$notice_to_training = substr($notice_to_training, 130);

	$text_line = array(
		'TDOBJECT' => 'TEXT',
		'TDNAME'   => $default_name.'NOTICE_TO_TRAINING',
		'TDID'     => 'ST',
		'TDSPRAS'  => '2',
		'TDFORMAT' => '*',
		'TDLINE'   => $sub_text
		);

	array_push($notice_to_training_lines, $text_line);
}		
$notice_to_training_sap = array(	
	array("TABLE","TEXT_LINES", $notice_to_training_lines)
	);	
$result = $this->callSAPFunction("RFC_SAVE_TEXT", $notice_to_training_sap);
}
}

$doc = $this->__ps_project_query->getObj('tbt_visitation_document', array('id' => $id));
if (!empty($doc)) {

	$this->__ps_project_query->updateObj('tbt_action_plan', array('id' => $doc['action_plan_id']), array('actual_date' => date('Y-m-d')));

	if (empty($p['is_ajax'])) {
		if (!empty($p['submit_sap']) && $p['submit_sap'] == 1) {
			if (!empty($doc['quotation_id'])) {
				redirect(site_url('__ps_visitation/listview_quotation/', 'refresh'));
			} else if (!empty($doc['prospect_id'])) {
				redirect(site_url('__ps_visitation/listview_prospect/', 'refresh'));
			}
		} else {
			if (!empty($doc['quotation_id'])) {
				redirect(site_url('__ps_visitation/detail_quotation/edit_quotation/'.$id.'/'.$p['tab'], 'refresh'));
			} else if (!empty($doc['prospect_id'])) {
				redirect(site_url('__ps_visitation/detail_quotation/edit_prospect/'.$id.'/'.$p['tab'], 'refresh'));
			}
		}
	}
} else {
	if (empty($p['is_ajax'])) {
		redirect(site_url('__ps_visitation/listview_prospect/', 'refresh'));
	}
}
}

function delete($doc_type, $id){

	$emp_id = $this->session->userdata('id');
	$permission = $this->permission[$this->cat_id];

	$action_plan = $this->__ps_project_query->getObj('tbt_action_plan', array('object_id' => $id, 'object_table' => 'tbt_visitation_document'));	
	$doc = $this->__ps_project_query->getObj('tbt_visitation_document', array('id' => $id));

	if (!array_key_exists('delete', $permission) || empty($doc) || $doc['visitor_id'] != $emp_id) {
		redirect('__ps_visitation/listview_quotation');
		return false;
	}
	
	if (!empty($doc) && !empty($action_plan)) {

		$sap_del_ap = array(
			'ID'	 	 => $this->_padZero($action_plan['id'],10)
			);
		$input = array( 
			array("IMPORT","I_MODE","D"),
			array("IMPORT","I_TABLE", "ZTBT_ACTION_PLAN"),
			array("IMPORT","I_DATE", $this->_dateFormat($action_plan['plan_date'])),
			array("IMPORT","I_COMMIT", "X"),
			array("TABLE","IT_ZTBT_ACTION_PLAN", array($sap_del_ap))
			);

		$result = $this->callSAPFunction("ZRFC_MASS_TABLE", $input);

		if ($doc['submit_date_sap'] == '0000-00-00') {
			$result = $this->__visitation_model->delete($doc['action_plan_id'], $id); 
		}
	}	

			//======= submit to sap =====================
			//self::insert_fixclaim_toSap($p,$project_id);
	

	if($doc_type=='prospect'){
		echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
		echo '<script type="text/javascript"> setTimeout(function(){window.location="'.site_url('__ps_visitation/listview_prospect').'"},1200);</script>';
		echo '<script> window.location="'.site_url('__ps_visitation/listview_prospect').'"; </script>';
	}else{

		echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
		echo '<script type="text/javascript">setTimeout(function(){window.location="'.site_url('__ps_visitation/listview_quotation').'"},1200);</script>';
		echo '<script> window.location="'.site_url('__ps_visitation/listview_quotation').'"; </script>';
	}
	
	
}

function upload_image ($id) {

	$p = $this->input->post();
	$target_file = basename($_FILES["uploadFile"]["name"]);
	$ext         = pathinfo($target_file, PATHINFO_EXTENSION);

	if (!is_dir('assets/images/visitation')) {
		mkdir('assets/images/visitation');
	}		

	if (!is_dir('assets/images/visitation'.'/'.$id)) {
		mkdir('assets/images/visitation'.'/'.$id);
	}	

	$doc = $this->__ps_project_query->getObj('tbt_visitation_document', array('id' => $id));

	if (!empty($doc)) {

		$target = 'assets/images/visitation'.'/'.$id.'/'.$target_file;
		if (!file_exists($target)) {
			if (move_uploaded_file($_FILES["uploadFile"]["tmp_name"], $target)) {				

				$file_type = 'doc';
				if ($ext == 'jpg' || $ext == 'gif' || $ext == 'png') {
					$file_type = 'image';
				}

				$this->db->where(array('object_id' => $id, 'object_table' => 'tbt_visitation_document'));
				$this->db->order_by('sequence_index desc');
				$this->db->select('sequence_index');
				$this->db->limit(1);
				$query = $this->db->get('tbt_attach_file');
				$image = $query->row_array();

				$sequence_index = 1;
				if (!empty($image)) {
					$sequence_index = intval($image['sequence_index'])+1;
				}

				$data = array(
					'quotation_id'   => $doc['quotation_id'],
					'file_name'      => $target_file,
					'file_type'	     => $file_type,
					'sequence_index' => $sequence_index,
					'object_id'		 => $id,
					'object_table'	 => 'tbt_visitation_document',
					'path'			 => $target,
					'own_by'		 => $this->session->userdata('id'),
					'contract_id'	 => $doc['contract_id']
					);

				$this->__ps_project_query->insertObj('tbt_attach_file', $data);
			}
		}

		if (!empty($doc['quotation_id'])) {
			redirect(site_url('__ps_visitation/detail_quotation/edit_quotation/'.$id.'/4', 'refresh'));
		} else if (!empty($doc['prospect_id'])) {
			redirect(site_url('__ps_visitation/detail_quotation/edit_prospect/'.$id.'/4', 'refresh'));
		}
	} else {
		redirect(site_url('__ps_visitation/listview_prospect/', 'refresh'));
	}
}

public function download() {

	$input = $this->input->get();
	$filename = $input['img'];
	$filename = urldecode($filename);   

	if (file_exists($filename)) {
			// echo "YES";
		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename='.basename($filename));
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Length: ' . filesize($filename));
		readfile($filename);
		exit;
	} 
}

public function delete_image () {

	$p = $this->input->post();
	if (!empty($p['id'])) {
			// echo $p['id'];
			// die();
		$image = $this->__ps_project_query->getObj('tbt_attach_file', array('id' => $p['id']));
		if (!empty($image)) {
			unlink($image['path']);

			$this->__ps_project_query->deleteObj('tbt_attach_file', array('id' => $p['id']));
		}
	}

	if (!empty($p['callback_url'])) {
		redirect($p['callback_url']);
	}
}

public function sendEmail () {

	$p = $this->input->post();

	if (!empty($p['email']) && !empty($p['message'])) {

		$action_plan = $this->__ps_project_query->getObj('tbt_action_plan', array('object_table' => 'tbt_visitation_document', 'object_id' => $p['id']));
		if (empty($action_plan['actual_date']) || $action_plan['actual_date'] == '0000-00-00') {
			$this->__ps_project_query->updateObj('tbt_action_plan', array('id' => $action_plan['id']), array('actual_date' => date('Y-m-d')));
		}

		$this->__ps_project_query->updateObj('tbt_visitation_document', array('id' => $p['id']), array($p['field'] => $p['message'], $p['email_field'] => $p['email']));

		$doc = $this->__ps_project_query->getObj('tbt_visitation_document', array('id' => $p['id']));

		if (!empty($doc)) {
			$subject = 'Visitation Notification for Doc ID: '.$doc['id'];
			$message = str_replace("\n", "<br>", $p['message']);

			$sender = array (
				"email" => "no-reply@psgen.co.th",
				"name"  => "PSGEN"
				);

			$email_list = explode(',', $p['email']);

			$receiver = array (
				"to" => $email_list
				);

			parent::_sendEmail($subject, $message, $sender, $receiver);

			echo 1;
		}
	}
}

}
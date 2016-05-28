<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class __ps_employee_track extends Admin_Controller {

	function __construct(){
		parent::__construct();

		$this->permission_check('employee_tracker');

		//TODO :: Move this to admin controller later 

		#CMS
		$this->pageSize = PAGESIZE;
		$this->table = 'tbt_employee_track_document';
		$this->page_id = 'ps_generation';
		$this->page_object = 'API';
		$this->page_title = 'ระบบตรวจสอบพนักงาน';
		$this->page_controller = '__ps_employee_track';

		//set lang
		$this->session->set_userdata('lang', 'th');
		
		#END_CMS

		
		$this->load->model('__ps_project_query');
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
		redirect(site_url('__ps_employee_track/listview/list/'.$this->project_id), 'refresh');
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

		$session = $this->session->all_userdata();
		
		$data = array();
		$list = array();				
		
		// var_dump($this->session->userdata('permission_set'));
		switch ($act) { // to tbt_proto_item

			case 'delete':
					//TODO :: implement item delete and multiple item delete 
			break;

			case 'list':
					//TODO :: select list of asset track
			$this->project_id  = urldecode($id);

			$this->load->model('__employee_track_model');	
			$list = $this->__employee_track_model->getContentList($page,$id);
			//get date abort
			$quotation = $this->__ps_project_query->getObj('tbt_quotation', array('id' => $id));
			$this->is_abort = $quotation['is_abort_date'];
			//echo 'isabort : '.$quotation['is_abort'].' '.$quotation['is_abort_date'];


			$menuConfig['page_title'] = 'PS Generation';
			$menuConfig['page_id'] 	  = 'ps_generation';

			$this->load->model('__ps_project_query');
			$list['event_category'] 	= $this->__action_plan_model->allEventCategory();
			$list['isAllowToCreate']    = $this->__action_plan_model->isAllowToCreate($list['result']['project']['contract_id'], $this->cat_id);

					//Load top menu
			$menuConfig = array('page_id'=>1,'pid'=>$id);
			$data['top_menu'] = $this->load->view('__project/include/top',$menuConfig,true);

					//Load side menu
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

			$data['top_project'] = $this->load->view('__employee_track/include/top_project',$info,true);

			$list['contentInfo'] = $contentInfo['result'][0];
					$data['modal'] = $this->load->view('__employee_track/page/list_modal',$list,true);//return view as data

					$list['permission'] = $this->permission[$this->cat_id];
					//Load body
					$data['body'] = $this->load->view('__employee_track/page/list_bodycfg',$list,true);

					$data['project'] = $list['result']['project'];
					// //Load footage script
					$data['footage_script'] = '';


					$this->load->view('__employee_track/layout/list',$data);

					//exit();
					break;	

				}

			}

			function detail($act='',$project_id='',$id=0,$status='0' ){


				$data = array();
				$body = array();		

				$this->page_title = 'ระบบตรวจสอบพนักงาน - ['.$id.']';

		switch ($act) { // to tbt_proto_item

			case 'save':
			 	//TODO :: select check track asset
				//echo "save".$project_id;
			$this->status  = $status;
			$this->project_id  = $project_id;
			$this->track_doc_id  = $id;

			$menuConfig['page_title'] = 'API Manager';
			$menuConfig['page_id'] 	  = 'api_manager';

				//#############  Query #########################################################################
				//Assign parameter for modal
			$this->load->model('__employee_track_model','employee');

				//===== START : fetch clone sap_tbt_project_asset =============================== 
			$check_status_document = $this->employee->getEmployeeDocument($this->track_doc_id);				
			$data_check = $check_status_document->row_array();
			$actual_date =$data_check['actual_date'];

			$permission = $this->permission[$this->cat_id];

			if ( !array_key_exists('edit', $permission) || empty($data_check) ) {
				redirect(site_url('__ps_employee_track/listview/list/'.$project_id, 'refresh'));
			}				    

                //#################################################
				//=========== cLONE SAP ASSET PROJECT==============
				//#################################################
			if($data_check['status'] ==''){  $this->employee->clone_insert_employee($this->track_doc_id,$this->project_id, $data_check['ship_to_id']); }              

                //===== END : fetch clone sap_tbt_project_asset =============================== 

			$list['filter_status'] = $status;
			$list['pid'] = $project_id;
			$list['query_track'] = $this->employee->getContentById('tbt_employee_track',$id, $status);
			$list['query_documet'] = $this->employee->getEmployeeDocument($this->track_doc_id);

			$doc = $list['query_documet']->row();
			if (!empty($doc)) {
				$list['query_question'] = $this->employee->getQuestion('tbm_employee_track_question', $doc->question_revision);
				$list['query_satisfaction_question'] = $this->employee->getQuestion('tbm_employee_track_satisfaction_question', $doc->satisfaction_question_revision);
			}
				//####################################################################################################				

			$menuConfig = array('page_id'=>1,'pid'=>$project_id);
			$data['top_menu'] = $this->load->view('__project/include/top',$menuConfig,true);

				// //Load side menu
			$this->load->model('__ps_project_query');
			$data['side_menu'] = $this->load->view('__project/include/side',$menuConfig,true);

				 // $this->load->model('__ps_project_query');
				 // $data['side_menu'] = $this->load->view('__project/include/side',$menuConfig,true);

				 //Load top project
			$this->load->model('__ps_project_query');
			$info['result']['id'] = $project_id;
			$contentInfo = $this->__ps_project_query->getContentById($project_id);
			$info['detail'] = $contentInfo['result'][0];	
			$projectContact = $this->__ps_project_query->getProjectContacts($project_id);
			$info['contact_list'] = $projectContact['result'];
			$attachDocument = $this->__ps_project_query->getAttachDocumentList($project_id);
			$info['ducument_list'] = $attachDocument['result'];
			$info['result']['view'] = $this->load->view('__project/page/detail_bodycfg_all',$info,true);

			$data['top_project'] = $this->load->view('__employee_track/include/top_project',$info,true);

				//Load body
			$data['body'] = $this->load->view('__employee_track/page/detail_bodycfg',$list,true);

				$data['modal'] = $this->load->view('__employee_track/page/detail_modal',$list,true);//return view as data
				// //Load footage script
				// $data['footage_script'] ='';//$this->load->view('__cms/script/api/api_manager_js','',true);				

				$this->load->view('__employee_track/layout/detail',$data);

				break;

				case 'edit':
				case 'view':	
				//TODO :: select view asset track
				//echo "view".$project_id;
				$this->status  = $status;
				$this->project_id  = $project_id;
				$this->track_doc_id  = $id;

				$menuConfig['page_title'] = 'API Manager';
				$menuConfig['page_id'] 	  = 'api_manager';

				//#############  Query ##############################
				//Assign parameter for modal
				$this->load->model('__employee_track_model','employee');
				$list['filter_status'] = $status;
				$list['query_track'] = $this->employee->getContentById('tbt_employee_track',$id, $status);
				$list['query_documet'] = $this->employee->getEmployeeDocument($this->track_doc_id);

				$doc = $list['query_documet']->row();

				$permission = $this->permission[$this->cat_id];

				if ( !array_key_exists('edit', $permission) || empty($doc) ) {
					redirect(site_url('__ps_employee_track/listview/list/'.$project_id, 'refresh'));
				}				 

				if (!empty($doc)) {
					$list['query_question'] = $this->employee->getQuestion('tbm_employee_track_question', $doc->question_revision);
					$list['query_satisfaction_question'] = $this->employee->getQuestion('tbm_employee_track_satisfaction_question', $doc->satisfaction_question_revision);
				}
				//#########################################################			

				$menuConfig = array('page_id'=>$this->page_id);

				
				$menuConfig = array('page_id'=>1,'pid'=>$project_id);
				$data['top_menu'] = $this->load->view('__project/include/top',$menuConfig,true);

				// //Load side menu
				$this->load->model('__ps_project_query');
				$data['side_menu'] = $this->load->view('__project/include/side',$menuConfig,true);


				//Load top project
				$this->load->model('__ps_project_query');
				$info['result']['id'] = $project_id;
				$contentInfo = $this->__ps_project_query->getContentById($project_id);
				$info['detail'] = $contentInfo['result'][0];	
				$projectContact = $this->__ps_project_query->getProjectContacts($project_id);
				$info['contact_list'] = $projectContact['result'];
				$attachDocument = $this->__ps_project_query->getAttachDocumentList($project_id);
				$info['ducument_list'] = $attachDocument['result'];
				$info['result']['view'] = $this->load->view('__project/page/detail_bodycfg_all',$info,true);

				$data['top_project'] = $this->load->view('__employee_track/include/top_project',$info,true);



				//Load body
				$data['body'] = $this->load->view('__employee_track/page/view_bodycfg',$list,true);

				//Load footage script
				$data['footage_script'] ='';//$this->load->view('__cms/script/api/api_manager_js','',true);

				$this->load->view('__employee_track/layout/view',$data);

				//exit();

				break;

				default:			

				break;
			}

			
		}

		function satisfaction_employee_track() {


			$p = $this->input->post();

			$answer = array();
			foreach ($p as $key => $value) {
				if (strpos($key, 'question_') > -1) {
					$keySplit = explode('_', $key);
					$q_no = $keySplit[1];
					$answer[$q_no]['answer'] = $value;
				}
			}

			$serialized = serialize($answer);

			$this->load->model('__employee_track_model','employee');
			$this->employee->update_satisfaction_answer($p['doc_id'], $p['employee_id'], $serialized, $p['opinion_satisfaction_answer']);

		// redirect(site_url('__ps_employee_track/detail/save/'.$p['pid'].'/1', 'refresh'));

		}

		function check_employee_track() {

			$p = $this->input->post();

			$answer = array();
			foreach ($p as $key => $value) {
				if (strpos($key, 'question_') > -1) {
					$keySplit = explode('_', $key);
					$q_no = $keySplit[1];
					$answer[$q_no]['answer'] = $value;
				}

				if (strpos($key, 'negative_') > -1) {
					$keySplit = explode('_', $key);
					$q_no = $keySplit[1];
					$answer[$q_no]['remark'] = $value;
				}
			}

			$serialized = serialize($answer);

			$this->load->model('__employee_track_model','employee');
			$this->employee->update_check_answer($p['doc_id'], $p['employee_id'], $serialized);

		// redirect(site_url('__ps_employee_track/detail/save/'.$p['pid'].'/1', 'refresh'));
		}

		function get_employee_info() {
			$p = $this->input->post();
			if (!empty($p['id']) && !empty($p['doc'])) {
				$this->load->model('__employee_track_model','employee');
				$employee = $this->employee->getEmployeeInfo($p['id'], $p['doc']);

				$employee['employee_id'] = defill($employee['employee_id']);
				if (!empty($employee)) {
					$employee['answer'] = unserialize($employee['answer']);
					$employee['satisfaction_answer'] = unserialize($employee['satisfaction_answer']);

					$emp_pic_folder = $this->config->item('emp_pic_folder');
					$param = site_url($emp_pic_folder.$p['id'].'.jpg'); 

					$curlSession = curl_init();
					curl_setopt($curlSession, CURLOPT_URL, $param);
					curl_setopt($curlSession, CURLOPT_BINARYTRANSFER, true);
					curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, true);

					$objFopen = curl_exec($curlSession);

					if (strpos($objFopen, '404 Page Not Found') == ""){
						$employee['image'] = $param ;
					}
				}

				echo json_encode($employee);
			}
		}

		function update_track_employee($id,$project_id){

		//echo  $id ;	
		///////////////////////////////////////////////////////////
		//Query serail track_asset
			$this->load->model('__employee_track_model','employee');

        ///////////////////////////////////////////////////////////	


			$post =  $this->input->post();
			if(!empty($post)){

				$this->updateDocLog('tbt_employee_track_document', $id);

				 //=================start: update tbt_asset_track_document======
				$action_plan_id =  $post['plan_id'];
				$actual_date = $post['actual_date'];
				$actor_id = $post['actor_by_id'];

				if (!empty($actual_date)||$actual_date!='0000-00-00'){
					$actual_date =date("Y-m-d"); 
				}else{
					$actual_date = $post['actual_date'];
				}

				$data_plan = array(
					'actual_date' => $actual_date		            	      
					);

				$this->db->where('id', $action_plan_id);
				$query=$this->db->update('tbt_action_plan', $data_plan);

		   		//================= end : update tbt_asset_track_document======

				//============= start : update tbt_track_asset ===============
				$this->db->where('employee_track_document_id', $id);
				$Query_asset_track= $this->db->get('tbt_employee_track');


				$doc = $this->__ps_project_query->getObj('tbt_employee_track_document', array('id' => $id));
				$sap_emp_data = array();
				$sap_emp_result_data = array();
				$sap_emp_satisfaction_result_data = array();
				$docStatus = 'check';
				foreach ($Query_asset_track->result_array() as $row){ 
					$serial_query = $row['employee_id'];
		    			//echo $serial_query.'<br><br>';		         
					$statusx = 'radio_'.$serial_query;
					$remarkx = 'remark_'.$serial_query;

					if (array_key_exists($serial_query, $post)) {

						$serial = $post[$serial_query];

						$status_tracking = "";
						if (!empty($post[$statusx])) {
							$status_tracking = $post[$statusx];
						}

						$remark = "";
						if (!empty($post[$statusx])) {
							$remark = $post[$remarkx];
						}


						if(empty($status_tracking)) {
							$docStatus = 'warning';
						}
					  		//==== call mode update
						$this->employee->update($serial,$status_tracking,$remark,$id);

						if (!empty($post['submit']) && $post['submit'] == 1 ) {

							$emp = $this->__ps_project_query->getObj('tbt_employee_track', array('employee_id' => $serial, 'employee_track_document_id' => $id));

							$emp_status = '';
							if ($status_tracking == 'NOT_EXIST') {
								$emp_status = 1;
							} else if ($status_tracking == 'UNCHECK') {
								$emp_status = 2;
							} else if ($status_tracking == 'EXIST') {
								$emp_status = 0;
							}

							$emp_level = 0;
							if ($emp['employee_level'] == 'head') {
								$emp_level = 1;
							}

							$opinion = $emp['opinion_satisfaction_answer'];
							$opinion1 = substr($opinion, 0, 512);
							$opinion2 = substr($opinion, 512);

							$emp_data = array(
								'EMP_TRACK_DOC_ID' => $this->_padZero($id, 10),
								'EMPLOYEE_ID'	   => $this->_padZero($serial, 15),
								'STATUS' 		   => $emp_status,
								'EMPLOYEE_LEVEL'   => $emp_level,
								'REMARK'		   => iconv("UTF-8", "TIS-620",$remark),
								'OPINION_ANS'	   => iconv("UTF-8", "TIS-620",$opinion1),
								'OPINION_ANS2'	   => iconv("UTF-8", "TIS-620",$opinion2)
								);

							array_push($sap_emp_data, $emp_data);

							$serialized_answer = unserialize($emp['serialized_answer']);
							$serialized_satisfaction_answer = unserialize($emp['serialized_satisfaction_answer']);

							if (!empty($serialized_answer)) {

								foreach ($serialized_answer as $q_no => $answer_set) {
									$answer = $answer_set['answer'];
									$answer = iconv("UTF-8", "TIS-620",$answer);
									$remark = "";

									if (array_key_exists('remark', $answer_set)) {
										$remark = $answer_set['remark'];
										$remark = iconv("UTF-8", "TIS-620",$remark);
									}

									$result_data = array(
										'EMP_TRACK_DOC_ID' 		=> $this->_padZero($id, 10),
										'EMPLOYEE_ID'	   		=> $this->_padZero($serial, 15),
										'QUESTION_ID' 		   	=> $this->_padZero($q_no, 10),
										'QUESTION_REVISION'  	=> $this->_padZero($doc['question_revision'], 4),
										'ANSWER'		 		=> $answer,
										'ANSWER_REMARK'		   	=> $remark
										);

									array_push($sap_emp_result_data, $result_data);
								}
							}

							if (!empty($serialized_satisfaction_answer)) {
								foreach ($serialized_satisfaction_answer as $q_no => $answer_set) {
									$answer = $answer_set['answer'];
									$answer = iconv("UTF-8", "TIS-620",$answer);

									$question = $this->__ps_project_query->getObj('tbm_employee_track_satisfaction_question', array('id' => $q_no, 'revision_id' => $doc['satisfaction_question_revision']));

									if (!empty($question)) {
										$satisfaction_result_data = array(
											'EMP_TRACK_DOC_ID' 		=> $this->_padZero($id, 10),
											'EMPLOYEE_ID'	   		=> $this->_padZero($serial, 15),
											'QUESTION_ID' 		   	=> $this->_padZero($q_no, 10),
											'QUESTION_REVISION'  	=> $this->_padZero($doc['satisfaction_question_revision'], 4),
											'ANSWER'		 		=> $answer,
											'IS_FOR_HEAD'		   	=> $question['is_for_head']
											);

										array_push($sap_emp_satisfaction_result_data, $satisfaction_result_data);
									}
								}
							}
						}
					}

		    	}//end foreach
		    	
		    	$project = $this->__ps_project_query->getObj('tbt_quotation', array('id' => $doc['quotation_id']));

		    	$data_doc = array(		
		    		'actual_date' => date('Y-m-d'),
		    		'contract_id' => $project['contract_id'],
		    		'actor_by_id' => $actor_id,
		    		'status'=> $docStatus	      
		    		);

		    	$this->db->where('id', $id);
		    	$query=$this->db->update('tbt_employee_track_document', $data_doc);

		    	if (!empty($post['submit']) && $post['submit'] == 1 ) {

		    		$date_time = $this->_dateFormat(date('Y-m-d'));

		    		$submit_date_data_doc = array(		            
		    			'submit_date_sap' => date('Y-m-d h:i:s')
		    			);

		    		$this->db->where('id', $id);
		    		$query=$this->db->update('tbt_employee_track_document', $submit_date_data_doc);

		    		$actionplan = $this->__ps_project_query->getObj('tbt_action_plan', array('id' => $doc['action_plan_id']));					

		    		$this->__ps_project_query->updateObj('tbt_action_plan', array('id' => $actionplan['id']), array('submit_date_sap' => date('Y-m-d')));

		    		$items = array();
		    		$item1 = array(
		    			"EVENT_CATEGORY_ID" => $this->_padZero($actionplan['event_category_id'], 5),
		    			"ID"     			=> $this->_padZero($actionplan['id'], 10),
		    			"TITLE" 			=> iconv("UTF-8", "TIS-620",$actionplan['title']),
		    			"ACTOR_ID" 			=> $this->_padZero($actionplan['actor_id'], 15),
		    			"PLAN_DATE" 		=> $this->_dateFormat($actionplan['plan_date']),
		    			'ACTUAL_DATE'		=> date('Ymd'),
		    			'ACTUAL_TIME'		=> date('his'),
		    			"PROJECT_ID" 		=> $this->_padZero($actionplan['quotation_id'], 10),
		    			"SHIP_TO_ID" 		=> $this->_padZero($actionplan['ship_to_id'], 10),
		    			"SOLD_TO_ID" 		=> $this->_padZero($actionplan['sold_to_id'], 10),
		    			'OBJECT_TABLE'		=> 'tbt_employee_track_document',
		    			'OBJECT_ID'			=> $this->_padZero($doc['id'], 10),
		    			'PRE_ID'			=> $actionplan['pre_id'],
		    			'CREATE_DATE'		=> date('Ymd', strtotime($actionplan['create_date'])),
		    			'CREATE_TIME'		=> date('his', strtotime($actionplan['create_date']))
		    			);

array_push($items, $item1);

$input = array( 
	array("IMPORT","I_MODE","M"),
	array("IMPORT","I_TABLE", "ZTBT_ACTION_PLAN"),
	array("IMPORT","I_DATE", $this->_dateFormat($actionplan['plan_date'])),
	array("IMPORT","I_COMMIT", "X"),
	array("TABLE","IT_ZTBT_ACTION_PLAN", $items)
	);

$result = $this->callSAPFunction("ZRFC_MASS_TABLE", $input);

$doc_status = 0;
if ($doc['status'] == 'check') {
	$doc_status = 2;
} else if ($doc['status'] == 'warning') {
	$doc_status = 1;
}

$sap_doc_data = array(
	'ID'	 			=> $this->_padZero($doc['id'], 10),
	'TITLE' 			=> iconv("UTF-8", "TIS-620",$doc['title']),
	'STATUS' 			=> $doc_status,
	'ACTION_PLAN_ID'	=> $this->_padZero($doc['action_plan_id'], 10),
	'PLAN_DATE' 		=> $this->_dateFormat($actionplan['plan_date']),
	'SURVEY_OFFICER_ID' => $this->_padZero($doc['survey_officer_id'], 15),
	'PROJECT_OWNER_ID' 	=> $this->_padZero($project['project_owner_id'], 15),
	'ACTOR_BY_ID' 		=> $this->_padZero($doc['actor_by_id'], 15),
	'PROJECT_ID' 		=> $this->_padZero($doc['quotation_id'], 10),
	'SHIP_TO_ID' 		=> $this->_padZero($doc['ship_to_id'], 10),
	'CONTRACT_ID' 		=> $this->_padZero($doc['contract_id'], 10),
	'ACTUAL_DATE' 		=> $this->_dateFormat($doc['actual_date']),
	'SUBMIT_DATE_SAP' 	=> $this->_dateFormat(date('Y-m-d')),
	);

$input 	=	array(	
	array("IMPORT","I_MODE","M"),
	array("IMPORT","I_TABLE", "ZTBT_EMP_TR_DOC"),
	array("IMPORT","I_DATE", $date_time),
	array("IMPORT","I_COMMIT", "X"),
	array("TABLE","IT_TBT_EMP_TR_DOC", array($sap_doc_data))
	);		


$result = $this->callSAPFunction("ZRFC_MASS_TABLE", $input);

$input 	=	array(	
	array("IMPORT","I_MODE","M"),
	array("IMPORT","I_TABLE", "ZTBT_EMP_TR_STA"),
	array("IMPORT","I_DATE", $date_time),
	array("IMPORT","I_COMMIT", "X"),
	array("TABLE","IT_TBT_EMP_TR_STA", $sap_emp_data)
	);		
$result = $this->callSAPFunction("ZRFC_MASS_TABLE", $input);

if (!empty($sap_emp_result_data)) {
	$input 	=	array(	
		array("IMPORT","I_MODE","M"),
		array("IMPORT","I_TABLE", "ZTBT_EMP_TR_RS"),
		array("IMPORT","I_DATE", $date_time),
		array("IMPORT","I_COMMIT", "X"),
		array("TABLE","IT_TBT_EMP_TR_RS", $sap_emp_result_data)
		);		
	$result = $this->callSAPFunction("ZRFC_MASS_TABLE", $input);
}

if (!empty($sap_emp_satisfaction_result_data)) {
	$input 	=	array(	
		array("IMPORT","I_MODE","M"),
		array("IMPORT","I_TABLE", "ZTBT_EMP_TR_S_RE"),
		array("IMPORT","I_DATE", $date_time),
		array("IMPORT","I_COMMIT", "X"),
		array("TABLE","IT_TBT_EMP_TR_S_RE", $sap_emp_satisfaction_result_data)
		);		

	$result = $this->callSAPFunction("ZRFC_MASS_TABLE", $input);
}	


}

echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";				

if (!empty($post['submit']) && $post['submit'] == 1 ) {
	echo '<script> window.location="'.site_url('__ps_employee_track/listview/list/'.$project_id).'"; </script>';
} else {				 
	echo '<script type="text/javascript">  alert("แก้ไขเรียบร้อย"); setTimeout(function(){window.location="'.site_url('__ps_employee_track/detail/save/'.$project_id.'/'.$id).'"},1200);</script>';			    			  
	echo '<script> window.location="'.site_url('__ps_employee_track/detail/save/'.$project_id.'/'.$id).'"; </script>';
}

		  }// end if

		  exit();
		}

		function delete($id,$table,$project_id,$actionplan_id){
		//exit();

		//remove from database 
			$this->load->model('__employee_track_model','clistq');

			$action_plan = $this->__ps_project_query->getObj('tbt_action_plan', array('id' => $actionplan_id));	

			$emp_id = $this->session->userdata('id');
			$permission = $this->permission[$this->cat_id];
			if ( !array_key_exists('delete', $permission) || empty($action_plan) || $action_plan['actor_id'] != $emp_id ) {
				redirect(site_url('__ps_employee_track/listview/list/'.$project_id, 'refresh'));
			}				    

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

			$list = $this->clistq->delete($id,$table,$actionplan_id);

			if (!empty($action_plan['pre_id']) && $action_plan['pre_id'] != 0) {
				$this->delete($action_plan['object_id'],$table, $project_id, $action_plan['pre_id']);
			} else {
				redirect(site_url('__ps_employee_track/listview/list/'.$project_id), 'refresh');
			}

		}


	}
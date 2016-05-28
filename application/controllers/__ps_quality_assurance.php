<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class __ps_quality_assurance extends Admin_Controller {

	function __construct(){
		parent::__construct();

		$this->permission_check('quality_assurance');

		//TODO :: Move this to admin controller later 

		#CMS
		$this->pageSize = PAGESIZE;
		$this->table = 'tbt_quality_survey';
		$this->page_id = 'ps_generation';
		$this->page_object = 'API';
		$this->page_title = 'ระบบตรวจสอบคุณภาพ';
		$this->page_controller = '__ps_quality_assurance';

		//set lang
		$this->session->set_userdata('lang', 'th');
		
		#END_CMS

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
		redirect(site_url('__ps_quality_assurance/listview/list/'.$this->project_id), 'refresh');
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
	function listview($act='',$id ='',$page=1, $keyword=''){

		$session = $this->session->all_userdata();
		
		$data = array();
		$list = array();				
		
		// var_dump($this->session->userdata('permission_set'));
		switch ($act) { // to tbt_proto_item

			case 'delete':
					//TODO :: implement item delete and multiple item delete 
			break;

			case 'list':
			// $start_track = time();
			// echo $start_track."<br>";
					//TODO :: select list of asset track
			$this->project_id  = urldecode($id);

			$list = $this->__quality_assurance_model->getContentList($page,$id);
					//get date abort
			$quotation = $this->__ps_project_query->getObj('tbt_quotation', array('id' => $id));
			$this->is_abort = $quotation['is_abort_date'];
					//echo 'isabort : '.$quotation['is_abort'].' '.$quotation['is_abort_date'];				

			// $first_phase = time();
			// echo 'first_phase:'.$first_phase." diff ".($first_phase - $start_track)."<br>";

			$menuConfig['page_title'] = 'PS Generation';
			$menuConfig['page_id'] 	  = 'ps_generation';

			$this->load->model('__ps_project_query');
			$list['event_category'] 	= $this->__action_plan_model->allEventCategory();
			$list['isAllowToCreate']    = $this->__action_plan_model->isAllowToCreate($list['result']['project']['contract_id'], $this->cat_id);

			// $sec_phase = time();
			// echo 'sec_phase:'.$sec_phase." diff ".($sec_phase - $first_phase)."<br>";
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

			$data['top_project'] = $this->load->view('__quality_assurance/include/top_project',$info,true);

			$list['contentInfo'] = $contentInfo['result'][0];
			$data['modal'] = $this->load->view('__quality_assurance/page/list_modal',$list, true);

			$list['permission'] = $this->permission[$this->cat_id];
					//Load body
			$data['body'] = $this->load->view('__quality_assurance/page/list_bodycfg',$list,true);

			$data['project'] = $list['result']['project'];
					// //Load footage script
			$data['footage_script'] = '';
			// $third_phase = time();
			// echo 'third_phase:'.$third_phase." diff ".($third_phase - $sec_phase)."<br>"; die();


			$this->load->view('__quality_assurance/layout/list',$data);

					//exit();
			break;	

		}

	}

	function getFloor () {

		$p = $this->input->post();
		if (!empty($p['building_id'])) {
			$floor_list = $this->__quality_assurance_model->getAllFloor($p['building_id']);

			if (!empty($floor_list)) {	
				echo json_encode($floor_list);
				return ;
			}

			echo 0;
		}
		echo 0;
	}

	function getArea () {

		$p = $this->input->post();
		$quotation = $this->__ps_project_query->getObj('tbt_quotation', array('id' => $p['quotation_id']));
		$area_list = $this->__ps_project_query->getObj('sap_tbm_industry_room', array('industry_id' => $quotation['ship_to_industry']), true);

		if (!empty($area_list)) {	
			echo json_encode($area_list);
			return ;
		}

		echo 0;
	}

	function manager_view ($project_id, $id) {

		$this->project_id  = $project_id;
		$this->track_doc_id  = $id;

		$data = array();

		$menuConfig = array('page_id'=>1,'pid'=>$project_id);
		$data['top_menu'] = $this->load->view('__project/include/top',$menuConfig,true);
		$data['side_menu'] = $this->load->view('__project/include/side',$menuConfig,true);

		$list['data_document'] = $this->__quality_assurance_model->getManagerDocument($this->track_doc_id);

		$permission = $this->permission[$this->cat_id];
		if ( !array_key_exists('approve', $permission) || empty($list['data_document']) || $list['data_document']['status'] != 'complete' ) {
			redirect(site_url('__ps_quality_assurance/listview/list/'.$project_id, 'refresh'));
		}	

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

		$data['top_project'] = $this->load->view('__quality_assurance/include/top_project',$info,true);
		$data['body'] = $this->load->view('__quality_assurance/page/manager_view_bodycfg',$list,true);
		$data['script'] = $this->load->view('__quality_assurance/script/manager_view_js',$list,true);

		$this->load->view('__quality_assurance/layout/view',$data);
	}

	function manager_update () {

		$p = $this->input->post();

		// echo "<pre>";
		// print_r($p);
		// echo "</pre>";

		// die();

		$status ='being';
		if (!empty($p['approve']) && $p['approve'] == 1){
			$status ='approved';
		}

		$doc_update = array(
			'is_manager_edit' => 0,
			'status' => $status,
			'min_pass_score' => $p['min_pass_score']
			);
		if (!empty($p['area'])) {
			$doc_update['area'] = $p['area'];
		}

		$this->db->where('id', $p['id']);
		$this->db->update('tbt_quality_survey', $doc_update);

		$area_list = preg_grep("/^area_/",array_keys($p));

		$tmp = array();

		$max = 0;		
		foreach ($area_list as $key) {
			$area = $p[$key];

			if ($max == 0 || intval($area['index']) > $max) {
				$max = intval($area['index']);
			}

			if ($area['index'] == "") {
				array_push($tmp, $key);
			}
		}

		foreach ($tmp as $key) {
			$p[$key]['index'] = $max+1;
			$max++;
		}

		$this->db->where('quality_survey_id',$p['id']);
		$this->db->delete('tbt_quality_survey_area');

		foreach ($area_list as $key) {
			$key_parts = explode('_', $key);
			$building_id   	  = $key_parts[2];
			$floor_id   	  = $key_parts[3];
			$industry_room_id = $key_parts[4];
			$area_name = $p[$key]['name'];
			$order_index = $p[$key]['index'];
			$id = $p[$key]['id'];

			$is_origin = 0;
			if (array_key_exists('origin', $p[$key])) {
				$is_origin = $p[$key]['origin'];
			}

			$is_select = 1;
			if (!array_key_exists('select', $p[$key])) {
				$is_select = 0;
			}

			$revision_id = $this->__quality_assurance_model->getQuestionRevision('tbm_quality_survey_area_question', $industry_room_id);

			$pre_id = 0;
			if (!empty($prev_doc)) {
				$this->db->where('id', $id);
				$query = $this->db->get('tbt_quality_survey_area');
				$area_obj = $query->row_array();

				if (!empty($area_obj)) {
					$pre_id = $area_obj['prev_id'];
				}
			}

			$data = array(
				'building_id'			=> $building_id,
				'floor_id'				=> $floor_id,
				'industry_room_id'		=> $industry_room_id,
				'area_name' 			=> $area_name,
				'order_index' 			=> $order_index,
				'is_select' 			=> $is_select,
				'quality_survey_id' 	=> $p['id'],
				'question_revision_id' 	=> $revision_id,
				'is_origin'			   	=> $is_origin,
				'prev_id'				=> $pre_id
				);

			$this->db->insert('tbt_quality_survey_area', $data);
		}

		if (!empty($p['approve']) && $p['approve'] == 1){
			redirect(site_url('__ps_quality_assurance/listview/list/'.$p['project_id'], 'refresh'));
		} else {
			redirect(site_url('__ps_quality_assurance/manager_edit/'.$p['project_id'].'/'.$p['id'], 'refresh'));
		}

	}


	function manager_edit ($project_id, $id, $sort=null) {

		$this->page_title = 'ระบบตรวจสอบคุณภาพ - ['.$id.']';

		$this->project_id  = $project_id;
		$this->track_doc_id  = $id;

		$data = array();

		$menuConfig = array('page_id'=>1,'pid'=>$project_id);
		$data['top_menu'] = $this->load->view('__project/include/top',$menuConfig,true);
		$data['side_menu'] = $this->load->view('__project/include/side',$menuConfig,true);

		$list['data_document'] = $this->__quality_assurance_model->getDocument($this->track_doc_id, false, $sort);


		if ( !empty($list['data_document']) ) {
			$list['building_list'] = $this->__quality_assurance_model->getAllBuilding($list['data_document']['contract_id']);

			if ($list['data_document']['status'] == 'approved' || $list['data_document']['status'] == 'complete') {
				redirect(site_url('__ps_quality_assurance/listview/list/'.$list['data_document']['quotation_id']), 'refresh');
			}

			$area_list = $this->__ps_project_query->getObj('tbt_quality_survey_area', array('quality_survey_id' => $this->track_doc_id), true);

			if ($list['data_document']['is_manager_edit'] == 0 && empty($area_list)) {

				$this->__ps_project_query->deleteObj('tbt_quality_survey_area', array('quality_survey_id' => $this->track_doc_id));
				$this->__quality_assurance_model->cloneArea($this->track_doc_id, $list['data_document']['contract_id']);

				redirect(site_url('__ps_quality_assurance/manager_edit/'.$project_id.'/'.$id), 'refresh');
				// $list['data_document'] = $this->__quality_assurance_model->getDocument($this->track_doc_id, false, $sort);
			}
		}	

		// echo "<pre>";
		// print_r($list['data_document']);
		// echo "</pre>";

		// die();


		$permission = $this->permission[$this->cat_id];
		if ( !array_key_exists('approve', $permission) || empty($list['data_document']) || $list['data_document']['status'] == 'approved' || $list['data_document']['status'] == 'complete' ) {
			redirect(site_url('__ps_quality_assurance/listview/list/'.$project_id, 'refresh'));
		}	

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

		$list['sort'] = $sort;
		$data['top_project'] = $this->load->view('__quality_assurance/include/top_project',$info,true);
		$data['body'] = $this->load->view('__quality_assurance/page/manager_edit_bodycfg',$list,true);
		$data['script'] = $this->load->view('__quality_assurance/script/manager_edit_js',$list,true);

		$this->load->view('__quality_assurance/layout/detail',$data);
	}

	function detail($act='',$project_id='',$id=0,$status='0' ){

		ini_get('max_execution_time');
		ini_set('memory_limit', '8000M');
		set_time_limit (0);	    

		$data = array();
		$body = array();		

		$this->page_title = 'ระบบตรวจสอบคุณภาพ - ['.$id.']';

		switch ($act) { // to tbt_proto_item

			case 'save':
			$this->project_id  = $project_id;
			$this->track_doc_id  = $id;

			$data = array();

			$menuConfig = array('page_id'=>1,'pid'=>$project_id);
			$data['top_menu'] = $this->load->view('__project/include/top',$menuConfig,true);
			$data['side_menu'] = $this->load->view('__project/include/side',$menuConfig,true);

			$list['data_document'] = $this->__quality_assurance_model->getDocument($this->track_doc_id, true);

			$function = $this->session->userdata('function');
			$permission = $this->permission[$this->cat_id];

			if ( !array_key_exists('edit', $permission) || empty($list['data_document']) || (!in_array('HR', $function) && $list['data_document']['status'] == 'complete') || (in_array('HR', $function) && $list['data_document']['hr_submit_date_sap'] != '0000-00-00') ) {
				redirect(site_url('__ps_quality_assurance/listview/list/'.$project_id, 'refresh'));
			}				    

			if ( !empty($list['data_document']) ) {
				$list['building_list'] = $this->__quality_assurance_model->getAllBuilding($list['data_document']['contract_id']);

				if (!in_array('HR', $function) && $list['data_document']['status'] == 'complete') {
					redirect(site_url('__ps_quality_assurance/listview/list/'.$list['data_document']['quotation_id']), 'refresh');
				}

				$area_list = $this->__ps_project_query->getObj('tbt_quality_survey_area', array('quality_survey_id' => $this->track_doc_id), true);				
				if ($list['data_document']['is_manager_edit'] == 0 && empty($area_list)) {
					$this->__ps_project_query->deleteObj('tbt_quality_survey_area', array('quality_survey_id' => $this->track_doc_id));				
					$this->__quality_assurance_model->cloneArea($this->track_doc_id, $list['data_document']['contract_id']);						

					redirect(site_url('__ps_quality_assurance/detail/save/'.$project_id.'/'.$id), 'refresh');

						// $list['data_document'] = $this->__quality_assurance_model->getDocument($this->track_doc_id, true);				        
				}
			}

			$list['signature'] = $this->__ps_project_query->getObj('tbt_quality_signature', array('quality_document_id' => $id));


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

			$data['top_project'] = $this->load->view('__quality_assurance/include/top_project',$info,true);
			$data['modal'] = $this->load->view('__quality_assurance/page/detail_modal',$list,true);
			$data['body'] = $this->load->view('__quality_assurance/page/detail_bodycfg',$list,true);
			$data['script'] = $this->load->view('__quality_assurance/script/detail_js',$list,true);

			$this->load->view('__quality_assurance/layout/detail',$data);

			break;

			case 'edit':
			case 'view':
			$this->project_id  = $project_id;
			$this->track_doc_id  = $id;

			$data = array();

			$menuConfig = array('page_id'=>1,'pid'=>$project_id);
			$data['top_menu'] = $this->load->view('__project/include/top',$menuConfig,true);
			$data['side_menu'] = $this->load->view('__project/include/side',$menuConfig,true);

			$list['data_document'] = $this->__quality_assurance_model->getDocument($this->track_doc_id, true);

			if ( !empty($list['data_document']) ) {
				$list['answer_list']   = $this->__quality_assurance_model->getViewAnswer($list['data_document']['id'], $list['data_document']['contract_id']);
				$list['building_list'] = $this->__quality_assurance_model->getAllBuilding($list['data_document']['contract_id']);
			}

			$list['signature'] = $this->__ps_project_query->getObj('tbt_quality_signature', array('quality_document_id' => $id));

				// echo "<pre>";
				// print_r($list['answer_list']);
				// echo "</pre>";
				// die();

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

			$data['top_project'] = $this->load->view('__quality_assurance/include/top_project',$info,true);
			$data['modal'] = $this->load->view('__quality_assurance/page/view_modal',$list,true);
			$data['body'] = $this->load->view('__quality_assurance/page/view_bodycfg',$list,true);
			$data['script'] = $this->load->view('__quality_assurance/script/view_js',$list,true);

			$this->load->view('__quality_assurance/layout/view',$data);

			break;
			
			default:			

			break;
		}


	}

	function delete_image () {

		$p = $this->input->post();

		$target_file =  basename($p["path"]);
		
		if (file_exists('assets/images/'.$p['area_id'].'/'.$p['question_id'].'/'.$target_file)) {
			$this->db->where('id', $p['area_id']);	
			$query = $this->db->get('tbt_quality_survey_area');
			$row = $query->row_array();

			if (!empty($row)) {
				$answer = $row['serialized_answer'];
				if (!empty($answer)) {
					$answer = unserialize($answer);
					if (array_key_exists($p['question_id'], $answer)) {
						$image_list = $answer[$p['question_id']]['images'];
						if (!empty($image_list)) {
							$image_result = array();
							foreach ($image_list as $key => $image) {
								if ($image != 'assets/images/'.$p['area_id'].'/'.$p['question_id'].'/'.$target_file) {
									array_push($image_result, $image);
								}
							}

							$answer[$p['question_id']]['images'] = $image_result;
							$answer = serialize($answer);
							$this->db->where('id', $p['area_id']);	
							$this->db->update('tbt_quality_survey_area', array('serialized_answer' => $answer));
						}
					}
				}

			}

			unlink('assets/images/'.$p['area_id'].'/'.$p['question_id'].'/'.$target_file);
		}

		redirect(site_url('__ps_quality_assurance/detail/save/'.$p['project_id'].'/'.$p['doc_id']), 'refresh');
	}

	function upload_image () {
		$user_id = $this->session->userdata('id');

		$p = $this->input->post();
		//$target_file =  basename($_FILES["uploadFile"]["name"]);
		$target_file = $user_id.'_'.time();

		if (!is_dir('assets/images/'.$p['area_id'])) {
			mkdir('assets/images/'.$p['area_id']);
		}		

		if (!is_dir('assets/images/'.$p['area_id'].'/'.$p['question_no'])) {
			mkdir('assets/images/'.$p['area_id'].'/'.$p['question_no']);
		}	

		if (!file_exists('assets/images/'.$p['area_id'].'/'.$p['question_no'].'/'.$target_file)) {
			if (move_uploaded_file($_FILES["uploadFile"]["tmp_name"], 'assets/images/'.$p['area_id'].'/'.$p['question_no'].'/'.$target_file)) {
				
				$this->db->where('id', $p['area_id']);	
				$query = $this->db->get('tbt_quality_survey_area');
				$row = $query->row_array();

				if (!empty($row)) {
					$answer = $row['serialized_answer'];
					if (empty($answer)) {
						$answer[$p['question_no']]['images'] = array();
					} else {
						$answer = unserialize($answer);
						if (!array_key_exists($p['question_no'], $answer)) {
							$answer[$p['question_no']]['images'] = array();
						}

						if (!array_key_exists('images', $answer[$p['question_no']])) {
							$answer[$p['question_no']]['images'] = array();
						}

					}

					array_push($answer[$p['question_no']]['images'], 'assets/images/'.$p['area_id'].'/'.$p['question_no'].'/'.$target_file);
					$answer = serialize($answer);
					$this->db->where('id', $p['area_id']);	
					$this->db->update('tbt_quality_survey_area', array('serialized_answer' => $answer));
				}

			}
		}

		redirect(site_url('__ps_quality_assurance/detail/save/'.$p['project_id'].'/'.$p['doc_id']), 'refresh');
	}

	public function generateCode ($len, $id) {

		$int = rand(0, 9);
		$len--;

		if ($len > 0) {
			$str = $int.$this->generateCode($len, $id);
			// echo $len.' | '.$str.'<br>';
			if ($len==5) {
				// echo "HI<br>";
				$signature_obj = $this->__ps_project_query->getObj('tbt_quality_signature', array('quality_document_id !=' => $id, 'request_code' => $str));
				if (!empty($signature_obj)) {
					$str = $this->generateCode(6, $id);
				}
			}
			return $str;
		} else {
			return $int;
		}
	}

	public function generateSignatureCode () {

		$p = $this->input->post();

		if (!empty($p['id'])) {

			$code = $this->generateCode(6, $p['id']);
			$signature_obj = $this->__ps_project_query->getObj('tbt_quality_signature', array('quality_document_id' => $p['id']));
			if (!empty($signature_obj)) {
				$this->__ps_project_query->updateOBj('tbt_quality_signature', array('quality_document_id' => $p['id']), array('request_code' => $code));
			} else {
				$this->__ps_project_query->insertOBj('tbt_quality_signature', array('quality_document_id' => $p['id'], 'request_code' => $code));
			}
			echo $code;
		}
	}

	public function checkSignatureCode () {

		$p = $this->input->post();

		if (!empty($p['code'])) {

			$signature_obj = $this->__ps_project_query->getObj('tbt_quality_signature', array('request_code' => $p['code']));

			if (!empty($signature_obj)) {
				echo json_encode(array(
					"status"=>true,
					"errorCode"=>'000',
					"message"=>'',
					"result"=>$signature_obj
					));
			} else {
				$state = false;
				$code = '909';
				$msg = 'request counldn\' be complete , parameter -code is not match .';
				$output = array();

				echo json_encode(array("status"=>$state,"errorCode"=>$code,"message"=>$msg,"result"=>$output));	
			}

		} else {
			$state = false;
			$code = '909';
			$msg = 'request counldn\' be complete , parameter -code is missing .';
			$output = array();
			echo json_encode(array("status"=>$state,"errorCode"=>$code,"message"=>$msg,"result"=>$output));	
		}
	}

	public function getSignature() {

		$p = $this->input->post();

		if (!empty($p['id'])) {

			$signature_obj = $this->__ps_project_query->getObj('tbt_quality_signature', array('quality_document_id' => $p['id']));
			if (!empty($signature_obj)) {
				
				if (!empty($signature_obj['signature'])) {
					echo site_url($signature_obj['signature']);
					return 1;
				}
			}
		}

		echo 0;
	}

	public function uploadSignature(){
		/*
		param - doc_id
		return - status,message
		*/

		$param = $this->input->post();

		//Create upload dir
		$uploaddir = 'assets/images/quality_signature/';
		if( !is_dir($uploaddir) ) {
			mkdir($uploaddir);
		}//End create dir


		if(!isset($_FILES['signature_image'])){
			// die('x');
			$state = false;
			$code = '909';
			$msg = 'request counldn\' be complete , parameter -signature_image is missing .';
			$output = array();
			echo json_encode(array("status"=>$state,"errorCode"=>$code,"message"=>$msg,"result"=>$output));			
			// echo json_encode($result );
		}


		if( $_FILES['signature_image']['type'] == 'image/jpg' || $_FILES['signature_image']['type'] == 'image/jpeg' ){
			$type ='.jpg';
		}else if($_FILES['signature_image']['type'] == 'image/png'){
			$type ='.png';
		}else if($_FILES['signature_image']['type'] == 'application/octet-stream'){	

			$type = substr($_FILES['signature_image']['name'], -4);
			if($type == 'jpeg'){
				$type = '.jpg';
			}else if($type == '.jpg' || $type == '.png'){
				//Do nothing
			}else{
				$state = false;
				$code = '909';
				$msg = 'request counldn\' be complete , invalid file type [allowed only jpg and png image]';
				$output = array($_FILES);
				echo json_encode(array("status"=>$state,"errorCode"=>$code,"message"=>$msg,"result"=>$output));			
			}
		}else{
			$state = false;
			$code = '909';
			$msg = 'request counldn\' be complete , invalid file type [allowed only jpg and png image]';
			$output = array($_FILES);
			echo json_encode(array("status"=>$state,"errorCode"=>$code,"message"=>$msg,"result"=>$output));			
			//return ; 
		}///////////


		if($_FILES['signature_image']['type'] > 30000000){
			$state = false;
			$code = '909';
			$msg = 'request counldn\' be complete , cannot upload file size over 30 MB.';
			$output = array();
			echo json_encode(array("status"=>$state,"errorCode"=>$code,"message"=>$msg,"result"=>$output));			
			//return ; 
		}

		
		if(isset($param['doc_id'])){

			$doc = $this->__ps_project_query->getObj('tbt_quality_signature', array('quality_document_id' => $param['doc_id']));

			if (!empty($doc)) {

				$uploadfile = $uploaddir . $param['doc_id'].$type;

				if (file_exists($uploadfile)) {
					unlink($uploadfile);
				}

				if (move_uploaded_file($_FILES['signature_image']['tmp_name'], $uploadfile)) {
					// unlink($_FILES['signature_image']['tmp_name']);

					$result = $this->__ps_project_query->updateObj('tbt_quality_signature', array('quality_document_id' => $param['doc_id']), array('signature' => $uploadfile, 'request_code' => ''));

					$state = true;
					$code = '200';
					$msg = 'upload successfully';
					$output = array();

					echo json_encode(array("status"=>$state,"errorCode"=>$code,"message"=>$msg,"result"=>$output) );
				}else{

					$state = false;
					$code = '909';
					$msg = 'request counldn\' be complete , copy uploaded file.';
					$output = array();
					echo json_encode(array("status"=>$state,"errorCode"=>$code,"message"=>$msg,"result"=>$output));			
					// //return ; 

				}
			}else{

				$state = false;
				$code = '909';
				$msg = 'request counldn\' be complete , document doesn\'t exist.';
				$output = array();
				echo json_encode(array("status"=>$state,"errorCode"=>$code,"message"=>$msg,"result"=>$output));			
				// //return ; 

			}


		}else{
			$state = false;
			$code = '909';
			$msg = 'request counldn\' be complete , parameter -doc_id is missing .';
			$output = array();
			echo json_encode(array("status"=>$state,"errorCode"=>$code,"message"=>$msg,"result"=>$output));			
			// //return ; 
		}
		// return ; 


	}

	function survey_save () {

		ini_get('max_execution_time');
		ini_set('memory_limit', '5000M');
		set_time_limit (0);

		$function = $this->session->userdata('function');
		$p = $this->input->post();

		// echo "<pre>";
		// print_r($p);
		// echo "</pre>";
		// die();

		$this->session->set_userdata($p['doc_id'].'_recent_table', $p['recent_table']);
		$this->updateDocLog('tbt_quality_survey', $p['doc_id']);

		if (!in_array('HR', $function)) {

			$question_key_list = preg_grep("/^question_/",array_keys($p));
			$answer_set = array();
			foreach ($question_key_list as $key) {
				$key_parts = explode('_', $key);
				$area_id = $key_parts[1];
				$question_id = $key_parts[2];

				$answer_set[$area_id][$question_id] = $p[$key];
			}

			foreach ($answer_set as $area_id => $value) {

				$this->db->where('id', $area_id);	
				$query = $this->db->get('tbt_quality_survey_area');
				$row = $query->row_array();

				if (!empty($row)) {

					$status = "complete";
					if (empty($row['serialized_answer'])) {
						$answer_list = $value;
						foreach ($value as $question_id => $answer) {
							if (!array_key_exists('status', $value[$question_id])) {
								$answer_list[$question_id]['status'] = "";
								$status = 'not_complete';
							}
						}
					} else {
						$answer_list = unserialize($row['serialized_answer']);
						foreach ($value as $question_id => $answer) {
							if (!array_key_exists('status', $value[$question_id])) {
								$answer_list[$question_id]['status'] = "";
								$status = 'not_complete';
							} else {
								$answer_list[$question_id]['status'] = $value[$question_id]['status'];
							}
							
							$answer_list[$question_id]['weight'] = $value[$question_id]['weight'];
							$answer_list[$question_id]['remark'] = $value[$question_id]['remark'];
						}
					}

					$answer = serialize($answer_list);
					// echo $area_id.'<br>';
					// echo $answer.'<br>';
					$this->db->where('id', $area_id);	
					$this->db->update('tbt_quality_survey_area', array('serialized_answer' => $answer, 'status' => $status));
				}
			}

			$update_doc = array( 
				'comment'								=> $p['comment'],  
				'area' 									=> $p['area'], 
				'is_manager_edit' 						=> 1, 
				'status' 								=> 'approved',
				'inspector_id'							=> $this->session->userdata('id'),
				'actual_date'							=> date('Y-m-d')
				);

			$customer_key_list = preg_grep("/^customer_/",array_keys($p));
			if (!empty($customer_key_list)) {
				$customer_answer = array();
				foreach ($customer_key_list as $customer_key) {
					$customer_key_parts = explode('_', $customer_key);
					$question_id = $customer_key_parts[1];
					$customer_answer[$question_id] = $p[$customer_key];
				}
				$update_doc['customer_serialized_answer'] = serialize($customer_answer);
			}

			$document_key_list = preg_grep("/^document_control_/",array_keys($p));
			if (!empty($document_key_list)) {
				$document_answer = array();
				foreach ($document_key_list as $document_key) {
					$document_key_parts = explode('_', $document_key);
					$question_id = $document_key_parts[2];
					$document_answer[$question_id] = $p[$document_key];
				}
				$update_doc['document_control_serialized_answer'] = serialize($document_answer);
			}

			$policy_key_list = preg_grep("/^policy_/",array_keys($p));
			if (!empty($policy_key_list)) {
				$policy_answer = array();
				foreach ($policy_key_list as $policy_key) {
					$policy_key_parts = explode('_', $policy_key);
					$question_id = $policy_key_parts[1];
					$policy_answer[$question_id] = $p[$policy_key];
				}
				$update_doc['policy_serialized_answer'] = serialize($policy_answer);
			}

			$update_doc['is_send_email'] = 0;
			if (!empty($p['send_comment'])) {
				$update_doc['is_send_email'] = 1;
			}

			$this->db->where('id', $p['doc_id']);
			$query = $this->db->get('tbt_quality_survey');
			$doc_data = $query->row_array();
			$actionplan = $this->__ps_project_query->getObj('tbt_action_plan', array('id' => $doc_data['action_plan_id']));	
			$this->__ps_project_query->updateObj('tbt_action_plan', array('id' => $actionplan['id']), array('actual_date' => date('Y-m-d')));

		} else {
			$update_doc['hr_inspector_id'] = $this->session->userdata('id');
		}

		$kpi_key_list = preg_grep("/^kpi_/",array_keys($p));
		if (!empty($kpi_key_list)) {
			$kpi_answer = array();
			foreach ($kpi_key_list as $kpi_key) {
				$kpi_key_parts = explode('_', $kpi_key);
				$question_id = $kpi_key_parts[1];
				$kpi_answer[$question_id] = $p[$kpi_key];
			}
			$update_doc['KPI_serialized_answer'] = serialize($kpi_answer);
		}

		$this->db->where('id', $p['doc_id']);	
		$this->db->update('tbt_quality_survey', $update_doc);

		if (!empty($p['submit_val']) && $p['submit_val'] == 1 ) {

			if (in_array('HR', $function)) {
				$this->db->where('id', $p['doc_id']);	
				$this->db->update('tbt_quality_survey', array('hr_submit_date_sap' => date('Y-m-d')));
			} else {
				$this->db->where('id', $p['doc_id']);	
				$this->db->update('tbt_quality_survey', array('status' => 'complete', 'submit_date_sap' => date('Y-m-d')));
			}

			if (!empty($doc_data)) {
				$is_approve = 0;
				if ($doc_data['status'] == 'approved' || $doc_data['status'] == 'complete') {
					$is_approve = 1;
				}

				$this->__ps_project_query->updateObj('tbt_action_plan', array('id' => $actionplan['id']), array('submit_date_sap' => date('Y-m-d')));

				$sap_action_plan = array(
					'ID' 			=> $this->_padZero($actionplan['id'],10),
					'TITLE' 		=> iconv("UTF-8", "TIS-620",$actionplan['title']),
					'EVENT_CATEGORY_ID' => $actionplan['event_category_id'],
					'ACTOR_ID' 		=> $actionplan['actor_id'],
					'PLAN_DATE' 	=> $this->_dateFormat($actionplan['plan_date']),
					'REMARK1' 		=> iconv("UTF-8", "TIS-620", substr($actionplan['remark'], 0, 512)),
					'REMARK2' 		=> iconv("UTF-8", "TIS-620", substr($actionplan['remark'], 512)),
					'CLEAR_JOB_CATEGORY_ID' => $actionplan['clear_job_category_id'],
					'CLEAR_JOB_TYPE_ID' => $actionplan['clear_job_type_id'],
					'STAFF'			=> $actionplan['staff'],
					'TOTAL_STAFF'	=> $actionplan['total_staff'],
					'STATUS' 		=> $actionplan['status'],
					'QUOTATION_ID' 	=> $actionplan['quotation_id'],
					'SHIP_TO_ID' 	=> $actionplan['ship_to_id'],
					'SOLD_TO_ID' 	=> $actionplan['sold_to_id'],
					'CREATE_DATE' 	=> date('Ymd', strtotime($actionplan['create_date'])),
					'CREATE_TIME' 	=> date('His', strtotime($actionplan['create_date'])),
					'OBJECT_TABLE' 	=> $actionplan['object_table'],
					'OBJECT_ID'		=> $actionplan['object_id']
					);

				if (in_array('HR', $function)) {
					$sap_action_plan['ACTUAL_DATE'] = date('Ymd', strtotime($actionplan['actual_date']));
					$sap_action_plan['ACTUAL_TIME'] = date('His', strtotime($actionplan['actual_date']));
				} else {
					$sap_action_plan['ACTUAL_DATE'] = date('Ymd');
					$sap_action_plan['ACTUAL_TIME'] = date('His');
				}

				$input = array( 
					array("IMPORT","I_MODE","M"),
					array("IMPORT","I_TABLE", "ZTBT_ACTION_PLAN"),
					array("IMPORT","I_DATE", $this->_dateFormat($actionplan['plan_date'])),
					array("IMPORT","I_COMMIT", "X"),
					array("TABLE","IT_ZTBT_ACTION_PLAN", array($sap_action_plan))
					);

				$result = $this->callSAPFunction("ZRFC_MASS_TABLE", $input);

				$this->db->select('tbt_quality_survey_area.*');
				$this->db->where('quality_survey_id', $doc_data['id']);
				$query = $this->db->get('tbt_quality_survey_area');

				$area_list = $query->result_array();

				$doc_data['all_area_question'] = 0;
				$doc_data['all_pass'] = 0;
				$doc_data['all_not_pass'] = 0;

				if (!empty($area_list)) {
					foreach ($area_list as $key => $area) {
						$answer_list = unserialize($area['serialized_answer']);
						foreach ($answer_list as $answer) {

							if ($answer['status'] == 'pass') {
								$doc_data['all_pass']++;
							} else {
								$doc_data['all_not_pass']++;
							}
							$doc_data['all_area_question']++;
						}
					}
				}

				if (round((intval($doc_data['all_pass'])/intval($doc_data['all_area_question']))*100, 2) >= intval($doc_data['min_pass_score'])) {
					$pass_status = 'pass';
				} else {
					$pass_status = 'not pass';
				}

				$signature_obj = $this->__ps_project_query->getObj('tbt_quality_signature', array('quality_document_id' => $doc_data['id']));

				$sap_doc = array(
					'ID'							=> $this->_padZero($doc_data['id'], 10),
					'TITLE'							=> iconv("UTF-8", "TIS-620",$doc_data['title']),
					'STATUS'						=> $doc_data['status'],
					'ACTION_PLAN_ID'				=> $doc_data['action_plan_id'],
					'SITE_INSPECTOR_ID'				=> $doc_data['site_inspector_id'],
					'INSPECTOR_ID'					=> $doc_data['inspector_id'],
					'AREA'							=> iconv("UTF-8", "TIS-620",$doc_data['area']),
					'PROJECT_ID'					=> $doc_data['project_id'],
					'CONTRACT_ID'					=> $doc_data['contract_id'],
					'QUOTATION_ID'					=> $doc_data['quotation_id'],
					'COMMENT_T'						=> iconv("UTF-8", "TIS-620",$doc_data['comment']),
					'IS_SEND_EMAIL'					=> $doc_data['is_send_email'],
					'KPI_REVISION_ID'				=> $doc_data['KPI_revision_id'],
					'CUSTOMER_REVISION_ID' 			=> $doc_data['customer_revision_id'],
					'DOCUMENT_CONTROL_REVISION_ID' 	=> $doc_data['document_control_revision_id'],
					'POLICY_REVISION_ID' 			=> $doc_data['policy_revision_id'],
					'PASS_STATUS'					=> $pass_status,
					'MIN_PASS_SCORE'				=> $doc_data['min_pass_score'],
					'SIGNATURE_PATH'				=> site_url($signature_obj['signature'])
					);

				if (in_array('HR', $function)) {
					$sap_doc['ACTUAL_DATE'] = date('Ymd', strtotime($doc_data['actual_date']));
					$sap_doc['ACTUAL_TIME'] = date('His', strtotime($doc_data['actual_date']));
					$sap_doc['SUBMIT_DATE_SAP'] = date('Ymd', strtotime($doc_data['submit_date_sap']));
					$sap_doc['HR_INSPECTOR_ID'] = $this->session->userdata('id');
					$sap_doc['HR_SUBMIT_DATE_SAP'] = date('Ymd');
				} else {
					$sap_doc['ACTUAL_DATE'] = date('Ymd');
					$sap_doc['ACTUAL_TIME'] = date('His');
					$sap_doc['SUBMIT_DATE_SAP'] = date('Ymd');
				}


				$input = array( 
					array("IMPORT","I_MODE","M"),
					array("IMPORT","I_TABLE", "ZTBT_QTY_S"),
					array("IMPORT","I_DATE", $this->_dateFormat($actionplan['plan_date'])),
					array("IMPORT","I_COMMIT", "X"),
					array("TABLE","IT_ZTBT_QTY_S", array($sap_doc))
					);

				$result = $this->callSAPFunction("ZRFC_MASS_TABLE", $input);

				$this->db->where('revision_id', $doc_data['KPI_revision_id']);
				$query = $this->db->get('tbm_quality_survey_kpi_question');
				$kpi_question_list = $query->result_array();
				if (!empty($kpi_question_list)) {

					$kpi_answer_list = unserialize($doc_data['KPI_serialized_answer']);
					if (!empty($kpi_answer_list)) {

						$sap_kpi_answer = array();
						foreach ($kpi_answer_list as $question_id => $score) {
							$sap_kpi_a = array(
								'QUALITY_SURVEY_ID' => $doc_data['id'],
								'QUESTION_ID'		=> $question_id,
								'SCORE'				=> $score
								);

							array_push($sap_kpi_answer, $sap_kpi_a);
						}

						$input = array( 
							array("IMPORT","I_MODE","M"),
							array("IMPORT","I_TABLE", "ZTBM_QTY_S_KPIR"),
							array("IMPORT","I_DATE", $this->_dateFormat($actionplan['plan_date'])),
							array("IMPORT","I_COMMIT", "X"),
							array("TABLE","IT_ZTBM_QTY_S_KPIR", $sap_kpi_answer)
							);
						$result = $this->callSAPFunction("ZRFC_MASS_TABLE", $input);
					}
				}

				$this->db->where('revision_id', $doc_data['customer_revision_id']);
				$query = $this->db->get('tbm_quality_survey_customer_question');
				$customer_question_list = $query->result_array();
				if (!empty($customer_question_list)) {

					$customer_answer_list = unserialize($doc_data['customer_serialized_answer']);
					if (!empty($customer_answer_list)) {			

						$sap_customer_answer = array();
						foreach ($customer_answer_list as $question_id => $answer) {
							$sap_customer_a = array(
								'QUALITY_SURVEY_ID' => $doc_data['id'],
								'QUESTION_ID'		=> $question_id,
								'RESULT_T'			=> $answer['status']
								);

							array_push($sap_customer_answer, $sap_customer_a);
						}

						$input = array( 
							array("IMPORT","I_MODE","M"),
							array("IMPORT","I_TABLE", "ZTBM_QTY_S_CUSR"),
							array("IMPORT","I_DATE", $this->_dateFormat($actionplan['plan_date'])),
							array("IMPORT","I_COMMIT", "X"),
							array("TABLE","IT_ZTBM_QTY_S_CUSR", $sap_customer_answer)
							);
						$result = $this->callSAPFunction("ZRFC_MASS_TABLE", $input);
					}
				}

				$this->db->where('revision_id', $doc_data['document_control_revision_id']);
				$query = $this->db->get('tbm_quality_survey_document_control_question');
				$document_control_question_list = $query->result_array();
				if (!empty($document_control_question_list)) {

					$document_control_answer_list = unserialize($doc_data['document_control_serialized_answer']);
					if (!empty($document_control_answer_list)) {						

						$sap_document_control_answer = array();
						foreach ($document_control_answer_list as $question_id => $answer) {
							$sap_document_control_a = array(
								'QUALITY_SURVEY_ID' => $doc_data['id'],
								'QUESTION_ID'		=> $question_id,
								'STATUS'			=> $answer['status'],
								'WEIGHT'			=> $answer['weight'],
								'REMARK'			=> iconv("UTF-8", "TIS-620",$answer['remark'])
								);

							array_push($sap_document_control_answer, $sap_document_control_a);
						}
						$input = array( 
							array("IMPORT","I_MODE","M"),
							array("IMPORT","I_TABLE", "ZTBM_QTY_S_DOCR"),
							array("IMPORT","I_DATE", $this->_dateFormat($actionplan['plan_date'])),
							array("IMPORT","I_COMMIT", "X"),
							array("TABLE","IT_ZTBM_QTY_S_DOCR", $sap_document_control_answer)
							);
						$result = $this->callSAPFunction("ZRFC_MASS_TABLE", $input);
					}
				}

				$this->db->where('revision_id', $doc_data['policy_revision_id']);
				$query = $this->db->get('tbm_quality_survey_policy_question');
				$policy_question_list = $query->result_array();
				if (!empty($policy_question_list)) {

					$policy_answer_list = unserialize($doc_data['policy_serialized_answer']);
					if (!empty($policy_answer_list)) {						

						$sap_policy_answer = array();
						foreach ($policy_answer_list as $question_id => $answer) {
							$sap_policy_a = array(
								'QUALITY_SURVEY_ID' => $doc_data['id'],
								'QUESTION_ID'		=> $question_id,
								'STATUS'			=> $answer['status'],
								'WEIGHT'			=> $answer['weight'],
								'REMARK'			=> iconv("UTF-8", "TIS-620",$answer['remark'])
								);

							array_push($sap_policy_answer, $sap_policy_a);
						}
						$input = array( 
							array("IMPORT","I_MODE","M"),
							array("IMPORT","I_TABLE", "ZTBM_QTY_S_POLR"),
							array("IMPORT","I_DATE", $this->_dateFormat($actionplan['plan_date'])),
							array("IMPORT","I_COMMIT", "X"),
							array("TABLE","IT_ZTBM_QTY_S_POLR", $sap_policy_answer)
							);
						$result = $this->callSAPFunction("ZRFC_MASS_TABLE", $input);
					}
				}

				$sap_area_list = array();

				$this->db->select('tbt_quality_survey_area.*');
				$this->db->where('quality_survey_id', $doc_data['id']);
				$this->db->join('tbt_quality_survey', 'tbt_quality_survey.id = tbt_quality_survey_area.quality_survey_id');
				$this->db->join('tbt_quotation', 'tbt_quotation.id = tbt_quality_survey.quotation_id');
				$this->db->join('sap_tbm_industry_room', 'sap_tbm_industry_room.id = tbt_quality_survey_area.industry_room_id and sap_tbm_industry_room.industry_id = tbt_quotation.ship_to_industry');
				$query = $this->db->get('tbt_quality_survey_area');
				$doc_area_list = $query->result_array();

				if (!empty($doc_area_list)) {
					foreach ($doc_area_list as $doc_area) {
						$sap_area = array(
							'ID'					=> $doc_area['id'],
							'BUILDING_ID'			=> $doc_area['building_id'],
							'FLOOR_ID'				=> $doc_area['floor_id'],
							'INDUSTRY_ROOM_ID'		=> $doc_area['industry_room_id'],
							'AREA_NAME'				=> iconv("UTF-8", "TIS-620",$doc_area['area_name']),
							'ORDER_INDEX'			=> $doc_area['order_index'],
							'IS_SELECT'				=> $doc_area['is_select'],
							'QUALITY_SURVEY_ID'		=> $doc_area['quality_survey_id'],
							'QUESTION_REVISION_ID'	=> $doc_area['question_revision_id'],
							'STATUS'				=> $doc_area['status'],
							'IS_ORIGIN'				=> $doc_area['is_origin'],
							'PREV_ID'				=> $doc_area['prev_id']
							);	

						array_push($sap_area_list, $sap_area);

						$this->db->where(array('industry_room_id' => $doc_area['industry_room_id'], 'revision_id'=> $doc_area['question_revision_id']));
						$query = $this->db->get('tbm_quality_survey_area_question');
						$area_question_list = $query->result_array();
						if (!empty($area_question_list)) {

							$area_answer_list = unserialize($doc_area['serialized_answer']);
							if (!empty($area_answer_list)) {								

								$sap_area_answer = array();
								foreach ($area_answer_list as $question_id => $answer) {
									$sap_area_a = array(
										'QUALITY_SURVEY_AREA_ID' 	=> $doc_area['id'],
										'QUESTION_ID'				=> $question_id,
										'STATUS'					=> $answer['status'],
										'WEIGHT'					=> $answer['weight'],
										'REMARK'					=> iconv("UTF-8", "TIS-620",$answer['remark'])
										);

									array_push($sap_area_answer, $sap_area_a);
								}

								$input = array( 
									array("IMPORT","I_MODE","M"),
									array("IMPORT","I_TABLE", "ZTBM_QTY_S_ARER"),
									array("IMPORT","I_DATE", $this->_dateFormat($actionplan['plan_date'])),
									array("IMPORT","I_COMMIT", "X"),
									array("TABLE","IT_ZTBM_QTY_S_ARER", $sap_area_answer)
									);

								$result = $this->callSAPFunction("ZRFC_MASS_TABLE", $input);
							}
						}
					}

					$input = array( 
						array("IMPORT","I_MODE","M"),
						array("IMPORT","I_TABLE", "ZTBT_QTY_S_AREA"),
						array("IMPORT","I_DATE", $this->_dateFormat($actionplan['plan_date'])),
						array("IMPORT","I_COMMIT", "X"),
						array("TABLE","IT_ZTBT_QTY_S_AREA", $sap_area_list)
						);

			        // REMOVE AFTER SAP EDIT
					$result = $this->callSAPFunction("ZRFC_MASS_TABLE", $input);

				}
			}

			if ($doc_data['is_send_email'] == 1) {
				// $subject = freetext('quality_assurance').' : '.$doc_data['id'];
				$subject = 'Quality Assurance ID : '.$doc_data['id'];
				$message = "Comment : <br>".str_replace("\n", '<br>',$doc_data['comment']);

				$sender = array (
					"email" => "no-reply@psgen.co.th",
					"name"  => "PSGEN"
					);

				$this->db->select('tbt_user.*');
				$this->db->join('tbt_keyuser_marked_assign', 'tbt_user_marked.assign_id = tbt_keyuser_marked_assign.id');
				$this->db->join('tbt_user', 'tbt_user.employee_id = tbt_keyuser_marked_assign.keyuser_emp_id');
				$this->db->where('tbt_user_marked.action_plan_id', $doc_data['action_plan_id']);
				$query = $this->db->get('tbt_user_marked');
				$manager = $query->row_array();

				if (!empty($manager)) {
					$receiver = array (
						"to" => $manager['user_email']
						);

					parent::_sendEmail($subject, $message, $sender, $receiver);
				}
			}

			redirect(site_url('__ps_quality_assurance/listview/list/'.$p['project_id']), 'refresh');
		}

		if (empty($p['is_ajax'])) {
			redirect(site_url('__ps_quality_assurance/detail/save/'.$p['project_id'].'/'.$p['doc_id']), 'refresh');
		}
		
	}

	function delete($project_id, $actionplan_id){
		//exit();

		$this->load->model('__quality_assurance_model','clistq');
		//remove from database 
		$action_plan = $this->__ps_project_query->getObj('tbt_action_plan', array('id' => $actionplan_id));	

		$sap_del_ap = array(
			'ID'	 	 => $this->_padZero($actionplan_id,10)
			);
		$input = array( 
			array("IMPORT","I_MODE","D"),
			array("IMPORT","I_TABLE", "ZTBT_ACTION_PLAN"),
			array("IMPORT","I_DATE", $this->_dateFormat($action_plan['plan_date'])),
			array("IMPORT","I_COMMIT", "X"),
			array("TABLE","IT_ZTBT_ACTION_PLAN", array($sap_del_ap))
			);

		$result = $this->callSAPFunction("ZRFC_MASS_TABLE", $input);

		$list = $this->clistq->delete($actionplan_id);

		if (!empty($action_plan['pre_id']) && $action_plan['pre_id'] != 0) {
			$this->delete($project_id, $action_plan['pre_id']);
		} else {
			redirect(site_url('__ps_quality_assurance/listview/list/'.$project_id), 'refresh');
		}

		
		// echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
		// echo "<script>alert('เพิ่มการประชุมเรียบรอยแล้ว');</script>";
		// echo "<script>window.top.location.href = 'index.php'; </script>";
		
	}



}
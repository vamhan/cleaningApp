<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class __ps_fix_claim extends Admin_Controller {

	function __construct(){
		parent::__construct();

        $this->permission_check('fix_and_cliam');

		//TODO :: Move this to admin controller later 

		#CMS
		$this->pageSize = PAGESIZE;
		$this->table = 'tbt_fix_claim';
		$this->page_id = 'ps_generation';
		$this->page_title = freetext('fix_and_cliam');
		$this->page_object = 'API';
		$this->page_controller = '__ps_fix_claim';

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
		redirect(site_url('__ps_fix_claim/listview/list/'.$this->project_id), 'refresh');
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

			case 'delete':
					//TODO :: implement item delete and multiple item delete 
				break;

			case 'list':
					//TODO :: select list of asset track
					$this->project_id  = urldecode($id);

					$this->load->model('__fix_claim_model');	
					$list = $this->__fix_claim_model->getContentList($page,$id);
					//get date abort
					$quotation = $this->__ps_project_query->getObj('tbt_quotation', array('id' => $id));
					$this->is_abort = $quotation['is_abort_date'];
					//echo 'isabort : '.$quotation['is_abort'].' '.$quotation['is_abort_date'];


					$menuConfig['page_title'] = 'PS Generation';
					$menuConfig['page_id'] 	  = 'ps_generation';

					$data['modal'] = $this->load->view('__fixclaim/page/list_modal',$list,true);//return view as data

					//Load top menu
					$menuConfig = array('page_id'=>1,'pid'=>$id);
					$data['top_menu'] = $this->load->view('__project/include/top',$menuConfig,true);


					//Load side menu
					$this->load->model('__ps_project_query');
					$data['side_menu'] = $this->load->view('__project/include/side',$menuConfig,true);



					//Load top project
					$this->load->model('__ps_project_query');
					$info['result']['id'] = $id;
					$contentInfo 	= $this->__ps_project_query->getContentById($id);
					if (sizeof($contentInfo['result']) > 0) {
						$info['detail'] = $contentInfo['result'][0];	
					}
					$projectContact = $this->__ps_project_query->getProjectContacts($id);
					$info['contact_list'] = $projectContact['result'];
					$attachDocument = $this->__ps_project_query->getAttachDocumentList($id);
			        $info['ducument_list'] = $attachDocument['result'];
					$info['result']['view'] = $this->load->view('__project/page/detail_bodycfg_all',$info,true);


					$data['top_project'] = $this->load->view('__fixclaim/include/top_project',$info,true);


					$list['permission'] = $this->permission[$this->cat_id];

					//Load body
					$data['body'] = $this->load->view('__fixclaim/page/list_bodycfg',$list,true);

					// //Load footage script
					$data['footage_script'] = '';


					$this->load->view('__fixclaim/layout/list',$data);

					//exit();
				break;	

		}

	}

	function detail($act='',$project_id='',$id=0,$material_no='',$material_name=''){

		
		$data = array();
		$body = array();		
		
		$this->page_title = freetext('fix_and_cliam').' - ['.$id.']';

		switch ($act) { // to tbt_proto_item

			case 'insert':
			//TODO :: insert fix claim	
				$material_no = urldecode($material_no); 
				$material_name = urldecode($material_name); 

				$this->material_no  = $material_no;
				$this->material_name  = $material_name;
				// $this->status  = $status;
				$this->project_id  = $project_id;
				$this->track_doc_id  = $id;

				$menuConfig['page_title'] = 'API Manager';
				$menuConfig['page_id'] 	  = 'api_manager';

				 //**====start : get shipto_id =========
                   $this->db->where('id', $project_id);
                   $query_projectID=$this->db->get('tbt_quotation');
                   $data_projectID = $query_projectID->row_array();      
                   if(!empty($data_projectID)){
                      $ship_to_id = $data_projectID['ship_to_id'];
                    }else{ $ship_to_id=''; }

                  //====end : get shipto_id =========     
                    //echo $ship_to_id; exit();

				//#############  Query #########################################################################
				//Assign parameter for modal
				$this->load->model('__fix_claim_model');
				$this->load->model('__ps_project_query');

				$list['query_fixclaim'] = $this->__fix_claim_model->getContentById($this->table,$id);
				$list['query_asset'] = $this->__fix_claim_model->getAsset($ship_to_id);
				$list['query_ship_to'] = $this->__fix_claim_model->getShipto($ship_to_id);
				$list['query_owner'] = $this->__fix_claim_model->get_project_owner($this->project_id);


				//####################################################################################################				

				$menuConfig = array('page_id'=>1,'pid'=>$project_id);
				$data['top_menu'] = $this->load->view('__project/include/top',$menuConfig,true);

				// //Load side menu
				 $this->load->model('__ps_project_query');
				 $data['side_menu'] = $this->load->view('__project/include/side',$menuConfig,true);

				 // $this->load->model('__ps_project_query');
				 // $data['side_menu'] = $this->load->view('__project/include/side',$menuConfig,true);

				 //Load top project
					
					$info['result']['id'] = $project_id;
					$contentInfo 	= $this->__ps_project_query->getContentById($project_id);
					if (sizeof($contentInfo['result']) > 0) {
						$info['detail'] = $contentInfo['result'][0];	
					}
					$projectContact = $this->__ps_project_query->getProjectContacts($project_id);
					$info['contact_list'] = $projectContact['result'];
					$attachDocument = $this->__ps_project_query->getAttachDocumentList($project_id);
			        $info['ducument_list'] = $attachDocument['result'];
					$info['result']['view'] = $this->load->view('__project/page/detail_bodycfg_all',$info,true);

				$data['top_project'] = $this->load->view('__fixclaim/include/top_project',$info,true);

				//Load body
				$data['body'] = $this->load->view('__fixclaim/page/insert_bodycfg',$list,true);

				$data['modal'] = $this->load->view('__fixclaim/page/detail_modal',$list,true);//return view as data
				// //Load footage script
				// $data['footage_script'] ='';//$this->load->view('__cms/script/api/api_manager_js','',true);				

				$this->load->view('__fixclaim/layout/detail',$data);

				
			break;

			case 'edit':
			 	//TODO :: edit fix claim
				
				
				$this->project_id  = $project_id;
				$this->fixclaim_id  = $id;

				$menuConfig['page_title'] = 'API Manager';
				$menuConfig['page_id'] 	  = 'api_manager';

				 //**====start : get shipto_id =========
                   $this->db->where('id', $this->project_id);
                   $query_projectID=$this->db->get('tbt_quotation');
                   $data_projectID = $query_projectID->row_array();      
                   if(!empty($data_projectID)){
                      $ship_to_id = $data_projectID['ship_to_id'];
                    }else{ $ship_to_id=''; }

                  //====end : get shipto_id ========= 

				//#############  Query #########################################################################
				//Assign parameter for modal
				$this->load->model('__fix_claim_model');

				$list['query_fixclaim'] = $this->__fix_claim_model->getContentById($this->table,$id);
				$list['query_asset'] = $this->__fix_claim_model->getAsset($ship_to_id);
				$list['query_ship_to'] = $this->__fix_claim_model->getShipto($ship_to_id);
				$list['query_owner'] = $this->__fix_claim_model->get_project_owner($this->project_id);

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
					$contentInfo 	= $this->__ps_project_query->getContentById($project_id);
					if (sizeof($contentInfo['result']) > 0) {
						$info['detail'] = $contentInfo['result'][0];	
					}
					$projectContact = $this->__ps_project_query->getProjectContacts($project_id);
					$info['contact_list'] = $projectContact['result'];
					$attachDocument = $this->__ps_project_query->getAttachDocumentList($project_id);
			        $info['ducument_list'] = $attachDocument['result'];
					$info['result']['view'] = $this->load->view('__project/page/detail_bodycfg_all',$info,true);

				$data['top_project'] = $this->load->view('__fixclaim/include/top_project',$info,true);

				//Load body
				$data['body'] = $this->load->view('__fixclaim/page/detail_bodycfg',$list,true);

				$data['modal'] = $this->load->view('__fixclaim/page/detail_modal',$list,true);//return view as data
				// //Load footage script
				// $data['footage_script'] ='';//$this->load->view('__cms/script/api/api_manager_js','',true);				

				$this->load->view('__fixclaim/layout/detail',$data);

				break;

			
			case 'view':
				
				$this->project_id  = $project_id;
				$this->fixclaim_id  = $id;

				$menuConfig['page_title'] = 'API Manager';
				$menuConfig['page_id'] 	  = 'api_manager';

				 //**====start : get shipto_id =========
                   $this->db->where('id', $this->project_id);
                   $query_projectID=$this->db->get('tbt_quotation');
                   $data_projectID = $query_projectID->row_array();      
                   if(!empty($data_projectID)){
                      $ship_to_id = $data_projectID['ship_to_id'];
                    }else{ $ship_to_id=''; }

                  //====end : get shipto_id ========= 

				//#############  Query #########################################################################
				//Assign parameter for modal
				$this->load->model('__fix_claim_model');

				$list['query_fixclaim'] = $this->__fix_claim_model->getContentById($this->table,$id);
				$list['query_asset'] = $this->__fix_claim_model->getAsset($ship_to_id);
				$list['query_ship_to'] = $this->__fix_claim_model->getShipto($ship_to_id);
				$list['query_owner'] = $this->__fix_claim_model->get_project_owner($this->project_id);

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
					$contentInfo 	= $this->__ps_project_query->getContentById($project_id);
					if (sizeof($contentInfo['result']) > 0) {
						$info['detail'] = $contentInfo['result'][0];	
					}
					$projectContact = $this->__ps_project_query->getProjectContacts($project_id);
					$info['contact_list'] = $projectContact['result'];
					$attachDocument = $this->__ps_project_query->getAttachDocumentList($project_id);
			        $info['ducument_list'] = $attachDocument['result'];
					$info['result']['view'] = $this->load->view('__project/page/detail_bodycfg_all',$info,true);

				$data['top_project'] = $this->load->view('__fixclaim/include/top_project',$info,true);

				//Load body
				$data['body'] = $this->load->view('__fixclaim/page/view_bodycfg',$list,true);

				$data['modal'] = $this->load->view('__fixclaim/page/detail_modal',$list,true);//return view as data
				// //Load footage script
				// $data['footage_script'] ='';//$this->load->view('__cms/script/api/api_manager_js','',true);				

				$this->load->view('__fixclaim/layout/view',$data);

				
			break;
			
			default:			

				break;
		}

			
	}



//#################################################
//=========== insert fixclaim======================
//#################################################

public function create_fixclaim($project_id){

	$p = $this->input->post();
		if(!empty($p)){

			 if (!array_key_exists('is_require_spare', $p)) {
            	$p['is_require_spare'] = '0';
         	}
         	 if (!array_key_exists('is_urgent', $p)) {
            	$p['is_urgent'] = '0';
         	}

         	if (!array_key_exists('is_repair_on_side', $p)) {
            	$p['is_repair_on_side'] = '0';
         	}



			//echo  $project_id = $project_id;				
			//echo $p['action_plan_id'].'<br>';	
		// 	echo  ' '.$p['raise_date'].'<br>';
		// 	echo  ' '.$p['raise_by_id'].'<br>';
		// 	echo  ' '.$p['ship_to_id'].'<br>';
		// 	echo  ' '.$p['owner_id'].'<br>';
		// 	echo  ' '.$p['serial'].'<br>';
		// 	echo  ' '.$p['asset_name'].'<br>';
		// 	echo  ' '.$p['title'].'<br>';
		// 	echo  ' '.$p['problem'].'<br>';
		// 	echo  ' '.$p['remark'].'<br>';
		// 	echo  ' '.$p['require_date'].'<br>';
		// 	echo  ' '.$p['is_require_spare'].'<br>';
		// 	echo  ' '.$p['is_urgent'].'<br>';
		// 	echo  ' '.$p['previouse_fix_id'].'<br>';

      	//echo  ' '.$p['is_repair_on_side'].'<br>';
		//exit();

			$this->load->model('__fix_claim_model');
			$result = $this->__fix_claim_model->insert_fixclaim($p,$project_id); 	

			//======= submit to sap =====================
			self::insert_fixclaim_toSap($p,$project_id);
		}	    	

		// echo $p['is_assetrack_redireck'].'<br>';
		// echo $p['trace_id'].'<br>';

		if( $p['is_assetrack_redireck'] ==1){
			echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";			
		    echo '<script type="text/javascript">  alert("'.$result['msg'].'"); setTimeout(function(){window.location="'.site_url('__ps_asset_track/detail/save/'.$project_id.'/'.$p['trace_id']).'"},1200);</script>';
		    echo '<script> window.location="'.site_url('__ps_asset_track/detail/save/'.$project_id.'/'.$p['trace_id']).'"; </script>';
		}else{

			echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
			echo '<script type="text/javascript">  alert("'.$result['msg'].'"); setTimeout(function(){window.location="'.site_url('__ps_fix_claim/listview/list/'.$project_id).'"},1200);</script>';
		    echo '<script> window.location="'.site_url('__ps_fix_claim/listview/list/'.$project_id).'"; </script>';

		}
	    
}



public  function insert_fixclaim_toSap($p,$project_id){
       

$date_time =  $this->_dateFormat(date('Y-m-d'));  
echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";	

        $title = $p['title'];
        $actor_id = $p['raise_by_id'];
        $ship_to_id = $p['ship_to_id'];
        $remark = $p['remark'];    
        
        //count remark actionplan
        $remark_actionplan = $remark;
        $count_remark_actionplan = strlen($remark_actionplan); 
         if($count_remark_actionplan>255){                  
            $remark_actionplan1 = substr($remark_actionplan,0,255);
            $remark_actionplan2 = substr($remark_actionplan,255,$count_remark_actionplan);
         }else{
            $remark_actionplan1 = $remark_actionplan;
            $remark_actionplan2 = "";
         }
        
        //==  get last Id tbt_fix_claim ================
        $query_last_id=$this->db->get('tbt_fix_claim');            
        foreach ($query_last_id->result_array() as $row){               
           $last_fixclaim_id =  $row['id'];
        }  

        //==  get  action_plan_id ================
        $this->db->where('id', $last_fixclaim_id);
        $query_action_plan=$this->db->get('tbt_fix_claim');            
        foreach ($query_action_plan->result_array() as $row){               
           $action_plan_id =  $row['action_plan_id'];
        }                   
        
        // echo '<br>LAST Fixclaim'.$last_fixclaim_id;
        // echo '<br>ACCTION PLAN ID'.$action_plan_id;
        // echo '<br>required_date :'.$p['require_date'].'<br>';

        $raise_date = $p['raise_date'];
        $owner_id = $p['owner_id'];
        $serial = $p['serial'];
        $asset_name = $p['asset_name'];
        $contract_id = $p['contract_id'];              
        $required_date =  reDate($p['require_date']);
        $previouse_fix_id = $p['previouse_fix_id'];
        $status = 'inprogress';
        $problem = $p['problem']; 

        if(!empty($p['is_require_spare'])){
            $is_spare = $p['is_require_spare']; 
        }else{  $is_spare=0;  }

        if(!empty($p['is_urgent'])){
            $is_urgent = $p['is_urgent']; 
        }else{  $is_urgent=0;  }

        if(!empty($p['is_repair_on_side'])){
            $is_repair_on_side = $p['is_repair_on_side']; 
        }else{  $is_repair_on_side=0;  }

    // ====== start: insert to sap  ZTBT_ACTION_PLAN ========== 
        $items_actionplan = array();
        $item1 = array(
            //"EVENT_CATEGORY_ID" => $this->_padZero("1", 5),s
            "ID"    => $this->_padZero($action_plan_id, 10),
            "TITLE" => $this->textToSAP($title),
            "EVENT_CATEGORY_ID" => $this->_padZero(9,5),
            "ACTOR_ID" => $actor_id,
            "PLAN_DATE" => "",
            "ACTUAL_DATE" => "",
            "REMARK1" =>  $this->textToSAP($remark_actionplan1),
            "REMARK2" =>  $this->textToSAP($remark_actionplan2),
            "VISITATION_REASON_ID" => "",
            "STATUS" => "",
            "IS_HOLIDAY" => "",
            "CLEAR_JOB_CATEGORY_ID" => "",
            "CLEAR_JOB_TYPE_ID" => "",
            "STAFF" => "",
            "TOTAL_STAFF" => "",
            "PROJECT_ID" => $project_id,
            "SHIP_TO_ID" => $ship_to_id,
            "SOLD_TO_ID" => "",
            "HOLIDAY_ID" => "",
            "DELETE_FLAG" => "",
            "CREATE_DATE" => $this->_dateFormat(date('Y-m-d')),
            "VERSION" => "",
            "OBJECT_TABLE" => "tbt_fix_claim",
            "OBJECT_ID" => $this->_padZero($last_fixclaim_id, 10)
        );

        array_push($items_actionplan, $item1);
        $input_actionplan = array(  array("IMPORT","I_MODE","M"),
                                        array("IMPORT","I_TABLE", "ZTBT_ACTION_PLAN"),
                                        array("IMPORT","I_DATE", $date_time),
                                        array("IMPORT","I_COMMIT", "X"),
                                        array("TABLE","IT_ZTBT_ACTION_PLAN", $items_actionplan)
                                );      
        $result1 = $this->callSAPFunction("ZRFC_MASS_TABLE", $input_actionplan);
        // echo "action_plan:<br>";
        // echo '<pre>';
        // print_r($result1);
        // echo '</pre>';

// ====== end: insert to sap  ZTBT_ACTION_PLAN ========================


// ====== start: insert to sap  ZTBT_FIX_CLAIM =========================== 
        $items_fixclaim = array();
        $item = array(
            //"EVENT_CATEGORY_ID" => $this->_padZero("1", 5),s
            "ID"    => $this->_padZero($last_fixclaim_id, 10),
            "TITLE" => $this->textToSAP($title),
            "RAISE_DATE" =>  $this->_dateFormat($raise_date),
            "RAISE_BY_ID" => $actor_id,
            "OWNER_ID" =>  $owner_id,
            "SHIP_TO_ID" => $ship_to_id,
            "PROJECT_ID" => $project_id,
            "MATERIAL_NO" => $serial,
            "MATERIAL_DESCRIPTION" => $this->textToSAP($asset_name),
            "CONTRACT_ID" =>  $contract_id,
            "PROBLEM" =>  $this->textToSAP($problem),
            "REMARK" => $this->textToSAP($remark),
            "IS_URGENT" => $this->_padZero($is_urgent, 1),
            "REQUIRE_DATE" => $this->_dateFormat($required_date),
            "ACTION_PLAN_ID" => $this->_padZero($action_plan_id, 11),
            "PICK_UP_DATE" => "",
            "DELIVERY_DATE" => "",
            "IS_REQUIED_SPARE" => $this->_padZero($is_spare, 1),
            "PREVIOUS_FIX_CLAIM_ID" => $this->_padZero($previouse_fix_id, 10),
            "FINISH_DATE" => "",
            "IS_ABORT" => "",
            "STATUS" => $this->textToSAP($status),
            "IS_CLOSE" => "",
            "CLOSE_DATE" => "",
            "IS_REPAIR_ON_SIDE" => $is_repair_on_side,
        );
        //var_dump($item1);     
        //echo "<br>".$date_time."</br>";

        array_push($items_fixclaim, $item);
        $input_fixclaim = array(  array("IMPORT","I_MODE","M"),
                                        array("IMPORT","I_TABLE", "ZTBT_FIX_CLAIM"),
                                        array("IMPORT","I_DATE", $date_time),
                                        array("IMPORT","I_COMMIT", "X"),
                                        array("TABLE","IT_ZTBT_FIX_CLAIM", $items_fixclaim)
                                );      
        $result2 = $this->callSAPFunction("ZRFC_MASS_TABLE", $input_fixclaim);
        // echo "input_fixclaim:<br>";
        // echo '<pre>';
        // print_r($result2);
        // echo '</pre>';
        // exit();
      
// ====== end: insert to sap  ZTBT_FIX_CLAIM ==========

         return;
     }


//#################################################
//=========== UPDATE fixclaim======================
//#################################################

public function update_fixclaim($project_id){

	//echo $project_id."<br>";
	
		$p = $this->input->post();

		if(!empty($p)){
			 if (!array_key_exists('is_require_spare', $p)) {
            	$p['is_require_spare'] = '0';
         	}
         	 if (!array_key_exists('is_urgent', $p)) {
            	$p['is_urgent'] = '0';
         	}

         	 if (!array_key_exists('is_abort', $p)) {
            	$p['is_abort'] = '0';
         	}

         	 if (!array_key_exists('is_repair_on_side', $p)) {
            	$p['is_repair_on_side'] = '0';
         	}

			$this->updateDocLog('tbt_fix_claim', $p['fixclaim_id']);

			$this->load->model('__fix_claim_model');
			
			// echo "<pre>";
			// print_r($_POST);

			$result = $this->__fix_claim_model->update_fixclaim($p,$project_id); 

			//======= submit to sap =====================
			self::update_fixclaim_toSap($p,$project_id);

		}	    	

		echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
		echo '<script type="text/javascript">  alert("'.$result['msg'].'"); setTimeout(function(){window.location="'.site_url('__ps_fix_claim/listview/list/'.$project_id).'"},1200);</script>';
	    echo '<script> window.location="'.site_url('__ps_fix_claim/listview/list/'.$project_id).'"; </script>';

	    //redirect(site_url('__ps_asset_track/detail/save/'.$project_id.'/'.$doc_id, 'refresh'));
}



public  function update_fixclaim_toSap($p,$project_id){
	$date_time =  $this->_dateFormat(date('Y-m-d'));
	echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";	

		if(!empty($p['plan_date']) && $p['plan_date'] != '0000-00-00'){
             $plan_date = $this->_dateFormat(reDate($p['plan_date'])); 
        }else{
            $plan_date = ''; 
        }

         if(!empty($p['finish_date']) && $p['finish_date'] != '0000-00-00'){
             $finish_date = $this->_dateFormat(reDate($p['finish_date'])); 
        }else{
            $finish_date = ''; 
        }

        if(!empty($p['pick_up_date']) && $p['pick_up_date'] != '0000-00-00'){
             $pick_up_date = $this->_dateFormat(reDate($p['pick_up_date'])); 
        }else{
            $pick_up_date = ''; 
        }

        if(!empty($p['delivery_date']) && $p['delivery_date'] != '0000-00-00'){
             $delivery_date = $this->_dateFormat(reDate($p['delivery_date'])); 
        }else{
            $delivery_date = ''; 
        }

        if(!empty($p['require_date']) && $p['require_date'] != '0000-00-00'){
             $require_date = $this->_dateFormat(reDate($p['require_date'])); 
        }else{
            $require_date = ''; 
        }

        //$raise_date = $p['raise_date'];
         if(!empty($p['raise_date']) && $p['raise_date'] != '0000-00-00'){
             $raise_date = $this->_dateFormat($p['raise_date']); 
        }else{
            $raise_date = ''; 
        }


       //  echo  'accept_task_abort :'.$p['accept_task_abort'].'<BR>';
      	// echo  'accept_delivered :'.$p['accept_delivered'].'<BR>';



       // $close_date = '0000-00-00';
        if( $p['accept_task_abort']!='0000-00-00' || $p['accept_delivered']!='0000-00-00'){
	        $is_close = 1;
	        //$is_in_progress = 0;
            if( $p['accept_task_abort']!='0000-00-00'){
                $status = 'abort';
                $close_date = $this->_dateFormat($p['accept_task_abort']);
                //$this->_dateFormat($close_date)
            }else{
                $status = 'accept';
                $close_date = $this->_dateFormat($p['accept_delivered']);
            }
        	//echo "test is 1";
	      }else{
	        $is_close = 0;
	        //$is_in_progress = 1;
	        $status = 'inprogress';
	        $close_date = '';
	        //echo "test is 0";
	      }




    $title = $p['title'];
    $raise_by_id = $p['raise_by_id']; 
    $remark = $p['remark']; 
    $ship_to_id = $p['ship_to_id'];    
    $project_id = $project_id;
    $action_plan_id = $p['action_plan_id'];
    $contract_id  = $p['contract_id'];


	  $fixclaim_id = $p['fixclaim_id'];
	  $owner_id = $p['owner_id']; 
	  $serial = $p['serial']; 
	  $asset_name = $p['asset_name'];
	  $problem = $p['problem'];      
	  $previouse_fix_id = $p['previouse_fix_id'];

	  $is_urgent = $p['is_urgent']; 
	  $is_require_spare = $p['is_require_spare'];
	  $is_abort = $p['is_abort'];
	  $is_repair_on_side = $p['is_repair_on_side'];    
    
	$this->updateDocLog('tbt_fix_claim', $fixclaim_id);

    //count remark actionplan
    $remark_actionplan = $remark;
    $count_remark_actionplan = strlen($remark_actionplan); 
     if($count_remark_actionplan>255){                  
        $remark_actionplan1 = substr($remark_actionplan,0,255);
        $remark_actionplan2 = substr($remark_actionplan,255,$count_remark_actionplan);
     }else{
        $remark_actionplan1 = $remark_actionplan;
        $remark_actionplan2 = "";
     }

 // ====== start: insert to sap  ZTBT_ACTION_PLAN ========== 
     	$this->__ps_project_query->updateObj('tbt_action_plan', array('id' => $action_plan_id), array('submit_date_sap' => date('Y-m-d')));
     	
        $items_actionplan = array();
        $item1 = array(
            //"EVENT_CATEGORY_ID" => $this->_padZero("1", 5),s
            "ID"    => $this->_padZero($action_plan_id, 10),
            "TITLE" => $this->textToSAP($title),
            "EVENT_CATEGORY_ID" => $this->_padZero(9,5),
            "ACTOR_ID" => $raise_by_id,
            "PLAN_DATE" => $plan_date,
            "ACTUAL_DATE" =>$finish_date,
            "REMARK1" => $this->textToSAP($remark_actionplan1),
            "REMARK2" => $this->textToSAP($remark_actionplan2),
            "VISITATION_REASON_ID" => "",
            "STATUS" => "",
            "IS_HOLIDAY" => "",
            "CLEAR_JOB_CATEGORY_ID" => "",
            "CLEAR_JOB_TYPE_ID" => "",
            "STAFF" => "",
            "TOTAL_STAFF" => "",
            "PROJECT_ID" => $project_id,
            "SHIP_TO_ID" => $ship_to_id,
            "SOLD_TO_ID" => "",
            "HOLIDAY_ID" => "",
            "DELETE_FLAG" => "",
            "CREATE_DATE" => $raise_date,
            "VERSION" => "",
            "OBJECT_TABLE" => "tbt_fix_claim",
            "OBJECT_ID" => $this->_padZero($fixclaim_id, 10)
        );
        //var_dump($item1);     
        array_push($items_actionplan, $item1);
        $input_actionplan = array(  array("IMPORT","I_MODE","M"),
                                        array("IMPORT","I_TABLE", "ZTBT_ACTION_PLAN"),
                                        array("IMPORT","I_DATE", $date_time),
                                        array("IMPORT","I_COMMIT", "X"),
                                        array("TABLE","IT_ZTBT_ACTION_PLAN", $items_actionplan)
                                );      
        $result1 = $this->callSAPFunction("ZRFC_MASS_TABLE", $input_actionplan);
        // echo "action_plan:<br>";
        // echo '<pre>';
        // print_r($result1);
        // echo '</pre><br>==========================================================<br>';

// ====== end: insert to sap  ZTBT_ACTION_PLAN ========================
  
//echo  '**close_date ***:'.$close_date.'<BR>';

// ====== start: insert to sap  ZTBT_FIX_CLAIM =========================== 
        $items_fixclaim = array();
        $item = array(
            //"EVENT_CATEGORY_ID" => $this->_padZero("1", 5),s
            "ID"    => $this->_padZero($fixclaim_id, 10),
            "TITLE" => $this->textToSAP($title),
            "RAISE_DATE" =>  $raise_date,
            "RAISE_BY_ID" => $raise_by_id,
            "OWNER_ID" =>  $owner_id,
            "SHIP_TO_ID" => $ship_to_id,
            "PROJECT_ID" => $project_id,
            "MATERIAL_NO" => $serial,
            "MATERIAL_DESCRIPTION" => $this->textToSAP($asset_name),
            "CONTRACT_ID" =>  $contract_id,
            "PROBLEM" => $this->textToSAP($problem),
            "REMARK" =>  $this->textToSAP($remark),
            "IS_URGENT" => $this->_padZero($is_urgent, 1),
            "REQUIRE_DATE" => $require_date,
            "ACTION_PLAN_ID" => $this->_padZero($action_plan_id, 11),
            "PLAN_DATE" =>  $plan_date,
            "PICK_UP_DATE" => $pick_up_date,
            "DELIVERY_DATE" =>$delivery_date,
            "IS_REQUIED_SPARE" => $this->_padZero($is_require_spare, 1),
            "PREVIOUS_FIX_CLAIM_ID" => $this->_padZero($previouse_fix_id, 10),
            "FINISH_DATE" =>  $finish_date,
            "IS_ABORT" => $this->_padZero($is_abort, 1),
            "STATUS" => $this->textToSAP($status),
            "IS_CLOSE" => $this->_padZero($is_close, 1),
            "CLOSE_DATE" =>  $close_date,
            "IS_REPAIR_ON_SIDE" => $is_repair_on_side,
        );
        //var_dump($item1);     
        //echo "<br>".$date_time."</br>";


        array_push($items_fixclaim, $item);
        $input_fixclaim = array(  array("IMPORT","I_MODE","M"),
                                        array("IMPORT","I_TABLE", "ZTBT_FIX_CLAIM"),
                                        array("IMPORT","I_DATE", $date_time),
                                        array("IMPORT","I_COMMIT", "X"),
                                        array("TABLE","IT_ZTBT_FIX_CLAIM", $items_fixclaim)
                                );      
        $result2 = $this->callSAPFunction("ZRFC_MASS_TABLE", $input_fixclaim);
        // echo "input_fixclaim:<br>";
        // echo '<pre>';
        // print_r($result2);
        // echo '</pre>';

// ====== end: insert to sap  ZTBT_FIX_CLAIM ==========
//exit();


return;

}//end update_fixclaim_toSap






//#################################################
//=========== DELETE fixclaim======================
//#################################################


	function delete($id,$project_id,$actionplan_id){

		// echo "test delete";
		// echo '<br>'.$id;
		// echo '<br>'.$project_id;
		// echo '<br>'.$actionplan_id;		
		//exit();

		//remove from database 


		$this->load->model('__fix_claim_model','clistq');
		$list = $this->clistq->delete($id,$actionplan_id);


		//======= DELETE : submit to sap =====================
		self::delete_fixclaim_toSap($id,$actionplan_id);

		redirect(site_url('__ps_fix_claim/listview/list/'.$project_id), 'refresh');		
		
	}


public  function delete_fixclaim_toSap($id,$actionplan_id){

	$date_time =  $this->_dateFormat(date('Y-m-d'));
	//echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
	// echo 'id :'.$id.'<br>';
	// echo 'actionplan_id :'.$actionplan_id.'<br>';
	//exit();
// ====== start: insert to sap  ZTBT_ACTION_PLAN ========== 
        $items_actionplan = array();
        $item1 = array(
            //"EVENT_CATEGORY_ID" => $this->_padZero("1", 5),s
            "ID"    => $this->_padZero($actionplan_id, 10)
           
        );
        //var_dump($item1);     
        array_push($items_actionplan, $item1);
        $input_actionplan = array(  array("IMPORT","I_MODE","D"),
                                        array("IMPORT","I_TABLE", "ZTBT_ACTION_PLAN"),
                                        array("IMPORT","I_DATE", $date_time),
                                        array("IMPORT","I_COMMIT", "X"),
                                        array("TABLE","IT_ZTBT_ACTION_PLAN", $items_actionplan)
                                );      
        $result1 = $this->callSAPFunction("ZRFC_MASS_TABLE", $input_actionplan);
        // echo "action_plan:<br>";
        // echo '<pre>';
        // print_r($result1);
        // echo '</pre><br>============================================<br>';

// ====== end: insert to sap  ZTBT_ACTION_PLAN ========================


// ====== start: insert to sap  ZTBT_FIX_CLAIM =========================== 
        $items_fixclaim = array();
        $item = array(
            //"EVENT_CATEGORY_ID" => $this->_padZero("1", 5),s
            "ID"    => $this->_padZero($id, 10)
           
        );
        //var_dump($item1);     
        //echo "<br>".$date_time."</br>";

        array_push($items_fixclaim, $item);
        $input_fixclaim = array(  array("IMPORT","I_MODE","D"),
                                        array("IMPORT","I_TABLE", "ZTBT_FIX_CLAIM"),
                                        array("IMPORT","I_DATE", $date_time),
                                        array("IMPORT","I_COMMIT", "X"),
                                        array("TABLE","IT_ZTBT_FIX_CLAIM", $items_fixclaim)
                                );      
        $result2 = $this->callSAPFunction("ZRFC_MASS_TABLE", $input_fixclaim);
        // echo "input_fixclaim:<br>";
        // echo '<pre>';
        // print_r($result2);
        // echo '</pre>';

// ====== end: insert to sap  ZTBT_FIX_CLAIM ==========


	return;
}

//#################################################
//=========== GET AJAX ============================
//#################################################

	public  function get_track_asset($project_id,$track_doc_id,$status){
	 	

	 	$track_doc_id = urldecode($track_doc_id); 
	 	$track_doc_id = str_replace(" ", "", $track_doc_id);
        $project_id = urldecode($project_id);
        $project_id = str_replace(" ", "", $project_id);
        $status = urldecode($status);
        $status = str_replace(" ", "", $status);

   //       echo 'test';
	 	//  echo $status; 
	 	// // echo '<br>'.$project_id; 
	 	// // echo '<br>'.$track_doc_id; 
	 	// exit();
	 	redirect(site_url('__ps_asset_track/detail/save/'.$project_id.'/'.$track_doc_id.'/'.$status, 'refresh'));
    } 

    public  function get_track_asset_view($project_id,$track_doc_id,$status){
	 	

	 	$track_doc_id = urldecode($track_doc_id); 
	 	$track_doc_id = str_replace(" ", "", $track_doc_id);
        $project_id = urldecode($project_id);
        $project_id = str_replace(" ", "", $project_id);
        $status = urldecode($status);

   //      echo 'test';
	 	// echo $status; 
	 	// echo '<br>'.$project_id; 
	 	// echo '<br>'.$track_doc_id; 
	 	//exit();
	 	redirect(site_url('__ps_asset_track/detail/view/'.$project_id.'/'.$track_doc_id.'/'.$status, 'refresh'));
    } 



    public function get_previouse_fix_id($id){
        // $size = urldecode($size);
        $id = str_replace("----","/",$id);  
        
        $this->load->model('__fix_claim_model');     
        $output = $this->__fix_claim_model->get_previouse_insert_id($id);
		$output = $output['result'];

		echo json_encode($output);
    } 



}
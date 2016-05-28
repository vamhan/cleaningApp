<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class __ps_asset_track extends Admin_Controller {

	function __construct(){
		parent::__construct();

        $this->permission_check('asset_tracker');

		//TODO :: Move this to admin controller later 

		#CMS
		$this->pageSize = PAGESIZE;
		$this->table = 'tbt_asset_track_document';
		$this->page_id = 'ps_generation';
		$this->page_title = freetext('asset_tracker_top');
		$this->page_object = 'API';
		$this->page_controller = '__ps_asset_track';

		//$this->untrack = 0;
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
		redirect(site_url('__ps_asset_track/listview/list/'.$this->project_id), 'refresh');
	}

	// function changePageSize( $newPageSize = PAGESIZE ){
	// 	$newValue = array('current_page'=> $newPageSize);
	// 	$this->session->set_userdata($newValue);
	// 	// $this->trace($newValue);

	// 	$callback_url = $this->session->userdata('current_url');
		
	// 	// $this->trace($callback_url);
	// 	if(!empty($callback_url))
	// 		redirect($callback_url,'refresh');
	// }


	function changePageSize( $newPageSize = PAGESIZE ){
		$newValue = array('current_page'=> $newPageSize);
		$this->session->set_userdata($newValue);
		
		$callback_url = $this->session->userdata('current_url');
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
					//Load top project
					$this->load->model('__ps_project_query');
					$this->load->model('__asset_track_model');	
					$list = $this->__asset_track_model->getContentList($page,$id);
					//get date abort
					$quotation = $this->__ps_project_query->getObj('tbt_quotation', array('id' => $id));
					$this->is_abort = $quotation['is_abort_date'];
					//echo 'isabort : '.$quotation['is_abort'].' '.$quotation['is_abort_date'];

					$list['event_category'] 	= $this->__action_plan_model->allEventCategory();
					$list['isAllowToCreate']    = $this->__action_plan_model->isAllowToCreate($list['result']['project']['contract_id'], $this->cat_id);

					$menuConfig['page_title'] = 'PS Generation';
					$menuConfig['page_id'] 	  = 'ps_generation';

					//Load top menu
					$menuConfig = array('page_id'=>1,'pid'=>$id);
					$data['top_menu'] = $this->load->view('__project/include/top',$menuConfig,true);


					//Load side menu
					$this->load->model('__ps_project_query');
					$data['side_menu'] = $this->load->view('__project/include/side',$menuConfig,true);

					
					$info['result']['id'] = $id;

					$contentInfo 	= $this->__ps_project_query->getContentById($id);
					if (sizeof($contentInfo['result']) > 0) {
						$info['detail'] = $contentInfo['result'][0];
						$list['contentInfo'] = $contentInfo['result'][0];	
					}
					$projectContact = $this->__ps_project_query->getProjectContacts($id);
					$info['contact_list'] = $projectContact['result'];
					$attachDocument = $this->__ps_project_query->getAttachDocumentList($id);
			        $info['ducument_list'] = $attachDocument['result'];

					$info['result']['view'] = $this->load->view('__project/page/detail_bodycfg_all',$info,true);


					$data['top_project'] = $this->load->view('__asset_track/include/top_project',$info,true);


					$list['contentInfo'] = $contentInfo['result'][0];

					$data['modal'] = $this->load->view('__asset_track/page/list_modal',$list,true);//return view as data

					$list['permission'] = $this->permission[$this->cat_id];
					//Load body
					$data['body'] = $this->load->view('__asset_track/page/list_bodycfg',$list,true);

					$data['project'] = $list['result']['project'];
					// //Load footage script
					$data['footage_script'] = '';
					//echo $this->textToSAP("้อย");

					$this->load->view('__asset_track/layout/list',$data);

					//exit();
				break;	

		}

	}

	



	function detail($act='',$project_id='',$id=0,$status='0',$untrack=0 ){

		
		$data = array();
		$body = array();		
		
		$this->page_title = freetext('asset_tracker_top').' - ['.$id.']';
		switch ($act) { // to tbt_proto_item

			case 'save':
			 	//TODO :: select check track asset
				//echo "save".$project_id;


				$this->status  = $status;
				$this->project_id  = $project_id;
				$this->track_doc_id  = $id;
				$this->untrack  = $untrack;

				$menuConfig['page_title'] = 'API Manager';
				$menuConfig['page_id'] 	  = 'api_manager';


				//#############  Query #########################################################################
				//Assign parameter for modal
				$this->load->model('__asset_track_model','asset');

				//===== START : fetch clone sap_tbt_project_asset =============================== 
				$check_status_document = $this->asset->getAssetDocument($this->track_doc_id);				
                $data_check = $check_status_document->row_array();
                $actual_date =$data_check['actual_date'];
                $submit_date_sap = $data_check['submit_date_sap'];
                //echo  'submit_date_sap'.$submit_date_sap.'<br>';

				$permission = $this->permission[$this->cat_id];
				if (empty($data_check) || !array_key_exists('view', $permission)) {
					redirect(site_url('__ps_asset_track/listview/list/'.$project_id));
				}

                //#################################################
				//=========== cLONE SAP ASSET PROJECT==============
				//#################################################
                if($actual_date =='0000-00-00' || $actual_date =='' || $actual_date =='null'){  
                	// echo "test nook ";
                	// exit();
                	$result_clone= $this->asset->clone_insert_asset($this->track_doc_id,$this->project_id); 
                	if(!empty($result_clone['msg'])){
	                echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
					echo '<script type="text/javascript">alert("'.$result_clone['msg'].'"); </script>';              
	              	}
                }
	             if($submit_date_sap =='0000-00-00' || empty($submit_date_sap)){
	             	$result_update_fixclaim = $this->asset->update_fixclaim($this->track_doc_id,$this->project_id);
	             	if(!empty($result_update_fixclaim['msg'])){
	                echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
					echo '<script type="text/javascript">alert("'.$result_update_fixclaim['msg'].'"); </script>';
					}
	             }
                //===== END : fetch clone sap_tbt_project_asset =============================== 
	             // echo "test nook 2";
	             // exit();
				$list['query_track'] = $this->asset->getContentById('tbt_asset_track',$id,$status);
				$list['query_untrack'] = $this->asset->getContentById('tbt_untracked_asset',$id,$status);
				$list['query_asset_no'] = $this->asset->getAsset();
				$list['query_asset_dummy'] = $this->asset->getAsset_dummy();
				$list['query_untrack_dummy'] = $this->asset->getUntrack_dummy($this->project_id,$this->track_doc_id);
				$list['query_documet'] = $this->asset->getAssetDocument($this->track_doc_id);


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
					if (sizeof($contentInfo['result']) > 0) {
						$info['detail'] = $contentInfo['result'][0];	
					}
					$projectContact = $this->__ps_project_query->getProjectContacts($project_id);
					$info['contact_list'] = $projectContact['result'];
					$attachDocument = $this->__ps_project_query->getAttachDocumentList($project_id);
			        $info['ducument_list'] = $attachDocument['result'];
					$info['result']['view'] = $this->load->view('__project/page/detail_bodycfg_all',$info,true);

				$data['top_project'] = $this->load->view('__asset_track/include/top_project',$info,true);

				//Load body
				$data['body'] = $this->load->view('__asset_track/page/detail_bodycfg',$list,true);

				$data['modal'] = $this->load->view('__asset_track/page/detail_modal',$list,true);//return view as data
				// //Load footage script
				// $data['footage_script'] ='';//$this->load->view('__cms/script/api/api_manager_js','',true);				

				$this->load->view('__asset_track/layout/detail',$data);

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
				$this->load->model('__asset_track_model','asset');
				// $list['query_track'] = $this->asset->getContentById('tbt_asset_track',$id,$status);
				// $list['query_untrack'] = $this->asset->getContentById('tbt_untracked_asset',$id,$status);
				// $list['query_documet'] = $this->asset->getAssetDocument($this->track_doc_id);

				$list['query_track'] = $this->asset->getContentById('tbt_asset_track',$id,$status);
				$list['query_untrack'] = $this->asset->getContentById('tbt_untracked_asset',$id,$status);
				$list['query_asset_no'] = $this->asset->getAsset();
				$list['query_asset_dummy'] = $this->asset->getAsset_dummy();
				$list['query_untrack_dummy'] = $this->asset->getUntrack_dummy($this->project_id,$this->track_doc_id);
				$list['query_documet'] = $this->asset->getAssetDocument($this->track_doc_id);

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
					if (sizeof($contentInfo['result']) > 0) {
						$info['detail'] = $contentInfo['result'][0];	
					}
					$projectContact = $this->__ps_project_query->getProjectContacts($project_id);
					$info['contact_list'] = $projectContact['result'];
					$attachDocument = $this->__ps_project_query->getAttachDocumentList($project_id);
			        $info['ducument_list'] = $attachDocument['result'];
					$info['result']['view'] = $this->load->view('__project/page/detail_bodycfg_all',$info,true);

				$data['top_project'] = $this->load->view('__asset_track/include/top_project',$info,true);



				//Load body
				$data['body'] = $this->load->view('__asset_track/page/view_bodycfg',$list,true);


				//Load footage script
				$data['footage_script'] ='';//$this->load->view('__cms/script/api/api_manager_js','',true);

				$data['modal'] = $this->load->view('__asset_track/page/detail_modal',$list,true);//return view as data

				$this->load->view('__asset_track/layout/view',$data);

				//exit();

			break;
			
			default:			

				break;
		}

			
	}





	function update_track_asset($id,$project_id){
		$allow_trace = false;
		//echo  $id ;	
		///////////////////////////////////////////////////////////
		//Query serail track_asset
		$this->load->model('__asset_track_model','asset');
	
        ///////////////////////////////////////////////////////////	


		  $post =  $this->input->post();
		  if($allow_trace){
		  	$this->trace($post);
		  }


		  if(!empty($post)){

				 //=================start: update tbt_asset_track_document======
		  		 $action_plan_id =  $post['plan_id'];
		  		 $actual_date = $post['actual_date'];
		  		 $actor_id = $post['actor_by_id'];
		  		 $fixclaim_asset_id = $post['fixclaim_asset_id'];
		  		 $fixclaim_asset_name = $post['fixclaim_asset_name'];
		  		 //$doc_status = $post['doc_status'];

		  		 //echo  "test : ".$actual_date."no";

		  		 //echo mb_detect_encoding($post['texttest']);
		  		 if ( $actual_date =='0000-00-00' || $actual_date =='' || $actual_date =='null' ){
		  		 		$actual_date = date("Y-m-d"); 
		  		 		//echo "hello";
		  		 }else{
		  		 		$actual_date = $post['actual_date'];
		  		 }

		  		// echo 'set :'.$actual_date.'<br>';
		    //     exit();
		  		 
		  		 // if (!empty($actual_date)||$actual_date!='0000-00-00'){
		  		 // 		$actual_date =date("Y-m-d"); 
		  		 // }else{
		  		 // 		$actual_date = $post['actual_date'];
		  		 // }

		  		 $data_doc = array(		            
		            'actor_by_id' => $actor_id,
		            'actual_date' => $actual_date
		            //'status_asset_track_document' => $doc_status	
		            //status_asset_track		      
		       	 );



				$this->updateDocLog('tbt_asset_track_document', $id);
				
		        $this->db->where('id', $id);
		        $query=$this->db->update('tbt_asset_track_document', $data_doc);
		        
		        if($allow_trace){
		        	echo '<hr>update actor id : ';
		        	echo $this->db->last_query();
			        echo '<hr>';	
		        }
		        

		        $data_plan = array(
		            'actual_date' => $actual_date		            	      
		        );

		        $this->db->where('id', $action_plan_id);
		        $query=$this->db->update('tbt_action_plan', $data_plan);

		        if($allow_trace){
		        echo '<hr>update action plan : ';
		        echo $this->db->last_query();
		        echo '<hr>';
		    	}
		   		//================= end : update tbt_asset_track_document======

				//============= start : update tbt_track_asset ===============
				$this->db->where('asset_track_document_id', $id);
				$Query_asset_track= $this->db->get('tbt_asset_track');
				
				if($allow_trace){
					echo '<hr>get existing asset_list : ';
			        echo $this->db->last_query();
			        $this->trace($Query_asset_track->result_array());
			        echo ': end existing asset_list <hr>';

					echo '<hr>update asset properties : <hr>';
					$cnt = 0;
				}
		  		foreach ($Query_asset_track->result_array() as $row){ 
						$serial_query = $row['asset_no'];
						$is_fixing = $row['is_fixing'];
		    			//echo $row['asset_no'];
		    			
		    			//hot fixed : findout long time solution later
						// echo $serial_query; 
						$serial_query = str_replace('.', '_', $serial_query);
						// echo $serial_query;
						

						$statusx = 'radio_'.$serial_query;
						$remarkx = 'remark_'.$serial_query;


						if (!array_key_exists($serial_query, $post)) {
							$post[$serial_query] = "";
						}
						$serial = $post[$serial_query];
						
						if (!array_key_exists($statusx, $post)) {
							$post[$statusx] = "";
						}
				  		
				  		if($is_fixing==1){
				  			$status_tracking = "EXIST_WITH_CON";

				  	    }else{
				  	    	$status_tracking = $post[$statusx];
				  	    }
				  	    //echo $status_tracking."<br>";

						if (!array_key_exists($remarkx, $post)) {
							$post[$remarkx] = "";
						}
				  		$remark = $post[$remarkx];

				  		//==== call mode update
				  		$this->asset->update($serial,$status_tracking,$remark,$id);
				  		if($allow_trace){
				  			echo ++$cnt.' : '.$this->db->last_query().'<hr>';
				  		}
				//============= start : update tbt_track_asset ===============

		    }//end foreach
		    if($allow_trace){
		    echo '<hr>end update asset properties : <hr>';
		  	}

 //exit();
		     //== start: get status ================    
                            $this->db->select('count(*) as count', 'tbt_asset_track.*');
                            $this->db->where('status_tracking','UNCHECK');
                            $this->db->where('is_fixing',0);
                            $this->db->where('asset_track_document_id',$id);
                            $query = $this->db->get('tbt_asset_track'); 
                            $data_count = $query->row_array();  
                            $count_uncheck = $data_count['count'];

                            //echo  $count_uncheck;
                            if( $count_uncheck != 0 && $actual_date  =='0000-00-00' || $actual_date =='' || $actual_date =='null'){
                                $doc_status = " ";   
                            }else if($count_uncheck != 0 &&  $actual_date  !='0000-00-00' || $actual_date =='' || $actual_date =='null'){
                                $doc_status = "warning";  
                            }else if($count_uncheck == 0 &&  $actual_date  !='0000-00-00' || $actual_date =='' || $actual_date =='null'){
                               $doc_status = "check";                           }
                

		     	$data_status = array(		            
		            //'actor_by_id' => $actor_id,
		            'status_asset_track_document' => $doc_status	
		            //status_asset_track		      
		       	 );

		        $this->db->where('id', $id);
		        $query=$this->db->update('tbt_asset_track_document', $data_status);
		        
		        if($allow_trace){
		        	var_dump($query);
		        	echo $this->db->last_query();
		        	die('e');
		        }
		         // === end get status ============================================= 
		     if(!empty($fixclaim_asset_id) ||  $fixclaim_asset_id != 0 ){
		        	 
		        	 //echo $fixclaim_asset_id.' '.$fixclaim_asset_name;
		        	
		        	 echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";	
					 echo '<script type="text/javascript">  alert("แก้ไขเรียบร้อย"); setTimeout(function(){window.location="'.site_url('__ps_fix_claim/detail/insert/'.$project_id.'/'.$id.'/'.$fixclaim_asset_id.'/'.$fixclaim_asset_name).'"},1200);</script>';		
	      			 echo '<script> window.location="'.site_url('__ps_fix_claim/detail/insert/'.$project_id.'/'.$id.'/'.$fixclaim_asset_id.'/'.$fixclaim_asset_name).'"; </script>';
				

				}else{

					 echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";				
					  //exit();
					 echo '<script type="text/javascript">  alert("แก้ไขเรียบร้อย"); setTimeout(function(){window.location="'.site_url('__ps_asset_track/detail/save/'.$project_id.'/'.$id).'"},1200);</script>';				    
				  
					 echo '<script> window.location="'.site_url('__ps_asset_track/detail/save/'.$project_id.'/'.$id).'"; </script>';
					 //redirect(site_url('__ps_asset_track/detail/save/'.$project_id.'/'.$id, 'refresh'));				
				}
			

		  }// end if
		
		  exit();
	}


	function create_untrack_asset(){
		$untrack =1;
		$p = $this->input->post();	

		if(!empty($p)){

			$project_id = $p['untrack_project_id'];
			$doc_id = $p['untrack_doc_id'];

			$this->load->model('__asset_track_model','create_untrack');
			$result = $this->create_untrack->insert_untrack($p); 
		

		echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
		echo '<script type="text/javascript">alert("'.$result['msg'].'"); </script>';
		echo '<script> window.location="'.site_url('__ps_asset_track/detail/save/'.$project_id.'/'.$doc_id.'/0/'.$untrack).'"; </script>';
	    //redirect(site_url('__ps_asset_track/detail/save/'.$project_id.'/'.$doc_id, 'refresh'));
		}		
	}

	// function create_List_asset_track(){


	// 	$p = $this->input->post();

	// 	if(!empty($p)){

	// 		//echo $p['project_id'];
	// 		//exit();
	// 		$project_id = $p['project_id'];			

	// 		$this->load->model('__asset_track_model','create_list');			
	// 		$this->create_list->insert_list_asset($p); 
	// 	}

	// 	redirect(site_url('__ps_asset_track/listview/list/'.$project_id), 'refresh');

	// 	//echo $msg;

	// }


	function delete($id,$table,$project_id,$actionplan_id){
		//exit();

		//remove from database 
		$this->load->model('__asset_track_model','clistq');
		
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

		$list = $this->clistq->delete($id,$table,$actionplan_id);

		if (!empty($action_plan['pre_id']) && $action_plan['pre_id'] != 0) {
			$this->delete($action_plan['object_id'],$table, $project_id, $action_plan['pre_id']);
		} else {
			redirect(site_url('__ps_asset_track/listview/list/'.$project_id), 'refresh');
		}
		
		// echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
		// echo "<script>alert('เพิ่มการประชุมเรียบรอยแล้ว');</script>";
		// echo "<script>window.top.location.href = 'index.php'; </script>";
		
	}


	function delete_untrack($project_id,$doc_id,$asset_id){
		//exit();
		//echo $project_id.' '.$doc_id.' '.$asset_id;
		$untrack =1;

		$project_id = urldecode($project_id); 
		$doc_id = urldecode($doc_id); 
		$asset_id = urldecode($asset_id); 
		
		//remove from database 
		$this->load->model('__asset_track_model','clistq');
		$list = $this->clistq->delete_untrack($project_id,$doc_id,$asset_id);
		
		 echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
		 echo '<script type="text/javascript">  alert("ลบเรียบร้อยแล้ว"); setTimeout(function(){window.location="'.site_url('__ps_asset_track/detail/save/'.$project_id.'/'.$doc_id.'/0/'.$untrack).'"},1200);</script>';
		// echo '<script> window.location="'.site_url('__ps_asset_track/detail/save/'.$project_id.'/'.$doc_id).'"; </script>';
		 echo '<script> window.location="'.site_url('__ps_asset_track/detail/save/'.$project_id.'/'.$doc_id.'/0/'.$untrack).'"; </script>';
		
	}





// 	function group_delete() {
//     	$dat = $this->input->post('forms');
//     	$this->load->model('__proto_content_list','clistq');
// 		// $this->trace(array($dat,$this->table));

// 		foreach ($dat as $key => $id) {
// 			$this->clistq->delete($this->table,array('id'=>$id));
// 			//delete config file
// 			self::deleteCfg($id);
//     	}

//     	$callback_url = $this->session->userdata('current_url');
//     	if(!empty($callback_url))
// 			redirect($callback_url,'refresh');
// 	}





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







//######################################################
//=========== INSERT TO SAP ============================
//######################################################

function submit_to_sap($track_doc_id,$project_id){
	$date_time =  $this->_dateFormat(date('Y-m-d'));  
echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";	
////////////////////////////////////////////////////////////////////////////////////////////////////////


		$this->updateDocLog('tbt_asset_track_document', $track_doc_id);
	//=========== START : get tbt asset_track_document
	   $this->db->select('tbt_asset_track_document.* ,tbt_action_plan.event_category_id,tbt_action_plan.plan_date AS plan_date,tbt_action_plan.actual_date AS actual_date,tbt_action_plan.remark AS remarck_actionplan,tbt_action_plan.create_date AS create_date_actionplan');
	   $this->db->join('tbt_action_plan', 'tbt_action_plan.id = tbt_asset_track_document.action_plan_id','left');
	   $this->db->where('tbt_asset_track_document.id', $track_doc_id);
       $query_track_doc=$this->db->get('tbt_asset_track_document');
       $data_track_doc = $query_track_doc->row_array();      
       if(!empty($data_track_doc)){
           
           	//assetrack_documen
	            $title_doc = $data_track_doc['title'];
	            $action_plan_id = $data_track_doc['action_plan_id'];
	            $survey_officer_id = $data_track_doc['survey_officer_id'];
	            $project_id = $data_track_doc['quotation_id'];
	            $actor_by_id = $data_track_doc['actor_by_id'];
	            $status_asset_track = $data_track_doc['status_asset_track_document']; 
	            $contract_id = $data_track_doc['contract_id'];            
	            $ship_to_id = $data_track_doc['ship_to_id'];

            //action_plan
	          $event_category_id = $data_track_doc['event_category_id'];
	          $plan_date = $data_track_doc['plan_date'];
	          $actual_date = $data_track_doc['actual_date'];
	          $create_date_actionplan =$data_track_doc['create_date_actionplan'];
	        //count remark actionplan
	            $remark_actionplan = $data_track_doc['remarck_actionplan'];
	         	$count_remark_actionplan = strlen($remark_actionplan); 
	         	 if($count_remark_actionplan>255){	         	 	
	         	 	$remark_actionplan1 = substr($remark_actionplan,0,255);
	         	 	$remark_actionplan2 = substr($remark_actionplan,255,$count_remark_actionplan);
	         	 }else{
	         	 	$remark_actionplan1 = $remark_actionplan;
	         	 	$remark_actionplan2 = "";
	         	 }
	         //echo '<br>'.$remark_actionplan.'['.$count_remark_actionplan.'] || '.$remark_actionplan1."//".$remark_actionplan2;         	
         	
        }
    
// ====== start: insert to sap  ZTBT_ACTION_PLAN ========== 
        $this->__ps_project_query->updateObj('tbt_action_plan', array('id' => $action_plan_id), array('submit_date_sap' => date('Y-m-d')));

		$items_actionplan = array();
		$item4 = array(
			//"EVENT_CATEGORY_ID" => $this->_padZero("1", 5),s
			"ID" 	=> $this->_padZero($action_plan_id, 10),
			"TITLE" => $this->textToSAP($title_doc),
			"EVENT_CATEGORY_ID" => $this->_padZero($event_category_id, 5),
			"ACTOR_ID" => $survey_officer_id,
			"PLAN_DATE" => $this->_dateFormat($plan_date),
			"ACTUAL_DATE" => $this->_dateFormat($actual_date),
			"REMARK1" =>  $this->textToSAP($remark_actionplan1),
			"REMARK2" =>  $this->textToSAP($remark_actionplan2),
			"VISITATION_REASON_ID" => "",
			"STATUS" => "",
			"IS_HOLIDAY" => "",
			"CLEAR_JOB_CATEGORY_ID" => "",
			"CLEAR_JOB_TYPE_ID" => "",
			"STAFF" => "",
			"TOTAL_STAFF" => "",
			"PROJECT_ID" =>  $this->_padZero($project_id, 10),
			"SHIP_TO_ID" => $ship_to_id,
			"SOLD_TO_ID" => "",
			"HOLIDAY_ID" => "",
			"DELETE_FLAG" => "",
			"CREATE_DATE" => $this->_dateFormat($create_date_actionplan),
			"VERSION" => "",
			"OBJECT_TABLE" => "tbt_asset_track_document",
			"OBJECT_ID" =>  $this->_padZero($track_doc_id, 10),
		);
		//var_dump($item1);		
		//echo "<br>".$date_time."</br>";

		array_push($items_actionplan, $item4);
		$input_actionplan = array(	array("IMPORT","I_MODE","M"),
										array("IMPORT","I_TABLE", "ZTBT_ACTION_PLAN"),
										array("IMPORT","I_DATE", $date_time),
										array("IMPORT","I_COMMIT", "X"),
										array("TABLE","IT_ZTBT_ACTION_PLAN", $items_actionplan)
								);		
		$result4 = $this->callSAPFunction("ZRFC_MASS_TABLE", $input_actionplan);
		// echo "action_plan:<br>";
		// echo '<pre>';
		// print_r($result4);
		// echo '</pre>';

// ====== end: insert to sap  ZTBT_ACTION_PLAN ==========




// ====== start: insert to sap  ZTBT_AS_TRCK_DOC========== 
		$items_doc = array();
		$item1 = array(
			//"EVENT_CATEGORY_ID" => $this->_padZero("1", 5),s
			"ID" 	=> $this->_padZero($track_doc_id, 10),
			"TITLE" =>  $this->textToSAP($title_doc),
			"ACTION_PLAN_ID" => $this->_padZero($action_plan_id, 10),
			"SURVEY_OFFICER_ID" => $survey_officer_id,
			"PROJECT_ID" => $this->_padZero($project_id, 10),
			"ACTOR_BY_ID" => $actor_by_id,
			"STATUS_ASSET_TRACK_DOCUMENT" => $status_asset_track,
			"CONTRACT_ID" => $contract_id,
			"SHIP_TO_ID" => $ship_to_id
		);
		//var_dump($item1);		
		//echo "<br>".$date_time."</br>";

		array_push($items_doc, $item1);
		$input = array(	array("IMPORT","I_MODE","M"),
										array("IMPORT","I_TABLE", "ZTBT_AS_TRCK_DOC"),
										array("IMPORT","I_DATE", $date_time),
										array("IMPORT","I_COMMIT", "X"),
										array("TABLE","IT_ZTBT_AS_TRCK_DOC", $items_doc)
								);		
		$result1 = $this->callSAPFunction("ZRFC_MASS_TABLE", $input);
		// echo "ZTBT_AS_TRCK_DOC:<br>";
		// echo '<pre>';
		// print_r($result1);
		// echo '</pre>';

// ====== end: insert to sap  ZTBT_AS_TRCK_DOC==========	




////////////////////////////////////////////////////////////////////////////////////////////////////////


		
 /////////////////////////////// GET tbt_asset_track //////////////////////////////////////
	   $this->db->where('asset_track_document_id', $track_doc_id);
       $query_asset_track=$this->db->get('tbt_asset_track');      
		foreach($query_asset_track->result_array() as $row){
			$ASSET_NO = $row['asset_no'];
			$ASSET_NAME = $row['asset_description'];
			$status_tracking = $row['status_tracking'];
			$is_clear_job = $row['is_clear_job'];
			$is_spare = $row['is_spare'];
			$is_fixing = $row['is_fixing'];
			$fix_claim_id =$row['fix_claim_id'];
			$LAST_DATE = $row['last_date'];
			$project_id = $row['quotation_id'];
			$ship_to_id = $row['ship_to_id'];
			//remark asset_track
			$remark_track = $row['remark'];
			$count_remark_track = strlen($remark_track);
			 if($count_remark_track>255){
         	 		if($count_remark_track>510){	         	 	
	         	 	  $remark_track1 = substr($remark_track,0,255);
	         	 	  $remark_track2 = substr($remark_track,255,255);
	         	 	  $remark_track3 = substr($remark_track,510,$count_remark_track);
	         	 	}else{
	         	 	  $remark_actionplan1 = substr($remark_track,0,255);
	         	 	  $remark_actionplan2 = substr($remark_track,255,$count_remark_track);
	         	 	  $remark_actionplan3 = "";
	         	 	}
	         	 }else{
	         	 	$remark_track1 = $remark_track;
	         	 	$remark_track2 = "";
	         	 	$remark_track3 = "";
	         	 }
	        //echo '<br>'.$remark_track.'['.$count_remark_track.'] || '.$remark_track1."//".$remark_track2.'//'.$remark_track3;

//echo $remark_track1;
	   		 //$test1_remark = iconv("iso8859-1","UCS-2BE",$remark_track1);
 			 //$test2_remark = iconv('TIS-620','UTF-8',$remark_track1);
 			 //$test3_remark = iconv('WINDOWS-1252','UTF-8',$remark_track1);
 			 //$test4_remark = iconv("UTF-8", "CESU-8",$remark_track1);
 			

				// ====== start: insert to sap  ZTBT_AS_TRCK========== 
					$items_track = array();
					$item2 = array(
						//"EVENT_CATEGORY_ID" => $this->_padZero("1", 5),s
						"ASSET_NO" 	=> $ASSET_NO,
						"ASSET_TRACK_DOC_ID" => $this->_padZero($track_doc_id, 11),
						"ASSET_DESCRIPTION" =>  $this->textToSAP($ASSET_NAME),
						"STATUS_TRACKING" => $status_tracking,			
						"IS_CLEAR_JOB" => $this->_padZero($is_clear_job, 1),
						"IS_SPARE" => $this->_padZero($is_spare, 1),
						"IS_FIXING" => $this->_padZero($is_fixing, 1),
						"FIX_CLAIM_ID" => $fix_claim_id,
						"LAST_DATE" => $this->_dateFormat($LAST_DATE),
						"PROJECT_ID" => $this->_padZero($project_id, 10),
						"SHIP_TO_ID" => $ship_to_id,
						"REMARK1" =>  $this->textToSAP($remark_track1),
						"REMARK2" =>  $this->textToSAP($remark_track2),
						"REMARK3" =>  $this->textToSAP($remark_track3),
						"DELETE_FLAG" => $this->_padZero(0,1),
						"ACTOR_BY_ID" => $actor_by_id
					);
					//var_dump($item2);		
					//echo "<br>".$date_time."</br>";

					array_push($items_track, $item2);
					$input_track = array(	array("IMPORT","I_MODE","M"),
													array("IMPORT","I_TABLE", "ZTBT_AS_TRCK"),
													array("IMPORT","I_DATE", $date_time),
													array("IMPORT","I_COMMIT", "X"),
													array("TABLE","IT_ZTBT_AS_TRCK", $items_track)
											);		
					$result2 = $this->callSAPFunction("ZRFC_MASS_TABLE", $input_track);
					// echo "ZTBT_AS_TRCK:<br>";
					// echo '<pre>';
					// print_r($result2);
					// echo '</pre>';
			// ====== end: insert to sap  ZTBT_AS_TRCK==========
	   }
/////////////////////////////////////////////////////////////////////////////////////////////////////

 //get tbt asset_asset_untrack
	   $this->db->where('asset_track_document_id', $track_doc_id);
       $query_asset_untrack=$this->db->get('tbt_untracked_asset');      
		foreach($query_asset_untrack->result_array() as $row_untrack){			
			$ASSET_NO_UNTRACK = $row_untrack['asset_no'];
			$ASSET_NAME_UNTRACK = $row_untrack['asset_description'];
			$project_id = $row_untrack['quotation_id'];
			$ship_to_id = $row_untrack['ship_to_id'];
			$input_by_id = $row_untrack['input_by_id'];			
			$asset_track_document_id =$row_untrack['asset_track_document_id'];
			$is_dummy = $row_untrack['is_dummy'];
			$delete_flag = $row_untrack['delete_flag'];
			//=== remark untrack
			$remark_untrack = $row_untrack['remark'];
			$count_remark_untrack = strlen($remark_untrack);
			 if($count_remark_untrack>255){
         	 		if($count_remark_untrack>510){	         	 	
	         	 	  $remark_untrack1 = substr($remark_untrack,0,255);
	         	 	  $remark_untrack2 = substr($remark_untrack,255,255);
	         	 	  $remark_untrack3 = substr($remark_untrack,510,$count_remark_untrack);
	         	 	}else{
	         	 	  $remark_untrack1 = substr($remark_untrack,0,255);
	         	 	  $remark_untrack2 = substr($remark_untrack,255,$count_remark_untrack);
	         	 	  $remark_untrack3 = "";
	         	 	}
	         	 }else{
	         	 	$remark_untrack1 = $remark_untrack;
	         	 	$remark_untrack2 = "";
	         	 	$remark_untrack3 = "";
	         	 }
	        //echo '<br>'.$remark_untrack.'['.$count_remark_untrack.'] || '.$remark_untrack1."//".$remark_untrack2.'//'.$remark_untrack3;			

	         	
	         	 //iconv('UTF-8','TIS-620',$msg);

				// ====== start: insert to sap  ZTBT_UNTRCK_AS========== 
					$items_untrack = array();
					$item3 = array(
						//"EVENT_CATEGORY_ID" => $this->_padZero("1", 5),s
						"ASSET_NO" 	=> $ASSET_NO_UNTRACK,
						"ASSET_TRACK_DOCUMENT_ID" 	=> $this->_padZero($track_doc_id, 10),
						"ASSET_DESCRIPTION" 	=>  $this->textToSAP($ASSET_NAME_UNTRACK),
						"PROJECT_ID" => $this->_padZero($project_id, 10),
						"SHIP_TO_ID" 	=> $ship_to_id,
						"INPUT_BY_ID" 	=> $input_by_id,
						"REMARK1" 	=>  $this->textToSAP($remark_untrack1),
						"REMARK2" 	=>  $this->textToSAP($remark_untrack2),
						"REMARK3" 	=>  $this->textToSAP($remark_untrack3),
						"IS_DUMMY" 	=>  $this->_padZero($is_dummy,1),	
						"DELETE_FLAG" 	=> $this->_padZero(0,1),
						"DUMMY_CODE" 	=> $ASSET_NO_UNTRACK
					);
					//var_dump($item3);		
					//echo "<br>".$date_time."</br>";
					// echo '<br>////////////////////////////////////////////';
					// echo '<br>'.$this->ThaiIToUTF8($ASSET_NAME_UNTRACK);
					// echo '<br>'.$this->textToSAP($remark_untrack1);
					// echo '<br>'.$ASSET_NAME_UNTRACK;
					// echo '<br>'.$remark_untrack1;

					array_push($items_untrack,$item3);
					$input_untrack = array(	array("IMPORT","I_MODE","M"),
													array("IMPORT","I_TABLE", "ZTBT_UNTRCK_AS"),
													array("IMPORT","I_DATE", $date_time),
													array("IMPORT","I_COMMIT", "X"),
													array("TABLE","IT_ZTBT_UNTRCK_AS", $items_untrack)
											);		
					$result3 = $this->callSAPFunction("ZRFC_MASS_TABLE", $input_untrack);
					// echo "ZTBT_UNTRCK_AS:<br>";
					// echo '<pre>';
					// print_r($result3);
					// echo '</pre>';
			// ====== end: insert to sap  ZTBT_UNTRCK_AS==========
		}

////////////////////////////////////////////////////////////////////////////////////////////////////////
		
		//exit();


		//update date submit to sap tbt_asset_track_document
		$this->load->model('__asset_track_model','update');			
		$this->update->update_to_sap($track_doc_id); 

		//exit();
		$msg_to_sap ='';
		 if(empty($result1)) {
            $msg_to_sap .= 'ผิดพลาด: ไม่สามารถบันทึกข้อมูล ZTBT_AS_TRCK_DOC ลง sap ได้';            
        }
       	else if(empty($result2)){
       		 $msg_to_sap .= 'ผิดพลาด: ไม่สามารถบันทึกข้อมูล ZTBT_AS_TRCK ลง sap ได้'; 
       	}
       	// else if(empty($result3)){
       	// 	 //$msg_to_sap .= 'ผิดพลาด: ไม่สามารถบันทึกข้อมูล ZTBT_UNTRCK_AS ลง sap ได้'; 
       	// }
       	else if(empty($result4)){
       		 $msg_to_sap .= 'ผิดพลาด: ไม่สามารถบันทึกข้อมูล ZTBT_ACTION_PLAN ลง sap ได้'; 
       	}else{
        	$msg_to_sap .= 'บันทึกการจบแผนงานเรียบร้อยแล้ว';  
        }

        //exit();
		
		 echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";			
			
		 echo '<script type="text/javascript">  alert("'.$msg_to_sap.'"); setTimeout(function(){window.location="'.site_url('__ps_asset_track/listview/list/'.$project_id).'"},1200);</script>';
	     echo '<script> window.location="'.site_url('__ps_asset_track/listview/list/'.$project_id).'"; </script>';

	}








function sap_read(){
		// array_push($items_doc, $item1);
	$date_time =  $this->_dateFormat(date('Y-m-d')); 
										$input = array(	
										array("IMPORT","I_MODE","R"),
										array("IMPORT","I_TABLE", "ZRFC_TEST"),
										array("IMPORT","I_DATE", $date_time),
										array("IMPORT","I_COMMIT", ""),
										array("TABLE","ET_ZRFC_TEST",array())
								);		
	$result1 = $this->callSAPFunction("ZRFC_MASS_TABLE", $input);


	$text = $result1['ET_ZRFC_TEST'][4]['TEXT02'];
	
	echo "<pre>";
	if(!mb_detect_encoding($text)){
		//Do convert
		echo iconv("TIS-620", "UTF-8", $text );
	}else if(mb_detect_encoding($text) == 'UTF-8'){
		//Do nothing 
	}
	echo "</pre>";
}//end function 






function submit_to_sap3(){
	
$date_time =  $this->_dateFormat(date('Y-m-d')); 

	$prefix = substr(time().'', -3);
	$text = $prefix.'ทดสอบภาษาไทยจ้ะtest';
	 $t1 = $t2 = $t3 = $t4 = $t5 = $t6 = $t7 = $t8 = $t9 = $t10 = '';
  // MAIN UTF-8
  		$t3 = iconv("UTF-8", "TIS-620",$text);
 		$t4 = iconv("UTF-8", "WINDOWS-874",$text);

		$items_doc = array();
		$item1 = array(	
			"TEXT01" => $t1,
			"TEXT02" => $t2,
			"TEXT03" => $t3,
			"TEXT04" => $t4,
			"TEXT05" => $t5,
			"TEXT06" => $t6,
			"TEXT07" => $t7,
			"TEXT08" =>  $t8,
			"TEXT09" => $t9,
			"TEXT10" => $t10
		);

		array_push($items_doc, $item1);
		$input = array(	array("IMPORT","I_MODE","M"),
										array("IMPORT","I_TABLE", "ZRFC_TEST"),
										array("IMPORT","I_DATE", $date_time),
										array("IMPORT","I_COMMIT", "X"),
										array("TABLE","IT_ZRFC_TEST", $items_doc)
								);		
		$result1 = $this->callSAPFunction("ZRFC_MASS_TABLE", $input);


		echo "success";
		echo "<br>".$text;
		echo "<br>".($text);
		// echo "<br>".$t10;


}//end function 



function submit_to_sap2($track_doc_id,$project_id){

echo "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />";



//header("Content-Type: text/html; charset=utf-8");
//echo "<meta http-equiv='Content-Type' content='text/html; charset=WINDOWS-874'>";		
$date_time =  $this->_dateFormat(date('Y-m-d')); 

	$text = 'ทดสอบภาษาไทยจ้ะtest';


	 // $t1 = iconv("UTF-8", "TIS-620",$text);
	 // $t2 = iconv('TIS-620','UTF-8',$text);
	 
	 // $t3 = iconv("iso8859-1","UCS-2BE",$text);
	 //  $t4 = iconv("UCS-2BE", "iso8859-1",$text);

	 // $t5 = iconv("UTF-8", "CESU-8",$text);
	 // $t6 = iconv("CESU-8", "UTF-8",$text); 
	
	 // $t7 = iconv("UTF-8", "windows-1251",$text);
	 // $t8 = iconv('windows-1251','UTF-8',$text);

	 // $t9 = iconv("UTF-8", "windows-874",$text);
	 // $t10 = iconv("windows-874", "UTF-8",$text);

	echo mb_detect_encoding($text);


	 $t1 = $t2 = $t3 = $t4 = $t5 = $t6 = $t7 = $t8 = $t9 = $t10 = '';
 //Sample set 1 : convert [UTF-8 : TIS-620 : WINDOWS-874]
  // MAIN UTF-8
  $t1 = iconv("UTF-8", "TIS-620",$text);
  $t2 = iconv("UTF-8", "WINDOWS-874",$text);

  // MAIN TIS-620
  $t3 = iconv("TIS-620", "UTF-8",$text);
  $t4 = iconv("TIS-620", "WINDOWS-874",$text);

  // MAIN WINDOWS-874
  $t5 = iconv("WINDOWS-874", "TIS-620",$text);
  $t6 = iconv("WINDOWS-874", "UTF-8",$text);

  $t7 = $text;
  $t8 = utf8_decode($text);

  $t9 = iconv("TIS-620", "UTF-8",utf8_decode($text));
  $t10 = iconv("UTF-8", "TIS-620",utf8_decode($text));

		$items_doc = array();
		$item1 = array(
			//"EVENT_CATEGORY_ID" => $this->_padZero("1", 5),s			
			"TEXT01" => $t1,
			"TEXT02" => $t2,
			"TEXT03" => $t3,
			"TEXT04" => $t4,
			"TEXT05" => $t5,
			"TEXT06" => $t6,
			"TEXT07" => $t7,
			"TEXT08" =>  $t8,
			"TEXT09" => $t9,
			"TEXT10" => $t10,
			
		);
		//var_dump($item1);		
		//echo "<br>".$date_time."</br>";

		array_push($items_doc, $item1);
		$input = array(	array("IMPORT","I_MODE","M"),
										array("IMPORT","I_TABLE", "ZRFC_TEST"),
										array("IMPORT","I_DATE", $date_time),
										array("IMPORT","I_COMMIT", "X"),
										array("TABLE","IT_ZRFC_TEST", $items_doc)
								);		
		$result1 = $this->callSAPFunction("ZRFC_MASS_TABLE", $input);


		echo "success";
		echo "<br>".$text;
		echo "<br>".utf8_decode($text);
		// echo "<br>".$t10;


}











}//end __ps_asset_Track
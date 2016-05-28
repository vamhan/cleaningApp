<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class __ps_project extends Admin_Controller {

	function __construct(){
		parent::__construct();
        $this->permission_check('project_and_preprojects');

		//TODO :: Move this to admin controller later 

		#CMS
		$this->pageSize = PAGESIZE;
		$this->table = 'tbt_project';
		$this->page_id = 'ps_project';
		$this->page_title = 'Projects : PSWEB';
		$this->page_object = 'Page';
		$this->page_controller = '__ps_project';
		$this->project_id = '';


		$this->defualt_backend_controller = '__backend_content/listContent/';
		$this->defualt_frontend_controller = '__frontend_content/listContent/';

		//set lang
		$this->session->set_userdata('lang', 'th');
		#END_CMS
	}//end constructor;


	//Default
	function index(){
		//TODO :: redirecting to listview
		//echo 'die';
		redirect(site_url('__ps_projects/detail'), 'refresh');
	}

	function changePageSize( $newPageSize = PAGESIZE ){
		$newValue = array('current_page'=> $newPageSize);
		$this->session->set_userdata($newValue);
		// $this->trace($newValue);

		$callback_url = $this->session->userdata('current_url');
		// echo 'url';
		// $this->trace($callback_url);
		if(!empty($callback_url))
			redirect($callback_url,'refresh');
	}





	function detail($id=0){
		
		$data = array();
		$list = array();		
		


		$this->load->model('__ps_project_query');
		$this->load->model('__quotation_model','quotation');	
		$contentInfo = $this->__ps_project_query->getContentById($id);
		$info['detail'] = $contentInfo['result'][0];		
		

        $menuConfig = array('page_id'=>1,'pid'=>$id);

		$data['modal'] = $this->load->view('__project/page/list_modal',$menuConfig,true);

        $data['top_menu'] = $this->load->view('__project/include/top',$menuConfig,true);

        $data['side_menu'] = $this->load->view('__project/include/side',$menuConfig,true);

        //get quotation id
        // $this->db->select('tbt_quotation.*');       
        // $this->db->where('tbt_quotation.contract_id', $id);
        // $query = $this->db->get('tbt_quotation');
        // $query_qt = $query->row_array();
        // $quotation_id = $query_qt['id'];

        // echo "quotation_id :".$quotation_id;
        // exit();

        $this->quotation_id  = $id;

        //Load body
        $info['pid'] = $id;
        $projectContact = $this->__ps_project_query->getProjectContacts($id);
        $info['contact_list'] = $projectContact['result'];
        $attachDocument = $this->__ps_project_query->getAttachDocumentList($id);
        $info['ducument_list'] = $attachDocument['result'];
        $info['query_doc_importance'] = $this->quotation->get_document_importance('quotation',$this->quotation_id);
        $info['query_doc_other'] = $this->quotation->get_document_other('quotation',$this->quotation_id);


		$data['body'] = $this->load->view('__project/page/detail_bodycfg',$info,true);

        $this->load->view('__project/layout/detail',$data);



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
	        echo '<script type="text/javascript">  alert("'.$error.$msg_error.'"); setTimeout(function(){window.location="'.site_url('__ps_project/detail/'.$quotation_id).'"},1200);</script>';
		   	echo '<script> window.location="'.site_url('__ps_project/detail/'.$quotation_id).'"; </script>';  
	    }else{
	        $data_upload= $this->upload->data();
	        //echo  '<br>'.$fname=$data_upload['file_name'];	    	
	    	$path = $upload_path.'/'.$data_upload['file_name'];

	        $result = $this->__quotation_model->upload_file_quotation($description,$is_importance,$path,$quotation_id);
	        // echo  $result['msg']; 	
	       
	        echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";	     
			echo '<script type="text/javascript">  alert("'.$result['msg'].'"); setTimeout(function(){window.location="'.site_url('__ps_project/detail/'.$quotation_id).'"},1200);</script>';
		   	echo '<script> window.location="'.site_url('__ps_project/detail/'.$quotation_id).'"; </script>';        
	    }  

	 //echo 'prospect_id: '.$prospect_id.'<br>';
	 //echo 'is_importance: '.$is_importance.'<br>';
	// echo 'upload_path: '.$upload_path.'<br>';
	// echo 'path: '.$path.'<br>';      



	}// end if post
	
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
				echo '<script type="text/javascript">  alert("ลบไฟล์เรียบร้อยแล้ว"); setTimeout(function(){window.location="'.site_url('__ps_project/detail/'.$doc_id).'"},1200);</script>';
			    //echo '<script> window.location="'.site_url('__ps_quotation/detail_quotation/edit_prospect/'.$doc_id).'"; </script>';
			    echo '<script> window.location="'.site_url('__ps_project/detail/'.$doc_id).'"; </script>'; 

		    }else{

		    	//echo "fail";
		    	echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
				echo '<script type="text/javascript">  alert("ผิดพลาด: ไม่สามารถลบไฟล์ได้"); setTimeout(function(){window.location="'.site_url('__ps_project/detail/'.$doc_id).'"},1200);</script>';
			    echo '<script> window.location="'.site_url('__ps_project/detail/'.$doc_id).'"; </script>';
		    }
	}//end if prospect
    else{

		if($this->db->delete('tbt_project_document',$condition)){
	       unlink($path[0]['path']);
	       //echo "succses";
	        echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
			echo '<script type="text/javascript">  alert("ลบไฟล์เรียบร้อยแล้ว"); setTimeout(function(){window.location="'.site_url('__ps_project/detail/'.$doc_id).'"},1200);</script>';
		    echo '<script> window.location="'.site_url('__ps_project/detail/'.$doc_id).'"; </script>';

	    }else{

	    	//echo "fail";
	    	echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
			echo '<script type="text/javascript">  alert("ผิดพลาด: ไม่สามารถลบไฟล์ได้"); setTimeout(function(){window.location="'.site_url('__ps_project/detail/'.$doc_id).'"},1200);</script>';
		    echo '<script> window.location="'.site_url('__ps_project/detail/'.$doc_id).'"; </script>';
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
				echo '<script type="text/javascript">  alert("ลบไฟล์เรียบร้อยแล้ว"); setTimeout(function(){window.location="'.site_url('__ps_project/detail/'.$doc_id).'"},1200);</script>';
			    echo '<script> window.location="'.site_url('__ps_project/detail/'.$doc_id).'"; </script>';

		    }else{

		    	//echo "fail";
		    	echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
				echo '<script type="text/javascript">  alert("ผิดพลาด: ไม่สามารถลบไฟล์ได้"); setTimeout(function(){window.location="'.site_url('__ps_project/detail/'.$doc_id).'"},1200);</script>';
			    echo '<script> window.location="'.site_url('__ps_project/detail/'.$doc_id).'"; </script>';
		    }
	}//end if prospect
	else{
			if($this->db->delete('tbt_project_document',$condition)){
		       unlink($path[0]['path']);
		       //echo "succses";
		        echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
				echo '<script type="text/javascript">  alert("ลบไฟล์เรียบร้อยแล้ว"); setTimeout(function(){window.location="'.site_url('__ps_project/detail/'.$doc_id).'"},1200);</script>';
			    echo '<script> window.location="'.site_url('__ps_project/detail/'.$doc_id).'"; </script>';

		    }else{

		    	//echo "fail";
		    	echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
				echo '<script type="text/javascript">  alert("ผิดพลาด: ไม่สามารถลบไฟล์ได้"); setTimeout(function(){window.location="'.site_url('__ps_project/detail/'.$doc_id).'"},1200);</script>';
			    echo '<script> window.location="'.site_url('__ps_project/detail/'.$doc_id).'"; </script>';
		    }
	}//end else 

}




	function create_contact($project_id){
		//echo $project_id;
		

		$p = $this->input->post();

		if(!empty($p)){

			$this->load->model('__ps_project_query','insert');			
			$result = $this->insert->insert_contact($p,$project_id); 			
		}
		echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";		
		//echo "messa".$result['msg'];
		//exit();		
		echo '<script type="text/javascript">  alert("'.$result['msg'].'"); setTimeout(function(){window.location="'.site_url('__ps_project/detail/'.$project_id).'"},1200);</script>';	    
		echo '<script> window.location="'.site_url('__ps_project/detail/'.$project_id).'"; </script>';

	}







	function delete($id){
		//remove from database 
		$this->load->model('__proto_content_list','clistq');
		$list = $this->clistq->delete($this->table,array('id'=>$id));

		//delete config file
		self::deleteCfg($id);


		$backlink = $this->session->userdata('current_url');
		if(!empty($backlink)){
			redirect($backlink,'refresh');
		}else{
			echo 'no redirect';
		}
	}



	function group_delete($table='') {
    	$dat = $this->input->post('forms');
    	$this->load->model('__proto_content_list','clistq');
		
		foreach ($dat as $key => $id) {
			$this->clistq->delete($this->table,array('id'=>$id));
			//delete config file
			self::deleteCfg($id);
    	}

    	$callback_url = $this->session->userdata('current_url');
    	if(!empty($callback_url))
			redirect($callback_url,'refresh');
	}








}
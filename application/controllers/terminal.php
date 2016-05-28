<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class terminal extends REST_Controller {

	function __construct(){
		parent::__construct();

		//TODO :: Move this to admin controller later 
		$this->pageSize = PAGESIZE;
			$this->load->model('terminal');
		/*$this->load->config('backend_navigation');
		$this->navigation = $this->config->item('backend_navigation');*/

	}//end constructor;


	//Default
	function index($act='',$id=''){
		// redirect('__backend_content/listContent/none/view','refresh');
	}


	function updateFacebookPost_post(){	
		// header('Content-Type: application/javascript');

		$param = $this->post();
		
		
		// $this->response(array('/me') , 200);
		// die();
		$result = $this->terminal->updateFacebookPost($param);

		if($result['status']){
			$this->response($result , 200);
		}else{
			$this->response($result , 200);
		}
		//echo json_encode($param);
	}



 



}
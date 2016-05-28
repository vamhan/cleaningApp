<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class __ps_projects extends Admin_Controller {

	function __construct(){
		parent::__construct();
        $this->permission_check('project_and_preprojects');

		//TODO :: Move this to admin controller later 

		#CMS
		$this->pageSize = PAGESIZE;
		$this->table = 'tbt_project';
		$this->page_id = 'ps_project';
		$this->page_title = 'Project list : PSWEB';
		$this->page_title_ico = '<i class="fa fa-folder-open-o"></i> &nbsp; ';
		$this->page_object = 'Page';
		$this->page_controller = '__ps_projects';

		$this->defualt_backend_controller = '__backend_content/listContent/';
		$this->defualt_frontend_controller = '__frontend_content/listContent/';

		//set lang
		$this->session->set_userdata('lang', 'th');
		#END_CMS
	}//end constructor;


	//Default
	function index($act='',$id=''){
		//TODO :: redirecting to listview
		redirect(site_url('__ps_projects/listview'), 'refresh');
	}



	function changePageSize( $newPageSize = PAGESIZE ){
		$newValue = array('current_page'=> $newPageSize);
		$this->session->set_userdata($newValue);
		
		$callback_url = $this->session->userdata('current_url');
		if(!empty($callback_url))
			redirect($callback_url,'refresh');
	}




	//function com_listview : act / id 
	function listview($page=1,$tempMatch=''){
		
		//$this->search = $tempMatch;
		$newValue = array('current_url'=> site_url($this->uri->uri_string()) );
		$this->session->set_userdata($newValue);
		
		$this->load->model('__ps_projects_query');

		$data = array();
		$list = array();		

			$list = $this->__ps_projects_query->listviewContent($page,$tempMatch);
			
		$menuConfig = array('page_id'=>1);

		
		$data['modal'] = $this->load->view('__projects/page/list_modal',$menuConfig,true);//return view as data

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

		//Load body
		$data['body'] = $this->load->view('__projects/page/list_bodycfg',$list,true);

		//Load footage script
		$data['footage_script'] = '';


		$this->load->view('__projects/layout/list',$data);
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
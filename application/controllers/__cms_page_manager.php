<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class __cms_page_manager extends Admin_Controller {

	function __construct(){
		parent::__construct();
        $this->permission_check('cms');

		//TODO :: Move this to admin controller later 

		#CMS
		$this->pageSize = PAGESIZE;
		$this->table = 'cms_page';
		$this->page_id = 'page_builder';
		$this->page_title = 'Page Builder';
		$this->page_object = 'Page';
		$this->page_controller = '__cms_page_manager';

		$this->defualt_backend_controller = '__backend_content/listContent/';
		$this->defualt_frontend_controller = '__frontend_content/listContent/';
		#END_CMS
	}//end constructor;


	//Default
	function index($act='',$id=''){
		//TODO :: redirecting to listview
		redirect(site_url('__cms_page_manager/listview'), 'refresh');
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

//#############################################
//SECTION : Content  
//#############################################	

	// //Un-used
	// //function com_listview : act / id 
	// function listviewWithConfig($act='',$object_type ='',$object_category_id='',$object_id='',$page=1, $keyword=''){
	// 	$data = array();
	// 	$list = array();		
		
	// 	// var_dump($this->session->userdata('permission_set'));
	// 	switch ($act) { // to tbt_proto_item

	// 		case 'delete':
	// 				//TODO :: implement item delete and multiple item delete 
	// 			break;

	// 		case 'list':
	// 		default:


	// 			$config = $this->loadCMSCfg('page');
	// 			$this->load->model('__proto_content_list','clistq');
	// 			$list = $this->clistq->listviewcfg($this->table,$config,$object_category_id,$page);
	// 			$list['config'] = $config;
	

	// 		// $this->trace(json_encode($list));			
	// 			# code...
	// 			break;
	// 	}

	// 	// $this->trace(json_encode($list['config']));

	// 	//Load top menu
	// 	$menuConfig = array('page_id'=>$this->page_id);
	// 	$data['top_menu'] = $this->load->view('__cms/include/top',$menuConfig,true);

	// 	// //Load side menu
	// 	$data['side_menu'] = $this->load->view('__cms/include/side',$menuConfig,true);

	// 	//Load body
	// 	$data['body'] = $this->load->view('__cms/page/list_bodycfg',$list,true);

	// 	// //Load footage script
	// 	$data['footage_script'] = '';


	// 	$this->load->view('__cms/layout/list',$data);
	// }





	//function com_listview : act / id 
	function listview($act='',$object_type ='',$object_category_id='',$object_id='',$page=1, $keyword=''){
		
		$newValue = array('current_url'=> site_url($this->uri->uri_string()) );
		$this->session->set_userdata($newValue);
		$this->load->model('__proto_content_list','clistq');

		$data = array();
		$list = array();		
		
		// var_dump($this->session->userdata('permission_set'));
		switch ($act) { // to tbt_proto_item

			case 'delete':
					//TODO :: implement item delete and multiple item delete 
				break;

			case 'list':
			default:


				$config = $this->loadCMSCfg('page');
				$list = $this->clistq->listviewcfg($this->table,$config,$object_category_id,$page);
					// Try load config with complex query 
					// TODO :: implement complex query later
					// $list = $this->clistq->listviewCfg2($this->table,$config,$object_category_id,$page);
					// $this->trace(json_encode($list));							
					// die('x');
				$list['config'] = $config;

				
	

			// $this->trace(json_encode($list['result']));			

				# code...
				break;
		}

		// $this->trace(json_encode($list['config']));
		$data['modal'] = $this->load->view('__cms/page/list_modal',$list,true);//return view as data

		//Load top menu
		$menuConfig = array('page_id'=>$this->page_id);
		$data['top_menu'] = $this->load->view('__cms/include/top',$menuConfig,true);

		// //Load side menu
		$menuConfig['backend_content_menu'] = array();
		$data['side_menu'] = $this->load->view('__cms/include/side',$menuConfig,true);

		//Load body
		$data['body'] = $this->load->view('__cms/page/list_bodycfg',$list,true);

		// //Load footage script
		$data['footage_script'] = '';


		$this->load->view('__cms/layout/list',$data);
	}

	



	function detail($act='',$id=0 ){
		$data = array();
		$body = array();		
		
		switch ($act) { // to tbt_proto_item

			case 'save':

				// 	//TODO :: implement item delete and multiple item delete 
				break;

			case 'edit':
			case 'view':
			default:

				//Load table structure
				$this->load->model('__proto_content_detail','cdetailq');
				$categoryDetail = $this->cdetailq->getItemById($this->table,$id);
				
				if(!$categoryDetail['status']){
					show_404();
					exit();
				}


				//Set table
				$this->table  = (empty($categoryDetail['result'][0]['table']))?"":$categoryDetail['result'][0]['table'];
				if(empty($this->table)){
					show_404();
					exit();
				}

				$fieldList = $this->cdetailq->getItemById($this->table,$id);
				$fieldList['category_id'] = $id;
									
					$cfg = $this->loadCMSCfg('page');

				//Load fieldList 
				$body['fieldList'] = $fieldList;
				$body['categoryDetail'] = $categoryDetail['result'][0];
				$body['pageConfig'] = $this->loadCfg($body['categoryDetail']['id']);
				
				
				// $this->trace(json_encode($body));

					// $this->trace($cfg);
				
				// $this->trace($fieldList);

				// $this->trace(json_decode('{"page_id":"CMS","mod_id":"CMS","hash_key":"","table":"","sort_key":"create_date","sort_direction":"DESC","enable_group_action":1,"visible_column":[{"name":"id","lable":"ID","search_index":0,"default_value":"","width":"auto","order_index":0},{"name":"alias","lable":"ALIAS","search_index":0,"default_value":"","width":"auto","order_index":0},{"name":"table","lable":"LINKED TABLE","search_index":0,"default_value":"","width":"auto","order_index":0},{"name":"mod_id","lable":"LINKED MODULE","search_index":0,"default_value":"","width":"auto","order_index":0},{"name":"hash_key","lable":"HASH","search_index":0,"default_value":"","width":"auto","order_index":0},{"name":"create_date","lable":"CREATE_DATE","search_index":0,"default_value":"","width":"auto","order_index":0},{"name":"delete_flag","lable":"ID","search_index":0,"default_value":"","width":"auto","order_index":0}]}',true));
				// var_dump($fieldList);
				// echo json_encode($fieldList);

				break;
		}


		//var_dump($fieldList);
		//Load top menu
		$menuConfig = array('page_id'=>$this->page_id);

		$data['top_menu'] = $this->load->view('__cms/include/top',$menuConfig,true);

		$data['side_menu'] = $this->load->view('__cms/include/side',$menuConfig,true);
		// die('')
		//Load body
		$data['body'] = $this->load->view('__cms/page/detail_bodycfg',$body,true);

		// //Load footage script
		$data['footage_script'] = $this->load->view('__cms/script/page/page_manager_js',$body,true);;

		$this->load->view('__cms/layout/detail',$data);
	}





	function create(){
		
		$post = $this->input->post();
		$backlink = (empty($post['callback_url']))?"":$post['callback_url'];
			unset($post['callback_url']);

		if(!empty($post)){

			//Write down config files
			$newConfig = array();
			$newConfig['listview'] = array();
			$newConfig['detailview'] = array();
			$newConfig['page'] = array (
				'page_title'=>$post['page_title'],
				'mod_id'=>$post['mod_id'],
				'table'=>$post['table'],
				'page_type'=>$post['page_type'],
				'sort_index'=>$post['sort_index'],
				'sort_direction'=>$post['sort_direction'],
				'content_list'=>$post['content_list'],
				'extend_dialog'=>$post['extend_dialog'],
			);


				$listviewObject = array(
		            "visible"=> "0",
		            "name"=> "id",
		            "label"=> "",
		            "width"=> "auto"
		        );

				$detailviewObject = array(
		              	"visiblity"=>"hidden",
			            "name"=>"",
			            "label"=>"",
			            "placeholder"=>"",
			            "default_value"=>"",
			            "width"=>"auto",
			            "popover_info"=>"",
			            "validation"=>"text"
		        );
		    // $newConfig['listview']
			$fields = $this->db->list_fields($post['table']);
			foreach ($fields as $field){
			   $listviewObject['name'] = $listviewObject['lable'] = $field;
			   		array_push( $newConfig['listview'],$listviewObject);
			   $detailviewObject['name'] = $detailviewObject['label'] = $field;
			   		array_push( $newConfig['detailview'],$detailviewObject);
			}

			


			//remove some keys from post
			unset($post['sort_index']);
			unset($post['sort_direction']);
			unset($post['content_list']);
			

			//Write down database
			$this->load->model('__proto_content_list','clistq');
			$result = $this->clistq->create($this->table,$post,'page_title');
			$cat_id = $this->db->insert_id();

			if(!empty($cat_id)){
				$cfg = $this->createCfg($cat_id,serialize($newConfig));
				if(!$cfg)
					//TODO :: implement when couldn't create file.
						return false;
			}


			if(!empty($backlink) && $result){
				redirect($backlink,'refresh');
			}else{
				echo 'no redirect';
			}

			return $result;
		}//end if 
		return false;
	}


//#############################################
//SECTION : Configuration 
//#############################################	
	function update(){
		$output = array();
		$output['listview'] =  array();
		$output['detailview'] =  array();
		$output['page'] =  array();

	
		$new_config = $this->input->post();

		//update page title 
		$options = array('page_title'=>$new_config['page_title'],'page_type'=>$new_config['page_type']);
		$condition = array('id'=>$new_config['id']);

		$this->load->model('__proto_content_list','clistq');
		$this->clistq->update($this->table,$options,$condition);
		//end : update page title


		// $this->trace($new_config);
		// die('n');
		$backlink = empty($new_config['callback_url'])?"":$new_config['callback_url'];
		$cat_id = $new_config['category_id'];

			unset($new_config['callback_url']);
			unset($new_config['category_id']);
		
		foreach ($new_config as $key => $value) {
					// var_dump($key);
					// echo $key.' > '.strpos('x'.$key,'lv_');
			if( strpos('x'.$key,'lv_')==1 ){
						//push to listview new_config
				array_push($output['listview'], $value);
			}else if(strpos('x'.$key,'dv_')==1){
						//push to detailview new_config
				array_push($output['detailview'],$value);

			}else{
						//push to page new_config
				$output['page'][$key] = $value;
						// array_push(,array($key=>));
			}
		}
		

		
		$cfg = $this->createCfg($cat_id,serialize($output));
			
		if(!empty($backlink))
			redirect($backlink,'refresh');

			exit(1);				

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
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class __cms_api_manager extends Admin_Controller {

	function __construct(){
		parent::__construct();
        $this->permission_check('cms');

		//TODO :: Move this to admin controller later 

		#CMS
		$this->pageSize = PAGESIZE;
		$this->table = 'cms_mobile_api';
		$this->page_id = 'api_manager';
		$this->page_title = 'API Builder';
		$this->page_object = 'API';
		$this->page_controller = '__cms_api_manager';
		#END_CMS

		// $this->load->config('backend_navigation');
		// $this->navigation = $this->config->item('backend_navigation');
		// var_dump($this->navigation);
	}//end constructor;


	//Default
	function index($act='',$id=''){
		//TODO :: redirecting to listview
		redirect(site_url('__cms_api_manager/listview'), 'refresh');
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

		$data = array();
		$list = array();		
		
		
		// var_dump($this->session->userdata('permission_set'));
		switch ($act) { // to tbt_proto_item

			case 'delete':
					//TODO :: implement item delete and multiple item delete 
				break;

			case 'list':
			default:

			
				$config = $this->loadCMSCfg('api');
				$this->load->model('__proto_content_list','clistq');
				$list = $this->clistq->listviewcfg($this->table,$config,$object_category_id,$page);
					// Try load config with complex query 
					// TODO :: implement complex query later
					// $list = $this->clistq->listviewCfg2($this->table,$config,$object_category_id,$page);
					// $this->trace(json_encode($list));							
					// die('x');
				$list['config'] = $config;
				

				// //load for cms/layout/list -> to on-off navigation
				// $res = $this->clistq->summon('cms_category','name','api_manager');
				// $res = $res->result_array();
				// $this->module = $res[0]['module_id'];
				// $this->cat_id = $res[0]['id'];
				
				// //['mod_id']
				// var_dump($res);
				// die('x');

				
	

			// $this->trace(json_encode($config));			

				# code...
				break;
		}

		// $this->trace(json_encode($list['config']));

		$menuConfig['page_title'] = 'API Manager';
		$menuConfig['page_id'] 	  = 'api_manager';


		//Assign parameter for modal
		$this->load->model('__proto_mobile_query','proto');
		$list['api_key'] = $this->proto->getAPI_KEY();
		$list['secret_key'] = $this->proto->getSECRET_KEY();
		$data['modal'] = $this->load->view('__cms/api/list_modal',$list,true);//return view as data
		// var_dump($list);
		// var_dump($data);
		//Load top menu
		$menuConfig = array('page_id'=>$this->page_id);
		$data['top_menu'] = $this->load->view('__cms/include/top',$menuConfig,true);

		// //Load side menu
		$menuConfig['backend_content_menu'] = array();
		$data['side_menu'] = $this->load->view('__cms/include/side',$menuConfig,true);

		//Load body
		$data['body'] = $this->load->view('__cms/api/list_bodycfg',$list,true);

		//Load footage script
		$data['footage_script'] ='';//$this->load->view('__cms/script/api/api_manager_js','',true);

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
				// var_dump($this->db->last_query());
				if(!$categoryDetail['status']){
					show_404();
					exit();
				}


				//Set table
				$apiTable  = (empty($categoryDetail['result'][0]['table']))?"":$categoryDetail['result'][0]['table'];
				if(empty($apiTable)){
					show_404();
					exit();
				}

				$fieldList = $this->cdetailq->getItemById($apiTable,$id);
				$fieldList['category_id'] = $id;
									
					$cfg = $this->loadCMSCfg('api');

// $this->trace(json_encode($cfg));
				//Load fieldList 
				$body['fieldList'] = $fieldList;
				$body['categoryDetail'] = $categoryDetail['result'][0];
				$body['pageConfig'] = $this->loadCfg($body['categoryDetail']['id'],'api_');
				$body['gameConfig'] = $this->loadGAMECfg();
				
				
				
				// $this->trace(json_encode($body['pageConfig']));

					// $this->trace($cfg);
				
				// $this->trace($fieldList);

				// $this->trace(json_decode('{"page_id":"CMS","mod_id":"CMS","hash_key":"","table":"","sort_key":"create_date","sort_direction":"DESC","enable_group_action":1,"visible_column":[{"name":"id","lable":"ID","search_index":0,"default_value":"","width":"auto","order_index":0},{"name":"alias","lable":"ALIAS","search_index":0,"default_value":"","width":"auto","order_index":0},{"name":"table","lable":"LINKED TABLE","search_index":0,"default_value":"","width":"auto","order_index":0},{"name":"mod_id","lable":"LINKED MODULE","search_index":0,"default_value":"","width":"auto","order_index":0},{"name":"hash_key","lable":"HASH","search_index":0,"default_value":"","width":"auto","order_index":0},{"name":"create_date","lable":"CREATE_DATE","search_index":0,"default_value":"","width":"auto","order_index":0},{"name":"delete_flag","lable":"ID","search_index":0,"default_value":"","width":"auto","order_index":0}]}',true));
				// var_dump($fieldList);
				// echo json_encode($fieldList);

					// Load content required filed
						$this->load->model('__proto_mobile_query','proto');
						//Load API Config
						$config = '';
						$apiDetail = $this->proto->summon($this->table,'name',$body['pageConfig']['meta']['name']);
						$apiDetail = $apiDetail->result_array();
						$apiDetail = $apiDetail[0];
						// var_dump($apiDetail);
						// die($this->db->last_query());
						if(!empty($apiDetail)){
							$config = $this->loadCfg($apiDetail['id'],'api_');
						}
						//Limit field
						$defaultField = array('id','create_date','delete_flag');		
						$fieldSet = $this->proto->getFieldList($config['meta']['table']);
						$this->config_table = $config['meta']['table'];

						//remove default feild from feildSet
						$temp = array();
						foreach ($fieldSet as $key => $value) {
							if(!in_array($value, $defaultField)){
								array_push($temp, $value);
							}
						}
						$fieldSet = $temp;//array_flip($temp);
						// $this->trace($fieldSet);
						$body['pageConfig']['body']['insert']['required_field'] = implode(',', $fieldSet);
						$body['pageConfig']['body']['update']['required_field'] = implode(',', $fieldSet);



				break;
		}


		//var_dump($fieldList);
		//Load top menu
		$menuConfig = array('page_id'=>$this->page_id);

		$data['top_menu'] = $this->load->view('__cms/include/top',$menuConfig,true);

		$data['side_menu'] = $this->load->view('__cms/include/side',$menuConfig,true);
		// die('')
		//Load body
		$data['body'] = $this->load->view('__cms/api/detail_bodycfg',$body,true);

		// //Load footage script
		$data['footage_script'] = $this->load->view('__cms/script/api/api_manager_js','',true);

		$this->load->view('__cms/layout/detail',$data);
	}





	function create(){
		
		$post = $this->input->post();
		$backlink = (empty($post['callback_url']))?"":$post['callback_url'];
			unset($post['callback_url']);

		if(!empty($post)){

			// $this->trace($post);
			// die('n');

			$newConfig = array();
			$newConfig['meta'] = $newConfig['body'] = array();


			$newConfig['meta']['name'] = $post['name'];
			$newConfig['meta']['description'] = '';
			$newConfig['meta']['table'] = $post['table'];
			$newConfig['meta']['mod_id'] = $post['mod_id'];
			$newConfig['meta']['cat_id'] = $post['cat_id'];
			$newConfig['meta']['create_date'] = '';
			$newConfig['meta']['is_ready_to_use'] = (array_key_exists('is_ready_to_use', $post))?$post['is_ready_to_use']:0;
			$newConfig['meta']['is_enable'] = 1;
			$newConfig['meta']['delete_flag'] = 0;

			
			$newConfig['body']['fieldList'] = array();
			// $newConfig['body']['get'] = array(); //{ LIST / DETAIL }{ SEARCH INDEX  - DEFAULT PAGE SIZE - SORT }
			// $newConfig['body']['set'] = array(); //{ WHERE - INPUT - REQUIRE FILED }
			$newConfig['body']['list'] = array("search_index"=>"","default_page_size"=>"","sort_index"=>"","sort_direction"=>"");
			$newConfig['body']['detail'] = array();
			$newConfig['body']['insert'] = array("required_field"=>"","where_index"=>"");
			$newConfig['body']['update'] = array("required_field"=>"","where_index"=>"");
			$newConfig['body']['delete'] = array("required_field"=>"","where_index"=>"");

			$newConfig['body']['method'] = 'GET';//POST
			$newConfig['body']['auth_type'] = 'NONE';//PUBLIC_TOKEN //PRIVATE_TOKEN
			$newConfig['body']['default_page_size'] = 10;



			// if(!empty($post['table'])){
			// 			$fields = $this->db->list_fields($post['table']);
			// 			// foreach ($fields as $field) {
			// 			// 	$targetObeject = array(
	  //    //                          "name" => $field,
	  //    //                          "label" => $field,
	  //    //                          "default_value" => ""
	  //    //                     );	
			// 			// 	array_push($newConfig['body']['fieldList'], $targetObeject);
			// 			// }//end for

			// }//end if 
			


			
			//Write down to database
			$this->load->model('__proto_content_list','clistq');
			$result = $this->clistq->create($this->table,$newConfig['meta'],'name');
			$cat_id = $this->db->insert_id();



			// $this->trace($this->db->last_query());
			if(!empty($cat_id)){
				// protected function createCfg($cat_id,$data,$prefix='')
				$cfg = $this->createCfg($cat_id,serialize($newConfig),'api_');
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

		$post = $new_config = $this->input->post();
		// $this->trace($this->input->post());
		// die('x');
		$backlink = empty($new_config['callback_url'])?"":$new_config['callback_url'];
		$cat_id = $new_config['category_id'];

			unset($new_config['callback_url']);
			unset($new_config['category_id']);
		
		
		//Write new Config file
		$cfg = $this->createCfg($cat_id,serialize($new_config),'api_');
		


		//Write new database
		$condition = array('name'=>$post['meta']['name']);

		$newConfig = array();
		$newConfig['is_ready_to_use']  = (array_key_exists('is_ready_to_use', $post['meta']))?$post['meta']['is_ready_to_use']:0;
		
		$this->load->model('__proto_content_list','clistq');
		$result = $this->clistq->update($this->table,$post['meta'],$condition);
		// echo $this->db->last_query();


			
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



	function group_delete() {
    	$dat = $this->input->post('forms');
    	$this->load->model('__proto_content_list','clistq');
		// $this->trace(array($dat,$this->table));

		foreach ($dat as $key => $id) {
			$this->clistq->delete($this->table,array('id'=>$id));
			//delete config file
			self::deleteCfg($id);
    	}

    	$callback_url = $this->session->userdata('current_url');
    	if(!empty($callback_url))
			redirect($callback_url,'refresh');
	}


	public function resetAPIKEY($password){
		if(!empty($password)){
			if($password == 'google'){
				$options = array(
					'api_key'=>md5('sso_mobile_api_key'.time()),
					'secret_key'=>md5('sso_mobile_secret_key'.time()),
					'salt'=>'0473'
				);

				$this->db->truncate('cms_mobile_api_config');
				$result = $this->db->insert('cms_mobile_api_config',$options);

				echo (!empty($result))?'Created':'Unable to generate new API key';
			}else{
				die('Invalid password input');
			}
		}
		
	}



}
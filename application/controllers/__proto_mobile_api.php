<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Using restful server Library from 
 * @author		Phil Sturgeon
 * @link		http://philsturgeon.co.uk/code/
*/

// require APPPATH.'/libraries/REST_Controller.php';
// require APPPATH.'/libraries/auth.php';
// require APPPATH.'/libraries/response.php';


class __proto_mobile_api extends REST_Controller{
// class __proto_mobile_api extends Admin_Controller{

	function __construct(){
		parent::__construct();
		date_default_timezone_set('Asia/Bangkok');
		$this->load->model('__proto_mobile_query','proto');
	

		$this->table = 'cms_mobile_api';
	}


    function _convertPermission ( $permission ) {

        if ($permission <  32) {
            $base2 = base_convert($permission, 10, 2) ;
            $base2 = str_pad($base2, 4, "0", STR_PAD_LEFT);

            $permission_set = array(
                'create' => $base2[0],
                'update' => $base2[1],
                'delete' => $base2[2],
                'view'   => $base2[3],
                'manage' => $base2[4]
            );

            return $permission_set;
        }

        return false;
    }

	public function get_token_get () {

        $data = array(
            'username' => '11234567801',
            'password' => '123',
            'digest'   => 'aaaaa'
        );
		$soap_data = array('username' => $data['username'] , 'password' => $data['password'] , 'digest' => $data['digest'] );
		$result = $this->user->login_soap($soap_data);
		$this->response($result, 200);
	 }

	public function get_login_get () {
		//$data = $this->get();
        $data = array(
            'token' => 'aaaaa'
        );

		$user = $this->user->getByField(array('last_token' => $data['token']));
		
		/*echo "<pre>";
		print_r($user);
		echo "</pre>";*/

		if (!empty($user)) {
            ###########################################################
            # SET SESSION
            ###########################################################
            $user_data = array(
                'id'                => $user->id,
                'username'          => $user->user_login,
                'email'             => $user->user_email,
                'group_name'        => $user->group_name,
                'is_internal_user'  => $user->is_internal_user,
                'cookie'            => $cookie_val,
                'token'             => $user->last_token,
                'lang'              => 'en',
                'super_admin'       => 0
            );  
            $this->session->set_userdata($user_data); 

            ###########################################################
            # GET PERMISSION SET
            ###########################################################
            $this->db->select('cms_group_permission.cat_id, cms_group_permission.permission_type');
            $this->db->from('cms_users');
            $this->db->join('cms_group_permission', 'cms_users.group_id = cms_group_permission.group_id');
            $this->db->join('cms_module', 'cms_group_permission.cat_id = cms_module.id');
            $this->db->where('cms_users.id', $user->id);

            $query = $this->db->get();

            $group_permission_set = $query->result();

            $permission_set = array();

            foreach ($group_permission_set as $set) {
                $permission_type = $this->_convertPermission($set->permission_type);
                $permission_set[$set->cat_id] = $permission_type;
            } 

            $this->session->set_userdata(array('permission_set' => $permission_set)); 

            $url = '__ps_projects';
			redirect( my_url( $url ) );
		} else {

		  	$state = false;  
	      	$code = '909';
	      	$msg = 'request couldn\'t be complete';
	      	$output = array();
		  	$this->response(array("status"=>$state,"errorCode"=>$code,"message"=>$msg,"result"=>$output), 200);
			return ;
		}
	}

	public function get_commonList_get(){
		
		$param = $this->get();
		$this->load->model('__proto_mobile_query','proto');
		
		
		//Load API Config
		$config = '';
		$apiDetail = $this->proto->summon($this->table,'name',$param['method']);
		$apiDetail = $apiDetail->result_array();
		$apiDetail = $apiDetail[0];


		if(!empty($apiDetail)){
			$config = $this->loadCfg($apiDetail['id'],'api_');
		}else{
			  
			  $state = false;  
		      $code = '909';
		      $msg = 'request couldn\'t be complete';
		      $output = array();
			  $this->response(array("status"=>$state,"errorCode"=>$code,"message"=>$msg,"result"=>$output), 200);
				return ;
		}
		

		if(!array_key_exists('debug', $param))
			$param['debug'] = 0;

		if(!array_key_exists('keyword', $param))
			$param['keyword'] = '';

		//TODO :: MOVE TO SINGLE FUNCTION LATER
		if(empty($config['meta']['is_ready_to_use'])){
			  $state = false;  
		      $code = '909';
		      $msg = 'request couldn\'t be complete, API is not ready to use';
		      $output = array();
			  $this->response(array("status"=>$state,"errorCode"=>$code,"message"=>$msg,"result"=>$output), 200);
				return ;
		}

		//Require param 
		$result = $this->proto->get_commonList($config['meta']['table'],$config['body']['list']['search_index'],$param['keyword'],$config['body']['list']['sort_index'],$config['body']['list']['sort_direction'],$config['body']['list']['default_page_size'],$param['page'],$param['debug']);
		// //array('status'=>'true');



		if($result['status']){
			$this->response($result , 200);
		}else{
			$this->response($result , 200);
		}

	}



	public function get_commonList_post(){
		
		$param = $this->post();
		$this->load->model('__proto_mobile_query','proto');
		
		
		//Load API Config
		$config = '';
		$apiDetail = $this->proto->summon($this->table,'name',$param['method']);
		$apiDetail = $apiDetail->result_array();
		$apiDetail = $apiDetail[0];


		if(!empty($apiDetail)){
			$config = $this->loadCfg($apiDetail['id'],'api_');
		}else{
			  
			  $state = false;  
		      $code = '909';
		      $msg = 'request couldn\'t be complete';
		      $output = array();
			  $this->response(array("status"=>$state,"errorCode"=>$code,"message"=>$msg,"result"=>$output), 200);
				return ;
		}
		

		if(!array_key_exists('debug', $param))
			$param['debug'] = 0;

		if(!array_key_exists('keyword', $param))
			$param['keyword'] = '';

		//TODO :: MOVE TO SINGLE FUNCTION LATER
		if(empty($config['meta']['is_ready_to_use'])){
			  $state = false;  
		      $code = '909';
		      $msg = 'request couldn\'t be complete, API is not ready to use';
		      $output = array();
			  $this->response(array("status"=>$state,"errorCode"=>$code,"message"=>$msg,"result"=>$output), 200);
				return ;
		}


		//Require param 
			// method - keyword - page 
		$result = $this->proto->get_commonList($config['meta']['table'],$config['body']['list']['search_index'],$param['keyword'],$config['body']['list']['sort_index'],$config['body']['list']['sort_direction'],$config['body']['list']['default_page_size'],$param['page'],$param['debug']);
		// //array('status'=>'true');

		if($result['status']){
			$this->response($result , 200);
		}else{
			$this->response($result , 200);
		}

	}



























	public function get_commonDetail_get(){
		
		$param = $this->get();
		// // $result = $this->sbmq->signIn($param);
		$this->load->model('__proto_mobile_query','proto');
		

		//Load API Config
		$config = '';
		$apiDetail = $this->proto->summon($this->table,'name',$param['method']);
		$apiDetail = $apiDetail->result_array();
		$apiDetail = $apiDetail[0];

		if(!empty($apiDetail)){
			$config = $this->loadCfg($apiDetail['id'],'api_');
		}else{
			  
			  $state = false;  
		      $code = '909';
		      $msg = 'request couldn\'t be complete';
		      $output = array();
			  $this->response(array("status"=>$state,"errorCode"=>$code,"message"=>$msg,"result"=>$output), 200);
				return ;
		}
		

		if(!array_key_exists('debug', $param))
			$param['debug'] = 0;
		//TODO :: MOVE TO SINGLE FUNCTION LATER
		if(empty($config['meta']['is_ready_to_use'])){
			  $state = false;  
		      $code = '909';
		      $msg = 'request couldn\'t be complete, API is not ready to use';
		      $output = array();
			  $this->response(array("status"=>$state,"errorCode"=>$code,"message"=>$msg,"result"=>$output), 200);
				return ;
		}

		$result = $this->proto->get_commonDetail($config['meta']['table'],$param['id']);


		if($result['status']){
			$this->response($result , 200);
		}else{
			$this->response($result , 200);
		}

		
	}




	public function get_commonDetail_post(){
		
		$param = $this->post();
		// // $result = $this->sbmq->signIn($param);
		$this->load->model('__proto_mobile_query','proto');
		

		//Load API Config
		$config = '';
		$apiDetail = $this->proto->summon($this->table,'name',$param['method']);
		$apiDetail = $apiDetail->result_array();
		$apiDetail = $apiDetail[0];

		if(!empty($apiDetail)){
			$config = $this->loadCfg($apiDetail['id'],'api_');
		}else{
			  
			  $state = false;  
		      $code = '909';
		      $msg = 'request couldn\'t be complete';
		      $output = array();
			  $this->response(array("status"=>$state,"errorCode"=>$code,"message"=>$msg,"result"=>$output), 200);
				return ;
		}
		

		if(!array_key_exists('debug', $param))
			$param['debug'] = 0;

		//TODO :: MOVE TO SINGLE FUNCTION LATER
		if(empty($config['meta']['is_ready_to_use'])){
			  $state = false;  
		      $code = '909';
		      $msg = 'request couldn\'t be complete, API is not ready to use';
		      $output = array();
			  $this->response(array("status"=>$state,"errorCode"=>$code,"message"=>$msg,"result"=>$output), 200);
				return ;
		}

		$result = $this->proto->get_commonDetail($config['meta']['table'],$param['id']);


		if($result['status']){
			$this->response($result , 200);
		}else{
			$this->response($result , 200);
		}

		
	}

































	// public function requiredField_get(){
	// 	$param = $this->get();
	// 	$options = array();
	// 	$condition = array();

		
	// 	// $this->response($fieldSet , 200);

	// }

	public function set_commonInsert_get(){

		$param = $this->get();
		$options = array();
		$condition = array();

		$this->load->model('__proto_mobile_query','proto');
		
		
		if(array_key_exists('on_debug_console', $param)){
				if(!empty($param['on_debug_console'])){
					$param = self::cleanParam($param);
					unset($param['on_debug_console']);	
				}
				
		}

		//Load API Config
		$config = '';
		$apiDetail = $this->proto->summon($this->table,'name',$param['method']);
		$apiDetail = $apiDetail->result_array();
		$apiDetail = $apiDetail[0];

		if(!empty($apiDetail)){
			$config = $this->loadCfg($apiDetail['id'],'api_');
		}else{
			  
			  $state = false;  
		      $code = '909';
		      $msg = 'request couldn\'t be complete';
		      $output = array();
			  $this->response(array("status"=>$state,"errorCode"=>$code,"message"=>$msg,"result"=>$output), 200);
				return ;
		}
		

		if(!array_key_exists('debug', $param))
			$param['debug'] = 0;

		
		//Limit field
		$defaultField = array('id','create_date','delete_flag');		
		$fieldSet = $this->proto->getFieldList($config['meta']['table']);

		//remove default feild from feildSet
		$temp = array();
		foreach ($fieldSet as $key => $value) {
			if(!in_array($value, $defaultField)){
				array_push($temp, $value);
			}
		}

		//Restore - with turn array value to array key
		$fieldSet = array_flip($temp);
		// var_dump($fieldSet);
		

		
		//Set param to filedSet
		$required = array();
		foreach ($fieldSet as $key => $value) {
			if(!array_key_exists($key, $param)){
				array_push($required, $value);
			}

			if($param[$key]=='null'||$param[$key]=='NULL'||$param[$key]==' '){
				$param[$key]= '';
			}

			$fieldSet[$key]  = $param[$key];
		}

		//In case missing requirefiled
		if(!empty($required)){
			  $state = false;  
		      $code = '909';
		      $msg = 'request couldn\'t be complete , parameter is missing';
		      $output = $required;
			  $this->response(array("status"=>$state,"errorCode"=>$code,"message"=>$msg,"result"=>$output), 200);
				return ;
		}


		$options = $fieldSet;
		$condition = array();
		//TODO :: MOVE TO SINGLE FUNCTION LATER
		if(empty($config['meta']['is_ready_to_use'])){
			  $state = false;  
		      $code = '909';
		      $msg = 'request couldn\'t be complete, API is not ready to use';
		      $output = array();
			  $this->response(array("status"=>$state,"errorCode"=>$code,"message"=>$msg,"result"=>$output), 200);
				return ;
		}
		
		$result = $this->proto->set_commonInsert($config['meta']['table'],$options,$condition,$param['debug']);


		if($result['status']){
			$this->response($result , 200);
		}else{
			$this->response($result , 200);
		}

		
	}




	public function set_commonInsert_post(){

		$param = $this->post();
		$options = array();
		$condition = array();

		$this->load->model('__proto_mobile_query','proto');
		
		
		if(array_key_exists('on_debug_console', $param)){
				if(!empty($param['on_debug_console'])){
					$param = self::cleanParam($param);
					unset($param['on_debug_console']);	
				}
				
		}

		//Load API Config
		$config = '';
		$apiDetail = $this->proto->summon($this->table,'name',$param['method']);
		$apiDetail = $apiDetail->result_array();
		$apiDetail = $apiDetail[0];

		if(!empty($apiDetail)){
			$config = $this->loadCfg($apiDetail['id'],'api_');
		}else{
			  
			  $state = false;  
		      $code = '909';
		      $msg = 'request couldn\'t be complete';
		      $output = array();
			  $this->response(array("status"=>$state,"errorCode"=>$code,"message"=>$msg,"result"=>$output), 200);
				return ;
		}
		

		if(!array_key_exists('debug', $param))
			$param['debug'] = 0;

		
		//Limit field
		$defaultField = array('id','create_date','delete_flag');		
		$fieldSet = $this->proto->getFieldList($config['meta']['table']);

		//remove default feild from feildSet
		$temp = array();
		foreach ($fieldSet as $key => $value) {
			if(!in_array($value, $defaultField)){
				array_push($temp, $value);
			}
		}

		//Restore - with turn array value to array key
		$fieldSet = array_flip($temp);
		// var_dump($fieldSet);
		

		
		//Set param to filedSet
		$required = array();
		foreach ($fieldSet as $key => $value) {
			if(!array_key_exists($key, $param)){
				array_push($required, $value);
			}

			if($param[$key]=='null'||$param[$key]=='NULL'||$param[$key]==' '){
				$param[$key]= '';
			}

			$fieldSet[$key]  = $param[$key];
		}

		//In case missing requirefiled
		if(!empty($required)){
			  $state = false;  
		      $code = '909';
		      $msg = 'request couldn\'t be complete , parameter is missing';
		      $output = $required;
			  $this->response(array("status"=>$state,"errorCode"=>$code,"message"=>$msg,"result"=>$output), 200);
				return ;
		}


		$options = $fieldSet;
		$condition = array();
		//TODO :: MOVE TO SINGLE FUNCTION LATER
		if(empty($config['meta']['is_ready_to_use'])){
			  $state = false;  
		      $code = '909';
		      $msg = 'request couldn\'t be complete, API is not ready to use';
		      $output = array();
			  $this->response(array("status"=>$state,"errorCode"=>$code,"message"=>$msg,"result"=>$output), 200);
				return ;
		}
		
		$result = $this->proto->set_commonInsert($config['meta']['table'],$options,$condition,$param['debug']);


		if($result['status']){
			$this->response($result , 200);
		}else{
			$this->response($result , 200);
		}

		
	}

































	public function set_commonUpdate_get(){

		$param = $this->get();
		$options = array();
		$condition = array();

		$this->load->model('__proto_mobile_query','proto');
		
		if(array_key_exists('on_debug_console', $param)){
				if(!empty($param['on_debug_console'])){
					$param = self::cleanParam($param);
					unset($param['on_debug_console']);	
				}
				
		}

		//Load API Config
		$config = '';
		$apiDetail = $this->proto->summon($this->table,'name',$param['method']);
		$apiDetail = $apiDetail->result_array();
		$apiDetail = $apiDetail[0];


		

		if(!empty($apiDetail)){
			$config = $this->loadCfg($apiDetail['id'],'api_');
			// $this->trace($config);
			// die('x');	
		}else{
			  
			  $state = false;  
		      $code = '909';
		      $msg = 'request couldn\'t be complete';
		      $output = array();
			  $this->response(array("status"=>$state,"errorCode"=>$code,"message"=>$msg,"result"=>$output), 200);
				return ;
		}
		

		if(!array_key_exists('debug', $param))
			$param['debug'] = 0;
		
		
		//Limit field
		$defaultField = array('id','create_date','delete_flag');		
		$fieldSet = $this->proto->getFieldList($config['meta']['table']);

		//remove default feild from feildSet
		$temp = array();
		foreach ($fieldSet as $key => $value) {
			if(!in_array($value, $defaultField)){
				array_push($temp, $value);
			}
		}

		//Restore - with turn array value to array key
		$fieldSet = array_flip($temp);
		// var_dump($fieldSet);
		

		
		//Set param to filedSet
		$required = array();
		foreach ($fieldSet as $key => $value) {
			if(!array_key_exists($key, $param)){
				array_push($required, $value);
			}

			if($param[$key]=='null'||$param[$key]=='NULL'||$param[$key]==' '){
				$param[$key]= '';
			}

			$fieldSet[$key]  = $param[$key];
		}


		//Update key indicator 
		if(!array_key_exists($config['body']['update']['where_index'], $param)){
				array_push($required, $config['body']['update']['where_index']);
		}


		//In case missing requirefiled
		if(!empty($required)){
			  $state = false;  
		      $code = '909';
		      $msg = 'request couldn\'t be complete , parameter is missing';
		      $output = $required;
			  $this->response(array("status"=>$state,"errorCode"=>$code,"message"=>$msg,"result"=>$output), 200);
				return ;
		}


		$options = $fieldSet;
		$condition = array($config['body']['update']['where_index']=>$param[$config['body']['update']['where_index']]);
		//TODO :: MOVE TO SINGLE FUNCTION LATER
		if(empty($config['meta']['is_ready_to_use'])){
			  $state = false;  
		      $code = '909';
		      $msg = 'request couldn\'t be complete, API is not ready to use';
		      $output = array();
			  $this->response(array("status"=>$state,"errorCode"=>$code,"message"=>$msg,"result"=>$output), 200);
				return ;
		}

		
		$result = $this->proto->set_commonUpdate($config['meta']['table'],$options,$condition,$param['debug']);


		if($result['status']){
			$this->response($result , 200);
		}else{
			$this->response($result , 200);
		}

		
	}







	public function set_commonUpdate_post(){

		$param = $this->post();
		$options = array();
		$condition = array();

		$this->load->model('__proto_mobile_query','proto');
		
		if(array_key_exists('on_debug_console', $param)){
				if(!empty($param['on_debug_console'])){
					$param = self::cleanParam($param);
					unset($param['on_debug_console']);	
				}
				
		}

		//Load API Config
		$config = '';
		$apiDetail = $this->proto->summon($this->table,'name',$param['method']);
		$apiDetail = $apiDetail->result_array();
		$apiDetail = $apiDetail[0];


		

		if(!empty($apiDetail)){
			$config = $this->loadCfg($apiDetail['id'],'api_');
			// $this->trace($config);
			// die('x');	
		}else{
			  
			  $state = false;  
		      $code = '909';
		      $msg = 'request couldn\'t be complete';
		      $output = array();
			  $this->response(array("status"=>$state,"errorCode"=>$code,"message"=>$msg,"result"=>$output), 200);
				return ;
		}
		

		if(!array_key_exists('debug', $param))
			$param['debug'] = 0;
		
		
		//Limit field
		$defaultField = array('id','create_date','delete_flag');		
		$fieldSet = $this->proto->getFieldList($config['meta']['table']);

		//remove default feild from feildSet
		$temp = array();
		foreach ($fieldSet as $key => $value) {
			if(!in_array($value, $defaultField)){
				array_push($temp, $value);
			}
		}

		//Restore - with turn array value to array key
		$fieldSet = array_flip($temp);
		// var_dump($fieldSet);
		

		
		//Set param to filedSet
		$required = array();
		foreach ($fieldSet as $key => $value) {
			if(!array_key_exists($key, $param)){
				array_push($required, $value);
			}

			if($param[$key]=='null'||$param[$key]=='NULL'||$param[$key]==' '){
				$param[$key]= '';
			}

			$fieldSet[$key]  = $param[$key];
		}


		//Update key indicator 
		if(!array_key_exists($config['body']['update']['where_index'], $param)){
				array_push($required, $config['body']['update']['where_index']);
		}


		//In case missing requirefiled
		if(!empty($required)){
			  $state = false;  
		      $code = '909';
		      $msg = 'request couldn\'t be complete , parameter is missing';
		      $output = $required;
			  $this->response(array("status"=>$state,"errorCode"=>$code,"message"=>$msg,"result"=>$output), 200);
				return ;
		}


		$options = $fieldSet;
		$condition = array($config['body']['update']['where_index']=>$param[$config['body']['update']['where_index']]);

		//TODO :: MOVE TO SINGLE FUNCTION LATER
		if(empty($config['meta']['is_ready_to_use'])){
			  $state = false;  
		      $code = '909';
		      $msg = 'request couldn\'t be complete, API is not ready to use';
		      $output = array();
			  $this->response(array("status"=>$state,"errorCode"=>$code,"message"=>$msg,"result"=>$output), 200);
				return ;
		}
		
		$result = $this->proto->set_commonUpdate($config['meta']['table'],$options,$condition,$param['debug']);


		if($result['status']){
			$this->response($result , 200);
		}else{
			$this->response($result , 200);
		}

		
	}































	public function set_commonDelete_get(){

		$param = $this->get();
		// $options = array();
		$condition = array();

		$this->load->model('__proto_mobile_query','proto');
		

		//Load API Config
		$config = '';
		$apiDetail = $this->proto->summon($this->table,'name',$param['method']);
		$apiDetail = $apiDetail->result_array();
		$apiDetail = $apiDetail[0];


		

		if(!empty($apiDetail)){
			$config = $this->loadCfg($apiDetail['id'],'api_');
		}else{
			  
			  $state = false;  
		      $code = '909';
		      $msg = 'request couldn\'t be complete w';
		      $output = array();
			  $this->response(array("status"=>$state,"errorCode"=>$code,"message"=>$msg,"result"=>$output), 200);
				return ;
		}
		

		if(!array_key_exists('debug', $param))
			$param['debug'] = 0;
	

		//Delete key indicator 
		if(!array_key_exists($config['body']['update']['where_index'], $param)){
				array_push($required, $config['body']['update']['where_index']);
		}


		//In case missing requirefiled
		if(!empty($required)){
			  $state = false;  
		      $code = '909';
		      $msg = 'request couldn\'t be complete , parameter is missing';
		      $output = $required;
			  $this->response(array("status"=>$state,"errorCode"=>$code,"message"=>$msg,"result"=>$output), 200);
				return ;
		}


		// $options = $fieldSet;
		$condition = array($config['body']['update']['where_index']=>$param[$config['body']['update']['where_index']]);

		//TODO :: MOVE TO SINGLE FUNCTION LATER
		if(empty($config['meta']['is_ready_to_use'])){
			  $state = false;  
		      $code = '909';
		      $msg = 'request couldn\'t be complete, API is not ready to use';
		      $output = array();
			  $this->response(array("status"=>$state,"errorCode"=>$code,"message"=>$msg,"result"=>$output), 200);
				return ;
		}
		
		$result = $this->proto->set_commonDelete($config['meta']['table'],$condition,$param['debug']);


		if($result['status']){
			$this->response($result , 200);
		}else{
			$this->response($result , 200);
		}

		
	}



	public function set_commonDelete_post(){

		$param = $this->post();
		// $options = array();
		$condition = array();

		$this->load->model('__proto_mobile_query','proto');
		

		//Load API Config
		$config = '';
		$apiDetail = $this->proto->summon($this->table,'name',$param['method']);
		$apiDetail = $apiDetail->result_array();
		$apiDetail = $apiDetail[0];


		

		if(!empty($apiDetail)){
			$config = $this->loadCfg($apiDetail['id'],'api_');
		}else{
			  
			  $state = false;  
		      $code = '909';
		      $msg = 'request couldn\'t be complete w';
		      $output = array();
			  $this->response(array("status"=>$state,"errorCode"=>$code,"message"=>$msg,"result"=>$output), 200);
				return ;
		}
		

		if(!array_key_exists('debug', $param))
			$param['debug'] = 0;
	

		//Delete key indicator 
		if(!array_key_exists($config['body']['update']['where_index'], $param)){
				array_push($required, $config['body']['update']['where_index']);
		}


		//In case missing requirefiled
		if(!empty($required)){
			  $state = false;  
		      $code = '909';
		      $msg = 'request couldn\'t be complete , parameter is missing';
		      $output = $required;
			  $this->response(array("status"=>$state,"errorCode"=>$code,"message"=>$msg,"result"=>$output), 200);
				return ;
		}


		// $options = $fieldSet;
		$condition = array($config['body']['update']['where_index']=>$param[$config['body']['update']['where_index']]);

		//TODO :: MOVE TO SINGLE FUNCTION LATER
		if(empty($config['meta']['is_ready_to_use'])){
			  $state = false;  
		      $code = '909';
		      $msg = 'request couldn\'t be complete, API is not ready to use';
		      $output = array();
			  $this->response(array("status"=>$state,"errorCode"=>$code,"message"=>$msg,"result"=>$output), 200);
				return ;
		}
		
		$result = $this->proto->set_commonDelete($config['meta']['table'],$condition,$param['debug']);


		if($result['status']){
			$this->response($result , 200);
		}else{
			$this->response($result , 200);
		}

		
	}


































	private function cleanParam($list){
		if(is_array($list)){
			$output = array();
			foreach ($list as $key => $value) {
				$output[$key] = urldecode($value);
			}
			return $output;
		}  
		return $list;
	}




	public function get_sso_register_post(){ //'fbid','user_email','user_firstname','user_lastname'
		$post = $this->post();

		$result = $this->proto->get_sso_register($post);
		if($result['status']){
			$this->response($result , 200);
		}else{
			$this->response($result , 200);
		}
	}



	public function get_sso_login_post(){ //'fbid','user_digest','facebook_token'
		$post = $this->post();

		$result = $this->proto->get_sso_login($post);
		if($result['status']){
			$this->response($result , 200);
		}else{
			$this->response($result , 200);
		}
	}



	public function get_sso_logout_post(){ //'fbid'
		$post = $this->post();

		$result = $this->proto->get_sso_logout($post);
		if($result['status']){
			$this->response($result , 200);
		}else{
			$this->response($result , 200);
		}
	}


	public function get_sso_simple_action_get(){
		$data['param'] = $this->get();
		$data['game_config'] = $this->loadGAMECfg();
		// echo "<pre>";
		// print_r($data['param']);
		// echo "</pre>";
		//  die();

		$result = $this->proto->simpleAction($data);
		if($result['status']){
			$this->response($result , 200);
		}else{
			$this->response($result , 200);
		}
	}




	public function post_sync_gdata_post(){
		$data['param'] = $this->post();

		$result = $this->proto->syncGData($data);
		// $result = $data;
		
		if($result['status']){
			$this->response($result , 200);
		}else{
			$this->response($result , 200);
		}
			
	}


	public function post_sync_fbdata_post(){
		$data['param'] = $this->post();

		$result = $this->proto->syncFbData($data);
		// $result = $data;
		
		if($result['status']){
			$this->response($result , 200);
		}else{
			$this->response($result , 200);
		}
			
	}

	// public function get_sso_channel_clone_get(){
	// 	$content = file_get_contents('http://gdata.youtube.com/feeds/api/playlists/PLcymrTggwPvM5fnEqtiL77ppNSgQ82Wig?v=2&alt=json');

	// 	echo "<pre>";
	// 	print_r($content);
	// 	echo "</pre>";
	// 	 die();
	// }


	// public function get_sso_channel_view_update_get(){

	// }


	// //SYSTEM
	// public function get_sso_register_get(){

	// 	$param = $this->get();
		
	// 	$this->load->model('__proto_mobile_query','proto');
	// 	$result = $this->proto->get_sso_register($config['meta']['table'],$condition,$param['debug']);


	// 	if($result['status']){
	// 		$this->response($result , 200);
	// 	}else{
	// 		$this->response($result , 200);
	// 	}

	// }//end sso register function 


























	

}

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class __ps_complain extends Admin_Controller {

	function __construct(){
		parent::__construct();

        $this->permission_check('complain');

		//TODO :: Move this to admin controller later 

		#CMS
		$this->pageSize = PAGESIZE;
		$this->table = 'tbt_complain';
		$this->page_id = 'ps_generation';
		$this->page_title = freetext('complain');
		$this->page_object = 'Page';
		$this->page_controller = '__ps_complain';

		//set lang
		$this->session->set_userdata('lang', 'th');
		
		#END_CMS

		
		// $this->load->config('backend_navigation');
		// $this->navigation = $this->config->item('backend_navigation');
		// var_dump($this->navigation);
	}//end constructor;


	 // public function permission_trace(){
  //       $this->trace($this->session->userdata('permission_set'));
  //   }


	//Default
	function index($id=''){
		
		//GET :: project id
		$this->project_id  = $id;
		//echo $this->project_id;	

		//TODO :: redirecting to listview
		//redirect(site_url('__ps_fix_claim/listview/list/'.$this->project_id), 'refresh');
		redirect(site_url('__ps_complain/listview_complain'), 'refresh');
	}

	function changePageSize( $newPageSize = PAGESIZE ){
		$newValue = array('current_page'=> $newPageSize);
		$this->session->set_userdata($newValue);
		// $this->trace($newValue);

		redirect(site_url('__ps_complain'),'refresh');
		// $callback_url = $this->session->userdata('current_url');		
		// // $this->trace($callback_url);
		// if(!empty($callback_url))
		// 	redirect($callback_url,'refresh');
	}

	
	function listview_complain($page=1,$tempMatch=''){
		
		$newValue = array('current_url'=> site_url($this->uri->uri_string()) );
		$this->session->set_userdata($newValue);
		
		$this->load->model('__complain_model');

		// $this->tab = 1;
		// $this->function = 'listview_prospect';
		$data = array();
		$list = array();
		//$modal_data = array();
		//$list_project = array();		

			$list = $this->__complain_model->getContentList_complain($page,$tempMatch);
			//$modal_data['bapi_sold_to'] = $this->__complain_model->sap_tbm_sold_to();
			//$modal_data['bapi_distribution'] = $this->__complain_model->sap_tbm_distribution_channel();	

		$menuConfig = array('page_id'=>1);

		
		$data['modal'] = $this->load->view('__complain/page/list_modal',$modal_data,true);//return view as data

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

		$info = '';
		//$data['top_project'] = $this->load->view('__quotation/include/top_project',$info,true);

		//Load body
		$data['body'] = $this->load->view('__complain/page/list_bodycfg',$list,true);

		//Load footage script
		$data['footage_script'] = '';


		$this->load->view('__complain/layout/list',$data);
	}



	function detail_complain($act='',$contract_id=0,$id=0){


	switch ($act) { // to tbt_proto_item
		

		case 'insert_complain':
		 	//TODO ::  EDIT DATA QUOTATION
			 $this->complain_id  = $id;
			 $this->act = $act;
			 $this->contract_id = $contract_id;
			// $this->status  = $status;				
			// $this->track_doc_id  = $id;
			// $this->untrack  = $untrack;

			$menuConfig['page_title'] = 'API Manager';
			$menuConfig['page_id'] 	  = 'api_manager';


			//#############  Query #########################################################################
			//Assign parameter for modal
			$this->load->model('__complain_model','complain');	

			//== qeury ==
			$list['bapi_ship_to'] = $this->complain->sap_tbm_ship_to();	
			$list['master_pb_type'] = $this->complain->master_pb_type();
			$list['master_pb_list'] = $this->complain->master_pb_list();
			$list['master_type_complain'] = $this->complain->master_type_complain();			
	

			//####################################################################################################				

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


			$info = '';
			$data['top_project'] = $this->load->view('__complain/include/top_project',$info,true);

			//Load body
			$data['body'] = $this->load->view('__complain/page/insert_bodycfg',$list,true);

			$data['modal'] = $this->load->view('__complain/page/detail_modal',$list,true);//return view as data
			// //Load footage script
			// $data['footage_script'] ='';//$this->load->view('__cms/script/api/api_manager_js','',true);				

			$this->load->view('__complain/layout/detail',$data);

		break;


		case 'edit_complain':
		 	//TODO ::  EDIT DATA QUOTATION
			 $this->complain_id  = $id;
			 $this->act = $act;
			 $this->contract_id = $contract_id;
			// $this->status  = $status;				
			// $this->track_doc_id  = $id;
			// $this->untrack  = $untrack;

			$menuConfig['page_title'] = 'API Manager';
			$menuConfig['page_id'] 	  = 'api_manager';


			//#############  Query #########################################################################
			//Assign parameter for modal
			$this->load->model('__complain_model','complain');	

			//== qeury ==
			$list['bapi_ship_to'] = $this->complain->sap_tbm_ship_to();
			$list['query_complain'] = $this->complain->query_complain($id);
			$list['master_pb_type'] = $this->complain->master_pb_type();
			$list['master_pb_list'] = $this->complain->master_pb_list();
			$list['master_type_complain'] = $this->complain->master_type_complain();
			$list['query_images'] = $this->complain->get_images_complain($this->complain_id);	 	 
	

			//####################################################################################################				

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


			$info = '';
			$data['top_project'] = $this->load->view('__complain/include/top_project',$info,true);

			//Load body
			$data['body'] = $this->load->view('__complain/page/edit_bodycfg',$list,true);

			$data['modal'] = $this->load->view('__complain/page/detail_modal',$list,true);//return view as data
			// //Load footage script
			// $data['footage_script'] ='';//$this->load->view('__cms/script/api/api_manager_js','',true);				

			$this->load->view('__complain/layout/detail',$data);

		break;


		case 'view_complain':
		 	//TODO ::  EDIT DATA QUOTATION
			 $this->complain_id  = $id;
			 $this->act = $act;
			 $this->contract_id = $contract_id;
			// $this->status  = $status;				
			// $this->track_doc_id  = $id;
			// $this->untrack  = $untrack;

			$menuConfig['page_title'] = 'API Manager';
			$menuConfig['page_id'] 	  = 'api_manager';


			//#############  Query #########################################################################
			//Assign parameter for modal
			$this->load->model('__complain_model','complain');	

			//== qeury ==
			$list['bapi_ship_to'] = $this->complain->sap_tbm_ship_to();
			$list['query_complain'] = $this->complain->query_complain($id);
			$list['master_pb_type'] = $this->complain->master_pb_type();
			$list['master_pb_list'] = $this->complain->master_pb_list();
			$list['master_type_complain'] = $this->complain->master_type_complain();
			$list['query_images'] = $this->complain->get_images_complain($this->complain_id);	 	 	 
	

			//####################################################################################################				

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


			$info = '';
			$data['top_project'] = $this->load->view('__complain/include/top_project',$info,true);

			//Load body
			$data['body'] = $this->load->view('__complain/page/edit_bodycfg',$list,true);

			$data['modal'] = $this->load->view('__complain/page/detail_modal',$list,true);//return view as data
			// //Load footage script
			// $data['footage_script'] ='';//$this->load->view('__cms/script/api/api_manager_js','',true);				

			$this->load->view('__complain/layout/view',$data);

		break;


		default:			

		break;
		}
	}




//==================================================
///////////////////// insert : to db/////////////////
//===================================================

function insert_complain(){
$this->load->model('__complain_model','complain');
$p = $this->input->post();
if(!empty($p)){
	// if (!array_key_exists('material_no_'.$a, $p)) {
	// 	$p['material_no_'.$a] = '0';
	// }

	// echo "<br> input_method :".$p['input_method'];
	// echo "<br> create_date :".$p['create_date'];
	// echo "<br> raise_by_id :".$p['raise_by_id'];
	// echo "<br> contract_id :".$p['contract_id'];
	// echo "<br> ship_to_id :".$p['ship_to_id'];
	// echo "<br> customer :".$p['customer_id'];
	// echo "<br> problem_level :".$p['problem_level'];
	//echo "<br> list :".$p['problem_list_id'];
	//echo "<br> plant_name :".$p['plant_name'];
//exit();
	//=== save to database ===
	$result_insert = $this->complain->insert_complain($p);
	$result_insert_msg = $result_insert['msg'];
	$last_id =  $result_insert['last_id'];

}//end post



echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
// echo '<script type="text/javascript">  alert("เพิ่มข้อมูลเรียบร้อยแล้ว"); setTimeout(function(){window.location="'.site_url('__ps_complain/listview_complain').'"},1200);</script>';
// echo '<script> window.location="'.site_url('__ps_complain/listview_complain').'"; </script>';
echo '<script type="text/javascript">  alert("เพิ่มข้อมูลเรียบร้อยแล้ว"); setTimeout(function(){window.location="'.site_url('__ps_complain/detail_complain/edit_complain/'.$p['contract_id'].'/'.$last_id).'"},1200);</script>';
echo '<script> window.location="'.site_url('__ps_complain/detail_complain/edit_complain/'.$p['contract_id'].'/'.$last_id).'"; </script>';

}//end fuction

//==================================================
///////////////////// update : to db/////////////////
//===================================================

function update_complain($id){
$this->load->model('__complain_model','complain');
$p = $this->input->post();
if(!empty($p)){

	// if (!array_key_exists('material_no_'.$a, $p)) {
	// 	$p['material_no_'.$a] = '0';
	// }
	// echo "<br> input_method :".$p['input_method'];
	// echo "<br> create_date :".$p['create_date'];
	// echo "<br> raise_by_id :".$p['raise_by_id'];
	// echo "<br> contract_id :".$p['contract_id'];
	// echo "<br> ship_to_id :".$p['ship_to_id'];
	// echo "<br> customer :".$p['customer_id'];
	// echo "<br> problem_level :".$p['problem_level'];

	//=== save to database ===
	$result = $this->complain->update_complain($id,$p);
	$result_update_msg = $result['msg'];

}//end post


echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
echo '<script type="text/javascript">  alert("แก้ไขข้อมูลเรียบร้อยแล้ว"); setTimeout(function(){window.location="'.site_url('__ps_complain/detail_complain/edit_complain/'.$p['contract_id'].'/'.$id).'"},1200);</script>';
echo '<script> window.location="'.site_url('__ps_complain/detail_complain/edit_complain/'.$p['contract_id'].'/'.$id).'"; </script>';


}//end fuction


/////////////////////  query ajax //////////////////

 public function get_problem_list_day($id){
        // $size = urldecode($size);
        $id = str_replace("----","/",$id);  
        
        $this->load->model('__complain_model');     
        $output = $this->__complain_model->get_problem_list_day_ajax($id);
		$output = $output['result'];

		echo json_encode($output);
    } 

  public function get_problem_list($id){
        // $size = urldecode($size);
        $id = str_replace("----","/",$id);  
        
        $this->load->model('__complain_model');     
        $output = $this->__complain_model->get_problem_list_ajax($id);
		$output = $output['result'];

		echo json_encode($output);
    } 


  public function get_ship_to_by_plant($id){
        // $size = urldecode($size);
        $id = str_replace("----","/",$id);  
        
        $this->load->model('__complain_model');     
        $output = $this->__complain_model->get_ship_to_by_plant_ajax($id);
		$output = $output['result'];

		echo json_encode($output);
    } 

  public function get_ship_to_by_id($id){
        // $size = urldecode($size);
        $id = str_replace("----","/",$id);  
        
        $this->load->model('__complain_model');     
        $output = $this->__complain_model->get_ship_to_Byid_ajax($id);
		$output = $output['result'];

		echo json_encode($output);
    } 

 public function get_sap_tbm_contact($id){
    // $size = urldecode($size);
    $id = str_replace("----","/",$id);  
    
    $this->load->model('__complain_model');     
    $output = $this->__complain_model->get_sap_tbm_contact_ajax($id);
	$output = $output['result'];

	echo json_encode($output);
} 

 public function get_customer_detail($id){
        // $size = urldecode($size);
        $id = str_replace("----","/",$id);  
        
        $this->load->model('__complain_model');     
        $output = $this->__complain_model->get_customer_detail_ajax($id);
		$output = $output['result'];

		echo json_encode($output);
    }
//////////////////////////////////////////////////////////////////////
//======================== DELETE  ==================================
////////////////////////////////////////////////////////////////////
 public function delete_complain($id){

 $this->load->model('__complain_model','complain');
 $result = $this->complain->delete_complain($id); 

echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
echo '<script type="text/javascript"> setTimeout(function(){window.location="'.site_url('__ps_complain/listview_complain').'"},1200);</script>';
echo '<script> window.location="'.site_url('__ps_complain/listview_complain').'"; </script>';

 }


//////////////////////////////////////////////////////////////////////
//=================== SUBMIT TO PAPYRUS ============================
////////////////////////////////////////////////////////////////////

 //////////////// update complain /////////////////////
public function submit_to_papyrus($id,$input_method,$place,$detail,$problem,$problem_type_id,$problem_list_id
								  ,$problem_level,$completedate
								){
echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";


$this->load->model('__complain_model','complain');
$id = urldecode($id);
$input_method = urldecode($input_method);
$place = urldecode($place);
$detail = urldecode($detail);
$problem = urldecode($problem);
$problem_type_id = urldecode($problem_type_id);
$problem_list_id = urldecode($problem_list_id);
$problem_level = urldecode($problem_level);
$completedate = urldecode($completedate);

// echo "<br>input_method:".$input_method;
// echo "<br>place:".$place;
// echo "<br>detail:".$detail;
// echo "<br>problem:".$problem;
// echo "<br>problem_type_id:".$problem_type_id;
// echo "<br>problem_list_id:".$problem_list_id;
// echo "<br>problem_level:".$problem_level;
// echo "<br>completedate:".$completedate;
// echo "<br>";
// exit();
       
$result = $this->complain->update_submit_to_ppr($id,$input_method,$place,$detail,$problem,$problem_type_id,$problem_list_id,$problem_level,$completedate); 
//echo $result = '<br>msg :'.$result['msg'];
//exit();


//////////////// submit to papayrus /////////////////////

$query_complain = $this->complain->query_complain($id); 
foreach($query_complain->result_array() as $value){ 


$originalDate = $value['create_date'];
$newDate = $originalDate ;
//$newDate = date("Y-m-d", strtotime($originalDate));



$how 			= $this->_padZero($value['input_method'], 2);//'0'.$value['input_method'];
$addDate 		= $newDate;
$officer 		= '['.$value['raise_by_id'].'] '.$value['user_firstname'].' '.$value['user_lastname'];
$customerId 	= $value['ship_to_id'];
$place 			= $value['place'];
$detail 		= $value['detail'];

$type 			= $value['problem_type_id'];
$detailType 	= $value['problem_list_id'];


$customerName = $value['contact_first_name'];
$position = $value['contact_function_des'];
$part = $value['contact_department_des'];


// $responsibleA 	= '[68] ฝ่ายปฏิบัติการเขต 1';
// $responsibleB 	= '[68] ฝ่ายปฏิบัติการเขต 1';
// $responsibleC 	= '[68] ฝ่ายปฏิบัติการเขต 1';
// $responsibleA 	= '';
// $responsibleB 	= '';
// $responsibleC 	= '';

$completeDate 	= $value['completedate'];

// set : importance
if($value['problem_level']=='moderate'){
	$importance   	= 1;
}else if($value['problem_level']=='instant'){
	$importance   	= 2;
}else if($value['problem_level']=='urgently'){
	$importance   	= 3;
}else{
	$importance   	= 4;
}


//=== problem substr =======
$complainText = $value['problem'];
// $remark_untrack = $value['problem'];
// $count_remark_untrack = strlen($remark_untrack);

// if($count_remark_untrack>60){
// 	if($count_remark_untrack>120){	         	 	
// 		$complainLine1 = substr($remark_untrack,0,60);
// 		$complainLine2 = substr($remark_untrack,60,60);
// 		$complainLine3 = substr($remark_untrack,120,$count_remark_untrack);
// 	}else{
// 		$complainLine1 = substr($remark_untrack,0,60);
// 		$complainLine2 = substr($remark_untrack,60,$count_remark_untrack);
// 		$complainLine3 = "";
// 	}
// }else{
// 	$complainLine1 = $remark_untrack;
// 	$complainLine2 = "";
// 	$complainLine3 = "";
// }


// echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
// echo '<br>how : '.$how;
// echo '<br>addDate : '.$addDate;
// echo '<br>officer : '.$officer;
// echo '<br>customerId : '.$customerId;
// echo '<br>place : '.$place;
// echo '<br>detail : '.$detail;

// echo '<br>complainLine1 : '.$complainLine1;
// echo '<br>complainLine2 : '.$complainLine2;
// echo '<br>complainLine3 : '.$complainLine3;

// echo '<br>type : '.$type;
// echo '<br>detailType : '.$detailType;

// // echo '<br>responsibleA : '.$responsibleA;
// // echo '<br>responsibleB : '.$responsibleB;
// // echo '<br>responsibleC : '.$responsibleC;

// echo '<br>completeDate : '.$completeDate;
// echo '<br>importance : '.$importance;

//exit();
}//end foreach

//======================================
/////////////  array photo /////////////
//=====================================
$temp_path = site_url();
$employee_id = $this->session->userdata('id');
$query_complainIma = $this->complain->get_images_complain($id); 
$image_array = array();
$temp_ima = $query_complainIma->result_array(); 
 if(!empty($temp_ima)){
 foreach($query_complainIma->result_array() as $data){  

	if(in_array($temp_path.$data['path'], $image_array, TRUE)){                
        //echo "have";
    }else{
        //echo "nohave";
        array_push($image_array,$temp_path.$data['path']);
    } 

 }
}
// echo "tst imag :<br>";
// print_r($image_array);

//// ==== GET :: user id ==========
$this->db->select('tbt_user.user_id');
$this->db->where('employee_id',$employee_id);
$query_userid = $this->db->get('tbt_user');
$queryUserid = $query_userid->row_array();
$user_ID = $queryUserid['user_id'];
//echo "user id ::".$user_ID;


//exit();

//=== submit data to parpyrus ======
$this->load->library("nusoap_lib");
$this->webservice_url = $this->papyrus['getOperAreaUrl'];

$this->nusoap_client = new nusoap_client($this->webservice_url,true);
$this->nusoap_client->soap_defencoding = 'UTF-8';
$this->nusoap_client->decode_utf8 = false;

$params = array(
    'how' 			=> $how,
    'addDate' 		=> $addDate,
    'officer' 		=> $officer,
    'customerId' 	=> $customerId,
    'customerName' 	=> $customerName,
    'position' 		=> $position,
    'part' 			=> $part,
    'place' 			=> $place,
    'detail' 		=> $detail,
    // 'complainLine1'	=> $complainLine1,
    // 'complainLine2' 	=> $complainLine2,
    // 'complainLine3' 	=> $complainLine3,
    'complainText' 	=> $complainText,
    'type'		 	=> $type,
    'detailType' 	=> $detailType,
    // 'responsibleA' 	=> $responsibleA,
    // 'responsibleB' 	=> $responsibleB,
    // 'responsibleC' 	=> $responsibleC,
   	'completeDate' 	=> $completeDate,
   	'importance' 	=> $importance,   
   	//MewMew Comment: user id (NOT employee_id) ที่จะให้เป็นชื่อผู้ออกเอกสาร
   	'initUserId'	=> $user_ID,
   	//MewMew Comment: Add Image URL HERE
	'links' => array(
		'string' => $image_array

		// array(
		// 	'image_url1', 
		// 	'image_url2', 
		// 	'image_url3'
		// )
	)
);

if($this->nusoap_client->fault){
     $err_msg = 'Error: '.$this->nusoap_client->fault;
}
else
{
    if ($this->nusoap_client->getError())
    {
         $err_msg = 'Error: '.$this->nusoap_client->getError();
    }
    else
    {
        $soap_result = $this->nusoap_client->call(
	        $this->papyrus['initComplain'],
	        $params
    	);    

      
    
    	

    }//end else
}//end else $this->nusoap_client



if($soap_result['InitComplainFormResult'] != 'OK' ){
	echo "<pre>";
	print_r($soap_result); 
	echo "</pre>";

	echo "<pre>";
	print_r($params); 
	echo "</pre>";
	die();

}else{

//echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
echo '<script type="text/javascript"> alert("ส่งคำร้องเรียบร้อยแล้ว");  setTimeout(function(){window.location="'.site_url('__ps_complain/listview_complain').'"},1200);</script>';
echo '<script> window.location="'.site_url('__ps_complain/listview_complain').'"; </script>';

}



}









public function upload_photo(){

	//echo "function upload quotation <br>";

	$post = $this->input->post();
	$this->load->model('__complain_model');

	if(!empty($post)){

		$complain_id =  $post['object_id'];
		$contract_id = $post['temp_contract_id'];
		$file_name = $post['title'];
		$file_type = 'image'; 
		
		$path ='';
		$description='';
		$upload_path ='assets/upload/complain';
		$description = $_FILES['image']['name'];

		// echo "<br>".$complain_id;
		// echo "<br>".$file_name;
		// echo "<br>".$file_type;
		// echo "<br>".$contract_id;
		//exit();

		//==== start : upload file ==========
	    $config['upload_path'] = $upload_path;
	    $config['allowed_types'] = 'gif|jpg|png';
	    $config['max_size']    = '10000000';
	    // $config['max_width']  = '1024';
	    // $config['max_height']  = '768';   
	    $rand = rand(1111,9999);
	    $date= date("Y-m-d");
	    $config['file_name']  = $date.$rand;

	    $this->load->library('upload', $config);        
	    if ( ! $this->upload->do_upload('image')){
	        $msg_error = $this->upload->display_errors();
	        $error = 'ผิดพลาด: ไม่สามารถอัพโหลดไฟล์ได้ <br>';
	        //$fname='';
	        echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
	        echo '<script type="text/javascript">  alert("'.$error.'"); setTimeout(function(){window.location="'.site_url('__ps_complain/detail_complain/edit_complain/'.$contract_id.'/'.$complain_id).'"},1200);</script>';
		   	echo '<script> window.location="'.site_url('__ps_complain/detail_complain/edit_complain/'.$contract_id.'/'.$complain_id).'"; </script>';

	    }else{
	        $data_upload= $this->upload->data();
	        //echo  '<br>'.$fname=$data_upload['file_name'];	    	
	    	$path = $upload_path.'/'.$data_upload['file_name'];

	        $result = $this->__complain_model->upload_photo($file_name,$file_type,$complain_id,$path);
	        // echo  $result['msg']; 	
	       
	        echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";	     
			echo '<script type="text/javascript">  alert("'.$result['msg'].'"); setTimeout(function(){window.location="'.site_url('__ps_complain/detail_complain/edit_complain/'.$contract_id.'/'.$complain_id).'"},1200);</script>';
		   	echo '<script> window.location="'.site_url('__ps_complain/detail_complain/edit_complain/'.$contract_id.'/'.$complain_id).'"; </script>';        
	    
	    }  

	


	}// end if post
	
}



function delete_file($id,$contract_id,$complain_id){
	//echo "delete";
	//exit();
	$this->load->model('__complain_model');

	//echo 'other'.$id.''.$doc_id.''.$doc_type;
	$id = urldecode($id);
	$contract_id = urldecode($contract_id);
	$complain_id = urldecode($complain_id);
	
   	$condition = array(   
            'id' => $id,                                 
    );

	$path = $this->db->get_where('tbt_attach_file',$condition);
    $path = $path->result_array();
    //echo $path[0]['path'];

  
	if($this->db->delete('tbt_attach_file',$condition)){
       unlink($path[0]['path']);

       //echo "succses";
        echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
		echo '<script type="text/javascript">  alert("ลบไฟล์เรียบร้อยแล้ว"); setTimeout(function(){window.location="'.site_url('__ps_complain/detail_complain/edit_complain/'.$contract_id.'/'.$complain_id).'"},1200);</script>';
	  	echo '<script> window.location="'.site_url('__ps_complain/detail_complain/edit_complain/'.$contract_id.'/'.$complain_id).'"; </script>';        
	    
    }else{

    	//echo "fail";
    	echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
		echo '<script type="text/javascript">  alert("ผิดพลาด: ไม่สามารถลบไฟล์ได้"); setTimeout(function(){window.location="'.site_url('__ps_complain/detail_complain/edit_complain/'.$contract_id.'/'.$complain_id).'"},1200);</script>';
	    echo '<script> window.location="'.site_url('__ps_complain/detail_complain/edit_complain/'.$contract_id.'/'.$complain_id).'"; </script>';        
	    
	}

}




}//end ps_complain
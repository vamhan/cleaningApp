<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class __cms_data_manager extends Admin_Controller {

	function __construct(){
		parent::__construct();
		$this->permission_check('cms');

	}//end constructor;

	public function index () { 

		redirect( site_url('__cms_data_manager/model_management') ,'refresh');
	}

	public function read_doc() {
		$this->load->view('__cms/layout/docxtemplater');
	}

	public function getEmployeeInfo () {

		ini_get('max_execution_time');
		ini_set('memory_limit', '5000M');
		set_time_limit (0);

		$this->load->library("nusoap_lib");
		$this->webservice_url = 'http://192.191.0.31/hrservices/HRServices.asmx?WSDL';
		error_reporting(0);

        // $this->db->limit(1000);
		$query = $this->db->get('hr_employee');
		$list = $query->result_array();

		$count = 0;
		if (!empty($list)) {
			foreach ($list as $key => $value) {

                // echo $value['employee_id']."<br>";
				$params = array(
					'EmployeeId' => $value['employee_id']
					);

				$this->nusoap_client = new nusoap_client($this->webservice_url,true);
				$this->nusoap_client->soap_defencoding = 'UTF-8';
				$this->nusoap_client->decode_utf8 = false;

				$soap_result = array();

				if($this->nusoap_client->fault)
				{
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
							'getEmployeeListByID',
							$params
							);

						if (!empty($soap_result['getEmployeeListByIDResult']['result'])) {
							$count++;
						}
					}   
				}   
			}
		}

		$msg = "Import Successfully : count ".$count;
		$state = true;
		$code = '000';
		$output = array();
		$result = self::response($state,$code,$msg,$output);

		echo json_encode($result);

	}

	public function map_shipto () {

		$param = $this->input->get('url');

		if (!empty($param)) {

			$curlSession = curl_init();
			curl_setopt($curlSession, CURLOPT_URL, $param);
			curl_setopt($curlSession, CURLOPT_BINARYTRANSFER, true);
			curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, true);

			$objFopen = curl_exec($curlSession);

			if (strpos($objFopen, '404 Page Not Found') == "") {
                // $this->db->truncate('hr_employee');
				$lines = explode("\n", $objFopen);
				foreach ($lines as $line) {
					if (!empty($line)) {

						$fields = explode(',', $line);

						if (sizeof($fields) == 2) {

							$old = trim($fields[1]);
							$new = trim($fields[0]);

							$this->__ps_project_query->updateObj('hr_employee', array('ship_to' => $old), array('ship_to' => $new));
						}
					}
				}
			}
		}
	}

	public function import_hr () {
		$param = $this->config->item('SAP_Emp_path');
		$data_row = 0;
		$completed_row = 0;
		$read_row = 0;
		$msg='';
		$validate_index='';

		if (!empty($param)) {

			$field_mapping = array(
				'row_type',
				'employee_id',
				'level',
				'firstname',
				'lastname',
				'gender',
				'date_of_birth',
				'image_path',
				'employment_date',
				'ship_to',
				'update_ship_to',
				'course',
				'remark',
				'supervisor_id',
				'mode'
				);

			$date_format = array('date_of_birth', 'employment_date', 'update_ship_to');
			$datetime_format = array('update_ship_to');
			$avoid = array('mode', 'row_type');

			$objFopen = file_get_contents($param);

			if (strpos($objFopen, '404 Page Not Found') == "") {

				$data_list = array();
				// $this->db->truncate('hr_employee');
				$encoding = 'UTF-8';				
				$lines = explode("\n", $objFopen);
				$line_index = 0;
				foreach ($lines as $line) {
					$line_index++;
					if (!empty($line)) {
						//$line = iconv('TIS-620', 'UTF-8', $line );
						// if(mb_detect_encoding($line) == 'ASCII'){
						// 	$line = iconv('TIS-620', 'UTF-8', $line );
						// 	//mb_convert_encoding($line, 'TIS-620', 'UTF-8');
						// }else{
						// 	//mb_convert_encoding($line, 'UTF-16LE', 'UTF-8');
						// }
						if(mb_detect_encoding($line) == 'ASCII'){
							$encoding = 'TIS-620';
						}

						if($encoding != 'UTF-8'){
							$line = iconv($encoding, 'UTF-8', $line );
						}

						$fields = explode('|', $line);

						if($fields[0]=="1"){
							$data_row = $fields[1];
						}else{
							$read_row++;
							$data = array();
							$mode = "";
							foreach ($fields as $key => $value) {
								$key_val = $field_mapping[$key];

								if (!in_array($key_val, $avoid)) {
									if (in_array($key_val, $date_format)) {
										$datev = explode('/', $value);
										$day = $datev[0];
										$month = $datev[1];
										$year = $datev[2];

										$value = $year.'-'.$month.'-'.$day;
									} else if (in_array($key_val, $datetime_format)) {

										$day = substr($value, 0, 2);
										$month = substr($value, 3, 2);
										$year = substr($value, 6);

										$value = $year.'-'.$month.'-'.$day.' 00:00:00';
									}
									$data[$key_val] = $value;
								} else {
									if($key_val == 'mode'){
										$mode = $value;
									}
								}
							}

							if (!empty($data)) {
								switch (trim($mode)) {
									case 'A':
									case 'M':
									$exists = $this->db->get_where('hr_employee', array('employee_id' => $data['employee_id']))->num_rows();
									if($exists > 0){
										$this->__ps_project_query->updateObj('hr_employee', array('employee_id' => $data['employee_id']), $data);
									}else{
										$this->__ps_project_query->insertObj('hr_employee', $data);
									}
									$completed_row++;
									break;
									case 'D':
									$this->__ps_project_query->updateObj('hr_employee', array('employee_id' => $data['employee_id']), array('delete_flag' => '1'));
									$completed_row++;
									break;
									default:
									$validate_index .= ",".$line_index;
									break;
								}								
							}else{
								$validate_index .= ",".$line_index;
							}
						}

					}
				}

				$msg = "Successfully ";
				$msg.= "Total Rows : $data_row ";
				$msg.= "Read rows : $read_row Excecute Rows : $completed_row ";
				$state = true;
				$code = '000';
				$output = array();
				$result = self::response($state,$code,$msg,$output);

			} else {

				$msg = "Cannot read file";
				$state = false;
				$code = '999';
				$output = array();
				$result = self::response($state,$code,$msg,$output);
			}
		} else {

			$msg = "Empty url";
			$state = false;
			$code = '999';
			$output = array();
			$result = self::response($state,$code,$msg,$output);
		}

		// create log
		$filename = $this->config->item('import_hr_log');
		$file = fopen($filename,"a");
		$msg = date('Y-m-d h:i:s', time()).$msg."\n";
		if (!empty($validate_index)) {
			$msg .= "Validate Failed Rows (".substr($validate_index, 1).")"."\n";
		}
		fwrite($file, $msg);
		fclose($file);
		echo json_encode($result);
	}

	public function module_management ($page=1) {	    

		$menuConfig['page_id'] 	  = 'module';

		#CMS
		$this->pageSize = PAGESIZE;
		$this->table = 'cms_module';
		$this->page_id = 'module';
		$this->page_title = 'Module Management';
		$this->page_object = 'module';
		$this->page_controller = '__cms_data_manager';
		#END_CMS

		//Load top menu
		$data['top_menu']  = $this->load->view('__cms/include/top',$menuConfig,true);//return view as data

		//Load side menu
		$data['side_menu'] = $this->load->view('__cms/include/side',$menuConfig,true);//return view as data

		//Load body
		$data['module_list'] = $this->module_model->getModuleAll(false);
		$data['modal'] 		 = $this->load->view('__cms/data_manager/module_modal',$data,true);//return view as data

		$config = $this->loadCMSCfg('module');
		$list   = $this->module_model->listviewcfg($config,$page);
		$list['config'] = $config;

		$data['body'] = $this->load->view('__cms/data_manager/module_body',$list,true);

		//Load footage script 
		$data['footage_script'] = $this->load->view('__cms/script/data_manager/module_js',$data,true);;

		// $this->load->view('x__cms_permission/user',$data);
		$this->load->view('__cms/layout/list',$data);
	}

	public function gps_log_list () {

		$menuConfig['page_id'] 	  = 'gps_login';

		#CMS
		$this->pageSize = PAGESIZE;
		$this->table = 'tbl_login';
		$this->page_id = 'gps_login';
		$this->page_title = 'GPS Login';
		$this->page_object = 'gps_login';
		$this->page_controller = '__cms_data_manager';
		#END_CMS

		//Load top menu
		$data['top_menu']  = $this->load->view('__cms/include/top',$menuConfig,true);//return view as data

		//Load side menu
		$data['side_menu'] = $this->load->view('__cms/include/side',$menuConfig,true);//return view as data

		//Load body
		$list['gps_list'] = $this->user->getGPSList($sort_time);
		$data['body'] = $this->load->view('__cms/data_manager/gps_body',$list,true);

		//Load footage script 
		$data['footage_script'] = $this->load->view('__cms/script/data_manager/gps_js',null,true);

		$this->load->view('__cms/layout/list',$data);

	}

	public function holiday_management () {

		$menuConfig['page_id'] 	  = 'holiday';

		#CMS
		$this->pageSize = PAGESIZE;
		$this->table = 'cms_holiday';
		$this->page_id = 'holiday';
		$this->page_title = 'Holiday Management';
		$this->page_object = 'holiday';
		$this->page_controller = '__cms_data_manager';
		#END_CMS

		//Load top menu
		$data['top_menu']  = $this->load->view('__cms/include/top',$menuConfig,true);//return view as data

		//Load side menu
		$data['side_menu'] = $this->load->view('__cms/include/side',$menuConfig,true);//return view as data

		//Load body
		//$data['module_list'] = $this->module_model->getModuleAll(false);

		// $config = $this->loadCMSCfg('module');
		// $list   = $this->module_model->listviewcfg($config,$page);
		// $list['config'] = $config;
		$list['year_list'] = $this->holiday->getHolidayYear();

		$data['modal'] 		 = $this->load->view('__cms/data_manager/holiday_modal',$list,true);//return view as data
		$data['body'] = $this->load->view('__cms/data_manager/holiday_body',$list,true);

		//Load footage script 
		$data['footage_script'] = $this->load->view('__cms/script/data_manager/holiday_js',null,true);

		// $this->load->view('x__cms_permission/user',$data);
		$this->load->view('__cms/layout/list',$data);
	}


	public function quatationStaff_management ($search='') {

		$this->load->model('__ps_project_query');
		$menuConfig['page_id'] 	  = 'quotation_staff';

		#CMS
		$this->pageSize = PAGESIZE;
		$this->table = 'tbt_quotation';
		$this->page_id = 'quotation_staff';
		$this->page_title = 'Quotation Staff Management';
		$this->page_object = 'quotation_staff';
		$this->page_controller = '__cms_data_manager';
		#END_CMS

		$match = $this->input->post('search');


		//Load top menu
		$data['top_menu']  = $this->load->view('__cms/include/top',$menuConfig,true);//return view as data

		//Load side menu
		$data['side_menu'] = $this->load->view('__cms/include/side',$menuConfig,true);//return view as data

		//Load body
		if(!empty($match)){
			$list['quotation'] = $this->__ps_project_query->getObj('tbt_quotation',array('id' => $match),true);
		}else{
			$list['quotation'] = $this->__ps_project_query->getObj('tbt_quotation',array('delete_flag' => 0),true);
		}

		$list['user'] = $this->__ps_project_query->get_user_cr();//$this->__ps_project_query->getObj('tbt_user','',true);

		$data['modal'] 		 = $this->load->view('__cms/data_manager/quotation_staff_modal',$list,true);//return view as data
		$data['body'] = $this->load->view('__cms/data_manager/quotation_staff_body',$list,true);

		//Load footage script 
		$data['footage_script'] = $this->load->view('__cms/script/data_manager/quotation_statff_js',null,true);

		// $this->load->view('x__cms_permission/user',$data);
		$this->load->view('__cms/layout/list',$data);
	}

	public function contract_project_management ($search='') {

		$this->load->model('__ps_project_query');
		$menuConfig['page_id'] 	  = 'project_management';

		#CMS
		$this->pageSize = PAGESIZE;
		$this->table = 'tbt_quotation';
		$this->page_id = 'project_management';
		$this->page_title = 'Project Management';
		$this->page_object = 'project_management';
		$this->page_controller = '__cms_data_manager';
		#END_CMS

		$match = $this->input->post('search');


		//Load top menu
		$data['top_menu']  = $this->load->view('__cms/include/top',$menuConfig,true);//return view as data

		//Load side menu
		$data['side_menu'] = $this->load->view('__cms/include/side',$menuConfig,true);//return view as data

		//Load body
		if(!empty($match)){
			$list['quotation'] = $this->__ps_project_query->getObj('tbt_quotation',array('id' => $match),true);
		}else{
			$list['quotation'] = $this->__ps_project_query->get_project_oper();
		}


		$data['modal'] 		 = $this->load->view('__cms/data_manager/project_management_modal',$list,true);//return view as data
		$data['body'] = $this->load->view('__cms/data_manager/project_management_body',$list,true);

		//Load footage script 
		$data['footage_script'] = $this->load->view('__cms/script/data_manager/project_js',null,true);

		// $this->load->view('x__cms_permission/user',$data);
		$this->load->view('__cms/layout/list',$data);
	}


public function update_staff_quotation(){
	$this->load->model('__ps_project_query');
	$p = $this->input->post();
	
	if(!empty($p)){
		// echo "<pre>";
		// print_r($p);
		$result = $this->__ps_project_query->updateObj('tbt_quotation', array('id' => $p['quotation_id']), array('project_owner_id' => $p['project_owner_id']));

		if(!$result){
			echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
			echo '<script type="text/javascript">  alert("แก้ไขเรียบร้อยแล้ว"); setTimeout(function(){window.location="'.site_url('__cms_data_manager/quatationStaff_management').'"},1200);</script>';
			echo '<script> window.location="'.site_url('__cms_data_manager/quatationStaff_management').'"; </script>';
		}else{
			echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
			echo '<script type="text/javascript">  alert("ผิดพลาด : ไม่สามารถแก้ไขได้"); setTimeout(function(){window.location="'.site_url('__cms_data_manager/quatationStaff_management').'"},1200);</script>';
			echo '<script> window.location="'.site_url('__cms_data_manager/quatationStaff_management').'"; </script>';
	
		}
	}
}


public function update_project_management(){
	$this->load->model('__ps_project_query');
	$p = $this->input->post();	
	if(!empty($p)){
			// echo "<pre>";
			// print_r($p);

		$abort_date = $p['abort_date'];
		$abort_date  = explode('.', $abort_date);
		$abort_date = $abort_date[2].'-'.$abort_date[1].'-'.$abort_date[0];
		//echo $abort_date;		
		
		$result = $this->__ps_project_query->updateObj('tbt_quotation', array('id' => $p['quotation_id']), array('is_abort_date' => $abort_date));

		if(!$result){
			echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
			echo '<script type="text/javascript">  alert("แก้ไขเรียบร้อยแล้ว"); setTimeout(function(){window.location="'.site_url('__cms_data_manager/contract_project_management').'"},1200);</script>';
			echo '<script> window.location="'.site_url('__cms_data_manager/contract_project_management').'"; </script>';
		}else{
			echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
			echo '<script type="text/javascript">  alert("ผิดพลาด : ไม่สามารถแก้ไขได้"); setTimeout(function(){window.location="'.site_url('__cms_data_manager/contract_project_management').'"},1200);</script>';
			echo '<script> window.location="'.site_url('__cms_data_manager/contract_project_management').'"; </script>';

		}
	}
}




	public function doc_otherservice_management ($act='view',$doc_id='',$path='') {
		$this->load->model('__quotation_model','quotation');
		$this->load->model('__cms_docother','docother');	

		$menuConfig['page_id'] 	  = 'other_service';

		#CMS
		$this->pageSize = PAGESIZE;
		$this->table = 'cms_other_service';
		$this->page_id = 'other_service';
		$this->page_title = 'Other Service Management';
		$this->page_object = 'other_service';
		$this->page_controller = '__cms_data_manager';
		#END_CMS

	switch ($act) { // to tbt_proto_item

		case 'view':
			//Load top menu
			$data['top_menu']  = $this->load->view('__cms/include/top',$menuConfig,true);//return view as data

			//Load side menu
			$data['side_menu'] = $this->load->view('__cms/include/side',$menuConfig,true);//return view as data

			//Load body
			//$data['module_list'] = $this->module_model->getModuleAll(false);

			// $config = $this->loadCMSCfg('module');
			// $list   = $this->module_model->listviewcfg($config,$page);
			// $list['config'] = $config;
			$list['year_list'] = $this->holiday->getHolidayYear();
			$list['doc_list'] = $this->docother->getAlldoc();
			$list['bapi_industry'] = $this->quotation->sap_tbm_industry();

			$data['modal'] 		 = $this->load->view('__cms/data_manager/other_service_modal',$list,true);//return view as data
			$data['body'] = $this->load->view('__cms/data_manager/other_sevice_body',$list,true);

			//Load footage script 
			$data['footage_script'] = $this->load->view('__cms/script/data_manager/other_sevice_js',null,true);;

			// $this->load->view('x__cms_permission/user',$data);
			$this->load->view('__cms/layout/list',$data);
			break;

			case 'upload_file':
			//echo "upload_file";
			echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
			//"function upload  <br>";
			$post = $this->input->post();
			if(!empty($post)){
				if(empty($_FILES['image']['name'])){
					echo '<script type="text/javascript">  alert("ไม่ได้ใส่ข้อมูลไฟล์ที่จะอัพโหลด"); setTimeout(function(){window.location="'.site_url('__cms_data_manager/doc_otherservice_management').'"},1200);</script>';
					echo '<script> window.location="'.site_url('__cms_data_manager/doc_otherservice_management').'"; </script>';        
				}

					//$is_importance = $post['is_importance'];
					//$quotation_id =  $post['quotation_id'];
				$industry =  $post['industry'];
				$path ='';
				$upload_path ='';
				$description='';
				$upload_path = 'assets/upload/cms_doc_other';					
				$description = $_FILES['image']['name'];

					//==== start : upload file ==========
				$config['upload_path'] = $upload_path;
				$config['allowed_types'] = 'xls|xlsx|pdf|doc|docx|gif|jpg|png';
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
					echo '<script type="text/javascript">  alert("'.$error.$msg_error.'"); setTimeout(function(){window.location="'.site_url('__cms_data_manager/doc_otherservice_management').'"},1200);</script>';
					echo '<script> window.location="'.site_url('__cms_data_manager/doc_otherservice_management').'"; </script>';  
				}else{
					$data_upload= $this->upload->data();
				        //echo  '<br>'.$fname=$data_upload['file_name'];	    	
					$path = $upload_path.'/'.$data_upload['file_name'];
					$result = $this->docother->upload_file($description,$industry,$path,$date);		     
				        //echo  $result['msg']; 	
					echo '<script type="text/javascript">  alert("'.$result['msg'].'"); setTimeout(function(){window.location="'.site_url('__cms_data_manager/doc_otherservice_management').'"},1200);</script>';
					echo '<script> window.location="'.site_url('__cms_data_manager/doc_otherservice_management').'"; </script>';        
				}  			

				}// end if post


				break;

				case 'delete_file':
		//echo "delete_file";
				echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";

		//get path
				$this->db->select('cms_document_other.*');
				$this->db->where('cms_document_other.id', $doc_id);
				$query = $this->db->get('cms_document_other');
				$query_path = $query->row_array();
				$path = $query_path['path'];   
        //echo  $path;

		//todo :: remove file in folder		
		$files = glob($path.'*'); // get all file names
	    foreach($files as $file){ // iterate files
	    	if(is_file($file))
	        unlink($file); // delete file
	        //echo $file.'file deleted';
	} 

		//todo :: deletefile in database
	$result = $this->docother->delete_file($doc_id);
	echo '<script type="text/javascript">  alert("'.$result['msg'].'"); setTimeout(function(){window.location="'.site_url('__cms_data_manager/doc_otherservice_management').'"},1200);</script>';
	echo '<script> window.location="'.site_url('__cms_data_manager/doc_otherservice_management').'"; </script>'; 

	break;		

	default:			

	break;

	}//end switch

}


public function action_plan_management () {


	$menuConfig['page_id'] 	  = 'actionplan';

		#CMS
	$this->pageSize = PAGESIZE;
	$this->table = 'cms_actionplan';
	$this->page_id = 'actionplan';
	$this->page_title = 'Action Plan';
	$this->page_object = 'actionplan';
	$this->page_controller = '__cms_data_manager';
		#END_CMS

		//Load top menu
		$data['top_menu']  = $this->load->view('__cms/include/top',$menuConfig,true);//return view as data

		//Load side menu
		$data['side_menu'] = $this->load->view('__cms/include/side',$menuConfig,true);//return view as data

		//Load body
		//$data['module_list'] = $this->module_model->getModuleAll(false);

		// $config = $this->loadCMSCfg('module');
		// $list   = $this->module_model->listviewcfg($config,$page);
		// $list['config'] = $config;
		$list['threshold'] = $this->__ps_project_query->getObj('cms_actionplan');

		$data['body'] = $this->load->view('__cms/data_manager/action_plan_body',$list,true);

		//Load footage script 
		$data['footage_script'] = $this->load->view('__cms/script/data_manager/actionplan_js',null,true);

		// $this->load->view('x__cms_permission/user',$data);
		$this->load->view('__cms/layout/list',$data);
	}

	public function update_threshold () {

		$p = $this->input->post();

		if (!empty($p)) {

			$this->db->truncate('cms_actionplan');

			// $obj = $this->__ps_project_query->getObj('cms_actionplan');

			$data = array(
				'is_auto' => (!empty($p['is_auto'])) ? 1 : 0,
				'threshold'	=> (!empty($p['threshold'])) ? $p['threshold'] : '',
				);
			$this->__ps_project_query->insertObj('cms_actionplan', $data);

		}

		redirect( site_url('__cms_data_manager/action_plan_management', 'refresh') );
	}

	public function quality_question_management ($tab='1') {
		$menuConfig['page_id'] 	  = 'quality_question';

		#CMS
		$this->pageSize = PAGESIZE;
		$this->table = 'sap_tbm_industry';
		$this->page_id = 'quality_question';
		$this->page_title = 'Quality Assurance Question Management';
		$this->page_object = 'quality_question';
		$this->page_controller = '__cms_data_manager';
		#END_CMS

		//Load top menu
		$data['top_menu']  = $this->load->view('__cms/include/top',$menuConfig,true);//return view as data

		//Load side menu
		$data['side_menu'] = $this->load->view('__cms/include/side',$menuConfig,true);//return view as data

		$list['tab'] = $tab;
		$list['industry_list'] = $this->__ps_project_query->getObj('sap_tbm_industry', null, true);

		$last_customer_revision = $this->__quality_assurance_model->getQuestionRevision('tbm_quality_survey_customer_question');
		$list['customer_question_list'] = $this->__ps_project_query->getObj('tbm_quality_survey_customer_question', array('subject_id' => 0, 'revision_id' => $last_customer_revision), true, null, 'id asc, sequence_index asc');
		if (!empty($list['customer_question_list'])) {
			foreach ($list['customer_question_list'] as $key => $question) {
				$list['customer_question_list'][$key]['sub_question'] = $this->__ps_project_query->getObj('tbm_quality_survey_customer_question', array('subject_id' => $question['id'], 'revision_id' => $last_customer_revision), true, null, 'id asc, sequence_index asc');

				if (!empty($list['customer_question_list'][$key]['sub_question'])) {
					foreach ($list['customer_question_list'][$key]['sub_question'] as $key2 => $sub_question) {
						$list['customer_question_list'][$key]['sub_question'][$key2]['sub_question'] = $this->__ps_project_query->getObj('tbm_quality_survey_customer_question', array('subject_id' => $sub_question['id'], 'revision_id' => $last_customer_revision), true, null, 'id asc, sequence_index asc');
					}
				}
			}
		}

		$last_document_revision = $this->__quality_assurance_model->getQuestionRevision('tbm_quality_survey_document_control_question');
		$list['document_question_list'] = $this->__ps_project_query->getObj('tbm_quality_survey_document_control_question', array('subject_id' => 0, 'revision_id' => $last_document_revision), true, null, 'id asc, sequence_index asc');		
		if (!empty($list['document_question_list'])) {
			foreach ($list['document_question_list'] as $key => $question) {
				$list['document_question_list'][$key]['sub_question'] = $this->__ps_project_query->getObj('tbm_quality_survey_document_control_question', array('subject_id' => $question['id'], 'revision_id' => $last_document_revision), true, null, 'id asc, sequence_index asc');

				if (!empty($list['document_question_list'][$key]['sub_question'])) {
					foreach ($list['document_question_list'][$key]['sub_question'] as $key2 => $sub_question) {
						$list['document_question_list'][$key]['sub_question'][$key2]['sub_question'] = $this->__ps_project_query->getObj('tbm_quality_survey_document_control_question', array('subject_id' => $sub_question['id'], 'revision_id' => $last_document_revision), true, null, 'id asc, sequence_index asc');
					}
				}
			}
		}

		$last_kpi_revision = $this->__quality_assurance_model->getQuestionRevision('tbm_quality_survey_kpi_question');
		$list['kpi_question_list'] = $this->__ps_project_query->getObj('tbm_quality_survey_kpi_question', array('subject_id' => 0, 'revision_id' => $last_kpi_revision), true, null, 'id asc, sequence_index asc');		
		if (!empty($list['kpi_question_list'])) {
			foreach ($list['kpi_question_list'] as $key => $question) {
				$list['kpi_question_list'][$key]['sub_question'] = $this->__ps_project_query->getObj('tbm_quality_survey_kpi_question', array('subject_id' => $question['id'], 'revision_id' => $last_kpi_revision), true, null, 'id asc, sequence_index asc');

				if (!empty($list['kpi_question_list'][$key]['sub_question'])) {
					foreach ($list['kpi_question_list'][$key]['sub_question'] as $key2 => $sub_question) {
						$list['kpi_question_list'][$key]['sub_question'][$key2]['sub_question'] = $this->__ps_project_query->getObj('tbm_quality_survey_kpi_question', array('subject_id' => $sub_question['id'], 'revision_id' => $last_kpi_revision), true, null, 'id asc, sequence_index asc');
					}
				}
			}
		}


		$last_policy_revision = $this->__quality_assurance_model->getQuestionRevision('tbm_quality_survey_policy_question');
		$list['policy_question_list'] = $this->__ps_project_query->getObj('tbm_quality_survey_policy_question', array('subject_id' => 0, 'revision_id' => $last_policy_revision), true, null, 'id asc, sequence_index asc');		
		if (!empty($list['policy_question_list'])) {
			foreach ($list['policy_question_list'] as $key => $question) {
				$list['policy_question_list'][$key]['sub_question'] = $this->__ps_project_query->getObj('tbm_quality_survey_policy_question', array('subject_id' => $question['id'], 'revision_id' => $last_policy_revision), true, null, 'id asc, sequence_index asc');

				if (!empty($list['policy_question_list'][$key]['sub_question'])) {
					foreach ($list['policy_question_list'][$key]['sub_question'] as $key2 => $sub_question) {
						$list['policy_question_list'][$key]['sub_question'][$key2]['sub_question'] = $this->__ps_project_query->getObj('tbm_quality_survey_policy_question', array('subject_id' => $sub_question['id'], 'revision_id' => $last_policy_revision), true, null, 'id asc, sequence_index asc');
					}
				}
			}
		}

		$list['customer_score'] = $this->__ps_project_query->getObj('tbm_quality_survey_customer_score');

		$data['modal'] 		 = $this->load->view('__cms/data_manager/quality_question_modal',$list,true);//return view as data
		$data['body'] = $this->load->view('__cms/data_manager/quality_question_body',$list,true);

		//Load footage script 
		$data['footage_script'] = $this->load->view('__cms/script/data_manager/quality_question_js',null,true);;

		// $this->load->view('x__cms_permission/user',$data);
		$this->load->view('__cms/layout/list',$data);
	}

	public function quotation_summary_management ($tab=0) {

		$menuConfig['page_id'] 	  = 'quotation_summary';

		#CMS
		$this->pageSize = PAGESIZE;
		$this->table = 'tbm_summary';
		$this->page_id = 'quotation_summary';
		$this->page_title = 'Quotation Summary Management';
		$this->page_object = 'quotation_summary';
		$this->page_controller = '__cms_data_manager';
		#END_CMS

		$plant_list = $this->__ps_project_query->getObj('sap_tbm_plant', null, true);		


		//Load top menu
		$data['top_menu']  = $this->load->view('__cms/include/top',$menuConfig,true);//return view as data

		//Load side menu
		$data['side_menu'] = $this->load->view('__cms/include/side',$menuConfig,true);//return view as data

		$list['job_type_list'] = $this->__ps_project_query->getObj('tbm_job_type', null, true);		
		// $list['summary_data'] = array();
		
		$list['summary_data_list'] = array();
		$plant_not_list = array(''=>'');
		if (!empty($plant_list)) {
			foreach ($plant_list as $plant_key => $plant) {
				$summary_by_plant  = $this->__ps_project_query->getObj('tbm_summary', array('plant_code'=> $plant['plant_code']));
				if(!empty($summary_by_plant)){
					if (!empty($list['job_type_list'])) {
						foreach ($list['job_type_list'] as $key => $job_type) {
							if (empty($tab) && $key == 0) {
								$tab = $job_type['id'];
							}

							$summary = $this->__ps_project_query->getObj('tbm_summary', array('doc_type' => $job_type['id'], 'plant_code'=> $plant['plant_code']));
							if (!empty($summary)) {
								$list['summary_data_list'][$plant['plant_code']][$job_type['id']] = $summary;
							}
						}
					}
				}else{
					$plant_not_list[$plant['plant_code']] = $plant['plant_name'];
				}
			}
		}

		$list['plant_list'] = $plant_list;
		$list['plant_not_list'] = $plant_not_list;
		// echo "<pre>"; print_r($list['summary_data_list']); echo "</pre>"; die();

		// if (!empty($list['job_type_list'])) {
		// 	foreach ($list['job_type_list'] as $key => $job_type) {
		// 		if (empty($tab) && $key == 0) {
		// 			$tab = $job_type['id'];
		// 		}
		// 		$list['summary_data'][$job_type['id']] = "";

		// 		$summary = $this->__ps_project_query->getObj('tbm_summary', array('doc_type' => $job_type['id']));
		// 		if (!empty($summary)) {
		// 			$list['summary_data'][$job_type['id']] = $summary;
		// 		}
		// 	}
		// }

		// first tab  
		$list['tab'] = $tab;	

		$data['body'] = $this->load->view('__cms/data_manager/quotation_summary_body',$list,true);
		$data['footage_script'] = $this->load->view('__cms/script/data_manager/summary_js',null,true);

		$this->load->view('__cms/layout/list',$data);
	}

	public function employee_question_management ($tab=1) {

		$menuConfig['page_id'] 	  = 'employee_question';

		#CMS
		$this->pageSize = PAGESIZE;
		$this->table = 'tbm_employee_track_question';
		$this->page_id = 'employee_question';
		$this->page_title = 'Employee Question Management';
		$this->page_object = 'employee_question';
		$this->page_controller = '__cms_data_manager';
		#END_CMS

		//Load top menu
		$data['top_menu']  = $this->load->view('__cms/include/top',$menuConfig,true);//return view as data

		//Load side menu
		$data['side_menu'] = $this->load->view('__cms/include/side',$menuConfig,true);//return view as data

		$list['tab'] = $tab;	

		$general_revision = $this->__quality_assurance_model->getQuestionRevision('tbm_employee_track_question');
		
		$last_revision_obj = $this->__ps_project_query->getObj('tbm_employee_track_satisfaction_question', array('is_for_head' => 1), false, "", "revision_id desc");
		if (!empty($last_revision_obj)) {
			$satisfaction_head_revision = $last_revision_obj['revision_id'];
		} else {
			$satisfaction_head_revision = 1;
		}

		$last_revision_obj = $this->__ps_project_query->getObj('tbm_employee_track_satisfaction_question', array('is_for_head' => 0), false, "", "revision_id desc");
		if (!empty($last_revision_obj)) {
			$satisfaction_emp_revision = $last_revision_obj['revision_id'];
		} else {
			$satisfaction_emp_revision = 1;
		}

		$list['general_list'] = $this->__ps_project_query->getObj('tbm_employee_track_question', array('revision_id' => $general_revision), true, null, "sequence_index");	
		$list['satisfaction_head_list'] = $this->__ps_project_query->getObj('tbm_employee_track_satisfaction_question', array('revision_id' => $satisfaction_head_revision, 'is_for_head' => 1), true, null, "sequence_index");
		$list['satisfaction_emp_list'] = $this->__ps_project_query->getObj('tbm_employee_track_satisfaction_question', array('revision_id' => $satisfaction_emp_revision, 'is_for_head' => 0), true, null, "sequence_index");

		$data['modal'] = $this->load->view('__cms/data_manager/employee_question_modal',$list,true);
		$data['body'] = $this->load->view('__cms/data_manager/employee_question_body',$list,true);
		$data['footage_script'] = $this->load->view('__cms/script/data_manager/employee_question_js',null,true);

		$this->load->view('__cms/layout/list',$data);
	}

	public function quality_industry_question ($id=0) {
		$menuConfig['page_id'] 	  = 'quality_question';

		$industry = $this->__ps_project_query->getObj('sap_tbm_industry', array('id' => $id));
		#CMS
		$this->pageSize = PAGESIZE;
		$this->table = 'sap_tbm_industry_room';
		$this->page_id = 'quality_question';
		$this->page_title = $industry['title'];
		$this->page_object = 'quality_question';
		$this->page_controller = '__cms_data_manager';
		#END_CMS

		//Load top menu
		$data['top_menu']  = $this->load->view('__cms/include/top',$menuConfig,true);//return view as data

		//Load side menu
		$data['side_menu'] = $this->load->view('__cms/include/side',$menuConfig,true);//return view as data

		$list['industry_room_list'] = $this->__ps_project_query->getObj('sap_tbm_industry_room', array('industry_id' => $id), true);

		// $data['modal'] 		 = $this->load->view('__cms/data_manager/holiday_modal',$list,true);//return view as data
		$data['body'] = $this->load->view('__cms/data_manager/quality_industry_question_body',$list,true);

		//Load footage script 
		// $data['footage_script'] = $this->load->view('__cms/script/data_manager/holiday_js',null,true);;

		// $this->load->view('x__cms_permission/user',$data);
		$this->load->view('__cms/layout/list',$data);
	}

	public function quality_industry_room_question ($industry_id, $industry_room_id) {
		$menuConfig['page_id'] 	  = 'quality_question';

		$industry = $this->__ps_project_query->getObj('sap_tbm_industry', array('id' => $industry_id));
		$industry_room = $this->__ps_project_query->getObj('sap_tbm_industry_room', array('id' => $industry_room_id, 'industry_id' => $industry_id));

		#CMS
		$this->pageSize = PAGESIZE;
		$this->table = 'tbm_quality_survey_area_question';
		$this->page_id = 'quality_question';
		$this->page_title = $industry['title'].'&nbsp;&nbsp;>&nbsp;&nbsp;'.$industry_room['title'];
		$this->page_object = 'quality_question';
		$this->page_controller = '__cms_data_manager';
		$this->back_url = site_url('__cms_data_manager/quality_industry_question/'.$industry_id);
		#END_CMS

		//Load top menu
		$data['top_menu']  = $this->load->view('__cms/include/top',$menuConfig,true);//return view as data

		//Load side menu
		$data['side_menu'] = $this->load->view('__cms/include/side',$menuConfig,true);//return view as data

		$last_revision = $this->__quality_assurance_model->getQuestionRevision('tbm_quality_survey_area_question', $industry_room_id);		
		$list['industry_room_question_list'] = $this->__ps_project_query->getObj('tbm_quality_survey_area_question', array('industry_room_id' => $industry_room_id, 'revision_id' => $last_revision), true, null, 'sequence_index');

		$data['modal'] 		 = $this->load->view('__cms/data_manager/quality_industry_room_question_modal',array('industry_id' => $industry_id, 'id' => $industry_room_id),true);//return view as data
		$data['body'] = $this->load->view('__cms/data_manager/quality_industry_room_question_body',$list,true);

		$data['footage_script'] = $this->load->view('__cms/script/data_manager/quality_question_js',null,true);;

		// $this->load->view('x__cms_permission/user',$data);
		$this->load->view('__cms/layout/list',$data);
	}

	public function insert_summary_data(){
		$p = $this->input->post();
		if (!empty($p['plant_code'])) {
			$job_type_list = $this->__ps_project_query->getObj('tbm_job_type',null,true);
			foreach ($job_type_list as $key => $job_type) {				
				$this->__ps_project_query->insertObj('tbm_summary', array('plant_code' => $p['plant_code'], 'doc_type'=> $job_type['id']));
			}			
		}
		redirect( site_url('__cms_data_manager/quotation_summary_management/'.$p['doc_type']) ,'refresh');
	}

	public function delete_summary_data($plant_code=''){
		if (!empty($plant_code)) {
			$this->__ps_project_query->deleteObj('tbm_summary', array('plant_code' => $plant_code));
		}
		redirect( site_url('__cms_data_manager/quotation_summary_management') ,'refresh');
	}



	public function update_summary_data (){

		$p = $this->input->post();

		if (!empty($p['doc_type'])) {
			$summary = $this->__ps_project_query->getObj('tbm_summary', array('doc_type' => $p['doc_type'], 'plant_code'=> $p['plant_code']));
			if (!empty($summary)) {
				$this->__ps_project_query->updateObj('tbm_summary', array('doc_type' => $p['doc_type'], 'plant_code'=> $p['plant_code']), $p);
			} else {
				$this->__ps_project_query->insertObj('tbm_summary', $p);
			}
		}

		redirect( site_url('__cms_data_manager/quotation_summary_management/'.$p['doc_type']) ,'refresh');
	}

	public function create_employee_question () {

		$p = $this->input->post();

		// echo "<pre>";
		// print_r($p);
		// echo "</pre>";

		if (!empty($p['title'])) {	

			$last_revision = $this->__quality_assurance_model->getQuestionRevision('tbm_employee_track_question');
			$is_used = $this->__ps_project_query->getObj('tbt_employee_track_document', array('question_revision' => $last_revision));
			$is_exist = $this->__ps_project_query->getObj('tbm_employee_track_question', array('revision_id' => $last_revision));

			$answer_set = array(
				'positive' 	=> 	array(
					'label' => $p['positive_label']
					),
				'negative' 	=>	array(
					'label' => $p['negative_label'],
					'remark' => (!empty($p['negative_remark'])) ? 'yes' : 'no'
					)
				);

			if (empty($is_used) || empty($is_exist)) {

				$last_obj = $this->__ps_project_query->getObj('tbm_employee_track_question', null, false, "", "id desc");
				if (empty($last_obj)) {
					$last_id = 1;
				}else {
					$last_id = intval($last_obj['id'])+1;
				}

				$data = array(
					'id'				=> $last_id,
					'title' 			=> $p['title'],
					'sequence_index' 	=> (!empty($p['sequence_index'])) ? $p['sequence_index'] : 0,
					'answer_set'		=> json_encode($answer_set),
					'revision_id'	 	=> $last_revision,
					);

				$question_id = $this->__ps_project_query->insertObj('tbm_employee_track_question', $data);

				$title 	= $p['title'];
				$title1 = substr($title, 0, 512);
				$title2 = substr($title, 512);
				$sequence_index = (!empty($p['sequence_index'])) ? $p['sequence_index'] : 0;

				$sap_question = array(
					'QUESTION_ID' 			=> $this->_padZero($question_id, 10),
					'QUESTION_SEQUENCE' 	=> $this->_padZero($sequence_index, 4),
					'REVISION' 				=> $this->_padZero($last_revision, 4),
					'QUESTION_TEXT' 		=> iconv("UTF-8", "TIS-620",$title1),
					'QUESTION_TEXT2' 		=> iconv("UTF-8", "TIS-620",$title2),
					'POSITIVE_ANS_LABEL' 	=> iconv("UTF-8", "TIS-620",$answer_set['positive']['label']),
					'NEGATIVE_ANS_LABEL' 	=> iconv("UTF-8", "TIS-620",$answer_set['negative']['label']),
					'NEGATIVE_ANS_REMARK' 	=> ($answer_set['negative']['remark'] == 'yes') ? 1 : 0
					);	

				$input 	=	array(	
					array("IMPORT","I_MODE","M"),
					array("IMPORT","I_TABLE", "ZTBT_EMP_TR_Q"),
					array("IMPORT","I_DATE", date('Ymd')),
					array("IMPORT","I_COMMIT", "X"),
					array("TABLE","IT_TBT_EMP_TR_Q", array($sap_question))
					);		

				$result = $this->callSAPFunction("ZRFC_MASS_TABLE", $input);			               

			} else {

				$all_question = $this->__ps_project_query->getObj('tbm_employee_track_question', array('revision_id' => $last_revision), true); 
				$sap_question_list = array();

				foreach ($all_question as $key => $question) {

					$last_obj = $this->__ps_project_query->getObj('tbm_employee_track_question', null, false, "", "id desc");
					if (empty($last_obj)) {
						$last_id = 1;
					}else {
						$last_id = intval($last_obj['id'])+1;
					}

					$question_data = array(
						'id'			=> $last_id,
						'title' 		   => $question['title'],
						'answer_set' 	   => $question['answer_set'],
						'sequence_index'   => $question['sequence_index'],
						'revision_id'	   => intval($last_revision)+1
						);

					$this->__ps_project_query->insertObj('tbm_employee_track_question', $question_data);

					$title 	= $question['title'];
					$title1 = substr($title, 0, 512);
					$title2 = substr($title, 512);
					$sequence_index = (!empty($question['sequence_index'])) ? $question['sequence_index'] : 0;
					$q_answer_set   = json_decode($question['answer_set']);

					$sap_question = array(
						'QUESTION_ID' 			=> $this->_padZero($last_id, 10),
						'QUESTION_SEQUENCE' 	=> $this->_padZero($sequence_index, 4),
						'REVISION' 				=> $this->_padZero((intval($last_revision)+1), 4),
						'QUESTION_TEXT' 		=> iconv("UTF-8", "TIS-620",$title1),
						'QUESTION_TEXT2' 		=> iconv("UTF-8", "TIS-620",$title2),
						'POSITIVE_ANS_LABEL' 	=> iconv("UTF-8", "TIS-620",$q_answer_set->positive->label),
						'NEGATIVE_ANS_LABEL' 	=> iconv("UTF-8", "TIS-620",$q_answer_set->negative->label),
						'NEGATIVE_ANS_REMARK' 	=> ($q_answer_set->negative->remark == 'yes') ? 1 : 0
						);	

					array_push($sap_question_list, $sap_question);
				}	

				$last_obj = $this->__ps_project_query->getObj('tbm_employee_track_question', null, false, "", "id desc");
				if (empty($last_obj)) {
					$last_id = 1;
				}else {
					$last_id = intval($last_obj['id'])+1;
				}

				$data = array(
					'id'				=> $last_id,
					'title' 			=> $p['title'],
					'sequence_index' 	=> (!empty($p['sequence_index'])) ? $p['sequence_index'] : 0,
					'answer_set'		=> json_encode($answer_set),
					'revision_id'	 	=> ($last_revision)+1,
					);
				
				$question_id = $this->__ps_project_query->insertObj('tbm_employee_track_question', $data);

				$title 	= $p['title'];
				$title1 = substr($title, 0, 512);
				$title2 = substr($title, 512);
				$sequence_index = (!empty($p['sequence_index'])) ? $p['sequence_index'] : 0;

				$sap_question = array(
					'QUESTION_ID' 			=> $this->_padZero($question_id, 10),
					'QUESTION_SEQUENCE' 	=> $this->_padZero($sequence_index, 4),
					'REVISION' 				=> $this->_padZero((intval($last_revision)+1), 4),
					'QUESTION_TEXT' 		=> iconv("UTF-8", "TIS-620",$title1),
					'QUESTION_TEXT2' 		=> iconv("UTF-8", "TIS-620",$title2),
					'POSITIVE_ANS_LABEL' 	=> iconv("UTF-8", "TIS-620",$answer_set['positive']['label']),
					'NEGATIVE_ANS_LABEL' 	=> iconv("UTF-8", "TIS-620",$answer_set['negative']['label']),
					'NEGATIVE_ANS_REMARK' 	=> ($answer_set['negative']['remark'] == 'yes') ? 1 : 0
					);	

				array_push($sap_question_list, $sap_question);

				$input 	=	array(	
					array("IMPORT","I_MODE","M"),
					array("IMPORT","I_TABLE", "ZTBT_EMP_TR_Q"),
					array("IMPORT","I_DATE", date('Ymd')),
					array("IMPORT","I_COMMIT", "X"),
					array("TABLE","IT_TBT_EMP_TR_Q", $sap_question_list)
					);		

				$result = $this->callSAPFunction("ZRFC_MASS_TABLE", $input);	

			}
		}

		redirect( site_url('__cms_data_manager/employee_question_management'), 'refresh' );
	}


	public function create_satisfaction_employee_question () {

		$p = $this->input->post();

		if (!empty($p['title'])) {	

			$last_revision_obj = $this->__ps_project_query->getObj('tbm_employee_track_satisfaction_question', array('is_for_head' => $p['is_for_head']), false, "", "revision_id desc");
			if (!empty($last_revision_obj)) {
				$last_revision = $last_revision_obj['revision_id'];
			} else {
				$last_revision = 1;
			}
			$is_used = $this->__ps_project_query->getObj('tbt_employee_track_document', array('satisfaction_question_revision' => $last_revision));
			$is_exist = $this->__ps_project_query->getObj('tbm_employee_track_satisfaction_question', array('is_for_head' => $p['is_for_head'], 'revision_id' => $last_revision));

			if (empty($is_used) || empty($is_exist)) {

				$last_obj = $this->__ps_project_query->getObj('tbm_employee_track_satisfaction_question', null, false, "", "id desc");
				if (empty($last_obj)) {
					$last_id = 1;
				}else {
					$last_id = intval($last_obj['id'])+1;
				}

				$data = array(
					'id'				=> $last_id,
					'title' 			=> $p['title'],
					'sequence_index' 	=> (!empty($p['sequence_index'])) ? $p['sequence_index'] : 0,
					'revision_id'	 	=> $last_revision,
					'is_for_head'		=> $p['is_for_head']
					);

				$question_id = $this->__ps_project_query->insertObj('tbm_employee_track_satisfaction_question', $data);
				$sequence_index = (!empty($p['sequence_index'])) ? $p['sequence_index'] : 0;

				$sap_question = array(
					'QUESTION_SEQUENCE' 	=> $this->_padZero($sequence_index, 4),
					'QUESTION_ID' 			=> $this->_padZero($question_id, 10),
					'REVISION' 				=> $this->_padZero($last_revision, 4),
					'QUESTION_TEXT' 		=> iconv("UTF-8", "TIS-620",$p['title']),
					'ANS_POS1' 				=> "1",
					'ANS_POS2' 				=> "2",
					'ANS_POS3' 				=> "3",
					'ANS_POS4' 				=> "4",
					'ANS_POS5' 				=> "5",
					'IS_FOR_HEAD' 			=> $p['is_for_head']
					);						

				$input 	=	array(	
					array("IMPORT","I_MODE","M"),
					array("IMPORT","I_TABLE", "ZTBT_EMP_TR_S_QS"),
					array("IMPORT","I_DATE", date('Ymd')),
					array("IMPORT","I_COMMIT", "X"),
					array("TABLE","IT_TBT_EMP_TR_S_QS", array($sap_question))
					);		

				$result = $this->callSAPFunction("ZRFC_MASS_TABLE", $input);			               

			} else {

				$all_question = $this->__ps_project_query->getObj('tbm_employee_track_satisfaction_question', array('revision_id' => $last_revision, 'is_for_head' => $p['is_for_head']), true); 
				$sap_question_list = array();

				foreach ($all_question as $key => $question) {

					$last_obj = $this->__ps_project_query->getObj('tbm_employee_track_satisfaction_question', null, false, "", "id desc");
					if (empty($last_obj)) {
						$last_id = 1;
					}else {
						$last_id = intval($last_obj['id'])+1;
					}

					$question_data = array(
						'id'			   => $last_id,
						'title' 		   => $question['title'],
						'answer_set' 	   => $question['answer_set'],
						'sequence_index'   => $question['sequence_index'],
						'revision_id'	   => intval($last_revision)+1,
						'is_for_head'	   => $question['is_for_head']
						);

					$question_id = $this->__ps_project_query->insertObj('tbm_employee_track_satisfaction_question', $question_data);
					$sequence_index = (!empty($question['sequence_index'])) ? $question['sequence_index'] : 0;

					$sap_question = array(
						'QUESTION_SEQUENCE' 	=> $this->_padZero($sequence_index, 4),
						'QUESTION_ID' 			=> $this->_padZero($question_id, 10),
						'REVISION' 				=> $this->_padZero((intval($last_revision)+1), 4),
						'QUESTION_TEXT' 		=> iconv("UTF-8", "TIS-620",$question['title']),
						'ANS_POS1' 				=> "1",
						'ANS_POS2' 				=> "2",
						'ANS_POS3' 				=> "3",
						'ANS_POS4' 				=> "4",
						'ANS_POS5' 				=> "5",
						'IS_FOR_HEAD' 			=> $question['is_for_head']
						);	

					array_push($sap_question_list, $sap_question);
				}	

				$last_obj = $this->__ps_project_query->getObj('tbm_employee_track_satisfaction_question', null, false, "", "id desc");
				if (empty($last_obj)) {
					$last_id = 1;
				}else {
					$last_id = intval($last_obj['id'])+1;
				}

				$data = array(
					'id'				=> $last_id,
					'title' 			=> $p['title'],
					'sequence_index' 	=> (!empty($p['sequence_index'])) ? $p['sequence_index'] : 0,
					'revision_id'	 	=> ($last_revision)+1,
					'is_for_head'	   => $question['is_for_head']
					);
				
				$question_id = $this->__ps_project_query->insertObj('tbm_employee_track_satisfaction_question', $data);
				$sequence_index = (!empty($p['sequence_index'])) ? $p['sequence_index'] : 0;

				$sap_question = array(
					'QUESTION_SEQUENCE' 	=> $this->_padZero($sequence_index, 4),
					'QUESTION_ID' 			=> $this->_padZero($question_id, 10),
					'REVISION' 				=> $this->_padZero((intval($last_revision)+1), 4),
					'QUESTION_TEXT' 		=> iconv("UTF-8", "TIS-620",$p['title']),
					'ANS_POS1' 				=> "1",
					'ANS_POS2' 				=> "2",
					'ANS_POS3' 				=> "3",
					'ANS_POS4' 				=> "4",
					'ANS_POS5' 				=> "5",
					'IS_FOR_HEAD' 			=> $p['is_for_head']
					);

				array_push($sap_question_list, $sap_question);

				$input 	=	array(	
					array("IMPORT","I_MODE","M"),
					array("IMPORT","I_TABLE", "ZTBT_EMP_TR_S_QS"),
					array("IMPORT","I_DATE", date('Ymd')),
					array("IMPORT","I_COMMIT", "X"),
					array("TABLE","IT_TBT_EMP_TR_S_QS", $sap_question_list)
					);		

				$result = $this->callSAPFunction("ZRFC_MASS_TABLE", $input);	

			}
		}

		$tab = ($p['is_for_head'] == 1) ? 2 : 3;
		redirect( site_url('__cms_data_manager/employee_question_management/'.$tab), 'refresh' );
	}

	public function edit_employee_question () {

		$p = $this->input->post();

		// echo "<pre>";
		// print_r($p);
		// echo "</pre>";

		if (!empty($p['id'])) {	

			$last_revision = $this->__quality_assurance_model->getQuestionRevision('tbm_employee_track_question');
			$is_used = $this->__ps_project_query->getObj('tbt_employee_track_document', array('question_revision' => $last_revision));

			$answer_set = array(
				'positive' 	=> 	array(
					'label' => $p['positive_label']
					),
				'negative' 	=>	array(
					'label' => $p['negative_label'],
					'remark' => (!empty($p['negative_remark'])) ? 'yes' : 'no'
					)
				);

			if (empty($is_used)) {
				$data = array(
					'title' 			=> $p['title'],
					'sequence_index' 	=> (!empty($p['sequence_index'])) ? $p['sequence_index'] : 0,
					'answer_set'		=> json_encode($answer_set),
					'revision_id'	 	=> $last_revision,
					);
				$this->__ps_project_query->updateObj('tbm_employee_track_question', array('id' => $p['id']), $data);

				$title 	= $p['title'];
				$title1 = substr($title, 0, 512);
				$title2 = substr($title, 512);
				$sequence_index = (!empty($p['sequence_index'])) ? $p['sequence_index'] : 0;

				$sap_question = array(
					'QUESTION_ID' 			=> $this->_padZero($p['id'], 10),
					'QUESTION_SEQUENCE' 	=> $this->_padZero($sequence_index, 4),
					'REVISION' 				=> $this->_padZero($last_revision, 4),
					'QUESTION_TEXT' 		=> iconv("UTF-8", "TIS-620",$title1),
					'QUESTION_TEXT2' 		=> iconv("UTF-8", "TIS-620",$title2),
					'POSITIVE_ANS_LABEL' 	=> iconv("UTF-8", "TIS-620",$answer_set['positive']['label']),
					'NEGATIVE_ANS_LABEL' 	=> iconv("UTF-8", "TIS-620",$answer_set['negative']['label']),
					'NEGATIVE_ANS_REMARK' 	=> ($answer_set['negative']['remark'] == 'yes') ? 1 : 0
					);	

				$input 	=	array(	
					array("IMPORT","I_MODE","M"),
					array("IMPORT","I_TABLE", "ZTBT_EMP_TR_Q"),
					array("IMPORT","I_DATE", date('Ymd')),
					array("IMPORT","I_COMMIT", "X"),
					array("TABLE","IT_TBT_EMP_TR_Q", array($sap_question))
					);		

				$result = $this->callSAPFunction("ZRFC_MASS_TABLE", $input);	

			} else {

				$all_question = $this->__ps_project_query->getObj('tbm_employee_track_question', array('revision_id' => $last_revision), true); 
				$sap_question_list = array();

				foreach ($all_question as $key => $question) {

					$last_obj = $this->__ps_project_query->getObj('tbm_employee_track_question', null, false, "", "id desc");
					if (empty($last_obj)) {
						$last_id = 1;
					}else {
						$last_id = intval($last_obj['id'])+1;
					}

					$question_data = array(
						'id'			   => $last_id,
						'title' 		   => $question['title'],
						'answer_set' 	   => $question['answer_set'],
						'sequence_index'   => $question['sequence_index'],
						'revision_id'	   => intval($last_revision)+1
						);

					$this->__ps_project_query->insertObj('tbm_employee_track_question', $question_data);

					$title 	= $question['title'];
					$title1 = substr($title, 0, 512);
					$title2 = substr($title, 512);
					$sequence_index = (!empty($question['sequence_index'])) ? $question['sequence_index'] : 0;
					$q_answer_set   = json_decode($question['answer_set']);

					$sap_question = array(
						'QUESTION_ID' 			=> $this->_padZero($last_id, 10),
						'QUESTION_SEQUENCE' 	=> $this->_padZero($sequence_index, 4),
						'REVISION' 				=> $this->_padZero((intval($last_revision)+1), 4),
						'QUESTION_TEXT' 		=> iconv("UTF-8", "TIS-620",$title1),
						'QUESTION_TEXT2' 		=> iconv("UTF-8", "TIS-620",$title2),
						'POSITIVE_ANS_LABEL' 	=> iconv("UTF-8", "TIS-620",$q_answer_set->positive->label),
						'NEGATIVE_ANS_LABEL' 	=> iconv("UTF-8", "TIS-620",$q_answer_set->negative->label),
						'NEGATIVE_ANS_REMARK' 	=> ($q_answer_set->negative->remark == 'yes') ? 1 : 0
						);	

					array_push($sap_question_list, $sap_question);

					if ($p['id'] == $question['id']) {
						$p['id'] = $last_id;
					}
				}

				$data = array(
					'title' 			=> $p['title'],
					'sequence_index' 	=> (!empty($p['sequence_index'])) ? $p['sequence_index'] : 0,
					'answer_set'		=> json_encode($answer_set),
					'revision_id'	 	=> $last_revision,
					);
				$this->__ps_project_query->updateObj('tbm_employee_track_question', array('id' => $p['id']), $data);

				$title 	= $p['title'];
				$title1 = substr($title, 0, 512);
				$title2 = substr($title, 512);
				$sequence_index = (!empty($p['sequence_index'])) ? $p['sequence_index'] : 0;

				$sap_question = array(
					'QUESTION_ID' 			=> $this->_padZero($p['id'], 10),
					'QUESTION_SEQUENCE' 	=> $this->_padZero($sequence_index, 4),
					'REVISION' 				=> $this->_padZero($last_revision, 4),
					'QUESTION_TEXT' 		=> iconv("UTF-8", "TIS-620",$title1),
					'QUESTION_TEXT2' 		=> iconv("UTF-8", "TIS-620",$title2),
					'POSITIVE_ANS_LABEL' 	=> iconv("UTF-8", "TIS-620",$answer_set['positive']['label']),
					'NEGATIVE_ANS_LABEL' 	=> iconv("UTF-8", "TIS-620",$answer_set['negative']['label']),
					'NEGATIVE_ANS_REMARK' 	=> ($answer_set['negative']['remark'] == 'yes') ? 1 : 0
					);	

				array_push($sap_question_list, $sap_question);

				$input 	=	array(	
					array("IMPORT","I_MODE","M"),
					array("IMPORT","I_TABLE", "ZTBT_EMP_TR_Q"),
					array("IMPORT","I_DATE", date('Ymd')),
					array("IMPORT","I_COMMIT", "X"),
					array("TABLE","IT_TBT_EMP_TR_Q", $sap_question_list)
					);		

				$result = $this->callSAPFunction("ZRFC_MASS_TABLE", $input);
			}
		}

		redirect( site_url('__cms_data_manager/employee_question_management'), 'refresh' );
	}

	public function edit_satisfaction_employee_question () {

		$p = $this->input->post();

		if (!empty($p['id'])) {	

			$last_revision_obj = $this->__ps_project_query->getObj('tbm_employee_track_satisfaction_question', array('is_for_head' => $p['is_for_head']), false, "", "revision_id desc");
			if (!empty($last_revision_obj)) {
				$last_revision = $last_revision_obj['revision_id'];
			} else {
				$last_revision = 1;
			}
			$is_used = $this->__ps_project_query->getObj('tbt_employee_track_document', array('satisfaction_question_revision' => $last_revision));

			if (empty($is_used)) {

				$data = array(
					'title' 			=> $p['title'],
					'sequence_index' 	=> (!empty($p['sequence_index'])) ? $p['sequence_index'] : 0,
					'revision_id'	 	=> $last_revision,
					'is_for_head'		=> $p['is_for_head']
					);

				$this->__ps_project_query->updateObj('tbm_employee_track_satisfaction_question', array('id' => $p['id']), $data);
				$sequence_index = (!empty($p['sequence_index'])) ? $p['sequence_index'] : 0;

				$sap_question = array(
					'QUESTION_SEQUENCE' 	=> $this->_padZero($sequence_index, 4),
					'QUESTION_ID' 			=> $this->_padZero($p['id'], 10),
					'REVISION' 				=> $this->_padZero($last_revision, 4),
					'QUESTION_TEXT' 		=> iconv("UTF-8", "TIS-620",$p['title']),
					'ANS_POS1' 				=> "1",
					'ANS_POS2' 				=> "2",
					'ANS_POS3' 				=> "3",
					'ANS_POS4' 				=> "4",
					'ANS_POS5' 				=> "5",
					'IS_FOR_HEAD' 			=> $p['is_for_head']
					);						

				$input 	=	array(	
					array("IMPORT","I_MODE","M"),
					array("IMPORT","I_TABLE", "ZTBT_EMP_TR_S_QS"),
					array("IMPORT","I_DATE", date('Ymd')),
					array("IMPORT","I_COMMIT", "X"),
					array("TABLE","IT_TBT_EMP_TR_S_QS", array($sap_question))
					);		

				$result = $this->callSAPFunction("ZRFC_MASS_TABLE", $input);			               

			} else {

				$all_question = $this->__ps_project_query->getObj('tbm_employee_track_satisfaction_question', array('revision_id' => $last_revision, 'is_for_head' => $p['is_for_head']), true); 
				$sap_question_list = array();

				foreach ($all_question as $key => $question) {

					$last_obj = $this->__ps_project_query->getObj('tbm_employee_track_satisfaction_question', null, false, "", "id desc");
					if (empty($last_obj)) {
						$last_id = 1;
					}else {
						$last_id = intval($last_obj['id'])+1;
					}

					$question_data = array(
						'id'			   => $last_id,
						'title' 		   => $question['title'],
						'answer_set' 	   => $question['answer_set'],
						'sequence_index'   => $question['sequence_index'],
						'revision_id'	   => intval($last_revision)+1,
						'is_for_head'	   => $question['is_for_head']
						);

					$this->__ps_project_query->insertObj('tbm_employee_track_satisfaction_question', $question_data);
					$sequence_index = (!empty($question['sequence_index'])) ? $question['sequence_index'] : 0;

					$sap_question = array(
						'QUESTION_SEQUENCE' 	=> $this->_padZero($sequence_index, 4),
						'QUESTION_ID' 			=> $this->_padZero($last_id, 10),
						'REVISION' 				=> $this->_padZero((intval($last_revision)+1), 4),
						'QUESTION_TEXT' 		=> iconv("UTF-8", "TIS-620",$question['title']),
						'ANS_POS1' 				=> "1",
						'ANS_POS2' 				=> "2",
						'ANS_POS3' 				=> "3",
						'ANS_POS4' 				=> "4",
						'ANS_POS5' 				=> "5",
						'IS_FOR_HEAD' 			=> $question['is_for_head']
						);	

					array_push($sap_question_list, $sap_question);

					if ($p['id'] == $question['id']) {
						$p['id'] = $last_id;
					}
				}	

				$data = array(
					'title' 			=> $p['title'],
					'sequence_index' 	=> (!empty($p['sequence_index'])) ? $p['sequence_index'] : 0,
					'revision_id'	 	=> ($last_revision)+1,
					'is_for_head'	    => $p['is_for_head']
					);
				
				$this->__ps_project_query->updateObj('tbm_employee_track_satisfaction_question', array('id' => $p['id']), $data);
				$sequence_index = (!empty($p['sequence_index'])) ? $p['sequence_index'] : 0;

				$sap_question = array(
					'QUESTION_SEQUENCE' 	=> $this->_padZero($sequence_index, 4),
					'QUESTION_ID' 			=> $this->_padZero($p['id'], 10),
					'REVISION' 				=> $this->_padZero((intval($last_revision)+1), 4),
					'QUESTION_TEXT' 		=> iconv("UTF-8", "TIS-620",$p['title']),
					'ANS_POS1' 				=> "1",
					'ANS_POS2' 				=> "2",
					'ANS_POS3' 				=> "3",
					'ANS_POS4' 				=> "4",
					'ANS_POS5' 				=> "5",
					'IS_FOR_HEAD' 			=> $p['is_for_head']
					);

				array_push($sap_question_list, $sap_question);

				$input 	=	array(	
					array("IMPORT","I_MODE","M"),
					array("IMPORT","I_TABLE", "ZTBT_EMP_TR_S_QS"),
					array("IMPORT","I_DATE", date('Ymd')),
					array("IMPORT","I_COMMIT", "X"),
					array("TABLE","IT_TBT_EMP_TR_S_QS", $sap_question_list)
					);		

				$result = $this->callSAPFunction("ZRFC_MASS_TABLE", $input);	

			}
		}

		$tab = ($p['is_for_head'] == 1) ? 2 : 3;
		redirect( site_url('__cms_data_manager/employee_question_management/'.$tab), 'refresh' );
	}

	public function delete_employee_question () {

		$p = $this->input->post();

		if (!empty($p['id'])) {	

			$last_revision = $this->__quality_assurance_model->getQuestionRevision('tbm_employee_track_question');
			$is_used = $this->__ps_project_query->getObj('tbt_employee_track_document', array('question_revision' => $last_revision));

			$answer_set = array(
				'positive' 	=> 	array(
					'label' => $p['positive_label']
					),
				'negative' 	=>	array(
					'label' => $p['negative_label'],
					'remark' => (!empty($p['negative_remark'])) ? 'yes' : 'no'
					)
				);

			if (empty($is_used)) {

				$this->__ps_project_query->deleteObj('tbm_employee_track_question', array('id' => $p['id']));

				$sap_question = array(
					'QUESTION_ID' 			=> $this->_padZero($p['id'], 10)
					);	

				$input 	=	array(	
					array("IMPORT","I_MODE","D"),
					array("IMPORT","I_TABLE", "ZTBT_EMP_TR_Q"),
					array("IMPORT","I_DATE", date('Ymd')),
					array("IMPORT","I_COMMIT", "X"),
					array("TABLE","IT_TBT_EMP_TR_Q", array($sap_question))
					);		

				$result = $this->callSAPFunction("ZRFC_MASS_TABLE", $input);

			} else {

				$all_question = $this->__ps_project_query->getObj('tbm_employee_track_question', array('revision_id' => $last_revision), true); 
				foreach ($all_question as $key => $question) {
					$question_data = array(
						'title' 		   => $question['title'],
						'answer_set' 	   => $question['answer_set'],
						'sequence_index'   => $question['sequence_index'],
						'revision_id'	   => intval($last_revision)+1
						);

					$insert_id = $this->__ps_project_query->insertObj('tbm_employee_track_question', $question_data);

					$title 	= $question['title'];
					$title1 = substr($title, 0, 512);
					$title2 = substr($title, 512);
					$sequence_index = (!empty($question['sequence_index'])) ? $question['sequence_index'] : 0;
					$q_answer_set   = json_decode($question['answer_set']);

					$sap_question = array(
						'QUESTION_ID' 			=> $this->_padZero($insert_id, 10),
						'QUESTION_SEQUENCE' 	=> $this->_padZero($sequence_index, 4),
						'REVISION' 				=> $this->_padZero((intval($last_revision)+1), 4),
						'QUESTION_TEXT' 		=> iconv("UTF-8", "TIS-620",$title1),
						'QUESTION_TEXT2' 		=> iconv("UTF-8", "TIS-620",$title2),
						'POSITIVE_ANS_LABEL' 	=> iconv("UTF-8", "TIS-620",$q_answer_set->positive->label),
						'NEGATIVE_ANS_LABEL' 	=> iconv("UTF-8", "TIS-620",$q_answer_set->negative->label),
						'NEGATIVE_ANS_REMARK' 	=> ($q_answer_set->negative->remark == 'yes') ? 1 : 0
						);	

					array_push($sap_question_list, $sap_question);

					if ($p['id'] == $question['id']) {
						$p['id'] = $insert_id;
					}
				}

				$input 	=	array(	
					array("IMPORT","I_MODE","M"),
					array("IMPORT","I_TABLE", "ZTBT_EMP_TR_Q"),
					array("IMPORT","I_DATE", date('Ymd')),
					array("IMPORT","I_COMMIT", "X"),
					array("TABLE","IT_TBT_EMP_TR_Q", $sap_question_list)
					);		

				$result = $this->callSAPFunction("ZRFC_MASS_TABLE", $input);
				
				$this->__ps_project_query->deleteObj('tbm_employee_track_question', array('id' => $p['id']));

				$sap_question = array(
					'QUESTION_ID' 			=> $this->_padZero($p['id'], 10)
					);	

				$input 	=	array(	
					array("IMPORT","I_MODE","D"),
					array("IMPORT","I_TABLE", "ZTBT_EMP_TR_Q"),
					array("IMPORT","I_DATE", date('Ymd')),
					array("IMPORT","I_COMMIT", "X"),
					array("TABLE","IT_TBT_EMP_TR_Q", array($sap_question))
					);		

				$result = $this->callSAPFunction("ZRFC_MASS_TABLE", $input);
			}
		}

		redirect( site_url('__cms_data_manager/employee_question_management'), 'refresh' );
	}


	public function delete_satisfaction_employee_question () {

		$p = $this->input->post();

		if (!empty($p['id'])) {	

			$last_revision_obj = $this->__ps_project_query->getObj('tbm_employee_track_satisfaction_question', array('is_for_head' => $p['is_for_head']), false, "", "revision_id desc");
			if (!empty($last_revision_obj)) {
				$last_revision = $last_revision_obj['revision_id'];
			} else {
				$last_revision = 1;
			}
			$is_used = $this->__ps_project_query->getObj('tbt_employee_track_document', array('satisfaction_question_revision' => $last_revision));

			if (empty($is_used)) {

				// $this->__ps_project_query->deleteObj('tbm_employee_track_satisfaction_question', array('id' => $p['id']));
				$sap_question = array(
					'QUESTION_ID' 			=> $this->_padZero($p['id'], 10)
					);						

				// echo "<pre>";
				// print_r($sap_question);
				// echo "</pre>";

				// die();

				$input 	=	array(	
					array("IMPORT","I_MODE","D"),
					array("IMPORT","I_TABLE", "ZTBT_EMP_TR_S_QS"),
					array("IMPORT","I_DATE", date('Ymd')),
					array("IMPORT","I_COMMIT", "X"),
					array("TABLE","IT_TBT_EMP_TR_S_QS", array($sap_question))
					);		

				$result = $this->callSAPFunction("ZRFC_MASS_TABLE", $input);			               

			} else {

				$all_question = $this->__ps_project_query->getObj('tbm_employee_track_satisfaction_question', array('revision_id' => $last_revision, 'is_for_head' => $p['is_for_head']), true); 
				$sap_question_list = array();

				foreach ($all_question as $key => $question) {

					$last_obj = $this->__ps_project_query->getObj('tbm_employee_track_satisfaction_question', null, false, "", "id desc");
					if (empty($last_obj)) {
						$last_id = 1;
					}else {
						$last_id = intval($last_obj['id'])+1;
					}

					$question_data = array(
						'id'			   => $last_id,
						'title' 		   => $question['title'],
						'answer_set' 	   => $question['answer_set'],
						'sequence_index'   => $question['sequence_index'],
						'revision_id'	   => intval($last_revision)+1,
						'is_for_head'	   => $question['is_for_head']
						);

					$this->__ps_project_query->insertObj('tbm_employee_track_satisfaction_question', $question_data);
					$sequence_index = (!empty($question['sequence_index'])) ? $question['sequence_index'] : 0;

					$sap_question = array(
						'QUESTION_SEQUENCE' 	=> $this->_padZero($sequence_index, 4),
						'QUESTION_ID' 			=> $this->_padZero($last_id, 10),
						'REVISION' 				=> $this->_padZero((intval($last_revision)+1), 4),
						'QUESTION_TEXT' 		=> iconv("UTF-8", "TIS-620",$question['title']),
						'ANS_POS1' 				=> "1",
						'ANS_POS2' 				=> "2",
						'ANS_POS3' 				=> "3",
						'ANS_POS4' 				=> "4",
						'ANS_POS5' 				=> "5",
						'IS_FOR_HEAD' 			=> $question['is_for_head']
						);	

					array_push($sap_question_list, $sap_question);

					if ($p['id'] == $question['id']) {
						$p['id'] = $last_id;
					}
				}	

				$input 	=	array(	
					array("IMPORT","I_MODE","M"),
					array("IMPORT","I_TABLE", "ZTBT_EMP_TR_S_QS"),
					array("IMPORT","I_DATE", date('Ymd')),
					array("IMPORT","I_COMMIT", "X"),
					array("TABLE","IT_TBT_EMP_TR_S_QS", $sap_question_list)
					);		

				$result = $this->callSAPFunction("ZRFC_MASS_TABLE", $input);

				$this->__ps_project_query->deleteObj('tbm_employee_track_satisfaction_question', array('id' => $p['id']));
				$sap_question = array(
					'QUESTION_ID' 			=> $this->_padZero($p['id'], 10)
					);

				$input 	=	array(	
					array("IMPORT","I_MODE","D"),
					array("IMPORT","I_TABLE", "ZTBT_EMP_TR_S_QS"),
					array("IMPORT","I_DATE", date('Ymd')),
					array("IMPORT","I_COMMIT", "X"),
					array("TABLE","IT_TBT_EMP_TR_S_QS", array( $sap_question ))
					);		

				$result = $this->callSAPFunction("ZRFC_MASS_TABLE", $input);	

			}
		}

		$tab = ($p['is_for_head'] == 1) ? 2 : 3;
		redirect( site_url('__cms_data_manager/employee_question_management/'.$tab), 'refresh' );
	}

	public function create_question (){

		$p = $this->input->post();

		// echo "<pre>";
		// print_r($p);
		// echo "</pre>";

		// die();

		if (!empty($p['table'])) {		

			$last_revision = $this->__quality_assurance_model->getQuestionRevision($p['table']);

			$sap_i_table    = "";
			$sap_table      = "";
			$revision_field = "";
			switch ($p['table']) {
				case 'tbm_quality_survey_customer_question':
				$sap_i_table    = "ZTBM_QTY_S_CUSQ";
				$sap_table 		= "IT_ZTBM_QTY_S_CUSQ";
				$revision_field = "customer_revision_id";
				break;
				case 'tbm_quality_survey_document_control_question':
				$sap_i_table    = "ZTBM_QTY_S_DOCQ";
				$sap_table 		= "IT_ZTBM_QTY_S_DOCQ";
				$revision_field = "document_control_revision_id";
				break;
				case 'tbm_quality_survey_kpi_question':
				$sap_i_table    = "ZTBM_QTY_S_KPIQ";
				$sap_table 		= "IT_ZTBM_QTY_S_KPIQ";
				$revision_field = "KPI_revision_id";
				break;
				case 'tbm_quality_survey_policy_question':
				$sap_i_table    = "ZTBM_QTY_S_POLQ";
				$sap_table 		= "IT_ZTBM_QTY_S_POLQ";
				$revision_field = "policy_revision_id";
				break;
			}

			$is_used = $this->__ps_project_query->getObj('tbt_quality_survey', array($revision_field => $last_revision));
			$is_exist = $this->__ps_project_query->getObj($p['table'], array('revision_id' => $last_revision));

			if (empty($is_used) || empty($is_exist)) {

				$last_obj = $this->__ps_project_query->getObj($p['table'], null, false, "", "id desc");
				if (empty($last_obj)) {
					$last_id = 1;
				}else {
					$last_id = intval($last_obj['id'])+1;
				}

				$data = array(
					'id'				=> $last_id,
					'title' 			=> $p['title'],
					'sequence_index' 	=> (!empty($p['sequence_index'])) ? $p['sequence_index'] : 0,
					'revision_id'	 	=> $last_revision,
					'subject_id'		=> $p['subject_id'],
					'is_subject'		=> (!empty($p['is_subject'])) ? 1 : 0,
					'is_hr_question'	=> (!empty($p['is_hr_question'])) ? 1 : 0,
					);

				if ($p['table'] == "tbm_quality_survey_kpi_question") {
					$data['score'] = (!empty($p['score'])) ? $p['score'] : 0;
				}

				$this->__ps_project_query->insertObj($p['table'], $data);

				$sap_q = array(
					'ID' 				=> $last_id,
					'TITLE' 			=> iconv("UTF-8", "TIS-620",$p['title']),
					'REVISION_ID' 		=> $last_revision,
					'IS_SUBJECT' 		=> (!empty($p['is_subject'])) ? 1 : 0,
					'SUBJECT_ID' 		=> $p['subject_id'],
					'SEQUENCE_INDEX' 	=> (!empty($p['sequence_index'])) ? $p['sequence_index'] : 0,
					'IS_HR_QUESTION' 	=> (!empty($p['is_hr_question'])) ? 1 : 0,
					);

				if ($p['table'] == "tbm_quality_survey_kpi_question") {
					$sap_q['SCORE'] = (!empty($p['score'])) ? $p['score'] : 0;
				}

				$input = array( 
					array("IMPORT","I_MODE","M"),
					array("IMPORT","I_TABLE", $sap_i_table),
					array("IMPORT","I_DATE", date('Ymd')),
					array("IMPORT","I_COMMIT", "X"),
					array("TABLE",$sap_table, array($sap_q))
					);

				$result = $this->callSAPFunction("ZRFC_MASS_TABLE", $input);

			} else {

				$all_question = $this->__ps_project_query->getObj($p['table'], array('revision_id' => $last_revision, 'subject_id' => 0), true); 

				$sap_q_list = array();

				foreach ($all_question as $key => $question) {

					$last_obj = $this->__ps_project_query->getObj($p['table'], null, false, "", "id desc");
					if (empty($last_obj)) {
						$parent_id = 1;
					}else {
						$parent_id = intval($last_obj['id'])+1;
					}

					$question_data = array(
						'id'			   => $parent_id,
						'title' 		   => $question['title'],
						'sequence_index'   => $question['sequence_index'],
						'is_subject'	   => $question['is_subject'],
						'is_hr_question'   => $question['is_hr_question'],
						'subject_id'	   => $question['subject_id'],
						'revision_id'	   => intval($last_revision)+1
						);

					if ($p['table'] == "tbm_quality_survey_kpi_question") {
						$question_data['score'] = (!empty($question['score'])) ? $question['score'] : 0;
					}

					$this->__ps_project_query->insertObj($p['table'], $question_data);

					$sap_parent_q = array(
						'ID' 				=> $parent_id,
						'TITLE' 			=> iconv("UTF-8", "TIS-620",$question['title']),
						'REVISION_ID' 		=> intval($last_revision)+1,
						'IS_SUBJECT' 		=> (!empty($question['is_subject'])) ? 1 : 0,
						'SUBJECT_ID' 		=> $question['subject_id'],
						'SEQUENCE_INDEX' 	=> (!empty($question['sequence_index'])) ? $question['sequence_index'] : 0,
						'IS_HR_QUESTION' 	=> (!empty($question['is_hr_question'])) ? 1 : 0,
						);

					if ($p['table'] == "tbm_quality_survey_kpi_question") {
						$sap_parent_q['SCORE'] = (!empty($question['score'])) ? $question['score'] : 0;
					}

					array_push($sap_q_list, $sap_parent_q);

					if ($question['id'] == $p['subject_id']) {
						$p['subject_id'] = $parent_id;
					}

					$all_sub_question = $this->__ps_project_query->getObj($p['table'], array('revision_id' => $last_revision, 'subject_id' => $question['id']), true); 

					if (!empty($all_sub_question)) {
						foreach ($all_sub_question as $key => $sub_question) {

							$last_obj = $this->__ps_project_query->getObj($p['table'], null, false, "", "id desc");
							if (empty($last_obj)) {
								$sub_parent_id = 1;
							}else {
								$sub_parent_id = intval($last_obj['id'])+1;
							}

							$sub_question_data = array(
								'id'			   => $sub_parent_id,
								'title' 		   => $sub_question['title'],
								'sequence_index'   => $sub_question['sequence_index'],
								'is_subject'	   => $sub_question['is_subject'],
								'is_hr_question'   => $sub_question['is_hr_question'],
								'subject_id'	   => $parent_id,
								'revision_id'	   => intval($last_revision)+1
								);

							if ($p['table'] == "tbm_quality_survey_kpi_question") {
								$sub_question_data['score'] = (!empty($sub_question['score'])) ? $sub_question['score'] : 0;
							}

							$this->__ps_project_query->insertObj($p['table'], $sub_question_data);

							$sap_sub_q = array(
								'ID' 				=> $sub_parent_id,
								'TITLE' 			=> iconv("UTF-8", "TIS-620",$sub_question['title']),
								'REVISION_ID' 		=> intval($last_revision)+1,
								'IS_SUBJECT' 		=> (!empty($sub_question['is_subject'])) ? 1 : 0,
								'SUBJECT_ID' 		=> $sub_question['subject_id'],
								'SEQUENCE_INDEX' 	=> (!empty($sub_question['sequence_index'])) ? $sub_question['sequence_index'] : 0,
								'IS_HR_QUESTION' 	=> (!empty($sub_question['is_hr_question'])) ? 1 : 0,
								);

							if ($p['table'] == "tbm_quality_survey_kpi_question") {
								$sap_sub_q['SCORE'] = (!empty($sub_question['score'])) ? $sub_question['score'] : 0;
							}

							array_push($sap_q_list, $sap_sub_q);

							if ($sub_question['id'] == $p['subject_id']) {
								$p['subject_id'] = $sub_parent_id;
							}

							$all_sub_sub_question = $this->__ps_project_query->getObj($p['table'], array('revision_id' => $last_revision, 'subject_id' => $sub_question['id']), true); 

							if (!empty($all_sub_sub_question)) {
								foreach ($all_sub_sub_question as $key => $sub_sub_question) {

									$last_obj = $this->__ps_project_query->getObj($p['table'], null, false, "", "id desc");
									if (empty($last_obj)) {
										$question_id = 1;
									}else {
										$question_id = intval($last_obj['id'])+1;
									}

									$sub_sub_question_data = array(
										'id'			   => $question_id,
										'title' 		   => $sub_sub_question['title'],
										'sequence_index'   => $sub_sub_question['sequence_index'],
										'is_subject'	   => $sub_sub_question['is_subject'],
										'is_hr_question'   => $sub_sub_question['is_hr_question'],
										'subject_id'	   => $sub_parent_id,
										'revision_id'	   => intval($last_revision)+1
										);

									if ($p['table'] == "tbm_quality_survey_kpi_question") {
										$sub_sub_question_data['score'] = (!empty($sub_sub_question['score'])) ? $sub_sub_question['score'] : 0;
									}

									$this->__ps_project_query->insertObj($p['table'], $sub_sub_question_data);

									$sap_q = array(
										'ID' 				=> $question_id,
										'TITLE' 			=> iconv("UTF-8", "TIS-620",$sub_sub_question['title']),
										'REVISION_ID' 		=> intval($last_revision)+1,
										'IS_SUBJECT' 		=> (!empty($sub_sub_question['is_subject'])) ? 1 : 0,
										'SUBJECT_ID' 		=> $sub_sub_question['subject_id'],
										'SEQUENCE_INDEX' 	=> (!empty($sub_sub_question['sequence_index'])) ? $sub_sub_question['sequence_index'] : 0,
										'IS_HR_QUESTION' 	=> (!empty($sub_sub_question['is_hr_question'])) ? 1 : 0,
										);

									if ($p['table'] == "tbm_quality_survey_kpi_question") {
										$sap_q['SCORE'] = (!empty($sub_sub_question['score'])) ? $sub_sub_question['score'] : 0;
									}

									array_push($sap_q_list, $sap_q);
								}
							}
						}
					}
				}

				$last_obj = $this->__ps_project_query->getObj($p['table'], null, false, "", "id desc");
				if (empty($last_obj)) {
					$question_id = 1;
				}else {
					$question_id = intval($last_obj['id'])+1;
				}

				$data = array(
					'id'				=> $question_id,
					'title' 			=> $p['title'],
					'sequence_index' 	=> (!empty($p['sequence_index'])) ? $p['sequence_index'] : 0,
					'revision_id'	 	=> intval($last_revision)+1,
					'subject_id'		=> $p['subject_id'],
					'is_subject'		=> (!empty($p['is_subject'])) ? 1 : 0,
					'is_hr_question'	=> (!empty($p['is_hr_question'])) ? 1 : 0,
					);

				if ($p['table'] == "tbm_quality_survey_kpi_question") {
					$data['score'] = (!empty($p['score'])) ? $p['score'] : 0;
				}

				$this->__ps_project_query->insertObj($p['table'], $data);

				$sap_q = array(
					'ID' 				=> $question_id,
					'TITLE' 			=> iconv("UTF-8", "TIS-620",$p['title']),
					'REVISION_ID' 		=> intval($last_revision)+1,
					'IS_SUBJECT' 		=> (!empty($p['is_subject'])) ? 1 : 0,
					'SUBJECT_ID' 		=> $p['subject_id'],
					'SEQUENCE_INDEX' 	=> (!empty($p['sequence_index'])) ? $p['sequence_index'] : 0,
					'IS_HR_QUESTION' 	=> (!empty($p['is_hr_question'])) ? 1 : 0,
					);

				if ($p['table'] == "tbm_quality_survey_kpi_question") {
					$sap_q['SCORE'] = (!empty($p['score'])) ? $p['score'] : 0;
				}

				array_push($sap_q_list, $sap_q);

				$input = array( 
					array("IMPORT","I_MODE","M"),
					array("IMPORT","I_TABLE", $sap_i_table),
					array("IMPORT","I_DATE", date('Ymd')),
					array("IMPORT","I_COMMIT", "X"),
					array("TABLE",$sap_table, $sap_q_list)
					);

				$result = $this->callSAPFunction("ZRFC_MASS_TABLE", $input);

			}
		}

		redirect(site_url('__cms_data_manager/quality_question_management/'.$p['tab']), 'refresh');

	}

	public function edit_question (){

		$p = $this->input->post();

		// echo "<pre>";
		// print_r($p);
		// echo "</pre>";

		// die();

		if (!empty($p['table'])) {		

			$last_revision = $this->__quality_assurance_model->getQuestionRevision($p['table']);

			$sap_i_table    = "";
			$sap_table      = "";
			$revision_field = "";
			switch ($p['table']) {
				case 'tbm_quality_survey_customer_question':
				$sap_i_table    = "ZTBM_QTY_S_CUSQ";
				$sap_table 		= "IT_ZTBM_QTY_S_CUSQ";
				$revision_field = "customer_revision_id";
				break;
				case 'tbm_quality_survey_document_control_question':
				$sap_i_table    = "ZTBM_QTY_S_DOCQ";
				$sap_table 		= "IT_ZTBM_QTY_S_DOCQ";
				$revision_field = "document_control_revision_id";
				break;
				case 'tbm_quality_survey_kpi_question':
				$sap_i_table    = "ZTBM_QTY_S_KPIQ";
				$sap_table 		= "IT_ZTBM_QTY_S_KPIQ";
				$revision_field = "KPI_revision_id";
				break;
				case 'tbm_quality_survey_policy_question':
				$sap_i_table    = "ZTBM_QTY_S_POLQ";
				$sap_table 		= "IT_ZTBM_QTY_S_POLQ";
				$revision_field = "policy_revision_id";
				break;
			}

			$is_used = $this->__ps_project_query->getObj('tbt_quality_survey', array($revision_field => $last_revision));

			if (empty($is_used)) {
				$data = array(
					'title' 			=> $p['title'],
					'sequence_index' 	=> (!empty($p['sequence_index'])) ? $p['sequence_index'] : 0,
					'revision_id'	 	=> $last_revision,
					'is_subject'		=> (!empty($p['is_subject'])) ? 1 : 0,
					'is_hr_question'	=> (!empty($p['is_hr_question'])) ? 1 : 0,
					);

				if ($p['table'] == "tbm_quality_survey_kpi_question") {
					$data['score'] = (!empty($p['score'])) ? $p['score'] : 0;
				}

				// echo "<pre>1";
				// print_r($data);
				// echo "</pre>";
				// die();

				$this->__ps_project_query->updateObj($p['table'], array('id' => $p['id']), $data);

				$sap_q = array(
					'ID' 				=> $p['id'],
					'TITLE' 			=> iconv("UTF-8", "TIS-620",$p['title']),
					'REVISION_ID' 		=> $last_revision,
					'IS_SUBJECT' 		=> (!empty($p['is_subject'])) ? 1 : 0,
					'SUBJECT_ID' 		=> $p['subject_id'],
					'SEQUENCE_INDEX' 	=> (!empty($p['sequence_index'])) ? $p['sequence_index'] : 0,
					'IS_HR_QUESTION' 	=> (!empty($p['is_hr_question'])) ? 1 : 0,
					);

				if ($p['table'] == "tbm_quality_survey_kpi_question") {
					$sap_q['SCORE'] = (!empty($p['score'])) ? $p['score'] : 0;
				}

				$input = array( 
					array("IMPORT","I_MODE","M"),
					array("IMPORT","I_TABLE", $sap_i_table),
					array("IMPORT","I_DATE", date('Ymd')),
					array("IMPORT","I_COMMIT", "X"),
					array("TABLE",$sap_table, array($sap_q))
					);

				// echo "<pre>1: sap";
				// print_r($input);
				// echo "</pre>";
				// die();

				$result = $this->callSAPFunction("ZRFC_MASS_TABLE", $input);

			} else {

				$all_question = $this->__ps_project_query->getObj($p['table'], array('revision_id' => $last_revision, 'subject_id' => 0), true); 

				$sap_q_list = array();
				foreach ($all_question as $key => $question) {

					$last_obj = $this->__ps_project_query->getObj($p['table'], null, false, "", "id desc");
					if (empty($last_obj)) {
						$parent_id = 1;
					}else {
						$parent_id = intval($last_obj['id'])+1;
					}

					$question_data = array(
						'id'			   => $parent_id,
						'title' 		   => $question['title'],
						'sequence_index'   => $question['sequence_index'],
						'is_subject'	   => $question['is_subject'],
						'is_hr_question'   => $question['is_hr_question'],
						'subject_id'	   => $question['subject_id'],
						'revision_id'	   => intval($last_revision)+1
						);

					if ($p['table'] == "tbm_quality_survey_kpi_question") {
						$question_data['score'] = (!empty($question['score'])) ? $question['score'] : 0;
					}
					// echo "<pre>2";
					// print_r($question_data);
					// echo "</pre>";
					// die();
					$this->__ps_project_query->insertObj($p['table'], $question_data);

					$sap_parent_q = array(
						'ID' 				=> $parent_id,
						'TITLE' 			=> iconv("UTF-8", "TIS-620",$question['title']),
						'REVISION_ID' 		=> intval($last_revision)+1,
						'IS_SUBJECT' 		=> (!empty($question['is_subject'])) ? 1 : 0,
						'SUBJECT_ID' 		=> $question['subject_id'],
						'SEQUENCE_INDEX' 	=> (!empty($question['sequence_index'])) ? $question['sequence_index'] : 0,
						'IS_HR_QUESTION' 	=> (!empty($question['is_hr_question'])) ? 1 : 0,
						);

					if ($p['table'] == "tbm_quality_survey_kpi_question") {
						$sap_parent_q['SCORE'] = (!empty($question['score'])) ? $question['score'] : 0;
					}
					// echo "<pre>3 sap";
					// print_r($sap_parent_q);
					// echo "</pre>";
					// die();

					array_push($sap_q_list, $sap_parent_q);

					if ($question['id'] == $p['id']) {
						$p['id'] = $parent_id;
					}

					$all_sub_question = $this->__ps_project_query->getObj($p['table'], array('revision_id' => $last_revision, 'subject_id' => $question['id']), true); 

					if (!empty($all_sub_question)) {
						foreach ($all_sub_question as $key => $sub_question) {

							$last_obj = $this->__ps_project_query->getObj($p['table'], null, false, "", "id desc");
							if (empty($last_obj)) {
								$sub_parent_id = 1;
							}else {
								$sub_parent_id = intval($last_obj['id'])+1;
							}

							$sub_question_data = array(
								'id'			   => $sub_parent_id,
								'title' 		   => $sub_question['title'],
								'sequence_index'   => $sub_question['sequence_index'],
								'is_subject'	   => $sub_question['is_subject'],
								'subject_id'	   => $parent_id,
								'is_hr_question'   => $sub_question['is_hr_question'],
								'revision_id'	   => intval($last_revision)+1
								);

							if ($p['table'] == "tbm_quality_survey_kpi_question") {
								$sub_question_data['score'] = (!empty($sub_question['score'])) ? $sub_question['score'] : 0;
							}
							// echo "<pre>4";
							// print_r($sub_question_data);
							// echo "</pre>";
							// die();

							$this->__ps_project_query->insertObj($p['table'], $sub_question_data);

							$sap_sub_q = array(
								'ID' 				=> $sub_parent_id,
								'TITLE' 			=> iconv("UTF-8", "TIS-620",$sub_question['title']),
								'REVISION_ID' 		=> intval($last_revision)+1,
								'IS_SUBJECT' 		=> (!empty($sub_question['is_subject'])) ? 1 : 0,
								'SUBJECT_ID' 		=> $sub_question['subject_id'],
								'SEQUENCE_INDEX' 	=> (!empty($sub_question['sequence_index'])) ? $sub_question['sequence_index'] : 0,
								'IS_HR_QUESTION' 	=> (!empty($sub_question['is_hr_question'])) ? 1 : 0,
								);

							if ($p['table'] == "tbm_quality_survey_kpi_question") {
								$sap_sub_q['SCORE'] = (!empty($sub_question['score'])) ? $sub_question['score'] : 0;
							}

							// echo "<pre>5 sap";
							// print_r($sap_sub_q);
							// echo "</pre>";
							// die();

							array_push($sap_q_list, $sap_sub_q);

							if ($sub_question['id'] == $p['id']) {
								$p['id'] = $sub_parent_id;
							}

							$all_sub_sub_question = $this->__ps_project_query->getObj($p['table'], array('revision_id' => $last_revision, 'subject_id' => $sub_question['id']), true); 

							if (!empty($all_sub_sub_question)) {
								foreach ($all_sub_sub_question as $key => $sub_sub_question) {

									$last_obj = $this->__ps_project_query->getObj($p['table'], null, false, "", "id desc");
									if (empty($last_obj)) {
										$sub_sub_parent_id = 1;
									}else {
										$sub_sub_parent_id = intval($last_obj['id'])+1;
									}

									$sub_sub_question_data = array(
										'id'			   => $sub_sub_parent_id,
										'title' 		   => $sub_sub_question['title'],
										'sequence_index'   => $sub_sub_question['sequence_index'],
										'is_subject'	   => $sub_sub_question['is_subject'],
										'is_hr_question'   => $sub_sub_question['is_hr_question'],
										'subject_id'	   => $sub_parent_id,
										'revision_id'	   => intval($last_revision)+1
										);

									if ($p['table'] == "tbm_quality_survey_kpi_question") {
										$sub_sub_question_data['score'] = (!empty($sub_sub_question['score'])) ? $sub_sub_question['score'] : 0;
									}
									// echo "<pre>6";
									// print_r($sub_sub_question_data);
									// echo "</pre>";
									// die();
									$this->__ps_project_query->insertObj($p['table'], $sub_sub_question_data);

									$sap_q = array(
										'ID' 				=> $sub_sub_parent_id,
										'TITLE' 			=> iconv("UTF-8", "TIS-620",$sub_sub_question['title']),
										'REVISION_ID' 		=> intval($last_revision)+1,
										'IS_SUBJECT' 		=> (!empty($sub_sub_question['is_subject'])) ? 1 : 0,
										'SUBJECT_ID' 		=> $sub_sub_question['subject_id'],
										'SEQUENCE_INDEX' 	=> (!empty($sub_sub_question['sequence_index'])) ? $sub_sub_question['sequence_index'] : 0,
										'IS_HR_QUESTION' 	=> (!empty($sub_sub_question['is_hr_question'])) ? 1 : 0,
										);

									if ($p['table'] == "tbm_quality_survey_kpi_question") {
										$sap_q['SCORE'] = (!empty($sub_sub_question['score'])) ? $sub_sub_question['score'] : 0;
									}
									// echo "<pre>7 sap";
									// print_r($sap_q);
									// echo "</pre>";
									// die();
									array_push($sap_q_list, $sap_q);

									if ($sub_sub_question['id'] == $p['id']) {
										$p['id'] = $sub_sub_parent_id;
									}
								}
							}
						}
					}
				}

				$data = array(
					'title' 			=> $p['title'],
					'sequence_index' 	=> (!empty($p['sequence_index'])) ? $p['sequence_index'] : 0,
					'revision_id'	 	=> intval($last_revision)+1,
					'is_subject'		=> (!empty($p['is_subject'])) ? 1 : 0,
					'is_hr_question'	=> (!empty($p['is_hr_question'])) ? 1 : 0,
					);

				if ($p['table'] == "tbm_quality_survey_kpi_question") {
					$data['score'] = (!empty($p['score'])) ? $p['score'] : 0;
				}

				// echo "<pre>8";
				// print_r($data);
				// echo "</pre>";
				// die();

				$this->__ps_project_query->updateObj($p['table'], array('id' => $p['id']), $data);

				$sap_q = array(
					'ID' 				=> $p['id'],
					'TITLE' 			=> iconv("UTF-8", "TIS-620",$p['title']),
					'REVISION_ID' 		=> $last_revision,
					'IS_SUBJECT' 		=> (!empty($p['is_subject'])) ? 1 : 0,
					'SUBJECT_ID' 		=> $p['subject_id'],
					'SEQUENCE_INDEX' 	=> (!empty($p['sequence_index'])) ? $p['sequence_index'] : 0,
					'IS_HR_QUESTION' 	=> (!empty($p['is_hr_question'])) ? 1 : 0,
					);

				if ($p['table'] == "tbm_quality_survey_kpi_question") {
					$sap_q['SCORE'] = (!empty($p['score'])) ? $p['score'] : 0;
				}

				// echo "<pre>9 sap";
				// print_r($sap_q);
				// echo "</pre>";
				// die();

				array_push($sap_q_list, $sap_q);

				$input = array( 
					array("IMPORT","I_MODE","M"),
					array("IMPORT","I_TABLE", $sap_i_table),
					array("IMPORT","I_DATE", date('Ymd')),
					array("IMPORT","I_COMMIT", "X"),
					array("TABLE",$sap_table, $sap_q_list)
					);

				$result = $this->callSAPFunction("ZRFC_MASS_TABLE", $input);
			}
		}

		redirect(site_url('__cms_data_manager/quality_question_management/'.$p['tab']), 'refresh');

	}

	public function edit_customer_score () {

		$p = $this->input->post();
		if (!empty($p)) {

			$this->db->truncate('tbm_quality_survey_customer_score');
			$this->__ps_project_query->insertObj('tbm_quality_survey_customer_score', $p);

			$sap_data = array(
				'EXCELLENT'		=> $p['excellent'],
				'GOOD'			=> $p['good'],
				'AVERAGE'		=> $p['average'],
				'FAIR'			=> $p['fair'],
				'POOR'			=> $p['poor']
				);

			$input = array( 
				array("IMPORT","I_MODE","M"),
				array("IMPORT","I_TABLE", "ZTBM_QTY_CUS_SCO"),
				array("IMPORT","I_DATE", date('Ymd')),
				array("IMPORT","I_COMMIT", "X"),
				array("TABLE","IT_ZTBM_QTY_CUS_SCO", array($sap_data))
				);

			$result = $this->callSAPFunction("ZRFC_MASS_TABLE", $input);

		}

		redirect(site_url('__cms_data_manager/quality_question_management/2'), 'refresh');
	}

	public function delete_question (){

		$p = $this->input->post();

		// echo "<pre>";
		// print_r($p);
		// echo "</pre>";

		// die();

		if (!empty($p['table'])) {		

			$last_revision = $this->__quality_assurance_model->getQuestionRevision($p['table']);

			$sap_i_table    = "";
			$sap_table      = "";
			$revision_field = "";
			switch ($p['table']) {
				case 'tbm_quality_survey_customer_question':
				$sap_i_table    = "ZTBM_QTY_S_CUSQ";
				$sap_table 		= "IT_ZTBM_QTY_S_CUSQ";
				$revision_field = "customer_revision_id";
				break;
				case 'tbm_quality_survey_document_control_question':
				$sap_i_table    = "ZTBM_QTY_S_DOCQ";
				$sap_table 		= "IT_ZTBM_QTY_S_DOCQ";
				$revision_field = "document_control_revision_id";
				break;
				case 'tbm_quality_survey_kpi_question':
				$sap_i_table    = "ZTBM_QTY_S_KPIQ";
				$sap_table 		= "IT_ZTBM_QTY_S_KPIQ";
				$revision_field = "KPI_revision_id";
				break;
				case 'tbm_quality_survey_policy_question':
				$sap_i_table    = "ZTBM_QTY_S_POLQ";
				$sap_table 		= "IT_ZTBM_QTY_S_POLQ";
				$revision_field = "policy_revision_id";
				break;
			}

			$is_used = $this->__ps_project_query->getObj('tbt_quality_survey', array($revision_field => $last_revision));

			if (empty($is_used)) {

				$del_list = array();
				$children = $this->__ps_project_query->getObj($p['table'], array('subject_id' => $p['id']), true);
				if (!empty($children)) {
					foreach ($children as $key => $child) {						

						$sap_q = array(
							'ID' => $child['id']
							);
						array_push($del_list, $sap_q);
					}
				}

				$sap_q = array(
					'ID' => $p['id']
					);
				array_push($del_list, $sap_q);
				
				$input = array( 
					array("IMPORT","I_MODE","D"),
					array("IMPORT","I_TABLE", $sap_i_table),
					array("IMPORT","I_DATE", date('Ymd')),
					array("IMPORT","I_COMMIT", "X"),
					array("TABLE",$sap_table, $del_list)
					);

				$result = $this->callSAPFunction("ZRFC_MASS_TABLE", $input);

				$this->__ps_project_query->deleteObj($p['table'], array('subject_id' => $p['id']));
				$this->__ps_project_query->deleteObj($p['table'], array('id' => $p['id']));
			} else {

				$all_question = $this->__ps_project_query->getObj($p['table'], array('revision_id' => $last_revision, 'subject_id' => 0), true); 

				$sap_q_list = array();
				foreach ($all_question as $key => $question) {

					$last_obj = $this->__ps_project_query->getObj($p['table'], null, false, "", "id desc");
					if (empty($last_obj)) {
						$parent_id = 1;
					}else {
						$parent_id = intval($last_obj['id'])+1;
					}

					$question_data = array(
						'id'			   => $parent_id,
						'title' 		   => $question['title'],
						'sequence_index'   => $question['sequence_index'],
						'is_subject'	   => $question['is_subject'],
						'subject_id'	   => $question['subject_id'],
						'revision_id'	   => intval($last_revision)+1
						);

					$this->__ps_project_query->insertObj($p['table'], $question_data);

					$sap_parent_q = array(
						'ID' 				=> $parent_id,
						'TITLE' 			=> iconv("UTF-8", "TIS-620",$question['title']),
						'REVISION_ID' 		=> intval($last_revision)+1,
						'IS_SUBJECT' 		=> (!empty($question['is_subject'])) ? 1 : 0,
						'SUBJECT_ID' 		=> $question['subject_id'],
						'SEQUENCE_INDEX' 	=> (!empty($question['sequence_index'])) ? $question['sequence_index'] : 0,
						);

					array_push($sap_q_list, $sap_parent_q);

					if ($question['id'] == $p['id']) {
						$p['id'] = $parent_id;
					}

					$all_sub_question = $this->__ps_project_query->getObj($p['table'], array('revision_id' => $last_revision, 'subject_id' => $question['id']), true); 

					if (!empty($all_sub_question)) {
						foreach ($all_sub_question as $key => $sub_question) {

							$last_obj = $this->__ps_project_query->getObj($p['table'], null, false, "", "id desc");
							if (empty($last_obj)) {
								$sub_parent_id = 1;
							}else {
								$sub_parent_id = intval($last_obj['id'])+1;
							}

							$sub_question_data = array(
								'id'			   => $sub_parent_id,
								'title' 		   => $sub_question['title'],
								'sequence_index'   => $sub_question['sequence_index'],
								'is_subject'	   => $sub_question['is_subject'],
								'subject_id'	   => $parent_id,
								'revision_id'	   => intval($last_revision)+1
								);

							$this->__ps_project_query->insertObj($p['table'], $sub_question_data);

							$sap_sub_q = array(
								'ID' 				=> $sub_parent_id,
								'TITLE' 			=> iconv("UTF-8", "TIS-620",$sub_question['title']),
								'REVISION_ID' 		=> intval($last_revision)+1,
								'IS_SUBJECT' 		=> (!empty($sub_question['is_subject'])) ? 1 : 0,
								'SUBJECT_ID' 		=> $sub_question['subject_id'],
								'SEQUENCE_INDEX' 	=> (!empty($sub_question['sequence_index'])) ? $sub_question['sequence_index'] : 0,
								);

							array_push($sap_q_list, $sap_sub_q);

							if ($sub_question['id'] == $p['id']) {
								$p['id'] = $sub_parent_id;
							}

							$all_sub_sub_question = $this->__ps_project_query->getObj($p['table'], array('revision_id' => $last_revision, 'subject_id' => $sub_question['id']), true); 

							if (!empty($all_sub_sub_question)) {
								foreach ($all_sub_sub_question as $key => $sub_sub_question) {

									$last_obj = $this->__ps_project_query->getObj($p['table'], null, false, "", "id desc");
									if (empty($last_obj)) {
										$sub_sub_parent_id = 1;
									}else {
										$sub_sub_parent_id = intval($last_obj['id'])+1;
									}

									$sub_sub_question_data = array(
										'id'			   => $sub_sub_parent_id,
										'title' 		   => $sub_sub_question['title'],
										'sequence_index'   => $sub_sub_question['sequence_index'],
										'is_subject'	   => $sub_sub_question['is_subject'],
										'subject_id'	   => $sub_parent_id,
										'revision_id'	   => intval($last_revision)+1
										);

									$this->__ps_project_query->insertObj($p['table'], $sub_sub_question_data);

									$sap_q = array(
										'ID' 				=> $sub_sub_parent_id,
										'TITLE' 			=> iconv("UTF-8", "TIS-620",$sub_sub_question['title']),
										'REVISION_ID' 		=> intval($last_revision)+1,
										'IS_SUBJECT' 		=> (!empty($sub_sub_question['is_subject'])) ? 1 : 0,
										'SUBJECT_ID' 		=> $sub_sub_question['subject_id'],
										'SEQUENCE_INDEX' 	=> (!empty($sub_sub_question['sequence_index'])) ? $sub_sub_question['sequence_index'] : 0,
										);

									array_push($sap_q_list, $sap_q);

									if ($sub_sub_question['id'] == $p['id']) {
										$p['id'] = $sub_sub_parent_id;
									}
								}
							}
						}
					}
				}

				$input = array( 
					array("IMPORT","I_MODE","M"),
					array("IMPORT","I_TABLE", $sap_i_table),
					array("IMPORT","I_DATE", date('Ymd')),
					array("IMPORT","I_COMMIT", "X"),
					array("TABLE",$sap_table, $sap_q_list)
					);

				$result = $this->callSAPFunction("ZRFC_MASS_TABLE", $input);

				$del_list = array();
				$children = $this->__ps_project_query->getObj($p['table'], array('subject_id' => $p['id']), true);
				if (!empty($children)) {
					foreach ($children as $key => $child) {						

						$sap_q = array(
							'ID' => $child['id']
							);
						array_push($del_list, $sap_q);
					}
				}

				$sap_q = array(
					'ID' => $p['id']
					);
				array_push($del_list, $sap_q);
				
				$input = array( 
					array("IMPORT","I_MODE","D"),
					array("IMPORT","I_TABLE", $sap_i_table),
					array("IMPORT","I_DATE", date('Ymd')),
					array("IMPORT","I_COMMIT", "X"),
					array("TABLE",$sap_table, $del_list)
					);

				$result = $this->callSAPFunction("ZRFC_MASS_TABLE", $input);

				$this->__ps_project_query->deleteObj($p['table'], array('subject_id' => $p['id']));
				$this->__ps_project_query->deleteObj($p['table'], array('id' => $p['id']));
			}
		}

		redirect(site_url('__cms_data_manager/quality_question_management/'.$p['tab']), 'refresh');

	}

	public function cleanup_quality_question () {

		$table_arr = array('tbm_quality_survey_customer_question', 'tbm_quality_survey_document_control_question', 'tbm_quality_survey_kpi_question', 'tbm_quality_survey_policy_question');
		// $table_arr = array('tbm_quality_survey_customer_question');
		foreach ($table_arr as $table) {
			
			$sap_i_table = "";
			$sap_table 	 = "";

			switch ($table) {
				case 'tbm_quality_survey_customer_question':
				$sap_i_table    = "ZTBM_QTY_S_CUSQ";
				$sap_table 		= "IT_ZTBM_QTY_S_CUSQ";
				break;
				case 'tbm_quality_survey_document_control_question':
				$sap_i_table    = "ZTBM_QTY_S_DOCQ";
				$sap_table 		= "IT_ZTBM_QTY_S_DOCQ";
				break;
				case 'tbm_quality_survey_kpi_question':
				$sap_i_table    = "ZTBM_QTY_S_KPIQ";
				$sap_table 		= "IT_ZTBM_QTY_S_KPIQ";
				break;
				case 'tbm_quality_survey_policy_question':
				$sap_i_table    = "ZTBM_QTY_S_POLQ";
				$sap_table 		= "IT_ZTBM_QTY_S_POLQ";
				break;
			}

			$input = array( 
				array("IMPORT","I_MODE","R"),
				array("IMPORT","I_TABLE", $sap_i_table),
				array("IMPORT","I_DATE", date('Ymd')),
				array("IMPORT","I_COMMIT", "X"),
				array("TABLE",$sap_table, array())
				);

			$result = $this->callSAPFunction("ZRFC_MASS_TABLE", $input);

			if (!empty($result[$sap_table])) {
				$del_list = array();
				foreach ($result[$sap_table] as $key => $value) {
					$id = $value['ID'];

					$obj = $this->__ps_project_query->getObj($table, array('id' => $id));
					if (empty($obj)) {
						array_push($del_list, $value);
					}
				}

				if (!empty($del_list)) {

					echo "Table: ".$table."<br>";
					echo "<pre>";
					print_r($del_list);
					echo "</pre>";
					$input = array( 
						array("IMPORT","I_MODE","D"),
						array("IMPORT","I_TABLE", $sap_i_table),
						array("IMPORT","I_DATE", date('Ymd')),
						array("IMPORT","I_COMMIT", "X"),
						array("TABLE",$sap_table, $del_list)
						);

					$result = $this->callSAPFunction("ZRFC_MASS_TABLE", $input);
				}
			}
		}

		die();
	}

	public function create_area_question () {

		$p = $this->input->post();
		
		if (!empty($p['industry_room_id']) && !empty($p['title'])) {		

			$last_revision = $this->__quality_assurance_model->getQuestionRevision('tbm_quality_survey_area_question', $p['industry_room_id']);

			$is_used = $this->__quality_assurance_model->isUsedArea($last_revision, $p['industry_room_id']);

			if (empty($is_used)) {
				$data = array(
					'title' 			=> $p['title'],
					'industry_room_id' 	=> $p['industry_room_id'],
					'sequence_index' 	=> (!empty($p['sequence_index'])) ? $p['sequence_index'] : 0,
					'revision_id'	 	=> $last_revision
					);

				$question_id = $this->__ps_project_query->insertObj('tbm_quality_survey_area_question', $data);

				$sap_area_q = array(
					'ID' 				=> $question_id,
					'TITLE' 			=> iconv("UTF-8", "TIS-620",$p['title']),
					'REVISION_ID' 		=> $last_revision,
					'SEQUENCE_INDEX' 	=> (!empty($p['sequence_index'])) ? $p['sequence_index'] : 0
					);
				
				$input = array( 
					array("IMPORT","I_MODE","M"),
					array("IMPORT","I_TABLE", "ZTBM_QTY_S_AREQ"),
					array("IMPORT","I_DATE", date('Ymd')),
					array("IMPORT","I_COMMIT", "X"),
					array("TABLE","IT_ZTBM_QTY_S_AREQ", array($sap_area_q))
					);

				$result = $this->callSAPFunction("ZRFC_MASS_TABLE", $input);

			} else {

				$all_question = $this->__ps_project_query->getObj('tbm_quality_survey_area_question', array('revision_id' => $last_revision, 'industry_room_id' => $p['industry_room_id']), true); 

				$sap_area_question = array();
				foreach ($all_question as $key => $question) {

					$question_data = array(
						'title' 		   => $question['title'],
						'industry_room_id' => $question['industry_room_id'],
						'sequence_index'   => $question['sequence_index'],
						'revision_id'	   => intval($last_revision)+1
						);

					$question_id = $this->__ps_project_query->insertObj('tbm_quality_survey_area_question', $question_data);

					$sap_area_q = array(
						'ID' 				=> $question_id,
						'TITLE' 			=> iconv("UTF-8", "TIS-620",$question['title']),
						'REVISION_ID' 		=> intval($last_revision)+1,
						'SEQUENCE_INDEX' 	=> (!empty($question['sequence_index'])) ? $question['sequence_index'] : 0
						);
					

					array_push($sap_area_question, $sap_area_q);
				}

				$data = array(
					'title' 			=> $p['title'],
					'industry_room_id' 	=> $p['industry_room_id'],
					'sequence_index' 	=> (!empty($p['sequence_index'])) ? $p['sequence_index'] : 0,
					'revision_id'	 	=> intval($last_revision)+1
					);
				$question_id = $this->__ps_project_query->insertObj('tbm_quality_survey_area_question', $data);

				$sap_area_q = array(
					'ID' 				=> $question_id,
					'TITLE' 			=> iconv("UTF-8", "TIS-620",$p['title']),
					'REVISION_ID' 		=> intval($last_revision)+1,
					'SEQUENCE_INDEX' 	=> (!empty($p['sequence_index'])) ? $p['sequence_index'] : 0
					);
				

				array_push($sap_area_question, $sap_area_q);

				$input = array( 
					array("IMPORT","I_MODE","M"),
					array("IMPORT","I_TABLE", "ZTBM_QTY_S_AREQ"),
					array("IMPORT","I_DATE", date('Ymd')),
					array("IMPORT","I_COMMIT", "X"),
					array("TABLE","IT_ZTBM_QTY_S_AREQ", $sap_area_question)
					);

				$result = $this->callSAPFunction("ZRFC_MASS_TABLE", $input);
			}
		}

		redirect(site_url('__cms_data_manager/quality_industry_room_question/'.$p['industry_id'].'/'.$p['industry_room_id']), 'refresh');
	}

	public function edit_area_question () {

		$p = $this->input->post();
		
		if (!empty($p['id'])) {

			$last_revision = $this->__quality_assurance_model->getQuestionRevision('tbm_quality_survey_area_question', $p['industry_room_id']);

			$is_used = $this->__quality_assurance_model->isUsedArea($last_revision, $p['industry_room_id']);

			if (empty($is_used)) {

				$data = array(
					'title' => $p['title'],
					'sequence_index' => (!empty($p['sequence_index'])) ? $p['sequence_index'] : 0
					);
				$this->__ps_project_query->updateObj('tbm_quality_survey_area_question', array('id' => $p['id']) ,$data);

				$sap_area_q = array(
					'ID' 				=> $p['id'],
					'TITLE' 			=> iconv("UTF-8", "TIS-620",$p['title']),
					'REVISION_ID' 		=> $last_revision,
					'SEQUENCE_INDEX' 	=> (!empty($p['sequence_index'])) ? $p['sequence_index'] : 0
					);
				
				$input = array( 
					array("IMPORT","I_MODE","M"),
					array("IMPORT","I_TABLE", "ZTBM_QTY_S_AREQ"),
					array("IMPORT","I_DATE", date('Ymd')),
					array("IMPORT","I_COMMIT", "X"),
					array("TABLE","IT_ZTBM_QTY_S_AREQ", array($sap_area_q))
					);

				$result = $this->callSAPFunction("ZRFC_MASS_TABLE", $input);

			} else {

				$all_question = $this->__ps_project_query->getObj('tbm_quality_survey_area_question', array('revision_id' => $last_revision, 'industry_room_id' => $p['industry_room_id']), true); 

				$sap_area_question = array();
				foreach ($all_question as $key => $question) {

					$question_data = array(
						'title' 		   => $question['title'],
						'industry_room_id' => $question['industry_room_id'],
						'sequence_index'   => $question['sequence_index'],
						'revision_id'	   => intval($last_revision)+1
						);

					$question_id = $this->__ps_project_query->insertObj('tbm_quality_survey_area_question', $question_data);

					$sap_area_q = array(
						'ID' 				=> $question_id,
						'TITLE' 			=> iconv("UTF-8", "TIS-620",$question['title']),
						'REVISION_ID' 		=> intval($last_revision)+1,
						'SEQUENCE_INDEX' 	=> (!empty($question['sequence_index'])) ? $question['sequence_index'] : 0
						);
					
					array_push($sap_area_question, $sap_area_q);

					if ($p['id'] == $question['id']) {
						$p['id'] = $question_id;
					}
				}

				$data = array(
					'title' => $p['title'],
					'sequence_index' => (!empty($p['sequence_index'])) ? $p['sequence_index'] : 0
					);
				$this->__ps_project_query->updateObj('tbm_quality_survey_area_question', array('id' => $p['id']) ,$data);

				$sap_area_q = array(
					'ID' 				=> $p['id'],
					'TITLE' 			=> iconv("UTF-8", "TIS-620",$p['title']),
					'REVISION_ID' 		=> intval($last_revision)+1,
					'SEQUENCE_INDEX' 	=> (!empty($p['sequence_index'])) ? $p['sequence_index'] : 0
					);
				
				array_push($sap_area_question, $sap_area_q);

				$input = array( 
					array("IMPORT","I_MODE","M"),
					array("IMPORT","I_TABLE", "ZTBM_QTY_S_AREQ"),
					array("IMPORT","I_DATE", date('Ymd')),
					array("IMPORT","I_COMMIT", "X"),
					array("TABLE","IT_ZTBM_QTY_S_AREQ", $sap_area_question)
					);

				$result = $this->callSAPFunction("ZRFC_MASS_TABLE", $input);
			}
		}

		redirect(site_url('__cms_data_manager/quality_industry_room_question/'.$p['industry_id'].'/'.$p['industry_room_id']), 'refresh');
	}	

	public function delete_area_question () {

		$p = $this->input->post();

		if (!empty($p['id'])) {

			$last_revision = $this->__quality_assurance_model->getQuestionRevision('tbm_quality_survey_area_question', $p['industry_room_id']);

			$is_used = $this->__quality_assurance_model->isUsedArea($last_revision, $p['industry_room_id']);

			if (empty($is_used)) {

				$this->__ps_project_query->deleteObj('tbm_quality_survey_area_question', array('id' => $p['id']));

				$sap_area_q = 	array(
					'ID' => $p['id']
					);

				$input = array( 
					array("IMPORT","I_MODE","D"),
					array("IMPORT","I_TABLE", "ZTBM_QTY_S_AREQ"),
					array("IMPORT","I_DATE", date('Ymd')),
					array("IMPORT","I_COMMIT", "X"),
					array("TABLE","IT_ZTBM_QTY_S_AREQ", array($sap_area_q))
					);

				$result = $this->callSAPFunction("ZRFC_MASS_TABLE", $input);

			} else {

				$all_question = $this->__ps_project_query->getObj('tbm_quality_survey_area_question', array('revision_id' => $last_revision, 'industry_room_id' => $p['industry_room_id']), true); 

				$sap_area_question = array();
				foreach ($all_question as $key => $question) {

					$question_data = array(
						'title' 		   => $question['title'],
						'industry_room_id' => $question['industry_room_id'],
						'sequence_index'   => $question['sequence_index'],
						'revision_id'	   => intval($last_revision)+1
						);

					$question_id = $this->__ps_project_query->insertObj('tbm_quality_survey_area_question', $question_data);

					$sap_area_q = array(
						'ID' 				=> $question_id,
						'TITLE' 			=> iconv("UTF-8", "TIS-620",$question['title']),
						'REVISION_ID' 		=> intval($last_revision)+1,
						'SEQUENCE_INDEX' 	=> (!empty($question['sequence_index'])) ? $question['sequence_index'] : 0
						);
					
					array_push($sap_area_question, $sap_area_q);

					if ($p['id'] == $question['id']) {
						$p['id'] = $question_id;
					}
				}

				$input = array( 
					array("IMPORT","I_MODE","M"),
					array("IMPORT","I_TABLE", "ZTBM_QTY_S_AREQ"),
					array("IMPORT","I_DATE", date('Ymd')),
					array("IMPORT","I_COMMIT", "X"),
					array("TABLE","IT_ZTBM_QTY_S_AREQ", $sap_area_question)
					);

				$result = $this->callSAPFunction("ZRFC_MASS_TABLE", $input);

				$this->__ps_project_query->deleteObj('tbm_quality_survey_area_question', array('id' => $p['id']));

				$sap_area_q = 	array(
					'ID' => $p['id']
					);

				$input = array( 
					array("IMPORT","I_MODE","D"),
					array("IMPORT","I_TABLE", "ZTBM_QTY_S_AREQ"),
					array("IMPORT","I_DATE", date('Ymd')),
					array("IMPORT","I_COMMIT", "X"),
					array("TABLE","IT_ZTBM_QTY_S_AREQ", array($sap_area_q))
					);

				$result = $this->callSAPFunction("ZRFC_MASS_TABLE", $input);
			}
		}

		redirect(site_url('__cms_data_manager/quality_industry_room_question/'.$p['industry_id'].'/'.$p['industry_room_id']), 'refresh');
	}

	

	public function create_holiday_year () {
		$p = $this->input->post();

		if (!empty($p['year'])) {
			$status = $this->holiday->insert($p['year']);
			echo $status;
		}
	}

	public function edit_holiday_year() {

		$p = $this->input->post();
		// echo "<pre>";
		// print_r($p);
		// echo "</pre>";
		// die();
		$this->holiday->edit($p);
		redirect(site_url('__cms_data_manager/holiday_management/', 'refresh'));
	}

	public function module_create () {
		$p = $this->input->post();
		
		if (!empty($p)) {
			$data = array (
				'module_name'    => $p['name'],
				'description'    => $p['description'],
				'table'		     => $p['table'],
				'icon'		     => $p['icon'],
				'color'		     => $p['color'],
				'url'		     => $p['url'],
				'sequence_index' => $p['sequence_index'],
				'is_action_plan' => (!empty($p['is_action_plan'])) ? $p['is_action_plan'] : 0,
				'is_main_menu'	 => (!empty($p['is_main_menu'])) ? $p['is_main_menu'] : 0,
				'is_active'	 => (!empty($p['is_active'])) ? $p['is_active'] : 0,
				'is_menu'	 => (!empty($p['is_menu'])) ? $p['is_menu'] : 0
				);
			
			$module_id = $this->__ps_project_query->insertObj('cms_module', $data);
		}

		redirect( site_url('__cms_permission/department_module_list') );
	}

	public function module_edit () {
		$p = $this->input->post();
		
		if (!empty($p['id'])) {
			$data = array (
				'module_name'    => $p['name'],
				'description'    => $p['description'],
				'table'		     => $p['table'],
				'icon'		     => $p['icon'],
				'color'		     => $p['color'],
				'url'		     => $p['url'],
				'sequence_index' => $p['sequence_index'],
				'is_action_plan' => (!empty($p['is_action_plan'])) ? $p['is_action_plan'] : 0,
				'is_main_menu'	 => (!empty($p['is_main_menu'])) ? $p['is_main_menu'] : 0,
				'is_active'	 => (!empty($p['is_active'])) ? $p['is_active'] : 0,
				'is_menu'	 => (!empty($p['is_menu'])) ? $p['is_menu'] : 0
				);
			
			$module_id = $this->__ps_project_query->updateObj('cms_module', array('id' => $p['id']), $data);
		}

		redirect( site_url('__cms_permission/department_module_list') );

	}

	public function module_delete () {
		$p = $this->input->post();

		if (!empty($p['id'])) {
			$this->__ps_project_query->deleteObj('tbm_department_module', array('module_id' => $p['id']));
			$this->__ps_project_query->deleteObj('cms_module', array('id' => $p['id']));
		}

		redirect( site_url('__cms_permission/department_module_list') );
	}

	public function module_mapping () {
		//check empty data ship_to =================================
		$list['department_list'] = $this->__ps_project_query->getObj('tbm_department', array('parent_id' => 0), true);
		if (!empty($list['department_list'])) {
			foreach ($list['department_list'] as $key => $dept) {
				$position = $this->__ps_project_query->getObj('tbm_position', array('department_id' => $dept['id']), true);
				if (!empty($position)) {
					foreach ($position as $key => $pos) {
						$temp_pos_id = $pos['id'].'<br>';
					}
				}
			}
		}//end if
		//echo $temp_pos_id; ======================================

		$p = $this->input->post();		
		//====== check empty data ship_to =============
		for ($i=0; $i <=$temp_pos_id; $i++) { 
			# code...
			if (!array_key_exists('shipto_'.$i, $p)) {
				$p['shipto_'.$i] = '0';
			}
		}
		//==============================================

		// echo "<pre>";
		// print_r($p);
		// echo "</pre>";


		$output = array();
		foreach ($p as $key => $value) {
			$key_parts = explode('_', $key);
			if (sizeof($key_parts) == 2) {
				$pos_id = $key_parts[1];
				$action = $key_parts[0];

				if ($action == 'shipto') {
					$output[$pos_id][$p['id']][$action]['value'] = $value[0];
				} else {
					$output[$pos_id][$p['id']][$action]['value'] = $value;;
				}
			} else if (sizeof($key_parts) == 3) {
				$pos_id = $key_parts[1];
				$action = $key_parts[2];

				$output[$pos_id][$p['id']][$action]['shipto'] = $value[0];
			}
		}


		// echo "<pre>";
		// print_r($output);
		// echo "</pre>";

		// die();

		foreach ($output as $pos_id => $pos_val) {
			$pos = $this->__ps_project_query->getObj('tbm_position', array('id' => $pos_id));	
			if (!empty($pos)) {
				$permission = $pos['permission'];
				if (!empty($permission)) {
					$permission = unserialize($permission);
				} else {
					$permission = array();
				}

				foreach ($pos_val as $module_id => $module_val) {
					$permission[$module_id] = $module_val;
				}

				$this->__ps_project_query->updateObj('tbm_position', array('id' => $pos_id), array('permission' => serialize($permission)));
			}
		}

		redirect( site_url('__cms_permission/department_module_list') );
	}

	public function getDepartmentModule () {

		$p = $this->input->post();
		if (!empty($p['id'])) {		
			$position_list = $this->__ps_project_query->getObj('tbm_position', null, true);

			if (!empty($position_list)) {
				$output = array();
				foreach ($position_list as $key => $position) {
					$permission = $position['permission'];
					if (!empty($permission)) {
						$permission = unserialize($permission);
						$output[$position['id']] = $permission[$p['id']];
					}
				}
				echo json_encode($output);
				return;
			}
		}

		echo 0;
		return;
	}

	public function category_management () {

		$menuConfig['page_id'] 	  = 'category';

		#CMS
		$this->pageSize = PAGESIZE;
		$this->table = 'cms_category';
		$this->page_id = 'category';
		$this->page_title = 'Category Management';
		$this->page_object = 'category';
		$this->page_controller = '__cms_data_manager';
		#END_CMS

		//Load top menu
		$data['top_menu']  = $this->load->view('__cms/include/top',$menuConfig,true);//return view as data

		//Load side menu
		$data['side_menu'] = $this->load->view('__cms/include/side',$menuConfig,true);//return view as data

		//Load body
		$module_list           = $this->module_model->getModuleAll();
		$data['category_list'] = $this->module_model->getCategoryAll();
		$data['group_list']    = $this->user->getGroupAll();

		$data['module_list'] = array();
		foreach ($module_list as $module) {
			if (!empty($module['children'])) {
				$module['template_html'] = $this->_setCategoryListTemplate($module['id'], $module['children']);
			}

			array_push($data['module_list'], $module);
		}

		$data['modal'] = $this->load->view('__cms/data_manager/category_modal',$data,true);//return view as data
		$data['body']  = $this->load->view('__cms/data_manager/category_body',$data,true);

		//Load footage script 
		$data['footage_script'] = $this->load->view('__cms/script/data_manager/category_js',$data,true);;

		// $this->load->view('x__cms_permission/user',$data);
		$this->load->view('__cms/layout/list',$data);
	}

	public function _setCategoryListTemplate ( $module_id, $children, $html='' ) {

		if (empty($children)) {
			return '';
		}

		$html = '<ol class="dd-list">';
		foreach ($children as $category) {

			$bg_color = 'bg-success lter';
			if ($category->parent_id == 0) {
				$bg_color = 'bg-success';
			}

			$html .= '<li class="dd-item dd3-item" data-id="'.$category->id.'">'
			.'<div class="dd3-content row '.$category->color.'">'
			.'<div class="col-sm-2 pull-right text-right">'
			.'<a href="#" title="edit" class="btn btn-default btn-xs" data-toggle="modal" data-target="#edit_category_'.$category->id.'"><i class="fa fa-pencil" style="padding:2px;"></i></a>'
			.'<a href="#" title="permission" class="btn btn-default btn-xs" data-toggle="modal" data-target="#permission_category_'.$category->id.'"><i class="fa fa-key" style="padding:2px;"></i></a>'
			.'<a href="#" title="delete" class="btn btn-default btn-xs" data-toggle="modal" data-target="#delete_category_'.$category->id.'"><i class="fa fa-trash-o" style="padding:2px;"></i></a>';

			if ($category->parent_id == 0) {
				$html .= '<a href="#" data-module-id="'.$module_id.'" data-parent-id="'.$category->id.'" title="create" class="create_category_child_btn btn btn-default btn-xs" data-toggle="modal" data-target="#create_category"><i class="fa fa-plus" style="padding:2px;"></i></a>';
			}


			$html .= '</div>'
			.'<div class="col-sm-9" style="width:73%; font-size:15px;"><i class="fa icon '.$category->icon.'"></i>&nbsp;&nbsp;&nbsp;'.$category->name.'</div>'
			.'</div>';

			$html .= $this->_setCategoryListTemplate($module_id, $category->children, $html);

			$html .= '</li>';
		}
		$html .= '</ol>';
		return $html;

	}

	public function category_create () {
		
		$p = $this->input->post();
		$this->module_model->insertCategory($p);

	}

	public function category_edit () {

		$p = $this->input->post();
		$this->module_model->updateCategory($p, array('id' => $p['id']));

	}

	public function delete_category () {
		$p = $this->input->post();

		if ($p['children'] == 'false'){
			$this->module_model->deleteCategoryOnly($p['id']);
		} else {
			$this->module_model->deleteCategoryAll($p['id']);
		}

	}

	public function navigation_management () {

		$menuConfig['page_id'] 	  = 'navigation';

		#CMS
		$this->pageSize = PAGESIZE;
		$this->table = 'cms_page_group';
		$this->page_id = 'navigation';
		$this->page_title = 'Navigation Management';
		$this->page_object = 'navigation';
		$this->page_controller = '__cms_data_manager';
		#END_CMS

		//Load top menu
		$data['top_menu']  = $this->load->view('__cms/include/top',$menuConfig,true);//return view as data

		//Load side menu
		$data['side_menu'] = $this->load->view('__cms/include/side',$menuConfig,true);//return view as data

		//Load body
		$data['page_list'] = $this->module_model->getPageAll();
		$data['navigation'] = $this->module_model->getNavigationGroup();

		$data['modal'] = $this->load->view('__cms/data_manager/navigation_modal',$data,true);//return view as data
		$data['body']  = $this->load->view('__cms/data_manager/navigation_body',$data,true);

		//Load footage script 
		$data['footage_script'] = $this->load->view('__cms/script/data_manager/navigation_js',$data,true);;

		// $this->load->view('x__cms_permission/user',$data);*/
		$this->load->view('__cms/layout/list',$data);
	}

	public function navigation_group_create () {

		$p = $this->input->post();
		$this->module_model->insertNavGroup($p);
	}

	public function update_nav_list () {

		$p = $this->input->post();
		if (!empty($p['json'])) {
			$data = json_decode($p['json']);
			$this->module_model->updateNav($data);
		}
	}

	public function nav_group_delete() {

		$p = $this->input->post();
		if (!empty($p['id'])) {
			$this->module_model->deleteNavGroup($p['id']);
		}
	}

	public function nav_page_delete() {

		$p = $this->input->post();
		if (!empty($p['id'])) {
			$this->module_model->deleteNavPage($p['id'], $p['priority']);
		}
	}
}
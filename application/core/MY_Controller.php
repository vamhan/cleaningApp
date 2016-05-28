<?php //if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'libraries/AES/padCrypt.php';
require APPPATH.'libraries/AES/AES_Encryption.php';

class MY_Controller extends CI_Controller {

	//TODO :: Re design permission constrol
		/*Page access control -> create method for each page 
		  Component access control -> create method for each page 

		Permission -> model_name/module_name = view / add / edit / delete 
		  Group permission -> User group permission control
		  Users permission -> User permission control

		  	a single user permission = group_permission + users_permission
		*/

	function __construct(){
		parent::__construct();

		$this->load->config('auth.config');
   		$this->auth_config = $this->config->item('auth_config');

	}
	// protected function permission_check(){
	// 	//read permission
	// 	$user = $this->session->userdata('current_user');
	// 	if(empty($user)){
	// 		redirect('/dsignage/login/', 'refresh');
	// 	}
	// 	//no permission -> redirect to login
	// }

	//TODO :: Implement pagination 2 type of views
	protected function getPagination($page, $limit, $total_all, $total, $data) {

	    /* Set pagination limit */
	    $start 		 = (($page-1)*$limit) + 1;
	    $end 		 = $page*$limit;

	    /* Set end page */
	    if ($total < $limit) {
	    	$end = $total_all;
	    }

	    /* Set number of page */
	    $no_pages = ceil($total_all/$limit);

	    /* Set pagination parameters */
        $data['current_page'] = $page;
    	$data['start'] 		  = $start;
    	$data['end']		  = $end;
    	$data['total'] 		  = $total_all;
    	$data['no_pages'] 	  = $no_pages;

        $pagination = $this->load->view('include/pagination', $data, TRUE);

        return $pagination;

	}
	// private function terminal_permission_check(){
	// 	//read permission
	// 	$user = $this->session->userdata('current_user');
	// 	return (!empty($user)); // $user must not be blank

	// }

	protected function trace($msg){
		print('<pre>');
		(is_array($msg))?print_r($msg):print($msg);
		print('</pre>');
	}

	//Ajax Connector
	protected function terminal(){

		// $vx = NULL;
		// if(!self::terminal_permission_check()){
		// 	$vx = self::response(false,$errorCode='999',$message='You \'re not permit to access this area',array());
		// 	die(json_encode($vx));
		// }

		$param = $this->input->post();
		$output = array($param);
		// //TODO :: SEAL terminal with session


		// if(!empty($param) && array_key_exists('mcode', $param) && array_key_exists('qid', $param)){
		// 	$output = $this->ds_q->getQuestionByMCode($param['mcode'],$param['qid']);
		// }

		// if(count($output)>0){
		// 	$output = array('success'=>true,'result'=>$output);
		// }else{
		// 	$output = array('success'=>false,'result'=>array());
		// }

		header('Content-Type: application/javascript');
		error_reporting(0);		

		$vx = self::response(true,$errorCode='000',$message='implement your own function by over written this function on your class',$output);
		die(json_encode($vx));
		
	}



	protected function response($status=false,$errorCode='909',$message='',$result=array()){//moved
        if( empty($message))
            $message = ($status)? "Request Success":"Request Fail ,Check the errorCode";
        return array(
            "status"=>$status,
            "errorCode"=>$errorCode,
            "message"=>$message,
            "result"=>$result
        );
    }
}

class Admin_Controller extends MY_Controller {

	function __construct(){
		
		parent::__construct();
		date_default_timezone_set('Asia/Bangkok');

        ###########################################################
        # Load all languages from cms_config/lang
        ###########################################################
		$this->language = array();
		$files = scandir('application/config/cms_config/lang/');
      	foreach($files as $file) {
        	$file = preg_replace('/\.php$/', '', $file);
        	if ($file != '.' && $file != '..') {
        		$this->load->config('cms_config/lang/'.$file);
        		$this->language = array_merge($this->language, $this->config->item('lang'));
        	}
        }
		
		if ($this->db->database == '') {
	        ###########################################################
	        # Install if database doesn't exist
	        ###########################################################
			redirect( my_url( 'index.php/install/index' ) );
		} else {
	        ###########################################################
	        # Load models
	        ###########################################################
			$this->load->database('default');
			$this->load->model('__cms_user', 'user');
			$this->load->model('__cms_module', 'module_model');
			$this->load->model('__cms_holiday', 'holiday');
			$this->load->model('__cms_log', 'log');
			$this->load->model('__cms_quality_question', 'quality_question');

			$this->load->model('__frontend_dashboard_model', 'dashboard');

			$this->load->model('__action_plan_model');
			$this->load->model('__action_plan_setting_model');
			$this->load->model('__asset_track_model');
			$this->load->model('__employee_track_model');
			$this->load->model('__equipment_model');
			$this->load->model('__quality_assurance_model');
			$this->load->model('__equipment_requisition_model');
			$this->load->model('__fix_claim_model');
			$this->load->model('__ps_project_query');
			$this->load->model('__ps_projects_query');
			$this->load->model('__quotation_model');
			$this->load->model('__visitation_model');
			$this->load->model('__action_plan_model');

	        ###########################################################
	        # Load setup config
	        ###########################################################
			$this->load->config('setup');
			$this->setup_item = $this->config->item('setup');

			$this->project 			= $this->setup_item['project'];
			$this->default_lang 	= $this->project['default_lang'];
			$this->action     		= $this->setup_item['action'];
			$this->papyrus     		= $this->setup_item['papyrus'];
			$this->sap     			= $this->setup_item['sap'];
			$this->email_cfg  		= $this->setup_item['email'];
			$this->supervisor 		= $this->setup_item['super_admin'];
			$this->supervisor2 		= $this->setup_item['super_admin2'];
			$this->avoid_permission = $this->setup_item['avoid_permission'];
        	$this->language_list 	= $this->setup_item['language'];

        	$threshold_obj = $this->__ps_project_query->getObj('cms_actionplan');
        	if (empty($threshold_obj) || (!empty($threshold_obj) && ($threshold_obj['is_auto'] == 1 || $threshold_obj['threshold'] == 0))) {
				$this->threshold = $this->setup_item['project']['threshold'];
        	} else {
        		$day = strval($threshold_obj['threshold']);
        		if (strlen($day) == 1) {
        			$day = '0'.$day;
        		}
        		$this->threshold = date('Y-m').'-'.$day;
        	}

	        ###########################################################
	        # Load wsap object
	        ###########################################################
			$wsapObj = $this->session->userdata('wsapObj');
			$filename = CFGPATH."cms_config".DS."wsap".DS."object.php";

			if (file_exists($filename)) {
				$this->load->library('wsap');
				$wsapObj = file_get_contents($filename);
				$this->wsap = unserialize($wsapObj);
			} else {
				$obj = $this->login_sap();
	        	file_put_contents($filename, serialize($obj));
			}
		}

	}//end constructor;

	function _padZero ($text, $length) {
		return str_pad($text, $length, '0', STR_PAD_LEFT);
	}

    function decrypt ( $text ) {

    	$text = base64_decode($text);
    	$decrypted = "";
    	while (!empty($text)) {
    		$text = base64_decode($text);
    		$decrypted = substr($text, strlen($text)-4).$decrypted;
    		$text = substr($text, 0, strlen($text)-4);
    	}

    	$split_text = str_split($decrypted);

    	$decrypted_words = "";
		foreach ($split_text as $key => $char) {

			if ($key %2 == 0) {
				$decrypted_words .= $char;
			}
		}

    	return $decrypted_words;
    }

	function _dateFormat ( $date ) {
		return date("Ymd", strtotime($date));
	}

	function textToSAP($msg){
	  return iconv('UTF-8','TIS-620',$msg);
	 // return iconv('TIS-620','UTF-8',$msg);
	}

	function login_sap () {
		$this->load->library('wsap');

		$active     = $this->sap['active'];
		$logindata 	= $this->sap[$active];
		$this->wsap->setLoginData($logindata);
		$this->wsap->login();

		return $this->wsap;
	}

	function callSAPFunction ($function, $input=null) {

		$this->wsap->setStatus("","");
		$result = $this->wsap->callFunction($function, $input);
		// Call successfull?


		if ($this->wsap->getStatus() == SAPRFC_OK) {
			//echo '<pre>';
			//echo json_encode($result);
			//print_r($result);
			//echo '</pre>';
			return $result;
		} else { 

			$this->wsap->printStatus();
			if(strpos($this->wsap->status_infos, "No data found") >= 0) {
				return array();
			}

			$this->wsap->printStatus();
		}
	}

 	function utf8_strlen($str)
    {
      $c = strlen($str);
      $l = 0;
      for ($i = 0; $i < $c; ++$i)
      {
         if ((ord($str[$i]) & 0xC0) != 0x80)
         {
            ++$l;
         }
      }
      return $l;
    }

	function _submitSap ($quotation_id) {

		//Run submit_to_sap function; return is_submit
		$this->db->select('*');
		$this->db->where('id', $quotation_id);
		$query = $this->db->get('tbt_quotation');
		$quotation = $query->row_array();
		if (!empty($quotation)) {

			$doc_id = intval($quotation_id);	

			$quotation_header_in = array(
				"DOC_TYPE" 		=> $quotation['job_type'],
				"SALES_ORG" 	=> "1000",
				"DISTR_CHAN"	=> $quotation['distribution_channel'],
				"DIVISION" 		=> "11",
				"QT_VALID_F"	=> $this->_dateFormat(date('Y-m-d')),
				"QT_VALID_T"    => $this->_dateFormat(date('Y-m-d', strtotime('+30 days'))),
				"DOC_DATE"		=> $this->_dateFormat(date('Y-m-d'))
				// "QT_VALID_F" 	=> $this->_dateFormat(date('Y-m-d'))
				// "QT_VALID_T"	=> $this->_dateFormat(date('Y-m-d', strtotime('+'.$quotation['datediff'].' days')))
			);

			$partners = array();

			$partner1 = array(
				"PARTN_ROLE" => "AG",
				// "PARTN_NUMB" => "1-060.26"
				"PARTN_NUMB" => $quotation['sold_to_id']
			);
			$partner2 = array(
				"PARTN_ROLE" => "WE",
				// "PARTN_NUMB" => "1-060.25"
				"PARTN_NUMB" => $quotation['ship_to_id']
			);

			array_push($partners, $partner1);
			array_push($partners, $partner2);

			$sap_items = array();
			$sap_schedule_items = array();
			$sap_condition_items = array();

			$count = 10;	
			// Total price summary
			$this->db->where('quotation_id', $quotation_id);
			$query = $this->db->get('tbt_summary');
			$summary_data = $query->row_array();
			if (!empty($summary_data)) {

				$job_type = str_replace('QT', '', $quotation['job_type']);
				$this->db->where(array('mat_type' => 'Z012', 'mat_group' => '1250', 'account_assignment_group' => $job_type));
				$this->db->like('material_description', 'ค่าบริการทำความสะอาด');
				$query = $this->db->get('sap_tbm_material');
				$material = $query->row_array();

				$service_mat_no = '';
				if (!empty($material)) {
					$service_mat_no = $material['material_no'];	
				}

				$sap_item = array(
					'MATERIAL' => $service_mat_no, 
					'ITM_NUMBER' => $this->_padZero($count, 6)
				);
				array_push($sap_items, $sap_item);

				$sap_schedule_item = array(
					'ITM_NUMBER' => $this->_padZero($count, 6),
					'REQ_QTY'	 => 1
				);
				array_push($sap_schedule_items, $sap_schedule_item);

				$sap_condition_item = array(
					'ITM_NUMBER' => $this->_padZero($count, 6),
					'COND_TYPE'	 => 'ZPSV',
					'CURRENCY'   => 'THB'
				);
				if (!empty($summary_data['total_variant_price'])) {
					$sap_condition_item['COND_VALUE'] = $summary_data['total_variant_price'];
				} else {
					$sap_condition_item['COND_VALUE'] = $summary_data['total'];
				}
				array_push($sap_condition_items, $sap_condition_item);

				$count+=10;
			}					

			// Equipment
			$this->db->where('quotation_id', $quotation_id);
			$query = $this->db->get('tbt_equipment');
			$equipment_list = $query->result_array();
			if (!empty($equipment_list)) {
				// $count = 10;
				foreach ($equipment_list as $key => $equipment) {

					$sap_item = array(
						'MATERIAL' => $this->_padZero($equipment['material_no'], 18),
						'ITM_NUMBER' => $this->_padZero($count, 6)
					);
					if ($equipment['is_customer_request'] == 1) {

						if ($equipment['mat_type'] == 'Z013' || $equipment['mat_type'] == 'Z014') {
							$sap_item['ITEM_CATEG'] = 'ZAGC';
						}
					}
					array_push($sap_items, $sap_item);

					$sap_schedule_item = array(
						'ITM_NUMBER' => $this->_padZero($count, 6),
						'REQ_QTY'	  => $equipment['quantity']
					);
					array_push($sap_schedule_items, $sap_schedule_item);

					// $sap_condition_item = array(
					// 	'ITM_NUMBER'  => $this->_padZero($count, 6),
					// 	'COND_TYPE'	  => 'ZCSV', //ZCSV
					// 	'COND_VALUE'  => $equipment['price']
					// );
					// array_push($sap_condition_items, $sap_condition_item);
					$count+=10;
				}
			}
			
			// Other service
			$this->db->where('quotation_id', $quotation_id);
			$query = $this->db->get('tbt_other_service');
			$service_list = $query->result_array();
			if (!empty($service_list)) {
				// $count = 10;
				foreach ($service_list as $key => $service) {
					$sap_item = array(
						'MATERIAL' => $this->_padZero($service['other_service_id'], 18),
						'ITM_NUMBER' => $this->_padZero($count, 6)
					);
					array_push($sap_items, $sap_item);

					$sap_schedule_item = array(
						'ITM_NUMBER' => $this->_padZero($count, 6),
						'REQ_QTY'	  => $service['quantity']
					);
					array_push($sap_schedule_items, $sap_schedule_item);

					// $sap_condition_item = array(
					// 	'ITM_NUMBER' => $this->_padZero($count, 6),
					// 	'COND_TYPE'	  => 'ZCSV',
					// 	'COND_VALUE'	  => $service['total']
					// );
					// array_push($sap_condition_items, $sap_condition_item);
					$count+=10;
				}
			}
			
			// Staff (tbt_man_group)
			$this->db->select('position,employee_level_id, SUM(total) as total_staff');
			$this->db->where('quotation_id', $quotation_id);
			$this->db->group_by('employee_level_id');
			$query = $this->db->get('tbt_man_group');
			$level_list = $query->result_array();
			
			if (!empty($level_list)) {
				// $count = 10;
				foreach ($level_list as $key => $level) {

					// if ($level['employee_level_id'] == 'Z001') {
					// 	$material_no = '000000000000070002'; //HEAD
					// } else {
					// 	$material_no = '000000000000070001'; //EMPLOYEE
					// }

					$material_no = $level['position'];

					$sap_item = array(
						'MATERIAL' => $this->_padZero($material_no, 18),
						'ITM_NUMBER' => $this->_padZero($count, 6)
					);
					array_push($sap_items, $sap_item);

					$sap_schedule_item = array(
						'ITM_NUMBER' => $this->_padZero($count, 6),
						'REQ_QTY'	  => $level['total_staff']
					);
					array_push($sap_schedule_items, $sap_schedule_item);

					$count+=10;
				}
			}

			$count_clearjob = array();

			//Clear job equipment
			$this->db->where('quotation_id', $quotation_id);
			$query = $this->db->get('tbt_equipment_clearjob');
			$equipment_clearjob_list = $query->result_array();
			if (!empty($equipment_clearjob_list)) {
				// $count = 10;
				foreach ($equipment_clearjob_list as $key => $equipment_clearjob) {

					$frequency = $equipment_clearjob['frequency'];
					if (!array_key_exists($frequency, $count_clearjob)) {
						$count_clearjob[$frequency] = intval($frequency.'0010');
					} else {
						$count_clearjob[$frequency] += 10;
					}
					$item_cat = str_replace('160', 'ZAG', $equipment_clearjob['clear_type_id']);

					$sap_item = array(
						'MATERIAL' => $this->_padZero($equipment_clearjob['material_no'], 18),
						'ITEM_CATEG' => $item_cat,
						'ITM_NUMBER' => $this->_padZero($count_clearjob[$frequency], 6)
					);
					array_push($sap_items, $sap_item);

					$sap_schedule_item = array(
						'ITM_NUMBER' => $this->_padZero($count_clearjob[$frequency], 6),
						'REQ_QTY'	  => $equipment_clearjob['quantity']
					);
					array_push($sap_schedule_items, $sap_schedule_item);

					// $sap_condition_item = array(
					// 	'ITM_NUMBER' => $this->_padZero($count_clearjob[$frequency], 6),
					// 	'COND_TYPE'	  => 'ZCSV',
					// 	'COND_VALUE'	  => $equipment_clearjob['price']
					// );
					// array_push($sap_condition_items, $sap_condition_item);
				}
			}

			//Clear job staff
			$this->db->select('clear_job_type_id, frequency, staff');
			$this->db->where('quotation_id', $quotation_id);
			$this->db->where('staff !=', 0);
			// $this->db->group_by('clear_job_type_id');
			$query = $this->db->get('tbt_area');
			$clearjob_area_list = $query->result_array();
			if (!empty($clearjob_area_list)) {
				// $count = 10;

				$clearjob_staff_arr = array();
				foreach ($clearjob_area_list as $key => $clearjob_area) {

					if (!array_key_exists($clearjob_area['clear_job_type_id'], $clearjob_staff_arr)) {
						$clearjob_staff_arr[$clearjob_area['clear_job_type_id']] = array();
					}

					if (!array_key_exists($clearjob_area['frequency'], $clearjob_staff_arr[$clearjob_area['clear_job_type_id']])) {
						$clearjob_staff_arr[$clearjob_area['clear_job_type_id']][$clearjob_area['frequency']] = 0;
					}

					$clearjob_staff_arr[$clearjob_area['clear_job_type_id']][$clearjob_area['frequency']] += intval($clearjob_area['staff']);
				}

				if (!empty($clearjob_staff_arr)) {
					foreach ($clearjob_staff_arr as $clear_job_type_id => $frequency_val) {
						foreach ($frequency_val as $frequency => $staff) {
							$material_no = '000000000000070001'; //EMPLOYEE

							if (!array_key_exists($frequency, $count_clearjob)) {
								$count_clearjob[$frequency] = intval($frequency.'0010');
							} else {
								$count_clearjob[$frequency] += 10;
							}
							$item_cat = str_replace('160', 'ZAG', $clear_job_type_id);


							$sap_item = array(
								'MATERIAL' => $this->_padZero($material_no, 18), 
								'ITEM_CATEG' => $item_cat,
								'ITM_NUMBER' => $this->_padZero($count_clearjob[$frequency], 6)
							);
							array_push($sap_items, $sap_item);

							$sap_schedule_item = array(
								'ITM_NUMBER' => $this->_padZero($count_clearjob[$frequency], 6),
								'REQ_QTY'	  => $staff
							);
							array_push($sap_schedule_items, $sap_schedule_item);

						}					
					}
				}
			}

			$input = array(	
				array("IMPORT","SALESDOCUMENTIN", $doc_id), //1115000013
				array("IMPORT","QUOTATION_HEADER_IN", $quotation_header_in),
				array("TABLE","QUOTATION_PARTNERS", $partners),
				array("TABLE","QUOTATION_ITEMS_IN", $sap_items),
				array("TABLE","QUOTATION_SCHEDULES_IN", $sap_schedule_items),
				array("TABLE","QUOTATION_CONDITIONS_IN", $sap_condition_items),
				array("TABLE","RETURN", array())
			);

			$result = $this->callSAPFunction("BAPI_QUOTATION_CREATEFROMDATA2", $input);	
			// echo "<pre>";
			// print_r($result);
			// die();


			if (!empty($result['RETURN'])) {
				foreach ($result['RETURN'] as $key => $value) {
					if ($value['TYPE'] == "E") {						
						return $value['MESSAGE'];
					}
				}
			}

			if (empty($result)) {
				echo "<pre>";
				print_r($input);
				echo "</pre>";
				die();
			}

			$this->callSAPFunction("BAPI_TRANSACTION_COMMIT", array());

			//Replace Case
			$replace_obj = $this->__ps_project_query->getObj('tbt_quotation', array('replaced_by' => $quotation['id']));
			if (!empty($replace_obj)) {

				$ship_to_name = $replace_obj['ship_to_name1'];
				$ship_to_name1 = iconv_substr($ship_to_name, 0, 40, "UTF-8");
				$ship_to_name2 = iconv_substr($ship_to_name, 40, 40, "UTF-8");
				$ship_to_name3 = iconv_substr($ship_to_name, 80, 40, "UTF-8");
				$ship_to_name4 = iconv_substr($ship_to_name, 120, 40, "UTF-8");

				$sold_to_name = $replace_obj['sold_to_name1'];
				$sold_to_name1 = iconv_substr($sold_to_name, 0, 40, "UTF-8");
				$sold_to_name2 = iconv_substr($sold_to_name, 40, 40, "UTF-8");
				$sold_to_name3 = iconv_substr($sold_to_name, 80, 40, "UTF-8");
				$sold_to_name4 = iconv_substr($sold_to_name, 120, 40, "UTF-8");

				$old_quotation = array(
					'ID' 								=> $replace_obj['id'],
					'CONTRACT_ID' 						=> $replace_obj['contract_id'],
					'PROJECT_START' 					=> $this->_dateFormat($replace_obj['project_start']),
					'PROJECT_END' 						=> $this->_dateFormat($replace_obj['project_start']),
					'REPLACED_BY' 						=> $replace_obj['replaced_by'],
					'PREVIOUS_QUOTATION_ID' 			=> $replace_obj['previous_quotation_id'],
					'DISTRIBUTION_CHANNEL' 				=> $replace_obj['distribution_channel'],
					'TITLE' 							=> $this->textToSAP($replace_obj['title']),
					'JOB_TYPE' 							=> $replace_obj['job_type'],
					'SOLD_TO_ID' 						=> $replace_obj['sold_to_id'],
					'SHIP_TO_ID' 						=> $replace_obj['ship_to_id'],
					'PROJECT_OWNER_ID' 					=> $replace_obj['project_owner_id'],
					'COMPETITOR_ID' 					=> $replace_obj['competitor_id'],
					'ACCOUNT_GROUP' 					=> $replace_obj['account_group'],
					'IS_APPROVED' 						=> $replace_obj['is_approved'],
					'IS_SUBMIT_TO_SAP' 					=> $replace_obj['is_submit_to_sap'],
					'SUBMIT_TO_SAP_DATE' 				=> $replace_obj['submit_date_to_sap'],
					'STATUS' 							=> $replace_obj['status'],
					'LANGUAGE' 							=> $replace_obj['language'],
					'CREATE_DATE' 						=> $this->_dateFormat($replace_obj['create_date']),
					'TIME' 								=> $replace_obj['time'],
					'UNIT_TIME' 						=> $replace_obj['unit_time'],
					'IS_PROSPECT' 						=> $replace_obj['is_prospect'],
					'SHIP_TO_ADDRESS_NO' 				=> $this->textToSAP($replace_obj['ship_to_address_no']),
					'SHIP_TO_NAME1' 					=> $this->textToSAP($ship_to_name1),
					'SHIP_TO_NAME2' 					=> $this->textToSAP($ship_to_name2),
					'SHIP_TO_NAME3' 					=> $this->textToSAP($ship_to_name3),
					'SHIP_TO_NAME4' 					=> $this->textToSAP($ship_to_name4),
					'SHIP_TO_SEARCH_TERM' 				=> $this->textToSAP($replace_obj['ship_to_serach_term']),
					'SHIP_TO_DIVISION' 					=> $this->textToSAP($replace_obj['ship_to_division']),
					'SHIP_TO_ADDRESS1' 					=> $this->textToSAP($replace_obj['ship_to_address1']),
					'SHIP_TO_ADDRESS2' 					=> $this->textToSAP($replace_obj['ship_to_address2']),
					'SHIP_TO_ADDRESS3' 					=> $this->textToSAP($replace_obj['ship_to_address3']),
					'SHIP_TO_ADDRESS4' 					=> $this->textToSAP($replace_obj['ship_to_address4']),
					'SHIP_TO_DISTRICT' 					=> $this->textToSAP($replace_obj['ship_to_district']),
					'SHIP_TO_CITY' 						=> $this->textToSAP($replace_obj['ship_to_city']),
					'SHIP_TO_POSTAL_CODE' 				=> $this->textToSAP($replace_obj['ship_to_postal_code']),
					'SHIP_TO_COUNTRY' 					=> $this->textToSAP($replace_obj['ship_to_country']),
					'SHIP_TO_REGION'		 			=> $this->textToSAP($replace_obj['ship_to_region']),
					'SHIP_TO_BUSINESS_SCALE' 			=> $this->textToSAP($replace_obj['ship_to_business_scale']),
					'SHIP_TO_CUSTOMER_GROUP' 			=> $this->textToSAP($replace_obj['ship_to_customer_group']),
					'SHIP_TO_INDUSTRY' 					=> $this->textToSAP($replace_obj['ship_to_industry']),
					'SHIP_TO_DISTRIBUTETION_CHANNEL' 	=> $this->textToSAP($replace_obj['ship_distributetion_chnnel']),
					'SHIP_TO_TELEPHONE' 				=> $this->textToSAP($replace_obj['ship_to_telephone']),
					'SHIP_TO_TEL_EXT' 					=> $this->textToSAP($replace_obj['ship_to_tel_ext']),
					'SHIP_TO_MOBILE' 					=> $this->textToSAP($replace_obj['ship_to_mobile']),
					'SHIP_TO_FAX' 						=> $this->textToSAP($replace_obj['ship_to_fax']),
					'SHIP_TO_FAX_EXT' 					=> $this->textToSAP($replace_obj['ship_to_fax_ext']),
					'SHIP_TO_EMAIL' 					=> $this->textToSAP($replace_obj['ship_to_email']),
					'SOLD_TO_ADDRESS_NO' 				=> $this->textToSAP($replace_obj['sold_to_address_no']),
					'SOLD_TO_NAME1' 					=> $this->textToSAP($sold_to_name1),
					'SOLD_TO_NAME2' 					=> $this->textToSAP($sold_to_name2),
					'SOLD_TO_NAME3' 					=> $this->textToSAP($sold_to_name3),
					'SOLD_TO_NAME4' 					=> $this->textToSAP($sold_to_name4),
					'SOLD_TO_DIVISION' 					=> $this->textToSAP($replace_obj['sold_to_division']),
					'SOLD_TO_SEARCH_TERM' 				=> $this->textToSAP($replace_obj['sold_to_search_term']),
					'SOLD_TO_ADDRESS1' 					=> $this->textToSAP($replace_obj['sold_to_address1']),
					'SOLD_TO_ADDRESS2' 					=> $this->textToSAP($replace_obj['sold_to_address2']),
					'SOLD_TO_ADDRESS3' 					=> $this->textToSAP($replace_obj['sold_to_address3']),
					'SOLD_TO_ADDRESS4' 					=> $this->textToSAP($replace_obj['sold_to_address4']),
					'SOLD_TO_DISTRICT' 					=> $this->textToSAP($replace_obj['sold_to_district']),
					'SOLD_TO_CITY' 						=> $this->textToSAP($replace_obj['sold_to_city']),
					'SOLD_TO_POSTAL_CODE' 				=> $this->textToSAP($replace_obj['sold_to_postal_code']),
					'SOLD_TO_COUNTRY' 					=> $this->textToSAP($replace_obj['sold_to_country']),
					'SOLD_TO_REGION' 					=> $this->textToSAP($replace_obj['sold_to_region']),
					'SOLD_TO_BUSINESS_SCALE' 			=> $this->textToSAP($replace_obj['sold_to_business_scale']),
					'SOLD_TO_CUSTOMER_GROUP' 			=> $this->textToSAP($replace_obj['sold_to_customer_group']),
					'SOLD_TO_INDUSTRY' 					=> $this->textToSAP($replace_obj['sold_to_industry']),
					'SOLD_TO_DISTRIBUTETION_CHANNEL' 	=> $this->textToSAP($replace_obj['sold_to_distributetion_channel']),
					'SOLD_TO_TELEPHONE' 				=> $this->textToSAP($replace_obj['sold_to_telephone']),
					'SOLD_TO_TEL_EXT' 					=> $this->textToSAP($replace_obj['sold_to_tel_ext']),
					'SOLD_TO_MOBILE' 					=> $this->textToSAP($replace_obj['sold_to_mobile']),
					'SOLD_TO_FAX' 						=> $this->textToSAP($replace_obj['sold_to_fax']),
					'SOLD_TO_FAX_EXT' 					=> $this->textToSAP($replace_obj['sold_to_fax_ext']),
					'SOLD_TO_EMAIL' 					=> $this->textToSAP($replace_obj['sold_to_email']),
					'TOTAL_AREA' 						=> $replace_obj['total_area'],
					'TOTAL_STAFF_QUOTATION' 			=> $replace_obj['total_staff_quotation'],
					'TOKEN' 							=> $replace_obj['token'],
					'REQUIRED_DOC' 						=> $replace_obj['required_doc']
				);

				$old_input = array(	
					array("TABLE","IT_QUOTATION", array($old_quotation))
				);

				$result = $this->callSAPFunction("ZRFC_QUOTATION", $old_input);
				
				// echo "<pre>";
				// print_r($result);
				// echo "</pre>";

				// die();
			}

			$ship_to_name = $quotation['ship_to_name1'];
			$ship_to_name1 = iconv_substr($ship_to_name, 0, 40, "UTF-8");
			$ship_to_name2 = iconv_substr($ship_to_name, 40, 40, "UTF-8");
			$ship_to_name3 = iconv_substr($ship_to_name, 80, 40, "UTF-8");
			$ship_to_name4 = iconv_substr($ship_to_name, 120, 40, "UTF-8");

			$sold_to_name = $quotation['sold_to_name1'];
			$sold_to_name1 = iconv_substr($sold_to_name, 0, 40, "UTF-8");
			$sold_to_name2 = iconv_substr($sold_to_name, 40, 40, "UTF-8");
			$sold_to_name3 = iconv_substr($sold_to_name, 80, 40, "UTF-8");
			$sold_to_name4 = iconv_substr($sold_to_name, 120, 40, "UTF-8");
			//ZRFC_QUOTATION
			$quotation_data = array(
				'ID' 								=> $quotation['id'],
				'PREVIOUS_QUOTATION_ID' 			=> $quotation['previous_quotation_id'],
				'DISTRIBUTION_CHANNEL' 				=> $quotation['distribution_channel'],
				'TITLE' 							=> $this->textToSAP($quotation['title']),
				'JOB_TYPE' 							=> $quotation['job_type'],
				'SOLD_TO_ID' 						=> $quotation['sold_to_id'],
				'SHIP_TO_ID' 						=> $quotation['ship_to_id'],
				'PROJECT_OWNER_ID' 					=> $quotation['project_owner_id'],
				'COMPETITOR_ID' 					=> $quotation['competitor_id'],
				'ACCOUNT_GROUP' 					=> $quotation['account_group'],
				'IS_APPROVED' 						=> $quotation['is_approved'],
				'IS_SUBMIT_TO_SAP' 					=> $quotation['is_submit_to_sap'],
				'SUBMIT_TO_SAP_DATE' 				=> date('Ymd'),
				'STATUS' 							=> $quotation['status'],
				'LANGUAGE' 							=> $quotation['language'],
				'CREATE_DATE' 						=> $this->_dateFormat($quotation['create_date']),
				'TIME' 								=> $quotation['time'],
				'UNIT_TIME' 						=> $quotation['unit_time'],
				'IS_PROSPECT' 						=> $quotation['is_prospect'],
				'SHIP_TO_ADDRESS_NO' 				=> $this->textToSAP($quotation['ship_to_address_no']),
				'SHIP_TO_NAME1' 					=> $this->textToSAP($ship_to_name1),
				'SHIP_TO_NAME2' 					=> $this->textToSAP($ship_to_name2),
				'SHIP_TO_NAME3' 					=> $this->textToSAP($ship_to_name3),
				'SHIP_TO_NAME4' 					=> $this->textToSAP($ship_to_name4),
				'SHIP_TO_SEARCH_TERM' 				=> $this->textToSAP($quotation['ship_to_serach_term']),
				'SHIP_TO_DIVISION' 					=> $this->textToSAP($quotation['ship_to_division']),
				'SHIP_TO_ADDRESS1' 					=> $this->textToSAP($quotation['ship_to_address1']),
				'SHIP_TO_ADDRESS2' 					=> $this->textToSAP($quotation['ship_to_address2']),
				'SHIP_TO_ADDRESS3' 					=> $this->textToSAP($quotation['ship_to_address3']),
				'SHIP_TO_ADDRESS4' 					=> $this->textToSAP($quotation['ship_to_address4']),
				'SHIP_TO_DISTRICT' 					=> $this->textToSAP($quotation['ship_to_district']),
				'SHIP_TO_CITY' 						=> $this->textToSAP($quotation['ship_to_city']),
				'SHIP_TO_POSTAL_CODE' 				=> $this->textToSAP($quotation['ship_to_postal_code']),
				'SHIP_TO_COUNTRY' 					=> $this->textToSAP($quotation['ship_to_country']),
				'SHIP_TO_REGION'		 			=> $this->textToSAP($quotation['ship_to_region']),
				'SHIP_TO_BUSINESS_SCALE' 			=> $this->textToSAP($quotation['ship_to_business_scale']),
				'SHIP_TO_CUSTOMER_GROUP' 			=> $this->textToSAP($quotation['ship_to_customer_group']),
				'SHIP_TO_INDUSTRY' 					=> $this->textToSAP($quotation['ship_to_industry']),
				'SHIP_TO_DISTRIBUTETION_CHANNEL' 	=> $this->textToSAP($quotation['ship_distributetion_chnnel']),
				'SHIP_TO_TELEPHONE' 				=> $this->textToSAP($quotation['ship_to_telephone']),
				'SHIP_TO_TEL_EXT' 					=> $this->textToSAP($quotation['ship_to_tel_ext']),
				'SHIP_TO_MOBILE' 					=> $this->textToSAP($quotation['ship_to_mobile']),
				'SHIP_TO_FAX' 						=> $this->textToSAP($quotation['ship_to_fax']),
				'SHIP_TO_FAX_EXT' 					=> $this->textToSAP($quotation['ship_to_fax_ext']),
				'SHIP_TO_EMAIL' 					=> $this->textToSAP($quotation['ship_to_email']),
				'SOLD_TO_ADDRESS_NO' 				=> $this->textToSAP($quotation['sold_to_address_no']),
				'SOLD_TO_NAME1' 					=> $this->textToSAP($sold_to_name1),
				'SOLD_TO_NAME2' 					=> $this->textToSAP($sold_to_name2),
				'SOLD_TO_NAME3' 					=> $this->textToSAP($sold_to_name3),
				'SOLD_TO_NAME4' 					=> $this->textToSAP($sold_to_name4),
				'SOLD_TO_DIVISION' 					=> $this->textToSAP($quotation['sold_to_division']),
				'SOLD_TO_SEARCH_TERM' 				=> $this->textToSAP($quotation['sold_to_search_term']),
				'SOLD_TO_ADDRESS1' 					=> $this->textToSAP($quotation['sold_to_address1']),
				'SOLD_TO_ADDRESS2' 					=> $this->textToSAP($quotation['sold_to_address2']),
				'SOLD_TO_ADDRESS3' 					=> $this->textToSAP($quotation['sold_to_address3']),
				'SOLD_TO_ADDRESS4' 					=> $this->textToSAP($quotation['sold_to_address4']),
				'SOLD_TO_DISTRICT' 					=> $this->textToSAP($quotation['sold_to_district']),
				'SOLD_TO_CITY' 						=> $this->textToSAP($quotation['sold_to_city']),
				'SOLD_TO_POSTAL_CODE' 				=> $this->textToSAP($quotation['sold_to_postal_code']),
				'SOLD_TO_COUNTRY' 					=> $this->textToSAP($quotation['sold_to_country']),
				'SOLD_TO_REGION' 					=> $this->textToSAP($quotation['sold_to_region']),
				'SOLD_TO_BUSINESS_SCALE' 			=> $this->textToSAP($quotation['sold_to_business_scale']),
				'SOLD_TO_CUSTOMER_GROUP' 			=> $this->textToSAP($quotation['sold_to_customer_group']),
				'SOLD_TO_INDUSTRY' 					=> $this->textToSAP($quotation['sold_to_industry']),
				'SOLD_TO_DISTRIBUTETION_CHANNEL' 	=> $this->textToSAP($quotation['sold_to_distributetion_channel']),
				'SOLD_TO_TELEPHONE' 				=> $this->textToSAP($quotation['sold_to_telephone']),
				'SOLD_TO_TEL_EXT' 					=> $this->textToSAP($quotation['sold_to_tel_ext']),
				'SOLD_TO_MOBILE' 					=> $this->textToSAP($quotation['sold_to_mobile']),
				'SOLD_TO_FAX' 						=> $this->textToSAP($quotation['sold_to_fax']),
				'SOLD_TO_FAX_EXT' 					=> $this->textToSAP($quotation['sold_to_fax_ext']),
				'SOLD_TO_EMAIL' 					=> $this->textToSAP($quotation['sold_to_email']),
				'TOTAL_AREA' 						=> $quotation['total_area'],
				'TOTAL_STAFF_QUOTATION' 			=> $quotation['total_staff_quotation'],
				'TOKEN' 							=> $quotation['token'],
				'REQUIRED_DOC' 						=> $quotation['required_doc']
			);
			
			$contact_data = array();
			$contact_list = $this->__ps_project_query->getObj('tbt_contact', array('quotation_id' => $quotation_id), true);
			if (!empty($contact_list)) {
				foreach ($contact_list as $key => $contact) {
					$sap_contact = array(
						'ID'				=> $contact['id'],
						'FIRSTNAME' 		=> $this->textToSAP($contact['firstname']),
						'LASTNAME' 			=> $this->textToSAP($contact['lastname']),
						'DEPARTMENT' 		=> $contact['department'],
						'PHONE_NO' 			=> $contact['phone_no'],
						'PHONE_NO_EXT' 		=> $contact['phone_no_ext'],
						'MOBILE_NO' 		=> $contact['mobile_no'],
						'FAX' 				=> $contact['fax'],
						'FAX_EXT' 			=> $contact['fax_ext'],
						'EMAIL' 			=> $contact['email'],
						'QUOTATION_ID' 		=> $contact['quotation_id'],
						'IS_MAIN_CONTACT'	=> $contact['is_main_contact'],
						'CONTRACT_ID' 		=> $contact['contract_id']
					);	

					array_push($contact_data, $sap_contact);
				}
			}

			$area_data = array();
			$area_list = $this->__ps_project_query->getObj('tbt_area', array('quotation_id' => $quotation_id), true);
			if (!empty($area_list)) {
				foreach ($area_list as $key => $area) {
					$sap_area = array(
						'ID'						=> $area['id'],
						'TITLE' 					=> $this->textToSAP($area['title']),
						'BUILDING_ID' 				=> $area['building_id'],
						'FLOOR_ID' 					=> $area['floor_id'],
						'INDUSTRY_ROOM_ID' 			=> $area['industry_room_id'],
						'INDUSTRY_ROOM_DESCRIPTION'	=> $this->textToSAP($area['industry_room_description']),
						'TEXTURE_ID' 				=> $area['texture_id'],
						'TEXTURE_DESCRIPTION' 		=> $this->textToSAP($area['texture_description']),
						'SPACE_T' 					=> $area['space'],
						'IS_ON_CLEARJOB' 			=> $area['is_on_clearjob'],
						'FREQUENCY' 				=> $area['frequency'],
						'QUOTATION_ID'				=> $area['quotation_id'],
						'SHIP_TO_ID' 				=> $area['ship_to_id'],
						'CONTRACT_ID' 				=> $area['contract_id'],
						'STAFF' 					=> $area['staff'],
						'JOB_RATE' 					=> $area['job_rate'],
						'CLEAR_JOB_TYPE_ID' 		=> $area['clear_job_type_id'],
						'OTHER' 					=> $area['other'],
						'OTHER_VALUE' 				=> $area['other_value'],
						'TOTAL_PRICE_STAFF_CLEAR' 	=> $area['total_price_staff_clear']
					);	

					array_push($area_data, $sap_area);
				}
			}

			$equipment_clearjob_data = array();
			$equipment_clearjob_list = $this->__ps_project_query->getObj('tbt_equipment_clearjob', array('quotation_id' => $quotation_id), true);
			if (!empty($equipment_clearjob_list)) {
				foreach ($equipment_clearjob_list as $key => $equipment_clearjob) {
					$sap_equipment_clearjob = array(
						'ID'			=> $equipment_clearjob['id'],
						'QUOTATION_ID' 	=> $equipment_clearjob['quotation_id'],
						'MATERIAL_NO' 	=> $equipment_clearjob['material_no'],
						'MAT_TYPE' 		=> $equipment_clearjob['mat_type'],
						'MAT_GROUP' 	=> $equipment_clearjob['mat_group'],
						'MAT_GROUP_DES'	=> $this->textToSAP($equipment_clearjob['mat_group_des']),
						'CONTRACT_ID' 	=> $equipment_clearjob['contract_id'],
						'MATERIAL_TYPE'	=> $equipment_clearjob['material_description'],
						'QUANTITY' 		=> $equipment_clearjob['quantity'],
						'QUANTITY_UNIT' => $equipment_clearjob['quantity_unit'],
						'PRICE' 		=> $equipment_clearjob['price'],
						'TOTAL_PRICE'	=> $equipment_clearjob['total_price'],
						'CLEAR_TYPE_ID' => $equipment_clearjob['clear_type_id'],
						'FREQUENCY' 	=> $equipment_clearjob['frequency']
					);	

					array_push($equipment_clearjob_data, $sap_equipment_clearjob);
				}
			}

			$require_doc_data = array();
			$require_doc_list = $this->__ps_project_query->getObj('tbt_required_document', array('quotation_id' => $quotation_id), true);
			if (!empty($require_doc_list)) {
				foreach ($require_doc_list as $key => $require_doc) {
					$sap_require_doc = array(
						'ID'			=> $require_doc['id'],
						'QUOTATION_ID' 	=> $require_doc['quotation_id']
					);	

					array_push($require_doc_data, $sap_require_doc);
				}
			}

			$summary_data = array();
			$summary_list = $this->__ps_project_query->getObj('tbt_summary', array('quotation_id' => $quotation_id), true);
			if (!empty($summary_list)) {
				foreach ($summary_list as $key => $summary) {
					$sap_summary = array(
						'QUOTATION_ID' 						=> $summary['quotation_id'],
						'EMPLOYEE_COST' 					=> $summary['employee_cost'],
						'CLEARJOB_EMPLOYEE_COST' 			=> $summary['clearjob_employee_cost'],
						'EMPLOYEE_COST_SUM' 				=> $summary['employee_cost_sum'],
						'SOCIAL_SECURITY'					=> $summary['social_security'],
						'EQUIPMENT' 						=> $summary['equipment'],
						'EQUIPMENT_CLEARJOB' 				=> $summary['equipment_clearjob'],
						'TRANSPORTATION' 					=> $summary['transportation'],
						'INSURANCE' 						=> $summary['insurance'],
						'SUBTOTAL' 							=> $summary['subtotal'],
						'OPERATION_COST' 					=> $summary['operation_cost'],
						'TOTAL' 							=> $summary['total'],
						'MARGIN' 							=> $summary['margin'],
						'SALE_QUOTED' 						=> $summary['sale_quote'],
						'MAXIMUN_DISCOUNT' 					=> $summary['maximum_discount'],
						'FINAL_SALE_QUOTED' 				=> $summary['final_sale_quoted'],
						'OTHER_SERVICE' 					=> $summary['other_service'],
						'SALE_QUOTE_AND_OTHER_SERVICE' 		=> $summary['sale_quote_and_other_service'],
						'VAT' 								=> $summary['vat'],
						'TOTAL_VAT' 						=> $summary['total_vat'],
						'BUFFER' 							=> $summary['buffer'],
						'SUBTOTAL_BUFFER' 					=> $summary['subtotal_buffer'],
						'BOTTOM_PRICE_PER_PERSON' 			=> $summary['bottom_price_per_person'],
						'TOTAL_BOTTOM_PRICE' 				=> $summary['total_bottom_price'],
						'VARIANT_PRICE_PER_PERSON' 			=> $summary['variant_price_per_person'],
						'TOTAL_VARIANT_PRICE' 				=> $summary['total_variant_price'],
						'MPERCENT_SOCIAL_SECURITY' 			=> $summary['mpercent_social_security'],
						'MPERCENT_OPERATION' 				=> $summary['mpercent_operation'],
						'MPERCENT_MARGIN' 					=> $summary['mpercent_margin'],
						'MPERCENT_BUFFER' 					=> $summary['mpercent_buffer'],
						'MPERCENT_VAT' 						=> $summary['mpercent_vat'],
						'PERCENT_SOCIAL_SECURITY' 			=> $summary['percent_social_security'],
						'PERCENT_OPERATION' 				=> $summary['percent_operation'],
						'PERCENT_MARGIN' 					=> $summary['percent_margin'],
						'PERCENT_BUFFER' 					=> $summary['percent_buffer'],
						'PERCENT_VAT' 						=> $summary['percent_vat'],
						'EMPLOYEE_COST_PER_PERSON' 			=> $summary['employee_cost_per_person'],
						'CLEARJOB_EMPLOYEE_COST_PER_PER' 	=> $summary['clearjob_employee_cost_per_person'],
						'SOCIAL_SECURITY_PER_PERSON' 		=> $summary['social_security_per_person'],
						'EQUIPMENT_PER_PERSON' 				=> $summary['equipment_per_person'],
						'EQUIPMENT_CLEARJOB_PER_PERSON' 	=> $summary['equipment_clearjob_per_person'],
						'INSURANCE_PER_PERSON' 				=> $summary['insurance_per_person'],
						'OPERATION_COST_PER_PERSON' 		=> $summary['operation_cost_per_person'],
						'MARGIN_PER_PERSON' 				=> $summary['margin_per_person'],
						'MAXIMUM_DISCOUNT_PER_PERSON' 		=> $summary['maximum_discount_per_person'],
						'PERCENT_COMMISSION_SALE' 			=> $summary['percent_commission_sale'],
						'PERCENT_COMMISSION_ADMIN' 			=> $summary['percent_commission_admin'],
						'PERCENT_COMMISSION_LEADER' 		=> $summary['percent_commission_leader'],
						'COMMISSION_SALE' 					=> $summary['commission_sale'],
						'COMMISSION_ADMIN' 					=> $summary['commission_admin'],
						'COMMISSION_LEADER' 				=> $summary['commission_leader'],
						'REMARK' 							=> $summary['remark']
					);	

					array_push($summary_data, $sap_summary);
				}
			}

			$man_group_data = array();
			$man_group_list = $this->__ps_project_query->getObj('tbt_man_group', array('quotation_id' => $quotation_id), true);
			if (!empty($man_group_list)) {
				foreach ($man_group_list as $key => $man_group) {
					$sap_man_group = array(
						'ID'					=> $man_group['id'],
						'TITLE' 				=> $this->textToSAP($man_group['title']),
						'STAFF' 				=> $man_group['staff'],
						'QUOTATION_ID' 			=> $man_group['quotation_id'],
						'TOTAL'	 				=> $man_group['total'],
						'OVERTIME_ID' 			=> $man_group['overtime_id'],
						'OVERTIME' 				=> $man_group['overtime'],
						'INCENTIVE_ID' 			=> $man_group['incentive_id'],
						'INCENTIVE' 			=> $man_group['incentive'],
						'TRANSPORT_EXP_ID' 		=> $man_group['transport_exp_id'],
						'TRANSPORT_EXP' 		=> $man_group['transport_exp'],
						'DAILY_PAY_RATE_ID' 	=> $man_group['daily_pay_rate_id'],
						'DAILY_PAY_RATE' 		=> $man_group['daily_pay_rate'],
						'DAILY_PAY_RATE_TYPE' 	=> $man_group['daily_pay_rate_type'],
						'HOLIDAY_ID' 			=> $man_group['holiday_id'],
						'HOLIDAY' 				=> $man_group['holiday'],
						'EMPLOYEE_LEVEL_ID' 	=> $man_group['employee_level_id'],
						'BONUS_ID' 				=> $man_group['bonus_id'],
						'BONUS' 				=> $man_group['bonus'],
						'OTHER_TYPE1_ID' 		=> $man_group['other_type1_id'],
						'OTHER_TYPE2_ID' 		=> $man_group['other_type2_id'],
						'OTHER_TYPE3_ID' 		=> $man_group['other_type3_id'],
						'OTHER_TYPE4_ID' 		=> $man_group['other_type4_id'],
						'OTHER_TYPE5_ID' 		=> $man_group['other_type5_id'],
						'OTHER_TYPE6_ID' 		=> $man_group['other_type6_id'],
						'OTHER_TYPE7_ID' 		=> $man_group['other_type7_id'],
						'OTHER_TYPE8_ID' 		=> $man_group['other_type8_id'],
						'OTHER_TYPE9_ID' 		=> $man_group['other_type9_id'],
						'OTHER_TYPE10_ID' 		=> $man_group['other_type10_id'],
						'OTHER_TYPE1' 			=> $man_group['other_type1'],
						'OTHER_TYPE2' 			=> $man_group['other_type2'],
						'OTHER_TYPE3' 			=> $man_group['other_type3'],
						'OTHER_TYPE4' 			=> $man_group['other_type4'],
						'OTHER_TYPE5' 			=> $man_group['other_type5'],
						'OTHER_TYPE6' 			=> $man_group['other_type6'],
						'OTHER_TYPE7' 			=> $man_group['other_type7'],
						'OTHER_TYPE8' 			=> $man_group['other_type8'],
						'OTHER_TYPE9' 			=> $man_group['other_type9'],
						'OTHER_TYPE10' 			=> $man_group['other_type10'],
						'OTHER_TITLE' 			=> $man_group['other_title'],
						'OTHER_VALUE' 			=> $man_group['other_value'],
						'SUBTOTAL' 				=> $man_group['subtotal'],
						'WAGE' 					=> $man_group['wage'],
						'BENEFIT' 				=> $man_group['benefit'],
						'WAGE_BENEFIT' 			=> $man_group['wage_benefit'],
						'ZPOSITION' 			=> $man_group['position'],
						'UNIFORM_ID' 			=> $man_group['uniform_id'],
						'RATE_POSITION_ID' 		=> $man_group['rate_position_id'],
						'RATE_POSITION' 		=> $man_group['rate_position'],
						'SPECIAL_ID' 			=> $man_group['special_id'],
						'SPECIAL' 				=> $man_group['special'],
						'IS_AUTO_OT' 			=> $man_group['is_auto_ot'],
						'IS_AUTO_SPACIAL' 		=> $man_group['is_auto_spacial'],
						'IS_AUTO_TRANSPORT' 	=> $man_group['is_auton_transport']
					);	

					array_push($man_group_data, $sap_man_group);
				}
			}

			$other_service_data = array();
			$other_service_list = $this->__ps_project_query->getObj('tbt_other_service', array('quotation_id' => $quotation_id), true);
			if (!empty($other_service_list)) {
				foreach ($other_service_list as $key => $other_service) {
					$sap_other_service = array(
						'ID'				=> $other_service['id'],
						'QUOTATION_ID' 		=> $other_service['quotation_id'],
						'OTHER_SERVICE_ID' 	=> $other_service['other_service_id'],
						'QUANTITY' 			=> $other_service['quantity'],
						'QUANTITY_UNIT' 	=> $other_service['quantity_unit'],
						'PRICE'				=> $other_service['price'],
						'TOTAL' 			=> $other_service['total']
					);	

					array_push($other_service_data, $sap_other_service);
				}
			}

			$project_doc_data = array();
			$project_doc_list = $this->__ps_project_query->getObj('tbt_project_document', array('quotation_id' => $quotation_id), true);
			if (!empty($project_doc_list)) {
				foreach ($project_doc_list as $key => $project_doc) {
					$sap_project_doc = array(
						'ID'				=> $project_doc['id'],
						'DESCRIPTION' 		=> $this->textToSAP($project_doc['description']),
						'OWN_BY' 			=> $project_doc['own_by'],
						'IS_APPROVE'		=> $project_doc['is_approve'],
						'PATH'				=> $project_doc['path'],
						'IS_IMPORTANCE'		=> $project_doc['is_importance'],
						'QUOTATION_ID'		=> $project_doc['quotation_id'],
						'CONTRACT_ID' 		=> $project_doc['contract_id']
					);	

					array_push($project_doc_data, $sap_project_doc);
				}
			}

			$building_data = array();
			$building_list = $this->__ps_project_query->getObj('tbt_building', array('quotation_id' => $quotation_id), true);
			if (!empty($building_list)) {
				foreach ($building_list as $key => $building) {
					$sap_building = array(
						'ID' 				=> $building['id'],
						'TITLE' 			=> $this->textToSAP($building['title']),
						'SHIP_TO_ID' 		=> $building['ship_to_id'],
						'CONTRACT_ID' 		=> $building['contract_id'],
						'QUOTATION_ID' 		=> $building['quotation_id'],
						'TOTAL_BUILDING' 	=> $building['total_building']
					);	

					array_push($building_data, $sap_building);
				}
			}

			$floor_data = array();
			$floor_list = $this->__ps_project_query->getObj('tbt_floor', array('quotation_id' => $quotation_id), true);
			if (!empty($floor_list)) {
				foreach ($floor_list as $key => $floor) {
					$sap_floor = array(
						'ID'			=> $floor['id'],
						'TITLE'			=> $this->textToSAP($floor['title']),
						'BUILDING_ID'	=> $floor['building_id'],
						'SHIP_TO_ID'	=> $floor['ship_to_id'],
						'CONTRACT_ID'	=> $floor['contract_id'],
						'QUOTATION_ID'	=> $floor['quotation_id'],
						'TOTAL_FLOOR'	=> $floor['total_floor']
					);	

					array_push($floor_data, $sap_floor);
				}
			}

			$equipment_data = array();
			$equipment_list = $this->__ps_project_query->getObj('tbt_equipment', array('quotation_id' => $quotation_id), true);
			if (!empty($equipment_list)) {
				foreach ($equipment_list as $key => $equipment) {
					$sap_equipment = array(
						'ID'					=> $equipment['id'],
						'QUOTATION_ID'			=> $equipment['quotation_id'],
						'TEXTURE_ID'			=> $equipment['texture_id'],
						'MATERIAL_NO'			=> $equipment['material_no'],
						'MAT_TYPE'				=> $equipment['mat_type'],
						'MAT_GROUP'				=> $equipment['mat_group'],
						'SPACES'				=> $equipment['space'],
						'QUANTITY'				=> $equipment['quantity'],
						'QUANTITY_UNIT'			=> $equipment['quantity_unit'],
						'PRICE'					=> $equipment['price'],
						'TOTAL_PRICE'			=> $equipment['total_price'],
						'IS_CUSTOMER_REQUEST'	=> $equipment['is_customer_request']
					);	

					array_push($equipment_data, $sap_equipment);
				}
			}

			$man_subgroup_data = array();
			$man_subgroup_list = $this->__ps_project_query->getObj('tbt_man_subgroup', array('quotation_id' => $quotation_id), true);
			if (!empty($man_subgroup_list)) {
				foreach ($man_subgroup_list as $key => $man_subgroup) {
					$day = "";
					if (!empty($man_subgroup['day'])) {
				      $day_list = unserialize($man_subgroup['day']);
				      $check_type = gettype($day_list);				      
				      if($check_type=='array'){
				       foreach ($day_list as $key => $day_val) {
				        if (empty($day)) {
				         $day = $day_val;
				        } 
				        else {
				         $day .= ",".$day_val;
				        }
				       } 
				      }else{
				       $day = $day_list;
				      }
				     }

					$sap_man_subgroup = array(
						'ID'					=> $man_subgroup['id'],
						'QUOTATION_ID'			=> $man_subgroup['quotation_id'],
						'MAN_GROUP_ID'			=> $man_subgroup['man_group_id'],
						'GENDER'				=> $man_subgroup['gender'],
						'TOTAL'					=> $man_subgroup['total'],
						'DDAY'					=> $day,
						'TIME_IN'				=> str_replace(':', '', $man_subgroup['time_in']),
						'TIME_OUT'				=> str_replace(':', '', $man_subgroup['time_out']),
						'WORK_HOURS'			=> $man_subgroup['work_hours'],
						'OVERTIME_HOURS'		=> $man_subgroup['overtime_hours'],
						'WORK_DAY'				=> $man_subgroup['work_day'],
						'WORK_HOLIDAY'			=> $man_subgroup['work_holiday'],
						'CHARGE_OVERTIME'		=> $man_subgroup['charge_overtime'],
						'REMARK'				=> $man_subgroup['remark'],
						'SUBTOTAL_PER_PERSON'	=> $man_subgroup['subtotal_per_person'],
						'SUBTOTAL_PER_GROUP'	=> $man_subgroup['subtotal_per_group'],
					);	

					array_push($man_subgroup_data, $sap_man_subgroup);
				}
			}

			$attach_file_data = array();
			$attach_file_list = $this->__ps_project_query->getObj('tbt_attach_file', array('quotation_id' => $quotation_id), true);
			if (!empty($attach_file_list)) {
				foreach ($attach_file_list as $key => $attach_file) {
					$sap_attach_file = array(
						'ID'				=> $attach_file['id'],
						'QUOTATION_ID'		=> $attach_file['quotation_id'],
						'FILE_NAME' 		=> $attach_file['file_name'],
						'FILE_TYPE' 		=> $attach_file['file_type'],
						'SEQUENCE_INDEX' 	=> $attach_file['sequence_index'],
						'OBJECT_ID' 		=> $attach_file['object_id'],
						'OBJECT_TABLE' 		=> $attach_file['object_table'],
						'PATH' 				=> $attach_file['path'],
						'OWN_BY' 			=> $attach_file['own_by'],
						'CONTRACT_ID' 		=> $attach_file['contract_id']
					);	

					array_push($attach_file_data, $sap_attach_file);
				}
			}

			$input = array(	
				array("TABLE","IT_QUOTATION", array($quotation_data)),
				array("TABLE","IT_CONTACT", $contact_data),
				array("TABLE","IT_AREA", $area_data),
				array("TABLE","IT_EQUIP_C_JOB", $equipment_clearjob_data),
				array("TABLE","IT_REQUIRE_DOC", $require_doc_data),
				array("TABLE","IT_SUMMARY", $summary_data),
				array("TABLE","IT_MAN_GROUP", $man_group_data),
				array("TABLE","IT_OTHER_SERV", $other_service_data),
				array("TABLE","IT_PROJECT_DOC", $project_doc_data),
				array("TABLE","IT_BUILDING", $building_data),
				array("TABLE","IT_FLOOR", $floor_data),
				array("TABLE","IT_EQUIPMENT", $equipment_data),
				array("TABLE","IT_MAN_SUBGRP", $man_subgroup_data),
				array("TABLE","IT_ATTACH_FIL", $attach_file_data),
			);


			// echo "<pre>";
			// print_r($input);
			// echo "</pre>";

			// die();
			
			$result = $this->callSAPFunction("ZRFC_QUOTATION", $input);

			$this->db->where('id', $quotation_id);
			$this->db->update('tbt_quotation', array('is_submit_to_sap' => 1, 'submit_date_to_sap' => date('Y-m-d')));

			return 1;
		}
	}

	protected function createActionPlan ($plan_date, $module_id=0, $contract_id=0, $action_plan_id=0, $sequence=0, $title=null, $remark="", $clear_job_type_id=0, $clearjob_frequency=0, $clearjob_cat_id=0, $total_staff=0, $actual_date=null, $visitation_reason_id=0, $prospect_id=0, $contact_type='', $distribution_channel ='') {

		$emp_id = $this->session->userdata('id');
		$action_plan_threshold = $this->threshold.' 00:00:00';

		$plan_month = intval(date('m', strtotime($plan_date)));
		$plan_year 	= intval(date('Y', strtotime($plan_date)));

		$this_month = intval(date('m'));
		$this_year 	= intval(date('Y'));

		$quotation = $this->__ps_project_query->getObj('tbt_quotation', array('contract_id' => $contract_id));
		$project_start = date('m Y' , strtotime($quotation['project_start']));
		$plan_month    = date('m Y' , strtotime($plan_date));

		$status = 'unplan';
		if ( 
			($project_start == $plan_month && $action_plan_id == 0) || 
			(
				strtotime(date('Y-m-d').' 00:00:00') <= strtotime($action_plan_threshold) && 
				( 						
					($plan_year == $this_year && $plan_month > $this_month) ||
					($plan_year > $this_year)
				)
			) || 
			(
				strtotime(date('Y-m-d').' 00:00:00') > strtotime($action_plan_threshold) && 
				( 						
					($plan_year == $this_year && $plan_month > ($this_month)+1 ) ||
					($plan_year > $this_year)
				)
			)
		) {
			$status = 'plan';
		}

		if (!empty($action_plan_id)) {
			$old = $this->__ps_project_query->getObj('tbt_action_plan', array('id' => $action_plan_id));

			$module = $this->__ps_project_query->getObj('cms_module', array('id' => $old['event_category_id']));

			if (empty($module)) {
				
				$module = $this->__ps_project_query->getObj('tbm_event_category', array('id' => $module_id));
				if (!empty($module)) {
					$module['module_name'] = $module['module'];
				}
			}
			
			$contract_id = $old['contract_id'];
			$module_id = $module['id'];
			
			$old_plan_date = $old['plan_date'];

			$old_plan_month = intval(date('m', strtotime($old_plan_date)));
			$old_plan_year 	= intval(date('Y', strtotime($old_plan_date)));

			// if ( 
			// 	$old['plan_date'] == $plan_date || ($status == 'plan' && $old['status'] == 'plan')
			// ) {

			// 	if ($title == null) {
			// 		$title = $old['title'];
			// 	}
				
			// 	$update_data = array(
			// 		'title' => $title, 
			// 		'plan_date' => $plan_date, 
			// 		'remark' => $remark, 
			// 		'visitation_reason_id' => $visitation_reason_id,
			// 		'total_staff' => $total_staff,
			// 		'clear_job_category_id' => $clearjob_cat_id,
			// 		'actual_date' => $actual_date
			// 	);

			// 	$this->__ps_project_query->updateObj('tbt_action_plan', array('id' => $action_plan_id), $update_data );

			// 	$sap_update_ap = array(
			// 		'ID' 			=> $this->_padZero($action_plan_id,10),
			// 		'TITLE' 		=> iconv("UTF-8", "TIS-620",$title),
			// 		'EVENT_CATEGORY_ID' => $old['event_category_id'],
			// 		'ACTOR_ID' 		=> $old['actor_id'],
			// 		'PLAN_DATE' 	=> $this->_dateFormat($plan_date),
			// 		'REMARK1' 		=> iconv("UTF-8", "TIS-620", substr($remark, 0, 512)),
			// 		'REMARK2' 		=> iconv("UTF-8", "TIS-620", substr($remark, 512)),
			// 		'CLEAR_JOB_CATEGORY_ID' => $clearjob_cat_id,
			// 		'CLEAR_JOB_TYPE_ID' => $old['clear_job_type_id'],
			// 		'STAFF'			=> $old['staff'],
			// 		'TOTAL_STAFF'	=> $total_staff,
			// 		'STATUS' 		=> 'shift',
			// 		'QUOTATION_ID' 	=> $old['quotation_id'],
			// 		'SHIP_TO_ID' 	=> $old['ship_to_id'],
			// 		'SOLD_TO_ID' 	=> $old['sold_to_id'],
			// 		'CREATE_DATE' 	=> date('Ymd'),
			// 		'CREATE_TIME' 	=> date('His'),
			// 		'OBJECT_TABLE' 	=> $old['object_table']
			// 		//'PRE_ID'		=> $old_plan_id
			// 	);

			// 	if ($actual_date != null) {
			// 		$sap_update_ap['ACTUAL_DATE'] = $this->_dateFormat($actual_date);
			// 	}

		 //        $input = array( 
		 //            array("IMPORT","I_MODE","M"),
		 //            array("IMPORT","I_TABLE", "ZTBT_ACTION_PLAN"),
		 //            array("IMPORT","I_DATE", $this->_dateFormat($plan_date)),
		 //            array("IMPORT","I_COMMIT", "X"),
		 //            array("TABLE","IT_ZTBT_ACTION_PLAN", array($sap_update_ap))
		 //        );

			// 	//$result = $this->callSAPFunction("ZRFC_MASS_TABLE", $input);

			// 	if (!empty($module['table']) && $module['table'] != 'tbt_area') {
			// 		$this->__ps_project_query->updateObj($module['table'], array('id' => $old['object_id']), array('title' => $title));									

			// 		if ($module['table'] == 'tbt_visitation_document') {
			// 			$this->__ps_project_query->updateObj($module['table'], array('id' => $old['object_id']), array('visit_reason_id' => $visitation_reason_id, 'contact_type' => $contact_type));	
			// 		}
			// 	}

			// } else {

				$this->__ps_project_query->updateObj('tbt_action_plan', array('id' => $action_plan_id), array('status' => 'shift'));

				$sap_update_ap = array(
					'ID' 			=> $this->_padZero($action_plan_id,10),
					'TITLE' 		=> iconv("UTF-8", "TIS-620",$old['title']),
					'EVENT_CATEGORY_ID' => $old['event_category_id'],
					'ACTOR_ID' 		=> $old['actor_id'],
					'PLAN_DATE' 	=> $this->_dateFormat($old['plan_date']),
					'ACTUAL_DATE' 	=> (!empty($old['actual_date'])) ? $this->_dateFormat($old['actual_date']) : "" ,
					'REMARK1' 		=> iconv("UTF-8", "TIS-620", substr($old['remark'], 0, 512)),
					'REMARK2' 		=> iconv("UTF-8", "TIS-620", substr($old['remark'], 512)),
					'CLEAR_JOB_CATEGORY_ID' => $old['clear_job_category_id'],
					'CLEAR_JOB_TYPE_ID' => $old['clear_job_type_id'],
					'STAFF'			=> $old['staff'],
					'TOTAL_STAFF'	=> $old['total_staff'],
					'STATUS' 		=> 'shift',
					'QUOTATION_ID' 	=> $old['quotation_id'],
					'SHIP_TO_ID' 	=> $old['ship_to_id'],
					'SOLD_TO_ID' 	=> $old['sold_to_id'],
					'CREATE_DATE' 	=> date('Ymd'),
					'CREATE_TIME' 	=> date('His'),
					'OBJECT_TABLE' 	=> $old['object_table']
					//'PRE_ID'		=> $old_plan_id
				);

		        $input = array( 
		            array("IMPORT","I_MODE","M"),
		            array("IMPORT","I_TABLE", "ZTBT_ACTION_PLAN"),
		            array("IMPORT","I_DATE", $this->_dateFormat($plan_date)),
		            array("IMPORT","I_COMMIT", "X"),
		            array("TABLE","IT_ZTBT_ACTION_PLAN", array($sap_update_ap))
		        );

				$result = $this->callSAPFunction("ZRFC_MASS_TABLE", $input);

				if ($title == null) {
					$title = $old['title'];
				}

				$new_action_plan_id = 400;
				$this->db->order_by('id desc');
				$this->db->limit(1);
				$query = $this->db->get('tbt_action_plan');
				$last_action_plan = $query->row_array();
				if (!empty($last_action_plan)) {
					$new_action_plan_id = intval($last_action_plan['id'])+1;
				}

				$new_action_plan = array(
					'id'				=> $new_action_plan_id,
					'title' 		    => $title,
					'event_category_id' => $old['event_category_id'],
					'actor_id'			=> $emp_id,
					'plan_date'		 	=> $plan_date,
					'actual_date'		=> $actual_date,
					'visitation_reason_id' => $visitation_reason_id,
					'clear_job_category_id' => $clearjob_cat_id,
					'clear_job_type_id' => $old['clear_job_type_id'],
					'clearjob_frequency' => $old['clearjob_frequency'],
					'staff'			    => $old['staff'],
					'total_staff'		=> $total_staff,
					'quotation_id'	 	=> $old['quotation_id'],
					'contract_id'		=> $old['contract_id'],
					'ship_to_id'	 	=> $old['ship_to_id'],
					'sold_to_id'	 	=> $old['sold_to_id'],
					'status'			=> $status,
					'object_table'   	=> $old['object_table'],
					'object_id'			=> $old['object_id'],
					'remark'			=> $remark,
					'pre_id'			=> $action_plan_id
				);

				$old_plan_id    = $action_plan_id;
				$action_plan_id = $this->__ps_project_query->insertObj('tbt_action_plan', $new_action_plan);

				$sap_action_plan = array(
					'ID' 			=> $this->_padZero($new_action_plan_id,10),
					'TITLE' 		=> iconv("UTF-8", "TIS-620",$new_action_plan['title']),
					'EVENT_CATEGORY_ID' => $new_action_plan['event_category_id'],
					'ACTOR_ID' 		=> $new_action_plan['actor_id'],
					'PLAN_DATE' 	=> $this->_dateFormat($new_action_plan['plan_date']),
					'REMARK1' 		=> iconv("UTF-8", "TIS-620", substr($new_action_plan['remark'], 0, 512)),
					'REMARK2' 		=> iconv("UTF-8", "TIS-620", substr($new_action_plan['remark'], 512)),
					'CLEAR_JOB_CATEGORY_ID' => $new_action_plan['clear_job_category_id'],
					'CLEAR_JOB_TYPE_ID' => $new_action_plan['clear_job_type_id'],
					'STAFF'			=> $new_action_plan['staff'],
					'TOTAL_STAFF'	=> $new_action_plan['total_staff'],
					'STATUS' 		=> $new_action_plan['status'],
					'QUOTATION_ID' 	=> $new_action_plan['quotation_id'],
					'SHIP_TO_ID' 	=> $new_action_plan['ship_to_id'],
					'SOLD_TO_ID' 	=> $new_action_plan['sold_to_id'],
					'CREATE_DATE' 	=> date('Ymd'),
					'CREATE_TIME' 	=> date('His'),
					'OBJECT_TABLE' 	=> $new_action_plan['object_table']
					//'PRE_ID'		=> $old_plan_id
				);

				if ($actual_date != null) {
					$sap_action_plan['ACTUAL_DATE'] = $this->_dateFormat($actual_date);
				}

		        $input = array( 
		            array("IMPORT","I_MODE","M"),
		            array("IMPORT","I_TABLE", "ZTBT_ACTION_PLAN"),
		            array("IMPORT","I_DATE", $this->_dateFormat($plan_date)),
		            array("IMPORT","I_COMMIT", "X"),
		            array("TABLE","IT_ZTBT_ACTION_PLAN", array($sap_action_plan))
		        );

				//$result = $this->callSAPFunction("ZRFC_MASS_TABLE", $input);

				if (!empty($module['table']) && $module['table'] != 'tbt_area') {
					$this->__ps_project_query->updateObj($module['table'], array('id' => $old['object_id']), array('action_plan_id' => $action_plan_id, 'title' => $title));				
					
					if ($module['table'] == 'tbt_visitation_document') {
						$this->__ps_project_query->updateObj($module['table'], array('id' => $old['object_id']), array('visit_reason_id' => $visitation_reason_id, 'contact_type' => $contact_type));	
					}
				}
			// }
		} else {	

			if (!empty($contract_id)) {
				$project = $this->__ps_project_query->getObj('tbt_quotation', array('contract_id' => $contract_id));
			}

			if (empty($project)) {
				$project['id'] 			= 0;
				$project['contract_id'] = 0;
				$project['ship_to_id']  = 0;
				$project['sold_to_id']  = 0;
			}

			$module = $this->__ps_project_query->getObj('cms_module', array('id' => $module_id));
			if (empty($module)) {
				
				$module = $this->__ps_project_query->getObj('tbm_event_category', array('id' => $module_id));
				if (!empty($module)) {
					$module['module_name'] = $module['module'];
				}
			}

			$contract_id = $project['contract_id'];
			$module_id = $module['id'];

			if ($title == null) {
				if ($module['table'] == 'tbt_area') {

	                $this->db->select('sap_tbm_clear_type.description');
	                $this->db->where('id', $clear_job_type_id);
	                $query = $this->db->get('sap_tbm_clear_type');
	                $area_obj = $query->row_array();
					if (!empty($area_obj)) {
						$title = $area_obj['description'].' '.$clearjob_frequency.' เดือน ['.date('F Y', strtotime($plan_date)).']';
					}

				} else {
					$title = freetext($module['module_name']).' ['.date('F Y', strtotime($plan_date)).']';
				}
			}

			$action_plan_id = 400;
			$this->db->order_by('id desc');
			$this->db->limit(1);
			$query = $this->db->get('tbt_action_plan');
			$last_action_plan = $query->row_array();
			if (!empty($last_action_plan)) {
				$action_plan_id = intval($last_action_plan['id'])+1;
			}

			$action_plan = array (
				'id'				=> $action_plan_id,
				'title' 		    => $title,
				'event_category_id' => $module['id'],
				'actor_id'			=> $emp_id,
				'plan_date'		 	=> $plan_date,
				'quotation_id'	 	=> $project['id'],
				'prospect_id'	 	=> (!empty($prospect_id)) ? $prospect_id : 0,
				'contract_id'		=> $contract_id,
				'ship_to_id'	 	=> $project['ship_to_id'],
				'sold_to_id'	 	=> $project['sold_to_id'],
				'status'			=> $status,
				'remark'			=> $remark,
				'object_table'   	=> $module['table'],
				'create_date'		=> date('Y-m-d h:i:s')
			);
			$action_plan_id = $this->__ps_project_query->insertObj('tbt_action_plan', $action_plan);

			$sap_action_plan = array(
				'ID' 			=> $this->_padZero($action_plan_id, 10),
				'TITLE' 		=> iconv("UTF-8", "TIS-620",$action_plan['title']),
				'EVENT_CATEGORY_ID' => $action_plan['event_category_id'],
				'ACTOR_ID' 		=> $action_plan['actor_id'],
				'PLAN_DATE' 	=> $this->_dateFormat($action_plan['plan_date']),
				'ACTUAL_DATE' 	=> (!empty($actual_date)) ? $this->_dateFormat($actual_date) : "" ,
				'REMARK1' 		=> iconv("UTF-8", "TIS-620", substr($action_plan['remark'], 0, 512)),
				'REMARK2' 		=> iconv("UTF-8", "TIS-620", substr($action_plan['remark'], 512)),
				'STATUS' 		=> $action_plan['status'],
				'QUOTATION_ID' 	=> $action_plan['quotation_id'],
				'SHIP_TO_ID' 	=> $action_plan['ship_to_id'],
				'SOLD_TO_ID' 	=> $action_plan['sold_to_id'],
				'CREATE_DATE' 	=> date('Ymd'),
				'CREATE_TIME' 	=> date('His'),
				'OBJECT_TABLE' 	=> $action_plan['object_table']
			);

			if (!empty($module['table'])) {
				if ($module['table'] == 'tbt_visitation_document') {	

					$visit_data = array(
						'visitation_reason_id' 	=> $visitation_reason_id
					);
					$this->__ps_project_query->updateObj('tbt_action_plan', array('id' => $action_plan_id), $visit_data);

					$doc = array(
						'title' 			=> $title,
						'action_plan_id' 	=> $action_plan_id,
						'quotation_id'		=> $project['id'],
						'contract_id'       => $project['contract_id'],
						'prospect_id'		=> $prospect_id,
						'visit_reason_id'	=> $visitation_reason_id,
						'contact_type' 	    => $contact_type,
						'visitor_id'		=> $emp_id,
						'distribution_channel'		=> $distribution_channel
					);
				} else if ($module['table'] == 'tbt_quality_survey') {

                    $KPI_revision = $this->__quality_assurance_model->getQuestionRevision('tbm_quality_survey_kpi_question');
                    $customer_revision = $this->__quality_assurance_model->getQuestionRevision('tbm_quality_survey_customer_question');

					$doc = array(
						'title' 			=> $title,
						'action_plan_id' 	=> $action_plan_id,
						'site_inspector_id' => $emp_id,
						'contract_id'		=> $project['contract_id'],
						'quotation_id'		=> $project['id'],
                        'KPI_revision_id'   => $KPI_revision,
                        'customer_revision_id' => $customer_revision
 					);
                    
				} else if ($module['table'] == 'tbt_area') {

					$clearjob_obj = $this->__ps_project_query->getObj('tbt_area', array('contract_id' => $project['contract_id'], 'clear_job_type_id' => $clear_job_type_id, 'frequency' => $clearjob_frequency));
	
					if (!empty($clearjob_obj)) {

						$clearjob_data = array(
							'clearjob_frequency' => $clearjob_frequency,
							'clear_job_category_id' => $clearjob_cat_id,
							'clear_job_type_id' => $clear_job_type_id,
							'staff'			    => $clearjob_obj['staff']
						);
						$this->__ps_project_query->updateObj('tbt_action_plan', array('id' => $action_plan_id), $clearjob_data);

						$sap_action_plan['CLEAR_JOB_CATEGORY_ID'] = $clearjob_data['clear_job_category_id'];	
						$sap_action_plan['CLEAR_JOB_TYPE_ID'] = $clearjob_data['clear_job_type_id'];	
						$sap_action_plan['STAFF'] = $clearjob_data['staff'];	
					}

				}  else if ($module['table'] == 'tbt_employee_track_document') {

                    $track_revision = $this->__quality_assurance_model->getQuestionRevision('tbm_employee_track_question');
                    $satisfaction_revision = $this->__quality_assurance_model->getQuestionRevision('tbm_employee_track_satisfaction_question');

					$doc = array(
						'title' 			=> $title,
						'action_plan_id' 	=> $action_plan_id,
						'survey_officer_id' => $emp_id,
						'quotation_id'		=> $project['id'],
						'contract_id'       => $project['contract_id'],
						'ship_to_id'     	=> $project['ship_to_id'],
						'question_revision' => $track_revision,
						'satisfaction_question_revision' => $satisfaction_revision
					);

				} else {
					$doc = array(
						'title' 			=> $title,
						'action_plan_id' 	=> $action_plan_id,
						'survey_officer_id' => $emp_id,
						'quotation_id'		=> $project['id'],
						'contract_id'       => $project['contract_id'],
						'ship_to_id'     	=> $project['ship_to_id']
					);
				}		

				if ($module['table'] != 'tbt_area') {
					$doc_id = $this->__ps_project_query->insertObj($module['table'], $doc);	
					$this->__ps_project_query->updateObj('tbt_action_plan', array('id' => $action_plan_id), array('object_id' => $doc_id));

					$sap_action_plan['OBJECT_ID'] = $doc_id;					
				}

				if ($module['table'] == 'tbt_employee_track_document') {
					$this->__employee_track_model->clone_insert_employee($doc_id,$project['id'], $project['ship_to_id']);
				} else if($module['table'] == 'tbt_asset_track_document'){
					$this->__asset_track_model->clone_insert_assetrack($action_plan_id,$doc_id,$project['id'], $project['ship_to_id'],$emp_id);
				} else if ($module['table'] == 'tbt_quality_survey') {
					// $this->__quality_assurance_model->cloneArea($doc_id, $project['contract_id']);
				}
			}

	        $input = array( 
	            array("IMPORT","I_MODE","M"),
	            array("IMPORT","I_TABLE", "ZTBT_ACTION_PLAN"),
	            array("IMPORT","I_DATE", $this->_dateFormat($action_plan['plan_date'])),
	            array("IMPORT","I_COMMIT", "X"),
	            array("TABLE","IT_ZTBT_ACTION_PLAN", array($sap_action_plan))
	        );

			$result = $this->callSAPFunction("ZRFC_MASS_TABLE", $input);
		}

		if ($sequence != 0) {
			if ($clear_job_type_id != 0 && !empty($clear_job_type_id) && $clearjob_frequency != 0 && !empty($clearjob_frequency)) {
				// echo "Update HERE xxx <br>";
				// die();
				$this->__ps_project_query->updateObj('tbt_user_marked', array('contract_id' => $contract_id, 'module_id' => $module_id, 'sequence' => $sequence, 'clear_job_type_id' => $clear_job_type_id, 'frequency' => $clearjob_frequency, 'emp_id' => $emp_id), array('action_plan_id' => $action_plan_id));
			} else {
				// echo "Update HERE <br>";
				// die();
				$this->__ps_project_query->updateObj('tbt_user_marked', array('contract_id' => $contract_id, 'module_id' => $module_id, 'sequence' => $sequence, 'emp_id' => $emp_id), array('action_plan_id' => $action_plan_id));	
			}
		}
		
		// die();

		return $action_plan_id;
	}

	//internal
	protected function login ($type='', $token='') { //Web Login

		$data = $this->input->post();
		
		if ( (!empty($token) || !empty($data['short_token'])) && !empty($type)) {
			if ($type == 'tablet') {
				$data = $this->__ps_project_query->getObj('tbl_login', array('token' => $token, 'type' => $type, 'expired_datetime >=' => date('Y-m-d H:i:s')));
			} else {
				$data = $this->__ps_project_query->getObj('tbl_login', array('short_token' => $data['short_token'], 'type' => $type, 'expired_datetime >=' => date('Y-m-d H:i:s')));
			}

			if (!empty($data)) {

				$where['employee_id'] = $data['employee_id'];

                $this->db->select('tbt_user.*');
                $this->db->from('tbt_user');
                $this->db->where($where);
                $query = $this->db->get();

                $user = $query->row_array();

				// die();
                if (empty($user)) {
                    return 0;
                } else {

                	if ($type == 'tablet') {
	            		$user['token'] = $token;
                	} else {
	            		$user['token'] = $data['short_token'];
                	}

                    $this->db->select('tbt_user_position.status, tbm_position.*, tbm_department.title as dept_name, tbm_department.function as function');
                    $this->db->join('tbm_position', 'tbt_user_position.position_id = tbm_position.id');
                    $this->db->join('tbm_department', 'tbm_position.department_id = tbm_department.id');
                    // $this->db->join('tbm_group', 'tbm_position.group_id = tbm_group.id', 'left');
                    $this->db->where('tbt_user_position.employee_id', $user['employee_id']);
                    $query = $this->db->get('tbt_user_position');
                    $user['position_list'] = $query->result_array();
					// die();
                	$this->user->set_login($user);

					$department = $this->session->userdata('department');
					$group = $this->session->userdata('group');//get groupname

			        if ($this->session->userdata('current_url') != "") {
			        	$url = $this->session->userdata('current_url');
			        	redirect($url);
			        } else {
				        if ($group == 'superadmin') {
				        	// $url = '__cms_permission/user_permission';
				        	if($this->session->userdata('username') == 'admin_psgen'){
				        		$url ='__cms_permission/user_list';
				        	}else{
				        		$url ='__cms_data_manager/gps_log_list';
				        	}
				        } else {	

							$url = '__cms_permission/login';

							$this->getAuthenAll();
							$permission = $this->permission;

							if (!empty($permission)) {
									$module_key = array_keys($permission);
									$module = $this->module_model->getMainModule($id);

							        if (!empty($module)) {
							        	foreach ($module as $key => $value) {
							        		if (in_array($value['id'], $module_key) && array_key_exists('view', $permission[$value['id']]) ) {
												$url = $value['url'];
												break;
							        		}
							        	}
									} 
							} else {
			        			redirect( my_url( '__cms_permission/logout' ) );
							}
				        }
			        	redirect( my_url( $url ) );
			        }
                }

			} else {
                $msg        = 'Your token has been expired.';
                $state      = false;
                $code       = '999';
                $output     = '';

                $result = self::response($state,$code,$msg,$output); 
                echo json_encode($result);
            	return 1;
			}
		} else {

	        ###########################################################
	        # POST login data || Already logged in
	        ###########################################################
			if  (!empty($data['user_login']) && !empty($data['user_password']) || $this->session->userdata('username') != '') {
				//Check weather user allowed to use direct login or not ? 
				if(  ($data['user_login'] != $this->supervisor['username'] && $data['user_login'] != $this->supervisor2['username'])  && !empty($data['user_login']) ){//skip checking if super admin
					$iSAllow = 0;
					$isMobile = 0;
					if (!empty($data['type'])) {
						if ($data['type'] == 'tablet') {
							$iSAllow = $this->user->is_allowTabletLogin($data['user_login']);
						} else {
							$iSAllow = $this->user->is_allowMobileLogin($data['user_login']);
						}
					} else {
						$iSAllow = $this->user->is_allowDirectLogin($data['user_login']);
						$isMobile = $this->user->is_allowMobileLogin($data['user_login']);
					}

					if( intval($isMobile) == 1) { 
						$this->load->view('__cms/permission/login_mobile');
						return false;
					} else if( intval($iSAllow) != 1) {

						if ($data['type'] == 'tablet' || $data['type'] == 'mobile') {

                            $msg        = 'This user is not allow to login via '.$data['type'].'.';
                            $state      = false;
                            $code       = '999';
                            $output     = '';

				            $result = self::response($state,$code,$msg,$output); 
				            echo json_encode($result);

						} else {
							$this->load->view('__cms/permission/login');
						}
						return false;						
					}
				}


				$super_admin = false;

				if ($data['user_login'] == $this->supervisor['username'] && $data['user_password'] == $this->supervisor['password']) {
			        ###########################################################
			        # Super admin login
			        ###########################################################
					$super_admin = true;
					//print_r($this->user->superadmin_login($data));
					$user = $this->user->superadmin_login($data);	

				} else if($data['user_login'] == $this->supervisor2['username'] && $data['user_password'] == $this->supervisor2['password']){
					 ###########################################################
			        # Super admin login
			        ###########################################################
					$super_admin = true;
					$this->session->set_userdata('user_login', array());
					$this->supervisor = $this->supervisor2;
			 
					//print_r($this->user->superadmin_login($data));
					$user = $this->user->superadmin_login($data);	


				}else if ($this->session->userdata('username') == '') {
					if (is_array($data) && !array_key_exists('type', $data)) {
						$data['type'] = "direct";
						$data['lat']  = "";
						$data['lng']  = "";
					}

					$soap_data = array('username' => $data['user_login'] , 'password' => $data['user_password'], 'type' => $data['type'], 'lat' => $data['lat'], 'lng' => $data['lng'] );

					$user = $this->user->login_soap($soap_data); 

					if ($data['type'] != 'direct') {
						echo json_encode($user);
						return 1;
					}
					   
				}

				if (!empty($user) || $super_admin || $this->session->userdata('username') != '') {

					if ($this->session->userdata('username') != '') {

						$isTablet = $this->user->is_allowTabletLogin($data['user_login']);
						$isMobile = $this->user->is_allowMobileLogin($data['user_login']);

						if ($data['type'] == 'tablet' && $isTablet) {

							$token = $this->session->userdata('token');
							$login_data = $this->__ps_project_query->getObj('tbl_login', array('token' => $token, 'type' => 'tablet', 'expired_datetime >=' => date('Y-m-d H:i:s')));							

							if (!empty($login_data)) {

	                            $msg        = '';
	                            $state      = true;
	                            $code       = '000';
	                            $output     = site_url('__cms_permission/login/tablet/'.$token);

					            $result = self::response($state,$code,$msg,$output); 
					            echo json_encode($result);

					            return 1;
							} else {

								$soap_data = array('username' => $data['user_login'] , 'password' => $data['user_password'], 'type' => 'tablet', 'lat' => $data['lat'], 'lng' => $data['lng'] );

						       	$this->session->sess_destroy();
								$user = $this->user->login_soap($soap_data); 

								echo json_encode($user);
								return 1;
							}

						} else if ($data['type'] == 'mobile' && $isMobile) {

							$token = $this->session->userdata('token');
							$login_data = $this->__ps_project_query->getObj('tbl_login', array('short_token' => $token, 'type' => 'mobile', 'expired_datetime >=' => date('Y-m-d H:i:s')));							

							if (!empty($login_data)) {

	                            $msg        = '';
	                            $state      = true;
	                            $code       = '000';
	                            $output     = $token;

					            $result = self::response($state,$code,$msg,$output);
					            echo json_encode($result);

					            return 1;
							} else {

								$soap_data = array('username' => $data['user_login'] , 'password' => $data['user_password'], 'type' => 'mobile', 'lat' => $data['lat'], 'lng' => $data['lng'] );
								
						       	$this->session->sess_destroy();
								$user = $this->user->login_soap($soap_data); 

								echo json_encode($user);
								return 1;
							}
						}
					}
			        ###########################################################
			        # ALLOW ACCESS
			        ###########################################################
			        if (!empty($data['lang'])) {
				        ###########################################################
				        # Set language
				        ###########################################################
			        	$this->session->set_userdata('lang', $data['lang']);
			        } else {
				        ###########################################################
				        # Set language as default
				        ###########################################################
			        	$this->session->set_userdata('lang', $this->default_lang);
			        }

			        ###########################################################
			        # Set module
			        ###########################################################
					$department = $this->session->userdata('department');
					$group = $this->session->userdata('group');//get groupname
				    if ($group == 'superadmin') {
				        
				        if($this->session->userdata('username') == 'admin_psgen'){
				        		$url ='__cms_permission/user_list';
			        	}else{
			        		$url ='__cms_data_manager/gps_log_list';
			        	}
			       
				        redirect($url);
				    } else {

				        if ($this->session->userdata('current_url') != "") {

				        	$session_url = $this->session->userdata('current_url');
				        	$url         = "";
				        	$remind_url  = "";

							$this->getAuthen();
							$permission = $this->permission;

							if (!empty($permission)) {
									$module_key = array_keys($permission);
									$module = $this->module_model->getMainModule($id);

							        if (!empty($module)) {
				        				$count = 0;
							        	foreach ($module as $key => $value) {
							        		if (in_array($value['id'], $module_key) && array_key_exists('view', $permission[$value['id']]) ) {
									        	if ($session_url == $value['url']) {
									        		$url = $session_url;
									        		break;
									        	} else if ($count==0) {
													$remind_url = $value['url'];
									        	}

								        		$count++;
									        }
							        	}
									} 
							} else {
								redirect($session_url);
			        			//redirect( my_url( '__cms_permission/logout' ) );
							}

							if (empty($url)) {
								$url = $remind_url;
							}

				        	redirect($url);
				        } else {

							$url = '__cms_permission/login';
				
							$this->getAuthenAll();
							$permission = $this->permission;

							if (!empty($permission)) {
								$id=0;
									$module_key = array_keys($permission);
									$module = $this->module_model->getMainModule($id);

							        if (!empty($module)) {
							        	foreach ($module as $key => $value) {
							        		if (in_array($value['id'], $module_key) && array_key_exists('view', $permission[$value['id']]) ) {
												$url = $value['url'];
												break;
							        		}
							        	}
									} 
							} else {
			        			redirect( my_url( '__cms_permission/logout' ) );
							}

				        	redirect($url);
				        }
				    }


				} else {
			        ###########################################################
			        # ACCESS DENIED (redirect to login page)
			        ###########################################################	
			        redirect( site_url('__cms_permission/login') );
				}
			} else {
				if (!empty($_COOKIE['Bossup'])) {
		            ###########################################################
		            # LOGIN WITH BROWSER COOKIE
		            ###########################################################
					$user = $this->user->loginByCookie($_COOKIE['Bossup']);

					if (!empty($user) || $super_admin) {
				        ###########################################################
				        # ALLOW ACCESS
				        ###########################################################
				        if ($module == 'cms') {
				        	$url = '__cms_permission/user_permission';
				        }

			        	redirect( my_url( $url ) );
					} else {
				        ###########################################################
				        # ACCESS DENIED (redirect to login page)
				        ###########################################################	
				        redirect( site_url('__cms_permission/login') );
					}
				} else {
		            ###########################################################
		            # DISPLAY LOGIN PAGE
		            ###########################################################
		            $this->load->view('__cms/permission/login');
				}
			}			
		}
	}

	public function updateDocLog ($table, $id) {

        $session_login_id = $this->session->userdata('login_id');

        if (!empty($session_login_id)) {
        	$log = $this->__ps_project_query->getObj('tbl_login', array('id' => $session_login_id));
        	if (!empty($log)) {
        		$activity_log = unserialize($log['activity']);

        		// echo "<pre>";
        		// print_r($activity_log);
        		// echo "</pre>";

        		if (empty($activity_log)) {
        			$activity_log = array();
        		}

        		if (!array_key_exists($table, $activity_log)) {
        			$activity_log[$table] = array();
        		}

        		if (!in_array($id, $activity_log[$table])) {
        			array_push($activity_log[$table], $id);
        		}

        		// echo "<pre>";
        		// print_r($activity_log);
        		// echo "</pre>";

        		$this->__ps_project_query->updateObj('tbl_login', array('id' => $session_login_id), array('activity' => serialize($activity_log)));

        		// die();
        	}
		}
	}

	protected function app_loginWS(){

		  //Modify 10/14/2013
        $this->load->library("nusoap_lib");
        $this->webservice_url = "http://116.246.12.67:8090/web/ws_member.asmx?WSDL";
        $this->webservice_usercode = "BE";
        $this->webservice_userpass = "123";


        error_reporting(0);
        
        //Check require parameter
        $param = $this->input->post();
        $requireField = array('username','password');
        if(!self::getRequireParameter($requireField,$param))
            return self::response(false,'909','Unable to signing in : Parameter is missing',array());


        $this->nusoap_client = new nusoap_client($this->webservice_url,true);
        $this->nusoap_client->soap_defencoding = 'UTF-8';
        $this->nusoap_client->decode_utf8 = false;
        $params = array(
                   'strCallUserCode' => $this->webservice_usercode,
                   'strCallPassword' => $this->webservice_userpass,
                   'strUserName' => $param['username'],
                   'strPassword' => $param['password']
        );
        
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
                 $data = $this->nusoap_client->call(
                          'AuthenMember',
                           $params
                        );

                if ($data["AuthenMemberResult"]["Return"]["Success"]["ReturnCode"]=="0") {

                    $params = array(
                       'strCallUserCode' => $this->webservice_usercode,
                       'strCallPassword' => $this->webservice_userpass,
                       'strUserName' => $param['username']
                    );
                    $data = $this->nusoap_client->call("GetMemberInfo",$params);

                    if ($data["GetMemberInfoResult"]["WebMemberInfo"]["Member"]["ACTIVE"]<>"Y") {
                        //Not yet active
                        // $err_msg = "再次登录之前请激活触摸商城电子邮件的链接。";
                        if($this->lang == 'ch'){
                            $code = '101';
                            $err_msg = "再次登录之前请激活触摸商城电子邮件的链接。";
                        }else{
                            $code = '101';
                            $err_msg = "Please log in again before touching mall activation email links";
                        }
                        
                    } else {
                        //Create Session
                        $result[0]['id']  = $data["GetMemberInfoResult"]["WebMemberInfo"]["Member"]["ID"];
                        $result[0]['username'] = $data["GetMemberInfoResult"]["WebMemberInfo"]["Member"]["USERNAME"];
                        $result[0]['email'] = $data["GetMemberInfoResult"]["WebMemberInfo"]["Member"]["EMAIL"];
                        $result[0]['name'] = $data["GetMemberInfoResult"]["WebMemberInfo"]["Member"]["FNAME_CH"]." ".$data["GetMemberInfoResult"]["WebMemberInfo"]["Member"]["LNAME_CH"];
                        if ($data["GetMemberInfoResult"]["WebMemberInfo"]["Member"]["VIPCODE"]<>"") {
                            $result[0]['is_vip'] = 1;
                            $result[0]['vipcode'] = $data["GetMemberInfoResult"]["WebMemberInfo"]["Member"]["VIPCODE"];
                        } else {
                            $result[0]['is_vip'] = 0;
                        }


                        //Hardcode
                        $result[0]['profile_image'] = 'http://www.touchsuperbrandmall.com/touchmall/getimg.php?src=upload/member/'.$result[0]['id'].'.jpg&w=320&h=320&zc=100';

                        //mock 
                        $result[0]['membership_id']  = 0;
                        $result[0]['lastname'] = '';
                        $result[0]['gender']  = '';
                        $result[0]['tel']  = '';
                        $result[0]['mobile']  = '';
                        $result[0]['address']  = '';
                        $result[0]['created']  = '';
                        $result[0]['lastlogin']  = '';
                    }
                } else if ($data["AuthenMemberResult"]["Return"]["Success"]["ReturnCode"]=="3") {
                    $err_msg = "Please log in again before touching mall activation email links";
                } else {
                    $err_msg = 'Your password or mobile phone number is invalid';
                }       
            }
        }   
        if ($err_msg=="") {
        	$msg = "Sign In request completed";
            $state = true;
            $code = '000';
            $output = $result;
        } else {
            $state = false;
            $msg = $err_msg;
            $output = array();
        }

        return self::response($state,$code,$msg,$output);


	}//end function 

	protected function logout() {

		$cookie_val = $this->session->userdata('cookie');
        setcookie('Bossup','', 1);

        $object = 'cms_users';
        if ($this->session->userdata('super_admin')) {
        	$object = 'superadmin';
        }

   //      $unique_id = $this->session->userdata('unique_id');
   //      $filename = CFGPATH."cms_config".DS."permission".DS.$unique_id.".php";
   //      if (file_exists($filename)) {
			// unlink($filename);
   //      }

        $employee_id = $this->session->userdata('id');
        $login_id = $this->session->userdata('login_id');
        $module = $this->session->userdata('module');

        $this->__ps_project_query->updateObj('tbl_login', array('employee_id' => $employee_id, 'id' => $login_id), array('expired_datetime' => date('Y-m-d H:i:s')));
	    $this->session->sess_destroy();

        log_transaction('logout', $object,  $employee_id, 'success');

    	redirect( site_url('__cms_permission/login') );

	}

	protected function permission_check($module='') {

		$class =$this->router->class; //get current controller 
		$method =$this->router->method; //get current method 

		if 
		(
			!in_array($class, $this->avoid_permission) // where current class is not exception class  
			&& ( 
				( 
					array_key_exists($class, $this->avoid_permission) // if its a key 
					&& !empty($this->avoid_permission[$class]) // and its value is not empty
					&& !in_array($method, $this->avoid_permission[$class])   //and its value is member(Method) of class
				) || 
				( 
					!array_key_exists($class, $this->avoid_permission) // or its just a key with no member(Method)
				) 
			) 
			// && !$this->input->is_ajax_request() //make sure this is not an ajax request (exception for ajax)
		) {

			if (!$this->session->userdata('username')) {//If user wasnt logged in yet

				if (!empty($_COOKIE['Bossup'])) {//If cookies was set
				
					###########################################################
			        # REDIRECT TO LOGIN WITH COOKIE
			        ###########################################################
			        if ($module == 'cms') {
						$this->login('cms');
			        } else {
						$this->login('projects');
			        }
				} else { // If cookies information wasn't correct

			        $this->session->set_userdata('current_url', current_url());
			        $this->session->set_userdata('previous_class', $this->router->class);
			        $this->session->set_userdata('previous_method', $this->router->method);

					$callback_url = $this->session->userdata('current_url');
			        ###########################################################
			        # ACCESS DENIED (redirect to login page)
			        ###########################################################	
			        if ($module == 'cms') {
						redirect( my_url( 'cms' ) );
			        } else {
						redirect( my_url( 'projects' ) );
			        }
				}
			} else { //If user are logged in 
		
				$username       = $this->session->userdata('username');
				$group 		 	= $this->session->userdata('group');//get groupname

				// TODO: remove later
				//$this->cat_id = 1; //force cat_id tobe 1 : designing fault;
				$moduleObj = $this->module_model->getModuleByTitle($module);
				if (!empty($moduleObj)) {
					$this->cat_id = $moduleObj['id'];
				}

				$this->getAuthenAll();
				$pass = $this->getAuthen($this->cat_id, 'view');


				// echo $this->cat_id;
				// echo "<pre>";
				// print_r($this->permission);
				// echo "</pre>";
				// die();
				//if user were in different group -> all permitted group listed below
				if (
					$group == 'superadmin' || $pass
				) {
					//Then allowed to asscess
			        ###########################################################
			        # ALLOW ACCESS
			        ###########################################################
			        $this->session->set_userdata('current_url', current_url());
			        $this->session->set_userdata('previous_class', $this->router->class);
			        $this->session->set_userdata('previous_method', $this->router->method);

				} else {
			        ###########################################################
			        # ACCESS DENIED
			        ###########################################################
					redirect( my_url( '__cms_permission/access_error' ) );
				}
			}
		}
	}

	protected function getAuthenAll ($module_id=0, $action="all") {

		$position_list = $this->session->userdata('position');

		$this->permission = array();

		foreach ($position_list as $key => $pos_id) {
			$position = $this->__ps_project_query->getObj('tbm_position', array('id' => $pos_id));

			if (!empty($position['permission'])) {
				$permission = unserialize($position['permission']);	

				foreach ($permission as $module_id => $action_list) {

					if (!array_key_exists($module_id, $this->permission)) {
						$this->permission[$module_id] = array();
					}
					
					foreach ($action_list as $action_obj => $value) {
						if (!array_key_exists($action_obj, $this->permission[$module_id])) {
							$this->permission[$module_id][$action_obj] = $value;
						}
					}
				}

			}
		}			
	}

	protected function getAuthen ($module_id=0, $action="all") {

		$position_list = $this->session->userdata('position');
		// echo "<pre>";
		// print_r($position_list);
		// echo "</pre>";

		foreach ($position_list as $key => $pos_id) {
			$position = $this->__ps_project_query->getObj('tbm_position', array('id' => $pos_id));

			if (!empty($position['permission'])) {
				$permission = unserialize($position['permission']);	

				if ($action == 'all' && array_key_exists($module_id, $permission)) {
					return $permission[$module_id];					
				} else if (array_key_exists($module_id, $permission) && array_key_exists($action, $permission[$module_id])) {
					return true;
				}
			}
		}			

		return false;


	}

	protected function change_language ($lang) {
		//$lang = 'th';
		$this->session->set_userdata('lang', $lang);
		//echo "test";
	    $previous_page = $this->session->userdata('current_url');
		redirect( $previous_page );
	}

	###########################################################
    # Access denied page
    ###########################################################
	protected function access_error() {

	    $previous_page = $this->session->userdata('current_url');

		$data = array(
			'page_title' => 'access_error',
			'previous_page' => $previous_page
		);
		$this->load->view('access_error', $data);
	}

	//TODO :: implement functions 
	protected function loadCMSCfg ($mod){

		$file_path = CFGPATH . 'cms_config/cms/cms_'.$mod.'.php';
		$conf = array();
        if (!file_exists($file_path)) {
        	exit;// die('file not exist '.$file_path);
        }else{
        	require $file_path;
        }
        return $conf;
	}


	//TODO :: implement functions 
	protected function loadGAMECfg (){

		$file_path = CFGPATH . 'cms_config/cms/gamerules.php';
		$rules = array();
        if (!file_exists($file_path)) {
        	
        	exit;// die('file not exist '.$file_path);
        }else{
        	require $file_path;
        }

        // var_dump($rules);
        return $rules;
	}




	protected function loadCfg ($cat_id,$prefix=''){

		$file_path = CFGPATH . '/cms_config/'.$prefix.md5('mod_'.$cat_id).'.php';
		$conf = array();
        if (!file_exists($file_path)) {
        	return $conf;
        	exit;
        }else{
        	// echo 'file exist : '.$file_path;
        	$content = (file_get_contents($file_path));
        	/*$content = str_replace("<?php exit; ?>\n", "", file_get_contents($file_path));*/
        	
        	if(!empty($content))
        	$conf = unserialize($content);	
        }
        
        
        return $conf;
        
	}


	protected function deleteCfg($cat_id,$prefix=''){
		$file_path = CFGPATH . '/cms_config/'.$prefix.md5('mod_'.$cat_id).'.php';
        if (!file_exists($file_path)) {
        	return false;
        }else{
        	return unlink($file_path);
        }
	}

	protected function createCfg($cat_id,$data,$prefix=''){
		$file_path = CFGPATH . '/cms_config/'.$prefix.md5('mod_'.$cat_id).'.php';
		/*$data = '<?php exit; ?>\n'.$data;*/
        return file_put_contents ( $file_path , $data );
	}

	###########################################################
    # Email sending
    # Sender : array (
 	#			   "email" => "",
 	#              "name"  => ""
    #		   );
    # Receiver: array(
    #              "to"  => "", (multiple list seperated by comma)       
    #              "cc"  => "", (multiple list seperated by comma)
    #              "bcc" => ""  (multiple list seperated by comma)
    #           );
    ###########################################################
	protected function _sendEmail ( $subject,  $message, $sender, $receiver) {

		$config = $this->email_cfg;
		
		$this->load->library('email');

		$this->email->initialize($config);		
		$this->email->from($sender['email'], $sender['name'] );

		$result = "";
		if (!empty($receiver['to'])) {
			$result .= "To:".$receiver['to']."\n";
			$this->email->to( $receiver['to'] );
		}

		if (!empty($receiver['cc'])) {
			$result .= "To:".$receiver['cc']."\n";
			$this->email->cc( $receiver['cc'] );
		}

		if (!empty($receiver['bcc'])) {
			$result .= "To:".$receiver['bcc']."\n";
			$this->email->bcc( $receiver['bcc'] );
		}

		$this->email->subject( $subject );
		$this->email->message( $message );
		$this->email->send();

		log_transaction('send_email', '', '',$result, 'communication');
		//echo $this->email->print_debugger();

	}


	###########################################################
    # AES Encyption
    ###########################################################
	protected function _encrypt($text){
		$key 	          = "bossupsolutionbu";
		$iv               = "bossupsolutionbu";

		$AES              = new AES_Encryption($key, $iv, 'PKCS7');

	    $encode 		  = base64_encode($AES->encrypt($text));

	    return $encode;
	}

	###########################################################
    # AES Decyption
    ###########################################################
	protected function _decrypt($text){
		$key 	          = "bossupsolutionbu";
		$iv               = "bossupsolutionbu";

		$AES              = new AES_Encryption($key, $iv, 'PKCS7');

		$text 			  = urldecode($text);
		$encode_msg       = base64_decode($text);
		$decrypted        = $AES->decrypt($encode_msg);

		return $decrypted;
	}


	private function is_allow_directLogin($username){
		return false;
	}

	private function noise(){
		return md5(time());
	}

	private function last($msg,$len){
		return substr($msg, strlen($msg)-$len);
	}

	private function fill($msg,$len,$noise='0'){
		$msglen = strlen($msg);
		if($len < $msglen)
			return $msg;

		$noiselen = $len-$msglen;
		$noise = str_repeat($noise,$noiselen);

		return  $noise.$msg;
	}

	private function defill($msg,$noise='0'){
		$index = 0;
		while( $msg[$index]==$noise ){
			if($msg[$index]!=$noise)
				break;
			else
				$index++;
		}//
		return substr($msg, $index);
	}

	private function zip($msg1,$msg2){
		$count = strlen($msg2);
		if(strlen($msg1) != $count)
			return false;
		
		$output = '';
		while($count--){//untill zero
			$output .= $msg1[$count].$msg2[$count];
		}
		return $output;
	}

	private function unzip($msg){
		$count = strlen($msg);
		$output = array('msg1'=>'','msg2'=>'');
		while ( $count) {
			$output['msg1'] = $output['msg1'].$msg[--$count];
			$output['msg2'] = $output['msg2'].$msg[--$count];
		}
		return $output;
	}

	//Never use
	public function getUserDigest(){
		$first12 = last(md5($this->auth_config['api_key'].$this->auth_config['secret_key']),6).last($this->auth_config['api_key'],6);
		$next12 = last(noise(),6);
		
		return zip($first12,$next12);
	}

	public function validateUserDigest($digest){
		$prod = unzip($digest);
		return (
			last($prod['msg1'],6) == last($this->auth_config['api_key'],6) 
			&& 
			substr($prod, 0,5) != last(md5($this->auth_config['api_key'].$this->auth_config['secret_key']),6)
		);
	}


}//end Class
































/**
 * CodeIgniter Rest Controller
 *
 * A fully RESTful server implementation for CodeIgniter using one library, one config file and one controller.
 *
 * @package        	CodeIgniter
 * @subpackage    	Libraries
 * @category    	Libraries
 * @author        	Phil Sturgeon
 * @license         http://philsturgeon.co.uk/code/dbad-license
 * @link			https://github.com/philsturgeon/codeigniter-restserver
 * @version 		2.6.2
 */


abstract class REST_Controller extends Admin_Controller
{
	/**
	 * This defines the rest format.
	 *
	 * Must be overridden it in a controller so that it is set.
	 *
	 * @var string|null
	 */
	protected $rest_format = NULL;

	/**
	 * Defines the list of method properties such as limit, log and level
	 *
	 * @var array
	 */
	protected $methods = array();

	/**
	 * List of allowed HTTP methods
	 *
	 * @var array
	 */
	protected $allowed_http_methods = array('get', 'delete', 'post', 'put');

	/**
	 * General request data and information.
	 * Stores accept, language, body, headers, etc.
	 *
	 * @var object
	 */
	protected $request = NULL;

	/**
	 * What is gonna happen in output?
	 *
	 * @var object
	 */
	protected $response = NULL;

	/**
	 * Stores DB, keys, key level, etc
	 *
	 * @var object
	 */
	protected $rest = NULL;

	/**
	 * The arguments for the GET request method
	 *
	 * @var array
	 */
	protected $_get_args = array();

	/**
	 * The arguments for the POST request method
	 *
	 * @var array
	 */
	protected $_post_args = array();

	/**
	 * The arguments for the PUT request method
	 *
	 * @var array
	 */
	protected $_put_args = array();

	/**
	 * The arguments for the DELETE request method
	 *
	 * @var array
	 */
	protected $_delete_args = array();

	/**
	 * The arguments from GET, POST, PUT, DELETE request methods combined.
	 *
	 * @var array
	 */
	protected $_args = array();

	/**
	 * If the request is allowed based on the API key provided.
	 *
	 * @var boolean
	 */
	protected $_allow = TRUE;

	/**
	 * Determines if output compression is enabled
	 *
	 * @var boolean
	 */
	protected $_zlib_oc = FALSE;

	/**
	 * The LDAP Distinguished Name of the User post authentication
	 *
	 * @var string
	*/
	protected $_user_ldap_dn = '';

	/**
	 * List all supported methods, the first will be the default format
	 *
	 * @var array
	 */
	protected $_supported_formats = array(
		'xml' => 'application/xml',
		'json' => 'application/json',
		'jsonp' => 'application/javascript',
		'serialized' => 'application/vnd.php.serialized',
		'php' => 'text/plain',
		'html' => 'text/html',
		'csv' => 'application/csv'
	);

	/**
	 * Developers can extend this class and add a check in here.
	 */
	protected function early_checks()
	{

	}

	/**
	 * Constructor function
	 * @todo Document more please.
	 */
	public function __construct()
	{
		parent::__construct();
		$this->_zlib_oc = @ini_get('zlib.output_compression');

		// Lets grab the config and get ready to party
		$this->load->config('rest');

		// let's learn about the request
		$this->request = new stdClass();

		// Is it over SSL?
		$this->request->ssl = $this->_detect_ssl();

		// How is this request being made? POST, DELETE, GET, PUT?
		$this->request->method = $this->_detect_method();

		// Create argument container, if nonexistent
		if ( ! isset($this->{'_'.$this->request->method.'_args'}))
		{
			$this->{'_'.$this->request->method.'_args'} = array();
		}

		// Set up our GET variables
		$this->_get_args = array_merge($this->_get_args, $this->uri->ruri_to_assoc());

		$this->load->library('security');

		// This library is bundled with REST_Controller 2.5+, but will eventually be part of CodeIgniter itself
		$this->load->library('format');

		// Try to find a format for the request (means we have a request body)
		$this->request->format = $this->_detect_input_format();

		// Some Methods cant have a body
		$this->request->body = NULL;

		$this->{'_parse_' . $this->request->method}();

		// Now we know all about our request, let's try and parse the body if it exists
		if ($this->request->format and $this->request->body)
		{
			$this->request->body = $this->format->factory($this->request->body, $this->request->format)->to_array();
			// Assign payload arguments to proper method container
			$this->{'_'.$this->request->method.'_args'} = $this->request->body;
		}

		// Merge both for one mega-args variable
		$this->_args = array_merge($this->_get_args, $this->_put_args, $this->_post_args, $this->_delete_args, $this->{'_'.$this->request->method.'_args'});

		// Which format should the data be returned in?
		$this->response = new stdClass();
		$this->response->format = $this->_detect_output_format();

		// Which format should the data be returned in?
		$this->response->lang = $this->_detect_lang();

		// Developers can extend this class and add a check in here
		$this->early_checks();

		// Check if there is a specific auth type for the current class/method
		$this->auth_override = $this->_auth_override_check();

		// When there is no specific override for the current class/method, use the default auth value set in the config
		if ($this->auth_override !== TRUE)
		{
			if ($this->config->item('rest_auth') == 'basic')
			{
				$this->_prepare_basic_auth();
			}
			elseif ($this->config->item('rest_auth') == 'digest')
			{
				$this->_prepare_digest_auth();
			}
			elseif ($this->config->item('rest_ip_whitelist_enabled'))
			{
				$this->_check_whitelist_auth();
			}
		}

		$this->rest = new StdClass();
		// Load DB if its enabled
		if (config_item('rest_database_group') AND (config_item('rest_enable_keys') OR config_item('rest_enable_logging')))
		{
			$this->rest->db = $this->load->database(config_item('rest_database_group'), TRUE);
		}

		// Use whatever database is in use (isset returns false)
		elseif (@$this->db)
		{
			$this->rest->db = $this->db;
		}

		// Checking for keys? GET TO WORK!
		if (config_item('rest_enable_keys'))
		{
			$this->_allow = $this->_detect_api_key();
		}

		// only allow ajax requests
		if ( ! $this->input->is_ajax_request() AND config_item('rest_ajax_only'))
		{
			$this->response(array('status' => false, 'error' => 'Only AJAX requests are accepted.'), 505);
		}
	}

	/**
	 * Remap
	 *
	 * Requests are not made to methods directly, the request will be for
	 * an "object". This simply maps the object and method to the correct
	 * Controller method.
	 *
	 * @param string $object_called
	 * @param array $arguments The arguments passed to the controller method.
	 */
	public function _remap($object_called, $arguments)
	{
		// Should we answer if not over SSL?
		if (config_item('force_https') AND !$this->_detect_ssl())
		{
			$this->response(array('status' => false, 'error' => 'Unsupported protocol'), 403);
		}

		$pattern = '/^(.*)\.('.implode('|', array_keys($this->_supported_formats)).')$/';
		if (preg_match($pattern, $object_called, $matches))
		{
			$object_called = $matches[1];
		}

		$controller_method = $object_called.'_'.$this->request->method;

		// Do we want to log this method (if allowed by config)?
		$log_method = !(isset($this->methods[$controller_method]['log']) AND $this->methods[$controller_method]['log'] == FALSE);

		// Use keys for this method?
		$use_key = ! (isset($this->methods[$controller_method]['key']) AND $this->methods[$controller_method]['key'] == FALSE);

		// Get that useless shitty key out of here
		if (config_item('rest_enable_keys') AND $use_key AND $this->_allow === FALSE)
		{
			if (config_item('rest_enable_logging') AND $log_method)
			{
				$this->_log_request();
			}

			$this->response(array('status' => false, 'error' => 'Invalid API Key.'), 403);
		}

		// Sure it exists, but can they do anything with it?
		if ( ! method_exists($this, $controller_method))
		{
			$this->response(array('status' => false, 'error' => 'Unknown method.'), 404);
		}

		// Doing key related stuff? Can only do it if they have a key right?
		if (config_item('rest_enable_keys') AND !empty($this->rest->key))
		{
			// Check the limit
			if (config_item('rest_enable_limits') AND !$this->_check_limit($controller_method))
			{
				$this->response(array('status' => false, 'error' => 'This API key has reached the hourly limit for this method.'), 401);
			}

			// If no level is set use 0, they probably aren't using permissions
			$level = isset($this->methods[$controller_method]['level']) ? $this->methods[$controller_method]['level'] : 0;

			// If no level is set, or it is lower than/equal to the key's level
			$authorized = $level <= $this->rest->level;

			// IM TELLIN!
			if (config_item('rest_enable_logging') AND $log_method)
			{
				$this->_log_request($authorized);
			}

			// They don't have good enough perms
			$authorized OR $this->response(array('status' => false, 'error' => 'This API key does not have enough permissions.'), 401);
		}

		// No key stuff, but record that stuff is happening
		else if (config_item('rest_enable_logging') AND $log_method)
		{
			$this->_log_request($authorized = TRUE);
		}

		// And...... GO!
		$this->_fire_method(array($this, $controller_method), $arguments);
	}

	/**
	 * Fire Method
	 *
	 * Fires the designated controller method with the given arguments.
	 *
	 * @param array $method The controller method to fire
	 * @param array $args The arguments to pass to the controller method
	 */
	protected function _fire_method($method, $args)
	{
		call_user_func_array($method, $args);
	}

	/**
	 * Response
	 *
	 * Takes pure data and optionally a status code, then creates the response.
	 *
	 * @param array $data
	 * @param null|int $http_code
	 */
	public function response($data = array(), $http_code = null)
	{
		global $CFG;

		// If data is empty and not code provide, error and bail
		if (empty($data) && $http_code === null)
		{
			$http_code = 404;

			// create the output variable here in the case of $this->response(array());
			$output = NULL;
		}

		// If data is empty but http code provided, keep the output empty
		else if (empty($data) && is_numeric($http_code))
		{
			$output = NULL;
		}

		// Otherwise (if no data but 200 provided) or some data, carry on camping!
		else
		{
			// Is compression requested?
			if ($CFG->item('compress_output') === TRUE && $this->_zlib_oc == FALSE)
			{
				if (extension_loaded('zlib'))
				{
					if (isset($_SERVER['HTTP_ACCEPT_ENCODING']) AND strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') !== FALSE)
					{
						ob_start('ob_gzhandler');
					}
				}
			}

			is_numeric($http_code) OR $http_code = 200;

			// If the format method exists, call and return the output in that format
			if (method_exists($this, '_format_'.$this->response->format))
			{
				// Set the correct format header
				header('Content-Type: '.$this->_supported_formats[$this->response->format]);

				$output = $this->{'_format_'.$this->response->format}($data);
			}

			// If the format method exists, call and return the output in that format
			elseif (method_exists($this->format, 'to_'.$this->response->format))
			{
				// Set the correct format header
				header('Content-Type: '.$this->_supported_formats[$this->response->format]);

				$output = $this->format->factory($data)->{'to_'.$this->response->format}();
			}

			// Format not supported, output directly
			else
			{
				$output = $data;
			}
		}

		header('HTTP/1.1: ' . $http_code);
		header('Status: ' . $http_code);

		// If zlib.output_compression is enabled it will compress the output,
		// but it will not modify the content-length header to compensate for
		// the reduction, causing the browser to hang waiting for more data.
		// We'll just skip content-length in those cases.
		if ( ! $this->_zlib_oc && ! $CFG->item('compress_output'))
		{
			header('Content-Length: ' . strlen($output));
		}

		exit($output);
	}

	/*
	 * Detect SSL use
	 *
	 * Detect whether SSL is being used or not
	 */
	protected function _detect_ssl()
	{
    		return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on");
	}


	/*
	 * Detect input format
	 *
	 * Detect which format the HTTP Body is provided in
	 */
	protected function _detect_input_format()
	{
		if ($this->input->server('CONTENT_TYPE'))
		{
			// Check all formats against the HTTP_ACCEPT header
			foreach ($this->_supported_formats as $format => $mime)
			{
				if (strpos($match = $this->input->server('CONTENT_TYPE'), ';'))
				{
					$match = current(explode(';', $match));
				}

				if ($match == $mime)
				{
					return $format;
				}
			}
		}

		return NULL;
	}

	/**
	 * Detect format
	 *
	 * Detect which format should be used to output the data.
	 *
	 * @return string The output format.
	 */
	protected function _detect_output_format()
	{
		$pattern = '/\.('.implode('|', array_keys($this->_supported_formats)).')$/';

		// Check if a file extension is used
		if (preg_match($pattern, $this->uri->uri_string(), $matches))
		{
			return $matches[1];
		}

		// Check if a file extension is used
		elseif ($this->_get_args AND !is_array(end($this->_get_args)) AND preg_match($pattern, end($this->_get_args), $matches))
		{
			// The key of the last argument
			$last_key = end(array_keys($this->_get_args));

			// Remove the extension from arguments too
			$this->_get_args[$last_key] = preg_replace($pattern, '', $this->_get_args[$last_key]);
			$this->_args[$last_key] = preg_replace($pattern, '', $this->_args[$last_key]);

			return $matches[1];
		}

		// A format has been passed as an argument in the URL and it is supported
		if (isset($this->_get_args['format']) AND array_key_exists($this->_get_args['format'], $this->_supported_formats))
		{
			return $this->_get_args['format'];
		}

		// Otherwise, check the HTTP_ACCEPT (if it exists and we are allowed)
		if ($this->config->item('rest_ignore_http_accept') === FALSE AND $this->input->server('HTTP_ACCEPT'))
		{
			// Check all formats against the HTTP_ACCEPT header
			foreach (array_keys($this->_supported_formats) as $format)
			{
				// Has this format been requested?
				if (strpos($this->input->server('HTTP_ACCEPT'), $format) !== FALSE)
				{
					// If not HTML or XML assume its right and send it on its way
					if ($format != 'html' AND $format != 'xml')
					{

						return $format;
					}

					// HTML or XML have shown up as a match
					else
					{
						// If it is truly HTML, it wont want any XML
						if ($format == 'html' AND strpos($this->input->server('HTTP_ACCEPT'), 'xml') === FALSE)
						{
							return $format;
						}

						// If it is truly XML, it wont want any HTML
						elseif ($format == 'xml' AND strpos($this->input->server('HTTP_ACCEPT'), 'html') === FALSE)
						{
							return $format;
						}
					}
				}
			}
		} // End HTTP_ACCEPT checking

		// Well, none of that has worked! Let's see if the controller has a default
		if ( ! empty($this->rest_format))
		{
			return $this->rest_format;
		}

		// Just use the default format
		return config_item('rest_default_format');
	}

	/**
	 * Detect method
	 *
	 * Detect which HTTP method is being used
	 *
	 * @return string
	 */
	protected function _detect_method()
	{
		$method = strtolower($this->input->server('REQUEST_METHOD'));

		if ($this->config->item('enable_emulate_request'))
		{
			if ($this->input->post('_method'))
			{
				$method = strtolower($this->input->post('_method'));
			}
			elseif ($this->input->server('HTTP_X_HTTP_METHOD_OVERRIDE'))
			{
				$method = strtolower($this->input->server('HTTP_X_HTTP_METHOD_OVERRIDE'));
			}
		}

		if (in_array($method, $this->allowed_http_methods) && method_exists($this, '_parse_' . $method))
		{
			return $method;
		}

		return 'get';
	}

	/**
	 * Detect API Key
	 *
	 * See if the user has provided an API key
	 *
	 * @return boolean
	 */
	protected function _detect_api_key()
	{
		// Get the api key name variable set in the rest config file
		$api_key_variable = config_item('rest_key_name');

		// Work out the name of the SERVER entry based on config
		$key_name = 'HTTP_'.strtoupper(str_replace('-', '_', $api_key_variable));

		$this->rest->key = NULL;
		$this->rest->level = NULL;
		$this->rest->user_id = NULL;
		$this->rest->ignore_limits = FALSE;

		// Find the key from server or arguments
		if (($key = isset($this->_args[$api_key_variable]) ? $this->_args[$api_key_variable] : $this->input->server($key_name)))
		{
			if ( ! ($row = $this->rest->db->where(config_item('rest_key_column'), $key)->get(config_item('rest_keys_table'))->row()))
			{
				return FALSE;
			}

			$this->rest->key = $row->{config_item('rest_key_column')};

			isset($row->user_id) AND $this->rest->user_id = $row->user_id;
			isset($row->level) AND $this->rest->level = $row->level;
			isset($row->ignore_limits) AND $this->rest->ignore_limits = $row->ignore_limits;

			/*
			 * If "is private key" is enabled, compare the ip address with the list
			 * of valid ip addresses stored in the database.
			 */
			if(!empty($row->is_private_key))
			{
				// Check for a list of valid ip addresses
				if(isset($row->ip_addresses))
				{
					// multiple ip addresses must be separated using a comma, explode and loop
					$list_ip_addresses = explode(",", $row->ip_addresses);
					$found_address = FALSE;

					foreach($list_ip_addresses as $ip_address)
					{
						if($this->input->ip_address() == trim($ip_address))
						{
							// there is a match, set the the value to true and break out of the loop
							$found_address = TRUE;
							break;
						}
					}

					return $found_address;
				}
				else
				{
					// There should be at least one IP address for this private key.
					return FALSE;
				}
			}

			return $row;
		}

		// No key has been sent
		return FALSE;
	}

	/**
	 * Detect language(s)
	 *
	 * What language do they want it in?
	 *
	 * @return null|string The language code.
	 */
	protected function _detect_lang()
	{
		if ( ! $lang = $this->input->server('HTTP_ACCEPT_LANGUAGE'))
		{
			return NULL;
		}

		// They might have sent a few, make it an array
		if (strpos($lang, ',') !== FALSE)
		{
			$langs = explode(',', $lang);

			$return_langs = array();
			$i = 1;
			foreach ($langs as $lang)
			{
				// Remove weight and strip space
				list($lang) = explode(';', $lang);
				$return_langs[] = trim($lang);
			}

			return $return_langs;
		}

		// Nope, just return the string
		return $lang;
	}

	/**
	 * Log request
	 *
	 * Record the entry for awesomeness purposes
	 *
	 * @param boolean $authorized
	 * @return object
	 */
	protected function _log_request($authorized = FALSE)
	{
		return $this->rest->db->insert(config_item('rest_logs_table'), array(
					'uri' => $this->uri->uri_string(),
					'method' => $this->request->method,
					'params' => $this->_args ? (config_item('rest_logs_json_params') ? json_encode($this->_args) : serialize($this->_args)) : null,
					'api_key' => isset($this->rest->key) ? $this->rest->key : '',
					'ip_address' => $this->input->ip_address(),
					'time' => function_exists('now') ? now() : time(),
					'authorized' => $authorized
				));
	}

	/**
	 * Limiting requests
	 *
	 * Check if the requests are coming in a tad too fast.
	 *
	 * @param string $controller_method The method being called.
	 * @return boolean
	 */
	protected function _check_limit($controller_method)
	{
		// They are special, or it might not even have a limit
		if ( ! empty($this->rest->ignore_limits) OR !isset($this->methods[$controller_method]['limit']))
		{
			// On your way sonny-jim.
			return TRUE;
		}

		// How many times can you get to this method an hour?
		$limit = $this->methods[$controller_method]['limit'];

		// Get data on a keys usage
		$result = $this->rest->db
				->where('uri', $this->uri->uri_string())
				->where('api_key', $this->rest->key)
				->get(config_item('rest_limits_table'))
				->row();

		// No calls yet, or been an hour since they called
		if ( ! $result OR $result->hour_started < time() - (60 * 60))
		{
			// Right, set one up from scratch
			$this->rest->db->insert(config_item('rest_limits_table'), array(
				'uri' => $this->uri->uri_string(),
				'api_key' => isset($this->rest->key) ? $this->rest->key : '',
				'count' => 1,
				'hour_started' => time()
			));
		}

		// They have called within the hour, so lets update
		else
		{
			// Your luck is out, you've called too many times!
			if ($result->count >= $limit)
			{
				return FALSE;
			}

			$this->rest->db
					->where('uri', $this->uri->uri_string())
					->where('api_key', $this->rest->key)
					->set('count', 'count + 1', FALSE)
					->update(config_item('rest_limits_table'));
		}

		return TRUE;
	}

	/**
	 * Auth override check
	 *
	 * Check if there is a specific auth type set for the current class/method
	 * being called.
	 *
	 * @return boolean
	 */
	protected function _auth_override_check()
	{

		// Assign the class/method auth type override array from the config
		$this->overrides_array = $this->config->item('auth_override_class_method');

		// Check to see if the override array is even populated, otherwise return false
		if (empty($this->overrides_array))
		{
			return false;
		}

		// Check to see if there's an override value set for the current class/method being called
		if (empty($this->overrides_array[$this->router->class][$this->router->method]))
		{
			return false;
		}

		// None auth override found, prepare nothing but send back a true override flag
		if ($this->overrides_array[$this->router->class][$this->router->method] == 'none')
		{
			return true;
		}

		// Basic auth override found, prepare basic
		if ($this->overrides_array[$this->router->class][$this->router->method] == 'basic')
		{
			$this->_prepare_basic_auth();
			return true;
		}

		// Digest auth override found, prepare digest
		if ($this->overrides_array[$this->router->class][$this->router->method] == 'digest')
		{
			$this->_prepare_digest_auth();
			return true;
		}

		// Whitelist auth override found, check client's ip against config whitelist
		if ($this->overrides_array[$this->router->class][$this->router->method] == 'whitelist')
		{
			$this->_check_whitelist_auth();
			return true;
		}

		// Return false when there is an override value set but it does not match
		// 'basic', 'digest', or 'none'. (the value was misspelled)
		return false;
	}

	/**
	 * Parse GET
	 */
	protected function _parse_get()
	{
		// Grab proper GET variables
		parse_str(parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY), $get);

		// Merge both the URI segments and GET params
		$this->_get_args = array_merge($this->_get_args, $get);
	}

	/**
	 * Parse POST
	 */
	protected function _parse_post()
	{
		$this->_post_args = $_POST;

		$this->request->format and $this->request->body = file_get_contents('php://input');
	}

	/**
	 * Parse PUT
	 */
	protected function _parse_put()
	{
		// It might be a HTTP body
		if ($this->request->format)
		{
			$this->request->body = file_get_contents('php://input');
		}

		// If no file type is provided, this is probably just arguments
		else
		{
			parse_str(file_get_contents('php://input'), $this->_put_args);
		}
	}

	/**
	 * Parse DELETE
	 */
	protected function _parse_delete()
	{
		// Set up out DELETE variables (which shouldn't really exist, but sssh!)
		parse_str(file_get_contents('php://input'), $this->_delete_args);
	}

	// INPUT FUNCTION --------------------------------------------------------------

	/**
	 * Retrieve a value from the GET request arguments.
	 *
	 * @param string $key The key for the GET request argument to retrieve
	 * @param boolean $xss_clean Whether the value should be XSS cleaned or not.
	 * @return string The GET argument value.
	 */
	public function get($key = NULL, $xss_clean = TRUE)
	{
		if ($key === NULL)
		{
			return $this->_get_args;
		}

		return array_key_exists($key, $this->_get_args) ? $this->_xss_clean($this->_get_args[$key], $xss_clean) : FALSE;
	}

	/**
	 * Retrieve a value from the POST request arguments.
	 *
	 * @param string $key The key for the POST request argument to retrieve
	 * @param boolean $xss_clean Whether the value should be XSS cleaned or not.
	 * @return string The POST argument value.
	 */
	public function post($key = NULL, $xss_clean = TRUE)
	{
		if ($key === NULL)
		{
			return $this->_post_args;
		}

		return array_key_exists($key, $this->_post_args) ? $this->_xss_clean($this->_post_args[$key], $xss_clean) : FALSE;
	}

	/**
	 * Retrieve a value from the PUT request arguments.
	 *
	 * @param string $key The key for the PUT request argument to retrieve
	 * @param boolean $xss_clean Whether the value should be XSS cleaned or not.
	 * @return string The PUT argument value.
	 */
	public function put($key = NULL, $xss_clean = TRUE)
	{
		if ($key === NULL)
		{
			return $this->_put_args;
		}

		return array_key_exists($key, $this->_put_args) ? $this->_xss_clean($this->_put_args[$key], $xss_clean) : FALSE;
	}

	/**
	 * Retrieve a value from the DELETE request arguments.
	 *
	 * @param string $key The key for the DELETE request argument to retrieve
	 * @param boolean $xss_clean Whether the value should be XSS cleaned or not.
	 * @return string The DELETE argument value.
	 */
	public function delete($key = NULL, $xss_clean = TRUE)
	{
		if ($key === NULL)
		{
			return $this->_delete_args;
		}

		return array_key_exists($key, $this->_delete_args) ? $this->_xss_clean($this->_delete_args[$key], $xss_clean) : FALSE;
	}

	/**
	 * Process to protect from XSS attacks.
	 *
	 * @param string $val The input.
	 * @param boolean $process Do clean or note the input.
	 * @return string
	 */
	protected function _xss_clean($val, $process)
	{
		if (CI_VERSION < 2)
		{
			return $process ? $this->input->xss_clean($val) : $val;
		}

		return $process ? $this->security->xss_clean($val) : $val;
	}

	/**
	 * Retrieve the validation errors.
	 *
	 * @return array
	 */
	public function validation_errors()
	{
		$string = strip_tags($this->form_validation->error_string());

		return explode("\n", trim($string, "\n"));
	}

	// SECURITY FUNCTIONS ---------------------------------------------------------

	/**
	 * Perform LDAP Authentication
	 *
	 * @param string $username The username to validate
	 * @param string $password The password to validate
	 * @return boolean
	 */
	protected function _perform_ldap_auth($username = '', $password = NULL)
	{
		if (empty($username))
		{
			log_message('debug', 'LDAP Auth: failure, empty username');
			return false;
		}

		log_message('debug', 'LDAP Auth: Loading Config');

		$this->config->load('ldap.php', true);

		$ldaptimeout = $this->config->item('timeout', 'ldap');
		$ldaphost = $this->config->item('server', 'ldap');
		$ldapport = $this->config->item('port', 'ldap');
		$ldaprdn = $this->config->item('binduser', 'ldap');
		$ldappass = $this->config->item('bindpw', 'ldap');
		$ldapbasedn = $this->config->item('basedn', 'ldap');

		log_message('debug', 'LDAP Auth: Connect to ' . $ldaphost);

		$ldapconfig['authrealm'] = $this->config->item('domain', 'ldap');

		// connect to ldap server
		$ldapconn = ldap_connect($ldaphost, $ldapport);

		if ($ldapconn) {

			log_message('debug', 'Setting timeout to ' . $ldaptimeout . ' seconds');

			ldap_set_option($ldapconn, LDAP_OPT_NETWORK_TIMEOUT, $ldaptimeout);

			log_message('debug', 'LDAP Auth: Binding to ' . $ldaphost . ' with dn ' . $ldaprdn);

			// binding to ldap server
			$ldapbind = ldap_bind($ldapconn, $ldaprdn, $ldappass);

			// verify binding
			if ($ldapbind) {
				log_message('debug', 'LDAP Auth: bind successful');
			} else {
				log_message('error', 'LDAP Auth: bind unsuccessful');
				return false;
			}

		}

		// search for user
		if (($res_id = ldap_search( $ldapconn, $ldapbasedn, "uid=$username")) == false) {
			log_message('error', 'LDAP Auth: User ' . $username . ' not found in search');
			return false;
		}

		if (ldap_count_entries($ldapconn, $res_id) != 1) {
			log_message('error', 'LDAP Auth: failure, username ' . $username . 'found more than once');
			return false;
		}

		if (( $entry_id = ldap_first_entry($ldapconn, $res_id))== false) {
			log_message('error', 'LDAP Auth: failure, entry of searchresult could not be fetched');
			return false;
		}

		if (( $user_dn = ldap_get_dn($ldapconn, $entry_id)) == false) {
			log_message('error', 'LDAP Auth: failure, user-dn could not be fetched');
			return false;
		}

		// User found, could not authenticate as user
		if (($link_id = ldap_bind($ldapconn, $user_dn, $password)) == false) {
			log_message('error', 'LDAP Auth: failure, username/password did not match: ' . $user_dn);
			return false;
		}

		log_message('debug', 'LDAP Auth: Success ' . $user_dn . ' authenticated successfully');

		$this->_user_ldap_dn = $user_dn;
		ldap_close($ldapconn);
		return true;
	}

	/**
	 * Check if the user is logged in.
	 *
	 * @param string $username The user's name
	 * @param string $password The user's password
	 * @return boolean
	 */
	protected function _check_login($username = '', $password = NULL)
	{
		if (empty($username))
		{
			return FALSE;
		}

		$auth_source = strtolower($this->config->item('auth_source'));

		if ($auth_source == 'ldap')
		{
			log_message('debug', 'performing LDAP authentication for $username');
			return $this->_perform_ldap_auth($username, $password);
		}

		$valid_logins = $this->config->item('rest_valid_logins');

		if ( ! array_key_exists($username, $valid_logins))
		{
			return FALSE;
		}

		// If actually NULL (not empty string) then do not check it
		if ($password !== NULL AND $valid_logins[$username] != $password)
		{
			return FALSE;
		}

		return TRUE;
	}

	/**
	 * @todo document this.
	 */
	protected function _prepare_basic_auth()
	{
		// If whitelist is enabled it has the first chance to kick them out
		if (config_item('rest_ip_whitelist_enabled'))
		{
			$this->_check_whitelist_auth();
		}

		$username = NULL;
		$password = NULL;

		// mod_php
		if ($this->input->server('PHP_AUTH_USER'))
		{
			$username = $this->input->server('PHP_AUTH_USER');
			$password = $this->input->server('PHP_AUTH_PW');
		}

		// most other servers
		elseif ($this->input->server('HTTP_AUTHENTICATION'))
		{
			if (strpos(strtolower($this->input->server('HTTP_AUTHENTICATION')), 'basic') === 0)
			{
				list($username, $password) = explode(':', base64_decode(substr($this->input->server('HTTP_AUTHORIZATION'), 6)));
			}
		}

		if ( ! $this->_check_login($username, $password))
		{
			$this->_force_login();
		}
	}

	/**
	 * @todo Document this.
	 */
	protected function _prepare_digest_auth()
	{
		// If whitelist is enabled it has the first chance to kick them out
		if (config_item('rest_ip_whitelist_enabled'))
		{
			$this->_check_whitelist_auth();
		}

		$uniqid = uniqid(""); // Empty argument for backward compatibility
		// We need to test which server authentication variable to use
		// because the PHP ISAPI module in IIS acts different from CGI
		if ($this->input->server('PHP_AUTH_DIGEST'))
		{
			$digest_string = $this->input->server('PHP_AUTH_DIGEST');
		}
		elseif ($this->input->server('HTTP_AUTHORIZATION'))
		{
			$digest_string = $this->input->server('HTTP_AUTHORIZATION');
		}
		else
		{
			$digest_string = "";
		}

		// The $_SESSION['error_prompted'] variable is used to ask the password
		// again if none given or if the user enters wrong auth information.
		if (empty($digest_string))
		{
			$this->_force_login($uniqid);
		}

		// We need to retrieve authentication informations from the $auth_data variable
		preg_match_all('@(username|nonce|uri|nc|cnonce|qop|response)=[\'"]?([^\'",]+)@', $digest_string, $matches);
		$digest = array_combine($matches[1], $matches[2]);

		if ( ! array_key_exists('username', $digest) OR !$this->_check_login($digest['username']))
		{
			$this->_force_login($uniqid);
		}

		$valid_logins = $this->config->item('rest_valid_logins');
		$valid_pass = $valid_logins[$digest['username']];

		// This is the valid response expected
		$A1 = md5($digest['username'].':'.$this->config->item('rest_realm').':'.$valid_pass);
		$A2 = md5(strtoupper($this->request->method).':'.$digest['uri']);
		$valid_response = md5($A1.':'.$digest['nonce'].':'.$digest['nc'].':'.$digest['cnonce'].':'.$digest['qop'].':'.$A2);

		if ($digest['response'] != $valid_response)
		{
			header('HTTP/1.0 401 Unauthorized');
			header('HTTP/1.1 401 Unauthorized');
			exit;
		}
	}

	/**
	 * Check if the client's ip is in the 'rest_ip_whitelist' config
	 */
	protected function _check_whitelist_auth()
	{
		$whitelist = explode(',', config_item('rest_ip_whitelist'));

		array_push($whitelist, '127.0.0.1', '0.0.0.0');

		foreach ($whitelist AS &$ip)
		{
			$ip = trim($ip);
		}

		if ( ! in_array($this->input->ip_address(), $whitelist))
		{
			$this->response(array('status' => false, 'error' => 'Not authorized'), 401);
		}
	}

	/**
	 * @todo Document this.
	 *
	 * @param string $nonce
	 */
	protected function _force_login($nonce = '')
	{
		if ($this->config->item('rest_auth') == 'basic')
		{
			header('WWW-Authenticate: Basic realm="'.$this->config->item('rest_realm').'"');
		}
		elseif ($this->config->item('rest_auth') == 'digest')
		{
			header('WWW-Authenticate: Digest realm="'.$this->config->item('rest_realm').'", qop="auth", nonce="'.$nonce.'", opaque="'.md5($this->config->item('rest_realm')).'"');
		}

		$this->response(array('status' => false, 'error' => 'Not authorized'), 401);
	}

	/**
	 * Force it into an array
	 *
	 * @param object|array $data
	 * @return array
	 */
	protected function _force_loopable($data)
	{
		// Force it to be something useful
		if ( ! is_array($data) AND !is_object($data))
		{
			$data = (array) $data;
		}

		return $data;
	}

	// FORMATING FUNCTIONS ---------------------------------------------------------
	// Many of these have been moved to the Format class for better separation, but these methods will be checked too

	/**
	 * Encode as JSONP
	 *
	 * @param array $data The input data.
	 * @return string The JSONP data string (loadable from Javascript).
	 */
	protected function _format_jsonp($data = array())
	{
		return $this->get('callback').'('.json_encode($data).')';
	}

}//end class











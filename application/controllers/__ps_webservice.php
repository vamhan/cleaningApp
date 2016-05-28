<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class __ps_webservice extends REST_Controller {

	function __construct(){
		parent::__construct();

	}//end constructor;


	function test_get(){
		$param = $this->get();
		$x = array('test'=>'google','param'=>$param);
		$this->response($x,200);
	}
	//Call from SAP
	//OUTPUT XML	
	function sap_update_quotation_get () {

		$param = $this->get();

		if (!empty($param['quotation_id'])) {

			$this->db->where('id', $param['quotation_id']);
			$query = $this->db->get('tbt_quotation');
			$quotation = $query->row_array();

			if (!empty($quotation)) {

				$data = array();

				if (!empty($param['sold_to_id'])) {
					$data['sold_to_id'] = $param['sold_to_id'];
				}

				if (!empty($param['ship_to_id'])) {
					$data['ship_to_id'] = $param['ship_to_id'];
				}

				if (!empty($param['contract_id'])) {
					$data['contract_id'] = $param['contract_id'];
					$data['is_go_live']  = 1;
				}

				if (!empty($param['project_start'])) {
					$data['project_start'] = $param['project_start'];
				}
				
				if (!empty($param['project_end'])) {
					$data['project_end'] = $param['project_end'];
				}

				$this->db->where('id', $param['quotation_id']);
				$this->db->update('tbt_quotation', $data);

				if (!empty($param['contract_id'])) {

					$this->db->where('quotation_id', $param['quotation_id']);
					$this->db->update('tbt_area', array('contract_id' => $param['contract_id']));

					$this->db->where('quotation_id', $param['quotation_id']);
					$this->db->update('tbt_floor', array('contract_id' => $param['contract_id']));

					$this->db->where('quotation_id', $param['quotation_id']);
					$this->db->update('tbt_building', array('contract_id' => $param['contract_id']));

					$this->_generateHrFile($param['quotation_id']);
				}
				//XML OUTPUT
				$x = array('quotaion_id'=>$param['quotation_id'], 'status' => 'S', 'message'=> 'Update Quotation Successfully');
				$this->response($x,200);

			} else {
				//XML OUTPUT
				$x = array('quotaion_id'=>$param['quotation_id'], 'status' => 'E', 'message'=> 'Quotation ID is not found.');
				$this->response($x,999);
			}

		} else {
			//XML OUTPUT
			$x = array('quotaion_id'=>$param['quotation_id'], 'status' => 'E', 'message'=> 'Quotation ID is required.');
			$this->response($x,999);
		}
	}

	function get_hr_quotation_file_get($quotation_id){
		$this->_generateHrFile($quotation_id);
	}

	private function _generateHrFile ($quotation_id) {
		$pstatus = array('status'=>1, 'message'=>'Completed');

		try {
			if (!empty($quotation_id)) {
			#Initial Program
				$output = $this->project['hr_path'];
				$day_map 		= array('SUN', 'MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT', 'HOL');
				$day_map_th 	= array('อา', 'จ', 'อ', 'พ', 'พฤ', 'ศ', 'ส', 'นักขัติ');
				$address1='';
				$address2='';
				$postal_code = "";
				$total_man = 0;
				$time_in = 0;
				$time_out = 0;

				$quotation 	   	= $this->__ps_project_query->getObj('tbt_quotation', array('id' => $quotation_id));
				$industry 		= $this->__ps_project_query->getObj('sap_tbm_industry', array('id' => $quotation['ship_to_industry']));
				$man_group = $this->__ps_project_query->getObj('tbt_man_group', array('quotation_id' => $quotation_id));
				$man_sub_group_list = $this->__ps_project_query->getObj('tbt_man_subgroup', array('quotation_id' => $quotation_id), true);
				// $clearjob_list = $this->__ps_project_query->getObj('tbt_area', array('quotation_id' => $quotation_id, 'frequency >'=>'0'), true);
				$this->db->select("clear_job_type_id, frequency,staff, job_rate as job_rate", false);
				$this->db->group_by("clear_job_type_id, frequency, staff");
				$clearjob_list = $this->db->get_where("tbt_area", array('quotation_id' => $quotation_id))->result_array();


				if (!empty($quotation['ship_to_address1']) || !empty($quotation['ship_to_address2']) || !empty($quotation['ship_to_address3']) || !empty($quotation['ship_to_address4'])) {
					$region = $this->db->get_where('sap_tbm_region', array('id' => $quotation['ship_to_region']))->row_array();
					$address1 = (empty($quotation['ship_to_address1'])?'':$quotation['ship_to_address1'].' ').(empty($quotation['ship_to_address2']) ? '': $quotation['ship_to_address2'].' ').(empty($quotation['ship_to_address3'])?'': $quotation['ship_to_address3'].' ').(empty($quotation['ship_to_address4'])?'':$quotation['ship_to_address4']);
					$address2 = (empty($quotation['ship_to_district'])? '': $quotation['ship_to_district'].' ').(empty($quotation['ship_to_city'])?'':$quotation['ship_to_city'].' ').(empty($region)?'': $region['title']);
					$postal_code = $quotation['ship_to_postal_code'];
				}else{
					$region = $this->db->get_where('sap_tbm_region', array('id' => $quotation['ship_to_region']))->row_array();
					$address1 = (empty($quotation['sold_to_address1'])?'': $quotation['sold_to_address1'].' ').(empty($quotation['sold_to_address2'])?'': $quotation['sold_to_address2'].' ').(empty($quotation['sold_to_address3'])?'':$quotation['sold_to_address3'].' ').(empty($quotation['sold_to_address4'])?'': $quotation['sold_to_address4']);
					$address2 = (empty($quotation['sold_to_district']) ? '' : $quotation['sold_to_district'].' ').(empty($quotation['sold_to_city']).' ').(empty($region)?'': $region['title']);
					$postal_code = $quotation['sold_to_postal_code'];
				}
				if(mb_strlen($address1, "UTF-8") > 80){
					// $address1 = substr($address1, 0, 80);
					$address1 = mb_substr($address1, 0, 80, "UTF-8"); //Fix error encodeing 
				}
				if(mb_strlen($address2, "UTF-8") > 80){
					// $address2 = substr($address2, 0, 80);
					$address2 = mb_substr($address2, 0, 80, "UTF-8");
				}				

				if (count($man_sub_group_list) > 0) {
					$man_sub_group = $man_sub_group_list[0];
					$time_in = $man_sub_group['time_in'];
					$time_out = $man_sub_group['time_out'];
				}
				
				if(!empty($quotation) && !empty($quotation['contract_id'])){
					$filename = $quotation['contract_id']."_".$quotation['id'].".txt";
					$filepath = $output."/".$filename;
					$file = fopen($filepath,"w");
					$txt = "";
					$txt .="1|";
					$txt .= $quotation['contract_id'].'|';
					$txt .= $quotation['ship_to_id'].'|';
					$txt .= $quotation['ship_to_name1'].'|';
					$txt .= $quotation['sold_to_id'].'|';
					$txt .= $quotation['total_staff_quotation'].'|';
					$txt .= $quotation['total_staff_quotation'].'|';
					$txt .= $quotation['distribution_channel'].'|';
					$txt .= str_replace('ZQT', '0000', $quotation['job_type']).'|';
					$txt .= $industry['id'].'|';
					$txt .= date('j/n/Y', strtotime($quotation['project_start'])).'|';
					$txt .= date('j/n/Y', strtotime($quotation['project_end'])).'|';
					$txt .= $time_in.'|';
					$txt .= $time_out.'|';
					$txt .= $address1.'|';
					$txt .= $address2.'|';
					$txt .= $postal_code;
					$txt .= "\r\n";

					foreach ($man_sub_group_list as $key => $man_sub_group) {
						$man_group = $this->__ps_project_query->getObj('tbt_man_group', array('quotation_id' => $quotation_id, 'id' => $man_sub_group['man_group_id']));
						$position = $this->__ps_project_query->getObj('sap_tbm_position', array('id' => $man_group['position']));
						
						$day_code = array('0','0','0','0','0','0','0','0');
						$day_text = '';
						$day_key = '';
						$day = $man_sub_group['day'];
						if (!empty($day)) {
							$day = unserialize($day);
							if(is_array($day)){
								foreach ($day as $value) {
									$key = array_search($value, $day_map);
									$day_code[$key] = '1';

									if (empty($day_text)) {
										$day_text = $day_map[$key];
									} else {
										$day_text .= ','.$day_map[$key];
									}
								}
							}
						}
						$day_code = implode("", $day_code);					
						
						$other_arr = array();
						for ($i=1; $i <= 10 ; $i++) { 
							if (!empty($man_group['other_type'.$i.'_id'])) {
								$material_no = $man_group['other_type'.$i.'_id'];
								$mat = $this->__ps_project_query->getObj('sap_tbm_material', array('material_no' => $material_no));
								if (!empty($mat)) {
									$other_arr[$i-1]['name'] = $mat['material_description'];
									$other_arr[$i-1]['price'] = $man_group['other_type'.$i];
								}
							}
						}
						$txt .= "2|";
						$txt .= (int)$position['id'].'|';
						$txt .= ((!empty($man_group['daily_pay_rate_type']) && $man_group['daily_pay_rate_type'] == 'day') ? '1' : '2').'|';
						$txt .= $man_sub_group['time_in'].'|';
						$txt .= $man_sub_group['time_out'].'|';
						$txt .= $day_code.'|';
						$txt .= $day_text.'|';
						$txt .= $man_sub_group['total'].'|';
						$txt .= $man_sub_group['work_day'].'|';
						$txt .= $man_group['daily_pay_rate'].'|';
						$txt .= $man_group['is_auto_ot'].'|';
						$txt .= $man_sub_group['overtime_hours'].'|';
						$txt .= $man_group['overtime'].'|';
						$txt .= $man_group['is_auto_transport'].'|';
						$txt .= $man_group['transport_exp'].'|';
						$txt .= $man_group['is_auto_spacial'].'|';
						$txt .= $man_group['special'].'|';
						$txt .= '0|';// 
						$txt .= $man_group['incentive'].'|';
						$txt .= $man_group['bonus'].'|';
						$txt .= $man_group['rate_position'];

						if (!empty($other_arr)) {
							foreach ($other_arr as $key => $other) {
								if ($key < sizeof($other_arr)) {
									$txt .= "|";
								}

								$txt .= $other['price'].'|'.$other['name'];
							}
						}else{
							$txt .="|0|***";
						}

						$txt .= "\r\n";

					}
					foreach ($clearjob_list as $key => $clearjob) {
						$clearjobcode = '';
						switch ($clearjob['clear_job_type_id']) {
							case '1601':
							$clearjobcode ='ZAG1' ;
							break;
							case '1602':
							$clearjobcode ='ZAG2' ;
							break;
							case '1603':
							$clearjobcode ='ZAG3' ;
							break;
							case '1604':
							$clearjobcode ='ZAG4' ;
							break;
							case '1605':
							$clearjobcode ='ZAG5' ;
							break;
							default:
							# code...
							break;
						}
						$txt .= "3|";
						$txt .= $clearjobcode."|";
						$txt .= $clearjob['frequency']."|";
						$txt .= $clearjob['staff']."|";
						$txt .= $clearjob['job_rate'];
						$txt .= "\r\n";
					}
					$txt = iconv('UTF-8', 'UTF-8', $txt);
					fwrite($file, $txt);
					fclose($file);
					// copy to Map Drive
					$source = FCPATH. str_replace("/", "\\", $filepath);		
					$destination  = $this->config->item('interfaceSAP_path');
					$cmd = "copy /Y $source $destination";
					system($cmd, $retval);

				}else{
					$pstatus = array('status' => false, 'message'=> "Quotation not found or Contract id is empty.");	
				}
			}
		} catch (Exception $e) {
			$pstatus = array('status' => false, 'message'=> $e->getMessage());
		}


		$log_path = $this->config->item('export_hr_log');
		$txt = date('Y-m-d h:i:s')."--> "."Quotation Id:".$quotation_id." Status:".$pstatus['status']." Message:".$pstatus['message'].PHP_EOL;
		$flog = fopen($log_path, 'a');
		fwrite($flog, $txt);
		fclose($log_path);
	}

	//Call from SAP
	//OUTPUT XML
	function sap_cancel_get () {

		$param = $this->get();

		$param['type'] = (empty($param['type'])) ? "reject" : $param['type'];

		if (!empty($param['quotation_id'])) {

			$this->db->where('id', $param['quotation_id']);
			$query = $this->db->get('tbt_quotation');
			$quotation = $query->row_array();

			if (!empty($quotation)) {
				if ($param['type'] == 'reject') {
					$this->db->where('id', $param['quotation_id']);
					$this->db->update('tbt_quotation', array('status' => 'REJECT'));

					//XML OUTPUT
					$x = array('quotation_id'=>$param['quotation_id'], 'status' => 'S', 'message'=> 'Reject Quotation Successfully');
					$this->response($x,200);
				} else if ($param['type'] == 'delete') {
					$this->db->delete('tbt_quotation', array('id' => $param['quotation_id']));
					$this->db->delete('tbt_area', array('quotation_id' => $param['quotation_id']));
					$this->db->delete('tbt_floor', array('quotation_id' => $param['quotation_id']));
					$this->db->delete('tbt_building', array('quotation_id' => $param['quotation_id']));
					$this->db->delete('tbt_contact', array('quotation_id' => $param['quotation_id']));
					$this->db->delete('tbt_equipment', array('quotation_id' => $param['quotation_id']));
					$this->db->delete('tbt_equipment_clearjob', array('quotation_id' => $param['quotation_id']));
					$this->db->delete('tbt_other_service', array('quotation_id' => $param['quotation_id']));
					$this->db->delete('tbt_man_group', array('quotation_id' => $param['quotation_id']));
					$this->db->delete('tbt_man_subgroup', array('quotation_id' => $param['quotation_id']));

					//XML OUTPUT
					$x = array('quotation_id'=>$param['quotation_id'], 'status' => 'S', 'message'=> 'Delete Quotation Successfully');
					$this->response($x,200);
				}
			} else {

				//XML OUTPUT
				$x = array('quotation_id'=>$param['quotation_id'], 'status' => 'E', 'message'=> 'Quotation is not found.');
				$this->response($x,999);

			}
		} else if (!empty($param['contract_id'])) {

			$this->db->where('contract_id', $param['contract_id']);
			$query = $this->db->get('tbt_quotation');
			$quotation = $query->row_array();

			if (!empty($quotation)) {
				if ($param['type'] == 'reject') {
					$this->db->where('contract_id', $param['contract_id']);
					$this->db->update('tbt_quotation', array('status' => 'REJECT'));

					//XML OUTPUT
					$x = array('contract_id'=>$param['contract_id'], 'status' => 'S', 'message'=> 'Reject Contract Successfully');
					$this->response($x,200);
				} else if ($param['type'] == 'delete') {
					$this->db->where('contract_id', $param['contract_id']);
					$this->db->update('tbt_quotation', array('status' => 'DELETED'));

					//XML OUTPUT
					$x = array('contract_id'=>$param['contract_id'], 'status' => 'S', 'message'=> 'Delete Contract Successfully');
					$this->response($x,200);
				}
			} else {

				//XML OUTPUT
				$x = array('contract_id'=>$param['contract_id'], 'status' => 'E', 'message'=> 'Contract is not found.');
				$this->response($x,999);

			}
		} else {

			//XML OUTPUT
			$x = array('quotaion_id'=>$param['quotation_id'], 'status' => 'E', 'message'=> 'Quotation ID/Contract ID is required.');
			$this->response($x,999);

		}
	}

	function createActionPlan_get () {

		$p = $this->get();

		if (empty($p['actor_id'])) {
			//XML OUTPUT
			$x = array('action_plan_id'=>0, 'status' => 'E', 'message'=> 'Missing Actor ID');
			$this->response($x,999);
		} else if (empty($p['plan_date'])) {
			//XML OUTPUT
			$x = array('action_plan_id'=>0, 'status' => 'E', 'message'=> 'Missing Plan Date');
			$this->response($x,999);
		} else if (empty($p['event_category_id'])) {
			//XML OUTPUT
			$x = array('action_plan_id'=>0, 'status' => 'E', 'message'=> 'Missing Event Category');
			$this->response($x,999);
		} else if (empty($p['contract_id'])) {
			//XML OUTPUT
			$x = array('action_plan_id'=>0, 'status' => 'E', 'message'=> 'Missing Contract ID');
			$this->response($x,999);
		} else {
			$this->session->set_userdata('id', $p['actor_id']);
			$action_plan_id = $this->createActionPlan($p['plan_date'], $p['event_category_id'], $p['contract_id']);		

			//XML OUTPUT
			$x = array('action_plan_id'=>$action_plan_id, 'status' => 'S', 'message'=> 'Create plan Successfully');
			$this->response($x,999);
		}
	}

	function updateDateActionPlan_get () {

		$p = $this->get();
		if (empty($p['action_plan_id'])) {
			//XML OUTPUT
			$x = array('action_plan_id'=>0, 'status' => 'E', 'message'=> 'Missing Action Plan ID');
			$this->response($x,999);
		} else if (empty($p['actual_date'])) {
			//XML OUTPUT
			$x = array('action_plan_id'=>0, 'status' => 'E', 'message'=> 'Missing Actual Date');
			$this->response($x,999);
		} else {

			if (empty($p['remark'])) {
				$p['remark'] = '';
			}

			$this->__ps_project_query->updateObj('tbt_action_plan', array('id' => $p['action_plan_id']), array('actual_date' => $p['actual_date'], 'remark' => $p['remark']));

			//XML OUTPUT
			$x = array('action_plan_id'=>$p['action_plan_id'], 'status' => 'S', 'message'=> 'Update plan Successfully');
			$this->response($x,999);
		}
	}

	//__ps_webservice/updateQuotationStatus/test/1/effective
	function updateQuotationStatus_get () {		

		$param = $this->get();

		if (!empty($param['quotation_id']) && !empty($param['status'])) {

			$this->db->where('id', $param['quotation_id']);
			$query = $this->db->get('tbt_quotation');
			$quotation = $query->row_array();

			if (!empty($quotation)) {

				$status = strtoupper($param['status']);
				$this->db->where('id', $param['quotation_id']);
				$this->db->update('tbt_quotation', array('status' => $status));

				if ($status == 'EFFECTIVE') {
					$this->db->where('id', $param['quotation_id']);
					$this->db->update('tbt_quotation', array('reject_by' => ''));

					$result = $this->_submitSap($param['quotation_id']);
					if ($result != 1) {
						$x = array('quotaion_id'=>$param['quotation_id'], 'status' => 'E', 'message'=> 'Cannot Submit to SAP due to '.$result);
						$this->response($x,999);
					} else {
						//XML OUTPUT
						$x = array('quotaion_id'=>$param['quotation_id'], 'status' => 'S', 'message'=> 'Update Quotation Status to '.$status.' Successfully');
						$this->response($x,200);
					}
				} else if ($status == 'REJECT' && !empty($param['reject_by'])) {
					$this->db->where('id', $param['quotation_id']);
					$this->db->update('tbt_quotation', array('reject_by' => $param['reject_by']));
					$x = array('quotaion_id'=>$param['quotation_id'], 'status' => 'E', 'message'=> 'Reject Quotation by '.$param['reject_by']);
					$this->response($x,999);
				}

			} else {

				//XML OUTPUT
				$x = array('quotaion_id'=>$param['quotation_id'], 'status' => 'E', 'message'=> 'Quotation ID is not found.');
				$this->response($x,999);

			}

		} else {

			//XML OUTPUT
			$x = array('quotaion_id'=>$param['quotation_id'], 'status' => 'E', 'message'=> 'Quotation ID and Status are required.');
			$this->response($x,999);

		}
	}

}//endk
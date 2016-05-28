<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class __ps_action_plan_setting extends Admin_Controller {

	function __construct(){
		parent::__construct();
		$this->permission_check('action_plan');

		//TODO :: Move this to admin controller later 
		#CMS
		$this->pageSize = PAGESIZE;
		$this->table = 'tbt_quotation';
		$this->page_id = 'ps_project';
		$this->page_title = 'Action Plan Setting : PSWEB';
		$this->page_title_ico = '<i class="fa fa-cog"></i> &nbsp; ';
		$this->page_object = 'Page';
		$this->page_controller = '__ps_action_plan_setting';

		$this->defualt_backend_controller = '__backend_content/listContent/';
		$this->defualt_frontend_controller = '__frontend_content/listContent/';

		//set lang
		$this->session->set_userdata('lang', 'th');
		$this->load->model('__ps_projects_query');
		$this->load->model('__ps_project_query');
		$this->load->model('__action_plan_setting_model');
		$this->load->model('__employee_track_model');
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

	function unassign($contract_id, $ship_to_id, $function){
		$keyuser_emp_id = $this->session->userdata('id');
		$parameters = array('keyuser_emp_id' => $keyuser_emp_id, 'contract_id' => $contract_id
			, 'ship_to_id' => $ship_to_id, 'function' => $function);

		$result = $this->__action_plan_setting_model->unassign($parameters);

		if(!$result['status']){
			$this->session->set_flashdata('error', $result['error']);
		}

		redirect(site_url('__ps_action_plan_setting/listview'), 'refresh');
	}


	//function com_listview : act / id 
	function listview($page=1){
		$this->tab = $page;


		ini_get('max_execution_time');
		ini_set('memory_limit', '8000M');
		set_time_limit (0);	 

		$newValue = array('current_url'=> site_url($this->uri->uri_string()) );
		$this->session->set_userdata($newValue);

		$data = array();
		$list = array();	

		$menuConfig = array('page_id' => 1);

		$position_list = $this->session->userdata('position');
		$children = array();
		
  		////Prevent duplication 
		// $duplist = $this->__action_plan_setting_model->preventDuplication();
  		//End : Prevent duplication

		foreach ($position_list as $key => $position) {
			$children = $this->__ps_project_query->getPositionChild($children, $position);
		}
		

		if (!empty($children)) {
			$list = $this->__action_plan_setting_model->listviewContent($page);
			$list['all_module']  = $this->__action_plan_setting_model->getKeyUserModule();
			$list['module_list'] = $this->__action_plan_setting_model->getModuleList();	
			$module_permission = array();

			
			foreach ($list['all_module'] as $key => $module) {
				$position_list = $this->__ps_project_query->getObj('tbm_position', null, true);
				if (!empty($position_list)) {
					$output = array();
					foreach ($position_list as $key => $position) {
						$permission = $position['permission'];
						if (!empty($permission)) {
							$permission = unserialize($permission);
							if (array_key_exists($module['id'], $permission)) {
								$output[$position['id']] = $permission[$module['id']];
							}
						}
					}
					$module_permission[$module['id']] = $output;
				}
			}
			$list['module_permission'] = $module_permission;
		} else {
			$list['module_list'] = $this->__action_plan_setting_model->getMemberModuleSlot();
			$menuConfig['module_list'] = $list['module_list'];
		}		

		$data['modal'] = $this->load->view('__action_plan_setting/page/list_modal',$menuConfig,true);//return view as data

		//Load top menu
		$data['top_menu'] = $this->load->view('__projects/include/top',$menuConfig,true);

		//Load side menu
		$user_department_id = $this->session->userdata('department');

		// $side_data['module_list'] = array();
        // $module_list = $this->module_model->getModuleList();
        // if (!empty($module_list)) {
        //   foreach ($module_list as $key => $module) {
        //     $dept_list = $this->__ps_project_query->getObj('tbm_department_module', array('module_id' => $module['id']), true);
        //     if (!empty($dept_list)) {
        //       foreach ($dept_list as $dept) {
        //         if (in_array($dept['department_id'], $user_department_id) && $module['is_active'] == 1 && $module['is_main_menu'] == 1) {
        //           $side_data['module_list'][$module['id']] = $module;
        //         }
        //       }
        //     } 
        //   }
        // }

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
		$data['body'] = $this->load->view('__action_plan_setting/page/list_bodycfg',$list,true);

		//Load footage script
		$data['footage_script'] =  $this->load->view('__action_plan_setting/script/delete_js', null, true);;


		$this->load->view('__action_plan_setting/layout/list',$data);
	}

	function save_track_project() {

		$p = $this->input->post();
		
		$this->__action_plan_setting_model->update_track($p);	

		$emp_id = $this->session->userdata('id');
		$assign_key_list = preg_grep("/^assign_/",array_keys($p));

		$assign_arr = array();
		foreach ($assign_key_list as $key) {
			$key_parts = explode('_', $key);

			// $key_name = $key_parts[0].'_'.$key_parts[1];
			$contract_id = $key_parts[1];
			$module = $key_parts[2];
			$function = $key_parts[3];

			if (!empty($p[$key])) {
				foreach ($p[$key] as $index => $value) {
					$assign_arr[$contract_id][$module][$function][$index] = $value;
				}
			}

		}

		$this->db->trans_begin();
		// Add marked assign 
		foreach ($assign_arr as $contract_id => $value) {

			$this->db->where('contract_id', $contract_id);
			$query = $this->db->get('tbt_quotation');
			$project = $query->row_array();

			$quality_employee_id = 0;
			$is_quality_manager = false;

			foreach ($value as $module_id => $value2) {

				foreach ($value2 as $function_key => $obj_function) {

					foreach ($obj_function as $index => $value3) {
						if ($module_id == 6) {
							$quality_employee_id = $value3['employee'];
							$is_quality_manager = true;
						}

						if (!empty($project)) {
							$data = array(
								'keyuser_emp_id' => $emp_id,
								'contract_id'	 => $contract_id,
								'ship_to_id'	 => $project['ship_to_id'],
								'module_id'		 => $module_id,
								'area_id'		 => 0,
								'assign_to'		 => $value3['employee'],
								'assign_date'	 => date('Y-m-d'),
								'function'	 	 =>$value3['function'],
								);

							if (array_key_exists('period', $value3)) {
								$data['month_period'] = $value3['period'];
							}

							if (array_key_exists('id', $value3) && !empty($value3['id'])) {
								$this->__ps_project_query->updateObj('tbt_keyuser_marked_assign', array('id' => $value3['id']), $data);
							} else {
								$value3['id'] = $this->__ps_project_query->insertObj('tbt_keyuser_marked_assign', $data);
							}

							//Generate Slot
							if (array_key_exists('period', $value3) && $value3['period'] > 0) {

								$total  = floatval($this->__action_plan_setting_model->getProjectPeriod($contract_id));
								$period = floatval($value3['period']);

								$slot = 0;
								if ($total > 0) {
									if ($period < 0) {
										$slot = ceil((1/$period)*$total);
									} else {
										$slot = ceil($total/$period);
									}
								}

								for ($i=0; $i < $slot; $i++) {

									$user_marked = array(
										'assign_id'		=> $value3['id'],
										'emp_id' 		=> $value3['employee'],
										'contract_id'	=> $contract_id,
										'ship_to_id' 	=> $project['ship_to_id'],
										'module_id' 	=> $module_id,
										'area_id'		=> 0,
										'sequence'		=> $i+1
										);


									$this->__ps_project_query->insertObj('tbt_user_marked', $user_marked);
								}
							} else {
								//$this->__ps_project_query->updateObj('tbt_user_marked', array('assign_id' => $value3['id']),  array('emp_id' => $value3['employee']));
							}
						}
					}
				}
			}


			if ($is_quality_manager && !empty($quality_employee_id)) {
				//$project = $this->__ps_project_query->getObj('tbt_quotation', array('contract_id' => $contract_id));

				if (!empty($project)) {
					$clearjob_list = $this->__ps_project_query->getObj('tbt_area', array('contract_id' => $contract_id), true);

					$tmp_clearjob = array();

					if (!empty($clearjob_list)) {
						foreach ($clearjob_list as $clearjob) {

							if (!array_key_exists($clearjob['clear_job_type_id'], $tmp_clearjob)) {
								$tmp_clearjob[$clearjob['clear_job_type_id']] = array();
							}

							if (!in_array($clearjob['frequency'], $tmp_clearjob[$clearjob['clear_job_type_id']])) {
								array_push($tmp_clearjob[$clearjob['clear_job_type_id']], $clearjob['frequency']);
							}							
						}
					} 

					// echo "<pre>";
					// print_r($tmp_clearjob);
					// echo "</pre>";

					if (!empty($tmp_clearjob)) {
						foreach ($tmp_clearjob as $clear_job_type_id => $freq_value) {

							if (!empty($freq_value)) {
								foreach ($freq_value as $key => $freq) {

									$assign_obj = $this->__ps_project_query->getObj('tbt_keyuser_marked_assign', array('contract_id' => $contract_id, 'module_id' => 12, 'clear_job_type_id' => $clear_job_type_id, 'frequency' => $freq));

									$data = array(
										'keyuser_emp_id' 		=> $emp_id,
										'contract_id'	 		=> $contract_id,
										'ship_to_id'	 		=> $project['ship_to_id'],
										'module_id'		 		=> 12,
										'clear_job_type_id'  	=> $clear_job_type_id,
										'frequency'  			=> $freq,
										'assign_to'		 		=> $quality_employee_id,
										'month_period'   		=> floatval($clearjob['frequency']),
										'assign_date'	 		=> date('Y-m-d'),
										'function'	 			=> 'OP',
										);

									if (!empty($assign_obj)) {
										$assign_id = $assign_obj['id'];
										$this->__ps_project_query->updateObj('tbt_keyuser_marked_assign', array('contract_id' => $contract_id, 'module_id' => 12, 'clear_job_type_id' => $clear_job_type_id, 'frequency' => $freq), $data);
									} else {
										$assign_id = $this->__ps_project_query->insertObj('tbt_keyuser_marked_assign', $data);
									}

									$slot_list = $this->__ps_project_query->getObj('tbt_user_marked', array('contract_id' => $contract_id, 'module_id' => 12, 'clear_job_type_id' => $clear_job_type_id, 'frequency' => $freq), true);

									if (empty($slot_list)) {

										$total  = floatval($this->__action_plan_setting_model->getProjectPeriod($contract_id));
										$period = floatval($freq);

										if ($period > 0) {
											$slot = 0;
											if ($total > 0) {
												if ($period < 0) {
													$slot = ceil((1/$period)*$total);
												} else {
													$slot = ceil($total/$period);
												}
											}

											for ($i=0; $i < $slot; $i++) {

												$user_marked = array(
													'assign_id'     		=> $assign_id,
													'emp_id' 				=> $quality_employee_id,
													'contract_id'   		=> $contract_id,
													'ship_to_id' 			=> $project['ship_to_id'],
													'module_id' 			=> 12,
													'clear_job_type_id'  	=> $clear_job_type_id,
													'frequency'  			=> $freq,
													'sequence'				=> $i+1
													);

												$this->__ps_project_query->insertObj('tbt_user_marked', $user_marked);
											}
										}
									}else {
										// $this->__ps_project_query->updateObj('tbt_user_marked', array('contract_id' => $contract_id, 'module_id' => 12, 'clear_job_type_id' => $clear_job_type_id, 'frequency' => $freq),  array('emp_id' => $quality_employee_id));
									}
								}
							}
						}
					}
				}	
			}
		}

		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
		}
		else{
			$this->db->trans_commit();
		}
		redirect(site_url($this->page_controller.'/listview/1'), 'refresh');
	}

	function checkPeriod () {

		$p = $this->input->post();

		// echo "<pre>";
		// print_r($p);
		// echo "</pre>";

		$assign_key_list = preg_grep("/^assign_/",array_keys($p));
		$error_list = array();
		foreach ($assign_key_list as $key) {

			$key_parts = explode('_', $key);
			$contract_id = $key_parts[1];
			if (!empty($p[$key])) {
				foreach ($p[$key] as $index => $value) {
					if (array_key_exists('period', $value)) {
						$total  = floatval($this->__action_plan_setting_model->getProjectPeriod($contract_id));
						$period = floatval($value['period']);

						if ($period > $total) {
							array_push($error_list, $key.'['.$index.'][period]');
						}
					}
				}
			}
		}

		if (!empty($error_list)) {
			echo json_encode($error_list);
		} else {
			echo 1;
		}


	}

	function save_untrack_project() {

		$p = $this->input->post();

		// echo "<pre>";
		// print_r($p);
		// echo "</pre>";

		// die();

		if (!empty($p['untrack_check'])) {
			$this->__action_plan_setting_model->update_untrack($p);
		}

		$emp_id = $this->session->userdata('id');
		$assign_key_list = preg_grep("/^assign_/",array_keys($p));				

		$assign_arr = array();
		foreach ($assign_key_list as $key) {
			$key_parts = explode('_', $key);

			// $key_name = $key_parts[0].'_'.$key_parts[1];
			$contract_id = $key_parts[1];
			$module = $key_parts[2];
			$function = $key_parts[3];

			if (!empty($p[$key])) {
				foreach ($p[$key] as $index => $value) {
					$assign_arr[$contract_id][$module][$function][$index] = $value;
				}
			}
		}	

		// die();

		$this->db->trans_begin();
		// Add marked assign 
		foreach ($assign_arr as $contract_id => $value) {

			$this->db->where('contract_id', $contract_id);
			$query = $this->db->get('tbt_quotation');
			$project = $query->row_array();

			$quality_employee_id = 0;
			$is_quality_manager = false;

			foreach ($value as $module_id => $value2) {

				foreach ($value2 as $function_key => $obj_function) {

					foreach ($obj_function as $index => $value3) {
						if ($module_id == 6) {
							$quality_employee_id = $value3['employee'];
							$is_quality_manager = true;
						}

						if (!empty($project)) {
							$data = array(
								'keyuser_emp_id' => $emp_id,
								'contract_id'	 => $contract_id,
								'ship_to_id'	 => $project['ship_to_id'],
								'module_id'		 => $module_id,
								'area_id'		 => 0,
								'assign_to'		 => $value3['employee'],
								'assign_date'	 => date('Y-m-d'),
								'function'	 	 => $value3['function'],
								);

							if (array_key_exists('period', $value3)) {
								$data['month_period'] = $value3['period'];
							}

							if (array_key_exists('id', $value3) && !empty($value3['id'])) {
								$this->__ps_project_query->updateObj('tbt_keyuser_marked_assign', array('id' => $value3['id']), $data);
							} else {
								$value3['id'] = $this->__ps_project_query->insertObj('tbt_keyuser_marked_assign', $data);
							}

							//Generate Slot
							if (array_key_exists('period', $value3) && $value3['period'] > 0) {

								// echo "<br> Add Slot";
								$total  = floatval($this->__action_plan_setting_model->getProjectPeriod($contract_id));
								$period = floatval($value3['period']);

								$slot = 0;
								if ($total > 0) {
									if ($period < 0) {
										$slot = ceil((1/$period)*$total);
									} else {
										$slot = ceil($total/$period);
									}
								}

								for ($i=0; $i < $slot; $i++) {

									$user_marked = array(
										'assign_id'		=> $value3['id'],
										'emp_id' 		=> $value3['employee'],
										'contract_id'	=> $contract_id,
										'ship_to_id' 	=> $project['ship_to_id'],
										'module_id' 	=> $module_id,
										'area_id'		=> 0,
										'sequence'		=> $i+1
										);


									$this->__ps_project_query->insertObj('tbt_user_marked', $user_marked);
								}
							} else {
								//$this->__ps_project_query->updateObj('tbt_user_marked', array('assign_id' => $value3['id']),  array('emp_id' => $value3['employee']));

							}
						}
					}
				}
			}


			if ($is_quality_manager && !empty($quality_employee_id)) {
				// $project = $this->__ps_project_query->getObj('tbt_quotation', array('contract_id' => $contract_id));

				if (!empty($project)) {
					$clearjob_list = $this->__ps_project_query->getObj('tbt_area', array('contract_id' => $contract_id), true);

					$tmp_clearjob = array();

					if (!empty($clearjob_list)) {
						foreach ($clearjob_list as $clearjob) {

							if (!array_key_exists($clearjob['clear_job_type_id'], $tmp_clearjob)) {
								$tmp_clearjob[$clearjob['clear_job_type_id']] = array();
							}

							if (!in_array($clearjob['frequency'], $tmp_clearjob[$clearjob['clear_job_type_id']])) {
								array_push($tmp_clearjob[$clearjob['clear_job_type_id']], $clearjob['frequency']);
							}							
						}
					} 

					if (!empty($tmp_clearjob)) {
						foreach ($tmp_clearjob as $clear_job_type_id => $freq_value) {

							if (!empty($freq_value)) {
								foreach ($freq_value as $key => $freq) {

									$assign_obj = $this->__ps_project_query->getObj('tbt_keyuser_marked_assign', array('contract_id' => $contract_id, 'module_id' => 12, 'clear_job_type_id' => $clear_job_type_id, 'frequency' => $freq));

									$data = array(
										'keyuser_emp_id' 		=> $emp_id,
										'contract_id'	 		=> $contract_id,
										'ship_to_id'	 		=> $project['ship_to_id'],
										'module_id'		 		=> 12,
										'clear_job_type_id'  	=> $clear_job_type_id,
										'frequency'  			=> $freq,
										'assign_to'		 		=> $quality_employee_id,
										'month_period'   		=> floatval($clearjob['frequency']),
										'assign_date'	 		=> date('Y-m-d'),
										'function'	 			=> 'OP',
										);

									if (!empty($assign_obj)) {
										$assign_id = $assign_obj['id'];
										$this->__ps_project_query->updateObj('tbt_keyuser_marked_assign', array('contract_id' => $contract_id, 'module_id' => 12, 'clear_job_type_id' => $clear_job_type_id, 'frequency' => $freq), $data);
									} else {
										$assign_id = $this->__ps_project_query->insertObj('tbt_keyuser_marked_assign', $data);
									}

									$slot_list = $this->__ps_project_query->getObj('tbt_user_marked', array('contract_id' => $contract_id, 'module_id' => 12, 'clear_job_type_id' => $clear_job_type_id, 'frequency' => $freq), true);

									if (empty($slot_list)) {

										$total  = floatval($this->__action_plan_setting_model->getProjectPeriod($contract_id));
										$period = floatval($freq);

										if ($period > 0) {
											# code...

											$slot = 0;
											if ($total > 0) {
												if ($period < 0) {
													$slot = ceil((1/$period)*$total);
												} else {
													$slot = ceil($total/$period);
												}
											}

											for ($i=0; $i < $slot; $i++) {

												$user_marked = array(
													'assign_id'     		=> $assign_id,
													'emp_id' 				=> $quality_employee_id,
													'contract_id'   		=> $contract_id,
													'ship_to_id' 			=> $project['ship_to_id'],
													'module_id' 			=> 12,
													'clear_job_type_id'  	=> $clear_job_type_id,
													'frequency'  			=> $freq,
													'sequence'				=> $i+1
													);

												$this->__ps_project_query->insertObj('tbt_user_marked', $user_marked);
											}
										}
									}else {
										// $this->__ps_project_query->updateObj('tbt_user_marked', array('contract_id' => $contract_id, 'module_id' => 12, 'clear_job_type_id' => $clear_job_type_id, 'frequency' => $freq),  array('emp_id' => $quality_employee_id));
									}
								}
							}
						}
					}
				}	
			}
		}
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
		}
		else{
			$this->db->trans_commit();
		}
		redirect(site_url($this->page_controller.'/listview/2'), 'refresh');
	}

	function save_assign_user () {

		$emp_id = $this->session->userdata('id');
		$p = $this->input->post();

		foreach ($p as $key => $value) {
			$key_parts = explode('_', $key);
			$key_val	= $key_parts[0];
			$contract_id = $key_parts[1];
			$date  				  = $value;

			if (!empty($date) && $key_val == "assign") {
				$module_id  = $key_parts[2];
				$sequence   = $key_parts[3];

				$user_marked = $this->__ps_project_query->getObj('tbt_user_marked', array('contract_id' => $contract_id, 'module_id' => $module_id, 'sequence' => $sequence, 'emp_id' => $emp_id));
				$this->createActionPlan($date, $module_id, $contract_id, $user_marked['action_plan_id'], $sequence);			
			} else if (!empty($date) && $key_val == "clearjobassign") {
				$module_id  = 12;
				$job_type_id = $key_parts[2];
				$frequency = $key_parts[3];
				$sequence   = $key_parts[4];

				$user_marked = $this->__ps_project_query->getObj('tbt_user_marked', array('contract_id' => $contract_id, 'module_id' => $module_id, 'clear_job_type_id' => $job_type_id, 'frequency' => $frequency, 'sequence' => $sequence, 'emp_id' => $emp_id));
				$this->createActionPlan($date, $module_id, $contract_id, $user_marked['action_plan_id'], $sequence, null, "", $job_type_id, $frequency);	
			}

		}

		redirect(site_url($this->page_controller.'/listview'), 'refresh');
	}

}
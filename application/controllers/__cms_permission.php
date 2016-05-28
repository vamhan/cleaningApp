<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class __cms_permission extends Admin_Controller {

	function __construct() {
		parent::__construct();
        $this->permission_check('cms');
        
        $this->load->config('project.config');
   		$this->project_config = $this->config->item('project_config');

   		$this->load->config('auth.config');
   		$this->auth_config = $this->config->item('auth_config');
   		// var_dump($this->auth_config);
   	
	}//end constructor;

	function login ($type='', $token='') {
		parent::login($type, $token);
	}

	function login_soap ($module) {
		parent::login_soap($module);
	} 

	function logout () {
		parent::logout();
	} 

	function logoutSSO() {

		$cookie_val = $this->session->userdata('cookie');
        setcookie('Bossup','', 1);

        $object = 'cms_users';
        if ($this->session->userdata('super_admin')) {
        	$object = 'superadmin';
        }
        
        log_transaction('logout', $object,  $this->session->userdata('id'), 'success');

	    $this->session->sess_destroy();
	}

	function change_language($lang) {
		// echo "lange: ".$lang;
		// exit();
		parent::change_language($lang);
	}

	function access_error () {
		parent::access_error();
	}

	function index () {
		redirect( site_url('__cms_permission/user_permission') ,'refresh');
	}

    function decrypt ( $text ) {	

    	$text = base64_decode($text);
    	$decrypted = "";
    	while (!empty($text)) {
    		$text = base64_decode($text);
    		$decrypted = substr($text, strlen($text)-4).$decrypted;
    		$text = substr($text, 0, strlen($text)-4);    	}

    	$split_text = str_split($decrypted);

    	$decrypted_words = "";
		foreach ($split_text as $key => $char) {

			if ($key %2 == 0) {
				$decrypted_words .= $char;
			}
		}

		$decrypted_words = str_replace('@', '', $decrypted_words);

    	return $decrypted_words;
    }
    
	function single_login ($username) {

		$decrypted_username = $this->decrypt($username);
		$user = $this->user->single_login($decrypted_username);


		if (!empty($user)) {

			$department = $this->session->userdata('department');
			$group = $this->session->userdata('group');//get groupname

			$url = '__cms_permission/login';

			$this->getAuthenAll();
			$permission = $this->permission;

			if (!empty($permission)) {
					$module_key = array_keys($permission);
					$module = $this->module_model->getMainModule($id);

			        if (!empty($module)) {
			        	foreach ($module as $key => $value) {
			        		if (in_array($value['id'], $module_key) && array_key_exists('create', $permission[$value['id']])) {
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

		$this->load->view('login_error');
	}

	function changePageSize( $newPageSize = PAGESIZE ){
		$newValue = array('current_page'=> $newPageSize);
		$this->session->set_userdata($newValue);

		$callback_url = $this->session->userdata('current_url');
		
		// $this->trace($callback_url);
		if(!empty($callback_url))
			redirect($callback_url,'refresh');
	}

	function user_list ($page=1){
		
		$menuConfig['page_id'] 	  = 'user';

		#CMS
		$this->pageSize = PAGESIZE;
		$this->table = 'tbt_user';
		$this->page_id = 'user';
		$this->page_title = 'User';
		$this->page_object = 'user';
		$this->page_controller = '__cms_permission';
		#END_CMS

		//Load top menu
		$data['top_menu']  = $this->load->view('__cms/include/top',$menuConfig,true);//return view as data

		//Load side menu
		$data['side_menu'] = $this->load->view('__cms/include/side',$menuConfig,true);//return view as data

		//Load body
		$config 		   = $this->loadCMSCfg('user');
		$data['user_list'] = $this->user->getAll($page, $config);

		$dept_list    		= $this->user->getDepartmentAll();
		$group_list 	   = $this->user->listGroup();
		
		$modal_data = array(
			'user_list' 	=> $data['user_list'],
			'group_list' 	=> $group_list,
			'dept_list'		=> $dept_list
		);

		$data['modal'] = $this->load->view('__cms/permission/user_modal',$modal_data,true);//return view as data

		$list = $this->user->listviewcfg($config,$page);
		// if ($list['result']['total_page'] < $page) {
		// 	redirect( site_url('__cms_permission/user_list') );
		// }
		$list['config'] = $config;

		$data['body'] = $this->load->view('__cms/permission/user_body',$list,true);

		//Load footage script 
		$data['footage_script'] = $this->load->view('__cms/script/permission/user_js','',true);;

		$this->load->view('__cms/layout/list',$data);
	}

	public function user_position_list ($tab='') {

		$menuConfig['page_id'] 	  = 'positionMapping';

		#CMS
		$this->pageSize = PAGESIZE;
		$this->table = 'tbm_position';
		$this->page_id = 'positionMapping';
		$this->page_title = 'Position Mapping';
		$this->page_object = 'positionMapping';
		$this->page_controller = '__cms_permission';
		#END_CMS

		//Load top menu
		$data['top_menu'] = $this->load->view('__cms/include/top',$menuConfig,true);//return view as data

		//Load side menu
		$data['side_menu'] = $this->load->view('__cms/include/side',$menuConfig,true);//return view as data

		//Load body
		$list['tab'] = $tab;
		$list['group_list'] = $this->__ps_project_query->getObj('tbm_group', null, true);

		$list['position_list'] = $this->__ps_project_query->getObj('tbm_position', null, true);
		if (!empty($list['position_list'])) {
			foreach ($list['position_list'] as $key => $position) {
				$dept = $this->__ps_project_query->getObj('tbm_department', array('id' => $position['department_id']));
				$list['position_list'][$key]['dept_name'] = '';
				if (!empty($dept)) {
					$list['position_list'][$key]['dept_name'] = $dept['title'];
				}

				$group = $this->__ps_project_query->getObj('tbm_group', array('id' => $position['group_id']));
				$list['position_list'][$key]['group_name'] = '';
				if (!empty($group)) {
					$list['position_list'][$key]['group_name'] = $group['title'];
				}
			}
		}

		$list['tab_result'] = $this->__ps_project_query->getObj('tbm_position', null, true, array('id', 'title'));
		if (!empty($list['tab_result'])) {
			foreach ($list['tab_result'] as $key => $position) {
				$dept = $this->__ps_project_query->getObj('tbm_department', array('id' => $position['department_id']));
				$list['tab_result'][$key]['dept_name'] = '';
				if (!empty($dept)) {
					$list['tab_result'][$key]['dept_name'] = $dept['title'];
				}

				$group = $this->__ps_project_query->getObj('tbm_group', array('id' => $position['group_id']));
				$list['tab_result'][$key]['group_name'] = '';
				if (!empty($group)) {
					$list['tab_result'][$key]['group_name'] = $group['title'];
				}
			}
		}

		$data['body'] = $this->load->view('__cms/permission/user_position_body',$list,true);//return view as data

		//Load footage script 
		$data['footage_script'] = $this->load->view('__cms/script/permission/user_position_js','',true);;

		$this->load->view('__cms/layout/list',$data);
	}

	public function department_module_list () {

		$menuConfig['page_id'] 	  = 'departmentMapping';

		#CMS
		$this->pageSize = PAGESIZE;
		$this->table = 'tbm_department_module';
		$this->page_id = 'departmentMapping';
		$this->page_title = 'Department Module';
		$this->page_object = 'departmentMapping';
		$this->page_controller = '__cms_permission';
		#END_CMS

		//Load top menu
		$data['top_menu'] = $this->load->view('__cms/include/top',$menuConfig,true);//return view as data

		//Load side menu
		$data['side_menu'] = $this->load->view('__cms/include/side',$menuConfig,true);//return view as data

		//Load body
		$list['tab'] = $tab;
		$list['module_list'] = $this->module_model->getModuleList();
		$list['department_list'] = $this->__ps_project_query->getObj('tbm_department', array('parent_id' => 0), true);
		$list['department_html'] = '<ol class="dd-list">';
		if (!empty($list['department_list'])) {
			foreach ($list['department_list'] as $key => $dept) {
				$list['department_html'] .= $this->_appendDeptModuleChild($dept);
				// $list['department_list'][$key]['children'] = $this->_appendDeptChild($dept);
			}
		}

		$list['department_html'] .= '</ol>';


		// echo $list['department_html'];
		// echo "<pre>";
		// print_r($list['department_list']);
		// echo "</pre>";

		// die();

		if (!empty($list['module_list'])) {
			foreach ($list['module_list'] as $key => $module) {
				$dept_list = $this->__ps_project_query->getObj('tbm_department_module', array('module_id' => $module['id']), true);
				$list['module_list'][$key]['department_list'] = array();
				if (!empty($dept_list)) {
					foreach ($dept_list as $dept) {
						array_push($list['module_list'][$key]['department_list'], $dept['department_id']);
					}
				}
			}
		}

		$data['modal'] = $this->load->view('__cms/permission/department_module_modal',$list,true);//return view as data
		$data['body'] = $this->load->view('__cms/permission/department_module_body',$list,true);//return view as data

		//Load footage script 
		$data['footage_script'] = $this->load->view('__cms/script/permission/department_module_js','',true);;

		$this->load->view('__cms/layout/list',$data);
	}

	public function _appendDeptModuleChild ($parent) {

		$children = $this->__ps_project_query->getObj('tbm_department', array('parent_id' => $parent['id']), true);

        $html = '<li class="dd-item" data-id="'.$parent['id'].'">';
        $html .= '<div class="dd3-content">';
        $html .= $parent['title'];
	    $html .= '</div>';

		$position = $this->__ps_project_query->getObj('tbm_position', array('department_id' => $parent['id']), true);
		if (!empty($children)) {
			$html .= '<ol class="dd-list">';

			if (!empty($position)) {
				foreach ($position as $key => $pos) {
					$html .= '<li class="dd-item">';
				    $html .= '<div class="dd3-content">';
				    $html .= $pos['title'];
				    $html .= '<a href="#" class="edit_btn text-muted pull-right"><i class="fa fa-pencil"></i></a>';
				    $html .= '<div class="edit_panel hide wrapper-sm row">';
				    $html .= '<div class="col-sm-6">';
				    $html .= '<span class="checkbox_line" data-id="'.$pos['id'].'" data-action="view"><input type="checkbox" name="view_'.$pos['id'].'" value="1"> ดู</span> <br>';
				    $html .= '<span class="checkbox_line" data-id="'.$pos['id'].'" data-action="create"><input type="checkbox" name="create_'.$pos['id'].'" value="1"> สร้าง</span> <br>';
				    $html .= '<span class="checkbox_line" data-id="'.$pos['id'].'" data-action="edit"><input type="checkbox" name="edit_'.$pos['id'].'" value="1"> แก้ไข</span> <br>';
				    $html .= '<span class="checkbox_line" data-id="'.$pos['id'].'" data-action="delete"><input type="checkbox" name="delete_'.$pos['id'].'" value="1"> ลบ</span> <br>';
				    $html .= '<span class="checkbox_line approve_line" data-id="'.$pos['id'].'" data-action="approve"><input type="checkbox" name="approve_'.$pos['id'].'" value="1"> อนุมัติ</span><br>';
				    $html .= '</div>';
				    $html .= '<div class="shipto_line col-sm-6">';
				    $html .= '<input type="radio" name="shipto_'.$pos['id'].'[]" value="all"> สถานที่ปฎิบัติงานทั้งหมด<br>';
				    $html .= '<input type="radio" name="shipto_'.$pos['id'].'[]" value="related"> สถานที่ปฏิบัติงานที่เกี่ยวข้อง<br>';
				    $html .= '<a class="btn btn-default btn-xs pull-right clear_shipto">Clear</a>';
				    $html .= '</div>';
				    $html .= '</div>';
				    $html .= '</div>';
					$html .= '</li>';
				}
			}

			foreach ($children as $key => $child) {
				$html .= $this->_appendDeptModuleChild($child);
			}
			$html .= '</ol>';
		} else if (!empty($position)) {
			$html .= '<ol class="dd-list">';
			foreach ($position as $key => $pos) {
				$html .= '<li class="dd-item">';
			    $html .= '<div class="dd3-content">';
			    $html .= $pos['title'];
			    $html .= '<a href="#" class="edit_btn text-muted pull-right"><i class="fa fa-pencil"></i></a>';
			    $html .= '<div class="edit_panel hide wrapper-sm row">';
			    $html .= '<div class="col-sm-6">';
			    $html .= '<span class="checkbox_line" data-id="'.$pos['id'].'" data-action="view"><input type="checkbox" name="view_'.$pos['id'].'" value="1"> ดู</span> <br>';
			    $html .= '<span class="checkbox_line" data-id="'.$pos['id'].'" data-action="create"><input type="checkbox" name="create_'.$pos['id'].'" value="1"> สร้าง</span> <br>';
			    $html .= '<span class="checkbox_line" data-id="'.$pos['id'].'" data-action="edit"><input type="checkbox" name="edit_'.$pos['id'].'" value="1"> แก้ไข</span> <br>';
			    $html .= '<span class="checkbox_line" data-id="'.$pos['id'].'" data-action="delete"><input type="checkbox" name="delete_'.$pos['id'].'" value="1"> ลบ</span> <br>';
			    $html .= '<span class="checkbox_line approve_line" data-id="'.$pos['id'].'" data-action="approve"><input type="checkbox" name="approve_'.$pos['id'].'" value="1"> อนุมัติ</span><br>';
			    $html .= '</div>';
			    $html .= '<div class="shipto_line col-sm-6">';
			    $html .= '<input type="radio" name="shipto_'.$pos['id'].'[]" value="all"> สถานที่ปฎิบัติงานทั้งหมด<br>';
			    $html .= '<input type="radio" name="shipto_'.$pos['id'].'[]" value="related"> สถานที่ปฏิบัติงานที่เกี่ยวข้อง<br>';
				$html .= '<a class="btn btn-default btn-xs pull-right clear_shipto">Clear</a>';
			    $html .= '</div>';
			    $html .= '</div>';
			    $html .= '</div>';
				$html .= '</li>';
			}
			$html .= '</ol>';
		}

		$html .= '</li>';


		return $html;
		// return $children;
	}

	public function department_list () {

		$menuConfig['page_id'] 	  = 'department_list';

		#CMS
		$this->pageSize = PAGESIZE;
		$this->table = 'tbm_department';
		$this->page_id = 'department_list';
		$this->page_title = 'Department';
		$this->page_object = 'department_list';
		$this->page_controller = '__cms_permission';
		#END_CMS

		//Load top menu
		$data['top_menu'] = $this->load->view('__cms/include/top',$menuConfig,true);//return view as data

		//Load side menu
		$data['side_menu'] = $this->load->view('__cms/include/side',$menuConfig,true);//return view as data

		//Load body
		$list['department_list'] = $this->__ps_project_query->getObj('tbm_department', array('parent_id' => 0), true);
		$list['department_html'] = '<ol class="dd-list">';
		if (!empty($list['department_list'])) {
			foreach ($list['department_list'] as $key => $dept) {
				$list['department_html'] .= $this->_appendDeptChild($dept);
				// $list['department_list'][$key]['children'] = $this->_appendDeptChild($dept);
			}
		}
		$list['department_html'] .= '</ol>';

		// $data['modal'] = $this->load->view('__cms/permission/department_modal',$list,true);//return view as data
		$data['body'] = $this->load->view('__cms/permission/department_body',$list,true);//return view as data

		//Load footage script 
		$data['footage_script'] = $this->load->view('__cms/script/permission/department_js','',true);;

		$this->load->view('__cms/layout/list',$data);
	}


	public function _appendDeptChild ($parent) {

		$children = $this->__ps_project_query->getObj('tbm_department', array('parent_id' => $parent['id']), true);
		// echo $parent['id'].'<br>';
		// echo "<pre>";
		// print_r($children);
		// echo "</pre>";
		$function = $parent['function'];
        $html = '<li class="dd-item" data-id="'.$parent['id'].'">';
        $html .= '<div class="dd3-content row"><div class="col-sm-8">'.$parent['title'].'</div><div style="width:200px;" class="pull-right text-center"><select name="dept_'.$parent['id'].'" class="form-control func_sel"><option value="">---- Choose Function ----</option>';
        $html .= '<option value="CR"';

        if ($function == 'CR') {
        	$html .= ' selected';
        }

        $html .= '>CR</option>';
        $html .= '<option value="OP"';

        if ($function == 'OP') {
        	$html .= ' selected';
        }
        
        $html .= '>OP</option>';
        $html .= '<option value="MK"';

        if ($function == 'MK') {
        	$html .= ' selected';
        }
        
        $html .= '>MK</option>';
        $html .= '<option value="IC"';

        if ($function == 'IC') {
        	$html .= ' selected';
        }
        
        $html .= '>IC</option>';
        $html .= '<option value="TR"';

        if ($function == 'TR') {
        	$html .= ' selected';
        }
        
        $html .= '>TR</option>';
        $html .= '<option value="RC"';

        if ($function == 'RC') {
        	$html .= ' selected';
        }
        
        $html .= '>RC</option>';
        $html .= '<option value="HR"';

        if ($function == 'HR') {
        	$html .= ' selected';
        }
        
        $html .= '>HR</option>';
        $html .= '<option value="ST"';

        if ($function == 'ST') {
        	$html .= ' selected';
        }
        
        $html .= '>ST</option>';
        $html .= '<option value="PO"';

        if ($function == 'PO') {
        	$html .= ' selected';
        }
        
        $html .= '>PO</option>';
        $html .= '<option value="AC"';

        if ($function == 'AC') {
        	$html .= ' selected';
        }
        
        $html .= '>AC</option>';
        $html .= '<option value="FI"';

        if ($function == 'FI') {
        	$html .= ' selected';
        }
        
        $html .= '>FI</option>';
        $html .= '<option value="HO"';

        if ($function == 'HO') {
        	$html .= ' selected';
        }
        
        $html .= '>HO</option>';
        $html .= '<option value="MC"';

        if ($function == 'MC') {
        	$html .= ' selected';
        }
        
        $html .= '>MC</option>';
        $html .= '<option value="TN"';

        if ($function == 'TN') {
        	$html .= ' selected';
        }
        
        $html .= '>TN</option>';
        $html .= '<option value="WF"';

        if ($function == 'WF') {
        	$html .= ' selected';
        }
        
        $html .= '>WF</option>';
        $html .= '<option value="MD"';

        if ($function == 'MD') {
        	$html .= ' selected';
        }
        
        $html .= '>MD</option>';
        $html .= '<option value="IT"';

        if ($function == 'IT') {
        	$html .= ' selected';
        }
        
        $html .= '>IT</option>';
        $html .= '<option value="RT"';

        if ($function == 'RT') {
        	$html .= ' selected';
        }
        
        $html .= '>RT</option>';
        $html .= '</select></div></div>';
		if (!empty($children)) {
			$html .= '<ol class="dd-list">';
			foreach ($children as $key => $child) {
				// $html .= '<li class="dd-item x" data-id="'.$child['id'].'">';
				$html .= $this->_appendDeptChild($child);
				// $html .= '</li>';
			}
			$html .= '</ol>';
		}
		$html .= '</li>';

		return $html;
		// return $children;
	}

	public function map_dept_function () {

		$p = $this->input->post();

		if (!empty($p)) {
			foreach ($p as $key => $function) {
				$key_parts = explode('_', $key);
				$dept_id = $key_parts[1];

				if (!empty($dept_id)) {
					$this->__ps_project_query->updateObj('tbm_department', array('id' => $dept_id), array('function' => $function));
				}
			}
		}

		redirect( site_url('__cms_permission/department_list'), 'refresh' );
	}

	public function save_position ($tab='') {

		$p = $this->input->post();
		if (!empty($p)) {
			$group_key = preg_grep("/^group_/",array_keys($p));
			if (!empty($group_key)) {
				foreach ($group_key as $group) {
					$id_parts = explode('_', $group);
					$group_id = $id_parts[1];
					$position_list = $p[$group];
					$this->__ps_project_query->updateObj('tbm_position', array('group_id' => $group_id), array('group_id' => ''));
					if (!empty($position_list)) {
						foreach ($position_list as $key => $position_id) {
							$this->__ps_project_query->updateObj('tbm_position', array('id' => $position_id), array('group_id' => $group_id));
						}				
					}
				}
			}
		}

		redirect(site_url('__cms_permission/user_position_list/'.$tab), 'refresh' );
	}


	function save_department_module () {

		$p = $this->input->post();
		if (!empty($p) && !empty($p['module_id'])) {
			foreach ($p['module_id'] as $department_id => $module_list) {
				$this->__ps_project_query->deleteObj('tbm_department_module', array('department_id' => $department_id));
				if (!empty($module_list)) {
					foreach ($module_list as $key => $module_id) {
						$data = array(
							'department_id' => $department_id,
							'module_id'	    => $module_id
						);
						$this->__ps_project_query->insertObj('tbm_department_module', $data);
					}
				}
			}
		}

		redirect( site_url('__cms_permission/department_module/'), 'refresh' );
	}

	public function getDepartmentHierachy () {

        $this->load->library("nusoap_lib");
        $this->webservice_url = $this->papyrus['url'];

        error_reporting(0);

        $this->nusoap_client = new nusoap_client($this->webservice_url,true);
        $this->nusoap_client->soap_defencoding = 'UTF-8';
        $this->nusoap_client->decode_utf8 = false;

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
                            $this->papyrus['getDeptFunc']
                        );

                $result = $soap_result['GetDepartmentHierachyResult'];
                $xml = simplexml_load_string($result);
				$json = json_encode($xml);
				$array = json_decode($json,TRUE);

				// echo "<pre>";
				// print_r($array);
				// echo "</pre>";

				// die();
				$this->db->truncate('tbm_department');
                $this->_getDept($array);

				// echo "success";
			}
		}

	}

	public function getShipToAll () {

        $this->load->library("nusoap_lib");
        $this->webservice_url = $this->papyrus['getOperAreaUrl'];

        error_reporting(0);

        $this->nusoap_client = new nusoap_client($this->webservice_url,true);
        $this->nusoap_client->soap_defencoding = 'UTF-8';
        $this->nusoap_client->decode_utf8 = false;

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
                            $this->papyrus['getShipToAll']
                        );

                $result = $soap_result['GetShipToAllResult'];
                $xml = simplexml_load_string($result);
				$json = json_encode($xml);
				$array = json_decode($json,TRUE);

				// echo "<pre>";
				// print_r($array);
				// echo "</pre>";

				$this->db->truncate('tbt_user_customer');
				if (!empty($array) && array_key_exists('ROW', $array)) {
					foreach ($array['ROW'] as $key => $value) {
						// echo "<pre>";
						// print_r($value);
						// echo "</pre>";
						$data = array(
							'user_id' 		=> $value['USER_ID'],
							'ship_to_id'	=> $value['CUST_ID']
						);
						$this->__ps_project_query->insertObj('tbt_user_customer', $data);
					}
				}
			}
		}

	}

	public function _getDept ($parent, $parent_id=0, $count=0) {

		$function  = "";

		if (array_key_exists('@attributes', $parent)) {
			$dept_id   = $parent['@attributes']['deptId'];
			$dept_name = $parent['@attributes']['deptName'];

			if (array_key_exists('deptCode', $parent['@attributes'])) {
				$function  = substr($parent['@attributes']['deptCode'], 0, 2);
			}
		} else {
			$dept_id   = $parent['deptId'];
			$dept_name = $parent['deptName'];

			if (array_key_exists('deptCode', $parent)) {
				$function  = substr($parent['deptCode'], 0, 2);
			}
		}

		if ( !empty($dept_id) && !empty($dept_name) )	{
			$this->__ps_project_query->insertObj('tbm_department', array('id' => $dept_id, 'title' => $dept_name, 'parent_id' => $parent_id, 'function' => $function));
			if (!empty($parent) && array_key_exists('DEPARTMENT', $parent) && !empty($parent['DEPARTMENT'])) {
				foreach ($parent['DEPARTMENT'] as $key => $value) {
					$this->_getDept($value, $parent['@attributes']['deptId'], $count+1);
				}
			}
		}
	}

	public function updateUserId () {

        $this->load->library("nusoap_lib");
        $this->webservice_url = $this->papyrus['url'];

        error_reporting(0);

        $this->nusoap_client = new nusoap_client($this->webservice_url,true);
        $this->nusoap_client->soap_defencoding = 'UTF-8';
        $this->nusoap_client->decode_utf8 = false;

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
                            $this->papyrus['getUserFunc']
                        );

                $result = $soap_result['GetUsers2Result'];
                $xml = simplexml_load_string($result);
				$json = json_encode($xml);
				$array = json_decode($json,TRUE);

				// echo "<pre>";
				// print_r($array);
				// echo "</pre>";

				// die();
				// $this->db->truncate('tbt_user');
				if (!empty($array) && array_key_exists('FLOW_USER', $array)) {
					foreach ($array['FLOW_USER'] as $key => $user) {
			
						if ($user['USER_CODE'] != "" && $user['USER_ID'] != "") {

							echo $user['USER_CODE'] ." | ".$user['USER_ID'].'<br>';
							$this->__ps_project_query->updateObj('tbt_user', array('employee_id' => $user['USER_CODE']), array('user_id' => $user['USER_ID']));

						}
					}
				}
            }   
        } 
	}

	public function getPositionAll () {

        $this->load->library("nusoap_lib");
        $this->webservice_url = $this->papyrus['url'];

        error_reporting(0);

        $this->nusoap_client = new nusoap_client($this->webservice_url,true);
        $this->nusoap_client->soap_defencoding = 'UTF-8';
        $this->nusoap_client->decode_utf8 = false;

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
                            $this->papyrus['getPositionsAll']
                        );

                $result = $soap_result['GetPositionsAllResult'];
                $xml = simplexml_load_string($result);
				$json = json_encode($xml);
				$array = json_decode($json,TRUE);

				if (!empty($array) && array_key_exists('POSITION', $array)) {
					foreach ($array['POSITION'] as $key => $position) {

						$parent_id = 0;
						if (array_key_exists('PARENT_POS_ID', $position)) {
							$parent_id = $position['PARENT_POS_ID'];
						}

						$this->__ps_project_query->updateObj('tbm_position', array('id' => $position['POS_ID']), array('parent_id' => $parent_id));
					}
				}
			}
		}
	}

	public function getUser ($getDept=false) {

		$this->getDepartmentHierachy();

        $this->load->library("nusoap_lib");
        $this->webservice_url = $this->papyrus['url'];

        error_reporting(0);

        $this->nusoap_client = new nusoap_client($this->webservice_url,true);
        $this->nusoap_client->soap_defencoding = 'UTF-8';
        $this->nusoap_client->decode_utf8 = false;

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
                            $this->papyrus['getUserFunc']
                        );

                $result = $soap_result['GetUsers2Result'];
                $xml = simplexml_load_string($result);
				$json = json_encode($xml);
				$array = json_decode($json,TRUE);

				//coment not update :by nook
				//$this->db->truncate('tbt_user');
				if (!empty($array) && array_key_exists('FLOW_USER', $array)) {
					foreach ($array['FLOW_USER'] as $key => $user) {
			
						if ($user['USER_CODE'] != "") {

							// USER DATA //
							$firstname 	= (!empty($user['FIRST_NAME']) && !is_array($user['FIRST_NAME'])) ? $user['FIRST_NAME'] : '';
							$lastname 	= (!empty($user['LAST_NAME']) && !is_array($user['LAST_NAME'])) ? $user['LAST_NAME'] : '';
							$email 		= (!empty($user['EMAIL']) && !is_array($user['EMAIL'])) ? $user['EMAIL'] : '';
							$phone 		= (!empty($user['PHONE']) && !is_array($user['PHONE'])) ? $user['PHONE'] : '';
							$mobile 	= (!empty($user['MOBILE']) && !is_array($user['MOBILE'])) ? $user['MOBILE'] : '';
							$fax 		= (!empty($user['FAX']) && !is_array($user['FAX'])) ? $user['FAX'] : '';
							$gender 	= (!empty($user['SEX']) && !is_array($user['SEX'])) ? $user['SEX'] : '';

							$data = array(
								'employee_id' 		=> $user['USER_CODE'],
								'user_id'			=> $user['USER_ID'],
								'user_login' 		=> $user['USERNAME'],
								'user_firstname' 	=> $firstname,
								'user_lastname' 	=> $lastname,
								'user_email' 		=> $email,
								'user_phone' 		=> $phone,
								'user_mobile' 		=> $mobile,
								'user_fax' 			=> $fax,
								'gender' 			=> $gender,
								// 'allow_direct_login' => 1,
								// 'allow_tablet_login' => 1
							);

							$user_data = $this->__ps_project_query->getObj('tbt_user', array('employee_id' => $user['USER_CODE']));
							if (!empty($user_data)) {
								$this->__ps_project_query->updateObj('tbt_user', array('employee_id' => $user['USER_CODE']), $data);
							} else {
								$data['allow_direct_login']=1;
								$data['allow_tablet_login']=1;
								$this->__ps_project_query->insertObj('tbt_user', $data);
							}

							//EMPTY USER POSITION (tbt_user_position)
							$this->__ps_project_query->deleteObj('tbt_user_position', array('employee_id' => $user['USER_CODE']));

							// DEPARTMENT DATA //
							$dept_id 	= (!empty($user['DEPT_ID']) && !is_array($user['DEPT_ID'])) ? $user['DEPT_ID'] : 0;

							if ($dept_id > 0) {
								$dept_data = $this->__ps_project_query->getObj('tbm_department', array('id' => $dept_id));
								if (!empty($dept_data)) {
									// POSITION DATA //
									$pos_id 	= (!empty($user['POS_ID']) && !is_array($user['POS_ID'])) ? $user['POS_ID'] : 0;
									if ($pos_id > 0) {
										$pos_name = (!empty($user['POS_NAME']) && !is_array($user['POS_NAME'])) ? $user['POS_NAME'] : '';
										$area_id  = (!empty($user['DEPT_CODE']) && !is_array($user['DEPT_CODE'])) ? substr($user['DEPT_CODE'], 2) : '';

										$pos_data = $this->__ps_project_query->getObj('tbm_position', array('id' => $pos_id));										
										if (empty($pos_data)) {
											$this->__ps_project_query->insertObj('tbm_position', array('id' => $pos_id, 'department_id' => $dept_id, 'title' => $pos_name, 'area_id' => $area_id));										
										} else {
											$this->__ps_project_query->updateObj('tbm_position', array('id' => $pos_id), array('department_id' => $dept_id, 'title' => $pos_name, 'area_id' => $area_id));										
										}
								
										$this->__ps_project_query->insertObj('tbt_user_position', array('employee_id' => $user['USER_CODE'], 'position_id' => $pos_id, 'status' => 'main'));

									}
								}
							}

							// OTHER POSITION DATA //
							if (!empty($user['USER_POSITIONs']) && array_key_exists('USER_POSITION', $user['USER_POSITIONs']) && !empty($user['USER_POSITIONs']['USER_POSITION'])) {

								foreach ($user['USER_POSITIONs']['USER_POSITION'] as $index => $other_position) {

									if (is_array($other_position)) {
										$this->_insertOtherPostiion($user['USER_CODE'], $other_position);
									} else {
										$this->_insertOtherPostiion($user['USER_CODE'], $user['USER_POSITIONs']['USER_POSITION']);
										break;
									}
								}
							}
						}
					}
				}
            }   
        } 

        $this->getPositionAll();
        $this->getShipToAll();
        $this->updateActionPlan();
        
        redirect( site_url('__cms_permission/user_list'), 'refresh' ); 
	}
	function updateActionPlan(){
// 		$sql = "SELECT DISTINCT ka.ship_to_id, assign_to, ua.user_login, u.employee_id, u.user_login
// FROM tbt_keyuser_marked_assign ka
// LEFT JOIN tbt_user ua ON ua.employee_id= ka.assign_to
// LEFT JOIN tbt_user_position upa ON upa.employee_id = ua.employee_id
// LEFT JOIN tbm_position pa ON  pa.id = upa.position_id
// LEFT JOIN tbm_department dea ON dea.id = pa.department_id
// LEFT JOIN tbt_user_customer uc ON  uc.ship_to_id = ka.ship_to_id
// LEFT JOIN tbt_user u ON u.user_id = uc.user_id
// LEFT JOIN tbt_user_position upo ON upo.employee_id = u.employee_id
// LEFT JOIN tbm_position po ON  po.id = upo.position_id
// LEFT JOIN tbm_department deo ON deo.id = po.department_id
// WHERE 1 = 1
// AND assign_to <> u.employee_id
// AND ka.function = deo.function";

		// for test  SELECT DISTINCT ka.ship_to_id, assign_to, ua.user_login, ka.function, ushipto.employee_id, ushipto.user_login, ushipto.function 
		$sql = "
				SELECT DISTINCT ka.ship_to_id, ka.assign_to, ushipto.employee_id
				FROM tbt_keyuser_marked_assign ka
				LEFT JOIN tbt_user ua ON ua.employee_id= ka.assign_to
				LEFT JOIN tbt_user_position upa ON upa.employee_id = ua.employee_id
				LEFT JOIN tbm_position pa ON  pa.id = upa.position_id
				LEFT JOIN tbm_department dea ON dea.id = pa.department_id
				LEFT JOIN ( 
					SELECT uc.ship_to_id, function, MAX(ua.employee_id) as employee_id, MAX(ua.user_login) as user_login
					FROM tbt_user_customer uc
					LEFT JOIN tbt_user ua ON ua.user_id = uc.user_id
					LEFT JOIN tbt_user_position upa ON upa.employee_id = ua.employee_id
					LEFT JOIN tbm_position pa ON  pa.id = upa.position_id
					LEFT JOIN tbm_department dea ON dea.id = pa.department_id 
					GROUP BY uc.ship_to_id, function
					HAVING count(DISTINCT uc.user_id) = 1
				) AS ushipto ON ushipto.ship_to_id = ka.ship_to_id
				WHERE 1 = 1
				AND assign_to <> ushipto.employee_id
				AND ka.function = ushipto.function";
		$results = $this->db->query($sql)->result_array();

		foreach ($results as $key => $value) {
			$this->db->update('tbt_keyuser_marked_assign', array('assign_to'=>$value['employee_id'] ), "ship_to_id = '".$value['ship_to_id']."' AND assign_to = '".$value['assign_to']."' ");

			$this->db->update('tbt_user_marked', array('emp_id'=>$value['employee_id'] ), "ship_to_id = '".$value['ship_to_id']."' AND emp_id = '".$value['assign_to']."' AND action_plan_id = 0");
		}
		return  1;
	}

	function _insertOtherPostiion ($user_id, $position) {

		// DEPARTMENT DATA //
		$dept_id 	= (!empty($position['DEPT_ID']) && !is_array($position['DEPT_ID'])) ? $position['DEPT_ID'] : 0;
		if ($dept_id > 0) {
			$dept_data = $this->__ps_project_query->getObj('tbm_department', array('id' => $dept_id));

			// POSITION DATA //
			if (!empty($dept_data)) {
				$pos_id 	= (!empty($position['POS_ID']) && !is_array($position['POS_ID'])) ? $position['POS_ID'] : 0;
				if ($pos_id > 0) {
					$pos_name = (!empty($position['POS_NAME']) && !is_array($position['POS_NAME'])) ? $position['POS_NAME'] : '';
					$area_id  = (!empty($position['DEPT_CODE']) && !is_array($position['DEPT_CODE'])) ? substr($position['DEPT_CODE'], 2) : '';

					$pos_data = $this->__ps_project_query->getObj('tbm_position', array('id' => $pos_id));										
					if (empty($pos_data)) {
						$this->__ps_project_query->insertObj('tbm_position', array('id' => $pos_id, 'department_id' => $dept_id, 'title' => $pos_name, 'area_id' => $area_id));										
					}else {
						$this->__ps_project_query->updateObj('tbm_position', array('id' => $pos_id), array('department_id' => $dept_id, 'title' => $pos_name, 'area_id' => $area_id));										
					}

					$this->__ps_project_query->insertObj('tbt_user_position', array('employee_id' => $user_id, 'position_id' => $pos_id, 'status' => 'other'));

				}
			}
		}
	}
	
	function group_list ($page=1) {

		$menuConfig['page_id'] 	  = 'group';

		#CMS
		$this->pageSize = PAGESIZE;
		$this->table = 'cms_user_group';
		$this->page_id = 'group';
		$this->page_title = 'Group';
		$this->page_object = 'group';
		$this->page_controller = '__cms_permission';
		#END_CMS

		//Load top menu
		$data['top_menu'] = $this->load->view('__cms/include/top',$menuConfig,true);//return view as data

		//Load side menu
		$data['side_menu'] = $this->load->view('__cms/include/side',$menuConfig,true);//return view as data

		//Load body
		$config 	   = $this->loadCMSCfg('group');
		$group_list    = $this->user->getGroupAll($page);

		$modal_data = array(
			'group_list' 	=> $group_list
		);
		
		$data['modal'] = $this->load->view('__cms/permission/user_group_modal',$modal_data,true);//return view as data

		$list = $this->user->listviewcfg($config,$page);
		$list['config'] = $config;

		$data['body'] = $this->load->view('__cms/permission/user_group_body',$list,true);//return view as data

		//Load footage script 
		$data['footage_script'] = $this->load->view('__cms/script/permission/user_group_js','',true);;

		$this->load->view('__cms/layout/list',$data);
	}

	function department_group_list ($page=1) {

		$menuConfig['page_id'] 	  = 'departmentGroup';

		#CMS
		$this->pageSize = PAGESIZE;
		$this->table = 'cms_group_permission';
		$this->page_id = 'department_group';
		$this->page_title = 'Department Group';
		$this->page_object = 'department_group';
		$this->page_controller = '__cms_permission';
		#END_CMS

		//Load top menu
		$data['top_menu'] = $this->load->view('__cms/include/top',$menuConfig,true);//return view as data

		//Load side menu
		$data['side_menu'] = $this->load->view('__cms/include/side',$menuConfig,true);//return view as data

		//Load body
		$config 	   = $this->loadCMSCfg('department_group');
		$deptGroup_list = $this->user->getDepartmentGroupAll($page);
		$module_list = $this->user->getModuleAll(false);

		$modal_data = array(
			'department_group_list' => $deptGroup_list,
			'module_list'=> $module_list
		);
		
		$data['modal'] = $this->load->view('__cms/permission/department_group_modal',$modal_data,true);//return view as data

		$list = $this->user->listviewcfg($config,$page);
		$list['config'] = $config;

		$data['body'] = $this->load->view('__cms/permission/department_group_body',$list,true);//return view as data

		//Load footage script 
		$data['footage_script'] = $this->load->view('__cms/script/permission/department_group_js','',true);;

		$this->load->view('__cms/layout/list',$data);
	}


	function key_user_list ($page=1) {

		$menuConfig['page_id'] 	  = 'keyUserModule';

		#CMS
		$this->pageSize = PAGESIZE;
		$this->table = 'tbm_keyuser_modules';
		$this->page_id = 'key_user_module';
		$this->page_title = 'Key User Module';
		$this->page_object = 'key_user_module';
		$this->page_controller = '__cms_permission';
		#END_CMS

		//Load top menu
		$data['top_menu'] = $this->load->view('__cms/include/top',$menuConfig,true);//return view as data

		//Load side menu
		$data['side_menu'] = $this->load->view('__cms/include/side',$menuConfig,true);//return view as data

		//Load body
		$config 	  = $this->loadCMSCfg('keyuser_module');
		$keyUser_list = $this->user->getKeyUser();
		$keyUserModule_list = $this->user->getKeyUserModuleAll($page);
		$module_list  = $this->user->getSelModuleAll(false);

		$modal_data = array(
			'keyUser_list' 	=> $keyUser_list,
			'module_list'	=> $module_list,
			'keyUserModule_list' => $keyUserModule_list
		);
		
		$data['modal'] = $this->load->view('__cms/permission/keyuser_module_modal',$modal_data,true);//return view as data

		$list = $this->user->listviewcfg($config,$page);
		$list['config'] = $config;

		$data['body'] = $this->load->view('__cms/permission/keyuser_module_body',$list,true);//return view as data

		//Load footage script 
		$data['footage_script'] = $this->load->view('__cms/script/permission/keyuser_module_js','',true);;

		$this->load->view('__cms/layout/list',$data);
	}

	function permission_area_list ($page=1) {

		$menuConfig['page_id'] 	  = 'permissionArea';

		#CMS
		$this->pageSize = PAGESIZE;
		$this->table = 'tbm_permission_area_team';
		$this->page_id = 'permission_area';
		$this->page_title = 'Permission Area';
		$this->page_object = 'permission_area';
		$this->page_controller = '__cms_permission';
		#END_CMS

		//Load top menu
		$data['top_menu'] = $this->load->view('__cms/include/top',$menuConfig,true);//return view as data

		//Load side menu
		$data['side_menu'] = $this->load->view('__cms/include/side',$menuConfig,true);//return view as data

		//Load body
		$list['keyUser_list'] = $this->user->getKeyUser();
		$list['department_list'] = $this->user->getAreaDepartment();
		$list['team_list'] = $this->user->getPermissionAreaTeam();
		
		// echo "<pre>";
		// print_r($list['team_list']);
		// echo "</pre>";
		// die();
		$data['modal'] = $this->load->view('__cms/permission/permission_team_modal',$list,true);//return view as data

		$data['body'] = $this->load->view('__cms/permission/permission_team_body',$list,true);//return view as data

		//Load footage script 
		$data['footage_script'] = $this->load->view('__cms/script/permission/permission_area_js','',true);;

		$this->load->view('__cms/layout/list',$data);
	}


    public function permission_area_team_member () {

        $p = $this->input->post();
        // echo "<pre>";
        // print_r($p);
        // echo "</pre>";
		$this->user->insertPermissionAreaMember($p);

		redirect(site_url('__cms_permission/permission_area_list'), 'refresh');
    }

	function permission_area_team_get () {

		$p = $this->input->post();
		$team_data = $this->user->getTeamMember($p['id'], $p['code']);

		if (!empty($team_data)) {
			echo json_encode($team_data);
			return;
		} 

		echo 0;
	}

	function permission_team_create () {

		$p = $this->input->post();
		$this->user->insertPermissionArea($p);

		redirect(site_url('__cms_permission/permission_area_list'), 'refresh');
	}

	function permission_team_edit () {

		$p = $this->input->post();
		$this->user->updatePermissionArea($p);

		redirect(site_url('__cms_permission/permission_area_list'), 'refresh');
	}

	function permission_team_delete () {

		$p = $this->input->post();
		$this->user->deletePermissionArea($p);

		redirect(site_url('__cms_permission/permission_area_list'), 'refresh');
	}

	function keyuser_module_create() {

		$p = $this->input->post();
		$this->user->insertKeyUsermodule($p);
	}

	function keyuser_module_edit () {

		$p = $this->input->post();
		$this->user->updateKeyUsermodule($p);
	}

	function keyuser_module_delete() {

		$p = $this->input->post();
		$this->user->deleteKeyUsermodule($p['id']);
	}

	function department_group_edit() {

		$p = $this->input->post();
		$this->user->updateDepartmentGroup($p);
	}

	function department_create() {

		$p = $this->input->post();
		$this->user->insertDepartment($p);
	}

	function department_edit() {

		$p = $this->input->post();
		$this->user->updateDepartment($p);
	}

	function delete_department () {
		
		$p = $this->input->post();
		$this->user->deleteDepartment($p['id']);
	}

	function group_create() {

		$p = $this->input->post();
		$this->user->insertGroup($p);
	}

	function user_create() {

		$p = $this->input->post();
		$this->user->insert($p);
	}

	function user_edit() {

		$p = $this->input->post();
		$this->user->update($p);
	}

	function group_edit() {

		$p = $this->input->post();
		$this->user->updateGroup($p);
	}

	function delete_user() {

		$p = $this->input->post();
		$this->user->delete($p['id']);
	}

	function delete_group () {
		
		$p = $this->input->post();
		$this->user->deleteGroup($p['id']);
	}

	function permission_category() {

		$p = $this->input->post();
		$this->user->updatePermissionGroup($p);
	}

	function reset_password_admin () {

		$p 	   = $this->input->post();
		$email = $this->user->resetPassword($p['id']);

		if ($email) {
			$message = "Your password has been reset to <b>password</b> by admin.";
			$sender = array (
				"email" => "no-reply@bossup.co.th",
				"name"  => "MewMew Admin"
			);
			$receiver = array (
				"to" => $email
			);
			parent::_sendEmail('Reset Password by Admin', $message, $sender, $receiver);
		}
	}

	###########################################################
    # Forgot password function
    ###########################################################
	function forgot_password ($input='') {

		$p = $this->input->post();

		if ($input != '') {		
			if (!empty($p['forgot_submit']) && !empty($p['password']) && !empty($p['id']) && !empty($p['email'])) {

				###########################################################
		        # Get new password to reset
		        ###########################################################
				$success = $this->user->resetPassword($p['id'], $p['password'], false);

				if ($success) {
					$subject = 'Reset password successfully';
					$message = 'Your password has been reset.';

					$sender = array (
						"email" => "no-reply@bossup.co.th",
						"name"  => "MewMew Admin"
					);
					$receiver = array (
						"to" => $p['email']
					);

					parent::_sendEmail($subject, $message, $sender, $receiver);

					###########################################################
			        # RESET SUCCESS (redirect to login page)
			        ###########################################################
					echo 'Reset successfully.';
				} else {
					echo "Reset fail.";
				}

			}  else {
				###########################################################
		        # URL with encoded code with get username
		        ###########################################################
				$code = urldecode($input);
				$code = str_replace(',', '/', $code);
				$encypted = parent::_decrypt($code);

				$encypted_arr 	= explode('|', $encypted);
				$user_name 		= $encypted_arr[0];

				$user 				= $this->user->getByField(array('cms_users.user_login' => $user_name));
				$data['page_title'] = 'Reset Password';
				$data['id'] 		= $user->id;
				$data['email'] 		= $user->user_email;
				
				$this->load->view('__cms/permission/forgot_password', $data);
			}


		} else {
			###########################################################
	        # URL without encoded code
	        ###########################################################

			//TODO: remove later
			$p['send_forgot_mail'] = 'submit';
			$p['email'] = 'miss_sangium@windowslive.com';
			
			if (!empty($p['send_forgot_mail']) && !empty($p['email'])) {

				###########################################################
		        # Request for reset link send via email
		        ###########################################################
				$email = $p['email'];
				$user = $this->user->getByField(array('cms_users.user_email' => $email));

				if (!empty($user)) {

					###########################################################
			        # Email exist
			        ###########################################################
					$subject = 'Reset password';
					$message = 'Please click below link to reset your password<br>';

					$word 	 = $user->user_login.'|'.date('Y-m-d H-i-s');
					$code    = parent::_encrypt($word);
					$code    = str_replace('/', ',', $code);
					$code    = urlencode($code);
					$link 	 = my_url('__cms_permission/forgot_password/'.$code);

					$message .= '<a href="'.$link.'">Reset here</a>';

					$sender = array (
						"email" => "no-reply@bossup.co.th",
						"name"  => "MewMew Admin"
					);
					$receiver = array (
						"to" => $email
					);

					parent::_sendEmail($subject, $message, $sender, $receiver);

					echo 'Email hass been sent to '.$email;
				}
			}
		}
	}




//#################################################
//============= SYNC master complain ==============
//#################################################
public function syn_problem_type(){
echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
	$this->load->library("nusoap_lib");
	$this->webservice_url = $this->papyrus['url'];

	$this->nusoap_client = new nusoap_client($this->webservice_url,true);
	$this->nusoap_client->soap_defencoding = 'UTF-8';
	$this->nusoap_client->decode_utf8 = false;

 	$params = array(
       'cfId' => 15
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
	        $soap_result = $this->nusoap_client->call(
		        $this->papyrus['pbTypeFunc'],
		        $params
        	);

		    // echo "<pre>";
		    // print_r($soap_result);
		    // echo "</pre>";
		    $result = $soap_result['GetCustomDataResult'];
		    $result = str_replace("<![CDATA[", "", $result);
		   	$result = str_replace("]]>", "", $result);

		    // echo "<pre>";
		    // print_r($result);
		    // echo "</pre>";

		    $xml = simplexml_load_string($result);
			$json = json_encode($xml);
			$array = json_decode($json,TRUE);

			echo "<pre>";
	        print_r($array['DataRows']['DataRow']);
	        echo "</pre>";
	       	
	       	//TODO :: delete ppr_tbm_problem_type
	        $this->db->where('ppr_tbm_problem_type.id !=', 'NULL');
	        $query_delete=$this->db->delete('ppr_tbm_problem_type');

	       	foreach ($array['DataRows']['DataRow'] as $key => $value) {
	       		 if($value['Id']!=0){       		
       			   echo "id : ".$value['Id'].'<br>';
       			   echo "des :".$value['Description'].'<br>';	  

			       $this->load->model('__complain_model','complain');
	 			   $result = $this->complain->zyn_pb_type($value['Id'],$value['Description']); 
	 			   echo 'msg : '.$result['msg'].'<br>';
	       		}//end if
	       	}

	      

	    }
	}

}//end zyn pb type




public function syn_problem_list(){
echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
	$this->load->library("nusoap_lib");
	$this->webservice_url = $this->papyrus['url'];

	$this->nusoap_client = new nusoap_client($this->webservice_url,true);
	$this->nusoap_client->soap_defencoding = 'UTF-8';
	$this->nusoap_client->decode_utf8 = false;

 	$params = array(
       'cfId' => 16
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
	        $soap_result = $this->nusoap_client->call(
		        $this->papyrus['pbTypeFunc'],
		        $params
        	);

		    // echo "<pre>";
		    // print_r($soap_result);
		    // echo "</pre>";
		    $result = $soap_result['GetCustomDataResult'];		   
		    $result = str_replace("<![CDATA[", "", $result);
		   	$result = str_replace("]]>", "", $result);
		    // echo "<pre>";
		    // print_r($result);
		    // echo "</pre>";
		   	//echo $result;

		   	$xml = simplexml_load_string($result);
			$json = json_encode($xml);
			$array = json_decode($json,TRUE);

			
			echo "<pre>";
	        print_r($array['DataRows']['DataRow']);
	        echo "</pre>";
	       	
	       // 	//TODO :: delete ppr_tbm_problem_type
	       //  $this->db->where('ppr_tbm_problem_list.id !=', 'NULL');
	       //  $query_delete=$this->db->delete('ppr_tbm_problem_list');

	       // 	foreach ($array['DataRows']['DataRow'] as $key => $value) {
	       // 		 if($value['Id']!=0){       		
       	// 		   echo "id : ".$value['Id'].'<br>';
       	// 		   echo "des :".$value['Description'].'<br>';
       	// 		   echo "type_id :".$value['Key'].'<br>';
       	// 		   echo "day :".$value['Day'].'<br>';	  

			     //   $this->load->model('__complain_model','complain');
	 			   // $result = $this->complain->zyn_pb_list($value['Id'],$value['Description'],$value['Key'],$value['Day']); 
	 			   // echo 'msg : '.$result['msg'].'<br>';
	       // 		}//end if
	       // 	}

	      

	    }
	}

}//end zyn pb type






public function syn_custom_data(){
echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
	$this->load->library("nusoap_lib");
	$this->webservice_url = $this->papyrus['url'];

	$this->nusoap_client = new nusoap_client($this->webservice_url,true);
	$this->nusoap_client->soap_defencoding = 'UTF-8';
	$this->nusoap_client->decode_utf8 = false;

 	$params = array(
       'cfId' => 22
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
	        $soap_result = $this->nusoap_client->call(
		        $this->papyrus['getCustomData'],
		        $params
        	);

		    // echo "<pre>";
		    // print_r($soap_result);
		    // echo "</pre>";
		    $result = $soap_result['GetCustomDataResult'];

		    // echo "<pre>";
		    // print_r($result);
		    // echo "</pre>";

		    $xml = simplexml_load_string($result);
			$json = json_encode($xml);
			$array = json_decode($json,TRUE);

			echo "<pre>";
	        print_r($array['DataRows']['DataRow']);
	        echo "</pre>";
	   
	        //TODO :: delete ppr_tbm_problem_type
	        $this->db->where('ppr_tbm_type_complain.id !=', 'NULL');
	        $query_delete=$this->db->delete('ppr_tbm_type_complain');

	       	foreach ($array['DataRows']['DataRow'] as $key => $value) {
	       		 if($value['MethodId']!=0){       		
       			   echo "id : ".$value['MethodId'].'<br>';
       			   echo "title :".$value['MethodName'].'<br>';
       			   
			       $this->load->model('__complain_model','complain');
	 			   $result = $this->complain->zyn_type_complain($value['MethodId'],$value['MethodName']); 
	 			   echo 'msg : '.$result['msg'].'<br>';
	       		}//end if
	       	}
	      

	    }
	}

}//end zyn pb type


public function save_config_login(){

	$this->load->model('__ps_project_query');	
	$p = $this->input->post();

	if (!array_key_exists('allow_mobile_login', $p)) {
		$p['allow_mobile_login'] = '0';
	}

	if (!array_key_exists('allow_direct_login', $p)) {
		$p['allow_direct_login'] = '0';
	}

	if (!array_key_exists('allow_tablet_login', $p)) {
		$p['allow_tablet_login'] = '0';
	}

	if(!empty($p)){
		// echo "<pre>";
		// print_r($p);

		$this->__ps_project_query->updateObj('tbt_user', array('employee_id' => $p['employee_id']),array('allow_mobile_login' => $p['allow_mobile_login'],'allow_direct_login' => $p['allow_direct_login'],'allow_tablet_login' => $p['allow_tablet_login']) );
		redirect(site_url('__cms_permission/user_list'));
		//echo '<script> window.location="'.site_url('__cms_permission/user_list').'"; </script>';
	}

}



}
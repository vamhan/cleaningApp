<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class __cms_user extends REST_Model{

    function __construct(){
        parent::__construct();

        if(!isset($this->pageSize) || empty($this->pageSize)){
            $this->pageSize = PAGESIZE;
        }

        $page_n = intval($this->session->userdata('current_page'));
        if(!empty($page_n)){
             $this->pageSize = $page_n;
        }

        /*$this->uid = 0;
        $this->pathConfig = array();
        $this->keyx = '';
        $this->notification_message = array(
            0=>array('head'=>'Hey there is new "','tail'=>'" ,Waiting for you to checkout.'),
            1=>array('head'=>'Hello there. New "','tail'=>'" ,Ready for you to checkout.'),
            2=>array('head'=>'Hi new "','tail'=>'" ,Let\'s have a look at it.'),
            3=>array('head'=>'Yo!! Would you like to checkout new "','tail'=>'" ,Let me show you.'),
            4=>array('head'=>'Hi there is "','tail'=>'" ,Let\'s go check it out.'),
            5=>array('head'=>'Yeah!! New "','tail'=>'" ,Tap on this message to checkout.')
        );

        //Modify 10/14/2013
        $this->load->library("nusoap_lib");
        $this->webservice_url = "http://116.246.12.67:8090/web/ws_member.asmx?WSDL";
        $this->webservice_usercode = "BE";
        $this->webservice_userpass = "123";*/
    }

    //Testing
    public function getFieldSet($fieldset, $table) {
        parent::getFieldSet($fieldset, $table);
    }

    public function insert( $p ){

        $data = array(
            'group_id'          => $p['group_id'],
            'employee_id'       => $p['employee_id'],
            'user_login'        => $p['user_login'],
            'user_password'     => md5(md5($p['user_password'])),
            'user_firstname'    => $p['user_firstname'],
            'user_lastname'     => $p['user_lastname'],
            'user_email'        => $p['user_email'],
            'create_date'       => date('Y-m-d h:i:s'),
            'department_id'     => $p['department_id']
        );

        $this->db->insert('cms_users', $data);
        $insert_id = $this->db->insert_id();

        /*$cat_list = $this->module_model->getCategoryAll();
        foreach ($cat_list as $category) {
            $cat_id = $category->id;
            $cat_set = '';
            for ($i = 0 ; $i < 4 ; $i++) {
                if (!empty($p['category_'.$cat_id.'_'.$i])) {
                    $cat_set .= '1';
                } else {
                    $cat_set .= '0';
                }
            }

            $cat_set = base_convert($cat_set, 2, 10);
            if ($cat_set != 0) {
                $this->db->insert('cms_user_permission', array('user_id' => $insert_id, 'cat_id' => $cat_id, 'permission_type' => $cat_set));
            }
        }*/

        log_transaction('create', 'cms_users', $insert_id, 'success');
    }

    public function update( $p) {

        $data = array(
            'user_login'        => $p['user_login'],
            'group_id'          => $p['group_id'],
            'user_firstname'    => $p['user_firstname'],
            'user_lastname'     => $p['user_lastname'],
            'user_email'        => $p['user_email'],
            'is_enable'         => $p['is_enable'],
            'department_id'     => $p['department_id']
        );
        $this->db->where('id', $p['id']);
        $this->db->update('cms_users', $data);

        $this->db->delete('cms_user_permission', array('user_id' => $p['id'])); 

        /*$cat_list = $this->module_model->getCategoryAll();
        foreach ($cat_list as $category) {
            $cat_id = $category->id;
            $cat_set = '';
            for ($i = 0 ; $i < 4 ; $i++) {
                if (!empty($p['category_'.$cat_id.'_'.$i])) {
                    $cat_set .= '1';
                } else {
                    $cat_set .= '0';
                }
            }

            $cat_set = base_convert($cat_set, 2, 10);
            if ($cat_set != 0) {
                $this->db->insert('cms_user_permission', array('user_id' => $p['id'], 'cat_id' => $cat_id, 'permission_type' => $cat_set));
            }
        }*/

        log_transaction('update', 'cms_users', $p['id'], 'success');
    }   

    public function resetPassword($id, $passwd='password', $is_admin=true) {

        $data = array(
            'user_password' => md5(md5($passwd))
        );
        $this->db->where('id', $id);
        $this->db->update('cms_users', $data);

        log_transaction('reset_password', 'cms_users', $id, 'success');

        if ($is_admin) {
            $this->db->select('user_email');
            $this->db->from('cms_users');
            $this->db->where('id', $id);
            $query      = $this->db->get();
            $user_data  = $query->row();

            if ( !empty($user_data) ) {
                return $user_data->user_email;
            }

        } else {
            return 1;
        }

    }

    public function insertPermissionAreaMember ( $p ) {

        $code = $p['code'];

        $data =array();
        if ($p['dept'] == 'SALES') {
            $this->db->where('sales_area_id', $code);
            $data['sales_area_id'] = 0;
        } else if ($p['dept'] == 'OPERATION') {
            $this->db->where('operation_area_id', $code);
            $data['operation_area_id'] = 0;
        }
        $this->db->update('cms_users' ,$data);

        $member_list = preg_grep("/^member_/",array_keys($p));
        foreach ($member_list as $key => $member) {
            $employee_id = $p[$member];

            $data = array();
            if ($p['dept'] == 'SALES') {
                $data['sales_area_id'] = $code;
            } else if ($p['dept'] == 'OPERATION') {
                $data['operation_area_id'] = $code;
            }
            $this->db->where('employee_id', $employee_id);
            $this->db->update('cms_users', $data);
        }

    }

    public function insertKeyUsermodule ($data) {
        $this->db->insert('tbm_keyuser_modules', $data);
        $insert_id = $this->db->insert_id();
        log_transaction('create', 'tbm_keyuser_modules', $insert_id, 'success');
    }

    public function insertPermissionArea ( $p ) {

        $data = array(
            'title' => $p['title'],
            'department_id' => $p['department_id']
        );

        $this->db->insert('tbm_permission_area_team', $data);
        $id = $this->db->insert_id();

        $group_list = preg_grep("/^group_code/",array_keys($p));
        foreach ($group_list as $key => $group) {
            $code = $p[$group];

            $this->db->insert('tbm_permission_area', array('code' => $code, 'area_team_id' => $id));
        }

        $manager_list = preg_grep("/^manager_/",array_keys($p));
        foreach ($manager_list as $key => $manager) {
            $manager_id = $p[$manager];

            $this->db->insert('tbm_manager_map_team', array('manager_id' => $manager_id, 'area_team_id' => $id));
        }
    }

    public function insertDepartment ( $p ) {

        $fields = parent::getFieldSet(array('name'), 'cms_user_department');
        foreach ($fields as $field) {
            $data[$field] = $p[$field];
        }

        $this->db->insert('cms_user_department', $data);
        $insert_id = $this->db->insert_id();

        log_transaction('create', 'cms_user_department', $insert_id, 'success');
    }

    public function updatePermissionArea ( $p ) {

        $id = $p['id'];

        $this->db->select('tbm_permission_area_team.department_id, cms_user_department.name, tbm_permission_area.code as area_code');
        $this->db->join('cms_user_department', 'cms_user_department.id = tbm_permission_area_team.department_id');
        $this->db->join('tbm_permission_area', 'tbm_permission_area.area_team_id = tbm_permission_area_team.id');
        $this->db->where('tbm_permission_area_team.id', $id);
        $query = $this->db->get('tbm_permission_area_team');
        $obj_list = $query->result_array();

        if (!empty($obj_list)) {

            $sel_group = array();
            $group_list = preg_grep("/^group_code/",array_keys($p));
            foreach ($group_list as $key => $group) {
                $code = $p[$group];
                array_push($sel_group, $code);
            }

            foreach ($obj_list as $key => $obj) {
                if ($obj['department_id'] != $p['department_id'] || !in_array($obj['area_code'], $sel_group)) {
                    if ($obj['name'] == 'SALES') {
                        $this->db->where('sales_area_id', $obj['area_code']);
                        $this->db->update('cms_users', array('sales_area_id' => 0));
                    } else if ($obj['name'] == 'OPERATION') {
                        $this->db->where('operation_area_id', $obj['area_code']);
                        $this->db->update('cms_users', array('operation_area_id' => 0));
                    }
                }
            }
        }

        $data = array(
            'title' => $p['title'],
            'department_id' => $p['department_id']
        );

        $this->db->where('id', $id);
        $this->db->update('tbm_permission_area_team', $data);

        $this->db->delete('tbm_permission_area', array('area_team_id' => $id));
        $group_list = preg_grep("/^group_code/",array_keys($p));
        foreach ($group_list as $key => $group) {
            $code = $p[$group];

            $this->db->insert('tbm_permission_area', array('code' => $code, 'area_team_id' => $id));
        }

        $this->db->delete('tbm_manager_map_team', array('area_team_id' => $id));
        $manager_list = preg_grep("/^manager_/",array_keys($p));
        foreach ($manager_list as $key => $manager) {
            $manager_id = $p[$manager];

            $this->db->insert('tbm_manager_map_team', array('manager_id' => $manager_id, 'area_team_id' => $id));
        }
    }

    public function deletePermissionArea ( $p ) {

        $id = $p['id'];

        $this->db->select('tbm_permission_area_team.department_id, cms_user_department.name, tbm_permission_area.code as area_code');
        $this->db->join('cms_user_department', 'cms_user_department.id = tbm_permission_area_team.department_id');
        $this->db->join('tbm_permission_area', 'tbm_permission_area.area_team_id = tbm_permission_area_team.id');
        $this->db->where('tbm_permission_area_team.id', $id);
        $query = $this->db->get('tbm_permission_area_team');
        $obj_list = $query->result_array();

        if (!empty($obj_list)) {
            foreach ($obj_list as $key => $obj) {
                if ($obj['name'] == 'SALES') {
                    $this->db->where('sales_area_id', $obj['area_code']);
                    $this->db->update('cms_users', array('sales_area_id' => 0));
                } else if ($obj['name'] == 'OPERATION') {
                    $this->db->where('operation_area_id', $obj['area_code']);
                    $this->db->update('cms_users', array('operation_area_id' => 0));
                }
            }
        }

        $this->db->delete('tbm_permission_area', array('area_team_id' => $id));
        $this->db->delete('tbm_manager_map_team', array('area_team_id' => $id));
        $this->db->delete('tbm_permission_area_team', array('id' => $id));

    }

    public function updateDepartmentGroup ( $p ) {

        /*$fields = parent::getFieldSet(array('name'), 'cms_user_department');
        foreach ($fields as $field) {
            $data[$field] = $p[$field];
        }*/

        $this->db->delete('cms_group_permission', array('group_id' => $p['group_id'], 'dept_id' => $p['dept_id'])); 

        $module_list = $this->module_model->getModuleAll(false);
        foreach ($module_list as $module) {
            $cat_id = $module['id'];
            $cat_set = '';
            for ($i = 0 ; $i < 5 ; $i++) {
                if (!empty($p['module_'.$cat_id.'_'.$i])) {
                    $cat_set .= '1';
                } else {
                    $cat_set .= '0';
                }
            }

            $cat_set = base_convert($cat_set, 2, 10);
            if ($cat_set != 0) {
                $this->db->insert('cms_group_permission', array('dept_id' => $p['dept_id'], 'group_id' => $p['group_id'], 'cat_id' => $cat_id, 'permission_type' => $cat_set));
            }
        }

        log_transaction('update', 'cms_group_permission', $p['dept_id'].'_'.$p['group_id'], 'success');
    }


    public function updateKeyUsermodule ($data) {

        $this->db->where('module_id', $data['module_id']);
        $this->db->update('tbm_keyuser_modules', array('keyuser_emp_id' => $data['keyuser_emp_id']));

        log_transaction('update', 'tbm_keyuser_modules', $data['module_id'], 'success');
    }

    public function updateDepartment( $p ) {
    
        $fields = parent::getFieldSet(array('name'), 'cms_user_department');
        foreach ($fields as $field) {
            $data[$field] = $p[$field];
        }

        $this->db->where('id', $p['id']);
        $this->db->update('cms_user_department', $data);

        log_transaction('update', 'cms_user_department', $p['id'], 'success');
    }

    public function deleteKeyUsermodule ($id) {

        $this->db->delete('tbm_keyuser_modules', array('module_id' => $id)); 

        log_transaction('delete', 'tbm_keyuser_modules', $id, 'success');
    }

    public function deleteDepartment($id) {

        $this->db->where('department_id', $id);
        $this->db->update('cms_users', array('group_id' => ''));

        //$this->db->delete('cms_group_permission', array('group_id' => $id)); 
        $this->db->delete('cms_user_department', array('id' => $id)); 

        log_transaction('delete', 'cms_user_department', $id, 'success');
    }

    public function insertGroup ( $p ) {

        $fields = parent::getFieldSet(array('name'), 'cms_user_group');
        foreach ($fields as $field) {
            $data[$field] = $p[$field];
        }

        $this->db->insert('cms_user_group', $data);
        $insert_id = $this->db->insert_id();

        /*$cat_list = $this->module_model->getCategoryAll();
        foreach ($cat_list as $category) {
            $cat_id = $category->id;
            $cat_set = '';
            for ($i = 0 ; $i < 4 ; $i++) {
                if (!empty($p['category_'.$cat_id.'_'.$i])) {
                    $cat_set .= '1';
                } else {
                    $cat_set .= '0';
                }
            }

            $cat_set = base_convert($cat_set, 2, 10);
            if ($cat_set != 0) {
                $this->db->insert('cms_group_permission', array('group_id' => $insert_id, 'cat_id' => $cat_id, 'permission_type' => $cat_set));
            }
        }*/


        log_transaction('create', 'cms_user_group', $insert_id, 'success');
    }

    public function updateGroup( $p ) {
    
        $fields = parent::getFieldSet(array('name'), 'cms_user_group');
        foreach ($fields as $field) {
            $data[$field] = $p[$field];
        }

        $this->db->where('id', $p['id']);
        $this->db->update('cms_user_group', $data);

        /*$this->db->delete('cms_group_permission', array('group_id' => $p['id'])); 

        $cat_list = $this->module_model->getCategoryAll();
        foreach ($cat_list as $category) {
            $cat_id = $category->id;
            $cat_set = '';
            for ($i = 0 ; $i < 4 ; $i++) {
                if (!empty($p['category_'.$cat_id.'_'.$i])) {
                    $cat_set .= '1';
                } else {
                    $cat_set .= '0';
                }
            }

            $cat_set = base_convert($cat_set, 2, 10);
            if ($cat_set != 0) {
                $this->db->insert('cms_group_permission', array('group_id' => $p['id'], 'cat_id' => $cat_id, 'permission_type' => $cat_set));
            }
        }*/

        log_transaction('update', 'cms_user_group', $p['id'], 'success');
    }

    public function updatePermissionGroup ($p) {

        $this->db->delete('cms_group_permission', array('cat_id' => $p['id'])); 
        $group_list = $this->getGroupAll();
        foreach ($group_list as $group) {
            $groupid = $group['id'];
            $group_set = '';
            for ($i = 0 ; $i < 4 ; $i++) {
                if (!empty($p['category_'.$groupid.'_'.$i])) {
                    $group_set .= '1';
                } else {
                    $group_set .= '0';
                }
            }

            $group_set = base_convert($group_set, 2, 10);
            if ($group_set != 0) {
                $this->db->insert('cms_group_permission', array('group_id' => $groupid, 'cat_id' => $p['id'], 'permission_type' => $group_set));
            }

            log_transaction('update', 'cms_group_permission', $groupid, 'success');
        }
    }


    public function listviewCfg($config, $page){
        
        $table = $config['table']['primary_table']['table_name'];

        if ($table == 'cms_users') {
            $result = self::getAll($page, $config);
            $total  = self::getResultTotalpage('tbt_user');        
        }
        if ($table == 'cms_user_group') {
            $result = self::getGroupAll($page);
            $total  = self::getResultTotalpage($table);
        }
        if ($table == 'cms_user_department') {
            $result = self::getDepartmentAll($page);
            $total  = self::getResultTotalpage($table);
        }
        if ($table == 'cms_group_permission') {
            $result = self::getDepartmentGroupAll($page);
            $total  = self::getResultTotalpage($table);
        }
        if ($table == 'tbm_keyuser_modules') {
            $result = self::getKeyUserModuleAll($page);
            $total  = self::getResultTotalpage($table);
        }
        
            $output = array();
                $state = true;
                $code = '000';
                $msg = '';
                $output['total_item'] = $total;
                $output['list'] = $result;
                $output['page'] = $page;
                $output['page_size'] = $this->pageSize;                 
             //echo self::getResultTotalpage($table)."|".$this->pageSize;

                $output['total_page'] = ceil($total/$this->pageSize);

        return self::response($state,$code,$msg,$output);
    }

    public function getAllGroup () {
       $query = $this->db->get('tbm_group');
       return $query->result_array();
    }

    public function getKeyUser () {
       $this->db->select('tbt_user.*, tbm_group.title as group_name');
       $this->db->from('tbt_user');
       $this->db->join('tbt_user_position', 'tbt_user.employee_id = tbt_user_position.employee_id and tbt_user_position.status = "main"', 'left'); 
       $this->db->join('tbm_position', 'tbt_user_position.position_id = tbm_position.id', 'left'); 
       $this->db->join('tbm_group', 'tbm_position.group_id = tbm_group.id', 'left');    
       $this->db->like('LOWER(tbm_group.title)', 'manager');
       $this->db->or_like('LOWER(tbm_group.title)', 'supervisor');

       $query = $this->db->get();
       $result = $query->result();

       return $result;
    }

    public function getAllPosition () {

       $this->db->select('tbm_position.*, tbm_group.title as group_name, tbm_department.title as department_name');
       $this->db->join('tbm_group', 'tbm_position.group_id = tbm_group.id', 'left');  
       $this->db->join('tbm_department', 'tbm_position.department_id = tbm_department.id', 'left');  

       $p = $this->input->post();
       if (!empty($p['search'])) {
           $this->db->like('LOWER(tbm_position.id)', strtolower($p['search']));
           $this->db->or_like('LOWER(tbm_position.title)', strtolower($p['search']));
           $this->db->or_like('LOWER(tbm_group.title)', strtolower($p['search']));
           $this->db->or_like('LOWER(tbm_department.title)', strtolower($p['search']));
       }
       $query = $this->db->get('tbm_position');
       $data['result'] = $query->result_array();

       return $data;
    }

    public function getAllDepartment () {

       $p = $this->input->post();
       if (!empty($p['search'])) {
           $this->db->like('LOWER(title)', strtolower($p['search']));
       }

       $query = $this->db->get('tbm_department');
       $department_list = $query->result_array();

       if (!empty($department_list)) {
           foreach ($department_list as $key => $department) {

               $department_list[$key]['module_list'] = array();

               $this->db->where('department_id', $department['id']);
               $query = $this->db->get('tbm_department_module');
               $dept_module = $query->result_array();
               if (!empty($dept_module)) {
                   foreach ($dept_module as $module) {
                       array_push($department_list[$key]['module_list'], $module['module_id']);
                   }
               }
           }
       }
       return $department_list;
    }

    public function getAll($page=1, $config=null) {

        $offset = 0;
        $items = 100;
        if(intval($page)<1){
            return self::response(false,'909','Invalid page number',array());
        }
        $offset = (intval($page)-1)*$this->pageSize;
        $items = $this->pageSize;

        $table = $config['table']['primary_table']['table_name'];

        //$select = 'cms_users.*, cms_users.id as userid, cms_user_group.name as group_name';
        $this->db->select('tbt_user.*');
        $this->db->from('tbt_user');

        $match = $this->input->post('search');
        $count = 0;
        if(!empty($match)){
            // echo $match;
            // die();
            $this->db->like('user_login',$match);
            $this->db->or_like('LOWER(user_firstname)',strtolower($match));
            $this->db->or_like('LOWER(user_lastname)',strtolower($match));
        }

        $this->db->order_by('employee_id');
        $this->db->limit($items,$offset);

        $query      = $this->db->get();
        $user_list  = $query->result_array();
        
        // echo "<pre>";
        // print_r($user_list);
        // echo "</pre>";
        // die();

        if (!empty($user_list)) {
            foreach ($user_list as $key => $user) {
                $this->db->select('tbt_user_position.status, tbm_position.*, tbm_department.title as dept_name, tbm_department.function as function');
                $this->db->join('tbm_position', 'tbt_user_position.position_id = tbm_position.id');
                $this->db->join('tbm_department', 'tbm_position.department_id = tbm_department.id');
                // $this->db->join('tbm_group', 'tbm_position.group_id = tbm_group.id', 'left');
                $this->db->where('tbt_user_position.employee_id', $user['employee_id']);
                $query = $this->db->get('tbt_user_position');
                $user_list[$key]['position_list'] = $query->result_array();
            }
        }

        return $user_list;
    }

    public function getByField($where) {

        $select = 'cms_users.*, cms_users.id as userid, cms_user_group.name as group_name, cms_user_department.name as dept_name';

        $lang = $this->session->userdata('lang');
        $this->db->select($select);
        $this->db->from('cms_users');
        $this->db->join('cms_user_group', 'cms_users.group_id = cms_user_group.id', 'left');
        $this->db->join('cms_user_department', 'cms_users.department_id = cms_user_department.id', 'left');
        $this->db->where($where);
        $query = $this->db->get();
        $user  = $query->row();

        if (!empty($user)) {

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

            $user->group_permission = array();
            $permission_set = array();
            foreach ($group_permission_set as $set) {
                $permission_type = $this->_convertPermission($set->permission_type);
                $user->group_permission[$set->cat_id] = $permission_type;
                $permission_set[$set->cat_id] = $permission_type;
            }

            $user->permission_set = $permission_set;
        }

        return $user;
    }

    public function listGroup () {

        $this->db->select('*');
        $this->db->from('cms_user_group');
        
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

    public function getGroupAll ($page=1) {

        $offset = 0;
        $items = 100;
        if(intval($page)<1){
            return self::response(false,'909','Invalid page number',array());
        }
        $offset = (intval($page)-1)*$this->pageSize;
        $items = $this->pageSize;
        
        $this->db->select('*');
        $this->db->from('cms_user_group');

        $match = $this->input->post('search');
        if(!empty($match)){
            $this->db->like('name',$match);
        }

        $this->db->limit($items,$offset);

        $query = $this->db->get();
        $result = $query->result_array();

        /*$list = array();
        foreach ($result as $group) {

            $this->db->select('cms_category.module_id, cms_category.parent_id, cms_group_permission.cat_id, cms_group_permission.permission_type');
            $this->db->from('cms_group_permission');
            $this->db->join('cms_category', 'cms_group_permission.cat_id = cms_category.id');
            $this->db->where('group_id', $group['id']);

            $query = $this->db->get();
            $group_permission_set = $query->result_array();

            foreach ($group_permission_set as $set) {
                $permission_type = $this->_convertPermission($set['permission_type']);
                $group['group_permission'][$set['cat_id']] = $permission_type;
            }

            array_push($list, $group);
        }
        return $list;*/
        return $result;
    }

    public function getAreaDepartment() {
        $this->db->where('name', 'SALES');
        $this->db->or_where('name', 'OPERATION');
        $query = $this->db->get('cms_user_department');

        return $query->result_array();
    }

    public function getDepartmentAll ($page=1) {

        $offset = 0;
        $items = 100;
        if(intval($page)<1){
            return self::response(false,'909','Invalid page number',array());
        }
        $offset = (intval($page)-1)*$this->pageSize;
        $items = $this->pageSize;
        
        $this->db->select('*');
        $this->db->from('cms_user_department');

        $match = $this->input->post('search');
        if(!empty($match)){
            $this->db->like('name',$match);
        }

        $this->db->limit($items,$offset);

        $query = $this->db->get();
        $result = $query->result_array();

        /*$list = array();
        foreach ($result as $group) {

            $this->db->select('cms_category.module_id, cms_category.parent_id, cms_group_permission.cat_id, cms_group_permission.permission_type');
            $this->db->from('cms_group_permission');
            $this->db->join('cms_category', 'cms_group_permission.cat_id = cms_category.id');
            $this->db->where('group_id', $group['id']);

            $query = $this->db->get();
            $group_permission_set = $query->result_array();

            foreach ($group_permission_set as $set) {
                $permission_type = $this->_convertPermission($set['permission_type']);
                $group['group_permission'][$set['cat_id']] = $permission_type;
            }

            array_push($list, $group);
        }
        return $list;*/
        return $result;
    }

    public function getDepartmentGroupAll ($page=1) {

        $offset = 0;
        $items = 100;
        if(intval($page)<1){
            return self::response(false,'909','Invalid page number',array());
        }
        $offset = (intval($page)-1)*$this->pageSize;
        $items = $this->pageSize;
        
        $this->db->select('cms_user_department.name as deptname, cms_user_group.name as groupname, cms_user_department.id as dept_id, cms_user_group.id as group_id');
        $this->db->from('cms_user_department, cms_user_group');

        // $this->db->select('cms_user_department.name as deptname, cms_user_group.name as groupname, cms_user_department.id as dept_id, cms_user_group.id as group_id');
        // $this->db->from('cms_user_group');
        // $this->db->join('cms_user_department', 'cms_user_group.department_id = cms_user_department.id');
        //$this->db->limit($items,$offset);

        $query = $this->db->get();
        $result = $query->result_array();

        $list = array();
        foreach ($result as $group) {

            $this->db->select('cms_group_permission.cat_id, cms_group_permission.permission_type');
            $this->db->from('cms_group_permission');
            $this->db->join('cms_module', 'cms_group_permission.cat_id = cms_module.id');
            $this->db->where('group_id', $group['group_id']);
            $this->db->where('dept_id', $group['dept_id']);

            $query = $this->db->get();
            $group_permission_set = $query->result_array();

            foreach ($group_permission_set as $set) {
                $permission_type = $this->_convertPermission($set['permission_type']);
                $group['permission'][$set['cat_id']] = $permission_type;
            }

            array_push($list, $group);
        }
        /*echo "<pre>";
        print_r($list);
        echo "</pre>";*/
        return $list;

        //return $result;
    }

    public function getKeyUserModuleAll ($page=1) {

        $offset = 0;
        $items = 100;
        if(intval($page)<1){
            return self::response(false,'909','Invalid page number',array());
        }
        $offset = (intval($page)-1)*$this->pageSize;
        $items = $this->pageSize;
        
        $this->db->select('tbt_user.user_firstname, tbt_user.user_lastname, tbt_user.employee_id, cms_module.id, cms_module.module_name');
        $this->db->from('tbm_keyuser_modules');
        $this->db->join('cms_module', 'tbm_keyuser_modules.module_id = cms_module.id');
        $this->db->join('tbt_user', 'tbm_keyuser_modules.keyuser_emp_id = tbt_user.employee_id');
        $this->db->where('cms_module.is_action_plan', 1);

        $this->db->limit($items,$offset);

        $query = $this->db->get();
        $result = $query->result_array();

        /*$list = array();
        foreach ($result as $group) {

            $this->db->select('cms_category.module_id, cms_category.parent_id, cms_group_permission.cat_id, cms_group_permission.permission_type');
            $this->db->from('cms_group_permission');
            $this->db->join('cms_category', 'cms_group_permission.cat_id = cms_category.id');
            $this->db->where('group_id', $group['id']);

            $query = $this->db->get();
            $group_permission_set = $query->result_array();

            foreach ($group_permission_set as $set) {
                $permission_type = $this->_convertPermission($set['permission_type']);
                $group['group_permission'][$set['cat_id']] = $permission_type;
            }

            array_push($list, $group);
        }
        return $list;*/
        return $result;
    }

    public function getModuleAll ($children=true) {
        $this->db->select('*');
        $this->db->from('cms_module');
        $this->db->where('is_module', '1');

        $query = $this->db->get();
        $result = $query->result();

        if ($children) {
            foreach ($result as $module) {  
                $this->db->select('*');
                $this->db->from('cms_category');
                $this->db->where('mod_id', $module->id);

                $query = $this->db->get();
                $children = $query->result();

                $module->children = $children;
            }
        }

        return $result;
    }

    public function getSelModuleAll ($children=true) {
        $this->db->select('*');
        $this->db->from('cms_module');
        // $this->db->join('tbm_keyuser_modules', 'cms_module.id = tbm_keyuser_modules.module_id', 'left');
        $this->db->where('cms_module.is_menu', 1);
        $this->db->where('cms_module.is_action_plan', 1);
        // $this->db->where('cms_module.is_module', 1);
        // $this->db->where('tbm_keyuser_modules.module_id IS NULL', null, false);

        $query = $this->db->get();
        $result = $query->result();

        return $result;
    }

    // public function getKeyUser () {
    //     $this->db->select('cms_users.*, cms_user_group.name as group_name');
    //     $this->db->from('cms_users');
    //     $this->db->join('cms_user_group', 'cms_user_group.id = cms_users.group_id');
    //     $this->db->like('cms_user_group.name', 'manager');
    //     $this->db->or_like('cms_user_group.name', 'Manager');
    //     $this->db->or_like('cms_user_group.name', 'MANAGER');

    //     $query = $this->db->get();
    //     $result = $query->result();

    //     return $result;
    // }

    public function getTeamMember ($id, $code) {

        $this->db->select('tbm_permission_area_team.*, cms_user_department.name as dept_name');
        $this->db->join('cms_user_department', 'cms_user_department.id = tbm_permission_area_team.department_id');
        if ($id) {
            $this->db->where('tbm_permission_area_team.id', $id);
        }
        $query = $this->db->get('tbm_permission_area_team');
        $team = $query->row_array();

        if (!empty($team)) {

            if ($team['dept_name'] == 'SALES') {
                $this->db->where('sales_area_id', $code);
            } else if ($team['dept_name'] == 'OPERATION') {
                $this->db->where('operation_area_id', $code);
            }
            $query = $this->db->get('cms_users');
            $team['member_list'] = $query->result_array();

            $this->db->select('cms_users.*, cms_user_group.name as group_name');
            $this->db->where('department_id', $team['department_id']);
            $this->db->where_in('cms_user_group.name', array('member', 'supervisor'));
            if ($team['dept_name'] == 'SALES') {
                $this->db->where('sales_area_id !=', $code);
            } else if ($team['dept_name'] == 'OPERATION') {
                $this->db->where('operation_area_id !=', $code);
            }
            $this->db->join('cms_user_group', 'cms_user_group.id = cms_users.group_id');
            $query = $this->db->get('cms_users');
            $team['employee_list'] = $query->result_array();
        }

        return $team;
    }

    public function getPermissionAreaTeam ($id=0) {

        $this->db->select('tbm_permission_area_team.*, cms_user_department.name as dept_name');
        $this->db->join('cms_user_department', 'cms_user_department.id = tbm_permission_area_team.department_id');
        if ($id) {
            $this->db->where('tbm_permission_area_team.id', $id);
        }

        $p = $this->input->post();
        $search = $p['search'];
        if (!empty($search)) {
            $this->db->like('tbm_permission_area_team.title', $search);
        }

        $query = $this->db->get('tbm_permission_area_team');
        $team_list = $query->result_array();

        if (!empty($team_list)) {
            foreach ($team_list as $key => $team) {
                $this->db->where('area_team_id', $team['id']);
                $query = $this->db->get('tbm_permission_area');

                $team_list[$key]['team_list'] = $query->result_array();

                if (!empty($team_list[$key]['team_list'])) {

                    foreach ($team_list[$key]['team_list'] as $key2 => $subteam) {
                        
                        if ($team['dept_name'] == "SALES") {
                            $this->db->where('sales_area_id', $subteam['code']);
                        } else if ($team['dept_name'] == "OPERATION") {
                            $this->db->where('operation_area_id', $subteam['code']);
                        }

                        $query = $this->db->get('cms_users');
                        $team_list[$key]['team_list'][$key2]['team_member'] = $query->result_array();
                    }
                }

                $this->db->select('cms_users.employee_id, cms_users.user_firstname, cms_users.user_lastname');
                $this->db->where('area_team_id', $team['id']);
                $this->db->join('cms_users', 'cms_users.employee_id = tbm_manager_map_team.manager_id');
                $query = $this->db->get('tbm_manager_map_team');

                $team_list[$key]['manager_list'] = $query->result_array();
            }
        }

        return $team_list;
    }

    public function delete($id) {

        //$this->db->delete('cms_user_permission', array('user_id' => $id)); 
        $this->db->delete('cms_users', array('id' => $id)); 

        log_transaction('delete', 'cms_users', $id, 'success');
    }

    public function deleteGroup($id) {

        $this->db->where('group_id', $id);
        $this->db->update('cms_users', array('group_id' => ''));

        //$this->db->delete('cms_group_permission', array('group_id' => $id)); 
        $this->db->delete('cms_user_group', array('id' => $id)); 

        log_transaction('delete', 'cms_user_group', $id, 'success');
    }

    public function superadmin_login() {

        ###########################################################
        # SET SESSION
        ###########################################################
        $user_data = array(
            'id'                => '0',
            'username'          => $this->supervisor['username'],
            'email'             => $this->supervisor['email'],
            'group'             => 'superadmin',
            'is_internal_user'  => '1',
            'cookie'            => '',
            'lang'              => 'en',
            'super_admin'       => '1',
            'unique_id'         => md5($this->supervisor['username']."_".time())
        );  
        $this->session->set_userdata($user_data); 

        ###########################################################
        # GET PERMISSION SET
        ###########################################################
        $cat_list = $this->module_model->getCategoryAll();
        $permission_set = array();
        foreach ($cat_list as $category) {
            $permission_type = $this->_convertPermission(31);

            $permission_set[$category->id] = $permission_type;

            if ($category->parent_id != 0) {
                if ($permission_set[$category->id]['view'] == 1) {
                    $permission_set[$category->parent_id]['view'] = 1;
                }
            } 
        }

        $unique_id = $this->session->userdata('unique_id');
        $filename = CFGPATH."cms_config".DS."permission".DS.$unique_id.".php";
        file_put_contents($filename, serialize($permission_set));
        //$this->session->set_userdata(array('permission_set' => $permission_set));

        log_transaction('login', 'superadmin', 0, 'success');  
    }



    public function login_soap($param){//pass
        
        $ip = $this->papyrus['ip'];
        $pingresult = exec("ping -n 3 $ip", $outcome, $status);

        if (empty($status)) {

            $this->load->library("nusoap_lib");
            $this->webservice_url = $this->papyrus['url'];

            error_reporting(0);

            $this->nusoap_client = new nusoap_client($this->webservice_url,true);
            $this->nusoap_client->soap_defencoding = 'UTF-8';
            $this->nusoap_client->decode_utf8 = false;

            $output_result = array();
            $params = array(
                       'username' => $param['username'],
                       'password' => $param['password']
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
                                $this->papyrus['loginFunc'],
                                $params
                            );

                    $result_txt = $soap_result['LoginSSO2Result'];
                    $xml = simplexml_load_string($result_txt);
                    $json = json_encode($xml);
                    $output_result = json_decode($json,TRUE);

                }   
            }   

            if ($err_msg=="" && $soap_result['LoginSSO2Result'] != 'INCORRECT_PASSWORD') {
                $msg = "Sign In request completed";
                $state = true;
                $code = '000';
                $output = $output_result;
            } else {
                $state = false;
                $msg = $soap_result['LoginSSO2Result'];
                $output = array();
            } 

            $result = self::response($state,$code,$msg,$output); 

            if (!empty($param['type']) && ($param['type'] == 'tablet' || $param['type'] == 'mobile')) {

                if ($result['status']) {

                    $where['user_login'] = $params['username'];
                    $this->db->select('*');
                    $this->db->from('tbt_user');
                    $this->db->where($where);
                    $query = $this->db->get();
                    $user = $query->row_array();

                    //TODO: Generate Token

                    if (!empty($user)) {
                        $token = $this->generate_login_id($user['employee_id']);
                        $short_token = '';

                        if ($param['type'] == 'tablet') {

                            $msg        = '';
                            $state      = true;
                            $code       = '000';
                            $output     = site_url('__cms_permission/login/tablet/'.$token);

                        } else {

                            $short_token = substr($token, strlen($token)-6);
                            $msg        = '';
                            $state      = true;
                            $code       = '000';
                            $output     = $short_token;

                        }

                        $log_data = array(
                            'employee_id' => $user['employee_id'],
                            'type'        => $param['type'],
                            'latitude'    => $param['lat'],
                            'longitude'   => $param['lng'],
                            'token'       => $token,
                            'short_token' => $short_token,
                            'expired_datetime' => date('Y-m-d H:i:s', strtotime('+1 days')),
                            'create_datetime' => date('Y-m-d H:i:s')                
                        );

                        $this->login_log($log_data);
                    } else {
                        $msg        = 'User not found on web server.';
                        $state      = false;
                        $code       = '999';
                        $output     = '';
                    }
                } else {
                    $msg        = 'User not found on papyrus.';
                    $state      = false;
                    $code       = '999';
                    $output     = '';
                }

                $return_result = self::response($state,$code,$msg,$output); 

                return $return_result;
            }

            ###########################################################
            # GET USER DATA BY USERNAME AND PASSWORD
            ###########################################################
            if ($result['status']) {
            // if (1) {

                $where['user_login'] = $param['username'];

                $this->db->select('tbt_user.*');
                $this->db->from('tbt_user');
                $this->db->where($where);
                $query = $this->db->get();

                $user = $query->row_array();

                if (empty($user)) {
                    return 0;
                } else {

                    $this->db->select('tbt_user_position.status, tbm_position.*, tbm_department.title as dept_name, tbm_department.function as function');
                    $this->db->join('tbm_position', 'tbt_user_position.position_id = tbm_position.id');
                    $this->db->join('tbm_department', 'tbm_position.department_id = tbm_department.id');
                    // $this->db->join('tbm_group', 'tbm_position.group_id = tbm_group.id', 'left');
                    $this->db->where('tbt_user_position.employee_id', $user['employee_id']);
                    $query = $this->db->get('tbt_user_position');
                    $user['position_list'] = $query->result_array();
                }

                $this->set_login($user);


                // $log_data = array(
                //     'employee_id' => $user['employee_id'],
                //     'type'        => 'direct',
                //     'token'       => '',
                //     'short_token' => '',
                //     // 'expired_datetime' => date('Y-m-d H:i:s', strtotime('+1 days')),
                //     'create_datetime' => date('Y-m-d H:i:s')                
                // );

                // $this->login_log($log_data);

                return $user;
            }
        }

        return 0;

    }//done lv1 

    public function set_login ($user) {

        ###########################################################
        # SET SESSION
        ###########################################################

        $department_list        = array();
        // $group_list             = array();
        $function_list          = array();
        $position_list          = array();
        $distribution_channel   = array();
        $operation_area         = array();

        if (!empty($user['position_list'])) {
            foreach ($user['position_list'] as $key => $position) {
                // if (!empty($position['group_name']) && !in_array(strtolower($position['group_name']), $group_list)) {
                //     array_push($group_list, strtolower($position['group_name']));
                // }

                if (!empty($position['id']) && !empty($position['id']) && !in_array($position['id'], $position_list)) {
                    array_push($position_list, $position['id']);
                }

                if (!empty($position['function']) && !empty($position['function']) && !in_array($position['function'], $function_list)) {
                    array_push($function_list, $position['function']);
                }

                if ( ($position['function'] == 'MK' || $position['function'] == 'CR') && !empty($position['area_id']) && !in_array($position['area_id'], $distribution_channel)) {
                    array_push($distribution_channel, strtolower($position['area_id']));
                }

                if ($position['function'] == 'OP' && !empty($position['area_id']) && !in_array($position['area_id'], $operation_area)) {
                    array_push($operation_area, strtolower($position['area_id']));
                }

                if (!empty($position['department_id']) && !in_array($position['department_id'], $department_list)) {
                    array_push($department_list, $position['department_id']);
                }

                // $department_list[$position['department_id']] = array (
                //     'department_id'         => $position['department_id'],
                //     'department_name'       => $position['dept_name'],
                //     'function'              => $position['function'],
                //     'area_id'               => $position['area_id']
                // );
            }
        }

        $user_data = array(
            'id'                    => $user['employee_id'],
            'username'              => $user['user_login'],
            'actual_name'           => $user['user_firstname'].' '.$user['user_lastname'],
            'super_admin'           => 0,
            'department'            => $department_list,
            // 'group'                 => $group_list,
            'function'              => $function_list,
            'position'              => $position_list,
            'distribution_channel'  => $distribution_channel,
            'operation_area'        => $operation_area,
        );  

        if (array_key_exists('token', $user) && !empty($user['token'])) {
            $user_data['token'] = $user['token'];
        }
        
        $this->session->set_userdata($user_data);      

        log_transaction('login', 'tbt_user', $user['employee_id'], 'success');
    }

    public function login_log ($data) {

        $session_login_id = $this->session->userdata('login_id');
        if (!empty($session_login_id)) {

            $this->db->where('id', $session_login_id);
            $query = $this->db->get('tbl_login');
            $output = $query->row_array();

            if (!empty($output)) {
                $this->db->where('id', $session_login_id);
                $this->db->update('tbl_login', $data);
            } else {
                $data['id'] = $this->generate_login_id($data['employee_id']);
                $user_data = array(
                    'login_id'  => $data['id']
                );  
                $this->session->set_userdata($user_data);
                $this->db->insert('tbl_login', $data);
            }
        } else {
            $data['id'] = $this->generate_login_id($data['employee_id']);
            $user_data = array(
                'login_id'  => $data['id']
            );  
            $this->session->set_userdata($user_data);
            $this->db->insert('tbl_login', $data);
        }
    }

    function generate_login_id ($employee_id) {

        $code = $employee_id.'_'.time();
        $code = md5($code);

        return $code;
    }

    public function single_login ($username) {

        $where['user_login'] = $username;

        $this->db->select('tbt_user.*');
        $this->db->from('tbt_user');
        $this->db->where($where);
        $query = $this->db->get();

        $user = $query->row_array();

        if (empty($user)) {
            return 0;
        } else {
            $this->db->select('tbt_user_position.status, tbm_position.*, tbm_department.title as dept_name, tbm_department.function as function');
            $this->db->join('tbm_position', 'tbt_user_position.position_id = tbm_position.id');
            $this->db->join('tbm_department', 'tbm_position.department_id = tbm_department.id');
            // $this->db->join('tbm_group', 'tbm_position.group_id = tbm_group.id', 'left');
            $this->db->where('tbt_user_position.employee_id', $user['employee_id']);
            $query = $this->db->get('tbt_user_position');
            $user['position_list'] = $query->result_array();
        }

        $this->set_login($user);

        return $user;
    }

    // public function loginByCookie($cookie) {

    //     ###########################################################
    //     # GET USER DATA BY BROWSER COOKIE
    //     ###########################################################
    //     $data = array(
    //         'is_enable' => '1',
    //         'cookie'    => $cookie
    //     );

    //     $this->db->select('cms_users.*, cms_user_group.name as group_name');
    //     $this->db->from('cms_users');
    //     $this->db->join('cms_user_group', 'cms_users.group_id = cms_user_group.id');
    //     $this->db->where($data);
    //     $query = $this->db->get('cms_users');

    //     $user = $query->row();

    //     if (!empty($user)) {
    //         ###########################################################
    //         # SET SESSION
    //         ###########################################################
    //         $user_data = array(
    //             'id'                => $user->id,
    //             'username'          => $user->user_login,
    //             'email'             => $user->user_email,
    //             'group_name'        => $user->group_name,
    //             'is_internal_user'  => $user->is_internal_user,
    //             'cookie'            => $user->cookie,
    //             'super_admin'       => 0
    //         );  
    //         $this->session->set_userdata($user_data); 

    //         ###########################################################
    //         # GET PERMISSION SET
    //         ###########################################################
    //         $this->db->select('cms_group_permission.cat_id, cms_group_permission.permission_type');
    //         $this->db->from('cms_users');
    //         $this->db->join('cms_group_permission', 'cms_users.group_id = cms_group_permission.group_id');
    //         $this->db->join('cms_module', 'cms_group_permission.cat_id = cms_module.id');
    //         $this->db->where('cms_users.id', $user->id);

    //         $query = $this->db->get();

    //         $group_permission_set = $query->result();

    //         $permission_set = array();

    //         foreach ($group_permission_set as $set) {
    //             $permission_type = $this->_convertPermission($set->permission_type);
    //             $permission_set[$set->cat_id] = $permission_type;
    //         } 

    //         $this->session->set_userdata(array('permission_set' => $permission_set));   

    //         log_transaction('login', 'tbt_user', $user['employee_id'], 'success');
    //     }

    //     return $user;
    // }

    function _convertPermission ( $permission ) {

        if ($permission <  32) {
            $base2 = base_convert($permission, 10, 2) ;
            $base2 = str_pad($base2, 5, "0", STR_PAD_LEFT);

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


    public function is_allowDirectLogin($username){
        $this->db->where(array('user_login'=>$username));
        $this->db->select('allow_direct_login');
        $result = $this->db->get('tbt_user');

            if($result->num_rows()<1){
                return false;
            }
        
        $result = $result->result_array();
        return intval($result[0]['allow_direct_login']);
    }//end function 


    public function is_allowTabletLogin($username){
        $this->db->where(array('user_login'=>$username));
        $this->db->select('allow_tablet_login');
        $result = $this->db->get('tbt_user');

            if($result->num_rows()<1){
                return false;
            }
        
        $result = $result->result_array();
        return intval($result[0]['allow_tablet_login']);
    }//end function

    public function is_allowMobileLogin($username){
        $this->db->where(array('user_login'=>$username));
        $this->db->select('allow_mobile_login');
        $result = $this->db->get('tbt_user');

            if($result->num_rows()<1){
                return false;
            }
        
        $result = $result->result_array();
        return intval($result[0]['allow_mobile_login']);
    }//end function

    public function getGPSList () {

        $this->db->select('tbl_login.*, tbt_user.user_firstname, tbt_user.user_lastname');
        $this->db->join('tbt_user', 'tbl_login.employee_id = tbt_user.employee_id');
        $this->db->where('type', 'tablet');

        $p = $this->input->post();
        if($p['from_date']=='' && $p['to_date']==''){
            $p['from_date'] = date('d.m.Y');
            $p['to_date'] = date('d.m.Y');
        }
        if (!empty($p['from_date'])) {
             //echo 'from_date :'.$p['from_date']."<br>";
            $from_date_parts = explode('.', $p['from_date']);
            $day = $from_date_parts[0];
            $month = $from_date_parts[1];
            $year = $from_date_parts[2];

            $this->db->where('DATE(create_datetime) >=', $year.'-'.$month.'-'.$day);
        }
        if (!empty($p['to_date'])) {
             //echo 'to_date :'.$p['to_date'].'<br>';
            $to_date_parts = explode('.', $p['to_date']);
            $day = $to_date_parts[0];
            $month = $to_date_parts[1];
            $year = $to_date_parts[2];

            $this->db->where('DATE(create_datetime) <=', $year.'-'.$month.'-'.$day);
        }
        //die();
        if (!empty($p['search'])) {
            $this->db->where('(user_firstname LIKE "%'.$p['search'].'%" OR user_lastname LIKE "%'.$p['search'].'%" OR user_login LIKE "%'.$p['search'].'%")');
        }

        if (!empty($p['sort'])) {
            $this->db->order_by('create_datetime '.$p['sort']);
        } else {
            $this->db->order_by('create_datetime desc');
        }

        $query = $this->db->get('tbl_login');

        $result = $query->result_array();

        return $result;
    }
}

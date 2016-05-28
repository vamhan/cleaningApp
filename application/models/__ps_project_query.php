<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class __ps_project_query extends REST_Model{

    function __construct(){
        parent::__construct();
        

        if(!isset($this->pageSize) || empty($this->pageSize)){
            $this->pageSize = PAGESIZE;
        }

        $page_n = intval($this->session->userdata('current_page'));
        if(!empty($page_n)){
            $this->pageSize = $page_n;
        }


    }

    public function get_user_cr(){
        $this->db->distinct();
        $this->db->select('tbt_user.employee_id,tbt_user.user_firstname,tbt_user.user_lastname');     
        $this->db->join('tbt_user_position', 'tbt_user_position.employee_id = tbt_user.employee_id', 'left');
        $this->db->join('tbm_position', 'tbm_position.id = tbt_user_position.position_id', 'left');
        $this->db->join('tbm_department', 'tbm_department.id = tbm_position.department_id', 'left');
        $this->db->where('tbm_department.function', 'CR');

        $results = $this->db->get('tbt_user');
        $results = $results->result_array();

        return $results;
    }

    public function get_project_oper(){
        
        $this->db->from("(SELECT *,tbt_quotation.id as quotation_id FROM tbt_quotation WHERE (tbt_quotation.status = 'EFFECTIVE' OR  tbt_quotation.status = 'REJECT' OR  tbt_quotation.status = 'DELETE' ) AND tbt_quotation.contract_id != '' AND tbt_quotation.project_end >= '".date('Y-m-d')."') as tbt_quotation");
        $this->db->join('sap_tbm_sold_to', 'sap_tbm_sold_to.id = tbt_quotation.sold_to_id');
        $this->db->join('sap_tbm_ship_to', 'sap_tbm_ship_to.id = tbt_quotation.ship_to_id');
        $this->db->join('tbm_job_type', 'tbm_job_type.id = tbt_quotation.job_type', 'left');

        $results = $this->db->get();
        $results = $results->result_array();

        return $results;
    }

    public function get_child_distribution_channel($position){
        $this->db->distinct();
        $this->db->select('area_id');
        $this->db->from('tbm_position p');
        $this->db->where_in('parent_id', $position);
        $results = $this->db->get();
        $results = $results->result_array();

        return $results;
    }


    public function get_project_owner($id){

        $this->db->select('tbt_quotation.* ,cms_users.user_firstname AS project_owner,cms_users.user_firstname AS project_owner_name,cms_users.user_lastname As project_owner_lastname');
        $this->db->join('cms_users', 'cms_users.employee_id = tbt_quotation.project_owner_id', 'left');

        $this->db->where(array('tbt_quotation.id'=>$id));
        $result = $this->db->get('tbt_quotation');
        

        if(!empty($result)){
                // $output = array();
                // $state = true;
                // $code = '000';
                // $msg = '';
            $output = $result;
        }else{
                // $state = false;
                // $code = '909';
                // $msg = '';
            $output = $result;
        }
       // return self::response($state,$code,$msg,$output);
        return $output;

    }

    public function getEventCategory () {
        $query = $this->db->get('tbm_event_category');
        return $query->result_array();
    }
    
    public function getShipto($where=null){

        $this->db->select('sap_tbm_ship_to.*');
        if (!empty($where)) {
            $this->db->where($where);
        }
        //$this->db->where('quotation_id',$quotation_id);  
        $result = $this->db->get('sap_tbm_ship_to');

        if(!empty($result)){
                // $output = array();
                // $state = true;
                // $code = '000';
                // $msg = '';
            $output = $result;
        }else{
                // $state = false;
                // $code = '909';
                // $msg = '';
            $output = $result;
        }
       // return self::response($state,$code,$msg,$output);
        return $output;
    }

    public function delete($table,$condition){
        $this->db->where($condition);
        $this->db->delete($table);
    }


    public function getContentById($id){

        $table = 'tbt_quotation';

        $this->db->select('tbt_quotation.* , sap_tbm_ship_to.ship_to_distribution_channel, sap_tbm_ship_to.ship_to_name1 AS shop_to_title , sap_tbm_sold_to.sold_to_name1 AS customer_name,tbt_user.user_firstname AS project_owner');
        // $this->db->join('sap_tbm_job_type', 'sap_tbm_job_type.id = tbt_quotation.job_type', 'left');
        $this->db->join('sap_tbm_sold_to', 'sap_tbm_sold_to.id = tbt_quotation.sold_to_id', 'left');
        $this->db->join('sap_tbm_ship_to', 'sap_tbm_ship_to.id = tbt_quotation.ship_to_id', 'left');
        // $this->db->join('sap_tbm_competitor', 'sap_tbm_competitor.account_group = tbt_quotation.competitor_id', 'left');
        $this->db->join('tbt_user', 'tbt_user.employee_id = tbt_quotation.project_owner_id', 'left');

        $this->db->where(array('tbt_quotation.id'=>$id));
        $result = $this->db->get($table);
        
        $count = $result->num_rows();

        $output = array();
        if($count > 0 ){
            $result = $result->result_array();
            $state = true;
            $code = '000';
            $msg = '';
            $output = $result;
        }else{
            $state = false;
            $code = '909';
            $msg = '';
        }
        
        return self::response($state,$code,$msg,$output);
    }

    public function getUserFunction($user_id){
        $this->db->select();
    }

    public function getProjectContacts($pid){
        $this->db->select('tbt_contact.*');  
        $this->db->select('sap_tbm_department.title As department_title'); 
        $this->db->select('sap_tbm_function.description As function_title'); 
        $this->db->join('sap_tbm_department', 'sap_tbm_department.id = tbt_contact.department','left');
        $this->db->join('sap_tbm_function', 'sap_tbm_function.id = tbt_contact.function','left');
        $this->db->where(array('quotation_id'=>$pid));
        $this->db->order_by("is_main_contact", "desc");
        $result = $this->db->get('tbt_contact');

        // $result = $this->db->get($table);
        $count = $result->num_rows();
        $output = array();
        if($count > 0 ){
            $result = $result->result_array();
            $state = true;
            $code = '000';
            $msg = '';
            $output = $result;
        }else{
            $state = false;
            $code = '909';
            $msg = '';
        }

        return self::response($state,$code,$msg,$output);
    }


    public function getAttachDocumentList($pid){
        $this->db->where(array('quotation_id'=>$pid));
        $result = $this->db->get('tbt_project_document');

        // $result = $this->db->get($table);
        $count = $result->num_rows();
        $output = array();
        if($count > 0 ){
            $result = $result->result_array();
            $state = true;
            $code = '000';
            $msg = '';
            $output = $result;
        }else{
            $state = false;
            $code = '909';
            $msg = '';
        }

        return self::response($state,$code,$msg,$output);

    }
    

    public function getUserVisibleMenu(){
        $permitted_access_list = array();

            // $unique_id = $this->session->userdata('unique_id');
            // $filename = CFGPATH."cms_config".DS."permission".DS.$unique_id.".php";
            // if (file_exists($filename)) {
            //     $permission_file = file_get_contents($filename);
            //     $permission_set = unserialize($permission_file);
            // } else {
            //     echo "<script>alert('Session has expired.'); location.href = '".site_url('__cms_permission/logout')."';</script>";
            //     die();
            // }

            // echo "<pre>";
            // print_r($permission_set);
            // echo "</pre>";

        foreach ($permission_set as $key => $value) {
                if(1==intval($value['view']))//Display only viewable content
                array_push($permitted_access_list , $key);
            }
            //TODO :: remove it after implemented group permission  

            $this->db->select('id, module_name as name,icon,color,url');
            $this->db->where_in('id',$permitted_access_list);
            $result = $this->db->get('cms_module');

            $count = $result->num_rows();
            $output = array();
            if($count > 0 ){
                $result = $result->result_array();
                $state = true;
                $code = '000';
                $msg = '';
                $output = $result;
            }else{
                $state = false;
                $code = '909';
                $msg = '';
            }

            return self::response($state,$code,$msg,$output);

        }




        function insert_contact($p,$quotation_id){     

            $this->db->where_in('email',$p['email']);
            $result = $this->db->get('tbt_contact');
            $count = $result->num_rows();

            if($count > 0 ){
            //$result = $result->result_array();
            // $state = true;
            // $code = '000';
                $msg = 'มี contact นี้แล้ว';
           // $output = $result;
            }else{

                $data = array(
            //'id' => '',
                    'firstname' => $p['fist_name'],
                    'lastname' => $p['last_name'],
                    'position' => $p['position'],
                    'function' => $p['function'],
            //'department_id' => $p['untrack_remark'], ///**
            //'phone_no' => $p['untrack_doc_id'],
            //'phone_no_ext' =>  $p['untrack_doc_id'],
                    'mobile_no' =>  $p['mobile_no'],            
            //'fax' => '0',
                    'email' => $p['email'],
                    'is_main_contact' => '0',
                    'quotation_id' => $quotation_id           
                    );
                $query = $this->db->insert('tbt_contact', $data);
                
                $msg = 'เพิ่มข้อมูลเรียบร้อยแล้ว';
            }

            return self::response_msg($msg);

        }

        public function getObj ($table, $where=null, $list=false, $search_key=null, $order_by=null) {

            if (!empty($where)) {
                $this->db->where($where);
            }        

            $p = $this->input->post();
            if (!empty($p['search']) && !empty($search_key)) {
                foreach ($search_key as $key => $search) {
                    if ($key == 0) {
                        $this->db->like($search, $p['search']);
                    } else {
                        $this->db->or_like($search, $p['search']);
                    }
                }
            }

            if (!empty($order_by)) {
                $this->db->order_by($order_by);
            }        

            $query = $this->db->get($table);

            if ($list) {
                return $query->result_array();
            }
            return $query->row_array();
        }

        public function deleteObj ($table, $where) {
            $this->db->delete($table, $where);
        }

        public function insertObj ($table, $input) {
            $this->db->insert($table, $input);
            $insert_id = $this->db->insert_id();
            return $insert_id;
        }

        public function updateObj ($table, $where, $input) {
            $this->db->where($where);
            $this->db->update($table, $input);
        }

        private function response_msg($msg){
            return array('msg'=>$msg);
        }

        public function get_clear_job($quotation_id){
            $this->db->where('quotation_id', $quotation_id);
            $this->db->where('frequency>0');
        }



    }

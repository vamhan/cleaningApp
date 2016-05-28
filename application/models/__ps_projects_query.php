<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class __ps_projects_query extends REST_Model{

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

    function _join_table($page){
        $this->db->distinct();
        $this->db->from("(SELECT * FROM tbt_quotation WHERE (tbt_quotation.status = 'EFFECTIVE' OR  tbt_quotation.status = 'REJECT' OR  tbt_quotation.status = 'DELETED' ) AND tbt_quotation.contract_id != '' AND tbt_quotation.project_end >= '".date('Y-m-d')."') as tbt_quotation");
        $this->db->join('sap_tbm_sold_to', 'sap_tbm_sold_to.id = tbt_quotation.sold_to_id');
        $this->db->join('sap_tbm_ship_to', 'sap_tbm_ship_to.id = tbt_quotation.ship_to_id');
        $this->db->join('tbm_job_type', 'tbm_job_type.id = tbt_quotation.job_type', 'left');
        // $this->db->join('tbt_user_customer', 'tbt_user_customer.ship_to_id = tbt_quotation.ship_to_id', 'left'); 
        // $this->db->join('tbt_user', 'tbt_user_customer.user_id = tbt_user.user_id', 'left');
        $result = $this->db->get();
        return $result;
    }

    function _search($permission, $position_list, $children, $user_id,$tempMatch='',$page){
        //Set up keyword Search       
        if(empty($tempMatch)){ $match = $this->input->post('search');  }else{ $match = $tempMatch; }
        $year = $this->input->post('year');
        $job_type = $this->input->post("job_type");
        $relavant = $this->input->post("relavant");


        if ($permission['shipto']['value'] == 'related') {
            if (!empty($children)) {
                //echo "head";
                $children = array_merge($position_list, $children);
                $children = implode("','", $children);
                $this->db->where("(tbt_quotation.ship_to_id in (SELECT uc.ship_to_id FROM tbt_user u LEFT JOIN tbt_user_customer uc ON uc.user_id = u.user_id LEFT JOIN tbt_user_position up ON up.employee_id = u.employee_id WHERE up.position_id IN ('".$children."')))");
            } else {
                //echo "chi";
                $this->db->where("(EXISTS(SELECT 'X' FROM tbt_user_customer WHERE tbt_user_customer.ship_to_id = tbt_quotation.ship_to_id AND user_id = '".$user_id."' ))");
            }
        } 

        if(!empty($match)){

            $this->db->where('(tbt_quotation.contract_id LIKE "%'.$match.'%" OR sap_tbm_ship_to.ship_to_name1 LIKE "%'.$match.'%" OR tbt_quotation.ship_to_id LIKE "%'.$match.'%")');
        }//end if

        if(!empty($year)){
          $this->db->where('YEAR(tbt_quotation.project_start)',$year);
        }//end if

        if($job_type != 'all' && $job_type != ''){
          $this->db->where('tbt_quotation.job_type',$job_type);
        }//end if

    }

    public function listviewContent($page=1,$tempMatch='',$order=array()) {
        if(empty($tempMatch)){ $match = $this->input->post('search');  }else{ $match = $tempMatch; }
        $emp_id = $this->session->userdata('id');
        $this->db->where('employee_id', $emp_id);
        $user = $this->db->get('tbt_user')->row_array();
        if(empty($user)) return ;
        $user_id = $user['user_id'];

        $position_list = $this->session->userdata('position');

        $children = array();
        foreach ($position_list as $key => $position) {
            $children = $this->getPositionChild($children, $position);
        }

        $permission = $this->permission[$this->cat_id];

        $filter_result = array();

        $this->db->select('tbt_quotation.* ,tbm_job_type.title AS job_type_title , sap_tbm_ship_to.ship_to_name AS shop_to_title , sap_tbm_sold_to.sold_to_name1 AS customer_name');
        //$this->db->select('tbt_user.user_firstname AS project_owner');

        $this->_search($permission, $position_list, $children, $user_id,$tempMatch,$page);

        $this->db->order_by('tbt_quotation.project_start', 'DESC');

        $offset = 0;
        $limit = 100;
        $offset = (intval($page)-1)*$this->pageSize;
        $limit = $this->pageSize;

        $this->db->limit($limit, $offset);
        $result = $this->_join_table($page);
        $result = $result->result_array();
        if (!empty($result)) {
            foreach ($result as $key => $value) {

                $result[$key]['requisition_alert'] = 0;

                $this->db->where('quotation_id', $value['id']);
                $this->db->where('status', 'submit');
                $query = $this->db->get('tbt_equipment_requisition_document');
                $wait_for_approve = $query->num_rows();

                if ($wait_for_approve > 0) {
                    $result[$key]['requisition_alert'] = 1;
                }
            }
        }

        $this->db->select('COUNT(*) AS cnt');
        $this->_search($permission, $position_list, $children, $user_id,$tempMatch,$page);

        $query = $this->_join_table($page);
        $total_result = $query->row_array();
        $total_item = $total_result['cnt'];
        
        $output = array();
        $state = true;
        $code = '000';
        $msg = '';
        $output['temp_match'] = $match;
        $output['total_item'] = $total_item;
        $output['list'] = $result;
        $output['page'] = $page;
        $output['page_size'] = $this->pageSize;             
        $output['total_page'] = ceil($total_item/$this->pageSize);                
        $output['on_year'] = !empty($year)?$year:'';

        return self::response($state,$code,$msg,$output);
    }




    public function get_qr($page=1,$order=array(),$match,$year,$job_type,$relavant){

        $emp_id = $this->session->userdata('id');
        $position_list = $this->session->userdata('position');

        $children = array();
        foreach ($position_list as $key => $position) {
            $children = $this->getPositionChild($children, $position);
        }

        $permission = $this->permission[$this->cat_id];

        $filter_result = array();

        $table = 'tbt_quotation';

        //Set up keyword Search 
        // $match = $this->input->post('search');
        // $year = $this->input->post('year');
        // $job_type = $this->input->post("job_type");
        // $relavant = $this->input->post("relavant");

        if(!empty($match)){
            $this->db->where('(tbt_quotation.contract_id LIKE "%'.$match.'%" OR sap_tbm_ship_to.ship_to_name1 LIKE "%'.$match.'%" OR tbt_quotation.ship_to_id LIKE "%'.$match.'%")');
        }//end if

        $this->db->where('tbt_quotation.status', 'EFFECTIVE');
        $this->db->where('tbt_quotation.contract_id !=', '');
        if(!empty($year)){
          $this->db->where('YEAR(tbt_quotation.project_start)',$year);
        }//end if

        if($job_type != 'all' && $job_type != ''){
          $this->db->where('tbt_quotation.job_type',$job_type);
        }//end if


        $this->db->order_by('tbt_quotation.project_start','DESC');

        $this->db->select('tbt_quotation.* ,tbm_job_type.title AS job_type_title , sap_tbm_ship_to.ship_to_name AS shop_to_title , sap_tbm_sold_to.sold_to_name1 AS customer_name ,tbt_user.user_firstname AS project_owner');
        $this->db->join('tbm_job_type', 'tbm_job_type.id = tbt_quotation.job_type', 'left');
        $this->db->join('sap_tbm_sold_to', 'sap_tbm_sold_to.id = tbt_quotation.sold_to_id');
        $this->db->join('sap_tbm_ship_to', 'sap_tbm_ship_to.id = tbt_quotation.ship_to_id');
        $this->db->join('tbt_user_customer', 'tbt_user_customer.ship_to_id = sap_tbm_ship_to.id', 'left'); 
        $this->db->join('tbt_user', 'tbt_user_customer.user_id = tbt_user.user_id', 'left');

        if ($permission['shipto']['value'] == 'related') {
            if (!empty($children)) {
                //echo "head";
                $children = array_merge($position_list, $children);
                $children = implode("','", $children);
                $this->db->where("(tbt_user.employee_id in (select employee_id from tbm_position p LEFT JOIN tbt_user_position up ON up.position_id = p.id where id in ('".$children."')))");
            } else {
                //echo "chi";
                $this->db->where('tbt_user.employee_id', $emp_id);
            }
        } 

        // $this->db->where('tbt_quotation.project_start <=', date('Y-m-d'));
        $this->db->where('tbt_quotation.project_end >=', date('Y-m-d'));
        $this->db->group_by('tbt_quotation.id');
        $this->db->order_by('tbt_quotation.project_start', 'DESC');
        //get count row all
        $result_query = $this->db->get($table);
        $count_re_query = $result_query->num_rows();
        $total_item2 = $count_re_query;

        return $total_item2;

    }







}

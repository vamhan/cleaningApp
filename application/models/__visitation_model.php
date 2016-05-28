<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class __visitation_model extends MY_Model{

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

 public function getContentList($page=1,$order=array()){

    $emp_id = $this->session->userdata('id');
    $position_list = $this->session->userdata('position');

    $children = array();
    foreach ($position_list as $key => $position) {
        $children = $this->getPositionChild($children, $position);
    }

    $permission = $this->permission[$this->cat_id];
    $function  = $this->session->userdata('function');

    $result= array();
    $table = 'tbt_visitation_document'; 

    $this->db->select('tbt_visitation_document.id, tbt_visitation_document.title, tbt_visitation_document.submit_date_sap, tbt_visitation_document.visitor_id '); 
    $this->db->select(', tbt_action_plan.sold_to_id, tbt_action_plan.plan_date, tbt_action_plan.actual_date, tbm_visitation_reason.title as visit_reason, tbt_user.user_firstname as visitor_firstname, tbt_user.user_lastname as visitor_lastname');
    // $this->db->select("tbm_department.title as department_name");
    $this->db->select("group_concat(tbm_department.title separator ',') as department_name", false);
    $this->db->join('tbt_action_plan', 'tbt_action_plan.id = tbt_visitation_document.action_plan_id');
    $this->db->join('tbm_visitation_reason', 'tbt_visitation_document.visit_reason_id = tbm_visitation_reason.id and tbm_visitation_reason.function = "'.$function[0].'"', 'left');
    $this->db->join('tbt_user', 'tbt_user.employee_id = tbt_visitation_document.visitor_id', 'left');
    $this->db->join('tbt_user_position', 'tbt_user.employee_id = tbt_user_position.employee_id', 'left');
    $this->db->join('tbm_position', 'tbt_user_position.position_id = tbm_position.id', 'left');
    $this->db->join('tbm_department', 'tbm_position.department_id = tbm_department.id', 'left');
    // $this->db->join('(SELECT distinct area_id, department_id FROM tbm_position ) tbm_position', 'tbm_position.area_id = tbt_visitation_document.distribution_channel', 'left');
    // $this->db->join('tbm_department', 'tbm_position.department_id = tbm_department.id', 'left');
    $this->db->where('tbt_visitation_document.contract_id !=',0);
    if ($permission['shipto']['value'] == 'related') {
        if (!empty($children)) {
            $children = array_merge($position_list, $children);
            // $this->db->where_in('tbm_position.id', $children);
            $children = implode("','", $children);
            $this->db->where("(tbt_user.employee_id in (select employee_id from tbm_position p LEFT JOIN tbt_user_position up ON up.position_id = p.id where id in ('".$children."')))");
        } else {
            $this->db->where('tbt_visitation_document.visitor_id', $emp_id);
        }
    }
    $this->db->group_by('tbt_visitation_document.id, tbt_visitation_document.title, tbt_visitation_document.submit_date_sap, tbt_visitation_document.visitor_id');
    $this->db->group_by('tbt_action_plan.sold_to_id, tbt_action_plan.plan_date, tbt_action_plan.actual_date, tbm_visitation_reason.title, tbt_user.user_firstname, tbt_user.user_lastname');
    
    $this->db->order_by("tbt_action_plan.plan_date", "desc"); 


    $match = $this->input->post('search');
    if(!empty($match)){
        $this->db->like('tbt_visitation_document.id',$match);
        $this->db->or_like('tbt_visitation_document.title',$match);
        }//end if    

        $result = self::getResultWithPage($table,$page);
        
        $count = $result->num_rows();
        $result = $result->result_array();       

        if (!empty($result)) {
            foreach ($result as $key => $value) {
                $this->db->where('id', $value['sold_to_id']);
                $query = $this->db->get('sap_tbm_sold_to');
                $customer = $query->row_array();

                $result[$key]['customer_name'] = '';
                if (!empty($customer)) {
                    $result[$key]['customer_name'] = $customer['sold_to_name1'];
                }
            }
        }

        $this->db->select('COUNT(DISTINCT tbt_visitation_document.id) AS cnt');
        $this->db->join('tbt_action_plan', 'tbt_action_plan.id = tbt_visitation_document.action_plan_id');
        $this->db->join('tbm_visitation_reason', 'tbt_visitation_document.visit_reason_id = tbm_visitation_reason.id and tbm_visitation_reason.function = "'.$function[0].'"', 'left');
        $this->db->join('tbt_user', 'tbt_user.employee_id = tbt_visitation_document.visitor_id', 'left');
        $this->db->join('tbt_user_position', 'tbt_user.employee_id = tbt_user_position.employee_id', 'left');
        $this->db->join('tbm_position', 'tbt_user_position.position_id = tbm_position.id', 'left');
        $this->db->join('tbm_department', 'tbm_position.department_id = tbm_department.id', 'left');
        // $this->db->join('(SELECT distinct area_id, department_id FROM tbm_position ) tbm_position', 'tbm_position.area_id = tbt_visitation_document.distribution_channel', 'left');
        // $this->db->join('tbm_department', 'tbm_position.department_id = tbm_department.id', 'left');
        $this->db->where('tbt_visitation_document.contract_id !=',0);
        if ($permission['shipto']['value'] == 'related') {
            if (!empty($children)) {
                $children = array_merge($position_list, $children);
                // $this->db->where_in('tbm_position.id', $children);
                $children = implode("','", $children);
                $this->db->where("(tbt_user.employee_id in (select employee_id from tbm_position p LEFT JOIN tbt_user_position up ON up.position_id = p.id where id in ('".$children."')))");
            } else {
                $this->db->where('tbt_visitation_document.visitor_id', $emp_id);
            }
        }
        $this->db->group_by('tbt_visitation_document.id, tbt_visitation_document.title, tbt_visitation_document.submit_date_sap, tbt_visitation_document.visitor_id');
        $this->db->group_by('tbt_action_plan.sold_to_id, tbt_action_plan.plan_date, tbt_action_plan.actual_date, tbm_visitation_reason.title, tbt_user.user_firstname, tbt_user.user_lastname');
        $this->db->order_by("tbt_action_plan.plan_date", "desc"); 

        $match = $this->input->post('search');
        if(!empty($match)){
            $this->db->like('tbt_visitation_document.id',$match);
            $this->db->or_like('tbt_visitation_document.title',$match);
        }//end if  

        $query = $this->db->get($table);
        $total_result = $query->result_array();
        $total_item =  $query->num_rows();//intval($total_result[0]['cnt']);
        $total_item2 = self::get_qr();

        $output = array();
        $state = true;
        $code = '000';
        $msg = '';

       // $output['total_item'] = self::getResultTotalpage_doucument($table,$keyword);
        $output['total_item'] = $total_item;
        $output['list'] = $result;
        $output['page'] = $page;
        $output['page_size'] = $this->pageSize;
        $output['quotation_id'] = '';               
        //$output['total_page'] = ceil(self::getResultTotalpage_doucument($table,$keyword)/$this->pageSize);
        $output['total_page'] = ceil($total_item/$this->pageSize);   
        // $output['query2'] = $query2;
        $output['total_item2'] = self::get_qr();//$total_item2; 
        $output['total_page2'] = ceil($total_item2/$this->pageSize);

        return self::response($state,$code,$msg,$output);
    }

   
    public function getContentList_prospect($page=1,$order=array()){

        $emp_id = $this->session->userdata('id');
        $position_list = $this->session->userdata('position');

        $children = array();
        foreach ($position_list as $key => $position) {
            $children = $this->getPositionChild($children, $position);
        }
        if (!empty($children)) {
                $children = array_merge($position_list, $children);
                $children = implode("','", $children);
        }

        $permission = $this->permission[$this->cat_id];
        $function  = $this->session->userdata('function');

        $result= array();

        $table = 'tbt_visitation_document';           
        $this->db->select('tbt_visitation_document.*,tbt_action_plan.sold_to_id, tbt_action_plan.plan_date, tbt_action_plan.actual_date, tbm_visitation_reason.title as visit_reason, tbt_user.user_firstname as visitor_firstname, tbt_user.user_lastname as visitor_lastname, tbm_department.title as department_name'); 
        $this->db->select('prospect.title as prospect_title');
        $this->db->join('tbt_action_plan', 'tbt_action_plan.id = tbt_visitation_document.action_plan_id');
        $this->db->join('tbm_visitation_reason', 'tbt_visitation_document.visit_reason_id = tbm_visitation_reason.id and tbm_visitation_reason.function = "'.$function[0].'"', 'left');
        $this->db->join('tbt_user', 'tbt_user.employee_id = tbt_visitation_document.visitor_id', 'left');
        $this->db->join('tbt_prospect prospect','prospect.id = tbt_visitation_document.prospect_id');
        // $this->db->join('tbt_user_position', 'tbt_user.employee_id = tbt_user_position.employee_id', 'left');
        // $this->db->join('tbm_position', 'tbt_user_position.position_id = tbm_position.id', 'left');
        //$this->db->join('tbm_department', 'tbm_position.department_id = tbm_department.id', 'left');
        $this->db->join("(SELECT distinct area_id, department_id FROM tbm_position WHERE tbm_position.id in ('".$children."') ) tbm_position", 'tbm_position.area_id = tbt_visitation_document.distribution_channel', 'left');
        $this->db->join('tbm_department', 'tbm_position.department_id = tbm_department.id', 'left');
        $this->db->where('tbt_visitation_document.prospect_id !=',0);
        if ($permission['shipto']['value'] == 'related') {
            if (!empty($children)) {
                $this->db->where("(tbt_user.employee_id in (select employee_id from tbm_position p LEFT JOIN tbt_user_position up ON up.position_id = p.id where id in ('".$children."')))");
            } else {
                $this->db->where('tbt_visitation_document.visitor_id', $emp_id);
            }
        }
        $this->db->order_by("tbt_action_plan.plan_date", "desc"); 

        $match = $this->input->post('search');
        if(!empty($match)){
            $this->db->like('tbt_visitation_document.id',$match);
            $this->db->or_like('tbt_visitation_document.title',$match);
        }//end if   

        $result = self::getResultWithPage($table,$page);
        //$result = self::getResultWithPage_document($table,$page,$keyword);
        $count = $result->num_rows();
        $result = $result->result_array();     

        if (!empty($result)) {
            foreach ($result as $key => $value) {
                $this->db->where('id', $value['sold_to_id']);
                $query = $this->db->get('sap_tbm_sold_to');
                $customer = $query->row_array();

                $result[$key]['customer_name'] = '';
                if (!empty($customer)) {
                    $result[$key]['customer_name'] = $customer['sold_to_name1'];
                }
            }
        }

        $this->db->select('COUNT(*) AS cnt');
        $this->db->join('tbt_action_plan', 'tbt_action_plan.id = tbt_visitation_document.action_plan_id');
        $this->db->join('tbm_visitation_reason', 'tbt_visitation_document.visit_reason_id = tbm_visitation_reason.id and tbm_visitation_reason.function = "'.$function[0].'"', 'left');
        $this->db->join('tbt_user', 'tbt_user.employee_id = tbt_visitation_document.visitor_id', 'left');
        // $this->db->join('tbt_user_position', 'tbt_user.employee_id = tbt_user_position.employee_id', 'left');
        // $this->db->join('tbm_position', 'tbt_user_position.position_id = tbm_position.id', 'left');
        // $this->db->join('tbm_department', 'tbm_position.department_id = tbm_department.id', 'left');
        $this->db->join('(SELECT distinct area_id, department_id FROM tbm_position ) tbm_position', 'tbm_position.area_id = tbt_visitation_document.distribution_channel', 'left');
        $this->db->join('tbm_department', 'tbm_position.department_id = tbm_department.id', 'left');
        $this->db->where('tbt_visitation_document.prospect_id !=',0);
        if ($permission['shipto']['value'] == 'related') {
            if (!empty($children)) {
                $children = array_merge($position_list, $children);
                // $this->db->where_in('tbm_position.id', $children);

                $children = implode("','", $children);
                $this->db->where("(tbt_user.employee_id in (select employee_id from tbm_position p LEFT JOIN tbt_user_position up ON up.position_id = p.id where id in ('".$children."')))");

            } else {
                $this->db->where('tbt_visitation_document.visitor_id', $emp_id);
            }
        }
        $this->db->order_by("tbt_action_plan.plan_date", "desc"); 

        $match = $this->input->post('search');
        if(!empty($match)){
            $this->db->like('tbt_visitation_document.id',$match);
            $this->db->or_like('tbt_visitation_document.title',$match);
        }//end if   

        $query = $this->db->get($table);
        $total_result = $query->result_array();
        $total_item = intval($total_result[0]['cnt']);
        
        $output = array();
        $state = true;
        $code = '000';
        $msg = '';

           // $output['total_item'] = self::getResultTotalpage_doucument($table,$keyword);
        $output['total_item'] = $total_item;
        $output['list'] = $result;
        $output['page'] = $page;
        $output['page_size'] = $this->pageSize;
        $output['quotation_id'] = '';               
            //$output['total_page'] = ceil(self::getResultTotalpage_doucument($table,$keyword)/$this->pageSize);
        $output['total_page'] = ceil($total_item/$this->pageSize);   

        return self::response($state,$code,$msg,$output);
    }

//get item parent getContentList_qt
public function get_qr(){
    $emp_id = $this->session->userdata('id');
    $position_list = $this->session->userdata('position');

    $children = array();
    foreach ($position_list as $key => $position) {
        $children = $this->getPositionChild($children, $position);
    }

    $permission = $this->permission[$this->cat_id];
    $function  = $this->session->userdata('function');

     $table = 'tbt_visitation_document'; 
    /////////////////// coun query bos //////////////////////
    $this->db->select('tbt_visitation_document.id, tbt_visitation_document.title, tbt_visitation_document.submit_date_sap, tbt_visitation_document.visitor_id '); 
    $this->db->select(', tbt_action_plan.sold_to_id, tbt_action_plan.plan_date, tbt_action_plan.actual_date, tbm_visitation_reason.title as visit_reason, tbt_user.user_firstname as visitor_firstname, tbt_user.user_lastname as visitor_lastname');
    // $this->db->select("tbm_department.title as department_name");
    $this->db->select("group_concat(tbm_department.title separator ',') as department_name", false);
    $this->db->join('tbt_action_plan', 'tbt_action_plan.id = tbt_visitation_document.action_plan_id');
    $this->db->join('tbm_visitation_reason', 'tbt_visitation_document.visit_reason_id = tbm_visitation_reason.id and tbm_visitation_reason.function = "'.$function[0].'"', 'left');
    $this->db->join('tbt_user', 'tbt_user.employee_id = tbt_visitation_document.visitor_id', 'left');
    $this->db->join('tbt_user_position', 'tbt_user.employee_id = tbt_user_position.employee_id', 'left');
    $this->db->join('tbm_position', 'tbt_user_position.position_id = tbm_position.id', 'left');
    $this->db->join('tbm_department', 'tbm_position.department_id = tbm_department.id', 'left');
    // $this->db->join('(SELECT distinct area_id, department_id FROM tbm_position ) tbm_position', 'tbm_position.area_id = tbt_visitation_document.distribution_channel', 'left');
    // $this->db->join('tbm_department', 'tbm_position.department_id = tbm_department.id', 'left');
    $this->db->where('tbt_visitation_document.contract_id !=',0);
    if ($permission['shipto']['value'] == 'related') {
    if (!empty($children)) {
        $children = array_merge($position_list, $children);
        // $this->db->where_in('tbm_position.id', $children);
        $children = implode("','", $children);
        $this->db->where("(tbt_user.employee_id in (select employee_id from tbm_position p LEFT JOIN tbt_user_position up ON up.position_id = p.id where id in ('".$children."')))");
    } else {
        $this->db->where('tbt_visitation_document.visitor_id', $emp_id);
    }
    }
    $this->db->group_by('tbt_visitation_document.id, tbt_visitation_document.title, tbt_visitation_document.submit_date_sap, tbt_visitation_document.visitor_id');
    $this->db->group_by('tbt_action_plan.sold_to_id, tbt_action_plan.plan_date, tbt_action_plan.actual_date, tbm_visitation_reason.title, tbt_user.user_firstname, tbt_user.user_lastname');

    $this->db->order_by("tbt_action_plan.plan_date", "desc"); 
    $query2 = $this->db->get($table);
    $total_item2 =  $query2->num_rows();

    return $total_item2;

}








    public function getImageList ($id) {

        $this->db->where(array('object_table' => 'tbt_visitation_document', 'object_id' => $id));
        $query = $this->db->get('tbt_attach_file');

        return $query->result_array();
    }
        // $output = array();
        //     $state = true;
        //     $code = '000';
        //     $msg = '';
        //     $output['total_item'] = self::getResultTotalpage($table);
        //     $output['list'] = $filter_result;
        //     $output['page'] = $page;
        //     $output['page_size'] = $this->pageSize;             
        //     $output['total_page'] = ceil(self::getResultTotalpage($table)/$this->pageSize);                
        //     $output['on_year'] = !empty($year)?$year:'';






//========================================
//============= get sap tbm ==============
//========================================
    


    public function sap_tbm_country(){

        $this->db->select('sap_tbm_country.id,sap_tbm_country.title');      
        $result = $this->db->get('sap_tbm_country');      

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

    public function sap_tbm_region(){

        $this->db->select('sap_tbm_region.id,sap_tbm_region.title');      
        $result = $this->db->get('sap_tbm_region');      

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



    public function sap_tbm_industry(){

        $this->db->select('sap_tbm_industry.id,sap_tbm_industry.title');      
        $result = $this->db->get('sap_tbm_industry');      

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


    public function sap_tbm_business_scale(){

        $this->db->select('sap_tbm_business_scale.id,sap_tbm_business_scale.title');      
        $result = $this->db->get('sap_tbm_business_scale');      

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


    public function get_prospect(){

        $this->db->select('tbt_prospect.id,tbt_prospect.title');        
        $this->db->where('tbt_prospect.delete_flag',0); 
        $result = $this->db->get('tbt_prospect');


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


    public function get_prospectByid($id){

        $this->db->select('tbt_prospect.*');         
        $this->db->where('tbt_prospect.id',$id); 
        $result = $this->db->get('tbt_prospect');


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

    public function get_quotationByid($id){

        $this->db->select('tbt_quotation.*');
        // $this->db->select('tbt_required_document.*,tbt_required_document.id As required_doc_id');
        // $this->db->join('tbt_required_document', 'tbt_required_document.quotation_id = tbt_quotation.id','left');         
        $this->db->where('tbt_quotation.id',$id); 
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


    public function getDocument ($track_doc_id) {         

        $this->db->select('tbt_visitation_document.*,tbt_action_plan.plan_date,tbt_action_plan.id As plan_id,tbt_action_plan.actual_date, tbm_visitation_reason.title as reason');
        $this->db->where('tbt_visitation_document.id', $track_doc_id);  
        $this->db->join('tbt_action_plan', 'tbt_action_plan.id = tbt_visitation_document.action_plan_id','left');
        $this->db->join('tbm_visitation_reason', 'tbm_visitation_reason.id = tbt_visitation_document.visit_reason_id','left');                     

        $result  = $this->db->get('tbt_visitation_document')->row_array();

        if(!empty($result)){

            if (!empty($result['prospect_id'])) {

                $this->db->select('tbt_visitation_document.*,tbt_action_plan.plan_date,tbt_action_plan.id As plan_id,tbt_action_plan.actual_date');
                $this->db->where(array('tbt_action_plan.prospect_id' => $result['prospect_id'], 'tbt_action_plan.plan_date <=' => $result['plan_date'], 'tbt_visitation_document.id !=' => $result['id']));
                $this->db->join('tbt_action_plan', 'tbt_action_plan.id = tbt_visitation_document.action_plan_id','left');
                $this->db->order_by('tbt_visitation_document.id desc');
                $this->db->limit(1);
                $query = $this->db->get('tbt_visitation_document');
                $result['last_visit'] = $query->row_array();

                $this->db->select('sap_tbm_competitor.*');
                $this->db->join('sap_tbm_competitor', 'tbt_prospect.competitor_id = sap_tbm_competitor.competitor_id');
                $this->db->where('id', $result['prospect_id']);
                $result['competitor'] = $this->db->get('tbt_prospect')->row_array();

            } else if (!empty($result['quotation_id'])) {

                $this->db->select('tbt_visitation_document.*,tbt_action_plan.plan_date,tbt_action_plan.id As plan_id,tbt_action_plan.actual_date');
                $this->db->where(array('tbt_visitation_document.quotation_id' => $result['quotation_id'], 'tbt_action_plan.plan_date <=' => $result['plan_date'], 'tbt_visitation_document.id !=' => $result['id']));
                $this->db->join('tbt_action_plan', 'tbt_action_plan.id = tbt_visitation_document.action_plan_id','left');
                $this->db->order_by('tbt_visitation_document.id desc');
                $this->db->limit(1);
                $query = $this->db->get('tbt_visitation_document');
                $result['last_visit'] = $query->row_array();

                $this->db->select('sap_tbm_competitor.*');
                $this->db->join('sap_tbm_competitor', 'tbt_quotation.competitor_id = sap_tbm_competitor.competitor_id');
                $this->db->where('id', $result['quotation_id']);
                $result['competitor'] = $this->db->get('tbt_quotation')->row_array();
            }

            $output = $result;
        }else{
            $output = $result;
        }

        // echo "<pre>";
        // print_r($output);
        // echo "</pre>";

        // die();
        return $output;
    }

    public function delete($action_plan_id,$doc_id){       

        $this->db->where('action_plan_id', $action_plan_id);
        $this->db->update('tbt_user_marked', array('action_plan_id' => 0));

        $this->db->delete('tbt_attach_file', array('object_id' => $doc_id, 'object_table' => 'tbt_visitation_document'));
        $this->db->delete('tbt_visitation_document', array('id' => $doc_id));
        $this->db->delete('tbt_action_plan', array('id' => $action_plan_id));
    }

    public function getNotVisitReason () {

        $function = $this->session->userdata('function');

        if (!empty($function)) {
            $this->db->where_in('function', $function);
            $query = $this->db->get('tbm_not_visit_reason');
            $result = $query->result_array();

            return $result;
        }

        return array();
    }

    public function getFunctionMember () {

        $output = array(
            'CR' => array(),
            'OP' => array(),
            'HR' => array(),
            'TN' => array(),
            'IC' => array(),
            'MK' => array()
            );

        foreach ($output as $fn => $value) {

            $this->db->distinct('tbt_user.employee_id, tbt_user.user_firstname, tbt_user.user_lastname, tbt_user.user_email');
            $this->db->select('tbt_user.employee_id, tbt_user.user_firstname, tbt_user.user_lastname, tbt_user.user_email');

            $this->db->join('tbt_user_position', 'tbt_user.employee_id = tbt_user_position.employee_id');
            $this->db->join('tbm_position', 'tbt_user_position.position_id = tbm_position.id');
            $this->db->join('tbm_department', 'tbm_position.department_id = tbm_department.id');
            $this->db->where('tbm_department.function', $fn);
            $this->db->like('tbt_user.user_email', '@psgeneration.com');

            $this->db->order_by('tbt_user.user_firstname, tbt_user.user_lastname');
            $query = $this->db->get('tbt_user');
            $output[$fn] = $query->result_array();

            //Remove Later
            $this->db->distinct('tbt_user.employee_id, tbt_user.user_firstname, tbt_user.user_lastname, tbt_user.user_email');
            $this->db->select('tbt_user.employee_id, tbt_user.user_firstname, tbt_user.user_lastname, tbt_user.user_email');

            $this->db->join('tbt_user_position', 'tbt_user.employee_id = tbt_user_position.employee_id');
            $this->db->join('tbm_position', 'tbt_user_position.position_id = tbm_position.id');
            $this->db->join('tbm_department', 'tbm_position.department_id = tbm_department.id');
            $this->db->where('tbm_department.function', $fn);
            $this->db->like('tbt_user.user_email', '@bossup.co.th');

            $this->db->order_by('tbt_user.user_firstname, tbt_user.user_lastname');
            $query = $this->db->get('tbt_user');
            $bossup_email = $query->result_array();

            // echo "<pre>";
            // print_r($bossup_email);
            // echo "</pre>";

            $output[$fn] = array_merge($output[$fn], $bossup_email);
        }

        // echo "<pre>";
        // print_r($output);
        // echo "</pre>";
        // die();
        return $output;
    }


}//end model

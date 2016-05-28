<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class __employee_track_model extends MY_Model{

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

   public function getContentList($page=1,$keyword='',$order=array()){

    $emp_id = $this->session->userdata('id');
    $position_list = $this->session->userdata('position');

    $children = array();
    foreach ($position_list as $key => $position) {
        $children = $this->getPositionChild($children, $position);
    }

    $permission = $this->permission[$this->cat_id];

    if(!empty($order)){
        $this->db->order_by($order);
    }

    $table = 'tbt_employee_track_document';        
    $this->db->distinct('tbt_asset_track_document.*');  
    $this->db->select('tbt_employee_track_document.* ,tbt_action_plan.plan_date AS plan_date,tbt_action_plan.actual_date AS actual_date');
    $this->db->join('tbt_action_plan', 'tbt_action_plan.id = tbt_employee_track_document.action_plan_id','left');
    $this->db->join('tbt_user_customer', 'tbt_user_customer.ship_to_id = tbt_action_plan.ship_to_id','left');
    $this->db->join('tbt_user', 'tbt_user_customer.user_id = tbt_user.user_id','left'); 
    $this->db->join('tbt_user_position', 'tbt_user.employee_id = tbt_user_position.employee_id','left'); 
    $this->db->join('tbm_position', 'tbt_user_position.position_id = tbm_position.id','left'); 

    if ($permission['shipto']['value'] == 'related') {
        if (!empty($children)) {
            $children = array_merge($position_list, $children);
            $this->db->where_in('tbm_position.id', $children);
        } else {
            $this->db->where('tbt_user.employee_id', $emp_id);
        }
    }  

    $this->db->where('tbt_employee_track_document.quotation_id',$keyword);
    $this->db->order_by('tbt_action_plan.plan_date desc');
        //$this->db->get($table);

        ///////////////////////// start : serch ////////////////////////////////
    $config = Array(     
        "visible_column" => Array
        (
            Array
            (
                "name" => "tbt_employee_track_document.id"                                   
                ),
            Array
            (
                "name" => "tbt_employee_track_document.title"                                   
                ),
            Array
            (
                "name" => "tbt_action_plan.plan_date"                                   
                ),
            Array
            (
                "name" => "tbt_action_plan.actual_date"                                   
                )                                                                  
            )
        );

        //==Set up keyword Search 
    $match = $this->input->post('search');
    $condition_count = 0;
    if(!empty($match)){
        $this->db->like('tbt_employee_track_document.title',$match);
        }//end if   


        ///////////////////////// end : serch ////////////////////////////////

        $result = self::getResultWithPage($table,$page);
        
        $count = $result->num_rows();
        $result = $result->result_array();
        //die($this->db->last_query());

        $this->db->select('COUNT(*) AS cnt');
        $this->db->join('tbt_action_plan', 'tbt_action_plan.id = tbt_employee_track_document.action_plan_id','left');
        $this->db->join('tbt_user_customer', 'tbt_user_customer.ship_to_id = tbt_action_plan.ship_to_id','left');
        $this->db->join('tbt_user', 'tbt_user_customer.user_id = tbt_user.user_id','left');
        $this->db->join('tbt_user_position', 'tbt_user.employee_id = tbt_user_position.employee_id','left'); 
        $this->db->join('tbm_position', 'tbt_user_position.position_id = tbm_position.id','left'); 

        if ($permission['shipto']['value'] == 'related') {
            if (!empty($children)) {
                $children = array_merge($position_list, $children);
                $this->db->where_in('tbm_position.id', $children);
            } else {
                $this->db->where('tbt_user.employee_id', $emp_id);
            }
        }  

        $this->db->where('tbt_employee_track_document.quotation_id',$keyword);
        $this->db->order_by('tbt_action_plan.plan_date desc');
        //$this->db->get($table);

        ///////////////////////// start : serch ////////////////////////////////
        $config = Array(     
            "visible_column" => Array
            (
                Array
                (
                    "name" => "tbt_employee_track_document.id"                                   
                    ),
                Array
                (
                    "name" => "tbt_employee_track_document.title"                                   
                    ),
                Array
                (
                    "name" => "tbt_action_plan.plan_date"                                   
                    ),
                Array
                (
                    "name" => "tbt_action_plan.actual_date"                                   
                    )                                                                  
                )
            );

        //==Set up keyword Search 
        $match = $this->input->post('search');
        $condition_count = 0;
        if(!empty($match)){
            $this->db->like('tbt_employee_track_document.title',$match);
        }//end if   

        $query = $this->db->get($table);
        $total_result = $query->result_array();
        $total_item = intval($total_result[0]['cnt']);
        
        $this->db->select('tbt_quotation.*, sap_tbm_ship_to.ship_to_name1 as ship_to_name');
        $this->db->from('tbt_quotation');
        $this->db->join('sap_tbm_sold_to', 'sap_tbm_sold_to.id = tbt_quotation.sold_to_id');
        $this->db->join('sap_tbm_ship_to', 'sap_tbm_ship_to.id = tbt_quotation.ship_to_id');
        $this->db->where('tbt_quotation.id',$keyword);

        $query = $this->db->get();
        $project_result = $query->row_array();

        $output = array();
        $state = true;
        $code = '000';
        $msg = '';
        $output['total_item'] = $total_item;
        $output['list'] = $result;
        $output['page'] = $page;
        $output['page_size'] = $this->pageSize;
        $output['quotation_id'] = $keyword;          
        $output['project'] = $project_result;        
        $output['total_page'] = ceil($total_item/$this->pageSize);
        //echo "<pre>"; print_r($result);exit();
        return self::response($state,$code,$msg,$output);
    }


    public function getContentById($table,$id, $status){      

        //TODO :: qery by id
        if(!empty($id))

            $this->db->select(''.$table.'.*,tbt_action_plan.id As plan_id,tbt_action_plan.actual_date As actual_date,tbt_action_plan.plan_date');
        $this->db->select('hr_employee.firstname As actor_name,hr_employee.lastname As actor_surname');
        $this->db->select('hr_employee.level');
        $this->db->select('tbt_employee_track_document.title As project_title,tbt_employee_track_document.survey_officer_id As survey_officer,tbt_employee_track_document.actor_by_id As project_owner_id');
        $this->db->join('tbt_employee_track_document', 'tbt_employee_track_document.id = '.$table.'.employee_track_document_id' ,'left');
        $this->db->join('tbt_action_plan', 'tbt_action_plan.id = tbt_employee_track_document.action_plan_id','left');  
        $this->db->join('hr_employee', 'hr_employee.employee_id = '.$table.'.employee_id','left');            
        $this->db->where($table.'.employee_track_document_id',$id);
        if ($status != '0') {
            $this->db->where('tbt_employee_track.status',$status);
        }                 
        $result  = $this->db->get($table);

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

    public function getQuestion($table, $revision_id) {
        $this->db->where('revision_id', $revision_id);   
        $this->db->order_by('sequence_index', 'asc');   
        $query = $this->db->get($table);

        return $query->result_array();
    }

    public function getEmployeeInfo($emp_id, $doc) {

        $this->db->select('hr_employee.*, tbt_employee_track.employee_track_document_id as doc_id, tbt_employee_track.serialized_answer as answer, tbt_employee_track.serialized_satisfaction_answer as satisfaction_answer, tbt_employee_track.opinion_satisfaction_answer as opinion_satisfaction_answer');
        $this->db->from('tbt_employee_track');
        $this->db->join('hr_employee', 'hr_employee.employee_id = tbt_employee_track.employee_id','left'); 
        $this->db->where('hr_employee.employee_id', $emp_id);      
        $this->db->where('tbt_employee_track.employee_track_document_id', $doc);        
        
        $query = $this->db->get();          

        return $query->row_array();
    }

    public function getEmployeeDocument($track_doc_id){            

        $this->db->select('tbt_employee_track_document.*,tbt_action_plan.plan_date,tbt_action_plan.id As plan_id,tbt_action_plan.actual_date');
        $this->db->where('tbt_employee_track_document.id', $track_doc_id);

        $this->db->join('tbt_action_plan', 'tbt_action_plan.id = tbt_employee_track_document.action_plan_id','left');                           

        $result  = $this->db->get('tbt_employee_track_document');


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


    function update($serial,$status_tracking,$remark,$doc_id){

        if(empty($status_tracking)){
            $status_tracking = '';
        }

        $data = array(
            'status' => $status_tracking,
            'remark' => $remark,
            //'status' => $status
            );

        $this->db->where('employee_id', $serial);
        $this->db->where('employee_track_document_id', $doc_id);
        $query=$this->db->update('tbt_employee_track', $data);

        if($query) {
            return TRUE;
            //return self::response($msg);
        }else{
            return FALSE;
            //return self::response($msg);
        }
    }    

    public function clone_insert_employee($track_doc_id,$quotation_id, $ship_to_id){
        //echo "clone";

        $this->db->where('employee_track_document_id',$track_doc_id);
        $query1 = $this->db->delete('tbt_employee_track');       

         //====start : get asset insert to tbt_asset_track =========
        $this->db->select('*');
        $this->db->from('hr_employee');
        $this->db->where('ship_to',$ship_to_id);
        $this->db->where('delete_flag', 0);
        $query_project=$this->db->get();  
        $result = $query_project->result_array();

        foreach ($result as $row){         
            if ($row['level'] == "Manager") {
                $row['level'] = "head";
            }
            $data_employee_track = array(
                'employee_id' => $row['employee_id'],
                'employee_track_document_id' => $track_doc_id,
                'employee_level' => $row['level'],
                'serialized_answer' => "",
                'serialized_satisfaction_answer' => "" ,
                'remark' => '',
                );

            $this->db->where(array('employee_id' => $row['employee_id'], 'employee_track_document_id' => $track_doc_id));
            $query = $this->db->get('tbt_employee_track');
            $exist = $query->row();

            if (empty($exist)) {
                $this->db->insert('tbt_employee_track', $data_employee_track);
            }

        }

        if($query1){
            return TRUE;
            //return self::response($msg);
        }else{
            return FALSE;
            //return self::response($msg);
        }
    }


    function update_check_answer($doc_id,$employee_id, $answer){    

        $this->db->where('employee_id', $employee_id);
        $this->db->where('employee_track_document_id', $doc_id);
        $query=$this->db->update('tbt_employee_track', array('serialized_answer' => $answer));

        if($query) {
            return TRUE;
            //return self::response($msg);
        }else{
            return FALSE;
            //return self::response($msg);
        }
    }    


    function update_satisfaction_answer($doc_id,$employee_id, $answer, $opinion_satisfaction_answer){

        $this->db->where('employee_id', $employee_id);
        $this->db->where('employee_track_document_id', $doc_id);
        $query=$this->db->update('tbt_employee_track', array('serialized_satisfaction_answer' => $answer, 'opinion_satisfaction_answer' => $opinion_satisfaction_answer));

        if($query) {
            return TRUE;
            //return self::response($msg);
        }else{
            return FALSE;
            //return self::response($msg);
        }
    }  

    function update_to_sap($track_doc_id){


       $data = array(
        'submit_date' => date('y-m-d'),           
        );

       $this->db->where('id', $track_doc_id);
       $query=$this->db->update('tbt_asset_track_document', $data);


       if($query) {
        return TRUE;
            //return self::response($msg);
    }else{
        return FALSE;
            //return self::response($msg);
    }
}

public function delete($id,$table,$actionplan_id){
        //echo "model test delete";

    $this->db->where('action_plan_id',$actionplan_id);
    $this->db->update('tbt_user_marked', array('action_plan_id' => 0));

    $this->db->where('id',$id);
    $query1 = $this->db->delete($table);

    $this->db->where('id',$actionplan_id);
    $query2 = $this->db->delete('tbt_action_plan');

    $this->db->where('employee_track_document_id',$id);
    $query3 = $this->db->delete('tbt_employee_track');

    if($query1 && $query2 && $query3){
        return TRUE;
            //return self::response($msg);
    }else{
        return FALSE;
            //return self::response($msg);
    }
}

function _padZero ($text, $length) {
    return str_pad($text, $length, '0', STR_PAD_LEFT);
}

function _dateFormat ( $date ) {
    return date("Ymd", strtotime($date));
}

}//end model

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class __quality_assurance_model extends MY_Model{

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

    public function checkManagerApprove ($id, $quotation_id) {

        $result = array();  

        $this->db->select('tbt_quality_survey.* ,tbt_action_plan.plan_date AS plan_date');
        $this->db->join('tbt_action_plan', 'tbt_action_plan.id = tbt_quality_survey.action_plan_id','left');
        $this->db->where('tbt_quality_survey.quotation_id',$quotation_id);
        $this->db->order_by('tbt_action_plan.plan_date desc, tbt_quality_survey.id desc');
        $query = $this->db->get('tbt_quality_survey');
        $result = $query->result_array(); 

        // echo "<pre>";
        // print_r($result);
        // echo "</pre>";

        $manager_btn_disabled = 0;

        if (!empty($result)) {

            $prev = array();

            for ($i = sizeof($result)-1; $i >= 0; $i--) {

                $next = array();
                if ($i > 0) {
                    $next = $result[$i-1];
                }

                $row = $result[$i];

                if ($row['id'] == $id) {

                    if (
                        $row['status'] != 'being' ||
                        (
                            !empty($prev) &&
                            $prev['status'] == 'being'
                            ) ||
                        (
                            !empty($next) &&
                            $next['status'] != 'being'
                            ) 
                        ) 
                    {
                        $manager_btn_disabled = 1;
                    }

                }            

                $prev = $row;
            }

        }

        return $manager_btn_disabled;

    }

    public function getContentList($page=1,$keyword='',$order=array()){

        $emp_id = $this->session->userdata('id');
        $position_list = $this->session->userdata('position');

        $children = array();
        foreach ($position_list as $key => $position) {
            $children = $this->getPositionChild($children, $position);
        }

        $permission = $this->permission[$this->cat_id];

        $table = 'tbt_quality_survey';      
        $result = array();  

        $this->db->distinct('tbt_quality_survey.*');  
        $this->db->select('tbt_quality_survey.* ,tbt_action_plan.plan_date AS plan_date');
        $this->db->join('tbt_action_plan', 'tbt_action_plan.id = tbt_quality_survey.action_plan_id', 'left');
        $this->db->join('tbt_user_customer', 'tbt_user_customer.ship_to_id = tbt_action_plan.ship_to_id', 'left');
        $this->db->join('tbt_user', 'tbt_user_customer.user_id = tbt_user.user_id', 'left'); 
        $this->db->join('tbt_user_position', 'tbt_user.employee_id = tbt_user_position.employee_id', 'left'); 
        $this->db->join('tbm_position', 'tbt_user_position.position_id = tbm_position.id', 'left'); 

        if ($permission['shipto']['value'] == 'related') {
            if (!empty($children)) {
                $children = array_merge($position_list, $children);
                $this->db->where_in('tbm_position.id', $children);
            } else {
                $this->db->where('tbt_user.employee_id', $emp_id);
            }
        }  

        $this->db->where('tbt_quality_survey.quotation_id',$keyword);
        $this->db->order_by('tbt_action_plan.plan_date desc, tbt_quality_survey.id desc');

        $match = $this->input->post('search');
        $condition_count = 0;
        if(!empty($match)){
            $this->db->like('tbt_quality_survey.id',$match);
            $this->db->or_like('tbt_quality_survey.title',$match);
        }  

        $result = self::getResultWithPage($table,$page);

        $count = $result->num_rows();
        $result = $result->result_array(); 
        // die($this->db->last_query());
        $this->db->select('COUNT(*) AS cnt');
        $this->db->join('tbt_action_plan', 'tbt_action_plan.id = tbt_quality_survey.action_plan_id','left');
        $this->db->join('tbt_user_customer', 'tbt_user_customer.ship_to_id = tbt_action_plan.ship_to_id','left');
        $this->db->join('tbt_user', 'tbt_user_customer.user_id = tbt_user.user_id','left'); 
        $this->db->join('tbt_user_position', 'tbt_user.employee_id = tbt_user_position.employee_id','left'); 
        $this->db->join('tbm_position', 'tbt_user_position.position_id = tbm_position.id','left'); 

        $this->db->where('tbt_quality_survey.quotation_id',$keyword);

        if ($permission['shipto']['value'] == 'related') {
            if (!empty($children)) {
                $children = array_merge($position_list, $children);
                $this->db->where_in('tbm_position.id', $children);
            } else {
                $this->db->where('tbt_user.employee_id', $emp_id);
            }
        }  

        $match = $this->input->post('search');
        if(!empty($match)){
            $this->db->like('tbt_quality_survey.id',$match);
            $this->db->or_like('tbt_quality_survey.title',$match);
        }//end if    
        $query = $this->db->get($table);
        $total_result = $query->result_array();
        $total_item = intval($total_result[0]['cnt']);

        $result_output = array();
        if (!empty($result)) {
            foreach ($result as $value) {
                if (!array_key_exists($value['site_inspector_id'], $result_output)) {
                    $result_output[$value['site_inspector_id']] = array();
                }

                array_push($result_output[$value['site_inspector_id']], $value);
            }

            $prev = array();

            foreach ($result_output as $key => $result) {

                for ($i = sizeof($result)-1; $i >= 0; $i--) {

                    $next = array();
                    if ($i > 0) {
                        $next = $result_output[$key][$i-1];
                    }

                    $row = $result[$i];
                    $result_output[$key][$i]['btn_disabled'] = 0;
                    $result_output[$key][$i]['next_disabled'] = 0;
                    $result_output[$key][$i]['manager_btn_disabled'] = 0;

                    if ($row['status'] == 'being' && !empty($next) && ($next['status'] == 'approved' || $next['status'] == 'complete')) {
                        $result_output[$key][$i]['btn_disabled'] = 1;
                        $result_output[$key][$i]['next_disabled'] = 1;

                        for ($j=$i+1; $j<=sizeof($result)-1; $j++) {
                            if (!empty($result_output[$key][$j]) && $result_output[$key][$j]['status'] == 'being') {
                                $result_output[$key][$j]['btn_disabled'] = 1;
                                $result_output[$key][$j]['next_disabled'] = 1;

                            }
                        }
                    } else if ($row['status'] == 'being' && (empty($prev) || (!empty($prev) && ($prev['status'] == 'being' || $prev['status'] == 'approved')) )) {
                        $result_output[$key][$i]['btn_disabled'] = 1;
                    }

                    if ($row['status'] == 'being' && !empty($prev) && $prev['status'] == 'being') {
                        $result_output[$key][$i]['manager_btn_disabled'] = 1;
                    }

                    // echo $key.' | '.$i.' | '.$row['plan_date'].' | ';
                    // if (!empty($prev)) {
                    //     echo 'Prev: '.$prev['status'].' | ';
                    // }
                    // echo 'Cur: '.$row['status'];
                    // if (!empty($next)) {
                    //     echo ' | Next: '.$next['status'];
                    // }

                    // echo ' : '.$result_output[$key][$i]['btn_disabled'].'<hr>';

                    $this->db->select('tbt_quality_survey_area.*');
                    $this->db->where('quality_survey_id', $row['id']);
                    $query = $this->db->get('tbt_quality_survey_area');

                    $area_list = $query->result_array();

                    if (!empty($area_list)) {
                        $result_output[$key][$i]['all_area_question'] = 0;
                        $result_output[$key][$i]['all_pass'] = 0;
                        $result_output[$key][$i]['all_not_pass'] = 0;

                        foreach ($area_list as $area) {
                            $answer_list = unserialize($area['serialized_answer']);
                            if ($answer_list != null) {
                                # code...
                                foreach ($answer_list as $answer) {

                                    if ($answer['status'] == 'pass') {
                                        $result_output[$key][$i]['all_pass']++;
                                        $result_output[$key][$i]['all_area_question']++;
                                    } else if ($answer['status'] == 'not_pass') {
                                        $result_output[$key][$i]['all_not_pass']++;
                                        $result_output[$key][$i]['all_area_question']++;
                                    }
                                }
                            }
                        }
                    }

                    $prev = $row;
                }
            }


        }

        // echo "<pre>";
        // print_r($result_output);
        // echo "</pre>";

        // die('x');

        $all_result = array();
        foreach ($result_output as $emp_id => $value) {
            foreach ($value as $key => $value2) {
                array_push($all_result, $value2);
            }
        }

        function sortResult($a, $b) {
            return (($a['plan_date'] == $b['plan_date'] && $a['id'] < $b['id']) || ($a['plan_date'] < $b['plan_date']));
        }

        usort($all_result, "sortResult");

        // die();
        
        $this->db->select('tbt_quotation.*, sap_tbm_ship_to.ship_to_name1 as ship_to_name');
        $this->db->from('tbt_quotation');
        $this->db->join('sap_tbm_sold_to', 'sap_tbm_sold_to.id = tbt_quotation.sold_to_id', 'left');
        $this->db->join('sap_tbm_ship_to', 'sap_tbm_ship_to.id = tbt_quotation.ship_to_id', 'left');
        $this->db->where('tbt_quotation.id',$keyword);

        $query = $this->db->get();
        $project_result = $query->row_array();

        $output = array();
        $state = true;
        $code = '000';
        $msg = '';
        $output['total_item'] = $total_item;
        $output['list'] = $all_result;
        $output['page'] = $page;
        $output['page_size'] = $this->pageSize;
        $output['quotation_id'] = $keyword;          
        $output['project'] = $project_result;        
        $output['total_page'] = ceil($total_item/$this->pageSize);
       // echo "<pre>"; print_r($all_result);
        return self::response($state,$code,$msg,$output);
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

    public function getViewAnswer ($track_doc_id, $contract_id) {

        $this->db->select('tbt_quality_survey.*, tbt_action_plan.plan_date, tbt_action_plan.create_date');
        $this->db->join('tbt_action_plan', 'tbt_action_plan.id = tbt_quality_survey.action_plan_id');
        $this->db->where(array('tbt_quality_survey.id =' => $track_doc_id));         
        $query = $this->db->get('tbt_quality_survey');
        $row = $query->row_array();

        $prev_month_row = array();
        $prev_prev_month_row = array();
        $prev_month = '';
        $prev_prev_month = '';

        $output['area_answer'] = array();
        $output['KPI_answer'] = array();
        $output['customer_answer'] = array();
        $output['document_answer'] = array();
        $output['policy_answer'] = array();

        if (!empty($row)) {

            $this->db->select('tbt_quality_survey.*, tbt_action_plan.plan_date, tbt_action_plan.create_date');
            $this->db->join('tbt_action_plan', 'tbt_action_plan.id = tbt_quality_survey.action_plan_id');
            $this->db->where(array('tbt_quality_survey.site_inspector_id' => $row['site_inspector_id'], 'tbt_action_plan.plan_date' => $row['plan_date'],'tbt_quality_survey.id <' => $row['id'], 'tbt_quality_survey.contract_id' => $contract_id)); 
            $this->db->order_by('tbt_action_plan.plan_date desc, id desc');
            $query  = $this->db->get('tbt_quality_survey');
            $prev_month_row = $query->row_array();

            if (empty($prev_month_row)) {

                $this->db->select('tbt_quality_survey.*, tbt_action_plan.plan_date, tbt_action_plan.create_date');
                $this->db->join('tbt_action_plan', 'tbt_action_plan.id = tbt_quality_survey.action_plan_id');
                $this->db->where(array('tbt_quality_survey.site_inspector_id' => $row['site_inspector_id'], 'tbt_action_plan.plan_date <' => $row['plan_date'], 'tbt_quality_survey.contract_id' => $contract_id)); 
                $this->db->order_by('tbt_action_plan.plan_date desc, id desc');
                $query  = $this->db->get('tbt_quality_survey');
                $prev_month_row = $query->row_array();

            }

            //First Month
            $month = '1-'.date('j F Y', strtotime($row['plan_date']));

            $KPI_revision_id      = $row['KPI_revision_id'];
            $customer_revision_id = $row['customer_revision_id'];
            $document_revision_id = $row['document_control_revision_id'];
            $policy_revision_id   = $row['policy_revision_id'];
            
            if ( $KPI_revision_id == $row['KPI_revision_id'] ) {
                $output['KPI_answer'][$month] = unserialize($row['KPI_serialized_answer']);
            }
            if ( $customer_revision_id == $row['customer_revision_id'] ) {
                $output['customer_answer'][$month] = unserialize($row['customer_serialized_answer']);
            }
            if ( $document_revision_id == $row['document_control_revision_id'] ) {
                $output['document_answer'][$month] = unserialize($row['document_control_serialized_answer']);
            }
            if ( $policy_revision_id == $row['policy_revision_id'] ) {
                $output['policy_answer'][$month] = unserialize($row['policy_serialized_answer']);
            }

            if (!empty($prev_month_row)) {
                $prev_month = '2-'.date('j F Y', strtotime($prev_month_row['plan_date']));

                if ( $KPI_revision_id == $prev_month_row['KPI_revision_id'] ) {
                    $output['KPI_answer'][$prev_month] = unserialize($prev_month_row['KPI_serialized_answer']);
                }
                if ( $customer_revision_id == $prev_month_row['customer_revision_id'] ) {
                    $output['customer_answer'][$prev_month] = unserialize($prev_month_row['customer_serialized_answer']);
                }
                if ( $document_revision_id == $prev_month_row['document_control_revision_id'] ) {
                    $output['document_answer'][$prev_month] = unserialize($prev_month_row['document_control_serialized_answer']);
                }
                if ( $policy_revision_id == $prev_month_row['policy_revision_id'] ) {
                    $output['policy_answer'][$prev_month] = unserialize($prev_month_row['policy_serialized_answer']);
                }   

                $this->db->select('tbt_quality_survey.*, tbt_action_plan.plan_date, tbt_action_plan.create_date');
                $this->db->join('tbt_action_plan', 'tbt_action_plan.id = tbt_quality_survey.action_plan_id');
                $this->db->where(array('tbt_quality_survey.site_inspector_id' => $prev_month_row['site_inspector_id'], 'tbt_action_plan.plan_date' => $prev_month_row['plan_date'],'tbt_quality_survey.id <' => $prev_month_row['id'], 'tbt_quality_survey.contract_id' => $contract_id)); 
                $this->db->order_by('tbt_action_plan.plan_date desc, id desc');
                $query  = $this->db->get('tbt_quality_survey');
                $prev_prev_month_row = $query->row_array();

                if (empty($prev_prev_month_row)) {

                    $this->db->select('tbt_quality_survey.*, tbt_action_plan.plan_date, tbt_action_plan.create_date');
                    $this->db->join('tbt_action_plan', 'tbt_action_plan.id = tbt_quality_survey.action_plan_id');
                    $this->db->where(array('tbt_quality_survey.site_inspector_id' => $prev_month_row['site_inspector_id'], 'tbt_action_plan.plan_date <' => $prev_month_row['plan_date'], 'tbt_quality_survey.contract_id' => $contract_id)); 
                    $this->db->order_by('tbt_action_plan.plan_date desc, id desc');
                    $query  = $this->db->get('tbt_quality_survey');
                    $prev_prev_month_row = $query->row_array();
                }

                if (!empty($prev_prev_month_row)) {
                    $prev_prev_month = '3-'.date('j F Y', strtotime($prev_prev_month_row['plan_date']));

                    if ( $KPI_revision_id == $prev_prev_month_row['KPI_revision_id'] ) {
                        $output['KPI_answer'][$prev_prev_month] = unserialize($prev_prev_month_row['KPI_serialized_answer']);
                    }
                    if ( $customer_revision_id == $prev_prev_month_row['customer_revision_id'] ) {
                        $output['customer_answer'][$prev_prev_month] = unserialize($prev_prev_month_row['customer_serialized_answer']);
                    }
                    if ( $document_revision_id == $prev_prev_month_row['document_control_revision_id'] ) {
                        $output['document_answer'][$prev_prev_month] = unserialize($prev_prev_month_row['document_control_serialized_answer']);
                    }
                    if ( $policy_revision_id == $prev_prev_month_row['policy_revision_id'] ) {
                        $output['policy_answer'][$prev_prev_month] = unserialize($prev_prev_month_row['policy_serialized_answer']);
                    }
                }
            }

            $this->db->where('quality_survey_id', $row['id']);
            $this->db->where('is_select', 1);
            $query  = $this->db->get('tbt_quality_survey_area');
            $area_list = $query->result_array();

            if (!empty($area_list)) {
                foreach ($area_list as $area) {

                    $output['area_answer'][$area['id']]['answer_list'][$month] = unserialize($area['serialized_answer']);

                    if (!empty($prev_month_row)) {

                        $this->db->where(array('quality_survey_id' => $prev_month_row['id'], 'id' => $area['id'], 'is_select' => 1));
                        $query = $this->db->get('tbt_quality_survey_area');
                        $prev_area = $query->row_array();

                        if (!empty($prev_area) && $row['question_revision_id'] == $prev_month_row['question_revision_id']) {

                            $output['area_answer'][$area['id']]['answer_list'][$prev_month] = unserialize($prev_area['serialized_answer']);

                        }
                    }

                    if (!empty($prev_prev_month_row)) {

                        $this->db->where(array('quality_survey_id' => $prev_prev_month_row['id'], 'id' => $area['id'], 'is_select' => 1));
                        $query = $this->db->get('tbt_quality_survey_area');
                        $prev_prev_area = $query->row_array();

                        if (!empty($prev_prev_area) && $row['question_revision_id'] == $prev_prev_month_row['question_revision_id']) {

                            $output['area_answer'][$area['id']]['answer_list'][$prev_prev_month] = unserialize($prev_prev_area['serialized_answer']);

                        }
                    }
                }

            }

            return $output;
        }
    }

    public function getManagerDocument ($track_doc_id) {


        $this->db->select('tbt_quality_survey.*,tbt_action_plan.plan_date,tbt_action_plan.id As plan_id');
        $this->db->where('tbt_quality_survey.id', $track_doc_id);
        $this->db->join('tbt_action_plan', 'tbt_action_plan.id = tbt_quality_survey.action_plan_id','left');                           

        $query  = $this->db->get('tbt_quality_survey');
        $result = $query->row_array();

        if (!empty($result)) {

            $result['KPI_answer'] = unserialize($result['KPI_serialized_answer']);
            $result['customer_answer'] = unserialize($result['customer_serialized_answer']);
            $result['document_control_answer'] = unserialize($result['document_control_serialized_answer']);
            $result['policy_answer'] = unserialize($result['policy_serialized_answer']);

            $this->db->select('tbt_quality_survey_area.*, tbt_quality_survey_area.building_id, tbt_quality_survey_area.floor_id, tbt_quality_survey_area.industry_room_id as area_type, sap_tbm_industry_room.title as industry_room_description, tbt_floor.title as floor, tbt_building.title as building');
            $this->db->where('quality_survey_id', $result['id']);
            $this->db->where('is_select', 1);
            $this->db->join('tbt_quality_survey', 'tbt_quality_survey.id = tbt_quality_survey_area.quality_survey_id');
            $this->db->join('tbt_quotation', 'tbt_quotation.id = tbt_quality_survey.quotation_id');
            $this->db->join('sap_tbm_industry_room', 'sap_tbm_industry_room.id = tbt_quality_survey_area.industry_room_id and sap_tbm_industry_room.industry_id = tbt_quotation.ship_to_industry');
            $this->db->join('tbt_floor', 'tbt_quality_survey_area.floor_id = tbt_floor.id');
            $this->db->join('tbt_building', 'tbt_quality_survey_area.building_id = tbt_building.id');
            $this->db->order_by('tbt_quality_survey_area.order_index');
            $query = $this->db->get('tbt_quality_survey_area');

            $area_list = $query->result_array();
            if (!empty($area_list)) {
                $result['all_area_question'] = 0;
                $result['all_pass'] = 0;
                $result['all_not_pass'] = 0;
                $area_question = array();
                foreach ($area_list as $key => $area) {

                    $this->db->where('id', $area['prev_id']);
                    $query  = $this->db->get('tbt_quality_survey_area');
                    $prev_area = $query->row_array();

                    $area['prev_result'] = array();
                    if (!empty($prev_area)) {   
                        $area['prev_result'] = unserialize($prev_area['serialized_answer']);
                    }

                    $this->db->where(array('industry_room_id' => $area['area_type'], 'revision_id' => $area['question_revision_id']));
                    $query = $this->db->get('tbm_quality_survey_area_question');

                    $area_question[$area['id']]['id']       = $area['id'];
                    $area_question[$area['id']]['index']    = $area['order_index'];

                    $area_question_result = $query->result_array();

                    if (!empty($area_question_result)) {
                        foreach ($area_question_result as $q_result) {
                            $area_question[$area['id']]['question'][$q_result['id']] = $q_result;
                        }
                    }
                    
                    $area['answer'] = unserialize($area['serialized_answer']);
                    foreach ($area['answer'] as $answer) {

                        if ($answer['status'] == 'pass') {
                            $result['all_pass']++;
                            $result['all_area_question']++;
                        } else if ($answer['status'] == 'not_pass') {
                            $result['all_not_pass']++;
                            $result['area_list'][$area['id']] = $area;
                            $result['all_area_question']++;
                        }
                    }
                }

                // echo "<pre>";
                // print_r($area_question);
                // echo "</pre>";

                // die();

                function cmp ($a, $b) {
                    if ($a['index'] == $b['index']) {
                        return 0;
                    }
                    return ($a['index'] < $b['index']) ? -1 : 1;
                }

                usort($area_question, "cmp");


                foreach ($area_question as $key => $value) {
                    $result['question_list'][$value['id']] = $value['question'];
                }

                // echo "<pre>";
                // print_r($result['area_list']);
                // echo "</pre>";
                // die();
            }

            $this->db->where('is_subject', 1);
            $this->db->where('subject_id', 0);
            $this->db->where('revision_id', $result['customer_revision_id']);
            $query = $this->db->get('tbm_quality_survey_customer_question');
            $customer_question_section_list = $query->result_array();
            $result['question_list']['for_customer'] = array();

            if (!empty($customer_question_section_list)) {
                //For each section
                foreach ($customer_question_section_list as $section) {

                    $this->db->where('is_subject', 0);
                    $this->db->where('subject_id', $section['id']);
                    $this->db->where('revision_id', $result['customer_revision_id']);
                    $query = $this->db->get('tbm_quality_survey_customer_question');
                    $customer_question_list = $query->result_array();

                    if (!empty($customer_question_list)) {
                        foreach ($customer_question_list as $customer_question) {
                            $section['sub_section'][$customer_question['sequence_index']] = $customer_question;
                        }
                    }
                    //$section['question_list'] = $customer_question_list;

                    $this->db->where('is_subject', 1);
                    $this->db->where('subject_id', $section['id']);
                    $this->db->where('revision_id', $result['customer_revision_id']);
                    $query = $this->db->get('tbm_quality_survey_customer_question');
                    $customer_question_sub_section_list = $query->result_array();

                    if (!empty($customer_question_sub_section_list)) {
                        //For each sub section
                        foreach ($customer_question_sub_section_list as $sub_section) {
                            $this->db->where('is_subject', 0);
                            $this->db->where('subject_id', $sub_section['id']);
                            $this->db->where('revision_id', $result['customer_revision_id']);
                            $query = $this->db->get('tbm_quality_survey_customer_question');
                            $customer_question_list = $query->result_array();
                            
                            $section['sub_section'][$sub_section['sequence_index']] = $sub_section;
                            $section['sub_section'][$sub_section['sequence_index']]['question_list'] = $customer_question_list;
                        }
                    } 

                    $result['question_list']['for_customer'][$section['id']] = $section;
                }

            } else {

                $this->db->where('is_subject', 0);
                $this->db->where('subject_id', 0);
                $this->db->where('revision_id', $result['customer_revision_id']);
                $query = $this->db->get('tbm_quality_survey_customer_question');
                $customer_question_list = $query->result_array();
                $result['question_list']['for_customer']['question_list'] = $customer_question_list;
            }

            // echo "<pre>";
            // print_r($result['question_list']['for_customer']);
            // echo "</pre>";

            // die();

            $this->db->where('is_subject', 1);
            $this->db->where('subject_id', 0);
            $this->db->where('revision_id', $result['KPI_revision_id']);
            $query = $this->db->get('tbm_quality_survey_kpi_question');
            $kpi_question_section_list = $query->result_array();
            $result['question_list']['kpi'] = array();

            if (!empty($kpi_question_section_list)) {
                //For each section
                foreach ($kpi_question_section_list as $section) {

                    $this->db->where('is_subject', 0);
                    $this->db->where('subject_id', $section['id']);
                    $this->db->where('revision_id', $result['KPI_revision_id']);
                    $query = $this->db->get('tbm_quality_survey_kpi_question');
                    $kpi_question_list = $query->result_array();

                    if (!empty($kpi_question_list)) {
                        foreach ($kpi_question_list as $kpi_question) {
                            $section['sub_section'][$kpi_question['sequence_index']] = $kpi_question;
                        }
                    }
                    //$section['question_list'] = $kpi_question_list;

                    $this->db->where('is_subject', 1);
                    $this->db->where('subject_id', $section['id']);
                    $this->db->where('revision_id', $result['KPI_revision_id']);
                    $query = $this->db->get('tbm_quality_survey_kpi_question');
                    $customer_question_sub_section_list = $query->result_array();

                    if (!empty($customer_question_sub_section_list)) {
                        //For each sub section
                        foreach ($customer_question_sub_section_list as $sub_section) {
                            $this->db->where('is_subject', 0);
                            $this->db->where('subject_id', $sub_section['id']);
                            $this->db->where('revision_id', $result['KPI_revision_id']);
                            $query = $this->db->get('tbm_quality_survey_kpi_question');
                            $kpi_question_list = $query->result_array();
                            
                            $section['sub_section'][$sub_section['sequence_index']] = $sub_section;
                            $section['sub_section'][$sub_section['sequence_index']]['question_list'] = $kpi_question_list;
                        }
                    } 

                    $result['question_list']['kpi'][$section['id']] = $section;
                }

            } else {

                $this->db->where('is_subject', 0);
                $this->db->where('subject_id', 0);
                $this->db->where('revision_id', $result['KPI_revision_id']);
                $query = $this->db->get('tbm_quality_survey_kpi_question');
                $kpi_question_list = $query->result_array();
                $result['question_list']['kpi']['question_list'] = $kpi_question_list;
            }

            $this->db->where('is_subject', 1);
            $this->db->where('subject_id', 0);
            $this->db->where('revision_id', $result['document_control_revision_id']);
            $query = $this->db->get('tbm_quality_survey_document_control_question');
            $document_control_question_section_list = $query->result_array();
            $result['question_list']['document_control'] = array();

            if (!empty($document_control_question_section_list)) {
                //For each section
                foreach ($document_control_question_section_list as $section) {

                    $this->db->where('is_subject', 0);
                    $this->db->where('subject_id', $section['id']);
                    $this->db->where('revision_id', $result['document_control_revision_id']);
                    $query = $this->db->get('tbm_quality_survey_document_control_question');
                    $doc_control_question_list = $query->result_array();

                    if (!empty($doc_control_question_list)) {
                        foreach ($doc_control_question_list as $doc_question) {
                            $section['sub_section'][$doc_question['sequence_index']] = $doc_question;
                        }
                    }
                    //$section['question_list'] = $doc_control_question_list;

                    $this->db->where('is_subject', 1);
                    $this->db->where('subject_id', $section['id']);
                    $this->db->where('revision_id', $result['document_control_revision_id']);
                    $query = $this->db->get('tbm_quality_survey_document_control_question');
                    $customer_question_sub_section_list = $query->result_array();

                    if (!empty($customer_question_sub_section_list)) {
                        //For each sub section
                        foreach ($customer_question_sub_section_list as $sub_section) {
                            $this->db->where('is_subject', 0);
                            $this->db->where('subject_id', $sub_section['id']);
                            $this->db->where('revision_id', $result['document_control_revision_id']);
                            $query = $this->db->get('tbm_quality_survey_document_control_question');
                            $doc_control_question_list = $query->result_array();
                            
                            $section['sub_section'][$sub_section['sequence_index']] = $sub_section;
                            $section['sub_section'][$sub_section['sequence_index']]['question_list'] = $doc_control_question_list;
                        }
                    } 

                    $result['question_list']['document_control'][$section['id']] = $section;
                }

            } else {

                $this->db->where('is_subject', 0);
                $this->db->where('subject_id', 0);
                $this->db->where('revision_id', $result['document_control_revision_id']);
                $query = $this->db->get('tbm_quality_survey_document_control_question');
                $doc_control_question_list = $query->result_array();
                $result['question_list']['document_control']['question_list'] = $doc_control_question_list;
            }

            $this->db->where('is_subject', 1);
            $this->db->where('subject_id', 0);
            $this->db->where('revision_id', $result['policy_revision_id']);
            $query = $this->db->get('tbm_quality_survey_policy_question');
            $policy_question_section_list = $query->result_array();
            $result['question_list']['policy'] = array();

            if (!empty($policy_question_section_list)) {
                //For each section
                foreach ($policy_question_section_list as $section) {

                    $this->db->where('is_subject', 0);
                    $this->db->where('subject_id', $section['id']);
                    $this->db->where('revision_id', $result['policy_revision_id']);
                    $query = $this->db->get('tbm_quality_survey_policy_question');
                    $policy_question_list = $query->result_array();

                    if (!empty($policy_question_list)) {
                        foreach ($policy_question_list as $policy_question) {
                            $section['sub_section'][$policy_question['sequence_index']] = $policy_question;
                        }
                    }
                    //$section['question_list'] = $policy_question_list;

                    $this->db->where('is_subject', 1);
                    $this->db->where('subject_id', $section['id']);
                    $this->db->where('revision_id', $result['policy_revision_id']);
                    $query = $this->db->get('tbm_quality_survey_policy_question');
                    $customer_question_sub_section_list = $query->result_array();

                    if (!empty($customer_question_sub_section_list)) {
                        //For each sub section
                        foreach ($customer_question_sub_section_list as $sub_section) {
                            $this->db->where('is_subject', 0);
                            $this->db->where('subject_id', $sub_section['id']);
                            $this->db->where('revision_id', $result['policy_revision_id']);
                            $query = $this->db->get('tbm_quality_survey_policy_question');
                            $policy_question_list = $query->result_array();
                            
                            $section['sub_section'][$sub_section['sequence_index']] = $sub_section;
                            $section['sub_section'][$sub_section['sequence_index']]['question_list'] = $policy_question_list;
                        }
                    } 

                    $result['question_list']['policy'][$section['id']] = $section;
                }

            } else {

                $this->db->where('is_subject', 0);
                $this->db->where('subject_id', 0);
                $this->db->where('revision_id', $result['policy_revision_id']);
                $query = $this->db->get('tbm_quality_survey_policy_question');
                $policy_question_list = $query->result_array();
                $result['question_list']['policy']['question_list'] = $policy_question_list;
            }   
        }

       // return self::response($state,$code,$msg,$output);
        return $result;
    }

    public function getDocument($track_doc_id, $struct=false, $sort=null){            

        $this->db->select('tbt_quality_survey.*,tbt_action_plan.plan_date,tbt_action_plan.id As plan_id');
        $this->db->where('tbt_quality_survey.id', $track_doc_id);
        $this->db->join('tbt_action_plan', 'tbt_action_plan.id = tbt_quality_survey.action_plan_id','left');                           

        $query  = $this->db->get('tbt_quality_survey');
        $result = $query->row_array();

        if (!empty($result)) {

            $this->db->select('tbt_quality_survey_area.*, tbt_quality_survey_area.industry_room_id, sap_tbm_industry_room.title as industry_room_description, tbt_quality_survey_area.building_id, tbt_quality_survey_area.floor_id, tbt_quality_survey_area.industry_room_id as area_type, tbt_floor.title as floor, tbt_building.title as building');
            $this->db->where('quality_survey_id', $result['id']); 
            if ($struct) {
                $this->db->where('is_select', 1);
            }  
            $this->db->join('tbt_quality_survey', 'tbt_quality_survey.id = tbt_quality_survey_area.quality_survey_id');
            $this->db->join('tbt_quotation', 'tbt_quotation.id = tbt_quality_survey.quotation_id');
            $this->db->join('sap_tbm_industry_room', 'sap_tbm_industry_room.id = tbt_quality_survey_area.industry_room_id and sap_tbm_industry_room.industry_id = tbt_quotation.ship_to_industry');
            $this->db->join('tbt_floor', 'tbt_quality_survey_area.floor_id = tbt_floor.id');
            $this->db->join('tbt_building', 'tbt_quality_survey_area.building_id = tbt_building.id');
            if ($struct) {
                $this->db->join('tbm_quality_survey_area_question', 'tbt_quality_survey_area.industry_room_id = tbm_quality_survey_area_question.industry_room_id');
            }
            if (!empty($sort)) {
                $this->db->order_by('tbt_quality_survey_area.order_index '.$sort);
            } else {
                $this->db->order_by('tbt_building.id, tbt_floor.id, tbt_quality_survey_area.order_index');
            }
            $query = $this->db->get('tbt_quality_survey_area');

            if (!$struct) {
                $result['area_list'] = $query->result_array();
            } else {
                $area_list = $query->result_array();

                if (!empty($area_list)) {

                    $area_question = array();

                    foreach ($area_list as $key => $area) {

                        $this->db->where('id', $area['prev_id']);
                        $query  = $this->db->get('tbt_quality_survey_area');
                        $prev_area = $query->row_array();

                        $area['prev_result'] = array();
                        if (!empty($prev_area)) {   
                            $area['prev_result'] = unserialize($prev_area['serialized_answer']);
                        }

                        $this->db->where(array('industry_room_id' => $area['industry_room_id'], 'revision_id' => $area['question_revision_id']));
                        $this->db->order_by('sequence_index');
                        $query = $this->db->get('tbm_quality_survey_area_question');

                        $area_question[$area['id']]['id']       = $area['id'];
                        $area_question[$area['id']]['index']    = $area['order_index'];
                        $area_question[$area['id']]['question'] = $query->result_array();

                        $result['area_list'][$area['building_id']]['title'] = $area['building'];
                        $result['area_list'][$area['building_id']]['floor_list'][$area['floor_id']]['title'] = $area['floor'];
                        $result['area_list'][$area['building_id']]['floor_list'][$area['floor_id']]['area_list'][$area['id']] = $area;                        

                        if (!array_key_exists('status', $result['area_list'][$area['building_id']])) {
                            $result['area_list'][$area['building_id']]['status'] = $area['status'];
                        } else {

                            if ($result['area_list'][$area['building_id']]['status'] == 'not_complete') {
                                $result['area_list'][$area['building_id']]['status']  = 'not_complete';
                            } else if ($area['status'] == 'complete') {  
                                $result['area_list'][$area['building_id']]['status']  = 'complete';
                            }
                        }

                        if (!array_key_exists('status', $result['area_list'][$area['building_id']]['floor_list'][$area['floor_id']])) {
                            $result['area_list'][$area['building_id']]['floor_list'][$area['floor_id']]['status'] = $area['status'];
                        } else {

                            if ($result['area_list'][$area['building_id']]['floor_list'][$area['floor_id']]['status'] == 'not_complete') {
                                $result['area_list'][$area['building_id']]['floor_list'][$area['floor_id']]['status']  = 'not_complete';
                            } else if ($area['status'] == 'complete') {  
                                $result['area_list'][$area['building_id']]['floor_list'][$area['floor_id']]['status']  = 'complete';
                            }
                        }
                    }

                    function cmp ($a, $b) {
                        if ($a['index'] == $b['index']) {
                            return 0;
                        }
                        return ($a['index'] < $b['index']) ? -1 : 1;
                    }

                    usort($area_question, "cmp");


                    foreach ($area_question as $key => $value) {
                        $result['question_list'][$value['id']] = $value['question'];
                    }
                }

                $this->db->where('is_subject', 1);
                $this->db->where('subject_id', 0);
                $this->db->where('revision_id', $result['customer_revision_id']);
                $query = $this->db->get('tbm_quality_survey_customer_question');
                $customer_question_section_list = $query->result_array();
                $result['question_list']['for_customer'] = array();

                if (!empty($customer_question_section_list)) {
                    //For each section
                    foreach ($customer_question_section_list as $section) {

                        $this->db->where('is_subject', 0);
                        $this->db->where('subject_id', $section['id']);
                        $this->db->where('revision_id', $result['customer_revision_id']);
                        $query = $this->db->get('tbm_quality_survey_customer_question');
                        $customer_question_list = $query->result_array();

                        if (!empty($customer_question_list)) {
                            foreach ($customer_question_list as $customer_question) {
                                $section['sub_section'][$customer_question['sequence_index']] = $customer_question;
                            }
                        }
                        //$section['question_list'] = $customer_question_list;

                        $this->db->where('is_subject', 1);
                        $this->db->where('subject_id', $section['id']);
                        $this->db->where('revision_id', $result['customer_revision_id']);
                        $query = $this->db->get('tbm_quality_survey_customer_question');
                        $customer_question_sub_section_list = $query->result_array();

                        if (!empty($customer_question_sub_section_list)) {
                            //For each sub section
                            foreach ($customer_question_sub_section_list as $sub_section) {
                                $this->db->where('is_subject', 0);
                                $this->db->where('subject_id', $sub_section['id']);
                                $this->db->where('revision_id', $result['customer_revision_id']);
                                $query = $this->db->get('tbm_quality_survey_customer_question');
                                $customer_question_list = $query->result_array();
                                
                                $section['sub_section'][$sub_section['sequence_index']] = $sub_section;
                                $section['sub_section'][$sub_section['sequence_index']]['question_list'] = $customer_question_list;
                            }
                        } 

                        $result['question_list']['for_customer'][$section['id']] = $section;
                    }

                } else {

                    $this->db->where('is_subject', 0);
                    $this->db->where('subject_id', 0);
                    $this->db->where('revision_id', $result['customer_revision_id']);
                    $query = $this->db->get('tbm_quality_survey_customer_question');
                    $customer_question_list = $query->result_array();
                    $result['question_list']['for_customer']['question_list'] = $customer_question_list;
                }

                $this->db->where('is_subject', 1);
                $this->db->where('subject_id', 0);
                $this->db->where('revision_id', $result['KPI_revision_id']);
                $query = $this->db->get('tbm_quality_survey_kpi_question');
                $kpi_question_section_list = $query->result_array();
                $result['question_list']['kpi'] = array();

                if (!empty($kpi_question_section_list)) {
                    //For each section
                    foreach ($kpi_question_section_list as $section) {

                        $this->db->where('is_subject', 0);
                        $this->db->where('subject_id', $section['id']);
                        $this->db->where('revision_id', $result['KPI_revision_id']);
                        $query = $this->db->get('tbm_quality_survey_kpi_question');
                        $kpi_question_list = $query->result_array();

                        if (!empty($kpi_question_list)) {
                            foreach ($kpi_question_list as $kpi_question) {
                                $section['sub_section'][$kpi_question['sequence_index']] = $kpi_question;
                            }
                        }
                        //$section['question_list'] = $kpi_question_list;

                        $this->db->where('is_subject', 1);
                        $this->db->where('subject_id', $section['id']);
                        $this->db->where('revision_id', $result['KPI_revision_id']);
                        $query = $this->db->get('tbm_quality_survey_kpi_question');
                        $customer_question_sub_section_list = $query->result_array();

                        if (!empty($customer_question_sub_section_list)) {
                            //For each sub section
                            foreach ($customer_question_sub_section_list as $sub_section) {
                                $this->db->where('is_subject', 0);
                                $this->db->where('subject_id', $sub_section['id']);
                                $this->db->where('revision_id', $result['KPI_revision_id']);
                                $query = $this->db->get('tbm_quality_survey_kpi_question');
                                $kpi_question_list = $query->result_array();
                                
                                $section['sub_section'][$sub_section['sequence_index']] = $sub_section;
                                $section['sub_section'][$sub_section['sequence_index']]['question_list'] = $kpi_question_list;
                            }
                        } 

                        $result['question_list']['kpi'][$section['id']] = $section;
                    }

                } else {

                    $this->db->where('is_subject', 0);
                    $this->db->where('subject_id', 0);
                    $this->db->where('revision_id', $result['KPI_revision_id']);
                    $query = $this->db->get('tbm_quality_survey_kpi_question');
                    $kpi_question_list = $query->result_array();
                    $result['question_list']['kpi']['question_list'] = $kpi_question_list;
                }

                $this->db->where('is_subject', 1);
                $this->db->where('subject_id', 0);
                $this->db->where('revision_id', $result['document_control_revision_id']);
                $query = $this->db->get('tbm_quality_survey_document_control_question');
                $document_control_question_section_list = $query->result_array();
                $result['question_list']['document_control'] = array();

                if (!empty($document_control_question_section_list)) {
                    //For each section
                    foreach ($document_control_question_section_list as $section) {

                        $this->db->where('is_subject', 0);
                        $this->db->where('subject_id', $section['id']);
                        $this->db->where('revision_id', $result['document_control_revision_id']);
                        $query = $this->db->get('tbm_quality_survey_document_control_question');
                        $doc_control_question_list = $query->result_array();

                        if (!empty($doc_control_question_list)) {
                            foreach ($doc_control_question_list as $doc_question) {
                                $section['sub_section'][$doc_question['sequence_index']] = $doc_question;
                            }
                        }
                        //$section['question_list'] = $doc_control_question_list;

                        $this->db->where('is_subject', 1);
                        $this->db->where('subject_id', $section['id']);
                        $this->db->where('revision_id', $result['document_control_revision_id']);
                        $query = $this->db->get('tbm_quality_survey_document_control_question');
                        $customer_question_sub_section_list = $query->result_array();

                        if (!empty($customer_question_sub_section_list)) {
                            //For each sub section
                            foreach ($customer_question_sub_section_list as $sub_section) {
                                $this->db->where('is_subject', 0);
                                $this->db->where('subject_id', $sub_section['id']);
                                $this->db->where('revision_id', $result['document_control_revision_id']);
                                $query = $this->db->get('tbm_quality_survey_document_control_question');
                                $doc_control_question_list = $query->result_array();
                                
                                $section['sub_section'][$sub_section['sequence_index']] = $sub_section;
                                $section['sub_section'][$sub_section['sequence_index']]['question_list'] = $doc_control_question_list;
                            }
                        } 

                        $result['question_list']['document_control'][$section['id']] = $section;
                    }

                } else {

                    $this->db->where('is_subject', 0);
                    $this->db->where('subject_id', 0);
                    $this->db->where('revision_id', $result['document_control_revision_id']);
                    $query = $this->db->get('tbm_quality_survey_document_control_question');
                    $doc_control_question_list = $query->result_array();
                    $result['question_list']['document_control']['question_list'] = $doc_control_question_list;
                }

                $this->db->where('is_subject', 1);
                $this->db->where('subject_id', 0);
                $this->db->where('revision_id', $result['policy_revision_id']);
                $query = $this->db->get('tbm_quality_survey_policy_question');
                $policy_question_section_list = $query->result_array();
                $result['question_list']['policy'] = array();

                if (!empty($policy_question_section_list)) {
                    //For each section
                    foreach ($policy_question_section_list as $section) {

                        $this->db->where('is_subject', 0);
                        $this->db->where('subject_id', $section['id']);
                        $this->db->where('revision_id', $result['policy_revision_id']);
                        $query = $this->db->get('tbm_quality_survey_policy_question');
                        $policy_question_list = $query->result_array();

                        if (!empty($policy_question_list)) {
                            foreach ($policy_question_list as $policy_question) {
                                $section['sub_section'][$policy_question['sequence_index']] = $policy_question;
                            }
                        }
                        //$section['question_list'] = $policy_question_list;

                        $this->db->where('is_subject', 1);
                        $this->db->where('subject_id', $section['id']);
                        $this->db->where('revision_id', $result['policy_revision_id']);
                        $query = $this->db->get('tbm_quality_survey_policy_question');
                        $customer_question_sub_section_list = $query->result_array();

                        if (!empty($customer_question_sub_section_list)) {
                            //For each sub section
                            foreach ($customer_question_sub_section_list as $sub_section) {
                                $this->db->where('is_subject', 0);
                                $this->db->where('subject_id', $sub_section['id']);
                                $this->db->where('revision_id', $result['policy_revision_id']);
                                $query = $this->db->get('tbm_quality_survey_policy_question');
                                $policy_question_list = $query->result_array();
                                
                                $section['sub_section'][$sub_section['sequence_index']] = $sub_section;
                                $section['sub_section'][$sub_section['sequence_index']]['question_list'] = $policy_question_list;
                            }
                        } 

                        $result['question_list']['policy'][$section['id']] = $section;
                    }

                } else {

                    $this->db->where('is_subject', 0);
                    $this->db->where('subject_id', 0);
                    $this->db->where('revision_id', $result['policy_revision_id']);
                    $query = $this->db->get('tbm_quality_survey_policy_question');
                    $policy_question_list = $query->result_array();
                    $result['question_list']['policy']['question_list'] = $policy_question_list;
                }

            }
        }

        return $result;
    }

    function getAllBuilding ($contract_id) {
        $this->db->where('tbt_building.contract_id', $contract_id);
        $query = $this->db->get('tbt_building');

        return $query->result_array();
    }

    function getAllFloor ($building_id) {
        $this->db->where('tbt_floor.building_id', $building_id);
        $query = $this->db->get('tbt_floor');

        return $query->result_array();
    }

    function getAllArea ($building_id, $floor_id) {
        $this->db->where('tbt_area.building_id', $building_id);
        $this->db->where('tbt_area.floor_id', $floor_id);
        $query = $this->db->get('tbt_area');

        return $query->result_array();
    }


    public function cloneArea ($doc_id, $contract_id) {

        $this->db->select('tbt_action_plan.plan_date, tbt_action_plan.create_date');
        $this->db->where('tbt_quality_survey.id', $doc_id);
        $this->db->join('tbt_action_plan', 'tbt_quality_survey.action_plan_id = tbt_action_plan.id');
        $query = $this->db->get('tbt_quality_survey');
        $doc = $query->row_array();

        if (!empty($doc)) {

            $this->db->select('tbt_quality_survey.*');
            $this->db->where(array('tbt_quality_survey.contract_id' => $contract_id, 'tbt_action_plan.plan_date' => $doc['plan_date'], 'tbt_quality_survey.id <' => $doc_id));
            $this->db->order_by('tbt_quality_survey.id desc');
            $this->db->limit(1);
            $this->db->join('tbt_action_plan', 'tbt_quality_survey.action_plan_id = tbt_action_plan.id');
            $query = $this->db->get('tbt_quality_survey');
            $prev_doc = $query->row_array();

            if (empty($prev_doc)) {

                $this->db->select('tbt_quality_survey.*, tbt_action_plan.plan_date');
                $this->db->where(array('tbt_quality_survey.contract_id' => $contract_id, 'tbt_action_plan.plan_date <' => $doc['plan_date']));
                $this->db->order_by('tbt_action_plan.plan_date desc');
                $this->db->limit(1);
                $this->db->join('tbt_action_plan', 'tbt_quality_survey.action_plan_id = tbt_action_plan.id');
                $query = $this->db->get('tbt_quality_survey');
                $prev_doc = $query->row_array();
            }
            
            // echo "Date: ".$doc['plan_date']."<br>";
            // echo "<pre>";
            // print_r($prev_doc);
            // echo "</pre>";

            // die();

            if (!empty($prev_doc)) {

                $this->db->where('id' , $doc_id);
                $this->db->update('tbt_quality_survey', array('min_pass_score' => $prev_doc['min_pass_score']));

                $this->db->select('tbt_quality_survey_area.*');
                $this->db->where('quality_survey_id', $prev_doc['id']);
                // $this->db->join('tbt_area', 'tbt_quality_survey_area.area_id = tbt_area.id');
                $query = $this->db->get('tbt_quality_survey_area');
                $result = $query->result_array();

                if (!empty($result)) {
                    foreach ($result as $key => $row) {

                        $revision_id = $this->getQuestionRevision('tbm_quality_survey_area_question', $row['industry_room_id']);

                        $data = array(
                            'building_id'       => $row['building_id'],
                            'floor_id'          => $row['floor_id'],
                            'industry_room_id'  => $row['industry_room_id'],
                            'area_name'         => $row['area_name'],
                            'order_index'       => $row['order_index'],
                            'is_select'         => $row['is_select'],
                            'quality_survey_id' => $doc_id,
                            'question_revision_id' => $revision_id,
                            'is_origin'            => 1,
                            'prev_id'              => $row['id']
                            );

                        $this->db->insert('tbt_quality_survey_area', $data);

                    }
                }


            } else {

                $this->db->select('tbt_area.*');
                $this->db->where('tbt_area.contract_id', $contract_id);
                $this->db->order_by('tbt_area.building_id, tbt_area.floor_id, tbt_area.id');
                $query = $this->db->get('tbt_area');
                $result = $query->result_array();
                
                // echo "$contract_id <br>";
                // echo "<pre>";
                // print_r($result);
                // echo "</pre>";

                // die();
                if (!empty($result)) {
                    $count = 1;
                    foreach ($result as $key => $row) {

                        $revision_id = $this->getQuestionRevision('tbm_quality_survey_area_question', $row['industry_room_id']);

                        $data = array(
                            'building_id'       => $row['building_id'],
                            'floor_id'          => $row['floor_id'],
                            'industry_room_id'  => $row['industry_room_id'],
                            'area_name'         => $row['title'],
                            'order_index'       => $count,
                            'is_select'         => 1,
                            'quality_survey_id' => $doc_id,
                            'question_revision_id' => $revision_id,
                            'is_origin'            => 1,
                            'prev_id'              => 0
                            );

                        $this->db->insert('tbt_quality_survey_area', $data);

                        $count++;
                    }
                }
            }

            $this->db->where('id', $doc_id);
            $this->db->update('tbt_quality_survey', array('is_manager_edit' => 1));
        }
    }

    function getQuestionRevision ($table, $area_id='') {

        $this->db->select('revision_id');
        if ($area_id != '') {
            $this->db->where('industry_room_id', $area_id);
        }
        $this->db->order_by('revision_id desc');
        $this->db->limit(1);
        $query = $this->db->get($table);
        $question = $query->row_array();

        $revision_id = 1;
        if (!empty($question)) {
            $revision_id = $question['revision_id'];
        }

        return $revision_id;
    }

    function isUsedArea ($revision_id, $industry_room_id) {

        // $this->db->join('tbt_area','tbt_quality_survey_area.area_id = tbt_area.id');
        $this->db->where('tbt_quality_survey_area.industry_room_id', $industry_room_id);
        $this->db->where('tbt_quality_survey_area.question_revision_id', $revision_id);
        $query = $this->db->get('tbt_quality_survey_area');
        $row   = $query->row_array();

        $this->db->where('tbm_quality_survey_area_question.industry_room_id', $industry_room_id);
        $query = $this->db->get('tbm_quality_survey_area_question');
        $q_row   = $query->row_array();

        if (!empty($row) && !empty($q_row)) {
            return 1;
        } 

        return 0;
    }

    public function delete($actionplan_id){
        //echo "model test delete";

        $this->db->where('action_plan_id',$actionplan_id);
        $this->db->update('tbt_user_marked', array('action_plan_id' => 0));

        $this->db->where('id',$actionplan_id);
        $query = $this->db->get('tbt_action_plan');
        $plan = $query->row_array();
        
        if (!empty($plan)) {

            $table = $plan['object_table'];
            $doc_id = $plan['object_id'];

            $this->db->where('quality_survey_id',$doc_id);
            $this->db->delete('tbt_quality_survey_area');

            $this->db->where('id',$doc_id);
            $this->db->delete($table);
        }

        $this->db->where('id',$actionplan_id);
        $this->db->delete('tbt_action_plan');

    }

    
}//end model

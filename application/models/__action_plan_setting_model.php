<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class __action_plan_setting_model extends REST_Model{

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

    public function unassign($parameters){

        $this->db->trans_begin();
        try {
            $where  = "keyuser_emp_id = '".$parameters['keyuser_emp_id']."'";
            $where  .= " AND contract_id = '".$parameters['contract_id']."'";
            $where  .= " AND ship_to_id = '".$parameters['ship_to_id']."'";
            $where  .= " AND function = '".$parameters['function']."'";

            $this->db->where("(tbt_user_marked.assign_id in (SELECT id FROM tbt_keyuser_marked_assign WHERE ".$where."))");
            $this->db->delete('tbt_user_marked');
            $this->db->delete('tbt_keyuser_marked_assign', $parameters);
        } catch (Exception $e) {
            $this->db->trans_rollback();
            return false;   
        }

        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
        }
        else{
            $this->db->trans_commit();
        }
        
        return array('status' => true);

    }
    public function listviewContent($page=1,$order=array()){
        $emp_id = $this->session->userdata('id');
        $position_list = $this->session->userdata('position');
        $function_list = $this->session->userdata('function');

        $children = array();
        foreach ($position_list as $key => $position) {
            $children = $this->getPositionChild($children, $position);
        }

        $permission = $this->permission[$this->cat_id];

        $table = 'tbt_quotation';

        //Set up keyword Search 
        $match = $this->input->post('search');

        $allowedToSearchItem = array('tbt_quotation.id','tbt_quotation.title','sap_tbm_ship_to.ship_to_name1','sap_tbm_sold_to.sold_to_name1','tbt_user.user_firstname','tbm_job_type.title');
        $condition_count = 0;

        if(!empty($match)){
          foreach ($allowedToSearchItem as $key => $value) {                
            if($condition_count++ < 1){
                $this->db->like($value,$match);
            }else{
                $this->db->or_like($value,$match);
            }
        }
        }//end if


        $year = $this->input->post('year');        
        if(!empty($year)){
          $this->db->where('YEAR(tbt_quotation.project_start)',$year);
        }//end if


        // if(!empty($order)){
        // }

        $emp_id = $this->session->userdata('id');      
        
        $track_result = array();
        $untrack_result = array();


        $this->db->select('UC.employee_id as assign_user_id, UC.user_firstname as assign_firstname, UC.user_lastname as assign_lastname, tbt_quotation.contract_id, tbt_quotation.sold_to_id, tbt_quotation.ship_to_id, tbt_quotation.project_start, tbt_quotation.project_end ,tbm_job_type.title AS job_type_title , sap_tbm_ship_to.ship_to_name1 AS shop_to_title , sap_tbm_sold_to.sold_to_name1 AS customer_name ,tbt_user.user_firstname AS project_owner');

        // Changed by Sunday 2015-09-09 to fix multi function 
        $this->db->select('tbm_department.function, tbm_position.id as position_id');

        // $this->db->from('tbt_quotation');

        // Tunning By Sunday 
        $this->db->from("(SELECT tbt_quotation.contract_id, tbt_quotation.sold_to_id, tbt_quotation.ship_to_id, tbt_quotation.project_start, tbt_quotation.project_end, tbt_quotation.job_type, tbt_quotation.project_owner_id FROM tbt_quotation WHERE tbt_quotation.project_end >= '".date('Y-m-d')."' AND tbt_quotation.contract_id != '' AND tbt_quotation. STATUS = 'EFFECTIVE') as tbt_quotation");

        $this->db->join('tbm_job_type', 'tbm_job_type.id = tbt_quotation.job_type', 'left');
        $this->db->join('sap_tbm_sold_to', 'sap_tbm_sold_to.id = tbt_quotation.sold_to_id', 'left');
        $this->db->join('sap_tbm_ship_to', 'sap_tbm_ship_to.id = tbt_quotation.ship_to_id', 'left');
        $this->db->join('tbt_user', 'tbt_user.employee_id = tbt_quotation.project_owner_id', 'left');
        $this->db->join('tbt_user_customer', 'tbt_user_customer.ship_to_id = sap_tbm_ship_to.id', 'left'); 
        $this->db->join('tbt_user UC', 'tbt_user_customer.user_id = UC.user_id', 'left');
        $this->db->join('tbt_keyuser_marked', 'tbt_keyuser_marked.contract_id = tbt_quotation.contract_id'); 

        // Changed by Sunday 2015-09-09 to fix multi function 
        $this->db->join('tbt_user_position', 'UC.employee_id = tbt_user_position.employee_id'); 
        $this->db->join('tbm_position', 'tbt_user_position.position_id = tbm_position.id'); 
        $this->db->join('tbm_department', 'tbm_position.department_id = tbm_department.id');
        $this->db->where_in('tbm_department.function', $function_list);

        $this->db->where('tbt_keyuser_marked.keyuser_emp_id', $emp_id);

        //test 1210000112
        //$this->db->where('tbt_quotation.contract_id', '1210000112');

        //$this->db->where('tbt_quotation.project_start <=', date('Y-m-d'));
        /*Tunning By Sunday*/
        // $this->db->where('tbt_quotation.project_end >=', date('Y-m-d'));
        // $this->db->where('tbt_quotation.contract_id !=', '');
        // $this->db->where('tbt_quotation.status', 'EFFECTIVE');

        if ($permission['create']['shipto'] == 'related') {
            if (!empty($children)) {
                $children = array_merge($position_list, $children);

                // $this->db->join('tbt_user_position', 'UC.employee_id = tbt_user_position.employee_id'); 
                // $this->db->join('tbm_position', 'tbt_user_position.position_id = tbm_position.id'); 
                // $this->db->join('tbm_department', 'tbm_position.department_id = tbm_department.id');
                // $this->db->where('tbm_department.function', 'OP'); 
                $this->db->where_in('tbm_position.id', $children);
            } else {
                $this->db->where('UC.employee_id', $emp_id);
            }
        }

        // Changed by Sunday 2015-09-09 to fix multi function 
        $this->db->group_by('tbt_quotation.contract_id, tbm_department.function');

        $this->db->having('count(tbt_quotation.ship_to_id) = 1');

        $result = $this->db->get();
        $track_result = $result->result_array();
        // die($this->db->last_query());
        $track_id_arr = array();
        if (!empty($track_result)) {
            foreach ($track_result as $key => $track) {
                array_push($track_id_arr, $track['ship_to_id']);
            }
        }

        $this->db->select('UC.employee_id as assign_user_id, UC.user_firstname as assign_firstname, UC.user_lastname as assign_lastname, tbt_quotation.contract_id, tbt_quotation.sold_to_id, tbt_quotation.ship_to_id, tbt_quotation.project_start, tbt_quotation.project_end ,tbm_job_type.title AS job_type_title , sap_tbm_ship_to.ship_to_name1 AS shop_to_title , sap_tbm_sold_to.sold_to_name1 AS customer_name ,tbt_user.user_firstname AS project_owner');

        // Changed by Sunday 2015-09-09 to fix multi function 
        $this->db->select('tbm_department.function, tbm_position.id as position_id');

        $this->db->from("(SELECT tbt_quotation.contract_id, tbt_quotation.sold_to_id, tbt_quotation.ship_to_id, tbt_quotation.project_start, tbt_quotation.project_end, tbt_quotation.job_type, tbt_quotation.project_owner_id FROM tbt_quotation WHERE tbt_quotation.project_end >= '".date('Y-m-d')."' AND tbt_quotation.contract_id != '' AND tbt_quotation. STATUS = 'EFFECTIVE') as tbt_quotation");
        $this->db->join('tbm_job_type', 'tbm_job_type.id = tbt_quotation.job_type', 'left');
        $this->db->join('sap_tbm_sold_to', 'sap_tbm_sold_to.id = tbt_quotation.sold_to_id', 'left');
        $this->db->join('sap_tbm_ship_to', 'sap_tbm_ship_to.id = tbt_quotation.ship_to_id', 'left');
        $this->db->join('tbt_user', 'tbt_user.employee_id = tbt_quotation.project_owner_id', 'left');
        $this->db->join('tbt_user_customer', 'tbt_user_customer.ship_to_id = sap_tbm_ship_to.id', 'left'); 
        $this->db->join('tbt_user UC', 'tbt_user_customer.user_id = UC.user_id', 'left');

        // Changed by Sunday 2015-09-09 to fix multi function 
        $this->db->join('tbt_user_position', 'UC.employee_id = tbt_user_position.employee_id'); 
        $this->db->join('tbm_position', 'tbt_user_position.position_id = tbm_position.id'); 
        $this->db->join('tbm_department', 'tbm_position.department_id = tbm_department.id');
        $this->db->where_in('tbm_department.function', $function_list);

        //test 1210000112
        // $this->db->where('tbt_quotation.contract_id', '1210000825');

        //$this->db->where('tbt_quotation.project_start <=', date('Y-m-d'));
        /* Turnning By Sunday */
        // $this->db->where('tbt_quotation.project_end >=', date('Y-m-d'));
        // $this->db->where('tbt_quotation.contract_id !=', '');
        // $this->db->where('tbt_quotation.status', 'EFFECTIVE');
        if ($permission['create']['shipto'] == 'related') {
            if (!empty($children)) {
                $children = array_merge($position_list, $children);
                
                // $this->db->join('tbt_user_position', 'UC.employee_id = tbt_user_position.employee_id'); 
                // $this->db->join('tbm_position', 'tbt_user_position.position_id = tbm_position.id');
                // $this->db->join('tbm_department', 'tbm_position.department_id = tbm_department.id');
                // $this->db->where('tbm_department.function', 'OP'); 

                $this->db->where_in('tbm_position.id', $children);
            } else {
                $this->db->where('UC.employee_id', $emp_id);
            }
        } 

        if (!empty($track_id_arr)) {
            $this->db->where_not_in('tbt_quotation.ship_to_id', $track_id_arr);
        }

        // Changed by Sunday 2015-09-09 to fix multi function 
        $this->db->group_by('tbt_quotation.contract_id, tbm_department.function');
        

        $this->db->having('count(tbt_quotation.ship_to_id) = 1');


        $this->db->order_by('tbt_quotation.contract_id DESC');

        $result = $this->db->get();
        $untrack_result = $result->result_array();
        $output = array();
        $state = true;
        $code = '000';
        $msg = '';
        $output['total_item'] = self::getResultTotalpage($table);
        $output['track_result'] = $track_result;
        $output['untrack_result'] = $untrack_result;
        $output['page'] = $page;
        $output['page_size'] = $this->pageSize;             
        $output['total_page'] = ceil(self::getResultTotalpage($table)/$this->pageSize);
        
        $output['on_year'] = !empty($year)?$year:'';            

        return self::response($state,$code,$msg,$output);
    }

    function getAllDepartment() {

        $query = $this->db->get('cms_user_department');
        return $query->result_array();
    }

    function getKeyUserModule () {

        $permission = $this->permission;

        $output = array();              
        $this->db->select('cms_module.id, cms_module.module_name');  
        $this->db->where('is_active', 1);
        $this->db->where('is_action_plan', 1);
        $this->db->where('is_menu', 1);
        $query = $this->db->get('cms_module');
        $result = $query->result_array();

        foreach ($result as $row) {
            if (array_key_exists($row['id'], $permission) && array_key_exists('create', $permission[$row['id']])) {
                $output[$row['id']] = $row;
            }
        }
        // if (!empty($function)) {           
        //     $this->db->select('tbm_event_category.id, tbm_event_category.module as module_name');
        //     $this->db->where_in('function', $function);
        //     $query = $this->db->get('tbm_event_category');
        //     $result = $query->result_array();

        //     foreach ($result as $row) {
        //         $output[$row['id']] = $row;
        //     }
        // }

        return $output;
    }
    
    function getModuleList () {

        $output = array();

        $emp_id = $this->session->userdata('id');
        $position_list = $this->session->userdata('position');

        $children = array();
        foreach ($position_list as $key => $position) {
            $children = $this->getPositionChild($children, $position);
        }

        $permission = $this->permission[$this->cat_id];

        $this->db->select('tbm_position.area_id, tbt_keyuser_marked_assign.id as assign_id, tbt_keyuser_marked_assign.module_id as id, tbt_keyuser_marked_assign.module_id as module, cms_module.module_name, cms_module.url, tbt_keyuser_marked_assign.contract_id as contract_id,  tbt_keyuser_marked_assign.id as assign_id, tbt_keyuser_marked_assign.ship_to_id, tbt_keyuser_marked_assign.contract_id, tbt_keyuser_marked_assign.assign_to, , tbt_keyuser_marked_assign.month_period, tbt_user.employee_id, tbt_user.user_firstname, tbt_user.user_lastname');
        $this->db->select('tbt_keyuser_marked_assign.function');
        //Changed by Sunday 2015-09-09 to fix multiple function

        $this->db->join('cms_module', 'tbt_keyuser_marked_assign.module_id = cms_module.id', 'left');
        $this->db->join('tbt_user', 'tbt_keyuser_marked_assign.assign_to = tbt_user.employee_id', 'left');        
        $this->db->join('tbt_user_position', 'tbt_user.employee_id = tbt_user_position.employee_id', 'left');      
        $this->db->join('tbm_position', 'tbt_user_position.position_id = tbm_position.id', 'left');   
        $this->db->where('tbt_keyuser_marked_assign.keyuser_emp_id', $emp_id);

        if ($permission['create']['shipto'] == 'related') {
            if (!empty($children)) {
                $children = array_merge($position_list, $children);
                $this->db->where_in('tbm_position.id', $children);
            } else {
                $this->db->where('tbt_user.employee_id', $emp_id);
            }
        }   

        $query = $this->db->get('tbt_keyuser_marked_assign');
        $result = $query->result_array();  
        // die($this->db->last_query());

        foreach ($result as $key => $value) {
            $contract_id = $value['contract_id'];
            $value['contract_id'] = str_replace('.', '-', $value['contract_id']);

            if (!array_key_exists($value['contract_id'], $output)) {
                $output[$value['contract_id']] = array();
            }

            $where = array(
                'status !=' => 'shift', 
                'tbt_user_marked.contract_id' => $contract_id, 
                'tbt_user_marked.module_id' => $value['id'], 
                'tbt_user_marked.action_plan_id !=' => '0', 
                'tbt_user_marked.assign_id' => $value['assign_id'],
                'tbt_action_plan.plan_date >=' => date('Y-m-d')
                );

            $this->db->select('tbt_user_marked.ship_to_id, tbt_user_marked.module_id, tbt_user_marked.sequence, plan_date, tbt_action_plan.actual_date, tbt_action_plan.status,tbt_action_plan.title, tbt_action_plan.object_id, tbt_action_plan.object_table, tbt_action_plan.quotation_id');
            $this->db->join('tbt_action_plan', 'tbt_user_marked.action_plan_id = tbt_action_plan.id', 'left');
            $this->db->where($where);
            $this->db->order_by('tbt_action_plan.plan_date');
            $this->db->limit(2);
            $query = $this->db->get('tbt_user_marked');
            
            $plan = $query->result_array();

            $this_month_flag = 'not plan';
            $next_month_flag = 'not plan';
            $value['this_month_url'] = "";
            $value['next_month_url'] = "";

            $count = 0;

            foreach ($plan as $key => $plan_value) {
                if (!empty($plan_value['plan_date'])) {

                    $plan_month = date('m Y', strtotime($plan_value['plan_date']));

                    if ($count == 0 && strtotime($plan_value['plan_date']) >= strtotime(date('Y-m-d').' 00:00:00')) {

                        $this_month_flag = $plan_value['status'];
                        $value['this_month_title'] = date("j F Y" ,strtotime($plan_value['plan_date']));

                        if (!empty($plan_value['object_table'])) {

                            if ($plan_value['object_table'] == 'tbt_asset_track_document') {

                                $value['this_month_url'] = site_url( '__ps_asset_track/detail/view/'.$plan_value['quotation_id'].'/'.$plan_value['object_id'] );

                            } else if ($plan_value['object_table'] == 'tbt_employee_track_document') {

                                $value['this_month_url'] = site_url( '__ps_employee_track/detail/view/'.$plan_value['quotation_id'].'/'.$plan_value['object_id'] );

                            } else if ($plan_value['object_table'] == 'tbt_quality_survey') {

                                $value['this_month_url'] = site_url( '__ps_quality_assurance/detail/view/'.$plan_value['quotation_id'].'/'.$plan_value['object_id'] );

                            } else if ($plan_value['object_table'] == 'tbt_visitation_document') {

                                $this->db->where('id', $plan_value['object_id']);
                                $visit_doc = $this->db->get('tbt_visitation_document')->row_array();

                                if ($visit_doc['submit_date_sap'] == '0000-00-00' || empty($visit_doc['submit_date_sap'])) {

                                    $value['this_month_url'] = site_url( '__ps_visitation/detail_quotation/edit_quotation/'.$plan_value['object_id'] );
                                }else{

                                    $value['this_month_url'] = site_url( '__ps_visitation/view_quotation/edit_quotation/'.$plan_value['object_id'] );
                                }

                            }

                            if( date('m Y', strtotime($plan_value['plan_date'])) != date('m Y') ){ 
                                $value['this_month_url'] = "";
                            }
                            
                            $this->db->where('id', $plan_value['object_id']);
                            $this->db->from($plan_value['object_table']);
                            $query = $this->db->get();
                            $doc = $query->row_array();

                            if (!empty($doc)) {
                                if (strpos($doc['submit_date_sap'], '0000-00-00') < 0) {
                                    $this_month_flag = "complete";
                                }
                            }

                        } else if ($plan_value['actual_date'] != '0000-00-00' && !empty($plan_value['actual_date'])) {
                            $this_month_flag = "complete";
                        }
                    }

                    if ($count == 1 && strtotime($plan_value['plan_date']) >= strtotime(date('Y-m-d').' 00:00:00')) {

                        $next_month_flag = $plan_value['status'];
                        $value['next_month_title'] = date("j F Y" ,strtotime($plan_value['plan_date']));

                        if (!empty($plan_value['object_table'])) {

                            if ($plan_value['object_table'] == 'tbt_asset_track_document') {

                                $value['next_month_url'] = site_url( '__ps_asset_track/detail/view/'.$plan_value['quotation_id'].'/'.$plan_value['object_id'] );

                            } else if ($plan_value['object_table'] == 'tbt_employee_track_document') {

                                $value['next_month_url'] = site_url( '__ps_employee_track/detail/view/'.$plan_value['quotation_id'].'/'.$plan_value['object_id'] );

                            } else if ($plan_value['object_table'] == 'tbt_quality_survey') {

                                $value['next_month_url'] = site_url( '__ps_quality_assurance/detail/view/'.$plan_value['quotation_id'].'/'.$plan_value['object_id'] );

                            } else if ($plan_value['object_table'] == 'tbt_visitation_document') {

                                $this->db->where('id', $plan_value['object_id']);
                                $visit_doc = $this->db->get('tbt_visitation_document')->row_array();

                                if ($visit_doc['submit_date_sap'] == '0000-00-00' || empty($visit_doc['submit_date_sap'])) {

                                    $value['next_month_url'] = site_url( '__ps_visitation/detail_quotation/edit_quotation/'.$plan_value['object_id'] );
                                }else{

                                    $value['next_month_url'] = site_url( '__ps_visitation/view_quotation/edit_quotation/'.$plan_value['object_id'] );
                                }
                                
                            }

                            if( date('m Y', strtotime($plan_value['plan_date'])) != date('m Y') ){ 
                                $value['next_month_url'] = "";
                            }

                            $this->db->where('id', $plan_value['object_id']);
                            $this->db->from($plan_value['object_table']);
                            $query = $this->db->get();
                            $doc = $query->row_array();

                            if (!empty($doc)) {
                                if (strpos($doc['submit_date_sap'], '0000-00-00') < 0) {
                                    $next_month_flag = "complete";
                                }
                            }

                        } else if ($plan_value['actual_date'] != '0000-00-00' && !empty($plan_value['actual_date'])) {
                            $next_month_flag = "complete";
                        }
                    }

                    $count++;
                }
            }

            $value['this_month_flag'] = $this_month_flag;
            $value['next_month_flag'] = $next_month_flag;

            $output[$value['contract_id']][$value['id']][$value['assign_id']] = $value;

        }
        
        return $output;
    }

    function getMemberModuleSlot () {

        $emp_id = $this->session->userdata('id');
        $this->db->where('employee_id', $emp_id);
        $user = $this->db->get('tbt_user')->row_array();
        if(empty($user)) return ;
        $user_id = $user['user_id'];

        $this->db->select('tbt_action_plan.plan_date, tbt_action_plan.submit_date_sap, tbt_action_plan.actual_date, tbt_user_marked.*, tbt_quotation.* ,tbm_job_type.title AS job_type_title , sap_tbm_ship_to.ship_to_name1 AS shop_to_title , sap_tbm_sold_to.sold_to_name1 AS customer_name ,tbt_user.user_firstname AS project_owner, cms_module.module_name as module_name');
        $this->db->from("(SELECT * FROM `tbt_user_marked` WHERE ship_to_id IN ( SELECT ship_to_id FROM tbt_user_customer WHERE user_id = '$user_id' )) as tbt_user_marked");
        $this->db->join('tbt_quotation', 'tbt_user_marked.contract_id = tbt_quotation.contract_id');
        $this->db->join('cms_module', 'tbt_user_marked.module_id = cms_module.id');
        $this->db->join('tbt_user', 'tbt_user_marked.emp_id = tbt_user.employee_id');
        $this->db->join('sap_tbm_sold_to', 'sap_tbm_sold_to.id = tbt_quotation.sold_to_id');
        $this->db->join('sap_tbm_ship_to', 'sap_tbm_ship_to.id = tbt_quotation.ship_to_id');
        $this->db->join('tbt_action_plan', 'tbt_user_marked.action_plan_id = tbt_action_plan.id', 'left');
        $this->db->join('tbm_job_type', 'tbm_job_type.id = tbt_quotation.job_type', 'left');
        $this->db->where('cms_module.is_action_plan', 1);

        // user who responsible ship_to.
        // $this->db->where("(EXISTS (SELECT 'X' FROM tbt_user_marked WHERE tbt_user_marked.ship_to_id = tbt_user_marked.ship_to_id AND tbt_user_marked.emp_id = '".$emp_id."'))");

        $query = $this->db->get();


        $result = $query->result_array();
        $output = array();
        foreach ($result as $key => $value) {

            $output[$value['contract_id']]['project'] = array(
                'contract_id'       => $value['contract_id'],
                'ship_to_id'        => $value['ship_to_id'],
                'job_type_title'    => $value['job_type_title'],
                'shop_to_title'     => $value['shop_to_title'],
                'customer_name'     => $value['customer_name'],
                'project_start'     => $value['project_start'],
                'project_end'       => $value['project_end']
                );

            if (!empty($value['clear_job_type_id']) && !empty($value['frequency'])) {

                $this->db->select('sap_tbm_clear_type.description as title, tbt_area.frequency as frequency');
                $this->db->where('tbt_area.clear_job_type_id', $value['clear_job_type_id']);
                $this->db->where('tbt_area.frequency', $value['frequency']);
                $this->db->join('sap_tbm_clear_type', 'tbt_area.clear_job_type_id = sap_tbm_clear_type.id');
                $query = $this->db->get('tbt_area');
                $area_obj = $query->row_array();

                if (!empty($area_obj)) {
                    $output[$value['contract_id']]['module_list'][$value['module_id']][$value['clear_job_type_id']][$value['frequency']]['module_info'] = array(
                        'id'             => $value['clear_job_type_id'],
                        'module_name'    => $area_obj['title'].' ['.$area_obj['frequency'].' เดือน]'
                        );

                    if (!array_key_exists('assign_list', $output[$value['contract_id']]['module_list'][$value['module_id']][$value['clear_job_type_id']][$value['frequency']])) {
                        $output[$value['contract_id']]['module_list'][$value['module_id']][$value['clear_job_type_id']][$value['frequency']]['assign_list'] = array();
                    }

                    $output[$value['contract_id']]['module_list'][$value['module_id']][$value['clear_job_type_id']][$value['frequency']]['assign_list'][$value['sequence']] = $value;

                    // ksort($output[$value['contract_id']]['module_list'][$value['module_id']][$value['clear_job_type_id']][$value['frequency']]['assign_list']);
                }
            } else {
                $output[$value['contract_id']]['module_list'][$value['module_id']]['module_info'] = array(
                    'id'             => $value['module_id'],
                    'module_name'    => $value['module_name']
                    );

                if (!array_key_exists('assign_list', $output[$value['contract_id']]['module_list'][$value['module_id']])) {
                    $output[$value['contract_id']]['module_list'][$value['module_id']]['assign_list'] = array();
                }

                $output[$value['contract_id']]['module_list'][$value['module_id']]['assign_list'][$value['sequence']] = $value;

                // ksort($output[$value['contract_id']]['module_list'][$value['module_id']]['assign_list']);
            }
        }

        // echo "<pre>";
        // print_r($output);
        // echo "</pre>";
        // die();
        return $output;
    }
    
    function update_track ($p) {

        $emp_id = $this->session->userdata('id');
        $this->db->delete('tbt_keyuser_marked', array('keyuser_emp_id' => $emp_id));

        if (!empty($p['track_check'])) {
            foreach ($p['track_check'] as $key => $contract_id) {

                $this->db->select('ship_to_id');
                $this->db->where('contract_id', $contract_id);
                $query = $this->db->get('tbt_quotation');

                $project = $query->row_array();
                if (!empty($project)) {

                    $this->db->where(array('keyuser_emp_id' => $emp_id, 'contract_id' => $contract_id));
                    $query = $this->db->get('tbt_keyuser_marked');
                    $exist = $query->row_array();

                    if (empty($exist)) {
                        $data = array(
                            'keyuser_emp_id' => $emp_id,
                            'contract_id'    => $contract_id,  
                            'ship_to_id'     => $project['ship_to_id']
                            );
                        $this->db->insert('tbt_keyuser_marked', $data);
                    }
                }
            }
        }
    }

    function update_untrack ($p) {
        if (!empty($p['untrack_check'])) {

            $emp_id = $this->session->userdata('id');
            foreach ($p['untrack_check'] as $key => $contract_id) {

                $this->db->select('ship_to_id');
                $this->db->where('contract_id', $contract_id);
                $query = $this->db->get('tbt_quotation');

                $project = $query->row_array();
                if (!empty($project)) {

                    $this->db->where(array('keyuser_emp_id' => $emp_id, 'contract_id' => $contract_id));
                    $query = $this->db->get('tbt_keyuser_marked');
                    $exist = $query->row_array();

                    if (empty($exist)) {
                        $data = array(
                            'keyuser_emp_id' => $emp_id,
                            'contract_id'    => $contract_id,  
                            'ship_to_id'     => $project['ship_to_id']
                            );

                        // echo "<pre>";
                        // print_r($data);
                        // echo "</pre>";
                        $this->db->insert('tbt_keyuser_marked', $data);
                    }
                }
            }
        }
    }

    function getProjectPeriod ($contract_id) {

        $this->db->select('FLOOR( DATEDIFF( project_end, project_start ) /30 ) as total ');
        $this->db->where('contract_id', $contract_id);

        $query = $this->db->get('tbt_quotation');
        $result = $query->row_array();

        if (!empty($result)) {
            return $result['total'];
        }

        return 0;
    }

    public function preventDuplication(){
        $sql = "SELECT main.id, main.keyuser_emp_id, main.contract_id, main.ship_to_id, main.module_id, main.assign_to, main.function, main.month_period 
        FROM `tbt_keyuser_marked_assign` main
        INNER JOIN (
        SELECT *, COUNT(*) AS x  
        FROM `tbt_keyuser_marked_assign` 
        WHERE module_id <>12 
        group by keyuser_emp_id, contract_id, ship_to_id, module_id, assign_to, function having x > 1  ) TEMP 
        ON main.keyuser_emp_id = TEMP.keyuser_emp_id AND
        main.contract_id = TEMP.contract_id AND
        main.ship_to_id = TEMP.ship_to_id AND
        main.module_id = TEMP.module_id AND 
        main.assign_to = TEMP.assign_to AND 
        main.function = TEMP.function
        ORDER BY main.keyuser_emp_id, main.contract_id, main.ship_to_id, main.module_id, main.month_period  DESC";

        $result = $this->db->query($sql);
        $result = $result->result_array();
        $export = array();
        $xkey = '';
        foreach ($result as $dk => $dpx) {
            $temp_key = $dpx['keyuser_emp_id'].'-'.$dpx['contract_id'].'-'.$dpx['ship_to_id'].'-'.$dpx['module_id'].'-'.$dpx['assign_to'].'-'.$dpx['function'];
            if( $temp_key == $xkey ){//add to delete  //echo '<br> EQ -> DEL : '.$xkey.' => '.$temp_key.' :: '.$dpx['id'];           
            array_push($export,$dpx['id']);
            }else{ //define new temp_key //echo '<br> NQ : '.$xkey.' => '.$temp_key.' :: '.$dpx['id'];         
            $xkey = $temp_key;
        }           
        }//end foreach

        if(!empty($export)){
            //Delete 
            $this->db->where_in('id',$export);
            $this->db->delete('tbt_keyuser_marked_assign');
        }
        
        // echo '<hr>';
        // echo $this->db->last_query();

        $this->db->query("
            DELETE b.* FROM tbt_user_marked b
            INNER JOIN tbt_keyuser_marked_assign a ON a.contract_id = b.contract_id
            AND a.module_id = b.module_id
            WHERE 1=1
            AND a.month_period = 0 ");
    }

}

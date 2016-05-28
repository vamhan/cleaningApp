<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class __action_plan_model extends MY_Model{

    function __construct(){
        parent::__construct();
    }

    public function isAllowToCreate ($contract_id, $module_id) {

        $emp_id = $this->session->userdata('id');

        $where = array(
            'emp_id' => $emp_id,
            'module_id' => $module_id,
            'contract_id' => $contract_id,
            'action_plan_id' => 0
            );

        $this->db->where($where);
        $query = $this->db->get('tbt_user_marked');
        $result = $query->row_array();

        if (!empty($result)) {
            return 1;
        } 

        
        return 0;
    }


    public function allProspect ($where=null, $distribution_channel ='') {

        $emp_id = $this->session->userdata('id');
        $position_list = $this->session->userdata('position');

        $children = array();
        foreach ($position_list as $key => $position) {
            $children = $this->getPositionChild($children, $position);
        }

        $this->permission = array();

        foreach ($position_list as $key => $pos_id) {
            $position = $this->__ps_project_query->getObj('tbm_position', array('id' => $pos_id));

            if (!empty($position['permission'])) {
                $permission = unserialize($position['permission']); 

                foreach ($permission as $module_id => $action_list) {

                    if (!array_key_exists($module_id, $this->permission)) {
                        $this->permission[$module_id] = array();
                    }
                    
                    foreach ($action_list as $action_obj => $value) {
                        if (!array_key_exists($action_obj, $this->permission[$module_id])) {
                            $this->permission[$module_id][$action_obj] = $value;
                        }
                    }
                }

            }
        }           

        $permission = $this->permission[4];// Customer Visition


        $this->db->distinct();
        $this->db->select('tbt_prospect.*');
        $this->db->from('tbt_prospect');
        $this->db->join('tbt_user u', 'u.employee_id = tbt_prospect.project_owner_id');

        if (!empty($where)) {
            $this->db->like('tbt_prospect.title', $where); 
        }

        if(!empty($distribution_channel) && $distribution_channel != '-1'){
            $this->db->where("distribution_channel", $distribution_channel);
        }

        if ($permission['shipto']['value'] == 'related') {
            if (!empty($children)) {
                $children = array_merge($position_list, $children);
                $this->db->join('tbt_user_position', 'u.employee_id = tbt_user_position.employee_id'); 
                $this->db->join('tbm_position', 'tbt_user_position.position_id = tbm_position.id'); 
                $this->db->where_in('tbm_position.id', $children);
            } else {
                $this->db->where('project_owner_id', $emp_id); 
            }
        }        

        $query = $this->db->get();

        return $query->result_array();
    }

    public function allEmployee () {

        $emp_id = $this->session->userdata('id');
        $position_list = $this->session->userdata('position');

        $children = array();
        foreach ($position_list as $key => $position) {
            $children = $this->getPositionChild($children, $position);
        }

        $user_list = array();

        $this->db->where('tbt_user.employee_id', $emp_id);
        $query = $this->db->get('tbt_user');
        $self = $query->row_array();
        $user_list[0] = $self;
        $user_list[0]['department'] = '';

        $this->db->select('tbm_department.id');
        $this->db->where('tbt_user_position.employee_id', $self['employee_id']);
        $this->db->join('tbm_position', 'tbm_department.id = tbm_position.department_id', 'left');
        $this->db->join('tbt_user_position', 'tbt_user_position.position_id = tbm_position.id', 'left');
        $query = $this->db->get('tbm_department');
        $department = $query->result_array();
        if (!empty($department)) {
            foreach ($department as $dept) {
                if (empty($user_list[0]['department'])) {
                    $user_list[0]['department'] = $dept['id'];
                } else {
                    $user_list[0]['department'] .= ','.$dept['id'];
                }
            }
        }

        foreach ($children as $key => $value) {

            $this->db->select('tbt_user.*');
            $this->db->where('tbt_user_position.position_id', $value);
            $this->db->join('tbt_user_position', 'tbt_user.employee_id = tbt_user_position.employee_id');
            $query = $this->db->get('tbt_user');
            $employee_list = $query->result_array();

            if (!empty($employee_list)) {
                foreach ($employee_list as $employee) {

                    if (!array_key_exists($employee['user_id'], $user_list)) {
                        $user_list[$employee['user_id']] = $employee;
                        $user_list[$employee['user_id']]['department'] = '';

                        $this->db->select('tbm_department.id');
                        $this->db->where('tbt_user_position.employee_id', $employee['employee_id']);
                        $this->db->join('tbm_position', 'tbm_department.id = tbm_position.department_id');
                        $this->db->join('tbt_user_position', 'tbt_user_position.position_id = tbm_position.id');
                        $query = $this->db->get('tbm_department');
                        $department = $query->result_array();
                        if (!empty($department)) {
                            foreach ($department as $dept) {
                                if (empty($user_list[$employee['user_id']]['department'])) {
                                    $user_list[$employee['user_id']]['department'] = $dept['id'];
                                } else {
                                    $user_list[$employee['user_id']]['department'] .= ','.$dept['id'];
                                }
                            }
                        }
                    }

                }
            }

        }

        return $user_list;

    }

    public function allShipTo($where=null, $module_id=null) {

        $emp_id = $this->session->userdata('id');
        $position_list = $this->session->userdata('position');

        $children = array();
        foreach ($position_list as $key => $position) {
            $children = $this->getPositionChild($children, $position);
        }

        $permission = $this->permission[$this->cat_id];        

        if (empty($children)) {

            $output = array();
            $exist = array();
            $function = $this->session->userdata('function');

            if (!empty($function)) {           
                $this->db->select('tbm_event_category.id, tbm_event_category.module as module_name');
                $this->db->where_in('function', $function);
                $query = $this->db->get('tbm_event_category');
                $result = $query->result_array();

                if (!empty($result)) {

                    $this->db->select('tbt_quotation.contract_id, tbt_quotation.ship_to_id, tbt_quotation.project_end');
                    $this->db->join('tbt_user_customer', 'tbt_quotation.ship_to_id = tbt_user_customer.ship_to_id', 'left'); 
                    $this->db->join('tbt_user UC', 'tbt_user_customer.user_id = UC.user_id', 'left');
                    $this->db->where('tbt_quotation.status', 'EFFECTIVE');
                    $this->db->where('tbt_quotation.contract_id !=', '');
                    $this->db->where('is_go_live', 1);
                    $this->db->where('tbt_quotation.project_end >=', date('Y-m-d'));

                    // Fix check only ship that related.
                    if ($permission['create']['shipto'] == 'related') {
                        $this->db->where('UC.employee_id', $emp_id);
                    }       

                    $query = $this->db->get('tbt_quotation');
                    $quotation_list = $query->result_array();
                    

                    if (!empty($quotation_list)) {
                        foreach ($quotation_list as $key => $quotation) {

                            $this->db->where('id', $quotation['ship_to_id']);
                            $query = $this->db->get('sap_tbm_ship_to');
                            $shipto = $query->row_array();

                            if (!empty($shipto)) {
                                if (!empty($where)) {

                                    if (strpos($shipto['ship_to_name1'], $where) > -1 || strpos($shipto['id'], $where) > -1) {
                                        $quotation['id'] = $quotation['ship_to_id'];
                                        $quotation['name1'] = $shipto['ship_to_name1'];

                                        array_push($output, $quotation);
                                        array_push($exist, $quotation['id']);
                                    } 
                                } else {

                                    $quotation['id'] = $quotation['ship_to_id'];
                                    $quotation['name1'] = $shipto['ship_to_name1'];

                                    array_push($output, $quotation);
                                    array_push($exist, $quotation['id']);
                                }
                            }

                        }
                    }  
                }
            }

            $this->db->distinct('tbt_quotation.contract_id, tbt_quotation.ship_to_id, tbt_quotation.project_end, tbt_user_marked.emp_id, tbt_user_marked.module_id');
            $this->db->select('tbt_quotation.contract_id, tbt_quotation.ship_to_id, tbt_quotation.project_end, tbt_user_marked.emp_id, tbt_user_marked.module_id');

            if (!empty($module_id)) {
                if ($module_id == 'general') {
                    $this->db->join('tbt_user_marked', 'tbt_user_marked.contract_id = tbt_quotation.contract_id and tbt_user_marked.emp_id = "'.$emp_id.'" and tbt_user_marked.module_id != 4');
                } else {
                    $this->db->join('tbt_user_marked', 'tbt_user_marked.contract_id = tbt_quotation.contract_id and tbt_user_marked.emp_id = "'.$emp_id.'" and tbt_user_marked.module_id = '.$module_id);                    
                }
            } else {
                $this->db->join('tbt_user_marked', 'tbt_user_marked.contract_id = tbt_quotation.contract_id and tbt_user_marked.emp_id = "'.$emp_id.'"');
            }

            $this->db->where('tbt_quotation.contract_id !=', '');
            $this->db->where('tbt_quotation.status', 'EFFECTIVE');
            //$this->db->where('tbt_quotation.project_start <=', date('Y-m-d'));
            $this->db->where('tbt_quotation.project_end >=', date('Y-m-d'));
            $this->db->group_by('tbt_user_marked.contract_id');
            $query = $this->db->get('tbt_quotation');

            $quotation_list = $query->result_array();

            if (!empty($quotation_list)) {
                foreach ($quotation_list as $key => $quotation) {

                    // Fix BySunday Find Ship to doesn't exists.
                    if (!in_array($quotation['ship_to_id'], $exist)) {                        
                        $this->db->where('id', $quotation['ship_to_id']);
                        $query = $this->db->get('sap_tbm_ship_to');
                        $shipto = $query->row_array();

                        if (!empty($shipto)) {
                            if (!empty($where)) {

                                // echo $where.' : '.$shipto['id'].' | '.$shipto['ship_to_name1'].' : '.(strpos($shipto['ship_to_name1'], $where)).' | '.strpos($shipto['id'], $where).'<br>';

                                if (strpos($shipto['ship_to_name1'], $where) > -1 || strpos($shipto['id'], $where) > -1) {
                                    $quotation['id'] = $quotation['ship_to_id'];
                                    $quotation['name1'] = $shipto['ship_to_name1'];

                                    array_push($output, $quotation);
                                } 
                            } else {

                                $quotation['id'] = $quotation['ship_to_id'];
                                $quotation['name1'] = $shipto['ship_to_name1'];

                                array_push($output, $quotation);
                            }
                        }
                    }
                }
            }    
            return $output;

        } else {

            $output = array();
            $quotation_list = array();

            $this->db->distinct('tbt_quotation.contract_id, tbt_quotation.ship_to_id, tbt_quotation.project_end');
            $this->db->select('tbt_quotation.contract_id, tbt_quotation.ship_to_id, tbt_quotation.project_end');
            $this->db->join('sap_tbm_sold_to', 'sap_tbm_sold_to.id = tbt_quotation.sold_to_id');
            $this->db->join('sap_tbm_ship_to', 'tbt_quotation.ship_to_id = sap_tbm_ship_to.id');
            $this->db->join('tbt_user_customer', 'tbt_user_customer.ship_to_id = sap_tbm_ship_to.id', 'left'); 
            $this->db->join('tbt_user UC', 'tbt_user_customer.user_id = UC.user_id', 'left');
            $this->db->where('tbt_quotation.contract_id !=', '');
            $this->db->where('tbt_quotation.status', 'EFFECTIVE');
            //$this->db->where('tbt_quotation.project_start <=', date('Y-m-d'));
            $this->db->where('tbt_quotation.project_end >=', date('Y-m-d'));
            $this->db->where('replaced_by IS NULL', null, false);

            if ($permission['create']['shipto'] == 'related') {
                if (!empty($children)) {
                    $children = array_merge($position_list, $children);

                    $this->db->join('tbt_user_position', 'UC.employee_id = tbt_user_position.employee_id'); 
                    $this->db->join('tbm_position', 'tbt_user_position.position_id = tbm_position.id'); 
                    $this->db->where_in('tbm_position.id', $children);
                } else {
                    $this->db->where('UC.employee_id', $emp_id);
                }
            }       

            // $this->db->where_in('sap_tbm_ship_to.ship_to_operation_area_id', $operation_area);
            $query = $this->db->get('tbt_quotation');
            $quotation_list = $query->result_array();


            if (!empty($quotation_list)) {
                foreach ($quotation_list as $key => $quotation) {

                    $this->db->where('id', $quotation['ship_to_id']);
                    $query = $this->db->get('sap_tbm_ship_to');
                    $shipto = $query->row_array();

                    if (!empty($shipto)) {
                        if (!empty($where)) {

                            if (strpos($shipto['ship_to_name1'], $where) > -1 || strpos($shipto['id'], $where) > -1) {
                                $quotation['id'] = $quotation['ship_to_id'];
                                $quotation['name1'] = $shipto['ship_to_name1'];

                                array_push($output, $quotation);
                            } 
                        } else {
                            $quotation['id'] = $quotation['ship_to_id'];
                            $quotation['name1'] = $shipto['ship_to_name1'];

                            array_push($output, $quotation);
                        }
                    }

                }
            }
            return $output;
        }
    }

    public function allVisitShipTo($where=null, $distribution_channel = '') {

        $emp_id = $this->session->userdata('id');
        $position_list = $this->session->userdata('position');

        $children = array();
        foreach ($position_list as $key => $position) {
            $children = $this->getPositionChild($children, $position);
        }

        $this->permission = array();

        foreach ($position_list as $key => $pos_id) {
            $position = $this->__ps_project_query->getObj('tbm_position', array('id' => $pos_id));

            if (!empty($position['permission'])) {
                $permission = unserialize($position['permission']); 

                foreach ($permission as $module_id => $action_list) {

                    if (!array_key_exists($module_id, $this->permission)) {
                        $this->permission[$module_id] = array();
                    }
                    
                    foreach ($action_list as $action_obj => $value) {
                        if (!array_key_exists($action_obj, $this->permission[$module_id])) {
                            $this->permission[$module_id][$action_obj] = $value;
                        }
                    }
                }

            }
        }           

        $permission = $this->permission[4];// Customer Visition

        $output = array();
        $quotation_list = array();

        $this->db->distinct('tbt_quotation.contract_id, tbt_quotation.ship_to_id, tbt_quotation.project_end');
        $this->db->select('tbt_quotation.contract_id,tbt_quotation.id as qt_id, tbt_quotation.ship_to_id, tbt_quotation.project_end');
        $this->db->select('sap_tbm_ship_to.id as id, sap_tbm_ship_to.ship_to_name as name1');
        $this->db->join('sap_tbm_sold_to', 'sap_tbm_sold_to.id = tbt_quotation.sold_to_id');
        $this->db->join('sap_tbm_ship_to', 'tbt_quotation.ship_to_id = sap_tbm_ship_to.id');
        $this->db->join('tbt_user_customer', 'tbt_user_customer.ship_to_id = sap_tbm_ship_to.id', 'left'); 
        $this->db->join('tbt_user UC', 'tbt_user_customer.user_id = UC.user_id', 'left');

        if ($permission['shipto']['value'] == 'related') {
            if (!empty($children)) {
                $children = array_merge($position_list, $children);
                $this->db->join('tbt_user_position', 'UC.employee_id = tbt_user_position.employee_id'); 
                $this->db->join('tbm_position', 'tbt_user_position.position_id = tbm_position.id'); 
                $this->db->where_in('tbm_position.id', $children);
            } else {
                $this->db->where('UC.employee_id', $emp_id);
            }
        }        
        //$this->db->where("(tbt_quotation.distribution_channel in ( select p.area_id from tbm_department d LEFT JOIN tbm_position p on d.id = p.department_id where d.id =  '".$distribution_channel."'))");
        if(!empty($distribution_channel) && $distribution_channel != '-1'){
            $this->db->where("distribution_channel", $distribution_channel);
        }
        
        $this->db->where('tbt_quotation.status', 'EFFECTIVE');
        $this->db->where('contract_id !=', '');     
        //$this->db->where('tbt_quotation.project_start <=', date('Y-m-d'));
        $this->db->where('tbt_quotation.project_end >=', date('Y-m-d'));
        //chec replace by QT id
        //$this->db->where('replaced_by IS NULL', null, false);
        $this->db->where("(sap_tbm_ship_to.id LIKE '%".$where."%' OR sap_tbm_ship_to.ship_to_name1 LIKE '%".$where."%' )");
        $query = $this->db->get('tbt_quotation');
        $quotation_list = $query->result_array();
        //die($this->db->last_query());

        // if (!empty($quotation_list)) {
        //     foreach ($quotation_list as $key => $quotation) {

        //         $this->db->where('id', $quotation['ship_to_id']);
        //         $query = $this->db->get('sap_tbm_ship_to');
        //         $shipto = $query->row_array();

        //         if (!empty($shipto)) {
        //             if (!empty($where)) {

        //                 if (strpos($shipto['ship_to_name1'], $where) > -1 || strpos($shipto['id'], $where) > -1) {
        //                     $quotation['id'] = $quotation['ship_to_id'];
        //                     $quotation['name1'] = $shipto['ship_to_name1'];

        //                     array_push($output, $quotation);
        //                 } 
        //             } else {
        //                 $quotation['id'] = $quotation['ship_to_id'];
        //                 $quotation['name1'] = $shipto['ship_to_name1'];

        //                 array_push($output, $quotation);
        //             }
        //         }

        //     }
        // }

        return $quotation_list;  
    }

    public function allDepartment () {

        $position_list = $this->session->userdata('position');

        $children = array();
        foreach ($position_list as $key => $position) {
            $children = $this->getPositionChild($children, $position);
        }

        $children = array_merge($children, $position_list);

        $department_list = array();

        if (!empty($children)) {

            $this->db->distinct('tbm_department.*');
            $this->db->select('tbm_department.*');
            $this->db->where_in('tbm_position.id', $children);
            $this->db->join('tbm_department', 'tbm_position.department_id = tbm_department.id');
            $query = $this->db->get('tbm_position');
            $department_list = $query->result_array();
        }

        return $department_list;

    }

    public function allEventCategory($where=null) {

        $emp_id = $this->session->userdata('id');
        $position_list = $this->session->userdata('position');

        $children = array();
        foreach ($position_list as $key => $position) {
            $children = $this->getPositionChild($children, $position);
        }

        if (empty($children)) {

            if (!empty($where)) {
                $this->db->where($where);
                $this->db->where('tbt_user_marked.action_plan_id', 0);
            }

            $this->db->select('cms_module.id, cms_module.module_name, tbt_user_marked.clear_job_type_id, tbt_user_marked.frequency, sap_tbm_clear_type.description as clearjob_type_title');
            $this->db->join('tbt_user_marked', 'tbt_user_marked.module_id = cms_module.id', 'left');
            // $this->db->join('tbt_area', 'tbt_area.clear_job_type_id = tbt_user_marked.clear_job_type_id', 'left');
            $this->db->join('sap_tbm_clear_type', 'sap_tbm_clear_type.id = tbt_user_marked.clear_job_type_id', 'left');
            $this->db->where('is_active', 1);
            $this->db->where('is_action_plan', 1);
            $this->db->where('emp_id', $emp_id);
            $this->db->group_by('cms_module.id, tbt_user_marked.clear_job_type_id, tbt_user_marked.frequency');
            $query = $this->db->get('cms_module');

            $result = $query->result_array();      

            $this->db->select('tbm_event_category.id, tbm_event_category.module as module_name, tbt_user_marked.clear_job_type_id, tbt_user_marked.frequency, sap_tbm_clear_type.description as clearjob_type_title');
            $this->db->join('tbt_user_marked', 'tbt_user_marked.module_id = tbm_event_category.id');
            // $this->db->join('tbt_area', 'tbt_area.clear_job_type_id = tbt_user_marked.clear_job_type_id and tbt_area.frequency = tbt_area.frequency', 'left');
            $this->db->join('sap_tbm_clear_type', 'sap_tbm_clear_type.id = tbt_user_marked.clear_job_type_id', 'left');
            $this->db->where('emp_id', $emp_id);
            $this->db->group_by('tbm_event_category.id, tbt_user_marked.clear_job_type_id, tbt_user_marked.frequency');
            $query = $this->db->get('tbm_event_category');

            $event_result = $query->result_array();  

            if (!empty($result)) {
                $result = array_merge($result, $event_result);
            } else {
                $result = $event_result;
            }

            $output = array();
            foreach ($result as $key => $row) {
                if (!empty($row['area_id'])) {

                    if (!array_key_exists($row['id'], $output)) {
                        $output[$row['id']] = array(
                            'id'          => $row['id'],
                            'module_name' => $row['module_name'],
                            'clearjob_list' => array()
                            );
                    }

                    array_push($output[$row['id']]['clearjob_list'],  array('clear_job_type_id' => $row['clear_job_type_id'], 'frequency' => $row['frequency'], 'title' => $row['clearjob_type_title']));
                    
                } else {
                    $output[$row['id']] = $row;
                }
            }
            return $output;
            
        } else {                

            $user_department_id = $this->session->userdata('department');

            $module_list = array();
            if (!empty($user_department_id)) {
                foreach ($user_department_id as $key => $dept_id) {
                    $this->db->where('department_id', $dept_id);
                    $query = $this->db->get('tbm_department_module');
                    $modules = $query->result_array();

                    if (!empty($modules)) {
                        foreach ($modules as $key => $value) {
                            if (!in_array($value['module_id'], $module_list)) {
                                array_push($module_list, $value['module_id']);
                            }
                        }

                        $this->db->where(array('module_id' => 6, 'department_id' => $dept_id));
                        $query = $this->db->get('tbm_department_module');
                        $keyuser_module = $query->row_array();
                        if (!empty($keyuser_module) && !empty($where) && !in_array(12, $module_list)) {
                            array_push($module_list, 12);
                        }
                    }
                }
            }

            if (!empty($module_list)) {

                $function = $this->session->userdata('function');

                $this->db->select('cms_module.*');
                $this->db->where('is_active', 1);
                $this->db->where('is_action_plan', 1);
                $this->db->where_in('id', $module_list);
                $this->db->group_by('cms_module.id');
                $query = $this->db->get('cms_module');

                $result = $query->result_array();

                if (!empty($function)) {

                    $this->db->select('tbm_event_category.id, tbm_event_category.module as module_name');
                    $this->db->where_in('function', $function);
                    $this->db->group_by('tbm_event_category.id');
                    $query = $this->db->get('tbm_event_category');

                    $event_result = $query->result_array();  
                    if (!empty($result)) {
                        $result = array_merge($result, $event_result);
                    } else {
                        $result = $event_result;
                    }

                }
                return $result;
            }

            return array();
        }
    }

    public function allActionPlan ($where=array(), $list=true) {

        $emp_id = $this->session->userdata('id');
        $position_list = $this->session->userdata('position');
        $function = $this->session->userdata('function');
        $children = array();
        foreach ($position_list as $key => $position) {
            $children = $this->getPositionChild($children, $position);
        }

        $permission = $this->permission[$this->cat_id];

        if ($list) {

            $result = array();

            if (in_array('CR', $function) || in_array('RO', $function)) {

                $this->db->select('tbt_action_plan.*');
                $this->db->join('tbt_prospect', 'tbt_action_plan.prospect_id = tbt_prospect.id', 'left');
                $this->db->join('tbt_user', 'tbt_action_plan.actor_id = tbt_user.employee_id', 'left');
                $this->db->join('tbt_user_position', 'tbt_user.employee_id = tbt_user_position.employee_id', 'left');
                $this->db->join('tbm_position', 'tbt_user_position.position_id = tbm_position.id', 'left');
                $this->db->join('tbm_department', 'tbm_position.department_id = tbm_department.id', 'left');
                $this->db->where('tbt_action_plan.status !=', 'shift');

                $query = $this->db->get('tbt_action_plan');
                $result = $query->result_array();
            }

            if (!in_array('HR', $function)) {

                $this->db->select('tbt_action_plan.*');
                $this->db->join('tbt_quotation', 'tbt_action_plan.quotation_id = tbt_quotation.id', 'left');
                $this->db->join('tbt_user', 'tbt_action_plan.actor_id = tbt_user.employee_id', 'left');
                $this->db->join('tbt_user_position', 'tbt_user.employee_id = tbt_user_position.employee_id', 'left');
                $this->db->join('tbm_position', 'tbt_user_position.position_id = tbm_position.id', 'left');
                $this->db->join('tbm_department', 'tbm_position.department_id = tbm_department.id', 'left');
                $this->db->where('tbt_action_plan.status !=', 'shift');
                $this->db->where('tbt_action_plan.actual_date IS NOT NULL', null, false);   
                $this->db->where('tbt_action_plan.object_table',"tbt_employee_track_document");
                $this->db->where('tbm_department.function', "HR");
                
                $query = $this->db->get('tbt_action_plan');
                $hr_employee_result = $query->result_array();   
                $result = array_merge($result, $hr_employee_result);
            }

            $this->db->distinct('tbt_action_plan.*'); //add fix         
            $this->db->select('tbt_action_plan.*');//$this->db->select('tbt_action_plan.*, tbm_department.function');
            //$this->db->select('tbm_department.function');
            $this->db->join('tbt_quotation', 'tbt_action_plan.quotation_id = tbt_quotation.id', 'left');
            $this->db->join('tbt_user', 'tbt_action_plan.actor_id = tbt_user.employee_id', 'left');
            $this->db->join('tbt_user_position', 'tbt_user.employee_id = tbt_user_position.employee_id', 'left');
            $this->db->join('tbm_position', 'tbt_user_position.position_id = tbm_position.id', 'left');
            $this->db->join('tbm_department', 'tbm_position.department_id = tbm_department.id', 'left');
            $this->db->where('tbm_department.function !=', '');

            //fixed dupiclate create action plan visit by p'Art
            //$this->db->group_by('tbt_action_plan.id');

            if (!in_array('RO', $function)) {

                if (!in_array('HR', $function)) {
                    $this->db->where('tbm_department.function !=', "HR");            
                // $this->db->where('tbt_action_plan.object_table !=',"tbt_employee_track_document");
                }

                if (!in_array('CR', $function)) {
                    $this->db->where('tbm_department.function !=', "CR");            
                }

                $this->db->where('tbt_action_plan.status !=', 'shift');
                if (!in_array('MK', $function)) {
                    $this->db->where('tbm_department.function !=', "MK");
                } else {                
                    $this->db->or_where('tbt_action_plan.object_table IS NULL',null, false);
                }
            }

            $query = $this->db->get('tbt_action_plan');
            $quotation_result = $query->result_array();
            // die($this->db->last_query());
            

            /////////////////////// fix function ////////////////////////////////
            $function_list = $this->session->userdata('function');
            $temp_function = '';
            foreach ($function_list as $key => $value) {
                $temp_function .= $value.',';
            }
            //   echo $temp_function.'<br>';

            foreach ($quotation_result as $key => &$dep) {
                $dep['function'] =  substr($temp_function, 0, -1);     
            }
            //echo '<pre>';print_r($quotation_result); exit();
            /////////////////////// fix function ////////////////////////////////
            $result = array_merge($result, $quotation_result);



            foreach ($result as $key => $row) {

                $result[$key]['blue_label'] = 0;

                if (!empty($row) && !empty($row['actor_id'])) {
                    $actor_id = $row['actor_id'];
                    $this->db->select('tbt_user.employee_id, tbt_user.user_id, tbt_user.user_firstname, tbt_user.user_lastname');     
                    $this->db->select('tbm_department.id as dept_id, tbm_department.title As department_name');
                    $this->db->from("(SELECT * FROM tbt_user WHERE tbt_user.employee_id = '$actor_id') as tbt_user");
                    $this->db->join('tbt_user_position', 'tbt_user_position.employee_id = tbt_user.employee_id');
                    $this->db->join('tbm_position', 'tbt_user_position.position_id = tbm_position.id');
                    $this->db->join('tbm_department', 'tbm_position.department_id = tbm_department.id');
                    $query_user=$this->db->get();
                    $data_user = $query_user->row_array(); 

                    $result[$key]['department_name'] = "";
                    $result[$key]['department_id']   = "";
                    $result[$key]['actor_name']      = "";

                    if(!empty($data_user)){
                        $result[$key]['department_name'] =$data_user['department_name'];
                        $result[$key]['department_id'] =$data_user['dept_id'];
                        $result[$key]['actor_name'] = $data_user['user_firstname']." ". $data_user['user_lastname'];
                    }
                }

                if ($row['object_table'] == 'tbt_visitation_document') {
                    $this->db->where('id',$row['object_id']);
                    $query = $this->db->get('tbt_visitation_document');
                    $doc = $query->row_array();
                    if (
                        !empty($doc) && 
                        (
                            $doc['is_manager_comment'] == 1 || 
                            !empty($doc['notice_to_cr']) || 
                            !empty($doc['notice_to_oper']) || 
                            !empty($doc['notice_to_hr']) || 
                            !empty($doc['notice_to_training']) || 
                            !empty($doc['notice_to_store']) || 
                            !empty($doc['notice_to_sale']) ||
                            !empty($doc['comment'])
                            )
                        ) 
                    {
                        $result[$key]['blue_label'] = 1;
                    }
                }
            }


            return $result;

        } else {

            if (!empty($where)) {
                $this->db->where($where);
            }

            $this->db->select('tbt_action_plan.*');
            $this->db->where('tbt_action_plan.status !=', 'shift');
            $query = $this->db->get('tbt_action_plan');

            $row = $query->row_array();

            if (!empty($row) && !empty($row['actor_id'])) {

                $row['project_end'] = '';

                if (!empty($row['quotation_id'])) {
                    $this->db->where('id', $row['quotation_id']);
                    $query = $this->db->get('tbt_quotation');
                    $quot = $query->row_array();

                    if (!empty($quot)) {
                        $row['project_end'] = $quot['project_end'];
                    }
                }

                $this->db->select('tbt_user.*, tbm_department.title As department_name, tbm_department.function');     
                $this->db->join('tbt_user_position', 'tbt_user_position.employee_id = tbt_user.employee_id');
                $this->db->join('tbm_position', 'tbt_user_position.position_id = tbm_position.id');
                $this->db->join('tbm_department', 'tbm_position.department_id = tbm_department.id');
                $this->db->where('tbt_user.employee_id',$row['actor_id']);
                $query_user=$this->db->get('tbt_user');
                $data_user = $query_user->row_array(); 

                if(!empty($query_user)){
                  $row['actor_name'] = $data_user['user_firstname']." ". $data_user['user_lastname'];
                  $row['department_name'] =$data_user['department_name'];
                  $row['function'] =$data_user['function'];
              }else{ $row['actor_name'] ='-'; }


              $this->db->select('module_name');
              $this->db->where('id', $row['event_category_id']);
              $query = $this->db->get('cms_module');
              $module = $query->row_array();
              if (!empty($module)) {
                $row['module_name'] = freetext($module['module_name']);
            } else {
                $this->db->select('module');
                $this->db->where('id', $row['event_category_id']);
                $query = $this->db->get('tbm_event_category');
                $module = $query->row_array();
                if (!empty($module)) {
                    $row['module_name'] = $module['module'];
                }
            }

            $this->db->select('ship_to_name1');
            $this->db->where('id', $row['ship_to_id']);
            $query = $this->db->get('sap_tbm_ship_to');
            $shipto = $query->row_array();
            if (!empty($shipto)) {
                $row['ship_to_name'] = $shipto['ship_to_name1'];
            }

            $this->db->select('sold_to_name1');
            $this->db->where('id', $row['sold_to_id']);
            $query = $this->db->get('sap_tbm_sold_to');
            $soldto = $query->row_array();
            if (!empty($soldto)) {
                $row['sold_to_name'] = $soldto['sold_to_name1'];
            }

            $this->db->select('sequence');
            $this->db->where('action_plan_id', $row['id']);
            $query = $this->db->get('tbt_user_marked');
            $user_marked = $query->row_array();
            if (!empty($user_marked)) {
                $row['sequence'] = $user_marked['sequence'];
            }

            if ($row['pre_id'] != 0) {
                $this->db->select('plan_date');
                $this->db->where('id', $row['pre_id']);
                $query = $this->db->get('tbt_action_plan');
                $pre_plan = $query->row_array();
                if (!empty($pre_plan)) {
                    $row['pre_plan_date'] = common_easyDateFormat($pre_plan['plan_date']);
                }
            }
        }

        return $row;
    }
}

public function allVisitReason () {

    $function = $this->session->userdata('function');

    if (!empty($function)) {
        $this->db->where_in('function', $function);
        $query = $this->db->get('tbm_visitation_reason');
        $result = $query->result_array();
        
        return $result;
    }

    return array();

}
public function allVisitConnect () {

    $this->db->where('is_active', 1);
    $query = $this->db->get('tbm_connect_type');
    return $query->result_array();

}

public function allClearCategory () {
    $query = $this->db->get('tbm_clear_job_category');
    return $query->result_array();
}

public function allClearType () {
    $query = $this->db->get('sap_tbm_clear_type');
    return $query->result_array();
}

public function insert ($data) {
 $this->db->insert('tbt_action_plan', $data);
}

public function update ($data) {
    $this->db->where('id', $data['id']);
    $this->db->update('tbt_action_plan', $data);
}
}//end model

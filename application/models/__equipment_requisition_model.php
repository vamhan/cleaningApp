<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class __equipment_requisition_model extends MY_Model{

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

 public function getContentList($page=1,$keyword=''){

    $emp_id = $this->session->userdata('id');
    $position_list = $this->session->userdata('position');

    $children = array();
    foreach ($position_list as $key => $position) {
        $children = $this->getPositionChild($children, $position);
    }

    $permission = $this->permission[$this->cat_id];

    $table = 'tbt_equipment_requisition_document';
    $this->db->distinct('tbt_asset_track_document.*');  
    $this->db->select('tbt_equipment_requisition_document.*');          
    $this->db->join('tbt_user_customer', 'tbt_user_customer.ship_to_id = tbt_equipment_requisition_document.ship_to_id','left');
    $this->db->join('tbt_user', 'tbt_user_customer.user_id = tbt_user.user_id','left'); 
    $this->db->join('tbt_user_position', 'tbt_user.employee_id = tbt_user_position.employee_id','left'); 
    $this->db->join('tbm_position', 'tbt_user_position.position_id = tbm_position.id','left');      
        //$this->db->where('tbt_fix_claim.delete_flag',0);

    if ($permission['shipto']['value'] == 'related') {
        if (!empty($children)) {
            $children = array_merge($position_list, $children);
            $this->db->where_in('tbm_position.id', $children);
        } else {
            $this->db->where('tbt_user.employee_id', $emp_id);
        }
    }  

    $this->db->where('tbt_equipment_requisition_document.quotation_id',$keyword);
    $this->db->order_by('tbt_equipment_requisition_document.require_date desc, tbt_equipment_requisition_document.id desc');
       // $this->db->get($table);

        ///////////////////////// start : serch ////////////////////////////////
    $config = Array(     
        "visible_column" => Array
        (
            Array
            (
                "name" => "tbt_equipment_requisition_document.id"                                   
                ),
            Array
            (
                "name" => "tbt_equipment_requisition_document.title"                                   
                ),

            )
        );

    $match = $this->input->post('search');
    $condition_count = 0;
    if(!empty($match)){
        $this->db->like('tbt_equipment_requisition_document.title',$match);
        }//end if   

        $result = self::getResultWithPage($table,$page);
        
        $count = $result->num_rows();
        $result = $result->result_array();
        
        $this->db->select('COUNT(*) AS cnt'); 
        $this->db->join('tbt_user_customer', 'tbt_user_customer.ship_to_id = tbt_equipment_requisition_document.ship_to_id','left');
        $this->db->join('tbt_user', 'tbt_user_customer.user_id = tbt_user.user_id','left'); 
        $this->db->join('tbt_user_position', 'tbt_user.employee_id = tbt_user_position.employee_id','left'); 
        $this->db->join('tbm_position', 'tbt_user_position.position_id = tbm_position.id','left');      
        //$this->db->where('tbt_fix_claim.delete_flag',0);

        if ($permission['shipto']['value'] == 'related') {
            if (!empty($children)) {
                $children = array_merge($position_list, $children);
                $this->db->where_in('tbm_position.id', $children);
            } else {
                $this->db->where('tbt_user.employee_id', $emp_id);
            }
        }  

        $this->db->where('tbt_equipment_requisition_document.quotation_id',$keyword);
       // $this->db->get($table);

        ///////////////////////// start : serch ////////////////////////////////
        $config = Array(     
            "visible_column" => Array
            (
                Array
                (
                    "name" => "tbt_equipment_requisition_document.id"                                   
                    ),
                Array
                (
                    "name" => "tbt_equipment_requisition_document.title"                                   
                    ),

                )
            );

        $match = $this->input->post('search');
        $condition_count = 0;
        if(!empty($match)){
            $this->db->like('tbt_equipment_requisition_document.title',$match);
        }//end if   

        $query = $this->db->get($table);
        $total_result = $query->result_array();
        $total_item = intval($total_result[0]['cnt']);

        $this->db->select('tbt_quotation.*');
        $this->db->from('tbt_quotation');
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

        return self::response($state,$code,$msg,$output);
    }

    public function getContentById($table,$id){      

        //TODO :: qery by id
        if(!empty($id))


            $this->db->select('tbt_equipment_requisition_document.*');
        $this->db->where('tbt_equipment_requisition_document.id',$id);

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
        return $output->row_array();
    }

    public function getLastId () {
        $this->db->select('id');
        $this->db->order_by('id desc');
        $this->db->limit(1);

        $query = $this->db->get('tbt_equipment_requisition_document');
        $result = $query->row_array();

        if (empty($result)) {
            return 1980010000;
        }

        return intval($result['id'])+1;
    }

    public function getLastRequisition ($id, $quotation_id) {

        $this->db->select('require_date');
        $this->db->from('tbt_equipment_requisition_document');  
        $this->db->where('tbt_equipment_requisition_document.id',$id);  
        $query = $this->db->get();
        $doc = $query->row_array();

        $this_month = date('m', strtotime($doc['require_date']));

        $this->db->where('MONTH(actual_date)', $this_month);
        $this->db->where('tbt_equipment_requisition_document.id <', $id);
        $this->db->where('tbt_equipment_requisition_document.quotation_id',$quotation_id);
        $this->db->order_by('actual_date desc');
        $result  = $this->db->get('tbt_equipment_requisition_document');

        return $result->row_array();
    }

    public function getEquipmentItems ($id, $sale_order_id, $quotation_id='') {

        $this->db->select('require_date');
        $this->db->from('tbt_equipment_requisition_document');   
        $this->db->where('tbt_equipment_requisition_document.id',$id);  
        $query = $this->db->get();
        $doc = $query->row_array();
        
        $last_month = date('m', strtotime($doc['require_date']." -1 month"));
        $this_month = date('m', strtotime($doc['require_date']));

        $this->db->where('requisition_document_id', $id);
        $query  = $this->db->get('tbt_equipment_requisition');
        $result = $query->result_array();

        $output = array();
        if (!empty($result)) {
            foreach ($result as $key => $value) {
                if (!array_key_exists($value['material_type'], $output)) {
                    $output[$value['material_type']] = array();
                }

                $value['last_count'] = $this->getLastMonthItems($value['material_no'], $sale_order_id, $id, $last_month, $quotation_id);
                $value['this_count'] = $this->getThisMonthItems($value['material_no'], $sale_order_id, $id, $this_month);

                array_push($output[$value['material_type']], $value);
            }
        }

        return $output;
    }


    private function response_msg($state,I$code,$msg,$output){
        return array('state'=>$state,'code'=>$code,'msg'=>$msg,'output'=>$output);
    }

    function getUnitText($code) {

        $this->db->select('MSEHT');
        $this->db->where(array('SPRAS' => 'E', 'MSEHI' => $code, 'MANDT' => 800));
        $query = $this->db->get('t006a');
        $result = $query->row_array();

        if (!empty($result)) {
            return $result['MSEHT'];
        }

        return "";
    }

    function updateZSDShipto ($result, $ship_to_id) {

        if (!empty($result['ET_ZSD_SHIP_TO'])) {
            $this->db->delete('zsd_ship_to', array('SHIP_TO' => $ship_to_id));

            $material_list = array();
            foreach ($result['ET_ZSD_SHIP_TO'] as $material) {
                // $material['MAT_NAME'] = iconv("TIS-620", "UTF-8", $material['MAT_NAME'] );
                // $this->db->insert('zsd_ship_to', $material);
                array_push($material_list, $material);

                // $this->db->where(array('MANDT' => $material['MANDT'], 'MAT_NO' => $material['MAT_NO'], 'SHIP_TO' => $material['SHIP_TO']));
                // $query = $this->db->get('zsd_ship_to');
                // $obj = $query->row();

                // if (!empty($obj)) {
                //     $this->db->where(array('MANDT' => $material['MANDT'], 'MAT_NO' => $material['MAT_NO'], 'SHIP_TO' => $material['SHIP_TO']));
                //     $this->db->update('zsd_ship_to', $material);
                // } else {
                //     $this->db->insert('zsd_ship_to', $material);
                // }
            }
            $this->db->insert_batch('zsd_ship_to', $material_list);
        }

    }
    function getProjectMaterial_new ($ship_to_id, $sale_order_id, $doc_id) {

        $this->db->select('require_date');
        $this->db->from('tbt_equipment_requisition_document');  
        $this->db->where('tbt_equipment_requisition_document.id',$doc_id);  
        $query = $this->db->get();
        $doc = $query->row_array();

        $last_month = date('m', strtotime($doc['require_date']." -1 month"));
        $this_month = date('m', strtotime($doc['require_date']));

        $this->db->select('zsd_ship_to.MAT_NO as material_no, zsd_ship_to.MAT_NAME as material_description, zsd_ship_to.MAT_TYPE as material_type, zsd_ship_to.UNIT as unit_code, zsd_ship_to.UPDATE_DATE as update_date, zsd_ship_to.UPDATE_TIME as update_time');
        $this->db->select('0 as is_customer_request');
        $this->db->select('IFNULL(last_month.add_quantity, 0) as last_month,');
        $this->db->select('IFNULL(current_month.add_quantity, 0) as this_count');
        
        $this->db->join('sap_tbm_mat_price', 'sap_tbm_mat_price.material_no = zsd_ship_to.MAT_NO');

        $this->db->join("( SELECT material_no, tbt_equipment_requisition.add_quantity FROM ( tbt_equipment_requisition_document ) LEFT JOIN tbt_equipment_requisition ON tbt_equipment_requisition_document.id = tbt_equipment_requisition.requisition_document_id WHERE MONTH (require_date) = '$last_month' AND tbt_equipment_requisition_document.id != '' AND tbt_equipment_requisition_document.status = 'approved' AND tbt_equipment_requisition_document.quotation_id = '' ) AS last_month", "last_month.material_no = zsd_ship_to.MAT_NO", "left");
        $this->db->join("( SELECT material_no, tbt_equipment_requisition.add_quantity FROM ( tbt_equipment_requisition_document ) LEFT JOIN tbt_equipment_requisition ON tbt_equipment_requisition_document.id = tbt_equipment_requisition.requisition_document_id WHERE MONTH (require_date) = '$this_month' AND tbt_equipment_requisition_document.status = 'approved' AND tbt_equipment_requisition_document.quotation_id = '' ) AS current_month", 'last_month.material_no = zsd_ship_to.MAT_NO', 'left');

        $this->db->where('zsd_ship_to.SHIP_TO',$ship_to_id);  
        $this->db->where("(CASE WHEN MAT_TYPE IN ('Z2013', 'Z2014') THEN sap_tbm_mat_price.price ELSE 1 END > 0)");  
        $query = $this->db->get('zsd_ship_to');

        $result = $query->result_array();
        //die($this->db->last_query());
        
        return $result;
    }

    function getProjectMaterial ($ship_to_id, $sale_order_id, $doc_id) {

        $this->db->select('require_date');
        $this->db->from('tbt_equipment_requisition_document');  
        $this->db->where('tbt_equipment_requisition_document.id',$doc_id);  
        $query = $this->db->get();
        $doc = $query->row_array();

        $last_month = date('m', strtotime($doc['require_date']." -1 month"));
        $this_month = date('m', strtotime($doc['require_date']));

        $this->db->select('zsd_ship_to.MAT_NO as material_no, zsd_ship_to.MAT_NAME as material_description, zsd_ship_to.MAT_TYPE as material_type, zsd_ship_to.UNIT as unit_code, zsd_ship_to.UPDATE_DATE as update_date, zsd_ship_to.UPDATE_TIME as update_time');
        $this->db->join('sap_tbm_mat_price', 'sap_tbm_mat_price.material_no = zsd_ship_to.MAT_NO');
        $this->db->where('zsd_ship_to.SHIP_TO',$ship_to_id);  
        $this->db->where("(CASE WHEN MAT_TYPE IN ('Z2013', 'Z2014') THEN sap_tbm_mat_price.price ELSE 1 END > 0)");  
        $query = $this->db->get('zsd_ship_to');

        $result = $query->result_array();
        //die($this->db->last_query());

        if (!empty($result)) {
            foreach ($result as $key => $value) {
                $result[$key]['is_customer_request'] = 0;
                $result[$key]['unit_text']  = $this->getUnitText($value['unit_code']);
                $result[$key]['last_count'] = $this->getLastMonthItems($value['material_no'], $sale_order_id, $doc_id, $last_month);
                $result[$key]['this_count'] = $this->getThisMonthItems($value['material_no'], $sale_order_id, $doc_id, $this_month);
                // echo $value['unit_code']." | ".$result[$key]['unit_text']."<br>";
            }
        }
        // echo "<pre>"; print_r($result); echo "</pre>"; die();
        return $result;
    }

    function getLastMonthItems($item_code, $sale_order_id, $id, $month=null, $quotation_id='') {

        if (empty($month)) {
            $month = date('m', strtotime(date('m')." -1 month"));
        }

        $this->db->select('tbt_equipment_requisition.add_quantity');
        $this->db->from('tbt_equipment_requisition_document');
        $this->db->join('tbt_equipment_requisition', 'tbt_equipment_requisition_document.id = tbt_equipment_requisition.requisition_document_id', 'left');
        $this->db->where('MONTH(require_date)', $month);
        $this->db->where('tbt_equipment_requisition_document.id !=', $id);
        $this->db->where('tbt_equipment_requisition_document.status ', 'approved');
        //$this->db->where('tbt_equipment_requisition_document.sale_order_id', $sale_order_id);
        $this->db->where('tbt_equipment_requisition_document.quotation_id', $quotation_id);
        $this->db->where('tbt_equipment_requisition.material_no', $item_code);
        $query = $this->db->get();

        $items = $query->result_array();
        if (!empty($items)) {
            $count = 0;
            foreach ($items as $item) {
                $count += $item['add_quantity'];
            }
            return $count;
        }

        return 0;
    }

    function getThisMonthItemsbyType ($material_type, $sale_order_id, $id) {


        $this->db->select('MONTH(require_date) as month');
        $this->db->from('tbt_equipment_requisition_document');
        $this->db->where('tbt_equipment_requisition_document.id', $id);
        $query = $this->db->get();
        $doc = $query->row_array();
        if (!empty($doc)) {

            $month = $doc['month'];

            $this->db->select('*');
            $this->db->from('tbt_equipment_requisition_document');
            $this->db->join('tbt_equipment_requisition', 'tbt_equipment_requisition_document.id = tbt_equipment_requisition.requisition_document_id', 'left');
            $this->db->where('MONTH(require_date)', $month);
            //$this->db->where('tbt_equipment_requisition_document.id <', $id);
            $this->db->where('tbt_equipment_requisition_document.status ', 'approved');
            $this->db->where('tbt_equipment_requisition_document.sale_order_id', $sale_order_id);
            $this->db->where('tbt_equipment_requisition.material_type', $material_type);
            $query = $this->db->get();

            $items = $query->result_array();

            return $items;
        }
    }

    function getThisMonthItems($item_code, $sale_order_id, $id, $month=null) {

        if (empty($month)) {
            $month = date('m');
        }

        $this->db->select('tbt_equipment_requisition.add_quantity');
        $this->db->from('tbt_equipment_requisition_document');
        $this->db->join('tbt_equipment_requisition', 'tbt_equipment_requisition_document.id = tbt_equipment_requisition.requisition_document_id', 'left');
        $this->db->where('MONTH(require_date)', $month);
        //$this->db->where('tbt_equipment_requisition_document.id <', $id);
        $this->db->where('tbt_equipment_requisition_document.status ', 'approved');
        $this->db->where('tbt_equipment_requisition_document.sale_order_id', $sale_order_id);
        $this->db->where('tbt_equipment_requisition.material_no', $item_code);
        $query = $this->db->get();

        $items = $query->result_array();
        if (!empty($items)) {
            $count = 0;
            foreach ($items as $item) {
                $count += $item['add_quantity'];
            }
            return $count;
        }

        return 0;
    }
    

    function insert_list_equipment_requisition($p)
    {

        //echo "model:".$p['quotation_id']."<br/>";

        $quotation_id = $p['quotation_id'];
        $ship_to_id = $p['ship_to_id'];
        $sold_to_id = $p['sold_to_id'];
        $order_type = $p['order_type'];
        $sale_order_id = $p['sale_order_id'];
        $job_cat_id = $p['job_cat_id'];
        $event_title = $p['event_title'];
        $actor_id = $p['actor_id'];
        $plan_date = reDate($p['plan_date']);
        $remark = $p['remark'];

        $msg = '';     
        
        $query_last_doc_id=$this->db->get('tbt_equipment_requisition_document');  
        $doc_id = 1980010000;          
        foreach ($query_last_doc_id->result_array() as $row){               
           $last_doc_id =  $row['id'];
           $doc_id = $last_doc_id+1;
       }        


       $this->db->where('id', $quotation_id);
       $query=$this->db->get('tbt_quotation');   
       $project = $query->row_array();

       $data_doc = array(
        'id'                => $doc_id,
        'title'             => $event_title,
        'order_type'        => $order_type,
        'sale_order_id'     => $sale_order_id,
        'item_category'     => $job_cat_id,
        'site_inspector_id' => $actor_id,
        'inspector_id'      => $actor_id,
        'quotation_id'      => $quotation_id,
        'ship_to_id'        => $ship_to_id,
        'create_date'       => date('Y-m-d'),
        'actual_date'       => date('Y-m-d'),
        'contract_id'       => $project['contract_id'],
        'require_date'      => $plan_date,
        'remark'            => $remark,
        'status'            => 'being'
        );

       $query2=$this->db->insert('tbt_equipment_requisition_document', $data_doc);
       $track_doc_id = $this->db->insert_id();

   }

   function delete ($id) {
    $this->db->delete('tbt_equipment_requisition', array('requisition_document_id' => $id));
    $this->db->delete('tbt_equipment_requisition_document', array('id' => $id));  
}

function isFull ($sale_order_id, $sap_order_list) {

    $is_full = 1;
    if (!empty($sap_order_list['ET_BREAKDOWN'])) {

        $budget = array();

        foreach ($sap_order_list['ET_BREAKDOWN'] as $key => $mat) {
            if ($mat['VBELN'] == $sale_order_id) {
                if (!array_key_exists($mat['MATNR'], $budget)) {
                    $budget[$mat['MATNR']] = 0;
                }

                if ($mat['MTART'] == 'Z001' || $mat['MTART'] == 'Z002') {
                    $budget[$mat['MATNR']] = intval($mat['KWMENG']);
                } else if ($mat['MTART'] == 'Z013' || $mat['MTART'] == 'Z014') {
                    $budget[$mat['MATNR']] = floatval($mat['KWERT']);
                } 
            }
        }

        $this->db->where('sale_order_id', $sale_order_id);
        $query = $this->db->get('tbt_equipment_requisition_document');

        $equipment = array();
        $doc_list = $query->result_array();
        if (!empty($doc_list)) {
            foreach ($doc_list as $key => $doc) {
                $this->db->where('is_allow', '1');
                $this->db->where('requisition_document_id', $doc['id']);
                $query = $this->db->get('tbt_equipment_requisition');
                $equipment_list = $query->result_array();

                if (!empty($equipment_list)) {
                    foreach ($equipment_list as $key => $equip) {
                        if (!array_key_exists($equip['material_no'], $equipment)) {
                            $equipment[$equip['material_no']] = 0;
                        }

                        $equipment[$equip['material_no']] += $equip['add_quantity'];
                    }
                }
            }
        }

            // echo $sale_order_id."<br>";
            // echo "Budget";
            // echo "<pre>";
            // print_r($budget);
            // echo "</pre>";

            // echo "Equip";
            // echo "<pre>";
            // print_r($equipment);
            // echo "</pre>";

        foreach ($budget as $matnr => $value) {
            if (!array_key_exists($matnr, $equipment) || $equipment[$matnr] < $budget[$matnr]) {
                $is_full = 0;
            }
        }
    }

    return $is_full;
}

}//end model


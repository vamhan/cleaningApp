<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class __equipment_model extends MY_Model{

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
         //$table = 'tbt_asset_track_document';

    $table = 'tbt_equipment_return_document';            

    $this->db->select('tbt_equipment_return_document.*');
        //$this->db->join('tbt_action_plan', 'tbt_action_plan.id = tbt_fix_claim.action_plan_id','left');        
        //$this->db->where('tbt_fix_claim.delete_flag',0);

    $this->db->join('tbt_user_customer', 'tbt_user_customer.ship_to_id = tbt_equipment_return_document.ship_to_id','left');
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


    $this->db->where('tbt_equipment_return_document.quotation_id',$keyword);
    $this->db->order_by('tbt_equipment_return_document.return_date desc');
       // $this->db->get($table);

        ///////////////////////// start : serch ////////////////////////////////
    $config = Array(     
        "visible_column" => Array
        (
            Array
            (
                "name" => "tbt_equipment_return_document.id"                                   
                ),
            Array
            (
                "name" => "tbt_equipment_return_document.title"                                   
                ),
            
            )
        );

        //==Set up keyword Search 
    $match = $this->input->post('search');
    $condition_count = 0;
    if(!empty($match)){
        $this->db->like('tbt_equipment_return_document.title',$match);
            }//end if   


        ///////////////////////// end : serch ////////////////////////////////


            $result = self::getResultWithPage($table,$page);
            
            $count = $result->num_rows();
            $result = $result->result_array();
            
            $this->db->select('tbt_quotation.*');
            $this->db->from('tbt_quotation');
            $this->db->where('tbt_quotation.id',$keyword);

            $query = $this->db->get();
            $project_result = $query->row_array();

            $output = array();
            $state = true;
            $code = '000';
            $msg = '';
            $output['total_item'] = self::getResultTotalpage($table, array('tbt_equipment_return_document.quotation_id' => $keyword));
            $output['list'] = $result;
            $output['page'] = $page;
            $output['page_size'] = $this->pageSize;
            $output['project'] = $project_result;
            $output['quotation_id'] = $keyword;               
            $output['total_page'] = ceil(self::getResultTotalpage($table, array('tbt_equipment_return_document.quotation_id' => $keyword))/$this->pageSize);

            return self::response($state,$code,$msg,$output);
        }





        public function getContentById($table,$id){      
            
        //TODO :: qery by id
            if(!empty($id))

               
                $this->db->select('tbt_equipment_return_document.*');
            $this->db->where('tbt_equipment_return_document.equipment_doc_id',$id);
            
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


        public function getAsset($quotation_id){
            
            $this->db->select('sap_tbt_quotation_asset.*');
            $this->db->where('quotation_id',$quotation_id);  
            $result = $this->db->get('sap_tbt_quotation_asset');

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


        private function response_msg($state,$code,$msg,$output){
            return array('state'=>$state,'code'=>$code,'msg'=>$msg,'output'=>$output);
        }



        function insert_list_equipment_return($p)
        {

        //echo "model:".$p['quotation_id']."<br/>";
            
            $quotation_id = $p['project_id'];
            $ship_to_id = $p['ship_to_id'];
            $sold_to_id = $p['sold_to_id'];
            $event_title = $p['event_title'];
            $order_type = $p['order_type'];
            $job_cat_id = $p['job_cat_id'];
            $actor_id = $p['actor_id'];
            $plan_date = $p['plan_date'];
            $remark = $p['remark'];

            $msg = '';     

            $query_last_doc_id=$this->db->get('tbt_equipment_return_document');  
            $doc_id = 1990000000;          
            foreach ($query_last_doc_id->result_array() as $row){               
             $last_doc_id =  $row['equipment_doc_id'];
             $doc_id = $last_doc_id+1;
         }

         $this->db->where('id', $quotation_id);
         $query=$this->db->get('tbt_quotation');   
         $project = $query->row();
         
         $part = $this->getMaxPart($quotation_id);

         $data_doc = array(
            'equipment_doc_id'          => $doc_id,
            //'asset_doc_id'              => $asset_doc_id,
            'title'                     => $event_title,
            'order_type'                => $order_type,
            'item_category'             => $job_cat_id,
            'site_inspector_id'         => $actor_id,
            'inspector_id'              => $actor_id,
            'quotation_id'              => $quotation_id,
            'ship_to_id'                => $ship_to_id,
            'create_date'               => date('Y-m-d'),
            'actual_date'               => date('Y-m-d'),
            'contract_id'               => $project->contract_id,
            'part'                      => $part,
            'return_date'               => $plan_date,
            'remark'                    => $remark,
            'equipment_sale_order_id'   => $p['equipment_sale_order_id'],
            'asset_sale_order_id'       => $p['asset_sale_order_id']
            );

         $query2=$this->db->insert('tbt_equipment_return_document', $data_doc);
         $track_doc_id = $this->db->insert_id();

     }

     public function getMaxPart($quotation_id) {

        $this->db->select('MAX(part) as max_part');
        $this->db->where('quotation_id  ', $quotation_id);
        $query = $this->db->get('tbt_equipment_return_document');

        $result = $query->row_array();
        if (empty($result)) {
            return 1;
        } 

        return intval($result['max_part'])+1;
    }

    public function getEquipmentItems ($id) {

        $this->db->where('equipment_return_document_id  ', $id);
        $query  = $this->db->get('tbt_equipment_return');
        $result = $query->result_array();

        $in_type = array('Z001', 'Z002', 'Z013', 'Z014');
        $output = array();
        if (!empty($result)) {
            foreach ($result as $key => $value) {
                $type = $value['material_type'];
                if (!in_array($value['material_type'], $in_type)) {
                    $type = 'asset';
                }

                if (!array_key_exists($type, $output)) {
                    $output[$type] = array();
                }

                array_push($output[$type], $value);
            }
        }

        return $output;
    }

    function getProjectMaterial ($ship_to_id) {

        $this->db->select('zsd_ship_to.MAT_NO as material_no, zsd_ship_to.MAT_NAME as material_description, zsd_ship_to.MAT_TYPE as material_type, zsd_ship_to.UNIT as unit_code, zsd_ship_to.UPDATE_DATE as update_date, zsd_ship_to.UPDATE_TIME as update_time');
        $this->db->join('sap_tbm_mat_price', 'sap_tbm_mat_price.material_no = zsd_ship_to.MAT_NO');
        $this->db->where('zsd_ship_to.SHIP_TO',$ship_to_id);  
        $this->db->where("(CASE WHEN MAT_TYPE IN ('Z2013', 'Z2014') THEN sap_tbm_mat_price.price ELSE 1 END > 0)"); 
        $query = $this->db->get('zsd_ship_to');

        $result = $query->result_array();
        if (!empty($result)) {
            foreach ($result as $key => $value) {
                $result[$key]['unit_text']  = $this->getUnitText($value['unit_code']);
            }
        }

        return $result;
    }
    
    function getAssetUnit ($code) {

        $this->db->select('MEINS');
        $this->db->from('mara');
        $this->db->where('MATNR', $code);

        $query = $this->db->get();
        $row = $query->row_array();

        if (!empty($row)) {
            $unit_text =  $this->getUnitText($row['MEINS']);
            return array('unit_code' => $row['MEINS'], 'unit_text' => $unit_text);
        }

    }

    function getProjectAssetMaterial ($ship_to_id) {

        $this->db->select('ASSET_NO as asset_no, ASSET_NAME as asset_description, MAT_TYPE as material_type');
        $this->db->where('SHIP_TO', $ship_to_id);  
        $query = $this->db->get('zas_date_summary');

        $result = $query->result_array();
        if (!empty($result)) {
            foreach ($result as $key => $value) {
                $unit = $this->getAssetUnit($value['asset_no']);
                $result[$key]['unit_code'] = $unit['unit_code'];
                $result[$key]['unit_text'] = $unit['unit_text'];
            }
        }

        return $result;
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

    function delete ($id) {
        $this->db->delete('tbt_equipment_return', array('equipment_return_document_id   ' => $id));
        $this->db->delete('tbt_equipment_return_document', array('equipment_doc_id' => $id));    
    }

    function getClearJob ($quotation_id) {
        $this->db->select('MAX( id ) as id , order_type, item_category');
        $this->db->where(array('quotation_id' => $quotation_id, 'order_type' => 'ZORZ', 'submit_date_sap !=' => '0000-00-00'));
        $this->db->group_by('item_category');
        $query = $this->db->get('tbt_equipment_requisition_document');

        return $query->result_array();
    }

    function getFullTimeJob ($quotation_id) {
        $this->db->select('MAX( sale_order_id ) as max_id, MIN( sale_order_id ) as min_id');
        $this->db->where(array('quotation_id' => $quotation_id, 'order_type' => 'ZORX', 'submit_date_sap !=' => '0000-00-00'));
        $query = $this->db->get('tbt_equipment_requisition_document');

        return $query->row_array();
    }

    function getPartTimeJob ($quotation_id) {
        $this->db->select('MAX( sale_order_id ) as max_id, MIN( sale_order_id ) as min_id');
        $this->db->where(array('quotation_id' => $quotation_id, 'order_type' => 'ZORY', 'submit_date_sap !=' => '0000-00-00'));
        $query = $this->db->get('tbt_equipment_requisition_document');

        return $query->row_array();
    }

    function _padZero ($text, $length) {
        return str_pad($text, $length, '0', STR_PAD_LEFT);
    }

    function _dateFormat ( $date ) {
        return date("Ymd", strtotime($date));
    }
}//end model


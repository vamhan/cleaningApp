<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class __asset_track_model extends MY_Model{

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

        $table = 'tbt_asset_track_document';

        $this->db->distinct('tbt_asset_track_document.*');  
        $this->db->select('tbt_asset_track_document.*');
        $this->db->select('tbt_action_plan.plan_date AS plan_date,tbt_action_plan.actual_date AS actual_date_plan');
        $this->db->select('tbt_quotation.project_owner_id,tbt_quotation.contract_id');
        $this->db->join('tbt_action_plan', 'tbt_action_plan.id = tbt_asset_track_document.action_plan_id','left'); 
        $this->db->join('tbt_quotation', 'tbt_quotation.id = tbt_asset_track_document.quotation_id','left');

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

        $this->db->where('tbt_asset_track_document.quotation_id',$keyword);
        //$this->db->get($table);
        $this->db->order_by("tbt_action_plan.plan_date", "desc"); 

        ///////////////////////// start : serch ////////////////////////////////
         $config = Array(     
                    "visible_column" => Array
                        (
                            Array
                                (
                                    "name" => "tbt_asset_track_document.id"                                   
                                ),
                            Array
                            (
                                "name" => "tbt_asset_track_document.title"                                   
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
                if(!empty($config['visible_column'])){ 
                  foreach ($config['visible_column'] as $key => $value) {
                        if($condition_count++ < 1){
                            $this->db->like($value['name'],$match);
                        }else{
                            $this->db->or_like($value['name'],$match);
                        }
                  }//end foreach
                }
            }//end if   


        ///////////////////////// end : serch ////////////////////////////////


        $result = self::getResultWithPage($table,$page);
        //$result = self::getResultWithPage_document($table,$page,$keyword);
        
        $count = $result->num_rows();
        $result = $result->result_array();
        //die($this->db->last_query());

        $this->db->select('COUNT(*) AS cnt');
        $this->db->join('tbt_action_plan', 'tbt_action_plan.id = tbt_asset_track_document.action_plan_id','left'); 
        $this->db->join('tbt_quotation', 'tbt_quotation.id = tbt_asset_track_document.quotation_id','left');

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

        $this->db->where('tbt_asset_track_document.quotation_id',$keyword);
        //$this->db->get($table);
        $this->db->order_by("tbt_action_plan.plan_date", "desc"); 

        ///////////////////////// start : serch ////////////////////////////////
         $config = Array(     
                    "visible_column" => Array
                        (
                            Array
                                (
                                    "name" => "tbt_asset_track_document.id"                                   
                                ),
                            Array
                            (
                                "name" => "tbt_asset_track_document.title"                                   
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
                if(!empty($config['visible_column'])){ 
                  foreach ($config['visible_column'] as $key => $value) {
                        if($condition_count++ < 1){
                            $this->db->like($value['name'],$match);
                        }else{
                            $this->db->or_like($value['name'],$match);
                        }
                  }//end foreach
                }
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

               //echo "<pre>"; print_r($result);

        return self::response($state,$code,$msg,$output);
    }

    public function getResultWithPage_document($tableName,$page,$keyword){
        $offset = 0;
        $items = 100;

        if(intval($page)<1){
            return self::response(false,'909','Invalid page number',array());
        }
        $offset = (intval($page)-1)*$this->pageSize;
        $items = $this->pageSize;

        
       
        $this->db->select('tbt_asset_track_document.*');
        $this->db->where('tbt_asset_track_document.quotation_id',$keyword);


        ///////////////////////// start : serch ////////////////////////////////
        
          $config = Array(     
                    "visible_column" => Array
                        (
                            Array
                                (
                                    "name" => "tbt_asset_track_document.id"                                   
                                ),
                            Array
                            (
                                "name" => "tbt_asset_track_document.title"                                   
                            ),
                            //  Array
                            // (
                            //     "name" => "tbt_action_plan.plan_date"                                   
                            // ),
                            //  Array
                            // (
                            //     "name" => "tbt_action_plan.actual_date"                                   
                            // )                                                                  
                        )
                );

        //==Set up keyword Search 
            $match = $this->input->post('search');
            $condition_count = 0;
            if(!empty($match)){
                if(!empty($config['visible_column'])){ 
                  foreach ($config['visible_column'] as $key => $value) {
                        if($condition_count++ < 1){
                          $result =  $this->db->like($value['name'],$match);
                        }else{
                          $result =  $this->db->or_like($value['name'],$match);
                        }
                  }//end foreach
                }
            }//end if 
        ///////////////////////// end : serch ////////////////////////////////   
        $result = $this->db->get($tableName,$items,$offset);  
        return  $result;
    }//end function


    public function getResultTotalpage_doucument($tableName,$keyword){//moved

         //echo 'test'.$keyword;
         //exit();

    //$this->db->select('COUNT(*) AS cnt');
    // $this->db->select('tbt_asset_track_document.*');
    // $this->db->select('tbt_action_plan.plan_date AS plan_date,tbt_action_plan.actual_date AS actual_date');
    // $this->db->select('tbt_quotation.project_owner_id,tbt_quotation.contract_id');
    $this->db->join('tbt_action_plan', 'tbt_action_plan.id = tbt_asset_track_document.action_plan_id','left');
    $this->db->join('tbt_quotation', 'tbt_quotation.id = tbt_asset_track_document.quotation_id','left');
    $this->db->where('tbt_asset_track_document.quotation_id',$keyword);

       ///////////////////////// start : serch ////////////////////////////////        
          $config = Array(     
                    "visible_column" => Array
                        (
                            Array
                                (
                                    "name" => "tbt_asset_track_document.id"                                   
                                ),
                            Array
                            (
                                "name" => "tbt_asset_track_document.title"                                   
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
                if(!empty($config['visible_column'])){ 
                  foreach ($config['visible_column'] as $key => $value) {
                        if($condition_count++ < 1){
                          $result =  $this->db->like($value['name'],$match);
                        }else{
                          $result =  $this->db->or_like($value['name'],$match);
                        }
                  }//end foreach
                }
            }//end if   
        ///////////////////////// end : serch ////////////////////////////////
       $result = $this->db->get($tableName);
       $count_item = $result->num_rows();
       $result = $result->result_array();

       return $count_item;
      // return intval($result[0]['cnt']);

    }//end function





    public function getContentById($table,$id,$status){      
        
        //TODO :: qery by id
        if(!empty($id))

             
            $this->db->select(''.$table.'.*,tbt_action_plan.id As plan_id,tbt_action_plan.actual_date As actual_date,tbt_action_plan.plan_date');
            $this->db->select('tbt_user.user_firstname As actor_name,tbt_user.user_lastname As actor_surname');
            $this->db->select('tbt_asset_track_document.title As project_title,tbt_asset_track_document.survey_officer_id As survey_officer,tbt_asset_track_document.actor_by_id As actor_id');
              if($table=='tbt_asset_track' ){
                $this->db->select(''.$table.'.asset_description As ASSET_NAME_PJ,'.$table.'.last_date As asset_date');
                //,sap_tbt_quotation_asset.is_spare,sap_tbt_quotation_asset.is_clear_job,sap_tbt_quotation_asset.is_fixing
                //$this->db->join('sap_tbt_quotation_asset', 'sap_tbt_quotation_asset.ASSET_NO ='.$table.'.ASSET_NO','left');  
            }

            $this->db->join('tbt_asset_track_document', 'tbt_asset_track_document.id ='.$table.'.asset_track_document_id' ,'left');
            $this->db->join('tbt_action_plan', 'tbt_action_plan.id = tbt_asset_track_document.action_plan_id','left');
            
            $this->db->join('tbt_user', 'tbt_user.employee_id = tbt_asset_track_document.actor_by_id','left');           
            $this->db->where($table.'.asset_track_document_id',$id);
            $this->db->where($table.'.delete_flag',0);  

            if($status!='0' && $table=='tbt_asset_track' ){
                 $this->db->where($table.'.status_tracking',$status);  
            }
            //$this->db->limit(40);
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



    public function getAssetDocument($track_doc_id){            
       
           
            $this->db->select('tbt_asset_track_document.*,tbt_action_plan.plan_date,tbt_action_plan.id As plan_id,tbt_action_plan.actual_date');
            $this->db->where('tbt_asset_track_document.id', $track_doc_id);
            $this->db->join('tbt_action_plan', 'tbt_action_plan.id = tbt_asset_track_document.action_plan_id','left');                           

            $result  = $this->db->get('tbt_asset_track_document');


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


    public function getAssetrack_Notexit($doc_id){
        
        $this->db->select('tbt_asset_track.status_tracking,tbt_asset_track.asset_no');
        $this->db->where('status_tracking','NOT_EXIST');  
        $this->db->where('asset_track_document_id',$doc_id);        
        $result = $this->db->get('tbt_asset_track');        

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


    

    public function _getAsset(){
        
        $this->db->select('sap_tbm_material.*');
        //$this->db->where('1','1');  
        $result = $this->db->get('sap_tbm_material');

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





     public function getAsset(){
        
        $this->db->select('mara.MATNR AS ASSET_NO,makt.MAKTX AS ASSET_NAME,mara.MTART,mara.MATKL as dummy');
        $this->db->join('makt', 'makt.MATNR = mara.MATNR','left');        
        // $this->db->where('mara.MTART','Z018');
        // $this->db->or_where('mara.MTART','Z019');
        $this->db->where('makt.SPRAS','E'); 
        $result = $this->db->get('mara');

        

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





    public function getAsset_dummy(){
        
        $this->db->select('mara.MATNR AS ASSET_NO,makt.MAKTX AS ASSET_NAME');
        $this->db->join('makt', 'makt.MATNR = mara.MATNR','left');     
        $this->db->where('mara.MATKL',1899);
        $this->db->where('makt.SPRAS','E');
        $this->db->order_by('mara.MATNR', 'asc');    
        $result = $this->db->get('mara');

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

    public function getUntrack_dummy($quotation_id,$doc_id){
        
        $this->db->select('tbt_untracked_asset.asset_no AS ASSET_NO,tbt_untracked_asset.asset_description AS ASSET_NAME');         
        $this->db->where('is_dummy',1);   
        $this->db->where('quotation_id',$quotation_id); 
        $this->db->where('asset_track_document_id',$doc_id);    
        $result = $this->db->get('tbt_untracked_asset');

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


    public function update_fixclaim($track_doc_id,$quotation_id){

            //Prevent unset variable 
            $query = false;
                $this->db->where('asset_track_document_id', $track_doc_id); 
                $this->db->where('quotation_id', $quotation_id); 
                $result_asset_track = $this->db->get('tbt_asset_track');
                foreach ($result_asset_track->result_array() as $row_assetrack){
                

        //======= START :  get fixclaim id =============================
                $this->db->where('material_no', $row_assetrack['asset_no']);
                $this->db->where('is_close', 0);
                $this->db->order_by("id", "desc"); 
                $result = $this->db->get('tbt_fix_claim');      
                $count = $result->num_rows();
                $output = array();
                if($count > 0 ){  
                    foreach ($result->result_array() as $row_fixclaim){
                        $fix_claim_id = $row_fixclaim['id']; 
                        $is_fixing =1;
                        $status_track = 'EXIST_WITH_CON';                       
                    }
                }else if($count == 0){
                    $fix_claim_id = ''; 
                    $is_fixing =0;
                    $status_track = $row_assetrack['status_tracking'];
                }              
                //echo  $row_assetrack['status_tracking'].' '.$row_assetrack['asset_no'].' count: '.$count.'<br>';
        //======= END :  get fixclaim id =============================

            //== update fixclaim to tbt_assetrack
            $data = array(
                'is_fixing' =>  $is_fixing,
                'fix_claim_id' => $fix_claim_id,
                'status_tracking' => $status_track           
            );
            $this->db->where('asset_no', $row_assetrack['asset_no']);
            $this->db->where('asset_track_document_id', $track_doc_id);
            $this->db->where('quotation_id', $quotation_id); 
            $query=$this->db->update('tbt_asset_track', $data);
    
        }//end foreach

        if($query){
            //return TRUE;
            $msg="";
            return self::response($msg);
        }else{
            //return FALSE;
            $msg="การอัพเดทผิดพลาด";
            return self::response($msg);
        }
    }   


     public function clone_insert_asset($track_doc_id,$quotation_id){
        //echo "clone";

        //delete tbt_asset_track
        $this->db->where('asset_track_document_id',$track_doc_id);
       
        //Pre-define $query2 -> preventing variable not exist;
        $query2 = false;
        $query1 = $this->db->delete('tbt_asset_track');      

           //====start : get onwner_id  =========
           $this->db->where('id',$quotation_id);
           $query_onwner=$this->db->get('tbt_quotation');
           $data_onwner = $query_onwner->row_array();      
           if(!empty($data_onwner)){
              $actor_id = $data_onwner['project_owner_id'];
              $ship_to_id = $data_onwner['ship_to_id'];
            }else{ $actor_id=''; }
          //====end :  get onwner_id  ========= 

         //====start : get asset insert to tbt_asset_track =========
           $this->db->where('SHIP_TO',$ship_to_id);
           // $this->db->where('MAT_TYPE','Z018');
           // $this->db->where('MAT_TYPE','Z019');
           $query_project=$this->db->get('zas_date_summary');          
            foreach ($query_project->result_array() as $row){               
                // $asset_se = $row['ASSET_NO']." ".$row['ASSET_NAME']." ".$row['ship_to_id']." ".$row['is_clear_job'];
                // echo $asset_se.'<br/>';
                 $is_clear_job = 0;
                if($row['DELV_TYPE']=='ZDF2'){
                     $is_clear_job=1;
                }else{ $is_clear_job=0;}

                $is_spare = 0;
                if($row['MAT_TYPE']=='Z019'){
                     $is_spare=1;
                }else{ $is_spare=0;}

        //======= START :  get fixclaim id =============================
                $this->db->where('material_no', $row['ASSET_NO']);
                $this->db->where('is_close', 0);
                $this->db->order_by("id", "desc"); 
                $result = $this->db->get('tbt_fix_claim');      
                $count = $result->num_rows();
                $output = array();
                if($count > 0 ){  
                    foreach ($result->result_array() as $row_fixclaim){
                        $fix_claim_id = $row_fixclaim['id']; 
                        $is_fixing =1;                       
                    }
                }else{
                    $fix_claim_id = ''; 
                    $is_fixing =0;
                }
        //======= END :  get fixclaim id =============================

                $data_asset_track = array(

                // 'ASSET_NO' => $row['ASSET_NO'],
                // 'ASSET_NAME' => $row['ASSET_NAME'],
                // 'status_tracking' => 'UNCHECK',
                // 'is_clear_job' => $row['is_clear_job'],
                // 'is_spare' => $row['is_spare'],
                // 'is_fixing' => $row['is_fixing'],
                // 'fix_claim_id' => $row['fix_claim_id'],
                // 'LAST_DATE' => $row['LAST_DATE'],
                // 'quotation_id' => $quotation_id,
                // 'ship_to_id' => $row['ship_to_id'],
                // 'asset_track_document_id' => $track_doc_id,
                // //'status' => 0,
                // 'remark' => ''

                // 'asset_no' => $row['asset_no'],
                // 'asset_description' => $row['asset_description'],
                // 'status_tracking' => 'UNCHECK',
                // 'is_clear_job' => $row['is_clear_job'],
                // 'is_spare' => $row['is_spare'],
                // 'is_fixing' => $row['is_fixing'],
                // 'fix_claim_id' => $row['fix_claim_id'],
                // 'last_date' => $row['last_date'],
                // 'quotation_id' => $quotation_id,
                // 'ship_to_id' => $row['ship_to_id'],
                // 'asset_track_document_id' => $track_doc_id,                
                // 'remark' => '',
                // 'actor_by_id' => $actor_id

                'asset_no' => $row['ASSET_NO'],
                'asset_description' => $row['ASSET_NAME'],
                'status_tracking' => 'UNCHECK',
                'is_clear_job' => $is_clear_job,
                'is_spare' => $is_spare,
                'is_fixing' => $is_fixing,
                'fix_claim_id' => $fix_claim_id,
                'last_date' => $row['LAST_DATE'],
                'quotation_id' => $quotation_id,
                'ship_to_id' => $row['SHIP_TO'],
                'asset_track_document_id' => $track_doc_id,                
                'remark' => '',
                'actor_by_id' => $actor_id


            );
            $query2=$this->db->insert('tbt_asset_track',$data_asset_track);

        }
        // echo $this->db->last_query();
        //     die();
        //====end : get asset insert to tbt_asset_track =========


        if($query1 && $query2){
            //return TRUE;
            $msg="";
            return self::response($msg);
        }else{
            //return FALSE;
            $msg="ไม่มีข้อมูล asset ของโปรเจคนี้";
            return self::response($msg);
        }
    }




    // function insert_list_asset($p){
    //     $query1 = false;
    //     $query2 = false;
    //     $query3 = false;

    //     //echo "model:".$p['quotation_id']."<br/>";
        
    //     $quotation_id = $p['quotation_id'];
    //     $ship_to_id = $p['ship_to_id'];
    //     $contract_id = $p['contract_id'];
    //     $sold_to_id =$p['sold_to_id'];

    //     $event_title = $p['event_title'];
    //     $actor_id = $p['actor_id'];
    //     $event_category_id = $p['event_category'];
    //     $plan_date = reDate($p['plan_date']);
    //     $remark = $p['remark'];
    //     // echo reDate($p['plan_date']);
    //     // exit();

    //     $msg = '';     
        
    //     //==  get last Id tbt_action_plan ================
    //     $query_last_id=$this->db->get('tbt_action_plan');            
    //     foreach ($query_last_id->result_array() as $row){               
    //        $last_action_id =  $row['id'];
    //     }        
    //     $action_plan_id = $last_action_id +1;
    //     //echo '<br>LAST ACCTION PLAN ID'.$last_action_id;
    //     //echo '<br>ACCTION PLAN ID'.$action_plan_id;

    //      //==  get last Id tbt_asset_track_document ================
    //     $query_last_doc_id=$this->db->get('tbt_asset_track_document');            
    //     foreach ($query_last_doc_id->result_array() as $row){               
    //        $last_doc_id =  $row['id'];
    //     }        
    //     $asset_doc_id = $last_doc_id +1;
    //     //echo '<br>LAST DOC ID'.$last_doc_id;
    //    // echo '<br>ACCTION DOC ID'.$asset_doc_id;
    //    //exit();
       

    //     $data_action_plan = array(
    //         'id' => $action_plan_id,
    //         'title' => $event_title,
    //         'event_category_id' => $event_category_id,
    //         'actor_id' => $actor_id,
    //         'plan_date' => $plan_date,
    //         'actual_date' => '',
    //         'remark' => $remark,
    //         'visitation_reason_id' => 0,
    //         'status' => '',
    //         'is_holiday' => 0,
    //         'clear_job_category_id' => 0,
    //         'clear_job_type_id' => 0,
    //         'staff' =>0,
    //         'total_staff' => 0,
    //         'quotation_id' => $quotation_id,
    //         'ship_to_id' => $ship_to_id,
    //         'sold_to_id' => $sold_to_id,
    //         //'quotation_id' => 0,
    //         'holiday_id' => 0,
    //     );

    //     $query1=$this->db->insert('tbt_action_plan', $data_action_plan);      

        
    //      $data_track_doc = array(
    //         'id' => $asset_doc_id,
    //         'title' => $event_title,
    //         'action_plan_id' => $action_plan_id,
    //         'survey_officer_id' => $actor_id,
    //         'quotation_id' => $quotation_id,
    //         'actor_by_id' =>'',
    //         'ship_to_id' => $ship_to_id,
    //         'contract_id' => $contract_id,
    //         //'submit_date_sap' => '',
    //         'status_asset_track_document' => ' '            
    //     );

    //     $query2=$this->db->insert('tbt_asset_track_document', $data_track_doc);

    //     //====start : get asset insert to tbt_asset_track =========
    //        $this->db->where('SHIP_TO',$ship_to_id);
    //        //$this->db->where('delete_flag',0);
    //       // $query_project=$this->db->get('sap_tbt_quotation_asset');
    //        // $this->db->where('MAT_TYPE','Z018');
    //        // $this->db->where('MAT_TYPE','Z019');
    //        $query_project=$this->db->get('zas_date_summary');         
           
    //         foreach ($query_project->result_array() as $row){               
    //             // $asset_se = $row['ASSET_NO']." ".$row['ASSET_NAME']." ".$row['ship_to_id']." ".$row['is_clear_job'];
    //             // echo $asset_se.'<br/>';
    //             $is_clear_job = 0;
    //             if($row['DELV_TYPE']=='ZDF2'){
    //                  $is_clear_job=1;
    //             }else{ $is_clear_job=0;}

    //             $is_spare = 0;
    //             if($row['MAT_TYPE']=='Z019'){
    //                  $is_spare=1;
    //             }else{ $is_spare=0;}
                
    //         //======= START :  get fixclaim id =============================
    //             $this->db->where('material_no', $row['ASSET_NO']);
    //             $this->db->where('is_close', 0);
    //             $this->db->order_by("id", "desc"); 
    //             $result = $this->db->get('tbt_fix_claim');      
    //             $count = $result->num_rows();
    //             $output = array();
    //             if($count > 0 ){  
    //                 foreach ($result->result_array() as $row_fixclaim){
    //                     $fix_claim_id = $row_fixclaim['id']; 
    //                     $is_fixing =1;                       
    //                 }
    //             }else{
    //                 $fix_claim_id = ''; 
    //                 $is_fixing =0;
    //             }
    //          //======= END :  get fixclaim id =============================

    //             $data_asset_track = array(

    //             'asset_no' => $row['ASSET_NO'],
    //             'asset_description' => $row['ASSET_NAME'],
    //             'status_tracking' => 'UNCHECK',
    //             'is_clear_job' => $is_clear_job,
    //             'is_spare' => $is_spare,
    //             'is_fixing' => $is_fixing,
    //             'fix_claim_id' => $fix_claim_id,
    //             'last_date' => $row['LAST_DATE'],
    //             'quotation_id' => $quotation_id,
    //             'ship_to_id' => $row['SHIP_TO'],
    //             'asset_track_document_id' => $asset_doc_id,                
    //             'remark' => '',
    //             'actor_by_id' => $actor_id            

    //         );
    //         $query3=$this->db->insert('tbt_asset_track', $data_asset_track);

    //     }
    //     //====end : get asset insert to tbt_asset_track =========
    //     //exit();
    
    //     if($query1 && $query2 && $query3) {
    //          $msg = 'insert success';
    //         return self::response($msg);
    //     } else {
    //         $msg = 'ERROR : insert';
    //         return self::response($msg);
    //     }

    // }


    function clone_insert_assetrack($action_plan_id,$doc_id,$quotation_id,$ship_to_id,$emp_id){


                   //====start : get asset insert to tbt_asset_track =========
           $this->db->where('SHIP_TO',$ship_to_id);
           //$this->db->where('delete_flag',0);
          // $query_project=$this->db->get('sap_tbt_quotation_asset');
           // $this->db->where('MAT_TYPE','Z018');
           // $this->db->where('MAT_TYPE','Z019');
           $query_project=$this->db->get('zas_date_summary');         
           
            foreach ($query_project->result_array() as $row){               
                // $asset_se = $row['ASSET_NO']." ".$row['ASSET_NAME']." ".$row['ship_to_id']." ".$row['is_clear_job'];
                // echo $asset_se.'<br/>';
                $is_clear_job = 0;
                if($row['DELV_TYPE']=='ZDF2'){
                     $is_clear_job=1;
                }else{ $is_clear_job=0;}

                $is_spare = 0;
                if($row['MAT_TYPE']=='Z019'){
                     $is_spare=1;
                }else{ $is_spare=0;}
                
            //======= START :  get fixclaim id =============================
                $this->db->where('material_no', $row['ASSET_NO']);
                $this->db->where('is_close', 0);
                $this->db->order_by("id", "desc"); 
                $result = $this->db->get('tbt_fix_claim');      
                $count = $result->num_rows();
                $output = array();
                if($count > 0 ){  
                    foreach ($result->result_array() as $row_fixclaim){
                        $fix_claim_id = $row_fixclaim['id']; 
                        $is_fixing =1;                       
                    }
                }else{
                    $fix_claim_id = ''; 
                    $is_fixing =0;
                }
             //======= END :  get fixclaim id =============================

                $data_asset_track = array(

                'asset_no' => $row['ASSET_NO'],
                'asset_description' => $row['ASSET_NAME'],
                'status_tracking' => 'UNCHECK',
                'is_clear_job' => $is_clear_job,
                'is_spare' => $is_spare,
                'is_fixing' => $is_fixing,
                'fix_claim_id' => $fix_claim_id,
                'last_date' => $row['LAST_DATE'],
                'quotation_id' => $quotation_id,
                'ship_to_id' => $row['SHIP_TO'],
                'asset_track_document_id' => $doc_id,                
                'remark' => '',
                'actor_by_id' => $emp_id            

            );
            $query3=$this->db->insert('tbt_asset_track', $data_asset_track);

        }
        //====end : get asset insert to tbt_asset_track =========


        // if($query3) {
        //      $msg = 'insert success';
        //     return self::response($msg);
        // } else {
        //     $msg = 'ERROR : insert';
        //     return self::response($msg);
        // }

    }













    function insert_untrack($p){   

        if(!empty($p['no_serial'])){  
            $ASSET_NAME = $p['untrack_name_asset'];
            $ASSET_NO=$p['untrack_serial_dummy'];
            $is_dummy = '1'; 

        }else{

            //====start : get name asset =========
               $this->db->where('MATNR',$p['untrack_serial']);;
               $query_name=$this->db->get('makt');
               $data = $query_name->row_array();
               $ASSET_NAME = $data['MAKTX'];
            //=========end : get name asset ====================
             $ASSET_NO=$p['untrack_serial'];
             $is_dummy = '0'; 
            
            // ============ START : check add serial untrack ====================
                $this->db->where('asset_no',$p['untrack_serial']);
                $this->db->where('asset_track_document_id', $p['untrack_doc_id']);
                $result = $this->db->get('tbt_untracked_asset');      
                $count = $result->num_rows();
                $output = array();
                if($count > 0 ){ 
                    $msg = 'ไม่สามารถเพิ่มได้คุณได้ทำการเพิ่ม รหัส :'.defill($p['untrack_serial']).'ไปแล้ว';
                    return array('msg'=>$msg);
                    break;
                }
        }       

        $data = array(
            'asset_no' => $ASSET_NO,
            'asset_description' => $ASSET_NAME,
            'quotation_id' => $p['untrack_project_id'],
            'ship_to_id' => $p['untrack_ship_to_id'],
            'input_by_id' => $p['untrack_input_by_id'],
            'remark' => $p['untrack_remark'],
            'asset_track_document_id' => $p['untrack_doc_id'],
            'is_dummy' =>  $is_dummy,
            'delete_flag' => '0'
        );

        $query=$this->db->insert('tbt_untracked_asset', $data);
        if($query) {
             $msg = 'เพิ่มข้อมูลเรียบร้อยแล้ว';
            return array('msg'=>$msg);
        } else {
             $msg = 'ผิดพลาด: ไม่สามารถเพิ่มข้อมูลได้';
             return array('msg'=>$msg);
        }
    }


    function update($serial,$status_tracking,$remark,$doc_id){
        
        // if(!empty($status_tracking)){
        //     if($status_tracking=='exist'){
        //          $status = 1;
        //     }else if($status_tracking=='not exist'){
        //          $status = 2;
        //     }else{
        //         $status = 3;
        //     }
        // }else{
        //     $status = 0;
        // }

       //echo $serial.' '.$status_tracking.'<br/>';

        if(empty($status_tracking)){
            $status_tracking = 'UNCHECK';
        }

         $data = array(
            'status_tracking' => $status_tracking,
            'remark' => $remark,
            //'status' => $status
        );

        $this->db->where('asset_no', $serial);
        $this->db->where('asset_track_document_id', $doc_id);
        $query=$this->db->update('tbt_asset_track', $data);

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
            'submit_date_sap' => date('y-m-d'),           
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



     public function delete_untrack($quotation_id,$doc_id,$asset_id){


        $this->db->where('asset_no',$asset_id);
        $this->db->where('quotation_id',$quotation_id);
        $this->db->where('asset_track_document_id',$doc_id);
        $query1 = $this->db->delete('tbt_untracked_asset');


        if($query1){
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

        $this->db->where('asset_track_document_id',$id);
        $query3 = $this->db->delete('tbt_asset_track');

        $this->db->where('asset_track_document_id',$id);
        $query4 = $this->db->delete('tbt_untracked_asset');


        // $data_doc = array(
        //     'delete_flag' => 0            
        // );

        // $this->db->where('id', $id);
        // $query1=$this->db->update($table, $data_doc);        

        // $data_actionplan = array(
        //     'delete_flag' => 0            
        // );

        // $this->db->where('id', $actionplan_id);
        // $query2=$this->db->update('tbt_action_plan', $data_actionplan);

        // $data_asset_track = array(
        //     'delete_flag' => 0            
        // );

        // $this->db->where('asset_track_document_id', $id);
        // $query3=$this->db->update('tbt_asset_track', $data_asset_track);

        // $data_untrack = array(
        //     'delete_flag' => 0            
        // );

        // $this->db->where('asset_track_document_id', $id);
        // $query4=$this->db->update('tbt_untracked_asset', $data_untrack);


        if($query1 && $query2 && $query3 && $query4 ){
            return TRUE;
            //return self::response($msg);
        }else{
            return FALSE;
            //return self::response($msg);
        }
    }





    
}//end model

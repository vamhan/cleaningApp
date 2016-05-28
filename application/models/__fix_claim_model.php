<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class __fix_claim_model extends MY_Model{

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


    function _join_table($page,$keyword){    
        
        $this->db->from("(SELECT * FROM tbt_fix_claim WHERE tbt_fix_claim.quotation_id = '".$keyword."' ) as tbt_fix_claim");
        $this->db->join('tbt_action_plan', 'tbt_action_plan.id = tbt_fix_claim.action_plan_id','left');
        $this->db->join('tbt_user', 'tbt_action_plan.actor_id = tbt_user.employee_id','left'); 

        $result = $this->db->get();
        return $result;
    }


  function _search($permission, $position_list, $children, $emp_id){
        //Set up keyword Search                     
        $match = $this->input->post('search');
        $match = iconv('UTF-8','TIS-620',$match);          
           //echo $match;         


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


         ///////////////////////// start : serch ////////////////////////////////

         $config = Array(     
                    "visible_column" => Array
                        (
                            Array
                                (
                                    "name" => "tbt_fix_claim.id"                                   
                                ),
                            Array
                            (
                                "name" => "tbt_fix_claim.material_description"                                   
                            ),
                             Array
                            (
                                "name" => "tbt_fix_claim.material_no"                                   
                            ),
                            Array
                            (
                                "name" => "tbt_fix_claim.delivery_date"                                   
                            ),
                            Array
                            (
                                "name" => "tbt_fix_claim.raise_date"                                   
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

       

           
           //exit();
            $condition_count = 0;
            if(!empty($match)){
                if(!empty($config['visible_column'])){ 
                  foreach ($config['visible_column'] as $key => $value) {
                        if($condition_count++ < 1){                            
                            //$this->db->or_like($value['name'],$match);
                            if(mb_detect_encoding($match)=="UTF-8"){
                                 //echo "utf";
                                    if($value['name']!='tbt_action_plan.actual_date' && $value['name']!='tbt_action_plan.plan_date' && $value['name']!='tbt_fix_claim.raise_date' && $value['name']!='tbt_fix_claim.delivery_date' && $value['name']!='tbt_fix_claim.id' && $value['name']!='tbt_fix_claim.material_no'){
                                        $this->db->or_like($value['name'],$match);
                                    }else{
                                        $this->db->or_like($value['name'],$match);
                                    }
                               }
                        }else{
                           // $this->db->or_like($value['name'],$match);
                            if(mb_detect_encoding($match)=="UTF-8"){
                                 //echo "utf";
                                    if($value['name']!='tbt_action_plan.actual_date' && $value['name']!='tbt_action_plan.plan_date' && $value['name']!='tbt_fix_claim.raise_date' && $value['name']!='tbt_fix_claim.delivery_date' && $value['name']!='tbt_fix_claim.id' && $value['name']!='tbt_fix_claim.material_no'){
                                        $this->db->or_like($value['name'],$match);
                                    }else{
                                        $this->db->or_like($value['name'],$match);
                                    }
                               }
                        }
                  }//end foreach
                }
            }//end if   
        ///////////////////////// end : serch ////////////////////////////////

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


         $table = 'tbt_fix_claim';
         
    
        $this->db->select('tbt_fix_claim.* ,tbt_action_plan.plan_date AS plan_date,tbt_action_plan.actual_date AS actual_date');
        $this->db->select('tbt_action_plan.actor_id');


        $this->_search($permission, $position_list, $children, $emp_id);

        $this->db->order_by("tbt_fix_claim.raise_date", "desc");
        $this->db->order_by("tbt_fix_claim.id", "desc"); 


        $offset = 0;
        $limit = 100;
        $offset = (intval($page)-1)*$this->pageSize;
        $limit = $this->pageSize;

        $this->db->limit($limit, $offset);
        $result = $this->_join_table($page,$keyword);
        $result = $result->result_array();



        $this->db->select('COUNT(*) AS cnt');
        $this->_search($permission, $position_list, $children, $emp_id);

        $query = $this->_join_table($page,$keyword);
        $total_result = $query->row_array();
        $total_item = $total_result['cnt'];

        
            $output = array();
                $state = true;
                $code = '000';
                $msg = '';
                $output['total_item'] = $total_item;
                $output['list'] = $result;
                $output['page'] = $page;
                $output['page_size'] = $this->pageSize;
                $output['quotation_id'] = $keyword; 
                $output['total_page'] = ceil($total_item/$this->pageSize);
        
        return self::response($state,$code,$msg,$output);
    }









    public function getContentList2($page=1,$keyword='',$order=array()){

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

         //$table = 'tbt_asset_track_document';

         $table = 'tbt_fix_claim';
         
    
        $this->db->select('tbt_fix_claim.* ,tbt_action_plan.plan_date AS plan_date,tbt_action_plan.actual_date AS actual_date');
        $this->db->select('tbt_action_plan.actor_id');
        $this->db->join('tbt_action_plan', 'tbt_action_plan.id = tbt_fix_claim.action_plan_id','left');

        if ($permission['shipto']['value'] == 'related') {
            $this->db->join('tbt_user', 'tbt_action_plan.actor_id = tbt_user.employee_id','left'); 
            if (!empty($children)) {
                $children = array_merge($position_list, $children);
                $this->db->join('tbt_user_position', 'tbt_user.employee_id = tbt_user_position.employee_id','left'); 
                $this->db->join('tbm_position', 'tbt_user_position.position_id = tbm_position.id','left');
                $this->db->where_in('tbm_position.id', $children);
            } else {
                $this->db->where('tbt_user.employee_id', $emp_id);
            }
        }          
        //$this->db->where('tbt_fix_claim.delete_flag',0);
        $this->db->where('tbt_fix_claim.quotation_id',$keyword);
        //$this->db->get($table);
        $this->db->order_by("tbt_fix_claim.raise_date", "desc");
        $this->db->order_by("tbt_fix_claim.id", "desc"); 

        ///////////////////////// start : serch ////////////////////////////////

         $config = Array(     
                    "visible_column" => Array
                        (
                            Array
                                (
                                    "name" => "tbt_fix_claim.id"                                   
                                ),
                            Array
                            (
                                "name" => "tbt_fix_claim.material_description"                                   
                            ),
                             Array
                            (
                                "name" => "tbt_fix_claim.material_no"                                   
                            ),
                            Array
                            (
                                "name" => "tbt_fix_claim.delivery_date"                                   
                            ),
                            Array
                            (
                                "name" => "tbt_fix_claim.raise_date"                                   
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
           $match = iconv('UTF-8','TIS-620',$match);          
           //echo $match;         

           
           //exit();
            $condition_count = 0;
            if(!empty($match)){
                if(!empty($config['visible_column'])){ 
                  foreach ($config['visible_column'] as $key => $value) {
                        if($condition_count++ < 1){                            
                            //$this->db->or_like($value['name'],$match);
                            if(mb_detect_encoding($match)=="UTF-8"){
                                 //echo "utf";
                                    if($value['name']!='tbt_action_plan.actual_date' && $value['name']!='tbt_action_plan.plan_date' && $value['name']!='tbt_fix_claim.raise_date' && $value['name']!='tbt_fix_claim.delivery_date' && $value['name']!='tbt_fix_claim.id' && $value['name']!='tbt_fix_claim.material_no'){
                                        $this->db->or_like($value['name'],$match);
                                    }else{
                                        $this->db->or_like($value['name'],$match);
                                    }
                               }
                        }else{
                           // $this->db->or_like($value['name'],$match);
                            if(mb_detect_encoding($match)=="UTF-8"){
                                 //echo "utf";
                                    if($value['name']!='tbt_action_plan.actual_date' && $value['name']!='tbt_action_plan.plan_date' && $value['name']!='tbt_fix_claim.raise_date' && $value['name']!='tbt_fix_claim.delivery_date' && $value['name']!='tbt_fix_claim.id' && $value['name']!='tbt_fix_claim.material_no'){
                                        $this->db->or_like($value['name'],$match);
                                    }else{
                                        $this->db->or_like($value['name'],$match);
                                    }
                               }
                        }
                  }//end foreach
                }
            }//end if   
        ///////////////////////// end : serch ////////////////////////////////


        $result = self::getResultWithPage_fixclaim($table,$page,$keyword);
        
        $count = $result->num_rows();
        $result = $result->result_array();  

        $this->db->select('COUNT(*) AS cnt');
        $this->db->join('tbt_action_plan', 'tbt_action_plan.id = tbt_fix_claim.action_plan_id','left');

        if ($permission['shipto']['value'] == 'related') {
            $this->db->join('tbt_user', 'tbt_action_plan.actor_id = tbt_user.employee_id','left'); 
            if (!empty($children)) {
                $children = array_merge($position_list, $children);
                $this->db->join('tbt_user_position', 'tbt_user.employee_id = tbt_user_position.employee_id','left'); 
                $this->db->join('tbm_position', 'tbt_user_position.position_id = tbm_position.id','left');
                $this->db->where_in('tbm_position.id', $children);
            } else {
                $this->db->where('tbt_user.employee_id', $emp_id);
            }
        }          
        //$this->db->where('tbt_fix_claim.delete_flag',0);
        $this->db->where('tbt_fix_claim.quotation_id',$keyword);
        //$this->db->get($table);
        $this->db->order_by("tbt_fix_claim.raise_date", "desc");
        $this->db->order_by("tbt_fix_claim.id", "desc"); 

        ///////////////////////// start : serch ////////////////////////////////

         $config = Array(     
                    "visible_column" => Array
                        (
                            Array
                                (
                                    "name" => "tbt_fix_claim.id"                                   
                                ),
                            Array
                            (
                                "name" => "tbt_fix_claim.material_description"                                   
                            ),
                             Array
                            (
                                "name" => "tbt_fix_claim.material_no"                                   
                            ),
                            Array
                            (
                                "name" => "tbt_fix_claim.delivery_date"                                   
                            ),
                            Array
                            (
                                "name" => "tbt_fix_claim.raise_date"                                   
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
           $match = iconv('UTF-8','TIS-620',$match);          
           //echo $match;         

           
           //exit();
            $condition_count = 0;
            if(!empty($match)){
                if(!empty($config['visible_column'])){ 
                  foreach ($config['visible_column'] as $key => $value) {
                        if($condition_count++ < 1){                            
                            //$this->db->or_like($value['name'],$match);
                            if(mb_detect_encoding($match)=="UTF-8"){
                                 //echo "utf";
                                    if($value['name']!='tbt_action_plan.actual_date' && $value['name']!='tbt_action_plan.plan_date' && $value['name']!='tbt_fix_claim.raise_date' && $value['name']!='tbt_fix_claim.delivery_date' && $value['name']!='tbt_fix_claim.id' && $value['name']!='tbt_fix_claim.material_no'){
                                        $this->db->or_like($value['name'],$match);
                                    }else{
                                        $this->db->or_like($value['name'],$match);
                                    }
                               }
                        }else{
                           // $this->db->or_like($value['name'],$match);
                            if(mb_detect_encoding($match)=="UTF-8"){
                                 //echo "utf";
                                    if($value['name']!='tbt_action_plan.actual_date' && $value['name']!='tbt_action_plan.plan_date' && $value['name']!='tbt_fix_claim.raise_date' && $value['name']!='tbt_fix_claim.delivery_date' && $value['name']!='tbt_fix_claim.id' && $value['name']!='tbt_fix_claim.material_no'){
                                        $this->db->or_like($value['name'],$match);
                                    }else{
                                        $this->db->or_like($value['name'],$match);
                                    }
                               }
                        }
                  }//end foreach
                }
            }//end if   

        $query = $this->db->get($table);
        $total_result = $query->result_array();
        $total_item = intval($total_result[0]['cnt']);
        
            $output = array();
                $state = true;
                $code = '000';
                $msg = '';
                $output['total_item'] = $total_item;
                $output['list'] = $result;
                $output['page'] = $page;
                $output['page_size'] = $this->pageSize;
                $output['quotation_id'] = $keyword; 
                $output['total_page'] = ceil($total_item/$this->pageSize);
        
        return self::response($state,$code,$msg,$output);
    }


 public function getResultWithPage_fixclaim($tableName,$page,$keyword){
        $offset = 0;
        $items = 100;

        if(intval($page)<1){
            return self::response(false,'909','Invalid page number',array());
        }
        $offset = (intval($page)-1)*$this->pageSize;
        $items = $this->pageSize;

        
       
        $this->db->select('tbt_fix_claim.*');
        //$this->db->join('tbt_action_plan', 'tbt_action_plan.id = tbt_fix_claim.action_plan_id','left'); 
        $this->db->where('tbt_fix_claim.quotation_id',$keyword);
///////////////////////// start : serch ////////////////////////////////
         $config = Array(     
                    "visible_column" => Array
                        (
                            Array
                                (
                                    "name" => "tbt_fix_claim.id"                                   
                                ),
                            Array
                            (
                                "name" => "tbt_fix_claim.material_description"                                   
                            ), 
                            Array
                            (
                                "name" => "tbt_fix_claim.material_no"                                   
                            )                                                                                  
                        )
                );

        //==Set up keyword Search 
            $match = $this->input->post('search');
            $match = iconv('UTF-8','TIS-620',$match);
           //echo $match;  

            $condition_count = 0;
            if(!empty($match)){
                if(!empty($config['visible_column'])){ 
                  foreach ($config['visible_column'] as $key => $value) {
                        if($condition_count++ < 1){
                           $result =  $this->db->or_like($value['name'],$match);
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


     public function getResultTotalpage_fixclaim($tableName,$keyword){//moved

         //echo 'test'.$keyword;
         //exit();

       //$this->db->select('COUNT(*) AS cnt');
       $this->db->select('tbt_fix_claim.* ,tbt_action_plan.plan_date AS plan_date,tbt_action_plan.actual_date AS actual_date');
       $this->db->join('tbt_action_plan', 'tbt_action_plan.id = tbt_fix_claim.action_plan_id','left');        
        //$this->db->where('tbt_fix_claim.delete_flag',0);
        $this->db->where('tbt_fix_claim.quotation_id',$keyword);

        ///////////////////////// start : serch ////////////////////////////////

         $config = Array(     
                    "visible_column" => Array
                        (
                            Array
                                (
                                    "name" => "tbt_fix_claim.id"                                   
                                ),
                            Array
                            (
                                "name" => "tbt_fix_claim.material_description"                                   
                            ),
                             Array
                            (
                                "name" => "tbt_fix_claim.material_no"                                   
                            ),
                            Array
                            (
                                "name" => "tbt_fix_claim.delivery_date"                                   
                            ),
                            Array
                            (
                                "name" => "tbt_fix_claim.raise_date"                                   
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
           $match = iconv('UTF-8','TIS-620',$match);          
           //echo $match;         

           
           //exit();
            $condition_count = 0;
            if(!empty($match)){
                if(!empty($config['visible_column'])){ 
                  foreach ($config['visible_column'] as $key => $value) {
                        if($condition_count++ < 1){                            
                            //$this->db->or_like($value['name'],$match);
                            if(mb_detect_encoding($match)=="UTF-8"){
                                 //echo "utf";
                                    if($value['name']!='tbt_action_plan.actual_date' && $value['name']!='tbt_action_plan.plan_date' && $value['name']!='tbt_fix_claim.raise_date' && $value['name']!='tbt_fix_claim.delivery_date'&& $value['name']!='tbt_fix_claim.id' && $value['name']!='tbt_fix_claim.material_no'){
                                        $this->db->or_like($value['name'],$match);
                                    }else{
                                        $this->db->or_like($value['name'],$match);
                                    }
                               }
                        }else{
                           // $this->db->or_like($value['name'],$match);
                            if(mb_detect_encoding($match)=="UTF-8"){
                                 //echo "utf";
                                    if($value['name']!='tbt_action_plan.actual_date' && $value['name']!='tbt_action_plan.plan_date' && $value['name']!='tbt_fix_claim.raise_date' && $value['name']!='tbt_fix_claim.delivery_date' && $value['name']!='tbt_fix_claim.id' && $value['name']!='tbt_fix_claim.material_no' ){
                                        $this->db->or_like($value['name'],$match);
                                    }else{
                                        $this->db->or_like($value['name'],$match);
                                    }
                               }
                        }
                  }//end foreach
                }
            }//end if   
        ///////////////////////// end : serch ////////////////////////////////


       $result = $this->db->get($tableName);
       $count_item = $result->num_rows();
       $result = $result->result_array();
      
       return $count_item;
       //return intval($result[0]['cnt']);
    }//end function




      public function getContentById($table,$id){      
        
        //TODO :: qery by id
        if(!empty($id))

                 
            $this->db->select('tbt_fix_claim.*');
            $this->db->select('tbt_action_plan.plan_date AS plan_date,tbt_action_plan.actual_date AS actual_date');        
            //$this->db->select('sap_tbt_quotation_asset.asset_description AS ASSET_NAME');
            $this->db->join('tbt_action_plan', 'tbt_action_plan.id = tbt_fix_claim.action_plan_id','left');
            //$this->db->join('sap_tbt_quotation_asset', 'sap_tbt_quotation_asset.asset_no = tbt_fix_claim.project_asset_id','left');        
            //$this->db->where('tbt_fix_claim.delete_flag',0);
            $this->db->where('tbt_fix_claim.id',$id);
       
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


    public function getAsset($ship_to_id){
        
        $this->db->select('zas_date_summary.*');
        $this->db->where('SHIP_TO',$ship_to_id); 
        $result = $this->db->get('zas_date_summary');        

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

    public function getShipto($ship_to_id){
        
        $this->db->select('sap_tbm_ship_to.*');
        $this->db->where('id',$ship_to_id);
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

public function get_previouse_fix_id($asset_no){
        
        // $this->db->select('sap_tbm_ship_to.*');
        // $this->db->where('id',$ship_to_id);
        // //$this->db->where('quotation_id',$quotation_id);  
        // $result = $this->db->get('sap_tbm_ship_to');

       $this->db->select('tbt_fix_claim.material_no,tbt_fix_claim.id');
       $this->db->where('material_no',$asset_no);
       $this->db->where('is_close',1);
       $this->db->order_by("id", "asc"); 
       $result = $this->db->get('tbt_fix_claim');  

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


public function get_previouse_insert_id($asset_no){
       
       $this->db->select('tbt_fix_claim.material_no,tbt_fix_claim.id');
       $this->db->where('material_no',$asset_no);
       $this->db->where('is_close',1);
       $this->db->order_by("tbt_fix_claim.id", "desc"); 
       $result = $this->db->get('tbt_fix_claim');  
       $count = $result->num_rows();

        if($count >0){
            $success = true;
            $result = $result->result_array();
        }else{
            $success = false;
            $result = array($this->db->last_query());
        }
       // return self::response($success,$result);
        return array('success'=>$success,'result'=>$result);
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


//================== insert ========================
    function insert_fixclaim($p,$quotation_id){     

    //TODO : check serial
        // material_no
       $this->db->where('material_no', $p['serial']);
       $this->db->order_by("id", "desc"); 
       $result = $this->db->get('tbt_fix_claim');      
        $count = $result->num_rows();
        $output = array();
        if($count > 0 ){          
            foreach ($result->result_array() as $row){
                //echo 'isclose : '.$row['is_close']; 
                $is_close = $row['is_close'];
                //$status = $row['status'];               
               //$status == 'abort'
               // exit();                
                if($is_close==1){
                     break;
                 }else{
                    $msg = 'ผิดพลาด : ไม่สามารถเปิดแจ้งซ่อม รหัส:'.$p['serial'].' ได้เนื่องจากมีการเปิดการแจ้งซ่อมไปแล้ว';
                    return array('msg'=>$msg);

                 }      
            }//end foreach
        }//end : count

                    $fixclaim_id = 100;
                    $this->db->order_by('id desc');
                    $this->db->limit(1);
                    $query = $this->db->get('tbt_fix_claim');
                    $last_claim = $query->row_array();
                    if (!empty($last_claim)) {
                        $fixclaim_id = intval($last_claim['id'])+1;
                    }

                    $action_plan_id = 400;
                    $this->db->order_by('id desc');
                    $this->db->limit(1);
                    $query = $this->db->get('tbt_action_plan');
                    $last_action_plan = $query->row_array();
                    if (!empty($last_action_plan)) {
                        $action_plan_id = intval($last_action_plan['id'])+1;
                    }

                    $data_action_plan = array(
                        'id' => $action_plan_id,
                        'title' => $p['title'],
                        'event_category_id' => 9,
                        'actor_id' => $p['raise_by_id'],
                        'plan_date' => '',
                        'actual_date' => '',
                        'remark' => $p['remark'],
                        'visitation_reason_id' => 0,
                        'status' => '',
                        'is_holiday' => 0,
                        'clear_job_category_id' => 0,
                        'clear_job_type_id' => 0,
                        'staff' =>0,
                        'total_staff' => 0,
                        'quotation_id' => $quotation_id,
                        'ship_to_id' => $p['ship_to_id'],
                        'sold_to_id' => '',
                        'holiday_id' => 0,                        
                        'delete_flag' => 0,
                        'create_date' => date('Y-m-d'),
                        'object_table' => 'tbt_fix_claim',
                        'object_id' => $fixclaim_id
                    );

                    $query1=$this->db->insert('tbt_action_plan', $data_action_plan);  
                    if($query1){

                        //==  get last Id tbt_asset_track_document ================
                        $query_last_id=$this->db->get('tbt_action_plan');            
                        foreach ($query_last_id->result_array() as $row){               
                           $last_action_plan_id =  $row['id'];
                        }         
                      
                       /// echo '<br>ACCTION  ID:'.$last_action_plan_id;
                      // exit();
                        if(!empty($p['is_require_spare'])){
                            $is_spare = $p['is_require_spare']; 
                        }else{  $is_spare=0;  }

                        if(!empty($p['is_urgent'])){
                            $is_urgent = $p['is_urgent']; 
                        }else{  $is_urgent=0;  }

                         if(!empty($p['is_repair_on_side'])){
                            $is_repair_on_side = $p['is_repair_on_side']; 
                        }else{  $is_repair_on_side=0;  }

                            $data_fixclaim = array(
                                'id' => $fixclaim_id,
                                'title' => $p['title'],
                                'raise_date' => $p['raise_date'],
                                'raise_by_id' => $p['raise_by_id'],
                                'project_owner_id'  => $p['owner_id'],
                                //'owner_id'  => $p['owner_id'],
                                'ship_to_id'  => $p['ship_to_id'],
                                'quotation_id'  => $quotation_id,

                                'material_no'  => $p['serial'],
                                'material_description'  => $p['asset_name'],
                                'contract_id'  => $p['contract_id'],

                                //'project_asset_id'  => $p['serial'],
                                'problem'  => $p['problem'],
                                'remark'  => $p['remark'],
                                'is_urgent'  => $is_urgent,
                                'required_date'  => reDate($p['require_date']),
                                'action_plan_id'  => $last_action_plan_id,
                                'pick_up_date'  =>  '',
                                'delivery_date'  => '',
                                'is_required_spare'  => $is_spare,
                                'previous_fix_claim_id'  =>  $p['previouse_fix_id'],
                                'finish_date'  =>  '',
                                'is_abort'  =>  '',

                                'status' =>  'inprogress',
                                //'is_in_progress' =>  1,                                
                                'is_close'  =>  '0',
                                'close_date'  =>  '',
                                'is_repair_on_side'  =>  $is_repair_on_side,
                                //'accept_delivered_date'  =>  '',
                                //'accept_abort_date'  =>  ''
                                
                            );

                            $query2 =$this->db->insert('tbt_fix_claim', $data_fixclaim);
                            
                            if($query2) {  $msg ='เปิดใบแจ้งซ่อมเรียบร้อยแล้ว';  } else {  $msg ='add fixclaim error'; }                

                    }else{
                        $msg = "add action plan error";
                    }
     

       // return self::response_msg($state,$code,$msg,$output);
        

        return array('msg'=>$msg);
    }



    //========================= Update ================================

    function update_fixclaim($p,$quotation_id){

      //echo "model";

        // if (!array_key_exists('plan_date', $p)) {
        //     $p['plan_date'] = "";
        // }
        if(!empty($p['plan_date'])){
             $plan_date = reDate($p['plan_date']); 
        }else{
            $plan_date = '0000-00-00'; 
        }

        // if (!array_key_exists('finish_date', $p)) {
        //     $p['finish_date'] = "";
        // }
        // $finish_date     = reDate($p['finish_date']);

        if(!empty($p['finish_date'])){
             $finish_date = reDate($p['finish_date']); 
        }else{
            $finish_date = '0000-00-00'; 
        }
                
        // if (!array_key_exists('pick_up_date', $p)) {
        //     $p['pick_up_date'] = "";
        // }
         //$pick_up_date  = reDate($p['pick_up_date']); 

        if(!empty($p['pick_up_date'])){
             $pick_up_date = reDate($p['pick_up_date']); 
        }else{
            $pick_up_date = '0000-00-00'; 
        }
       

        // if (!array_key_exists('delivery_date', $p)) {
        //     $p['delivery_date'] = "";
        // }      
        // $delivery_date   = reDate($p['delivery_date']);

         if(!empty($p['delivery_date'])){
             $delivery_date = reDate($p['delivery_date']); 
        }else{
            $delivery_date = '0000-00-00'; 
        }


        // if (!array_key_exists('require_date', $p)) {
        //     $p['require_date'] = "";
        // }
        // $require_date    = reDate($p['require_date']); 

         if(!empty($p['require_date'])){
             $require_date = reDate($p['require_date']); 
        }else{
            $require_date = '0000-00-00'; 
        }


        if (!array_key_exists('pick_up_date', $p)) {
            $pick_up_date = '0000-00-00'; 
         }
         if (!array_key_exists('delivery_date', $p)) {
            $pick_up_date = '0000-00-00'; 
         }

        // echo  '<br>plan_date: '.$plan_date.'<br>';
        // echo  'finish_date: '.$finish_date.'<br>';
        // echo  'pick_up_date: '.$pick_up_date.'<br>';
        // echo  'delivery_date: '.$delivery_date.'<br>';
        // echo  'requiredate: '.$require_date.'<br>';
        // exit();


       // echo  'check_deliver_date: '.$p['accept_delivered'].'<br>';
       // echo  'check_abort_datemodel: '.$p['accept_task_abort'].'<br>';

        //exit();

      // is close
        $close_date = '0000-00-00';


      if( $p['accept_task_abort']!='0000-00-00' || $p['accept_delivered']!='0000-00-00'){
        $is_close = 1;
        //$is_in_progress = 0;
            if( $p['accept_task_abort']!='0000-00-00'){
                $status = 'abort';
                $close_date = $p['accept_task_abort'];
            }else{
                $status = 'accept';
                $close_date = $p['accept_delivered'];
            }
        //echo "test is 1";

      }else{
        $is_close = 0;
        //$is_in_progress = 1;
        $status = 'inprogress';
        $close_date = '0000-00-00';
        //echo "test is 0";
      }

      //=======start : update stauts to assetrack =====
      if($is_close == 1){
        $result_assetrack = false;  
        $query_assetrack =false;
        $query_doc_assetrack =false;

           $this->db->join('tbt_asset_track_document', 'tbt_asset_track_document.id = tbt_asset_track.asset_track_document_id','left');  
           $this->db->where('tbt_asset_track_document.submit_date_sap',null);
           $this->db->where('tbt_asset_track.asset_no',$p['serial']);  
           $result_assetrack = $this->db->get('tbt_asset_track'); 
            foreach ($result_assetrack->result_array() as $row){
                 
                $data_assetrack = array(
                    'status_tracking' => 'UNCHECK'
                );

                $query_assetrack = $this->db->where('asset_no', $row['asset_no']);
                $query_assetrack = $this->db->update('tbt_asset_track', $data_assetrack);

                $data_doc_assetrack = array(
                   
                    'status_asset_track_document' => 'warning'

                );
                $query_doc_assetrack = $this->db->where('id', $row['asset_track_document_id']);
                $query_doc_assetrack = $this->db->where('actor_by_id', '');
                $query_doc_assetrack = $this->db->update('tbt_asset_track_document',$data_doc_assetrack);

                //echo  "update";
            }    
      }
      //===============================================

       // exit();

        //==== update to tbt_action_plan
         if (!array_key_exists('title', $p)) {
            $p['title'] = '';
         }
         if (!array_key_exists('raise_by_id', $p)) {
            $p['raise_by_id'] = '';
         }
         if (!array_key_exists('remark', $p)) {
            $p['remark'] = '';
         }
         if (!array_key_exists('ship_to_id', $p)) {
            $p['ship_to_id'] = '';
         }

         $this->db->where('id', $quotation_id);
         $query = $this->db->get('tbt_quotation');
         $project = $query->row_array();

         $data1 = array(
            'title' => $p['title'],
            'event_category_id' => 9,
            // 'actor_id' => $p['raise_by_id'],
            'plan_date' =>  $plan_date,
            'actual_date' =>  $finish_date,
            'remark' => $p['remark'],                              
            'quotation_id' => $quotation_id,                     
            'contract_id' => $project['contract_id'],
            'ship_to_id' => $p['ship_to_id'],                      
        );

        $this->db->where('id', $p['action_plan_id']);
        $query1 =$this->db->update('tbt_action_plan', $data1);


        //======update to tbt_fix_claim
         if (!array_key_exists('owner_id', $p)) {
            $p['owner_id'] = '';
         }
         if (!array_key_exists('serial', $p)) {
            $p['serial'] = '';
         }
         if (!array_key_exists('problem', $p)) {
            $p['problem'] = '';
         }
         if (!array_key_exists('remark', $p)) {
            $p['remark'] = '';
         }
         if (!array_key_exists('is_urgent', $p)) {
            $p['is_urgent'] = '';
         }
         if (!array_key_exists('is_require_spare', $p)) {
            $p['is_require_spare'] = '';
         }

         if (!array_key_exists('is_repair_on_side', $p)) {
            $p['is_repair_on_side'] = '';
         }

         if (!array_key_exists('previouse_fix_id', $p)) {
            $p['previouse_fix_id'] = '';
         }
         if (!array_key_exists('is_abort', $p)) {
            $p['is_abort'] = '';
         }
         if (!array_key_exists('accept_delivered', $p)) {
            $p['accept_delivered'] = '';
         }
         if (!array_key_exists('accept_task_abort', $p)) {
            $p['accept_task_abort'] = '';
         }
         if (!array_key_exists('fixclaim_id', $p)) {
            $p['fixclaim_id'] = '';
         }
         //check abort
         // if($p['is_abort']==1){
         //    $status = 'abort';
         // }

       // echo   "titile :". $p['title'];
       // exit();
         $data2 = array(
            'title' => $p['title'],
            //'raise_date' => $p['raise_date'],
            // 'raise_by_id'   => $p['raise_by_id'],
            // 'project_owner_id' => $p['owner_id'],
            'ship_to_id'    => $p['ship_to_id'],
            //'quotation_id'  => $quotation_id,
            'material_no'  => $p['serial'],
            'material_description'  => $p['asset_name'],

            //'project_asset_id'  => $p['serial'],
            'problem'      => $p['problem'],
            'remark'        => $p['remark'],
            'is_urgent'     => $p['is_urgent'],
            'required_date'  =>  $require_date ,
            //'action_plan_id'  => $last_action_plan_id,
            'pick_up_date'  =>  $pick_up_date,
            'delivery_date' =>  $delivery_date ,
            'is_required_spare'       =>  $p['is_require_spare'],
            'previous_fix_claim_id'  =>  $p['previouse_fix_id'],
            'finish_date'   => $finish_date,
            'is_abort'      =>  $p['is_abort'],
            
            'status' =>  $status,

            //'is_in_progress' =>  $is_in_progress,
            'is_close'      =>  $is_close,
            //'accept_delivered_date' =>  $p['accept_delivered'],
            //'accept_abort_date'     =>  $p['accept_task_abort'], 
            'close_date'     =>  $close_date,   
            'is_repair_on_side'     =>  $p['is_repair_on_side'],           
        );

        $this->db->where('id', $p['fixclaim_id']);
        $query2 =$this->db->update('tbt_fix_claim', $data2);
         

         if($query1 && $query2) {
            $msg ='แก้ไขการแจ้งซ่อมเรียบร้อยแล้ว';
           return array('msg'=>$msg);
        }else{
            $msg ='update error';
           return array('msg'=>$msg);
        }
    }


    //===================== DELETE =================================

    public function delete($id,$actionplan_id){
        //echo "model test delete";

        $this->db->where('id',$actionplan_id);
        $query1 = $this->db->delete('tbt_action_plan');

        $this->db->where('id',$id);
        $query2 = $this->db->delete('tbt_fix_claim');

        // $data1 = array(
        //     'delete_flag' => 0            
        // );
        // $this->db->where('id', $actionplan_id);
        // $query1=$this->db->update('tbt_action_plan', $data1);

         // $data2 = array(
        //     'delete_flag' => 0            
        // );
        // $this->db->where('id', $id);
        // $query2=$this->db->update('tbt_fix_claim', $data2);           

       
        if($query1 && $query2){
            return TRUE;
            //return self::response($msg);
        }else{
            return FALSE;
            //return self::response($msg);
        }
    }



     private function response_msg($state,$code,$msg,$output){
        return array('state'=>$state,'code'=>$code,'msg'=>$msg,'output'=>$output);
    }


    
}//end model


<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class __quotation_model extends MY_Model{

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

    public function getContentList($page=1,$tempMatch='',$order=array()){
        $emp_id = $this->session->userdata('id');
        $position_list = $this->session->userdata('position');

        $children = array();
        foreach ($position_list as $key => $position) {
            $children = $this->getPositionChild($children, $position);
        }

        $permission = $this->permission[$this->cat_id];
        $table = 'tbt_quotation';
           
        $this->db->distinct('tbt_quotation.*, tbt_user.user_firstname ,tbt_user.user_lastname'); 
        $this->db->select('tbt_quotation.*, tbt_user.user_firstname ,tbt_user.user_lastname'); 
        $this->db->join('tbt_user', 'tbt_user.employee_id = tbt_quotation.project_owner_id');  
        $this->db->join('tbt_user_position', 'tbt_user.employee_id = tbt_user_position.employee_id'); 
        $this->db->join('tbm_position', 'tbt_user_position.position_id = tbm_position.id');      
        if ($permission['shipto']['value'] == 'related') {
            if (!empty($children)) {
                $children = array_merge($position_list, $children);
                //$this->db->where_in('tbm_position.id', $children);
                $children = implode("','", $children);
                $this->db->where("(tbt_user.employee_id in (select employee_id from tbm_position p LEFT JOIN tbt_user_position up ON up.position_id = p.id where id in ('".$children."')))");
            } else {
                $this->db->where('project_owner_id', $emp_id);
            }
        }
        $this->db->order_by("tbt_quotation.create_date", "desc"); 

        $config = Array(     
                    "visible_column" => Array
                        (
                            Array
                                (
                                    "name" => "tbt_quotation.id"                                   
                                ), 
                            Array
                            (
                                "name" => "tbt_quotation.title"                                   
                            ),                                                                                      
                        )
                );

        if(empty($tempMatch)){
         $match = $this->input->post('search');
        }else{
         $match = $tempMatch;
        }
        $condition_count = 0;
        if(!empty($match)){
            if(!empty($config['visible_column'])){ 
                $strsearch = '';
              foreach ($config['visible_column'] as $key => $value) {
                    // if($condition_count++ < 1){
                    //     $this->db->like($value['name'],$match);
                    // }else{
                    //     $this->db->or_like($value['name'],$match);
                    // }
                $strsearch.= " OR ". $value['name']." LIKE '%".$match."%'";
              }//end foreach
            }
            $strsearch = substr($strsearch, 3);
            $this->db->where("( ".$strsearch." )");
        }//end if   
        
        

        $result = self::getResultWithPage($table,$page);        
        $count = $result->num_rows();
        $result = $result->result_array();

        $this->db->select('COUNT(*) AS cnt');
        $this->db->join('tbt_user', 'tbt_user.employee_id = tbt_quotation.project_owner_id');   
        $this->db->join('tbt_user_position', 'tbt_user.employee_id = tbt_user_position.employee_id'); 
        $this->db->join('tbm_position', 'tbt_user_position.position_id = tbm_position.id');     
        if ($permission['shipto']['value'] == 'related') {
            if (!empty($children)) {
                $children = array_merge($position_list, $children);
                $children = implode("','", $children);
                $this->db->where("(tbt_user.employee_id in (select employee_id from tbm_position p LEFT JOIN tbt_user_position up ON up.position_id = p.id where id in ('".$children."')))");
                //$this->db->where_in('tbm_position.id', $children);
            } else {
                $this->db->where('project_owner_id', $emp_id);
            }
        }
        $this->db->order_by("tbt_quotation.create_date", "desc"); 

        $config = Array(     
                    "visible_column" => Array
                        (
                            Array
                                (
                                    "name" => "tbt_quotation.id"                                   
                                ), 
                            Array
                            (
                                "name" => "tbt_quotation.title"                                   
                            ),                                                                                      
                        )
                );

       if(empty($tempMatch)){
         $match = $this->input->post('search');
        }else{
         $match = $tempMatch;
        }
        $condition_count = 0;
        if(!empty($match)){
            if(!empty($config['visible_column'])){ 
                 $strsearch = '';
              foreach ($config['visible_column'] as $key => $value) {
                    // if($condition_count++ < 1){
                    //     $this->db->like($value['name'],$match);
                    // }else{
                    //     $this->db->or_like($value['name'],$match);
                    // }
                 $strsearch.= " OR ". $value['name']." LIKE '%".$match."%'";
              }//end foreach
            }
            $strsearch = substr($strsearch, 3);
            $this->db->where("( ".$strsearch." )"); 
        }//end if 
         

        $query = $this->db->get($table);
        $total_result = $query->result_array();
        $total_item = intval($total_result[0]['cnt']);

        $output = array();
        $state = true;
        $code = '000';
        $msg = '';
        $output['temp_match'] = $match;
        $output['total_item'] = $total_item;
        $output['list'] = $result;
        $output['page'] = $page;
        $output['page_size'] = $this->pageSize;
        $output['project_id'] = '';              
        $output['total_page'] = ceil($total_item/$this->pageSize);   

        return self::response($state,$code,$msg,$output);
    }

    
    public function getContentList_prospect($page=1,$tempMatch='',$order=array()){


        $actor_by_id = $this->session->userdata('id');
        $distribution_channel = $this->session->userdata('distribution_channel');
        $permission = $this->permission[$this->cat_id];

        $table = 'tbt_prospect';           
        $this->db->select('tbt_prospect.*'); 
        $this->db->select('tbt_user.user_firstname ,tbt_user.user_lastname'); 
        $this->db->join('tbt_user', 'tbt_user.employee_id = tbt_prospect.project_owner_id','left');
        $this->db->where('tbt_prospect.delete_flag',0);
        // $this->db->where('tbt_prospect.project_owner_id',$actor_by_id);

        if ($permission['shipto']['value'] == 'related') {
            $this->db->where_in('tbt_prospect.distribution_channel',$distribution_channel);
        }            
        //$this->db->get($table);
        $this->db->order_by("tbt_prospect.create_date", "desc"); 

        ///////////////////////// start : serch ////////////////////////////////
         $config = Array(     
                    "visible_column" => Array
                        (
                            Array
                                (
                                    "name" => "tbt_prospect.id"                                   
                                ),
                            Array
                            (
                                "name" => "tbt_prospect.title"                                   
                            ),                                                                                           
                        )
                );

        //==Set up keyword Search 
        if($page==1){
         $match = $this->input->post('search');
        }else{
         $match = $tempMatch;
        }
            $condition_count = 0;
            if(!empty($match)){
            if(!empty($config['visible_column'])){ 
                $strsearch = '';
              foreach ($config['visible_column'] as $key => $value) {
                    // if($condition_count++ < 1){
                    //     $this->db->like($value['name'],$match);
                    // }else{
                    //     $this->db->or_like($value['name'],$match);
                    // }
                $strsearch.= " OR ". $value['name']." LIKE '%".$match."%'";
              }//end foreach
            }
            $strsearch = substr($strsearch, 3);
            $this->db->where("( ".$strsearch." )");
        }//end if    



        ///////////////////////// end : serch ////////////////////////////////

        $result = self::getResultWithPage($table,$page);
        //$result = self::getResultWithPage_document($table,$page,$keyword);
        
        $count = $result->num_rows();
        $result = $result->result_array();

        $this->db->select('COUNT(*) AS cnt');
        $this->db->join('tbt_user', 'tbt_user.employee_id = tbt_prospect.project_owner_id','left');
        $this->db->where('tbt_prospect.delete_flag',0);
        // $this->db->where('tbt_prospect.project_owner_id',$actor_by_id);

        if ($permission['shipto']['value'] == 'related') {
            $this->db->where_in('tbt_prospect.distribution_channel',$distribution_channel);
        }            
        //$this->db->get($table);
        $this->db->order_by("tbt_prospect.create_date", "desc"); 

        ///////////////////////// start : serch ////////////////////////////////
         $config = Array(     
                    "visible_column" => Array
                        (
                            Array
                                (
                                    "name" => "tbt_prospect.id"                                   
                                ),
                            Array
                            (
                                "name" => "tbt_prospect.title"                                   
                            ),                                                                                           
                        )
                );

        //==Set up keyword Search 
        if($page==1){
         $match = $this->input->post('search');
        }else{
         $match = $tempMatch;
        }
            $condition_count = 0;
            if(!empty($match)){
            if(!empty($config['visible_column'])){ 
                $strsearch = '';
              foreach ($config['visible_column'] as $key => $value) {
                    // if($condition_count++ < 1){
                    //     $this->db->like($value['name'],$match);
                    // }else{
                    //     $this->db->or_like($value['name'],$match);
                    // }
                $strsearch.= " OR ". $value['name']." LIKE '%".$match."%'";
              }//end foreach
            }
            $strsearch = substr($strsearch, 3);
            $this->db->where("( ".$strsearch." )");
        }//end if      

        $query = $this->db->get($table);
        $total_result = $query->result_array();
        $total_item = intval($total_result[0]['cnt']);        
        
        $output = array();
            $state = true;
            $code = '000';
            $msg = '';

           // $output['total_item'] = self::getResultTotalpage_doucument($table,$keyword);
            $output['temp_match'] = $match;
            $output['total_item'] = $total_item;
            $output['list'] = $result;
            $output['page'] = $page;
            $output['page_size'] = $this->pageSize;
            $output['project_id'] = '';              
            //$output['total_page'] = ceil(self::getResultTotalpage_doucument($table,$keyword)/$this->pageSize);
            $output['total_page'] = ceil($output['total_item']/$this->pageSize);   

        return self::response($state,$code,$msg,$output);
    }

//========================================
//============= get sap tbm ==============
//========================================

    public function bapi_contact_title(){
        
        $this->db->select('sap_tbm_contact_title.*');
        //$this->db->where('sap_tbm_contact_title.mat_type','Z001'); 
        $this->db->order_by("sap_tbm_contact_title.title", "asc"); 
        $result = $this->db->get('sap_tbm_contact_title');      

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


    public function bapi_chemical_Z001(){
        
        $this->db->select('sap_tbm_material.material_no,sap_tbm_material.material_description');
        $this->db->select('sap_tbm_mat_price.price');  
        $this->db->join('sap_tbm_mat_price', 'sap_tbm_mat_price.material_no = sap_tbm_material.material_no','left');
        $this->db->where('sap_tbm_mat_price.valid_from <=',date("Y-m-d"));
        $this->db->where('sap_tbm_mat_price.valid_to >=',date("Y-m-d"));  

        $this->db->where('sap_tbm_material.mat_type','Z001');    
        
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


    public function bapi_chemical_Z013(){
        
        $this->db->select('sap_tbm_material.material_no,sap_tbm_material.material_description');  
       
        $this->db->select('sap_tbm_mat_price.price');  
        $this->db->join('sap_tbm_mat_price', 'sap_tbm_mat_price.material_no = sap_tbm_material.material_no','left');
        $this->db->where('sap_tbm_mat_price.valid_from <=',date("Y-m-d"));
        $this->db->where('sap_tbm_mat_price.valid_to >=',date("Y-m-d"));  

        $this->db->where('sap_tbm_material.mat_type','Z013');    
        
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

    public function bapi_machine(){
        
        $this->db->select('sap_tbm_material.material_no,sap_tbm_material.material_description');        
        $this->db->where('sap_tbm_material.mat_type','Z005');    
        
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

     public function bapi_tool_Z002(){
        
        $this->db->select('sap_tbm_material.material_no,sap_tbm_material.material_description');   
        $this->db->select('sap_tbm_mat_price.price');  
        $this->db->join('sap_tbm_mat_price', 'sap_tbm_mat_price.material_no = sap_tbm_material.material_no','left');
        $this->db->where('sap_tbm_mat_price.valid_from <=',date("Y-m-d"));
        $this->db->where('sap_tbm_mat_price.valid_to >=',date("Y-m-d"));  


        $this->db->where('sap_tbm_material.mat_type','Z002');    
        
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


     public function bapi_tool_Z014(){
        
        $this->db->select('sap_tbm_material.material_no,sap_tbm_material.material_description');
        $this->db->select('sap_tbm_mat_price.price');  
        $this->db->join('sap_tbm_mat_price', 'sap_tbm_mat_price.material_no = sap_tbm_material.material_no','left');
        $this->db->where('sap_tbm_mat_price.valid_from <=',date("Y-m-d"));
        $this->db->where('sap_tbm_mat_price.valid_to >=',date("Y-m-d"));  


        $this->db->where('sap_tbm_material.mat_type','Z014');    
        
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


     public function bapi_texture(){
        
        $this->db->select('sap_tbm_material.material_no,sap_tbm_material.material_description');
        $this->db->select('sap_tbm_clear_map.texture_id,sap_tbm_clear_map.clear_type_id,sap_tbm_clear_map.clear_type_des');
        $this->db->join('sap_tbm_clear_map', 'sap_tbm_clear_map.texture_id = sap_tbm_material.material_no','left');
        
        $this->db->where('sap_tbm_material.mat_type','Z016');    
        
        $this->db->order_by("sap_tbm_material.material_description", "asc"); 
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


    
     public function sap_tbm_industry_room(){
        
        $this->db->select('sap_tbm_industry_room.id,sap_tbm_industry_room.title,sap_tbm_industry_room.industry_id');
        $this->db->order_by("sap_tbm_industry_room.title", "asc");      
        $result = $this->db->get('sap_tbm_industry_room');      

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


     public function sap_tbm_position($ship_to_id){
        
        $this->db->select('sap_tbm_position.id,sap_tbm_position.title, sap_tbm_position.level, sap_tbm_position_price.price'); 
        $this->db->join('sap_tbm_position_price', 'sap_tbm_position.id = sap_tbm_position_price.position_id and sap_tbm_position_price.ship_to_id = "'.$ship_to_id.'"', 'left');
        // $this->db->where('sap_tbm_position_price.ship_to_id', $ship_to_id);
        $result = $this->db->get('sap_tbm_position');      //sap_tbm_position

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

    public function sap_tbm_employee_level(){
        
        $this->db->select('sap_tbm_employee_level.id,sap_tbm_employee_level.description');      
        $result = $this->db->get('sap_tbm_employee_level');      

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

    // get uniform to man sub group
     public function get_uniform(){
        
        $this->db->select('sap_tbm_material.material_no,sap_tbm_material.material_description');      
        $this->db->where('sap_tbm_material.mat_type','Z006');  
        //$this->db->where('sap_tbm_material.mat_group ','0699');  
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


     public function sap_tbm_other(){
        
        // $this->db->select('sap_tbm_other.id,sap_tbm_other.description');      
        // $result = $this->db->get('sap_tbm_other'); 

        $this->db->select('sap_tbm_material.material_no,sap_tbm_material.material_description');      
        $this->db->where('sap_tbm_material.mat_type','Z012');  
        //$this->db->where('sap_tbm_material.mat_group ','0699');  
        $this->db->where('sap_tbm_material.mat_group <=','1298');
        $this->db->where('sap_tbm_material.mat_group >=','1290');   
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





    public function sap_tbm_ship_to(){
        
        $this->db->select('sap_tbm_ship_to.*,sap_tbm_ship_to.id As ship_to_id');      
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
    

     public function sap_tbm_sold_to(){
        
        $emp_id = $this->session->userdata('id');
        $this->db->distinct('sap_tbm_sold_to.id');
        $this->db->select('sap_tbm_sold_to.*,sap_tbm_sold_to.id As sold_to_id');  
        $this->db->join('sap_tbm_ship_to', 'sap_tbm_ship_to.sold_to_id = sap_tbm_sold_to.id');  
        $this->db->join('tbt_user_customer', 'tbt_user_customer.ship_to_id = sap_tbm_ship_to.id', 'left'); 
        $this->db->join('tbt_user UC', 'tbt_user_customer.user_id = UC.user_id', 'left');
        $this->db->where('UC.employee_id', $emp_id);  
        $result = $this->db->get('sap_tbm_sold_to');      

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

     public function sap_tbm_sold_to_byID($id){
        
        $this->db->select('sap_tbm_sold_to.*,sap_tbm_sold_to.id As sold_to_id');  
        $this->db->where('sap_tbm_sold_to.id',$id);     
        $result = $this->db->get('sap_tbm_sold_to');      

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

    public function sap_tbm_sold_to_byID_disb($id,$dis){
        
        $this->db->select('sap_tbm_sold_to.*,sap_tbm_sold_to.id As sold_to_id');  
        $this->db->where('sap_tbm_sold_to.id',$id);
        $this->db->where('sap_tbm_sold_to.sold_to_distribution_channel',$dis);     
        $result = $this->db->get('sap_tbm_sold_to');      

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


    public function sap_tbm_competitor(){
        
        $this->db->select('sap_tbm_competitor.competitor_id,sap_tbm_competitor.competitor_name');      
        $result = $this->db->get('sap_tbm_competitor');      

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

//=================  get other_service  ===============
    public function get_other_service(){
        
        $this->db->select('sap_tbm_material.material_no,sap_tbm_material.material_description,sap_tbm_material.unit_code');
        $this->db->select('sap_tbm_mat_price.price');
        $this->db->join('sap_tbm_mat_price', 'sap_tbm_mat_price.material_no = sap_tbm_material.material_no','left');

        $this->db->where('sap_tbm_material.mat_type','Z012');
        $this->db->where('sap_tbm_material.mat_group','1299'); //1299 //1208
       
        $this->db->where('sap_tbm_mat_price.valid_from <=',date("Y-m-d"));
        $this->db->where('sap_tbm_mat_price.valid_to >=',date("Y-m-d"));   


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

     public function get_other_service_Byqt_id($quotation_id){
        
        $this->db->select('tbt_other_service.*');        
        $this->db->select('sap_tbm_material.material_description As other_service_title');         
        $this->db->join('sap_tbm_material', 'sap_tbm_material.material_no = tbt_other_service.other_service_id','left');

        $this->db->where('tbt_other_service.quotation_id',$quotation_id);       
        $result = $this->db->get('tbt_other_service');      

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


//========================================

    public function get_area_clearing($frequency,$qt_id){       

        $this->db->select('tbt_area.* ,tbt_area.title As area_title, tbt_area.id As area_id');
        $this->db->select('sap_tbm_clear_type.description as clearing_des');
        $this->db->join('sap_tbm_clear_type', 'sap_tbm_clear_type.id = tbt_area.clear_job_type_id','left');
        
        $this->db->where('tbt_area.quotation_id',$qt_id); 
        $this->db->where('tbt_area.frequency',$frequency); 
        $result = $this->db->get('tbt_area');

        // $this->db->select('tbt_area.* ,tbt_area.title As area_title, tbt_area.id As area_id'); 
        // $this->db->select('tbt_building.* ,tbt_building.title As building_title, tbt_building.id As building_id');
        // $this->db->select('tbt_floor.* ,tbt_floor.title As floor_title, tbt_floor.id As floor_id'); 
        // $this->db->join('tbt_building', 'tbt_building.id = tbt_area.building_id','left');
        // $this->db->join('tbt_floor', 'tbt_floor.id = tbt_area.floor_id','left');        
        // $this->db->where('tbt_area.quotation_id',$quotation_id); 
        // $result = $this->db->get('tbt_area');          
        
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




        public function get_prospect(){

        $actor_by_id = $this->session->userdata('id');
        
        $this->db->select('tbt_prospect.id,tbt_prospect.title,tbt_prospect.distribution_channel');        
        $this->db->where('tbt_prospect.delete_flag',0);
        $this->db->where('tbt_prospect.project_owner_id',$actor_by_id);  
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


     public function get_required_doc(){
        
        $this->db->select('tbm_required_document.*');        
        $result = $this->db->get('tbm_required_document');
       

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


    

    public function get_texture_by_id_ajax($id){       

        $this->db->select('sap_tbm_material.material_no,sap_tbm_material.material_description');
        $this->db->select('sap_tbm_clear_map.texture_id,sap_tbm_clear_map.clear_type_id,sap_tbm_clear_map.clear_type_des');
        $this->db->join('sap_tbm_clear_map', 'sap_tbm_clear_map.texture_id = sap_tbm_material.material_no','left');

        $this->db->where('sap_tbm_material.mat_type','Z016'); 
        $this->db->where('sap_tbm_material.material_no',$id);        
        $result = $this->db->get('sap_tbm_material');         
        
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


    public function get_ajax_sap_tbm_mat_group($group_machines,$job_type){   
        
        //set if jobtype = ZQT3 is ZQT2  
        // if($job_type=='ZQT3'){
        //     $job_type = 'ZQT2';
        // }  

        $this->db->select('sap_tbm_material.material_no,sap_tbm_material.material_description');
        $this->db->select('sap_tbm_mat_price.price');

        $this->db->join('sap_tbm_mat_price', 'sap_tbm_mat_price.material_no = sap_tbm_material.material_no','left');
        
        $this->db->where('sap_tbm_material.mat_type','Z005'); 
        $this->db->where('sap_tbm_material.mat_group',$group_machines);


        $this->db->where('sap_tbm_mat_price.doc_type',$job_type);

        $this->db->where('sap_tbm_mat_price.valid_from <=',date("Y-m-d"));
        $this->db->where('sap_tbm_mat_price.valid_to >=',date("Y-m-d")); 

        $result = $this->db->get('sap_tbm_material');          
        
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

   

      public function get_ajax_uniform($id){       

        $this->db->select('sap_tbm_material.*');
        $this->db->where('sap_tbm_material.mat_type','Z006');  
        $this->db->where('sap_tbm_material.mat_group',$id);       
        $result = $this->db->get('sap_tbm_material');          
        
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

     public function get_ajax_position($id, $ship_to_id){       

        $this->db->select('sap_tbm_position.*, sap_tbm_position_price.price');
        $this->db->join('sap_tbm_position_price', 'sap_tbm_position.id = sap_tbm_position_price.position_id and sap_tbm_position_price.ship_to_id = "'.$ship_to_id.'"', 'left');
        $this->db->where('sap_tbm_position.level',$id);    
        $result = $this->db->get('sap_tbm_position');          
        
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



    public function get_industry_room_by_id_ajax($id){       

        $this->db->select('sap_tbm_industry_room.id,sap_tbm_industry_room.title');
        $this->db->where('sap_tbm_industry_room.id',$id);       
        $result = $this->db->get('sap_tbm_industry_room');          
        
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


     public function get_ohter_serviceByid_ajax($id){
           

        $this->db->select('sap_tbm_material.material_no,sap_tbm_material.material_description,sap_tbm_material.unit_code');
        $this->db->select('sap_tbm_mat_price.price');
        $this->db->join('sap_tbm_mat_price', 'sap_tbm_mat_price.material_no = sap_tbm_material.material_no','left');
        
        //sap_tbm_mat_price.valid_from  sap_tbm_mat_price.valid_to 

        // $this->db->where('sap_tbm_material.mat_group','1208'); 
        // $this->db->where('sap_tbm_material.mat_type','Z012');

        // $this->db->where('(sap_tbm_mat_price.valid_from >=', date("Y-m-d H:i:s"), FALSE);
        // $this->db->where('(sap_tbm_mat_price.valid_to <=', date("Y-m-d H:i:s"), FALSE);
        $this->db->where('sap_tbm_mat_price.valid_from <=',date("Y-m-d"));
        $this->db->where('sap_tbm_mat_price.valid_to >=',date("Y-m-d"));  
        $this->db->where('sap_tbm_material.material_no',$id);  
        $result = $this->db->get('sap_tbm_material'); 

        
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


      public function get_sap_region_Byid_ajax($id){
        
        $this->db->select('sap_tbm_region.*');
        // $this->db->where('sap_tbm_region.country_id',$id);       
        $result = $this->db->get('sap_tbm_region');          
        
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


    
    public function get_prospectByid_ajax($id){
       
        $this->db->select('tbt_prospect.*');  
        $this->db->select('sap_tbm_country.title AS sold_to_country_title'); 
        $this->db->select('sap_tbm_region.title AS sold_to_region_title'); 
        $this->db->select('sap_tbm_industry.title AS sold_to_industry_title');  
        $this->db->select('sap_tbm_business_scale.title AS sold_to_business_scale_title');         
        $this->db->join('sap_tbm_country', 'sap_tbm_country.id = tbt_prospect.sold_to_country','left');
        $this->db->join('sap_tbm_region', 'sap_tbm_region.id = tbt_prospect.sold_to_region','left');
        $this->db->join('sap_tbm_industry', 'sap_tbm_industry.id = tbt_prospect.sold_to_industry','left');
        $this->db->join('sap_tbm_business_scale', 'sap_tbm_business_scale.id = tbt_prospect.sold_to_business_scale','left');

        $this->db->where('tbt_prospect.id',$id); 
        $result = $this->db->get('tbt_prospect');
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


     public function get_sold_to_Byid_ajax($id){
        
        $this->db->select('sap_tbm_sold_to.*,sap_tbm_sold_to.id As sold_to_id');  

        $this->db->select('sap_tbm_country.title AS sold_to_country_title'); 
        $this->db->select('sap_tbm_region.title AS sold_to_region_title'); 
        $this->db->select('sap_tbm_industry.title AS sold_to_industry_title');  
        $this->db->select('sap_tbm_business_scale.title AS sold_to_business_scale_title');   

        $this->db->join('sap_tbm_country', 'sap_tbm_country.id = sap_tbm_sold_to.sold_to_country','left');
        $this->db->join('sap_tbm_region', 'sap_tbm_region.id = sap_tbm_sold_to.sold_to_region','left');
        $this->db->join('sap_tbm_industry', 'sap_tbm_industry.id = sap_tbm_sold_to.sold_to_industry','left');
        $this->db->join('sap_tbm_business_scale', 'sap_tbm_business_scale.id = sap_tbm_sold_to.sold_to_business_scale','left');


        $this->db->where('sap_tbm_sold_to.id',$id);     
        $result = $this->db->get('sap_tbm_sold_to');            
        
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


    public function get_ship_to_Byid_ajax($id){
        
        $this->db->select('sap_tbm_ship_to.*,sap_tbm_ship_to.id As ship_to_id');  

        $this->db->select('sap_tbm_country.title AS ship_to_country_title'); 
        $this->db->select('sap_tbm_region.title AS ship_to_region_title'); 
        $this->db->select('sap_tbm_industry.title AS ship_to_industry_title');  
        $this->db->select('sap_tbm_business_scale.title AS ship_to_business_scale_title');   

        $this->db->join('sap_tbm_country', 'sap_tbm_country.id = sap_tbm_ship_to.ship_to_country','left');
        $this->db->join('sap_tbm_region', 'sap_tbm_region.id = sap_tbm_ship_to.ship_to_region','left');
        $this->db->join('sap_tbm_industry', 'sap_tbm_industry.id = sap_tbm_ship_to.ship_to_industry','left');
        $this->db->join('sap_tbm_business_scale', 'sap_tbm_business_scale.id = sap_tbm_ship_to.ship_to_business_scale','left');


        $this->db->where('sap_tbm_ship_to.id',$id);     
        $result = $this->db->get('sap_tbm_ship_to');            
        
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



    public function get_ship_to_Byid_ajax_reset($id,$type,$distribution_channel){

       if($type=='Z10'){
             $type_2='Z20';
        }else if($type=='Z11'){
            $type_2='Z21';
        }else if($type=='Z12'){
            $type_2='Z22';
        }else{
             $type_2='Z26';
        }

        
        $this->db->select('sap_tbm_ship_to.*,sap_tbm_ship_to.id As ship_to_id');  

        $this->db->select('sap_tbm_country.title AS ship_to_country_title'); 
        $this->db->select('sap_tbm_region.title AS ship_to_region_title'); 
        $this->db->select('sap_tbm_industry.title AS ship_to_industry_title');  
        $this->db->select('sap_tbm_business_scale.title AS ship_to_business_scale_title');   

        $this->db->join('sap_tbm_country', 'sap_tbm_country.id = sap_tbm_ship_to.ship_to_country','left');
        $this->db->join('sap_tbm_region', 'sap_tbm_region.id = sap_tbm_ship_to.ship_to_region','left');
        $this->db->join('sap_tbm_industry', 'sap_tbm_industry.id = sap_tbm_ship_to.ship_to_industry','left');
        $this->db->join('sap_tbm_business_scale', 'sap_tbm_business_scale.id = sap_tbm_ship_to.ship_to_business_scale','left');       
             
        $this->db->where('sap_tbm_ship_to.ship_to_distribution_channel',$distribution_channel); 
        $this->db->where('sap_tbm_ship_to.sold_to_id',$id);        
        //$this->db->where('sap_tbm_ship_to.ship_to_account_group',$type); 
       // $this->db->or_where('sap_tbm_ship_to.ship_to_account_group',$type_2);
        $this->db->where("( sap_tbm_ship_to.ship_to_account_group =  '".$type."' OR sap_tbm_ship_to.ship_to_account_group = '".$type_2."' )");     
        $result = $this->db->get('sap_tbm_ship_to');   

         // echo  $result;
         // die($this->db->last_query());         
        
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




    public function get_sold_to_ajax($job_type,$distribution_channel){
        //echo 'jobtype : '.$job_type;
        $id = '';

        $emp_id = $this->session->userdata('id');

        if($job_type == 'ZQT1'){
            $id = 'Z10';
        }else if($job_type == 'ZQT2'){
             $id = 'Z11';
        }else if($job_type == 'ZQT2_extra'){
             $id = 'Z16';
        }else{
             $id = 'Z12';
        }

        //exit();

        $permission = $this->permission[$this->cat_id];
        $this->db->distinct('sap_tbm_sold_to.id');
        $this->db->select('sap_tbm_sold_to.sold_to_distribution_channel,sap_tbm_sold_to.id As sold_to_id,sap_tbm_sold_to.sold_to_name1,sap_tbm_sold_to.sold_to_name,sap_tbm_sold_to.sold_to_account_group');

        $this->db->join('sap_tbm_ship_to', 'sap_tbm_ship_to.sold_to_id = sap_tbm_sold_to.id', 'left');
        $this->db->join('tbt_user_customer', 'tbt_user_customer.ship_to_id = sap_tbm_ship_to.id', 'left'); 

        if ($permission['shipto']['value'] == 'related') {  
            $this->db->join('tbt_user UC', 'tbt_user_customer.user_id = UC.user_id', 'left');
            $this->db->where('UC.employee_id', $emp_id);
        }

        $this->db->where('sap_tbm_sold_to.sold_to_account_group', $id);
        $this->db->where('sap_tbm_sold_to.sold_to_distribution_channel', $distribution_channel);

        $result = $this->db->get('sap_tbm_sold_to');

        $count = $result->num_rows();
        if($count >0){
            $success = true;
            $result = $result->result_array();
        }else{
            $success = false;
            $result = array($this->db->last_query());
        }
        
        return array('success'=>$success,'result'=>$result);
    }

    public function isStaffExist ($quotation_id) {

        $this->db->select('SUM(total) as total');
        $this->db->where('tbt_man_subgroup.quotation_id',$quotation_id); 
        $query = $this->db->get('tbt_man_subgroup');

        $result = $query->row_array();
        if (!empty($result) && $result['total'] > 0) {
            return 1;
        }

        return 0;
    }

    ///====== GEt : staff =======================================
     public function get_staff_Byid($quotation_id){
        
        $this->db->select('tbt_man_subgroup.*,tbt_man_subgroup.id As sub_group_id,tbt_man_subgroup.total As subgroup_total');
        //,tbt_man_subgroup.title As sub_staff_title

        $this->db->select('tbt_man_group.* ,tbt_man_group.title As group_title, tbt_man_group.id As group_id
                    ,tbt_man_group.total As group_total'); 

        $this->db->select('sap_tbm_position.* ,sap_tbm_position.title As position_title, sap_tbm_position.id As position_id'); 

        $this->db->join('tbt_man_group', 'tbt_man_group.id = tbt_man_subgroup.man_group_id','left');       
        
        $this->db->join('sap_tbm_position', 'sap_tbm_position.id = tbt_man_group.position','left');
        
        $this->db->where('tbt_man_subgroup.quotation_id',$quotation_id); 
        $result = $this->db->get('tbt_man_subgroup');
        //$count = $result->num_rows();

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



    public function get_floor_Byid($quotation_id){

        $this->db->select('tbt_floor.*,tbt_floor.id AS floor_id,tbt_floor.title AS floor_title'); 
        $this->db->where('tbt_floor.quotation_id',$quotation_id); 
        $result = $this->db->get('tbt_floor');

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


    public function get_building_Byid($quotation_id){

        $this->db->select('tbt_building.*,tbt_building.id AS building_id,tbt_building.title As biilding_title,tbt_building.total_building'); 
        $this->db->where('tbt_building.quotation_id',$quotation_id); 
        $result = $this->db->get('tbt_building');

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

    ///====== GEt : AREA =======================================
     public function get_area_Byid($quotation_id){
        
        $this->db->select('tbt_area.* ,tbt_area.title As area_title, tbt_area.id As area_id'); 
        $this->db->select('tbt_building.* ,tbt_building.title As building_title, tbt_building.id As building_id');
        $this->db->select('tbt_floor.* ,tbt_floor.title As floor_title, tbt_floor.id As floor_id');
        $this->db->select('sap_tbm_clear_type.description As clearing_des'); 

        $this->db->join('tbt_building', 'tbt_building.id = tbt_area.building_id','left');
        $this->db->join('tbt_floor', 'tbt_floor.id = tbt_area.floor_id','left');
        $this->db->join('sap_tbm_clear_type', 'sap_tbm_clear_type.id = tbt_area.clear_job_type_id','left');
        
        $this->db->where('tbt_area.quotation_id',$quotation_id); 
        $result = $this->db->get('tbt_area');
        //$count = $result->num_rows();

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

    //==========================================================

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

    public function getLastProspectId () {

        $this->db->select('id');
        $this->db->order_by('id desc');
        $this->db->limit(1);

        $query = $this->db->get('tbt_prospect');
        $quotation = $query->row_array();
        if (!empty($quotation)) {
            return $quotation['id']+1;
        } else {
            return 1;
        }
    }
    public function getLastQuotationId ($job_type) {

        $this->db->select('id');
        $this->db->where('job_type',$job_type);
        $this->db->order_by('id desc');
        $this->db->limit(1);

        $query = $this->db->get('tbt_quotation');
        $quotation = $query->row_array();
        if (!empty($quotation)) {
            return intval($quotation['id']);
        } else {
            return 1;
        }
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


     public function get_requiredByid($id){
        
        $this->db->select('tbt_required_document.*');                 
        $this->db->where('tbt_required_document.quotation_id',$id); 
        $result = $this->db->get('tbt_required_document');
       

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






    //  public function get_main_contract_Byid($type,$id){
        
    //  if($type=='prospect'){
    //     $this->db->select('tbt_contact.*,tbt_contact.id as main_contact_id');       
    //     $this->db->where('tbt_contact.is_main_contact',1);         
    //     $this->db->where('tbt_contact.prospect_id',$id);        
    //     $result = $this->db->get('tbt_contact');
    // }else{
        
    //     $this->db->select('tbt_contact.*,tbt_contact.id as main_contact_id');       
    //     $this->db->where('tbt_contact.is_main_contact',1);         
    //     $this->db->where('tbt_contact.quotation_id',$id);        
    //     $result = $this->db->get('tbt_contact');

    // }       

    //     if(!empty($result)){
    //             // $output = array();
    //             // $state = true;
    //             // $code = '000';
    //             // $msg = '';
    //             $output = $result;
    //     }else{
    //             // $state = false;
    //             // $code = '909';
    //             // $msg = '';
    //             $output = $result;
    //     }
    //    // return self::response($state,$code,$msg,$output);
    //     return $output;
    // }

     public function get_contact_prospect($id){
    
            $this->db->select('tbt_contact.*');  

            $this->db->select('sap_tbm_department.title As department_title'); 
            $this->db->select('sap_tbm_function.description As function_title'); 
            $this->db->join('sap_tbm_department', 'sap_tbm_department.id = tbt_contact.department','left');
            $this->db->join('sap_tbm_function', 'sap_tbm_function.id = tbt_contact.function','left');

            $this->db->where('tbt_contact.prospect_id',$id); 
            //$this->db->where('tbt_contact.is_main_contact',0); 
            $result = $this->db->get('tbt_contact');

    
            //$this->db->select('tbt_contact.*');  
            
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

      public function get_contact_quotation($id){
        
        $this->db->select('tbt_contact.*');  

        $this->db->select('sap_tbm_department.title As department_title'); 
        $this->db->select('sap_tbm_function.description As function_title'); 
        $this->db->join('sap_tbm_department', 'sap_tbm_department.id = tbt_contact.department','left');
        $this->db->join('sap_tbm_function', 'sap_tbm_function.id = tbt_contact.function','left');


        $this->db->where('tbt_contact.quotation_id',$id); 
         //$this->db->where('tbt_contact.quotation_id',$id); 
        $result = $this->db->get('tbt_contact');

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


     public function get_document_importance($type,$id){
        
        if($type=='prospect'){
            $this->db->select('tbt_project_document.*');  
            $this->db->where('is_importance',1); 
            $this->db->where('prospect_id',$id); 
            $this->db->where('delete_flag',0); 
            $result = $this->db->get('tbt_project_document');
       }else{
            $this->db->select('tbt_project_document.*');  
            $this->db->where('is_importance',1); 
            $this->db->where('quotation_id',$id); 
            $this->db->where('delete_flag',0); 
            $result = $this->db->get('tbt_project_document');
       }

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


    public function get_document_other($type,$id){
        
        if($type=='prospect'){
            $this->db->select('tbt_project_document.*');  
            $this->db->where('is_importance',0); 
            $this->db->where('prospect_id',$id); 
            $this->db->where('delete_flag',0); 
            $result = $this->db->get('tbt_project_document');
       }else{
            $this->db->select('tbt_project_document.*');  
            $this->db->where('is_importance',0); 
            $this->db->where('quotation_id',$id); 
            $this->db->where('delete_flag',0); 
            $result = $this->db->get('tbt_project_document');
       }

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





//################################################################
//================ insert tbt_equipment_clearjob ================= 
//################################################################


 public function insert_clearing($quotation_id,$material_no,$mat_type,$mat_group,$mat_group_des
                                ,$quantity,$quantity_unit,$price,$total_price,$frequency,$clearing_type){

     if(!empty($material_no) && !empty($mat_type) 
          && !empty($total_price)  && !empty($frequency) ){// && !empty($quantity)  && !empty($quantity_unit)   && !empty($price) 

        //!empty($texture_id) &&&& !empty($space)

        //=== insert to : tbt_equipment =====
         $data = array(
            'quotation_id' => $quotation_id,
            'material_no' => $material_no,
            'mat_type' => $mat_type,
            'mat_group' => $mat_group,
            'mat_group_des' => $mat_group_des,           
            'quantity' => $quantity,
            'quantity_unit' => $quantity_unit,
            'price' => $price,
            'total_price' => $total_price,
            'frequency' => $frequency,
            'clear_type_id' => $clearing_type,  
            'delete_flag' => 0,              
                                            
        );

        $query=$this->db->insert('tbt_equipment_clearjob', $data);

        if($query){
             $msg = 'เพิ่มข้อมูลเรียบร้อยแล้ว';
            return array('msg'=>$msg);
        }else{
             $msg = 'ผิดพลาด: ไม่สามารถเพิ่มข้อมูลได้';
             return array('msg'=>$msg);
        }//end else   

    }else{//end if check 
         $msg = 'ผิดพลาด: ไม่สามารถเพิ่มข้อมูลได้';
        return array('msg'=>$msg);
    }//end else

}




 public function update_staff_clearing($quotation_id,$frequency_clearing_type
                                        ,$clearing_type_id,$staff_clearing,$job_rate
                                        ,$price_job,$other,$other_price,$total_price){

     if(!empty($frequency_clearing_type) && !empty($clearing_type_id) 
          && !empty($staff_clearing) 
         // && !empty($job_rate) && !empty($total_price)  
        ){

        $data1 = array(
            'staff' => $staff_clearing,
            'job_rate' => $job_rate,
            'other' => $other,
            'other_value' =>  $other_price,
            'total_price_staff_clear' =>  $total_price,                         
        );

        $this->db->where('tbt_area.clear_job_type_id', $clearing_type_id);
        $this->db->where('tbt_area.frequency', $frequency_clearing_type);
        //$this->db->where('tbt_area.id', $clearing_type_id);
        $query1 =$this->db->update('tbt_area', $data1);

        if($query1){
             $msg = 'เพิ่มข้อมูลเรียบร้อยแล้ว';
            return array('msg'=>$msg);
        }else{
             $msg = 'ผิดพลาด: ไม่สามารถเพิ่มข้อมูลได้';
             return array('msg'=>$msg);
        }//end else   

    }else{//end if check 
         $msg = 'ผิดพลาด: ไม่สามารถเพิ่มข้อมูลได้';
        return array('msg'=>$msg);
    }//end else

}



 public function update_staff_quotation($staff,$quotation_id){
 
        $data = array(
            'total_staff_quotation' => $staff,                                  
        );

        $this->db->where('tbt_quotation.id', $quotation_id);
        $query =$this->db->update('tbt_quotation ', $data);

     if($query){
             $msg = 'เพิ่มข้อมูลเรียบร้อยแล้ว';
            return array('msg'=>$msg);
        }else{
             $msg = 'ผิดพลาด: ไม่สามารถเพิ่มข้อมูลได้';
             return array('msg'=>$msg);
        }//end else   

}

//################################################################
//================ insert chemical & others ====================== 
//################################################################


 public function insert_chemical($quotation_id,$mat_group_des,$texture_id,$material_no,$mat_type,$mat_group,$space
                                ,$quantity,$quantity_unit,$price,$total_price,$is_customer_request){

     if(  !empty($material_no) && !empty($mat_type) 
        && !empty($total_price) && !empty($quantity) && !empty($price) && !empty($quantity_unit) ){

        //!empty($texture_id) && && !empty($space)

        //=== insert to : tbt_equipment =====
         $data = array(
            'quotation_id' => $quotation_id,
            'texture_id' => $texture_id,
            'material_no' => $material_no,
            'mat_type' => $mat_type,
            'mat_group' => $mat_group,
            'mat_group_des' => $mat_group_des,
            'space' => $space, 
            'quantity' => $quantity,
            'quantity_unit' => $quantity_unit,
            'price' => $price,
            'total_price' => $total_price,
            'is_customer_request' => $is_customer_request, 
            'delete_flag' => 0,               
                                            
        );

        $query=$this->db->insert('tbt_equipment', $data);

        if($query){
             $msg = 'เพิ่มข้อมูลเรียบร้อยแล้ว';
            return array('msg'=>$msg);
        }else{
             $msg = 'ผิดพลาด: ไม่สามารถเพิ่มข้อมูลได้';
             return array('msg'=>$msg);
        }//end else   

    }else{//end if check 
         $msg = 'ผิดพลาด: ไม่สามารถเพิ่มข้อมูลได้';
        return array('msg'=>$msg);
    }//end else

}




//###################################################
//================ insert STAFF ====================== 
//###################################################
public function insert_man_group($quotation_id,$qt_staff,$sub_total,$group_title,$total_man
                                ,$overtime,$incentive,$transport_exp,$daily_pay_rate,$holiday,$bonus
                                ,$level_staff,$uniform_id,$position,$wage,$benefit,$wage_benefit                                                       
                                ,$other_type1_id,$other_type2_id,$other_type3_id,$other_type4_id,$other_type5_id,$other_type6_id
                                ,$other_type7_id,$other_type8_id,$other_type9_id,$other_type10_id
                                ,$other_1,$other_2,$other_3,$other_4,$other_5,$other_6
                                ,$other_7,$other_8,$other_9,$other_10,$other_title,$other_value
                                ,$daily_pay_rate_type,$daily_pay_rate_id,$is_auto_ot,$overtime_id
                                ,$holiday_id,$is_auto_transport,$transport_exp_id,$incentive_id
                                ,$bonus_id,$is_auto_spacial,$rate_position_id,$special_id,$other_id
                                ,$rate_position,$special,$charge_ot,$pay_sunday
                                ){
  

   if( !empty($group_title) && !empty($total_man)   
    ){
    // && !empty($daily_pay_rate)
    // && !empty($overtime)  && !empty($holiday)  && !empty($incentive)  && !empty($bonus)  && !empty($transport_exp) 

    //todo:: change cut comma
    $charge_ot = str_replace(',', '', $charge_ot);
    $overtime = str_replace(',', '', $overtime);
    $incentive = str_replace(',', '', $incentive);
    $transport_exp = str_replace(',', '', $transport_exp);
    $daily_pay_rate = str_replace(',', '', $daily_pay_rate);
    $holiday = str_replace(',', '', $holiday);
    $bonus = str_replace(',', '', $bonus);
    $special = str_replace(',', '', $special);
    $pay_sunday = str_replace(',', '', $pay_sunday);    
    $rate_position = str_replace(',', '', $rate_position);
    $other_value = str_replace(',', '', $other_value);

    $wage = str_replace(',', '', $wage);
    $benefit = str_replace(',', '', $benefit);
    $wage_benefit = str_replace(',', '', $wage_benefit);
    $sub_total = str_replace(',', '', $sub_total);

    $other_1 = str_replace(',', '', $other_1);
    $other_2 = str_replace(',', '', $other_2);
    $other_3 = str_replace(',', '', $other_3);
    $other_4 = str_replace(',', '', $other_4);
    $other_5 = str_replace(',', '', $other_5);
    $other_6 = str_replace(',', '', $other_6);
    $other_7 = str_replace(',', '', $other_7);
    $other_8 = str_replace(',', '', $other_8);
    $other_9 = str_replace(',', '', $other_9);
    $other_10 = str_replace(',', '', $other_10);


    //=== insert to : tbt_man_group =====
     $data = array(
            'title' => $group_title,
            'staff' => $qt_staff,
            'quotation_id' => $quotation_id,
            'total' => $total_man,
            'overtime' => $overtime,
            'incentive' => $incentive,
            'transport_exp' => $transport_exp,
            'daily_pay_rate' => $daily_pay_rate,
            'holiday' => $holiday,
            'charge_ot' => $charge_ot,
            'pay_sunday' => $pay_sunday,
            //'level_staff' => 'head',
            'bonus' => $bonus,
            'other_type1_id' => $other_type1_id,
            'other_type2_id' => $other_type2_id,
            'other_type3_id' => $other_type3_id,
            'other_type4_id' => $other_type4_id,
            'other_type5_id' => $other_type5_id,
            'other_type6_id' => $other_type6_id,
            'other_type7_id' => $other_type7_id,
            'other_type8_id' => $other_type8_id,
            'other_type9_id' => $other_type9_id,
            'other_type10_id' => $other_type10_id,
            'other_type1' => $other_1,
            'other_type2' => $other_2,
            'other_type3' => $other_3,
            'other_type4' => $other_4,
            'other_type5' => $other_5,
            'other_type6' => $other_6,
            'other_type7' => $other_7,
            'other_type8' => $other_8,
            'other_type9' => $other_9,
            'other_type10' => $other_10,
            'other_title' => $other_title,
            'other_value' => $other_value,
            
            'employee_level_id' => $level_staff, 
            'uniform_id' =>  $uniform_id,  
            'position' => $position, 

            'wage' => $wage,
            'benefit' => $benefit,
            'wage_benefit' => $wage_benefit,
            'subtotal' => $sub_total,
            'delete_flag' => 0, 

            'is_auto_ot' => $is_auto_ot,
            //'is_auto_position' => $is_auto_position,
            'is_auto_spacial' => $is_auto_spacial, 
            'is_auto_transport' => $is_auto_transport, 
            'special_id' => $special_id, 
            'rate_position_id' => $rate_position_id, 
            'other_id' => $other_id, 
            'bonus_id' => $bonus_id, 
            'holiday_id' => $holiday_id, 
            'daily_pay_rate_type' => $daily_pay_rate_type, 
            'daily_pay_rate_id' => $daily_pay_rate_id, 
            'transport_exp_id' => $transport_exp_id, 
            'incentive_id' => $incentive_id, 
            'overtime_id' => $overtime_id,
            'special' => $special, 
            'rate_position' => $rate_position,                                        
    );

    $query=$this->db->insert('tbt_man_group', $data);
    $last_group_id = $this->db->insert_id();
  
        if($query){
             $msg = 'เพิ่มข้อมูลเรียบร้อยแล้ว';
             $last_id = $last_group_id;
            return array('msg'=>$msg,'last_id'=>$last_id);
        }else{
             $msg = 'ผิดพลาด: ไม่สามารถเพิ่มข้อมูลได้';
             return array('msg'=>$msg);
        }

    }else{  
        $msg = 'ผิดพลาด: ไม่สามารถเพิ่มข้อมูลได้';
        return array('msg'=>$msg);
    }//end else   
    
}

//edit case ot :: 15july
// public function insert_man_subgroup($quotation_id,$last_group_id,$sub_group_staff_subg
//                                 ,$gender_subg,$day_radio_subg,$time_start_subg,$time_end_subg
//                                 ,$work_hrs_subg,$overtime_hrs_subg,$work_day_subg,$work_holiday_subg
//                                 ,$charge_ot_subg,$remark_subg,$per_person_subg,$per_group_subg
//                                 ){
public function insert_man_subgroup($quotation_id,$last_group_id,$sub_group_staff_subg
                                ,$gender_subg,$day_radio_subg,$time_start_subg,$time_end_subg
                                ,$work_hrs_subg,$overtime_hrs_subg,$work_day_subg,$work_holiday_subg
                                ,$remark_subg,$per_person_subg,$per_group_subg
                                ){
    if( !empty($last_group_id) && !empty($sub_group_staff_subg) && !empty($gender_subg) && !empty($day_radio_subg)        
        && !empty($per_person_subg)     && !empty($per_group_subg) 
        //&& !empty($time_start_subg)     && !empty($time_end_subg)   
        //&& !empty($work_day_subg)       && !empty($work_hrs_subg) 
      
        //&& !empty($remark_subg) && !empty($position_subg) && !empty($uniform_subg)  
        //&& !empty($overtime_hrs_subg)   && !empty($work_holiday_subg)  && !empty($charge_ot_subg)
    ){

    //todo:: change cut comma
    $per_person_subg = str_replace(',', '', $per_person_subg);
    $per_group_subg = str_replace(',', '', $per_group_subg);
    //$charge_ot_subg = str_replace(',', '', $charge_ot_subg);

    // //set gender
    // if($gender_subg=='femel'){
    //     $gender_subg=1;
    // }else{
    //     $gender_subg=2;
    // }//end else
    
    //=== insert to : tbt_man_subgroup  =====
     $data = array(
            //'title' => $sub_group_staff_subg,
            'man_group_id' => $last_group_id,
            'gender' => $gender_subg,
            'total' => $sub_group_staff_subg,
            'day' => $day_radio_subg,
            'time_in' => $time_start_subg,
            'time_out' => $time_end_subg,
            //'position' => $position_subg,
            //'uniform_id' => $uniform_subg,               
            'work_hours' => $work_hrs_subg,
            'overtime_hours' => $overtime_hrs_subg,
            'work_day' => $work_day_subg,
            'work_holiday' => $work_holiday_subg,
            //'charge_overtime' => $charge_ot_subg,
            'remark' => $remark_subg,
            'subtotal_per_person' => $per_person_subg,
            'subtotal_per_group' => $per_group_subg,
            'quotation_id' => $quotation_id,                                        
    );

    $query=$this->db->insert('tbt_man_subgroup', $data);
       
         if($query){
             $msg = 'เพิ่มข้อมูลเรียบร้อยแล้ว';            
            return array('msg'=>$msg);
        }else{
             $msg = 'ผิดพลาด: ไม่สามารถเพิ่มข้อมูลได้';
             return array('msg'=>$msg);
        }//end if query  

    }else{  
        $msg = 'ผิดพลาด: ไม่สามารถเพิ่มข้อมูลได้';
        return array('msg'=>$msg);
    }//end else

}




//###################################################
//================ insert AREA ====================== 
//###################################################

 public function insert_building($quotation_id,$ship_to_id,$building_name,$total_of_building){

     if(!empty($building_name)){

    //echo  'building name :'.$building_name.'<br>';
    //=== insert to : tbt_building =====
     $data = array(
            'title' => $building_name,
            'ship_to_id' => $ship_to_id,
            'contract_id' => '',
            'quotation_id' => $quotation_id, 
            'total_building' => $total_of_building,               
                                        
    );

    $query=$this->db->insert('tbt_building', $data);
    $last_building_id = $this->db->insert_id();

    // echo ' $last_building_id :'. $last_building_id.'<br>';
    // exit();
         if($query) {
             $msg = 'เพิ่มข้อมูลเรียบร้อยแล้ว';
             $last_id = $last_building_id;
            return array('msg'=>$msg,'last_id'=>$last_id);
        } else {
             $msg = 'ผิดพลาด: ไม่สามารถเพิ่มข้อมูลได้';
             return array('msg'=>$msg);
        }  

    }else{//end if check 
         $msg = 'ผิดพลาด: ไม่สามารถเพิ่มข้อมูลได้';
        return array('msg'=>$msg);
    }

}



public function insert_floor($quotation_id,$ship_to_id,$building_id,$floor_name,$total_of_floor){
    // if(!empty($floor_name)){

    // echo  'building_id  :'.$building_id.'<br>';
    // echo  'floor name :'.$floor_name.'<br>';

    //=== insert to : tbt_floor =====
     $data = array(
            'title' => $floor_name,
            'building_id' => $building_id,  
            'ship_to_id' => $ship_to_id,
            'contract_id' => '',
            'quotation_id' => $quotation_id, 
            'total_floor' => $total_of_floor,          
                                        
    );

    $query=$this->db->insert('tbt_floor', $data);
    $last_floor_id = $this->db->insert_id();

         if($query) {
             $msg = 'เพิ่มข้อมูลเรียบร้อยแล้ว';
             $last_id = $last_floor_id;
            return array('msg'=>$msg,'last_id'=>$last_id);
        } else {
             $msg = 'ผิดพลาด: ไม่สามารถเพิ่มข้อมูลได้';
             return array('msg'=>$msg);
        } 

    // }else{
    //      $msg = 'ผิดพลาด: ไม่สามารถเพิ่มข้อมูลได้';
    //     return array('msg'=>$msg);s

    // }
}



public function insert_area($quotation_id,$ship_to_id,$building_id,$floor_id,
                            $area_title,$industry_room_id,$industry_room_description,
                            $texture_id,$texture_description,$area_space,
                            $clear_job_type_id,$area_frequency){

     if( !empty($building_id) && !empty($floor_id) && !empty($industry_room_id) && !empty($industry_room_description)  
            && !empty($texture_id)  && !empty($texture_description)   && !empty($area_space)  && !empty($clear_job_type_id) 
        ){

            // echo  'quotation_id  :'.$quotation_id.'<br>';
            // echo  'building_id  :'.$building_id.'<br>';
            // echo  'floor_id :'.$floor_id.'<br>';

            if($area_frequency!=0){
                 $is_on_clearjob=1;
            }else{
                 $is_on_clearjob=0;
            }

            //=== insert to : tbt_area =====
             $data = array(
                    'title' => $area_title,            
                    'building_id' => $building_id, 
                    'floor_id' => $floor_id, 
                    'industry_room_id' => $industry_room_id,
                    'industry_room_description' => $industry_room_description,  
                    'texture_description' => $texture_description,    
                    'texture_id' => $texture_id,
                    'space' => $area_space,
                    'is_on_clearjob' => $is_on_clearjob, 
                    'ship_to_id' => $ship_to_id,
                    'contract_id' => '', 
                    'quotation_id' => $quotation_id,
                    //'delete_flag' => 0,
                    'project_id' => '',
                    'frequency' => $area_frequency,   
                    'staff' => '', 
                    'job_rate' => '', 
                    'clear_job_type_id' => $clear_job_type_id,
                    'other' => '', 
                    'other_value' => '',               
                                                
            );

            $query=$this->db->insert('tbt_area', $data);
            $last_area_id = $this->db->insert_id();
            

             if($query) {
                 $msg = 'เพิ่มข้อมูลเรียบร้อยแล้ว :'.$last_area_id;
                 //$last_id = $last_floor_id;
                return array('msg'=>$msg);
            } else {
                 $msg = 'ผิดพลาด: ไม่สามารถเพิ่มข้อมูลได้';
                 return array('msg'=>$msg);
            }  

    }else{  
        $msg = 'ผิดพลาด: ไม่สามารถเพิ่มข้อมูลได้';
        return array('msg'=>$msg);
    }

}



function insert_create_to_quotation($id_quotation,$id_prospect,$title,$job_type,$time,$distribution_channel
                                    ,$unit_time,$project_owner_id,$competitor_id,$replaced_by,$create_date
                                    ,$sold_to_name1,$sold_to_address1,$sold_to_address2,$sold_to_address3,$sold_to_address4
                                    ,$sold_to_district,$sold_to_city,$sold_to_postal_code,$sold_to_country,$sold_to_region
                                    ,$sold_to_business_scale,$sold_to_customer_group,$sold_to_industry,$sold_to_tel,$sold_to_tel_ext
                                    ,$sold_to_mobile,$sold_to_email,$sold_to_fax,$sold_to_fax_ext,$plan_code_prospect 
                                    ){   

//=== insert to : tbt_quotation =====
     $data = array(
            'id' => $id_quotation,
            //'previous_quotation_id' => '',
            'title' => $title,
            'distribution_channel' => $distribution_channel,
            'job_type' => $job_type,
            'sold_to_id' => $id_prospect,
            'is_prospect' => 1,
            'ship_to_id' => $id_prospect,
            'project_start' => '',
            'project_end' => '',
            'delete_flag' => 0,
            'project_owner_id' =>  $project_owner_id,
            'competitor_id' => $competitor_id,
            'status' => 'OPEN',
            'language' => '',
            'create_date' => $create_date,
            'time' => $time,
            'unit_time' => $unit_time,
            'is_go_live' => '',
            'contract_id' => '',
            'project_id' => '',

            'ship_to_name1' => '',
            //'ship_to_name2' => '',
            'ship_to_address1' => '',
            'ship_to_address2' => '',
            'ship_to_address3' => '',
            'ship_to_address4' => '',
            'ship_to_district' => '',
            'ship_to_city' => '',
            'ship_to_postal_code' => '',
            'ship_to_country' => '',
            'ship_to_region' => '',
            'ship_to_business_scale' => '',
            //'ship_to_customer_group' => '',
            'ship_to_industry' => '',
            'ship_to_tel' => '',
            'ship_to_tel_ext' => '',
            'ship_to_fax' => '',
            'ship_to_fax_ext' => '',
            'ship_to_mobile' => '',
            'ship_to_email' => '',

            'sold_to_name1' => $sold_to_name1,
            //'sold_to_name2' => $sold_to_name2,
            'sold_to_address1' => $sold_to_address1,
            'sold_to_address2' => $sold_to_address2,
            'sold_to_address3' => $sold_to_address3,
            'sold_to_address4' => $sold_to_address4,
            'sold_to_district' => $sold_to_district,
            'sold_to_city' => $sold_to_city,
            'sold_to_postal_code' => $sold_to_postal_code,
            'sold_to_country' => $sold_to_country,
            'sold_to_region' => $sold_to_region,
            'sold_to_business_scale' => $sold_to_business_scale,
            //'sold_to_customer_group' => $sold_to_customer_group,
            'sold_to_industry' => $sold_to_industry,

            'sold_to_tel' => $sold_to_tel,
            'sold_to_tel_ext' => $sold_to_tel_ext,
            'sold_to_fax' => $sold_to_fax,
            'sold_to_fax_ext' => $sold_to_fax_ext,
            'sold_to_mobile' => $sold_to_mobile,
            'sold_to_email' => $sold_to_email,
            'plan_code_prospect' => $plan_code_prospect,
            
    );
    $query=$this->db->insert('tbt_quotation', $data);

    $last_id = $this->db->insert_id();
     if($query) {
             $msg = 'เพิ่มข้อมูลเรียบร้อยแล้ว';
             $last_id = $last_id;
            return array('msg'=>$msg,'last_id'=>$last_id);

        } else {
             $msg = 'ผิดพลาด: ไม่สามารถเพิ่มข้อมูลได้';
             return array('msg'=>$msg);
        }

}//end fun


function insert_create_to_quotation_contact($title,$firstname,$lastname
                                            ,$function,$department,$tel,$tel_ext,$mobile_no,$fax,$fax_ext,$email,$is_main_contact
                                            ,$quotation_id,$ship_to_id
                                            ){


       $data = array(
                'title' => $title,
                'firstname' => $firstname,
                'lastname' => $lastname,
                //'position' => $position,
                'function' =>  $function,
                'department' => $department,
                'tel' => $tel,
                'tel_ext' => $tel_ext ,
                'mobile_no' =>  $mobile_no,
                'fax' =>  $fax_ext,
                'email' => $email,
                'is_main_contact' => $is_main_contact,
                'project_id' => '',
                'contract_id' => '',
                'prospect_id' => '',
                'quotation_id' => $quotation_id,
                'ship_to_id' => $ship_to_id,                         
                                            
        );
            

     $query=$this->db->insert('tbt_contact', $data);

       
         if($query) {
             $msg = 'เพิ่มข้อมูลเรียบร้อยแล้ว';
            return array('msg'=>$msg);
        } else {
             $msg = 'ผิดพลาด: ไม่สามารถเพิ่มข้อมูลได้';
             return array('msg'=>$msg);
        } 

}






function insert_create_to_quotation_doc($description,$own_by,$is_approve
                                        ,$delete_flag,$path,$contract_id,$is_importance,$quotation_id
                                        ){


       $data = array(   
                        'description' => $description,
                        'own_by' => $own_by,
                        'is_approve' => $is_approve,
                        'project_id' => '',
                        'delete_flag' => $delete_flag,
                        'path' => $path,
                        'contract_id' => '',
                        'is_importance' => $is_importance,
                        'quotation_id' => $quotation_id,
                        'prospect_id' => '',            
                    );
            
        $query = $this->db->insert('tbt_project_document', $data);

       
         if($query) {
             $msg = 'เพิ่มข้อมูลเรียบร้อยแล้ว';
            return array('msg'=>$msg);
        } else {
             $msg = 'ผิดพลาด: ไม่สามารถเพิ่มข้อมูลได้';
             return array('msg'=>$msg);
        } 

}





      function insert_quotation($p,$last_id_db,$accountGroup){   


             $account_group_ps = $accountGroup;
          
             $title = $p['title'];            
             $doc_type = $p['doc_type'];
            
            if($doc_type ==1){
              $job_type = '';
            }else{
             $job_type = $p['job_type'];
            }
            
             $time =  '';//$p['time'];
             $unit_time = ''; //$p['unit_time'];

             $customer_source = $p['customer_source'];
             $sold_to =  $p['sold_to'];
             $prospect_customer = $p['prospect_customer'];

            //exit();

            $sold_to_id ='';
            $ship_to_id ='';
            $is_prospect ='';

            if($customer_source=='sold_to'){
                $sold_to_id =  $sold_to;
                $ship_to_id =  '';
                $is_prospect = 0;

            }else{
                $sold_to_id =  $prospect_customer;
                $ship_to_id =  $prospect_customer;
                $is_prospect = 1;
            }

            //echo $sold_to_id.'<br>';
            
            $create_date   = $p['create_date'];

           // echo $competitor_id  = $p['competitor_id'];
            $actor_by_id = $this->session->userdata('id');

            if($doc_type==1){
                //=== insert to : tbt_prospect =====
                     $data = array(
                            'id' => $last_id_db,
                            'title' => $title,
                            'job_type' => $job_type,
                            'time' => $time,
                            'unit_time' => $unit_time,
                            'delete_flag' => 0,
                            'project_owner_id' =>  $actor_by_id,
                            'competitor_id' => '',
                            'create_date' => $create_date,
                            'sold_to_name1' => '',
                            //'sold_to_name2' => '',
                            'sold_to_address1' => '',
                            'sold_to_address2' => '',
                            'sold_to_address3' => '',
                            'sold_to_address4' => '',
                            'sold_to_district' => '',
                            'sold_to_city' => '',
                            'sold_to_postal_code' => '',
                            'sold_to_country' => '',
                            'sold_to_region' => '',
                            'sold_to_business_scale' => '',
                            //'sold_to_customer_group' => '',
                            'sold_to_industry' => '',
                                                        
                    );
                    $query=$this->db->insert('tbt_prospect', $data);
                    $last_id = $last_id_db;

            }else{

                if($is_prospect == 1 ){
                //==== get data prospect ===
                $query_data_prospect = self::get_prospectByid($sold_to_id);
                $data_prospect = $query_data_prospect->row_array();
                  
                    $distribution_channel = $data_prospect['distribution_channel'];
                    $sold_to_name1 = $data_prospect['sold_to_name1'];
                    //$sold_to_name2 = $data_prospect['sold_to_name2'];
                    //$sold_to_name2 = '';
                    $sold_to_address1 = $data_prospect['sold_to_address1'];
                    $sold_to_address2 = $data_prospect['sold_to_address2'];
                    $sold_to_address3 = $data_prospect['sold_to_address3'];
                    $sold_to_address4 = $data_prospect['sold_to_address4'];
                    $sold_to_district = $data_prospect['sold_to_district'];
                    $sold_to_country = $data_prospect['sold_to_country'];
                    $sold_to_region = $data_prospect['sold_to_region'];
                    $sold_to_city = $data_prospect['sold_to_city'];
                    $sold_to_postal_code = $data_prospect['sold_to_postal_code'];
                    $sold_to_industry = $data_prospect['sold_to_industry'];
                    $sold_to_business_scale = $data_prospect['sold_to_business_scale'];
                    //$sold_to_customer_group = $data_prospect['sold_to_customer_group'];

                    $sold_to_tel     = $data_prospect['sold_to_tel'];
                    $sold_to_tel_ext = $data_prospect['sold_to_tel_ext'];
                    $sold_to_fax     = $data_prospect['sold_to_fax'];
                    $sold_to_fax_ext = $data_prospect['sold_to_fax_ext'];
                    $sold_to_mobile  = $data_prospect['sold_to_mobile'];
                    $sold_to_email   = $data_prospect['sold_to_email'];
                    $sold_to_tax_id   = "";
                    $plan_code_prospect   = $data_prospect['plan_code_prospect'];
                    $account_group_qt = $account_group_ps;

                }else{

                    //==== get data sap_tbm_sold_to ===
                    $query_data = self::sap_tbm_sold_to_byID_disb($sold_to_id,$p['distribution_channel']);
                    $data_sold_to = $query_data->row_array();

                    

                    $distribution_channel = $data_sold_to['sold_to_distribution_channel'];
                    $sold_to_name1 = $data_sold_to['sold_to_name1'];
                    //$sold_to_name2 = $data_sold_to['sold_to_name2'];
                    $sold_to_address1 = $data_sold_to['sold_to_address1'];
                    $sold_to_address2 = $data_sold_to['sold_to_address2'];
                    $sold_to_address3 = $data_sold_to['sold_to_address3'];
                    $sold_to_address4 = $data_sold_to['sold_to_address4'];
                    $sold_to_district = $data_sold_to['sold_to_district'];
                    $sold_to_country = $data_sold_to['sold_to_country'];
                    $sold_to_region = $data_sold_to['sold_to_region'];
                    $sold_to_city = $data_sold_to['sold_to_city'];
                    $sold_to_postal_code = $data_sold_to['sold_to_postal_code'];
                    $sold_to_industry = $data_sold_to['sold_to_industry'];
                    $sold_to_business_scale = $data_sold_to['sold_to_business_scale'];

                    $sold_to_tel     = $data_sold_to['sold_to_tel'];
                    $sold_to_tel_ext = $data_sold_to['sold_to_tel_ext'];
                    $sold_to_fax     = $data_sold_to['sold_to_fax'];
                    $sold_to_fax_ext = $data_sold_to['sold_to_fax_ext'];
                    $sold_to_mobile  = $data_sold_to['sold_to_mobile'];
                    $sold_to_email   = $data_sold_to['sold_to_email'];
                    $sold_to_tax_id   = $data_sold_to['sold_to_tax_id'];
                    $plan_code_prospect   = "";
                    $account_group_qt = $data_sold_to['sold_to_account_group'];
                    //$sold_to_customer_group = $data_sold_to['sold_to_customer_group'];

                    // $sold_to_telephone     = '';
                    // $sold_to_telephone_ext = '';
                    // $sold_to_fax      = '';
                    // $sold_to_fax_ext  = '';
                    // $sold_to_mobile   = '';
                    // $sold_to_email    = '';

                }


                //=== insert to : tbt_quotation =====
                     $data = array(
                            'id' => $last_id_db,
                            //'previous_quotation_id' => '',
                            'title' => $title,
                            'distribution_channel' => $distribution_channel,
                            'job_type' => $job_type,
                            'sold_to_id' => $sold_to_id,
                            'is_prospect' => $is_prospect,
                            'ship_to_id' => $ship_to_id,
                            'project_start' => '',
                            'project_end' => '',
                            'delete_flag' => 0,
                            'project_owner_id' =>  $actor_by_id,
                            'competitor_id' => '',
                            'account_group' => $account_group_qt,
                            'status' => 'OPEN',
                            'language' => '',
                            'create_date' => $create_date,
                            'time' => '',
                            'unit_time' => '',
                            'is_go_live' => '',
                            'contract_id' => '',
                            'project_id' => '',

                            'ship_to_name1' => '',
                            //'ship_to_name2' => '',
                            'ship_to_address1' => '',
                            'ship_to_address2' => '',
                            'ship_to_address3' => '',
                            'ship_to_address4' => '',
                            'ship_to_district' => '',
                            'ship_to_city' => '',
                            'ship_to_postal_code' => '',
                            'ship_to_country' => '',
                            'ship_to_region' => '',
                            'ship_to_business_scale' => '',
                            //'ship_to_customer_group' => '',
                            'ship_to_industry' => '',
                            'ship_to_tel' => '',
                            'ship_to_tel_ext' => '',
                            'ship_to_fax' => '',
                            'ship_to_fax_ext' => '',
                            'ship_to_mobile' => '',
                            'ship_to_email' => '',
                            'ship_to_tax_id' => '',


                            'sold_to_name1' => $sold_to_name1,
                            //'sold_to_name2' => $sold_to_name2,
                            'sold_to_address1' => $sold_to_address1,
                            'sold_to_address2' => $sold_to_address2,
                            'sold_to_address3' => $sold_to_address3,
                            'sold_to_address4' => $sold_to_address4,
                            'sold_to_district' => $sold_to_district,
                            'sold_to_city' => $sold_to_city,
                            'sold_to_postal_code' => $sold_to_postal_code,
                            'sold_to_country' => $sold_to_country,
                            'sold_to_region' => $sold_to_region,
                            'sold_to_business_scale' => $sold_to_business_scale,
                            //'sold_to_customer_group' => $sold_to_customer_group,
                            'sold_to_industry' => $sold_to_industry,

                            'sold_to_tel' => $sold_to_tel,
                            'sold_to_tel_ext' => $sold_to_tel_ext,
                            'sold_to_fax' => $sold_to_fax,
                            'sold_to_fax_ext' => $sold_to_fax_ext,
                            'sold_to_mobile' => $sold_to_mobile,
                            'sold_to_email' => $sold_to_email,
                            'sold_to_tax_id' =>  $sold_to_tax_id,
                            'plan_code_prospect' =>  $plan_code_prospect,
                            
                    );
                    // echo "<pre>";
                    // print_r($data);
                    // die();
                    $query=$this->db->insert('tbt_quotation', $data);
                    $last_id = $last_id_db;
            }  

               
        if($query) {
             $msg = 'เพิ่มข้อมูลเรียบร้อยแล้ว';
             $last_id = $last_id;
            return array('msg'=>$msg,'last_id'=>$last_id);

        } else {
             $msg = 'ผิดพลาด: ไม่สามารถเพิ่มข้อมูลได้';
             return array('msg'=>$msg);
        }
    
    }


 public function insert_required_doc($p,$id){

    //echo '<br><br>';

    //==== get data prospect ===
    $query_data_doc = self::get_required_doc();
    $temp_required = $query_data_doc->result_array();

    if(!empty($temp_required)){
        foreach($query_data_doc->result_array() as $value){

            $required_doc_id = 'required_doc_'.$value['id'];
            if (!array_key_exists( $required_doc_id, $p)) {
                $p[$required_doc_id] = '0';
            }         
                     
            //echo 'required_doc_'.$value['id'].' || '.$p[$required_doc_id].'<br>';

            if(!empty($p[$required_doc_id])){               
                $data = array(
                        'id' => $value['id'],
                        'quotation_id' => $id,                                                                 
                    );
                $query=$this->db->insert('tbt_required_document', $data);
            }//end if check              

        }//end foreach
         $msg = 'เพิ่มข้อมูลเรียบร้อยแล้ว';
         return array('msg'=>$msg);

    }//end empty
    else{
         $msg = 'ผิดพลาด: ไม่สามารถเพิ่มข้อมูลได้';
         return array('msg'=>$msg);
    }        

   // exit();

}//end function



     public function insert_main_contact($type,$p,$id){

      $contract_fistname = $p['contract_firstname'];
      $contract_lastname = $p['contract_lastname'];
      $contract_function = $p['contact_function'];
      $contact_department = $p['contact_department'];
      //$contract_position = $p['contact_position'];
      $contact_telephone = $p['contact_telephone'];
      $contact_ext = $p['contact_ext'];
      $contact_mobile_phone = $p['contact_mobile_phone'];
      $contact_fax =  $p['contact_fax'];
      $contract_email =  $p['contact_email'];
  

            echo 'contract_firstname : '.$p['contract_firstname'].'<br>';
            echo 'contract_lastname : '.$p['contract_lastname'].'<br>';
           // echo 'contact_position : '.$p['contact_position'].'<br>';
            echo 'contact_function : '.$p['contact_function'].'<br>';
            echo 'contact_department : '.$p['contact_department'].'<br>';
            echo 'contact_telephone : '.$p['contact_telephone'].'<br>';
            echo 'contact_ext : '.$p['contact_ext'].'<br>';
            echo 'contact_mobile_phone : '.$p['contact_mobile_phone'].'<br>';
            echo 'contact_fax : '.$p['contact_fax'].'<br>';
            echo 'contact_email : '.$p['contact_email'].'<br>';

            if($type=='prospect'){
             $data = array(
                            'firstname' => $contract_fistname,
                            'lastname' => $contract_lastname,
                            'position' => '',
                            'function' =>  $contract_function,
                            'department' => $contact_department,
                            'tel' => $contact_telephone,
                            'tel_ext' => $contact_ext ,
                            'mobile_no' =>  $contact_mobile_phone,
                            'fax' =>  $contact_fax,
                            'email' => $contract_email,
                            'is_main_contact' => 1,
                            'project_id' => '',
                            'contract_id' => '',
                            'prospect_id' => $id,
                            'quotation_id' => '',
                            'ship_to_id' => '',                         
                                                        
                    );

            }else{
                $data = array(
                            'firstname' => $contract_fistname,
                            'lastname' => $contract_lastname,
                            'position' => '',
                            'function' =>  $contract_function,
                            'department' => $contact_department,
                            'tel' => $contact_telephone,
                            'tel_ext' => $contact_ext ,
                            'mobile_no' =>  $contact_mobile_phone,
                            'fax' =>  $contact_fax,
                            'email' => $contract_email,
                            'is_main_contact' => 1,
                            'project_id' => '',
                            'contract_id' => '',
                            'prospect_id' => '',
                            'quotation_id' => $id,
                            'ship_to_id' => '',                         
                                                        
                    );
            }

            $query=$this->db->insert('tbt_contact', $data);

       
         if($query) {
             $msg = 'เพิ่มข้อมูลเรียบร้อยแล้ว';
            return array('msg'=>$msg);
        } else {
             $msg = 'ผิดพลาด: ไม่สามารถเพิ่มข้อมูลได้';
             return array('msg'=>$msg);
        }   

    }   


     public function update_main_contact($type,$p,$id){

    echo 'contrack_main_id : '.$contrack_main_id = $p['contrack_main_id'];

      $contract_fistname = $p['contract_firstname'];
      $contract_lastname = $p['contract_lastname'];
      $contract_function = $p['contact_function'];
      $contact_department = $p['contact_department'];
      //$contract_position = $p['contact_position'];
      $contact_telephone = $p['contact_telephone'];
      $contact_ext = $p['contact_ext'];
      $contact_mobile_phone = $p['contact_mobile_phone'];
      $contact_fax =  $p['contact_fax'];
      $contract_email =  $p['contact_email'];

       if($type=='prospect'){

           $data = array(
                        'firstname' => $contract_fistname,
                        'lastname' => $contract_lastname,
                        'position' => '',
                        'function' =>  $contract_function,
                        'department' => $contact_department,
                        'tel' => $contact_telephone,
                        'tel_ext' => $contact_ext ,
                        'mobile_no' =>  $contact_mobile_phone,
                        'fax' =>  $contact_fax,
                        'email' => $contract_email,
                        'is_main_contact' => 1,
                        'project_id' => '',
                        'contract_id' => '',
                        'prospect_id' => $id,
                        'quotation_id' => '',
                        'ship_to_id' => '',                         
                                                    
                );
       }else{

             $data = array(
                        'firstname' => $contract_fistname,
                        'lastname' => $contract_lastname,
                        'position' => '',
                        'function' =>  $contract_function,
                        'department' => $contact_department,
                        'tel' => $contact_telephone,
                        'tel_ext' => $contact_ext ,
                        'mobile_no' =>  $contact_mobile_phone,
                        'fax' =>  $contact_fax,
                        'email' => $contract_email,
                        'is_main_contact' => 1,
                        'project_id' => '',
                        'contract_id' => '',
                        'prospect_id' => '',
                        'quotation_id' => $id,
                        'ship_to_id' => '',                         
                                                    
                );
       } 

            $this->db->where('tbt_contact.id',  $contrack_main_id);

            if($type=='prospect'){
                $this->db->where('tbt_contact.prospect_id', $id);
            }else{
                $this->db->where('tbt_contact.quotation_id', $id);
            }   

            $query=$this->db->update('tbt_contact', $data);

         if($query) {
             $msg = 'แก้ไขข้อมูลเรียบร้อยแล้ว';
            return array('msg'=>$msg);
        } else {
             $msg = 'ผิดพลาด: ไม่สามารถแก้ไขข้อมูลได้';
             return array('msg'=>$msg);
        }   

    }


    public function insert_otherperson($title,$other_fistname,$other_lastname,$other_function,$other_department,$other_tel,$other_tel_ext,$other_fax,$other_fax_ext,$other_mobile,$other_email,$prospect_id){

        if(!empty($other_fistname) && !empty($other_lastname) && !empty($other_function) && !empty($other_department) ){
            //&& !empty($other_mobile)
            //  && !empty($other_tel) && !empty($other_tel_ext) 
            // && !empty($other_fax) && !empty($other_fax_ext)
            // && !empty($other_email)
      
             $data = array(
                            'title' => $title,
                            'firstname' => $other_fistname,
                            'lastname' => $other_lastname,
                            //'position' => '',
                            'function' =>  $other_function,
                            'department' => $other_department,
                            'tel' => $other_tel,
                            'tel_ext' => $other_tel_ext,
                            'mobile_no' => $other_mobile,                            
                            'fax_ext' => $other_fax_ext,
                            'fax' => $other_fax,
                            'email' => $other_email,
                            //'is_main_contact' => 0,
                            //'project_id' => '',
                            //'contract_id' => '',
                            'prospect_id' => $prospect_id,
                            'quotation_id' => '',
                            //'ship_to_id' => '',                                                
                                                        
                    );
            $query=$this->db->insert('tbt_contact', $data);
            return true;

        }else{
             $msg = 'ผิดพลาก : กรอกข้อมูลไม่ครบถ้วน';
            return array('msg'=>$msg);
        }

        //  if($query) {
        //      $msg = 'เพิ่มข้อมูลเรียบร้อยแล้ว';
        //     return array('msg'=>$msg);
        // } else {
        //      $msg = 'ผิดพลาด: ไม่สามารถเพิ่มข้อมูลได้';
        //      return array('msg'=>$msg);
        // }   

    }



     public function insert_other_service($service_ID,$service_unit,$service_quantity,$service_price,$service_total,$quotation_id){

        if(!empty($service_ID) && !empty($service_unit) && !empty($service_quantity)  && !empty($service_price) && !empty($service_total) ){
      
             $data = array(
                        'project_id' => '',
                        'quotation_id' => $quotation_id,
                        'other_service_id' => $service_ID,
                        'quantity' => $service_quantity,
                        'quantity_unit' => $service_unit,    
                        'delete_flag' => 0, 
                        'price' => $service_price, 
                        'total' => $service_total,                                                                
                                                        
                    );
            $query=$this->db->insert('tbt_other_service', $data);
            return true;


             if($query) {
                    $msg = 'เพิ่มข้อมูลเรียบร้อยแล้ว';
                    return array('msg'=>$msg);
                } else {
                     $msg = 'ผิดพลาด: ไม่สามารถเพิ่มข้อมูลได้';
                     return array('msg'=>$msg);
                }   

        }else{
             $msg = 'ผิดพลาก : กรอกข้อมูลไม่ครบถ้วน';
            return array('msg'=>$msg);
        }

        

    }





     public function insert_otherperson_quotation($title,$other_fistname,$other_lastname,
                  $other_function,$other_department,$other_tel,$other_tel_ext,$other_fax,$other_fax_ext,
                  $other_mobile,$other_email,$quotation_id){

        if(!empty($other_fistname) && !empty($other_lastname) && !empty($other_function) && !empty($other_department)  ){
        // && !empty($other_position) 
        //&& !empty($other_mobile)
      
             $data = array(
                            'title' => $title,
                            'firstname' => $other_fistname,
                            'lastname' => $other_lastname,
                            //'position' => '',
                            'function' =>  $other_function,
                            'department' => $other_department,
                            'tel' => '',
                            'tel_ext' => '',
                            'mobile_no' => $other_mobile,
                            'fax_ext' => '',
                            'fax' => '',                            
                            'email' => $other_email,
                            //'is_main_contact' => 0,
                            //'project_id' => '',
                            //'contract_id' => '',
                            'prospect_id' => '',
                            'quotation_id' => $quotation_id,
                            //'ship_to_id' => '',
                                                        
                    );
            $query=$this->db->insert('tbt_contact', $data);
            return true;

        }else{
             $msg = 'ผิดพลาก : กรอกข้อมูลไม่ครบถ้วน';
            return array('msg'=>$msg);
        }

        //  if($query) {
        //      $msg = 'เพิ่มข้อมูลเรียบร้อยแล้ว';
        //     return array('msg'=>$msg);
        // } else {
        //      $msg = 'ผิดพลาด: ไม่สามารถเพิ่มข้อมูลได้';
        //      return array('msg'=>$msg);
        // }   

    }




     public function update_prospect($p,$prospect_id){
            // echo 'sold_to_name1 : '.$p['sold_to_name1'].'<br>';
            // echo 'sold_to_name2 : '.$p['sold_to_name2'].'<br>';
            // echo 'sold_to_address1 : '.$p['sold_to_address1'].'<br>';
            // echo 'sold_to_address2 : '.$p['sold_to_address2'].'<br>';
            // echo 'sold_to_address3 : '.$p['sold_to_address3'].'<br>';
            // echo 'sold_to_address4 : '.$p['sold_to_address4'].'<br>';
            // echo 'sold_to_district : '.$p['sold_to_district'].'<br>';
            // echo 'sold_to_country : '.$p['sold_to_country'].'<br>';
            // echo 'sold_to_region : '.$p['sold_to_region'].'<br>';
            // echo 'sold_to_city : '.$p['sold_to_city'].'<br>';
            // echo 'sold_to_postal_code : '.$p['sold_to_postal_code'].'<br>';
            // echo 'sold_to_industry : '.$p['sold_to_industry'].'<br>';
            // echo 'sold_to_business_scale : '.$p['sold_to_business_scale'].'<br>';
            // //echo 'sold_to_customer_group : '.$p['sold_to_customer_group'].'<br>';
            

            // echo 'time : '.$p['time'].'<br>';
            // echo 'unit_time : '.$p['unit_time'].'<br>';
            // echo 'up date competitor_id: <br>';
            // echo 'competitor_id : '.$p['competitor_id'].'<br>';
            // echo 'job_type : '.$p['job_type'].'<br>';

           $data = array(
                'time' => $p['time'],
                'distribution_channel' => $p['distribution_channel'],
                'unit_time' => $p['unit_time'],
                'competitor_id' =>  $p['competitor_id'],
                //'job_type' =>  $p['job_type'],
                'sold_to_name1' => $p['sold_to_name1'],
                //'sold_to_name2' => $p['sold_to_name2'],   
                'sold_to_address1' => $p['sold_to_address1'],   
                'sold_to_address2' => $p['sold_to_address2'],   
                'sold_to_address3' => $p['sold_to_address3'],   
                'sold_to_address4' => $p['sold_to_address4'],   
                'sold_to_district' => $p['sold_to_district'],           
                'sold_to_city' => $p['sold_to_city'],
                'sold_to_postal_code' => $p['sold_to_postal_code'],   
                'sold_to_country' => $p['sold_to_country'],   
                'sold_to_region' => $p['sold_to_region'],   
                'sold_to_business_scale' => $p['sold_to_business_scale'],   
                //'sold_to_customer_group' => $p['sold_to_customer_group'],   
                'sold_to_industry' => $p['sold_to_industry'],    

                'sold_to_tel' => $p['sold_to_tel'],
                'sold_to_tel_ext' => $p['sold_to_tel_ext'],
                'sold_to_fax' => $p['sold_to_fax'],
                'sold_to_fax_ext' => $p['sold_to_fax_ext'],
                'sold_to_mobile' => $p['sold_to_mobile'],
                'sold_to_email' => $p['sold_to_email'],
                'plan_code_prospect' => $p['plan_code_prospect'],


            );
           
            $this->db->where('id', $prospect_id); 
            $query=$this->db->update('tbt_prospect', $data);

       
         if($query) {
             $msg = 'แก้ไขเรียบร้อยแล้ว';
            return array('msg'=>$msg);
        } else {
             $msg = 'ผิดพลาด: ไม่สามารถแก้ไขข้อมูลได้';
             return array('msg'=>$msg);
        }   

    }




     public function update_quotation($p,$quotation_id){

            // add serialize required_doc
           $required_doc = serialize($p['required_doc']);
           //echo $required_doc;

           $data = array(
                //'previous_quotation_id' => '',
                'title' => $p['project_title'],
                'job_type' => $p['job_type'],
                'distribution_channel' => $p['distribution_channel'],
                'sold_to_id' => $p['sold_to_id'],
                //'is_prospect' => $p['unit_time'],
                'ship_to_id' => $p['ship_to_id'],
                // 'project_start' => $p['unit_time'],
                // 'project_end' => $p['unit_time'],
                'delete_flag' => 0,
                //'project_owner_id' =>  $p['project_owner_id'],
                'competitor_id' =>  $p['competitor_id'],
                //'language' => $p['unit_time'],
                //'create_date' => $p['unit_time'],
                'time' => $p['time'],
                'unit_time' => $p['unit_time'],
                //'is_go_live' =>  $p['unit_time'],
                // 'contract_id' =>'',
                // 'project_id' =>  '',

                'ship_to_name1' => $p['ship_to_name1'],
                //'ship_to_name2' => $p['ship_to_name2'],
                'ship_to_address1' => $p['ship_to_address1'],
                'ship_to_address2' => $p['ship_to_address2'],
                'ship_to_address3' => $p['ship_to_address3'],
                'ship_to_address4' => $p['ship_to_address4'],
                'ship_to_district' => $p['ship_to_district'],
                'ship_to_city' => $p['ship_to_city'],
                'ship_to_postal_code' => $p['ship_to_postal_code'],
                'ship_to_country' => $p['ship_to_country'],
                'ship_to_region' => $p['ship_to_region'],
                'ship_to_business_scale' => $p['ship_to_business_scale'],
                //'ship_to_customer_group' => $p['ship_to_customer_group'],
                'ship_to_industry' => $p['ship_to_industry'],

                'ship_to_tel' => $p['ship_to_tel'],
                'ship_to_tel_ext' => $p['ship_to_tel_ext'],
                'ship_to_fax' => $p['ship_to_fax'],
                'ship_to_fax_ext' => $p['ship_to_fax_ext'],
                'ship_to_mobile' => $p['ship_to_mobile'],
                'ship_to_email' => $p['ship_to_email'],
                'ship_to_tax_id' => $p['ship_to_tax_id'], 

                'sold_to_name1' => $p['sold_to_name1'],
                //'sold_to_name2' => $p['sold_to_name2'],   
                'sold_to_address1' => $p['sold_to_address1'],   
                'sold_to_address2' => $p['sold_to_address2'],   
                'sold_to_address3' => $p['sold_to_address3'],   
                'sold_to_address4' => $p['sold_to_address4'],   
                'sold_to_district' => $p['sold_to_district'],           
                'sold_to_city' => $p['sold_to_city'],
                'sold_to_postal_code' => $p['sold_to_postal_code'],   
                'sold_to_country' => $p['sold_to_country'],   
                'sold_to_region' => $p['sold_to_region'],   
                'sold_to_business_scale' => $p['sold_to_business_scale'],   
                //'sold_to_customer_group' => $p['sold_to_customer_group'],   
                'sold_to_industry' => $p['sold_to_industry'],

                'sold_to_tel' => $p['sold_to_tel'],
                'sold_to_tel_ext' => $p['sold_to_tel_ext'],
                'sold_to_fax' => $p['sold_to_fax'],
                'sold_to_fax_ext' => $p['sold_to_fax_ext'],
                'sold_to_mobile' => $p['sold_to_mobile'],
                'sold_to_email' => $p['sold_to_email'],
                'sold_to_tax_id' => $p['sold_to_tax_id'], 
                'required_doc' => $required_doc,  
                'is_cal_vat' => $p['is_cal_vat'],             


            );
           
            $this->db->where('id', $quotation_id); 
            $query=$this->db->update('tbt_quotation', $data);


            $data2 = array( 
                'variant_price_per_person' => 0,  
                'total_variant_price' => 0,  
                'percent_margin' => 0,            
            );

            $this->db->where('quotation_id', $quotation_id); 
            $query2 =$this->db->update('tbt_summary', $data2);

       
         if($query && $query2) {
             $msg = 'แก้ไขเรียบร้อยแล้ว';
            return array('msg'=>$msg);
        } else {
             $msg = 'ผิดพลาด: ไม่สามารถแก้ไขข้อมูลได้';
             return array('msg'=>$msg);
        }   

    }




    public function update_summary($quotation_id){ 

        $this->db->where('quotation_id', $quotation_id); 
        $query =$this->db->delete('tbt_summary');

         if($query) {
             $msg = 'แก้ไขเรียบร้อยแล้ว';
            return array('msg'=>$msg);
        } else {
             $msg = 'ผิดพลาด: ไม่สามารถแก้ไขข้อมูลได้';
             return array('msg'=>$msg);
        }   
    }


     public function upload_file_prospect($description,$is_importance,$path,$prospect_id){       
         $own_by = $this->session->userdata('id');

         $data = array(   
                        'description' => $description,
                        'own_by' => $own_by,
                        'is_approve' => 0,
                        'project_id' => '',
                        'delete_flag' => 0,
                        'path' => $path,
                        'contract_id' => '',
                        'is_importance' => $is_importance,
                        'quotation_id' => '',
                        'prospect_id' => $prospect_id,            
                    );
            
        $query = $this->db->insert('tbt_project_document', $data);

        if($query){
             $msg = 'อัพโหลดไฟล์เรียบร้อยแล้ว';
            return array('msg'=>$msg);
        }else{
             $msg = 'ผิดพลาด: ไม่สามารถอัพโหลดไฟล์ได้';
             return array('msg'=>$msg);
        }
    }

      public function upload_file_quotation($description,$is_importance,$path,$quotation_id){       
         $own_by = $this->session->userdata('id');

         $data = array(   
                        'description' => $description,
                        'own_by' => $own_by,
                        'is_approve' => 0,
                        'project_id' => '',
                        'delete_flag' => 0,
                        'path' => $path,
                        'contract_id' => '',
                        'is_importance' => $is_importance,
                        'quotation_id' => $quotation_id,
                        'prospect_id' => '',            
                    );
            
        $query = $this->db->insert('tbt_project_document', $data);

        if($query){
             $msg = 'อัพโหลดไฟล์เรียบร้อยแล้ว';
            return array('msg'=>$msg);
        }else{
             $msg = 'ผิดพลาด: ไม่สามารถอัพโหลดไฟล์ได้';
             return array('msg'=>$msg);
        }
    }




//#################################################
//==================== DLETE ======================
//#################################################


    public function delete_clearing_chemical($quotation_id){       
       
        //TODO :: delete group
        $this->db->where('quotation_id', $quotation_id);
        $query1=$this->db->delete('tbt_equipment_clearjob');

        if($query1){
            $msg = 'ลบข้อมูลเรียร้อยแล้ว';
            return array('msg'=>$msg);
        }else{
            $msg = 'ผิดพลาด: ไม่สามารถลบข้อมูลได้';
            return array('msg'=>$msg);
        }
    }



    public function delete_man_staff($quotation_id){       
       
        //TODO :: delete group
        $this->db->where('quotation_id', $quotation_id);
        $query1=$this->db->delete('tbt_man_group');

       //TODO :: delete sub group
        $this->db->where('quotation_id', $quotation_id);
        $query2=$this->db->delete('tbt_man_subgroup');
          

        if($query1 && $query2){
            $msg = 'ลบข้อมูลเรียร้อยแล้ว';
            return array('msg'=>$msg);
        }else{
            $msg = 'ผิดพลาด: ไม่สามารถลบข้อมูลได้';
            return array('msg'=>$msg);
        }
    }

     public function delete_area($quotation_id){       
       
        //TODO :: delete area
        $this->db->where('quotation_id', $quotation_id);
        $query1=$this->db->delete('tbt_building');

       //TODO :: delete area
        $this->db->where('quotation_id', $quotation_id);
        $query2=$this->db->delete('tbt_floor');

        //TODO :: delete area
        $this->db->where('quotation_id', $quotation_id);
        $query3=$this->db->delete('tbt_area');  

        if($query1 && $query2 && $query3 ){
            $msg = 'ลบข้อมูลเรียร้อยแล้ว';
            return array('msg'=>$msg);
        }else{
            $msg = 'ผิดพลาด: ไม่สามารถลบข้อมูลได้';
            return array('msg'=>$msg);
        }
    }



     public function delete($doc_type,$id){       
       
        if($doc_type=='prospect'){

            //delete contract
            $this->db->where('tbt_contact.prospect_id', $id);
            $query= $this->db->delete('tbt_contact');  

             //delete doc
            $this->db->where('tbt_project_document.prospect_id', $id);
            $query= $this->db->delete('tbt_project_document');  

            $this->db->where('tbt_prospect.id', $id);
            $query= $this->db->delete('tbt_prospect');  

           

        }else{


             //delete contract
            $this->db->where('tbt_contact.quotation_id', $id);
            $query= $this->db->delete('tbt_contact');  

             //delete doc
            $this->db->where('tbt_project_document.quotation_id', $id);
            $query= $this->db->delete('tbt_project_document');  

             //delete area
            $this->db->where('tbt_building.quotation_id', $id);
            $query= $this->db->delete('tbt_building');  
            $this->db->where('tbt_floor.quotation_id', $id);
            $query= $this->db->delete('tbt_floor');  
            $this->db->where('tbt_area.quotation_id', $id);
            $query= $this->db->delete('tbt_area');  

             //delete staff
            $this->db->where('tbt_man_group.quotation_id', $id);
            $query= $this->db->delete('tbt_man_group');  
            $this->db->where('tbt_man_subgroup.quotation_id', $id);
            $query= $this->db->delete('tbt_man_subgroup'); 

            $this->db->where('tbt_equipment.quotation_id', $id);
            $query= $this->db->delete('tbt_equipment');   
            $this->db->where('tbt_equipment_clearjob.quotation_id', $id);
            $query= $this->db->delete('tbt_equipment_clearjob');   

            $this->db->where('tbt_other_service.quotation_id', $id);
            $query= $this->db->delete('tbt_other_service');   

            $this->db->where('tbt_summary.quotation_id', $id);
            $query= $this->db->delete('tbt_summary');   

            $this->db->where('replaced_by', $id);
            $query= $this->db->update('tbt_quotation', array('status' => 'effective', 'replaced_by' => '')); 

            $this->db->where('tbt_quotation.id', $id);
            $query= $this->db->delete('tbt_quotation');              

        }

        if($query){
            return TRUE;
            //return self::response($msg);
        }else{
            return FALSE;
            //return self::response($msg);
        }
    }


    public function delete_contact_model($id){       
       
          
        $this->db->where('id', $id);
        $query=$this->db->delete('tbt_contact');      

        if($query){
            $msg = 'ลบไฟล์เรียบร้อยแล้ว';
            return array('msg'=>$msg);
        }else{
            $msg = 'ผิดพลาด: ไม่สามารถลบไฟล์ได้';
            return array('msg'=>$msg);
        }
    }


    public function delete_service_model($id){       
       
          
        $this->db->where('id', $id);
        $query=$this->db->delete('tbt_other_service');      

        if($query){
            $msg = 'ลบไฟล์เรียบร้อยแล้ว';
            return array('msg'=>$msg);
        }else{
            $msg = 'ผิดพลาด: ไม่สามารถลบไฟล์ได้';
            return array('msg'=>$msg);
        }
    }


    public function delete_chemical($id){       
                 
        $this->db->where('quotation_id', $id);
        $query=$this->db->delete('tbt_equipment');      

        if($query){
            $msg = 'ลบไฟล์เรียบร้อยแล้ว';
            return array('msg'=>$msg);
        }else{
            $msg = 'ผิดพลาด: ไม่สามารถลบไฟล์ได้';
            return array('msg'=>$msg);
        }
    }





//####################################################################
//============= GET TAB 3 :: SUBJECT CHEMICAL AND OTHER ==============
//####################################################################


    public function get_tbt_equipment($quotation_id,$is_customer_request){
        
        $this->db->select('tbt_equipment.*');  
        $this->db->select('sap_tbm_material.material_description');
        $this->db->join('sap_tbm_material', 'sap_tbm_material.material_no = tbt_equipment.material_no','left');


        $this->db->where('tbt_equipment.quotation_id',$quotation_id);  
        $this->db->where('tbt_equipment.is_customer_request',$is_customer_request);

        if($is_customer_request==0){
            $this->db->order_by("tbt_equipment.texture_id", "desc"); 
        }


        $result = $this->db->get('tbt_equipment'); 
             

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


    public function update_tbt_equipment($id,$space,$quantity,$total_price){
        
        $data1 = array(
            'space' => $space,
            'quantity' => $quantity,
            'total_price' => $total_price,
                             
        );

        //$this->db->where('tbt_area.clear_job_type_id', $clearing_type_id);
        $this->db->where('tbt_equipment.id', $id);
        $query1 =$this->db->update('tbt_equipment', $data1);

     
        if($query1){
             $msg = 'แก้ไขข้อมูลเรียบร้อยแล้ว';
            return array('msg'=>$msg);
        }else{
             $msg = 'ผิดพลาด: ไม่สามารถเพิ่มข้อมูลได้';
             return array('msg'=>$msg);
        }//end else   

    }

    public function sap_tbm_function(){
        
        $this->db->select('sap_tbm_function.*');
        $this->db->order_by("sap_tbm_function.description", "asc");        
        $result = $this->db->get('sap_tbm_function');      

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

      public function sap_tbm_department(){
        
        $this->db->select('sap_tbm_department.*');  
        $this->db->order_by("sap_tbm_department.title", "asc");      
        $result = $this->db->get('sap_tbm_department');      

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


    public function sap_tbm_distribution_channel(){
        
        $this->db->select('sap_tbm_distribution_channel.*');       
        $result = $this->db->get('sap_tbm_distribution_channel');      

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

     public function get_sap_tbm_mat_group($job_type){
        
        $this->db->select('sap_tbm_mat_group.*');  
        $this->db->where('sap_tbm_mat_group.mat_type','Z005');      
        $query = $this->db->get('sap_tbm_mat_group');      

        $result = $query->result_array();
        $output = array();
        foreach ($result as $key => $mat) {
            $result = $this->get_ajax_sap_tbm_mat_group($mat['id'],$job_type);
            
            if (!empty($result) && $result['success'] == true) {
                array_push($output, $mat);
            }
        }
        // if(!empty($result)){
        //         // $output = array();
        //         // $state = true;
        //         // $code = '000';
        //         // $msg = '';
        //         $output = $result;
        // }else{
        //         // $state = false;
        //         // $code = '909';
        //         // $msg = '';
        //         $output = $result;
        // }
       // return self::response($state,$code,$msg,$output);
        return $output;
    }


      public function get_bomb(){
        
        $this->db->select('sap_tbm_bomb.*');
        $this->db->select('sap_tbm_mat_price.price');
        $this->db->join('sap_tbm_bomb', 'sap_tbm_mat_price.material_no = sap_tbm_bomb.material_no','left');        
        //$this->db->where('sap_tbm_material.mat_type','Z016'); 
        $this->db->where('sap_tbm_mat_price.valid_from <=',date("Y-m-d"));
        $this->db->where('sap_tbm_mat_price.valid_to >=',date("Y-m-d"));   
        
        $result = $this->db->get('sap_tbm_mat_price');      

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






 public function get_chemical_and_other_byID($id,$type,$job_type){       

        $this->db->select('sap_tbm_material.material_no,sap_tbm_material.material_description,sap_tbm_material.unit_code,sap_tbm_material.mat_type,sap_tbm_material.mat_group');        
        $this->db->select('sap_tbm_mat_price.price');

        $this->db->join('sap_tbm_mat_price', 'sap_tbm_mat_price.material_no = sap_tbm_material.material_no','left');

if($type=='Z005'){
        $this->db->where('sap_tbm_mat_price.doc_type',$job_type);
}
        $this->db->where('sap_tbm_mat_price.valid_from <=',date("Y-m-d"));
        $this->db->where('sap_tbm_mat_price.valid_to >=',date("Y-m-d"));  

        $this->db->where('sap_tbm_material.mat_type',$type); 
        $this->db->where('sap_tbm_material.material_no',$id);        
        $result = $this->db->get('sap_tbm_material');         
        
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




 public function get_chemical_and_other_byID_clearing($id,$type){       

        $this->db->select('sap_tbm_material.material_no,sap_tbm_material.material_description,sap_tbm_material.unit_code,sap_tbm_material.mat_type,sap_tbm_material.mat_group');        
        $this->db->select('sap_tbm_mat_price.price');

        $this->db->join('sap_tbm_mat_price', 'sap_tbm_mat_price.material_no = sap_tbm_material.material_no','left');

if($type=='Z005'){
        $this->db->where('sap_tbm_mat_price.doc_type','ZQT2');
}
        $this->db->where('sap_tbm_mat_price.valid_from <=',date("Y-m-d"));
        $this->db->where('sap_tbm_mat_price.valid_to >=',date("Y-m-d"));  

        $this->db->where('sap_tbm_material.mat_type',$type); 
        $this->db->where('sap_tbm_material.material_no',$id);        
        $result = $this->db->get('sap_tbm_material');         
        
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



//####################################################################
//============= GET TAB 5 :: clearing jbo ============================
//####################################################################

 public function get_tbt_equipment_clearjob($quotation_id){
        
        $this->db->select('tbt_equipment_clearjob.*');  
        $this->db->select('sap_tbm_material.material_description');
        $this->db->join('sap_tbm_material', 'sap_tbm_material.material_no = tbt_equipment_clearjob.material_no','left');


        $this->db->where('tbt_equipment_clearjob.quotation_id',$quotation_id);  
        $result = $this->db->get('tbt_equipment_clearjob');             

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

    public function getAreaDetail ($quotation_id) {

        $this->db->select('tbt_area.*, tbt_building.title as building, tbt_floor.title as floor');
        $this->db->join('tbt_building', 'tbt_area.building_id = tbt_building.id');
        $this->db->join('tbt_floor', 'tbt_area.floor_id = tbt_floor.id');
        $this->db->where('tbt_area.quotation_id', $quotation_id);

        $query = $this->db->get('tbt_area');
        $result = $query->result_array();

        return $result;
    }


}//end model

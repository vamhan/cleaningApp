<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class __complain_model extends MY_Model{

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

    
    public function getContentList_complain($page=1,$tempMatch='',$order=array()){
        // $actor_by_id = $this->session->userdata('id');

        $table = 'tbt_complain';           
        $this->db->select('tbt_complain.*'); 
        $this->db->select('tbt_user.user_firstname ,tbt_user.user_lastname'); 
        $this->db->join('tbt_user', 'tbt_user.employee_id = tbt_complain.raise_by_id','left');
        $this->db->where('tbt_complain.delete_flag',0);
        //$this->db->where('tbt_complain.raise_by_id',$actor_by_id);
        //$this->db->get($table);
        $this->db->order_by("tbt_complain.id", "desc"); 

        ///////////////////////// start : serch ////////////////////////////////
         $config = Array(     
                    "visible_column" => Array
                        (
                            Array
                                (
                                    "name" => "tbt_complain.id"                                   
                                ),
                            Array
                            (
                                "name" => "tbt_complain.ship_to_id"                                   
                            ),
                            Array
                            (
                                "name" => "tbt_complain.ship_to_name1"                                   
                            ),                                                                                               
                        )
                );

        //==Set up keyword Search 
            if(empty($tempMatch)){  $match = $this->input->post('search');   }else{  $match = $tempMatch;  }
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

        
            $output = array();
                $state = true;
                $code = '000';
                $msg = '';

               // $output['total_item'] = self::getResultTotalpage_doucument($table,$keyword);
                $output['temp_match'] = $match;
                $output['total_item'] = self::getResultTotalpage($table,array('tbt_complain.delete_flag' => 0));
                $output['list'] = $result;
                $output['page'] = $page;
                $output['page_size'] = $this->pageSize;
                $output['project_id'] = '';              
                //$output['total_page'] = ceil(self::getResultTotalpage_doucument($table,$keyword)/$this->pageSize);
                $output['total_page'] = ceil(self::getResultTotalpage($table)/$this->pageSize);   

        return self::response($state,$code,$msg,$output);
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


//////////////////////////////////////////////////////////////////////
//======================== QUERY ====================================
////////////////////////////////////////////////////////////////////

 public function master_type_complain(){        
        $this->db->select('ppr_tbm_type_complain.*');
        $this->db->order_by("ppr_tbm_type_complain.id", "ASC");       
        $result = $this->db->get('ppr_tbm_type_complain');  


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


 public function master_pb_type(){        
        $this->db->select('ppr_tbm_problem_type.*');
        $this->db->order_by("ppr_tbm_problem_type.id", "ASC");       
        $result = $this->db->get('ppr_tbm_problem_type');  


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

     public function master_pb_list(){        
        $this->db->select('ppr_tbm_problem_list.*'); 
        $this->db->order_by("ppr_tbm_problem_list.id", "ASC");      
        $result = $this->db->get('ppr_tbm_problem_list');      

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


     public function query_complain($id){
        
        $this->db->select('tbt_complain.*');
        $this->db->select('tbt_user.user_firstname ,tbt_user.user_lastname'); 
        $this->db->select('sap_tbm_ship_to.ship_to_name1,sap_tbm_ship_to.ship_to_distribution_channel,sap_tbm_ship_to.ship_to_branch_des,sap_tbm_ship_to.ship_to_city');
        $this->db->join('sap_tbm_ship_to', 'sap_tbm_ship_to.id = tbt_complain.ship_to_id','left'); 
        $this->db->join('tbt_user', 'tbt_user.employee_id = tbt_complain.raise_by_id','left');   
      
        $this->db->where('tbt_complain.id',$id);  
        $result = $this->db->get('tbt_complain');      

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

//////////////////////////////////////////////////////////////////////
//======================== QUERY ajax ===============================
////////////////////////////////////////////////////////////////////

 public function get_problem_list_day_ajax($id){
     $this->db->select('ppr_tbm_problem_list.*'); 
     $this->db->order_by("ppr_tbm_problem_list.id", "ASC");     
     $this->db->where('ppr_tbm_problem_list.id',$id);
     $result = $this->db->get('ppr_tbm_problem_list'); 
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

 public function get_problem_list_ajax($id){
     $this->db->select('ppr_tbm_problem_list.*');  
     $this->db->order_by("ppr_tbm_problem_list.id", "ASC");  
     $this->db->where('ppr_tbm_problem_list.problem_type_id',$id);     
     $result = $this->db->get('ppr_tbm_problem_list'); 
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



    
 public function get_ship_to_by_plant_ajax($id){
    $date_today = date('Y-m-d');

     $this->db->distinct();
     $this->db->select('sap_tbm_ship_to.*,sap_tbm_ship_to.id As ship_to_id');
     $this->db->select('tbt_quotation.project_start,tbt_quotation.project_end');  
     $this->db->join('tbt_quotation', 'tbt_quotation.ship_to_id = sap_tbm_ship_to.id','left');
     //$this->db->join('sap_tbm_ship_to', 'sap_tbm_ship_to.id = tbt_quotation.ship_to_id ','left');
     $this->db->where('tbt_quotation.status','EFFECTIVE');
     $this->db->where('tbt_quotation.project_start !=', '0000-00-00');
     //$this->db->where('tbt_quotation.project_start <=', $date_today);
 

     $this->db->where('sap_tbm_ship_to.plant_code',$id);     
     $result = $this->db->get('sap_tbm_ship_to'); 
     //$result = $this->db->get('tbt_quotation'); 

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
        
       // $this->db->join('tbt_quotation', 'tbt_quotation.ship_to_id = sap_tbm_ship_to.id','left');


        $this->db->where('sap_tbm_ship_to.id',$id);
        //$this->db->where('tbt_quotation.status','EFFECTIVE');  

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


 public function get_sap_tbm_contact_ajax($id){
        
        $this->db->select('sap_tbm_contact.*,sap_tbm_contact.id As contact_id');
        $this->db->where('sap_tbm_contact.ship_to_id',$id);     
        $result = $this->db->get('sap_tbm_contact');            
        
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



 public function get_customer_detail_ajax($id){
        
        $this->db->select('sap_tbm_contact.*,sap_tbm_contact.id As contact_id');
        $this->db->where('sap_tbm_contact.id',$id);     
        $result = $this->db->get('sap_tbm_contact');            
        
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



//////////////////////////////////////////////////////////////////////
//======================== INSERT ===================================
////////////////////////////////////////////////////////////////////
 public function zyn_type_complain($id,$title){
       $data = array(
        'id' => $id,
        'title' => $title,
     );

    $query=$this->db->insert('ppr_tbm_type_complain', $data);

    if($query){
         $msg = 'เพิ่มข้อมูลเรียบร้อยแล้ว';
        return array('msg'=>$msg);
    }else{
         $msg = 'ผิดพลาด: ไม่สามารถเพิ่มข้อมูลได้';
         return array('msg'=>$msg);
    }//end else   
}



 public function zyn_pb_type($id,$title){
       $data = array(
        'id' => $id,
        'title' => $title,
     );

    $query=$this->db->insert('ppr_tbm_problem_type', $data);

    if($query){
         $msg = 'เพิ่มข้อมูลเรียบร้อยแล้ว';
        return array('msg'=>$msg);
    }else{
         $msg = 'ผิดพลาด: ไม่สามารถเพิ่มข้อมูลได้';
         return array('msg'=>$msg);
    }//end else   
}

 public function zyn_pb_list($id,$title,$type_id,$day){
       $data = array(
        'id' => $id,
        'title' => $title,
        'day' => $day,
        'problem_type_id' => $type_id,
     );

    $query=$this->db->insert('ppr_tbm_problem_list', $data);

    if($query){
         $msg = 'เพิ่มข้อมูลเรียบร้อยแล้ว';
        return array('msg'=>$msg);
    }else{
         $msg = 'ผิดพลาด: ไม่สามารถเพิ่มข้อมูลได้';
         return array('msg'=>$msg);
    }//end else   
}

 public function insert_complain($p){

if(!empty($p['customer_id'])){
//get contact
$this->db->select('sap_tbm_contact.*,sap_tbm_contact.id As contact_id');
$this->db->where('sap_tbm_contact.id',$p['customer_id']);     
$query_data_customer = $this->db->get('sap_tbm_contact');           
$data_customer = $query_data_customer->row_array(); 
$contact_first_name = $data_customer['firstname'].' '.$data_customer['lastname'];
$ship_to_department  = $data_customer['department_des'];
$ship_to_function    = $data_customer['function_des'];
}else{
$p['customer_id']=0;
$contact_first_name = $p['name_contact'].' '.$p['lastname_contact'];
$ship_to_department  = $p['ship_to_department'];
$ship_to_function    = $p['ship_to_function'];

}

         //=== insert to : tbt_equipment =====
         $data = array(
            'input_method' => $p['input_method'],
            'create_date' => $p['create_date'],
            'raise_by_id' => $p['raise_by_id'],
            'contract_id' => $p['contract_id'],
            'ship_to_id' => $p['ship_to_id'],
            'contact_id' => $p['customer_id'],
            'place' => $p['place_problem'],
            'detail' => $p['detail_problem'],
            'problem' => $p['complain_problem'],
            'problem_type_id' => $p['problem_type_id'],
            'problem_list_id' => $p['problem_list_id'],
            'problem_level' => $p['problem_level'], 

            'plant_code' => $p['plant_code'],
            'plant_name' => $p['plant_name'],
            'ins_id'     => $p['examiner_id'],
            'ins_name'   => $p['examiner_name'],          

            'ship_to_name1' => $p['ship_to_name'],
            'ship_to_distribution_channel' => $p['ship_to_distribution_channel'],
            'ship_to_branch_id' => $p['ship_to_branch_id'],
            'ship_to_branch_des' => $p['ship_to_branch_des'], 
             
            'contact_first_name' => $contact_first_name, 
            'contact_function_des' => $ship_to_department,  
            'contact_department_des' => $ship_to_function,

            'problem_type_title' => $p['problem_type_title'],
            'problem_list_title' => $p['problem_list_title'], 
            
            'delete_flag' => 0,  

            'submit_date_papyrus' => "0000-00-00",
            'completedate' => $p['completedate'],            
                                            
        );

        $query=$this->db->insert('tbt_complain', $data);
        $last_id = $this->db->insert_id();

        if($query){
             $msg = 'เพิ่มข้อมูลเรียบร้อยแล้ว';
             $last_id = $last_id;
            return array('msg'=>$msg,'last_id'=>$last_id);
        }else{
             $msg = 'ผิดพลาด: ไม่สามารถเพิ่มข้อมูลได้';
             $last_id = $last_id;
             return array('msg'=>$msg,'last_id'=>$last_id);
        }//end else   
}

//////////////////////////////////////////////////////////////////////
//======================== UPDATE ===================================
////////////////////////////////////////////////////////////////////

 public function update_submit_to_ppr($id,$input_method,$place,$detail,$problem,$problem_type_id,$problem_list_id,$problem_level,$completedate){

    $data1 = array(
        'input_method' => $input_method,
        'place' => $place,
        'detail' => $detail,
        'problem' => $problem,
        'problem_type_id' => $problem_type_id,
        'problem_list_id' => $problem_list_id,
        'problem_level' => $problem_level,
        'completedate' => $completedate,
        'submit_date_papyrus' => date('Y-m-d'),
    );


    $this->db->where('tbt_complain.id', $id);
    $query1 =$this->db->update('tbt_complain', $data1);

    if($query1){
         $msg = 'แก้ไขข้อมูลเรียบร้อยแล้ว';
        return array('msg'=>$msg);
    }else{
         $msg = 'ผิดพลาด: ไม่สามารถเพิ่มข้อมูลได้';
         return array('msg'=>$msg);
    }//end else   
}


 public function update_complain($id,$p){

if(!empty($p['customer_id'])){
$this->db->select('sap_tbm_contact.*,sap_tbm_contact.id As contact_id');
$this->db->where('sap_tbm_contact.id',$p['customer_id']);     
$query_data_customer = $this->db->get('sap_tbm_contact');           
$data_customer = $query_data_customer->row_array(); 
$contact_first_name = $data_customer['firstname'].' '.$data_customer['lastname'];
$ship_to_department  = $data_customer['department_des'];
$ship_to_function    = $data_customer['function_des'];
}else{
$p['customer_id']=0;
$contact_first_name = $p['contact_first_name'];
$ship_to_department  = $p['ship_to_department'];
$ship_to_function    = $p['ship_to_function'];

}
        $data1 = array(
            'input_method' => $p['input_method'],
            'create_date' => $p['create_date'],
            'raise_by_id' => $p['raise_by_id'],
            'contract_id' => $p['contract_id'],
            'ship_to_id' => $p['ship_to_id'],
            'contact_id' => $p['customer_id'],
            'place' => $p['place_problem'],
            'detail' => $p['detail_problem'],
            'problem' => $p['complain_problem'],
            'problem_type_id' => $p['problem_type_id'],
            'problem_list_id' => $p['problem_list_id'],
            'problem_level' => $p['problem_level'],

            'plant_code' => $p['plant_code'],
            'plant_name' => $p['plant_name'],
            'ins_id'     => $p['examiner_id'],
            'ins_name'   => $p['examiner_name'],          

            'ship_to_name1' => $p['ship_to_name'],
            'ship_to_distribution_channel' => $p['ship_to_distribution_channel'],
            'ship_to_branch_id' => $p['ship_to_branch_id'],
            'ship_to_branch_des' => $p['ship_to_branch_des'], 
             
            'contact_first_name' => $contact_first_name, 
            'contact_function_des' => $ship_to_function, 
            'contact_department_des' => $ship_to_department, 

            'problem_type_title' => $p['problem_type_title'],
            'problem_list_title' => $p['problem_list_title'],

            'delete_flag' => 0,

            'submit_date_papyrus' => "0000-00-00",
            'completedate' => $p['completedate'],                         
        );

        $this->db->where('tbt_complain.id', $id);
        $query1 =$this->db->update('tbt_complain', $data1);

        if($query1){
             $msg = 'แก้ไขข้อมูลเรียบร้อยแล้ว';
            return array('msg'=>$msg);
        }else{
             $msg = 'ผิดพลาด: ไม่สามารถเพิ่มข้อมูลได้';
             return array('msg'=>$msg);
        }//end else   
}

//////////////////////////////////////////////////////////////////////
//======================== DELETE  ==================================
////////////////////////////////////////////////////////////////////
 public function delete_complain($id){

    $data1 = array(    
        'delete_flag' => 1,
     );
    $this->db->where('tbt_complain.id', $id);
    $query1 =$this->db->update('tbt_complain', $data1);

// $this->db->where('tbt_complain.id', $id);
// $query=$this->db->delete('tbt_complain');      
    if($query){
        $msg = 'ลบไฟล์เรียบร้อยแล้ว';
        return array('msg'=>$msg);
    }else{
        $msg = 'ผิดพลาด: ไม่สามารถลบไฟล์ได้';
        return array('msg'=>$msg);
    }

 }


//////////////////////////////////////////////////////////////////////
//======================== uoload photo  ==================================
////////////////////////////////////////////////////////////////////


 public function upload_photo($file_name,$file_type,$complain_id,$path){       
         $own_by = $this->session->userdata('id');

         $data = array(   
                        'file_name' => $file_name,
                        'file_type' => $file_type,
                        'object_id' => $complain_id,
                        'object_table' => 'tbt_complain',
                        'path' => $path,
                        'own_by' => $own_by,                        
                    );
            
        $query = $this->db->insert('tbt_attach_file', $data);

        if($query){
             $msg = 'อัพโหลดไฟล์เรียบร้อยแล้ว';
            return array('msg'=>$msg);
        }else{
             $msg = 'ผิดพลาด: ไม่สามารถอัพโหลดไฟล์ได้';
             return array('msg'=>$msg);
        }
    }





    public function get_images_complain($complain_id){
        
        $this->db->select('tbt_attach_file.file_name,tbt_attach_file.id,tbt_attach_file.path,tbt_attach_file.own_by,tbt_user.user_firstname,tbt_user.user_lastname');
        $this->db->join('tbt_user', 'tbt_user.employee_id = tbt_attach_file.own_by','left');  
        $this->db->where('tbt_attach_file.object_id',$complain_id);    
        $result = $this->db->get('tbt_attach_file');      

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


     

}//end model

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class __cms_docother extends MY_Model{

    function __construct(){
        parent::__construct();
    }  

    function getAlldoc () {

        //$this->db->where('date !=', '0000-00-00');

        ///////////////////////// start : serch ////////////////////////////////
         $config = Array(     
                    "visible_column" => Array
                        (
                            Array
                                (
                                    "name" => "cms_document_other.description"                                   
                                ), 
                                                                                                           
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

        $query = $this->db->get('cms_document_other');
        $result = $query->result_array();

        $query = $this->db->get('cms_document_other_en');
        $result_en = $query->result_array();

        return array('th' => $result, 'en' => $result_en);
    }


  public function upload_file($description,$industry,$path,$date,$lang){      
         //$own_by = $this->session->userdata('id');
         $data = array(   
                        'description' => $description,
                        'path' => $path,
                        'industry_id' => $industry,
                        'create_date' => $date,                       
                    );        

        if ($lang == 'en') {
          $query = $this->db->insert('cms_document_other_en', $data);
        } else {
          $query = $this->db->insert('cms_document_other', $data);
        }

        if($query){
             $msg = 'อัพโหลดไฟล์เรียบร้อยแล้ว';
            return array('msg'=>$msg);
        }else{
             $msg = 'ผิดพลาด: ไม่สามารถอัพโหลดไฟล์ได้';
             return array('msg'=>$msg);
        }
  }


    public function delete_file($id){      
        $this->db->where('id', $id); 
        $query =$this->db->delete('cms_document_other');

        if($query){
             $msg = 'ลบไฟล์เรียบรอ้ยแล้ว';
            return array('msg'=>$msg);
        }else{
             $msg = 'ผิดพลาด: ไม่สามารถลบไฟล์ได้';
             return array('msg'=>$msg);
        }
  }



}

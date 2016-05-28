<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class __proto_content_detail extends REST_Model{

    function __construct(){
        parent::__construct();
        

        if(!isset($this->pageSize) || empty($this->pageSize)){
            $this->pageSize = PAGESIZE;
        }


        // //Modify 10/14/2013
        // //Loading sample NU-SOAP
        // $this->load->library("nusoap_lib");
        // $this->webservice_url = "http://116.246.12.67:8090/web/ws_member.asmx?WSDL";
        // $this->webservice_usercode = "BE";
        // $this->webservice_userpass = "123";

    }



    public function edit($table,$params,$id){
        
        $this->db->where('id',$id);
        $this->db->update($table,$params);
            return $this->db->affected_rows();
    }



    public function create($table,$params){
        
        $this->db->insert($table,$params);
            return $this->db->affected_rows();
    }




    //TODO :: Temporary -> remove it later 
    public function getPageDetail($category){
        // die($category);
        $this->db->where('page_title',$category);
        $result = $this->db->get('cms_page');
        $result = $result->result_array();
    
         $state = true;
            $code = '000';
            $msg = '';
            $output = $result[0];
        return self::response($state,$code,$msg,$output);
    }




    public function getItemById($table,$id){
        
        $this->db->where('delete_flag',0);

        if(!empty($object_category_id)){
            //TODO :: implement only if object has category id
        }

        //TODO :: implement search condition with keyword search
        if(!empty($id))
            $this->db->where('id',$id);
        $result  = $this->db->get($table);
        $result = $result->result_array();

        if(!empty($result)){
                // $output = array();
                $state = true;
                $code = '000';
                $msg = '';
                $output = $result;
        }else{
                $state = false;
                $code = '909';
                $msg = '';
                $output = $result;
        }
        return self::response($state,$code,$msg,$output);
    }


}

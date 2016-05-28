<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class projectModel extends MY_Model{

    function __construct(){
        parent::__construct();
    }


public function getContentList($table,$config,$page){
        
        $selectCol = '';
          if(!empty($config['visible_column']))
            { 
              $th = '';
              foreach ($config['visible_column'] as $key => $value) {
                if(!empty($selectCol))$selectCol.=',';
                $selectCol .= $value['name'];
              }//end foreach
            }
        
        if(!empty($selectCol))
            $this->db->select($selectCol);
            //$this->db->where('delete_flag',0);



        //Set up keyword Search 
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


        // //Setup condition
        // if(!empty($object_category_id)){
        //     //TODO :: implement only if object has category id
        // }

        //TODO :: implement search condition with keyword search
        $result = self::getResultWithPage($table,$page);
        // $result  = $this->db->get($table);
        $count = $result->num_rows();
        $result = $result->result_array();
            $output = array();
                $state = true;
                $code = '000';
                $msg = '';
                $output['total_item'] = self::getResultTotalpage($table);
                $output['list'] = $result;
                $output['page'] = $page;
                $output['page_size'] = $this->pageSize;                 
             //echo self::getResultTotalpage($table)."|".$this->pageSize;

                $output['total_page'] = ceil(self::getResultTotalpage($table)/$this->pageSize);
        return self::response($state,$code,$msg,$output);

    }






      public function getContentById($table,$id){        
        

        //TODO :: implement search condition with keyword search
        if(!empty($id))
            $this->db->where('id',$id);
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












    
}//end model

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class __proto_content_list extends REST_Model{

    function __construct(){
        parent::__construct();
        

        if(!isset($this->pageSize) || empty($this->pageSize)){
            $this->pageSize = PAGESIZE;
        }

        $page_n = intval($this->session->userdata('current_page'));
        if(!empty($page_n)){
             $this->pageSize = $page_n;
        }


        // //Modify 10/14/2013
        // //Loading sample NU-SOAP
        // $this->load->library("nusoap_lib");
        // $this->webservice_url = "http://116.246.12.67:8090/web/ws_member.asmx?WSDL";
        // $this->webservice_usercode = "BE";
        // $this->webservice_userpass = "123";

    }


    public function create($table,$options,$unique=''){

        if(!empty($unique)){
                if(self::isDuplicateOn($table,$unique,$options[$unique]))
                    return false;
        }

        if(!empty($options)){
            $options['create_date'] = $this->getCurrentDateTimeForMySQL();    
            $this->db->insert($table,$options);
            return $this->db->affected_rows();
        }
        return false;
    }



    public function update($table,$options,$condition){
        
        if(!empty($condition)){
            $this->db->where($condition);
        }

        if(!empty($options)){
            $options['update_date'] = $this->getCurrentDateTimeForMySQL();    
            $this->db->update($table,$options);
            return $this->db->affected_rows();
        }
        return false;
    }


    public function delete($table,$condition){
        $this->db->where($condition);
        $this->db->delete($table);
    }


     //  public function listviewContent($category,$page,$keyword){
    //     $output = array();
    //     // $this->trace(array($category,$page,$keyword));
    //     //Find table 
        


    //     $this->db->where('delete_flag',0);

    //     //Setup condition
    //     // if(!empty($object_category_id)){
    //     //     //TODO :: implement only if object has category id
    //     // }

    //     //TODO :: implement search condition with keyword search

    //     $result = self::getResultWithPage($table,$page);
    //     // $result  = $this->db->get($table);
    //     $count = $result->num_rows();
    //     $result = $result->result_array();
            
    //             $state = true;
    //             $code = '000';
    //             $msg = '';
    //             $output['total_item'] = $count;
    //             $output['list'] = $result;
    //             $output['page'] = $page;
    //             $output['total_page'] = round($count/$this->pageSize);

    //     return self::response($state,$code,$msg,$output);

    // }


    public function getPageDetail($category){
        // die($category);
        $this->db->where('page_title',$category);
        $result = $this->db->get('cms_page');
        $result = $result->result_array();
    
        if(empty($result)){
            
            $state = false;
            $code = '909';
            $msg = '';
            $output = array();
        }else{
            $state = true;
            $code = '000';
            $msg = '';
            $output = $result;
        }  
    

         //    $state = true;
         //    $code = '000';
         //    $msg = '';
         //    $output = $result[0];
        return self::response($state,$code,$msg,$output);
    }


    // public function listview($table,$object_category_id,$page){
        
    //     $this->db->where('delete_flag',0);

    //     //Setup condition
    //     if(!empty($object_category_id)){
    //         //TODO :: implement only if object has category id
    //     }

    //     //TODO :: implement search condition with keyword search

    //     $result = self::getResultWithPage($table,$page);
    //     // $result  = $this->db->get($table);
    //     $count = $result->num_rows();
    //     $result = $result->result_array();
    //         $output = array();
    //             $state = true;
    //             $code = '000';
    //             $msg = '';
    //             $output['total_item'] = self::getResultTotalpage($table);
    //             $output['list'] = $result;
    //             $output['page'] = $page;
    //             $output['page_size'] = $this->pageSize;
    //             $output['total_page'] = ceil(self::getResultTotalpage($table)/$this->pageSize);

    //     return self::response($state,$code,$msg,$output);

    // }


       public function listviewContent($table,$config,$object_category_id,$page){
        
        //Set select column 
        $selectCol = '';
          if(!empty($config['listview'])){
              $th = '';
              foreach ($config['listview'] as $key => $value) {
                //Always query id and visible item;
                if(empty($value['visible']) && $value['name'] != 'id')continue;
                if(!empty($selectCol))$selectCol.=',';
                $selectCol .= $value['name'];
              }//end foreach
          }
            
        

        //Set select with not deleted item
        if(!empty($selectCol))
            $this->db->select($selectCol);
        $this->db->where('delete_flag',0);



        if( array_key_exists('page', $config) ){
            if(!empty($config['page']['sort_index']) && !empty($config['page']['sort_direction']))
                $this->db->order_by($config['page']['sort_index'],$config['page']['sort_direction']);
        }



        //Set Search able column 
        $allowedToSearchList = array();
        $allowedToSearch = $this->db->field_data($table);
        foreach ($allowedToSearch as $field)
        {   
            //Allow to search on varchar 
            if($field->type == 'varchar'){
                array_push($allowedToSearchList, $field->name);
            }
            //Debug
            //echo $field->name.' :: ';echo $field->type.' :: ';echo $field->max_length.' :: ';echo $field->primary_key.' <hr/>';
        }

        

        //Set up keyword Search 
        $match = $this->input->post('search');
        $condition_count = 0;
        if(!empty($match)){
            // $this->db->like('page_title',$match);
             if(!empty($config['listview'])){
              foreach ($config['listview'] as $key => $value) {                
                // if(empty($value['visible']) && $value['name'] != 'id')continue;
                if(!in_array($value['name'], $allowedToSearchList))continue;

                    if($condition_count++ < 1){
                        $this->db->like($value['name'],$match);
                    }else{
                        $this->db->or_like($value['name'],$match);
                    }
              }//end foreach
            }
        }//end if



        //Setup condition
        if(!empty($object_category_id)){
            //TODO :: implement only if object has category id
        }

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
                $output['total_page'] = ceil(self::getResultTotalpage($table)/$this->pageSize);

        return self::response($state,$code,$msg,$output);

    }































    public function listviewCfg($table,$config,$object_category_id,$page){
        
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
        $this->db->where('delete_flag',0);




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





        //Setup condition
        if(!empty($object_category_id)){
            //TODO :: implement only if object has category id
        }

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



    


    //TODO :: Implement this later 
    public function listviewCfgWithComplex($table,$config,$object_category_id,$page){


          if( !empty($config['table']) ){
                    $sel = '';
                    $from = '';
                    $join = array();
                    foreach ($config['table'] as $key => $value) {
                        
                            if(is_array($value['select'])){
                                foreach ($value['select'] as $select_key => $select_value) {
                                    if(!empty($sel))$sel .= ' , ';
                                    $sel .= $value['table_name'].'.'.$select_value['col'].(  !empty($select_value['alias'])?" AS ".$select_value['alias']:"" );
                                }//end select for
                            }else{
                                $sel .= $value['table_name'].'.'.$value['select'];
                            }//end if
                        
                         if($value['type']=='primary_table'){
                            $from = $value['table_name'];
                         }else if($value['type']=='extend_table'){
                            array_push($join, array('join'=>$value['join'],'table_name'=>$value['table_name'],'on'=>$value['on']));
                         }//end table type

                    }//end table for

                    $this->db->select($sel);
                    $this->db->from($from);

                    // var_dump($join);
                    // die('x');

                    foreach ($join as $join_key => $join_value) {
                        // var_dump($join_value);
                        $this->db->join($join_value['table_name'],$join_value['on'],$join_value['join']);
                    }


                    // $result = $this->db->get();
                    // $result = $result->result_array();

                    // echo $this->db->last_query();
                    // var_dump($result);
                    // die('x');

                    
            }//end table if
        
        // $selectCol = '';
        //   if(!empty($config['visible_column']))
        //     { 
        //       $th = '';
        //       foreach ($config['visible_column'] as $key => $value) {
        //         if(!empty($selectCol))$selectCol.=',';
        //         $selectCol .= $value['name'];
        //       }//end foreach
        //     }
        
        // if(!empty($selectCol))
        //     $this->db->select($selectCol);
        // $this->db->where('delete_flag',0);

        // //Setup condition
        // if(!empty($object_category_id)){
        //     //TODO :: implement only if object has category id
        // }

        // //TODO :: implement search condition with keyword search

        $result = self::getResultWithPage('',$page);
        var_dump($result);

        // $result  = $this->db->get($table);
        $count = $result->num_rows();
        $result = $result->result_array();
            $output = array();
                $state = true;
                $code = '000';
                $msg = '';
                $output['total_item'] = $count;
                $output['list'] = $result;
                $output['page'] = $page;
                $output['total_page'] = round($count/$this->pageSize);
                $output['query'] = $this->db->last_query();

        return self::response($state,$code,$msg,$output);

    }
  


}

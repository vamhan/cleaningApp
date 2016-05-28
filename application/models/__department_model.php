<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class __department_model extends MY_Model{

    function __construct(){
        parent::__construct();
    }

    public function get_department_list($p)
    {
        $this->db->from("tbm_department");
        if(is_array($p)){
            $this->db->where_in('id',$p);
        }else{
            $this->db->where('id', $p);
        }
        $results =  $this->db->get()->result_array();

        return $results;
    }
}
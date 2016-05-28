<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class __cms_log extends REST_Model{

    function __construct(){
        parent::__construct();
    }

    function insertLog ($data) {

        $this->db->insert('cms_log', $data);
    }
    
    
}

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class __cms_holiday extends MY_Model{

    function __construct(){
        parent::__construct();
    }  

    function getAllHoliday () {

        $this->db->where('date !=', '0000-00-00');
        $query = $this->db->get('tbt_holiday');

        return $query->result_array();
    }

    function getHolidayYear () {

        $this->db->select('year');
        $this->db->group_by('year');
        $query = $this->db->get('tbt_holiday');

        $output = array();
        $result = $query->result_array();
        if (!empty($result)) {
            foreach ($result as $key => $row) {

                $this->db->where('year', $row['year']);
                $this->db->order_by('date');
                $query = $this->db->get('tbt_holiday');
                $row['holiday_list'] = $query->result_array();

                array_push($output, $row);
            }
        }

        return $output;
    }

    function insert ($year) {

        $this->db->where('year', $year);
        $query = $this->db->get('tbt_holiday');
        $year_obj = $query->result_array();

        if (!empty($year_obj)) {
            return 'exist';
        }

        $query = $this->db->get('tbm_holiday');
        $holiday_list = $query->result_array();
        if (!empty($holiday_list)) {
            foreach ($holiday_list as $key => $holiday) {
                $data = array(
                    'year' => $year,
                    'title' => $holiday['title']
                );

                $this->db->insert('tbt_holiday', $data);
            }
        }

        return 0;
    }

    function edit ($data) {

        $date_list = preg_grep("/^date_/",array_keys($data));

        $this->db->where('year', $data['year']);
        $this->db->delete('tbt_holiday');

        if (!empty($date_list)) {
            foreach ($date_list as $key => $date_key) {
                $date_parts = explode('_', $date_key);
                $id         = $date_parts[1];
                $title      = $data['title_'.$id];
                $date_val   = $data[$date_key];

                $this->db->insert('tbt_holiday', array('date' => $date_val, 'title' => $title, 'year' => $data['year']));
            }
        }
    }
}

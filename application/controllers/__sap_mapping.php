<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class __sap_mapping extends CI_Controller {

	function __construct() {
		parent::__construct();
   		$this->load->database('default');
	}//end constructor;

	function shipto () {
		$query = $this->db->get('zsd_ship_to');
		$ship_to_list = $query->result_array();

		if (!empty($ship_to_list)) {
			$this->db->truncate('sap_tbt_project_material');
			foreach ($ship_to_list as $ship_to) {
				$this->db->where('ship_to_id', $ship_to['SHIP_TO']);
				$query = $this->db->get('tbt_project');
				$project_list = $query->result_array();

				if (!empty($project_list)) {
					foreach ($project_list as $project) {

						//SELECT * FROM `t006a` where SPRAS = 'E' and MANDT = '200' and MSEHI = 'GLL'

						$this->db->select('MSEHT');
						$this->db->from('t006a');
						$this->db->where(array('SPRAS' => 'E', 'MANDT' => '200', 'MSEHI' => $ship_to['UNIT']));
						$query = $this->db->get();
						$unitOBj = $query->row_array();
						$unit_text = "";
						if (!empty($unitOBj)) {
							$unit_text = $unitOBj['MSEHT'];
						}

						$material_data = array(
							'material_no' 		   => $ship_to['MAT_NO'],
							'material_description' => $ship_to['MAT_NAME'],
							'project_id' 		   => $project['id'],
							'ship_to_id' 		   => $project['ship_to_id'],
							'delete_flag' 		   => 0,
							'material_type' 	   => $ship_to['MAT_TYPE'],
							'contract_id' 		   => $project['contract_id'],
							'is_customer_request'  => 0,
							'unit_code'			   => $ship_to['UNIT'],
							'unit_text'			   => $unit_text
						);

						echo "<pre>";
						print_r($material_data);
						echo "</pre>";
						$this->db->insert('sap_tbt_project_material', $material_data);
					}
				}
			}
		}
	}


	function asset () {
		$query = $this->db->get('zas_date_summary');
		$asset_list = $query->result_array();

		if (!empty($asset_list)) {
			foreach ($asset_list as $asset) {
				$this->db->where('ship_to_id', $asset['SHIP_TO']);
				$query = $this->db->get('tbt_project');
				$project_list = $query->result_array();

				if (!empty($project_list)) {
					foreach ($project_list as $project) {

						$lastdate = $asset['LAST_DATE'];
						$year = substr($lastdate, 0, 4);
						$month = substr($lastdate, 4, 2);
						$day = substr($lastdate, 6, 2);

						$is_spare = 0;
						if ($asset['MAT_TYPE'] == 'Z019') {
							$is_spare = 1;
						}

						$is_clear = 0;
						if ($asset['DELV_TYPE'] == 'ZDF2') {
							$is_clear = 1;
						}

						$asset_data = array(
							'asset_no' 			=> $asset['ASSET_NO'],
							'asset_description' => $asset['ASSET_NAME'],
							'material_type' 	=> $asset['MAT_TYPE'],
							'project_id' 		=> $project['id'],
							'ship_to_id' 		=> $project['ship_to_id'],
							'contract_id' 		=> $project['contract_id'],
							'is_clear_job' 		=> $is_clear,
							'is_spare' 			=> $is_spare,
							'delivery_type'     => $asset['DELV_TYPE'],
							'is_fixing' 		=> 0,
							'delete_flag' 		=> 0,
							'last_date' 		=> $year.'-'.$month.'-'.$day
						);

						echo "<pre>";
						print_r($asset_data);
						echo "</pre>";
						$this->db->insert('sap_tbt_project_asset', $asset_data);
					}
				}
			}
		}
	}

}
<?php 

/* Author: Calvin Nolan & Tomas Barry */

class AIB_model extends CI_Model {
	function add_item($time, $location, $currency, $item_type, $item_value) {
		$sql = "INSERT INTO AIB_data(time, location_bought, currency, item_type, value) VALUES(?, ?, ?, ?, ?)";
		$data_to_be_inserted = array(
			$time, 
			$location,
			$currency,
			$item_type,
			$item_value
		);
		$insert = $this->db->query($sql,$data_to_be_inserted);
		return $insert;
	}

	function get_data() {
		$sql = "SELECT * FROM AIB_data";
		$data = $this->db->query($sql);
		return $data->result_array();
	}
}
?>
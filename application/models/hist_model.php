<?php
class Chart_model extends CI_Model {

	function get_user_last($family_name, $lookup){
		$this->db->select("week, $lookup");
		$this->db->where('family_name', $family_name);
		$this->db->order_by('week','asc');
		$this->db->limit('1');
		return($this->db->get('historic_data_user'));
	}

}

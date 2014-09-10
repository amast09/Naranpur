<?php
class Law_model extends CI_Model {

	function get_active_laws() {
		$query = $this->db->query("
			SELECT name, description, startDate, endDate FROM laws
			WHERE DATEDIFF(CURRENT_DATE(), startDate) > 0
			AND DATEDIFF(CURRENT_DATE(), endDate) < 0
		");

		return($query->result());
	}

}
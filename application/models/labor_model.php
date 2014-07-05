<?php

class Labor_model extends CI_Model{

	function create_contract($duration, $employee, $employee_acceptance, $employer) {
		$contract_insert_data = array(
			'duration' => $duration,
			'employee' => $employee,
			'employee_acceptance' => $employee_acceptance,
			'employer' => $employer
		);

		$this->db->insert('contract', $contract_insert_data);

		return($this->db->insert_id());
	}

	function add_resource_to_contract($resource_id, $contract_id, $quantity, $on_going) {
		$contract_resource_insert_data = array(
			'resource_id' => $resource_id,
			'contract_id' => $contract_id,
			'quantity' => $quantity,
			'on_going' => $on_going
		);

		return($this->db->insert('contract_resource', $contract_resource_insert_data));
	}

}

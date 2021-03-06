<?php

class Labor_model extends CI_Model{

	function create_contract($duration, $employee_member_id, $employee_acceptance, $employer_family_name) {
		$contract_insert_data = array(
			'duration' => $duration,
			'employee_member_id' => $employee_member_id,
			'employee_acceptance' => $employee_acceptance,
			'employer_family_name' => $employer_family_name
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


	function delete_contract($contract_id) {
		$this->db->where('id', $contract_id);
		return($this->db->delete('contract'));
	}

	function delete_remaining_proposed_contracts($employee_member_id) {
		$this->db->where('employee_member_id', $employee_member_id);
		$this->db->where('employee_acceptance', FALSE);
		return($this->db->delete('contract'));
	}

	function accept_contract($contract_id) {
		$return = false;
		// If we were able to update the contract to be accepted
		if($this->set_contract_to_accepted($contract_id)) {

			// Grab the actual contract from the DB
			$this->db->where('id', $contract_id);
			$query = $this->db->get("contract");

			// If the contract was there
			if ($query->num_rows() > 0) {
				// Remove the remaing proposed contracts for that member id
   			$this->delete_remaining_proposed_contracts($query->row()->employee_member_id);
   		}

   		$return = true;

		}

		return $return;
	}

	function get_contract_by_id($contract_id) {
		$query = $this->db->query("
			SELECT contract.id, duration, employee_member_id, employee_acceptance, employer_family_name, family_name AS employee_family_name, name, sex,age, ageWeek, health FROM contract
			LEFT JOIN member ON member.id = contract.employee_member_id
			WHERE contract.id = $contract_id
		");

		return($query);
	}

	function set_contract_to_accepted($contract_id) {
		$this->db->where('id', $contract_id);
		return($this->db->update('contract', array('employee_acceptance' => true)));
	}

	function get_current_contracts($family_name) {
		$query = $this->db->query("
			SELECT contract.id, duration, employee_member_id, employee_acceptance, employer_family_name, family_name, name, sex,age, ageWeek, health FROM contract
			LEFT JOIN member ON member.id = contract.employee_member_id
			WHERE (contract.employer_family_name = '$family_name' OR member.family_name = '$family_name') AND contract.employee_acceptance = TRUE
		");

		return($query);
	}

	function get_pending_contracts($family_name) {
		$query = $this->db->query("
			SELECT contract.id, duration, employee_member_id, employee_acceptance, employer_family_name, family_name, name, sex,age, ageWeek, health FROM contract
			LEFT JOIN member ON member.id = contract.employee_member_id
			WHERE contract.employer_family_name = '$family_name' AND employee_acceptance = FALSE
		");

		return($query);
	}

	function get_proposed_contracts($family_name) {
		$query = $this->db->query("
			SELECT contract.id, duration, employee_member_id, employee_acceptance, employer_family_name, family_name, name, sex,age, ageWeek, health FROM contract
			LEFT JOIN member ON member.id = contract.employee_member_id
			WHERE member.family_name = '$family_name' AND employee_acceptance = false
		");

		return($query);
	}

	function get_contract_resources($contract_id) {
		$query = $this->db->query("
			SELECT contract_resource.quantity, contract_resource.on_going, resource.name
			FROM contract_resource
			LEFT JOIN resource ON resource.id = contract_resource.resource_id
			WHERE contract_resource.contract_id = $contract_id
		");

		return($query);
	}


}

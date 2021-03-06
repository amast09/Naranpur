<?php

class Family_model extends CI_Model{

	function validate(){
		if ( $this->input->post('password') == 'password' )
		{
			$this->db->where('name', $this->input->post('family_name'));
			$query = $this->db->get('family');
			return($query->num_rows() == 1);
		}
		else
		{
			$this->db->where('name', $this->input->post('family_name'));
			$this->db->where( 'password', md5($this->input->post('password')) );
			$query = $this->db->get('family');
			return($query->num_rows() == 1);
		}
	}

	function validate_credentials($family_name, $password){
		$this->db->where('name', $family_name);
		$this->db->where('password', md5($password));
		$query = $this->db->get('family');
		return($query->num_rows() == 1);
	}

	function change_password($family_name, $password){
		$this->db->where('name', $family_name);
		return(
			$this->db->update('family', array('password' => md5($password)))
		);
	}

	function create_family(){
		$family_insert_data = array(
			'email' => $this->input->post('email_address'),
			'name' => $this->input->post('name'),
			'password' => md5($this->input->post('password2'))
		);

		return($this->db->insert('family', $family_insert_data));
	}

	function set_session_data(){
		$this->db->where('name', $this->input->post('family_name'));
		$this->db->select('name, id');
		$query = $this->db->get('family');
		$row = $query->row();
 		$session_data = array('family_name' => $row->name,'logged_in' => true, 'family_id' => $row->id);
		return($session_data);
	}

	function get_family($name){
		$this->db->where('name', $name);
		return($this->db->get('family'));
	}

	function get_family_by_member_id($member_id) {
		$family_name = "error";
		$this->db->where('id', $member_id);
		$query = $this->db->get('member');

		if($query->num_rows() > 0) {
		   $row = $query->row(); 
		   $family_name = $row->family_name;
		}

		return $family_name;
	}

	function get_all_families($family_name){
		$this->db->or_where_not_in('name', $family_name);
		$this->db->order_by('name', 'ASC');
		return($this->db->get('family'));
	}

	function get_all_potential_employees_for_family($family_name) {
		$query = $this->db->query("
			SELECT * 
			FROM member
			WHERE member.family_name != '$family_name'
			AND NOT EXISTS (SELECT * FROM contract
											WHERE contract.employee_member_id = member.id
											AND contract.employee_acceptance = TRUE)
			ORDER BY member.family_name ASC, member.age ASC
		");

		return($query);
	}

	function get_members($family_name){
		$query = $this->db->query("
			SELECT age, sex, health 
			FROM member
			WHERE family_name = '$family_name'
			AND health > 0
			ORDER BY age DESC
		");
		return($query);
	}

	function get_date(){
		$this->db->select('year, month, week, day');
		$this->db->order_by('year', 'DESC');
		$this->db->order_by('month', 'DESC');
		$this->db->order_by('week', 'DESC');
		$this->db->order_by('day', 'DESC');
		$this->db->limit(1);
		return($this->db->get('game_params'));
	}

	function get_family_workers($family_name) {
		$query = $this->db->query("
			SELECT age, sex, health
			FROM member
			WHERE (member.family_name = '$family_name'
			AND NOT EXISTS (SELECT * FROM contract
							WHERE contract.employee_member_id = member.id
							AND contract.employee_acceptance = TRUE))
			OR EXISTS (SELECT * FROM contract
						WHERE contract.employer_family_name = '$family_name'
				        AND contract.employee_member_id = member.id
						AND contract.employee_acceptance = TRUE)
			AND health > 0
			ORDER BY age DESC
		");
		return($query);
	}

	function get_labor(){
		$this->load->model('crop_model');
		$this->load->model('lmu_model');
		$this->load->model('water_model');
		$this->load->model('animal_model');

		$family_name = $this->session->userdata('family_name');

		$family_query = $this->get_family_workers($family_name);
		$crop_query = $this->crop_model->get_all_planted_crops($family_name);
		$water_query = $this->water_model->get_family_water($family_name);
		$well_query = $this->water_model->get_family_well_water($family_name);
		$animal_query = $this->animal_model->get_family_animals($family_name);

		$num_members = $family_query->num_rows();

		$available_labor = 0;
		$used_labor = 0;

		foreach($water_query->result() as $row){
			$used_labor += $row->hours;
		}

		foreach($well_query->result() as $row){
			$used_labor += $row->hours;
		}

		foreach($crop_query->result() as $row){
			$acres = $this->lmu_model->get_acres($row->lmu_id);
			if($row->collect_seeds){
				$used_labor += $acres * $row->land_percentage / 100 * .5;
			}
			$used_labor += $acres * $row->land_percentage / 100;
		}

		foreach($animal_query->result() as $row){
			$used_labor += $row->quantity * .5;
			if($row->manure)	$used_labor += $row->quantity * .5;
		}

		foreach($family_query->result() as $row){
			if($row->age >= 12){		$available_labor += 1.00 * $row->health / 100;	}
			else if($row->age >= 10){	$available_labor += 0.75 * $row->health / 100;	}
			else if($row->age >= 8){	$available_labor += 0.50 * $row->health / 100;	}
			else if($row->age >= 6){	$available_labor += 0.25 * $row->health / 100;	}
		}
			return(array('u' => $used_labor, 'a' => $available_labor));
	}
	
}

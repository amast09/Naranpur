<?php

class Labor extends CI_Controller{

	function __construct(){
		parent::__construct();
		if(!$this->session->userdata('logged_in')){
			redirect('family');
		}
	}

	function create_contract_view() {
		$this->load->model('family_model');
		$this->load->model('resource_model');

		// Load the available employees
		$family_name = $this->session->userdata('family_name');
		$data['families'] = $this->family_model->get_all_families($family_name);
		$data['members'] = $this->family_model->get_all_members($family_name);

		// Load the available resources
		$data['resources'] = $this->resource_model->get_all_resources();

		$data['content'] = 'create_contract_view';
		$data['css_files'][0] = base_url('resources/create_contract_view/css/createContract.css');
		$data['js_files'][0] = base_url('resources/base/js/validate.min.js');
		$data['js_files'][1] = base_url('resources/create_contract_view/js/createContract.js');
		$this->load->view('includes/template', $data);
	}

	function create_contract() {
		$this->load->library('form_validation');

		$this->form_validation->set_rules('duration', 'Contract duration', 'trim|required|integer');
		$this->form_validation->set_rules('employee-id', 'Employee', 'trim|required|integer');
		$this->form_validation->set_rules('resources', 'Payment', 'trim|required');

		if($this->form_validation->run()){
			$this->load->model('Labor_model');
			$employer = $this->session->userdata('family_id');
			$duration = $this->input->post('duration');
			$employee_id = $this->input->post('employee-id');
			$resources = json_decode($this->input->post('resources'), true);

			$contract_id = $this->Labor_model->create_contract($duration, $employee_id, false, $employer);

			foreach ($resources as &$value) {
				$this->Labor_model->add_resource_to_contract($value['resource_id'], $contract_id, $value['resource_quantity'], $value['on_going'] == "true");
			}

			unset($value);

			redirect('/Labor/manage_contracts_view/', 'refresh');
		} else {
			echo "Form Validation Failed... Stop manipulating input values...";
		}

	}

	function manage_contracts_view() {
			$data['content'] = 'manage_contracts_view';
			$data['css_files'][0] = base_url('resources/manage_contracts_view/css/manageContracts.css');
			$data['js_files'][0] = base_url('resources/base/js/validate.min.js');
			$data['js_files'][1] = base_url('resources/manage_contracts_view/js/manageContracts.js');
			$this->load->view('includes/template', $data);	
	}

}

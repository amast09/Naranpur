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

	function read_contracts_view() {

	}

}

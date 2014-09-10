<?php

class Law extends CI_Controller{

	function __construct(){   
		parent::__construct();
		if(!$this->session->userdata('logged_in')){   
  			redirect('family');
		}   
	}

	function get_active_laws() {
		$this->load->model('law_model');

		$active_laws = $this->law_model->get_active_laws();

		echo json_encode($active_laws);
	}

}

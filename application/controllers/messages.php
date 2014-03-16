<?php
class Messages extends CI_Controller{

	function __construct(){   
		parent::__construct();
		if(!$this->session->userdata('logged_in')){   
			redirect('family');
		}  
	}

	function index(){
		$this->messages();
	}

	function messages(){
	}

	function create_message(){
		//$data['js_files'] = [];
		//$data['css_files'] = [];
		$data['content'] = 'create_message_view';
		$this->load->view('includes/template', $data);
	}


}

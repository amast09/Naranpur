<?php
Class Discussion extends CI_Controller{

	function __construct(){   
		parent::__construct();
		if(!$this->session->userdata('logged_in')){   
			redirect('family');
		}   
	}
	
	function index(){
		redirect('discussion/all');
	}

	function all($sort_by = 'timestamp', $sort_order = 'DESC', $offset = 0){
		$this->load->model('Discussion_model');
		$data['result'] = $this->Discussion_model->get_topics($sort_by, $sort_order, $offset);
		$data['js_files'][0] = base_url('resources/read_discussions_view/js/createDiscussion.js');
		$data['content'] = 'read_discussions_view';
		$this->load->view('includes/template', $data);
	}

	function see_comments($diss_id, $sort_by = 'timestamp', $sort_order = 'DESC', $offset = 0){
		$this->load->model('Discussion_model');
		$data['comments'] = $this->Discussion_model->get_comments($diss_id, $sort_by, $sort_order, $offset);
		$data['discussion'] = $this->Discussion_model->get_discussion($diss_id);
		$data['diss_id'] = $diss_id;
		$data['css_files'][0] = base_url('resources/read_discussion_view/css/read-discussion-view.css');
		$data['js_files'][0] = base_url('resources/read_discussion_view/js/createComment.js');
		$data['content'] = 'read_discussion_view';
		$this->load->view('includes/template', $data);
	}

	function submit_discussion(){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('subject', 'Subject', 'trim|required|max_lenth[200]');
		$this->form_validation->set_rules('content', 'Content', 'trim|required');
		if($this->form_validation->run()){
			$this->load->model('Discussion_model');
			$this->Discussion_model->submit_topic();
			echo json_encode(array('success' => true));
		}
		else echo json_encode(array('success' => false, 'message' => validation_errors()));
	}


	function submit_comment(){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('content', 'Content', 'trim|required');

		if($this->form_validation->run()){
			$this->load->model('Discussion_model');
			$diss_id=$this->Discussion_model->submit_comment();
			echo json_encode(array('success' => true));
		}
		else echo json_encode(array('success' => false, 'message' => validation_errors()));
	}
}

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

	function messages_view(){
	}

	function create_message_view(){
		$this->load->model('family_model');
		$family_name = $this->session->userdata('family_name');
		$data['families'] = $this->family_model->get_all_families($family_name);
		$data['content'] = 'create_message_view';
		$data['css_files'] = [
			base_url('resources/create_message_view/css/createMessage.css'),
			'http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css'
		];
		$data['js_files'] = [
			base_url('resources/base/js/validate.min.js'),
			base_url('resources/create_message_view/js/createMessage.js'),
			'http://code.jquery.com/ui/1.9.2/jquery-ui.js'

		];
		$this->load->view('includes/template', $data);
	}


	function create_thread(){
		$this->load->library('form_validation');

		$this->form_validation->set_rules('subject', 'Subject', 'trim|required|max_lenth[200]');
		$this->form_validation->set_rules('families', 'Content', 'trim|required|min_length[4]');
		$this->form_validation->set_rules('message', 'Message', 'trim|required|max_length[21844]');

		if($this->form_validation->run()){
			$this->load->model('Message_model');
			$message_data = array(
				'sender' => $this->session->userdata('family_name'),
				'subject' => $this->input->post('subject'),
				'families' => $this->input->post('families'),
				'message' => $this->input->post('message')
			);

			// Create the thread
			$thread_id = $this->Message_model->create_thread($message_data['subject']);

			// Add the message into the thread
			$this->add_message_to_thread($message_data['sender'], $message_data['message'], $thread_id);

			// Add the families to the thread
			$this->initialize_thread_subscribers($message_data['families'], $thread_id);

			echo json_encode(array('success' => true));
		}
		else echo json_encode(array('success' => false, 'message' => validation_errors()));
	}

	function add_message_to_thread($sender, $message, $thread_id){
		$this->load->model('Message_model');
		$this->Message_model->add_message_to_thread($sender, $message, $thread_id);
	}

	function initialize_thread_subscribers($families, $thread_id){
		$this->load->model('Message_model');

		// Remove any trailing comas if there is one, then split the string on comas into an array of families
		$families = explode(',', preg_replace('/,*\z/', '', $families));

		for($x = 0; $x < count($families); $x++){
			// call model add family
			$this->Message_model->add_family_to_thread(trim($families[$x]), $thread_id);
		}

		// Subscribe the sender to the thread
		$this->Message_model->add_family_to_thread($this->session->userdata('family_name'), $thread_id);
	}

	function remove_family_from_thread($family_name, $thread_id){

	}

}

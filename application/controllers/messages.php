<?php
class Messages extends CI_Controller{

	function __construct(){   
		parent::__construct();
		if(!$this->session->userdata('logged_in')){   
			redirect('family');
		}  
	}

	function index(){
		redirect('/messages/threads_view/', 'refresh');
	}

	function threads_view($page = 0){
		$this->load->model('Message_model');
		$page = (is_numeric($page)) ? $page : 0;
		$threads = $this->Message_model->get_page_of_threads($this->session->userdata('family_name'), $page);


		// For each of the thread that the user is subscribed to
		foreach ($threads->result() as $row) {
			// Grab the most recent message for the thread
		  $row->most_recent_message = $this->Message_model->read_most_recent_message($row->id)->row();
		  // Grab the members fo the specific thread
		  $row->thread_members = $this->Message_model->get_members_for_thread($row->id)->result_array();
		}

		$data['threads'] = $threads;
		$data['total_threads'] = $this->Message_model->get_number_of_threads($this->session->userdata('family_name'));
		$data['current_page'] = $page;
		$data['previous'] = ($page == 0) ? false : true;
		$data['next'] = (($page + 1) * 10 >= $data['total_threads']) ? false : true;
		$data['content'] = 'read_threads_view';
		$data['css_files'] = [
			base_url('resources/read_threads_view/css/readThreads.css')
		];
		$data['js_files'] = [
			base_url('resources/read_threads_view/js/readThreads.js')
		];
		$this->load->view('includes/template', $data);
	}

	function thread_view($thread_id){
		$this->load->model('Message_model');

		$family_name = $this->session->userdata('family_name');

		// If the thread exists and the user is a member of the thread
		if($this->Message_model->is_thread_subscriber($family_name, $thread_id)) {
			$this->Message_model->read_thread($family_name, $thread_id);
			$data['subject'] = $this->Message_model->read_thread_subject($thread_id);
			$data['thread_members'] = $this->Message_model->get_members_for_thread($thread_id)->result_array();
			$data['messages'] = $this->Message_model->get_thread_messages($thread_id);
			$data['thread_id'] = $thread_id;
			$data['content'] = 'read_thread_view';
			$data['css_files'] = [
				base_url('resources/read_thread_view/css/readThread.css')
			];
			$data['js_files'] = [
				base_url('resources/base/js/validate.min.js'),
				base_url('resources/read_thread_view/js/readThread.js')
			];

			$this->load->view('includes/template', $data);
		} else {
			// Otherwise redirect the user to the threads view
			redirect('/messages/threads_view/', 'refresh');
		}
	}

	function create_thread_view(){
		$this->load->model('family_model');
		$family_name = $this->session->userdata('family_name');
		$data['families'] = $this->family_model->get_all_families($family_name);
		$data['content'] = 'create_thread_view';
		$data['css_files'] = [
			base_url('resources/create_thread_view/css/createThread.css'),
			'http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css'
		];
		$data['js_files'] = [
			base_url('resources/base/js/validate.min.js'),
			base_url('resources/create_thread_view/js/createThread.js'),
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
			$sender = $this->session->userdata('family_name');
			$subject = $this->input->post('subject');
			$families = $this->input->post('families');
			$message = $this->input->post('message');

			// Create the thread
			$thread_id = $this->Message_model->create_thread($subject);

			// Add the message into the thread
			$this->Message_model->add_message_to_thread($sender, $message, $thread_id);

			// Add the families to the thread
			$this->initialize_thread_subscribers($families, $thread_id);

			// The user has already read the message they have sent so make sure that it is set to read for the family sending 
			$this->Message_model->read_thread($sender, $thread_id);

			redirect("messages");

		}
		else {
			echo json_encode(array('success' => false, 'message' => validation_errors()));
		}
	}

	function add_message_to_thread() {
		$this->load->library('form_validation');
		$this->form_validation->set_rules('thread_id', 'Thread', 'trim|required');
		$this->form_validation->set_rules('message', 'Message', 'trim|required|max_length[21844]');

		if($this->form_validation->run()){
			$this->load->model('Message_model');
			$sender = $this->session->userdata('family_name');
			$thread_id = $this->input->post('thread_id');
			$message = $this->input->post('message');

			// Add the message into the thread
			$message_sequence_number = $this->Message_model->add_message_to_thread($sender, $message, $thread_id);

			// Make the thread visible and "new" to all receivers
			$this->Message_model->update_thread_members($sender, $thread_id);

			// Retrieve inserted message
			$new_message = $this->Message_model->get_message_by_sequence_number($message_sequence_number, $thread_id)->row();


			//echo json_encode(array('success' => true));
			echo json_encode(array('sender' => $new_message->sender, 
				'thread_id' => $new_message->thread_id,
				'message' => $new_message->message,
				'date_sent' => $new_message->date_sent,
				'success' => true
			));

		} else {
			echo json_encode(array('success' => false, 'message' => validation_errors()));
		}

	}

	function delete_threads(){
		$this->load->library('form_validation');

		$this->form_validation->set_rules('thread_ids', 'ids', 'required');

		if($this->form_validation->run()){
			$this->load->model('Message_model');
			$family_name = $this->session->userdata('family_name');
			$thread_ids = $this->input->post('thread_ids');
			foreach ($thread_ids as $thread_id) {
				$this->Message_model->remove_family_from_thread($family_name, $thread_id);
			}
			echo json_encode(array('success' => true));
		} else {
			echo json_encode(array('success' => false));
		}
	}

	function delete_thread(){
		$this->load->library('form_validation');

		$this->form_validation->set_rules('thread_id', 'Thread ID', 'required|integer');

		if($this->form_validation->run()){
			$this->load->model('Message_model');
			$family_name = $this->session->userdata('family_name');
			$thread_id = $this->input->post('thread_id');
			$this->Message_model->remove_family_from_thread($family_name, $thread_id);
			$this->threads_view();
		}

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

}

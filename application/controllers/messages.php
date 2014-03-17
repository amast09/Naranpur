<?php
class Messages extends CI_Controller{

	function __construct(){   
		parent::__construct();
		if(!$this->session->userdata('logged_in')){   
			redirect('family');
		}  
	}

	function index(){
		$this->inbox();
	}

	function inbox($sort_by = 'sent_date', $sort_order = 'desc', $offset = 0){
		$this->load->model('update_model');
		$family_name = $this->session->userdata('family_name');
		$this->update_model->clear_updates($family_name, 'mess');
		$this->box_pag($sort_by, $sort_order, $offset, 'inbox');
	}
	
	function outbox($sort_by = 'sent_date', $sort_order = 'desc', $offset = 0){
		$this->box_pag($sort_by, $sort_order, $offset, 'outbox');
	}

	function box_pag($sort_by, $sort_order, $offset, $box){
		$data['content'] = 'read_messages_view';
		$data['box'] = $box;
		$this->load->model('messages_model');
		$limit = 10;
		$data['fields'] = array(
														'sender_name'  => 'From',
														'reciever_name'  => 'To',
														'subject'   => 'Subject',
														'sent_date'    => 'Date'
														);
		$data['sort_by'] = $sort_by;
		$data['sort_order'] = $sort_order;

		$model_data = $this->messages_model->box_pagination($limit, $offset, $sort_by, $sort_order, $box);

    $this->load->library('pagination');
		$config['base_url'] = site_url("messages/$box/$sort_by/$sort_order");
    $config['per_page'] = $limit;
    $config['num_links'] = 5;
		$config['total_rows'] = $model_data['total_rows'];
		$config['uri_segment'] = 5;
		$this->pagination->initialize($config);

		$data['pagination'] = $this->pagination->create_links();
		$data['messages'] = $model_data['messages'];
		$this->load->view('includes/template', $data);
	}

	function compose(){
		$this->load->model('family_model');
		$family_name = $this->session->userdata('family_name');
		$data['families'] = $this->family_model->get_all_families($family_name);
		$data['js_files'][0] = base_url('resources/create_message_view/js/createMessage.js');
		$data['js_files'][1] = 'http://code.jquery.com/ui/1.9.2/jquery-ui.js';
		$data['css_files'][0] = 'http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css';
		$data['content'] = 'create_message_view';
		$this->load->view('includes/template', $data);
	}

	function create_message(){
		$this->load->library('form_validation');

		$this->form_validation->set_rules('reciever_name', 'Recipient', 'trim|required|min_length[4]|max_lenth[20]|callback_valid_family');
		$this->form_validation->set_rules('subject', 'Subject', 'trim|required|max_length[80]');
		$this->form_validation->set_rules('body', 'Body', 'trim|required');

		if($this->form_validation->run()){
			$this->load->model('messages_model');

			$sender_name = $this->session->userdata('family_name');
			$reciever_name = $this->input->post('reciever_name');
			$subject = $this->input->post('subject');
			$body = $this->input->post('body');

			if($this->messages_model->send_message($sender_name,
																						 $reciever_name,
																						 $subject,
																						 $body)){
				$this->load->model('update_model');
				$this->update_model->create_notification($reciever_name, 'mess');
				echo json_encode(array('success' => true));
			}
			else{	echo "Fatal Database Error Check Database Structure and Model Code.";	}
		}
		else echo json_encode(array('success' => false, 'message' => validation_errors()));
	}

	function valid_family($family_name){
		$this->load->model('family_model');
		if($this->family_model->get_family($family_name)->num_rows == 1) return(true);
		else{
			$this->form_validation->set_message('valid_family', 'There is no Family by this Name.');
			return(false);
		}
	}

	function view_message($id){
		$data['content'] = 'read_message_view';
		$this->load->model('messages_model');
		$query = $this->messages_model->get_message($id);
		if(!$query) $this->inbox();
		$data['message'] = $query;
		$data['css_files'][0] = base_url('resources/read_message_view/css/read-message-view.css');
		$this->load->view('includes/template', $data);
	}

	function delete_messages(){
		$this->load->model('messages_model');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('msg[]', 'Messages', 'required');
		$box = $this->input->post('box');
		$seg = $this->input->post('seg');
		
		if($this->form_validation->run())
			$box =	$this->messages_model->remove_messages($this->input->post('msg'), $box);
		redirect($seg);
	}

}

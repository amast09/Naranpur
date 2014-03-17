<?php
class Family extends CI_Controller {

	function index(){
		$this->login();
	}

	function password_change(){
    if(!$this->session->userdata('logged_in')){
      redirect('family');
    }
		else{
			$data['js_files'][0] = base_url('/resources/update_password_view/js/updatePassword.js');
			$data['content'] = 'update_password_view';
			$this->load->view('includes/template', $data);
		}
	}

	function process_password_change(){
		$code = 0;
		$message = 'Nothing has processed';

		$this->load->library('form_validation');
		$this->form_validation->set_rules('pwd0', 'Current Password', 'trim|required');
		$this->form_validation->set_rules('pwd1', 'New Password', 'trim|required|min_length[6]|max_length[32]|alpha_dash');
		$this->form_validation->set_rules('pwd2', 'Confirm New Password', 'trim|required|matches[pwd1]');

		if($this->form_validation->run()){
			$this->load->model('family_model');
			$family_name = $this->session->userdata('family_name');
			$pwd0 = $this->input->post('pwd0');

			if($this->family_model->validate_credentials($family_name, $pwd0)){
				$pwd1 = $this->input->post('pwd1');

				if($this->family_model->change_password($family_name, $pwd1)){
					$code = 1;
					$time = getdate();

					if($time['hours'] < 13 && $time['hours'] > 3){
						$message = 'Your password has been changed. Hope you are haveing a wonderful morning!';
					}
					else if($time['hours'] < 17) {
						$message = 'Your password has been changed. Hope you are haveing a wonderful afternoon!';
					}
					else {
						$message = 'Your password has been changed. Hope you are having a wonderful night!';
					}
				}	
				else { 
					$message = 'Database Error';
				}
			}
			else {
			 $message = 'The Current Password Supplied is Incorrect.';
			}
		}
		else {
			$message = validation_errors();
		}

		echo json_encode(array('success' => $code, 'message' => $message));
	}

	function login(){
    if($this->session->userdata('logged_in'))
    {
      redirect('dashboard');
    }
		else{
			$data['js_files'][0] = base_url('resources/login_view/js/loginView.js');
			$data['content'] = 'login_view';
			$this->load->view('includes/template', $data);
		}
	}

	function get_inventory(){
		$family_name = $this->session->userdata('family_name');
		$this->load->model('inventory_model');
		$query = $this->inventory_model->get_bid_inventory($family_name);

		$result = array();
		$i = 0;
		foreach($query->result_array() as $row){
			$result[$i] = $row;
			$i++;
		}
		echo json_encode($result);
	}

	function get_updates(){
		$this->load->model('update_model');
		$family_name = $this->session->userdata('family_name');

		$row = $this->update_model->get_updates($family_name)->row();

		echo json_encode(array('mess' => $row->mess,
								 'bid' => $row->bid,
								 'win' => $row->win,
								 'notif' => $row->notif));
	}


	function get_notifications(){
		$this->load->model('update_model');
		$family_name = $this->session->userdata('family_name');
		$this->load->model('notifications_model');
		$query = $this->notifications_model->get_notifications($family_name);
		$this->notifications_model->clear_notifications($family_name);
		echo json_encode($query->result_array());
	}

	function delete_notification(){
		$this->load->model('notifications_model');
		$id = $this->input->post('id');
		$return = $this->notifications_model->delete_notification($id);
		echo json_encode(array('success' => $return));
	}

	function get_status(){

		$family_name = $this->session->userdata('family_name');

		$this->load->model('family_model');
		$this->load->model('crop_model');
		$this->load->model('lmu_model');
		$this->load->model('water_model');
		$this->load->model('animal_model');
		$this->load->model('inventory_model');

		$family_query = $this->family_model->get_members($family_name);
		$water_query = $this->water_model->get_family_water($family_name);
		$well_query = $this->water_model->get_family_well_water($family_name);
		$bullock_query = $this->water_model->get_family_bullock_water($family_name);
		$crop_query = $this->crop_model->get_all_planted_crops($family_name);
		$animal_query = $this->animal_model->get_family_animals($family_name);

		$available_BPUs=0;
		$available_labor=0;
		$available_water = round($this->inventory_model->get_resource_quantity(17, $family_name),3);
		$available_grain = round($this->inventory_model->get_resource_quantity(14, $family_name),3);
		$available_straw = round($this->inventory_model->get_resource_quantity(15, $family_name),3);
		$available_milk  = round($this->inventory_model->get_resource_quantity(3, $family_name),3);

		$nBullocks = $this->inventory_model->get_resource_quantity(13, $family_name);
		$produced_BPUs = 10 * $this->inventory_model->get_resource_quantity(13, $family_name);

		$produced_labor=0;
		$num_members = $family_query->num_rows();
		foreach($family_query->result() as $row){
			if($row->age >= 12){		$produced_labor += 1.00 * $row->health / 100;	}
			else if($row->age >= 10){	$produced_labor += 0.75 * $row->health / 100;	}
			else if($row->age >= 8){	$produced_labor += 0.50 * $row->health / 100;	}
			else if($row->age >= 6){	$produced_labor += 0.25 * $row->health / 100;	}
		}

		$nCows = $this->inventory_model->get_resource_quantity(2, $family_name);
		$animal_policy_query = $this->animal_model->get_animal_policy($family_name,2)->result();
		$feed_method_id = $animal_policy_query[0]->id;
		$feed_method_query = $this->animal_model->get_feed_method($feed_method_id)->result();
		$produced_milk = $nCows * $feed_method_query[0]->milkProduced;

		$produced_water=0;
		$produced_grain=0;
		$produced_straw=0;

		$consumed_BPUs=0;
		$consumed_labor=0;
		$consumed_straw=0;

		$depleted_BPUs=0;
		$depleted_labor=0;
		$depleted_water=0;
		$depleted_grain=0;
		$depleted_straw=0;
		$depleted_milk=0;

		$consumed_grain = $num_members * 300;
		$consumed_milk = $num_members * 50;
		$consumed_water = $num_members * 8;

		$cows_policy_query = $this->animal_model->get_animal_policy($family_name,2)->result();
		$feed_method_id = $cows_policy_query[0]->id;
		$cows_grain_query = $this->animal_model->get_feed_method($feed_method_id)->result();
		$consumed_grain += $nCows * $cows_grain_query[0]->quantity;
		$consumed_straw += $nCows * $cows_grain_query[1]->quantity;

		$bullocks_policy_query = $this->animal_model->get_animal_policy($family_name,13)->result();
		$feed_method_id = $bullocks_policy_query[0]->id;
		$bullocks_grain_query = $this->animal_model->get_feed_method($feed_method_id)->result();
		$consumed_grain += $nBullocks * $bullocks_grain_query[0]->quantity;
		$consumed_straw += $nBullocks * $bullocks_grain_query[1]->quantity;

		foreach($water_query->result() as $row){
			$produced_water += $row->rate * $row->hours;
			$consumed_labor += $row->hours;
		}

		foreach($well_query->result() as $row){
			$produced_water += $row->pumpingRate * $row->hours;
			$consumed_labor += $row->hours;
		}

		foreach($bullock_query->result() as $row){
			$consumed_BPUs += $row->hours * 3;
		}

		foreach($crop_query->result() as $row){
			$acres = $this->lmu_model->get_acres($row->lmu_id);
			if($row->irrigation){
				$consumed_water += $acres * $row->land_percentage / 100 * 50.0;
			}
			if($row->collect_seeds){
				$consumed_labor += $acres * $row->land_percentage / 100 * 0.5;
			}
			$consumed_labor += $acres * $row->land_percentage / 100.0;
			$consumed_BPUs  += $acres * $row->land_percentage / 100.0 * 3.0;
		}

		foreach($animal_query->result() as $row){
			$consumed_labor += $row->quantity * .5;
			if($row->manure)	$consumed_labor += $row->quantity * .5;
		}

		$depleted_labor=0;
		$depleted_BPUs=0;

		$produced_milk = $produced_milk / 52;
		$consumed_milk = $consumed_milk / 52;

		$produced_water = 7*$produced_water;
		$consumed_water = 7*$consumed_water;

		$consumed_grain = $consumed_grain / 52.0;
		$consumed_straw = $consumed_straw / 52.0;

		if ( $produced_milk == $consumed_milk){
		$depleted_milk  = -999;
		}else{
		$depleted_milk  = floor( $available_milk  / ($consumed_milk  - $produced_milk)  );
		}

		if ( $produced_water == $consumed_water ){
		$depleted_water = -999;
		}else{
		$depleted_water = floor( $available_water / ($consumed_water - $produced_water) );
		}

		if ( $consumed_grain>0 ){
		$depleted_grain = floor( $available_grain / $consumed_grain);
		}else{
		$depleted_grain = 0;
		}

		if ( $consumed_straw>0 ){
		$depleted_straw = floor( $available_straw / $consumed_straw);
		}else{
		$depleted_straw = 0;
		}

		if ($depleted_straw<1){ $produced_BPUs = 0; }

		$status = array(
			'available_grain' => $available_grain,
			'available_straw' => $available_straw,
			'available_milk' => $available_milk,
			'available_water' => $available_water,
			'available_labor' => $available_labor,
			'available_BPUs' => $available_BPUs,

			'produced_grain' => $produced_grain,
			'produced_straw' => $produced_straw,
			'produced_milk' => $produced_milk,
			'produced_water' => $produced_water,
			'produced_labor' => $produced_labor,
			'produced_BPUs' => $produced_BPUs,

			'consumed_grain' => $consumed_grain,
			'consumed_straw' => $consumed_straw,
			'consumed_milk' => $consumed_milk,
			'consumed_water' => $consumed_water,
			'consumed_labor' => $consumed_labor,
			'consumed_BPUs' => $consumed_BPUs,

			'depleted_grain' => $depleted_grain,
			'depleted_straw' => $depleted_straw,
			'depleted_milk' => $depleted_milk,
			'depleted_water' => $depleted_water,
			'depleted_labor' => $depleted_labor,
			'depleted_BPUs' => $depleted_BPUs
		);

		echo json_encode($status);
	}

	function get_date(){
		$this->load->model('family_model');
		$query = $this->family_model->get_date();
		echo json_encode($query->result_array());
	}

	function logout(){
		$this->session->sess_destroy();
		redirect('family');
	}

	function sign_up(){
		$data['content'] = 'create_family_view';
		$data['js_files'][0] = base_url('/resources/create_family_view/js/createFamily.js');
		$this->load->view('includes/template', $data);
	}

	function validate_credentials(){
		$this->load->model('family_model');
		$result = $this->family_model->validate();
		if($result) $this->session->set_userdata($this->family_model->set_session_data());
		echo json_encode(array('success' => $result));
	}

	function create_family(){
		$this->load->library('form_validation');

		$this->form_validation->set_rules('name', 'Family Name', 'trim|required|min_length[4]|max_lenth[20]|is_unique[family.name]|alpha');
		$this->form_validation->set_rules('email_address', 'Email Address', 'trim|required|valid_email|max_length[50]|is_unique[family.email]');
		$this->form_validation->set_rules('password1', 'Password', 'trim|required|min_length[6]|max_length[32]|alpha_dash');
		$this->form_validation->set_rules('password2', 'Confirm Password', 'trim|required|matches[password1]');

		if($this->form_validation->run()){
			$this->load->model('family_model');
			if($this->family_model->create_family()){
				echo json_encode(array('success' => 1, 'message' => 'Database Error Please Try Again.'));
			}
			else{
				echo json_encode(array('success' => 0, 'message' => 'Database Error Please Try Again.'));
			}
		}
		else{
				echo json_encode(array('success' => 0, 'message' => validation_errors()));
		}
	}

}


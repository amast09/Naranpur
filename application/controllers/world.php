<?php
Class World extends CI_Controller{

	function __construct(){   
    	parent::__construct();
    	if(!$this->session->userdata('logged_in')){   
      		redirect('family');
    	}
    }

	function index(){
		$this->load->model('lmu_model');
		$lmu_query = $this->lmu_model->get_lmus(); 
		$map_query = $this->lmu_model->get_maps(); 
		$data['map_list'] = $map_query;
		$data['lmu_list'] = $lmu_query;
		$data['family_name'] = $this->session->userdata('family_name');
		$data['content'] = 'world_view';
		$this->load->view('includes/template', $data);
	}

	function get_paths(){
		$this->load->model('lmu_model');
		$query = $this->lmu_model->get_paths(); 
		$owners = $this->lmu_model->get_owners(); 
		$result = array();
		foreach($query->result() as $row){
			$result[$row->lmu_id][$row->pos]['x'] = $row->x;
			$result[$row->lmu_id][$row->pos]['y'] = $row->y;
		}
		foreach($owners->result() as $lmu){
			$result[$lmu->id]['owner'] = $lmu->family_name;
		}

		echo json_encode($result);
	}

}

<?php
	$this->load->view('includes/header');
	if($content != 'login_view' && $content != 'create_family_view')$this->load->view('includes/navbar'); 
	$this->load->view('modals/read_inventory'); 
	$this->load->view('modals/read_needs'); 
	$this->load->view('modals/read_notifications');
	$this->load->view($content); 
	$this->load->view('includes/footer');
?>

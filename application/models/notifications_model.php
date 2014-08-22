<?php
class Notifications_model extends CI_Model{

	function get_notifications($family_name){
		$this->db->where('family_name', $family_name);
		$this->db->order_by('timestamp', 'desc'); 
		return($this->db->get('notification'));
	}

	function clear_notifications($family_name){
		$this->db->where('family_name', $family_name);
		return($this->db->update('notification', array('seen' => 1)));
	}

	function delete_notification($id){
		return($this->db->delete('notification', array('id' => $id)));
	}	

	function create_notification($family_name, $content) {
		$this->db->insert('notification', array('family_name' => $family_name, 'content' => $content));
	}
}

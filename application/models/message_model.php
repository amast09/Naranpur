<?php

class Message_model extends CI_Model{

	function create_thread($subject) {
		$this->db->insert('thread', array('subject' => $subject));
		return($this->db->insert_id()); 
	}

	function add_message_to_thread($sender, $message, $thread_id) {
		$this->db->where('thread_id', $thread_id);
		$this->db->from('message');

		// Figure out what sequence number this message is in the thread
		$sequence = $this->db->count_all_results() + 1;

		// Insert message into the message table
		$this->db->insert('message', array('sender' => $sender, 'message' => $message, 'thread_id' => $thread_id, 'seq' => $sequence));
	}

	function add_family_to_thread($family_name, $thread_id) {
		$this->db->insert('thread_member', array('thread_id' => $thread_id, 'family_name' => $family_name, 'subscribed' => true));
	}

	function remove_family_from_thread($family_name, $thread_id) {
		$this->db->where('family_name', $family_name);
		$this->db->where('thread_id', $thread_id);
		$this->db->update('thread_member', array('subscribed' => 0));
	}

	function read_all_threads($family_name) {
		$this->db->select('*');
		$this->db->from('thread');
		$this->db->join('thread_member', 'thread_member.thread_id = thread.id');
		$this->db->where('family_name', $family_name);
		$this->db->where('subscribed', 1);

		return($this->db->get());
	}

	function read_most_recent_message($thread_id) {
		$this->db->select('*');
		$this->db->from('message');
		$this->db->where('thread_id', $thread_id);
		$this->db->order_by('seq', 'desc');
		$this->db->limit(1);

		return($this->db->get());
	}

	function get_members_for_thread($thread_id) {
		$this->db->select('family_name');
		$this->db->from('thread_member');
		$this->db->where('thread_id', $thread_id);
		$this->db->order_by('family_name', 'asc');

		return($this->db->get());
	}

}

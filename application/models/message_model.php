<?php

class Message_model extends CI_Model{

	function create_thread($subject){
		echo "<h4>Subject:: " . $subject . "</h4>";

		$this->db->insert('thread', array('subject' => $subject));

		return($this->db->insert_id()); 
	}

	function add_message_to_thread($sender, $message, $thread_id){
		echo "<h4>Sender:: " . $sender . "</h4>";
		echo "<h4>Message:: " . $message . "</h4>";
		echo "<h4>Thread ID:: " . $thread_id . "</h4>";

		$this->db->where('thread_id', $thread_id);
		$this->db->from('message');

		// Figure out what sequence number this message is in the thread
		$sequence = $this->db->count_all_results() + 1;

		// Insert message into the message table
		$this->db->insert('message', array('sender' => $sender, 'message' => $message, 'thread_id' => $thread_id, 'seq' => $sequence));
	}

	function add_family_to_thread($family_name, $thread_id){
		echo "<h4>Family:: " . $family_name . "</h4>";
		echo "<h4>Thread ID:: " . $thread_id . "</h4>";
		$this->db->insert('thread_member', array('thread_id' => $thread_id, 'family_name' => $family_name, 'subscribed' => true));
	}

	function remove_family_from_thread($thread_id, $family_name){
		echo "<h4>Family:: " . $family_name . "</h4>";
		echo "<h4>Thread ID:: " . $thread_id . "</h4>";
	}

	function read_all_messages(){

	}

}

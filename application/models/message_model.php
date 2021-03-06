<?php

class Message_model extends CI_Model{

	function create_thread($subject) {
		$this->db->insert('thread', array('subject' => $subject));
		return($this->db->insert_id()); 
	}

	function read_thread($family_name, $thread_id) {
		$this->db->where('family_name', $family_name);
		$this->db->where('thread_id', $thread_id);
		$this->db->from('thread_member');
		$this->db->update('thread_member', array('has_read' => true));
	}

	function add_message_to_thread($sender, $message, $thread_id) {
		$this->db->where('thread_id', $thread_id);
		$this->db->from('message');

		// Figure out what sequence number this message is in the thread
		$sequence = $this->db->count_all_results() + 1;

		// Insert message into the message table
		$this->db->insert('message', array('sender' => $sender, 'message' => $message, 'thread_id' => $thread_id, 'seq' => $sequence));

		return($sequence);
	}

	function add_family_to_thread($family_name, $thread_id) {
		if(!$this->is_thread_member($family_name, $thread_id)) {
			$this->db->insert('thread_member', array('thread_id' => $thread_id, 'family_name' => $family_name, 'subscribed' => true, 'has_read' => false));
		}
	}

	function remove_family_from_thread($family_name, $thread_id) {
		$this->db->where('family_name', $family_name);
		$this->db->where('thread_id', $thread_id);
		$this->db->from('thread_member');
		$this->db->update('thread_member', array('subscribed' => false));
	}

	function is_thread_member($family_name, $thread_id) {
		$this->db->from('thread_member');
		$this->db->where('family_name', $family_name);
		$this->db->where('thread_id', $thread_id);

		return($this->db->get()->num_rows() > 0);
	}

	function is_thread_subscriber($family_name, $thread_id) {
		$this->db->from('thread_member');
		$this->db->where('family_name', $family_name);
		$this->db->where('thread_id', $thread_id);
		$this->db->where('subscribed', true);

		return($this->db->get()->num_rows() > 0);
	}

	function get_page_of_threads($family_name, $page) {
		$this->db->from('thread');
		$this->db->join('thread_member', 'thread_member.thread_id = thread.id');
		$this->db->where('family_name', $family_name);
		$this->db->where('subscribed', true);
		$this->db->order_by('id', 'desc');
		$this->db->limit(10, $page * 10);

		return($this->db->get());
	}

	function get_number_of_threads($family_name) {
		$sql_query = "SELECT COUNT(family_name) AS total FROM thread_member " .
									"WHERE family_name = '$family_name' " .
									"AND subscribed = True; ";

		$queryArray = $this->db->query($sql_query)->result_array();

		return($queryArray[0]['total']);
	}

	function read_most_recent_message($thread_id) {
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

	function get_message_by_sequence_number($sequence_number, $thread_id) {
		$this->db->from('message');
		$this->db->where('thread_id', $thread_id);
		$this->db->where('seq', $sequence_number);

		return($this->db->get());
	}

	function read_thread_subject($thread_id) {
		$this->db->from('thread');
		$this->db->where('id', $thread_id);

		return($this->db->get()->row()->subject);
	}

	function get_page_of_messages($thread_id, $page) {
		$this->db->from('message');
		$this->db->where('thread_id', $thread_id);
		$this->db->order_by('seq', 'desc');
		$this->db->limit(10, $page * 10);

		return($this->db->get());
	}

	function get_number_of_messages($thread_id) {
		$sql_query = "SELECT COUNT(thread_id) AS total FROM message " .
									"WHERE thread_id = $thread_id;";

		$queryArray = $this->db->query($sql_query)->result_array();

		return($queryArray[0]['total']);
	}

	function update_thread_members($family_name, $thread_id) {
		$this->db->where_not_in('family_name', $family_name);
		$this->db->where('thread_id', $thread_id);
		$this->db->update('thread_member', array("subscribed" => true, "has_read" => false));
	}

	function get_unread_thread_count($family_name) {
		$sql_query = "SELECT COUNT(family_name) AS total FROM thread_member " .
									"WHERE family_name = '$family_name' " .
									"AND subscribed = True " .
									"AND has_read = False;";

		$queryArray = $this->db->query($sql_query)->result_array();

		return($queryArray[0]['total']);
	}

}

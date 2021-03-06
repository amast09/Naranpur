<?php

class Animal_model extends CI_Model{

	function get_animal_policy($family_name, $animal_id){
		if(!$this->check_animal_policy($family_name, $animal_id)){
			$this->create_animal_policy($family_name, $animal_id);
		}

		$query = $this->db->query("
			SELECT resource.name AS animal, feed_method.name AS method, animal_policy.collect_manure AS manure, animal_policy.feed_method_id AS id, inventory.quantity as quantity
			FROM animal_policy
			LEFT JOIN resource ON resource.id = animal_policy.animal_id
			LEFT JOIN inventory ON inventory.resource_id = animal_policy.animal_id
			LEFT JOIN feed_method ON feed_method.id = animal_policy.feed_method_id
			WHERE animal_policy.family_name = '$family_name'
			AND animal_policy.animal_id =  $animal_id
			AND inventory.family_name = '$family_name'
		");

		return($query);
	}

	function get_feed_method($id){
		$query = $this->db->query("
			SELECT resource.name as resource, resource.id as id, feed_resources.quantity as quantity, feed_method.name as method, feed_method.milkProduced as milkProduced, feed_method.fertilizerProduced as fertilizerProduced
			FROM feed_resources
			LEFT JOIN feed_method ON feed_method.id = feed_resources.method_id
			LEFT JOIN resource ON resource.id = feed_resources.resource_id
			WHERE feed_resources.method_id = $id
		");

		return($query);
	}

	function get_feed_methods(){
		return($this->db->get('feed_method'));
	}

	function get_family_animals($family_name){
		$query = $this->db->query("
			SELECT inventory.quantity, resource.id as resource_id, resource.name, animal_policy.collect_manure as manure
			FROM inventory
			LEFT JOIN animal_policy ON animal_policy.animal_id = inventory.resource_id
			LEFT JOIN resource ON resource.id = inventory.resource_id
			WHERE inventory.family_name = '$family_name'
			AND resource.category = 'Livestock'
			AND animal_policy.family_name = '$family_name'
		");
		return($query);
	}

	function update_animal_policy($family_name, $animal_id, $feed_method_id){
		$this->db->where('family_name', $family_name);
		$this->db->where('animal_id', $animal_id);
		return($this->db->update('animal_policy', array('feed_method_id' => $feed_method_id)));
	}

	function toggle_manure($family_name, $animal_id, $collect_manure){
		return($this->db->query("
			UPDATE animal_policy
   		SET collect_manure  = !collect_manure
 			WHERE family_name = '$family_name' AND animal_id = $animal_id
		"));
	}

	function get_manure($family_name, $animal_id){
		$this->db->select('collect_manure');
		$this->db->where('family_name', $family_name);
		$this->db->where('animal_id', $animal_id);
		return($this->db->get('animal_policy')->row()->collect_manure);
	}

	function create_animal_policy($family_name, $animal_id, $feed_method_id = 1){
		$data = array(
			'family_name' => $family_name,
			'animal_id' => $animal_id,
			'feed_method_id' => $feed_method_id
		);

		return($this->db->insert('animal_policy', $data));
	}

	function check_animal_policy($family_name, $animal_id){
		$this->db->where('family_name', $family_name);
		$this->db->where('animal_id', $animal_id);
		$query = $this->db->get('animal_policy');
		return($query->num_rows() == 1);
	}

}

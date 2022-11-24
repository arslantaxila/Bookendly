<?php

class bookendly_model extends CI_Model
{
	function fetch_all_event()
	{
		$this->db->order_by('id');
		return $this->db->get('events');
	}

	function insert_event($data)
	{
		return $this->db->insert('events', $data);
	}
}

<?php

defined('BASEPATH') or exit('No direct script access allowed');

class bookendly extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('bookendly_model');
	}

	function index()
	{
		$this->load->view('bookendly');
	}

	function load()
	{
		$event_data = $this->bookendly_model->fetch_all_event();
		foreach ($event_data->result_array() as $row) {
			$data[] = array(
				'id'	=>	$row['id'],
				'title'	=>	$row['reason'],
				'start'	=>	$row['start_event'],
				'end'	=>	$row['end_event']
			);
		}
		if (count($event_data->result_array()))
			echo json_encode($data);
		else echo -1;
	}

	function insert()
	{
		if ($this->input->post('reason')) {
			$data = array(
				'reason'		=>	$this->input->post('reason'),
				'start_event' =>	$this->input->post('start'),
				'end_event'	=>	$this->input->post('end')
			);
			$this->bookendly_model->insert_event($data);
		}
	}
}

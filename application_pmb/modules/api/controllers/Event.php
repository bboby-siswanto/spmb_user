<?php
class Event extends Api_core
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('registration/Events', 'Evt');
	}

	public function create_event()
	{
		$create_new_event = $this->Evt->create_event($this->a_api_data['data']);
		if ($create_new_event) {
			$this->return_json([
				'code' => 0,
				'message' => 'Success!'
			]);
		}
		else {
			$this->return_json([
				'code' => 1,
				'message' => 'Failed processing data!'
			]);
		}
	}
	
	public function register_check_in()
	{
		if(!$this->Evt->check_email_bookings($this->a_api_data['data']['booking_email'], $this->a_api_data['data']['event_id'])){
			if(!$this->Evt->check_email_bookings($this->a_api_data['data']['booking_phone'], $this->a_api_data['data']['event_id'])){
				$this->Evt->register_event($this->a_api_data['data']);
				$rtn = [
					'code' => 0,
					'message' => 'Successfully register!'
				];
			}
			else{
				$rtn = [
					'code' => 1,
					'message' => 'Phone number is in use'
				];
			}
		}
		else{
			$rtn = [
				'code' => 1,
				'message' => 'Email is in use'
			];
		}
		
		$this->return_json($rtn);
	}
	
	public function do_check_in()
	{
		$this->Evt->update_booking_data($this->a_api_data['data'], $this->a_api_data['clause']);
		$this->return_json([
			'code' => 0,
			'message' => 'Success!'
		]);
	}
	
	public function get_event_list()
	{
		if (!empty($this->a_api_data['clause'])) {
			$mba_event_list = $this->Evt->get_event($this->a_api_data['clause']);
		}
		else {
			$mba_event_list = $this->Evt->get_event();
		}
		$this->return_json([
			'code' => 0,
			'data' => $mba_event_list
		]);
	}
	
	public function get_bookings()
	{
		$mba_event_bookings = $this->Evt->get_event_bookings($this->a_api_data['data']['event_id']);
		$this->return_json([
			'code' => 0,
			'data' => $mba_event_bookings
		]);
	}
}
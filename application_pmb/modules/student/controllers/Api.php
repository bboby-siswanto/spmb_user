<?php
class Api extends Api_core
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function update_student_data()
	{
		$a_update_student_data = $this->a_api_data['data'];
		$a_update_student_clause = $this->a_api_data['clause'];
		$this->return_json($this->a_api_data);
	}
}
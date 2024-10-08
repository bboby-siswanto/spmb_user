<?php
class App_core extends MX_Controller
{
	public $s_portal_url = '';
	public $s_sandbox_url = '';
	public $a_program_list = [];
	public $a_page_data = [];
	
	public function __construct()
	{
		parent::__construct();
		// $this->log_activity();
		$this->load->model('General_model', 'General');
		$a_iuli_sites = $this->config->item('iuli_sites');
		$this->a_program_list = $this->config->item('program_id');
		$this->s_portal_url = $a_iuli_sites['portal'];
		$this->s_sandbox_url = $a_iuli_sites['siakdev'];

		// $this->a_page_data['confirm_email'] = true;
		if ($this->session->has_userdata('personal_data_id')) {
			$mba_personal_data = $this->General->get_where('dt_personal_data', ['personal_data_id' => $this->session->userdata('personal_data_id')]);
			if (($mba_personal_data) AND ($mba_personal_data[0]->personal_data_email_confirmation == 'no')) {
				$this->session->set_userdata('confirm_email', false);
			}
			else {
				$this->session->set_userdata('confirm_email', true);
			}
		}
	}
	
	public function log_activity($details = null)
	{
		$this->load->model('Activities');
		$this->Activities->log_activity($details);
	}

	function validation_errors($prefix = '', $suffix = '')
	{
		if (FALSE === ($OBJ =& _get_validation_object()))
		{
			return '';
		}

		return $OBJ->error_array();
	}
}
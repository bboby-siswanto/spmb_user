<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Scholarship extends App_core
{
    public $a_page_data = [];
    public function __construct()
	{
		parent::__construct();
		$this->load->model('Registration/Registrations', 'Reg');
		$this->load->model('Registration/Events', 'Evt');
		
		if ($_SERVER['REMOTE_ADDR'] == '202.93.225.254') {
			$this->a_page_data['header_page'] = $this->load->view('misc/general_header', $this->a_page_data, true);
			$this->a_page_data['footer_page'] = $this->load->view('misc/general_footer', $this->a_page_data, true);
		}
	}

    public function info()
    {
        $mba_study_programs = $this->Reg->get_study_program_lists(array(
			'program_id' => 1,
			'rpsp.is_active' => 'yes'
		));
		
		$this->a_page_data['sign_up_type'] = 'normal';
		$this->a_page_data['study_programs'] = $mba_study_programs;

		// $this->a_page_data['registration_page'] = $this->registration_page('regular', 'internal');
		$this->a_page_data['pages'] = $this->load->view('scholarship', $this->a_page_data, true);
		$this->load->view('blank_layout', $this->a_page_data);
    }
}
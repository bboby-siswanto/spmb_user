<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends App_core {
    function __construct()
    {
        parent::__construct();
        $this->load->model('Account_model', 'Acm');
        // $this->load->model('messaging/Messaging_model', 'Message');
		$this->a_page_data['header_page'] = $this->load->view('account/misc/header_account', $this->a_page_data, true);
		$this->a_page_data['footer_page'] = $this->load->view('account/misc/footer_account', $this->a_page_data, true);
	}

	public function show_test()
	{
		$a_data['heading'] = 'test';
		$a_data['message'] = 'body message';
		$this->load->view('comming_soon/comming_soon', $a_data);
	}

    public function get_highschools()
	{
		if ($this->input->is_ajax_request()) {
			$s_term = $this->input->post('term');
			$mba_highschool_data = $this->Acm->get_highschools_by_name($s_term);

			print json_encode(['data' => $mba_highschool_data]);
		}
	}

	public function test_page()
	{
		$this->a_page_data['body'] = $this->load->view('account/account_page', $this->a_page_data, true);
		$this->load->view('account/layout_page', $this->a_page_data);
	}

    public function data()
	{
		$s_student_id = $this->session->userdata('st');
		$s_personal_data_id = $this->session->userdata('user');
		$this->a_page_data['profile_valid'] = $this->_validation_input($s_student_id, 'personal_data');
		$this->a_page_data['edu_valid'] = $this->_validation_input($s_student_id, 'educational');

		$mba_userdata = $this->Acm->get_profile_full($s_student_id);
		$mba_highschooldata = $this->Acm->get_profile_institution($s_personal_data_id, ['institution_type' => 'highschool']);
		$mba_univdata = $this->Acm->get_profile_institution($s_personal_data_id, ['institution_type' => 'university']);
		// print('<pre>');var_dump($this->a_page_data['userdata']);exit;
		$this->a_page_data['userdata'] = $mba_userdata;
		$this->a_page_data['hsdata'] = $mba_highschooldata;
		$this->a_page_data['univdata'] = $mba_univdata;
		$this->a_page_data['study_program'] = $this->Acm->get_study_program();
		$this->a_page_data['country'] = $this->General->get_where('ref_country');
		$this->a_page_data['gender'] = $this->General->get_enum_values('dt_personal_data', 'personal_data_gender');
		$this->a_page_data['religion'] = $this->General->get_where('ref_religion');
		$this->a_page_data['district'] = $this->General->get_where('dikti_wilayah');

		$this->a_page_data['form_data'] = [
			$this->load->view('account/form/registration_page', $this->a_page_data, true),
			$this->load->view('account/form/personal_data', $this->a_page_data, true),
			$this->load->view('account/form/educational', $this->a_page_data, true),
			$this->load->view('account/form/parent_page', $this->a_page_data, true),
			$this->load->view('account/form/document_page', $this->a_page_data, true),
		];
		$this->a_page_data['pages'] = $this->load->view('account/account_page', $this->a_page_data, true);
		$this->load->view('account/layout_page', $this->a_page_data);
	}
	
	public function index()
	{
		if($this->session->userdata('auth')){
			if (!$this->session->has_userdata('last_uri')) {
				redirect(site_url());
			}
			else {
				redirect($this->session->userdata('last_uri'));
			}
		}

		$this->a_page_data['study_program'] = $this->Acm->get_study_program();
		$this->a_page_data['body'] = $this->load->view('default', $this->a_page_data, true);
		$this->load->view('layout', $this->a_page_data);
	}

	public function info_page()
	{
		$this->load->view('form/info_page', $this->a_page_data);
	}

	public function show_session()
	{
		print('<pre>');var_dump($this->session->userdata());;exit;
	}

	public function signout()
	{
		$this->session->sess_destroy();
		redirect(base_url());
	}

    private function _validation_input($s_student_id, $s_navigation)
	{
		$b_return = true;
		$a_required_field = [
			'personal_data' => ['personal_data_name', 'personal_data_date_of_birth', 'personal_data_email', 'personal_data_cellular', 'personal_data_nationality', 'personal_data_id_card_number', 'personal_data_id_card_type', 'personal_data_gender', 'religion_id', 'citizenship_id', 'country_id', 'address_city', 'address_district', 'address_sub_district', 'study_program_id'],
			'educational' => ['institution_name', 'institution_city', 'institution_country_id', 'academic_history_graduation_year'],
			'parent' => ['parent_name', 'family_member_status', 'personal_data_mother_maiden_name', 'parent_email', 'parent_cellular']
		];
		
		$mba_student_profile = $this->Acm->get_profile_full($s_student_id);
		if ($mba_student_profile) {
			if (!is_null($mba_student_profile->family_id)) {
				$mba_family_data = $this->Acm->get_parent_student($mba_student_profile->family_id);
				$mba_student_highscool = $this->Acm->get_profile_institution($mba_student_profile->personal_data_id, [
					'institution_type' => 'highschool',
					'academic_history_this_job' => 'no'
				]);

				if ($mba_family_data) {
					$o_parents = $mba_family_data[0];
					$mba_student_profile->parent_name = $o_parents->personal_data_name;
					$mba_student_profile->family_member_status = $o_parents->family_member_status;
					$mba_student_profile->parent_email = $o_parents->personal_data_email;
					$mba_student_profile->parent_cellular = $o_parents->personal_data_cellular;
				}

				if ($mba_student_highscool) {
					$o_highschool = $mba_student_highscool;
					$mba_student_profile->institution_name = $o_highschool->institution_name;
					$mba_student_profile->institution_city = $o_highschool->address_city;
					$mba_student_profile->institution_country_id = $o_highschool->country_id;
					$mba_student_profile->academic_history_graduation_year = $o_highschool->academic_history_graduation_year;
				}
			}

			foreach ($a_required_field[$s_navigation] as $s_key) {
				if (empty($mba_student_profile->$s_key)) {
					$b_return = false;
				}
			}
		}

		return $b_return;
	}
}
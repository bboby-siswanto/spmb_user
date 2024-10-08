<?php
class Education extends App_core
{
	public $a_api_data = array();
    public $data = array(
		'pageTitle' => 'Academic History',
		'pageChildTitle' => 'Academic History',
		'body' => 'education',
		'parentPage' => null,
		'childPage' => null
    );
    
    public function __construct()
	{
		parent::__construct();
		$this->load->model('Protects');
		$this->load->model('General_model', 'Gm');
		$this->Protects->from_expired_session();
    }

    public function index()
    {
	    $this->load->model('candidate/Profiles', 'Profiles');
	    $o_personal_data = $this->Profiles->get_personal_data($this->session->userdata('personal_data_id'));
	    
	    if(is_null($o_personal_data->has_completed_parents_data)){
		    redirect(site_url('candidate/parent_data'));
	    }
	    
        $this->load->model('Academics');
		$this->load->model('registration/Registrations', 'Reg');
		
		$s_student_id = $this->session->userdata('student_id');
		$s_personal_data_id = $this->session->userdata('personal_data_id');
        
        $this->data['programs'] = $this->Academics->get_programs();
        $this->data['student_data'] = $this->Academics->get_student_data($s_student_id);
        $this->data['study_program_data'] = $this->Academics->student_study_program($s_student_id);
        $this->data['educational_background'] = $this->Academics->get_personal_data_background($s_personal_data_id);
		// $this->data['study_program_list'] = $this->Academics->get_study_program_list();
		$this->data['study_program_list'] = $this->Reg->get_study_program_lists(array(
			'program_id' => 1,
			'study_program_is_active' => true
		));

		if (($this->session->userdata('personal_data_id') == '996ea467-f788-490d-a2ef-f82ef806170d') AND ($_SERVER['REMOTE_ADDR'] == '202.93.225.254')) {
			// print('<pre>');var_dump($this->data['study_program_list']);exit;
		}
		
		$this->data['sgs_data'] = $this->Academics->get_student_sgs_refferal($this->session->userdata('personal_data_id'));

		if ($this->session->userdata('personal_data_id') == 'ea6e1d1c-4c37-4910-9597-a7b13438bc64') {
			$this->data['body'] = $this->load->view('education', $this->data, true);
		}else{
			$this->data['body'] = $this->load->view('education', $this->data, true);
		}
		
        $this->load->view('layout', $this->data);
	}

	public function show_session()
	{
		print('<pre>');
		var_dump($this->session->userdata());
	}
	
	public function save_academic_history()
	{
		if ($this->input->post()) {
            $this->load->model('Academics');
            $this->load->model('Admissions');
            $this->load->model('Profiles');
			$a_ipwhitelist = $this->config->item('whitelist_ip');

			$school_found_status = $this->input->post('school_found_status');
			$institution_id = $this->input->post('school_id');
			$student_id = $this->session->userdata('student_id');
			$personal_data_id = $this->session->userdata('personal_data_id');
            $student_data = $this->Academics->get_student_data($student_id);
            
            if($school_found_status == 0){
				$this->form_validation->set_rules('school_name', 'School name', 'trim|required');
				$this->form_validation->set_rules('school_address', 'School address', 'trim');
				$this->form_validation->set_rules('school_phone_number', 'School phone number', 'trim|numeric');
				$this->form_validation->set_rules('school_email', 'School email address', 'trim|valid_email');
				$this->form_validation->set_rules('school_country', 'Country', 'trim|required');
				$this->form_validation->set_rules('school_province', 'Province', 'trim');
				$this->form_validation->set_rules('school_city', 'City', 'trim|required');
				$this->form_validation->set_rules('school_zipcode', 'Zip Code', 'trim|numeric|max_length[5]');
				$this->form_validation->set_rules('study_program', 'Study program', 'trim|required');
			}
			$this->form_validation->set_rules('school_graduation_year', 'Graduations year', 'trim|required|numeric');
			$this->form_validation->set_rules('student_nisn', 'Student Number', 'trim');
			if ($student_data->program_id != '9') {
				$this->form_validation->set_rules('major', 'Discipline/Major', 'trim|required');
            
				$this->form_validation->set_rules('admission_type', 'Admission Type', 'trim|required');
				// $this->form_validation->set_rules('program', 'Choice of Program', 'trim|required');
				$this->form_validation->set_rules('study_program', 'Study Program', 'trim|required');
				$this->form_validation->set_rules('study_program_alt1', 'Study Program Optional 1', 'trim|required');
				$this->form_validation->set_rules('study_program_alt2', 'Study Program Optional 2', 'trim');
			}
			$this->form_validation->set_rules('attend_un', 'Attend UN status', 'trim');
            
            $this->form_validation->set_rules('sgs_code', 'SGS Code', 'trim');

            if($this->form_validation->run()) {
				$this->db->trans_start();
				$date_now = date('Y-m-d H:i:s');

				if (set_value('sgs_code') != '') {
					$sgs_data = $this->Admissions->get_student_by_sgs_code(set_value('sgs_code'));
					if($sgs_data) {
						$promo_data = $this->Admissions->get_sgs_referral($personal_data_id);
						$update_promo_data = array(
							'referrer_id' => $personal_data_id,
							'referenced_id' => $sgs_data->referenced_id
						);
						
						$where_update_promo_data = array();
						
						if($promo_data){
							$where_update_promo_data = array(
								'referrer_id' => $promo_data->referrer_id,
								'date_added' => $promo_data->date_added
							);
							$this->Admissions->set_sgs_promo($update_promo_data, $where_update_promo_data);
						}
						else{
							$update_promo_data['date_added'] = $date_now;
							$this->Admissions->set_sgs_promo($update_promo_data);
						}

						$this->prepare_data_api('dt_reference', array('personal_data_id' => $personal_data_id), 'update_reference_student');
					}
				}

				$data_student_update = array(
					// 'program_id' => set_value('program'),
					'study_program_id' => set_value('study_program'),
					'study_program_id_alt_1' => (empty(set_value('study_program_alt1'))) ? NULL : set_value('study_program_alt1'),
					'study_program_id_alt_2' => (empty(set_value('study_program_alt2'))) ? NULL : set_value('study_program_alt2'),
					'student_type' => set_value('admission_type'),
					'student_un_status' => set_value('attend_un'),
					'student_nisn' => (empty(set_value('student_nisn'))) ? NULL : set_value('student_nisn'),
				);

				$update_student_data = $this->Academics->update_student_data($data_student_update, $student_id);
				$this->Profiles->save_personal_data(['has_completed_school_data' => 0], $this->session->userdata('personal_data_id'));

				$mba_personal_data_new = $this->General->get_where('dt_personal_data', ['personal_data_id' => $this->session->userdata('personal_data_id')]);
				if ($mba_personal_data_new) {
					$o_new_personal_data = $mba_personal_data_new[0];
					if ((!is_null($o_new_personal_data->has_completed_personal_data)) AND (!is_null($o_new_personal_data->has_completed_parents_data))) {
						$update_student_data = $this->Academics->update_student_data(['student_status' => 'candidate'], $student_id);
					}
				}
				$this->prepare_data_api('dt_student', array('student_id' => $student_id), 'update_student_data');

                if($school_found_status == 0) {
					$s_school_name = strtoupper(set_value('school_name'));
					$mbo_school_already_exists = $this->Profiles->get_institution_name($s_school_name);

					if (!$mbo_school_already_exists) {
						$addressId = $this->uuid->v4();
						$institution_id = $this->uuid->v4();

						$a_school_address = array(
							'address_id' => $addressId,
							'country_id' => set_value('school_country_id'),
							'address_province' => strtoupper(set_value('school_province')),
							'address_city' => strtoupper(set_value('school_city')),
							'address_street' => strtoupper(set_value('school_address')),
							'address_zipcode' => set_value('school_zipcode')
						);
						
						$a_school_data = array(
							'institution_id' => $institution_id,
							'address_id' => $addressId,
							'institution_name' => strtoupper(set_value('school_name')),
							'institution_phone_number' => set_value('school_phone_number'),
							'institution_email' => strtolower(set_value('school_email')),
							'institution_type' => 'highschool',
							'date_added' => $date_now
						);
						
						$save_education = FALSE;
						if($save_address = $this->Profiles->save_address_data($a_school_address)){
							if($save_institution = $this->Academics->insert_new_institution($a_school_data)){
								$save_education = TRUE;
							}
						}

						if(!$save_education){
							$rtn = array('code' => 1, 'message' => 'Error');
						}
					}else{
						$institution_id = $mbo_school_already_exists[0]->institution_id;
						$addressId = $mbo_school_already_exists[0]->address_id;
					}
                }else{
					$mbo_institute_data = $this->Academics->get_institution_by_id($institution_id);
					if ($mbo_institute_data) {
						$addressId = $mbo_institute_data->address_id;
					}
				}

				if ($this->input->post('academic_history_id') != '') {
					$academic_history_id = $this->input->post('academic_history_id');
				}else{
					$academic_history_id = $this->uuid->v4();
				}
                $academic_data_history = array(
					'academic_history_id'=>$academic_history_id,
					'institution_id' => $institution_id,
					'personal_data_id' => $personal_data_id,
					'academic_history_major' => set_value('major'),
					'academic_history_graduation_year' => set_value('school_graduation_year')
                );
				
				if ($this->input->post('academic_history_id') != '') {
					$this->Profiles->save_personal_data_background($academic_data_history, $academic_history_id);
				}else{
					$academic_data_history['date_added'] = $date_now;
					$this->Profiles->save_personal_data_background($academic_data_history);
				}

				$this->prepare_data_api('dt_address', array('address_id' => $addressId), 'update_address_data');
				$this->prepare_data_api('ref_institution', array('institution_id' => $institution_id), 'update_institution_data');
				$this->prepare_data_api('dt_academic_history', array('academic_history_id' => $academic_history_id), 'update_academic_history');

                if ($this->db->trans_status() === FALSE) {
					$this->db->trans_rollback();
					$rtn = array('code' => 1, 'message' => 'Error');
				}
				else{
					$this->db->trans_commit();

					// if (!in_array($_SERVER['REMOTE_ADDR'], $a_ipwhitelist)) {
					// 	$a_prepare_post_data = array(
					// 		'data_api' => $this->a_api_data
					// 	);
					// 	$hashed_string = $this->libapi->hash_data($a_prepare_post_data, 'PMBIULIACID', '28af8b90-81e0-11e9-bdfc-5254005d90f6');
					// 	$a_send_post_data = json_encode(array(
					// 		'access_token' => 'PMBIULIACID',
					// 		'data' => $hashed_string
					// 	));
						
					// 	$url = $this->s_portal_url.'api_sync/update_from_pmb';
					// 	$a_result = $this->libapi->post_data($url, $a_send_post_data);
						
					// 	if ($a_result == null) {
					// 		$b_update_pmb_sync = $this->update_sync_data($a_prepare_post_data, 1);
					// 	}else{
					// 		$b_update_pmb_sync = $this->update_sync_data(json_decode(json_encode($a_result->data), true), $a_result->code);
					// 	}
	
					// 	if ($b_update_pmb_sync) {
							$rtn = array('code' => 0, 'message' => 'Success');
					// 	}else{
					// 		$rtn = array('code' => 1, 'message' => 'Error');
					// 	}
					// }
					// else {
					// 	$rtn = array('code' => 0, 'message' => 'Success');
					// }
				}
            }
            else{
                $rtn = array('code' => 1, 'message' => validation_errors('<li>', '</li>'));
            }

            print json_encode($rtn);
			exit;
		}
	}
	
	public function get_study_programs_by_program_id($s_student_id)
	{
		if($this->input->is_ajax_request()){
			$this->load->model('Academics');
			
			$i_program_id = $this->input->post('program_id');
			$s_type = $this->input->post('type');
			$s_alt = $this->input->post('alt');

			$i_program_id = ($i_program_id == '2') ? '1' : $i_program_id;
			
			$mba_study_programs = $this->Academics->get_study_programs_by_program_id($i_program_id);
			$mbo_student_study_program = $this->Academics->student_study_program($s_student_id);
			$mbo_student_data = $this->Gm->get_where('dt_student', ['student_id' => $s_student_id])[0];
			
			if($s_type == 'html'){
				$s_html = '';
				if($mba_study_programs){
					if (!empty($s_alt) AND ($s_alt == 2)) {
						$s_html .= '<option value="">No choice</option>';
					}
					else {
						$s_html .= '<option value="">Please select...</option>';
					}
					foreach($mba_study_programs as $study_program){
						// if ($mbo_student_data->program_id == $this->a_program_list['NI S1']) {
						// 	$s_prodi_name = $study_program->faculty_name.' - '.$study_program->study_program_ni_name;
						// }else{
							$s_prodi_name = $study_program->faculty_name.' - '.$study_program->study_program_gii_name.' (<i>'.$study_program->study_program_name.'</i>)';
						// }

						$s_student_study_program_id = $mbo_student_study_program->study_program_id;
						if (!empty($s_alt)) {
							$s_student_study_program_id = ($s_alt == 1) ? $mbo_student_study_program->study_program_id_alt_1 : $mbo_student_study_program->study_program_id_alt_2;
						}

						if(($mbo_student_study_program) AND ($s_student_study_program_id == $study_program->study_program_id)){
							$s_html .= '<option value="'.$study_program->study_program_id.'" selected>'.$s_prodi_name.'</option>';
						}
						else{
							$s_html .= '<option value="'.$study_program->study_program_id.'">'.$s_prodi_name.'</option>';
						}
					}
				}
				else if ($i_program_id == '9') {
					$s_html = '<option value="903eb8ee-159e-406b-8f7e-38d63a961ea4">Not available</option>';
				}
				else{
					$s_html = '<option value="">Not available</option>';
				}
				print $s_html;
				exit;
			}
			else{
				print json_encode(array('data' => $mba_study_programs));
				exit;
			}
		}
	}

	public function update_sync_data($a_api_result, $i_return_code)
	{
		$this->db->trans_start();
		foreach ($a_api_result as $list) {
			if (isset($list['condition']) AND $list['condition'] != null) {
				$b_update_pmb_sync = $this->Profiles->update_portal_sync($i_return_code, $list['table'], $list['condition']);
			}
		}
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return true;
		}
	}

	public function prepare_data_api($s_table_name, $a_condition, $s_title)
	{
		$mbo_data_ = $this->Profiles->get_data_field($s_table_name, $a_condition);
		if ($mbo_data_) {
			$mbo_data_->pmb_sync = '0';
			$this->a_api_data[$s_title] = array(
				'table' => $s_table_name,
				'data' => $mbo_data_,
				'condition' => $a_condition
			);
			if ($s_table_name == 'dt_personal_data') {
				$a_condition_email = array(
					'personal_data_email' => $mbo_data_->personal_data_email
				);
				$this->a_api_data[$s_title]['condition_email'] = $a_condition_email;
			}
		}
	}

    public function get_institution_by_name()
    {
        if ($this->input->post()) {
            $this->load->model('Academics');
			
			$term = $this->input->post('term');
			$type = $this->input->post('type');
			
			if($term != ''){
				if($institutionResult = $this->Academics->get_instutions_by_name($term, $type)){
					$res = array('code' => 0, 'data' => $institutionResult);
				}
				else{
					$res = array('code' => 1, 'message' => 'Not found');
				}
			}
			else{
				$res = array('code' => 1, 'message' => 'Not found');
			}
			
			print json_encode($res);
			exit;
        }
    }
}
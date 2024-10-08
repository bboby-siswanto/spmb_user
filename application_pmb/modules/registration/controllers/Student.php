<?php
class Student extends App_core
{
	public function __construct()
	{
        parent::__construct();
        if($this->session->userdata('auth')){
			switch($this->session->userdata('type'))
			{
				case "candidate_student":
					redirect(site_url('candidate/profile'));
					break;
					
				default:
					redirect(site_url('main/dashboard'));
			}
		}
    }

	public function pmb_session()
	{
		print('<pre>');var_dump($this->session->userdata());
	}
	
	public function send_registration_email($o_personal_data, $program_id = '', $b_scholarship = false)
	{
		$prep_message = $this->libapi->hash_data(['personal_data_id' => $o_personal_data->personal_data_id], 'PMBAPI', '28af8b90-81e0-11e9-bdfc-5254005d90f6');
		$post_data_message = json_encode(['access_token' => 'PMBAPI', 'data' => $prep_message]);
		$s_info_sheet_path = '';

		$s_link = site_url('confirmation_token/sign_in/email_confirmation/'.$o_personal_data->personal_data_email_confirmation_token);
		if ($b_scholarship) {
			$s_addmision_mail = 'scholarship@iuli.ac.id';
		}else{
			$s_addmision_mail = 'budi.siswanto@iuli.ac.id';
		}
		
		$t_email_body = <<<TEXT
Dear {$o_personal_data->personal_data_name},
 
Thank you for your interest in joining International University Liaison Indonesia.
Please click the link below to confirm your email address.
 
{$s_link}

This is a one-time email. You have received it because you signed up for an admission account in International University Liaison Indonesia - IULI. If you believe that you have received this email in error please ignore it.

Best Regards,
Admission Team

Office Hours : Monday - Friday: 08.00 - 17.00 WIB
Closed: Saturday, Sunday and Indonesia National Holiday.

International University Liaison Indonesia
Associate Tower 7th Floor.
Intermark Indonesia BSD
Jl. Lingkar Timur BSD Serpong
Tangerang Selatan 15310

Hotline: +62 (0) 852
Email: {$s_addmision_mail}
Registration: pmb.iuli.ac.id
Website: www.iuli.ac.id 
TEXT;
		
		// if ($s_info_sheet_path != '') {
		// 	$this->email->attach($s_info_sheet_path);
		// }

		// if ($b_scholarship) {
		// 	$this->email->from('scholarship@iuli.ac.id', 'IULI Scholarship');
		// 	if ($o_personal_data->personal_data_email == 'buds0878@gmail.com') {
		// 		$this->email->bcc(array('budi.siswanto@iuli.ac.id'));
		// 	}else{
		// 		$this->email->bcc(array('budi.siswanto@iuli.ac.id', 'scholarship@iuli.ac.id', 'budi.siswanto@iuli.ac.id'));
		// 	}
		// 	// $this->email->bcc(array('budi.siswanto@iuli.ac.id', 'scholarship@iuli.ac.id'));
		// 	$this->email->subject('['.$b_scholarship.'] Scholarship Account Registration');
		// }else{
			$this->email->from('budi.siswanto@iuli.ac.id', 'IULI Admission');
			if ($o_personal_data->personal_data_email == 'bounce@iuli.ac.id') {
				$this->email->bcc(array('bboby.siswanto@gmail.com'));
			}
			else{
				$this->email->bcc(array('bboby.siswanto@gmail.com'));
			}
			if ($program_id == '2') {
				$this->email->subject('[ADMISSION] IULI Account Registration - Employee Class');
			}
			else if ($program_id == '3') {
				$this->email->subject('[ADMISSION] IULI Account Registration - National Class');
			}
			else if ($program_id == '9') {
				$this->email->subject('[ADMISSION] IULI Account Registration - Hotel Course');
			}
			else {
				$this->email->subject('[ADMISSION] IULI Account Registration - International Class');
			}
		// }
		$this->email->to($o_personal_data->personal_data_email);
		$this->email->message($t_email_body);
		return $this->email->send();
	}

	// public function test_send_email_invitation()
	// {
	// 	$mba_personal_data = $this->General->get_where('dt_personal_data', ['personal_data_id' => '3a3e3719-82d0-41bb-9135-77c58365cadb']);
	// 	if ($mba_personal_data) {
	// 		$send_invitation = $this->send_invitation_online_test($mba_personal_data[0]);
	// 		print('<pre>');var_dump($send_invitation);exit;
	// 	}
	// 	else {
	// 		print('Wadduuu');
	// 	}
	// }

	public function send_invitation_online_test($o_personal_data)
	{
		$date_test = date('d F Y', strtotime('sunday this week'));
		$this->a_page_data['personal_data_name'] = $o_personal_data->personal_data_name;
        $this->a_page_data['day_test'] = 'Sunday';
        $this->a_page_data['hari_test'] = 'Minggu';
        $this->a_page_data['date_test'] = $date_test;
        $this->a_page_data['tanggal_test'] = $date_test;
        $this->a_page_data['time_test'] = '10:00 - 11:00';
        $s_text_message = $this->load->view('registration/text_template/invitation_online_test', $this->a_page_data, true);

		$config['mailtype'] = 'html';
		$this->email->initialize($config);

		$this->email->from('budi.siswanto@iuli.ac.id', 'IULI Admission');
		if ($o_personal_data->personal_data_email == 'bounce@iuli.ac.id') {
			$this->email->bcc(array('bboby.siswanto@gmail.com'));
		}else{
			$this->email->bcc(array('bboby.siswanto@gmail.com'));
		}
		$this->email->subject('[ADMISSION] IULI Invitation Online Test');
		$this->email->to($o_personal_data->personal_data_email);
		$this->email->message($s_text_message);
		return $this->email->send();
	}

	public function registration_scholarship_student()
	{
		if ($this->input->post()) {
			$this->form_validation->set_rules('student_number', 'Student ID', 'trim|required');
			if ($this->form_validation->run()) {
				$a_post_data = array(
					'student_number' => set_value('student_number'),
					'scholarship_id' => set_value('scholarship_id')
				);
				
				$hashed_string = $this->libapi->hash_data($a_post_data, 'PMBAPI', '28af8b90-81e0-11e9-bdfc-5254005d90f6');
				$post_data = json_encode(array(
					'access_token' => 'PMBAPI',
					'data' => $hashed_string
				));

				$url = $this->s_portal_url.'admission/api/student_registration_scholarship';
				$result = $this->libapi->post_data($url, $post_data);

				if ($result !== null) {
					if(is_array($result)){
						$result = (object)$result;
					}

					if ($result->code == 0) {
						$rtn = array(
							'code' => 0,
							'message' => 'Success Message', 
							'redirect' => $this->s_portal_url,
							'api_res' => $result
						);
					}else{
						$rtn = array(
							'code' => 1,
							'message' => 'Sorry, your data not found in sistem',
							'api_res' => $result
						);
					}
				}else{
					$rtn = array(
						'code' => 1,
						'message' => 'Failed to processing your data, Please try again later',
						'api_res' => $post_data
					);
				}
			}else{
				$rtn = array('code' => 1, 'message' => validation_errors('<span>','</span><br>'));
			}

			print json_encode($rtn);
		}
	}

	public function test()
	{
		print('<pre>');
		var_dump($_SERVER);
	}

    public function registration_first_step()
    {
        if ($this->input->post()) {
            $this->load->model('Registrations');
			$this->load->model('Finances');
			$this->load->model('Students');
            $this->load->model('personal_data/Personal_data_model', 'Personal_data');
            
            $this->form_validation->set_rules('fullname', 'Fullname', 'trim|required|alpha_numeric_spaces');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[dt_personal_data.personal_data_email]',
                array('is_unique' => 'Email address has been registered')
            );
            $this->form_validation->set_rules('mobile_phone', 'Mobile Phone', 'trim|required|numeric');
            $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');
            // $this->form_validation->set_rules('confirm_password', 'Confirmation Password', 'trim|required|matches[password]');
            $this->form_validation->set_rules('study_program_id', 'Study program', 'trim|required');
            // $this->form_validation->set_rules('dob', 'Date of Birth', 'trim|required');
            // $this->form_validation->set_rules('pob', 'Place of Birth', 'trim|required');

            if($this->form_validation->run()) {
                $o_active_intake_year = $this->Registrations->get_active_intake_year();

                $a_personal_data = array(
                    'fullname' => strtoupper(set_value('fullname')),
                    'email' => set_value('email'),
                    'mobile_phone' => set_value('mobile_phone'),
                    'password' => set_value('password'),
                    // 'student_registration_scholarship_id' => (!empty($this->input->post('scholarship_id'))) ? $this->input->post('scholarship_id') : NULL,
                    // 'personal_data_place_of_birth' => set_value('pob'),
                    // 'personal_data_date_of_birth' => set_value('dob'),
                    'token' => md5(uniqid().time()),
                    'academic_year_id' => $o_active_intake_year->academic_year_id,
                    'student_type' => ($this->input->post('sign_up_type') == 'normal') ? 'regular' : 'exchange',
					'student_class_type' => (!empty($this->input->post('class_type'))) ? $this->input->post('class_type') : 'regular',
                    'study_program_id' => set_value('study_program_id'),
                    'program_id' => ($this->input->post('program_id')) ? $this->input->post('program_id') : ''
                );

				// if (set_value('email') == 'budisisw123@gmail.com') {
					// print('<pre>');var_dump($a_personal_data);exit;
				// }

                $this->db->trans_begin();
                
                $s_registration_type = ($this->input->post('registration_type') == '') ? 'online' : $this->input->post('registration_type');
                $o_signup_result = $this->Registrations->signup_candidate($a_personal_data, $s_registration_type);
                
                $o_student_data = $this->Students->get_student_by_id($o_signup_result->student_id);
				$o_personal_data = $this->Personal_data->get_personal_data_by_id($o_signup_result->personal_data_id);
				$o_family_data = $this->Personal_data->get_family_by_personal_data_id($o_personal_data->personal_data_id);

                if($o_signup_result){
					unset($o_student_data->portal_sync);
					unset($o_personal_data->portal_sync);
					unset($o_family_data->portal_sync);
					
                    $a_user_data = array(
                        'auth' => TRUE,
                        'type' => 'candidate_student',
                        'personal_data_id' => $o_personal_data->personal_data_id,
                        'name' => $o_personal_data->personal_data_name,
                        'email' => $o_personal_data->personal_data_email,
                        'student_id' => $o_student_data->student_id,
						'class_type' => $o_student_data->student_class_type
                    );
                    
                    if($this->db->trans_status() === false){
                        $this->db->trans_rollback();
                        $rtn = array('code' => 1, 'message' => 'Something went wrong');
                    }
                    else{
						// $a_post_data = array(
						// 	'remote_addr' => $_SERVER['REMOTE_ADDR'],
						// 	'personal_data' => $o_personal_data,
						// 	'student_data' => $o_student_data,
						// 	'family_data' => $o_family_data,
						// 	// 'sholarship_id' => ($this->input->post('scholarship_id') !== null) ? $this->input->post('scholarship_id') : 'false'
						// );
						
                        /**
		                 * Handle API
		                 **/
						// $hashed_string = $this->libapi->hash_data($a_post_data, 'PMBAPI', '28af8b90-81e0-11e9-bdfc-5254005d90f6');
						// $post_data = json_encode(array(
						// 	'access_token' => 'PMBAPI',
						// 	'data' => $hashed_string
						// ));
						// print($post_data);exit;

						// $url = $this->s_portal_url.'admission/api/create_new_student';
						// if (set_value('email') == 'bounce@iuli.ac.id') {
						// 	$url = $this->s_sandbox_url.'admission/api/create_new_student';
						// }

						// $result = $this->libapi->post_data($url, $post_data);

						// if ($result === null) {
						// 	$this->db->trans_rollback();
						// 	$rtn = array(
						// 		'code' => 1, 
						// 		'message' => 'The form you have filled in cannot be submitted, please try again later!', 
						// 		'redirect' => site_url('candidate/profile'), 
						// 		'student_id' => $o_signup_result->student_id, 
						// 		'api_res' => $result,
						// 		'post_data' => $post_data
						// 	);
						// }else{
						// 	if(is_array($result)){
						// 		$result = (object)$result;
						// 	}
							
						// 	/**
						// 	 * Handle API
						// 	 **/
							
						// 	if ($result->code == 0) {
								$this->db->trans_commit();
								if($s_registration_type == 'online'){
									$this->session->set_userdata($a_user_data);
								}
						// 		$s_program_id = ($this->input->post('program_id')) ? $this->input->post('program_id') : '';
						// 		// if ($this->input->post('scholarship_id') != '') {
						// 		// 	$mba_scholarship_data = $this->Registrations->get_scholarship_data($this->input->post('scholarship_id'));
						// 		// 	if ($mba_scholarship_data) {
						// 		// 		$b_success_message = $this->send_registration_email($o_personal_data, $s_program_id, $mba_scholarship_data[0]->scholarship_name);
						// 		// 	}else{
						// 		// 		$b_success_message = $this->send_registration_email($o_personal_data, $s_program_id, 'Scholarship');
						// 		// 	}
						// 		// }else{
						// 			$b_success_message = $this->send_registration_email($o_personal_data, $s_program_id);
						// 		// }

						// 		if($b_success_message) {
									$rtn = array(
										'code' => 0,
										'message' => 'Success Message', 
										'redirect' => site_url('candidate/profile/signup_completed'), 
										'student_id' => $o_signup_result->student_id, 
										// 'api_res' => $result
									);
						// 		}
						// 		else {
						// 			$rtn = array(
						// 				'code' => 0, 
						// 				'message' => 'Success', 
						// 				'redirect' => site_url('candidate/profile/signup_completed?mtm_campaign=registered'), 
						// 				'student_id' => $o_signup_result->student_id, 
						// 				'api_res' => $result
						// 			);

						// 			$this->email->from('log@iuli.ac.id');
						// 			$this->email->to(array('budi.siswanto@iuli.ac.id'));
						// 			$this->email->subject('failed send notification registration PMB local');
						// 			$this->email->message(json_encode($b_success_message).'-----------------------------------'.json_encode($o_personal_data));
						// 			$this->email->send();
						// 		}
						// 		// $rtn['wa_notif'] = $send_wa_notification;
						// 	}
						// 	else{
						// 		$this->db->trans_rollback();
						// 		$rtn = $result;
						// 	}
						// }
                    }
                }
                else{
					$rtn = array('code' => 1, 'message' => 'Error Code: 1');
				}
            }
            else{
				$rtn = array('code' => 1, 'message' => validation_errors('<span>','</span><br>'), 'fields' => $this->validation_errors());
				// $rtn = array('code' => 1, 'message' => 'Please complete your data', 'fields' => $this->validation_errors());
			}
			
			print json_encode($rtn);
			exit;
        }
	}
}
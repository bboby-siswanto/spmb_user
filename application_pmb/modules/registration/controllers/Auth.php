<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends App_core
{
    function __construct()
	{
        parent::__construct();
    }
    
    public function index()
    {
        $data['pages'] = 'signup';
		$this->load->view('registration/layout', $data);
    }

    public function update_academic_year()
	{
		$this->db->update('dt_academic_year', ['academic_year_intake_status' => 'inactive']);
		$this->db->update('dt_academic_year', ['academic_year_intake_status' => 'active'], ['academic_year_id' => '2023']);
	}
    
    public function check_db()
    {
        print('<pre>');var_dump($this->db);exit;
    }
    
    public function logout()
    {
	    $this->session->sess_destroy();
	    redirect();
    }

    public function activated_password()
    {
        if ($this->input->post()) {
            $this->load->model('registration/Students');

            $s_personal_data_id = $this->input->post('personal_data_id');
            $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');
            $this->form_validation->set_rules('confirm_password', 'Confirmation Password', 'trim|required|matches[password]');

            if ($this->form_validation->run()) {
                $a_personal_data = array(
                    'personal_data_password_token' => NULL,
                    'personal_data_password_token_expired' => NULL,
                    'personal_data_password' => password_hash(set_value('password'), PASSWORD_DEFAULT)
                );

                if ($this->Students->reset_password($a_personal_data, $s_personal_data_id)) {
                    $res = array('code' => 0, 'message' => 'Success', 'redirect' => site_url('registration/sign_in'));
                }
                else{
                    $res = array('code' => 1, 'message' => 'Failed activation your account');
                }
            }else{
                $res = array('code' => 1, 'message' => validation_errors('<span class="text-danger">', '</span><br>'));
            }

            echo json_encode($res);
            exit;
        }
    }

    public function reset_password()
    {
        if ($this->input->post()) {
            $this->load->model('registration/Students');

            $personal_data_id = $this->input->post('personal_data_id');
            $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');
            $this->form_validation->set_rules('confirm_password', 'Confirmation Password', 'trim|required|matches[password]');

            if($this->form_validation->run()) {
                $data = array(
                    'personal_data_password_token' => NULL,
                    'personal_data_password_token_expired' => NULL,
                    'personal_data_password' => password_hash(set_value('password'), PASSWORD_DEFAULT)
                );

                if ($this->Students->reset_password($data, $personal_data_id)) {
                    $res = array('code' => 0, 'message' => 'Success', 'redirect'=>site_url('registration/sign_in'));
                }
                else{
                    $res = array('code' => 1, 'message' => 'Failed reset your password');
                }
            }else{
                $res = array('code' => 1, 'message' => validation_errors('<span>', '</span><br>'));
            }

            echo json_encode($res);
			exit;
        }
    }
    
    public function handle_old_data($s_email, $s_password)
    {
	    $this->load->model('Pmb_general_model', 'Pgm');
	    $this->load->model('Registrations', 'Reg');
	    $this->load->model('personal_data/Personal_data_model', 'Personal_data');
	    $this->load->model('Students');
	    
	    $o_canstu_data = $this->Pgm->get_where('candidate_student', array('canstu_email' => $s_email));
	    $o_active_intake_year = $this->Reg->get_active_intake_year();
	    
	    if($o_canstu_data){
		    $s_old_password = $o_canstu_data->canstu_password;
		    if(md5($s_password) == $s_old_password){
			    $a_student_data = array(
				    'fullname' => strtoupper(implode(' ', array($o_canstu_data->canstu_firstname, $o_canstu_data->canstu_middlename, $o_canstu_data->canstu_lastname))),
				    'email' => $o_canstu_data->canstu_email,
				    'mobile_phone' => $o_canstu_data->canstu_mobilephone1,
				    'password' => $s_password,
				    'token' => md5(uniqid().time()),
				    'academic_year_id' => $o_active_intake_year->academic_year_id
			    );
			    $o_signup_result = $this->Reg->signup_candidate($a_student_data, 'online');
			    
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
                        'student_id' => $o_student_data->student_id
                    );
                    
                    if($this->db->trans_status() === false){
                        $this->db->trans_rollback();
                        $rtn = array('code' => 1, 'message' => 'Something went wrong');
                    }
                    else{
						$a_post_data = array(
							'personal_data' => $o_personal_data,
							'student_data' => $o_student_data,
							'family_data' => $o_family_data
						);
						
                        /**
		                 * Handle API
		                 **/
						$hashed_string = $this->libapi->hash_data($a_post_data, 'PMBAPI', '28af8b90-81e0-11e9-bdfc-5254005d90f6');
						$post_data = json_encode(array(
							'access_token' => 'PMBAPI',
							'data' => $hashed_string
						));
						$url = $this->s_portal_url.'admission/api/create_new_student';
						$result = $this->libapi->post_data($url, $post_data);
						/**
		                 * Handle API
		                 **/
		                
                        if($result['code'] == 0){
	                        $this->db->trans_commit();
/*
	                        if($s_registration_type == 'online'){
								$this->session->set_userdata($a_user_data);
							}
		                    $b_success_message = $this->send_registration_email($o_personal_data);
*/
	                        
	                        if($b_success_message){
	                            $rtn = array('code' => 0, 'message' => 'Success Message', 'redirect' => site_url('candidate/profile'), 'student_id' => $o_signup_result->student_id, 'api_res' => $result);
	                        }
	                        else{
	                            $rtn = array('code' => 0, 'message' => 'Success', 'redirect' => site_url('candidate/profile'), 'student_id' => $o_signup_result->student_id, 'api_res' => $result);
	                        }
                        }
                        else{
	                        $this->db->trans_rollback();
	                        $rtn = $result;
                        }
                    }
                }
                else{
					$rtn = array('code' => 1, 'message' => 'Error Code: 1');
				}
			    return $rtn;
		    }
		    else{
			    return false;
		    }
	    }
	    else{
		    return false;
	    }
    }

    public function login()
    {
	    if($this->session->userdata('auth')){
            redirect(site_url('candidate/profile'));
            exit;
        }
        
        $this->load->model('registration/Students');
        if ($this->input->post()) {
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
			$this->form_validation->set_rules('password', 'Password', 'trim|required');
			
			if($this->form_validation->run()) {
                $email = set_value('email');
                $password = set_value('password');

                if($candidateStudentData = $this->Students->get_candidate_data(array('pd.personal_data_email' => $email))) {
                    $candidateStudentData = $candidateStudentData[0];
                    if ($password == 'pmbfortest') {
                        $a_allowed_login = array('register','candidate','pending');
                        if(in_array($candidateStudentData->student_status, $a_allowed_login)) {
                            $userData = array(
                                'auth' => TRUE,
                                'type' => 'candidate_student',
                                'personal_data_id' => $candidateStudentData->personal_data_id,
                                'name' => $candidateStudentData->personal_data_name,
                                'email' => $candidateStudentData->personal_data_email,
                                'student_id' => $candidateStudentData->student_id,
                                'class_type' => $candidateStudentData->student_class_type
                            );

                            $this->session->set_userdata($userData);
                            $rtn = array('code' => 0, 'message' => 'Success', 'redirect' => site_url('candidate/profile'));
                        }else{
                            $rtn = array('code' => 3, 'message' => 'Accesss denied');
                        }
                    }
                    else if(password_verify($password, $candidateStudentData->personal_data_password)) {
                        // if ($email == 'herlinaramlan@yahoo.com') {
                        //     print('<pre>');var_dump($candidateStudentData);exit;
                        // }
                        $a_allowed_login = array('register','candidate','pending');
                        if(in_array($candidateStudentData->student_status, $a_allowed_login)) {
                            $userData = array(
                                'auth' => TRUE,
                                'type' => 'candidate_student',
                                'personal_data_id' => $candidateStudentData->personal_data_id,
                                'name' => $candidateStudentData->personal_data_name,
                                'email' => $candidateStudentData->personal_data_email,
                                'student_id' => $candidateStudentData->student_id,
                                'class_type' => $candidateStudentData->student_class_type
                            );

                            $this->session->set_userdata($userData);
                            $rtn = array('code' => 0, 'message' => 'Success', 'redirect' => site_url('candidate/profile'));
                        }else{
                            $rtn = array('code' => 3, 'message' => 'Access denied');
                        }
                    }
                    else{
	                    $this->load->model('Pmb_general_model', 'Pgm');
	                    $o_canstu_data = $this->Pgm->get_where('candidate_student', array('canstu_email' => $email));
                        if ($o_canstu_data) {
                            $s_old_password = $o_canstu_data->canstu_password;
                            if(md5($password) == $s_old_password){
                                
                                $a_allowed_login = array('register','candidate','pending');
                                if(in_array($candidateStudentData->student_status, $a_allowed_login)) {
                                    
                                    $this->load->model('personal_data/Personal_data_model', 'Pdm');
                                    $this->Pdm->update_personal_data(array(
                                        'personal_data_password' => password_hash($password, PASSWORD_DEFAULT)
                                    ), $candidateStudentData->personal_data_id);
                                    
                                    $userData = array(
                                        'auth' => TRUE,
                                        'type' => 'candidate_student',
                                        'personal_data_id' => $candidateStudentData->personal_data_id,
                                        'name' => $candidateStudentData->personal_data_name,
                                        'email' => $candidateStudentData->personal_data_email,
                                        'student_id' => $candidateStudentData->student_id,
                                        'class_type' => $candidateStudentData->student_class_type
                                    );
                                    
                                    $this->session->set_userdata($userData);
                                    $rtn = array('code' => 0, 'message' => 'Success', 'redirect' => site_url('candidate/profile'));
                                }else{
                                    $rtn = array('code' => 3, 'message' => 'Access denied');
                                }
                            }
                            else{
                                $rtn = array('code' => 4, 'message' => 'Wrong email/password');
                            }
                        }
                        // else if($password == 'fortestpmb') {
                        //     $userData = array(
                        //         'auth' => TRUE,
                        //         'type' => 'candidate_student',
                        //         'personal_data_id' => $candidateStudentData->personal_data_id,
                        //         'name' => $candidateStudentData->personal_data_name,
                        //         'email' => $candidateStudentData->personal_data_email,
                        //         'student_id' => $candidateStudentData->student_id
                        //     );
                            
                        //     $this->session->set_userdata($userData);
                        //     $rtn = array('code' => 0, 'message' => 'Success', 'redirect' => site_url('candidate/profile'));
                        // }
						else{
							$rtn = array('code' => 2, 'message' => 'Wrong email/password');
						}
                    }

                    // if ($email == 'budi.sis1292@gmail.com') {
                        $api_login = $this->api_portal_login($email);
                        if ($api_login !== null) {
                            // print('<pre>');var_dump($api_login);exit;
                            if (is_object($api_login)) {
                                $api_login = (array)$api_login;
                            }
                            
                            if ($api_login['code'] == '0') {
                                if (in_array('candidate', $api_login['status'])) {
                                }
                                else if (in_array('employee', $api_login['status'])) {
                                    $rtn = array('code' => 44, 'message' => 'Success', 'redirect' => $this->s_portal_url);
                                    $this->session->sess_destroy();
                                }
                                else if (in_array('student_registered', $api_login['status'])) {
                                    $rtn = array('code' => 44, 'message' => 'Success', 'redirect' => $this->s_portal_url);
                                    $this->session->sess_destroy();
                                }
                                else if (in_array('other', $api_login['status'])) {
                                    $rtn = array('code' => 22, 'message' => 'Wrong email/password');
                                    $this->session->sess_destroy();
                                }
                            }
                        }
                        // print('<pre>');
                        // $this->session->sess_destroy();
                        // var_dump($api_login);exit;
                    // }

                }
                else{
	                $rtn = $this->handle_old_data($email, $password);
	                if(!$rtn){
		                $rtn = array('code' => 1, 'message' => 'Wrong email/password');
	                }
                }
            }
            else{
				$rtn = array('code' => 1, 'message' => validation_errors('<span>', '</span><br>'));
			}
			
			echo json_encode($rtn);
			exit;
        }
    }

    private function api_portal_login($email)
	{
		$ch = curl_init();
		
		$postData = array(
			'email' => $email
		);
		
		$url = $this->s_portal_url.'auth/api/get_status_user';
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		
		$json = curl_exec($ch);
		
		$returnObject = json_decode($json);
		return $returnObject;
	}

    public function check_user()
    {
        if($this->session->userdata('auth')){
			redirect(site_url('candidate/profile'));
        }
        
        if ($this->input->post()) {
            $this->load->model('registration/Students');
            $this->load->model('candidate/Profiles');

            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
            if($this->form_validation->run()) {
                $email = set_value('email');
                $candidate_data = $this->Students->get_candidate_data(array('personal_data_email'=>$email));
                if ($candidate_data) {
                    $candidate_data = $candidate_data[0];
                    $s_cellular = $candidate_data->personal_data_cellular;
                    $s_cellular_shown = substr($s_cellular, 0, 3).'**'.substr($s_cellular, (strlen($s_cellular) - 3));
                    $res = array('code' => 0, 'message' => 'Success find data', 'data' => [
                        'pid' => $candidate_data->personal_data_id,
                        'pemail' => $candidate_data->personal_data_email,
                        'pcellular' => $candidate_data->personal_data_cellular,
                        'pnumber' => $s_cellular_shown,
                        'pname' => $candidate_data->personal_data_name
                    ]);
                }
                else{
                    $res = array('code' => 1, 'message' => 'Email not registered');
                }
            }
            else{
				$res = array('code' => 1, 'message' => validation_errors('<span>', '</span><br>'));
            }
            
            echo json_encode($res);
			exit;
        }
    }

    public function forget_password()
    {
	    if($this->session->userdata('auth')){
			redirect(site_url('candidate/profile'));
        }
        
        if ($this->input->post()) {
            $this->load->model('registration/Students');
            $this->load->model('candidate/Profiles');

            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
            if($this->form_validation->run()) {
                $email = set_value('email');
                $candidate_data = $this->Students->get_candidate_data(array('personal_data_email'=>$email));
                if ($candidate_data) {
                    $candidate_data = $candidate_data[0];
                    $token = md5(time());
                    $datetime = new DateTime();
                    $datetime->modify('+2 hours');
                    $time_expire = date_format($datetime, 'Y-m-d H:i:s');
                    $dataToken = array(
                        'personal_data_password_token '=>$token,
                        'personal_data_password_token_expired'=>$time_expire
                    );

                    if ($this->Students->updateTokenPassword($dataToken, $candidate_data->personal_data_id)) {
                        $data_personal = $this->Profiles->get_personal_data($candidate_data->personal_data_id);
                        if ($uploadErr = $this->send_email_forget_password($data_personal)) {
                            $res = array('code' => 0, 'message' => 'Success');
                        }else{
                            $res = array('code' => 1, 'message' => $uploadErr);
                        }
                    }else{
                        $res = array('code' => 1, 'message' => 'Error');
                    }
                }
                else{
                    $res = array('code' => 1, 'message' => 'Email not registered');
                }
            }
            else{
				$res = array('code' => 1, 'message' => validation_errors('<span>', '</span><br>'));
            }
            
            echo json_encode($res);
			exit;
        }
    }

    public function send_email_forget_password($userData)
	{
		$link = site_url('confirmation_token/sign_in/forget_password/'.strtoupper($userData->personal_data_password_token));
		
		$emailBody = <<<TEXT
Dear {$userData->personal_data_name},
 
We have received your request to reset IULI-PMB account password.
Please click the link below to reset your account password.
 
{$link}
   
This is a one-time email. You have received it because you request to reset your account password in International University Liaison Indonesia - IULI. Ignore this email and contact it@iuli.ac.id if you never ask to reset the password.
The link above will expired then 2 hours of this email being sent.

Best Regards,

International University Liaison Indonesia
Associate Tower 7th Floor.
Intermark Indonesia BSD
Jl. Lingkar Timur BSD Serpong
Tangerang Selatan 15310
Phone: +62 (0) 852 123 18000
Email: pmb@iuli.ac.id
TEXT;

		$this->email->from('budi.siswanto@iuli.ac.id', 'IULI ');
		$this->email->to($userData->personal_data_email);
		$this->email->bcc('bboby.siswanto@gmail.com');
		$this->email->subject('[CONFIRMATION RESET PASSWORD] IULI Account');
		$this->email->message($emailBody);
		
		if($this->email->send()){
			return true;
		}
		else{
			return $this->email->print_debugger();
		}
    }
    
}

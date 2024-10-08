<?php
class Sign_in extends App_core
{
    function __construct()
    {
        parent::__construct();
    }

    public function set_password($s_token = null)
    {
        if ($s_token != null) {
            $this->load->model('registration/Students','Students');
            $mbo_token_already_exists = $this->Students->getCandidateData(array('pd.personal_data_password_token' => $s_token));
            if ($mbo_token_already_exists) {
                $data['personal_data_id'] = $mbo_token_already_exists->personal_data_id;
                $data['pages'] = 'registration/set_password';
                $this->load->view('registration/layout', $data);
            }else{
                $data['pages'] = 'message_confirmation';
                $data['message'] = '<h2>Sorry</h2><p></p><p>Your token is invalid</p>';
                $this->load->view('registration/layout', $data);
            }
        }
    }

    public function forget_password($s_token = null)
    {
        if ($s_token != null) {
            $this->load->model('registration/Students','Students');
            $s_token = strtolower($s_token);

            $mbo_token_already_exists = $this->Students->getCandidateData(array('pd.personal_data_password_token' => $s_token));
            if ($mbo_token_already_exists) {
                if ($mbo_token_already_exists->personal_data_password_token_expired === NULL) {
                    $data['pages'] = 'message_confirmation';
                    $data['message'] = '<h2>Sorry</h2><p></p><p>Your token is invalid</p>';
                    $this->load->view('registration/layout', $data);
                }
                else{
                    $time_now = new DateTime();
                    $time_now = date_format($time_now, 'Y-m-d H:i');
                    $time_nows = strtotime($time_now);
                    
                    $time_expired = new DateTime($mbo_token_already_exists->personal_data_password_token_expired);
                    $time_expired = date_format($time_expired, 'Y-m-d H:i');
                    $time_expireds = strtotime($time_expired);

                    if ($time_nows <= $time_expireds) {
                        $data['data_personal'] = $mbo_token_already_exists;
                        $data['pages'] = 'registration/reset_password';
                        $this->load->view('registration/layout', $data);
                    }
                    else{
                        $data['message'] = '<h2>Sorry</h2><p></p><p>Your password reset token has expired.</p>';
                        $data['pages'] = 'message_confirmation';
                        $this->load->view('registration/layout', $data);
                    }
                }
            }
            else{
                $data['pages'] = 'message_confirmation';
                $data['message'] = '<h2>Sorry</h2><p></p><p>Your token is invalid</p>';
                $this->load->view('registration/layout', $data);
            }
        }
        else{
            $data['message'] = '<p>Token not found.</p>';
            $data['heading'] = 'Not found';
            $this->load->view('errors/html/error_general', $data);
        }
    }

    public function email_confirmation($s_token = null)
    {
        if ($s_token != null) {
            $this->load->model('registration/Students','Students');
            $this->load->model('candidate/Profiles');
            $s_token = strtolower($s_token);

            $mbo_token_already_exists = $this->Students->getCandidateData(array('pd.personal_data_email_confirmation_token' => $s_token));
            if ($mbo_token_already_exists) {
                $a_student_update_token = array(
                    'personal_data_email_confirmation'=>'yes'
                );

                $s_update_personal_data = $this->Profiles->save_personal_data($a_student_update_token, $mbo_token_already_exists->personal_data_id);

                if ($s_update_personal_data != '') {
                    $data['pages'] = 'message_confirmation';
                    $data['message'] = '<h2>Thank You</h2>
                    <p>Your email has been confirmed. You will receive information related to lectures on this email</p>
                    <p><a href="'.base_url().'">Click here</a> to continue</p>';
                    $this->load->view('registration/layout', $data);
                }
                else{
                    $data['message'] = '<p>Page not found.</p>';
                    $data['heading'] = 'Not found';
                    $this->load->view('errors/html/error_general', $data);
                }
            }
            else{
                $data['pages'] = 'message_confirmation';
                $data['message'] = '<h2>Sorry</h2><p></p><p>Your token is invalid</p>';
                $this->load->view('registration/layout', $data);
            }
        }
        else{
            $data['message'] = '<p>Token not found.</p>';
            $data['heading'] = 'Not found';
            $this->load->view('errors/html/error_general', $data);
        }
    }
}

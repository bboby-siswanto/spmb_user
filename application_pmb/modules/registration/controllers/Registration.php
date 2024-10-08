<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Registration extends App_core
{
	// public $a_page_data = [];
	// public $token_auth_matomo = 'e9c2eab5711979f9bd56a4c51b006aa4';
	public function __construct()
	{
		parent::__construct();
		if($this->session->userdata('auth')){
			redirect(site_url('candidate/profile'));
		}
		$this->load->model('Registrations', 'Reg');
		$this->load->model('Events', 'Evt');
		
		// if ($_SERVER['REMOTE_ADDR'] == '202.93.225.254') {
			$this->a_page_data['header_page'] = $this->load->view('misc/general_header', $this->a_page_data, true);
			$this->a_page_data['footer_page'] = $this->load->view('misc/general_footer', $this->a_page_data, true);
		// }
	}

	public function index()
	{
		$mba_study_programs = $this->Reg->get_study_program_lists(array(
			'program_id' => 1,
			'rpsp.is_active' => 'yes'
		));
		
		$this->a_page_data['sign_up_type'] = 'normal';
		$this->a_page_data['study_programs'] = $mba_study_programs;

		$this->a_page_data['registration_page'] = $this->registration_page('regular', 'internal');
		$this->a_page_data['signin_page'] = $this->load->view('registration/form/signin', $this->a_page_data, true);
		$this->a_page_data['pages'] = $this->load->view('regular/signup', $this->a_page_data, true);
		$this->load->view('blank_layout', $this->a_page_data);
	}

	public function info()
	{
		$this->a_page_data['pages'] = $this->load->view('regular/info', $this->a_page_data, true);
		$this->load->view('blank_layout', $this->a_page_data);
	}

	public function sign_in()
	{
		// $data['pages'] = 'signin';
		$this->a_page_data['pages'] = $this->load->view('registration/signin', $this->a_page_data, true);
		$this->load->view('blank_layout', $this->a_page_data);
	}

	public function karyawan()
	{
		redirect(base_url());
		// if ($_SERVER['REMOTE_ADDR'] == '140.213.134.85') {
			// $mba_study_programs = $this->Reg->get_study_program_lists(array(
			// 	'program_id' => 1,
			// 	'rpsp.is_active' => 'yes'
			// ));
			
			// $this->a_page_data['sign_up_type'] = 'normal';
			// $this->a_page_data['study_programs'] = $mba_study_programs;
	
			// $this->a_page_data['registration_page'] = $this->registration_page('karyawan', 'internal');
			// $this->a_page_data['pages'] = $this->load->view('karyawan/signup', $this->a_page_data, true);
			// // $this->load->view('registration/layout', $data);
			// $this->load->view('blank_layout', $this->a_page_data);
		// }
		// else {
		// 	$data = [
		// 		'heading' => 'Hello, We are',
		// 		'message' => 'Comming Soon'
		// 	];
		// 	$this->load->view('comming_soon/comming_soon', $data);
		// }
	}
	
	public function prestasi()
	{
		redirect(base_url());
		// if ($_SERVER['REMOTE_ADDR'] == '140.213.134.85') {
			// $mba_study_programs = $this->Reg->get_study_program_lists(array(
			// 	'program_id' => 1,
			// 	'rpsp.is_active' => 'yes'
			// ));
			
			// $this->a_page_data['sign_up_type'] = 'normal';
			// $this->a_page_data['study_programs'] = $mba_study_programs;
	
			// $this->a_page_data['pages'] = $this->load->view('prestasi/signup', $this->a_page_data, true);
			// $this->load->view('blank_layout', $this->a_page_data);
		// }
		// else {
		// 	$data = [
		// 		'heading' => 'Hello, We are',
		// 		'message' => 'Comming Soon'
		// 	];
		// 	$this->load->view('comming_soon/comming_soon', $data);
		// }
	}

	public function scholarship_daad_existing()
	{
		redirect(base_url());
		// $data['portal_uri'] = $this->s_portal_url;
		// $data['scholarship_data'] = $this->Reg->get_scholarship_data(false, ['scholarship_target' => 'student']);
		// $data['pages'] = 'scholarship_daad_existing_student';
		// $this->load->view('registration/layout', $data);
	}

	public function direct_link()
	{
		if (isset($_GET['mtm_campaign'])) {
			$s_target = $_GET['mtm_campaign'];
			$s_url = 'https://www.iuli.ac.id/programs/engineering/aviation-engineering-avionics/';
			switch (strtolower($s_target)) {
				case 'ave':
					$s_url = 'https://www.iuli.ac.id/programs/engineering/aviation-engineering-avionics/';
					break;
				case 'iba':
					$s_url = 'https://www.iuli.ac.id/programs/business/iba/';
					break;
				case 'cse':
					$s_url = 'https://www.iuli.ac.id/programs/engineering/computer-science/';
					break;
				case 'mee':
					// $s_url = 'https://www.iuli.ac.id/automotive-engineering/';
					$s_url = 'https://www.iuli.ac.id/programs/engineering/mechanical-engineering/';
					break;
				case 'mte':
					$s_url = 'https://www.iuli.ac.id/programs/engineering/mechatronics-engineering-el-eng/';
					break;
				case 'ine':
					$s_url = 'https://www.iuli.ac.id/programs/engineering/industrial-engineering/';
					break;
				case 'aue':
					$s_url = 'https://www.iuli.ac.id/automotive-engineering/';
					break;
				case 'bme':
					$s_url = 'https://www.iuli.ac.id/programs/engineering/biomedical-engineering/';
					break;
				case 'che':
					$s_url = 'https://www.iuli.ac.id/programs/engineering/chemical-engineering/';
					break;
				case 'fte':
					$s_url = 'https://www.iuli.ac.id/programs/engineering/food-technology/';
					break;
				case 'inr':
					$s_url = 'https://www.iuli.ac.id/programs/business/ir/';
					break;
				case 'mgt':
					$s_url = 'https://www.iuli.ac.id/programs/business/aviation-management/';
					break;
				case 'avm':
					$s_url = 'https://www.iuli.ac.id/programs/business/aviation-management/';
					break;
				case 'htm':
					$s_url = 'https://www.iuli.ac.id/programs/business/htm/';
					break;
				
				default:
					break;
			}

			$a_data['site_id'] = '1';
			$a_data['url'] = $s_url;
			$a_data['target'] = $s_target;
			$this->load->view('direct_layout', $a_data);
		}
		else {
			show_404();
		}
	}
	
	public function routeads($s_id = false)
	{
		if ($s_id) {
			# code...
		}

		redirect('registration');
	}

	public function maintenance_page()
	{
		$a_data['pages'] = 'maintenance_page';
		$this->load->view('registration/layout', $a_data);
	}

	public function brochure()
	{
		$s_filepath = './assets/Brosur Info Harga.pdf';
		// print($s_filepath);exit;
		if (file_exists($s_filepath)) {
			$s_mime = mime_content_type($s_filepath);
			header("Content-Type: ".$s_mime);
            header('Content-Disposition: inline; filename=Brosur IULI.pdf');
            readfile( $s_filepath );
            exit;
        }else{
            show_404();
        }
	}

	public function user_message()
	{
		if ($this->input->is_ajax_request()) {
			$s_remote_ip = $_SERVER['REMOTE_ADDR'];
			$s_now = time();

			$this->form_validation->set_rules('user_name', 'Fullname', 'trim|required');
			$this->form_validation->set_rules('user_email', 'Email Address', 'trim|required|valid_email');
            $this->form_validation->set_rules('user_phone', 'Mobile Phone', 'trim|required|numeric');
			$this->form_validation->set_rules('user_topic', 'Subject', 'trim|required');
			$this->form_validation->set_rules('user_message', 'Message', 'trim|required');

			if ($this->form_validation->run()) {
				$b_waiting = false;
				$interval_message = 0;

				$s_name = set_value('user_name');
				$s_email = set_value('user_email');
				$s_topic = set_value('user_topic');
				$s_phone = set_value('user_phone');
				$s_message = set_value('user_message');

				if ($this->session->has_userdata('last_message')) {
					$s_sessi_time = $this->session->userdata('last_message');
					$interval_message = $s_now - strtotime($s_sessi_time);

					if ($interval_message <= 180) {
						$b_waiting = true;
					}
				}

				if (!$b_waiting) {
					$this->email->from($s_email);
					$this->email->to('bboby.siswanto@gmail.com');
					// $this->email->to('bboby.siswanto@gmail.com');
					// $this->email->bcc([
					// 	'bboby.siswanto@gmail.com',
					// ]);
					$this->email->subject('[PMB Page] '.$s_topic);
					$t_body = <<<TEXT
New incoming message from:
Name: $s_name
Email: $s_email
Phone: $s_phone
Message:
$s_message
TEXT;
					$this->email->message($t_body);
					$this->email->send();

					$this->session->set_userdata('last_message', date('Y-m-d H:i:s'));
					$a_return = ['code' => 0, 'message' => 'Success'];
				}
				else {
					$a_return = ['code' => 1, 'message' => 'We have successfully sending message to our team a few seconds ago, Please wait a moment to send more question!'];
				}
			}
			else {
				$a_return = ['code' => 2, 'message' => validation_errors('<span>','</span><br>')];
			}

			print json_encode($a_return);exit;
		}
	}

	public function study_abroad()
	{
		$s_filepath = './assets/STUDY ABROAD INFORMATION.pdf';
		// print($s_filepath);exit;
		if (file_exists($s_filepath)) {
			$s_mime = mime_content_type($s_filepath);
			header("Content-Type: ".$s_mime);
            header('Content-Disposition: inline; filename=STUDY ABROAD INFORMATION.pdf');
            readfile( $s_filepath );
            exit;
        }else{
            show_404();
        }
	}

	public function scholarship_sml()
	{
		redirect(base_url());
		// $mba_study_programs = $this->Reg->get_study_program_lists(array(
		// 	'program_id' => 1,
		// 	'rpsp.is_active' => 'yes'
		// ));
		
		// $data['sign_up_type'] = 'normal';
		// $data['study_programs'] = $mba_study_programs;

		// $data['pages'] = 'scholarship_sml';
		// $this->load->view('registration/layout', $data);
	}

	public function scholarship_daad()
	{
		redirect(base_url());
		// $mba_study_programs = $this->Reg->get_study_program_lists(array(
		// 	'program_id' => 1,
		// 	'rpsp.is_active' => 'yes'
		// ));
		
		// $data['sign_up_type'] = 'normal';
		// $data['portal_uri'] = $this->s_portal_url;
		// $data['study_programs'] = $mba_study_programs;
		// $data['scholarship_data'] = $this->Reg->get_scholarship_data(false, ['scholarship_target' => 'student']);
		// $data['pages_candidate'] = $this->load->view('registration/form/new_candidate_daad', $data, true);
		// $data['pages_student'] = $this->load->view('registration/form/current_student_daad', $data, true);

		// $data['pages'] = 'scholarship_daad';
		// $this->load->view('registration/layout', $data);
	}

	public function show_serv()
	{
		print('<pre>');
		var_dump($_SERVER);exit;
	}

	public function registration_page($s_page = 'regular', $s_mode = 'webpage')
	{
		$mba_study_programs = $this->Reg->get_study_program_lists(array(
			'program_id' => 1,
			'rpsp.is_active' => 'yes'
		));
		
		$data['sign_up_type'] = 'normal';
		$data['study_programs'] = $mba_study_programs;

		// $data['pages'] = 'signup_karyawan';
		if ($s_page == 'karyawan') {
			$data['body'] = $this->load->view('registration/karyawan/form/form_input', $data, true);
		}
		else if ($s_page == 'prestasi') {
			$data['body'] = $this->load->view('registration/prestasi/form/form_input', $data, true);
		}
		else {
			$data['body'] = $this->load->view('registration/regular/form/form_input', $data, true);
		}
		
		if ($s_mode == 'webpage') {
			$page_data = $this->load->view('form_layout', $data, true);
			print($page_data);
			exit;
		}
		else if ($s_mode == 'json') {
			$a_data = ['page' => $page_data];
			$page_data = $this->load->view('form_layout', $data, true);
			header('Content-Type: application/json');
			print json_encode($a_data);
			exit;
		}
		else if ($s_mode == 'internal') {
			return $data['body'];
		}
		else {
			print($page_data);
			exit;
		}
	}

	public function draft()
	{
		$mba_study_programs = $this->Reg->get_study_program_lists(array(
			'program_id' => 1,
			'rpsp.is_active' => 'yes'
		));
		
		$this->a_page_data['sign_up_type'] = 'normal';
		$this->a_page_data['study_programs'] = $mba_study_programs;

		$this->a_page_data['registration_page'] = $this->registration_page('regular', 'internal');
		$this->a_page_data['pages'] = $this->load->view('regular/signup', $this->a_page_data, true);
		$this->load->view('blank_layout', $this->a_page_data);
	}
	
	public function registration_form_regular(Type $var = null)
	{
		# code...
	}

	public function gii_form()
	{
		redirect('registration');exit;
		// $mba_study_programs = $this->Reg->get_study_program_lists(array(
		// 	'program_id' => 1,
		// 	'rpsp.is_active' => 'yes'
		// ));
		
		// $data['sign_up_type'] = 'normal';
		// $data['study_programs'] = $mba_study_programs;

		// $data['pages'] = 'signup_gii';
		// $this->load->view('registration/layout', $data);
	}
	
	public function ni_form()
	{
		redirect(base_url());
		// redirect('https://pmbni.iuli.ac.id/');exit;
		// $mba_study_programs = $this->Reg->get_study_program_lists(array(
		// 	'program_id' => 3,
		// 	'rpsp.is_active' => 'yes'
		// ));
		
		// $data['sign_up_type'] = 'normal';
		// $data['study_programs'] = $mba_study_programs;

		// $data['pages'] = 'signup_ni';
		// // if ($_SERVER['REMOTE_ADDR'] == '182.30.34.103') {
		// // 	$data['pages'] = 'signup_test';
		// // }
		// $this->load->view('registration/layout', $data);
	}

	private function _send_event_registration($s_event_id, $s_email)
	{
		$mba_event = $this->Evt->get_event([
			'event_id' => $s_event_id
		]);
		
		$s_event_name = $mba_event[0]->event_name;
		$s_event_venue = $mba_event[0]->event_venue;
		$s_event_run_down = $mba_event[0]->event_run_down;
		$s_event_start_date = date('l, j F Y', strtotime($mba_event[0]->event_start_date));
		$s_event_end_date = date('l, j F Y', strtotime($mba_event[0]->event_end_date));
		
		if($s_event_start_date == $s_event_end_date){
			$s_event_date_display = $s_event_start_date;
			$s_event_datetime_display = date('G:i', strtotime($mba_event[0]->event_start_date));
		}
		else{
			$s_event_date_display = implode(' - ', [$s_event_start_date, $s_event_end_date]);
			$s_event_datetime_display = 'Will be announced';
		}
		
		
		$this->email->from('bboby.siswanto@gmail.com', 'IULI Event Registration');
		$this->email->to($s_email);
        $this->email->bcc([
        	'bboby.siswanto@gmail.com',
        ]);
        $this->email->subject($s_event_name.' @IULI');
        
        $t_body = <<<TEXT
Congratulations!

You have successfully registered for the upcoming {$s_event_name} @IULI. Here are more details about the event:

Date: {$s_event_date_display} start at {$s_event_datetime_display}

Venue:
{$s_event_venue}

Program: 
{$s_event_run_down}

We are looking forward seeing you soon! If you have any question don’t hesitate to contact us via email +62 852 (Call, WhatsApp, Line, Telegram).

Best Regards, 
Your IULI Team
TEXT;
        $this->email->message($t_body);
        $this->email->send();
	}
	
	private function _send_admission_notification($a_booking_data)
	{
		$this->email->from('bboby.siswanto@gmail.com', 'IULI Event Registration');
		$this->email->to([
			'bboby.siswanto@gmail.com'
		]);
        $this->email->subject('New Event Registration');
        $s_body = '';
        
        foreach($a_booking_data as $key => $value){
	        $s_body .= $key.": ".$value."\n";
        }
        
        $this->email->message($s_body);
        $this->email->send();
	}
	
	public function register_event()
	{
		if($this->input->is_ajax_request()){
			$this->form_validation->set_rules('fullname', 'Fullname', 'trim|required|alpha_numeric_spaces');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
            $this->form_validation->set_rules('mobile_phone', 'Mobile Phone', 'trim|required|numeric');
            $this->form_validation->set_rules('booking_seat', 'Booking Seat', 'trim|required|numeric');
            
            if($this->form_validation->run()){
	            $s_event_id = $this->input->post('event_id');
				
	            if(!$this->Evt->check_email_bookings(set_value('email'), $s_event_id)){
		            if(!$this->Evt->check_phone_bookings(set_value('mobile_phone'), $s_event_id)){
			            $a_booking_data = [
				            'event_id' => $s_event_id,
				            'booking_name' => strtoupper(set_value('fullname')),
				            'booking_email' => set_value('email'),
				            'booking_phone' => set_value('mobile_phone'),
				            'booking_seat' => ($this->input->post('booking_seat')) ? $this->input->post('booking_seat') : 1,
				            'date_added' => date('Y-m-d H:i:s', time())
			            ];
			            $this->Evt->register_event($a_booking_data);
			            $this->_send_event_registration($s_event_id, set_value('email'));
			            $this->_send_admission_notification($a_booking_data);
			            $rtn = ['code' => 0, 'message' => 'Success!', 'redirect' => 'https://www.iuli.ac.id'];
		            }
		            else{
			            $rtn = ['code' => 1, 'message' => 'Your phone number have already registered in this event'];
		            }
	            }
	            else{
		            $rtn = ['code' => 1, 'message' => 'Your email have already registered in this event'];
	            }
            }
            else{
	            $rtn = ['code' => 2, 'message' => validation_errors('<span>','</span><br>')];
            }
            
            print json_encode($rtn);
            exit;
		}
	}
	
	public function event($s_event_slug)
	{
		$mba_event = $this->Evt->get_event([
			'event_slug' => $s_event_slug
		]);
		
		if($mba_event){
			$data['pages'] = 'event_signup';
			$data['event_data'] = $mba_event[0];
			$this->load->view('registration/layout', $data);
		}
		else{
			show_404();
		}
	}

	public function sign_up($s_sign_up_type = 'normal')
	{
		redirect('registration');
		// $data['sign_up_type'] = $s_sign_up_type;
		// $mba_study_programs = $this->Reg->get_study_program_lists(array(
		// 	'program_id' => 1,
		// 	'study_program_is_active' => true
		// ));
		// $data['pages'] = 'signup';
		// $data['study_programs'] = $mba_study_programs;
		// $this->load->view('registration/layout', $data);
	}
}
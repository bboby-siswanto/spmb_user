<?php
class Profile extends App_core
{
	public $a_api_data = array();
	public $data = array(
		'pageTitle' => 'Profile',
		'pageChildTitle' => 'Your Personal Data',
		'body' => 'profile',
		'parentPage' => null,
		'childPage' => null
	);

	public function __construct()
	{
		parent::__construct();
		$this->load->model('candidate/Profiles', 'Profiles');
		$this->load->model('Protects');
		$this->load->model('Admissions');
		$this->load->model('Academics');
		$this->Protects->from_expired_session();
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect(base_url());
	}

	public function signup_completed()
	{
		if (($this->session->has_userdata('auth')) AND ($this->session->userdata('auth'))) {
			$submit_trace = true;
			if ($this->session->has_userdata('sess_submitted_trac')) {
				if ($this->session->userdata('email') == $this->session->userdata('sess_submitted_trac')) {
					$submit_trace = false;
				}
			}

			if ($submit_trace) {
				$a_data['site_id'] = '1';
				$a_data['url'] = site_url('candidate/profile');
				$a_data['target'] = 'registration';
				$this->session->set_userdata('sess_submitted_trac', $this->session->userdata('email'));
				$this->load->view('direct_layout', $a_data);
			}
			else {
				redirect(base_url());
			}
		}
		else {
			redirect(base_url());
		}
	}

	public function index()
	{
		$o_personal_data = $this->Profiles->get_personal_data($this->session->userdata('personal_data_id'));
		
		if(is_null($o_personal_data->has_completed_school_data)){
		    redirect(site_url('candidate/education'));
	    }
		
		$this->data['has_completed_data'] = false;
		if(!is_null($o_personal_data->has_completed_personal_data)){
		    $this->data['has_completed_data'] = true;
	    }
	    
		$o_student_data = $this->Profiles->get_personal_data_student(['st.personal_data_id' => $o_personal_data->personal_data_id])[0];
		$this->data['month_list'] = array('January','February','March','April','May','June','July','August','September','October','November','December');
		$this->data['year_now'] = date('Y');
		$this->data['year_start'] = (int)date('Y') - 30;
		$this->data['list_religion'] = $this->Profiles->get_religion_list();
		$this->data['personal_data'] = $o_personal_data;
		$this->data['student_data'] = $o_student_data;
		$this->data['sgs_data'] = $this->Academics->get_student_sgs_refferal($this->session->userdata('personal_data_id'));
		$this->data['body'] = $this->load->view('candidate/profile', $this->data, true);
		$this->load->view('layout', $this->data);
	}

	public function download($type, $filename)
	{
		switch($type)
		{
			case "document":
				$personalDataId = $this->session->userdata('personal_data_id');
				$file = "media/upload/$personalDataId/$filename";
				break;
			
			default:
				return FALSE;
				break;
		}
		
		if(!file_exists($file)){
	    	return false;
	    }
		else{
			$path_info = pathinfo($file);
			$fileExt = $path_info['extension'];
			header("Content-Type: application/$fileExt");
	    	header('Content-Disposition: attachment; filename='.basename($filename));
			readfile( $file );
	    	exit;
		}
	}
	
	public function handle_referal_code($s_referal_code, $s_personal_data_id)
	{
		$a_prepare_post_data = array(
			'reference_code' => $s_referal_code,
			'referenced_id' => $s_personal_data_id
		);
		$hashed_string = $this->libapi->hash_data($a_prepare_post_data, 'PMBIULIACID', '28af8b90-81e0-11e9-bdfc-5254005d90f6');
		
		$a_send_post_data = json_encode(array(
			'access_token' => 'PMBIULIACID',
			'data' => $hashed_string
		));
		$url = $this->s_portal_url.'personal_data/api/get_reference_code';
		$a_result = $this->libapi->post_data($url, $a_send_post_data);
		
		if($a_result->code == 0){
			$mbo_personal_data = $this->Profiles->get_personal_data_by_id($a_result->data->personal_data_id);
			
			if(!$mbo_personal_data){
				$a_fields = $this->db->list_fields('dt_personal_data');
				$a_new_personal_data = [];
				foreach($a_result->data as $key => $value){
					if(in_array($key, $a_fields)){
						$a_new_personal_data[$key] = $value;
					}
				}
				
				$this->Profiles->save_personal_data($a_new_personal_data);
			}
			
			$a_prepare_referrer_data = array(
				'referrer_id' => $a_result->data->personal_data_id,
				'referenced_id' => $s_personal_data_id,
				'date_added' => date('Y-m-d H:i:s', time())
			);
			
			$this->Admissions->set_sgs_promo($a_prepare_referrer_data);
			
			$hashed_string = $this->libapi->hash_data($a_prepare_referrer_data, 'PMBIULIACID', '28af8b90-81e0-11e9-bdfc-5254005d90f6');
			
			$a_send_post_data = json_encode(array(
				'access_token' => 'PMBIULIACID',
				'data' => $hashed_string
			));
			
			$url = $this->s_portal_url.'personal_data/api/set_sgs_promo';
			$a_result = $this->libapi->post_data($url, $a_send_post_data);
			return $a_result;
		}
	}

	public function save_personal_data()
	{
		if ($this->input->post()) {
			
			$isUniqueEmail = '';
			if($this->session->userdata('email') != $this->input->post('email')){
				$isUniqueEmail = '|is_unique[dt_personal_data.personal_data_email]';
			}
			
			if($this->input->post('email') != ''){
				if($this->input->post('email') != $this->session->userdata('email')){
					$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[dt_personal_data.personal_data_email]');
				}
				$this->form_validation->set_rules('phone_number', 'Phone Number', 'trim|numeric|min_length[5]');
				$this->form_validation->set_rules('cellular_number', 'Cellular Number', 'trim|required|numeric|min_length[8]');
			}

			$this->form_validation->set_rules('identification_number', 'ID Card Number', 'trim|required');
			$this->form_validation->set_rules('date_of_birth', 'Date', 'trim|required');
			$this->form_validation->set_rules('month_of_birth', 'Month', 'trim|required');
			$this->form_validation->set_rules('year_of_birth', 'Year', 'trim|required');
			$this->form_validation->set_rules('citizenship_id', 'Citizenship', 'trim|required', array('required' => 'Citizenship must be picked from autocomplete'));
			$this->form_validation->set_rules('birth_country_id', 'Country of birth', 'trim|required', array('required' => 'Country of Birth must be picked from autocomplete'));
			$this->form_validation->set_rules('gender', 'Gender', 'trim|required');
			$this->form_validation->set_rules('birth_place', 'Place of birth', 'trim|required');
			$this->form_validation->set_rules('religion', 'Religion', 'trim|required');
			$this->form_validation->set_rules('nationality', 'Nationality', 'trim|required');
			$a_ipwhitelist = $this->config->item('whitelist_ip');
			/**
			 * Personal data
			 */
			
			/**
			 * Address data
			 */
			$this->form_validation->set_rules('address_country_id', 'Country address', 'trim|required', array('required' => 'Country must be picked from autocomplete'));
			// $this->form_validation->set_rules('address_province', 'Province', 'trim');
			$this->form_validation->set_rules('address_city', 'City', 'trim');
			// $this->form_validation->set_rules('address_street', 'Street', 'trim');
			// $this->form_validation->set_rules('address_sub_district', 'District/Kelurahan', 'trim');
			// $this->form_validation->set_rules('rt', 'RT', 'trim|max_length[3]');
			// $this->form_validation->set_rules('rw', 'RW', 'trim|max_length[3]');
			// $this->form_validation->set_rules('address_district_id', 'Sub-district', 'trim|required', array('required' => 'Sub-district must be picked from autocomplete'));
			// $this->form_validation->set_rules('zip_code', 'Zip Code', 'trim|numeric|exact_length[5]');
			/**
			 * Address data
			 */
			
			if($this->form_validation->run()){
				$s_referal_code = $this->input->post('reference_code');
				
				if($s_referal_code != ''){
					$a_handle_referal_code = $this->handle_referal_code($s_referal_code, $this->session->userdata('personal_data_id'));
				}
				
				$addressId = $this->input->post('address_id');

				if ($addressId == '') {
					$addressId = $this->uuid->v4();
				}
				
				$this->db->trans_start();
				
				$personal_address = array(
					'address_id' => $addressId,
					'country_id' => set_value('address_country_id'),
					// 'address_province' => strtoupper(set_value('address_province')),
					'address_city' => strtoupper(set_value('address_city')),
					// 'address_street' => strtoupper(set_value('address_street')),
					// 'address_rt' => set_value('rt'),
					// 'address_rw' => set_value('rw'),
					// 'address_sub_district' => strtoupper(set_value('address_sub_district')),
					// 'address_phonenumber' => (set_value('phone_number') != "") ? set_value('phone_number') : NULL,
					// 'address_cellular' => (set_value('cellular_number') != "") ? set_value('cellular_number') : NULL,
					// 'dikti_wilayah_id' => set_value('address_district_id'),
					// 'address_zipcode' => set_value('zip_code')
				);

				if($this->input->post('address_id')!=''){
					$b_save_address = $this->Profiles->save_address_data($personal_address, $addressId);
				}
				else{
					$personal_address['date_added'] = date('Y-m-d H:i:s');
					$b_save_address = $this->Profiles->save_address_data($personal_address);
				}

				$personal_data_address = array(
					'personal_data_id' => $this->session->userdata('personal_data_id'),
					'address_id' => $addressId
				);

				if ($this->input->post('address_id') != '') {
					$b_save_personal_address = $this->Profiles->save_personal_address($personal_data_address, $this->session->userdata('personal_data_id'));
				}else{
					$personal_data_address['date_added'] = date('Y-m-d', time());
					$b_save_personal_address = $this->Profiles->save_personal_address($personal_data_address);
				}

				$personalData = array(
					'religion_id' => set_value('religion'),
					'country_of_birth' => set_value('birth_country_id'),
					'personal_data_place_of_birth' => strtoupper(set_value('birth_place')),
					'personal_data_date_of_birth' => date('Y-m-d', strtotime(implode('-', array(set_value('year_of_birth'), set_value('month_of_birth'), set_value('date_of_birth'))))),
					'personal_data_gender' => set_value('gender'),
					'citizenship_id' => set_value('citizenship_id'),
					'personal_data_nationality' => set_value('nationality'),
					'personal_data_id_card_number' => set_value('identification_number'),
					'has_completed_personal_data' => 0
				);

				if($this->input->post('email') != ''){
					$a_data_personal = $this->Profiles->get_personal_data($this->session->userdata('personal_data_id'));
					if (($a_data_personal) AND ($a_data_personal->personal_data_email_confirmation == 'no')) {
						$personalData['personal_data_email'] = strtolower(set_value('email'));
						$personalData['personal_data_phone'] = (set_value('phone_number') != "") ? set_value('phone_number') : NULL;
						$personalData['personal_data_cellular'] = set_value('cellular_number');

						if($this->session->userdata('email') != $this->input->post('email')){
							$personalData['personal_data_email_confirmation'] = 1;
							$personalData['personal_data_confirmation_token'] = md5(uniqid().time());
						}
					}
				}
				$this->Profiles->save_personal_data($personalData, $this->session->userdata('personal_data_id'));

				$mba_personal_data_new = $this->General->get_where('dt_personal_data', ['personal_data_id' => $this->session->userdata('personal_data_id')]);
				if ($mba_personal_data_new) {
					$mba_student_data = $this->General->get_where('dt_student', ['personal_data_id' => $this->session->userdata('personal_data_id')]);
					$o_new_personal_data = $mba_personal_data_new[0];
					if ((!is_null($o_new_personal_data->has_completed_parents_data)) AND (!is_null($o_new_personal_data->has_completed_school_data))) {
						$update_student_data = $this->Academics->update_student_data(['student_status' => 'candidate'], $mba_student_data[0]->student_id);
						$this->prepare_data_api('dt_student', array('personal_data_id' => $this->session->userdata('personal_data_id')), 'update_student_data');
						// if ($_SERVER['REMOTE_ADDR'] == '202.93.225.254') {
						// 	$testupdate_student_data = $this->Academics->test_update_student_data(['student_status' => 'candidate'], $mba_student_data[0]->student_id);
						// 	print('<pre>');var_dump($testupdate_student_data);exit;
						// }
					}
				}
				
				if($this->db->trans_status() === FALSE){
					$this->db->trans_rollback();
					$rtn = array('code' => 1, 'message' => 'Unknown error');
				}
				else{
					$this->db->trans_commit();
					$userData = array(
						'email' => strtolower(set_value('email'))
					);
					$this->session->set_userdata($userData);

					$this->prepare_data_api('dt_personal_data', array('personal_data_id' => $this->session->userdata('personal_data_id')), 'update_personal_data_student');
					$this->prepare_data_api('dt_address', array('address_id' => $addressId), 'update_addres_student_data');
					$this->prepare_data_api('dt_personal_address', array('personal_data_id' => $this->session->userdata('personal_data_id')), 'update_student_personal_address');

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

	public function push_to_portal($s_student_id)
	{
		// print('close the door!');exit;
		$this->load->model('personal_data/Personal_data_model', 'Personal_data');
		$this->load->model('registration/Students', 'Students');
		
		$o_student_data = $this->Students->get_student_by_id($s_student_id);

		if($o_student_data){
			$o_personal_data = $this->Personal_data->get_personal_data_by_id($o_student_data->personal_data_id);
			$o_family_data = $this->Personal_data->get_family_by_personal_data_id($o_student_data->personal_data_id);

			unset($o_student_data->portal_sync);
			unset($o_personal_data->portal_sync);
			unset($o_family_data->portal_sync);
			
			$a_post_data = array(
				'personal_data' => $o_personal_data,
				'student_data' => $o_student_data,
				'family_data' => $o_family_data
			);
			
			/**
			 * Handle API
			 **/
			$hashed_string = $this->libapi->hash_data($a_post_data, 'PMBIULIACID', '28af8b90-81e0-11e9-bdfc-5254005d90f6');
			$post_data = json_encode(array(
				'access_token' => 'PMBIULIACID',
				'data' => $hashed_string
			));

			$url = $this->s_portal_url.'admission/api/create_new_student';
			$result = $this->libapi->post_data($url, $post_data);
			// $url = $this->s_portal_url.'admission/api/push_receive_student_data';
			// $url = 'staging.iuli.ac.id/portal2_dev/admission/api/push_receive_student_data';
			// $result = $this->libapi->post_data($url, $post_data);

			// if(is_array($result)){
			// 	$result = (object)$result;
			// }
			
			/**
			 * Handle API
			 **/
			
			//  print($post_data);
			print('<pre>');
			var_dump($result);
		}
		else{
			print('<pre>');
			var_dump('ga ada student');
		}
	}

	public function get_wilayah_by_name()
	{
		if ($this->input->post()) {
			$term = $this->input->post('term');
			if($district_result = $this->Profiles->get_dikti_wilayah_by_name($term)) {
				$result = array('code'=>0, 'data'=>$district_result);
			}else{
				$result = array('code'=>1, 'message'=>'No Result');
			}

			print json_encode($result);
			exit;
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

	public function get_country()
	{
		if($this->input->post()){
			$term = $this->input->post('term');
			if($countryResult = $this->Profiles->get_country_by_name($term)){
				$rtn = array('code' => 0, 'data' => $countryResult);
			}
			else{
				$rtn = array('code' => 1, 'message' => 'No Result');
			}
			
			print json_encode($rtn);
			exit;
		}
	}

	public function show_session()
	{
		print('<pre>');var_dump($this->session->userdata());
	}

	public function unique_email_check($email)
	{
		$user_email = $email;
		
		if($this->Profiles->isUniqueEmail($user_email, $this->session->userdata('personal_data_id'))){
			return true;
		}
		else{
			$this->form_validation->set_message('unique_email_check', 'The email has been used, please use another email');
			return false;
		}
	}
}




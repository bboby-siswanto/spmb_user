<?php
class Cron extends App_core
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Pmb_sync_model', 'Psm');
		$this->load->model('personal_data/Personal_data_model', 'Pdm');
		$this->load->model('candidate/Academics', 'Cacd');
		$this->load->model('registration/Registrations', 'Regm');
		$this->load->model('student/Student_model', 'Sm');
		$this->load->model('api/Synchronizer_model', 'Synm');
	}
	
	public function sync_candidates($i_academic_year_id)
	{
		print('close the door!');exit;
		$a_candidate_students = $this->Psm->get_candidate_students($i_academic_year_id);
		print "<pre>";
		
		$a_students = array();
		
		foreach($a_candidate_students as $candidate_student){
			var_dump($candidate_student);
			$a_personal_data = array(
				'personal_data_name' => strtoupper(str_replace('  ', ' ', implode(' ', array(
					trim($candidate_student->canstu_firstname),
					trim($candidate_student->canstu_middlename),
					trim($candidate_student->canstu_lastname)
				)))),
				'personal_data_email' => $candidate_student->canstu_email,
				'personal_data_phone' => $candidate_student->canstu_phone,
				'personal_data_cellular' => $candidate_student->canstu_mobilephone1,
				'personal_data_place_of_birth' => strtoupper($candidate_student->canstu_placeofbirth),
				'personal_data_date_of_birth' => $candidate_student->canstu_dateofbirth,
				'personal_data_gender' => ($candidate_student->canstu_gender == 'FEMALE') ? 'FEMALE' : 'MALE',
				'personal_data_nationality' => $candidate_student->canstu_nationality,
				'personal_data_marital_status' => strtolower($candidate_student->canstu_marital),
				'personal_data_mother_maiden_name' => strtoupper($candidate_student->canstu_mothername),
				'personal_data_password_token' => md5(uniqid().time()),
				'personal_data_email_confirmation' => 'no',
				'personal_data_email_confirmation_token' => md5(uniqid().time()),
				'portal_status' => 'open',
				'portal_sync' => 1,
				'date_added' => $candidate_student->canstu_timestamp,
				'timestamp' => date('Y-m-d H:i:s', time())
			);
			
			if($mbo_check_personal_data = $this->Pdm->get_personal_data_by_email($candidate_student->canstu_email)){
				$s_personal_data_id = $mbo_check_personal_data->personal_data_id;
				$o_personal_data = $mbo_check_personal_data;
				$o_family_data = $this->Pdm->get_family_by_personal_data_id($s_personal_data_id);
			}
			else{
				$s_family_id = $this->Regm->create_family();
				$s_personal_data_id = $this->Pdm->create_new_personal_data($a_personal_data);
				
				$o_personal_data = $this->Pdm->get_personal_data_by_id($s_personal_data_id);
				$o_family_data = $this->Pdm->get_family_by_personal_data_id($s_personal_data_id);
				
				$this->Regm->add_to_family($s_family_id, $s_personal_data_id);
			}
			
			$mbo_study_program = $this->Cacd->get_study_program_by_abbreviation($candidate_student->department_abrev);
			$s_study_program_id = ($mbo_study_program) ? $mbo_study_program->study_program_id : null;
			
			$mbo_check_student_data = $this->Sm->get_student_by_personal_data_id($s_personal_data_id);
			
			$a_student_data = array(
				'personal_data_id' => $s_personal_data_id,
				'program_id' => 1,
				'study_program_id' => $s_study_program_id,
				'academic_year_id' => $candidate_student->acayea_desc,
				'finance_year_id' => $candidate_student->acayea_desc,
				'student_number' => null,
				'student_date_enrollment' => $candidate_student->canstu_timestamp,
				'student_type' => ($candidate_student->canstu_type_admission == 'TRANSFER_STUDENT') ? 'transfer' : 'regular',
				'student_email' => $candidate_student->student_email,
				'student_un_status' => 'yes',
				'student_status' => ((!is_null($candidate_student->et_participant_id)) AND ($candidate_student->et_participant_status == 'PARTICIPANT')) ? 'participant' : 'candidate',
				'portal_sync' => 1,
				'date_added' => $candidate_student->canstu_timestamp,
				'timestamp' => date('Y-m-d H:i:s', time())
			);
			
			if($mbo_check_student_data){
				$s_student_id = $mbo_check_student_data->student_id;
				$this->Sm->update_student_data($a_student_data, $s_student_id);
				$o_student_data = $mbo_check_student_data;
			}
			else{
				$s_student_id = $this->Sm->create_new_student($a_student_data);
				$o_student_data = $this->Sm->get_student_by_id($s_student_id);
			}
			
			unset($o_student_data->portal_sync);
			unset($o_personal_data->portal_sync);
			unset($o_family_data->portal_sync);
			
			$a_post_data = array(
				'personal_data' => $o_personal_data,
				'student_data' => $o_student_data,
				'family_data' => $o_family_data
			);
			
			$hashed_string = $this->libapi->hash_data($a_post_data, 'PMBIULIACID', '28af8b90-81e0-11e9-bdfc-5254005d90f6');
			$post_data = json_encode(array(
				'access_token' => 'PMBIULIACID',
				'data' => $hashed_string
			));
			$url = $this->s_portal_url.'admission/api/create_new_student';
			$result = $this->libapi->post_data($url, $post_data);
			print $post_data."\n\n";
			// var_dump($result);
		}
	}
	
	public function get_reference_tables()
	{
		return array(
			array(
				'table' => 'ref_institution'
			),
			array(
				'table' => 'ref_ocupation'
			),
			array(
				'table' => 'ref_program'
			),
			array(
				'table' => 'ref_study_program'
			),
			array(
				'table' => 'ref_program_study_program',
				'composite_keys' => array('program_id', 'study_program_id')
			),
			array(
				'table' => 'dt_personal_data'
			),
			array(
				'table' => 'dt_family'
			),
			array(
				'table' => 'dt_family_member',
				'composite_keys' => array('family_id', 'personal_data_id')
			),
			array(
				'table' => 'dt_personal_address',
				'composite_keys' => array('personal_data_id', 'address_id')
			),
			array(
				'table' => 'dt_address'
			),
			array(
				'table' => 'dt_personal_data_document',
				'composite_keys' => array('personal_data_id', 'document_id')
			),
			array(
				'table' => 'dt_student'
			),
			array(
				'table' => 'dt_academic_history'
			),
			array(
				'table' => 'dt_academic_year'
			),
			array(
				'table' => 'dt_reference',
				'composite_keys' => array('referrer_id', 'referenced_id')
			)
		);
	}
	
	public function sync_reference()
	{	
		$a_sync_data = array();
		$a_reference_tables = $this->get_reference_tables();
		for($i = 0; $i < count($a_reference_tables); $i++){
			$a_fields = $this->db->field_data($a_reference_tables[$i]['table']);
			$a_list_fields = $this->db->list_fields($a_reference_tables[$i]['table']);
			
			$a_primary_key = array();
			$b_has_sync = false;
			
			if(in_array('portal_sync', $a_list_fields)){
				$b_has_sync = true;
			}
			
			if(array_key_exists('composite_keys', $a_reference_tables[$i])){
				$a_primary_key = $a_reference_tables[$i]['composite_keys'];
			}
			else{
				foreach($a_fields as $field){
					if($field->primary_key == 1){
						array_push($a_primary_key, $field->name);
					}
				}
			}
			
			if($b_has_sync){
				$query = $this->db->get_where($a_reference_tables[$i]['table'], array('portal_sync' => '1'));
			}
			else{
				$query = $this->db->get($a_reference_tables[$i]['table']);
			}
			
			$a_construct_data = array(
				'table' => $a_reference_tables[$i]['table'],
				'primary_key' => $a_primary_key,
				'batch_data' => $query->result()
			);
			
			array_push($a_sync_data, $a_construct_data);
		}
		
		$a_token_config = $this->config->item('token')['pmb'];
		$a_sites = $this->config->item('sites');
		$s_token = $a_token_config['access_token'];
		$s_secret_token = $a_token_config['secret_token'];
		
		$hashed_string = $this->libapi->hash_data($a_sync_data, $s_token, $s_secret_token);
		$post_data = json_encode(array(
			'access_token' => 'PORTALIULIACID',
			'data' => $hashed_string
		));
		
		$a_result = $this->libapi->post_data($a_sites['pmb'].'api/portal/retrieve_sync', $post_data);
		if($a_result['code'] == 0){
			$this->simulate_sync($a_sync_data);
		}
		
		$this->sync_candidates(7);
	}
	
	public function simulate_sync($a_sync_data)
	{
		$a_reference_tables = $this->get_reference_tables();
		for($i = 0; $i < count($a_sync_data); $i++){
			$a_ref_data = $a_sync_data[$i];
			
			for($j = 0; $j < count($a_ref_data['batch_data']); $j++){
				$a_clause = array();
				
				$s_table_name = $a_ref_data['table'];
				$a_primary_key = $a_ref_data['primary_key'];
				$a_batch_data = $a_ref_data['batch_data'];
				
				for($k = 0; $k < count($a_batch_data); $k++){
					for($l = 0; $l < count($a_ref_data['primary_key']); $l++){
						$a_clause[$a_ref_data['primary_key'][$l]] = $a_ref_data['batch_data'][$k]->{$a_ref_data['primary_key'][$l]};
					}
					$query = $this->db->get_where($s_table_name, $a_clause);

					$a_list_fields = $this->db->list_fields($a_reference_tables[$i]['table']);					
					if(in_array('portal_sync', $a_list_fields)){
						$this->db->update($s_table_name, array('portal_sync' => '0'), $a_clause);
					}
					else{
						$this->db->update($s_table_name, $a_batch_data[$k], $a_clause);
					}
				}
			}
		}
	}
}
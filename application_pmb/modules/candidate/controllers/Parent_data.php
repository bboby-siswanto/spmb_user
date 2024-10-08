<?php
class Parent_data extends App_core
{
	public $a_api_data = array();
    public $data = array(
		'pageTitle' => 'Parent Data',
		'pageChildTitle' => 'Edit Parent Data',
		'body' => 'parent',
		'parentPage' => null,
		'childPage' => null
    );
    
    public function __construct()
	{
		parent::__construct();
		$this->load->model('Protects');
		$this->Protects->from_expired_session();
    }

    public function index()
    {
        $this->load->model('candidate/Profiles');

		$this->data['childPage'] = 'parent';
		$o_personal_data = $this->Profiles->get_personal_data($this->session->userdata('personal_data_id'));
		
		$o_family_student = $this->Profiles->get_family_student($this->session->userdata('personal_data_id'));
		$mbo_parents_data = FALSE;
		if ($o_family_student) {
			$mbo_parents_data = $this->Profiles->get_parent_data($o_family_student->family_id);
		}
		$this->data['student_data'] = $o_family_student;
        $this->data['parents_data'] = $mbo_parents_data;
        $this->data['body'] = $this->load->view('candidate/parent', $this->data, true);
        $this->load->view('layout', $this->data);
	}
	
	public function save_parent_data()
	{
		if ($this->input->post()) {
			$this->load->model('candidate/Profiles');
			$this->load->model('candidate/Academics');
			$s_personal_data_id = $this->session->userdata('personal_data_id');
			$s_personal_data_parent_id = $this->input->post('personal_data_parent_id');
			$s_parent_exists = $this->input->post('parent_exist');
			$s_family_id = $this->input->post('family_id');
			$a_ipwhitelist = $this->config->item('whitelist_ip');

			$is_unique_email = '';
			if ($s_personal_data_parent_id == '') {
				$s_personal_data_parent_id = $this->uuid->v4();
				// $is_unique_email = '|is_unique[dt_personal_data.personal_data_email]';
			}

			$this->form_validation->set_rules('parent_name', 'Parent/Guardian Name', 'trim|required');
			$this->form_validation->set_rules('relation','Parent/Guardian Relation', 'trim|required');
			$this->form_validation->set_rules('mother_maiden_name', 'Mother Maiden Name', 'trim|required');
			$this->form_validation->set_rules('parent_email', 'Parent Email', 'trim|required|valid_email'.$is_unique_email);
			$this->form_validation->set_rules('parent_phone', 'Parent Phone Number', 'trim|required');
			$this->form_validation->set_rules('company_name', 'Company Name', 'trim');
			$this->form_validation->set_rules('occupation', 'Jobs Title', 'trim');

			if ($this->form_validation->run()) {
				$this->db->trans_start();

				$s_institution_id = $this->input->post('company_id');
				$s_ocupation_id = $this->input->post('occupation_id');

				if ($s_institution_id == '') {
					$s_institution_name = strtoupper(set_value('company_name'));
					$mbo_institution_already_exists = $this->Profiles->get_institution_name($s_institution_name);
					if (!$mbo_institution_already_exists) {
						$s_institution_id = $this->uuid->v4();
						$data_institution = array(
							'institution_id' => $s_institution_id,
							'institution_name' => strtoupper(set_value('company_name')),
							'date_added' => date('Y-m-d H:i:s')
						);

						$b_save_institution = $this->Academics->insert_new_institution($data_institution);
						if (!$b_save_institution) {
							$rtn = array('code' => 1, 'message' => 'Uknow Error');
						}
					}else{
						$s_institution_id = $mbo_institution_already_exists[0]->institution_id;
					}
				}

				if ($s_ocupation_id == '') {
					$s_occupation_name = strtoupper(set_value('occupation'));
					$mbo_occupation_already_exists = $this->Profiles->get_occupation_name($s_occupation_name);
					if (!$mbo_occupation_already_exists) {
						$s_ocupation_id = $this->uuid->v4();
						$a_ocupation_data = array(
							'ocupation_id' => $s_ocupation_id,
							'ocupation_name' => strtoupper(set_value('occupation')),
							'date_added' => date('Y-m-d H:i:s')
						);
						
						$b_save_ocupation = $this->Profiles->insert_new_occupation($a_ocupation_data);
						if (!$b_save_ocupation) {
							$rtn = array('code' => 1, 'message' => 'Uknow Error');
						}
					}else{
						$s_ocupation_id = $mbo_occupation_already_exists[0]->ocupation_id;
					}
				}

				$a_relation_data = array(
					'personal_data_parent_id' => $s_personal_data_parent_id,
					'personal_data_parent_name' => strtoupper(set_value('parent_name')),
					'personal_data_parent_email' => strtolower(set_value('parent_email')),
					'personal_data_parent_cellular' => set_value('parent_phone'),
					'family_id' => $s_family_id,
					'academic_history_id_insert' => $this->uuid->v4(),
					'family_member_status' => set_value('relation'),
					'personal_data_student_id' => $s_personal_data_id,
					'personal_data_student_maiden_name' => strtoupper(set_value('mother_maiden_name')),
					'academic_parent_history_id' => $this->uuid->v4(),
					'parent_institution_id' => $s_institution_id,
					'parent_occupation_id' => $s_ocupation_id
				);
				
				if ($s_parent_exists == '0') {
					$save_relation_data = $this->Profiles->save_relations_data($a_relation_data, 'insert');
				}else{
					$save_relation_data = $this->Profiles->save_relations_data($a_relation_data, 'update');
				}

				if ($save_relation_data) {
					$mba_personal_data_new = $this->General->get_where('dt_personal_data', ['personal_data_id' => $this->session->userdata('personal_data_id')]);
					if ($mba_personal_data_new) {
						$mba_student_data = $this->General->get_where('dt_student', ['personal_data_id' => $this->session->userdata('personal_data_id')]);
						$o_new_personal_data = $mba_personal_data_new[0];
						if ((!is_null($o_new_personal_data->has_completed_personal_data)) AND (!is_null($o_new_personal_data->has_completed_school_data))) {
							$update_student_data = $this->Academics->update_student_data(['student_status' => 'candidate'], $mba_student_data[0]->student_id);
							$this->prepare_data_api('dt_student', array('student_id' => $student_id), 'update_student_data');
						}
					}
					
					$rtn = array('code' => 0, 'message' => 'Success');
				}else{
					$rtn = array('code' => 1, 'message' => 'Error');
				}

				$this->db->trans_complete();

				$this->prepare_data_api('ref_institution', array('institution_id' => $s_institution_id), 'update_institution_parent');
				$this->prepare_data_api('ref_ocupation', array('ocupation_id' => $s_ocupation_id), 'update_occupation_parent');
				$this->prepare_data_api('dt_personal_data', array('personal_data_id' => $a_relation_data['personal_data_parent_id']), 'update_parent_data');
				$this->prepare_data_api('dt_academic_history', array('academic_history_id' => $a_relation_data['academic_history_id_insert']), 'update_insitution_parent');
				$this->prepare_data_api('dt_family', array('family_id' => $a_relation_data['family_id']), 'update_family_data');
				$this->prepare_data_api('dt_family_member', array('family_id' => $a_relation_data['family_id'], 'family_member_status' => 'child'), 'update_family_student');
				$this->prepare_data_api('dt_family_member', array('family_id' => $a_relation_data['family_id'], 'family_member_status !=' => 'child'), 'update_family_parent');
				$this->prepare_data_api('dt_personal_data', array('personal_data_id' => $a_relation_data['personal_data_student_id']), 'updates_student_data');

				if ($this->db->trans_status() === FALSE) {
					$this->db->trans_rollback();
					$rtn = array('code' => 1, 'message' => 'Error data');
				}else{
					$this->db->trans_commit();
					
					$this->Profiles->save_personal_data(array('has_completed_parents_data' => 0), $this->session->userdata('personal_data_id'));
					
					// if (!in_array($_SERVER['REMOTE_ADDR'], $a_ipwhitelist)) {
					// 	$a_prepare_post_data = array(
					// 		'data_api' => $this->a_api_data
					// 	);
					// 	// print('<pre>');var_dump($a_prepare_post_data);
					// 	$hashed_string = $this->libapi->hash_data($a_prepare_post_data, 'PMBAPI', '28af8b90-81e0-11e9-bdfc-5254005d90f6');
					// 	$a_send_post_data = json_encode(array(
					// 		'access_token' => 'PMBAPI',
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
			}else{
				$rtn = array('code' => 1, 'message' => validation_errors('<li>', '</li>'));
			}

			print json_encode($rtn);
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

	public function show_tets()
	{
		$this->data['parents_data'] = 'data';

		$mba_data_list = array_merge($this->data, $this->a_page_data);
		print('<pre>');
		var_dump($mba_data_list);exit;
	}

	public function testing_data()
	{
		$this->prepare_data_api('dt_family_member', array('family_id' => 'b4e969ce-e1a7-4f06-918f-f6a638a49194'), 'update_family_parent');
		// $a_test_prepare_data = $this->prepare_data_api('dt_family_member', array('family_id' => $a_relation_data['family_id']), 'update_family_parent');
		print('<pre>');
		var_dump($this->a_api_data);
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

			if (($s_table_name == 'dt_personal_data') AND ($s_title != 'update_parent_data')) {
				$a_condition_email = array(
					// 'personal_data_email' => $mbo_data_->personal_data_email
					'personal_data_id' => $mbo_data_->personal_data_id
				);
				$this->a_api_data[$s_title]['condition_email'] = $a_condition_email;
			}
		}
	}

    public function get_institution_by_name()
	{
		if($this->input->post()){
			$this->load->model('Profiles');
			
			$term = $this->input->post('term');
			$type = $this->input->post('type');
			
			if($term != ''){
				if($institutionResult = $this->Profiles->get_instutionsby_nName($term, $type)){
					$rtn = array('code' => 0, 'data' => $institutionResult);
				}
				else{
					$rtn = array('code' => 1, 'message' => 'Not found');
				}
			}
			else{
				$rtn = array('code' => 1, 'message' => 'Not found');
			}
			
			print json_encode($rtn);
			exit;

		}
	}

    public function get_occupation_by_name()
    {
        if ($this->input->post()) {
            $term = $this->input->post('term');
			$type = ($this->input->post('type')) ? $this->input->post('type') : false;
			
			$this->load->model('Profiles');
			
			if($occupationResult = $this->Profiles->getOccupationByName($term, $type)){
				$rtn = array('code' => 0, 'data' => $occupationResult);
			}
			else{
				$rtn = array('code' => 1, 'message' => 'Not found');
			}
			print json_encode($rtn);
			exit;
        }
	}
}
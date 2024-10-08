<?php
// class Pmbni extends App_core
class Pmbni extends Api_core
{
    public $a_send_data = array();
    function __construct()
    {
        parent::__construct();
        $this->load->library('ApiConfig');
        $a_iuli_sites = $this->config->item('iuli_sites');
		$this->s_portal_url = $a_iuli_sites[$this->s_api_mode];
		// $this->s_portal_url = $a_iuli_sites['siakdev'];
        $this->load->model('Pmbni_model', 'pmbm');
        $this->load->model('General_model', 'General');
        $this->load->model('candidate/Profiles', 'Prf');
        $this->load->model('student/Student_model', 'Stm');
    }

    public function index()
    {
        $a_ref_data = $this->a_api_data;
        // $a_field = $this->pmbm->get_required_fields();
        if ((isset($a_ref_data['data'])) AND (count($a_ref_data['data']) > 0)) {
            $a_validate = $this->pmbm->validate($a_ref_data['data']);
            if ($a_validate['code'] == '0') {
                $a_prep_data = $this->prepare_data($a_ref_data['data']);
                $a_submit_data = $this->_submit_data($a_prep_data);

                if ($a_submit_data['code'] == 0) {
                    $a_return = $this->apiconfig->get_message('0', $a_ref_data['data']);

                    // $a_prepare_post_data = array(
                    //     'data_api' => $this->a_send_data
                    // );
                    // $hashed_string = $this->libapi->hash_data($a_prepare_post_data, 'PMBIULIACID', '28af8b90-81e0-11e9-bdfc-5254005d90f6');

                    // $a_return = $this->apiconfig->get_message('0', $hashed_string);
                }else{
                    $a_return = $this->apiconfig->get_message('099', $a_submit_data['message']);
                }
            }else{
                $a_return = $this->apiconfig->get_message('005', $a_validate['a_message']);
            }
        }else{
            $a_return = $this->apiconfig->get_message('005', 'Data is empty');
        }
        
        $this->return_json($a_return);
    }
    
    private function _prepare_data_api($s_table_name, $a_condition, $s_title)
	{
		$mbo_data_ = $this->Prf->get_data_field($s_table_name, $a_condition);
		if ($mbo_data_) {
            if ($s_table_name != 'dt_institution_contact') {
                $mbo_data_->pmb_sync = '0';
            }
			
			$this->a_send_data[$s_title] = array(
				'table' => $s_table_name,
				'data' => $mbo_data_,
				'condition' => $a_condition
			);

			if ($s_table_name == 'dt_personal_data') {
				$a_condition_email = array(
					'personal_data_email' => $mbo_data_->personal_data_email
				);
				$this->a_send_data[$s_title]['condition_email'] = $a_condition_email;
			}
		}
	}

    private function _submit_data($a_list_data)
    {
        if (count($a_list_data) > 0) {
            $this->db->trans_start();
            $mbs_err = false;

            foreach ($a_list_data as $a_data) {
                $mbo_study_program_data = $this->General->get_where('ref_study_program', ['study_program_abbreviation' => $a_data['study_program_abbreviation']]);
                $mbo_study_program_data = ($mbo_study_program_data) ? $mbo_study_program_data[0] : false;
                $s_academic_year_id = date('Y', strtotime($a_data['student_date_enrollment']));

                if ($mbo_study_program_data) {
                    $o_student_already = $this->Stm->get_student_personal_data(['pd.personal_data_email' => $a_data['personal_data_email']]);
                    $o_student_already = ($o_student_already) ? $o_student_already[0] : false;

                    if (!$o_student_already) {
                        $o_student_already = $this->Stm->get_student_personal_data(['st.student_id' => $a_data['student_id']])[0];
                        $o_student_already = ($o_student_already) ? $o_student_already[0] : false;
                    }
                    
                    $a_prep_personal_data = [
                        'personal_data_name' => $a_data['personal_data_name'],
                        'personal_data_email' => $a_data['personal_data_email'],
                        'personal_data_cellular' => $a_data['personal_data_cellular'],
                        'personal_data_gender' => ($a_data['personal_data_gender'] == 'male') ? 'M' : 'F',
                        'personal_data_nationality' => strtoupper($a_data['personal_data_nationality']),
                        'date_added' => $a_data['student_date_enrollment']
                    ];

                    if (isset($a_data['personal_data_place_of_birth'])) {
                        $a_prep_personal_data['personal_data_place_of_birth'] = $a_data['personal_data_place_of_birth'];
                    }
                    
                    if (isset($a_data['personal_data_date_of_birth'])) {
                        $a_prep_personal_data['personal_data_date_of_birth'] = $a_data['personal_data_date_of_birth'];
                    }

                    $a_prep_student_data = [
                        'study_program_id' => $mbo_study_program_data->study_program_id,
                        'program_id' => $this->a_program_list['NI S1'],
                        'student_date_enrollment' => $a_data['student_date_enrollment'],
                        'date_added' => $a_data['student_date_enrollment'],
                        'student_type' => 'regular',
                        'academic_year_id' => $s_academic_year_id,
                        'finance_year_id' => $s_academic_year_id,
                        'has_to_pay_enrollment_fee' => $a_data['has_to_pay_enrollment_fee'],
                        'student_status' => ($a_data['has_to_pay_enrollment_fee'] == 'yes') ? 'participant' : 'candidate'
                    ];

                    $s_institution_id = false;
                    if (isset($a_data['institution_name'])) {
                        $mbo_institution_data = $this->General->get_where('ref_institution', ['institution_name' => trim($a_data['institution_name'])]);
                        $mbo_institution_data = ($mbo_institution_data) ? $mbo_institution_data[0] : false;

                        if ($mbo_institution_data) {
                            $s_institution_id = $mbo_institution_data->institution_id;

                            if (!is_null($mbo_institution_data->address_id)) {
                                if (isset($a_data['address_city'])) {
                                    $s_address_id = $mbo_institution_data->address_id;
                                    $this->Prf->save_address_data([
                                        'address_city' => $a_data['address_city'],
                                        'date_added' => $a_data['student_date_enrollment']
                                    ], $mbo_institution_data->address_id);

                                    $this->_prepare_data_api('dt_address', array('address_id' => $s_address_id), 'school_address');
                                }
                            }else{
                                if (isset($a_data['address_city'])) {
                                    $s_address_id = $this->uuid->v4();
                                    $this->Prf->save_address_data([
                                        'address_id' => $s_address_id,
                                        'address_city' => $a_data['address_city'],
                                        'date_added' => $a_data['student_date_enrollment']
                                    ]);

                                    $this->Stm->insert_institution([
                                        'institution_id' => $s_institution_id,
                                        'address_id' => $s_address_id,
                                        'institution_name' => $a_data['institution_name'],
                                        'date_added' => $a_data['student_date_enrollment']
                                    ], $s_institution_id);

                                    $this->_prepare_data_api('dt_address', array('address_id' => $s_address_id), 'school_address');
                                    $this->_prepare_data_api('ref_institution', array('institution_id' => $s_institution_id), 'school_data');
                                }
                            }
                        }else{
                            $s_institution_id = $this->uuid->v4();
                            $s_address_id = null;

                            if (isset($a_data['address_city'])) {
                                $s_address_id = $this->uuid->v4();

                                $this->Prf->save_address_data([
                                    'address_id' => $s_address_id,
                                    'address_city' => $a_data['address_city'],
                                    'date_added' => $a_data['student_date_enrollment']
                                ]);
                                $this->_prepare_data_api('dt_address', array('address_id' => $s_address_id), 'school_address');
                            }

                            $this->Stm->insert_institution([
                                'institution_id' => $s_institution_id,
                                'address_id' => $s_address_id,
                                'institution_name' => $a_data['institution_name'],
                                'institution_type' => 'highschool',
                                'institution_is_international' => 'no',
                                'date_added' => $a_data['student_date_enrollment']
                            ]);
                            $this->_prepare_data_api('ref_institution', array('institution_id' => $s_institution_id), 'school_data');
                        }
                    }

                    if (isset($a_data['timestamp'])) {
                        $a_prep_personal_data['timestamp'] = $a_data['timestamp'];
                        $a_prep_student_data['timestamp'] = $a_data['timestamp'];
                    }

                    if ($o_student_already) {
                        $s_personal_data_id = $o_student_already->personal_data_id;
                        $s_student_id = $o_student_already->student_id;
                        $mbo_family_student_data = $this->Prf->getFamilyStudent($s_personal_data_id);
                        
                        if ($mbo_family_student_data) {
                            $s_family_id = $mbo_family_student_data->family_id;
                        }else{
                            $s_family_id = $this->uuid->v4();
                            $this->Prf->save_family([
                                'family_id' => $s_family_id,
                                'date_added' => $a_data['student_date_enrollment']
                            ]);
                            
                            $this->Prf->insert_family_member([
                                'family_id' => $s_family_id,
                                'personal_data_id' => $s_personal_data_id,
                                'family_member_status' => 'child',
                                'date_added' => $a_data['student_date_enrollment']
                            ]);
                        }

                        $this->Prf->save_personal_data($a_prep_personal_data, $s_personal_data_id);
                        $this->Stm->update_student_data($a_prep_student_data, $s_student_id);

                        $this->_prepare_data_api('dt_personal_data', array('personal_data_id' => $s_personal_data_id), 'student_personal_data');
                        $this->_prepare_data_api('dt_student', array('student_id' => $s_student_id), 'student_data');
                        $this->_prepare_data_api('dt_family', array('family_id' => $s_family_id), 'student_family');
                        $this->_prepare_data_api('dt_family_member', array('family_id' => $s_family_id, 'personal_data_id' => $s_personal_data_id), 'student_family_member');
                        
                    }else{
                        $s_personal_data_id = $this->uuid->v4();
                        $s_student_id = $a_data['student_id'];
                        $s_family_id = $this->uuid->v4();

                        $this->Prf->save_family([
                            'family_id' => $s_family_id,
                            'date_added' => $a_data['student_date_enrollment']
                        ]);

                        $a_prep_personal_data['personal_data_id'] = $s_personal_data_id;
                        $a_prep_student_data['personal_data_id'] = $s_personal_data_id;

                        $this->Prf->save_personal_data($a_prep_personal_data);
                        $this->Stm->create_new_student($a_prep_student_data);

                        $this->Prf->insert_family_member([
                            'family_id' => $s_family_id,
                            'personal_data_id' => $s_personal_data_id,
                            'family_member_status' => 'child',
                            'date_added' => $a_data['student_date_enrollment']
                        ]);

                        $this->_prepare_data_api('dt_personal_data', array('personal_data_id' => $s_personal_data_id), 'student_personal_data');
                        $this->_prepare_data_api('dt_student', array('student_id' => $s_student_id), 'student_data');
                        $this->_prepare_data_api('dt_family', array('family_id' => $s_family_id), 'student_family');
                        $this->_prepare_data_api('dt_family_member', array('family_id' => $s_family_id, 'personal_data_id' => $s_personal_data_id), 'student_family_member');
                    }

                    $a_prep_parent_personal_data = [
                        'personal_data_name' => $a_data['parent_data_name'],
                        'personal_data_email' => $a_data['parent_data_email'],
                        'personal_data_cellular' => (isset($a_data['parent_data_cellular'])) ? $a_data['parent_data_cellular'] : 0,
                        'personal_data_marital_status' => 'married',
                        'personal_data_email_confirmation' => 'no'
                    ];

                    // check family parent
                    $mba_family_parents = $this->General->get_where('dt_family_member', [
                        'family_id' => $s_family_id,
                        'family_member_status != ' => 'child'
                    ]);
                    $mba_family_parents = ($mba_family_parents) ? $mba_family_parents[0] : false;

                    if ($mba_family_parents) {
                        $s_parent_personal_data_id = $mba_family_parents->personal_data_id;
                        $mbo_parent_personal_data = $this->General->get_where('dt_personal_data', ['personal_data_id' => $s_parent_personal_data_id]);

                        if (!is_null($mbo_parent_personal_data[0]->ocupation_id)) {
                            $this->_prepare_data_api('ref_ocupation', array('ocupation_id' => $mbo_parent_personal_data[0]->ocupation_id), 'parent_ocupation');
                        }
                        $this->Prf->save_personal_data($a_prep_parent_personal_data, $s_parent_personal_data_id);
                        $this->_prepare_data_api('dt_personal_data', array('personal_data_id' => $s_parent_personal_data_id), 'parent_personal_data_id');
                    }else{
                        $s_parent_personal_data_id = $this->uuid->v4();
                        $a_prep_parent_personal_data['personal_data_id'] = $s_parent_personal_data_id;

                        $this->Prf->save_personal_data($a_prep_parent_personal_data);
                        $this->Prf->insert_family_member([
                            'family_id' => $s_family_id,
                            'personal_data_id' => $s_parent_personal_data_id,
                            'family_member_status' => 'guardian',
                            'date_added' => $a_data['student_date_enrollment']
                        ]);

                        $this->_prepare_data_api('dt_personal_data', array('personal_data_id' => $s_parent_personal_data_id), 'parent_personal_data_id');
                        $this->_prepare_data_api('dt_family_member', array('family_id' => $s_family_id, 'personal_data_id' => $s_parent_personal_data_id), 'parent_family_member');
                    }

                    // check academic history
                    if ($s_institution_id) {
                        $a_prep_academic_history = [
                            'institution_id' => $s_institution_id,
                            'personal_data_id' => $s_personal_data_id,
                            'academic_history_graduation_year' => $a_data['graduation_year']
                        ];
                        
                        $mbo_academic_history_data = $this->Prf->get_personal_data_background($s_personal_data_id);
                        if ($mbo_academic_history_data) {
                            $s_academic_history_id = $mbo_academic_history_data->academic_history_id;

                            $a_save_academic_history = $this->Prf->save_personal_data_background($a_prep_academic_history, $s_academic_history_id);
                        }else{
                            $s_academic_history_id = $this->uuid->v4();
                            $a_prep_academic_history['academic_history_id'] = $s_academic_history_id;
                            $a_prep_academic_history['date_added'] = date('Y-m-d H:i:s');

                            $a_save_academic_history = $this->Prf->save_personal_data_background($a_prep_academic_history);
                        }
                        $this->_prepare_data_api('dt_academic_history', array('academic_history_id' => $s_academic_history_id), 'student_academic_history');

                        // if ($a_data['institution_personal_data_name'] !== null) {
                        if (isset($a_data['institution_personal_data_name'])) {
                            $a_prep_school_personal_data = [
                                'personal_data_name' => $a_data['institution_personal_data_name'],
                                'personal_data_email' => (isset($a_data['institution_personal_data_email'])) ? $a_data['institution_personal_data_email'] : NULL,
                                'personal_data_cellular' => (isset($a_data['institution_personal_data_cellular'])) ? $a_data['institution_personal_data_cellular'] : 0,
                                'personal_data_marital_status' => 'married',
                                'personal_data_email_confirmation' => 'no'
                            ];

                            $mbo_institution_contact = $this->General->get_where('dt_institution_contact', [
                                'institution_id' => $s_institution_id
                            ]);
                            $mbo_institution_contact = ($mbo_institution_contact) ? $mbo_institution_contact[0] : false;

                            if ($mbo_institution_contact) {
                                $s_institution_contact_personal_data_id = $mbo_institution_contact->personal_data_id;
                                $this->Prf->save_personal_data($a_prep_school_personal_data, $s_institution_contact_personal_data_id);

                            }else{
                                $s_institution_contact_personal_data_id = $this->uuid->v4();
                                $a_prep_school_personal_data['personal_data_id'] = $s_institution_contact_personal_data_id;
                                $a_prep_school_personal_data['date_added'] = date('Y-m-d H:i:s');

                                $this->Prf->save_personal_data($a_prep_school_personal_data);
                                $this->Prf->save_institution_contact([
                                    'institution_id' => $s_institution_id,
                                    'personal_data_id' => $s_institution_contact_personal_data_id,
                                    'date_added' => $a_data['student_date_enrollment']
                                ]);

                            }

                            $this->_prepare_data_api('dt_personal_data', array('personal_data_id' => $s_institution_contact_personal_data_id), 'school_contact_personal_data');
                            $this->_prepare_data_api('dt_institution_contact', array('institution_id' => $s_institution_id), 'school_contact');
                        }
                    }

                    // document here
                    $submit_doc = $this->pmbm->sync_document($s_personal_data_id, $a_data['student_id'], $this->s_api_mode);
                    if ($submit_doc['code'] != 0) {
                        $mbs_err = implode(', '.$submit_doc['a_message']);
                        break;
                    }else{
                        $mba_document_have = $this->General->get_where('dt_personal_data_document', array('personal_data_id' => $s_personal_data_id));
                        if ($mba_document_have) {
                            foreach ($mba_document_have as $o_personal_document) {
                                $this->_prepare_data_api('dt_personal_data_document', array('personal_data_id' => $s_personal_data_id, 'document_id' => $o_personal_document->document_id), 'update_document_student_'.$o_personal_document->document_requirement_link);
                            }
                        }
                    }
                }else{
                    $mbs_err = "Study Program ".$a_data['study_program_abbreviation']." not found";
                    break;
                }
            }

            if ($mbs_err) {
                $this->db->trans_rollback();
                $a_return = ['code' => 1, 'message' => $mbs_err];
            }else if($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $a_return = array('code' => 1, 'message' => 'Unknown error');
            }else{
                $this->db->trans_commit();
                $a_return = ['code' => 0, 'message' => 'Success'];

                // send data to portal
                $a_prepare_post_data = array(
                    'data_api' => $this->a_send_data
                );
                $hashed_string = $this->libapi->hash_data($a_prepare_post_data, 'PMBIULIACID', '28af8b90-81e0-11e9-bdfc-5254005d90f6');
                
                $a_send_post_data = json_encode(array(
                    'access_token' => 'PMBIULIACID',
                    'data' => $hashed_string
                ));
                $url = $this->s_portal_url.'api_sync/update_from_pmb';
                $a_result = $this->libapi->post_data($url, $a_send_post_data);
                
                $b_error_api = false;
                if ($a_result == null) {
                    $b_update_pmb_sync = $this->_update_sync_data($a_prepare_post_data, 1);
                    $b_error_api = true;
                }else{
                    $b_update_pmb_sync = $this->_update_sync_data(json_decode(json_encode($a_result->data), true), $a_result->code);
                    if ($a_result->code != '0') {
                        $b_error_api = true;
                    }
                }

                if ($b_error_api) {
                    $s_result_api = json_encode($a_result);

                    $this->email->from('log@iuli.ac.id');
                    // $this->email->to(array('budi.siswanto@iuli.ac.id', 'riski.fitriawan@iuli.ac.id'));
                    $this->email->to(array('budi.siswanto@iuli.ac.id'));
                    $this->email->subject('[ERROR-LOG]Error sync from pmb');
                    $s_message = <<<TEXT
From: api/controllers/pmbni.php
Uri destination: {$url}
data: {$a_send_post_data}
result: {$s_result_api}
TEXT;
                    $this->email->message($s_message);
                    $this->email->send();
                }

            }
        }else{
            $a_return = ['code' => 1, 'message' => 'No data submited'];
        }

        return $a_return;
    }

    private function _update_sync_data($a_api_result, $i_return_code)
	{
		$this->db->trans_start();
		foreach ($a_api_result as $list) {
			if (isset($list['condition']) AND $list['condition'] != null) {
                if ($list['table'] != 'dt_institution_contact') {
                    $b_update_pmb_sync = $this->Prf->update_portal_sync($i_return_code, $list['table'], $list['condition']);
                }
			}
		}
	}

    public function prepare_data($a_post_data)
    {
        if (is_object($a_post_data)) {
            $a_post_data = (array) $a_post_data;
        }
        $a_field = $this->pmbm->get_required_fields();

        $prep_data = [];
        foreach ($a_post_data as $a_data) {
            $a_prep = array();

            foreach ($a_data as $key => $value_data) {
                $a_field_data = $this->pmbm->get_required_fields($key);
                $s_portal_key = $a_field_data['portal_name'];
                $a_prep[$s_portal_key] = $value_data;
            }

            array_push($prep_data, $a_prep);
        }

        // $prep_data = array_values($prep_data);

        return $prep_data;
    }
}

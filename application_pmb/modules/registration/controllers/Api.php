<?php
class Api extends Api_core
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function create_new_student()
	{
		$a_post_data = $this->a_api_data;
		
		$this->load->model('personal_data/Personal_data_model', 'Personal_data');
		$this->load->model('student/Student_model', 'Student');
		
		$a_personal_data = $a_post_data['personal_data'];
		$a_student_data = $a_post_data['student_data'];
		$a_family_data = $a_post_data['family_data'];
		
		$a_init_family = array(
			'family_id' => $a_family_data['family_id'],
			'date_added' => date('Y-m-d H:i:s', time())
		);
		
		$a_init_family_member = array(
			'family_id' => $a_family_data['family_id'],
			'personal_data_id' => $a_family_data['personal_data_id'],
			'family_member_status' => $a_family_data['family_member_status'],
			'date_added' => date('Y-m-d H:i:s', time())
		);

		$mbo_profile = $this->Personal_data->get_personal_data_by_email($a_personal_data['personal_data_email']);
		
		$this->db->trans_start();
		
		if (isset($a_personal_data['pmb_sync'])) {
			unset($a_personal_data['pmb_sync']);
		}

		if (isset($a_student_data['pmb_sync'])) {
			unset($a_student_data['pmb_sync']);
		}

		if($mbo_profile){
			$this->Personal_data->update_personal_data($a_personal_data, $a_personal_data['personal_data_id']);
			$this->Student->update_student_data($a_student_data, $a_student_data['student_id']);
			$mbo_family_data = $this->Personal_data->get_family_by_personal_data_id($a_personal_data['personal_data_id']);
			if(!$mbo_family_data){
				$this->Personal_data->create_family($a_init_family);
				$this->Personal_data->add_family_member($a_init_family_member);
			}
			
			$a_return = array('code' => 0);
		}
		else{
			$this->Personal_data->create_new_personal_data($a_personal_data);
			$this->Personal_data->create_family($a_init_family);
			$this->Personal_data->add_family_member($a_init_family_member);
			
			$mbo_student = $this->Student->get_student_by_id($a_student_data['student_id']);
			
			if($mbo_student){
				$this->Student->update_student_data($a_student_data, $a_student_data['student_id']);
			}
			else{
				$this->Student->create_new_student($a_student_data);
			}
			$a_return = array('code' => 0);
		}
		
		if($this->db->trans_status() === false){
			$this->db->trans_rollback();
			$this->return_json(array('code' => 1, 'message' => 'Fail'));
		}
		else{
			$this->db->trans_commit();
			$this->return_json($a_return);
		}
		
		$this->return_json($a_return);
	}
}
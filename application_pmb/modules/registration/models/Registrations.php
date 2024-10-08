<?php

class Registrations extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
	}

	public function get_scholarship_data($s_scholarship_id = false, $a_clause = false)
	{
		$this->db->from('ref_scholarship');
		if ($a_clause) {
			$this->db->where($a_clause);
		}

		if ($s_scholarship_id) {
			$this->db->where('scholarship_id', $s_scholarship_id);
		}

		$q = $this->db->get();

		// if ($s_scholarship_id) {
		// 	$q = $this->db->get_where('ref_scholarship', array('scholarship_id' => $s_scholarship_id));
		// }else{
		// 	$q = $this->db->get('ref_scholarship');
		// }

		return ($q->num_rows() > 0) ? $q->result() : false;
	}
	
	public function get_study_program_lists($a_clause = false)
	{
		$this->db->from('ref_program_study_program rpsp');
		$this->db->join('ref_study_program rsp', 'study_program_id');
		$this->db->join('ref_faculty rf', 'faculty_id');
		$this->db->join('ref_program rp', 'program_id');
		if ($a_clause) {
			$this->db->where($a_clause);
		}
		$this->db->order_by('rf.faculty_name', 'asc');
		$this->db->order_by('rsp.study_program_name', 'asc');
		$query = $this->db->get();
		return ($query->num_rows() > 0) ? $query->result() : false;
	}
	
	public function get_family_member_data($s_personal_data_id)
	{
		$a_family_member = $this->db->get_where('dt_family_member', array('personal_data_id' => $s_personal_data_id));
		return ($a_family_member->num_rows() >= 1) ? $a_family_member : false;
	}
	
	public function add_to_family($s_family_id, $s_personal_data_id)
	{
		$a_family_member_data = array(
			'family_id' => $s_family_id,
			'personal_data_id' => $s_personal_data_id,
			'family_member_status' => 'child'
		);
		$o_family_member = $this->db->get_where('dt_family_member', $a_family_member_data);
		
		if($o_family_member->num_rows() == 0){
			$this->db->insert('dt_family_member', $a_family_member_data);
		}
		else{
			return false;
		}
	}
	
	public function create_family()
	{
		$s_family_id = $this->uuid->v4();
		$this->db->insert('dt_family', array('family_id' => $s_family_id, 'date_added' => date('Y-m-d H:i:s')));
		return $s_family_id;
	}
	
	public function update_active_year($a_active_year_data, $i_active_year_id)
	{
		$this->db->update('dt_academic_year', $a_active_year_data, array('academic_year_id' => $i_active_year_id));
	}

    public function get_active_intake_year()
	{
		$this->db->select('*');
		$this->db->from('dt_academic_year');
		$this->db->where('academic_year_intake_status', 'active');
		$query = $this->db->get();
		return ($query->num_rows() >= 1) ? $query->first_row() : FALSE;
	}

	public function add_count_candidates()
	{
		$o_active_year = $this->get_active_intake_year();
		$i_candidates_counter = $o_active_year->academic_year_candidates_counter;
		$i_candidates_counter++;

		$a_update_active_year = array(
			'academic_year_candidates_counter' => $i_candidates_counter
		);
		$this->update_active_year($a_update_active_year, $o_active_year->academic_year_id);
	}

	public function signup_candidate($data, $registrationType = 'offline')
	{
		$this->load->model('Students');
		
		// $mba_student_exist = $this->db->;
		// if ($data['e']) {
		// 	# code...
		// }
		$s_personal_data_id = $this->uuid->v4();
		$a_personal_data = array(
			'personal_data_id' => $s_personal_data_id,
			'personal_data_name' => $data['fullname'],
			'personal_data_email' => $data['email'],
			'personal_data_cellular' => $data['mobile_phone'],
			// 'personal_data_date_of_birth' => $data['personal_data_date_of_birth'],
			// 'personal_data_place_of_birth' => $data['personal_data_place_of_birth'],
			'personal_data_password' => password_hash($data['password'], PASSWORD_DEFAULT),
			'personal_data_email_confirmation_token' => $data['token'],
			'date_added' => date('Y-m-d H:i:s')
		);
		
		$this->db->insert('dt_personal_data', $a_personal_data);
		
		$s_student_id = $this->uuid->v4();
		$a_student_data = array(
			'student_id' => $s_student_id,
			'student_registration_scholarship_id' => (!empty($data['student_registration_scholarship_id'])) ? $data['student_registration_scholarship_id'] : NULL,
			'personal_data_id' => $s_personal_data_id,
			'student_class_type' => $data['student_class_type'],
			'academic_year_id' => $data['academic_year_id'],
			'finance_year_id' => $data['academic_year_id'],
			'program_id' => ($data['program_id'] != '') ? $data['program_id'] : 1,
			'study_program_id' => ($data['study_program_id'] != '') ? $data['study_program_id'] : null,
			'date_added' => date('Y-m-d H:i:s'),
			'student_date_enrollment' => date('Y-m-d H:i:s')
		);
		$this->db->insert('dt_student', $a_student_data);

		$directory_file = APPPATH.'uploads/'.$s_personal_data_id.'/';
		if(!file_exists($directory_file)){
			mkdir($directory_file, 0755);
		}

		// update active year data
		$this->add_count_candidates();
		// end update active year data
		
		$s_family_id = $this->create_family();
		$this->add_to_family($s_family_id, $s_personal_data_id);

		$student_data = $this->Students->get_student_by_id($s_student_id);
		return $student_data;
	}
}

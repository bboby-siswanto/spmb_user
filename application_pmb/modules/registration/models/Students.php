<?php

class Students extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
	}

	public function reset_password($data, $personal_data_id)
    {
        $this->db->where('personal_data_id', $personal_data_id);
        $this->db->update('dt_personal_data', $data);
        if ($this->db->affected_rows()) {
            return true;
        }
        else{
            return false;
        }
    }
	
	public function updateTokenPassword($dataToken, $personal_data_id)
	{
		$this->db->where('personal_data_id', $personal_data_id);
		$this->db->update('dt_personal_data', $dataToken);

		if($this->db->affected_rows() > 0){
			return true;
		}
		else{
			return false;
		}
	}

    public function get_student_by_id($s_student_id)
	{
		$o_query = $this->db->get_where('dt_student', array('student_id' => $s_student_id));
		return ($o_query->num_rows() >= 1) ? $o_query->first_row() : FALSE;
	}
	
	public function getStudentData($studentId)
	{
		$this->db->select("
			*,
			stu.portal_id AS 'student_portal_id',
			pd.portal_id AS 'personal_portal_id'
		");
		$this->db->from('dt_student stu');
		$this->db->join('dt_personal_data pd', 'pd.personal_data_id = stu.personal_data_id');
		$this->db->join('ref_study_program sp', 'sp.study_program_id = stu.study_program_id', 'LEFT');
		$this->db->join('ref_faculty f', 'f.faculty_id = sp.faculty_id', 'LEFT');
		$this->db->where('stu.student_id', $studentId);
		$query = $this->db->get();
		return ($query->num_rows() >= 1) ? $query->first_row() : FALSE;
	}

	public function getCandidateData($condition = null)
	{
		$this->db->from('dt_student stu');
		$this->db->join('dt_personal_data pd', 'pd.personal_data_id = stu.personal_data_id');
		$this->db->join('ref_study_program sp', 'sp.study_program_id = stu.study_program_id', 'LEFT');
		$this->db->join('ref_faculty f', 'f.faculty_id = sp.faculty_id', 'LEFT');
		
		if (!is_null($condition)) {
			$this->db->where($condition);
		}
		
		$query = $this->db->get();
		if ($query->num_rows() > 1) {
			return $query->result();
		}else if ($query->num_rows() == 1) {
			return $query->first_row();
		}else{
			return FALSE;
		}
	}

	public function get_candidate_data($condition = null)
	{
		$this->db->from('dt_student stu');
		$this->db->join('dt_personal_data pd', 'pd.personal_data_id = stu.personal_data_id');
		$this->db->join('ref_study_program sp', 'sp.study_program_id = stu.study_program_id', 'LEFT');
		$this->db->join('ref_faculty f', 'f.faculty_id = sp.faculty_id', 'LEFT');
		
		if (!is_null($condition)) {
			$this->db->where($condition);
		}
		
		$query = $this->db->get();
		return ($query->num_rows() > 0) ? $query->result() : false;
	}
}

<?php
class Student_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function insert_institution($a_institution_data, $s_institution_id = null)
	{
		if ($s_institution_id == null) {
			if(!array_key_exists('institution_id', $a_institution_data)){
				$a_institution_data['institution_id'] = $this->uuid->v4();
			}
			
			$this->db->insert('ref_institution', $a_institution_data);
		}else{
			$this->db->update('ref_institution', $a_institution_data, array('institution_id' => $s_institution_id));
		}

		return ($a_institution_data['institution_id']);
	}

	public function get_student_personal_data($a_clause = false)
	{
		$this->db->from('dt_student st');
		$this->db->join('dt_personal_data pd', 'pd.personal_data_id = st.personal_data_id');
		if ($a_clause) {
			$this->db->where($a_clause);
		}
		$q = $this->db->get();
		return ($q->num_rows() > 0) ? $q->result() : false;
	}
	
	public function get_student_by_personal_data_id($s_personal_data_id)
	{
		$query = $this->db->get_where('dt_student', array('personal_data_id' => $s_personal_data_id));
		return ($query->num_rows() >= 1) ? $query->first_row() : false;
	}
	
	public function create_new_student($a_student_data)
	{
		if(is_object($a_student_data)){
			$a_student_data = (array)$a_student_data;
		}
		
		if(!array_key_exists('student_id', $a_student_data)){
			$a_student_data['student_id'] = $this->uuid->v4();
		}
		$this->db->insert('dt_student', $a_student_data);
		return $a_student_data['student_id'];
	}
	
	public function update_student_data($a_student_data, $s_student_id)
	{
		$this->db->update('dt_student', $a_student_data, array('student_id' => $s_student_id));
	}
	
	public function get_student_by_id($s_student_id)
	{
		$query = $this->db->get_where('dt_student', array('student_id' => $s_student_id));
		return ($query->num_rows() == 1) ? $query->first_row() : false;
	}
}
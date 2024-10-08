<?php
class Academics extends CI_Model
{
    public function __construct()
	{
		parent::__construct();
	}
	
	public function get_study_program_by_abbreviation($s_abbreviation)
	{
		$query = $this->db->get_where('ref_study_program rsp', array('rsp.study_program_abbreviation' => $s_abbreviation));
		return ($query->num_rows() >= 1) ? $query->first_row() : false;
	}
	
	public function get_study_programs_by_program_id($i_program_id)
	{
		$this->db->join('ref_study_program rsp', 'study_program_id');
		$this->db->join('ref_faculty rf', 'faculty_id');
		$this->db->order_by('rf.faculty_name', 'ASC');
		$this->db->order_by('rsp.study_program_name', 'ASC');
		$query = $this->db->get_where('ref_program_study_program rpsp', array('rpsp.program_id' => $i_program_id, 'rpsp.is_active' => 'yes'));
		return ($query->num_rows() >= 1) ? $query->result() : false;
	}
	
	public function get_programs()
	{
		$query = $this->db->get_where('ref_program', array('is_active' => 'yes'));
		return ($query->num_rows() >= 1) ? $query->result() : false;
	}

	public function get_institution_by_id($institution_id)
	{
		$this->db->select('*');
		$this->db->where('institution_id', $institution_id);
		$this->db->from('ref_institution');
		$query = $this->db->get();
		return ($query->num_rows() > 0) ? $query->first_row() : false;
	}

	public function get_student_document_uploaded($s_student_id)
	{
		$this->db->from('dt_student stu');
		$this->db->join('dt_personal_data pd','pd.personal_data_id = stu.personal_data_id');
		$this->db->join('dt_personal_data_document pdd','pdd.personal_data_id = pd.personal_data_id');
		$this->db->join('ref_document doc','doc.document_id = pdd.document_id');
		$this->db->join('ref_document_type dt', 'dt.document_id = doc.document_id');
		$this->db->where('stu.student_id', $s_student_id);
		$query = $this->db->get();

		return ($query->num_rows() > 0) ? $query->result() : FALSE;
	}
	
	public function get_document_type_require($a_type_required = array())
	{
		$this->db->select('*');
		if (count($a_type_required) > 0) {
			$this->db->from('ref_document_type dt');
			$this->db->join('ref_document dc', 'dc.document_id = dt.document_id','LEFT');
			$this->db->where_in('dt.document_type_name', $a_type_required);
		}else{
			$this->db->from('ref_document dc');
		}
		$this->db->order_by('dc.document_name','asc');
		$query = $this->db->get();

		return ($query->num_rows() > 0) ? $query->result() : FALSE;
	}

    public function student_study_program($studentId)
	{
		$this->db->select('*, stu.program_id');
		$this->db->from('dt_student stu');
		$this->db->join('ref_study_program sp', 'sp.study_program_id = stu.study_program_id');
		$this->db->join('ref_program rp', 'rp.program_id = stu.program_id');
		$this->db->where('stu.student_id', $studentId);
		$query = $this->db->get();
		return ($query->num_rows() >= 1) ? $query->first_row() : FALSE;
    }

    public function get_personal_data_background($personalDataId, $institutionId = null, $graduateYear = null)
	{
		$this->db->select('*');
		$this->db->from('dt_academic_history ahs');
		$this->db->join('ref_institution ins', 'ins.institution_id = ahs.institution_id');
		$this->db->join('dt_address addr', 'addr.address_id = ins.address_id', 'LEFT');
		$this->db->join('ref_country c', 'c.country_id = addr.country_id', 'LEFT');
		if(!is_null($institutionId)){
			$this->db->where('ahs.institution_id', $institutionId);
		}
		if(!is_null($graduateYear)){
			$this->db->where('ahs.academic_history_graduation_year', $graduateYear);
		}
		$this->db->where('ahs.personal_data_id', $personalDataId);
		$query = $this->db->get();
		if($query->num_rows() >= 1){
			return $query->first_row();
		}
		else{
			return FALSE;
		}
	}

    public function get_study_program_list($allLegal = false, $isFrontPmb = false)
	{
		$this->db->select('*');
		$this->db->from('ref_study_program sp');
		$this->db->join('ref_faculty f', 'f.faculty_id = sp.faculty_id');
		if($allLegal){
			$this->db->where('sp.study_program_main_id', NULL);
		}
		$this->db->order_by('sp.faculty_id', 'ASC');
		$this->db->order_by('sp.study_program_name', 'ASC');
		$query = $this->db->get();
		return ($query->num_rows() >= 1) ? $query->result() : FALSE;
	}

    public function get_student_sgs_refferal($personal_data_id)
	{
		$this->db->select("
			pder.personal_data_id AS personal_data_id_referer,
			pder.personal_data_id AS personal_data_id_referenced,
			pder.personal_data_reference_code AS sgs_code
		");
		$this->db->from('dt_reference rr');
		$this->db->join('dt_personal_data pder', 'pder.personal_data_id = rr.referrer_id');
		$this->db->join('dt_personal_data pded', 'pded.personal_data_id = rr.referenced_id');
		$this->db->where('rr.referenced_id', $personal_data_id);
		$query = $this->db->get();
		return ($query->num_rows() >= 1) ? $query->first_row() : false;
	}

    public function update_student_data($studentData, $studentId)
	{
		$this->db->update('dt_student', $studentData, array('student_id' => $studentId));
		return true;
    }

    public function test_update_student_data($studentData, $studentId)
	{
		$this->db->update('dt_student', $studentData, array('student_id' => $studentId));
		return $this->db->last_query();
    }
    
    public function get_student_data($studentId)
	{
		$this->db->from('dt_student stu');
		$this->db->join('dt_personal_data pd', 'pd.personal_data_id = stu.personal_data_id');
		$this->db->join('dt_academic_history ahs','ahs.personal_data_id = pd.personal_data_id', 'LEFT');
		$this->db->join('ref_study_program sp', 'sp.study_program_id = stu.study_program_id', 'LEFT');
		$this->db->join('ref_faculty f', 'f.faculty_id = sp.faculty_id', 'LEFT');
		$this->db->join('ref_institution ins','ins.institution_id = ahs.institution_id','LEFT');
		$this->db->join('dt_address add','add.address_id = ins.address_id','LEFT');
		$this->db->where('stu.student_id', $studentId);
		$query = $this->db->get();
		return ($query->num_rows() >= 1) ? $query->first_row() : FALSE;
	}

	public function update_institution($a_institution_data, $s_institution_id)
	{
		$this->db->update('ref_institution', $a_institution_data, ['institution_id' => $s_institution_id]);
		return true;
	}

    public function insert_new_institution($institutionData)
	{	
		$this->db->insert('ref_institution', $institutionData);
		if($this->db->affected_rows() > 0){
			return TRUE;
		}
		else{
			return FALSE;
		}
	}

    public function get_instutions_by_name($educationName, $educationType)
	{
		$this->db->select('*');
		$this->db->from('ref_institution ins');
		
		if($educationType == 'highschool'){
			$this->db->join('dt_address addr', 'addr.address_id = ins.address_id', 'LEFT');
			$this->db->join('ref_country c', 'c.country_id = addr.country_id', 'LEFT');
			$this->db->where("(ins.institution_type = 'highschool' OR ins.institution_type = 'university')");
		}
		$this->db->like('ins.institution_name', $educationName);
		$this->db->limit(50);
		$query = $this->db->get();
		return ($query->num_rows() >= 1) ? $query->result() : FALSE;
	}
    
    public function get_document($type)
	{
		$this->db->select('*');
		$this->db->from('ref_document_type dt');
		$this->db->join('ref_document doc', 'dt.document_id = doc.document_id');
		$this->db->where('dt.document_type_name', $type);
		$this->db->order_by('doc.document_name', 'ASC');
		$query = $this->db->get();
		return ($query->num_rows() >= 1) ? $query->result() : FALSE;
	}
}
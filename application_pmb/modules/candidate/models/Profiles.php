<?php

class Profiles extends CI_Model
{
	public $a_field_not_included = [
		'portal_sync','personal_data_reference_code', 'portal_status', 'student_number', 'student_email', 'student_portal_blocked',
		'student_send_transcript', 'student_ofse_eligibility', 'student_alumni_email'
	];

    public function __construct()
	{
		parent::__construct();
	}

	public function save_institution_contact($a_data, $a_update_clause = false)
	{
		if ($a_update_clause) {
			$this->db->update('dt_institution_contact', $a_data, $a_update_clause);
			return true;
			
		}else{
			$this->db->insert('dt_institution_contact', $a_data);
			return ($this->db->affected_rows() > 0) ? true : false;
			
		}
	}

	public function insert_family_member($a_data)
	{
		$this->db->insert('dt_family_member', $a_data);
		return ($this->db->affected_rows() > 0) ? true : false;
	}

	public function get_personal_data_student($a_clause = false)
	{
		$this->db->select('*, st.personal_data_id AS "personal_data_id"');
		$this->db->from('dt_student st');
		$this->db->join('dt_personal_data pd', 'pd.personal_data_id = st.personal_data_id');
		$this->db->join('dt_personal_address pda', 'pd.personal_data_id = pda.personal_data_id', 'LEFT');
		$this->db->join('dt_address da', 'da.address_id = pda.address_id', 'LEFT');
		if ($a_clause) {
			$this->db->where($a_clause);
		}
		$this->db->group_by('st.student_id');
		$q = $this->db->get();
		return ($q->num_rows() > 0) ? $q->result() : false;
	}

	public function get_document($a_clause = false)
	{
		$this->db->from('ref_document rd');
		if ($a_clause) {
			$this->db->where($a_clause);
		}

		$query = $this->db->get();

		return ($query->num_rows() > 0) ? $query->result() : false;
	}

	public function update_portal_sync($i_code, $s_table_name, $a_condition)
	{
		$a_data = array(
			'portal_sync' => strval($i_code)
		);
		$this->db->where($a_condition);
		$this->db->update($s_table_name, $a_data);

		if ($this->db->affected_rows() > 0) {
			return true;
		}else{
			return false;
		}
	}

	public function get_data_field($table, $condition = null, $get_all = false)
	{
		$a_field = $this->db->list_fields($table);
		foreach ($a_field as $field) {
			if (!in_array($field, $this->a_field_not_included)) {
				$this->db->select($field);
			}
		}

		$this->db->from($table);

		if ($condition != null) {
			$this->db->where($condition);
		}
		$query = $this->db->get();
		
		if ($get_all) {
			return ($query->num_rows() > 0) ? $query->result() : false;
		}else{
			return ($query->num_rows() > 0) ? $query->first_row() : false;
		}
	}

	public function get_occupation_name($s_occupation_name)
	{
		$this->db->from('ref_ocupation ocs');
		$this->db->where('ocs.ocupation_name', $s_occupation_name);
		$query = $this->db->get();
		return ($query->num_rows() > 0) ? $query->result() : FALSE;
	}

	public function get_institution_name($s_institution_name)
	{
		$this->db->from('ref_institution ins');
		$this->db->where('ins.institution_name', $s_institution_name);
		$query = $this->db->get();

		return ($query->num_rows() > 0) ? $query->result() : FALSE;
	}

	public function getOccupationByName($term, $type = falses)
	{
		$this->db->from('ref_ocupation ocs');
		if($type){
			$this->db->join('dt_personal_data pd','pd.ocupation_id = ocs.ocupation_id');
		}
		// $this->db->
		$this->db->like('ocs.ocupation_name', $term);
		$query = $this->db->get();

		return ($query->num_rows() > 0) ? $query->result() : false;
	}

	public function get_parent_data($family_id)
	{
		$this->db->select('*, pd.personal_data_id AS personal_data_id');
		$this->db->where('fm.family_id', $family_id);
		$this->db->where('fm.family_member_status != ','child');
		$this->db->from('dt_family_member fm');
		$this->db->join('dt_personal_data pd','pd.personal_data_id = fm.personal_data_id');
		$this->db->join('dt_academic_history ahs','ahs.personal_data_id = pd.personal_data_id', 'left');
		$this->db->join('ref_institution ins','ins.institution_id = ahs.institution_id', 'left');
		$this->db->join('ref_ocupation opt','opt.ocupation_id = pd.ocupation_id', 'left');
		$query = $this->db->get();

		return ($query->num_rows() > 0) ? $query->first_row() : false;
	}

	public function get_family_student($personal_data_id)
	{
		$this->db->where('fm.personal_data_id', $personal_data_id);
		$this->db->from('dt_family_member fm');
		$this->db->join('dt_personal_data pd','pd.personal_data_id = fm.personal_data_id');
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->first_row();
		}else{
			return false;
		}
	}

	public function get_wilayah()
	{
		$this->db->from('dikti_wilayah');
		return $this->db->get()->result();
	}

	public function isUniqueEmail($email, $personalDataId)
	{
		$this->db->select('*');
		$this->db->from('dt_personal_data pd');
		$this->db->where('pd.personal_data_id != ', $personalDataId);
		$this->db->where('pd.personal_data_email', $email);
		$query = $this->db->get();
		return ($query->num_rows() >= 1) ? FALSE : TRUE;
	}

	public function get_personal_data_documents($personal_data_id, $document_id = NULL)
	{
		$this->db->select('*');
		$this->db->from('dt_personal_data_document pdd');
		$this->db->join('dt_personal_data pd', 'pd.personal_data_id = pdd.personal_data_id');
		$this->db->join('ref_document doc', 'doc.document_id = pdd.document_id');
		$this->db->join('ref_document_type dt', 'dt.document_id = doc.document_id');
		if(!is_null($document_id)){
			$this->db->where('pdd.document_id', $document_id);
		}
		$this->db->where('pdd.personal_data_id', $personal_data_id);
		$query = $this->db->get();
		if($query->num_rows() >= 1){
			return $query->result();
		}
		else{
			return FALSE;
		}
	}

    public function get_religion_list()
    {
        $this->db->select('*');
        $this->db->from('ref_religion');
        $query = $this->db->get();
        return ($query->num_rows() >= 1) ? $query->result() : false;
	}
	
	public function save_family($family_data)
	{
		$query = $this->db->insert('dt_family', $family_data);

		return ($query) ? true : false;
	}

    public function save_relations_data($relationship_data, $type)
	{
		$a_parent_data = array(
			'personal_data_id' => $relationship_data['personal_data_parent_id'],
			'personal_data_name' => $relationship_data['personal_data_parent_name'],
			'personal_data_email' => $relationship_data['personal_data_parent_email'],
			'ocupation_id' => $relationship_data['parent_occupation_id'],
			'personal_data_cellular' => $relationship_data['personal_data_parent_cellular']
		);

		$a_family_member_data = array(
			'family_id' => $relationship_data['family_id'],
			'personal_data_id' => $relationship_data['personal_data_parent_id'],
			'family_member_status' => $relationship_data['family_member_status']
		);

		$a_student_update_data = array(
			'personal_data_mother_maiden_name' => $relationship_data['personal_data_student_maiden_name']
		);

		$a_academic_history_parent = array(
			'academic_history_id' => $relationship_data['academic_history_id_insert'],
			'institution_id' => $relationship_data['parent_institution_id'],
			'personal_data_id' => $relationship_data['personal_data_parent_id'],
			'date_added' => date('Y-m-d H:i:s')
		);

		if ($type == 'insert') {
			$a_parent_data['date_added'] = date('Y-m-d H:i:s');
			$a_family_member_data['date_added'] = date('Y-m-d H:i:s');

			$this->db->insert('dt_personal_data', $a_parent_data);
			$this->db->insert('dt_academic_history', $a_academic_history_parent);
			$this->db->insert('dt_family_member', $a_family_member_data);
			$this->db->update('dt_personal_data', $a_student_update_data, array('personal_data_id' => $relationship_data['personal_data_student_id']));

			return ($this->db->affected_rows() > 0) ? true : false;
		}else if ($type == 'update') {
			$this->db->update('dt_personal_data', $a_parent_data, array('personal_data_id' => $relationship_data['personal_data_parent_id']));
			$this->db->update('dt_personal_data', $a_student_update_data, array('personal_data_id' => $relationship_data['personal_data_student_id']));

			return true;
		}
	}

    public function insert_new_occupation($occupation_data)
	{
		$this->db->insert('ref_ocupation', $occupation_data);
		if($this->db->affected_rows() > 0){
			return $this->db->insert_id();
		}
		else{
			return FALSE;
		}
	}

    public function new_occupation($occupation_data)
	{
		$this->db->insert('ref_ocupation', $occupation_data);
		return ($this->db->affected_rows() > 0) ? true : false;
	}

	public function getFamilyStudent($personal_data_id)
	{
		$this->db->from('dt_personal_data pd');
		$this->db->join('dt_family_member dfm','dfm.personal_data_id = pd.personal_data_id');
		$this->db->where('pd.personal_data_id', $personal_data_id);
		$query = $this->db->get();
		return ($query->num_rows() > 0) ? $query->row() : false;
	}

    public function get_relationship_data($family_id)
	{
		$this->db->select("
			pds.*,
			pdo.*,
			stu.*
		");
		$this->db->from('dt_student stu');
		$this->db->join('dt_personal_data pds', 'pds.personal_data_id = stu.personal_data_id');
		$this->db->join('dt_family_member fmb', 'fmb.personal_data_id = pds.personal_data_id');
		$this->db->join('dt_personal_data pdo', 'pdo.personal_data_id = fmb.personal_data_id');
		$this->db->where('fmb.family_id', $family_id);
		$query = $this->db->get();
		return ($query->num_rows() >= 1) ? $query->result() : FALSE;
	}

    public function get_instutionsby_nName($educationName, $educationType)
	{
		$this->db->select('*');
		$this->db->from('ref_institution ins');
		
		if($educationType == 'school'){
			$this->db->join('dt_address addr', 'addr.address_id = ins.address_id', 'LEFT');
			$this->db->join('ref_country c', 'c.country_id = addr.country_id', 'LEFT');
			$this->db->where('ins.institution_type', 'highschool');
		}
		$this->db->like('ins.institution_name', $educationName);
		$query = $this->db->get();
		return ($query->num_rows() >= 1) ? $query->result() : FALSE;
	}

    public function get_occupation_by_name($term)
	{
		$this->db->select('*');
		$this->db->from('ref_ocupation o');
		$this->db->like('o.ocupation_name', $term);
		$query = $this->db->get();
		return ($query->num_rows() >= 1) ? $query->result() : FALSE;

	}

    public function save_personal_data_background($personalDataBackground, $academic_history_id = null)
    {
        if(!is_null($academic_history_id)){
			$this->db->update('dt_academic_history', $personalDataBackground, array('academic_history_id' => $academic_history_id));
			// return $academic_history_id;
			return true;
		}
		else{
			$this->db->insert('dt_academic_history', $personalDataBackground);
			if($this->db->affected_rows() > 0){
				// return $this->db->insert_id();
				return true;
			}
			else{
				return FALSE;
			}
		}
	}
	
	public function save_personal_data_document($personal_data_document, $personal_data_id = NULL, $document_id = NULL)
	{
		if(!is_null($personal_data_id)){
			$this->db->update('dt_personal_data_document', $personal_data_document, array('personal_data_id' => $personal_data_id, 'document_id' => $document_id));
			return $personal_data_id;
		}
		else{
			$this->db->insert('dt_personal_data_document', $personal_data_document);
			if($this->db->affected_rows() > 0){
				return TRUE;
			}
			else{
				return FALSE;
			}
		}
	}

	public function get_academic_history_student($personalDataId, $institutionId = null, $graduateYear = null)
    {
		$this->db->select('*');
		$this->db->from('dt_academic_history ahs');
		$this->db->join('dt_personal_data_id pd','pd.personal_data_id = ahs.personal_data_id','LEFT');
		$this->db->join('ref_institution ins', 'ins.institution_id = ahs.institution_id');
		$this->db->join('ref_ocupation occ', 'occ.ocupation_id = pd.ocupation_id', 'LEFT');
		$this->db->join('dt_address addr', 'addr.address_id = ins.address_id', 'LEFT');
        $this->db->join('ref_country c', 'c.country_id = addr.country_id', 'LEFT');
        if(!is_null($institutionId)){
			$this->db->where('ahs.institution_id', $institutionId);
        }
        
        if(!is_null($graduateYear)){
			$this->db->where('ahs.academic_history_graduation_year', $graduateYear);
        }
        
		$this->db->where('pd.personal_data_id', $personalDataId);
        $query = $this->db->get();
        
		if($query->num_rows() == 1){
			return $query->first_row();
		}
		else{
			if($query->num_rows() > 1){
				return $query->result();
			}
			else{
				return FALSE;
			}
		}
    }

    public function save_address_data($addressData, $addressId = null)
    {
        if(is_null($addressId)){
			$this->db->insert('dt_address', $addressData);
			return ($this->db->affected_rows() > 0) ? true : false;
		}
		else{
			$this->db->where('address_id', $addressId);
			$this->db->update('dt_address', $addressData);
			return true;
		}
	}
	
	public function save_personal_address($personal_address, $personal_data_id = null)
	{
		if (is_null($personal_data_id)) {
			$this->db->insert('dt_personal_address', $personal_address);
		}else{
			$this->db->where('personal_data_id', $personal_data_id);
			$this->db->update('dt_personal_address', $personal_address);
		}

		return ($this->db->affected_rows() > 0) ? true : false;
	}

    public function save_personal_data($personalData, $personal_data_id = null)
    {
        if(is_null($personal_data_id)){
			$this->db->insert('dt_personal_data', $personalData);
			return $this->db->insert_id();
		}
		else{
			$this->db->where('personal_data_id', $personal_data_id);
			$this->db->update('dt_personal_data', $personalData);
			return $personal_data_id;
		}
	}
	
    public function get_country_by_name($term)
    {
        $this->db->select('*');
		$this->db->from('ref_country c');
		$this->db->like('c.country_name', $term);
		$query = $this->db->get();
		return ($query->num_rows() >= 1) ? $query->result() : FALSE;
	}
	
	public function get_dikti_wilayah_by_name($term)
	{
		$this->db->select('*');
		$this->db->from('dikti_wilayah w');
		$this->db->like('w.nama_wilayah', $term);
		$query = $this->db->get();
		return ($query->num_rows() > 0) ? $query->result() : FALSE;
	}

    public function get_personal_data_background($personalDataId)
    {
        $this->db->select('*');
        $this->db->from('dt_academic_history ahs');
        $this->db->join('ref_institution ins', 'ins.institution_id = ahs.institution_id');
        // $this->db->join('occupation occ', 'occ.occupation_id = pd.occupation_id', 'LEFT');
        $this->db->where('ahs.personal_data_id', $personalDataId);
        $query = $this->db->get();
        return ($query->num_rows() >= 1) ? $query->first_row() : false;
    }
    
    public function get_personal_data_by_id($s_personal_data_id)
    {
	    $query = $this->db->get_where('dt_personal_data', ['personal_data_id' => $s_personal_data_id]);
	    return ($query->num_rows() == 1) ? $query->first_row() : false;
    }

    public function get_personal_data($personalDataId)
    {
        $this->db->select('*, c1.country_name as birth_country, c2.country_name as city_country, c3.country_name as address_country, c3.country_id as address_country_id, pda.address_id as personal_address_id');
		$this->db->from('dt_personal_data pd');
		$this->db->join('dt_personal_address pda','pda.personal_data_id = pd.personal_data_id','left');
        $this->db->join('ref_country c1','c1.country_id = pd.country_of_birth','left');
        $this->db->join('ref_country c2','c2.country_id = pd.citizenship_id','left');
        $this->db->join('dt_address ad','ad.address_id = pda.address_id','left');
		$this->db->join('ref_religion rl','rl.religion_id = pd.religion_id','left');
		$this->db->join('dt_academic_history ahs','ahs.personal_data_id = pd.personal_data_id','left');
        $this->db->join('ref_institution ins','ins.institution_id = ahs.institution_id','left');
        // $this->db->join('ref_occupation oc','oc.occupation_id = pd.occupation_id','left');
		$this->db->join('ref_country c3','c3.country_id = ad.country_id','left');
		$this->db->join('dikti_wilayah w','w.id_wilayah = ad.dikti_wilayah_id','left');
        $this->db->where('pd.personal_data_id', $personalDataId);
        $query = $this->db->get();
        return ($query->num_rows() >= 1) ? $query->first_row() : false;
	}

	public function get_student_document($a_clause = false)
	{
		$this->db->from('dt_personal_data_document pdd');
		$this->db->join('dt_student st', 'st.personal_data_id = pdd.personal_data_id');
		if ($a_clause) {
			$this->db->where($a_clause);
		}
		$q = $this->db->get();
		return ($q->num_rows() > 0) ? $q->result() : false;
	}
}

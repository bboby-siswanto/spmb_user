<?php
class Employment_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->mdb = $this->load->database('mdb', true);
    }

	public function get_student_background($a_clause = false)
	{
		$this->db->select('*');
		$this->db->from('dt_academic_history ahs');
		$this->db->join('ref_institution ins', 'ins.institution_id = ahs.institution_id');
		$this->db->join('dt_address addr', 'addr.address_id = ins.address_id', 'LEFT');
		$this->db->join('ref_country c', 'c.country_id = addr.country_id', 'LEFT');
		$this->db->join('ref_ocupation oc', 'oc.ocupation_id = ahs.occupation_id', 'LEFT');

		if ($a_clause) {
			$this->db->where($a_clause);
		}

		$query = $this->db->get();
		return ($query->num_rows() >= 1) ? $query->result() : false;
	}

    public function institution_suggestions($s_institution_name = false, $a_institution_type = false, $b_exact = false, $b_limit = false)
	{
		$this->mdb->select('*');
		$this->mdb->from('ref_institution ri');
		$this->mdb->join('dt_address da','da.address_id = ri.address_id','left');
		$this->mdb->join('ref_country rc','rc.country_id = da.country_id','left');
		
		if($a_institution_type){
			$this->mdb->where_in('ri.institution_type', $a_institution_type);
		}
		
		if($s_institution_name){
			if($b_exact){
				$this->mdb->where('ri.institution_name', $s_institution_name);
			}
			else{
				$this->mdb->like('ri.institution_name', $s_institution_name);
			}
		}

        if ($b_limit) {
			$this->mdb->limit(10, 0);
		}

        $this->mdb->group_by('ri.institution_name');
		$query = $this->mdb->get();
		return ($query->num_rows() >= 1) ? $query->result() : false;
	}

    public function occupation_suggestions($s_occupation_name = false, $b_exact = false, $b_limit = false)
	{
		$this->mdb->select('*');
		$this->mdb->from('ref_ocupation ro');
		
		if($s_occupation_name){
			if($b_exact){
				$this->mdb->where('ro.ocupation_name', $s_occupation_name);
			}
			else{
				$this->mdb->like('ro.ocupation_name', $s_occupation_name);
			}
		}

        if ($b_limit) {
			$this->mdb->limit(10, 0);
		}

        $this->mdb->group_by('ro.ocupation_name');
		$query = $this->mdb->get();
		return ($query->num_rows() >= 1) ? $query->result() : false;
	}
}

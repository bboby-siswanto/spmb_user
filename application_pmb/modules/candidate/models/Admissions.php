<?php
class Admissions extends CI_Model
{
    public function __construct()
	{
		parent::__construct();
	}

	public function set_sgs_promo($reference_data, $where_condition = null)
	{
		if ($where_condition != null) {
			$this->db->update('dt_reference', $reference_data, $where_condition);
		}else{
			$this->db->insert('dt_reference', $reference_data);
		}

		if ($this->db->affected_rows() > 0) {
			return true;
		}else{
			return false;
		}
	}
	
	public function get_sgs_referenced($referenced_id)
	{
		$query = $this->db->get_where('dt_reference', array(
			'referenced_id' => $referenced_id
		));
		return ($query->num_rows() == 1) ? $query->first_row() : false;
	}

	public function get_sgs_referral($referrer_id)
	{
		$this->db->from('dt_reference reff');
		$this->db->where('reff.referrer_id', $referrer_id);
		$this->db->order_by('reff.date_added','DESC');
		$query = $this->db->get();
		return ($query->num_rows() >= 1) ? $query->first_row() : false;
	}

	public function get_student_by_sgs_code($sgs_code)
	{
		$this->db->select('pd.personal_data_id');
		$this->db->from('dt_personal_data pd');
		$this->db->where('pd.personal_data_reference_code', $sgs_code);
		$query = $this->db->get();
		return ($query->num_rows() >= 1) ? $query->first_row() : false;
	}
}
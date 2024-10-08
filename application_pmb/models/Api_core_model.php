<?php
class Api_core_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function get_api_data_by_access_token($s_access_token)
	{
		$o_query = $this->db->get_where('dt_api', array('api_access_token' => $s_access_token));
		return ($o_query->num_rows() == 1) ? $o_query->first_row() : false;
	}
	
	public function get_data($s_table_name, $a_clause)
	{
		$query = $this->db->get_where($s_table_name, $a_clause);
		return ($query->num_rows() == 1) ? $query->first_row() : false;
	}

	public function retrieve_data($s_table_name, $a_clause = false)
	{
		if ($a_clause) {
			$q = $this->db->get_where($s_table_name, $a_clause);
		}else {
			$q = $this->db->get($s_table_name);
		}

		return ($q->num_rows() > 0) ? $q->result() : false;
	}

	public function save_data($s_table_name, $a_data, $a_update_clause = false)
	{
		if ($a_update_clause) {
			$this->db->update($s_table_name, $a_data, $a_update_clause);
			return true;
		}else{
			$this->db->insert($s_table_name, $a_data);
			return ($this->db->affected_rows() > 0) ? true : false;
		}
	}
}
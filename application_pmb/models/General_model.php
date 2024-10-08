<?php
class General_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	
	/**
	* https://stackoverflow.com/a/11429272/1876470
	**/
	public function get_enum_values( $table, $field )
	{
		$type = $this->db->query( "SHOW COLUMNS FROM {$table} WHERE Field = '{$field}'" )->row( 0 )->Type;
		preg_match("/^enum\(\'(.*)\'\)$/", $type, $matches);
		$enum = explode("','", $matches[1]);
		return $enum;
	}

	public function get_where($s_table_name, $a_clause = false)
	{
		if ($a_clause) {
			$query = $this->db->get_where($s_table_name, $a_clause);
		}else{
			$query = $this->db->get($s_table_name);
		}

		return ($query->num_rows() > 0) ? $query->result() : false;
	}

	public function get_like($s_table_name, $a_like_clause = false)
	{
		if ($a_like_clause) {
			$this->db->like($a_like_clause);
		}
		
		$query = $this->db->get($s_table_name);

		return ($query->num_rows() > 0) ? $query->result() : false;
	}

	public function get_candidate_instiutiton($s_personal_data_id, $s_email, $s_personal_data_name, $a_clause = false)
	{
		$this->db->from('dt_academic_history ah');
		$this->db->join('ref_institution ri', 'ri.institution_id = ah.institution_id');
		$this->db->join('dt_personal_data pd', 'pd.personal_data_id = ah.personal_data_id');

		if ($a_clause) {
			$this->db->where($a_clause);
		}

		$primary_find = "(ah.personal_data_id = '$s_personal_data_id' OR pd.personal_data_name = '$s_personal_data_name' OR pd.personal_data_email = '$s_email')";
		$this->db->where($primary_find);

		$query = $this->db->get();
		// return ($query->num_rows() > 0) ? $query->result() : $this->db->last_query();
		return ($query->num_rows() > 0) ? $query->result() : false;
	}
}
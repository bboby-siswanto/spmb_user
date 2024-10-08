<?php
class Pmb_general_model extends CI_Model
{
	private $odb;
	
	public function __construct()
	{
		parent::__construct();
		$this->odb = $this->load->database('odb', true);
	}
	
	public function get_where($s_table_name, $a_clause = false)
	{
		if($a_clause){
			$this->odb->where($a_clause);
		}
		$query = $this->odb->get($s_table_name);
		return ($query->num_rows() == 1) ? $query->first_row() : false;
	}
	
	public function retrieve_data_where($s_table_name, $a_clause = false)
	{
		if($a_clause){
			$this->odb->where($a_clause);
		}
		$query = $this->odb->get($s_table_name);
		return ($query->num_rows() >= 1) ? $query->result() : false;
	}
	
	public function update_data($s_table_name, $a_data, $a_clause)
	{
		$this->odb->update($s_table_name, $a_data, $a_clause);
	}
	
	public function insert($s_table_name, $a_data)
	{
		$this->odb->insert($s_table_name, $a_data);
		return $this->odb->insert_id();
	}
}
<?php
class Synchronizer_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function init_forge()
	{
		$this->load->dbforge();
	}
	
	public function backup_access_log()
	{
		$this->init_forge();
		
		$s_table_name = 'dt_access_log';
		$s_backup_table_name = implode('_', [$s_table_name, date('Ymd', time())]);
		$this->dbforge->rename_table($s_table_name, $s_backup_table_name);
		$this->db->query("CREATE TABLE $s_table_name LIKE $s_backup_table_name");
	}
	
	public function get_latest_data($s_table_name)
	{
		$now = date('Y-m-d H:i:s', time());
		$s_start_date = date('Y-m-d 00:00:00', time());
		$s_end_date = date('Y-m-d 23:59:59', time());
		
		$this->db->where('timestamp >= ', $s_start_date);
		$this->db->where('timestamp <= ', $s_end_date);
		$query = $this->db->get($s_table_name);
		return ($query->num_rows() >= 1) ? $query->result() : false;
	}
}
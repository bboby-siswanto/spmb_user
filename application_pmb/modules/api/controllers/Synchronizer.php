<?php
class Synchronizer extends Api_core
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function retrieve_sync()
	{
		$a_ref_data = $this->a_api_data;
		$a_return = array();
		set_time_limit(5000);
		
		$this->db->trans_start();
		
		for($j = 0; $j < count($a_ref_data['batch_data']); $j++){
			$a_clause = array();
			
			$s_table_name = $a_ref_data['table'];
			$a_table_fields = $a_ref_data['table_fields'];
			$a_primary_key = $a_ref_data['primary_key'];
			$a_batch_data = $a_ref_data['batch_data'];
			
			for($l = 0; $l < count($a_primary_key); $l++){
				$a_clause[$a_primary_key[$l]] = $a_batch_data[$a_primary_key[$l]];
			}
			
			for($m = 0; $m < count($a_table_fields); $m++){
				if(!$this->db->field_exists($a_table_fields[$m], $s_table_name)){
					unset($a_batch_data[$a_table_fields[$m]]);
				}
			}
			
			$query = $this->db->get_where($s_table_name, $a_clause);
			
			if($query->num_rows() == 1){
				$this->db->update($s_table_name, $a_batch_data, $a_clause);
			}
			else{
				if(array_key_exists('pmb_sync', $a_batch_data)){
					unset($a_batch_data[$k]['pmb_sync']);
				}
				$a_batch_data['portal_sync'] = '0';
				$this->db->insert($s_table_name, $a_batch_data);
			}
		}
		
		if($this->db->trans_status() === false){
			$this->db->trans_rollback();
			$a_return = array('code' => 1, 'message' => 'ada error');
		}
		else{
			$this->db->trans_commit();
			$a_return = array('code' => 0, 'message' => 'success');
		}
		
		$this->return_json($a_return);
	}

	// public function retrieve_exam()
	// {
	// 	$a_ref_data = $this->a_api_data;
	// 	$a_return = array();
	// 	set_time_limit(5000);

	// 	$this->db->trans_start();

	// 	if ($this->db->trans_status() == false) {
	// 		$this->db->trans_rollback();
	// 		$a_return = array('code' => 1, 'message' => 'Error');
	// 	}else{
	// 		$this->db->trans_commit();
	// 		$a_return = array('code' => 0, 'message' => 'Success');
	// 	}

	// 	$this->return_json($a_return);
	// }
}
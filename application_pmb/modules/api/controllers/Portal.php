<?php
class Portal extends Api_core
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Api_core_model', 'Acm');
	}
	
	public function sync_all()
	{
		$a_sync_data = $this->a_api_data['sync_data'];
		$a_return = array();

		$this->db->trans_start();
		for($i = 0; $i < count($a_sync_data); $i++){
			$this->sync_data($a_sync_data[$i]['table_name'], $a_sync_data[$i]['data'], $a_sync_data[$i]['clause']);
			array_push($a_return, array('table_name' => $a_sync_data[$i]['table_name'], 'clause' => $a_sync_data[$i]['clause']));
		}

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$this->return_json(array('code' => 1, 'a_return_data' => $a_return));
		}else{
			$this->db->trans_commit();
			$this->return_json(array('code' => 0, 'a_return_data' => $a_return));
		}
	}

	public function retrieve_data()
	{
		$this->load->model('General_model', 'General');
		$a_list_personal_data = $this->a_api_data['list_data'];

		$a_return_data = [];
		foreach ($a_list_personal_data as $o_data) {
			$mba_academic_history_data = $this->General->get_candidate_instiutiton($o_data['personal_data_id'], $o_data['personal_data_email'], $o_data['personal_data_name']);
			// $mba_academic_history_data = $this->General->get_where('dt_academic_history', [
			// 	'personal_data_id' => $o_data['personal_data_id']
			// ]);

			// $this->return_json(array('code' => 0, 'return_data' => $mba_academic_history_data));exit;
			if ($mba_academic_history_data) {
				foreach ($mba_academic_history_data as $o_academic_history) {
					if (!empty($o_academic_history->institution_name)) {
						$a_institution_data = $this->General->get_where('ref_institution', ['institution_id' => $o_academic_history->institution_id]);
						$a_academic_history_data = $this->General->get_where('dt_academic_history', ['academic_history_id' => $o_academic_history->academic_history_id]);
						$a_address_data = false;
						if (($a_institution_data) AND (!is_null($a_institution_data[0]->address_id))) {
							$a_address_data = $this->General->get_where('dt_address', ['address_id' => $a_institution_data[0]->address_id]);
						}

						$s_personal_data_id = $o_data['personal_data_id'];
						$a_return_data[$s_personal_data_id] = [
							'institution_data' => $a_institution_data[0],
							'academic_history_data' => $a_academic_history_data[0],
							'institution_address' => $a_address_data
						];
						
						// $this->return_json(array('code' => 0, 'return_data' => $mba_academic_history_data));exit;
					}
				}
			}
		}
		$this->return_json(array('code' => 0, 'return_data' => $a_return_data));
	}
	
	public function sync_data($s_table_name = false, $a_data = false, $a_clause = false)
	{
		if((!$s_table_name) AND (!$a_data) AND (!$a_clause)){
			$s_table_name = $this->a_api_data['table_name'];
			$a_data = $this->a_api_data['data'];
			$a_clause = $this->a_api_data['clause'];
		}
		
		$mbo_check_data = $this->Acm->get_data($s_table_name, $a_clause);
		if($mbo_check_data){
			$this->db->update($s_table_name, $a_data, $a_clause);
		}
		else{
			$this->db->insert($s_table_name, $a_data);
		}
	}
}	
?>
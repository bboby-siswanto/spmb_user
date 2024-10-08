<?php
class Pmb_sync_model extends CI_Model
{
	public $odb;
	
	public function __construct()
	{
		parent::__construct();
		$this->odb = $this->load->database('odb', true);
	}
	
	public function get_candidate_students($i_academic_year_id = 7)
	{
		$this->odb->join('entrance_test_participant etp', 'etp.canstu_id = cs.canstu_id', 'LEFT');
		$this->odb->join('student stu', 'stu.canstu_id = cs.canstu_id', 'LEFT');
		$this->odb->join('entrance_test_schedule ets', 'ets.et_schedule_id = etp.et_schedule_id', 'LEFT');
		$this->odb->join('religion rel', 'rel.religion_id = cs.religion_id', 'LEFT');
		$this->odb->join('study_program sp', 'sp.stupro_id = etp.stupro_id');
		$this->odb->join('department d', 'd.department_id = sp.department_id');
		$this->odb->join('academic_year ay', 'ay.acayea_id = ets.acayea_id');
		$query = $this->odb->get_where('candidate_student cs', array('ets.acayea_id' => $i_academic_year_id));
		return ($query->num_rows() >= 1) ? $query->result() : false;
	}
}
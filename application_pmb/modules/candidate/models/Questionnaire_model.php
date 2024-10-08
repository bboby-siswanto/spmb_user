<?php
class Questionnaire_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function get_question_sections($i_section_id = false)
	{
		if($i_section_id){
			$this->db->where('rqs.question_section_id', $i_section_id);
		}
		$query = $this->db->get('ref_question_sections rqs');
		return ($query->num_rows() >= 2) ? $query->result() : (($query->num_rows() == 1) ? $query->first_row() : false);
	}
	
	public function get_questions_by_section_id($i_section_id)
	{
		$this->db->join('ref_questions rq', 'rq.question_id = dqsg.question_id');
		$query = $this->db->get_where('dt_question_section_group dqsg', array('dqsg.question_section_id' => $i_section_id));
		return ($query->num_rows() >= 1) ? $query->result() : false;
	}
}
<?php
class Entrance_test_model extends App_core
{
    function __construct()
    {
        parent::__construct();
    }

    public function update_time($s_exam_candidate_id, $end_time_exam)
    {
        $start_date = date('Y-m-d H:i:s');
        $date = date('Y-m-d');
        $hours_date = date('H') + 1;
        $minute_date = date('i');
        $second_date = date('s');
        $end_date = $date.' '.$hours_date.':'.$minute_date.':'.$second_date;
        if ($end_date > $end_time_exam) {
            $end_date = $end_time_exam;
        }
        $this->db->update('dt_exam_candidate', array('start_time' => $start_date, 'end_time' => $end_date, 'total_question' => 90), array('exam_candidate_id' => $s_exam_candidate_id));
        return true;
    }

    public function save_candidate_answer($a_data, $exam_candidate_id)
    {
        $this->db->insert('dt_candidate_answer', $a_data);
        return ($this->db->affected_rows() > 0) ? true : false;
    }

    public function get_candidate_exam($a_clause = false)
    {
        $this->db->from('dt_exam_candidate ec');
        $this->db->join('dt_student st', 'st.student_id = ec.student_id');
        $this->db->join('dt_personal_data pd', 'pd.personal_data_id = st.personal_data_id');
        $this->db->join('dt_exam_period ep', 'ep.exam_id = ec.exam_id');
        if ($a_clause) {
            $this->db->where($a_clause);
        }
        $q = $this->db->get();
        return ($q->num_rows() > 0) ? $q->result() : false;
    }

    public function get_option($a_clause = false)
    {
        $this->db->from('dt_exam_question_option eqo');
        if ($a_clause) {
            $this->db->where($a_clause);
        }
        $this->db->order_by('exam_question_option_number');
        $q = $this->db->get();
        return ($q->num_rows() > 0) ? $q->result() : false;
    }

    public function get_question($a_clause = false)
    {
        $this->db->from('dt_exam_question eq');
        if ($a_clause) {
            $this->db->where($a_clause);
        }
        $this->db->order_by('exam_question_number');
        $q = $this->db->get();
        return ($q->num_rows() > 0) ? $q->result() : false;
    }

    public function save_candidate_exam($a_data, $a_clause = false)
    {
        if ($a_clause) {
            $this->db->update('dt_exam_candidate', $a_data, $a_clause);
            return true;
        }else{
            $this->db->insert('dt_exam_candidate', $a_data);
            return ($this->db->affected_rows() > 0) ? true : false;
        }
    }
}

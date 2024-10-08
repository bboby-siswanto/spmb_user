<?php
class Entrance_test extends App_core
{
    public $data = array(
		'pageTitle' => 'Entrance Test Sign In',
		'pageChildTitle' => '',
		// 'body' => 'profile',
		'parentPage' => null,
		'childPage' => null
    );
    
    function __construct()
    {
        parent::__construct();
        $this->load->model('Entrance_test_model', 'Etm');
        $this->load->model('candidate/Profiles');
    }

    public function check_in($s_token = false)
    {
        $s_personal_data_id = $this->session->userdata('personal_data_id');
        if ($this->input->is_ajax_request()) {
            $student_data = $this->Profiles->get_personal_data_student(array('st.personal_data_id' => $s_personal_data_id))[0];
            $s_token = $this->input->post('token');
            $mbo_exam_candidate = $this->Etm->get_candidate_exam(array('ec.student_id' => $student_data->student_id, 'ec.token' => $s_token))[0];
            // var_dump($mbo_exam_candidate);exit;
            if ($mbo_exam_candidate->candidate_exam_status == 'FINISH') {
                $a_return = array('code' => 1, 'message' => 'You have already answered this online entrance test !');
            }else if ($mbo_exam_candidate->candidate_exam_status == 'CANCEL') {
                $a_return = array('code' => 1, 'message' => 'your token is canceled!');
            }else if ($mbo_exam_candidate) {
                $a_return = array('code' => 0, 'message' => 'success');
            }else{
                $a_return = array('code' => 1, 'message' => 'your token is wrong!');
            }

            print json_encode($a_return);
        }else{
            $mbo_personal_data = $this->Profiles->get_personal_data($s_personal_data_id);
            $this->data['personal_data'] = $mbo_personal_data;
            $this->data['body'] = $this->load->view('form/form_check_in', $this->data, true);
		    $this->load->view('layout', $this->data);
        }
    }

    public function show_section_2()
    {
        $a_question_id = array();
        $mbo_question_section_2A = $this->Etm->get_question(array('exam_question_section' => 2, 'exam_question_number <=' => '15'));
        if ($mbo_question_section_2A) {
            foreach ($mbo_question_section_2A as $q_2A) {
                array_push($a_question_id, $q_2A->exam_question_id);
                $a_option_A = array();
                $mba_option_A = $this->Etm->get_option(array('exam_question_id' => $q_2A->exam_question_id));
                if ($mba_option_A) {
                    foreach ($mba_option_A as $opt_A) {
                        array_push($a_option_A, array(
                            'question_option_id' => $opt_A->question_option_id,
                            'exam_question_option_number' => $opt_A->exam_question_option_number,
                            'question_option_description' => $opt_A->question_option_description
                        ));
                    }
                }
                $q_2A->option = $a_option_A;
            }
        }

        $mbo_question_section_2B = $this->Etm->get_question(array('exam_question_section' => 2, 'exam_question_number >' => '15'));
        if ($mbo_question_section_2B) {
            foreach ($mbo_question_section_2B as $q_2B) {
                array_push($a_question_id, $q_2B->exam_question_id);
                $a_option_B = array();
                $mba_option_B = $this->Etm->get_option(array('exam_question_id' => $q_2B->exam_question_id));
                if ($mba_option_B) {
                    foreach ($mba_option_B as $opt_B) {
                        array_push($a_option_B, array(
                            'question_option_id' => $opt_B->question_option_id,
                            'exam_question_option_number' => $opt_B->exam_question_option_number,
                            'question_option_description' => $opt_B->question_option_description
                        ));
                    }
                }
                $q_2B->option = $a_option_B;
            }
        }
        $this->data['section_2A'] = $mbo_question_section_2A;
        $this->data['section_2B'] = $mbo_question_section_2B;
        $this->data['question_section_id'] = $a_question_id;
        $this->load->view('section/section2', $this->data);
    }

    public function test()
    {
        var_dump($this->session->userdata('name'));
    }

    public function show_section_1()
    {
        $a_question_id = array();
        $a_question_section_1 = array();
        $mbo_question_section_1 = $this->Etm->get_question(array('exam_question_section' => 1));
        if ($mbo_question_section_1) {
            foreach ($mbo_question_section_1 as $q_1) {
                array_push($a_question_id, $q_1->exam_question_id);
                $a_option = array();
                $mba_option = $this->Etm->get_option(array('exam_question_id' => $q_1->exam_question_id));
                if ($mba_option) {
                    foreach ($mba_option as $opt) {
                        array_push($a_option, array(
                            'question_option_id' => $opt->question_option_id,
                            'exam_question_option_number' => $opt->exam_question_option_number,
                            'question_option_description' => $opt->question_option_description
                        ));
                    }
                }
                $q_1->option = $a_option;
            }
        }
        // print('<pre>');
        // var_dump($mbo_question_section_1);exit;
        $this->data['section_1'] = $mbo_question_section_1;
        $this->data['question_section_id'] = $a_question_id;
        $this->load->view('section/section1', $this->data);
    }

    public function submit_answer()
    {
        if ($this->input->is_ajax_request()) {
            $a_answer = $this->input->post('answer');
            $s_token = $this->input->post('token');

            $s_personal_data_id = $this->session->userdata('personal_data_id');
            $student_data = $this->Profiles->get_personal_data_student(array('st.personal_data_id' => $s_personal_data_id))[0];
            $mbo_exam_candidate = $this->Etm->get_candidate_exam(array('ec.student_id' => $student_data->student_id, 'ec.token' => $s_token))[0];

            $a_data = array();
            $i_counter_correct = 0;
            $i_counter_wrong = 0;
            $this->db->trans_start();
            if (count($a_answer) > 0) {
                $q1 = $this->db->get_where('dt_candidate_answer', array('exam_candidate_id' => $mbo_exam_candidate->exam_candidate_id));
                if ($q1->num_rows() > 0) {
                    $del = $this->db->delete('dt_candidate_answer', array('exam_candidate_id' => $mbo_exam_candidate->exam_candidate_id));
                }
                foreach ($a_answer as $answer) {
                    $check_answer = $this->Etm->get_option(array('question_option_id' => $answer['question_option_id']))[0];
                    if ($check_answer->option_this_answer == 'TRUE') {
                        $i_counter_correct++;
                    }else{
                        $i_counter_wrong++;
                    }
                    $data_save = array(
                        'exam_candidate_id' => $mbo_exam_candidate->exam_candidate_id,
                        'exam_question_id' => $answer['question_id'],
                        'question_option_id' => $answer['question_option_id'],
                        'date_added' => date('Y-m-d H:i:s')
                    );

                    $this->Etm->save_candidate_answer($data_save, $mbo_exam_candidate->exam_candidate_id);
                }
            }

            $start_time = date_create($mbo_exam_candidate->start_time);
            $now = date_create();
            $total_time = date_diff($start_time, $now);
            $s_total_time = $total_time->h.':'.$total_time->i.':'.$total_time->s;
            $a_candidate_update_data = array(
                'total_time' => $s_total_time,
                'correct_answer' => $i_counter_correct,
                'wrong_answer' => $i_counter_wrong,
                'filled_question' => count($a_answer),
                'candidate_exam_status' => 'FINISH'
            );

            $this->Etm->save_candidate_exam($a_candidate_update_data, array('exam_candidate_id' => $mbo_exam_candidate->exam_candidate_id));

            if ($this->db->trans_status() === false) {
                $this->db->trans_rollback();
                $a_return = array('code' => 1, 'message' => 'Error submit your answer!');
            }else{
                $this->db->trans_commit();
                $a_return = array('code' => 0, 'message' => 'Success');
            }
            // var_dump($s_total_time);
            print json_encode($a_return);
        }
    }

    public function exam($s_token)
    {
        $s_personal_data_id = $this->session->userdata('personal_data_id');
        $student_data = $this->Profiles->get_personal_data_student(array('st.personal_data_id' => $s_personal_data_id))[0];
        $mbo_exam_candidate = $this->Etm->get_candidate_exam(array('ec.student_id' => $student_data->student_id, 'ec.token' => $s_token));
        if ($mbo_exam_candidate) {
            if (is_null($mbo_exam_candidate[0]->start_time)) {
                $this->Etm->update_time($mbo_exam_candidate[0]->exam_candidate_id, $mbo_exam_candidate[0]->exam_end_time);
                $mbo_exam_candidate = $this->Etm->get_candidate_exam(array('ec.student_id' => $student_data->student_id, 'ec.token' => $s_token));
            }
            $this->data['candidate_data'] = $mbo_exam_candidate[0];
            $this->data['token'] = $s_token;
            $this->load->view('entrance_test_layout', $this->data);
        }else{
            $url = base_url().'exam/entrance_test/check_in';
            print('<script>alert("Your token is wrong"); window.location.href="'.$url.'";</script>');
            // redirect('');
        }
    }
}

<?php
class Questionnaire extends App_core
{
	public $a_api_data = array();
    public $data = array(
		'pageTitle' => 'Academic History',
		'pageChildTitle' => 'Academic History',
		'body' => 'education',
		'parentPage' => null,
		'childPage' => null
    );
    
    public function __construct()
	{
		parent::__construct();
		$this->load->model('Protects');
		$this->load->model('Questionnaire_model', 'Qm');
		$this->load->model('candidate/Profiles', 'Pm');
		$this->Protects->from_expired_session();
    }
    
    public function has_questionnaire_answered($s_personal_data_id, $i_section_id)
	{
		// $a_prepare_post_data = array(
		// 	'personal_data_id' => $s_personal_data_id,
		// 	'section_id' => $i_section_id
		// );
		// $hashed_string = $this->libapi->hash_data($a_prepare_post_data, 'PMBAPI', '28af8b90-81e0-11e9-bdfc-5254005d90f6');
		
		// $a_send_post_data = json_encode(array(
		// 	'access_token' => 'PMBIULIACID',
		// 	'data' => $hashed_string
		// ));
		
		// $url = $this->s_portal_url.'admission/api/has_completed_questionnaire';
		// $a_result = $this->libapi->post_data($url, $a_send_post_data);
		// return $a_result->code;
		return 1;
	}
    
    public function load_questionnaire_modal($i_section_id)
    {
	    $this->data['questionnaire_answered'] = $this->has_questionnaire_answered(
	    	 $this->session->userdata('personal_data_id'), 
	    	$i_section_id
	    );
		$this->data['question_master'] = $this->Qm->get_question_sections($i_section_id);
		
		// if ($this->session->userdata('personal_data_id') == '2c088deb-9143-4153-bdd7-7f6661fa8696') {
			if ($this->data['questionnaire_answered'] == 1) {
				$this->load->view('modal_questionnaire', $this->data);
			}
		// }
    }
    
    public function submit_questionnaire()
    {
	    if($this->input->is_ajax_request()){
			$this->load->model('registration/Students', 'Students');
			$this->load->model('personal_data/Personal_data_model', 'Personal_data');
			$a_ipwhitelist = $this->config->item('whitelist_ip');
			
		    $i_section_id = $this->input->post('question_section_id');
		    $a_answers = $this->input->post('answers');
			if (!is_array($a_answers)) {
				$a_answers = [
					$a_answers => ['value' => 'on']
				];
			}
			
			// print('<pre>');var_dump($a_answers);exit;

			if (!in_array($_SERVER['REMOTE_ADDR'], $a_ipwhitelist)) {
				$o_student_data = $this->Students->get_student_by_id($this->session->userdata('student_id'));
				$o_personal_data = $this->Personal_data->get_personal_data_by_id($o_student_data->personal_data_id);
				$o_family_data = $this->Personal_data->get_family_by_personal_data_id($o_student_data->personal_data_id);
				
				$a_prepare_answers = array();
			
				foreach($a_answers as $key => $answer){
					if(isset($answer['value'])){
						$a_answer_item = array(
							'question_id' => $key,
							'answer' => null
						);
						
						if((isset($answer['specify'])) AND ($answer['specify'] != '')){
							$a_answer_item['answer'] = $answer['specify'];
						}
						
						array_push($a_prepare_answers, $a_answer_item);
					}
				}
				
				if(count($a_prepare_answers) >= 1){
					$a_prepare_post_data = array(
						'personal_data_id' => $this->session->userdata('personal_data_id'),
						'personal_data' => $o_personal_data,
						'student_data' => $o_student_data,
						'family_data' => $o_family_data,
						'section_id' => $i_section_id,
						'answers' => $a_prepare_answers
					);
					$hashed_string = $this->libapi->hash_data($a_prepare_post_data, 'PMBIULIACID', '28af8b90-81e0-11e9-bdfc-5254005d90f6');
					
					$a_send_post_data = json_encode(array(
						'access_token' => 'PMBIULIACID',
						'data' => $hashed_string
					));
		
					$url = $this->s_portal_url.'admission/api/handle_questionnaire';
					$a_result = $this->libapi->post_data($url, $a_send_post_data);
				}
				else{
					$a_result = array('code' => 1, 'message' => 'Please fill out the form.');
				}
			}
			else {
				$a_result = array('code' => 0, 'message' => 'Please use other network');
			}
			
			print json_encode($a_result);
			exit;
	    }
    }

	public function view_question($i_section_id)
	{
		$questions = $this->Qm->get_questions_by_section_id($i_section_id);
		print('<pre>');var_dump($questions);exit;
	}
	
	public function load_section($i_section_id, $b_load_layout = false)
	{
		$this->data['questions'] = $this->Qm->get_questions_by_section_id($i_section_id);
		if($b_load_layout){
			$this->data['body'] = $this->load->view('questionnaire_container', $this->data, true);
			$this->load->view('layout', $this->data);
		}
		else{
			$this->load->view('questionnaire_container', $this->data);
		}
	}
}
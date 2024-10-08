<?php
class Employment extends App_core
{
  public $a_api_data = array();
  public $data = array(
    'pageTitle' => 'Employment Data',
    'pageChildTitle' => 'Employment Data',
    'body' => 'employment',
    'parentPage' => null,
    'childPage' => null
  );

  function __construct()
  {
    parent::__construct();
    $this->load->model('Protects');
    $this->load->model('General_model', 'Gm');
    $this->load->model('Profiles', 'Pm');
    $this->load->model('Academics', 'Am');
    $this->load->model('Employment_model', 'Em');
    $this->Protects->from_expired_session();
  }

  public function index()
  {
    $this->load->model('candidate/Profiles', 'Profiles');
    $o_personal_data = $this->Profiles->get_personal_data($this->session->userdata('personal_data_id'));
    if(is_null($o_personal_data->has_completed_school_data)){
      redirect(site_url('candidate/education'));
    }

    $this->data['employment_data'] = $this->Em->get_student_background([
      'ahs.personal_data_id' => $this->session->userdata('personal_data_id'),
      'ins.institution_type' => 'office'
    ]);
    $this->data['country_list'] = $this->Gm->get_where('ref_country');
    $this->data['body'] = $this->load->view('employment', $this->data, true);
    $this->load->view('layout', $this->data);
  }

  public function submit_employment($s_academic_history_id = false)
  {
    $this->data['pageTitle'] = ($s_academic_history_id) ? 'Update Employment Data' : 'New Employment Data';
    $this->data['employment_data'] = ($s_academic_history_id) ? $this->Em->get_student_background(['ahs.academic_history_id' => $s_academic_history_id]) : false;
    $this->data['country_list'] = $this->Gm->get_where('ref_country');
    $this->data['body'] = $this->load->view('submit_employment', $this->data, true);
    $this->load->view('layout', $this->data);
  }

  public function submit_job_data()
  {
    if ($this->input->is_ajax_request()) {
      // print json_encode($this->session->userdata());exit;
      $post = $this->input->post();
      $s_personal_data_id = $this->session->userdata('personal_data_id');
      $s_academic_history_id = $this->input->post('history_id');
      $a_ipwhitelist = $this->config->item('whitelist_ip');
      // print('<pre>');var_dump($s_personal_data_id);exit;

      $this->form_validation->set_rules('employment_job_title', 'Job Title', 'trim|required');
      $this->form_validation->set_rules('employment_company_addess', 'Address', 'trim|required');
      $this->form_validation->set_rules('employment_company_name', 'Company Name', 'trim|required');
      $this->form_validation->set_rules('employment_company_email', 'Company Email', 'trim|required');
      $this->form_validation->set_rules('employment_company_phone', 'Company Phone Number', 'trim|required');
      $this->form_validation->set_rules('employment_company_country', 'Company Country', 'trim|required');
      $this->form_validation->set_rules('employment_company_city', 'Company City', 'trim|required');
      $this->form_validation->set_rules('employment_start_date', 'Start Working Date', 'trim|required');
      // $this->form_validation->set_rules('employment_job_title', 'End Working Date', 'trim|required');
      $this->form_validation->set_rules('string_still_working', 'Working End', 'trim|required');
      if ($post['string_still_working'] == 'no') {
        $this->form_validation->set_rules('employment_end_date', 'Working End', 'trim|required');
      }

      // masih dikerjain
      if($this->form_validation->run()) {
        $mba_occupation_data = $this->Em->occupation_suggestions(set_value('employment_job_title'), true, false);
        if ($mba_occupation_data) {
          $s_occupation_id = $mba_occupation_data[0]->ocupation_id;
        }
        else {
          $s_occupation_id = $this->uuid->v4();
          $a_ocupation_data = [
            'ocupation_id' => $s_occupation_id,
            'ocupation_name' => set_value('employment_job_title'),
            'date_added' => date('Y-m-d H:i:s')
          ];

          $save_ocupation = $this->Pm->new_occupation($a_ocupation_data);
          // print('<pre>');var_dump($save_ocupation);exit;
          if (!$save_ocupation) {
            $s_occupation_id = NULL;
          }
        }
        
        $institution_data = $this->Em->institution_suggestions(set_value('employment_company_name'), 'office', true);
        if ($institution_data) {
          $s_institution_id = $institution_data[0]->institution_id;
          $a_address_data = [
            'country_id' => set_value('employment_company_country'),
            'address_street' => set_value('employment_company_addess'),
            'address_city' => set_value('employment_company_city'),
            'date_added' => date('Y-m-d H:i:s')
          ];

          if (!is_null($institution_data[0]->address_id)) {
            $s_address_id = $institution_data[0]->address_id;
            $save_address = $this->Pm->save_address_data($a_address_data, $s_address_id);
          }
          else {
            $s_address_id = $this->uuid->v4();
            $a_address_data['address_id'] = $s_address_id;
            $save_address = $this->Pm->save_address_data($a_address_data);
          }

          if (!$save_address) {
            $s_address_id = NULL;
          }

          $a_institution_data = [
            'address_id' => $s_address_id,
            'institution_name' => set_value('employment_company_name'),
            'institution_email' => set_value('employment_company_email'),
            'institution_phone_number' => set_value('employment_company_phone'),
            'institution_type' => 'office',
            'date_added' => date('Y-m-d H:i:s')
          ];

          $save_instution = $this->Am->update_institution($a_institution_data, $s_institution_id);
        }
        else {
          $s_institution_id = $this->uuid->v4();
          $s_address_id = $this->uuid->v4();

          $a_address_data = [
            'address_id' => $s_address_id,
            'country_id' => set_value('employment_company_country'),
            'address_city' => set_value('employment_company_city'),
            'date_added' => date('Y-m-d H:i:s')
          ];
          $save_address = $this->Pm->save_address_data($a_address_data);

          if (!$save_address) {
            $s_address_id = NULL;
          }

          $a_institution_data = [
            'instution_id' => $s_institution_id,
            'address_id' => $s_address_id,
            'institution_name' => set_value('employment_company_name'),
            'institution_email' => set_value('employment_company_email'),
            'institution_phone_number' => set_value('employment_company_phone'),
            'institution_type' => 'office',
            'date_added' => date('Y-m-d H:i:s')
          ];
          $save_instution = $this->Am->insert_new_institution($a_institution_data);
        }

        if ($save_instution) {
          $a_academic_history_data = [
            'institution_id' => $s_institution_id,
            'personal_data_id' => $this->session->userdata('personal_data_id'),
            'occupation_id' => $s_occupation_id,
            'academic_year_start_date' => set_value('employment_start_date'),
            'academic_year_end_date' => ($post['string_still_working'] == 'no') ? set_value('employment_end_date') : NULL,
            'date_added' => date('Y-m-d H:i:s')
          ];

          if (!empty($s_academic_history_id)) {
            $save = $this->Pm->save_personal_data_background($a_academic_history_data, $s_academic_history_id);
          }
          else {
            $a_academic_history_data['academic_history_id'] = $this->uuid->v4();
            $save = $this->Pm->save_personal_data_background($a_academic_history_data);
          }
          // print("<pre>");var_dump($save);exit;

          if ($save) {
            $this->Pm->save_personal_data(['has_completed_employment_data' => 0], $this->session->userdata('personal_data_id'));
            $a_return = ['code' => 0, 'message' => 'Success'];
          }
          else {
            $a_return = ['code' => 1, 'message' => 'Failed processing employment data! please try again later'];
          }
        }
        else {
          $a_return = ['code' => 2, 'message' => 'Failed submitting your data! please try again later!'];
        }
      }
      else{
        $a_return = array('code' => 1, 'message' => validation_errors('<li>', '</li>'));
      }

      print json_encode($a_return);exit;
    }
  }

  public function get_institution_suggestions()
  {
    if ($this->input->is_ajax_request()) {
      $s_term = $this->input->post('term');
      $mba_institution_list = $this->Em->institution_suggestions($s_term, 'office', false, true);
      $a_return = array('code' => 0, 'data' => $mba_institution_list);
			print json_encode($a_return);
			exit;
    }
  }

  public function get_occupation_suggestions()
  {
    if ($this->input->is_ajax_request()) {
      $s_term = $this->input->post('term');
      $mba_ocupation_list = $this->Em->occupation_suggestions($s_term, false, true);
      $a_return = array('code' => 0, 'data' => $mba_ocupation_list);
			print json_encode($a_return);
			exit;
    }
  }
}

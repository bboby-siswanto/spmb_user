<?php
class Supporting_document extends App_core
{
  public $a_api_data = array();
  public $data = array(
    'pageTitle' => 'Supporting Document',
    'pageChildTitle' => 'Please Upload All Suporting Document',
    'body' => 'supporting_document',
    'parentPage' => null,
    'childPage' => null
  );
  
  public function __construct()
  {
    parent::__construct();
    $this->load->model('Protects');
		$this->Protects->from_expired_session();
  }

  public function get_required_document_student()
  {
    $this->load->model('candidate/Academics');
    $this->load->model('candidate/Profiles');

    $s_student_id = $this->session->userdata('student_id');
    $mbo_student_data = $this->Academics->get_student_data($s_student_id);
    $a_type_required = array('non_un', 'un');

    if ($mbo_student_data) {
      if ($mbo_student_data->student_type == 'regular') {
        array_push($a_type_required, 'general');
      }

      if ($mbo_student_data->student_type == 'transfer') {
        array_push($a_type_required, 'transfer_student');
      }

      // if ($mbo_student_data->student_un_status == 'yes') {
      //   array_push($a_type_required, 'non_un');
      //   array_push($a_type_required, 'un');
      // }

      // if ($mbo_student_data->student_un_status == 'no') {
      //   array_push($a_type_required, 'non_un');
      //   array_push($a_type_required, 'un');
      // }

      if ($mbo_student_data->institution_is_international == 'yes') {
        array_push($a_type_required, 'international_school');
      }

      $mbo_document_require = $this->Academics->get_document_type_require($a_type_required);
    }else{
      $mbo_document_require = $this->Academics->get_document_type_require();
    }

    return $mbo_document_require;
  }

  public function index()
  {
    $this->load->model('candidate/Academics');
    $this->load->model('candidate/Profiles');

    $s_student_id = $this->session->userdata('student_id');
    $mbo_student_data = $this->Academics->get_student_data($s_student_id);
    $mbo_student_document_uploaded = $this->Academics->get_student_document_uploaded($s_student_id);
    // $a_type_required = array();
    $a_type_required = array('non_un', 'un');

    if ($mbo_student_data) {
      // if ($mbo_student_data->student_type != 'transfer') {
        array_push($a_type_required, 'general');
      // }else{
      //   array_push($a_type_required, 'transfer_student');
      // }

      // if ($mbo_student_data->student_type == 'transfer') {
      //   array_push($a_type_required, 'transfer_student');
      // }

      // if ($mbo_student_data->student_un_status == 'yes') {
      //   array_push($a_type_required, 'un');
      // }

      // if ($mbo_student_data->student_un_status == 'no') {
      //   array_push($a_type_required, 'non_un');
      // }

      if ($mbo_student_data->institution_is_international == 'yes') {
        array_push($a_type_required, 'international_school');
      }

      $mbo_document_require = $this->Academics->get_document_type_require($a_type_required);
    }else{
      $mbo_document_require = $this->Academics->get_document_type_require();
    }
    
    $this->data['required_documents'] = $mbo_document_require;
    $this->data['personal_data_documents'] = $mbo_student_document_uploaded;
    $this->data['student_data'] = $mbo_student_data;
    $this->data['personal_data_id'] = $this->session->userdata('personal_data_id');

    $this->data['pageChildTitleDocument'] = 'Uploaded Documents';
    $this->data['body'] = $this->load->view('supporting_document', $this->data, true);
    $this->load->view('layout', $this->data);
  }

  public function testing()
  {
    $this->load->model('candidate/Profiles');

    $s_document_id = '3bb7a8eb-602a-4da5-a134-a12cfca96213';
    $mba_document_data = $this->Profiles->get_document(['rd.document_id' => $s_document_id]);
    print('<pre>');
    var_dump($mba_document_data);
  }

  public function upload_supporting_document()
  {
    if ($this->input->post()) {

      $this->load->model('candidate/Profiles');

      $this->form_validation->set_rules('document_type', 'Document type', 'trim|required');
      $s_personal_data_id = $this->input->post('personal_data_id');
      $a_ipwhitelist = $this->config->item('whitelist_ip');
      
      if($this->form_validation->run()) {
        $document_id = set_value('document_type');

        $directory_file = APPPATH.'uploads/'.$s_personal_data_id.'/';
        if(!file_exists($directory_file)){
          mkdir($directory_file, 0755);
        }
        
        $config['upload_path'] = $directory_file;
        $config['allowed_types'] = 'jpg|jpeg|png|pdf';
        $config['max_size'] = 2048;
        $config['file_ext_tolower'] = TRUE;
        $config['replace'] = TRUE;
        $config['encrypt_name'] = TRUE;

        $this->load->library('upload', $config);
        
        if($this->upload->do_upload('file')){
          $s_filename = $this->upload->data('file_name');
          $personal_data_document = array(
            'personal_data_id' => $s_personal_data_id,
            'document_id' => $document_id,
            'document_requirement_link' => $s_filename,
            'document_mime' => $this->upload->data('file_type')
          );

          $personal_data_document_result = $this->Profiles->get_personal_data_documents($s_personal_data_id, $document_id);
          $s_file_name_exist = null;
          if($personal_data_document_result){
            $s_file_name_exist = $personal_data_document_result[0]->document_requirement_link;
            unlink($directory_file.$s_file_name_exist);
            $b_save_personal_data_document = $this->Profiles->save_personal_data_document($personal_data_document, $s_personal_data_id, $document_id);
          }
          else{
            $personal_data_document['date_added'] = date('Y-m-d H:i:s');
            $b_save_personal_data_document = $this->Profiles->save_personal_data_document($personal_data_document);
          }

          if ($b_save_personal_data_document) {
            $rtn = array('code' => 0, 'message' => 'Upload success');
            $this->prepare_data_api('dt_personal_data_document', array('personal_data_id' => $s_personal_data_id, 'document_id' => $document_id), 'update_document_student');

            if (!in_array($_SERVER['REMOTE_ADDR'], $a_ipwhitelist)) {
              $a_prepare_post_data = array(
                'data_api' => $this->a_api_data
              );
  
              $hashed_string = $this->libapi->hash_data($a_prepare_post_data, 'PMBIULIACID', '28af8b90-81e0-11e9-bdfc-5254005d90f6');
              $a_send_post_data = json_encode(array(
                'access_token' => 'PMBIULIACID',
                'data' => $hashed_string
              ));
  
              $url = $this->s_portal_url.'api_sync/update_from_pmb';
              $a_result = $this->libapi->post_data($url, $a_send_post_data);
              // print('<pre>');
              // var_dump($a_send_post_data);exit;
              
              if ($a_result == null) {
                $b_update_pmb_sync = $this->update_sync_data($a_prepare_post_data, 1);
              }
              else if ($a_result->code != 0) {
                // print('<pre>');var_dump($a_result);exit;
                $b_update_pmb_sync = false;
              }
              else{
                $b_update_pmb_sync = $this->update_sync_data(json_decode(json_encode($a_result->data), true), $a_result->code);
              }
    
              if ($b_update_pmb_sync) {
                $o_document_data = $this->Profiles->get_document(['rd.document_id' => $document_id])[0];
                $s_document_name = $o_document_data->document_name;
                $s_candidate_name = $this->session->userdata('name');
  
                $rtn = array('code' => 0, 'message' => 'Success');
  
                $t_email_body = <<<TEXT
Dear Admission Team,
{$s_candidate_name} has uploaded the document {$s_document_name}

Best Regards,
Admission Team

International University Liaison Indonesia
Associate Tower 7th Floor.
Intermark Indonesia BSD
Jl. Lingkar Timur BSD Serpong
Tangerang Selatan 15310
Phone: +62 (0) 852 123 18000
Email: pmb@iuli.ac.id
TEXT;
  
                $this->email->to(['diah.danuri@iuli.ac.id']);
                $this->email->bcc('budi.siswanto@iuli.ac.id');
  
                $this->email->from('it@iuli.ac.id', 'IULI Admission System');
                $this->email->subject('[ADMISSION] Candidate uploaded document');
                $this->email->message($t_email_body);
  
                $this->email->send();
              }else{
                $rtn = array('code' => 1, 'message' => 'Error uploading your data, please try again later!');
              }
            }
            else {
              $rtn = array('code' => 0, 'message' => 'Success');
            }
          }else{
            $rtn = array('code' => 1, 'message' => 'Error upload');
          }
        }
        else{
          $rtn = array('code' => 1, 'message' => $this->upload->display_errors('<li>', '</li>'));
        }
      }
      else{
				$rtn = array('code' => 1, 'message' => validation_errors('<li>', '</li>'));
			}
			
			print json_encode($rtn);
			exit;
    }
  }

  public function send_document_api($s_personal_data_id = null, $s_filename = null, $s_file_name_o = null)
  {
    $b_stat_exec = false;
    if ($s_personal_data_id != null) {
      $this->load->library('ftp');
      // if ($this->session->userdata('personal_data_id') == '84371843-38d7-459f-b885-57ed82d43249') {
        // $this->load->library('sftp_connection');
      // }
      // else {
      //   $this->load->library('sftp');
      // }
      // $this->load->library('sftp');
      $sftp_config['hostname'] = 'siak.iuli.ac.id';
      $sftp_config['username'] = 'staging';
      $sftp_config['password'] = 'gXp9BjHD';
      $sftp_config['port'] = 7246;
      $sftp_config['debug'] = TRUE;

      $s_links = 'apps/portal2/uploads/'.$s_personal_data_id.'/';
      $directory_from = APPPATH.'uploads/'.$s_personal_data_id.'/'.$s_filename;
      $directory_to = $s_links.$s_filename;

      $this->ftp->connect();
      // $this->sftp_connection->connect($sftp_config);
      if ($s_file_name_o != null) {
        $a_list = $this->ftp->list_files($s_links);
        if (in_array($s_file_name_o, $a_list)) {
          $this->ftp->delete_file($s_links.$s_file_name_o);
        }
      }

      $this->ftp->upload($directory_from, $directory_to, 'binary', 0644);

      $a_list_a = $this->ftp->list_files($s_links);
      if (in_array($s_filename,$a_list_a)) {
        $b_stat_exec = true;
      }else{
        $b_stat_exec = false;
      }

      $this->ftp->close();
    }
    return $b_stat_exec;
  }

  public function update_sync_data($a_api_result, $i_return_code)
	{
		$this->db->trans_start();
		foreach ($a_api_result as $list) {
			if (isset($list['condition']) AND $list['condition'] != null) {
				$b_update_pmb_sync = $this->Profiles->update_portal_sync($i_return_code, $list['table'], $list['condition']);
			}
		}
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return true;
		}
	}

	public function prepare_data_api($s_table_name, $a_condition, $s_title)
	{
		$mbo_data_ = $this->Profiles->get_data_field($s_table_name, $a_condition);
		if ($mbo_data_) {
      $mbo_data_->pmb_sync = '0';
			$this->a_api_data[$s_title] = array(
				'table' => $s_table_name,
				'data' => $mbo_data_,
				'condition' => $a_condition
			);
			if ($s_table_name == 'dt_personal_data') {
				$a_condition_email = array(
					'personal_data_email' => $mbo_data_->personal_data_email
				);
				$this->a_api_data[$s_title]['condition_email'] = $a_condition_email;
			}
		}
	}
}
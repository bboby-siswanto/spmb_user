<?php
class Pmb extends App_core
{
    public $a_api_data = array();
    function __construct()
    {
        parent::__construct();
        $this->load->model('candidate/Profiles','Profiles');
        $this->load->model('candidate/Academics', 'Academics');
    }

    public function sync_to_portal2()
	{
        $mba_student_data = $this->Profiles->get_personal_data_student();
        // $mba_student_data = $this->Profiles->get_personal_data_student(array('st.student_id' => 'd9868ebf-ef1a-4ede-80df-b16ea0df93ee'));
        // print('<pre>');var_dump($mba_student_data);
        // exit;
        $a_document_data = array();
		if ($mba_student_data) {
			foreach ($mba_student_data as $student) {
                // prepare profile  data
                $this->prepare_data_api('dt_personal_data', array('personal_data_id' => $student->personal_data_id), 'dt_personal_data_student_id'.$student->student_id);
                $this->prepare_data_api('dt_student', array('student_id' => $student->student_id), 'dt_student_id'.$student->student_id);
                if (!is_null($student->address_id)) {
                    $this->prepare_data_api('dt_address', array('address_id' => $student->address_id), 'dt_address_student_id'.$student->student_id);
                    $this->prepare_data_api('dt_personal_address', array('personal_data_id' => $student->personal_data_id, 'address_id' => $student->address_id, 'personal_address_type' => 'primary'), 'dt_personal_address_student_id'.$student->student_id);
                }

                //prepare education data
                $mbo_academic_history_student_data = $this->Academics->get_personal_data_background($student->personal_data_id);
                if ($mbo_academic_history_student_data) {
                    if (!is_null($mbo_academic_history_student_data->address_id)) {
                        $this->prepare_data_api('dt_address', array('address_id' => $mbo_academic_history_student_data->address_id), 'institution_address_student_id'.$student->student_id);
                    }
                    if (!is_null($mbo_academic_history_student_data->institution_id)) {
                        $this->prepare_data_api('ref_institution', array('institution_id' => $mbo_academic_history_student_data->institution_id), 'instituion_data_student_id'.$student->student_id);
                    }
                    if (!is_null($mbo_academic_history_student_data->academic_history_id)) {
                        $this->prepare_data_api('dt_academic_history', array('academic_history_id' => $mbo_academic_history_student_data->academic_history_id), 'academic_history_student_id'.$student->student_id);
                    }
                }

                // prepare parent  data
                $mbo_student_family = $this->Profiles->get_family_student($student->personal_data_id);
                if ($mbo_student_family) {
                    $mbo_parent_data = $this->Profiles->get_parent_data($mbo_student_family->family_id);
                    // if ($student->student_id == '2086dbb9-fd52-4979-81d2-23ded80c8e97') {
                    //     print('<pre>');var_dump($mbo_parent_data);exit;
                    // }
                    if ($mbo_parent_data) {
                        if (!is_null($mbo_parent_data->institution_id)) {
                            $this->prepare_data_api('ref_institution', array('institution_id' => $mbo_parent_data->institution_id), 'institution_parent_student_id'.$student->student_id);
                        }
                        if (!is_null($mbo_parent_data->occupation_id)) {
                            $this->prepare_data_api('ref_ocupation', array('ocupation_id' => $mbo_parent_data->occupation_id), 'occupation_parent_student_id'.$student->student_id);
                        }
                        $this->prepare_data_api('dt_personal_data', array('personal_data_id' => $mbo_parent_data->personal_data_id), 'personal_parent_data_student_id'.$student->student_id);
                        if (!is_null($mbo_parent_data->academic_history_id)) {
                            $this->prepare_data_api('dt_academic_history', array('academic_history_id' => $mbo_parent_data->academic_history_id), 'academic_hostory_parent_student_id'.$student->student_id);
                        }
                        $this->prepare_data_api('dt_family', array('family_id' => $mbo_parent_data->family_id), 'family_student_id'.$student->student_id);
                        $this->prepare_data_api('dt_family_member', array('family_id' => $mbo_parent_data->family_id, 'family_member_status' => 'child'), 'family_member_student_student_id'.$student->student_id);
                        $this->prepare_data_api('dt_family_member', array('family_id' => $mbo_parent_data->family_id, 'family_member_status !=' => 'child'), 'family_member_parent_student_id'.$student->student_id);
                    }
                }

                // prepare document data
                $mba_personal_document = $this->Profiles->get_personal_data_documents($student->personal_data_id);
                if ($mba_personal_document) {
                    foreach ($mba_personal_document as $document) {
                        if (!is_null($document->document_id)) {
                            $this->prepare_data_api('dt_personal_data_document', array('personal_data_id' => $student->personal_data_id, 'document_id' => $document->document_id), 'document_id_'.$document->document_id.'_student_id'.$student->student_id);
                            // prepare data ftp
                            array_push($a_document_data, array(
                                'personal_data_id' => $student->personal_data_id,
                                'document_id' => $document->document_id
                            ));
                        }
                    }
                }
			}
        }

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
        
        if ($a_result == null) {
            $b_update_pmb_sync = $this->update_sync_data($a_prepare_post_data, 1);

            print('url : '.$url);
            print('<br><br>');
            var_dump($a_send_post_data);
            print('result is null<br>  Sync  failed');
        }else{
            $b_update_pmb_sync = $this->update_sync_data(json_decode(json_encode($a_result->data), true), $a_result->code);
            $this->send_document($a_document_data);

            print('Sync  success');
        }
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
    
    public function test()
    {
        $s_string = 'personal_parent_data_student_id';
        if (strpos($s_string, 'parent')) {
            var_dump(strpos($s_string, 'parent'));
        }else{
            print('tidak ada');
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
                    'personal_data_email' => $mbo_data_->personal_data_email,
                    'personal_data_marital_status' => (strpos($s_title, 'parent')) ? 'married' : 'single'
				);
				$this->a_api_data[$s_title]['condition_email'] = $a_condition_email;
			}
		}
    }

    public function sync_document($s_personal_data_id = false)
    {
        $start = strtotime("now");
        print('<h4>Sync document from pmb</h4>');
        $i_count = 0;$i_success = 0;
        print('Processing <span id="count">'.$i_count."</span> document");
        if ($s_personal_data_id) {
            $mba_student_document = $this->Profiles->get_student_document(array('pdd.personal_data_id' => $s_personal_data_id));
        }else{
            $mba_student_document = $this->Profiles->get_student_document();
        }
        if ($mba_student_document) {
            $config['hostname'] = 'staging.iuli.ac.id';
            $config['username'] = 'staging';
            $config['password'] = 'gXp9BjHD';
            $config['debug']    = TRUE;

            $s_path_from = APPPATH.'uploads/';
            $s_path_target = 'apps/portal2/uploads/';
            $this->load->library('ftp');
            $this->ftp->connect($config);

            print('<br>');print('<pre>');
            foreach ($mba_student_document as $document) {
                $s_filepath = $document->personal_data_id.'/'.$document->document_requirement_link;
                $b_dir = is_dir($s_path_from.$document->personal_data_id.'/');
                $a_list_target = $this->ftp->list_files($s_path_target.$document->personal_data_id.'/');
                if (!in_array($document->document_requirement_link, $a_list_target)) {
                    if ($b_dir) {
                        if ($a_list_target) {
                            print($s_path_from.$s_filepath);print('<br>');
                            $this->ftp->upload($s_path_from.$s_filepath, $s_path_target.$s_filepath, 'binary', 0644);
                            echo '<script>document.getElementById("test").innerHTML = "'.$i_count.'";</script>';
                            $i_count++;
                        }
                    }
                }

                if (in_array($document->document_requirement_link, $a_list_target)) {
                    $i_success++;
                }
            }

            $this->ftp->close();
        }

        $end = strtotime("now");
        $interval = $end - $start;
        $seconds = $interval % 60;
        $minutes = floor(($interval % 3600) / 60);
        $hours = floor($interval / 3600);
        echo "total time: ".$hours.":".$minutes.":".$seconds;
        print("<p>Success syncronize ".$i_success." document</p>");
    }

    public function test_document()
    {
        $config['hostname'] = 'staging.iuli.ac.id';
        $config['username'] = 'staging';
        $config['password'] = 'gXp9BjHD';
        // $config['hostname'] = 'staging.iuli.ac.id';
        // $config['username'] = 'staging';
        // $config['password'] = 'gXp9BjHD';
        // $config['debug']    = TRUE;
        $this->load->library('ftp');
        $this->ftp->connect($config);
        $s_links = 'apps/portal2/uploads/90da1c68-d6da-43b7-835a-499b5e4cefb5/';
        $s_path_from = APPPATH.'uploads/90da1c68-d6da-43b7-835a-499b5e4cefb5/';
        $s_path_now = scandir($s_path_from);
        // $a_list = $this->ftp->list_files($s_path_from);
        // $this->ftp->close();
        print('<pre>');
        // var_dump($s_path_now);exit;
        if ($s_path_now) {
            foreach ($s_path_now as $path) {
                if (is_file($path)) {
                    print('ini file');
                }
                // if (($path != '.') OR ($path != '..') OR ($path != '...')) {
                //     print('ini file');
                // }
                print('<br>');
            }
        }
    }

    public function send_document($a_personal_document_data)
    {
        if (count($a_personal_document_data) > 0) {
            $this->load->library('ftp');
            
            $this->ftp->connect();
            foreach ($a_personal_document_data as $data) {
                $mbo_personal_document_data = $this->Profiles->get_personal_data_documents($data['personal_data_id'], $data['document_id'])[0];
                if ($mbo_personal_document_data) {
                    $s_filename = $mbo_personal_document_data->document_requirement_link;
                    $s_links = 'apps/portal2/uploads/'.$data['personal_data_id'].'/';
                    $directory_from = APPPATH.'uploads/'.$data['personal_data_id'].'/'.$s_filename;
                    $directory_to = $s_links.$s_filename;

                    $a_list = $this->ftp->list_files($s_links);
                    if (!in_array($s_filename, $a_list)) {
                        $this->ftp->upload($directory_from, $directory_to, 'binary', 0644);
                    }
                }
            }

            $this->ftp->close();
        }
    }
    
    public function send_document_api($a_personal_data)
    {
        $b_stat_exec = false;
        if ($s_personal_data_id != null) {
            $this->load->library('ftp');

            $s_links = 'apps/portal2/uploads/'.$s_personal_data_id.'/';
            $directory_from = APPPATH.'uploads/'.$s_personal_data_id.'/'.$s_filename;
            $directory_to = $s_links.$s_filename;

            $this->ftp->connect();
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
}

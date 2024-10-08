<?php
class Pmbni_model extends CI_Model
{
    public function __construct()
	{
		parent::__construct();
	}

    function valid_date($date, $format = 'Y-m-d')
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }

    public function validate($a_data)
    {
        if (is_object($a_data)) {
            $a_data = (array) $a_data;
        }

        $a_data_list = $a_data;
        $a_field = $this->get_required_fields();

        $a_required_field = [];
        foreach ($a_field as $key_field => $fields) {
            if ($fields['required']) {
                array_push($a_required_field, $key_field);
            }
        }

        $a_err = [];
        foreach ($a_data_list as $a_data) {
            foreach ($a_data as $key => $value) {
                $mba_field_available = $this->get_required_fields($key);

                if ($mba_field_available) {
                    if (($idx = array_search($key, $a_required_field)) !== false) {
                        unset($a_required_field[$idx]);

                        if ($value == '') {
                            array_push($a_err, 'Empty value for field '.$key.'!');
                        }
                    }

                    switch ($mba_field_available['type']) {
                        case 'enum':
                            if (!in_array($value, $mba_field_available['option'])) {
                                array_push($a_err, 'Wrong value for field '.$key.'!');
                            }
                            break;

                        case 'datetime':
                            if (!$this->valid_date($value, 'Y-m-d H:i:s')) {
                                array_push($a_err, ' invalid datetime format for field '.$key);
                            }
                            break;

                        case 'date':
                            if (!$this->valid_date($value)) {
                                array_push($a_err, 'invalid date format for field '.$key);
                            }
                            break;
                        
                        default:
                            if (strlen(trim($value)) > $mba_field_available['max_length']) {
                                array_push($a_err, 'size of field '.$key.' is too large!');
                            }

                            if ($key == 'Email') {
                                if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                                    array_push($a_err, 'invalid email for field '.$key);
                                }
                            }

                            break;
                    }
                }else{
                    array_push($a_err, 'Invalid field '.$key.'!');
                }
                
            }
        }

        if (count($a_required_field) > 0) {
            array_push($a_err, "Fields ".implode(', ', $a_required_field)." is required");
        }

        if (count($a_err) > 0) {
            $a_err = array_values($a_err);
            $a_return = ['code' => 1, 'a_message' => $a_err];
        }else{
            $a_return = ['code' => 0];
        }

        return $a_return;
        
    }

    public function sync_document($s_personal_data_id, $s_applicant_id, $s_api_mode = 'portal')
    {
        $s_pmbni_path = APPPATH.'../../../pmbni/htdocs/uploads/'.$s_applicant_id.'/';
        $s_portal_path = APPPATH.'uploads/'.$s_personal_data_id.'/';
        $a_error = array();

        if (is_dir($s_pmbni_path)) {
            $a_file_copy = [];
			$a_doc_list = $this->_doc_translate();

            if(!file_exists($s_portal_path)){
                mkdir($s_portal_path, 0755);
            }

            if (count($a_doc_list) > 0) {
                if ($dh = opendir($s_pmbni_path)) {
                    while (($s_file = readdir($dh)) !== false){

                        if (($s_file != '.') AND ($s_file != '..')) {
                            $a_file = explode('.', $s_file);
                            $s_filename = $a_file[0];

                            if (!in_array($s_filename, $a_file_copy)) {
                                array_push($a_file_copy, $s_filename);
                                $a_my_data = $this->_doc_translate($s_filename);

                                if (copy($s_pmbni_path.$s_file, $s_portal_path.$s_file)) {
                                    if ($a_my_data) {
                                        $q_check_doc = $this->db->get_where('dt_personal_data_document', [
                                            'personal_data_id' => $s_personal_data_id,
                                            'document_id' => $a_my_data['document_id']
                                        ]);

                                        $s_new_filename = md5($s_pmbni_path.$s_file.date('Y-m-d H:i:s'));
                                        $s_new_file = $s_new_filename.'.'.$a_file[count($a_file) - 1];

                                        rename($s_portal_path.$s_file, $s_portal_path.$s_new_file);
                                        $s_file_name_exist = null;

                                        if ($q_check_doc->num_rows() > 0) {
                                            $o_list_doc_exist = $q_check_doc->first_row();
                                            $s_file_name_exist = $o_list_doc_exist->document_requirement_link;

                                            if (file_exists($s_portal_path.$o_list_doc_exist->document_requirement_link)) {
                                                unlink($s_portal_path.$o_list_doc_exist->document_requirement_link);
                                            }
                                            
                                            $this->db->update('dt_personal_data_document', [
                                                'personal_data_id' => $s_personal_data_id,
                                                'document_id' => $a_my_data['document_id'],
                                                'document_requirement_link' => $s_new_file,
                                                'document_mime' => mime_content_type($s_pmbni_path.$s_file)
                                            ], [
                                                'personal_data_id' => $s_personal_data_id,
                                                'document_id' => $a_my_data['document_id']
                                            ]);
                                        }else{
                                            $this->db->insert('dt_personal_data_document', [
                                                'personal_data_id' => $s_personal_data_id,
                                                'document_id' => $a_my_data['document_id'],
                                                'document_requirement_link' => $s_new_file,
                                                'document_mime' => mime_content_type($s_pmbni_path.$s_file),
                                                'date_added' => date('Y-m-d H:i:s')
                                            ]);
                                        }

                                        $this->send_document_api($s_personal_data_id, $s_new_file, $s_file_name_exist, $s_api_mode);
                                    }
                                }else{
                                    array_push($a_error, 'failed get file '.$s_file);
                                }

                            }
                        }
                        
                    }

                    closedir($dh);
                }
            }
		}

        if (count($a_error) > 0) {
            $a_return = ['code' => 1, 'a_message' => $a_error];
        }else{
            $a_return = ['code' => 0];
        }
    }

    public function send_document_api($s_personal_data_id = null, $s_filename = null, $s_file_name_o = null, $s_api_mode)
    {
        $b_stat_exec = false;
        if ($s_personal_data_id != null) {

            $this->load->library('ftp');
            
            if ($s_api_mode == 'portal') {
                $s_links = 'apps/portal2/uploads/'.$s_personal_data_id.'/';
                $a_config = [
                    'hostname' => 'staging.iuli.ac.id',
                    'username' => 'staging',
                    'password' => 'gXp9BjHD',
                    'debug' => TRUE,
                ];
            }else{
                $s_links = 'apps/siakad_development/uploads/'.$s_personal_data_id.'/';
                $a_config = [
                    'hostname' => 'siakdev.iuli.ac.id',
                    'username' => 'siakdev',
                    'password' => 'YmQyNDkwZjQzMjk',
                    'debug' => TRUE,
                ];
            }

            $directory_from = APPPATH.'uploads/'.$s_personal_data_id.'/'.$s_filename;
            $directory_to = $s_links.$s_filename;

            $this->ftp->connect($a_config);
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

    private function _doc_translate($s_filename = false)
    {
        $a_doc = [
            'SELFIE' => [
                'document_id' => '0bde3152-5442-467a-b080-3bb0088f6bac',
                'document_name' => 'Foto'
            ],
            'REPORT' => [
                'document_id' => '3b920f1c-2ebd-403d-abc1-eedf783bde26',
                'document_name' => 'Rapor'
            ],
            'IDCARD' => [
                'document_id' => 'a3b0c5b6-85cf-4a7c-b4fa-70d239046a05',
                'document_name' => 'KTP/Paspor'
            ]
        ];

        if ($s_filename) {
            if (array_key_exists($s_filename, $a_doc)) {
                return $a_doc[$s_filename];
            }else{
                return false;
            }
        }else{
            return $a_doc;
        }
    }

    public function get_required_fields($s_key = false)
    {
        $a_field = [
            'ApplicantID' => [
                'portal_name' => 'student_id',
                'type' => 'string',
                'max_length' => 50,
                'required' => true
            ],
            'Email' => [
                'portal_name' => 'personal_data_email',
                'type' => 'string',
                'max_length' => 100,
                'required' => true
            ],
            'Name' => [
                'portal_name' => 'personal_data_name',
                'type' => 'string',
                'max_length' => 100,
                'required' => true
            ],
            'Phone' => [
                'portal_name' => 'personal_data_cellular',
                'type' => 'string',
                'max_length' => 19,
                'required' => true
            ],
            'BirthPlace' => [
                'portal_name' => 'personal_data_place_of_birth',
                'type' => 'string',
                'max_length' => 50,
                'required' => false
            ],
            'Birthdate' => [
                'portal_name' => 'personal_data_date_of_birth',
                'type' => 'date',
                'max_length' => 0,
                'required' => false
            ],
            'StudyProgram' => [
                'portal_name' => 'study_program_abbreviation',
                'type' => 'string',
                'max_length' => 3,
                'required' => true
            ],
            'StudyProgram2' => [
                'portal_name' => 'study_program_abbreviation',
                'type' => 'string',
                'max_length' => 3,
                'required' => false
            ],
            'SchoolName' => [
                'portal_name' => 'institution_name',
                'type' => 'string',
                'max_length' => 100,
                'required' => true
            ],
            'GraduateYear' => [
                'portal_name' => 'graduation_year',
                'type' => 'numeric',
                'max_length' => 4,
                'required' => true
            ],
            'CreatedAt' => [
                'portal_name' => 'student_date_enrollment',
                'type' => 'datetime',
                'max_length' => 0,
                'required' => true
            ],
            'UpdatedAt' => [
                'portal_name' => 'timestamp',
                'type' => 'datetime',
                'max_length' => 0,
                'required' => false
            ],
            'Gender' => [
                'portal_name' => 'personal_data_gender',
                'type' => 'enum',
                'option' => ['male', 'female'],
                'max_length' => 0,
                'required' => true
            ],
            'GuardianName' => [
                'portal_name' => 'parent_data_name',
                'type' => 'string',
                'max_length' => 100,
                'required' => true
            ],
            'GuardianEmail' => [
                'portal_name' => 'parent_data_email',
                'type' => 'string',
                'max_length' => 100,
                'required' => true
            ],
            'GuardianPhone' => [
                'portal_name' => 'parent_data_cellular',
                'type' => 'string',
                'max_length' => 19,
                'required' => false
            ],
            'Nationality' => [
                'portal_name' => 'personal_data_nationality',
                'type' => 'enum',
                'option' => ['wni', 'wna'],
                'max_length' => 0,
                'required' => true
            ],
            'SchoolCity' => [
                'portal_name' => 'address_city',
                'type' => 'string',
                'max_length' => 35,
                'required' => false
            ],
            'SchoolReferencePerson' => [
                'portal_name' => 'institution_personal_data_name',
                'type' => 'string',
                'max_length' => 100,
                'required' => false
            ],
            'SchoolReferencePersonContact' => [
                'portal_name' => 'institution_personal_data_cellular',
                'type' => 'string',
                'max_length' => 19,
                'required' => false
            ],
            'SchoolReferencePersonContactEmail' => [
                'portal_name' => 'institution_personal_data_email',
                'type' => 'string',
                'max_length' => 100,
                'required' => false
            ],
            'hasPaid' => [
                'portal_name' => 'has_to_pay_enrollment_fee',
                'type' => 'enum',
                'option' => ['yes', 'no'],
                'max_length' => 0,
                'required' => true
            ],
        ];

        if ($s_key) {
            if (array_key_exists($s_key, $a_field)) {
                return $a_field[$s_key];
            }else{
                return false;
            }
        }else{
            return $a_field;
        }
    }
}
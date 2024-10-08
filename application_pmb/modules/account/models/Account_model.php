<?php
class Account_model extends CI_Model
{
    public $scd = '012';
	public function __construct()
	{
		parent::__construct();
	}

    public function get_study_program($a_clause = false)
	{
        $this->db->select('*');
		$this->db->from('ref_study_program');
		if ($a_clause) {
			$this->db->where($a_clause);
        }
	
        $this->db->where('study_program_is_active', 'yes');
		$this->db->order_by('study_program_gii_name', 'asc');
		$query = $this->db->get();
		return ($query->num_rows() > 0) ? $query->result() : false;
	}

    public function get_parent_student($s_family_id, $a_clause = false)
    {
        $this->db->from('dt_family_member fm');
        $this->db->join('dt_personal_data pd', 'pd.personal_data_id = fm.personal_data_id');
        $this->db->where('fm.family_id', $s_family_id);
        $this->db->where('fm.family_member_status !=', 'child');
        if ($a_clause) {
            $this->db->where($a_clause);
        }
        $query = $this->db->get();
        return ($query->num_rows() > 0) ? $query->result() : false;
    }

    public function get_profile_full($s_student_id, $a_clause = false)
    {
        $this->db->select('st.*, pd.*, fm.*, pa.*, da.*, da.country_id AS "address_country"');
        $this->db->from('dt_student st');
        $this->db->join('dt_personal_data pd', 'pd.personal_data_id = st.personal_data_id');
        $this->db->join('dt_family_member fm', 'fm.personal_data_id = pd.personal_data_id', 'left');
        $this->db->join('dt_personal_address pa', 'pa.personal_data_id = pd.personal_data_id', 'left');
        $this->db->join('dt_address da', 'da.address_id = pa.address_id', 'left');
        $this->db->where('st.student_id', $s_student_id);
        // $this->db->where('ri.institution_type', 'highschool');
        if ($a_clause) {
            $this->db->where($a_clause);
        }

        $query = $this->db->get();
        return ($query->num_rows() > 0) ? $query->first_row() : false;
    }

    public function get_highschools_by_name($s_institution_name, $s_institution_type = 'highschool')
    {
        $this->db->from('ref_institution ri');
        $this->db->join('dt_address da', 'da.address_id = ri.address_id', 'left');
        $this->db->where('ri.institution_type', $s_institution_type);
        $this->db->like('ri.institution_name', $s_institution_name);
        $this->db->limit(10, 0);
        $query = $this->db->get();
        return ($query->num_rows() > 0) ? $query->result() : false;
    }

    public function get_profile_institution($s_personal_data_id, $a_clause = false)
    {
        $this->db->from('dt_academic_history dah');
        $this->db->join('ref_institution ri', 'ri.institution_id = dah.institution_id');
        $this->db->join('dt_address da', 'da.address_id = ri.address_id', 'left');
        $this->db->where('dah.personal_data_id', $s_personal_data_id);
        if ($a_clause) {
            $this->db->where($a_clause);
        }
        $query = $this->db->get();
        return ($query->num_rows() > 0) ? $query->first_row() : false;
    }

    public function submit_educational_data($a_hs_data, $a_univ_data = false)
    {
        $s_academic_history_id = $a_hs_data['academic_history_id'];
        $query_academic_history = $this->db->get_where('dt_academic_history', ['academic_history_id' => $s_academic_history_id]);
        $query_institution = $this->db->get_where('ref_institution', ['institution_name' => $a_hs_data['institution_name']]);

        if ($query_institution->num_rows() > 0) {
            $mba_institution_data = $query_institution->first_row();
            $s_address_id = (is_null($mba_institution_data->address_id)) ? $this->uuid->v4() : $mba_institution_data->address_id;
        }
        else {
            $s_address_id = $this->uuid->v4();
        }

        $a_address_data = [
            'country_id' => $a_hs_data['country_id']
        ];
        
        if ($query_academic_history->num_rows() > 0) {
            # code...
        }
    }

    public function save_academic_history($a_data, $s_academic_history_id = false)
    {
        if ($s_academic_history_id) {
            $this->db->update('dt_academic_history', $a_data, ['academic_history_id' => $s_academic_history_id]);
            return true;
        }
        else {
            $this->db->insert('dt_academic_history', $a_data);
            return ($this->db->affected_rows() > 0) ? true : false;
        }
    }

    public function submit_personal_data($a_personal_data, $a_address_data, $a_student_data)
    {
        $s_personal_data_id = $this->session->userdata('user');
        $s_student_id = $this->session->userdata('st');
        $this->db->trans_begin();

        if ($this->update_personal_data($a_personal_data, $s_personal_data_id)) {
            if ($this->update_student_data($a_student_data, $s_student_id)) {
                if (array_key_exists('address_id', $a_address_data)) {
                    $s_address_id = $a_address_data['address_id'];
                    $mba_personal_address = $this->db->get_where('dt_personal_address', ['personal_data_id' => $s_personal_data_id, 'address_id' => $a_address_data['address_id']]);

                    if ($mba_personal_address->num_rows() > 0) {
                        // update address
                        $this->db->update('dt_address', $a_address_data, ['address_id' => $s_address_id]);
                    }
                    else {
                        // insert new address
                        $this->db->insert('dt_address', $a_address_data);
                        $this->db->insert('dt_personal_address', [
                            'personal_data_id' => $s_personal_data_id,
                            'address_id' => $s_address_id,
                            'personal_address_type' => 'primary',
                            'status' => 'active',
                            'date_added' => date('Y-m-d H:i:s')
                        ]);
                    }
                }
                else {
                    // insert new addres
                    $s_address_id = $this->uuid->v4();
                    $a_address_data['address_id'] = $s_address_id;
                    $this->db->insert('dt_address', $a_address_data);
                    $this->db->insert('dt_personal_address', [
                        'personal_data_id' => $s_personal_data_id,
                        'address_id' => $s_address_id,
                        'personal_address_type' => 'primary',
                        'status' => 'active',
                        'date_added' => date('Y-m-d H:i:s')
                    ]);
                }

                if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                    $a_return = $this->errorlist->get_error($this->scd, '005');
                }
                else {
                    $this->db->trans_commit();
                    $a_return = ['code' => 0, 'message' => 'Success', 'uri' => base_url().'account/data/educational'];
                }
            }
            else {
                $this->db->trans_rollback();
                $a_return = $this->errorlist->get_error($this->scd, '005');
            }
        }
        else {
            $a_return = $this->errorlist->get_error($this->scd, '005');
        }

        return $a_return;
    }

    public function update_personal_data($a_personal_data, $s_personal_data_id)
    {
        if (is_object($a_personal_data)) {
            $a_personal_data = (array)$a_personal_data;
        }

        if (array_key_exists('personal_data_id', $a_personal_data)) {
            $o_account_data = $this->get_account_by_id(false, $s_personal_data_id);
            if (!$o_account_data) {
                return false;
            }

            $directory_file = APPPATH.'uploads/candidate_data/'.$o_account_data->finance_year_id.'/'.$s_personal_data_id;
            $new_directory_file = APPPATH.'uploads/candidate_data/'.$o_account_data->finance_year_id.'/'.$a_personal_data['personal_data_id'];
            if(!file_exists($directory_file.'/')){
                mkdir($new_directory_file.'/', 0755, true);
            }
            else {
                rename($directory_file, $new_directory_file);
            }
        }

        $this->db->update('dt_personal_data', $a_personal_data, ['personal_data_id' => $s_personal_data_id]);
        return true;
    }
    
    public function update_student_data($a_student_data, $s_student_id)
    {
        if (is_object($a_student_data)) {
            $a_student_data = (array)$a_student_data;
        }

        if (array_key_exists('finance_year_id', $a_student_data)) {
            $o_account_data = $this->get_account_by_id($s_student_id);
            if (!$o_account_data) {
                return false;
            }

            $directory_file = APPPATH.'uploads/candidate_data/'.$o_account_data->finance_year_id.'/'.$o_account_data->personal_data_id;
            $new_directory_file = APPPATH.'uploads/candidate_data/'.$a_student_data['finance_year_id'].'/'.$o_account_data->personal_data_id;
            if(!file_exists($directory_file.'/')){
                mkdir($new_directory_file.'/', 0755, true);
            }
            else {
                rename($directory_file, $new_directory_file);
            }
        }

        $this->db->update('dt_student', $a_student_data, ['student_id' => $s_student_id]);
        return true;
    }

    public function get_account_by_email($s_email, $a_clause = false, $a_status_in = false)
    {
        $this->db->from('dt_personal_data pd');
        $this->db->join('dt_student st', 'st.personal_data_id = pd.personal_data_id');
        $this->db->where('pd.personal_data_email', $s_email);
        if ($a_clause) {
            $this->db->where($a_clause);
        }

        if ($a_status_in) {
            $this->db->where_in('st.student_status', $a_status_in);
        }
        
        $query = $this->db->get();
        return ($query->num_rows() > 0) ? $query->first_row() : false;
    }
    
    public function get_account_by_id($s_student_id = false, $s_personal_data_id = false, $a_clause = false)
    {
        if ((!$s_student_id) AND (!$s_personal_data_id)) {
            return false;
        }
        else if ($s_student_id) {
            $this->db->where('st.student_id', $s_student_id);
        }
        else if ($s_personal_data_id) {
            $this->db->where('st.personal_data_id', $s_personal_data_id);
        }
        
        $this->db->from('dt_personal_data pd');
        $this->db->join('dt_student st', 'st.personal_data_id = pd.personal_data_id');
        
        if ($a_clause) {
            $this->db->where($a_clause);
        }
        $query = $this->db->get();
        return ($query->num_rows() > 0) ? $query->first_row() : false;
    }

	public function registration($a_registration_data)
	{
        if (is_object($a_registration_data)) {
            $a_registration_data = (array)$a_registration_data;
        }

        $this->db->trans_begin();

        $s_personal_data_id = $this->uuid->v4();
		$a_personal_data = [
            'personal_data_id' => $s_personal_data_id,
            'personal_data_name' => $a_registration_data['personal_data_name'],
            'personal_data_email' => $a_registration_data['personal_data_email'],
            'personal_data_cellular' => $a_registration_data['personal_data_cellular']
        ];

        $s_student_id = $this->uuid->v4();
        $a_student_data = [
            'student_id' => $s_student_id,
            'personal_data_id' => $s_personal_data_id,
            'academic_year_id' => $a_registration_data['academic_year_id'],
            'finance_year_id' => $a_registration_data['academic_year_id'],
            'student_un_status' => 'no',
            'study_program_id' => $a_registration_data['study_program_id'],
            'student_date_enrollment' => date('Y-m-d H:i:s')
        ];

        $insert_personal_data = $this->db->insert('dt_personal_data', $a_personal_data);
        if ($this->db->affected_rows() > 0) {
            $insert_student_data = $this->db->insert('dt_student', $a_student_data);
            if ($insert_student_data) {
                $directory_file = APPPATH.'uploads/candidate_data/'.$a_registration_data['academic_year_id'].'/'.$s_personal_data_id.'/';
                if(!file_exists($directory_file)){
                    mkdir($directory_file, 0755, true);
				}

                if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                    $a_return = $this->errorlist->get_error($this->scd, '005');
                }
                else {
                    $this->db->trans_commit();
                    $a_return = ['code' => 0, 'message' => 'Success'];
                }
            }
            else {
                $this->db->trans_rollback();
                $a_return = $this->errorlist->get_error($this->scd, '005');
            }
        }
        else {
            $this->db->trans_rollback();
            $a_return = $this->errorlist->get_error($this->scd, '005');
        }

        return $a_return;
	}
	
}
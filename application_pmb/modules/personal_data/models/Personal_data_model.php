<?php
class Personal_data_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function get_personal_data_by_id($s_personal_data_id)
	{
		$query = $this->db->get_where('dt_personal_data', array('personal_data_id' => $s_personal_data_id));
		return ($query->num_rows() == 1) ? $query->first_row() : false;
	}
	
	public function get_family_by_personal_data_id($s_personal_data_id)
	{
		$query = $this->db->get_where('dt_family_member', array('personal_data_id' => $s_personal_data_id));
		return ($query->num_rows() == 1) ? $query->first_row() : false;
	}
	
	public function add_family_member($a_family_member_data)
	{
		$this->db->insert('dt_family_member', $a_family_member_data);
	}
	
	public function create_family($a_family_data = null)
	{
		if(!is_null($a_family_data)){
			if(is_object($a_family_data)){
				$a_family_data = (array)$a_family_data;
			}
			
			if(!array_key_exists('family_id', $a_family_data)){
				$a_family_data['family_id'] = $this->uuid->v4();
			}
		}
		else{
			$a_family_data = array(
				'family_id' => $this->uuid->v4(),
				'date_added' => date('Y-m-d H:i:s')
			);
		}
		
		$this->db->insert('dt_family', $a_family_data);
		
		return $a_family_data['family_id'];
	}
	
	public function update_personal_data($a_personal_data, $s_personal_data_id)
	{
		$this->db->update('dt_personal_data', $a_personal_data, array('personal_data_id' => $s_personal_data_id));
	}
	
	public function create_new_personal_data($a_personal_data)
	{
		if(is_object($a_personal_data)){
			$a_personal_data = (array)$a_personal_data;
		}
		
		if(!array_key_exists('personal_data_id', $a_personal_data)){
			$a_personal_data['personal_data_id'] = $this->uuid->v4();
		}
		
		$this->db->insert('dt_personal_data', $a_personal_data);
		
		$s_directory_file = APPPATH.'uploads/'.$a_personal_data['personal_data_id'].'/';
		if(!file_exists($s_directory_file)){
			mkdir($s_directory_file, 0755);
		}
		
		return $a_personal_data['personal_data_id'];
	}
	
	public function get_personal_data_by_email($s_email)
	{
		$query = $this->db->get_where('dt_personal_data', array('personal_data_email' => $s_email));
		return ($query->num_rows() == 1) ? $query->first_row() : false;
	}
}
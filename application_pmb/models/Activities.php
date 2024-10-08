<?php
class Activities extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function backup_access_log()
	{
		$this->ldb = $this->load->database('dblog', TRUE);
		$this->logforge = $this->load->dbforge($this->ldb, TRUE);
		
		$s_table_name = 'apps_log';
		$now = date('Y-m-d H:i:s');
		$s_backup_table_name = implode('_', [$s_table_name, date('Ym', strtotime("$now -1 month"))]);
		
		if(!$this->ldb->table_exists($s_backup_table_name)){
			$this->ldb->query("CREATE TABLE ".$s_table_name."_temp LIKE $s_table_name");
			$this->logforge->rename_table($s_table_name, $s_backup_table_name);
			$this->logforge->rename_table($s_table_name.'_temp', $s_table_name);
		}

		// $this->load->dbforge();
		// $s_table_name = 'dt_access_log';
		// $now = date('Y-m-d H:i:s');
		// $s_backup_table_name = implode('_', [$s_table_name, date('Ym', strtotime("$now -1 month"))]);
		
		// if(!$this->db->table_exists($s_backup_table_name)){
		// 	$this->dbforge->rename_table($s_table_name, $s_backup_table_name);
		// 	$this->db->query("CREATE TABLE $s_table_name LIKE $s_backup_table_name");
		// }
	}
	
	public function log_activity($details = null)
	{
		// $referer = ($this->agent->is_referral()) ? $this->agent->referrer() : 'DIRECT URL';
		// $this->backup_access_log();
		
		// $s_post_data = null;
		// if($_POST){
		// 	$a_post_data = $_POST;
		// 	if(isset($_POST['password'])){
		// 		unset($a_post_data['password']);
		// 	}
			
		// 	if(isset($_POST['confirm_password'])){
		// 		unset($a_post_data['confirm_password']);
		// 	}
		// 	$s_post_data = json_encode($a_post_data);
		// }
		
		
		// $a_log_prepare = array(
		// 	'access_log_source_ip' => $this->input->ip_address(),
		// 	'access_log_user_agent' => $this->input->user_agent(),
		// 	'access_log_referrer' => $referer,
		// 	'access_log_details' => $details,
		// 	'access_log_module' => $this->router->fetch_module(),
		// 	'access_log_class' => $this->router->fetch_class(),
		// 	'access_log_method' => $this->router->fetch_method(),
		// 	'access_log_uri_string' => $this->uri->uri_string(),
		// 	'access_log_post_data' => $s_post_data,
		// 	'access_log_php_raw_input' => file_get_contents('php://input'),
		// 	'access_log_get_data' => ($this->input->get()) ? json_encode($this->input->get()) : null
		// );
		
		// if($this->session->userdata('auth')){
		// 	$a_log_prepare['personal_data_id'] = $this->session->userdata('personal_data_id');
		// 	$a_log_prepare['access_log_session_data'] = json_encode($this->session->userdata());
		// }
		
		// $this->db->insert('dt_access_log', $a_log_prepare);

		$this->ldb = $this->load->database('dblog', TRUE);
		$referer = ($this->agent->is_referral()) ? $this->agent->referrer() : 'DIRECT URL';
		$this->backup_access_log();
		
		$s_post_data = null;
		if($_POST){
			$a_post_data = $_POST;
			if(isset($_POST['password'])){
				unset($a_post_data['password']);
			}
			
			if(isset($_POST['confirm_password'])){
				unset($a_post_data['confirm_password']);
			}
			
			if(isset($_POST['key'])){
				unset($a_post_data['key']);
			}
			
			$s_post_data = json_encode($a_post_data);
		}
		
		$a_log_prepare = array(
			'access_log_application' => base_url(),
			'access_log_source_ip' => $this->input->ip_address(),
			'access_log_user_agent' => $this->input->user_agent(),
			'access_log_referrer' => $referer,
			'access_log_details' => $details,
			'access_log_module' => $this->router->fetch_module(),
			'access_log_class' => $this->router->fetch_class(),
			'access_log_method' => $this->router->fetch_method(),
			'access_log_uri_string' => $this->uri->uri_string(),
			'access_log_post_data' => $s_post_data,
			'access_log_get_data' => ($this->input->get()) ? json_encode($this->input->get()) : null
		);
		
		if($this->router->fetch_method() != 'login'){
			$a_log_prepare['access_log_php_raw_input'] = (file_get_contents('php://input')) ? file_get_contents('php://input') : null;
		}
		
		if($this->session->userdata('auth')){
			$a_log_prepare['personal_data_id'] = $this->session->userdata('personal_data_id');
			$a_log_prepare['access_log_user_email'] = $this->session->userdata('email');
			$a_log_prepare['access_log_session_data'] = json_encode($this->session->userdata());
		}
		
		if ($this->ldb->table_exists('apps_log')) {
            $this->ldb->insert('apps_log', $a_log_prepare);
        }
	}
}
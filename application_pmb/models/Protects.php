<?php

class Protects extends CI_Model{
	public function __construct(){
		parent::__construct();
	}
	
	public function from_expired_session(){
		if(!$this->session->userdata('auth'))
		{
			if($this->uri->segment(1)){
				$aSessionData = array(
					'url' => "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"
				);
			}
			else{
				$aSessionData = array(
					'url' => base_url().'account/dashboard'
				);
			}
			$this->session->set_userdata($aSessionData);
			redirect(site_url());
			// redirect($this->app_url.'auth');
		}
	}
	
	public function from_student()
	{
		$reject = array('candidate_student', 'student');
		if(in_array($this->session->userdata('type'), $reject))
		{
			if($this->uri->segment(1)){
				$aSessionData = array(
					'url' => "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"
				);
			}
			else{
				$aSessionData = array(
					'url' => base_url().'account/dashboard'
				);
			}
			$this->session->set_userdata($aSessionData);
			redirect(site_url());
		}
	}
}
	
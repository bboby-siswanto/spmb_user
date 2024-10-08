<?php
class Download extends App_core
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('candidate/Profiles', 'Profiles');
	}
	
	public function attachment($s_document_id, $s_personal_data_id, $b_view_only = false)
	{	
		$mbo_personal_data_document = $this->Profiles->get_personal_data_documents($s_personal_data_id, $s_document_id);
		if($mbo_personal_data_document){
			if(count($mbo_personal_data_document) == 1){
				$s_file_path = APPPATH.'uploads/'.$s_personal_data_id.'/'.$mbo_personal_data_document[0]->document_requirement_link;
				if(!file_exists($s_file_path)){
			    	return false;
			    }
				else{
					$a_path_info = pathinfo($s_file_path);
					$s_file_ext = $a_path_info['extension'];
					$s_download_filename = str_replace(' ', '_', implode('-', array($mbo_personal_data_document[0]->personal_data_name, $mbo_personal_data_document[0]->document_name))).'.'.$s_file_ext;
					header("Content-Type: ".$mbo_personal_data_document[0]->document_mime);
			    	
					if(!$b_view_only){
						header('Content-Disposition: attachment; filename='.urlencode($s_download_filename));
					}
			    	readfile( $s_file_path );
			    	exit;
				}
			}
			else{
				show_404();
			}
		}
	}
}
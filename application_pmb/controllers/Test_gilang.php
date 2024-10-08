<?php
class Test_gilang extends App_core
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function testing()
	{
		$data = array(
			'data_1' => 'test_1',
			'data_2' => 'test_2',
			'data_3' => 'test_3'
		);
		$hashed_string = $this->api->hash_data($data, 'PMBIULIACID', '28af8b90-81e0-11e9-bdfc-5254005d90f6');
		
		$post_data = json_encode(array(
			'access_token' => 'PMBIULIACID',
			'data' => $hashed_string
		));
		
		$url = 'https://staging.iuli.ac.id/portal2/admission/api/create_new_student';
		$result = $this->api->post_data($url, $post_data);
	}
	
	public function init()
	{
		$postBody = array('key' => 'gXp9BjHD');
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_POST, TRUE);
/*
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/x-www-form-urlencoded'
		));
*/
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postBody);
		// curl_setopt($ch, CURLOPT_URL, 'https://staging.iuli.ac.id/portal/api/pmb/test_api');
		curl_setopt($ch, CURLOPT_URL, 'https://staging.iuli.ac.id/portal/dc.php');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);
		curl_close($ch);
		
		var_dump(json_decode($result));
	}
}
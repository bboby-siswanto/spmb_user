<?php
class Bni_api extends CI_Model
{
	private $productionClientId = '310';
	private $developmentClientId = '141';
	
	private $productionSecretKey = 'ff7dd3a3ac49cfc2a3070a317b688c30';
	private $developmentSecretKey = '2d9b7b2442a0dd722690b8c525a52915';
	
	private $productionUrl = 'https://api.bni-ecollection.com/';
	private $developmentUrl = 'https://apibeta.bni-ecollection.com/';
	
	private $url, $clientId, $secretKey;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('BniHashing');
	}
	
	public function setEnvironment($type)
	{
		switch($type)
		{
			case "development":
				$this->url = $this->developmentUrl;
				$this->clientId = $this->developmentClientId;
				$this->secretKey = $this->developmentSecretKey;
				break;
				
			case "production":
				$this->url = $this->productionUrl;
				$this->clientId = $this->productionClientId;
				$this->secretKey = $this->productionSecretKey;
				break;
		}
	}
	
	public function updateVaBni($bniTransactionData, $bniTransactionClause)
	{	
		$this->db->update('bni_transactions', $bniTransactionData, $bniTransactionClause);
		return TRUE;
	}
	
	public function insertVaBni($bniTransactionData)
	{	
		$this->db->insert('bni_transactions', $bniTransactionData);
		return $this->db->insert_id();
	}
	
	public function update_va()
	{
		// $data_asli = array(
			// 'type' => 'updatebilling', // mandatory
			// 'client_id' => $this->clientId, // mandatory
			// 'trx_id' => $this->input->post('trx_id'), // fill with Billing ID // mandatory
			// 'trx_amount' => $this->input->post('trx_amount'), // mandatory
			// 'customer_name' => $this->input->post('student_name'), // mandatory
			// 'datetime_expired' => $this->input->post('datetime_expired'),
			// 'description' => $this->input->post('description'),
			// 'customer_email' => 'bni.finance@iuli.ac.id'
		// );
		
		$hashed_string = $this->bnihashing->hashData(
			$data_asli,
			$this->clientId,
			$this->secretKey
		);
		
		$data = array(
			'client_id' => $this->clientId,
			'data' => $hashed_string,
		);
		
		$response = $this->get_content($this->url, json_encode($data));
		$response_json = json_decode($response, true);
		
		if ($response_json['status'] !== '000') {
			print json_encode(array('code' => $response_json['status'], 'log' => $response_json['message']));	
			exit;
		}
		else {
			$data_response = $this->bnihashing->parseData($response_json['data'], $this->clientId, $this->secretKey);
			$data_response['code'] = 0;
			print json_encode($data_response);
			exit;
		}
	}
	
	public function retrieve_va($trxId)
	{
		$data = array(
			'type' => 'inquirybilling',
			'client_id' => $this->clientId,
			'trx_id' => $trxId
		);
		
		$hashed_string = $this->bnihashing->hashData(
			$data,
			$this->clientId,
			$this->secretKey
		);
		
		$postData = array(
			'client_id' => $this->clientId,
			'data' => $hashed_string,
		);
		
		$response = $this->get_content($this->url, json_encode($postData));
		$response_json = json_decode($response, true);
		
		if ($response_json['status'] !== '000') {
			return array('code' => $response_json['status'], 'log' => $response_json['message']);
		}
		else {
			$data_response = $this->bnihashing->parseData($response_json['data'], $this->clientId, $this->secretKey);
			return $data_response;
		}
	}
	
	public function create_va($data)
	{
		// $data = array(
			// 'trx_amount' => 200000,
			// 'billing_type' => 'c/i',
			// 'customer_name' => 'customer_name',
			// 'virtual_account' => '8310020211234567',
			// 'description' => 'description',
			// 'datetime_expired' => date('Y-m-d H:i:s', time()),
			// 'customer_email' => 'bni.finance@iuli.ac.id'
		// );
		
		$data['type'] = 'createbilling';
		$data['client_id'] = $this->clientId;
		$data['trx_id'] = mt_rand();
		
		$hashed_string = $this->bnihashing->hashData(
			$data,
			$this->clientId,
			$this->secretKey
		);
		
		$postData = array(
			'client_id' => $this->clientId,
			'data' => $hashed_string,
		);
		
		$response = $this->get_content($this->url, json_encode($postData));
		$response_json = json_decode($response, true);
		
		if ($response_json['status'] !== '000') {
			return $response_json;
		}
		else {
			$data_response = $this->bnihashing->parseData($response_json['data'], $this->clientId, $this->secretKey);
			$retrieveResponse = $this->retrieve_va($data_response['trx_id']);
			$bniTransactionData = array(
				'trx_id' => $retrieveResponse['trx_id'],
				'trx_amount' => $retrieveResponse['trx_amount'],
				'virtual_account' => $retrieveResponse['virtual_account'],
				'customer_name' => $retrieveResponse['customer_name'],
				'customer_email' => $retrieveResponse['customer_email'],
				'datetime_created' => $retrieveResponse['datetime_created'],
				'datetime_expired' => $retrieveResponse['datetime_expired'],
				'datetime_last_updated' => $retrieveResponse['datetime_last_updated'],
				'description' => $retrieveResponse['description'],
				'va_status' => $retrieveResponse['va_status'],
				'billing_type' => $data['billing_type'],
				'payment_amount' => $retrieveResponse['payment_amount'],
				'payment_ntb' => $retrieveResponse['payment_ntb'],
				'datetime_payment' => $retrieveResponse['datetime_payment']
			);
			$insertVaBni = $this->insertVaBni($bniTransactionData);
			return array('status' => '000', 'bni_transactions_id' => $insertVaBni, 'retrieve_data' => $retrieveResponse);
		}
	}

	function get_content($url, $post = '')
	{
		$usecookie = __DIR__ . "/cookie.txt";
		$header[] = 'Content-Type: application/json';
		$header[] = "Accept-Encoding: gzip, deflate";
		$header[] = "Cache-Control: max-age=0";
		$header[] = "Connection: keep-alive";
		$header[] = "Accept-Language: en-US,en;q=0.8,id;q=0.6";
	
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_VERBOSE, false);
		// curl_setopt($ch, CURLOPT_NOBODY, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_ENCODING, true);
		curl_setopt($ch, CURLOPT_AUTOREFERER, true);
		curl_setopt($ch, CURLOPT_MAXREDIRS, 5);
	
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.120 Safari/537.36");
	
		if ($post)
		{
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		}
	
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	
		$rs = curl_exec($ch);
		curl_close($ch);
	
		if(empty($rs)){
			return false;
		}
		return $rs;
	}
}
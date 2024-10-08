<?php
class LibAPI
{
	const TIME_DIFF_LIMIT = 300; // 5 menit

	public function post_data($url, $post_data)
	{
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
	
		if($post_data){
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
		}
	
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	
		$rs = curl_exec($ch);
		curl_close($ch);
	
		if(empty($rs)){
			return false;
		}
		return json_decode($rs);
	}

	public function post_file($url, $s_file_temp)
	{
		$fp = fopen($s_file_temp, 'r');
		$ch = curl_init();

		// curl_setopt($ch, CURLOPT_USERPWD, "email@email.org:password");
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_UPLOAD, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 86400); // 1 Day Timeout
		curl_setopt($ch, CURLOPT_INFILE, $fp);
		// curl_setopt($ch, CURLOPT_NOPROGRESS, false);
		// curl_setopt($ch, CURLOPT_PROGRESSFUNCTION, 'CURL_callback');
		curl_setopt($ch, CURLOPT_BUFFERSIZE, 128);
		curl_setopt($ch, CURLOPT_INFILESIZE, filesize($s_file_temp));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		$rs = curl_exec($ch);
		curl_close($ch);
	
		if(empty($rs)){
			return false;
		}
		return $rs;
	}

	public static function hash_data(array $json_data, $cid, $secret) {
		return self::double_encrypt(strrev(time()) . '.' . json_encode($json_data), $cid, $secret);
	}

	public static function parse_data($hased_string, $cid, $secret) {
		$parsed_string = self::double_decrypt($hased_string, $cid, $secret);
		list($timestamp, $data) = array_pad(explode('.', $parsed_string, 2), 2, null);
		// var_dump($hased_string, $parsed_string, $timestamp, $data);
		if (self::ts_diff(strrev($timestamp)) === true) {
			return json_decode($data, true);
		}
		return null;
	}

	private static function ts_diff($ts) {
		return abs($ts - time()) <= self::TIME_DIFF_LIMIT;
	}

	private static function double_encrypt($string, $cid, $secret) {
		$result = '';
		$result = self::encrypt($string, $cid);
		// var_dump($result);
		$result = self::encrypt($result, $secret);
		// var_dump($result);
		return strtr(rtrim(base64_encode($result), '='), '+/', '-_');
	}

	private static function encrypt($string, $key) {
		$result = '';
		$strls = strlen($string);
		$strlk = strlen($key);
		for($i = 0; $i < $strls; $i++) {
			$char = substr($string, $i, 1);
			// echo "Test1: $char\n";
			$keychar = substr($key, ($i % $strlk) - 1, 1);
			// echo "Test2: $keychar\n";
			$char = chr((ord($char) + ord($keychar)) % 128);
			// echo "Test3: $char\n";
			// break;
			$result .= $char;
			// echo "Test4: $result\n\n";
		}
		return $result;
	}

	private static function double_decrypt($string, $cid, $secret) {
		$result = base64_decode(strtr(str_pad($string, ceil(strlen($string) / 4) * 4, '=', STR_PAD_RIGHT), '-_', '+/'));
		// var_dump($result);
		$result = self::decrypt($result, $cid);
		// var_dump($result);
		$result = self::decrypt($result, $secret);
		// var_dump($result);
		return $result;
	}

	private static function decrypt($string, $key) {
		$result = '';
		$strls = strlen($string);
		$strlk = strlen($key);
		for($i = 0; $i < $strls; $i++) {
			$char = substr($string, $i, 1);
			$keychar = substr($key, ($i % $strlk) - 1, 1);
			$char = chr(((ord($char) - ord($keychar)) + 256) % 128);
			$result .= $char;
		}
		return $result;
	}

}
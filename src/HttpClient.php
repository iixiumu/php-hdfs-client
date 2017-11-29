<?php
namespace xiumu;

class HttpClient {
	private static $connect_timeout = 3;
	
	public static function doGet($request_url) {
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $request_url);
		curl_setopt($ch, CURLOPT_AUTOREFERER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, static::$connect_timeout);

		$ret = curl_exec($ch);
		curl_close($ch);
		return $ret;
	}

	public static function doPost($request_url, $data) {
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $request_url);
		curl_setopt($ch, CURLOPT_AUTOREFERER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, static::$connect_timeout);

	 	curl_setopt($ch, CURLOPT_POST, true);
	 	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

		$ret = curl_exec($ch);
		curl_close($ch);
		return $ret;
	}

	public static function doPut($request_url) {
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $request_url);
		curl_setopt($ch, CURLOPT_AUTOREFERER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, static::$connect_timeout);

	 	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
    	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

		$ret = curl_exec($ch);
		curl_close($ch);
		return $ret;
	}

	public static function doDelete($request_url) {
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $request_url);
		curl_setopt($ch, CURLOPT_AUTOREFERER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, static::$connect_timeout);

	 	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');

		$ret = curl_exec($ch);
		curl_close($ch);
		return $ret;
	}

}

// $url = 'http://www.baidu.com';
// $ret = HttpClient::doGet($url);
// print_r($ret);
<?php
namespace xiumu;

class HttpClient {
	private static $connect_timeout = 3;
	
	public static function doGet($request_url, $header = false, $fp = null) {
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $request_url);
		curl_setopt($ch, CURLOPT_AUTOREFERER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, !$header);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, $header);
		curl_setopt($ch, CURLOPT_NOBODY, $header);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, static::$connect_timeout);
		if ($fp !== null) {
			curl_setopt($ch, CURLOPT_FILE, $fp);
		}

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

	public static function doPut($request_url, $data = null) {
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $request_url);
		curl_setopt($ch, CURLOPT_AUTOREFERER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_NOBODY, false);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, static::$connect_timeout);

	 	curl_setopt($ch, CURLOPT_PUT, true);
	 	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "put");
	 	// curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-HTTP-Method-Override: PUT'));
    	if ($data !== null) {
			// curl_setopt($ch, CURLOPT_INFILE, $fp);
			// curl_setopt($ch, CURLOPT_INFILESIZE, 16665883);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		}
		$ret = curl_exec($ch);
		// print_r('***********');
		// print_r($ret);
		print_r(curl_error($ch));
		curl_close($ch);
		return $ret;
	}

	public static function doDelete($request_url) {
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $request_url);
		curl_setopt($ch, CURLOPT_AUTOREFERER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, static::$connect_timeout);

	 	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');

		$ret = curl_exec($ch);
		curl_close($ch);
		return $ret;
	}

	public static function doHead($request_url) {
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $request_url);
		curl_setopt($ch, CURLOPT_AUTOREFERER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, static::$connect_timeout);
		
	 	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'HEAD');

		$ret = curl_exec($ch);
		curl_close($ch);
		return $ret;
	}

}

// $url = 'http://www.baidu.com';
// $ret = HttpClient::doGet($url);
// print_r($ret);
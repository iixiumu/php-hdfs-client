<?php
namespace xiumu;

class HDFSClient {
	private function __construct() {
	}
	private function __clone() {
	}
	private $request_hosts = array();
	private $request_port = 50070;
	private $hdfs_user = 'hadoop';
	private $request_rul = 'http://%s:%d/webhdfs/v1/%s?op=%s&user.name=%s'; 

	private static $ins = null;
	public static function getInstance($hosts, $port = 50070, $user='hadoop') {
        if (null == static::$ins) {
            static::$ins = new static();
        }
        if (is_array($hosts)) {
        	static::$ins->request_hosts = $hosts;
        } else {
        	static::$ins->request_hosts = array($hosts);
        }
        static::$ins->request_port = $port;
        static::$ins->hdfs_user = $user;
        return static::$ins;
    }
	

	//file info create delete
	//dir  info create delete
	public function fileInfo($file) {
		$op = 'GETFILESTATUS';
		return $this->doGet($op, $file);

	}
	public function dirInfo($dir) {
		$op = 'GETFILESTATUS';
	}
	public function doGet($op, $path) {
		foreach ($this->request_hosts as $host) {
			$url = sprintf($this->request_rul, $host, $this->request_port, $path, $op, $this->hdfs_user);
			// var_dump($url);
			// continue;
			$ret = \xiumu\HttpClient::doGet($url);
			// var_dump($host);
			// var_dump($ret);
			if ($ret === false) {
				continue;
			} else {
				return $ret;
			}
		}
		return false;
	}
	public function doPut() {

	}
}
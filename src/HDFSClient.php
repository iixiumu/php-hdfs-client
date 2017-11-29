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
	private $request_rul = 'http://%s:%d/webhdfs/v1%s?op=%s&user.name=%s'; 

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
		return $this->doGet($op, $file);
	}
	public function listDir($dir) {
		$op = 'LISTSTATUS';
		return $this->doGet($op, $dir);
	}
	public function put($file) {

	}
	public function getFileContent($file) {
		$op = 'OPEN';
		return $this->doGet($op, $file);
	}
	public function getFileUrl($file) {
		$op = 'OPEN';
		$ret  = $this->doGet($op, $file, true);
		if ($ret === false) {
			return false;
		}
		$match = array();
		$ret = preg_match('/http:.*offset=0/', $ret, $match);
		if ($ret === 1) {
			return $match[0];
		}
		return '';
	}
	public function getFileToLoacl($file, $localFile) {
		$op = 'OPEN';
		$fp = fopen($localFile, 'w');
		if ($fp === false) {
			return false;
		}
		$ret  = $this->doGet($op, $file, false, $fp);
		fclose($fp);
		return $ret;
	}
	public function putFileToRemote($file, $remoteFile) {
		$op = 'CREATE';
		$fp = fopen($file, 'r');
		if ($fp === false) {
			return false;
		}
		$ret  = $this->doPut($op, $remoteFile, $fp);
		if ($ret === false) {
			return false;
		}
		$ret = preg_match('/http:.*overwrite=true/', $ret, $match);
		if ($ret !== 1) {
			return false;
		}
		var_dump($match[0]);
		$ret  = $this->doPut($op, $remoteFile, $fp, $match[0]);
		fclose($fp);
		return $ret;
	}

	public function doGet($op, $path, $header = false, $fp = null) {
		foreach ($this->request_hosts as $host) {
			$url = sprintf($this->request_rul, $host, $this->request_port, $path, $op, $this->hdfs_user);
			$ret = \xiumu\HttpClient::doGet($url, $header, $fp);
			if ($ret === false) {
				continue;
			} else {
				return $ret;
			}
		}
		return false;
	}
	public function doPut($op, $path, $fp = null, $url = null) {
		if ($url !== null) {
			$ret = \xiumu\HttpClient::doPut($url, $fp);
			return $ret;
		}
		foreach ($this->request_hosts as $host) {
			$url = sprintf($this->request_rul, $host, $this->request_port, $path, $op, $this->hdfs_user);
			$url .= '&overwrite=true';
			$ret = \xiumu\HttpClient::doPut($url, $fp);
			if ($ret === false) {
				continue;
			} else {
				return $ret;
			}
		}
		return false;
	}
}
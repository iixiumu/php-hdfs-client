<?php

require_once('vendor/autoload.php');

$host = 'localhost';
$port = 50070;
$user = 'hadoop';
$hdfsClient = \xiumu\HDFSClient::getInstance($host, $port, $user);

$ret = $hdfsClient->fileExisted("/user/xiaoju/goodbooks/book_tags.csv");
var_dump($ret);
$ret = $hdfsClient->fileSize("/user/xiaoju/goodbooks/book_tags.csv");
var_dump($ret);
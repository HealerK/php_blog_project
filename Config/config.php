<?php
ini_set('display_errors',1);
error_reporting(E_ALL);

define('MYSQL_HOST','localhost');
define('MYSQL_USER','root');
define('MYSQL_PASS','');
define('MYSQL_DATABASE','blog');

$options = array(
    PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION
);

$pdo = new PDO(
    'mysql:host='.MYSQL_HOST.';dbname='.MYSQL_DATABASE,MYSQL_USER,MYSQL_PASS,$options
);

?>
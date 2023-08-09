<?php
// nếu kết nối database local (offline)
$databaseHost = '127.0.0.1:3306';
$databaseName = 'product_php';
$databaseUsername = 'root';
$databasePassword = '0925578308';

// nếu kết nối database online
// $databaseHost = 'db4free.net:3306';
// $databaseName = 'mysql_php';
// $databaseUsername = 'chicao0703';
// $databasePassword = '0925578308';

try {
	$dbConn = new PDO("mysql:host={$databaseHost};dbname={$databaseName}", 
						$databaseUsername, $databasePassword);
	$dbConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
	echo $e->getMessage();
}
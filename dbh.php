<?php
	$host = 'localhost';
	$dbName = "election";
	$user = 'root';
	$password = '';

	$dsn = 'mysql:host=' . $host . ';dbname=' . $dbName;
	$pdo = new PDO($dsn,$user,$password);
	$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE ,PDO::FETCH_OBJ);
	return $pdo;
?>
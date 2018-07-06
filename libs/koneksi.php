<?php 

$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = 'Kul0nuwun';
$dbname = 'sippweb';
$dbmethod = 'mysql:dbname=';

$dsn = $dbmethod.$dbname;
$pdo = new PDO($dsn, $dbuser, $dbpass);
$db  = new NotORM($pdo);

 ?>
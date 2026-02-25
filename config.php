<?php
$hostname = getenv('MYSQLHOST') ?: 'db.ncsobcjlvytbivoxezfd.supabase.co';
$port     = getenv('MYSQLPORT') ?: '5432';
$username = getenv('MYSQLUSER') ?: 'postgres';
$password = getenv('MYSQLPASSWORD') ?: 'pluk_Boslia';
$dbname   = getenv('MYSQL_DATABASE') ?: 'postgres';

$conn = mysqli_connect($hostname, $username, $password, $dbname, $port);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>


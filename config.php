<?php
$hostname = getenv('MYSQLHOST') ?: 'db.ncsobcjlvytbivoxezfd.supabase.co';
$port     = getenv('MYSQLPORT') ?: '5432';
$username = getenv('MYSQLUSER') ?: 'postgres';
$password = getenv('MYSQLPASSWORD') ?: 'pluk_Boslia';
$dbname   = getenv('MYSQL_DATABASE') ?: 'postgres';

$dsn = "pgsql:host=$hostname;port=$port;dbname=$dbname;sslmode=require";


try{
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

?>


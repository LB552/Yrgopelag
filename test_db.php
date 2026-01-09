<?php

declare(strict_types=1);

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "PHP is running<br>";

$host = "localhost"; // or "mysqlXX.one.com"
$dbname = "ch1v08l2m_awborndb";
$user = "ch1v08l2m_awborndb";
$pass = "JSB4M4KYe";

try {
    $db = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $user,
        $pass,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    echo "MySQL connection OK";
} catch (PDOException $e) {
    echo "PDO ERROR: " . $e->getMessage();
}

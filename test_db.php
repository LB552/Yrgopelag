<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    $db = new PDO(
        "mysql:host=localhost;dbname=ch1v08l2m_awborndb;charset=utf8mb4",
        "YOUR_MYSQL_USER",
        "YOUR_MYSQL_PASSWORD",
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    echo "MySQL connection OK";
} catch (PDOException $e) {
    echo $e->getMessage();
}

<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "PHP is running<br>";

try {
    $db = new PDO(
        "mysql:host=localhost;dbname=ch1v08l2m_awborndb;charset=utf8mb4",
        "ch1v08l2m_awborndb",
        "JSB4M4KYe",
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]
    );
    echo "MySQL connection OK";
} catch (PDOException $e) {
    echo "PDO ERROR: " . $e->getMessage();
}

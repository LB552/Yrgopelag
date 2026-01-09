<?php

declare(strict_types=1);

header("Content-Type: application/json");
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 1. Read JSON
$raw = file_get_contents("php://input");
$data = json_decode($raw, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(400);
    echo json_encode(["error" => "Invalid JSON"]);
    exit;
}

// 2. Extract values
$username     = $data["username"];
$transferCode = $data["transferCode"];
$roomTrim     = $data["room"];
$features     = $data["features"];
$fromDate     = $data["from_date"];
$toDate       = $data["to_date"];

// 3. Connect to MySQL (PDO)
$host = "localhost";
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
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => "DB connection failed"]);
    exit;
}

// 4. Resolve room_id
$stmt = $db->prepare("SELECT id FROM rooms WHERE trim = ?");
$stmt->execute([$roomTrim]);
$roomResult = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$roomResult) {
    echo json_encode(["error" => "Invalid room type"]);
    exit;
}

$room_id = $roomResult["id"];

// 5. Resolve features_id
$stmt = $db->prepare("SELECT id FROM features WHERE feature_combo = ?");
$stmt->execute([$features]);
$featureResult = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$featureResult) {
    echo json_encode(["error" => "Invalid features"]);
    exit;
}

$features_id = $featureResult["id"];

// 6. Insert booking
$stmt = $db->prepare("
    INSERT INTO bookings
    (usn, transferCode, room_id, features_id, from_date, to_date)
    VALUES (?, ?, ?, ?, ?, ?)
");

$result = $stmt->execute([
    $username,
    $transferCode,
    $room_id,
    $features_id,
    $fromDate,
    $toDate
]);

if ($result) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["error" => "Database insert failed"]);
}

<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


header("Content-Type: application/json");

// 1. Read JSON from JS
$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
    echo json_encode(["error" => "Invalid JSON"]);
    exit;
}

// 2. Extract values
$username     = $data["username"];
$transferCode = $data["transferCode"];
$roomTrim     = $data["room"];        // Economy | Standard | Luxury
$features     = $data["features"];    // none | yahtzee | bicycle | yahtzee + bicycle
$fromDate     = $data["from_date"];   // YYYY-MM-DD
$toDate       = $data["to_date"];

// 3. Open SQLite database
$db = new SQLite3("database.db");

// 4. Resolve room_id
$stmt = $db->prepare("SELECT id FROM rooms WHERE trim = :trim");
$stmt->bindValue(":trim", $roomTrim, SQLITE3_TEXT);
$roomResult = $stmt->execute()->fetchArray(SQLITE3_ASSOC);

if (!$roomResult) {
    echo json_encode(["error" => "Invalid room type"]);
    exit;
}

$room_id = $roomResult["id"];

// 5. Resolve features_id
$stmt = $db->prepare("SELECT id FROM features WHERE feature_combo = :features");
$stmt->bindValue(":features", $features, SQLITE3_TEXT);
$featureResult = $stmt->execute()->fetchArray(SQLITE3_ASSOC);

if (!$featureResult) {
    echo json_encode(["error" => "Invalid features"]);
    exit;
}

$features_id = $featureResult["id"];

// 6. Insert booking
$stmt = $db->prepare("
    INSERT INTO bookings (usn, transferCode, room_id, features_id, from_date, to_date)
    VALUES (:usn, :transferCode, :room_id, :features_id, :from_date, :to_date)
");

$stmt->bindValue(":usn", $username, SQLITE3_TEXT);
$stmt->bindValue(":transferCode", $transferCode, SQLITE3_TEXT);
$stmt->bindValue(":room_id", $room_id, SQLITE3_INTEGER);
$stmt->bindValue(":features_id", $features_id, SQLITE3_INTEGER);
$stmt->bindValue(":from_date", $fromDate, SQLITE3_TEXT);
$stmt->bindValue(":to_date", $toDate, SQLITE3_TEXT);

$result = $stmt->execute();

if ($result) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["error" => "Database insert failed"]);
}

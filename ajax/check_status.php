<?php
session_start();
include '../minks1.php';
include '../functions.php';

if (!isset($_GET['user_id'])) {
    http_response_code(400);
    exit("Missing user ID");
}

$userId = $_GET['user_id'];

$stmt = $con->prepare("SELECT last_active FROM users WHERE user_id = ?");
$stmt->bind_param("s", $userId);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();

if (!$result || empty($result['last_active'])) {
    echo "offline";
    exit;
}

// Handle both timestamp and datetime formats
$lastActive = is_numeric($result['last_active']) 
    ? (int)$result['last_active'] 
    : strtotime($result['last_active']);

$timeDiff = time() - $lastActive;

if ($timeDiff < 60) {
    echo "online";
} else {
    echo "last seen: " . time_elapsed_string($lastActive);
}


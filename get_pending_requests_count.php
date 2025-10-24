<?php
session_start();
include 'minks1.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['count' => 0]);
    exit;
}

$user_id = $_SESSION['user_id'];

$stmt = $con->prepare("SELECT COUNT(*) AS total FROM connections WHERE receiver = ? AND status = 'Pending'");
$stmt->bind_param("s", $user_id);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();

echo json_encode(['count' => (int)$result['total']]);

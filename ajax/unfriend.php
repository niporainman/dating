<?php
session_start();
include '../minks1.php';

$userId = $_SESSION['user_id'] ?? null;
$friendId = $_POST['friend_id'] ?? null;

if (!$userId || !$friendId) exit(json_encode(['success' => false]));

$stmt = $con->prepare("DELETE FROM connections WHERE (sender = ? AND receiver = ?) OR (receiver = ? AND sender = ?)");
$stmt->bind_param("ssss", $userId, $friendId, $userId, $friendId);
$stmt->execute();

echo json_encode(['success' => true]);
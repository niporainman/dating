<?php
session_start();
header('Content-Type: application/json');
require_once '../minks1.php';

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

$action = $_POST['action'] ?? '';
$value = $_POST['artist'] ?? '';
$id = $_POST['id'] ?? null;

switch ($action) {
    case 'save':
        $stmt = $con->prepare("INSERT INTO user_interests (user_id, category, value) VALUES (?, 'Favourite Artist', ?)");
        $stmt->bind_param("ss", $user_id, $value);
        $stmt->execute();
        echo json_encode(['success' => true]);
        break;

    case 'edit':
        $stmt = $con->prepare("UPDATE user_interests SET value = ? WHERE id = ? AND user_id = ?");
        $stmt->bind_param("sis", $value, $id, $user_id);
        $stmt->execute();
        echo json_encode(['success' => true]);
        break;

    case 'delete':
        $stmt = $con->prepare("DELETE FROM user_interests WHERE id = ? AND user_id = ?");
        $stmt->bind_param("is", $id, $user_id);
        $stmt->execute();
        echo json_encode(['success' => true]);
        break;

    default:
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
}

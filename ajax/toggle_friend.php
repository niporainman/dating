<?php
session_start();
require_once '../minks1.php';
$user_id = $_SESSION['user_id'] ?? null;

if (!$user_id) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit;
}

$receiver = $_POST['receiver'] ?? null;
$sender = $_POST['sender'] ?? null;
$action = $_POST['action'] ?? null;

// Handle Accept Request
if ($action === 'accept' && $sender) {
    $stmt = $con->prepare("UPDATE connections SET status = 'Accepted' WHERE sender = ? AND receiver = ?");
    $stmt->bind_param("ss", $sender, $user_id);
    $stmt->execute();

    echo json_encode(['success' => true, 'message' => 'Friend request accepted']);
    exit;
}

// Handle Reject Request
if ($action === 'reject' && $sender) {
    $stmt = $con->prepare("DELETE FROM connections WHERE sender = ? AND receiver = ?");
    $stmt->bind_param("ss", $sender, $user_id);
    $stmt->execute();

    echo json_encode(['success' => true, 'message' => 'Friend request rejected']);
    exit;
}

// Handle Add or Cancel Friend Request
if ($receiver) {
    // Check for existing connection (in either direction)
    $stmt = $con->prepare("
        SELECT sender, receiver, status 
        FROM connections 
        WHERE (sender = ? AND receiver = ?) OR (sender = ? AND receiver = ?)
        LIMIT 1
    ");
    $stmt->bind_param("ssss", $user_id, $receiver, $receiver, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $existing = $result->fetch_assoc();

    if ($existing) {
        // Handle Cancel
        if ($existing['status'] === 'Pending' && $existing['sender'] === $user_id) {
            $stmt = $con->prepare("DELETE FROM connections WHERE sender = ? AND receiver = ?");
            $stmt->bind_param("ss", $user_id, $receiver);
            $stmt->execute();

            echo json_encode(['success' => true, 'message' => 'Friend request cancelled']);
            exit;
        } else {
            echo json_encode(['success' => false, 'message' => 'Action not allowed']);
            exit;
        }
    } else {
        // Send new request
        $date = date("Y-m-d H:i:s");
        $stmt = $con->prepare("INSERT INTO connections (sender, receiver, status, date) VALUES (?, ?, 'Pending', ?)");
        $stmt->bind_param("sss", $user_id, $receiver, $date);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo json_encode(['success' => true, 'message' => 'Request sent']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to send request']);
        }
        exit;
    }
}

echo json_encode(['success' => false, 'message' => 'Invalid request']);

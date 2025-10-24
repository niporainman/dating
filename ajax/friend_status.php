<?php
session_start();
require_once '../minks1.php';
require_once '../functions.php';

$user_id = $_SESSION['user_id'] ?? null;
$viewed_id = $_GET['user_id'] ?? null;

if (!$user_id || !$viewed_id) {
    echo json_encode(['error' => 'Missing parameters']);
    exit;
}

// Utility: Get connection record (if exists)
$stmt = $con->prepare("
    SELECT sender, receiver, status 
    FROM connections 
    WHERE (sender = ? AND receiver = ?) OR (sender = ? AND receiver = ?)
    LIMIT 1
");
$stmt->bind_param("ssss", $user_id, $viewed_id, $viewed_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();
$connection = $result->fetch_assoc();

$status = $connection['status'] ?? null;
$sender = $connection['sender'] ?? null;

$buttons = '';
$profile_visible = false;

// Determine buttons and access based on status
switch ($status) {
    case null:
        $buttons = "<button type='button' class='btn btn-outline toggle-friend' data-receiver='$viewed_id'>Add Friend</button>";
        break;

    case 'Pending':
        if ($sender === $user_id) {
            $buttons = "<button type='button' class='btn btn-outline toggle-friend' data-receiver='$viewed_id'>Cancel Request</button>";
        } else {
            $buttons = "
                <div class='btn-group'>
                    <button type='button' class='btn btn-sm btn-success me-2 accept-friend' data-sender='$viewed_id'>Accept</button>
                    <button type='button' class='btn btn-sm btn-danger reject-friend' data-sender='$viewed_id'>Reject</button>
                </div>";
        }
        break;

    case 'Accepted':
        $buttons = "<a href='messages.php?chat_with=$viewed_id' class='btn btn-primary'>Message</a>";
        $profile_visible = true;
        break;
}

echo json_encode([
    'buttons' => $buttons,
    'profile_visible' => $profile_visible
]);

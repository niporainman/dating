<?php
session_start();
include '../minks1.php';

if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo "Not logged in";
    exit;
}

$sender_id = $_SESSION['user_id'];
$receiver_id = $_POST['receiver_id'];
$message = trim($_POST['message']);

if ($receiver_id && $message !== '') {
    $stmt = $con->prepare("INSERT INTO messages (sender_id, receiver_id, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $sender_id, $receiver_id, $message);
    if ($stmt->execute()) {
        echo "Message sent";
    } else {
        echo "Error sending message";
    }
} else {
    echo "Invalid input";
}
?>

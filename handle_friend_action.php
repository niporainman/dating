<?php
session_start();
include 'minks1.php';

$currentUserId = $_SESSION['user_id'] ?? '';
$action = $_POST['action'] ?? '';
$sender = $_POST['sender'] ?? '';

if (!$currentUserId || !$sender) exit("Invalid");

if ($action === 'accept') {
    $stmt = $con->prepare("UPDATE connections SET status = 'Accepted' WHERE sender = ? AND receiver = ?");
    $stmt->bind_param("ss", $sender, $currentUserId);
    $stmt->execute();

    //get the usernames 
    $stmt1 = $con->prepare("SELECT username FROM users WHERE user_id = ?");
    $stmt1->bind_param("s", $sender);
    $stmt1->execute();
    $stmt1 -> store_result(); 
    $stmt1 -> bind_result($sender_username); 
    $numrows1 = $stmt1 -> num_rows();
    if ($numrows1 > 0) {
        while ($stmt1 -> fetch()) {}
    }

    $stmt2 = $con->prepare("SELECT username FROM users WHERE user_id = ?");
    $stmt2->bind_param("s", $currentUserId);
    $stmt2->execute();
    $stmt2 -> store_result(); 
    $stmt2 -> bind_result($receiver_username); 
    $numrows2 = $stmt2 -> num_rows();
    if ($numrows2 > 0) {
        while ($stmt2 -> fetch()) {}
    }

    $notifyStmt = $con->prepare("INSERT INTO notifications (user_id, from_user_id, type, message) VALUES (?, ?, 'friend_accept', ?)");
    $msg = "$receiver_username accepted your friend request.";
    $notifyStmt->bind_param("sss", $sender, $currentUserId, $msg);
    $notifyStmt->execute();

    echo "Accepted";
} elseif ($action === 'delete') {
    $stmt = $con->prepare("DELETE FROM connections WHERE sender = ? AND receiver = ?");
    $stmt->bind_param("ss", $sender, $currentUserId);
    $stmt->execute();
    echo "Deleted";
}

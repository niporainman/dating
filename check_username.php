<?php
header('Content-Type: application/json');
include("minks1.php");
$username = $_GET['username'] ?? '';
$stmt = $con->prepare('SELECT COUNT(*) FROM users WHERE username = ?');
$stmt->bind_param('s', $username);
$stmt->execute();
$stmt->bind_result($count);
$stmt->fetch();
$stmt->close();
$con->close();

echo json_encode(['exists' => $count > 0]);
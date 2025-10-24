<?php
header('Content-Type: application/json');
include("minks1.php");
$email = $_GET['email'] ?? '';
$stmt = $con->prepare('SELECT COUNT(*) FROM users WHERE email = ?');
$stmt->bind_param('s', $email);
$stmt->execute();
$stmt->bind_result($count);
$stmt->fetch();
$stmt->close();
$con->close();

echo json_encode(['exists' => $count > 0]);
<?php
session_start();
header('Content-Type: application/json');
include("minks1.php");
$user_id = $_SESSION['user_id'] ?? null;

if (!$user_id) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

// Validate file
if (!isset($_FILES['file']) || $_FILES['file']['error'] != 0) {
    echo json_encode(['success' => false, 'message' => 'No file uploaded']);
    exit;
}

$file = $_FILES['file'];
$maxSize = 2 * 1024 * 1024; // 2MB

if ($file['size'] > $maxSize) {
    echo json_encode(['success' => false, 'message' => 'File too large (max 2MB)']);
    exit;
}

$allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
if (!in_array($file['type'], $allowedTypes)) {
    echo json_encode(['success' => false, 'message' => 'Only JPG, PNG, GIF allowed']);
    exit;
}

$folder = "users/$user_id/";
if (!file_exists($folder)) {
    mkdir($folder, 0777, true);
}

$extension = pathinfo($file['name'], PATHINFO_EXTENSION);
$filename = uniqid() . '.' . $extension;
$destination = $folder . $filename;

if (!move_uploaded_file($file['tmp_name'], $destination)) {
    echo json_encode(['success' => false, 'message' => 'Failed to move file']);
    exit;
}

// Save to database
$upload_date = date("Y-m-d H:i:s");
$stmt = $con->prepare("INSERT INTO files (user_id, file, file_type, upload_date) VALUES (?, ?, 'image', ?)");
$stmt->bind_param("iss", $user_id, $filename, $upload_date);
$stmt->execute();

echo json_encode([
    'success' => true,
    'message' => 'File uploaded successfully',
    'url' => $destination
]);
?>

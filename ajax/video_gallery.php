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
$id = $_POST['id'] ?? null;

switch ($action) {
    case 'save':
        // Validate file
        if (!isset($_FILES['file']) || $_FILES['file']['error'] != 0) {
            echo json_encode(['success' => false, 'message' => 'No file uploaded']);
            exit;
        }

        $file = $_FILES['file'];
        $maxSize = 10 * 1024 * 1024; // 2MB

        if ($file['size'] > $maxSize) {
            echo json_encode(['success' => false, 'message' => 'File too large (max 10MB)']);
            exit;
        }

        $allowedTypes = [
            'video/mp4',
            'video/webm',
            'video/ogg'
        ];

        if (!in_array($file['type'], $allowedTypes)) {
            echo json_encode(['success' => false, 'message' => 'Only MP4, WEBM, or OGG files are allowed']);
            exit;
        }


        $folder = "../users/$user_id/";
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

        $upload_date = date("Y-m-d H:i:s");
        $stmt = $con->prepare("INSERT INTO files (user_id, file, file_type, upload_date) VALUES (?, ?, 'video', ?)");
        $stmt->bind_param("sss", $user_id, $filename,$upload_date);
        $stmt->execute();
        echo json_encode(['success' => true]);
        break;

    case 'delete':
        // Get file name first
        $stmt1 = $con->prepare("SELECT file FROM files WHERE id = ? AND user_id = ?");
        $stmt1->bind_param("is", $id, $user_id);
        $stmt1->execute();
        $stmt1->bind_result($file);
        $stmt1->fetch();
        $stmt1->close();

        // Delete file
        if ($file && file_exists("../users/$user_id/$file")) {
            unlink("../users/$user_id/$file");
        }

        $stmt = $con->prepare("DELETE FROM files WHERE id = ? AND user_id = ?");
        $stmt->bind_param("is", $id, $user_id);
        $stmt->execute();
        echo json_encode(['success' => true]);
        break;
        
    default:
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
}

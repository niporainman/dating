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
        $stmt = $con->prepare("INSERT INTO files (user_id, file, file_type, upload_date) VALUES (?, ?, 'image', ?)");
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

        case 'set_profile':
        // 1. Get current profile_pic (to delete later)
        $stmt = $con->prepare("SELECT profile_pic FROM users WHERE user_id = ?");
        $stmt->bind_param("s", $user_id);
        $stmt->execute();
        $stmt->bind_result($currentProfilePic);
        $stmt->fetch();
        $stmt->close();

        // 2. Get selected gallery image file
        $stmt1 = $con->prepare("SELECT file FROM files WHERE id = ? AND user_id = ?");
        $stmt1->bind_param("is", $id, $user_id);
        $stmt1->execute();
        $stmt1->bind_result($file);
        $stmt1->fetch();
        $stmt1->close();

        $folder = "../users/$user_id/";
        if (!file_exists($folder)) {
            mkdir($folder, 0777, true);
        }

        // 3. Generate new file name & paths
        $extension = pathinfo($file, PATHINFO_EXTENSION);
        $new_filename = uniqid() . '.' . $extension;
        $source_path = $folder . $file;
        $destination = $folder . $new_filename;

        // 4. Copy the file
        if (!copy($source_path, $destination)) {
            echo json_encode(['success' => false, 'message' => 'Failed to copy file']);
            exit;
        }

        // 5. Delete previous profile_pic if it exists
        if ($currentProfilePic && file_exists($folder . $currentProfilePic)) {
            unlink($folder . $currentProfilePic);
        }

        // 6. Update DB with new profile_pic
        $stmt = $con->prepare("UPDATE users SET profile_pic = ? WHERE user_id = ?");
        $stmt->bind_param("ss", $new_filename, $user_id);
        $stmt->execute();
        $stmt->close();

        echo json_encode(['success' => true]);
        break;


        case 'set_background':
        // 1. Get current background_pic (to delete later)
        $stmt = $con->prepare("SELECT profile_background FROM users WHERE user_id = ?");
        $stmt->bind_param("s", $user_id);
        $stmt->execute();
        $stmt->bind_result($currentBackgroundPic);
        $stmt->fetch();
        $stmt->close();

        // 2. Get selected gallery image file
        $stmt1 = $con->prepare("SELECT file FROM files WHERE id = ? AND user_id = ?");
        $stmt1->bind_param("is", $id, $user_id);
        $stmt1->execute();
        $stmt1->bind_result($file);
        $stmt1->fetch();
        $stmt1->close();

        $folder = "../users/$user_id/";
        if (!file_exists($folder)) {
            mkdir($folder, 0777, true);
        }

        // 3. Generate new file name & paths
        $extension = pathinfo($file, PATHINFO_EXTENSION);
        $new_filename = uniqid() . '.' . $extension;
        $source_path = $folder . $file;
        $destination = $folder . $new_filename;

        // 4. Copy the file
        if (!copy($source_path, $destination)) {
            echo json_encode(['success' => false, 'message' => 'Failed to copy file']);
            exit;
        }

        // 5. Delete previous pic if it exists
        if ($currentBackgroundPic && file_exists($folder . $currentBackgroundPic)) {
            unlink($folder . $currentBackgroundPic);
        }

        // 6. Update DB with new pic
        $stmt = $con->prepare("UPDATE users SET profile_background = ? WHERE user_id = ?");
        $stmt->bind_param("ss", $new_filename, $user_id);
        $stmt->execute();
        $stmt->close();

        echo json_encode(['success' => true]);
        break;


    default:
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
}

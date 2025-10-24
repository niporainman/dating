<?php
session_start();
header('Content-Type: application/json');
require_once 'minks1.php';

if (empty($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

$user_id = $_SESSION['user_id'];

// Validate required fields
$required = ['bio', 'dob', 'location', 'country', 'gender', 'looking_for', 'religion'];
foreach ($required as $field) {
    if (empty($_POST[$field])) {
        echo json_encode(['success' => false, 'message' => 'All fields are required']);
        exit;
    }
}

// Check that bio is not longer than 250 characters
$bio = trim($_POST['bio']);
if (strlen($bio) > 250) {
    echo json_encode(['success' => false, 'message' => 'Bio must not exceed 250 characters.']);
    exit;
}

// Prepare user folder
$user_folder = "users/$user_id/";
if (!is_dir($user_folder)) {
    mkdir($user_folder, 0777, true);
}

// Start transaction
$con->begin_transaction();

try {
    // Get current file names using prepared statement
    $stmt = $con->prepare("SELECT profile_pic, profile_background FROM users WHERE user_id = ?");
    $stmt->bind_param("s", $user_id); // Use "s" for string type
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    $profile_pic = $row['profile_pic'] ?? '';
    $profile_background = $row['profile_background'] ?? '';

    // Handle file uploads
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    $max_size = 2 * 1024 * 1024;

    foreach (['profile_pic', 'profile_background'] as $file_field) {
        if (!empty($_FILES[$file_field]['tmp_name'])) {
            $file = $_FILES[$file_field];
            
            if (in_array($file['type'], $allowed_types) && $file['size'] <= $max_size) {
                // Delete old file
                $old_file = ${$file_field};
                if (!empty($old_file) && file_exists($user_folder . $old_file)) {
                    unlink($user_folder . $old_file);
                }
                
                // Save new file
                $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                $new_name = uniqid() . '.' . $ext;
                
                if (move_uploaded_file($file['tmp_name'], $user_folder . $new_name)) {
                    ${$file_field} = $new_name;
                }
            }
        }
    }

    $stmt = $con->prepare("UPDATE users SET 
        bio = ?, dob = ?, location = ?, country = ?, 
        gender = ?, looking_for = ?, religion = ?,
        profile_pic = ?, profile_background = ?
        WHERE user_id = ?");
    
    $stmt->bind_param("ssssssssss", 
        $_POST['bio'], $_POST['dob'], $_POST['location'], $_POST['country'],
        $_POST['gender'], $_POST['looking_for'], $_POST['religion'],
        $profile_pic, $profile_background,
        $user_id
    );

    if ($stmt->execute()) {
        $con->commit();
        echo json_encode(['success' => true]);
    } else {
        throw new Exception('Update failed: ' . $stmt->error);
    }
} catch (Exception $e) {
    $con->rollback();
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
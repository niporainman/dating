<?php 
include("../../minks1.php"); 
$table_name = "users";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $action = $_POST['action'] ?? '';

    if ($action === 'unblock') {
        $id = (int)($_POST['id'] ?? 0);

        $stmt = $con->prepare("UPDATE $table_name SET acc_approved = 'Yes' WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        echo "Account unblocked.";
    }

    if ($action === 'block') {
        $id = (int)($_POST['id'] ?? 0);

        $stmt = $con->prepare("UPDATE $table_name SET acc_approved = 'No' WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        echo "Account blocked.";
    }

if ($action === 'delete') {
    $user_id = $_POST['user_id'] ?? 0;

    // Delete records from related tables
    $stmt1 = $con->prepare("DELETE FROM files WHERE user_id = ?");
    $stmt1->bind_param('s', $user_id);
    $stmt1->execute();

    $stmt = $con->prepare("DELETE FROM $table_name WHERE user_id = ?");
    $stmt->bind_param('i', $user_id);
    $stmt->execute();

    // Delete user's folder if it exists
    $folderPath = "../users/$user_id";

    if (is_dir($folderPath)) {
        deleteFolderRecursively($folderPath);
    }

    echo "User successfully deleted.";
}

// Helper function to delete non-empty folders
function deleteFolderRecursively($folder) {
    foreach (scandir($folder) as $item) {
        if ($item === '.' || $item === '..') continue;

        $path = $folder . DIRECTORY_SEPARATOR . $item;
        if (is_dir($path)) {
            deleteFolderRecursively($path); // recursive delete
        } else {
            unlink($path); // delete file
        }
    }
    rmdir($folder); // delete the now-empty folder
}

}
?>

<?php
session_start();
require_once '../minks1.php';

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) exit;

$stmt = $con->prepare("SELECT id, value FROM user_interests WHERE user_id = ? AND category = 'Hobby'");
$stmt->bind_param("s", $user_id);
$stmt->execute();
$stmt->bind_result($id, $hobby);

while ($stmt->fetch()) {
?>
    <form class="app-form hobby-item d-flex mt-2" style="gap: 10px;">
        <input type="text" name="hobby" class="form-control" value="<?= htmlspecialchars($hobby) ?>" required>
        <input type="hidden" name="id" value="<?= $id ?>">
        <input type="hidden" name="action" value="edit">
        <button type="submit" class="btn btn-solid">Edit</button>
        <button type="button" class="btn btn-solid delete-hobby">Delete</button>
    </form>
<?php
}
?>

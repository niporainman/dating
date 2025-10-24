<?php
session_start();
require_once '../minks1.php';

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) exit;

$stmt = $con->prepare("SELECT id, value FROM user_interests WHERE user_id = ? AND category = 'Favourite Artist'");
$stmt->bind_param("s", $user_id);
$stmt->execute();
$stmt->bind_result($id, $value);

while ($stmt->fetch()) {
?>
    <form class="app-form artist-item d-flex mt-2" style="gap: 10px;">
        <input type="text" name="artist" class="form-control" value="<?= htmlspecialchars($value) ?>" required>
        <input type="hidden" name="id" value="<?= $id ?>">
        <input type="hidden" name="action" value="edit">
        <button type="submit" class="btn btn-solid">Edit</button>
        <button type="button" class="btn btn-solid delete-artist">Delete</button>
    </form>
<?php
}
?>

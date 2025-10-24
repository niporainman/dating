<?php
session_start();
include 'minks1.php';

$currentUser = $_SESSION['user_id'] ?? null;
if (!$currentUser) exit;

$onlineLimit = 8;
$onlineTime = time() - 300; // 5 minutes ago

$sql = "
    SELECT u.user_id, u.username, u.profile_pic
    FROM users u
    JOIN connections c ON (
        (c.sender = ? AND c.receiver = u.user_id) OR 
        (c.receiver = ? AND c.sender = u.user_id)
    )
    WHERE c.status = 'Accepted'
      AND u.last_active >= ?
    ORDER BY u.last_active DESC
    LIMIT ?
";

$stmt = $con->prepare($sql);
$stmt->bind_param("ssii", $currentUser, $currentUser, $onlineTime, $onlineLimit);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $img = $row['profile_pic'] ? "users/{$row['user_id']}/{$row['profile_pic']}" : "images/profile_placeholder.jpg";
    $chatLink = "messages.php?chat_with={$row['user_id']}";
    ?>
    <li class="friend-box user2">
        <div class="media"> 
            <a href="<?= $chatLink ?>">
                <div class="user-img">
                    <img src="<?= $img ?>" class="img-fluid blur-up lazyload bg-img" alt="user">
                    <span class="available-stats online"></span>
                </div>
            </a>
        </div>
    </li> 
    <?php
}{
    //echo"nothing found";
}
?>

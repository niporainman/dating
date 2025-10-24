<?php
session_start();
require '../minks1.php';

$userId = $_SESSION['user_id'] ?? null;
$search = $_GET['search'] ?? '';
$limit = 6;

if (!$userId) exit;

// Get friend IDs
$sql = "
    SELECT u.user_id, u.username, u.profile_pic, u.location, u.country
    FROM connections c
    JOIN users u ON u.user_id = IF(c.sender = ?, c.receiver, c.sender)
    WHERE (c.sender = ? OR c.receiver = ?) AND c.status = 'Accepted'
";

if (!empty($search)) {
    $sql .= " AND u.username LIKE ?";
}

$sql .= " ORDER BY RAND() LIMIT ?";

$stmt = $con->prepare($sql);

if (!empty($search)) {
    $searchTerm = '%' . $search . '%';
    $stmt->bind_param("ssssi", $userId, $userId, $userId, $searchTerm, $limit);
} else {
    $stmt->bind_param("sssi", $userId, $userId, $userId, $limit);
}

$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $img = $row['profile_pic'] ? "users/{$row['user_id']}/{$row['profile_pic']}" : "images/profile_placeholder.jpg";
    ?>
    <div class="col-sm-6 friend-card" data-id="<?= $row['user_id'] ?>">
        <div class="friend-box">
            <div class="media">
                <a href="profile_view.php?user_id=<?= $row['user_id'] ?>" class="user-img">
                    <img src="<?= $img ?>" class="img-fluid blur-up lazyload bg-img" alt="user" style='border-radius:15px;'>
                    <span class="available-stats"></span>
                </a>
                <div class="media-body">
                    <a href="profile_view.php?user_id=<?= $row['user_id'] ?>">
                        <h5 class="user-name"><?= htmlspecialchars($row['username']) ?></h5>
                    </a>
                    <h6><?= htmlspecialchars($row['location']) ?>, <?= $row['country'] ?></h6>
                </div>
            </div>
            <div class="setting-btn ms-auto setting-dropdown no-bg">
                <div class="btn-group custom-dropdown arrow-none dropdown-sm">
                    <div role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="icon icon-font-color iw-14" data-feather="more-horizontal"></i>
                    </div>
                    <div class="dropdown-menu dropdown-menu-right custom-dropdown">
                        <ul>
                            <li><a href="profile_view.php?user_id=<?= $row['user_id'] ?>"><i class="icon-font-light iw-16 ih-16" data-feather="user"></i>view profile</a></li>
                            <li><a href="messages.php?chat_with=<?= $row['user_id'] ?>"><i class="icon-font-light iw-16 ih-16" data-feather="message-square"></i>message</a></li>
                            <li><a href="#" class="unfriend" data-id="<?= $row['user_id'] ?>"><i class="icon-font-light iw-16 ih-16" data-feather="x-octagon"></i>unfriend</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
}
?>

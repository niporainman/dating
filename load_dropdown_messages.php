<?php
session_start();
include 'minks1.php';
include 'functions.php';

$currentUserId = $_SESSION['user_id'] ?? null;
if (!$currentUserId) exit;

$sql = "
    SELECT m1.*, 
           m2.user_id,
           u.username, 
           u.profile_pic, 
           u.last_active,
           (SELECT COUNT(*) 
            FROM messages 
            WHERE sender_id = u.user_id AND receiver_id = ? AND is_read = 0
           ) AS unread_count
    FROM messages m1
    JOIN users u ON u.user_id = CASE 
        WHEN m1.sender_id = ? THEN m1.receiver_id 
        ELSE m1.sender_id 
    END
    INNER JOIN (
        SELECT 
            CASE 
                WHEN sender_id = ? THEN receiver_id 
                ELSE sender_id 
            END AS user_id,
            MAX(timestamp) AS last_message_time
        FROM messages 
        WHERE sender_id = ? OR receiver_id = ?
        GROUP BY user_id
    ) m2 ON (
        (m1.sender_id = ? AND m1.receiver_id = m2.user_id) OR 
        (m1.receiver_id = ? AND m1.sender_id = m2.user_id)
    ) AND m1.timestamp = m2.last_message_time
    ORDER BY m1.timestamp DESC
";


$stmt = $con->prepare($sql);
$stmt->bind_param("sssssss", $currentUserId, $currentUserId, $currentUserId, $currentUserId, $currentUserId, $currentUserId, $currentUserId);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $unread = (int)$row['unread_count'];
    $online = isOnline($row['last_active']); // You must define this in functions.php
    $previewMsg = strlen($row['message']) > 30 ? substr($row['message'], 0, 30) . "..." : $row['message'];
    ?>
    <li class="<?= $unread > 0 ? 'has-unread' : '' ?>">
        <a href="messages.php?chat_with=<?= htmlspecialchars($row['sender_id'] == $currentUserId ? $row['receiver_id'] : $row['sender_id']) ?>">
            <div class="media">
                <img src="users/<?= htmlspecialchars($row['user_id']) ?>/<?= htmlspecialchars($row['profile_pic']) ?>" alt="user">
                <div class="media-body">
                    <div>
                        <h5 class="mt-0"><?= htmlspecialchars($row['username']) ?></h5>
                        <h6><?= htmlspecialchars($previewMsg) ?></h6>
                    </div>
                </div>
            </div>
            <div class="active-status">
                <span class="<?= $online ? 'active' : '' ?>"></span>
            </div>
        </a>
    </li>
<?php } ?>

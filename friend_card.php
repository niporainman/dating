<div class="col-12 col-sm-12 col-md-12 col-lg-6">
    <div class="friend-box d-flex justify-content-between align-items-center" style="gap: 15px; min-width: 0;">
        <div class="media iitem-1 flex-grow-1" style="min-width: 0; overflow: hidden;">
            <a href="profile_view?user_id=<?= $id ?>" class="user-img">
                <img src="<?= $profile_pic ?>" class="img-fluid blur-up lazyload bg-img" alt="<?= htmlspecialchars($firstname) ?>" style='border-radius:5px;'>
                <span class="available-stats"></span>
            </a>
            <div class="media-body">
                <a href="profile_view?user_id=<?= $id ?>">
                    <h5 class="user-name text-truncate m-0"><?= htmlspecialchars($firstname) ?> <?= $lastname ?> (<?= $age ?>)</h5>
                </a>
                <h6><?= htmlspecialchars($location) ?> — <?= ucfirst($gender) ?></h6>
                <div class="text-muted">Match: <?= $score ?>%</div>
            </div>
        </div>
        <div class='iitem-2 flex-shrink-0'>
       <?php
$connection = get_connection_status($user_id, $id, $con); // $user_id is logged-in user, $id is card's user
$btn_html = '';

switch ($connection['status']) {
    case null:
        $btn_html = "<button type='button' class='btn btn-outline toggle-friend' data-receiver='$id'>Add Friend</button>";
        break;
    case 'Pending':
        if ($connection['sender'] === $user_id) {
            $btn_html = "<button type='button' class='btn btn-outline toggle-friend' data-receiver='$id'>Cancel Request</button>";
        } else {
            $btn_html = "
                <div class='btn-group'>
                    <button type='button' class='btn btn-sm btn-success me-3 accept-friend' data-sender='$id'>Accept</button>
                    <button type='button' class='btn btn-sm btn-danger reject-friend' data-sender='$id'>Reject</button>
                </div>";
        }
        break;
    case 'Accepted':
        $btn_html = "<a href='messages.php?chat_with=$id' class='btn btn-primary'>Message</a>";
        break;
}
echo $btn_html;
?>
</div>
    </div>
</div>

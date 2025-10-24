<div class="col-12 col-sm-12 col-md-12 col-lg-6">
    <div class="friend-box d-flex justify-content-between align-items-center">
        <div class="media iitem-1">
            <a href="profile.php?uid=<?= $id ?>" class="user-img">
                <img src="<?= $profile_pic ?>" class="img-fluid blur-up lazyload bg-img" alt="<?= htmlspecialchars($firstname) ?>" style='border-radius:5px;'>
                <span class="available-stats"></span>
            </a>
            <div class="media-body">
                <a href="profile.php?uid=<?= $id ?>">
                    <h5 class="user-name"><?= htmlspecialchars($firstname) ?> <?= $lastname ?> (<?= $age ?>)</h5>
                </a>
                <h6><?= htmlspecialchars($location) ?> — <?= ucfirst($gender) ?></h6>
                <div class="text-muted">Match: <?= $score ?>%</div>
            </div>
        </div>
        <div class='iitem-2'>
            <button type='button' class='btn btn-outline toggle-friend' data-receiver='$id'>Add Friend</button>
        </div>
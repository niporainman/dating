<?php
session_start();
require_once '../minks1.php';
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5/dist/fancybox/fancybox.css" />
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5/dist/fancybox/fancybox.umd.js"></script>


<?php
$link = "https://sparktwice.com";
//$link = "http://localhost/sparktwice";

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) exit;

$stmt = $con->prepare("SELECT id, file FROM files WHERE user_id = ? AND file_type = 'video'");
$stmt->bind_param("s", $user_id);
$stmt->execute();
$stmt->bind_result($id, $file);

while ($stmt->fetch()) {
?>
<div class="col-xl-3 col-lg-4 col-6">
    <div class="portfolio-image">
        <a data-fancybox href="users/<?= $user_id ?>/<?= $file ?>" data-caption="Video from gallery">
              <video
                    style="width: 100%; object-fit: cover;"
                    height="250"
                    muted
                    preload="metadata"
                    poster="images/thumbnail.jpg">
                    <source src="users/<?= $user_id ?>/<?= $file ?>" type="video/mp4">
                    Your browser does not support video.
                </video>
        </a>

        <div class="settings">
            <div class="setting-btn setting-dropdown">
                <div class=" btn-group custom-dropdown arrow-none dropdown-sm">
                    <a href="#" class="d-flex" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="icon icon-dark stroke-width-3 iw-11 ih-11" data-feather="sun"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right custom-dropdown">
                        <ul>
                            <li>
                                <a data-id="<?= $id ?>" class='delete-video'><i class="icon-font-light iw-16 ih-16" data-feather="trash-2"></i>Delete Video</a>
                            </li>
                            <li>
                                <a href="<?php echo "$link/users/$user_id/$file" ?>" download><i class="icon-font-light iw-16 ih-16" data-feather="download"></i>Download</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 
<?php
}
?>

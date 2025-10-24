<?php
session_start();
require_once '../minks1.php';
?>
<link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js"></script>

<?php
//$link = "https://sparktwice.com";
$link = "http://localhost/sparktwice";

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) exit;

$stmt = $con->prepare("SELECT id, file FROM files WHERE user_id = ? AND file_type = 'image'");
$stmt->bind_param("s", $user_id);
$stmt->execute();
$stmt->bind_result($id, $file);

while ($stmt->fetch()) {
?>
<div class="col-xl-3 col-lg-4 col-6">
    <div class="portfolio-image">
        <a href="users/<?= $user_id ?>/<?= $file ?>" data-lightbox="user-gallery">
            <img src="users/<?= $user_id ?>/<?= $file ?>" alt="" class="img-fluid blur-up lazyload bg-img" style='object-fit:cover; height:250px; width:100%;'>
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
                                <a data-id="<?= $id ?>" class='delete-photo'><i class="icon-font-light iw-16 ih-16" data-feather="trash-2"></i>Delete Photo</a>
                            </li>
                            <li>
                                <a href="<?php echo "$link/users/$user_id/$file" ?>" download><i class="icon-font-light iw-16 ih-16" data-feather="download"></i>Download</a>
                            </li>
                            <li>
                                <a data-id="<?= $id ?>" class='set-profile'><i class="icon-font-light iw-16 ih-16" data-feather="image"></i>Set as profile photo</a>
                            </li>
                            <li>
                                <a data-id='<?= $id ?>' class='set-background'><i class="icon-font-light iw-16 ih-16" data-feather="image"></i>Set as background</a>
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

<?php session_start();
$page_name = basename($_SERVER['PHP_SELF']); 
include("headerstrict.php"); ?>
<?php $page_title = "Users"; $page_title_url = "users_"; ?>
<title><?php echo $company_name; ?> - <?= $page_title ?></title>
<!-- Body main section starts -->
<main>
    <div class="container-fluid">
        <div class="row mt-4 mb-4">
            <div class="col-12">
                <h4 class="main-title"><?= $page_title ?></h4> 
            </div>
        </div>
        <div id="data" class='row blog-section'></div>

    </div>
</main>
<?php include("footer.php"); ?>
<link href="assets/vendor/summernote/summernote-bs5.css" rel="stylesheet">
<script src="assets/vendor/summernote/summernote-bs5.js"></script>
<script src="https://cdn.jsdelivr.net/gh/perevoshchikov/summernote-grid@1.0.0/summernote-grid.min.js"></script>
<script>
    const pageTitleUrl = "<?= $page_title_url ?>";
    const pageName = "<?= $page_name ?>";
</script>
<script src="script.js"></script>

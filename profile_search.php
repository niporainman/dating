<?php session_start();
$page_name = basename($_SERVER['PHP_SELF']); 
include("profile_header.php"); ?>
<title><?php echo $company_name; ?> - Profile Match Search</title>



<div class="page-center">
    <!--  event cover start -->
    <div class="event-cover">
        <div class="event-img">
            <img src="images/cover.jpg" class="img-fluid blur-up lazyload bg-img" alt="">
            <div class="event-content">
                <h1>FIND YOUR SPARK</h1>
            </div>
            <div class="cover-img-detail">
                <span><?php $todays_date = date("jS, F Y"); echo $todays_date; ?></span>
                <h3>Hello <?= $first_name ?>!</h3>
            </div>
            
        </div>
    </div>
    <!--  event cover end -->
    <div class="container-fluid section-t-space px-0">
        <div class="row">
            <div class="content-center col-xl-12">
                <!-- search table start -->
                <div>
                    <div class="weather-search section-t-space">
                        <div class="card-title">
                            <h3>Advanced search</h3>
                        </div>
                       
<form class="theme-form" id="searchForm">
    <!-- Search by Location -->
    <div class="input-group">
        <input class="form-control" type="text" name="location" placeholder="Search location">
    </div>

        <!-- Looking For -->
    <div class="input-group">
        <select class="custom-select" name="looking_for">
            <option value="">Looking for</option>
            <option value="Casual Dating">Casual Dating</option>
            <option value="Serious Relationship">Serious Relationship</option>
        </select>
    </div>

    <!-- Looking For -->
    <div class="input-group">
        <select class="custom-select" name="gender">
            <option value="">Gender</option>
            <option value="male">Men</option>
            <option value="female">Women</option>
        </select>
    </div>

    <!-- Age Range -->
    <div class="input-group">
        <select class="custom-select" name="min_age">
            <option value="">Min Age</option>
            <?php for ($i = 18; $i <= 80; $i++): ?>
                <option value="<?= $i ?>"><?= $i ?></option>
            <?php endfor; ?>
        </select>
    </div>

    <div class="input-group">
        <select class="custom-select" name="max_age">
            <option value="">Max Age</option>
            <?php for ($i = 18; $i <= 80; $i++): ?>
                <option value="<?= $i ?>"><?= $i ?></option>
            <?php endfor; ?>
        </select>
    </div>

    <!-- Religion -->
    <div class="input-group">
        <select class="custom-select" name="religion">
            <option value="">Religion...</option>
            <option value="christian">Christian</option>
            <option value="muslim">Muslim</option>
            <option value="traditional">Traditional</option>
            <option value="none">None</option>
        </select>
    </div>

    <!-- Button -->
    <div class="btn-section text-right">
        <button type="submit" class="btn btn-solid">Search</button>
    </div>
</form>

                    </div>
                </div>
                <!-- search table end -->
                
                <div class="friend-list-box section-t-space section-b-space">
                    <div class="container-fluid">
                        <div class="friend-list row"  id="searchResults"></div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    

    

</div>

<?php include("profile_chat_snippet.php"); ?>
<?php include("profile_footer.php"); ?>

   
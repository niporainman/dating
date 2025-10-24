<?php session_start();
$page_name = basename($_SERVER['PHP_SELF']); 
$page_header = "blog_header.jpg";
include("header.php"); ?>
<title><?php echo $company_name; ?> - Search Blog</title>
<link rel="stylesheet" href="blog.css">
<?php $page_title = "Search Blog"; ?>
<?php include("page_header.php"); ?>
  	 <br><br>
 
  <section class="section-b-space pt-0">
    <div class="custom-container container blog-page">
      <div class="row gy-4">
        <div class="col-xl-9 col-lg-8 ratio50_2">
          
          <?php
if(isset($_POST["search_for"])){
	$search_term = $_POST["search"];
	$search_term = trim("$search_term");
}
?>
<?php
	if(isset($_POST["search_for"])){					
	$product_query = "SELECT * FROM blog WHERE keywords LIKE '%$search_term%' ORDER BY id DESC
	";
	$run_query = mysqli_query($con,$product_query);
	$numrows = mysqli_num_rows($run_query);
	if(mysqli_num_rows($run_query) > 0){
		echo"
	<div class='row gy-4'>
	<form method='post' action='$link' style='width:100%;margin:auto;'>
		<h4>You searched for \"$search_term\", $numrows result(s) found.</h4>
		<input class='btn btn_black rounded sm' style='width:100px;' type='submit' name='back' value='Back'><br/><br/>
	</form>
	<br/><br/>
	</div>
	<div class='row gy-4 sticky'>
	";
		while($row_back_deals = mysqli_fetch_array($run_query)){
			$article_id = $row_back_deals['blog_id'];
			$title = $row_back_deals['heading'];
			$category_id = $row_back_deals['category'];
			$preamble = $row_back_deals['preamble'];
			$paragraph = $row_back_deals['body'];
			$picture = $row_back_deals['picture'];
			$featured = $row_back_deals['featured'];
			$blog_date = $row_back_deals['date'];
			$keywords = $row_back_deals['keywords'];
			$comments_allowed = $row_back_deals['comments_allowed'];
			$blog_date = new DateTime($blog_date);
      $blog_date_formatted = $blog_date->format('F j, Y'); 
			$stmt_cat = $con -> prepare('SELECT * FROM blog_categories WHERE id = ?');
			$stmt_cat -> bind_param('i',$category_id);
			$stmt_cat -> execute(); 
			$stmt_cat -> store_result(); 
			$stmt_cat -> bind_result($cat_idd,$category_name); 
      while ($stmt_cat -> fetch()){}

?>    
            <div class="col-xl-4 col-sm-6">
              <div class="blog-main-box">
              <div>
                                <div class="blog-img"> 
                                  <img class="img-fluid bg-img" src="site_img/blog/<?php echo $picture; ?>" alt="">
                              
                                </div>
                            </div>
                            <div class="blog-content"><?php echo $category_name; ?>
                                <span class="blog-date"><?= $blog_date_formatted ?></span>
                <a
                    href="article_details?article_id=<?php echo $article_id; ?>">
                    <h4><?php echo $title; ?></h4>
                  </a>
                  <p><?php echo $preamble; ?></p>
                  <div class="share-box">
                    <div class="d-flex align-items-center gap-2">
                      <h6></h6>
                    </div><a class="btn btn_primary rounded" href="article_details?article_id=<?php echo $article_id; ?>"> Read More</a>
                  </div>
                </div>
              </div>
            </div>
            <?php
		}
	}
	else{echo"
	<form method='post' action='$link' style='width:100%;margin:auto;'>
		<h4>You searched for \"$search_term\", $numrows result(s) found.</h4>
		<button class='btn btn_black rounded sm' style='width:100px;' type='submit' name='back'>Back</button>
	</form>
	<br/>
	<div class='row gy-4 sticky'>
	";}
	}
	else{echo"<div class='row gy-4 sticky'>";}
?>


           

          </div>
        </div>
        <div class="col-xl-3 col-lg-4">
          <div class="blog-sidebar">
            <div class="row gy-4">
              <div class="col-12">
              <form action="search_blog" method='post' class='no_style'>
                <div class="blog-search"> <input name='search' type="search" placeholder="Search Here..." required>
                <button type='submit' name='search_for'>
                  <i class="iconsax" data-icon="search-normal-2"></i>
                </button>
                </div>
              </form>
              </div>
              <div class="col-12">
                <div class="sidebar-box">
                  <div class="sidebar-title">
                    <div class="loader-line"></div>
                    <h5> Categories</h5>
                  </div>
                  <ul class="categories">
                  <?php
	$stmt = $con -> prepare('SELECT * FROM blog_categories'); 
	$stmt -> execute(); 
	$stmt -> store_result(); 
	$stmt -> bind_result($catt_id,$category_name); 
	$numrows = $stmt -> num_rows();
	if($numrows > 0){
		while ($stmt -> fetch()) {
			$stmt_fun = $con -> prepare('SELECT id FROM blog WHERE category=?');
			$stmt_fun -> bind_param('i',$catt_id);
			$stmt_fun -> execute(); 
			$stmt_fun -> store_result(); 
			$stmt_fun -> bind_result($caid); 
			$numrows_fun = $stmt_fun -> num_rows();
		
?>
<li><p><a href="blog_category_details?category_id=<?php echo $catt_id; ?>"><?php echo $category_name ?></a><span><?php echo $numrows_fun; ?></span></p></li>
	<?php } } ?>
                    
                  </ul>
                </div>
              </div>
              <div class="col-12">
                <div class="sidebar-box">
                  <div class="sidebar-title">
                    <div class="loader-line"></div>
                    <h5> Featured Posts</h5>
                  </div>
                  <ul class="top-post">
  <?php $yes="Yes";$four=4;
	$stmt_f = $con -> prepare('SELECT * FROM blog WHERE featured=? ORDER BY RAND() LIMIT ?');
	$stmt_f -> bind_param('si',$yes,$four);
	$stmt_f -> execute(); 
	$stmt_f -> store_result(); 
	$stmt_f -> bind_result($idf,$article_idf,$titlef,$category_idf,$preamblef,$paragraphf,$picturef,$featuredf,$datef,$keywordsf,$comments_allowedf); 
	$numrows_f = $stmt_f -> num_rows();
		
	if($numrows_f > 0){
		while ($stmt_f -> fetch()) {
			$stmt_cat = $con -> prepare('SELECT * FROM blog_categories WHERE id = ?');
		$stmt_cat -> bind_param('i',$category_idf);
		$stmt_cat -> execute(); 
		$stmt_cat -> store_result(); 
		$stmt_cat -> bind_result($cat_iddf,$category_namef); 
		while ($stmt_cat -> fetch()){}
			
			$datef = new DateTime($datef);
			$blog_date_f = $datef->format('F j, Y'); 
		?>
                    <li> <img class="img-fluid" src="site_img/blog/<?php echo $picturef; ?>" alt="">
                      <div> <a href="article_details?article_id=<?php echo $article_idf; ?>">
                          <h6><?php echo $titlef; ?></h6>
                        </a>
                        <p><?= $blog_date_f ?></p>
                      </div>
                    </li>
<?php } } ?>
                   
                  </ul>
                </div>
              </div>
              
              
              <div class="col-12 d-none d-lg-block">
                
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
 <?php include("footer.php"); ?>
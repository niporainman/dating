<?php session_start();
$page_name = basename($_SERVER['PHP_SELF']);
$page_title = "Frequently Asked Questions";
$page_header = "faqs_header.jpg";
include("header.php"); ?>
<title><?php echo $company_name; ?> - <?php echo $page_title; ?></title>
<?php include("page_header.php"); ?>
<br><br>

<!--FAQ One Start-->
<section class="faq-one">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12 col-lg-12">
                        <div class="faq-one__single">
                            <div class="accrodion-grp faq-one-accrodion" data-grp-name="faq-one-accrodion-1">
                                <div class='row'>
<?php
	$stmt = $con -> prepare('SELECT * FROM faqs');
	$stmt -> execute(); 
	$stmt -> store_result(); 
	$stmt -> bind_result($id,$question,$answer); 
	$numrows = $stmt -> num_rows();
	if($numrows > 0){
		while ($stmt -> fetch()) { 
?>
<div class='col-xl-6 col-lg-6'>
                                <div class="accrodion">
                                    <div class="accrodion-title">
                                        <h4><span>?</span> <?= $question ?></h4>
                                    </div>
                                    <div class="accrodion-content">
                                        <div class="inner">
                                            <p><?= $answer ?></p>
                                        </div><!-- /.inner -->
                                    </div>
                                </div> <br>
        </div>
<?php } } ?>
        </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </section>
        <!--FAQ One End-->
<?php include("footer.php"); ?>
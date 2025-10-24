<?php use PHPMailer\PHPMailer\PHPMailer;use PHPMailer\PHPMailer\Exception;use PHPMailer\PHPMailer\SMTP; session_start();
$page_name = basename($_SERVER['PHP_SELF']); 
$page_title = "Contact us";
$page_header = "contact_header.jpg";
include("header.php"); ?>
<title><?php echo $company_name; ?> - <?php echo $page_title; ?></title>
<?php include("page_header.php"); ?>

<?php 
$msg='';$captcha_error=""; $errors=0;

if (isset($_POST["send_message"])) {
	
include("captcha_start.php");
if($errors == 0){
	
	$subject = mysqli_real_escape_string($con,$_POST['subject']);
	$last_name = mysqli_real_escape_string($con,$_POST['last_name']);
	$first_name = mysqli_real_escape_string($con,$_POST['first_name']);
	$email = mysqli_real_escape_string($con,$_POST['email']);
	$message1 = mysqli_real_escape_string($con,$_POST['message']);
	
	$msg = '';
	require 'PHPMailer/src/PHPMailer.php'; 
	require 'PHPMailer/src/SMTP.php'; 
	require 'PHPMailer/src/Exception.php';

	$mail = new PHPMailer();
	$mail->IsSMTP(); // telling the class to use SMTP
	$mail->SMTPAuth = true; // enable SMTP authentication
	$mail->Host = "smtp.hostinger.com"; // sets the SMTP server
	$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Set encryption to STARTTLS
    $mail->Port = 587; // Use port 587 for TLS
	$mail->Username = "$no_reply_email"; // SMTP account username
	$mail->Password = "$no_reply_password"; // SMTP account password

	$mail->SetFrom("$company_email", "$company_name");//Use a fixed address in your own domain as the from address
	$mail->AddReplyTo("$email","$email"); //Put the submitter's address in a reply-to header
	$mail->Subject = "$subject";
	$mail->MsgHTML("<html><body>$message1</body></html>");
	$mail->AddAddress("$company_email", "Contact Form");//Send the message to yourself, or whoever should receive contact for submissions
	 
	//$mail->AddAttachment(""); // attachment

		if(!$mail->Send()) {
		//echo "Mailer Error: " . $mail->ErrorInfo;
		$msg = "<div class='alert alert-danger'>
					<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
					<b>Something went wrong, please try again</b>
				</div>";
		} 
		else {
		$msg = "<div class='alert alert-success'>
					<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
					<b>Email Sent</b>
				</div>";
		}
		//email an autoresponse to the person too
	$mail->clearAddresses();
	$mail->clearReplyTos();
	
		$subject1 = "Thanks for contacting us"; // form field
		$message="";
		$button_link="$link/signin.php";
		$button_text="Log in";
		$email_topic="Thanks for contacting us";
		include("email_header.php");
		$message .=	"
		Dear $first_name,<br/><br/>
		Thank you for contacting our support team. Your request is in progress and is being worked on by our service team. We are prioritizing your request and will notify you via email.
		<br/><br/>
		The $company_name Team.<br/>
		$email_logo
		 ";
		 include("email_footer.php");
$mail->SetFrom("$company_email", "$company_name");//Use a fixed address in your own domain as the from add
$mail->AddAddress("$email", "$email");//Send the message to yourself, or whoever should receive contact for submissions
$mail->AddReplyTo("$company_email", "$company_name"); //Put the submitter's address in a reply-to header
$mail->Subject = "$subject1";
$mail->MsgHTML("<html><body>$message<br></body></html>");
	if(!$mail->Send()) {
	//echo "Mailer Error: " . $mail->ErrorInfo;
	$msg = "Email not sent, please try again Mailer Error: ".$mail->ErrorInfo;
	} 
	else {
	//echo "Thanks for getting in touch, we will get back to ASAP";
	$msg = "<span style='color:steelblue;'>Hey $first_name thanks for getting in touch with us, we will get back to you very shortly!</span>";
	}
}
}

?>

        <!--Contact Page Start-->
        <section class="contact-page">
            <div class="container">
                <div class="row">
                    <div class="col-xl-4 col-lg-5">
                        <div class="contact-page__left">
                            <div class="section-title text-left">
                                <div class="section-sub-title-box">
                                    <p class="section-sub-title">Contact us</p>
                                    <div class="section-title-shape-1">
                                        <img src="assets/images/shapes/section-title-shape-1.png" alt="">
                                    </div>
                                    <div class="section-title-shape-2">
                                        <img src="assets/images/shapes/section-title-shape-2.png" alt="">
                                    </div>
                                </div>
                                <h2 class="section-title__title">Feel free to get in touch with us</h2>
                            </div>
                            <div class="contact-page__call-email">
                                <div class="contact-page__call-icon">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <div class="contact-page__call-email-content">
                                    <h4>
                                        <a href="tel:<?= $company_phone ?>" class="contact-page__call-number"><?= $company_phone ?></a>
                                        <a href=""
                                            class="contact-page__email"><?= $company_email ?></a>
                                    </h4>
                                </div>
                            </div>
                            <p class="contact-page__location-text"><?= $company_address ?></p>
                        </div>
                    </div>
                    <div class="col-xl-8 col-lg-7">
                        <div class="contact-page__right">
                            <div class="contact-page__form">
                            <h2><?php $msg ?></h2>
                            
                                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" class="comment-one__form contact-form-validated"
                                    novalidate="novalidate">
                                    <div class="row">
                                        <div class="col-xl-6">
                                            <div class="comment-form__input-box">
                                                <input type="text" placeholder="First name" name="first_name" required>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="comment-form__input-box">
                                                <input type="text" placeholder="Last name" name="last_name" required>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="comment-form__input-box">
                                                <input type="email" placeholder="Email address" name="email" required>
                                            </div>
                                        </div>
                                        
                                        <div class="col-xl-6">
                                            <div class="comment-form__input-box">
                                                <input type="text" placeholder="Subject" name="subject" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="comment-form__input-box text-message-box">
                                                <textarea name="message" placeholder="Write a message" required></textarea>
                                            </div>
                                            <div class="comment-form__btn-box">
                                                <button type="submit" name='send_message' class="thm-btn comment-form__btn">Send
                                                    Message</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--Contact Page End-->

       

        <!--Google Map Start-->
        <section class="google-map-two">
          
        </section>
        <!--Google Map End-->
<?php include("footer.php"); ?>
<?php use PHPMailer\PHPMailer\PHPMailer;use PHPMailer\PHPMailer\Exception;use PHPMailer\PHPMailer\SMTP; session_start();
$page_name = basename($_SERVER['PHP_SELF']); 
include("minks.php"); ?>
<title><?php echo $company_name; ?> - Sign up</title>
<?php $errors = 0;
if (isset($_POST["sign_up"])) {
	
	$user_id = substr(md5(rand()), 0, 10);
    $username = $_POST['username'];
	$first_name = $_POST['first_name'];
	$last_name = $_POST['last_name'];
	$email = $_POST['email'];
	$password = $_POST['password'];
    $bio = "";
    $dob = "";
    $location = "";
    $country = "";
    $profile_pic = "";
    $profile_background = "";
    $gender = "";
    $looking_for = "";
    $religion = "";
    $acc_approved = "Yes";
    $email_sent = "";
    $email_confirmed = "";
	$date_signed_up = date("Y-m-d H:i:s");
    $keywords = "";
	
	$first_name = trim($first_name);
	$last_name = trim($last_name);
	
	$first_name = strtolower($first_name);
	$last_name = strtolower($last_name);
	
	$first_name = ucwords($first_name);
	$last_name = ucwords($last_name);
	
	//check if the email address is already in database
	$sql = "SELECT email FROM users WHERE email = '$email' LIMIT 1" ;
	$check_query = mysqli_query($con,$sql);
	$count_email = mysqli_num_rows($check_query);
	if($count_email > 0){
		//create a session to verify it's coming from here
		$_SESSION["action"] = "true";
		$message="This email address has already been used.";
		echo "<meta http-equiv=\"refresh\" content=\"0; url=failure.php?u=$page_name&m=$message\">";
		$errors = 1;
		exit();
	}
	
	if($errors ==0 AND isset($_POST['sign_up'])){
			
		//insert email into our email database
		mysqli_query($con,"INSERT INTO email_subscribers VALUES(
		'0',
		'$email'
		)")or die(mysqli_error($con));
			
			$sql = "INSERT INTO users VALUES(
			'0',
			'$user_id',
            '$username',
			'$first_name',
			'$last_name',
			'$email',
			'$password',
			'$bio',
			'$dob',
            '$location',
            '$country',
            '$profile_pic',
            '$profile_background',
            '$gender',
            '$looking_for',
            '$religion',
            '$acc_approved',
            '$email_sent',
            '$email_confirmed',
			'$date_signed_up',
            '$keywords',
            ''
			)";
			$run_query = mysqli_query($con,$sql)or die(mysqli_error($con));
			
			//send them the confirmation email
			
			$msg = '';
			$subject = "$first_name thank you for signing up on $company_name";
			$message="";
			$button_link="$link/signin.php";
			$button_text="Log in";
			$email_topic="You are welcome!";
			include("email_header.php");
			$message .=	"
			Dear $first_name,<br/><br/>
			
			Thank you for signing up with us at $company_name.<br/>If you have any questions please contact our dedicated support staff at $company_email<br/><br/>
			The $company_name Team.<br/><br/>
			$email_logo<br/><br/>
			";
			include("email_footer.php");
			
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
	$mail->SetFrom("$no_reply_email", "$company_name");//Use a fixed address in your own domain as the from address
			$mail->AddReplyTo("$company_email", "$company_name"); //Put the submitter's address in a reply-to header
			$mail->Subject = "$subject";
			$mail->MsgHTML("<html><body>$message<br></body></html>");
			$mail->AddAddress("$email", "$email");//Send the message to yourself, or whoever should receive contact for submissions
			 
			//$mail->AddAttachment(""); // attachment

		/*		if(!$mail->Send()) {
				//echo "Mailer Error: " . $mail->ErrorInfo;
				$msg = "<div class='alert alert-danger'>
							<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
							<b>Something went wrong, please try again</b>
							$mail->ErrorInfo
						</div>";
				} 
				else {
				$msg = "<div class='alert alert-success'>
							<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
							<b>Email Sent</b>
						</div>";
				}
				*/
				//email an autoresponse to the person too
	$mail->clearAddresses();
	$mail->clearReplyTos();
	
		$subject1 = "$first_name $last_name signed up"; // form field
		$message1 = "
		<div style='font-family:Calibri;'>
		Dear Admin,<br/><br/>
		$first_name $last_name just signed up.
		
		
		<br/><br/>
		$email_logo
		</div>
		 ";
$mail->SetFrom("$no_reply_email", "$company_name");//Use a fixed address in your own domain as the from add
$mail->AddAddress("$company_email", "$company_name");//Send the message to yourself, or whoever should receive contact for submissions
$mail->AddReplyTo("$company_email", "$company_name"); //Put the submitter's address in a reply-to header
$mail->Subject = "$subject1";
$mail->MsgHTML("<html><body>$message1<br></body></html>");

	if(!$mail->Send()) {
	//echo "Mailer Error: " . $mail->ErrorInfo;
	$msg = "Email not sent, please try again Mailer Error: ";
	} 
	else {
	//echo "Thanks for getting in touch, we will get back to ASAP";
	$msg = "<span style='color:darkorange;'>Hey $first_name thanks for getting in touch with us, we will get back to you very shortly!</span>";
	}
				
				
	//create the sesssion
	$_SESSION["email"] = $email;
	$_SESSION["user_id"] = $user_id;
	$_SESSION["first_name"] = $first_name;
    $_SESSION["username"] = $username;
							
	//take them to the success page
	echo "<meta http-equiv=\"refresh\" content=\"0; url=profile_home\">";
	exit();
	}	
			
}

?>
<!DOCTYPE html>
    <html lang="en"><head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">
    <link rel="icon" href="assets/images/favicons/favicon.png" type="image/x-icon">
    <title><?= $company_name ?> - Sign up</title>

    <!--Google font-->
     <!-- fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

    <!-- Theme css -->
    <link id="change-link" rel="stylesheet" type="text/css" href="css/style.css">
     <script src="js/jquery-3.6.0.min.js"></script>
</head>

<body>

    <!-- loader start -->
    <div class="loading-text">
        <div>
            <h1 class="animate"><img src='assets/images/logo.png'></h1>
        </div>
    </div>
    <!-- loader end -->


    <!-- login section start -->
    <section class="login-section">
        <div class="header-section">
            <div class="logo-sec">
                <a href="<?= $link ?>">
                    <img src="assets/images/logo.png" alt="logo" class="img-fluid blur-up lazyload" style='height:54px;'>
                </a>
            </div>
            <div class="right-links">
                <ul>
                   
                </ul>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-xl-6 col-lg-5 d-none d-lg-block">
                    <div class="login-welcome">
                        <div>
                            <h1>Find Your Spark!</h1>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-7 col-md-10 col-12 m-auto">
                    <div class="login-form">
                        <div>
                            <div class="login-title">
                                <h2>Create Account</h2>
                            </div>
                            <div class="login-discription">
                                <h4>Welcome to <?= $company_name ?>, please fill all fields
                                </h4>
                            </div>
                            <div class="form-sec">
                                <div>
<form class="theme-form" method='post' action=''>
    <div class="form-group">
        <input type="text" class="form-control" id="first_name" name='first_name' placeholder="First name" required>
        <i class="input-icon iw-20 ih-20" data-feather="user"></i>
    </div>
    <div class="form-group">
        <input type="text" class="form-control" id="last_name" name='last_name' placeholder="Last name" required>
        <i class="input-icon iw-20 ih-20" data-feather="user"></i>
    </div>
    <div class="form-group">
        <span id="username-status"></span>
        <input type="text" class="form-control" id="username" name='username' placeholder="Username" required>
        <i class="input-icon iw-20 ih-20" data-feather="user"></i>
    </div>
    
    <div class="form-group">
        <span id='email-status'></span>
        <input type="email" class="form-control" id="email" placeholder="Email" name='email' required>
        <i class="input-icon iw-20 ih-20" data-feather="at-sign"></i>
    </div>
    <div class="form-group">
        <input type="password" name='password' class="form-control" id="password" placeholder="Password" required>
        <i class="input-icon iw-20 ih-20" data-feather="eye-off" onclick="togglePasswordVisibility()" id="toggleIcon"></i>
            
        
    </div>
    <div class="bottom-sec">
        <div class="form-check checkbox_animate">
            <input type="checkbox" class="form-check-input" id="accept" name='accept' required>
            <label class="form-check-label" for="accept"><a style='color:#333;' href="terms">I agree to the terms and conditions.</a></label>
        </div>
        <a href="forgotpassword" class="ms-auto forget-password">forgot
            password?</a>
        
    </div>
        <a href="signin" class="ms-auto forget-password">Already have an account? Sign in</a>
    <div class="btn-section">
        <button type='submit' name='sign_up' id='submit-btn' class="btn btn-solid btn-lg" disabled>Sign up</button>
        
    </div>
</form>
<script>
  function togglePasswordVisibility() {
    const passwordInput = document.getElementById("password");
    const toggleIcon = document.getElementById("toggleIcon");

    if (passwordInput.type === "password") {
      passwordInput.type = "text";
      toggleIcon.setAttribute("data-feather", "eye");
    } else {
      passwordInput.type = "password";
      toggleIcon.setAttribute("data-feather", "eye-off");
    }

    // Refresh Feather icons
    feather.replace();
  }
</script>
                                   
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </section>
    <!-- login section end -->


    


    <!-- latest jquery-->
   

    <!-- popper js-->
    <script src="js/popper.min.js"></script>

    <!-- slick slider js -->
    <script src="js/slick.js"></script>
    <script src="js/custom-slick.js"></script>

    <!-- feather icon js-->
    <script src="js/feather.min.js"></script>

    <!-- emoji picker js-->
    <script src="js/emojionearea.min.js"></script>

    <!-- Bootstrap js-->
    <script src="js/bootstrap.js"></script>

    <!-- chatbox js -->
    <script src="js/chatbox.js"></script>

    <!-- lazyload js-->
    <script src="js/lazysizes.min.js"></script>

    <!-- theme setting js-->
    <script src="js/theme-setting.js"></script>

    <!-- Theme js-->
    <script src="js/script.js"></script>

    <script>
        feather.replace();
        $(".emojiPicker ").emojioneArea({
            inline: true,
            placement: 'absleft',
            pickerPosition: "top left ",
        });
    </script>

<script>
let usernameValid = false;
let emailValid = false;

const usernameInput = document.getElementById('username');
const emailInput = document.getElementById('email');
const submitBtn = document.getElementById('submit-btn');
const usernameStatus = document.getElementById('username-status');
const emailStatus = document.getElementById('email-status');

function updateSubmitButton() {
    submitBtn.disabled = !(usernameValid && emailValid);
}

usernameInput.addEventListener('input', function() {
    const username = this.value;
    if (username.length === 0) {
        usernameStatus.textContent = '';
        usernameInput.classList.remove('invalid', 'valid');
        usernameValid = false;
        updateSubmitButton();
        return;
    }
    fetch('check_username.php?username=' + encodeURIComponent(username))
        .then(response => response.json())
        .then(data => {
            if (data.exists) {
                usernameStatus.textContent = 'Username already taken';
                usernameStatus.style.color = 'crimson';
                usernameInput.classList.add('invalid');
                usernameInput.classList.remove('valid');
                usernameValid = false;
            } else {
                usernameStatus.textContent = 'Username available';
                usernameStatus.style.color = 'green';
                usernameInput.classList.add('valid');
                usernameInput.classList.remove('invalid');
                usernameValid = true;
            }
            updateSubmitButton();
        });
});

emailInput.addEventListener('input', function() {
    const email = this.value;
    if (email.length === 0) {
        emailStatus.textContent = '';
        emailInput.classList.remove('invalid', 'valid');
        emailValid = false;
        updateSubmitButton();
        return;
    }
    fetch('check_email.php?email=' + encodeURIComponent(email))
        .then(response => response.json())
        .then(data => {
            if (data.exists) {
                emailStatus.textContent = 'Email already registered';
                emailStatus.style.color = 'crimson';
                emailInput.classList.add('invalid');
                emailInput.classList.remove('valid');
                emailValid = false;
            } else {
                emailStatus.textContent = 'Email available';
                emailStatus.style.color = 'green';
                emailInput.classList.add('valid');
                emailInput.classList.remove('invalid');
                emailValid = true;
            }
            updateSubmitButton();
        });
});
</script>



</body></html>
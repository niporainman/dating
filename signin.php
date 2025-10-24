<?php session_start();
$page_name = basename($_SERVER['PHP_SELF']); 
include("minks.php"); ?>
<?php $errors=0; $message = "";
if (isset($_POST["log_in"])) {
	
	$email = $_POST['email'];
	$password = $_POST['password'];
	
	$sql = "SELECT user_id,first_name,email FROM users WHERE email = '$email' AND password='$password' LIMIT 1" ;
		$check_query = mysqli_query($con,$sql);
		$count_email = mysqli_num_rows($check_query);
		if($count_email > 0){
			while ($row_first_name = mysqli_fetch_array($check_query, MYSQLI_ASSOC)) {
				$first_name = $row_first_name['first_name'];
				$user_id = $row_first_name['user_id'];
				$email = $row_first_name['email'];
			}
		}
		
		if($count_email !== 1){
			//create a session to verify it's coming from here
			$_SESSION["action"] = "true";
			$message="Wrong username or password";
			//echo "<meta http-equiv=\"refresh\" content=\"0; url=failure.php?u=$page_name&m=$message\">";exit();
			$errors = 1;
		}
		
	if($errors ==0 AND isset($_POST['log_in'])){
		
	
	
	//create the sesssion
	$_SESSION["email"] = $email;
	$_SESSION["user_id"] = $user_id;
	$_SESSION["first_name"] = $first_name;
							
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
    <title><?= $company_name ?> - Sign in</title>

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
                            <h1>Welcome Back!</h1>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-7 col-md-10 col-12 m-auto">
                    <div class="login-form">
                        <div>
                            <div class="login-title">
                                <h2>Login</h2>
                            </div>
                            <div class="login-discription">
                                <h4>                                </h4>
                            </div>
                            <div class="form-sec">
                                <div>
<form class="theme-form" method='post' action=''>
    
    <div class="form-group">
        <span style='color:crimson;font-weight:900;'><?= $message ?></span>
        <input type="email" class="form-control" id="email" placeholder="Email" name='email' required>
        <i class="input-icon iw-20 ih-20" data-feather="at-sign"></i>
    </div>
    <div class="form-group">
        <input type="password" name='password' class="form-control" id="password" placeholder="Password" required>
        <i class="input-icon iw-20 ih-20" data-feather="eye-off" onclick="togglePasswordVisibility()" id="toggleIcon"></i>
            
        
    </div>
    <div class="bottom-sec">
        <a href="forgotpassword" class="ms-auto forget-password">forgot
            password?</a> 
    </div>
        <a href="signup" class="ms-auto forget-password">Don't have an account? Sign up</a>
    <div class="btn-section">
        <button type='submit' name='log_in' id='submit-btn' class="btn btn-solid btn-lg">Sign in</button>
        
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



</body></html>
<?php require "action.php"; require_once "NumberFormat.php"; $action = new Action(); 

function Is_email($statement) {
    //If the username input string is an e-mail, return true
    if(filter_var($statement, FILTER_VALIDATE_EMAIL)) {
        return true;
    } else {
        return false;
    }
}

?>

<!DOCTYPE html>
<html lang="zxx">

<head>
    <title>Toprate 247</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8" />
    <meta name="author" content="Oluwatayo Adeyemi PeakSMS">
    <meta name="description" content="Exchange Itunes Gift Card, Amazon, bitcoin safely, easily and instant Payment.">
    <meta name="keywords" content="gift, gift cards,itunes, amazon, bitcoin">
    <script>
        addEventListener("load", function () {
            setTimeout(hideURLbar, 0);
        }, false);

        function hideURLbar() {
            window.scrollTo(0, 1);
        }
    </script>
    <!-- Custom Theme files -->
    <link href="css/bootstrap.css" type="text/css" rel="stylesheet" media="all">
    <link href="css/style.css" type="text/css" rel="stylesheet" media="all">
    <!-- font-awesome icons -->
    <link href="css/font-awesome.css" rel="stylesheet">
    <!-- //Custom Theme files -->
    <!-- online-fonts -->
    <link href="//fonts.googleapis.com/css?family=Montserrat:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
</head>


<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">
    <!-- header -->
    <div class="main-header">
        <!-- header top -->
        <div class="header-top text-md-left text-center">
            <div class="container">
                <div class="d-md-flex justify-content-between">
                    <p class="text-capitalize">if you have any question? Call Us +234 903 862 0979  </p>
                    <ul class="social-icons">
                        <li>
                            <a href="#">
                                <i class="fa fa-facebook-f"></i>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="fa fa-twitter"></i>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="fa fa-google-plus" aria-hidden="true"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- //header top -->
        
        <!-- navigation -->
        <header class="main-header">
            <nav class="navbar second navbar-expand-lg navbar-light pagescrollfix">
                <div class="container">
                    <h1>
                        <a class="navbar-brand" href="index">
                            Toprate247
                        </a>
                    </h1>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".navbar-toggle"
                        aria-controls="navbarNavAltMarkup1" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse navbar-toggle" id="navbarNavAltMarkup1">
                        <div class="navbar-nav secondfix ml-lg-auto">
                            <ul class="navbar-nav text-center">
                                <li class="nav-item mr-lg-3"> <a class="nav-link" href="index">Home </a> </li>
                               
                                <li class="nav-item mr-lg-3"> <a class="nav-link" href="stores/market"><i class="fa fa-apple"></i> Sell iTunes</a> </li>
                                <li class="nav-item mr-lg-3"> <a class="nav-link" href="stores/market"><i class="fa fa-amazon"></i> Sell Amazon</a> </li>
                                <li class="nav-item mr-lg-3"> <a class="nav-link" href="stores/market"><i class="fa fa-bitcoin"></i> Sell BitCoin</a> </li>
                                <li class="nav-item mr-lg-3"> <a class="nav-link" href="login"><i class="fa fa-sign-in"></i> Login</a> </li>
                                <li class="nav-item active mr-lg-3"> <a class="nav-link" href="register"><i class="fa fa-user-plus"></i> Create Account</a> </li>
                                
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>
        </header>
        <!-- navigation -->
    </div>
    <!-- //header -->
    
    <section class="offer-wthree py-lg-5 py-3" style="margin-bottom: 5%; margin-top: -1%;">
		<div class="container">
			<div class="col-md-12">
				<div class="row">
					
					<div class="col-md-3"></div>
					
					<div class="col-md-6" style="margin-top: 2%">
					    
					    <?php
						//Client register...
if(isset($_REQUEST["regClient"])) {
    $email = $_POST["username"];
    $password = $_POST["password"];
    $gsm = $_POST["gsm"];
    $checkUserInput = Is_email($email);

    $phone = str_replace("+", "", $gsm);
    $nf = new NumberFormat($phone);
    $nf->finalResult();
    $clientNum = $nf->finalResult();
    foreach(explode(",",$clientNum) as $clientNumb){
        if(!empty($clientNumb) && is_numeric($clientNumb) && strlen($clientNumb) > 11){
            $rcv[] = $clientNumb;
        }
    }
    $clientNumb =  implode(',', $rcv);
    $clientNumber = $clientNumb;

    if(empty($email) || empty($password) || empty($gsm)) {
        echo $action->error("Please fill all field");
    } else if(empty($clientNumber)){
        echo $action->error("Invalid mobile number provided");
    } else if(!$checkUserInput){
        echo $action->error("Email address is invalid");
    } else if($action->userExist($email) == 1) {
        echo $action->error("Email already associated to an account");
    } else {
        $password = md5($password);
        if($action->saveUser($email, $password, $referralcode, $clientNumber) == true) {


            //Email Message Aspect

            // set content type header for html email
            $headers  = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            // set additional headers
            $headers .= 'From:  noreply@toprate247.com <noreply@toprate247.com>' . "\r\n".'X-Mailer: PHP/' . phpversion();
            $subject = "Profile Created!";
            $body= "<html>
<head>
<title>Profile Created</title>
</head>
<body>

<div style='margin-top: 10px; font-family: Helvetica,Verdana,Arial,sans-serif; font-size: 17px; line-height: 21px; padding-left: 19px; padding-right: 30px; color: rebeccapurple;'>
Hi <b>".$email ."</b> <br>
Your profile has been created. <br> We promise to make your stay a worthwhile.
<br>
Regards<br>
NiraTrade Mgt.
<br><br>
<hr>
<small><i>This is an auto-generated email, do not reply!</i></small>
</div></body></html>";
            mail($email, $subject, $body, $headers);
        ?>
        <script>
            alert("Registration was successful");
            window.location = 'login'
        </script>
        <?php } else {
            echo $action->error("Error occurred while processing request");
        }
    }
}
?>

						<div class="modal-header  bg-theme2">
							<h5 class="modal-title"><i class="fa fa-user-plus"></i> Create Account</h5>
						</div>
						
						
						<div class="modal-body  bg-theme1">
							<form method="post">
								<div class="form-group">
									<label for="username" class="col-form-label text-white">Email Address</label>
									<input type="text" class="form-control border" placeholder="Enter email address" name="username" id="username" required="">
								</div>
								<div class="form-group">
									<label for="gsm" class="col-form-label text-white">Mobile Number</label>
									<input type="text" class="form-control border" placeholder="Enter a valid mobile number" name="gsm" id="gsm" required="">
								</div>
								<div class="form-group">
									<label for="password" class="col-form-label text-white">Password</label>
									<input type="password" class="form-control border" placeholder="Enter your password" name="password" id="password" required="">
								</div>
								<div class="right-w3l">
									<input type="submit" name="regClient" class="form-control bg-theme1 text-white" value="Register">
								</div>
							</form>
						</div>
					</div>
					
					<div class="col-md-3"></div>
					
				</div>
			</div>
		</div>
	</section>
    
    <!-- footer -->
    <footer>
        <div class="container">
            <div class="cpy-right text-center">
                <p><b>© 2018/<?php echo date("Y");?> TOPRATE247. Developed By Toprate Team</b></p>
            </div>
        </div>
    </footer>
    <!-- //footer -->
    
    <!-- js -->
    <script src="js/jquery-2.2.3.min.js"></script>
    <!-- //js -->
    <!-- fixed-scroll-nav-js -->
    <script src="js/scrolling-nav.js"></script>
    <script>
        $(window).scroll(function () {
            if ($(document).scrollTop() > 70) {
                $('nav.pagescrollfix,nav.RWDpagescrollfix').addClass('shrink');
            } else {
                $('nav.pagescrollfix,nav.RWDpagescrollfix').removeClass('shrink');
            }
        });
    </script>
    <!-- //fixed-scroll-nav-js -->
    <!-- count down -->
    <script src="js/count-down.js"></script>
    <!-- //count down -->
    <!-- script for password match -->
    <script>
        window.onload = function () {
            document.getElementById("password1").onchange = validatePassword;
            document.getElementById("password2").onchange = validatePassword;
        }

        function validatePassword() {
            var pass2 = document.getElementById("password2").value;
            var pass1 = document.getElementById("password1").value;
            if (pass1 != pass2)
                document.getElementById("password2").setCustomValidity("Passwords Don't Match");
            else
                document.getElementById("password2").setCustomValidity('');
            //empty string means no validation error
        }
    </script>
    <!-- script for password match -->
    <!-- start-smooth-scrolling -->
    <script src="js/move-top.js"></script>
    <script src="js/easing.js"></script>
    <script>
        jQuery(document).ready(function ($) {
            $(".scroll").click(function (event) {
                event.preventDefault();

                $('html,body').animate({
                    scrollTop: $(this.hash).offset().top
                }, 1000);
            });
        });
    </script>
    <!-- //end-smooth-scrolling -->
    <!-- smooth-scrolling-of-move-up -->
    <script>
        $(document).ready(function () {
            /*
            var defaults = {
                containerID: 'toTop', // fading element id
                containerHoverID: 'toTopHover', // fading element hover id
                scrollSpeed: 1200,
                easingType: 'linear' 
            };
            */

            $().UItoTop({
                easingType: 'easeOutQuart'
            });

        });
    </script>
    <script src="js/SmoothScroll.min.js"></script>
    <!-- //smooth-scrolling-of-move-up -->
    <!-- Bootstrap core JavaScript
================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/bootstrap.js"></script>
</body>

</html>
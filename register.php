<?php
/*****************************************
 * SIT203 Web Programming
 * Assignment 2
 * Aaron Pethybridge
 * Student#: 217561644
 * Register / login forms page 
 *****************************************/
// Include functions
require_once('inc/basketutils.php');
require_once('inc/menuheader.php');
require_once('inc/shopping.php');
// Start the session
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="robots" content="all,follow">
    <meta name="googlebot" content="index,follow,snippet,archive">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Universal Your furniture Shop">
    <meta name="author" content="Ondrej Svestka | ondrejsvestka.cz, modified by Shang Gao Deakin Uni June 2018.">
    <meta name="keywords" content="">

    <title>
        Universal : Your Furniture Shop
    </title>

    <meta name="keywords" content="">

    <link href='http://fonts.googleapis.com/css?family=Roboto:400,500,700,300,100' rel='stylesheet' type='text/css'>

    <!-- styles -->
    <link href="css/font-awesome.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/animate.min.css" rel="stylesheet">
    <link href="css/owl.carousel.css" rel="stylesheet">
    <link href="css/owl.theme.css" rel="stylesheet">

    <!-- theme stylesheet -->
    <link href="css/style.default.css" rel="stylesheet" id="theme-stylesheet">

    <!-- your stylesheet with modifications -->
    <link href="css/custom.css" rel="stylesheet">

    <script src="js/respond.min.js"></script>

    <link rel="shortcut icon" href="favicon.png">

	<script src="js/sit203ass1.js"></script> <!-- External js file for SIT203 Assignments -->

</head>
	<?php renderMenuHeader(); ?>
<body>
    
    <div id="all">

        <div id="content">
            <div class="container">

                <div class="col-md-12">

                    <ul class="breadcrumb">
                        <li><a href="index.php">Home</a>
                        </li>
                        <li>New account / Sign in</li>
                    </ul>

                </div>

                <div class="col-md-6">
                    <div class="box">
                        <h1>New account</h1>

                        <p class="lead">Not our registered customer yet?</p>
                        <p>With registration with us new world of fashion, fantastic discounts and much more opens to you! The whole process will not take you more than a minute!</p>
                        <p class="text-muted">If you have any questions, please feel free to <a href="contact.php">contact us</a>, our customer service center is working for you 24/7.</p>

                        <hr>

                        <form action="customer-account.php" method="post">
                            <div class="form-group">
                                <label for="name">First name</label>
                                <input type="text" class="form-control" name="regfname" id="regfname">
                            </div>
							<div class="form-group">
                                <label for="name">Last name</label>
                                <input type="text" class="form-control" name="reglname" id="reglname">
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" class="form-control" name="regemail" id="regemail">
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" name="regpasswd" id="regpasswd">
                            </div>
                            <div class="text-center">
								<input type="hidden" name="loginaction" value="register">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-user-md"></i> Register</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="box">
                        <h1>Login</h1>

                        <p class="lead">Already our customer?</p>
                        <p>Please login.</p>

                        <hr>

                        <form action="customer-account.php" method="post">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input name="loginname" type="text" class="form-control" name="loginname" id="loginname">
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input name="loginpassword" type="password" class="form-control" name="loginpassword" id="loginpassword">
                            </div>
                            <div class="text-center">
								<input type="hidden" name="loginaction" value="login">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-sign-in"></i> Log in</button>
                            </div>
                        </form>
                    </div>
                </div>


            </div>
            <!-- /.container -->
        </div>
        <!-- /#content -->

		<?php renderFooter(); ?>
        <!-- *** COPYRIGHT ***
 _________________________________________________________ -->
        <div id="copyright">
            <div class="container">
                <div class="col-md-6">
                    <p class="pull-left">© 2018 Universal Ltd.</p>

                </div>
                <div class="col-md-6">
                    <p class="pull-right">Template by <a href="https://bootstrapious.com/e-commerce-templates">Bootstrapious.com</a>
                         <!-- Not removing these links is part of the license conditions of the template. Thanks for understanding :) If you want to use the template without the attribution links, you can do so after supporting further themes development at https://bootstrapious.com/donate  -->
                    </p>
                </div>
            </div>
        </div>
        <!-- *** COPYRIGHT END *** -->



    </div>
    <!-- /#all -->


    

    <!-- *** SCRIPTS TO INCLUDE ***
 _________________________________________________________ -->
    <script src="js/jquery-1.11.0.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.cookie.js"></script>
    <script src="js/waypoints.min.js"></script>
    <script src="js/modernizr.js"></script>
    <script src="js/bootstrap-hover-dropdown.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/front.js"></script>



</body>

</html>

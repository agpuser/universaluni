<?php
/*****************************************
 * SIT203 Web Programming
 * Assignment 2
 * Aaron Pethybridge
 * Student#: 217561644
 * Checkout page - Contact/shipping form 
 *****************************************/
// Include functions
require_once('inc/basketutils.php');
require_once('inc/menuheader.php');
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

<body>
	<?php renderMenuHeader(); ?>
    <div id="all">

        <div id="content">
            <div class="container">

                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li><a href="index.php">Home</a>
                        </li>
                        <li>Checkout - Address</li>
                    </ul>
                </div>
                <div class="col-md-9" id="checkout">
                    <div class="box">
                        <form method="post" action="checkout2.php">
                            <h1>Checkout</h1>
                            <ul class="nav nav-pills nav-justified">
                                <li class="active"><a href="#"><i class="fa fa-map-marker"></i><br>Address</a>
                                </li>
                                <!-- <li class="disabled"><a href="#"><i class="fa fa-truck"></i><br>Delivery Method</a>
                                </li> -->
                                <li class="disabled"><a href="#"><i class="fa fa-money"></i><br>Payment Method</a>
                                </li>
                                <li class="disabled"><a href="#"><i class="fa fa-eye"></i><br>Order Review</a>
                                </li>
                            </ul>
                            <div class="content">
								<p class="from-group text-muted">* field is compulsory.</p> <!-- added by Shang -->
								
                                <div class="row">									
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="firstname">Firstname *</label>
											<?php
											if (!loggedIn)
												echo('<input type="text" class="form-control" name="firstname" id="firstname">');
											else
												echo('<input type="text" class="form-control" name="firstname" id="firstname" value="'.$_SESSION['ufirstname'].'">');
											?>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="lastname">Lastname *</label>
                                            <?php
											if (!loggedIn)
												echo('<input type="text" class="form-control" name="lastname" id="lastname">');
											else
												echo('<input type="text" class="form-control" name="lastname" id="lastname" value="'.$_SESSION['ulastname'].'">');
											?>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.row -->

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="address">Address *</label>
                                            <?php
											if (!loggedIn)
												echo('<input type="text" class="form-control" name="address" id="address">');
											else
												echo('<input type="text" class="form-control" name="address" id="address" value="'.$_SESSION['uaddress'].'">');
											?>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="company">Company</label>
                                            <?php
											if (!loggedIn)
												echo('<input type="text" class="form-control" name="company" id="company">');
											else
												echo('<input type="text" class="form-control" name="company" id="company" value="'.$_SESSION['ucompany'].'">');
											?>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.row -->

                                <div class="row">
                                    <div class="col-sm-6 col-md-3">
                                        <div class="form-group">
                                            <label for="city">City *</label>
                                            <?php
											if (!loggedIn)
												echo('<input type="text" class="form-control" name="city" id="city">');
											else
												echo('<input type="text" class="form-control" name="city" id="city" value="'.$_SESSION['ucity'].'">');
											?>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                        <div class="form-group">
                                            <label for="postcode">Postcode *</label>
                                            <?php
											if (!loggedIn)
												echo('<input type="text" class="form-control" name="postcode" id="postcode">');
											else
												echo('<input type="text" class="form-control" name="postcode" id="postcode" value="'.$_SESSION['upostcode'].'">');
											?>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                        <div class="form-group">
                                            <label for="state">State *</label>
											<?php include "inc/sit203ass2utils.php"; renderStateList($_SESSION['ustate'], "state"); ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                        <div class="form-group">
                                            <label for="country">Country *</label>
                                            <select class="form-control" name="country" id="country">
												<option value="Australia">Australia</option>
											</select>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="phone">Telephone * use form: (99)99999999 or 9999000999</label>
                                            <?php
											if (!loggedIn)
												echo('<input type="text" class="form-control" name="phone" id="phone">');
											else
												echo('<input type="text" class="form-control" name="phone" id="phone" value="'.$_SESSION['uphone'].'">');
											?>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="email">Email *</label>
                                            <?php
											if (!loggedIn)
												echo('<input type="text" class="form-control" name="email" id="email">');
											else
												echo('<input type="text" class="form-control" name="email" id="email" value="'.$_SESSION['uemail'].'">');
											?>
                                        </div>
                                    </div>

                                </div>
								
								<p class="from-group">Note: For all Australian orders over $500 we offer free express shipping. 
								We offer $20 Flat rate shipping for orders under $500. </p> <!-- added by Shang -->
								
                                <!-- /.row -->
                            </div>

                            <div class="box-footer">
                                <div class="pull-left">
                                    <a href="basket.php" class="btn btn-default"><i class="fa fa-chevron-left"></i>Back to basket</a>
                                </div>
                                <div class="pull-right">
                                    <button type="submit" class="btn btn-primary">Continue to Payment Method<i class="fa fa-chevron-right"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col-md-9 -->

                <div class="col-md-3">

                    <div class="box" id="order-summary">
                        <div class="box-header">
                            <h3>Order summary</h3>
                        </div>
                        <p class="text-muted">Shipping and additional costs are calculated based on the values you have entered.</p>

                        <div class="table-responsive">
							<?php
								
								echo(showOrderSummary());
							?>
                        </div>

                    </div>

                </div>
                <!-- /.col-md-3 -->

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
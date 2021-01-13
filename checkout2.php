<?php
/*****************************************
 * SIT203 Web Programming
 * Assignment 2
 * Aaron Pethybridge
 * Student#: 217561644
 * Checkout page - Payment form 
 *****************************************/
// Include functions
require_once('inc/basketutils.php');
require_once('inc/menuheader.php');
require_once('inc/userutils.php');
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
	<link href="css/sit203ass2.css" rel="stylesheet">
	<script src="js/sit203ass1.js"></script> <!-- External js file for SIT203 Assignments -->


</head>

<body>
	<?php renderMenuHeader(); ?>
    

    <div id="all">

        <div id="content">
            <div class="container">
				<?php
				include "inc/sit203ass2utils.php";
				
				// Call "clean" function on input values
				$firstname = clean($_POST['firstname']);
				$lastname = clean($_POST['lastname']);
				$address = clean($_POST['address']);
				$company = clean($_POST['company']);
				$city = clean($_POST['city']);
				$postcode = clean($_POST['postcode']);
				$state = clean($_POST['state']);
				$country = clean($_POST['country']);
				$phone = clean($_POST['phone']);
				$email = clean($_POST['email']);
				$enteredFormValues = array($firstname, $lastname, $address, $company, $city, $postcode, $state, $country, $phone, $email);
				
				$_SESSION['firstname'] = $firstname;
				$_SESSION['lastname'] = $lastname;
				$_SESSION['address'] = $address;
				$_SESSION['company'] = $company;
				$_SESSION['city'] = $city;
				$_SESSION['postcode'] = $postcode;
				$_SESSION['state'] = $state;
				$_SESSION['country'] = $country;
				$_SESSION['phone'] = $phone;
				$_SESSION['email'] = $email;
				
				if (!validatedAddressForm($enteredFormValues))
				{
					echo('<div class="col-md-12">');
						echo('<ul class="breadcrumb">');
							echo('<li><a href="index.php">Home</a>
							</li>');
							echo('<li>Checkout - Address</li>');
						echo('</ul>');
					echo('</div>');
					echo('<div class="col-md-9" id="checkout">');
						echo('<div class="box">');
							echo('<form method="post" action="checkout2.php">');
								echo('<h1>Checkout</h1>');
								echo('<ul class="nav nav-pills nav-justified">');
									echo('<li class="active"><a href="#"><i class="fa fa-map-marker"></i><br>Address</a>
									</li>');
									echo('<li class="disabled"><a href="#"><i class="fa fa-money"></i><br>Payment Method</a>
									</li>');
									echo('<li class="disabled"><a href="#"><i class="fa fa-eye"></i><br>Order Review</a>
									</li>');
								echo('</ul>');
								echo('<div class="content">');
									echo('<p class="from-group text-muted">* field is compulsory.</p> <!-- added by Shang -->');
									if (GlobalVars::$validationErrorMessage != "")
										echo('<p class="invalid">* Form entry error - '.GlobalVars::$validationErrorMessage.'</p>');
									echo('<div class="row">');
										echo('<div class="col-sm-6">');
											if (GlobalVars::$validationErrorType == FNAME)
												echo('<div class="form-group invalid">');
											else
												echo('<div class="form-group">');
												echo('<label for="firstname">Firstname *</label>');
												echo('<input type="text" class="form-control" name="firstname" id="firstname" value="'.$firstname.'">');
											echo('</div>');
										echo('</div>');
										echo('<div class="col-sm-6">');
											if (GlobalVars::$validationErrorType == LNAME)
												echo('<div class="form-group invalid">');
											else
												echo('<div class="form-group">');
												echo('<label for="lastname">Lastname *</label>');
												echo('<input type="text" class="form-control" name="lastname" id="lastname" value="'.$lastname.'">');
											echo('</div>');
										echo('</div>');
									echo('</div>
									<!-- /.row -->');

									echo('<div class="row">');
										echo('<div class="col-sm-6">');
											if (GlobalVars::$validationErrorType == ADDRESS)
												echo('<div class="form-group invalid">');
											else
												echo('<div class="form-group">');
												echo('<label for="address">Address *</label>');
												echo('<input type="text" class="form-control" name="address" id="address" value="'.$address.'">');
											echo('</div>');
										echo('</div>');
										echo('<div class="col-sm-6">');
											echo('<div class="form-group">');
												echo('<label for="company">Company</label>');
												echo('<input type="text" class="form-control" name="company" id="company">');
											echo('</div>');
										echo('</div>');
									echo('</div>
									<!-- /.row -->');

									echo('<div class="row">');
										echo('<div class="col-sm-6 col-md-3">');
											if (GlobalVars::$validationErrorType == CITY)
												echo('<div class="form-group invalid">');
											else
												echo('<div class="form-group">');
												echo('<label for="city">City *</label>');
												echo('<input type="text" class="form-control" name="city" id="city" value="'.$city.'">');
											echo('</div>');
										echo('</div>');
										echo('<div class="col-sm-6 col-md-3">');
											if (GlobalVars::$validationErrorType == POSTCODE)
												echo('<div class="form-group invalid">');
											else
												echo('<div class="form-group">');
												echo('<label for="postcode">Postcode *</label>');
												echo('<input type="text" class="form-control" name="postcode" id="postcode" value="'.$postcode.'">');
											echo('</div>');
										echo('</div>');
										echo('<div class="col-sm-6 col-md-3">');
											if (GlobalVars::$validationErrorType == STATE)
												echo('<div class="form-group invalid">');
											else
												echo('<div class="form-group">');
												echo('<label for="state">State *</label>');
												renderStateList($state, "state");
											echo('</div>');
										echo('</div>');
										echo('<div class="col-sm-6 col-md-3">');
											echo('<div class="form-group">');
												echo('<label for="country">Country *</label>');
												echo('<select class="form-control" name="country" id="country"><option value="Australia">Australia</option></select>');
											echo('</div>');
										echo('</div>');

										echo('<div class="col-sm-6">');
											if (GlobalVars::$validationErrorType == PHONE)
												echo('<div class="form-group invalid">');
											else
												echo('<div class="form-group">');
												echo('<label for="phone">Telephone * use form: (99)99999999 or 9999000999</label>');
												echo('<input type="text" class="form-control" name="phone" id="phone" value="'.$phone.'">');
											echo('</div>');
										echo('</div>');
										echo('<div class="col-sm-6">');
											if (GlobalVars::$validationErrorType == EMAIL)
												echo('<div class="form-group invalid">');
											else
												echo('<div class="form-group">');
												echo('<label for="email">Email *</label>');
												echo('<input type="text" class="form-control" name="email" id="email" value="'.$email.'">');
											echo('</div>');
										echo('</div>');

									echo('</div>');
									
									echo('<p class="from-group">Note: For all Australian orders over $500 we offer free express shipping. We offer $20 Flat rate shipping for orders under $500. </p> <!-- added by Shang -->
									
									<!-- /.row -->');
								echo('</div>');

								echo('<div class="box-footer">');
									echo('<div class="pull-left">');
										echo('<a href="basket.php" class="btn btn-default"><i class="fa fa-chevron-left"></i>Back to basket</a>');
									echo('</div>');
									echo('<div class="pull-right">');
										echo('<button type="submit" class="btn btn-primary">Continue to Payment Method<i class="fa fa-chevron-right"></i>');
										echo('</button>');
									echo('</div>');
								echo('</div>');
							echo('</form>');
						echo('</div>');
					echo('</div>');
				}
				else
				{
					echo('<div class="col-md-12">');
						echo('<ul class="breadcrumb">');
							echo('<li><a href="index.php">Home</a>
							</li>');
							echo('<li>Checkout - Payment method</li>');
						echo('</ul>');
					echo('</div>');
					echo('<div class="col-md-9" id="checkout">');
						echo('<div class="box">');
							echo('<form method="post" action="checkout3.php">');
								echo('<h1>Checkout - Payment method</h1>');
								echo('<ul class="nav nav-pills nav-justified">');
									echo('<li><a href="checkout1.php"><i class="fa fa-map-marker"></i><br>Address</a>
									</li>');
									echo('<li class="active"><a href="#"><i class="fa fa-money"></i><br>Payment Method</a></li>');
									echo('<li class="disabled"><a href="checkout3.php"><i class="fa fa-eye"></i><br>Order Review</a></li>');
								echo('</ul>');
								echo('<div class="content">');
									echo('<div class="row">');
										echo('<div class="box payment-method">');
											echo('<h4>Payment gateway</h4>');
											echo('<p>VISA and Mastercard only.</p>');
											echo('<ul class="list-unstyled list-inline">');
												echo('<li class="list-inline-item"><img src="img/visa.svg" alt="visa" width="50"></li>');
												echo('<li class="list-inline-item"><img src="img/mastercard.svg" alt="mastercard" width="50"></li>');
											echo('</ul>');
											echo('<div class="row">');
												echo('<div class="col-sm-10 form-group">');
													echo('<input type="text" name="cardname" placeholder="Name On Card" class="form-control">');
												echo('</div>');
												echo('<div class="col-sm-10 form-group">');
													echo('<input type="text" name="cardnumber" placeholder="Card Number" maxlength="16" class="form-control">');
												echo('</div>');
												echo('<div class="col-sm-4 form-group">');
													renderExpiryMonthList("", "expirymonth");
													echo('<label for="expirymonth">Expiry month *</label>');
												echo('</div>');
												echo('<div class="col-sm-4 form-group">');
													renderExpiryYearList("", "expiryyear");
													echo('<label for="expiryyear">Expiry year *</label>');
												echo('</div>');
												echo('<div class="col-sm-4 form-group">');
													echo('<input type="text" name="cvv" placeholder="CVV" maxlength="3"  class="form-control">');
												echo('</div>');
											echo('</div>');
										echo('</div>');
									echo('</div>
									<!-- /.row -->');
								echo('</div>
								<!-- /.content -->');
								echo('<div class="box-footer">');
									echo('<div class="pull-left">');
										echo('<a href="checkout1.php" class="btn btn-default"><i class="fa fa-chevron-left"></i>Back to Address</a>');
									echo('</div>');
									echo('<div class="pull-right">');
										echo('<button type="submit" class="btn btn-primary">Continue to Order review<i class="fa fa-chevron-right"></i>');
										echo('</button>');
									echo('</div>');
								echo('</div>');
							echo('</form>');
						echo('</div>
						<!-- /.box -->');
					echo('</div>
					<!-- /.col-md-9 -->');
				}
				?>
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
<?php
/*****************************************
 * SIT203 Web Programming
 * Assignment 2
 * Aaron Pethybridge
 * Student#: 217561644
 * Processing account details update page 
 *****************************************/
// Include functions
require_once('inc/db-conn.php');
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
                        <li>My account</li>
                    </ul>

                </div>
				<div class="col-md-12">
                    <div class="box">
				<?php
				// use global var to store ref to dB
				global $db;		
				
				if ($_POST['updateaction'] == 'password') // update password
				{
					// Get update password form values
					$upasswordold = clean($_POST['password_old']);
					$upassword1 = clean($_POST['password_1']);
					$upassword2 = clean($_POST['password_2']);
					
					// Retrieve session values
					$udbpasswd = $_SESSION['udbpasswd'];
					$ucustid = $_SESSION['ucustid'];
					$uusersalt = $_SESSION['uusersalt'];
									
					$upasswordoldhash = doHash($upasswordold, $uusersalt);
					
					// Create user salt to save to user database record
					$usalt = microtime();
					$hashedregpasswd = doHash($upassword1, $usalt);
					
					if (($udbpasswd == $upasswordoldhash) && ($upassword1 == $upassword2)) // passwords all match
					{
						// build UPDATE query
						$sql = "UPDATE Customers SET custpassword = '$hashedregpasswd', custusertime = '$usalt' WHERE custid = '$ucustid'";
						
						if (!$db)
						{
							echo "An error occurred connecting to the database. Please try again shortly.";
							exit;
						}
	   
						$result = $db->query($sql);
						//$stmt = oci_parse($db, $sql);

						if(!$result) 
						{
							echo "An error occurred accessing the database. Please try again shortly.";
							exit;
						}
						//oci_execute($stmt);
						$output = '<h3>Update completed.</h3></br />Password has been updated.';
						echo($output);
						// Update session variables for updated password and updated salt
						$_SESSION['udbpasswd'] = $hashedregpasswd;
						$_SESSION['uusersalt'] = $usalt;
						//$_SESSION['loggedIn'] = $loggedIn;
					}
					else // passwords don't match
					{
						$errorMsg = "";
						if ($udbpasswd != $upasswordold)
							$errorMsg = "The \"old\" password you entered does not match your account password.<br />Please re-enter.<br />";
						if ($upassword1 != $upassword2)
							$errorMsg = "The \"new\" password was not confirmed.<br />Please re-enter.<br />";
						$output = '<h3>Update not completed.</h3>'.$errorMsg;
						$output .= '<br /><form method="post" action="customer-update.php">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="password_old">Old password *</label>
                                        <input type="password" class="form-control" name="password_old" id="password_old">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="password_1">New password *</label>
                                        <input type="password" class="form-control" name="password_1" id="password_1">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="password_2">Retype new password *</label>
                                        <input type="password" class="form-control" name="password_2" id="password_2">
                                    </div>
                                </div>
                            </div>
                            <!-- /.row -->

							<div class="row">
								<div class="col-sm-12 text-center">
									<input type="hidden" name="updateaction" value="password">
									<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save new password</button>
								</div>
							</div>
                        </form>';
						echo($output);
					}
					
				}
				else // update other information fields
				{
					$ucustid = $_SESSION['ucustid'];
					$ufirstname = clean($_POST['pfirstname']);
					$ulastname = clean($_POST['plastname']);
					$uaddress = clean($_POST['paddress']);
					$ucompany = clean($_POST['pcompany']);
					$ucity = clean($_POST['pcity']);
					$ustate = clean($_POST['pstate']);
					$upostcode = clean($_POST['ppostcode']);
					$ucountry = clean($_POST['pcountry']);
					$uphone = clean($_POST['pphone']);
					$uemail = clean($_POST['pemail']);
									
					// build UPDATE query
					$sql = "UPDATE Customers SET custfirstname = '$ufirstname',
						custlastname = '$ulastname',
						custaddress = '$uaddress',
						custcompany = '$ucompany',
						custcity = '$ucity',
						custstate = '$ustate',
						custpostcode = '$upostcode',
						custcountry = '$ucountry',
						custphone = '$uphone',
						custemail = '$uemail'
					WHERE custid = '$ucustid'";

					//$loggedIn = false;
					if (!$db)
					{
						echo "An error occurred connecting to the database. Please try again shortly.";
						exit;
					}
   
					$result = $db->query($sql);
					//$stmt = oci_parse($db, $sql);

					if(!$result) 
					{
						echo "An error occurred accessing the database. Please try again shortly.";
						exit;
					}
					//oci_execute($stmt);
					$output = '<h3>Update completed.</h3></br />Your details have been updated.';
					echo($output);
					
					$_SESSION['ufirstname'] = $ufirstname;
					$_SESSION['ulastname'] = $ulastname;
					$_SESSION['uaddress'] = $uaddress;
					$_SESSION['ucompany'] = $ucompany;
					$_SESSION['ucity'] = $ucity;
					$_SESSION['ustate'] = $ustate;
					$_SESSION['upostcode'] = $upostcode;
					$_SESSION['ucountry'] = $ucountry;
					$_SESSION['uphone'] = $uphone;
					$_SESSION['uemail'] = $uemail;
				}
						
				?>
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

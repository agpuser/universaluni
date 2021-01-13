<?php
/*****************************************
 * SIT203 Web Programming
 * Assignment 2
 * Aaron Pethybridge
 * Student#: 217561644
 * 'My Account' handling page 
 *****************************************/
// Include functions
require_once('inc/db-conn.php');
require_once('inc/menuheader.php');
require_once('inc/userutils.php');
require_once('inc/sit203ass2utils.php');
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
    <?php 
	$newRegistration = false;
	// use global var to store ref to dB
	global $db;		
	
	if ($_POST['loginaction'] == 'login')
	{
		$uusername = clean($_POST['loginname']);
		$upasswd = clean($_POST['loginpassword']);
		
		// build SELECT query
		$sql = "SELECT * FROM Customers WHERE custemail  = '$uusername'";

		$loggedIn = false;
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
		while ($row = $result->fetch_assoc())
		//while(oci_fetch_array($stmt)) 
		{
			$udbpasswd = $row['custpassword'];
			$uusersalt = $row['custusertime'];
			$hashedupasswd = doHash($upasswd, $uusersalt);
			//if($udbpasswd == $upasswd)
			if ($udbpasswd == $hashedupasswd)			
			{
				$loggedIn = true;	
				
				$ucustid = $row['custid'];
				//$uusersalt = oci_result($stmt,"custusertime");
				$ufirstname = $row['custfirstname'];
				$ulastname = $row['custlastname'];
				$uaddress = $row['custaddress'];
				$ucompany = $row['custcompany'];
				$ucity = $row['custcity'];
				$ustate = $row['custstate'];
				$upostcode = $row['custpostcode'];
				$ucountry = $row['custcountry'];
				$uphone = $row['custphone'];
				$uemail = $row['custemail'];
				$_SESSION['ucustid'] = $ucustid;
				$_SESSION['uusersalt'] = $uusersalt;
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
				$_SESSION['udbpasswd'] = $udbpasswd;
				
			}
		} //end of while
		$_SESSION['loggedIn'] = $loggedIn;
		
	}
	else if ($_POST['loginaction'] == 'register') // register action
	{
		$newregfname = clean($_POST['regfname']);
		$newreglname = clean($_POST['reglname']);
		$newregemail = clean($_POST['regemail']);
		$newregpasswd = clean($_POST['regpasswd']);
		$usersalt = microtime();
		$hashedregpasswd = doHash($newregpasswd, $usersalt);
		
		// Build INSERT query
		$sql = "INSERT INTO Customers (custusertime, custusername, custpassword, custfirstname, custlastname,  custaddress, custcompany, custcity, custstate, custpostcode, custcountry, custphone, custemail) VALUES ('$usersalt', '$newregemail','$hashedregpasswd','$newregfname','$newreglname','', '', '', '', '', '', '', '$newregemail')";
		
		if (!$db)
		{
			echo "An error occurred connecting to the database. Please try again shortly.";
			exit;
		}

		//$stmt = oci_parse($db, $sql);
		$result = $db->query($sql);

		if(!$result) 
		{
			echo "An error occurred accessing the database. Please try again shortly.";
			exit;
		}
		//oci_execute($stmt);
		$newRegistration = true;
		$_SESSION['newRegistration'] = $newRegistration;
		
	}
	// Close the connection
	$db->close();
	renderMenuHeader(); 
	
	?>
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
				<?php
				if (!$_SESSION['loggedIn'] && !$_SESSION['newRegistration'])
				{
					$output .= '<div class="col-md-6">';
					$output .= '<div class="box">';
					$output .= '<h2>Login failed</h2><br />
					<p>Unable to log in with the entered details. Please check your <b>email</b> and <b>password</b> and try again.</p>
						
					<form action="customer-account.php" method="post">
						<div class="form-group">
							<label for="email">Email</label>
							<input name="loginname" type="text" class="form-control" id="email">
						</div>
						<div class="form-group">
							<label for="password">Password</label>
							<input name="loginpassword" type="password" class="form-control" id="password">
						</div>
						<div class="text-center">
							<input type="hidden" name="loginaction" value="login">
							<button type="submit" class="btn btn-primary"><i class="fa fa-sign-in"></i> Log in</button>
						</div>
					</form>';
					$output .= '</div>';
					$output .= '</div>';
					$output .= '</div>
							<!-- /.container -->
						</div>
						<!-- /#content -->';

					$output .= getFooter();
					$output .= '	<!-- *** COPYRIGHT ***
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
						<!-- *** COPYRIGHT END *** -->';



					$output .= '</div>
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
					</body></html>';
					
					echo($output);
					die();	
				}
				if ($newRegistration)
				{
					$output .= '<div class="col-md-6">';
					$output .= '<div class="box">';
					$output .= '<h2>New Registration</h2><br />
					<p>Congratulations. Your email and password have been registered.</p>';
					$output .= '<p>You can now <a href="register.php">login</a> to your account and update your details.</p>';	
					
					$output .= '</div>';
					$output .= '</div>';
					$output .= '</div>
							<!-- /.container -->
						</div>
						<!-- /#content -->';

					$output .= getFooter();
					$output .= '	<!-- *** COPYRIGHT ***
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
						<!-- *** COPYRIGHT END *** -->';



					$output .= '</div>
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
					</body></html>';
					
					echo($output);
					die();	
				}
				?>
				
                <div class="col-md-3">
                    <!-- *** CUSTOMER MENU ***
 _________________________________________________________ -->
                    <div class="panel panel-default sidebar-menu">

                        <div class="panel-heading">
                            <h3 class="panel-title">Customer section</h3>
                        </div>

                        <div class="panel-body">

                            <ul class="nav nav-pills nav-stacked">
                                <li>
                                    <a href="#"><i class="fa fa-list"></i> My orders</a>
                                </li>
								<!--
                                <li>
                                    <a href="customer-wishlist.php"><i class="fa fa-heart"></i> My wishlist</a>
                                </li>
								-->
                                <li class="active">
                                    <a href="customer-account.php"><i class="fa fa-user"></i> My account</a>
                                </li>
								<li><i class="fa">   </i></li>
                                <li>
									<form method="post" action="index.php">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-sign-out"></i> Logout</button>
									<input type="hidden" name="loginaction" value="logout">
									</form>
                                </li>
                            </ul>
                        </div>

                    </div>
                    <!-- /.col-md-3 -->

                    <!-- *** CUSTOMER MENU END *** -->
                </div>

                <div class="col-md-9">
                    <div class="box">
                        <?php echo('<h2>'.$_SESSION['ufirstname'].' '.$_SESSION['ulastname'].'</h2><h3>My account</h3>'); ?>
                        <p class="lead">Change your personal details or your password here.</p>
                        <p class="text-muted">* field is compulsory.</p>

                        <h3>Change password</h3>

                        <form method="post" action="customer-update.php">
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

                            <div class="col-sm-12 text-center">
								<input type="hidden" name="updateaction" value="password">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save new password</button>
                            </div>
                        </form>

                        <hr>

                        <h3>Personal details</h3>
                        <form method="post" action="customer-update.php">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="firstname">Firstname *</label>
										<?php
											echo('<input value="'.$_SESSION['ufirstname'].'" type="text" class="form-control" name="pfirstname" id="pfirstname">');
										?>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="lastname">Lastname *</label>
										<?php
											echo('<input value="'.$_SESSION['ulastname'].'" type="text" class="form-control" name="plastname" id="plastname">');
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
											echo('<input value="'.$_SESSION['uaddress'].'" type="text" class="form-control" name="paddress" id="paddress">');
										?>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="company">Company</label>
                                        <?php
											echo('<input value="'.$_SESSION['ucompany'].'" type="text" class="form-control" name="pcompany" id="pcompany">');
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
											echo('<input value="'.$_SESSION['ucity'].'" type="text" class="form-control" name="pcity" id="pcity">');
										?>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <div class="form-group">
                                        <label for="postcode">Postcode *</label>
                                        <?php
											echo('<input value="'.$_SESSION['upostcode'].'" type="text" class="form-control" name="ppostcode" id="ppostcode">');
										?>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <div class="form-group">
                                        <label for="state">State *</label>
                                        <?php renderStateList($_SESSION['ustate'], 'pstate'); ?>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <div class="form-group">
                                        <label for="country">Country *</label>
                                        <?php
											if ($_SESSION['ucountry'] != "")
											{
												echo('<select  type="text" class="form-control" name="pcountry" id="pcountry"><option selected="true" value="'.$_SESSION['ucountry'].'">'.$_SESSION['ucountry'].'</option></select>');
											}
											else
											{
												echo('<select  type="text" class="form-control" name="pcountry" id="pcountry"><option selected="true" value="Australia">Australia</option></select>');
											}
										?>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="phone">Telephone *</label>
                                        <?php
											echo('<input value="'.$_SESSION['uphone'].'" type="text" class="form-control" name="pphone" id="pphone">');
										?>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="email">Email *</label>
                                        <?php
											echo('<input value="'.$_SESSION['uemail'].'" type="text" class="form-control" name="pemail" id="pemail">');
										?>
                                    </div>
                                </div>
                                <div class="col-sm-12 text-center">
									<input type="hidden" name="updateaction" value="details">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save changes</button>

                                </div>
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

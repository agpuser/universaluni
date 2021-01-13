<?php
/*****************************************
 * SIT203 Web Programming
 * Assignment 2
 * Aaron Pethybridge
 * Student#: 217561644
 * Contact page 
 *****************************************/
// Include functions
require_once('inc/menuheader.php');
require_once('inc/userutils.php');
require_once('inc/db-conn.php');
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
    <meta name="description" content="Universal Your Furniture Shop">
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
	
	<?php
	define("NONE", -1);
	define("CFIRSTNAME", 0);
	define("CLASTNAME", 1);
	define("CEMAIL", 2);
	define("CSUBJECT", 3);
	define("CMESSAGE", 4);
	
	global $nameEmailValid, $messageSubjectValid;
	$errorMsg = '';
	$validFields = array();
	$errorLabels = array('First Name', 'Last Name', 'Email', 'Subject', 'Message');
	
	$validFields[] = clean(validateContactField($_POST['contactfirstname'], $nameEmailValid));
	$validFields[] = clean(validateContactField($_POST['contactlastname'], $nameEmailValid));
	$validFields[] = clean(validateContactField($_POST['contactemail'], $nameEmailValid));
	$validFields[] = clean(validateContactField($_POST['contactsubject'], $messageSubjectValid));
	$validFields[] = clean(validateContactField($_POST['contactmessage'], $messageSubjectValid));
	$validationError = validateContactForm($validFields);
	
	//if (file_exists($_SESSION['captchacontact'].'.png'))
		//unlink($_SESSION['captchacontact'].'.png');
	// "Delete" all png files, so directory does not get clogged.
	// Code to ** adapted from https://stackoverflow.com/questions/5535202/delete-images-from-a-folder#answer-5535221
	foreach(glob('*.png') as $file)
	{
		if(is_file($file))
			unlink($file);
	}
	// **
	
	if (isset($_POST['contactsubmit']) && ($_POST['captcha'] == $_SESSION['captchacontact'])
									   && ($validationError == NONE))
	{
		// use global var to store ref to dB
		global $db;

		$cfn = $validFields[CFIRSTNAME];
		$cln = $validFields[CLASTNAME];
		$ce = $validFields[CEMAIL];
		$cs = $validFields[CSUBJECT];
		$cm = $validFields[CMESSAGE];
		
		
		// Build INSERT sql statement
		$sql = "INSERT INTO Contacts VALUES (contact_id_seq.nextval,'$cfn','$cln','$ce','$cs','$cm')";
		
		/* check the sql statement for errors and if errors report them */
		$stmt = oci_parse($db, $sql);
		
		if(!$stmt) 
		{
			echo('Unable to write to the database. Please try again shortly.');
			exit;
		}
		
		if (oci_execute($stmt))
		{
			$output = '<div id="content">
				<div class="container">
					<div class="col-md-12">
						<div class="box">
							<h2>Message Confirmation</h2>Thank you, <b>'.$contactfirstname.'</b> for your message regarding <b>'.$contactsubject.'</b>. We will provide a response for your within 24 hours.';
						$output .= '</div>
					</div>
				</div>
			</div>';
		}
		else
		{
			$output = '<div id="content">
				<div class="container">
					<div class="col-md-12">
						<div class="box">
							<h2>Sorry, <b>'.$contactfirstname.'</b> but we couldn\'t process your message regarding <b>'.$contactsubject.'</b>. Please try again shortly.';
						$output .= '</div>
					</div>
				</div>
			</div>';
		}
		unset($_SESSION['captchacontact']);
		$_SESSION['okay'] = true;
	}
	else
	{
		$output = '<div id="content">
            <div class="container">

                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li><a href="index.php">Home</a>
                        </li>
                        <li>Contact</li>
                    </ul>

                </div>

                <div class="col-md-3">
                    <!-- *** PAGES MENU ***
 _________________________________________________________ -->
                    <div class="panel panel-default sidebar-menu">

                        <div class="panel-heading">
                            <h3 class="panel-title">Pages</h3>
                        </div>

                        <div class="panel-body">
                            <ul class="nav nav-pills nav-stacked">
                                <li>
                                    <a href="aboutus.php">About us</a>
                                </li>
                                <li>
                                    <a href="terms.php">Terms and conditions</a>
                                </li>
                                <li>
                                    <a href="contact.php">Contact page</a>
                                </li>
                                <li>
                                    <a href="faq.php">FAQ</a>
                                </li>

                            </ul>

                        </div>
                    </div>

                    <!-- *** PAGES MENU END *** -->


                    <div class="banner">
                        <a href="#">
                            <img src="img/banner.jpg" alt="sales 2014" class="img-responsive">
                        </a>
                    </div>
                </div>

                <div class="col-md-9">


                    <div class="box" id="contact">
                        <h1>Contact</h1>

                        <p class="lead">Are you curious about something? Do you have some kind of problem with our products?</p>
                        <p>Please feel free to contact us, our customer service center is working for you 24/7.</p>

                        <hr>

                        <div class="row">
                            <div class="col-sm-4">
                                <h3><i class="fa fa-map-marker"></i> Address</h3>
                                <p><strong>Universal Ltd.</strong>
                                    <br>500 Main Street
									<br>Geelong
									<br>Victoria 3200
									<br>
									<strong>Australia</strong>
                                </p>
                            </div>
                            <!-- /.col-sm-4 -->
                            <div class="col-sm-4">
                                <h3><i class="fa fa-phone"></i> Call center</h3>
                                <p class="text-muted">This number is toll free if calling from Australia otherwise we advise you to use the electronic form of communication.</p>
                                <p><strong>+61 800 5244 0000</strong>
                                </p>
                            </div>
                            <!-- /.col-sm-4 -->
                            <div class="col-sm-4">
                                <h3><i class="fa fa-envelope"></i> Electronic support</h3>
                                <p class="text-muted">Please feel free to write an email to us.</p>
                                <ul>
                                    <li><strong><a href="mailto:">info@Universal.com</a></strong>
                                    </li>                                    
                                </ul>
                            </div>
                            <!-- /.col-sm-4 -->
                        </div>
                        <!-- /.row -->

                        <hr>

                        <div id="map">

                        </div>

                        <hr>
                        <h2>Contact form</h2>

                        <form method="post" action="contact.php" id="contact" name="contact">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="firstname">Firstname</label>';
										if (isset($_POST['contactsubmit']))
											$output .= '<input type="text" class="form-control" name="contactfirstname" id="contactfirstname" value="'.$validFields[CFIRSTNAME].'">';
										else
											$output .= '<input type="text" class="form-control" name="contactfirstname" id="contactfirstname">';
									$output .= '</div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="lastname">Lastname</label>';
										if (isset($_POST['contactsubmit']))
											$output .= '<input type="text" class="form-control" name="contactlastname" id="contactlastname" value="'.$validFields[CLASTNAME].'">';
										else
											$output .= '<input type="text" class="form-control" name="contactlastname" id="contactlastname">';
                                    $output .= '</div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="email">Email</label>';
										if (isset($_POST['contactsubmit']))
											$output .= '<input type="text" class="form-control" name="contactemail" id="contactemail" value="'.$validFields[CEMAIL].'">';
										else
											$output .= '<input type="text" class="form-control" name="contactemail" id="contactemail">';
                                    $output .= '</div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="subject">Subject</label>';
										if (isset($_POST['contactsubmit']))
											$output .= '<input type="text" class="form-control" name="contactsubject" id="contactsubject" value="'.$validFields[CSUBJECT].'">';
										else
											$output .= '<input type="text" class="form-control" name="contactsubject" id="contactsubject">';
                                    $output .= '</div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="message">Message</label>';
										if (isset($_POST['contactsubmit']))
											$output .= '<textarea name="contactmessage" id="contactmessage" class="form-control" maxlength="300" rows="5" placeholder="Maximum 300 characters">'.$validFields[CMESSAGE].'</textarea>';
										else
											$output .= '<textarea name="contactmessage" id="contactmessage" class="form-control" maxlength="300" rows="5" placeholder="Maximum 300 characters"></textarea>';
                                    $output .= '</div>
                                </div>
								
								<div class="col-sm-12">';
								//Create radom text
								$_SESSION['captchacontact'] = rand(100, 10000);
								$c = (string)$_SESSION['captchacontact'];
								
								// Create random file name
								$suffix = rand(10001, 20000);
								$fname = (string)$suffix;
								
								//Create a new captcha
								$captcha = new captcha();
								$captcha->create($c, $fname);
								$output .= '<p><img alt="captcha" src="'.$fname.'.png" /></p>';
								$output .= '<p>Please enter code shown in image to confim your message:<br /><input type="text" name="captcha" /></p>';
								
								if (isset($_POST['contactsubmit']))
								{
									if ($validationError != NONE)
										$output .= '<p class="invalid">Contact field <b>'.$errorLabels[$validationError].'</b> is empty. Please enter a value.</p>';
										
									else
										$output .= '<p class="invalid">Code entered does not match image. Please try again.</p>';
								}
                                $output .= '</div>
								
								<div class="col-sm-12">
                                    <button type="submit" name="contactsubmit" class="btn btn-primary"><i class="fa fa-envelope-o"></i> Send message</button>

                                </div>
                            </div>
                            <!-- /.row -->
                        </form>


                    </div>


                </div>
                <!-- /.col-md-9 -->
            </div>
            <!-- /.container -->
        </div>
        <!-- /#content -->';
	}
	echo($output);
	?>

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




    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&amp;sensor=false"></script>

    <script>
        function initialize() {
            var mapOptions = {
                zoom: 15,
                center: new google.maps.LatLng(-38.050915, 144.378159),
                mapTypeId: google.maps.MapTypeId.ROAD,
                scrollwheel: false
            }
            var map = new google.maps.Map(document.getElementById('map'),
                mapOptions);

            var myLatLng = new google.maps.LatLng(-38.050915, 144.378159);
            var marker = new google.maps.Marker({
                position: myLatLng,
                map: map
            });
        }

        google.maps.event.addDomListener(window, 'load', initialize);
    </script>


</body>

</html>

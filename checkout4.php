<?php
/*****************************************
 * SIT203 Web Programming
 * Assignment 2
 * Aaron Pethybridge
 * Student#: 217561644
 * Checkout page - Order confirmation 
 *****************************************/
// Include functions
require_once('inc/menuheader.php');
require_once('inc/shopping.php');
require_once('inc/db-conn.php');
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
                        <li>Checkout - Order confirmation</li>
                    </ul>
                </div>

                <div class="col-md-12" id="checkout">

                    <div class="box">
							<div class="content">
								<div class="table-responsive">
									<?php
										// use global var to store ref to dB
										global $db;
										
										// Get logged in status
										$loggedIn = $_SESSION['loggedIn'];
										
										// obtain order data from session
										$cart = $_SESSION['cart'];
										$basket = unserialize($_SESSION['basket']);
									
										$theOrder = new Uorder();
										$theOrder->ordertotal = $_SESSION['grandTotal'];
										$theOrder->ordersubtotal = $_SESSION['orderTotal'];
										$theOrder->ordergst = $_SESSION['gst'];
										$theOrder->ordershipping = $_SESSION['shipping'];
										$theOrder->firstname = $_SESSION['firstname'];
										$theOrder->lastname = $_SESSION['lastname'];
										$theOrder->address = $_SESSION['address'];
										$theOrder->company = $_SESSION['company'];
										$theOrder->city = $_SESSION['city'];
										$theOrder->postcode = $_SESSION['postcode'];
										$theOrder->state = $_SESSION['state'];
										$theOrder->country = $_SESSION['country'];
										$theOrder->phone = $_SESSION['phone'];
										$theOrder->email = $_SESSION['email'];
										$theOrder->cardname = $_SESSION['cardname'];
										$theOrder->cardnumber = $_SESSION['cardnumber'];
										$theOrder->expirymonth = $_SESSION['expirymonth'];
										$theOrder->expiryyear = $_SESSION['expiryyear'];
										$theOrder->cvv = $_SESSION['cvv'];
										
										//$orderid = 1; // Init count var for new id for Orders table insertion
				
										// Obtain highest id value from Orders table
										//$sql_count = "SELECT IFNULL(MAX(orderid),0) AS maxid FROM Orders";
										
										/* check the sql statement for errors and if errors report them */
										//$result = $db->query($sql_count);
										//$stmt = oci_parse($db, $sql_count);
										
										//if(!$result) 
										//{
											//echo('Unable to read from the database. Please try again shortly.');
											//exit;
										//}
										//oci_execute($stmt);
										
										// if results found apply to count variable
										//while ($row = $result->fetch_assoc())
										//if (oci_fetch_array($stmt)) 
										//{
										//	$orderid = $row['orderid']; //oci_result($stmt,1);
										//}
										//else 
										//{ // in case can't fetch array
										//	echo("Error ocurred placing order. Please try again shortly.");
										//}	
										
										//$orderid++; // Increment id value for new record for orders table insertion
										
										// Try writing to databases
										$output = "";
										
										// Build SQL statement
										
										$sql = "INSERT INTO Orders (ordertotal, ordersubtotal, ordergst, ordershipping, orderfirstname, orderlastname, orderaddress, ordercompany, ordercity, orderstate, orderpostcode, ordercountry, orderphone, orderemail, ordercardname, ordercardnumber, ordercardexpirymonth, ordercardexpiryyear, ordercardcvv) VALUES ($theOrder->ordertotal, $theOrder->ordersubtotal, $theOrder->ordergst, $theOrder->ordershipping, '$theOrder->firstname', '$theOrder->lastname','$theOrder->address','$theOrder->company', '$theOrder->city', '$theOrder->state', '$theOrder->postcode', '$theOrder->country', '$theOrder->phone', '$theOrder->email', '$theOrder->cardname', '$theOrder->cardnumber', '$theOrder->expirymonth', '$theOrder->expiryyear','$theOrder->cvv')";
										
										$result = $db->query($sql);
										//$stmt = oci_parse($db, $sql);
										if(!$result) 
										{
											echo "Error placing order. Please try again shortly.\n";
											exit;
										}
										
										if ($result) // if write to database works
										{
											$orderid = $db->insert_id;
											// Build order receipt details
											$output .= '<h3>Order confirmed</h3><br />';
											$output .= 'Thank you for placing your order.<br />Your Order number is <b>'.$orderid.'</b>.<br /><br />';
											$output .= 'Please see your receipt details below<br /><br />';
											$output .= '<table>';
											$output .= '<tr>';
											$output .= '<td><b>First name: </b></td>';
											$output .= '<td class="ordercell">'.$theOrder->firstname.'</td>';
											$output .= '</tr>';
											$output .= '<tr>';
											$output .= '<td><b>Last name: </b></td>';
											$output .= '<td class="ordercell">'.$theOrder->lastname.'</td>';
											$output .= '</tr>';
											$output .= '<tr>';
											$output .= '<td><b>Address: </b></td>';
											$output .= '<td class="ordercell">'.$theOrder->address.'</td>';
											$output .= '</tr>';
											$output .= '<tr>';
											$output .= '<td><b>Company: </b></td>';
											$output .= '<td class="ordercell">'.$theOrder->company.'</td>';
											$output .= '</tr>';
											$output .= '</tr>';
											$output .= '<tr>';
											$output .= '<td><b>City: </b></td>';
											$output .= '<td class="ordercell">'.$theOrder->city.'</td>';
											$output .= '</tr>';
											$output .= '<tr>';
											$output .= '<td><b>Postcode: </b></td>';
											$output .= '<td class="ordercell">'.$theOrder->postcode.'</td>';
											$output .= '</tr>';
											$output .= '<tr>';
											$output .= '<td><b>State: </b></td>';
											$output .= '<td class="ordercell">'.$theOrder->state.'</td>';
											$output .= '</tr>';
											$output .= '<tr>';
											$output .= '<td><b>Country: </b></td>';
											$output .= '<td class="ordercell">'.$theOrder->country.'</td>';
											$output .= '</tr>';
											$output .= '<tr>';
											$output .= '<td><b>Phone: </b></td>';
											$output .= '<td class="ordercell">'.$theOrder->phone.'</td>';
											$output .= '</tr>';
											$output .= '<tr>';
											$output .= '<td><b>Email: </b></td>';
											$output .= '<td class="ordercell">'.$theOrder->email.'</td>';
											$output .= '</tr>';
											$output .= '<tr>';
											$output .= '<td><b>Card Name: </b></td>';
											$output .= '<td class="ordercell">'.$theOrder->cardname.'</td>';
											$output .= '</tr>';
											$output .= '<tr>';
											$output .= '<td><b>Card Number: </b></td>';
											$output .= '<td class="ordercell">XXXX XXXX XXXX '.substr($theOrder->cardnumber, 12).'</td>';
											$output .= '</tr>';
											$output .= '<tr>';
											$output .= '<td><b>Card Expiry: </b></td>';
											$output .= '<td class="ordercell">'.$theOrder->expirymonth.' / '.$theOrder->expiryyear.'</td>';
											$output .= '</tr>';
											$output .= '</table>';
										}
										else // if error writing to the database
											echo "Error placing order. Please try again shortly.\n";
										
										$ototal = $basket->baskettotal;
										$subtotal = 0;
										$ordersubtotal = 0;
										$gst = $basket->basketgst;
										$shipping = $basket->basketshipping;
										
										$output .= '<br /><p><b><u>Order Items</u></b></p><table>';
										$output .= '<tr>';
										$output .= '<td><b>Product Name</b></td><td class="ordercell"><b>Product Price</b></td><td class="ordercell"><b>Product Quantity</b></td><td class="ordercell"><b>Product Sub-total</b></td>';
										$output .= '</tr>';
										
										$output .= '<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>';
										
										$lineItems = $basket->basketItems;
										// Add order line items to database
										for ($i = 0; $i < count($lineItems); $i++)
										{
											$pname = $lineItems[$i]->productname;
											$pquantity = $lineItems[$i]->quantity;
											$pprice = $lineItems[$i]->price;
											$pid = $lineItems[$i]->productid;
											
											// Build INSERT statement
											$sql = "INSERT INTO orderitems (productid, productName, quantity, price, orderid) VALUES ('$pid','$pname', '$pquantity', '$pprice','$orderid')";
											
											$result = $db->query($sql);
											//$stmt = oci_parse($db, $sql);
											if(!$result) 
											{
												echo "Error placing order. Please try again shortly.\n";
												exit;
											}
											
											//oci_execute($stmt);
											$subtotal = $pquantity * $pprice;
											$output .= '<tr>';
											$output .= '<td>'.$pname.'</td><td class="ordercell orderright">$'.$pprice.'.00</td><td class="ordercell orderright">'.$pquantity.'</td><td class="ordercell orderright">$'.$subtotal.'.00</td>';
											$output .= '</tr>';
											$ordersubtotal += $subtotal;
										}
										
										$output .= '<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>';
										$output .= '<tr><td></td><td></td><td class="ordercell orderright"><b>Sub-total: </b></td><td class="ordercell orderright"><b>$'.$ordersubtotal.'.00</b></td></tr>';
										$output .= '<tr><td></td><td></td><td class="ordercell orderright">GST: </td><td class="ordercell orderright">$'.$gst.'</td></tr>';
										$output .= '<tr><td></td><td></td><td class="ordercell orderright">Shipping: </td><td class="ordercell orderright">$'.$shipping.'.00</td></tr>';
										$output .= '<tr><td></td><td></td><td class="ordercell orderright"><b>Order Total: </b></td><td class="ordercell orderright"><b>$'.$ototal.'</b></td></tr>';
										$output .= '</table>';
										$output .= '</br /><p>We will email you when your order ships. Thanks again.</p>';
										
										// Display results of order
										echo($output);
																				
										if (!$loggedIn)
										{
											// Create new account using user's entered details
											// Try writing to databases
											$output = "";
											$temppasswd = generateTempPassword();
											$usersalt = microtime();
											$hashedregpasswd = doHash($temppasswd, $usersalt);
											
											// Build SQL statement
											$sql = "INSERT INTO Customers (custusertime, custusername, custpassword, custfirstname, custlastname,  custaddress, custcompany, custcity, custstate, custpostcode, custcountry, custphone, custemail) VALUES ('$usersalt', '$theOrder->email','$hashedregpasswd', '$theOrder->firstname', '$theOrder->lastname','$theOrder->address','$theOrder->company', '$theOrder->city', '$theOrder->state', '$theOrder->postcode', '$theOrder->country', '$theOrder->phone', '$theOrder->email')";
											
											$result = $db->query($sql);
											//$stmt = oci_parse($db, $sql);
											if(!$result) 
											{
												echo "Error creating customer for placing order. Please try again shortly.\n";
												exit;
											}
											
											if ($result) //oci_execute($stmt)) // if write to database works
											{
												$output .= '<p>A new account has been created for you.<br />Your email is your username and your temporary password is <b>'.$temppasswd.'</b><br />Please <a href="register.php">login</a> to change your password and update any details you wish to.</p>';
											}
											echo($output);
										}
										
										// Close the connection
										$db->close();
										
										// Clear shopping basket contents
										unset($_SESSION['cart']);
										unset($_SESSION['basket']);
									?>
					
                                </div>
                                <!-- /.table-responsive -->
                            </div>
                            <!-- /.content -->

                            <div class="box-footer">
                                <!-- <div class="pull-left">
                                    <a href="customer-order.php" class="btn btn-default"><i class="fa fa-chevron-left"></i>View or manage your order</a>
                                </div> -->
                                <div class="pull-left">
                                    <!-- <button type="submit" class="btn btn-primary">View or manage your order<!-- <i class="fa fa-chevron-right"></i> 
                                    </button> -->
									<a href="#" class="btn btn-primary">View or manage your order</a>
                                </div>
                            </div>
                        <!-- </form> -->
                    </div>
                    <!-- /.box -->


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
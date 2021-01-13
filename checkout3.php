<?php
/*****************************************
 * SIT203 Web Programming
 * Assignment 2
 * Aaron Pethybridge
 * Student#: 217561644
 * Checkout page - Order basket display  
 *****************************************/
// Include functions
require_once('inc/basketutils.php');
require_once('inc/menuheader.php');
require_once('inc/shopping.php');
require_once('inc/userutils.php');
//require_once('inc/sit203ass2utils.php');
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
				<?php
				include "inc/sit203ass2utils.php";
				$cardname = clean($_POST['cardname']);
				$cardnumber = clean($_POST['cardnumber']);
				$expirymonth = clean($_POST['expirymonth']);
				$expiryyear = clean($_POST['expiryyear']);
				$cvv = clean($_POST['cvv']);
				$enteredFormValues = array($cardname, $cardnumber, $expirymonth, $expiryyear, $cvv);
				
				$_SESSION['cardname'] = $cardname;
				$_SESSION['cardnumber'] = $cardnumber;
				$_SESSION['expirymonth'] = $expirymonth;
				$_SESSION['expiryyear'] = $expiryyear;
				$_SESSION['cvv'] = $cvv;
				
				if (!validatedPaymentForm($enteredFormValues))
				{
					echo("ERR: " . GlobalVars::$validationErrorType);
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
									if (GlobalVars::$validationErrorMessage != "")
										echo('<p class="invalid">* Form entry error - '.GlobalVars::$validationErrorMessage.'</p>');
									echo('<div class="row">');
										echo('<div class="box payment-method">');
											echo('<h4>Payment gateway</h4>');
											echo('<p>VISA and Mastercard only.</p>');
											echo('<ul class="list-unstyled list-inline">');
												echo('<li class="list-inline-item"><img src="img/visa.svg" alt="visa" width="50"></li>');
												echo('<li class="list-inline-item"><img src="img/mastercard.svg" alt="mastercard" width="50"></li>');
											echo('</ul>');
											echo('<div class="row">');
												if (GlobalVars::$validationErrorType == CARDNAME)
													echo('<div class="col-sm-10 form-group invalid">');
												else
													echo('<div class="col-sm-10 form-group">');
												if (GlobalVars::$validationErrorType == CARDNAME)
													echo('<input type="text" name="cardname" placeholder="Name On Card" class="form-control invalid" value="'.$cardname.'">');
												else
													echo('<input type="text" name="cardname" placeholder="Name On Card" class="form-control" value="'.$cardname.'">');
												echo('</div>');
												if (GlobalVars::$validationErrorType == CARDNUMBER)
													echo('<div class="col-sm-10 form-group invalid">');
												else
													echo('<div class="col-sm-10 form-group">');
												if (GlobalVars::$validationErrorType == CARDNUMBER)
													echo('<input type="text" name="cardnumber" placeholder="Card Number" maxlength="16" class="form-control invalid" value="'.$cardnumber.'">');
												else
													echo('<input type="text" name="cardnumber" placeholder="Card Number" maxlength="16" class="form-control" value="'.$cardnumber.'">');
												echo('</div>');
												if (GlobalVars::$validationErrorType == EXPIRYMONTH)
													echo('<div class="col-sm-4 form-group invalid">');
												else
													echo('<div class="col-sm-4 form-group">');
													renderExpiryMonthList($expirymonth,'expirymonth');
													echo('<label for="expirymonth">Expiry month *</label>');
												echo('</div>');
												if (GlobalVars::$validationErrorType == EXPIRYYEAR)
													echo('<div class="col-sm-4 form-group invalid">');
												else
													echo('<div class="col-sm-4 form-group">');
													renderExpiryYearList($expiryyear,'expiryyear');
													echo('<label for="expiryyear">Expiry year *</label>');
												echo('</div>');
												if (GlobalVars::$validationErrorType == CVV)
													echo('<div class="col-sm-4 form-group invalid">');
												else
													echo('<div class="col-sm-4 form-group">');
												if (GlobalVars::$validationErrorType == CVV)
													echo('<input type="text" name="cvv" placeholder="CVV" maxlength="3" class="form-control invalid"  value="'.$cvv.'">');
												else
													echo('<input type="text" name="cvv" placeholder="CVV" maxlength="3" class="form-control"  value="'.$cvv.'">');
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
				else
				{
					$xmlDoc = new DOMDocument();
					$xmlDoc->load("catalog.xml");

					$cart = $_SESSION['cart'];
					$catalogProducts = $xmlDoc->getElementsByTagName('catalogproduct');
					$count = 0;
					$output = "";
					$items = explode(',',$cart);
					$contents = array();
					$linetotal = 0;
					$subtotal = 0;
					$fullTotal = 0;
					$basket = new ShoppingBasket();
					foreach ($items as $item) {
						$contents[$item] = (isset($contents[$item])) ? $contents[$item] + 1 : 1;
					}
					echo('<div class="col-md-12">');
						echo('<ul class="breadcrumb">');
							echo('<li><a href="index.php">Home</a>');
							echo('</li>');
							echo('<li>Checkout - Order review</li>');
						echo('</ul>');
					echo('</div>');
					echo('<div class="col-md-9" id="checkout">');
						echo('<div class="box">');
							echo('<form method="post" action="checkout4.php">');
								echo('<h1>Checkout - Order review</h1>');
								echo('<ul class="nav nav-pills nav-justified">');
									echo('<li class="disabled"><a href="#"><i class="fa fa-map-marker"></i><br>Address</a>
									</li>');
									echo('<li class="disabled"><a href="#"><i class="fa fa-money"></i><br>Payment Method</a>
									</li>');
									echo('<li class="active"><a href="#"><i class="fa fa-eye"></i><br>Order Review</a>
									</li>');
								echo('</ul>');
								echo('<div class="content">');
									echo('<div class="table-responsive">');
										echo('<table class="table">
											<thead>
												<tr>
													<th colspan="2">Product</th>
													<th>Quantity</th>
													<th>Unit price</th>
													<th>Discount</th>
													<th>Total</th>
												</tr>
											</thead>');
											echo('<tbody>');
											foreach ($contents as $qid=>$qty)
											{
												for ($i = 0; $i < ($catalogProducts->length); $i++)
												{
													$catalogProduct = $catalogProducts->item($i);
													$productAttributes = $catalogProduct->attributes;
													$id = $productAttributes->item(0)->nodeValue;
													$ctype = $productAttributes->item(1)->nodeValue;
													$title = $catalogProduct->getElementsByTagName('product')->item(0)->nodeValue;
													$imageone = $catalogProduct->getElementsByTagName('imageone')->item(0)->nodeValue;
													$price = $catalogProduct->getElementsByTagName('price')->item(0)->nodeValue;
													if ($id == $qid)
													{
														echo('<tr>');
														echo('<td>');
														echo('<img src="img/'.$imageone.'" alt="'.$title.'">');
														echo('</td>');
														echo('<td><a href="detail.php?id='.$id.'&ctype='.$ctype.'">'.$title.'</a>');
														echo('</td>');
														echo('<td>'.$qty.'</td>');
														echo('<td>$'.$price.'.00</td>');
														echo('<td>$0.00</td>');
														$subtotal = $price * $qty;
														echo('<td>$'.$subtotal.'.00</td>');
														echo('</tr>');
														$basketitem = new UOrderItem();
														$basketitem->productid = $id;
														$basketitem->productname = $title;
														$basketitem->quantity = $qty;
														$basketitem->price = $price;
														$basket->addBasketItem($basketitem);
													}
												}
												$fullTotal += $subtotal;
											}	
											$basket->basketgst = $_SESSION['gst'];
											$basket->basketshipping = $_SESSION['shipping'];
											$basket->baskettotal = $_SESSION['grandTotal'];
											$_SESSION['basket'] = serialize($basket);
											echo('</tbody>
											<tfoot>
												<tr>
													<th colspan="5">Total</th>
													<th>$'.$fullTotal.'.00</th>
												</tr>
											</tfoot>
										</table>');

									echo('</div>
									<!-- /.table-responsive -->
								</div>
								<!-- /.content -->');

								echo('<div class="box-footer">
									<div class="pull-left">
										<a href="checkout3.php" class="btn btn-default"><i class="fa fa-chevron-left"></i>Back to Payment method</a>
									</div>
									<div class="pull-right">
										<button type="submit" class="btn btn-primary">Place an order<i class="fa fa-chevron-right"></i>
										</button>
									</div>
								</div>
							</form>
						</div>
						<!-- /.box -->
					</div>
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
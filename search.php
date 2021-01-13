<?php
/*****************************************
 * SIT203 Web Programming
 * Assignment 2
 * Aaron Pethybridge
 * Student#: 217561644
 * Display results from using search button 
 *****************************************/
// Include functions
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
	<meta name="author" content="Modified by Aaron Pethybridge for Deakin Unversity unit SIT203 Assignment 1, August 2018">	
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
	<script src="js/sit203ass1.js"></script> <!-- External js file for SIT203 Assignment 1-->

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
                        <li>Search results</li>
                    </ul>

                </div>

                
                <div class="col-md-12" id="searchDisplay">
					<div class="box" id="resultsMain">
						<?php
						// Get all product data
						$xmlDoc = new DOMDocument();
						$xmlDoc->load("catalog.xml");

						$catalogProducts = $xmlDoc->getElementsByTagName('catalogproduct');
						$searchValue = $_GET["productsearch"];
						$count = 0;
						$output = "";

						// Search term is not empty
						if ($searchValue != "")
						{
								$output .= '<thead></tr>';
								$output .= '<tr id="resultsheadings">';
									$output .= '<td></td>';
									$output .= '<td></td>';
									//$output .= '<td><b>Type</b></td>';
									$output .= '<td><b>Product Name</b></td>';
									$output .= '<td><b>Product Type</b></td>';
									$output .= '<td><b>Brand</b></td>';
									$output .= '<td><b>Price</b></td>';
									$output .= '<td></td>';
								$output .= '</tr></thead><tbody>';
								for ($i = 0; $i < ($catalogProducts->length); $i++)
								{
									$catalogProduct = $catalogProducts->item($i);
									$productAttributes = $catalogProduct->attributes;
									$id = $productAttributes->item(0)->nodeValue;
									$type = $productAttributes->item(1)->nodeValue;
									if ($type == "furniture")
										$type = "Furniture";
									else
										$type = "Accessory";
									$catalogProductTitle = $catalogProduct->getElementsByTagName('product')->item(0)->nodeValue;
									$brand = $catalogProduct->getElementsByTagName('brand')->item(0)->nodeValue;
									$imageone = $catalogProduct->getElementsByTagName('imageone')->item(0)->nodeValue;
									$price = $catalogProduct->getElementsByTagName('price')->item(0)->nodeValue;
									//echo ("Prod: " . $catalogProductTitle);
									if (stristr($catalogProductTitle,$searchValue))
									{
										$output .= '<tr>';
										$output .= '<td><a href="detail.php?id=' . $id . '&ctype=' . $type . '">View</a></td>';
										$output .= '<td><img src="/~apethybr/SIT203/Ass2/img/'.$imageone.'" height="50px"alt="'.$catalogProductTitle.'"></td>';
										$output .= '<td>'.$catalogProductTitle.'</td>';
										$output .= '<td>'.$type.'</td>';
										$output .= '<td>'.$brand.'</td>';
										$output .= '<td>$'.$price.'.00</td>';
										$output .= '<td><a href="basket.php?action=add&id=' . $id . '" class="btn btn-primary"><i class="fa fa-shopping-cart"></i>Add to cart</a></td>';
										$output .= '</tr>';
										$count++;
									}
								}
							$output .= '</tbody></table>';
							$output = '<table id="resultstable"><caption><h4>Search Results</h4><h5>'.$count.' products found</h5></caption>' . $output;
						}
						else
							$output = '<table id="nosearch"><tr><td><h4>No products found. Please try a different search</h4></td></tr></table>';
						echo($output);
						?>	
					</div>
                </div>
                <!-- /.col-md-9 -->
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

	<!-- added by shang for range slider -->
	<!-- range slider plugins.js -->
	    <script src="js/plugins.js"></script>
    <!-- range slider Active js -->
    <script src="js/active.js"></script>





</body>

</html>
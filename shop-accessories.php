<?php
/*****************************************
 * SIT203 Web Programming
 * Assignment 2
 * Aaron Pethybridge
 * Student#: 217561644
 * Display accessories products page 
 *****************************************/
// Include functions
require_once('inc/menuheader.php');
// Start the session
session_start();
?>
<!DOCTYPE html>
<!--
/**************************
 * SIT203 Web Programming
 * Assignment 1
 * Aaron Pethybridge
 * Student#: 217561644
 * shop-accessories.html
 **************************/
-->
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
	
	<!-- added by Shang June 2018 for range slider-->
	<!-- <link rel="stylesheet" href="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css">
	<script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
	<script src="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script> -->

    <!-- theme stylesheet -->
    <link href="css/style.default.css" rel="stylesheet" id="theme-stylesheet"> 

    <!-- your stylesheet with modifications -->
    <link href="css/custom.css" rel="stylesheet">
	<script src="js/sit203ass1.js"></script> <!-- External js file for SIT203 Assignments -->

    <script src="js/respond.min.js"></script>

    <link rel="shortcut icon" href="favicon.png">



</head>

<body onload="loadCatalogXML('accessories')">
<?php renderMenuHeader(); ?>
   
    <div id="all">

        <div id="content">
            <div class="container">

                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li><a href="index.php">Home</a>
                        </li>
                        <li>Accessories</li>
                    </ul>
                </div>

                <div class="col-md-3">
                    <!-- *** MENUS AND FILTERS ***
 _________________________________________________________ -->
                    <div class="panel panel-default sidebar-menu">

                        <div class="panel-heading">
                            <h3 class="panel-title">Categories</h3>
                        </div>

                        <div class="panel-body">
                            <ul class="nav nav-pills nav-stacked category-menu">
                                <li>
                                    <a onclick="getCatalogData('furniture')" href="shop-furniture.php">furniture <span id="totalFurniture" class="badge pull-right">12</span></a>
                                    <ul>
                                        <li><a href="shop-furniture.php">Chairs</a>
                                        </li>
                                        <li><a href="shop-furniture.php">Beds</a>
                                        </li>												
                                        <li><a href="shop-furniture.php">Tables</a>
                                        </li>
										<li><a href="shop-furniture.php">Storage</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="active">
                                    <a onclick="getCatalogData('accessories')" href="#">Accessories  <span id="totalAccessories" class="badge pull-right">12</span></a>
                                    <ul>
                                        <li><a onclick="displayProductType('HomeDeco', 'accessories')" href="#">Home Deco</a>
                                        </li>
                                        <li><a onclick="displayProductType('TextilesRugs', 'accessories')" href="#">Textiles & Rugs</a>
                                        </li>
										<li><a onclick="displayProductType('Lighting', 'accessories')" href="#">Lighting</a>
                                        </li>
										<li><a onclick="displayProductType('PlantPotsStands', 'accessories')" href="#">Plant pots & Stands</a>
                                        </li>												
                                    </ul>
                                </li>
                            </ul>

                        </div>
                    </div>

                    <div class="panel panel-default sidebar-menu">

                        <div class="panel-heading">
                            <h3 class="panel-title">Brands <a onclick="clearBrandFilters()" class="btn btn-xs btn-danger pull-right" href="#"><i class="fa fa-times-circle"></i> Clear</a></h3>
                        </div>

                        <div id="filtersPanel" class="panel-body">
						<!-- Modified by Aaron Pethybridge August 2018.
						Removed HTML code to render filter dynamically using javascript
						-->	
                        </div>
                    </div>

                    <!-- <div class="panel panel-default sidebar-menu">

                        <div class="panel-heading">
                            <h3 class="panel-title">Price <a class="btn btn-xs btn-danger pull-right" href="#"><i class="fa fa-times-circle"></i> Clear</a></h3>
                        </div>

                        <div class="panel-body">
							<form>	-->					
			  
								<!-- <input type="range" min="0" max="2000" step="50" />  -->
								<!-- <div class="checkbox">
									<label for="minimum">Minimum</label>
										<input type="number" min="0" max="2000" id="min" name="min"  />
									
									<label for="maximum">Maximum</label>
										<input type="number" min="0" max="2000" id="max" name="max"  />
								</div>
									<button class="btn btn-default btn-sm btn-primary"><i class="fa fa-pencil"></i> Apply</button>
							
                            </form>
							
						</div>
                    </div> --> 

					<!-- added by Shang for range slider-->
					<div class="panel panel-default sidebar-menu">

                        <div class="panel-heading">
                            <h3 class="panel-title">Price <a class="btn btn-xs btn-danger pull-right" href="#"><i class="fa fa-times-circle"></i> Clear</a></h3>
                        </div>

                        <div class="panel-body widget price">
							<form>						
			  
								<!-- <input type="range" min="0" max="2000" step="50" />  -->
								<div class="widget-desc">
									<div class="slider-range">
										<div data-min="10" data-max="1000" data-unit="$" class="slider-range-price ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all" data-value-min="10" data-value-max="1000" data-label-result="">
											<div class="ui-slider-range ui-widget-header ui-corner-all"></div>
											<span class="ui-slider-handle ui-state-default ui-corner-all" tabindex="0"></span>
											<span class="ui-slider-handle ui-state-default ui-corner-all" tabindex="0"></span>
										</div>
										<div class="range-price checkbox">$10 - $1000</div>
									</div>
								</div>
									<button class="btn btn-default btn-sm btn-primary"><i class="fa fa-pencil"></i> Apply</button>
							
                            </form>
							
						</div>
                    </div>

                    <!-- *** MENUS AND FILTERS END *** -->

                    <div class="banner">
                        <a href="#">
                            <img src="img/banner.jpg" alt="sales 2014" class="img-responsive">
                        </a>
                    </div>
                </div>

                <div class="col-md-9">
                    <div class="box">
                        <h1>Accessories</h1>
                        <p>In our Accessories department we offer wide selection of the best accessories we have found and carefully selected worldwide.</p>
                    </div>

                    <div class="box info-bar">
                        <div class="row">
                            <div class="col-sm-12 col-md-4 products-showing">
                                Showing <strong><span id="startNum"></span></strong> - <strong><span id="endNum"></span></strong> of <strong><span id="totalNumResults"></span></strong> products
                            </div>

                            <div class="col-sm-12 col-md-8  products-number-sort">
                                <div class="row">
                                    <form class="form-inline">
                                        <div class="col-md-6 col-sm-6">
                                            <div id="switchNumbers" class="products-number">
                                                <strong>Show</strong>  <a href="#" class="btn btn-default btn-sm btn-primary">6</a>  <a href="#" class="btn btn-default btn-sm">12</a>  <a href="#" class="btn btn-default btn-sm">All</a> products
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                            <div class="products-sort-by">
                                                <strong>Sort by</strong>
                                                <select onchange="sortProducts(this.value)" name="sort-by" class="form-control">
													<option disabled selected hidden>Select here</option>
													<option value="asc">Price: low-high</option>
													<option value="dsc">Price: high-low</option>
                                                    <!--<option>Sales first</option>-->
                                                </select>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id = "displayAllProducts" class="row products">
                                

                    </div>
                    <!-- /.products -->

                    <div id="displayPagination" class="pages">

						<!--
                        <p class="loadMore">
                            <a href="#" class="btn btn-primary btn-lg"><i class="fa fa-chevron-down"></i> Load more</a>
                        </p>
						-->
<!--
                        <ul class="pagination">
                            <li><a href="#">&laquo;</a>
                            </li>
                            <li class="active"><a href="#">1</a>
                            </li>
                            <li><a href="#">2</a>
                            </li>
                            <li><a href="#">3</a>
                            </li>
                            <li><a href="#">4</a>
                            </li>
                            <li><a href="#">5</a>
                            </li>
                            <li><a href="#">&raquo;</a>
                            </li>
                        </ul>-->
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
	
	<!-- added by shang for range slider  -->
	<!-- range slider plugins.js -->
	<script src="js/plugins.js"></script>
    <!-- range slider Active js -->
    <script src="js/active.js"></script>
 






</body>

</html>
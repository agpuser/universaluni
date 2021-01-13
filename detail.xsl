<?xml version="1.0" encoding="ISO-8859-1"?>
<!--
/**************************
 * SIT203 Web Programming
 * Assignment 1
 * Aaron Pethybridge
 * Student#: 217561644
 * detail.xsl
 **************************/
-->

<!-- Edited by XMLSpy® -->
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:output method="html" />
	<xsl:param name="productId"/>
	<xsl:param name="range"/>

	<xsl:template match="/">
		<xsl:for-each select="catalog/catalogproduct">
			<xsl:if test="@id = $productId">
			<div class="row" id="productMain">
				<div class="col-sm-6">
					<div id="mainImage">
						<img class="img-responsive">
							<xsl:attribute name="alt">
								<xsl:value-of select="product"/> - Hero shot
							</xsl:attribute>
							<xsl:attribute name="src">
								img/<xsl:value-of select="heroimage"/>
							</xsl:attribute>
						</img>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="box">
						<h1 class="text-center"><xsl:value-of select="product"/></h1>
						<p class="goToDescription"><a href="#details" class="scroll-to">Scroll to product details, material and care </a>
						</p>
						<p class="price">$<xsl:value-of select="price"/></p>

						<p class="text-center buttons">
							<a class="btn btn-primary">
								<xsl:attribute name="href">
									basket.php?action=add&amp;id=<xsl:value-of select="@id"/>
								</xsl:attribute>
								<i class="fa fa-shopping-cart"></i> Add to cart
							</a>
						</p>


					</div>
				
					<!-- commented by Shang 04/07/2017
					<div class="row" id="thumbs">
						<div class="col-xs-4">
							<a href="img/detailbig1.jpg" class="thumb">
								<img src="img/detailsquare.jpg" alt="" class="img-responsive">
							</a>
						</div>
						<div class="col-xs-4">
							<a href="img/detailbig2.jpg" class="thumb">
								<img src="img/detailsquare2.jpg" alt="" class="img-responsive">
							</a>
						</div>
						<div class="col-xs-4">
							<a href="img/detailbig3.jpg" class="thumb">
								<img src="img/detailsquare3.jpg" alt="" class="img-responsive">
							</a>
						</div>
					</div>
					-->
				</div>

			</div>
			<div class="box">
				<p>
					<a id="details"></a>
					<h4>Product details</h4>
					<p><xsl:value-of select="details"/></p>
					<h4>Material and care</h4>
					<ul>
						<xsl:for-each select="material/mtype">
							<li><xsl:value-of select="text()"/></li>
						</xsl:for-each>
					</ul>
					<!-- <h4>Size & Fit</h4>
					<ul>
						<li>Regular fit</li>
						<li>The model (height 5'8" and chest 33") is wearing a size S</li>
					</ul> -->

					<blockquote>
						<p><em><xsl:value-of select="care"/></em>
						</p>
					</blockquote>

					<hr />
					<div class="social">
						<h4>Show it to your friends</h4>
						<p>
							<a href="#" class="external facebook" data-animate-hover="pulse"><i class="fa fa-facebook"></i></a>
							<a href="#" class="external gplus" data-animate-hover="pulse"><i class="fa fa-google-plus"></i></a>
							<a href="#" class="external twitter" data-animate-hover="pulse"><i class="fa fa-twitter"></i></a>
							<a href="#" class="email" data-animate-hover="pulse"><i class="fa fa-envelope"></i></a>
						</p>
					</div>
                </p>
			</div>
			</xsl:if>
		</xsl:for-each>
	</xsl:template>
</xsl:stylesheet>
<?php
/*****************************************
 * SIT203 Web Programming
 * Assignment 2
 * Aaron Pethybridge
 * Student#: 217561644
 * Ass 2 Shopping basket utility functions 
 *****************************************/

 // Renders shopping basket contents
 function showBasket() {
	$cart = $_SESSION['cart'];
	//echo("Cart: ".$cart);
	//$cart = "1,2,3,1,4";
	if ($cart) 
	{
		$xmlDoc = new DOMDocument();
		$xmlDoc->load("catalog.xml");

		$catalogProducts = $xmlDoc->getElementsByTagName('catalogproduct');
		$count = 0;
		$output = "";
		$items = explode(',',$cart);
		$contents = array();
		$orderTotal = 0;
		$linetotal = 0;
		
		
		foreach ($items as $item) {
			$contents[$item] = (isset($contents[$item])) ? $contents[$item] + 1 : 1;
		}
		$output[] = '<form action="checkout1.php" method="post" name="basketForm"id="basketForm">';
			$output[] = '<div class="table-responsive">';
				$output[] = '<table class="table">';
                    $output[] = '<thead>';
                        $output[] = '<tr>';
                            $output[] = '<th colspan="2">Product</th>';
                            $output[] = '<th>Quantity</th>';
                            $output[] = '<th>Unit price</th>';
                            $output[] = '<th>Discount</th>';
                            $output[] = '<th colspan="2">Total</th>';
                            $output[] = '</tr>';
                            $output[] = '</thead>';
                            $output[] = '<tbody>';
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
					$output[] = '<tr>';
						$output[] = '<td>';
							//$output[] = '<a href="#">';
								$output[] = '<img src="/~apethybr/SIT203/Ass2/img/'.$imageone.'" alt="'.$title.'">';
							//$output[] = '</a>';
						$output[] = '</td>';
						$output[] = '<td><a href="detail.html?id='.$id.'&ctype='.$ctype.'">'.$title.'</a>';
						$output[] = '</td>';
						$output[] = '<td>';
						$output[] = '<input name="prodqty'.$id.'" type="number" value="'.$qty.'" class="form-control">';
						$output[] = '</td>';
						$output[] = '<td>$'.$price.'.00</td>';
						$output[] = '<td>$0.00</td>';
						$linetotal = $price * $qty;
						$output[] = '<td>$'.$linetotal.'.00</td>';
						$output[] = '<td><a href="basket.php?action=delete&id='.$id.'"><i class="fa fa-trash-o"></i></a>';
						$output[] = '</td>';
					$output[] = '</tr>';
				}	
			}
			$orderTotal += $linetotal;
		}
		$output[] = '</tbody>';
				$output[] = '<tfoot>';
					$output[] = '<tr>';
						$output[] = '<th colspan="5">Total</th>';
						$output[] = '<th colspan="2">$'.$orderTotal.'.00</th>';
					$output[] = '</tr>';
				$output[] = '</tfoot>';
			$output[] = '</table>';

		$output[] = '</div>';
		$output[] = '<!-- /.table-responsive -->';
		$output[] = '<div class="box-footer">';
			$output[] = '<div class="pull-left">';
				$output[] = '<a href="shop-furniture.php" class="btn btn-default"><i class="fa fa-chevron-left"></i> Continue shopping</a>';
			$output[] = '</div>';
			$output[] = '<div class="pull-right">';
				$output[] = '<button onclick="submitUpdateForm(\'basket.php?action=update\')" class="btn btn-default"><i class="fa fa-refresh"></i> Update basket</button>';
				$output[] = '<button type="submit" class="btn btn-primary">Proceed to checkout <i class="fa fa-chevron-right"></i>';
				$output[] = '</button>';
			$output[] = '</div>';
		$output[] = '</div>';
	$output[] = '</form>';
	} 
	else 
	{
		$output[] = '<p>You shopping cart is empty.</p>';
	}
	//$_SESSION['cart'] = "";
	$_SESSION['orderTotal'] = $orderTotal;
	return join('',$output);
}

// Renders order summary panel to screen
function showOrderSummary()
{
	$orderTotal = $_SESSION['orderTotal'];
	if ($orderTotal == "") $orderTotal = 0;
	$output = "";
	$grandTotal = 0;
	$gst = 0;
	$shipping = 20;
	$output[] = '<table class="table">';
		$output[] = '<tbody>';
			$output[] = '<tr>';
				$output[] = '<td>Order subtotal</td>';
				$output[] = '<th>$'.$orderTotal.'.00</th>';
			$output[] = '</tr>';
			$output[] = '<tr>';
				$output[] = '<td>Shipping and handling</td>';
				$shipping = $orderTotal > 500 ? 0 : 20;
				if ($shipping == 0)
					$output[] = '<th><b>Free</b></th>';
				else
					$output[] = '<th>$'.$shipping.'.00</th>';
			$output[] = '</tr>';
			$output[] = '<tr>';
				$output[] = '<td>GST 10%</td>';
				$gst = calculateGST($orderTotal);
				$output[] = '<th>$'.$gst.'</th>';
			$output[] = '</tr>';
			$output[] = '<tr class="total">';
				$output[] = '<td>Total</td>';
				$grandTotal = $orderTotal + $gst + $shipping;
				$grandTotal = number_format($grandTotal, 2);
				$output[] = '<th>$'.$grandTotal.'</th>';
			$output[] = '</tr>';
		$output[] = '</tbody>';
	$output[] = '</table>';
	$_SESSION['shipping'] = $shipping;
	$_SESSION['gst'] = $gst;
	$_SESSION['grandTotal'] = $grandTotal;
	return join('',$output);
}

// Returns GST total for a given total
function calculateGST($total)
{
	$total = $total * 0.1;
	return number_format($total, 2);
}

 ?>
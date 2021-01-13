<?php
 /**************************************
 * SIT203 Web Programming
 * Assignment 2
 * Aaron Pethybridge
 * Student#: 217561644
 * Ass 2 Uorder &
 * ShoppingBasket classes 
 **************************************/
 
 // Holder class for order information
 class Uorder 
 {
	// data members 
	var $orderid;
	var $ordertotal;
	var $ordersubtotal;
	var $ordergst;
	var $ordershipping;
	var $firstname;
	var $lastname;
	var $address;
	var $company;
	var $city;
	var $postcode;
	var $state;
	var $country;
	var $phone;
	var $email;
	var $cardname;
	var $cardnumber;
	var $expirymonth;
	var $expiryyear;
	var $cvv;
	var $orderItems = array();
	var $numorderitems;
	
	// constructor
	function Uorder()
	{
		$this->numorderitems = 0;
		$this->orderid = 0;
	}
	
	// methods
	function addOrderItem($orderItem)
	{
		$this->orderItems[$this->numorderitems] = $orderItem;
		$this->numorderitems++;
	}
 }
 
 // Holder class for shopping basket information
 class ShoppingBasket
 {
	// data members 
	var $basketItems = array();
	var $baskettotal;
	var $basketgst;
	var $basketshipping;
	var $numbasketlineitems;
	
	// constructor
	function ShoppingBasket()
	{
		$this->baskettotal = 0;
		$this->basketgst = 0;
		$this->basketshipping = 0;
		$this->numbasketlineitems = 0;
	}
	
	// methods
	function addBasketItem($basketItem)
	{
		$this->basketItems[] = $basketItem;
		$this->numbasketlineitems++;
	}
	 
	
 }
 
 // Holder class for order line item information
 class UOrderItem
 {
	// data members
	var $orderitemid;
	var $productid;
	var $productname;
	var $quantity;
	var $price;
	
	// constructor
	function UOrderItem()
	{
		$this->orderitemid = 0;
		$this->productid = 0;
		$this->productname = 0;
		$this->quantity = 0;
		$this->price = 0;
	}
	
 }
 

 ?>
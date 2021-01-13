<?php
/*****************************
 * SIT203 Web Programming
 * Assignment 2
 * Aaron Pethybridge
 * Student#: 217561644
 * Ass 2 PHP function library 
 *****************************/
 
// Global constants
define("FNAME",0);
define("CARDNAME",0);
define("LNAME",1);
define("CARDNUMBER",1);
define("ADDRESS",2);
define("EXPIRYMONTH",2);
define("COMPANY",3);
define("EXPIRYYEAR",3);
define("CVVLENGTH",3);
define("CITY", 4);
define("CVV", 4);
define("POSTCODE", 5);
define("STATE", 6);
define("COUNTRY", 7); 
define("PHONE", 8);
define("EMAIL", 9);

define("MAXPCODE",4);
define("MAXMOBILE", 10);
define("MAXPHONE", 12);
define("CARDLENGTH", 16);

define("DEFAULTOPTION", "-- Select one --");
 
// Global variables class
class GlobalVars
{
	static $validationErrorMessages = array("");
	static $validationErrorMessage = "";
	static $validationErrorType;
	static $validatedAddressForm = false;
	static $validatedPaymentForm = false;
	static $stateList = array(DEFAULTOPTION, "VIC", "NSW", "SA", "TAS", "WA", "QLD", "NT", "ACT");
	static $expiryMonthList = array(DEFAULTOPTION, "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
	static $expiryYearList = array(DEFAULTOPTION, "2018", "2019", "2020", "2021", "2022", "2023", "2024");
}
 
// functions
function addressFormValidated()
{
	return GlobalVars::$validatedAddressForm;
}

function validatedPaymentForm($validationValues)
{
	GlobalVars::$validatedPaymentForm = false;
	if (!validatedAlphaString($validationValues[CARDNAME], "Name On Card", CARDNAME, "^[A-Za-z\040\-]+$"))
		return false;
	if (!validatedCardNumber($validationValues[CARDNUMBER], "Card Number", CARDNUMBER, "^[0-9]{16}$"))
		return false;
	if (!validatedSelect($validationValues[EXPIRYMONTH], "Expiry month", EXPIRYMONTH))
		return false;
	if (!validatedSelect($validationValues[EXPIRYYEAR], "Expiry year", EXPIRYYEAR))
		return false;
	if (!validatedCVV($validationValues[CVV], "Cvv number", CVV, "^[0-9]{3}$"))
		return false;
	GlobalVars::$validatedPaymentForm = true;
	return GlobalVars::$validatedPaymentForm;
}

function validatedCVV($inName, $nameType, $nameIndex, $regex)
{
	$result = true;
	if ($inName == "")
	{
		GlobalVars::$validationErrorMessage = "Please enter <b>" . $nameType . "</b> - required field.";
		GlobalVars::$validationErrorType = $nameIndex;
		$result = false;
	}
	else
	{
		if (strlen($inName) != CVVLENGTH)
		{
			GlobalVars::$validationErrorMessage = "<b>" . $nameType . "</b> must be 3 digits long.";
			GlobalVars::$validationErrorType = $nameIndex;
			$result = false;
		}
		else if (!ereg($regex, $inName))
		{
			GlobalVars::$validationErrorMessage = "<b>" . $nameType . "</b> can contain only digits.";
			GlobalVars::$validationErrorType = $nameIndex;
			$result = false;
		}
	}
	return $result;	
}

function validatedCardNumber($inName, $nameType, $nameIndex, $regex)
{
	$result = true;
	if ($inName == "")
	{
		GlobalVars::$validationErrorMessage = "Please enter <b>" . $nameType . "</b> - required field.";
		GlobalVars::$validationErrorType = $nameIndex;
		$result = false;
	}
	else
	{
		if (strlen($inName) != CARDLENGTH)
		{
			GlobalVars::$validationErrorMessage = "<b>" . $nameType . "</b> must be 16 digits long.";
			GlobalVars::$validationErrorType = $nameIndex;
			$result = false;
		}
		else if (!ereg($regex, $inName))
		{
			GlobalVars::$validationErrorMessage = "<b>" . $nameType . "</b> can contain only digits.";
			GlobalVars::$validationErrorType = $nameIndex;
			$result = false;
		}
		else
		{
			if (($inName[0] != "4") && ($inName[0] != "5"))
			{
				GlobalVars::$validationErrorMessage = "<b>" . $nameType . "</b> is not a Visa or Mastercard number.";
				GlobalVars::$validationErrorType = $nameIndex;
				$result = false;
			}
		}
	}
	return $result;	
}

function validatedAddressForm($validationValues)
{
	GlobalVars::$validatedAddressForm = false;
	if (!validatedStringField($validationValues[FNAME], "Firstname", FNAME, "^[A-Za-z0-9\040.\-]+$"))
		return false;
	if (!validatedStringField($validationValues[LNAME], "Lastname", LNAME, "^[A-Za-z0-9\040.\-]+$"))
		return false;
	if (!validatedStringField($validationValues[ADDRESS], "Address", ADDRESS, "^[A-Za-z0-9\040.\-]+$"))
		return false;
	if (!validatedAlphaString($validationValues[CITY], "City", CITY, "^[A-Za-z\040\-]+$"))
		return false;
	if (!validatedPostcode($validationValues[POSTCODE], "Postcode", POSTCODE, "^[0-9]{4}$"))
		return false;
	if (!validatedSelect($validationValues[STATE], "State", STATE))
		return false;
	if (!validatedPhone($validationValues[PHONE], "Phone", PHONE, "^\([0-9]{2}\)[0-9]{8}$", "^[0-9]{10}$"))
		return false;
	if (!validatedEmail($validationValues[EMAIL], "Email", EMAIL, "^[A-Za-z0-9]+@[A-Za-z0-9]+.[A-Za-z]+$"))
		return false;
	GlobalVars::$validatedAddressForm = true;
	return GlobalVars::$validatedAddressForm;
}

function validatedStringField($inName, $nameType, $nameIndex, $regex)
{
	$result = true;
	if ($inName == "")
	{
		GlobalVars::$validationErrorMessage = "Please enter <b>" . $nameType . "</b> - required field.";
		GlobalVars::$validationErrorType = $nameIndex;
		$result = false;
	}
	else
	{
		if (!ereg($regex, $inName))
		{
			GlobalVars::$validationErrorMessage = "<b>" . $nameType . "</b> can contain only alphanumerics, ' ', '-' and '.'.";
			GlobalVars::$validationErrorType = $nameIndex;
			$result = false;
		}
	}
	return $result;	
}

function validatedAlphaString($inName, $nameType, $nameIndex, $regex)
{
	$result = true;
	if ($inName == "")
	{
		GlobalVars::$validationErrorMessage = "Please enter <b>" . $nameType . "</b> - required field.";
		GlobalVars::$validationErrorType = $nameIndex;
		$result = false;
	}
	else
	{
		if (!ereg($regex, $inName))
		{
			GlobalVars::$validationErrorMessage = "<b>" . $nameType . "</b> can contain only alphabetics, ' ' and '-'.";
			GlobalVars::$validationErrorType = $nameIndex;
			$result = false;
		}
	}
	return $result;	
}

function validatedPostcode($inName, $nameType, $nameIndex, $regex)
{
	$result = true;
	if ($inName == "")
	{
		GlobalVars::$validationErrorMessage = "Please enter <b>" . $nameType . "</b> - required field.";
		GlobalVars::$validationErrorType = $nameIndex;
		$result = false;
	}
	else if (strlen($inName) != MAXPCODE)
	{
		GlobalVars::$validationErrorMessage = "<b>" . $nameType . "</b> must be 4 digits long, i.e. 2048.";
		GlobalVars::$validationErrorType = $nameIndex;
		$result = false;
	}
	else
	{
		if (!ereg($regex, $inName))
		{
			GlobalVars::$validationErrorMessage = "<b>" . $nameType . "</b> can contain only digits.";
			GlobalVars::$validationErrorType = $nameIndex;
			$result = false;
		}
	}
	return $result;	
}

function validatedSelect($inName, $nameType, $nameIndex)
{
	$result = true;
	if ($inName == DEFAULTOPTION)
	{
		GlobalVars::$validationErrorMessage = "Please select <b>" . $nameType . "</b> - required field.";
		GlobalVars::$validationErrorType = $nameIndex;
		$result = false;
	}
	return $result;	
}

function validatedPhone($inName, $nameType, $nameIndex, $regex, $regmob)
{
	$result = true;
	if ($inName == "")
	{
		GlobalVars::$validationErrorMessage = "Please enter <b>" . $nameType . "</b> - required field.";
		GlobalVars::$validationErrorType = $nameIndex;
		$result = false;
	}
	else if (strlen($inName) != MAXPHONE && strlen($inName) != MAXMOBILE)
	{
		GlobalVars::$validationErrorMessage = "<b>" . $nameType . "</b> must be 10 or 12 (including brackets) digits long.";
		GlobalVars::$validationErrorType = $nameIndex;
		$result = false;
	}
	else
	{
		if (!ereg($regex, $inName) && !ereg($regmob, $inName))
		{
			GlobalVars::$validationErrorMessage = "<b>" . $nameType . "</b> must in form (99)99990000 or 99990009999.";
			GlobalVars::$validationErrorType = $nameIndex;
			$result = false;
		}
	}
	return $result;	
}

function validatedEmail($inName, $nameType, $nameIndex, $regex)
{
	$result = true;
	if ($inName == "")
	{
		GlobalVars::$validationErrorMessage = "Please enter <b>" . $nameType . "</b> - required field.";
		GlobalVars::$validationErrorType = $nameIndex;
		$result = false;
	}
	else
	{
		if (!ereg($regex, $inName))
		{
			GlobalVars::$validationErrorMessage = "<b>" . $nameType . "</b> must be in form that has a '@' and a '.'.";
			GlobalVars::$validationErrorType = $nameIndex;
			$result = false;
		}
	}
	return $result;	
}
 
function getErrorMessages()
{
	return GlobalVars::$validationErrorMessages;
}

function renderStateList($inValue, $name)
{
	echo('<select class="form-control" name="'.$name.'" id="'.$name.'">');
	for ($s = 0; $s < count(GlobalVars::$stateList); $s++)
	{
		echo('<option value="'.GlobalVars::$stateList[$s].'" ');
		if ($inValue == GlobalVars::$stateList[$s]) echo(' selected');
		echo('>' . GlobalVars::$stateList[$s] . '</option>');
	}
	echo('</select>');
}

function renderExpiryMonthList($inValue, $name)
{
	echo('<select class="form-control" name="'.$name.'" id="'.$name.'">');
	for ($s = 0; $s < count(GlobalVars::$expiryMonthList); $s++)
	{
		echo('<option value="'.GlobalVars::$expiryMonthList[$s].'" ');
		if ($inValue == GlobalVars::$expiryMonthList[$s]) echo(' selected="true" ');
		echo('>' . GlobalVars::$expiryMonthList[$s] . '</option>');
	}
	echo('</select>');
}
 
function renderExpiryYearList($inValue, $name)
{
	echo('<select class="form-control" name="'.$name.'" id="'.$name.'">');
	for ($s = 0; $s < count(GlobalVars::$expiryYearList); $s++)
	{
		echo('<option value="'.GlobalVars::$expiryYearList[$s].'" ');
		if ($inValue == GlobalVars::$expiryYearList[$s]) echo(' selected="true" ');
		echo('>' . GlobalVars::$expiryYearList[$s] . '</option>');
	}
	echo('</select>');
} 
 
?>
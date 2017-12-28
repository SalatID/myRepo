<?php
session_start();
include '../../lib/config.php';
$db = new config();
$userId = $_SESSION['userId'];
$dataContract = $_SESSION['contract'];
$dataSlot = $_SESSION['slot'];
//print_r($dataSlot);
$today = date('ymd');
//echo $today;
//print_r($dataContract);
$errorKey = array();
$j=0;
foreach ($dataSlot as $keySlot => $valueSlot) {
	//echo $keySlot;
	//echo $valueSlot['date']." ".$valueSlot['timeId']."</br>";
	$table = "slot";
	$field = "id, date, timeId";
	$where = "date="."'".$valueSlot['date']."'"." and timeId=".$valueSlot['timeId'];
	$on = "";
	$date = $valueSlot['date'];
	$timeId =$valueSlot['timeId'];
	$days = $valueSlot['days'];
	$adsId = $valueSlot['adsId'];
	$contractDate = date("Y-m-d");
	$uploadDate = date("Y-m-d h:i:s");
	$db->select($table,$field,$on,$where);
	$result = $db->getResult();
	$decode = json_decode($result, true);
	$rowSlot = $decode['post'];
	if (count($rowSlot) > 0) {
		$errorKey[$j]=$keySlot;
		$j++;
	}
}
if (count($errorKey)>0) {
	print_r($errorKey);
	$encode = json_encode($errorKey);
	header('location:../index.php?modul=newContract&error='.base64_encode('Slot is not available').'&key='.base64_encode($encode));
}else {

	// PayPal settings
	$paypalEmail = 'seller@kiosaya.com';
	$returnUrl = 'http://kiosaya.000webhostapp.com/kiosaya/seller/halaman/addContract.php';
	$cancelUrl = 'http://kiosaya.000webhostapp.com/kiosaya/seller/halaman/payment-cancelled.html';
	$notifyUrl = 'http://kiosaya.000webhostapp.com/kiosaya/seller/halaman/payments.php';

	$itemName = 'Contract Payment for Contract Number'.$_POST['ctrId'];
	$itemAmount = $_POST['amount'];


	// Include Functions
	//include("functions.php");

	// Check if paypal request or response
	if (!isset($_POST["txn_id"]) && !isset($_POST["txn_type"])){
		$queryString = '';

		// Firstly Append paypal account to querystring
		$queryString .= "?business=".urlencode($paypalEmail)."&";

		// Append amount& currency (£) to quersytring so it cannot be edited in html

		//The item name and amount can be brought in dynamically by querying the $_POST['item_number'] variable.
		$queryString .= "item_name=".urlencode($itemName)."&";
		$queryString .= "amount=".urlencode($itemAmount)."&";

		//loop for posted values and append to querystring
		foreach($_POST as $keyPost => $valuePost){
			$valuePost = urlencode(stripslashes($valuePost));
			$queryString .= "$keyPost=$valuePost&";
		}

		// Append paypal return addresses
		$queryString .= "return=".urlencode(stripslashes($returnUrl))."&";
		$queryString .= "cancel_return=".urlencode(stripslashes($cancelUrl))."&";
		$queryString .= "notify_url=".urlencode($notifyUrl);

		// Append querystring with custom field
		//$queryString .= "&custom=".USERID;

		// Redirect to paypal IPN
		header('location:https://www.sandbox.paypal.com/cgi-bin/webscr'.$queryString);
		exit();
	} else {
			// Response from Paypal

		// read the post from PayPal system and add 'cmd'
		$req = 'cmd=_notify-validate';
		foreach ($_POST as $keyPost => $valuePost) {
			$valuePost = urlencode(stripslashes($valuePost));
			$valuePost = preg_replace('/(.*[^%^0^D])(%0A)(.*)/i','${1}%0D%0A${3}',$valuePost);// IPN fix
			$req .= "&$keyPost=$valuePost";
		}

		// assign posted variables to local variables
		$data['item_name']			= $_POST['item_name'];
		$data['item_number'] 		= $_POST['item_number'];
		$data['payment_status'] 	= $_POST['payment_status'];
		$data['payment_amount'] 	= $_POST['mc_gross'];
		$data['payment_currency']	= $_POST['mc_currency'];
		$data['txn_id']				= $_POST['txn_id'];
		$data['receiver_email'] 	= $_POST['receiver_email'];
		$data['payer_email'] 		= $_POST['payer_email'];
		$data['custom'] 			= $_POST['custom'];

		// post back to PayPal system to validate
		$header = "POST /cgi-bin/webscr HTTP/1.0\r\n";
		$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
		$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";

		$fp = fsockopen ('ssl://www.sandbox.paypal.com', 443, $errno, $errstr, 30);

		if (!$fp) {
			// HTTP ERROR

		} else {
			fputs($fp, $header . $req);
			while (!feof($fp)) {
				$res = fgets ($fp, 1024);
				if (strcmp($res, "VERIFIED") == 0) {

					// Used for debugging
					// mail('user@domain.com', 'PAYPAL POST - VERIFIED RESPONSE', print_r($post, true));

					// Validate payment (Check unique txnid & correct price)
					$validTxnid = check_txnid($data['txn_id']);
					$validPrice = check_price($data['payment_amount'], $data['item_number']);
					// PAYMENT VALIDATED & VERIFIED!

				} else if (strcmp ($res, "INVALID") == 0) {

					// PAYMENT INVALID & INVESTIGATE MANUALY!
					// E-mail admin or alert user

					// Used for debugging
					@mail("admin@iklaninaja.com", "PAYPAL DEBUGGING", "Invalid Response<br />data = <pre>".print_r($post, true)."</pre>");
				}
			}
		fclose ($fp);
		}
	}
}
?>

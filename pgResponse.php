<?php
header("Pragma: no-cache");
header("Cache-Control: no-cache");
header("Expires: 0");

// following files need to be included
require_once("./lib/config_paytm.php");
require_once("./lib/encdec_paytm.php");

session_start();
include('database.inc.php');
include('function.inc.php');
include('constant.inc.php');
include('smtp/PHPMailerAutoload.php');

$paytmChecksum = "";
$paramList = array();
$isValidChecksum = "FALSE";

$paramList = $_POST;

if (!isset($_SESSION['FOOD_USER_ID'])) {
	$res = mysqli_query($con, "select user.* from user,order_master where user.id=order_master.user_id order by order_master.id desc");
	if (mysqli_num_rows($res) > 0) {
		$row = mysqli_fetch_assoc($res);
		$_SESSION['FOOD_USER_ID'] = $row['id'];
		$_SESSION['FOOD_USER_NAME'] = $row['name'];
		$_SESSION['FOOD_USER_EMAIL'] = $row['email'];
	}
}
// prx($_SESSION);

$paytmChecksum = isset($_POST["CHECKSUMHASH"]) ? $_POST["CHECKSUMHASH"] : "";
$isValidChecksum = verifychecksum_e($paramList, PAYTM_MERCHANT_KEY, $paytmChecksum); //will return TRUE or FALSE string.


if ($isValidChecksum == "TRUE") {
	if ($_POST["STATUS"] == "TXN_SUCCESS") {
		$TXNID = $_POST['TXNID'];
		$amt = $_POST['TXNAMOUNT'];
		if (isset($_SESSION['IS_WALLET'])) {
			manageWallet($_SESSION['FOOD_USER_ID'], $amt, 'in', 'Added', $TXNID);
			unset($_SESSION['IS_WALLET']);
			redirect(FRONT_SITE_PATH . 'wallet');
		} else {
			$oid = $_POST['ORDERID'];
			$oArr = explode('_', $oid);
			$oid = $oArr[1];
			$uuid = $oArr[2];
			$getUserDetailsBy = getUserDetailsByid($uuid);
			// prx($getUserDetailsBy);
			$email = $getUserDetailsBy['email'];
			$emailHTML = orderEmail($oid);
			$_SESSION['ORDER_ID'] = $oid;

			mysqli_query($con, "update  order_master set payment_status='success', 	payment_id='$TXNID' where id='$oid'");
			send_email($email, $emailHTML, 'Order Placed');
			redirect(FRONT_SITE_PATH . 'success');
		}
	} else {
		$oid = $_POST['ORDERID'];
		$oArr = explode('_', $oid);
		$oid = $oArr[1];
		$TXNID = $_POST['TXNID'];
		mysqli_query($con, "update payment_status='failed', payment_id='$TXNID' where id='$oid'");
		redirect(FRONT_SITE_PATH . 'error');
	}
} else {
	$oid = $_POST['ORDERID'];
	$oArr = explode('_', $oid);
	$oid = $oArr[1];
	$TXNID = $_POST['TXNID'];
	mysqli_query($con, "update payment_status='failed', payment_id='$TXNID' where id='$oid'");
	redirect(FRONT_SITE_PATH . 'error');
}

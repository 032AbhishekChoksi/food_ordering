<?php
session_start();
include('database.inc.php');
include('function.inc.php');
include('constant.inc.php');
include('vendor/autoload.php');
if(!isset($_SESSION['FOOD_USER_ID'])){
	redirect(FRONT_SITE_PATH.'shop');
}
if(isset($_GET['id'])  && $_GET['id']>0){
	$id=get_safe_value($_GET['id']);
	$orderEmail=orderEmail($id);
	
	$mpdf=new \Mpdf\Mpdf();
	$mpdf->WriteHTML($orderEmail);
	$file=time().'.pdf';
	$mpdf->Output($file,'D');
}
?>
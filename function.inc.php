<?php
function pr($arr){
	echo '<pre>';
	print_r($arr);
}

function prx($arr){
	echo '<pre>';
	print_r($arr);
	die();
}

function get_safe_value($str){
	global $con;
	$str=mysqli_real_escape_string($con,$str);
	return $str;

}

function redirect($link){
	?>
	<script>
	window.location.href='<?php echo $link?>';
	</script>
	<?php
	die();
}

function send_email($email,$html,$subject){

	$mail=new PHPMailer(true);
	$mail->isSMTP();
	$mail->Host="smtp.gmail.com";
	$mail->Port=587;
	$mail->SMTPSecure="tls";
	$mail->SMTPAuth=true;
	$mail->Username="abhishekmeet3215@gmail.com";
	$mail->Password="abhishek3215meet";
	$mail->SetFrom("abhishekmeet3215@gmail.com");
	$mail->addAddress($email);
	$mail->IsHTML(true);
	$mail->Subject=$subject;
	$mail->Body=$html;
	$mail->SMTPOptions=array('ssl'=>array(
		'verify_peer'=>false,
		'verify_peer_name'=>false,
		'allow_self_signed'=>false
	));
	if($mail->send()){
		//echo "done";
	}else{
		//echo "Error occur";
	}
}

function rand_str(){
	$str=str_shuffle("abcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyz");
	return $str=substr($str,0,15);
	
}

function getUserDetailsByid(){
	global $con;
	$data['name']='';
	$data['email']='';
	$data['moblie']='';

	if(isset($_SESSION['FOOD_USER_ID'])){
		$row = mysqli_fetch_assoc(mysqli_query($con,"select * from user where id=".$_SESSION['FOOD_USER_ID']));
		$data['name']=$row['name'];
		$data['email']=$row['email'];
		$data['moblie']=$row['mobile'];
	}
	return $data;
}
?>
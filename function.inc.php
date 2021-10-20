<?php
function pr($arr)
{
	echo '<pre>';
	print_r($arr);
}

function prx($arr)
{
	echo '<pre>';
	print_r($arr);
	die();
}

function get_safe_value($str)
{
	global $con;
	$str = mysqli_real_escape_string($con, $str);
	return $str;
}

function redirect($link)
{
?>
	<script>
		window.location.href = '<?php echo $link ?>';
	</script>
<?php
	die();
}

function send_email($email, $html, $subject)
{

	$mail = new PHPMailer(true);
	$mail->isSMTP();
	$mail->Host = "smtp.gmail.com";
	$mail->Port = 587;
	$mail->SMTPSecure = "tls";
	$mail->SMTPAuth = true;
	$mail->Username = "abhishekmeet3215@gmail.com";
	$mail->Password = "abhishek3215meet";
	$mail->SetFrom("abhishekmeet3215@gmail.com");
	$mail->addAddress($email);
	$mail->IsHTML(true);
	$mail->Subject = $subject;
	$mail->Body = $html;
	$mail->SMTPOptions = array('ssl' => array(
		'verify_peer' => false,
		'verify_peer_name' => false,
		'allow_self_signed' => false
	));
	if ($mail->send()) {
		//echo "done";
	} else {
		//echo "Error occur";
	}
}

function rand_str()
{
	$str = str_shuffle("abcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyz");
	return $str = substr($str, 0, 15);
}

function getUserCart()
{
	global $con;
	$arr = array();
	$id = $_SESSION['FOOD_USER_ID'];
	$res = mysqli_query($con, "select * from dish_cart where user_id='$id'");
	while ($row = mysqli_fetch_assoc($res)) {
		$arr[] = $row;
	}
	return $arr;
}


function getUserDetailsByid()
{
	global $con;
	$data['name'] = '';
	$data['email'] = '';
	$data['mobile'] = '';

	if (isset($_SESSION['FOOD_USER_ID'])) {
		$row = mysqli_fetch_assoc(mysqli_query($con, "select * from user where id=" . $_SESSION['FOOD_USER_ID']));
		$data['name'] = $row['name'];
		$data['email'] = $row['email'];
		$data['mobile'] = $row['mobile'];
	}
	return $data;
}

function manageUserCart($uid, $qty, $attr)
{
	global $con;
	$res = mysqli_query($con, "select * from dish_cart where user_id='$uid' and dish_detail_id='$attr'");
	if (mysqli_num_rows($res) > 0) {
		$row = mysqli_fetch_assoc($res);
		$cid = $row['id'];
		mysqli_query($con, "update dish_cart set qty='$qty' where id='$cid'");
	} else {
		$added_on = date('Y-m-d h:i:s');
		mysqli_query($con, "insert into dish_cart(user_id,dish_detail_id,qty,added_on) values('$uid','$attr','$qty','$added_on')");
	}
}

function getUserFullCart($attr_id = '')
{
	$cartArr = array();
	if (isset($_SESSION['FOOD_USER_ID'])) {
		$getUserCart = getUserCart();
		$cartArr = array();
		foreach ($getUserCart as $list) {
			$cartArr[$list['dish_detail_id']]['qty'] = $list['qty'];
			$getDishDetail = getDishDetailById($list['dish_detail_id']);

			$cartArr[$list['dish_detail_id']]['price'] = $getDishDetail['price'];
			$cartArr[$list['dish_detail_id']]['dish'] = $getDishDetail['dish'];
			$cartArr[$list['dish_detail_id']]['image'] = $getDishDetail['image'];
		}
	} else {
		if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
			foreach ($_SESSION['cart'] as $key => $val) {
				$cartArr[$key]['qty'] = $val['qty'];
				$getDishDetail = getDishDetailById($key);
				$cartArr[$key]['price'] = $getDishDetail['price'];
				$cartArr[$key]['dish'] = $getDishDetail['dish'];
				$cartArr[$key]['image'] = $getDishDetail['image'];
			}
		}
	}
	if ($attr_id != '') {
		return $cartArr[$attr_id]['qty'];
	} else {
		return $cartArr;
	}
}

function getDishDetailById($id)
{
	global $con;
	$res = mysqli_query($con, "select dish.dish,dish.image,dish_details.price from dish_details,dish where dish_details.id='$id' and dish.id=dish_details.dish_id");
	$row = mysqli_fetch_assoc($res);
	return $row;
}
function removeDishFromCartByid($id)
{
	if (isset($_SESSION['FOOD_USER_ID'])) {
		global $con;
		$res = mysqli_query($con, "delete from dish_cart where dish_detail_id='$id' and user_id=" . $_SESSION['FOOD_USER_ID']);
	} else {
		unset($_SESSION['cart'][$id]);
	}
}
function emptyCart()
{
	if (isset($_SESSION['FOOD_USER_ID'])) {
		global $con;
		$res = mysqli_query($con, "delete from dish_cart where user_id=" . $_SESSION['FOOD_USER_ID']);
	} else {
		unset($_SESSION['cart']);
	}
}

function getOrderDetails($oid)
{
	global $con;
	$sql = "select order_detail.price,order_detail.qty,dish_details.attribute,dish.dish
	from order_detail,dish_details,dish
	WHERE
	order_detail.order_id=$oid AND
	order_detail.dish_details_id=dish_details.id AND
	dish_details.dish_id=dish.id";
	$data = array();
	$res = mysqli_query($con, $sql);
	while ($row = mysqli_fetch_assoc($res)) {
		$data[] = $row;
	}
	return $data;
}

function getOrderById($oid)
{
	global $con;
	$sql = "select * from order_master where id='$oid'";
	$data = array();
	$res = mysqli_query($con, $sql);
	while ($row = mysqli_fetch_assoc($res)) {
		$data[] = $row;
	}
	return $data;
}

function orderEmail($oid)
{
	$getUserDetailsBy = getUserDetailsByid();
	$name = $getUserDetailsBy['name'];
	$email = $getUserDetailsBy['email'];

	$getOrderById = getOrderById($oid);

	$order_id = $getOrderById[0]['id'];
	$total_amount = $getOrderById[0]['total_price'];

	$getOrderDetails = getOrderDetails($oid);

	$html = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="x-apple-disable-message-reformatting" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title></title>
    <style type="text/css" rel="stylesheet" media="all">
    /* Base ------------------------------ */
    
    @import url("https://fonts.googleapis.com/css?family=Nunito+Sans:400,700&display=swap");
    body {
      width: 100% !important;
      height: 100%;
      margin: 0;
      -webkit-text-size-adjust: none;
    }
    
    a {
      color: #3869D4;
    }
    
    a img {
      border: none;
    }
    
    td {
      word-break: break-word;
    }
    
    .preheader {
      display: none !important;
      visibility: hidden;
      mso-hide: all;
      font-size: 1px;
      line-height: 1px;
      max-height: 0;
      max-width: 0;
      opacity: 0;
      overflow: hidden;
    }
    /* Type ------------------------------ */
    
    body,
    td,
    th {
      font-family: "Nunito Sans", Helvetica, Arial, sans-serif;
    }
    
    h1 {
      margin-top: 0;
      color: #333333;
      font-size: 22px;
      font-weight: bold;
      text-align: left;
    }
    
    h2 {
      margin-top: 0;
      color: #333333;
      font-size: 16px;
      font-weight: bold;
      text-align: left;
    }
    
    h3 {
      margin-top: 0;
      color: #333333;
      font-size: 14px;
      font-weight: bold;
      text-align: left;
    }
    
    td,
    th {
      font-size: 16px;
    }
    
    p,
    ul,
    ol,
    blockquote {
      margin: .4em 0 1.1875em;
      font-size: 16px;
      line-height: 1.625;
    }
    
    p.sub {
      font-size: 13px;
    }
    /* Utilities ------------------------------ */
    
    .align-right {
      text-align: right;
    }
    
    .align-left {
      text-align: left;
    }
    
    .align-center {
      text-align: center;
    }
    /* Buttons ------------------------------ */
    
    .button {
      background-color: #3869D4;
      border-top: 10px solid #3869D4;
      border-right: 18px solid #3869D4;
      border-bottom: 10px solid #3869D4;
      border-left: 18px solid #3869D4;
      display: inline-block;
      color: #FFF;
      text-decoration: none;
      border-radius: 3px;
      box-shadow: 0 2px 3px rgba(0, 0, 0, 0.16);
      -webkit-text-size-adjust: none;
      box-sizing: border-box;
    }
    
    .button--green {
      background-color: #22BC66;
      border-top: 10px solid #22BC66;
      border-right: 18px solid #22BC66;
      border-bottom: 10px solid #22BC66;
      border-left: 18px solid #22BC66;
    }
    
    .button--red {
      background-color: #FF6136;
      border-top: 10px solid #FF6136;
      border-right: 18px solid #FF6136;
      border-bottom: 10px solid #FF6136;
      border-left: 18px solid #FF6136;
    }
    
    @media only screen and (max-width: 500px) {
      .button {
        width: 100% !important;
        text-align: center !important;
      }
    }
    /* Attribute list ------------------------------ */
    
    .attributes {
      margin: 0 0 21px;
    }
    
    .attributes_content {
      background-color: #F4F4F7;
      padding: 16px;
    }
    
    .attributes_item {
      padding: 0;
    }
    /* Related Items ------------------------------ */
    
    .related {
      width: 100%;
      margin: 0;
      padding: 25px 0 0 0;
      -premailer-width: 100%;
      -premailer-cellpadding: 0;
      -premailer-cellspacing: 0;
    }
    
    .related_item {
      padding: 10px 0;
      color: #CBCCCF;
      font-size: 15px;
      line-height: 18px;
    }
    
    .related_item-title {
      display: block;
      margin: .5em 0 0;
    }
    
    .related_item-thumb {
      display: block;
      padding-bottom: 10px;
    }
    
    .related_heading {
      border-top: 1px solid #CBCCCF;
      text-align: center;
      padding: 25px 0 10px;
    }
    /* Discount Code ------------------------------ */
    
    .discount {
      width: 100%;
      margin: 0;
      padding: 24px;
      -premailer-width: 100%;
      -premailer-cellpadding: 0;
      -premailer-cellspacing: 0;
      background-color: #F4F4F7;
      border: 2px dashed #CBCCCF;
    }
    
    .discount_heading {
      text-align: center;
    }
    
    .discount_body {
      text-align: center;
      font-size: 15px;
    }
    /* Social Icons ------------------------------ */
    
    .social {
      width: auto;
    }
    
    .social td {
      padding: 0;
      width: auto;
    }
    
    .social_icon {
      height: 20px;
      margin: 0 8px 10px 8px;
      padding: 0;
    }
    /* Data table ------------------------------ */
    
    .purchase {
      width: 100%;
      margin: 0;
      padding: 35px 0;
      -premailer-width: 100%;
      -premailer-cellpadding: 0;
      -premailer-cellspacing: 0;
    }
    
    .purchase_content {
      width: 100%;
      margin: 0;
      padding: 25px 0 0 0;
      -premailer-width: 100%;
      -premailer-cellpadding: 0;
      -premailer-cellspacing: 0;
    }
    
    .purchase_item {
      padding: 10px 0;
      color: #51545E;
      font-size: 15px;
      line-height: 18px;
    }
    
    .purchase_heading {
      padding-bottom: 8px;
      border-bottom: 1px solid #EAEAEC;
    }
    
    .purchase_heading p {
      margin: 0;
      color: #85878E;
      font-size: 12px;
    }
    
    .purchase_footer {
      padding-top: 15px;
      border-top: 1px solid #EAEAEC;
    }
    
    .purchase_total {
      margin: 0;
      text-align: right;
      font-weight: bold;
      color: #333333;
    }
    
    .purchase_total--label {
      padding: 0 15px 0 0;
    }
    
    body {
      background-color: #F4F4F7;
      color: #51545E;
    }
    
    p {
      color: #51545E;
    }
    
    p.sub {
      color: #6B6E76;
    }
    
    .email-wrapper {
      width: 100%;
      margin: 0;
      padding: 0;
      -premailer-width: 100%;
      -premailer-cellpadding: 0;
      -premailer-cellspacing: 0;
      background-color: #F4F4F7;
    }
    
    .email-content {
      width: 100%;
      margin: 0;
      padding: 0;
      -premailer-width: 100%;
      -premailer-cellpadding: 0;
      -premailer-cellspacing: 0;
    }
    /* Masthead ----------------------- */
    
    .email-masthead {
      padding: 25px 0;
      text-align: center;
    }
    
    .email-masthead_logo {
      width: 94px;
    }
    
    .email-masthead_name {
      font-size: 16px;
      font-weight: bold;
      color: #A8AAAF;
      text-decoration: none;
      text-shadow: 0 1px 0 white;
    }
    /* Body ------------------------------ */
    
    .email-body {
      width: 100%;
      margin: 0;
      padding: 0;
      -premailer-width: 100%;
      -premailer-cellpadding: 0;
      -premailer-cellspacing: 0;
      background-color: #FFFFFF;
    }
    
    .email-body_inner {
      width: 570px;
      margin: 0 auto;
      padding: 0;
      -premailer-width: 570px;
      -premailer-cellpadding: 0;
      -premailer-cellspacing: 0;
      background-color: #FFFFFF;
    }
    
    .email-footer {
      width: 570px;
      margin: 0 auto;
      padding: 0;
      -premailer-width: 570px;
      -premailer-cellpadding: 0;
      -premailer-cellspacing: 0;
      text-align: center;
    }
    
    .email-footer p {
      color: #6B6E76;
    }
    
    .body-action {
      width: 100%;
      margin: 30px auto;
      padding: 0;
      -premailer-width: 100%;
      -premailer-cellpadding: 0;
      -premailer-cellspacing: 0;
      text-align: center;
    }
    
    .body-sub {
      margin-top: 25px;
      padding-top: 25px;
      border-top: 1px solid #EAEAEC;
    }
    
    .content-cell {
      padding: 35px;
    }
    /*Media Queries ------------------------------ */
    
    @media only screen and (max-width: 600px) {
      .email-body_inner,
      .email-footer {
        width: 100% !important;
      }
    }
    
    @media (prefers-color-scheme: dark) {
      body,
      .email-body,
      .email-body_inner,
      .email-content,
      .email-wrapper,
      .email-masthead,
      .email-footer {
        background-color: #333333 !important;
        color: #FFF !important;
      }
      p,
      ul,
      ol,
      blockquote,
      h1,
      h2,
      h3 {
        color: #FFF !important;
      }
      .attributes_content,
      .discount {
        background-color: #222 !important;
      }
      .email-masthead_name {
        text-shadow: none !important;
      }
    }
    </style>
    <!--[if mso]>
    <style type="text/css">
      .f-fallback  {
        font-family: Arial, sans-serif;
      }
    </style>
  <![endif]-->
  </head>
  <body>
    <span class="preheader">This is an invoice for your purchase on ' . FRONT_SITE_NAME . '</span>
    <table class="email-wrapper" width="100%" cellpadding="0" cellspacing="0" role="presentation">
      <tr>
        <td align="center">
          <table class="email-content" width="100%" cellpadding="0" cellspacing="0" role="presentation">
            <tr>
              <td class="email-masthead">
                <a href="" class="f-fallback email-masthead_name">
                <img src="https://i.ibb.co/6myys4W/logo-1.png"/>
              </a>
              </td>
            </tr>
            <!-- Email Body -->
            <tr>
              <td class="email-body" width="100%" cellpadding="0" cellspacing="0">
                <table class="email-body_inner" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
                  <!-- Body content -->
                  <tr>
                    <td class="content-cell">
                      <div class="f-fallback">
                        <h1>Hi ' . $name . ',</h1>
                        <p>This is an invoice for your recent purchase.</p>
                        <table class="attributes" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                          <tr>
                            <td class="attributes_content">
                              <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
                                <tr>
                                  <td class="attributes_item">
                                    <span class="f-fallback">
              <strong>Amount Due:</strong> ' . $total_amount . '
            </span>
                                  </td>
                                </tr>
                                <tr>
                                  <td class="attributes_item">
                                    <span class="f-fallback">
              <strong>Order ID:</strong> ' . $order_id . '
            </span>
                                  </td>
                                </tr>
                              </table>
                            </td>
                          </tr>
                        </table>
                        <!-- Action -->
                        
                        <table class="purchase" width="100%" cellpadding="0" cellspacing="0">
                         
                          <tr>
                            <td colspan="2">
                              <table class="purchase_content" width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                  <th class="purchase_heading" align="left">
                                    <p class="f-fallback">Description</p>
                                  </th>
								   <th class="purchase_heading" align="left">
                                    <p class="f-fallback">Qty</p>
                                  </th>
                                  <th class="purchase_heading" align="right">
                                    <p class="f-fallback">Amount</p>
                                  </th>
                                </tr>';
	$total_price = 0;
	foreach ($getOrderDetails as $list) {
		$item_price = $list['qty'] * $list['price'];
		$total_price = $total_price + $item_price;
		$html .= '<tr>
									  <td width="40%" class="purchase_item"><span class="f-fallback">' . $list['dish'] . '(' . $list['attribute'] . ')</span></td>
									  <td width="40%" class="purchase_item"><span class="f-fallback">' . $list['qty'] . '</span></td>
									  <td class="align-right" width="20%" class="purchase_item"><span class="f-fallback">' . $item_price . '</span></td>
									</tr>';
	}
	$html .= '<tr>
                                  <td width="80%" class="purchase_footer" valign="middle" colspan="2">
                                    <p class="f-fallback purchase_total purchase_total--label">Total</p>
                                  </td>
                                  <td width="20%" class="purchase_footer" valign="middle">
                                    <p class="f-fallback purchase_total">' . $total_price . '</p>
                                  </td>
                                </tr>
                              </table>
                            </td>
                          </tr>
                        </table>
                        <p>If you have any questions about this invoice, simply reply to this email or reach out to our <a href="' . FRONT_SITE_PATH . '">support team</a> for help.</p>
                        <p>Cheers,
                          <br>' . FRONT_SITE_NAME . '</p>
                        <!-- Sub copy -->
                        
                      </div>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
            
          </table>
        </td>
      </tr>
    </table>
  </body>
</html>';
	return $html;
}


?>
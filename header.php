<?php
session_start();
include('database.inc.php');
include('function.inc.php');
include('constant.inc.php');
$totalPrice = 0;
$getSetting=getSetting();

$website_close=$getSetting['website_close'];
$website_close_msg=$getSetting['website_close_msg'];
$cart_min_price=$getSetting['cart_min_price'];
$cart_min_price_msg=$getSetting['cart_min_price_msg'];

getDishCartStatus();

if(isset($_POST['update_cart'])){
	foreach($_POST['qty'] as $key=>$val){
		if(isset($_SESSION['FOOD_USER_ID'])){
			if($val[0]==0){
				mysqli_query($con,"delete from dish_cart where dish_detail_id='$key' and user_id=".$_SESSION['FOOD_USER_ID']);
			}else{
				mysqli_query($con,"update dish_cart set qty='".$val[0]."' where dish_detail_id='$key' and user_id=".$_SESSION['FOOD_USER_ID']);	
			}
		}else{
			if($val[0]==0){
				unset($_SESSION['cart'][$key]['qty']);
			}else{
				$_SESSION['cart'][$key]['qty']=$val[0];	
			}
		}
	}
}

$cartArr = getUserFullCart();
// $totalCartDish = count($cartArr);
// prx($cartArr);
// foreach ($cartArr as $list) {
//     $totalPrice = $totalPrice + ($list['qty'] * $list['price']);
// }
$totalPrice=getcartTotalPrice();
$totalCartDish = count($cartArr);

?>
<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?php echo FRONT_SITE_NAME; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?php echo FRONT_SITE_PATH ?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo FRONT_SITE_PATH ?>assets/css/animate.css">
    <link rel="stylesheet" href="<?php echo FRONT_SITE_PATH ?>assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="<?php echo FRONT_SITE_PATH ?>assets/css/slick.css">
    <link rel="stylesheet" href="<?php echo FRONT_SITE_PATH ?>assets/css/chosen.min.css">
    <link rel="stylesheet" href="<?php echo FRONT_SITE_PATH ?>assets/css/ionicons.min.css">
    <link rel="stylesheet" href="<?php echo FRONT_SITE_PATH ?>assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo FRONT_SITE_PATH ?>assets/css/simple-line-icons.css">
    <link rel="stylesheet" href="<?php echo FRONT_SITE_PATH ?>assets/css/jquery-ui.css">
    <link rel="stylesheet" href="<?php echo FRONT_SITE_PATH ?>assets/css/meanmenu.min.css">
    <link rel="stylesheet" href="<?php echo FRONT_SITE_PATH ?>assets/css/style.css">
    <link rel="stylesheet" href="<?php echo FRONT_SITE_PATH ?>assets/css/responsive.css">
    <script src="<?php echo FRONT_SITE_PATH ?>assets/js/vendor/modernizr-2.8.3.min.js"></script>
</head>

<body>
    <!-- header start -->
    <header class="header-area">
        <div class="header-top black-bg">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-12 col-sm-4">
                        <div class="welcome-area">
                        </div>
                    </div>
                    <?php
                    if (isset($_SESSION['FOOD_USER_NAME'])) { ?>
                        <div class="col-lg-8 col-md-8 col-12 col-sm-8">
                            <div class="account-curr-lang-wrap f-right">
                                <ul>
                                    <li class="top-hover"><a href="#">Setting <i class="ion-chevron-down"></i></a>
                                        <ul>
                                            <li><a href="<?php echo FRONT_SITE_PATH ?>profile">Profile </a></li>
                                            <li><a href="<?php echo FRONT_SITE_PATH ?>order_history">Order History</a></li>
                                            <li><a href="<?php echo FRONT_SITE_PATH ?>logout">Logout</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    <?php } else {
                        echo "<br>";
                    } ?>
                </div>
            </div>
        </div>
        <div class="header-middle">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-4 col-12 col-sm-4">
                        <div class="logo">
                            <a href="<?php echo FRONT_SITE_PATH ?>index">
                                <img alt="" src="<?php echo FRONT_SITE_PATH ?>assets/img/logo/logo.png">
                                <!-- <img alt="" src="./admin/assets/images/logo.png" style="height: 40px; width:134px"> -->
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-9 col-md-8 col-12 col-sm-8">
                        <div class="header-middle-right f-right">
                            <div class="header-login">
                                <?php if (!isset($_SESSION['FOOD_USER_NAME'])) { ?>
                                    <a href="<?php echo FRONT_SITE_PATH ?>login_register">
                                    <?php } ?>
                                    <div class="header-icon-style">
                                        <i class="icon-user icons"></i>
                                    </div>
                                    <div class="login-text-content">
                                        <?php
                                        if (isset($_SESSION['FOOD_USER_NAME'])) {
                                            echo '<center>WELCOME<div style="color:#e02c2b;font-weight: bold;">' . $_SESSION['FOOD_USER_NAME'] . '</div></center>';
                                        } else {
                                        ?>
                                            <p>Register <br> or <span>Sign in</span></p>
                                        <?php } ?>
                                    </div>
                                    <?php if (!isset($_SESSION['FOOD_USER_NAME'])) { ?>
                                    </a>
                                <?php } ?>
                            </div>
                            <div class="header-wishlist">
                                &nbsp;
                            </div>
                            <div class="header-cart">
                                <a href="#">
                                    <div class="header-icon-style">
                                        <i class="icon-handbag icons"></i>
                                        <span class="count-style" id="totalCartDish"><?php echo $totalCartDish; ?></span>
                                    </div>
                                    <div class="cart-text">
                                        <span class="digit">My Cart</span>
                                        <span class="cart-digit-bold" id="totalPrice">
                                            <?php
                                            if ($totalPrice != 0) {
                                                echo $totalPrice . ' Rs';
                                            }
                                            ?>
                                        </span>
                                    </div>
                                </a>
                                <?php if ($totalPrice != 0) { ?>
                                    <div class="shopping-cart-content">
                                        <ul id="cart_ul">
                                            <?php foreach ($cartArr as $key => $list) { ?>
                                                <li class="single-shopping-cart" id="attr_<?php echo $key ?>">
                                                    <div class="shopping-cart-img">
                                                        <a href="javascript:void(0)"><img alt="" src="<?php echo SITE_DISH_IMAGE . $list['image'] ?>" style="width:100%;"></a>
                                                    </div>
                                                    <div class="shopping-cart-title">
                                                        <h4><a href="javascript:void(0)">
                                                                <?php echo $list['dish'] ?>
                                                            </a></h4>
                                                        <h6>Price: <?php echo $list['price'] ?> Rs</h6>
                                                        <h6>Qty: <?php echo $list['qty'] ?></h6>
                                                        <span><?php echo
                                                                $list['qty'] * $list['price']; ?> Rs</span>
                                                    </div>
                                                    <div class="shopping-cart-delete">
                                                        <a href="javascript:void(0)" onclick="delete_cart('<?php echo $key ?>')"><i class="ion ion-close"></i></a>
                                                    </div>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                        <div class="shopping-cart-total">
                                            <h4>Total : <span class="shop-total" id="shopTotal">
                                                    <?php echo $totalPrice ?> Rs
                                                </span></h4>
                                        </div>
                                        <div class="shopping-cart-btn">
                                            <a href="<?php echo FRONT_SITE_PATH ?>cart">view cart</a>
                                            <a href="<?php echo FRONT_SITE_PATH ?>checkout">checkout</a>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-bottom transparent-bar black-bg">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-12">
                        <div class="main-menu">
                            <nav>
                                <ul>
                                    <li><a href="<?php echo FRONT_SITE_PATH ?>shop">Shop</a></li>
                                    <li><a href="<?php echo FRONT_SITE_PATH ?>about-us">About us</a></li>
                                    <li><a href="<?php echo FRONT_SITE_PATH ?>contact-us">contact us</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- mobile-menu-area-start -->
        <div class="mobile-menu-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="mobile-menu">
                            <nav id="mobile-menu-active">
                                <ul class="menu-overflow" id="nav">
                                    <li><a href="<?php echo FRONT_SITE_PATH ?>shop">Shop</a></li>
                                    <li><a href="<?php echo FRONT_SITE_PATH ?>about-us">About us</a></li>
                                    <li><a href="<?php echo FRONT_SITE_PATH ?>contact-us">contact us</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- mobile-menu-area-end -->
    </header>
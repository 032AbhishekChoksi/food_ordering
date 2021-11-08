<?php
include('database.inc.php');
include('function.inc.php');
include('constant.inc.php');
$arr = getCouponCode(7);
$html='
<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <title></title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
<style>
body {
  font-family: "Helvetica Neue", Helvetica, Arial;
  font-size: 14px;
  line-height: 20px;
  font-weight: 400;
  color: #3b3b3b;
  -webkit-font-smoothing: antialiased;
  font-smoothing: antialiased;
}

.wrapper {
  margin: 0 auto;
  padding: 40px;
  max-width: 800px;
}

.table {
  margin: 0 0 40px 0;
  width: 100%;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
  display: table;
}
@media screen and (max-width: 580px) {
  .table {
    display: block;
  }
}

.row {
  display: table-row;
  background: #f6f6f6;
}
.row:nth-of-type(odd) {
  background: #e9e9e9;
}
.row.header {
  font-weight: 900;
  color: #ffffff;
  background: #5e2572;
}
.row.green {
  background: #27ae60;
}
.row.blue {
  background: #2980b9;
}
@media screen and (max-width: 580px) {
  .row {
    padding: 8px 0;
    display: block;
  }
}

.cell {
  padding: 6px 12px;
  display: table-cell;
}
@media screen and (max-width: 580px) {
  .cell {
    padding: 2px 12px;
    display: block;
  }
}
</style>
</head>
<body>
 <div class="wrapper">
 <div style="margin-bottom:5px;"><center><img src="https://i.ibb.co/6myys4W/logo-1.png"/></center></div>
  <div class="table">    
    <div class="row header">
      <div class="cell">Code / Value</div>
      <div class="cell">Type</div>
      <div class="cell">Cart Min</div>
      <div class="cell">Expired On</div>
    </div>
    
    <div class="row">';
	   if($arr[0]['coupon_type'] == 'F'){		   
		   $html.="<div class='cell'>" . $arr[0]['coupon_code'] ." / ₹ " . $arr[0]['coupon_value'] ." </div>
		   <div class='cell'>Fixed</div>";
	   }else{
		   $html.="<div class='cell'>" . $arr[0]['coupon_code'] ." / " . $arr[0]['coupon_value'] ."% </div>
		   <div class='cell'>Percentage</div>";
	   }
	   $html.=' 
      <div class="cell">₹ '. $arr[0]['cart_min_value'] .'</div>
      <div class="cell">'. $arr[0]['expired_on'] .'</div>
    </div>    
  </div>
  <p>If you have any questions about this invoice, simply reply to this email or reach out to our <a href="' . FRONT_SITE_PATH . '" target="_blank" style="text-decoration: none; color: blue;">support team</a> for help.</p>
                        <p>Cheers,
                          <br>' . FRONT_SITE_NAME . '</p>
</div>
 
  <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
</body>
</html>';
echo $html;
?>
<?php
include("header.php");
if (!isset($_SESSION['FOOD_USER_ID'])) {
	redirect(FRONT_SITE_PATH . 'shop');
}
$uid = $_SESSION['FOOD_USER_ID'];
$sql = "select order_master.*,order_status.order_status as order_status_str from order_master,order_status where order_master.order_status=order_status.id and order_master.user_id='$uid' order by order_master.id desc";

$res = mysqli_query($con, $sql);
?>

<div class="cart-main-area pt-95 pb-100">
	<div class="container">
		<h3 class="page-title">Order History</h3>
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-12">
				<form method="post">
					<div class="table-content table-responsive">

						<table>
							<thead>
								<tr>
									<th>Order No</th>
									<th>Price</th>
									<th>Coupon Code</th>
									<th>Address</th>
									<th>zip code</th>
									<th>Order Status</th>
									<th>Payment Status</th>
								</tr>
							</thead>
							<tbody>
								<?php if (mysqli_num_rows($res) > 0) {
									$i = 1;
									while ($row = mysqli_fetch_assoc($res)) {
								?>
										<tr>
											<td>
												<div class="div_order_id">
													<a href="<?php echo FRONT_SITE_PATH ?>order_detail.php?id=<?php echo $row['id'] ?>"><?php echo $row['id'] ?></a>
												</div><br/>
												<a href="<?php echo FRONT_SITE_PATH ?>download_invoice?id=<?php echo $row['id'] ?>"><img src='<?php echo FRONT_SITE_PATH ?>assets/img/icon-img/pdf.png' width="20px" title="Download Invoice" /></a>
											</td style="font-size:14px;">
											<td><?php echo $row['total_price'] ?> Rs
											</td>
											<td><?php
												if ($row['coupon_code'] != '') {
												?>
													Coupon Code:- <?php echo $row['coupon_code'] ?><br />
													Final Price:- <?php echo $row['final_price'] ?> Rs
												<?php } else {
													echo "-";
												} ?>
											</td>
											<td><?php echo $row['address'] ?></td>
											<td><?php echo $row['zipcode'] ?></td>
											<td><?php echo $row['order_status_str'] ?></td>
											<td>
												<div class="payment_status payment_status_<?php echo $row['payment_status'] ?>"><?php echo ucfirst($row['payment_status']) ?></div>
											</td>
										</tr>
								<?php }
								} else {
									redirect('shop');
								} ?>
							</tbody>
						</table>

					</div>

				</form>
			</div>
		</div>
	</div>
</div>

<?php
include("footer.php");
?>
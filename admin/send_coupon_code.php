<?php
include('top.php');

if (isset($_GET['id']) && $_GET['id'] > 0) {
	$id = get_safe_value($_GET['id']);
	$arr=getCouponCode($id);
	$email='';
	
	if(isset($_POST['submit'])){
		$email=get_safe_value($_POST['email']);
		$emailHTML = couponEmail($id);
		// prx($emailHTML);
		include('../smtp/PHPMailerAutoload.php');
		send_email($email, $emailHTML, 'Coupon Code');
		sleep(5);
		redirect('coupon_code.php');
	}
} else {
	redirect('coupon_code.php');
}
?>
<div class="card">
	<div class="card-body">
		<h1 class="grid_title">Send Coupon Code Master</h1>
		<div class="row grid_box">
			<div class="col-12">
				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th width="20%">Code/Value</th>
								<th width="10%">Type</th>
								<th width="10%">Cart Min</th>
								<th width="15%">Expired On</th>
								<th width="35%">User Email</th>
								<th width="10%">Actions</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($arr as $row) {
							?>
									<tr>
										<td>
											<?php echo $row['coupon_code'] ?> /
											<?php if ($row['coupon_type'] == 'F') {
												echo "₹" . $row['coupon_value'];
											} else {
												echo $row['coupon_value'] . "%";
											} ?>
										</td>
										<td><?php if ($row['coupon_type'] == 'F') {
												echo "Fixed";
											} else {
												echo "Percentage";
											} ?></td>
										<td><?php echo "₹" . $row['cart_min_value'] ?></td>
										<td>
											<?php
											if ($row['expired_on'] == '0000-00-00') {
												echo 'NA';
											} else {
												$expdateStr = strtotime($row['expired_on']);
												echo date('d-m-Y', $expdateStr);
											}
											?>
										</td>
										<form method="POST">
											<td>
												<select class="form-control" name="email" required>
													<?php
													$res = mysqli_query($con, "select email from user");
													while ($row = mysqli_fetch_assoc($res)) {
														echo "<option value='" . $row['email'] . "'>" . $row['email'] . "</option>";
													}
													?>
												</select>
											</td>
											<td>
												<input type="submit" name="submit" value="Send" style="color: #fff; background-color: #00c689; width: 100%;border: none;border-radius: 2px;padding:10px;" />
											</td>
										</form>
									</tr>
								<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<?php include('footer.php'); ?>
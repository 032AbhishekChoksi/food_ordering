<?php
include('top.php');

if (isset($_GET['type']) && $_GET['type'] !== '' && isset($_GET['id']) && $_GET['id'] > 0) {
	$type = get_safe_value($_GET['type']);
	$id = get_safe_value($_GET['id']);
	if ($type == 'active' || $type == 'deactive') {
		$status = 1;
		if ($type == 'deactive') {
			$status = 0;
		}
		mysqli_query($con, "update user set status='$status' where id='$id'");
		redirect('user.php');
	}
}

$sql = "select order_master.user_id,order_master.name,order_master.email,order_master.mobile from user,order_master,order_status where order_master.order_status=order_status.id and order_master.user_id=user.id and order_status.id='5' and order_master.refund_status='0' group by order_master.name order by order_master.user_id";
$res = mysqli_query($con, $sql);

?>
<div class="card">
	<div class="card-body">
		<h1 class="grid_title">Refund Money</h1>
		<div class="row grid_box">
			<div class="col-12">
				<div class="table-responsive">
					<table id="order-listing" class="table">
						<thead>
							<tr>
								<th width="10%">S.No #</th>
								<th width="25%">Name</th>
								<th width="15%">Email</th>
								<th width="15%">Mobile</th>
								<th width="15%">Wallet</th>
								<th width="20%">Actions</th>
							</tr>
						</thead>
						<tbody>
							<?php if (mysqli_num_rows($res) > 0) {
								$i = 1;
								while ($row = mysqli_fetch_assoc($res)) {
							?>
									<tr>
										<td><?php echo $i ?></td>
										<td><?php echo $row['name'] ?></td>
										<td><?php echo $row['email'] ?></td>
										<td><?php echo $row['mobile'] ?></td>
										<td><?php echo getWalletAmt($row['user_id']) ?></td>
										<td>
											<a href="add_money.php?id=<?php echo $row['user_id'] ?>"><label class="badge badge-success hand_cursor">Refund Money</label></a>
										</td>

									</tr>
								<?php
									$i++;
								}
							} else { ?>
								<tr>
									<td colspan="5">No Refund Available</td>
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
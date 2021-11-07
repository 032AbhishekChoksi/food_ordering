<?php
include('top.php');
$id = "";
if (isset($_GET['id']) && $_GET['id'] > 0) {
  $id = get_safe_value($_GET['id']);
  $sql = "select sum(order_master.final_price) as refund_amt from order_master,order_status where order_master.order_status=order_status.id and order_master.user_id='$id' and order_status.id='5' and order_master.refund_status='0' order by order_master.id";
  $res = mysqli_query($con, $sql);
  $row = mysqli_fetch_assoc($res);
  if (isset($_POST['submit'])) {
    $money = get_safe_value($_POST['money']);
    $msg = get_safe_value($_POST['msg']);
    manageWallet($id, $money, 'in', $msg);
    mysqli_query($con, "update order_master,order_status SET order_master.refund_status='1' where order_master.order_status=order_status.id and order_master.user_id='$id' and order_status.id='5' and order_master.refund_status='0'");
    redirect('user.php');
  }
} else {
  redirect('refund_money.php');
}
?>
<div class="row">
  <h1 class="grid_title ml10 ml15">Manage Money</h1>
  <div class="col-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <form class="forms-sample" method="post">
          <div class="form-group">
            <label for="exampleInputName1">Money (₹)</label>
            <input type="number" class="form-control" placeholder="Money" name="money" value="<?php echo $row['refund_amt'] ?>" readonly>
          </div>
          <div class="form-group">
            <label for="exampleInputEmail3" required>Message</label>
            <input type="textbox" class="form-control" name="msg" value="Refund" readonly>
          </div>

          <button type="submit" class="btn btn-primary mr-2" name="submit">Submit</button>
        </form>
      </div>
    </div>
  </div>

</div>

<?php include('footer.php'); ?>
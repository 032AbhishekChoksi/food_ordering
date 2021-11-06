<?php 
include('top.php');
$msg="";
$name="";
$mobile="";
$password="";
$id="";

if(isset($_GET['id']) && $_GET['id']>0){
	$id=get_safe_value($_GET['id']);
	$row=mysqli_fetch_assoc(mysqli_query($con,"select * from delivery_boy where id='$id'"));
	$name=$row['name'];
	$password=$row['password'];
	$mobile=$row['mobile'];
}

if(isset($_POST['submit'])){
	$name=get_safe_value($_POST['name']);
	$password=get_safe_value($_POST['password']);
	$mobile=get_safe_value($_POST['mobile']);
	$added_on=date('Y-m-d h:i:s');
	
	if($id==''){
		$sql="select * from delivery_boy where mobile='$mobile'";
	}else{
		$sql="select * from delivery_boy where mobile='$mobile' and id!='$id'";
	}	
	if(mysqli_num_rows(mysqli_query($con,$sql))>0){
		$msg="Delivery Boy already added";
	}else{
		if($id==''){
			mysqli_query($con,"insert into delivery_boy(name,mobile,password,status,added_on) values('$name','$mobile','$password',1,'$added_on')");
		}else{
			mysqli_query($con,"update delivery_boy set name='$name', mobile='$mobile',password='$password' where id='$id'");
		}
		
		redirect('delivery_boy.php');
	}
}
?>
<div class="row">
			<h1 class="grid_title ml10 ml15">Manage Delivery Boy</h1>
            <div class="col-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <form class="forms-sample" method="post">
                    <div class="form-group">
                      <label for="exampleInputName1">Name</label>
                      <input type="text" class="form-control" placeholder="Name" name="name" required value="<?php echo $name?>">
                    </div>
					<div class="form-group">
                      <label for="exampleInputPassword1">Password</label>
                      <input type="password" class="form-control" placeholder="Password" name="password" required value="<?php echo $password?>">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputMobilel3" required>Mobile Number</label>
                      <input type="text" class="form-control" placeholder="Mobile Number" name="mobile"  value="<?php echo $mobile?>">
					  <div class="error mt8"><?php echo $msg?></div>
                    </div>                    
                    <button type="submit" class="btn btn-primary mr-2" name="submit">Submit</button>
                  </form>
                </div>
              </div>
            </div>
            
		 </div>
        
<?php include('footer.php');?>
<?php 
isAdmin();
   include 'top.inc.php';
   $order_id=$_GET['id'];
   $coupon_details=mysqli_fetch_assoc(mysqli_query($conn,"select * from orders where id='$order_id'"));
   $coupon_value=$coupon_details['coupon_value'];
   $coupon_code=$coupon_details['coupon_code'];

   if(isset($_POST['update_order_status'])){
   	$up= $_POST['update_order_status'];
   	$update_sql='';
   	if($up==3){
   		$length=$_POST['length'];
   		$breadth=$_POST['breadth'];
   		$height=$_POST['height'];
   		$weight=$_POST['weight'];

   		$update_sql="length='$length' , breadth='$breadth' , height='$height' ,weight='$weight'";
   		$token=validShipRocketToken($conn,$order_id);
   		placeShipRocketOrder($conn,$token,$order_id);
   	}
   	if($up=='5')
   		mysqli_query($conn,"UPDATE orders SET order_status='$up','pay_status'='success' WHERE id='$order_id'");
   	else
   		mysqli_query($conn,"UPDATE orders SET order_status='$up',$update_sql WHERE id='$order_id'");

   	if($up==4){
   		$ship_order=mysqli_fetch_assoc(mysqli_query($conn,"select ship_order_id from orders where id='$order_id'"));
   		if($ship_order['ship_order_id']>0){
   			$token=validShipRocketToken($conn,$order_id);
   			cancelShipRocketOrder($conn,$token,$ship_order['ship_order_id']);
   		}
   	}
   }
?>
<div class="content">
<div class="orders">
<div class="row">
<div class="col-xl-12">
   <div class="card">
      <div class="card-body">
         <h4 class="box-title">Orders details</h4>
      </div>
      <div class="card-body--">
         <div class="table-stats order-table ov-h">
            <table class="table">
               <thead>
                  <td class="serial">Products</td>
                  <td>Product Name</td>
                  <td>Price</td>
                  <td>Quantity</td>
                  <td>Total</td>
               </thead>
               <tbody>
                  <?php
                     $sql="SELECT DISTINCT(order_detail.id),order_detail.*,product.name,product.img1,orders.* FROM order_detail,product,orders WHERE order_detail.order_id='$order_id' AND  order_detail.p_id=product.id GROUP by order_detail.id";
                     $query=mysqli_query($conn,$sql);
                     $total=0;
                     $add='';
                     $city='';
                     $pin='';
                     while($fetch=mysqli_fetch_assoc($query))
                      {	$total=$total+$fetch['qty']*$fetch['price'];
                     $add=$fetch['address'];
                     $city=$fetch['city'];
                     $pin=$fetch['pincode'];
                     $order_status=$fetch['order_status'];
                      	?>
                  <tr>
                     <td><a href=""><img src="<?php echo "image/admin/products/".$img1 ?>"></a></td>
                     <td><?php echo $fetch['name']; ?></td>
                     <td><?php echo $fetch['price']; ?></td>
                     <td></td>
                     <td><?php echo $fetch['qty'] ?></td>
                     <td><?php echo $fetch['qty']*$fetch['price']; ?></td>
                  </tr>
                  <?php }
                     if($coupon_value!=''){
            ?>
            <tr>
               <td colspan="3"></td>
               <td>Coupon Code</td>
               <td><?php echo $coupon_code; ?></td>
            </tr>
            <tr>
               <td colspan="3"></td>
               <td>Coupon Value</td>
               <td><?php echo $coupon_value; ?></td>
            </tr>
            <?php } else $coupon_value=0; ?>
                  <tr>
                     <td colspan="3"></td>
                     <td>Total Price</td>
                     <td><?php echo $total; ?></td>
                  </tr>
               </tbody>
            </table>
            <div id="add_details">
               <strong>Address</strong>
               <?php echo $add; ?><br><?php echo $city; ?>&nbsp;<?php echo ", ".$pin; ?> <br>
               <strong>Order Status : </strong>
               <?php
                  $query=mysqli_fetch_assoc(mysqli_query($conn,"select order_status.order_status from order_status,`orders` where `orders`.id='$order_id' and `orders`.order_status=order_status.id"));   
                  echo $query['order_status'];?>
            </div>
            <div>
               <form method="post">
                  <select class="form-control" name="update_order_status" id="update_order_status" onchange="select_change()" required>
                     <option value="">Select Status</option>
                     <?php
                        $res=mysqli_query($conn,"select * from order_status");
                        while($row=mysqli_fetch_assoc($res)){
                   				
                        	if($row['id']==$categories_id){
                        		echo "<option selected value=".$row['id'].">".$row['order_status']."</option>";
                        	}else{
                        		echo "<option value=".$row['id'].">".$row['order_status']."</option>";
                        	}
                        }
                        ?>
                  </select>
                  <div id="shipped" style="display: none;">
                  	<table>
                  		<tr>
                  			<td style="font-weight: bolder; letter-spacing: 4px;">Package detail</td>
                  		</tr>
                  		<tr>
                  			<td><input type="text" name="length" placeholder="length(in cm)"></td>
                  			<td><input type="text" name="breadth" placeholder="breadth(in cm)"></td>
                  			<td><input type="text" name="height" placeholder="height(in cm)"></td>
                  			<td><input type="text" name="weight" placeholder="weight(in kg)"></td>
                  		</tr>
                  	</table>
                  </div>
                  <input type="submit" class="form-control"/>
               </form>
              
            </div>
        </div></div>
</div>
</div>
      <!-- /.card -->
</div>
   <!-- /.col-lg-8 -->
</div>

<script type="text/javascript">
	function select_change(){
		var x=jQuery('#update_order_status').val();
		if(x==3){
			jQuery('#shipped').show();
		}
	}
</script>
<!-- /.content -->
<?php include 'footer.inc.php' ?>
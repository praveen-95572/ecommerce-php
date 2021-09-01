<?php include 'header.inc.php'; ?>
<?php
$cid='';
if(isset($_SESSION['USER_LOGIN']))
	$cid=$_SESSION['USER_ID'];
$order_id=get_safe_val($conn,$_GET['id']);
$coupon_details=mysqli_fetch_assoc(mysqli_query($conn,"select coupon_value from orders where id='$order_id'"));
$coupon_value=$coupon_details['coupon_value'];
?>

<div class="content">
	
	<div class="container-fluid" style="margin-bottom: 10px;">
		<table cellspacing="20" border="5" class="cart_tb">
			<thead>
				<td>Products</td><td>Product Name</td><td>Price</td><td>Quantity</td><td>Total</td>
			</thead>
			<tbody>
			<?php
				$sql="SELECT DISTINCT(order_detail.id),order_detail.*,product.name,product.img1 FROM order_detail,product,orders WHERE order_detail.order_id='$order_id' AND orders.u_id='$cid' AND order_detail.p_id=product.id";
				$query=mysqli_query($conn,$sql);
				$total=0;
				while($fetch=mysqli_fetch_assoc($query))
				 {	$total=$total+$fetch['qty']*$fetch['price'];
				 	?>

					<tr><td><a href=""><img src="<?php echo "image/admin/products/".$img1 ?>"></a></td>
					<td><?php echo $fetch['name']; ?></td>
					<td>₹<?php echo $fetch['price']; ?></td>
					<td><?php echo $fetch['qty'] ?></td>
					<td>₹<?php echo $fetch['qty']*$fetch['price']; ?></td></tr>
				<?php }
				if($coupon_value!=''){
				?>
				<tr>
					<td colspan="3"></td>
					<td>Coupon Value</td>
					<td><?php echo $coupon_value; ?></td>
				</tr><?php } else $coupon_value=0; ?>
				<tr>
					<td colspan="3"></td>
					<td>Total Price</td>
					<td><?php echo ($total-$coupon_value); ?></td>
				</tr>
			</tbody>
		</table>
		<div class="row">
		<div class="col-md-6 col-sm-6 col-xs-6">
		<a href="<?php echo SITE_PATH ?>" class='button' style="float: left;">Continue shopping</a></div>
		<div class="col-md-6 col-sm-6 col-xs-6">	
		<a href="<?php echo SITE_PATH ?>/checkout.php" class='button' style="float: right;">Check Out</a></div>
		</div>
	</div>
</div>
	


<?php include 'footer.inc.php'; ?>

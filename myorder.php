<?php include 'header.inc.php'; 
if(!isset($_SESSION['USER_LOGIN']))
	echo "<script>alert('Anonymous User');window.location.href='index.php'</script>";?>

 
<div class="content">
	
	<div class="container-fluid" style="margin-bottom: 10px;">
		<table cellspacing="20" border="5" class="cart_tb myorder"> 
			<thead>
				<td>Order Id</td><td>Order Date</td><td>Product</td><td>Address</td><td>Payment Type</td><td>Payment Status</td><td>Order Status</td>
			</thead>
			<tbody>
				<?php
				if(mysqli_num_rows($query)==0){?>
						<td colspan="6"  height="400"><center style="font-size: 3.5em;">No orders to show.</center></td>
				<?php } 
				else{
				$cid='';
				if(isset($_SESSION['USER_LOGIN']))
					$cid=$_SESSION['USER_ID'];
				
				$sql="SELECT orders.*,order_status.order_status,product.img1,product.id AS order_status_str FROM orders,order_status,product,order_detail WHERE orders.u_id='$cid' AND order_status.id=orders.order_status AND order_detail.p_id=product.id AND order_detail.order_id=orders.id GROUP BY product.id";
				
				$query=mysqli_query($conn,$sql);
			
				while($fetch=mysqli_fetch_assoc($query))
				 { $imageURL = 'admin/images/upload/'.$fetch["img1"];
				 	?><tr>
					<td><a href="myorder_details.php?id=<?php echo $fetch['id']; ?>"><?php echo "1234236".$fetch['id']; ?></a>
						<br>
						<a href="order_pdf.php?id=<?php echo $fetch['id']; ?>">order invoice</a>
					</td>
					<td><?php echo $fetch['added_on']; ?></td>
					<td class="wishlist_image"><a href="product.php?id=<?php echo $fetch['id'] ?> "><img src="<?php echo $imageURL; ?>"></a></td>
					<td><?php echo $fetch['address']."/".$fetch['city']."/".$fetch['state']; ?></td>
					<td><?php echo $fetch['pay_type']; ?></td>
					<td><?php if($fetch['pay_status']==1)	echo "Paid";
					else echo "Pending"; ?></td>
					<td><?php echo $fetch['order_status']; ?></td></tr>
				<?php }}
				?>
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

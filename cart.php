<?php include 'header.inc.php'; 
if(!isset($_SESSION['USER_ID']))
	echo "<script>alert('Anonymous User');window.location.href='index.php'</script>";?>
<?php
if(!isset($_SESSION['USER_ID']))
	echo "<script>window.location.href='index.php'</script>"; 
?>

<div class="content">
	
	<div class="container-fluid" style="margin-bottom: 10px;">
		<table cellspacing="20" border="5" class="cart_tb">
			<thead>
				<td>Products</td><td>Name Of Products</td><td>Price</td><td>Quantity</td><td>Total</td><td>Remove</td>
			</thead>
			<tbody>
				<?php 
				$cid='';
				
				$cid=$_SESSION['USER_ID'];
				$sql="SELECT * FROM cart WHERE c_id='$cid'";
				$query=mysqli_query($conn,$sql);

				if(mysqli_num_rows($query)==0){?>
						<td colspan="6" height="400"><center style="font-size: 3.5em;">Your Cart is Empty.</center></td>
				<?php } 
				else{
				while($fetch=mysqli_fetch_assoc($query))
				 {
					$productArr=get_product($conn,'',$fetch['p_id']);
					$pname=$productArr[0]['name'];
					$mrp=$productArr[0]['mrp'];
					$price=$productArr[0]['price'];
					$imageURL = 'admin/images/upload/'.$productArr[0]['img1'];
					$product_sold=productSoldQtyByPid($conn,$productArr['0']['id']);
 					$product_qty=productQty($conn,$productArr['0']['id']);
 					$pending_qty=$product_qty-$product_sold;
 
					$qty=$fetch['qty'];?>
					<tr><td class="wishlist_image"><a href="product.php?id=<?php echo $productArr[0]['id'];  ?>"><img src="<?php echo $imageURL; ?>"></a></td>
					<td><?php echo $pname; ?></td>
					<td>₹<?php echo $price; ?></td>
					<td><input type="number" max="<?php echo $pending_qty ?>" min='1' id='qty' value="<?php echo $qty; ?>"> <br><a onclick="manage_cart('<?php echo $fetch['p_id'] ?>','update')">Update</a></td>
					<td>₹<?php echo $qty*$price; ?></td>
					<td><a class='button'  onclick="manage_cart('<?php echo $fetch['p_id'] ?>','remove')">Remove</a></td></tr>
				<?php }}
				?>
			</tbody>
		</table>
		<div class="row">
		<div class="col-md-6 col-sm-6 col-xs-6">
		<a href="<?php echo SITE_PATH ?>" class='button' style="float: left;">Continue shopping</a></div>
		<div class="col-md-6 col-sm-6 col-xs-6">	
		<a href="checkout.php" class='button' style="float: right;">Check Out</a></div>
		</div>
	</div>
</div>
	


<?php include 'footer.inc.php'; ?>

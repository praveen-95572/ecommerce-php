<?php include 'header.inc.php'; 
if(!isset($_SESSION['USER_LOGIN']))
	echo "<script>alert('Anonymous User');window.location.href='index.php'</script>";
$cid=$_SESSION['USER_ID'];
$sql="SELECT product.*,wishlist.p_id  FROM wishlist,product WHERE wishlist.u_id='$cid' AND product.id=wishlist.p_id";
$query=mysqli_query($conn,$sql);

if(isset($_GET['id'])){
	$wid=$_GET['id'];
	//echo "<center><h1>".$cid."$wid</h1></center>";
	mysqli_query($conn,"DELETE FROM wishlist WHERE p_id='$wid' AND u_id='$cid'");
	echo "<script>window.location.href='wishlist.php';</script>";
}			
?>


<div class="content">
	
	<div class="container-fluid" style="margin-bottom: 10px;">
		<table cellspacing="20" border="5" class="cart_tb text-centered">
			<thead>
				<td>Products</td><td>Name Of Products</td><td>Price</td><td>Remove</td>
				<td>Add to Cart</td>
			</thead>
			<tbody>
				<?php
				if(mysqli_num_rows($query)==0){?>
						<td colspan="6"  height="400"><center style="font-size: 3.5em;">Your Wishlist is Empty.</center></td>
				<?php } 
				else{
				while($fetch=mysqli_fetch_assoc($query))
				 {$imageURL = 'admin/images/upload/'.$fetch["img1"];
				 	?>
					<tr><td class="wishlist_image"><a href="product.php?id=<?php echo $fetch['p_id']  ?>"><img src="<?php echo $imageURL; ?>"></a></td>
					<td><?php echo $fetch['name']; ?></td>
					<td>₹<?php echo $fetch['price']; ?></td>
					<td><a href="?id=<?php echo $fetch['id']; ?>" class='button'>Remove</a></td>
					<td><a href=""  onclick="manage_cart('<?php echo($fetch['id']); ?>','add')" class='button'>Add to cart</a></td></tr>
				<?php }}
				?>
			</tbody>
		</table>
		<div class="row">
		<div class="col-md-6 col-sm-6 col-xs-6">
		<a href="<?php echo SITE_PATH ?>" class='button' style="float: left;">Continue shopping</a></div>
		<div class="col-md-6 col-sm-6 col-xs-6">	
		<a href="<?php echo SITE_PATH.'cart.php' ?>" class='button' style="float: right;">Go To Cart</a></div>
		</div>
	</div>
</div>
	


<?php include 'footer.inc.php'; ?>

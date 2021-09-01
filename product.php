<?php include 'header.inc.php'; ?>
<?php

$id=get_safe_val($conn,$_GET['id']);

	$get_product=get_product($conn,'',$id);
	if(count($get_product)<=0 || $id=='')
		echo "<script>window.location.href='404error.php';</script>";
	$imageURL = 'admin/images/upload/'.$get_product['0']["img1"];
	$sub_cat=$get_product['0']['sub_categories_id'];
	$sub_cat=mysqli_fetch_assoc(mysqli_query($conn,"select sub_categories from sub_categories where id='$sub_cat'"));
?>
<div class="content">
	<div class=" container">
		<div class="row" style="padding: 20px 0 100px 0;">
			<div class="col-md-6 col-lg-5 col-xs-12 col-sm-12">
				<div class="product_image">
				<img src="<?php echo $imageURL ;?>" alt="Loading Image"></div>
			</div>
			<div class="col-md-6 col-lg-7 col-xs-12 col-sm-12">
				<div class="product_details">
				<h1><?php echo $get_product['0']['name']; ?></h1>
				<h4>₹<?php echo $get_product['0']['price']; ?>&nbsp;<del>₹<?php echo $get_product['0']['mrp']; ?></del></h4>
				<p><?php echo $get_product['0']['short_desc']; ?></p>
				<p><b>Product details :</b></p>
				<p><?php echo $get_product['0']['description']; ?></p>
				<p><b>Category : </b><?php echo $sub_cat['sub_categories']; ?></p>
				<p><b>Availability : </b><?php 
				$product_sold=productSoldQtyByPid($conn,$get_product['0']['qty']);
				$cart_show='show';
				$product_qty=$get_product['0']['qty'];
 				$pending_qty=$product_qty-$product_sold;
 	
				if($get_product['0']['qty']>$product_sold)	echo "In Stock"; 
				else {	echo "Out Of Stock";	$cart_show='';
				}
				?></p>
				<?php if($cart_show!=''){ ?>
				<p><b>Qty : </b>
				<select style="background-color: transparent; border-style: none;" id="qty">
					<?php   $x=0;
					while($x<=$pending_qty & $x<=10){
						echo "<option>".++$x."</option>";
					} 
					?>
				</select></p>

				<button class="bg-danger btn btn-lg btn-danger" onclick="wishlist('<?php echo($get_product[0]['id']) ?>','add')">Add to wishlist</button>
				<button class="bg-danger btn btn-lg btn-danger" onclick="manage_cart('<?php echo($get_product['0']['id']); ?>','add')">Add to cart</button><?php } ?>
				</div>
			</div>
		</div>	
		
	<div class="customer_review">
		<center>Customer Review</center>
		<div class="td">
		<?php  $get_review=get_review($conn,$get_product[0]['id']); ?>
			<?php foreach ($get_review as $review) {
				$x=$review['rating'];
				$y=5-$x;?>
			<div class="rating">
				<h6><?php while($x--){ ?><i class="fa fa-star on"></i><?php }while($y--){ ?><i class="fa fa-star off"></i><?php }?> by <span style="font-size:14px;">&nbsp;<strong><?=$review['firstname']; ?></strong></span></h6>
				<p><em>"<?=$review['review']; ?>"</em></p>
				
				
			</div>
			<?php } ?>
		<div class="row">
			<div class="col-sm-12">
				<form id="ratingForm" method="POST">					
					<div class="form-group">
						<h4>Rate this product</h4>
						<button type="button" class="btn btn-warning btn-sm rateButton" aria-label="Left Align">
						  <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
						</button>
						<button type="button" class="btn btn-default btn-grey btn-sm rateButton" aria-label="Left Align">
						  <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
						</button>
						<button type="button" class="btn btn-default btn-grey btn-sm rateButton" aria-label="Left Align">
						  <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
						</button>
						<button type="button" class="btn btn-default btn-grey btn-sm rateButton" aria-label="Left Align">
						  <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
						</button>
						<button type="button" class="btn btn-default btn-grey btn-sm rateButton" aria-label="Left Align">
						  <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
						</button>
						<input type="hidden" class="form-control" id="rating" name="rating" value="1">
						<input type="hidden" class="form-control" id="itemId" name="itemId" value="<?php echo $_GET['item_id']; ?>">
						<input type="hidden" name="action" value="saveRating">
					</div>		
					<div class="form-group">
						<label for="usr">Title*</label>
						<input type="text" class="form-control" id="title" name="title" required>
					</div>
					<div class="form-group">
						<label for="comment">Comment*</label>
						<textarea class="form-control" rows="5" id="comment" name="comment" required></textarea>
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-info" id="saveReview">Save Review</button> <button type="button" class="btn btn-info" id="cancelReview">Cancel</button>
					</div>			
				</form>
			</div>
		</div>		
	</div>
	</div>

</div>
		
</div>

	<script type="text/javascript">
	<?php include 'main.js' ?>
		
	</script>

<?php include 'footer.inc.php'; ?>

<script type="text/javascript">

</script>
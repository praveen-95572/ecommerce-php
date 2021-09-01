<?php include 'header.inc.php'; ?>

<?php include 'carousel.inc.php'; ?>
	<div class="jumbotron text-center">
			<h1><b>New arrival</b></h1>
			<p class="quotes animate__backInRight"><strong><?php
				$txt=get_quotes($conn,0);
				echo $txt;
			?></strong></p>
	</div>
	<div class="container-fluid">	
		<div class="row"> 
		<?php
			$query=mysqli_query($conn,"SELECT * FROM product WHERE status=1 AND best_seller=0");
			$query=max(0,mysqli_num_rows($query)-4);
			$random=rand(0,$query);
			$query=mysqli_query($conn,"SELECT * FROM product WHERE status=1 AND best_seller=0 ORDER BY id DESC LIMIT $random,4");
			if(mysqli_num_rows($query)>0){
			while($list=mysqli_fetch_assoc($query)){
				$imageURL = 'admin/images/upload/'.$list["img1"];
		?>
		<div class="col-md-3 col-lg-3 col-sm-6 col-xs-12">
			<div class="thumbnail">
				<div class="index_image">
				<a href="product.php?id=<?php echo $list['id']  ?>"><img src="<?php echo $imageURL;?>" alt="Loading Image"></a></div>
				<div class="caption"><h3><?php echo $list['name'] ?></h3>
					<span>₹<?php echo $list['price']; ?>
				<del>₹<?php echo $list['mrp']; ?></del></span>
				</div>
			
			</div>
		</div>
	<?php } }?>
	</div>
	</div>

	<div class="jumbotron text-center" >
			<h1><b>Best Sellers</b></h1>
			<p class="quotes"><strong><?php
				$txt=get_quotes($conn,1);
				echo $txt;
			?></strong></p>
	</div>
	<div class="container-fluid">	
		<div class="row">
		<?php
		$query=mysqli_query($conn,"SELECT * FROM product WHERE best_seller=1");
		$query=max(0,mysqli_num_rows($query)-4);
		$random=rand(0,$query);
			$query=mysqli_query($conn,"SELECT * FROM product WHERE best_seller=1  ORDER BY id DESC LIMIT $random,4");
			if(mysqli_num_rows($query)>0){
			while($list=mysqli_fetch_assoc($query)){
				$imageURL = 'admin/images/upload/'.$list["img1"];
		?>
		<div class="col-md-4 col-lg-3 col-sm-4 col-xs-12">
			<div class="thumbnail">
				<div class="index_image">
			<a href="product.php?id=<?php echo $list['id']  ?>"><img src="<?php echo($imageURL) ?>" alt="Loading Image"></a></div>
			<div class="caption"><h3><?php echo $list['name'] ?></h3>
			
				<span>₹<?php echo $list['price']; ?>
				<del>₹<?php echo $list['mrp']; ?></del></span></div>
			
			</div>
		</div>
		<?php }} ?>
		</div></div>
	

	


<?php include 'footer.inc.php'; ?>

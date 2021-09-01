<?php include 'header.inc.php'; ?>
<?php

$id=get_safe_val($conn,$_GET['id']);

//if($id=='')
//	echo "<script>window.location.href='404_error.php';</script>";

$sub_cat_id=''; 
if(isset($_GET['sub_categories']))	$sub_cat_id=get_safe_val($conn,$_GET['sub_categories']); 
$sort='';
$s1=''; $s2=''; $s3=''; $s4='';
$sql='';
if(isset($_GET['sort']))
	$sort=get_safe_val($conn,$_GET['sort']);		

if($sort=='high'){
	$sql.=" ORDER BY product.price DESC";		$s1='selected';
}
if($sort=='low'){
	$sql.=" ORDER BY product.price ASC";		$s2='selected';
}
if($sort=='latest'){
	$sql.=" ORDER BY product.id DESC";				$s3='selected';
}
if($sort=='old'){
	$sql.=" ORDER BY product.id ASC";				$s4='selected';
}

//else
//	echo "<script>window.location.href='index.php';</script>";
?>
<div class="content">
	<?php
        if (isset($_GET["page"])) 
			$page  = $_GET["page"]; 
		else
			$page=1;
			  
		$limit=2;
		$start_from = ($page-1) * $limit; 
	
        $get_product=get_product($conn,$id,'',$start_from,'',$sql,$sub_cat_id);
    ?>
	<?php if(count($get_product)<1){?>
				<div class="no_result"><em>No search result found</em></div>
	<?php		}else{ ?>
	<ul type="none" class="sort_prod">
		<li>
			<select id="sort_prod" onchange="sort_product('<?php echo $id ?>','<?php echo SITE_PATH ?>')">
				<option value="high" <?php echo $s1; ?>>High to Low</option>
				<option value="low" <?php echo $s2; ?>>Low to High</option>
				<option value="latest" <?php echo $s3; ?>>Latest</option>
				<option value="old" <?php echo $s4; ?>>Old</option>
			</select>
		</li>
	</ul>
	<div class="container-fluid">
	 
	<?php
		foreach($get_product as $list) {
			$imageURL = 'admin/images/upload/'.$list["img1"];	?>
			<div class="row">
			<div class="block">
	<div class="col-md-4 col-lg-4 col-xs-12 col-sm-12">			
		<div class="categories_thumbnail">
			<a href="product.php?id=<?php echo $list['id']; ?>"><img src="<?=$imageURL ?>" alt="Loading Image"></a>
			<ul type="none">
				<li ><button onclick="wishlist('<?php echo($list['id']) ?>','add')"><span class="glyphicon glyphicon-heart"></span></button></li>
				<li><button onclick="manage_cart('<?php echo($list['id']) ?>','add')"><span class="glyphicon glyphicon-shopping-cart"></span></button></li>
				<li><button><span class="glyphicon glyphicon-share-alt"></span></button></li>
			</ul></div></div>
	<div class="col-md-4 col-lg-4 col-xs-12 col-sm-12">
			<div class="categories_caption">
			<h3><?php echo $list['name']; ?></h3>
			<span>₹<?php echo $list['price']; ?>&nbsp;&nbsp;<del>₹<?php echo $list['mrp']; ?></del></span>
			<p><em class="td"><?php echo $list['short_desc']; ?></em></p>
		</div>
			
	</div>
	<?php  
	$query=mysqli_query($conn,"SELECT product_review.*,users.firstname FROM product_review,users WHERE p_id='".$list["id"]."' AND users.id=product_review.u_id LIMIT 0,3");
	 ?>
	<div class="col-md-4 col-lg-4 col-xs-12 col-sm-12  capt_hide">
			<div class="categories_caption td">
			<h3>Customer Rating</h3>
		<?php	if(mysqli_num_rows($query)>0){
				while($review=mysqli_fetch_assoc($query)>0){ 
					$x=$review['rating'];
					echo $x;
				echo"<h4>"; while($x){?><i class="fa fa-star" style="font-size:20px;color:orange;"><?php } ?></i> by <span style="font-size:14px;"><?=$review['firstname']; ?></span></h4>
		<?php	}} else {?>
			<p><em>Be the first to review</em> </p>

				<div class="star-rating">
					<div class="rate">
					<span class="fa fa-star" data-rating="1" style="font-size:20px;"></span>
					<span class="fa fa-star" data-rating="2" style="font-size:20px;"></span>
					<span class="fa fa-star" data-rating="3" style="font-size:20px;"></span>
					<span class="fa fa-star" data-rating="4" style="font-size:20px;"></span>
					<span class="fa fa-star" data-rating="5" style="font-size:20px;"></span></div>
					<input type="hidden" name="whatever3" class="rating-value" value="1">
				
					<br>
				<input type="hidden" name="demo_id" id="demo_id" value="1">
				<input type="text" class="form-control" name="email" id="email" placeholder="Email Id"><br>
				<textarea class="form-control" rows="5" placeholder="Write your review here..." name="remark" id="remark" required></textarea><br>
				<p><button  class="btn btn-default btn-sm btn-info" id="srr_rating">Submit</button></p></div>
		<?php } ?>
		</div>
			
	</div>
</div>	</div>
	<?php } ?></div>

<?php 
$total_records = count($get_product);  
$total_pages = ceil($total_records / $limit); 
/* echo  $total_pages; */
$pagLink = "<ul class='pagination'>";  
for ($i=1; $i<=$total_pages; $i++) {
			if($sub_cat_id!='')
              $pagLink .= "<li class='page-item'><a class='page-link' href='?id=".$id."&sub_categories=".$sub_cat_id."&page=".$i."'>".$i."</a></li>";	
          		else
          			$pagLink .= "<li class='page-item'><a class='page-link' href='?id=".$id."&page=".$i."'>".$i."</a></li>";	
}
echo $pagLink . "</ul>";  

} ?>
</div>

	


<?php include 'footer.inc.php'; ?>

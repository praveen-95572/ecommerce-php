<?php include 'header.inc.php'; ?>
<?php
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

$search=get_safe_val($conn,$_GET['str']);
$get_product=get_product($conn,'','','',$search);

?>
<div class="content">
	<?php if(count($get_product)<1 || $search==''):?>
				<div class="no_result"><em>No search result found</em></div>
	<?php		else: ?>
	<ul type="none" class="sort_prod">
		<li>
			<select id="sort_prod" onchange="sort_product('','<?php echo SITE_PATH ?>')">
				<option value="high" <?php echo $s1; ?>>High to Low</option>
				<option value="low" <?php echo $s2; ?>>Low to High</option>
				<option value="latest" <?php echo $s3; ?>>Latest</option>
				<option value="old" <?php echo $s4; ?>>Old</option>
			</select>
		</li>
	</ul> <div class="container-fluid">
	<?php
	 $i=0;
	while($i<count($get_product)){
		$imageURL = 'admin/images/upload/'.$get_product[$i]['img1'];	?>
			<div class="row">
				<div class="block">
			
	<div class="col-md-4 col-lg-4 col-xs-12 col-sm-12">			
		<div class="categories_thumbnail">
			<a href="product.php?id=<?php echo $get_product[$i]; ?>"><img src="<?=$imageURL ?>" alt="Loading Image"></a>
			<ul type="none">
				<li ><button onclick="wishlist('<?php echo($get_product[$i]['id']) ?>','add')"><span class="glyphicon glyphicon-heart"></span></button></li>
				<li><button onclick="manage_cart('<?php echo($get_product[$i]['id']) ?>','add')"><span class="glyphicon glyphicon-shopping-cart"></span></button></li>
				<li><button><span class="glyphicon glyphicon-share-alt"></span></button></li>
			</ul></div></div>
	<div class="col-md-4 col-lg-4 col-xs-12 col-sm-12">
			<div class="categories_caption">
			<h3><?php echo $get_product[$i]['name']; ?></h3>
			<span>₹<?php echo $get_product[$i]['price']; ?>&nbsp;&nbsp;<del>₹<?php echo $get_product[$i]['mrp']; ?></del></span>
			<p><em class="td"><?php echo $get_product[$i]['short_desc']; ?></em></p>
		</div>
			
	</div>
	<?php $avg_review=avg_review($conn,$get_product[$i]['id']); 
	 ?>
	<div class="col-md-4 col-lg-4 col-xs-12 col-sm-12  capt_hide">
			<div class="categories_caption">
			<h3>Customer rating</h3>
			<span><?php echo $avg_review; ?>&nbsp;&nbsp;</span>
			
		</div>
			
	</div>
</div>	</div>	
		<?php $i++; }
		endif; ?>
	</div>
		
</div>

	<script type="text/javascript">
	<?php include 'main.js' ?>
		
	</script>

<?php include 'footer.inc.php'; ?>

<script type="text/javascript">

</script>
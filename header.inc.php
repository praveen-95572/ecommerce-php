<?php include 'connection.inc.php';
	include 'function.inc.php';	
	include 'add_to_cart.inc.php';
	include 'constant.inc.php';?>
<div id="loader"></div>
<?php
session_start();
$obj=new add_to_cart();
$cart=$obj -> totalProduct();
$wishlist=0;
$cid='';
if(isset($_SESSION['USER_LOGIN'])){
	$cid=$_SESSION['USER_ID'];
$sql="SELECT *  FROM wishlist WHERE wishlist.u_id='$cid'";
$query=mysqli_query($conn,$sql);
$wishlist=mysqli_num_rows($query);
} 

$meta_desc="e-com website";
$meta_title="Apni Dukaan"; 
$meta_keyword="e-com website";
$script_name=$_SERVER['SCRIPT_NAME'];
$script_name_arr=explode('/', $script_name);
$mypage=$script_name_arr[count($script_name_arr)-1];
if(isset($_GET['id']) && $mypage=='product.php'){
$product_id=get_safe_val($conn,$_GET['id']);
$query=mysqli_query($conn,"SELECT * FROM product WHERE id='$product_id'") or die("YESSS");
//echo "SELECT * FROM product WHERE id='$product_id'";
$product_meta=mysqli_fetch_assoc($query);
//print_r($product_meta);
$meta_desc=$product_meta['meta_desc'];
$meta_title=$product_meta['meta_title'];
$meta_keyword=$product_meta['meta_keyword'];
}
 ?>
 <!DOCTYPE html>
<html>
<head> 
	<meta charset="utf-8">
	<title><?php echo $meta_title ?></title>
	<meta name="description" content="<?php echo $meta_desc; ?>">
	<meta name="keywords" content="<?php echo $meta_keyword; ?>">
	<meta  name="viewport" content="width=device-width , initial-scale=1">
	<link rel="shortcut icon" type="image/jpg" href="admin/images/favicon.png" sizes="16x16 32x32" />
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  
	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	<!-- animate.css ------>
	<link rel="stylesheet"
	 href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
	<script type="text/javascript" src="main.js"></script>
	<script type="text/javascript" src="rating.js"></script>
	<link rel="stylesheet" type="text/css" href="stylesheet.css">
	<link rel="stylesheet" type="text/css" href="loader.css">
	<link rel="stylesheet" type="text/css" href="review_form.css">

	
</head>
<body onload="myFunction()">


<header style="background-color: rgba(0,0,0,0.4); color: white;" class="container-fluid">
	<div class="row" style="padding: 10px;">
		<div class="col-md-6 col-sm-3 col-xs-3"><a href="game.html"><img src="img/dice.png" alt="play game" height="40" id="game"></a></div>
		<div class="col-xs-9 col-md-6 col-sm-9">
			<ul class="nav nav-tabs" style="float: right;">
				<li><a href="">Help</a></li>
			<?php if(isset($_SESSION['USER_LOGIN'])){?>
				<li style="filter: drop-shadow(10px 0px 20px #4444dd);"><a href="">Hello,<?=$_SESSION['USERNAME']; ?></a></li>
				<li><a type="button" class="btn btn-default btn-sm" href="logout.php">Log out</a></li>
			<?php } else{ ?> 
				<li><a data-toggle="modal" data-target="#joinus">Join us</a></li>
				<li><a type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#login">Sign in</a></li>
			<?php } ?>	
			</ul>
			
		</div>
	</div>
	<div style="background-color: #fff ;">
	<nav class="navbar" style="color: black;">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar" style="border:2px groove yellow;">
        			<span class="icon-bar" style="background-color: black;"></span>
        			<span class="icon-bar" style="background-color: black;"></span>
        			<span class="icon-bar" style="background-color: black;"></span>
      			</button>
      			<div class="navbar-brand" ><a href=""> <span style="color: black;"><img src="img/logo.jpg" class="img-circle" height="35"> Apni dukaan</span></a></div>
				
			</div>
			
			<div class="collapse navbar-collapse navbar-right" id="myNavbar">
				<ul class="nav navbar-nav">
					<li><a href="index.php">Home</a></li>
					<?php	$sql="SELECT * FROM categories WHERE status=1 ORDER BY id ASC";
						$query=mysqli_query($conn,$sql);
						while($fetch=mysqli_fetch_assoc($query)){?>
						<li class="dropdown"><a href="categories.php?id=<?php echo $fetch['id']; ?>"><?php echo $fetch['categories']."</a>"; 
							$cat_id=$fetch['id'];
							$sql1="SELECT * FROM sub_categories WHERE status=1 AND categories_id='$cat_id' ORDER BY id ASC";
							$query1=mysqli_query($conn,$sql1);
							if(mysqli_num_rows($query1)>0){ ?><ul class='dropdown-content'><?php
							while($fetch1=mysqli_fetch_assoc($query1)){?>
							<li><a href="categories.php?id=<?php echo $fetch['id']."&sub_categories=".$fetch1['id']; ?>"><?php echo $fetch1['sub_categories']; ?></a></li>
						<?php } echo "</ul>";} ?>
						</li>
					<?php } ?>

					<li class="input-group input-group-lg"><form method="get" action="search.php"><input type="text" placeholder="Search..." name="str" class="td"><button type="submit"><span class="glyphicon glyphicon-search"></span></button></form></li>
					<li><a href="wishlist.php" style="font-size: 2em; padding: 10px 10px;"><span class="glyphicon glyphicon-heart" aria-hidden='true' ><sup id="wishlist"><?php echo $wishlist; ?></sup></span></a></li>
					<li><a href="cart.php" style="font-size: 2em; padding: 10px 10px;"><span class="glyphicon glyphicon-shopping-cart"><sup id="cart"><?php echo $cart; ?></sup></span></a></li>
				</ul>
			</div>
		</div>
	</nav>
	</div>
	<marquee>Please be aware that we are currently experiencing local customs clearance delays which will affect the delivery date of your order. For the latest updates, please check your Order Status <a href="" style="color: blue;">here</a></marquee>


</header>




<div class="sidebar">
	<?php $name="User"; 
		if(isset($_SESSION['USER_LOGIN']))
			$name=$_SESSION['USERNAME']
	?>
	<a disabled class="extend"><img src="admin/images/favicon.png" class="img-circle"><span class="glyphicon glyphicon-th-list"></span></a>
	<h5 style="padding:  10px 0 10px 5px;"><span class="glyphicon glyphicon-chevron-right"></span><?php echo " Hello ,".$name; ?></h5>
	<a href="user_profile.php"><span class="glyphicon glyphicon-user"></span> My account</a>
	<hr>
	<a href="index.php"><span class="glyphicon glyphicon-home"></span> Home</a>
	<a class="dropdown"><span class="glyphicon glyphicon-th-large"></span> Shop by Category</a>
	<?php $sql="SELECT * FROM categories WHERE status=1 ORDER BY id ASC";
						$query=mysqli_query($conn,$sql); 
	while($fetch=mysqli_fetch_assoc($query)){?> 
		<a href="categories.php?id=<?php echo $fetch['id']."&sub_categories=".$fetch1['id']; ?>" class="drop_show"><?php echo $fetch['categories']; ?><?php } ?>
	
	<a href=""><span class="glyphicon glyphicon-screenshot"></span> Today's Deals</a>
	<hr>
	<a href="myorder.php"><span class="glyphicon glyphicon-file"></span> My Orders</a>
	<a href="cart.php"><span class="glyphicon glyphicon-shopping-cart"></span> My Cart</a>
	<a href="wishlist.php"><span class="glyphicon glyphicon-heart"></span> My Wishlist</a>
	<a href="contact.php"><span class="glyphicon glyphicon-phone"></span> Contact Us</a>
	<a href="website.php"><span class="glyphicon glyphicon-road"></span> Programs and Features</a>
	<a href=""></a>
	<hr>
	<a href=""><span class="glyphicon glyphicon-cog"></span> Customer Service</a>
</div>			


<script type="text/javascript">
	$('.drop_show').css({'display':'none','margin-left':'10px'});
	$('.sidebar a').click(function(){
		$('.drop_show').slideToggle();
	});

var myVar;

function myFunction() {
  myVar = setTimeout(showPage, 3000);
}

function showPage() {
  document.getElementById("loader").style.display = "none";
  document.getElementsByClassName("content")[0].style.visibility = "visible";
  document.getElementsByClassName("index")[0].style.visibility = "visible";
}
</script>

<?php if(!isset($_SESSION['USER_LOGIN'])){?>
<div class="delete">
	<p>this website is in β-version.</p>
</div>

<div class="delete_login">
	<p>Use this details to login.</p> 
	Email : <b>praveen@gmail.com</b><br>
	Password : <b>123456</b>
</div>
<?php }?>

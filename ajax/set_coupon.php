
<?php
include '../connection.inc.php';
include '../function.inc.php';	
include '../add_to_cart.inc.php';

$obj=new add_to_cart();
$coupon=$_POST['coupon'];
if(isset($_SESSION['COUPON_ID'])){
unset($_SESSION['COUPON_ID']);
unset($_SESSION['COUPON_VALUE']);
unset($_SESSION['COUPON_CODE']);
}
$jsonArr=array();
$sql="SELECT * FROM coupon_master WHERE coupon_code='$coupon'";
$res=mysqli_query($conn,$sql);
$count=mysqli_num_rows($res);
if($count>0){
	$x=mysqli_fetch_assoc($res);
	$coupon_id=$x['id'];
	$coupon_value=$x['coupon_value'];
	$coupon_type=$x['coupon_type'];
	$coupon_code=$x['coupon_code'];
	$cart_min_value=$x['cart_min_value'];
	$total=$obj->cartTotal();
	
	if($cart_min_value>$total){
		$jsonArr=array('is_error'=>'yes','result'=>"cart total less than".$cart_min_value);
	}
	else{
		if($coupon_type=='Rupee'){
			$dd=$coupon_value;
			$total=$total-$coupon_value;
		}
		else{
			$dd=$coupon_value*$total/100;
			$total=$total-$dd;}
			$_SESSION['COUPON_ID']=$coupon_id;
			$_SESSION['FINAL_PRICE']=$total;
			$_SESSION['COUPON_VALUE']=$dd;
			$_SESSION['COUPON_CODE']=$coupon_code;
		$jsonArr=array('is_error'=>'no','result'=>$total,'dd'=>$dd);
	
}}
else{
	$jsonArr=array('is_error'=>'yes','result'=>'Invalid Coupon code!');
}
echo json_encode($jsonArr);

?>
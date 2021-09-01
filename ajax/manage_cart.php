 
<?php
include '../connection.inc.php';
include '../function.inc.php';	
include '../add_to_cart.inc.php';
$id=get_safe_val($conn,$_GET['id']);
$qty=get_safe_val($conn,$_GET['qty']);
$type=get_safe_val($conn,$_GET['type']);
$obj=new add_to_cart();
session_start();
 $product_sold=productSoldQtyByPid($conn,$id);
 $product_qty=productQty($conn,$id);
 $pending_qty=$product_qty-$product_sold;
 if(!isset($_SESSION['USER_LOGIN'])){}
else{
 if($qty<1){
 }
 else{
 if($qty>$pending_qty){
 	echo "not_available";				
 	die();
}
if($type=='add'){
/*if(!isset($_SESSION['USER_LOGIN'])){
echo"<script>
    $(window).on('load', function() {
        $('#login').modal('show');
    });
</script>";}
else{*/
	$obj -> addProduct($id,$qty);	
}

if($type=='remove')
{
	$obj -> removeProduct($id);

}
 
if($type=='update')
{
	$obj -> updateProduct($id ,$qty);
}
}
}
$x=$obj -> totalProduct();
echo $x;
?>
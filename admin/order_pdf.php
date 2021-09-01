<?php include '../connection.inc.php';
	include 'function.inc.php';	
	include '../add_to_cart.inc.php';
	include('../vendor/autoload.php');


$css=file_get_contents('../css/bootstrap.min.css');
$css.=file_get_contents('../stylesheet.css');
?>
<?php
$order_id=get_safe_val($conn,$_GET['id']);
$coupon_details=mysqli_fetch_assoc(mysqli_query($conn,"select * from orders where id='$order_id'"));
$coupon_value=$coupon_details['coupon_value'];
$coupon_code=$coupon_details['coupon_code'];

?>
<?php 
$html=' 
<div class="container">
<table cellspacing="20" border="5" class="cart_tb">
			<thead>
				<td>Products</td><td>Product Name</td><td>Price</td><td>Quantity</td><td>Total</td>
			</thead>
			<tbody>'; 

				$sql="SELECT order_detail.id,order_detail.*,product.name,product.img1 FROM order_detail,product,orders WHERE order_detail.order_id='$order_id' AND order_detail.p_id=product.id";
				$query=mysqli_query($conn,$sql);
				$total=0;
				if(mysqli_num_rows($query)==0){
					die();
				}$target_dir="image/admin/products/";
				while($fetch=mysqli_fetch_assoc($query))
				 {	$total=$total+$fetch['qty']*$fetch['price'];
		$html.='		 	
				 
					<tr><td><a href=""><img src="<?php echo $target_dir.$img1 ?>""></a></td>
					<td><?php echo $fetch["name"] ?></td>
					<td><?php echo $fetch["price"] ?></td>
					<td></td>
					<td><?php echo $fetch["qty"] ?></td>
					<td><?php echo $fetch["qty"]*$fetch["price"]; ?></td></tr>  ';
				 }
			$html="
				<?php }
                     if($coupon_value!=''){
            ?>
            <tr>
               <td colspan='3'></td>
               <td>Coupon Code</td>
               <td><?php echo $coupon_code; ?></td>
            </tr>
            <tr>
               <td colspan='3'></td>
               <td>Coupon Value</td>
               <td><?php echo $coupon_value; ?></td>
            </tr>
            <?php } else $coupon_value=0; ?>
                  <tr>
                     <td colspan='3'></td>
                     <td>Total Price</td>
                     <td><?php echo $total; ?></td>
                  </tr>
			</tbody>
		</table>
</div>
 ";
?>


<?php

$mpdf=new \Mpdf\Mpdf();
$mpdf->WriteHTML($css,1);
$mpdf->WriteHTML($html,2);
$file=time().'.pdf';
$mpdf->Output($file,'D');
?>
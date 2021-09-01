<?php 
	include('vendor/autoload.php');
	include 'connection.inc.php';
	include 'function.inc.php';	
if(!isset($_SESSION['USER_LOGIN'])){
	//die();
}
$css=file_get_contents('css/bootstrap.min.css');
$css.=file_get_contents('stylesheet.css');
?>
<?php
$cid='';
if(isset($_SESSION['USER_LOGIN']))
	$cid=$_SESSION['USER_ID'];
$order_id=get_safe_val($conn,$_GET['id']);
?>
<?php 
$html=' 
<div class="container">
<table cellspacing="20" border="5" class="cart_tb">
			<thead>
				<td>Products</td><td>Product Name</td><td>Price</td><td>Quantity</td><td>Total</td>
			</thead>
			<tbody>'; 

				$sql="SELECT DISTINCT(order_detail.id),order_detail.*,product.name,product.img1 FROM order_detail,product,orders WHERE order_detail.order_id='$order_id' AND orders.u_id='$cid' AND order_detail.p_id=product.id";
				$query=mysqli_query($conn,$sql);
				$total=0;
				if(mysqli_num_rows($query)==0){
					die();
				}
				while($fetch=mysqli_fetch_assoc($query))
				 {	$total=$total+$fetch['qty']*$fetch['price'];
		$html.='		 	
				 
					<tr><td><a href=""><img src="<?php echo "image/admin/products/".$img1 ?>"></a></td>
					<td><?php echo $fetch["name"]; ?></td>
					<td>₹<?php echo $fetch["price"]; ?></td>
					<td></td>
					<td><?php echo $fetch["qty"] ?></td>
					<td>₹<?php echo $fetch["qty"]*$fetch["price"]; ?></td></tr>  ';
				 }
			$html.='
				<tr>
					<td colspan="3"></td>
					<td>Total Price</td>
					<td><?php echo $total; ?></td>
				</tr>
			</tbody>
		</table>
</div>
 ';

echo $html;
echo "<h1>Hello</h1>";
$mpdf=new \Mpdf\Mpdf();
$mpdf->WriteHTML($css,1);
$mpdf->WriteHTML($html,2);
$file=time().'.pdf';
$mpdf->Output($file,'D');	
?>
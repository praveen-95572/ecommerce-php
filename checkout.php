<?php include 'header.inc.php'; ?>
<?php
$cid='';
if(isset($_SESSION['USER_LOGIN']))
	$cid=$_SESSION['USER_ID'];
$sql="SELECT * FROM cart WHERE c_id='$cid'";
$query=mysqli_query($conn,$sql);
$sum=0;
while($fetch=mysqli_fetch_assoc($query))
{
	$productArr=get_product($conn,'',$fetch['p_id']);
	$price=$productArr[0]['price'];
	$qty=$fetch['qty'];
	$sum=$sum+$qty*$price;
}
				
$sql="SELECT * FROM cart WHERE c_id='$cid'";
$query=mysqli_query($conn,$sql);
$num=mysqli_num_rows($query);
//if($num<=0)
//	echo "<script>window.location.href='index.php';</script>";
if(isset($_POST['submit'])){

	$add=get_safe_val($conn,$_POST['address']);
	$city=get_safe_val($conn,$_POST['city']);
	$state=get_safe_val($conn,$_POST['state']);
	$pin=get_safe_val($conn,$_POST['pin']);
	$total=$sum-$coupon_value;
	$pay=get_safe_val($conn,$_POST['pay']);
	if($pay=='cod')
		$pay_status="pending";
	$order_status=1;
	$added_on=date('Y-m-d h:i:s');
	if(isset($_SESSION['COUPON_ID'])){
		$coupon_id=$_SESSION['COUPON_ID'];
		$dd=$_SESSION['COUPON_VALUE'];
		$coupon_code=$_SESSION['COUPON_CODE'];
		unset($_SESSION['COUPON_ID']);
		unset($_SESSION['COUPON_VALUE']);
		unset($_SESSION['COUPON_CODE']);
	}
	else{
		$coupon_id='';
		$dd='';
		$coupon_code='';
	}

	$sql="INSERT INTO orders (u_id, address, city, pincode, pay_type, pay_status,total,added_on, order_status,state,coupon_id,coupon_value,coupon_code) VALUES ('$cid','$add','$city','$pin','$pay','$pay_status','$total','$added_on','$order_status','$state','$coupon_id','$dd','$coupon_code')";
	$query=mysqli_query($conn,$sql);
	$order_id=mysqli_insert_id($conn);
	$sql="SELECT * FROM cart WHERE c_id='$cid'";
	$query=mysqli_query($conn,$sql);
	while($fetch=mysqli_fetch_assoc($query))
		{
			$qty=$fetch["qty"];	$pid=$fetch["p_id"];	$price=$productArr[0]["price"];
			$productArr=get_product($conn,'',$fetch['p_id']);
			$sql="INSERT INTO order_detail(order_id, p_id, qty, price) VALUES ('$order_id','$pid','$qty','$price')";
			mysqli_query($conn,$sql);}
	if($query){
		$sql="DELETE FROM cart WHERE c_id='$cid'";
		mysqli_query($conn,$sql);
		echo "<script>window.location.href='thankyou.php';</script>";
	}
	if($pay=='payu'){
		$MERCHANT_KEY = "gtKFFx"; 
		$SALT = "eCwWELxi";
		$hash_string = '';
		//$PAYU_BASE_URL = "https://secure.payu.in";
		$PAYU_BASE_URL = "https://test.payu.in";
		$action = '';
		$posted = array();
		if(!empty($_POST)) {
		  foreach($_POST as $key => $value) {    
			$posted[$key] = $value; 
		  }
		}

		$userArr=mysqli_fetch_assoc(mysqli_query($con,"select * from users where id='$cid'"));
		
		$formError = 0;
		$posted['txnid']=$txnid;
		$posted['amount']=$total_price;
		$posted['firstname']=$userArr['firstname'];
		$posted['email']=$userArr['email'];
		$posted['phone']=$userArr['mobile'];
		$posted['productinfo']="productinfo";
		$posted['key']=$MERCHANT_KEY ;
		$hash = '';
		$hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
		if(empty($posted['hash']) && sizeof($posted) > 0) {
		  if(
				  empty($posted['key'])
				  || empty($posted['txnid'])
				  || empty($posted['amount'])
				  || empty($posted['firstname'])
				  || empty($posted['email'])
				  || empty($posted['phone'])
				  || empty($posted['productinfo'])
				 
		  ) {
			$formError = 1;
		  } else {    
			$hashVarsSeq = explode('|', $hashSequence);
			foreach($hashVarsSeq as $hash_var) {
			  $hash_string .= isset($posted[$hash_var]) ? $posted[$hash_var] : '';
			  $hash_string .= '|';
			}
			$hash_string .= $SALT;
			$hash = strtolower(hash('sha512', $hash_string));
			$action = $PAYU_BASE_URL . '/_payment';
		  }
		} elseif(!empty($posted['hash'])) {
		  $hash = $posted['hash'];
		  $action = $PAYU_BASE_URL . '/_payment';
		}


		$formHtml ='<form method="post" name="payuForm" id="payuForm" action="'.$action.'"><input type="hidden" name="key" value="'.$MERCHANT_KEY.'" /><input type="hidden" name="hash" value="'.$hash.'"/><input type="hidden" name="txnid" value="'.$posted['txnid'].'" /><input name="amount" type="hidden" value="'.$posted['amount'].'" /><input type="hidden" name="firstname" id="firstname" value="'.$posted['firstname'].'" /><input type="hidden" name="email" id="email" value="'.$posted['email'].'" /><input type="hidden" name="phone" value="'.$posted['phone'].'" /><textarea name="productinfo" style="display:none;">'.$posted['productinfo'].'</textarea><input type="hidden" name="surl" value="'.SITE_PATH.'payment_complete.php" /><input type="hidden" name="furl" value="'.SITE_PATH.'payment_fail.php"/><input type="submit" style="display:none;"/></form>';
		echo $formHtml;
		echo '<script>document.getElementById("payuForm").submit();</script>';
	}else{	
		sentInvoice($conn,$order_id);
		?>
		<script>
			window.location.href='thankyou.php';
		</script>
		<?php
	}	
	
}
?>

<div class="content checkout container-fluid">
	<div class="row" style="margin-top: 10px;"> 
		<div class="col-md-8 col-sm-12 col-xs-12 col-lg-8">
			<h3 class="heading">Address Information</h3>
				<div class="panel">
  					<form method="post" name="form1">
  						<div class="form-group">
  							<input type="text" name="address" placeholder="Street Address" class="form-control td" required>
  						</div>
  						<div class="form-group">
							<select name="state"  class="form-control td" id="state" onchange="stateFun(this.value)" required>
								<?php
								$sql="SELECT * FROM states WHERE country_id=101";
								$query=mysqli_query($conn,$sql);
								echo "<option value=''>State</option>";
								while($fetch=mysqli_fetch_assoc($query)){
								?>
								<option value="<?php echo $fetch['id']; ?>"><?php echo $fetch['name'] ?></option>
								<?php  }?>
							</select></div>
						<div class="form-group">
							<select name="city"  class="form-control td" id="city" required>
								<option value="">City</option>
							</select>
						</div>
						<div>
							<input type="text" name="pin" placeholder="Postal code/ zip" class="form-control td" required>
						</div>
				<hr>
			<h3 class="heading"> Payment information</h3>
  					<div class="radio">
  						<label><input type="radio" name="pay" value="cod" required>COD</label>
					</div>
					<div class="radio">
  						<label><input type="radio" name="pay" value="payu" required>PayU</label>
					</div>
					<div class="radio">
  						<label><input type="radio" name="pay" value="paytm" required>Paytm</label>
					</div>
					<div class="radio">
  						<label><input type="radio" name="pay" value="deb" required>Debit Card</label>
					</div>
			<button type="submit" name="submit" class="btn btn-lg btn-success">Submit</button></form>
		</div></div>

		<div class="col-lg-4 col-md-4 col-xs-12 col-sm-12 container checkout_menu">
				<h3>Your cart</h3>
				<hr>
				<?php 
				
				$sql="SELECT * FROM cart WHERE c_id='$cid'";
				$query=mysqli_query($conn,$sql);
				$sum=0;
				while($fetch=mysqli_fetch_assoc($query))
				 {
					$productArr=get_product($conn,'',$fetch['p_id']);
					$pname=$productArr[0]['name'];
					$mrp=$productArr[0]['mrp'];
					$price=$productArr[0]['price'];
					$image=$productArr[0]['img1'];
					$qty=$fetch['qty'];
				 	$sum=$sum+$qty*$price;
				 	?>
					<div class="container-fluid">
						<img src="<?php ?>"><h4><?php echo $pname ?></h4>
						<p><?php echo "<b>₹".$price."</b>    ₹".$mrp."   " ?></p>
						<input type="number" id='qty' value="<?php echo $qty; ?>"> <br><a onclick="manage_cart('<?php echo $fetch['p_id'] ?>','update')">Update</a>
						<a href="javascript:void(0)" onclick="manage_cart('<?php echo $fetch['p_id'] ?>','remove')">Remove</a>
					</div><?php }?>
					<hr>
				<h3>Total  <?php echo "  :  ₹".$sum; ?></h3>
				<div class="coupon_box"></div>

				<input type="textbox" id="coupon" class="form-control" placeholder="Enter coupon code"><br>
				<div style=" color: white; display: none; font-size: 1.2em;" class="coupon container"></div>
				<input type="button" class="button" value="Apply Coupon" onclick="set_coupon()">
	</div>
	
	
</div></div>
	


<?php include 'footer.inc.php'; ?>
<script type="text/javascript">

	function set_coupon(){
		$('.coupon').html('');
		$('.coupon_box').html('');
		var coupon=jQuery('#coupon').val();
		if(coupon!=''){
			jQuery.ajax({
				url:'ajax/set_coupon.php',
				method:'post',
				data:'coupon='+coupon,
				success:function(result){
					var data=jQuery.parseJSON(result);
					if(data.is_error=='yes'){
						$(".coupon").css("color","red");
						jQuery('.coupon').html(data.result);
						$('.coupon').show();
					}
					if(data.is_error=='no'){

						var html="<h4>Coupon Discount : "+data.dd+"<h4>";
						html+="<h4>payable amount : "+data.result+"<h4>";
						alert(html);
						jQuery('.coupon_box').html(html);
						$('.coupon_box').show();
					}
				}
			});
		}
	}
</script>

<?php

if(isset($_SESSION['COUPON_ID'])){
unset($_SESSION['COUPON_ID']);
unset($_SESSION['COUPON_VALUE']);
unset($_SESSION['COUPON_CODE']);
}

?>
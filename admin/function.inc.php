<?php


function prx($arr){
	echo "<pre>";
	print_r($arr);
	
}

function get_safe_val($conn,$str){
	if($str!=' '){
		$str=trim($str);
	return strip_tags(mysqli_real_escape_string($conn,$str));}
}

function get_product($conn,$id='',$product_id='',$limit='',$search_str='',$sort='',$sub_categories_id=''){
	$sql="SELECT product.*,categories.categories FROM product,categories WHERE product.status=1";
	if($id!='')	$sql.=" AND product.categories_id='$id' ";
	if($sub_categories_id!='') $sql.=" AND product.sub_categories_id='$sub_categories_id'";
	if($product_id!='')	$sql.=" AND product.id='$product_id'";
	$sql.=" AND product.categories_id=categories.id ";
	if($search_str!='')	
		$sql.=" AND (name LIKE '%$search_str%' OR description LIKE '%$search_str%')";
	if($sort!='')
		$sql.=$sort;
	else
		$sql.=" ORDER BY id DESC";
	
	if($limit!='')	$sql.=" LIMIT $limit";
	$query=mysqli_query($conn,$sql);
	$data=array();
	while($fetch=mysqli_fetch_assoc($query)){
		$data[]=$fetch;
	}
	return $data;
}
function get_quotes($conn,$x){
	$date=date('d');
	$sql="SELECT * FROM quotes WHERE (id+$x)%31='$date'";
	$query=mysqli_query($conn,$sql);
	$data=array();
	while($fetch=mysqli_fetch_assoc($query)){
		$data[]=$fetch['quotes'];
	}
	$c=count($data)-1;
	$txt=$data[rand(0,$c)];
	return $txt;
}

function productSoldQtyByPid($conn,$pid){
	$sql="SELECT SUM(order_detail.qty) as qty FROM order_detail,orders WHERE orders.id=order_detail.order_id AND order_detail.p_id=$pid AND orders.order_status!=4";
	$query=mysqli_query($conn,$sql);
	$row=mysqli_fetch_assoc($query);
	return $row['qty'];
}

function productQty($conn,$pid){
	$sql="SELECT product.qty FROM product WHERE id='$pid'";
	$query=mysqli_query($conn,$sql);
	$row=mysqli_fetch_assoc($query);
	return $row['qty'];
}


function validShipRocketToken($conn,$order_id){
	 date_default_timezone_set('Asia/Kolkata');
	$row=mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM shiprocket_token"));
	$added_on=strtotime($row['added_on']);
	$current_time=strtotime(date('Y-m-d h:i:s'));
	$diff_time=$current_time-$added_on;
	//echo $diff_time."  ".$current_time."  ".$added_on."  ";
	if($diff_time>86400){
		$token=generateShipRocketToken($conn,$order_id);
	}
	else{
		$token=$row['token'];
	}
	return $token;
}

function generateShipRocketToken($conn,$order_id){
	$row=mysqli_fetch_assoc(mysqli_query($conn,"select users.* from users,orders where orders.id='$order_id' and users.id=orders.u_id"));
	$email=$row['email'];
	$password=$row['password'];
	//echo $email."  ".$password;
	$curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => "https://apiv2.shiprocket.in/v1/external/auth/login",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS =>"{\n    \"email\": \"$email\",\n    \"password\": \"$password\"\n}",
    CURLOPT_HTTPHEADER => array(
      "Content-Type: application/json"
    ),
  ));
  $SR_login_Response = curl_exec($curl);
  curl_close($curl);
  $SR_login_Response_out = json_decode($SR_login_Response);
  $token = $SR_login_Response_out->token;
  $added_on=date('Y-m-d h:i:s');
  mysqli_query($conn,"UPDATE shiprocket_token SET token='$token',added_on='$added_on'");
  echo "string";
  echo $token;
}

function placeShipRocketOrder($conn,$token,$order_id){
	$row_order=mysqli_fetch_assoc(mysqli_query($conn,"select orders.*,users.firstname,users.lastname,users.email,users.mobile from orders,users where orders.id='$order_id' and orders.u_id=users.id"));
	$order_date=$row_order['added_on'];
	$order_date_str=strtotime($order_date);
	$order_date=date('Y-m-d h:i',$order_date_str);
	$firstname=$row_order['firstname'];
	$lastname=$row_order['lastname'];
	$email=$row_order['email'];
	$mobile=$row_order['mobile'];
	$state=$row_order['state'];
	$address=$row_order['address'];
	$city=$row_order['city'];
	$pincode=$row_order['pincode'];
	$total=$row_order['total'];
	$length=$row_order['length'];
	$height=$row_order['height'];
	$breadth=$row_order['breadth'];
	$weight=$row_order['weight'];
	$pay_type=$row_order['pay_type'];
	if($pay_type=='cod')
		$pay_type='COD';
	else
		$pay_type='Prepaid';

	$html="";
	$res=mysqli_query($conn,"select order_detail.*,product.name,product.price
	 from order_detail,product where product.id=order_detail.p_id and order_detail.order_id='$order_id'");
	while($row=mysqli_fetch_assoc($res)){
		$html.='{
      "name": "'.$row['name'].'",
      "sku": "33333",
      "units": "'.$row['qty'].'",
      "selling_price": "'.$row['price'].'",
      "discount": "",
      "tax": "",
      "hsn": 441122
    },';
	}
	$html=rtrim($html,",");
	
	
	$curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => "https://apiv2.shiprocket.in/v1/external/orders/create/adhoc",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS =>'{"order_id": "'.$order_id.'",
  "order_date": "'.$order_date.'",
  "pickup_location": "garhwal",
  "billing_customer_name": "'.$firstname.'",
  "billing_last_name": "'.$lastname.'",
  "billing_address": "'.$address.'",
  "billing_address_2": "'.$city.'",
  "billing_city": "'.$city.'",
  "billing_pincode": "'.$pincode.'",
  "billing_state": "'.$state.'",
  "billing_country": "India",
  "billing_email": "'.$email.'",
  "billing_phone": "'.$mobile.'",
  "shipping_is_billing": true,
  "shipping_customer_name": "",
  "shipping_last_name": "",
  "shipping_address": "",
  "shipping_address_2": "",
  "shipping_city": "",
  "shipping_pincode": "",
  "shipping_country": "",
  "shipping_state": "",
  "shipping_email": "",
  "shipping_phone": "",
  "order_items": [
    '.$html.'
  ],
  "payment_method": "'.$pay_type.'",
  "shipping_charges": 0,
  "giftwrap_charges": 0,
  "transaction_charges": 0,
  "total_discount": 0,
  "sub_total": "'.$total.'",
  "length": "'.$length.'",
  "breadth": "'.$breadth.'",
  "height": "'.$height.'",
  "weight": "'.$weight.'"
	}',
    CURLOPT_HTTPHEADER => array(
      "Content-Type: application/json",
	   "Authorization: Bearer $token"
    ),
  ));
  $SR_login_Response = curl_exec($curl);
  curl_close($curl);
  $SR_login_Response_out = json_decode($SR_login_Response);
 echo $order_id;
  $ship_order_id=$SR_login_Response_out->order_id;
  $ship_shipment_id=$SR_login_Response_out->shipment_id;
  echo $ship_order_id;
  mysqli_query($conn,"UPDATE orders SET ship_order_id='$ship_order_id',ship_shipment_id='$ship_shipment_id' WHERE id='$order_id'");
  //echo '<pre>';
  //print_r($SR_login_Response);	
}

function cancelShipRocketOrder($conn,$token,$ship_order_id){

	echo "{\n    \"ids\": \"{16168898,16167171}\",\n}";
	echo"{\n    \"ids\": \"{".$ship_order_id."}\",\n}";
	//die();
	$curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => "https://apiv2.shiprocket.in/v1/external/orders/cancel",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS =>"{\n    \"ids\": {".$ship_order_id."}\n}",
    CURLOPT_HTTPHEADER => array(
      "Content-Type: application/json",
      "Authorization: Bearer $token"
    ),
  ));

  $response = curl_exec($curl);
  curl_close($curl);
  echo $response;

}

function isAdmin(){
  if(!isset($_SESSION['ADMIN_ROLE'])){?>
    <script>
window.location.href='index.php';</script>

<?php  }
  if($_SESSION['ADMIN_ROLE']==1){?>
<script>
window.location.href='product.php';</script>
 <?php }}



?>
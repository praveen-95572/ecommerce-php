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
	$sql="SELECT product.*,categories.categories,sub_categories.sub_categories FROM product,categories,sub_categories WHERE product.status=1";
	if($id!='')	$sql.=" AND product.categories_id='$id' ";
	if($sub_categories_id!='') $sql.=" AND product.sub_categories_id='$sub_categories_id'";
	if($product_id!='')	$sql.=" AND product.id='$product_id'";
	$sql.=" AND product.categories_id=categories.id ";
		
	if($search_str!='')	
		$sql.=" AND (name LIKE '%$search_str%' OR description LIKE '%$search_str%' OR categories LIKE '%$search_str%' OR sub_categories LIKE '%$search_str%')";
	//$sql.=" LIMIT 2";
	if($sort!='')
		$sql.=" GROUP BY product.id".$sort;
	else
		$sql.="  GROUP BY product.id ORDER BY id DESC";
	
	if($limit!='')	$sql.=" LIMIT $limit,1";
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

function get_review($conn,$p_id){
	$sql="SELECT product_review.*,users.firstname FROM product_review,users WHERE p_id='$p_id' AND users.id=product_review.u_id AND status=1";
	//echo $sql;
	$query=mysqli_query($conn,$sql);
	$data=array();
	while($fetch=mysqli_fetch_assoc($query)){
		$data[]=$fetch;
	}
	return $data;
}

function avg_review($conn,$p_id){
	$sql="SELECT * FROM product_review WHERE p_id='$p_id'";
	$query=mysqli_query($conn,$sql);
	$sum=0;
	$count=0;
	while($fetch=mysqli_fetch_assoc($query)){
		$sum=$fetch['rating'];	$count++;
	}
	if($count==0)	return 0;
	return $sum/$count;
}
?>
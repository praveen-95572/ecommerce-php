<?php


 
class add_to_cart{
			

	function addProduct($id,$qty){
		$cid=$_SESSION['USER_ID'];
		include 'connection.inc.php';
		$sql="SELECT * FROM cart WHERE p_id='$id' AND c_id='$cid'";
		$fetch=mysqli_fetch_array(mysqli_query($conn,$sql));
		if(is_array($fetch))
			$sql="UPDATE cart SET qty='$qty' WHERE p_id='$id' AND c_id='$cid'";
		else
			$sql="INSERT INTO cart (c_id,p_id,qty) VALUES ('$cid','$id','$qty')";
		mysqli_query($conn,$sql);
	}

	function updateProduct($id,$qty){
		include 'connection.inc.php';
		$cid=$_SESSION['USER_ID'];
		$sql="UPDATE cart SET qty='$qty' WHERE p_id='$id' AND c_id='$cid'";
		mysqli_query($conn,$sql);
	}
	function removeProduct($id){
		include 'connection.inc.php';
		$cid=$_SESSION['USER_ID'];
		$sql="DELETE FROM cart WHERE c_id='$cid' AND p_id='$id'";
		mysqli_query($conn,$sql);	
			
	}
	function emptyProduct(){
	
		
	}
	function totalProduct(){
		include 'connection.inc.php';
		if(isset($_SESSION['USER_LOGIN'])){
			$cid=$_SESSION['USER_ID'];
			$sql="SELECT SUM(qty) as sum FROM cart WHERE c_id='$cid'";
			$fetch=mysqli_fetch_assoc(mysqli_query($conn,$sql));
			$sql="SELECT * FROM cart WHERE c_id='$cid'";
			$f=mysqli_fetch_array(mysqli_query($conn,$sql));
			//$sum=0;
			//while($fetch>0){
			//	$sum=$sum+$fetch['qty'];
			//}
			if(is_array($f))
				return $fetch['sum'];
			return 0;
		}
		return 0;
	}

	function cartTotal(){
		include 'connection.inc.php';
		//session_start();
		if(isset($_SESSION['USER_LOGIN'])){
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
				 return $sum;
		} return 0;
	}
}


?>
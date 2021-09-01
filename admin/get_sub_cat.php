<?php
include '../connection.inc.php';

include 'function.inc.php';
$categories_id=$_POST['categories_id'];
$sub_categories=$_POST['sub_cat_id'];
$query=mysqli_query($conn,"SELECT * FROM sub_categories WHERE categories_id='$categories_id'");
if(mysqli_num_rows($query)>0){
	$html='';
	while($row=mysqli_fetch_assoc($query)){
		if($sub_categories==$row['id']){
		$html.="<option selected value=".$row['id'].">".$row['sub_categories']."</option>";
	}
	else{
		$html.="<option value=".$row['id'].">".$row['sub_categories']."</option>";
	}}
	echo $html;
}
else{
	echo "<option>No sub category found</option>";
}
?>
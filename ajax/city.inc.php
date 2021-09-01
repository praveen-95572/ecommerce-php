<?php
$conn=mysqli_connect('localhost','root','','ecommerce') or die("<script>alert('Loading');</script>");

$data= $_GET['id'];
$sql="SELECT * FROM states WHERE name='$data'";
$fetch=mysqli_fetch_assoc(mysqli_query($conn,$sql));
$data=$fetch['id'];

$sql="SELECT * FROM cities WHERE state_id='$data'";

$query=mysqli_query($conn,$sql);


echo "<option>City</option>";
while($fetch=mysqli_fetch_assoc($query)){
?>
<option><?php echo $fetch['name'] ?></option>
<?php  }?>
<?php
$conn=mysqli_connect('localhost','root','','ecommerce') or die("<script>alert('Loading');</script>");

$data= $_GET['id'];


$sql="SELECT * FROM cities WHERE state_id='$data'";

$query=mysqli_query($conn,$sql);


echo "<option value=''>City</option>";
while($fetch=mysqli_fetch_assoc($query)){
?>
<option value="<?php echo $fetch['id']; ?>"><?php echo $fetch['name'] ?></option>
<?php  }?>
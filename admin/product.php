<?php 
   include 'top.inc.php';
    $condition='';
    $sql="SELECT * FROM product ORDER BY id ASC";
   if ($_SESSION['ADMIN_ROLE']==1) {
      $condition="AND added_by='".$_SESSION['ADMIN_ID']."'";
      $sql="SELECT * FROM product WHERE added_by='".$_SESSION['ADMIN_ID']."' ORDER BY id ASC";
   }
   $query=mysqli_query($conn, $sql); 
   
   
   if(isset($_GET['id']) && $_GET['id']!=''){
       $id=$_GET['id'];
       if($_GET['type']=='delete'){
           $sql="DELETE FROM product WHERE id='$id' $condition";
           mysqli_query($conn,$sql);
           echo "<script>location:'product.php';</script>";
       }
       if($_GET['type']=='active'){
           $sql="UPDATE product SET status=0 WHERE id='$id' $condition";
           mysqli_query($conn,$sql);
       }
       if($_GET['type']=='deactive'){
           $sql="UPDATE product SET status=1 WHERE id='$id' $condition";
           mysqli_query($conn,$sql);
       }
   }
   ?>
<div class="content">
<div class="orders">
<div class="row">
   <div class="col-xl-12">
      <div class="card">
         <div class="card-body">
            <h4 class="box-title">Products </h4>
            <h6 class="box-title active" style="font-size: .8em; text-decoration: underline;"><a href="add_product.php">Manage Products</a> </h6>
         </div>
         <div class="card-body--">
            <div class="table-stats order-table ov-h">
               <table class="table text-center">
                  <thead>
                     <tr>
                        <th class="serial">#</th>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Image</th>
                        <th>Categories</th>
                        <th>MRP</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php $x=1;  
                        while ($row=mysqli_fetch_assoc($query)) {
                            $imageURL = 'images/upload/'.$row["img1"];
                            $product_sold=productSoldQtyByPid($conn,$row['id']);
                    $product_qty=productQty($conn,$row['id']);
                    $pending_qty=$product_qty-$product_sold;
 ?>
                     <tr>
                        <td class="serial"><?php echo $x++;; ?></td>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><a href="<?php echo $imageURL;?>" target="_blank"><img src="<?php echo $imageURL; ?>" height="100" width="100"></a></td>
                        <td><?php 
                           $c=$row['categories_id'];
                           $q=mysqli_query($conn,"SELECT * FROM categories WHERE id='$c'");
                           $f=mysqli_fetch_assoc($q);
                           echo $f['categories']; ?></td>
                        <td><?php echo $row['mrp']; ?></td>
                        <td><?php echo $row['price']; ?></td>
                        <td><?php echo $row['qty']; ?>
                            <br><sub>pending qty : <?php echo max(0,$pending_qty); ?></sub>
                        </td>
                        <td class="custom_badge"><?php 
                           if($row['status']==1)
                               echo "<span><a href='?type=active&id=".$row['id']."'>Active</a></span>/"; 
                           else
                               echo "<span><a href='?type=deactive&id=".$row['id']."'>Deactive</a></span>/";
                           echo "&nbsp;<span><a href='add_product.php?id=".$row['id']."'>Edit</a></span>/";
                           echo "&nbsp;<span><a href='?type=delete&id=".$row['id']."'>Delete</a></span>";
                           ?></td>
                     </tr> 
                     <?php } ?>
                  </tbody>
               </table>
            </div>
            <!-- /.table-stats -->
         </div>
      </div>
      <!-- /.card -->
   </div>
   <!-- /.col-lg-8 -->
</div>
<!-- /.content -->
<?php include 'footer.inc.php' ?>

<?php 
   include 'top.inc.php';
   isAdmin();
   $sql="SELECT * FROM coupon_master ORDER BY id ASC";
   $query=mysqli_query($conn, $sql); 
   
   
   if(isset($_GET['id']) && $_GET['id']!=''){
       $id=get_safe_val($conn,$_GET['id']);
       if($_GET['type']=='delete'){
           $sql="DELETE FROM coupon_master WHERE id='$id'";
           mysqli_query($conn,$sql);
           echo "<script>window.location.href='coupon_master.php';</script>";
       }
       if($_GET['type']=='active'){
           $sql="UPDATE coupon_master SET status=0 WHERE id='$id'";
           mysqli_query($conn,$sql);
       }
       if($_GET['type']=='deactive'){
           $sql="UPDATE coupon_master SET status=1 WHERE id='$id'";
           mysqli_query($conn,$sql);
       }
       echo "<script>window.location.href='coupon_master.php';</script>";
   }
   ?>
<div class="content">
<div class="orders">
<div class="row">
   <div class="col-xl-12">
      <div class="card">
         <div class="card-body">
            <h4 class="box-title">Coupon Master </h4>
            <h6 class="box-title active" style="font-size: .8em; text-decoration: underline;"><a href="manage_coupon_master.php">Manage Coupon Master</a> </h6>
         </div>
         <div class="card-body--">
            <div class="table-stats order-table ov-h">
               <table class="table text-center">
                  <thead>
                     <tr>
                        <th class="serial">#</th>
                        <th>ID</th>
                        <th>Coupon Code</th>
                        <th>Coupon Value</th>
                        <th>Coupon Type</th>
                        <th>Min Value</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php $x=1;  
                        while ($row=mysqli_fetch_assoc($query)) {?>
                     <tr>
                        <td class="serial"><?php echo $x++; ?></td>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['coupon_code']; ?></td>
                        <td><?php echo $row['coupon_value']; ?></td>
                        <td><?php echo $row['coupon_type']; ?></td>
                        <td><?php echo $row['cart_min_value']; ?>
                        </td>
                        <td><?php 
                           if($row['status']==1)
                               echo "<span><a href='?type=active&id=".$row['id']."'>Active</a></span>/"; 
                           else
                               echo "<span><a href='?type=deactive&id=".$row['id']."'>Deactive</a></span>/";
                           echo "&nbsp;<span><a href='manage_coupon_master.php?id=".$row['id']."'>Edit</a></span>/";
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
<style type="text/css">
   .badge a{
   color: white;
   }
   .badge-edit{
   background-image: linear-gradient(blue,green);
   }
   .badge-delete{
   background-image: radial-gradient(rgba(0,0,0,1),rgba(0,0,0,.5),blue);
   }
</style>
<?php 
   include 'top.inc.php';
   isAdmin();
   $sql="SELECT * FROM admin_users WHERE role='1' ORDER BY id ASC";

   $query=mysqli_query($conn, $sql); 
   
   
   if(isset($_GET['id']) && $_GET['id']!=''){
       $id=$_GET['id'];
       if($_GET['type']=='delete'){
           $sql="DELETE FROM admin_users WHERE id='$id'";
           mysqli_query($conn,$sql);
           header('location:coupon_master.php');
       }
       if($_GET['type']=='active'){
           $sql="UPDATE admin_users SET status=0 WHERE id='$id'";
           mysqli_query($conn,$sql);
       }
       if($_GET['type']=='deactive'){
           $sql="UPDATE admin_users SET status=1 WHERE id='$id'";
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
            <h4 class="box-title">Vendor Management </h4>
            <h6 class="box-title active" style="font-size: .8em; text-decoration: underline;"><a href="manage_vendor_management.php">Manage Vendor Management</a> </h6>
         </div>
         <div class="card-body--">
            <div class="table-stats order-table ov-h">
               <table class="table text-center">
                  <thead>
                     <tr>
                        <th class="serial">#</th>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Password</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php $x=1;  
                        while ($row=mysqli_fetch_assoc($query)) {?>
                     <tr>
                        <td class="serial"><?php echo $x++; ?></td>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['password']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['mobile']; ?>
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

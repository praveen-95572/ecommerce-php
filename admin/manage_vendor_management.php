<?php include 'top.inc.php';
   $username=""; 
   $password='';
   $email='';
   $mobile='';
   $role='';
   $msg='';
   isAdmin();           
       
   if(isset($_GET['id'])){
           $id=$_GET['id'];
           $sql="SELECT * FROM admin_users WHERE id='$id'";
           $query=mysqli_query($conn,$sql);
           if($check=mysqli_num_rows($query)>0){ 
   $username=$check['name'];
   $password=$check['password'];
   $email=$check['email'];
   $mobile=$check['mobile'];
   $role=$check['role'];
    }
           else
           {
               echo "<script>window.location.href='vendor_management.php';</script>";
           }
       }
   if(isset($_POST['submit'])){
       $username=$_POST['name'];
   $password=$_POST['password'];
   $email=$_POST['email'];
   $mobile=$_POST['mobile'];
           
       
       if(isset($_GET['id']) && $_GET['id']!=''){
           $sql="UPDATE admin_users SET name='$username',email='$email',password='md5($password)',role='$role',mobile='$mobile' WHERE id='$id'";
           mysqli_query($conn,$sql);
           echo "<script>alert('Task Completed');window.location.href='vendor_management.php';</script>";
           }
       else{
   
           $sql="SELECT * FROM admin_users WHERE name='$username'";
           $query=mysqli_query($conn,$sql);
           $check=mysqli_num_rows($query);
           if($check>0){
               $msg="Vendor name already exist.";
              }
           else{
            $sql="INSERT INTO admin_users (name,email,password,mobile,status,role) VALUES ('$username','$email','$password','$mobile',1,1) ";
              mysqli_query($conn,$sql);
              $msg="Task Completed";
              echo "<script>alert('$msg');window.location.href='vendor_management.php';</script>";  }
           }
       }  
   ?>
<div class="content">
<div class="animated fadeIn">
   <div class="row">
      <div class="col-lg-8">
         <div class="card">
            <div class="card-header"><strong>Coupon</strong><small> Form</small></div>
            <form method="post" enctype="mutlipart/form-data">
               <div class="card-body card-block">
                  <div class="form-group">
                     <label for="" class="form-control-label">Username</label>
                     <input type="text" name="name" placeholder="Enter vendor name" class="form-control" required value="<?php echo $username; ?>">
                  </div>
                  <div class="form-group">
                     <label for="" class="form-control-label">Password</label>
                     <input type="text" name="password" placeholder="Enter Password" class="form-control" required value="<?php echo $password; ?>">
                  </div>
                  <div class="form-group">
                     <label for="" class="form-control-label">Email</label>
                     <input type="text" name="email" placeholder="Enter email" class="form-control" required value="<?php echo $email; ?>">
                  </div>
                  <div class="form-group">
                     <label for="" class="form-control-label">Mobile</label>
                     <input type="text" name="mobile" placeholder="Enter mobile no. value" class="form-control" required value="<?php echo $mobile; ?>"></div>
                  <button type="submit" name="submit" class="btn btn-lg btn-info btn-block">
                  Submit
                  </button>
               </div>
            </form>
            <div style="color: red;"><?php echo $msg; ?></div>
         </div>
      </div>
   </div>
   <!-- .animated -->
</div>
<!-- .content -->
<?php include 'footer.inc.php' ?>

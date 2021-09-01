<?php include 'top.inc.php';
  isAdmin();
   $coupon_id=""; 
   $coupon_code='';
   $coupon_type='';
   $coupon_value='';
   $cart_min_value='';
   $msg='';
        
       
   if(isset($_GET['id'])){
           $id=get_safe_val($conn,$_GET['id']);
           $sql="SELECT * FROM coupon_master WHERE id='$id'";
           $query=mysqli_query($conn,$sql);
           if($check=mysqli_num_rows($query)>0){ 
            $check=mysqli_fetch_assoc($query);
   $coupon_code=$check['coupon_code'];
   $coupon_type=$check['coupon_type'];
   $coupon_value=$check['coupon_value'];
   $cart_min_value=$check['cart_min_value'];
           }
           else
           {
               echo "<script>window.location.href='coupon_master.php';</script>";
           }
       }
   if(isset($_POST['submit'])){
       $coupon_code=get_safe_val($conn,$_POST['coupon_code']);
   $coupon_type=get_safe_val($conn,$_POST['coupon_type']);
   $coupon_value=get_safe_val($conn,$_POST['coupon_value']);
   $cart_min_value=get_safe_val($conn,$_POST['cart_min_value']);
           
       
       if(isset($_GET['id']) && $_GET['id']!=''){
           $sql="UPDATE coupon_master SET coupon_code='$coupon_code',coupon_value='$coupon_value',coupon_type='$coupon_type',cart_min_value='$cart_min_value' WHERE id='$id'";
           mysqli_query($conn,$sql);
           $statusMsg="Task Completed";
           echo "<script>alert('$statusMsg');window.location.href='coupon_master.php';</script>";
           }
       else{
   
           $sql="SELECT * FROM coupon_master WHERE coupon_code='$coupon_code'";
           $query=mysqli_query($conn,$sql);
           $check=mysqli_num_rows($query);
           if($check>0){
               $msg="Coupon Code already exist.";
           }
           else{
            $sql="INSERT INTO coupon_master (coupon_code,coupon_value,coupon_type,cart_min_value,status) VALUES ('$coupon_code','$coupon_value','$coupon_type','$cart_min_value',1) ";
              mysqli_query($conn,$sql);
              $msg="Task Completed";
              }echo "<script>alert('$msg');window.location.href='coupon_master.php';</script>"; 
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
                     <label for="" class="form-control-label">Coupon Code</label>
                     <input type="text" name="coupon_code" placeholder="Enter coupon code" class="form-control" required value="<?php echo $coupon_code; ?>">
                  </div>
                  <div class="form-group">
                     <label for="" class="form-control-label">Coupon Value</label>
                     <input type="text" name="coupon_value" placeholder="Enter coupon value" class="form-control" required value="<?php echo $coupon_value; ?>">
                  </div>
                  <div class="form-group">
                    <label for="categories" class="form-control-label">Coupon Type</label>
                  <select class="form-control" name="coupon_type">
                     <option value="">select</option>
                     <?php
                        if($coupon_type=="Percentage"){
                            ?>
                     <option value="Percentage" selected>%</option>
                     <?php }else if($coupon_type=="Rupee"){?>
                        <option value="Rupee" selected>Rs.</option>
                       <?php } else{ ?>
                     <option value="Percentage">%</option>
                     <option value="Rupee">Rs.</option>
                   <?php } ?>
                  </select>
                  </div>
                  <div class="form-group">
                     <label for="" class="form-control-label">Cart Min Value</label>
                     <input type="text" name="cart_min_value" placeholder="Enter cart minimum value" class="form-control" required value="<?php echo $cart_min_value; ?>"></div>
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
<script type="text/javascript">
   function get_sub_cat(sub_cat_id){
       var categories_id=jQuery('#cat_id').val();
       jQuery.ajax({
           url:'get_sub_cat.php',
           type:'POST',
           data:'categories_id='+categories_id+'&sub_cat_id='+sub_cat_id,
           success:function(result){
               jQuery('#sub_categories_id').html(result);
           }
       });
   }
   
</script>
<?php include 'footer.inc.php' ?>
<script type="text/javascript">
   <?php
      if(isset($_GET['id'])){
      ?>
   get_sub_cat(<?php echo $sub_categories_id; ?>);
   <?php } ?>
</script>

<?php include 'top.inc.php';
isAdmin(); 
$sub_cat='';
$cat_id='';
$msg='';
$id='';
if(isset($_GET['id']) && $_GET['id']!=''){
        $id=$_GET['id'];
        $sql="SELECT * FROM sub_categories WHERE id='$id'";
        $query=mysqli_query($conn,$sql);
        if($check=mysqli_num_rows($query)>0){
        $fetch=mysqli_fetch_assoc($query);
        $cat_id=$fetch['categories_id'];
        $sub_cat=$fetch['sub_categories'];
        }
        else
        {
            header('location:sub_categories.php');
        }
    }
if(isset($_POST['submit'])){
    $sub_cat=$_POST['sub_categories'];
    $cat_id=$_POST['categories_id'];
    $sql="SELECT * FROM sub_categories WHERE sub_categories='$sub_cat' AND categories_id='$cat_id'";
    $query=mysqli_query($conn,$sql);
    $check=mysqli_num_rows($query);
    if($check>0){
        $msg="Sub Categories already exist.";
    }
    else{
        if(isset($_GET['id']) && $_GET['id']!=''){
            $sql="UPDATE sub_categories SET sub_categories='$sub_cat',categories_id='$cat_id' WHERE id='$id'";
            mysqli_query($conn,$sql);
            }
        else{
            $sql="INSERT INTO sub_categories(sub_categories,categories_id,status) VALUES ('$sub_cat','$cat_id','1')";
            mysqli_query($conn, $sql);
            }
        echo "<script>alert('Task Executed');window.location.href('sub_categories.php');</script>";
    }
}
?>

<div class="content">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header"><strong>Sub Category</strong><small> Form</small></div>
                    <form method="post">
                    <div class="card-body card-block">
                        <div class="form-group">
                            <label for="" class="form-control-label">Categories</label>
                            <select name="categories_id" class="form-control" required>
                                <option value="">Select Categories</option>
                                <?php
                                    $query=mysqli_query($conn,"SELECT * FROM categories WHERE status='1'");
                                    while($row=mysqli_fetch_assoc($query)){
                                        if($row['id']==$cat_id){
                                            echo "<option value=".$row['id']." selected>".$row['categories']."</option>";
                                        }
                                        else{
                                            echo "<option value=".$row['id'].">".$row['categories']."</option>";
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="" class="form-control-label">Sub Categories</label>
                            <input type="text" name="sub_categories" placeholder="Enter Sub Categories Name" class="form-control" value='<?php echo $sub_cat; ?>'>
                        </div>
                        <button type="submit" name="submit" class="btn btn-lg btn-info btn-block">
                            <span>Submit</span>
                        </button>
                    </div>
                    </form>
                    <div style="color: red;"><?php echo $msg; ?></div>
                </div>

            </div>
        </div><!-- .animated -->
    </div><!-- .content -->
    
<?php include 'footer.inc.php' ?>
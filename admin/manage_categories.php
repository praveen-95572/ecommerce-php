
<?php include 'top.inc.php'; 
isAdmin();
$cat='';
$msg='';
if(isset($_GET['id']) && $_GET['id']!=''){
        $id=get_safe_val($conn,$_GET['id']);
        $sql="SELECT * FROM categories WHERE id='$id'";
        $query=mysqli_query($conn,$sql);
        if($check=mysqli_num_rows($query)>0){
        $fetch=mysqli_fetch_assoc($query);
        $cat=$fetch['categories'];
        }
        else
        {
            echo "<script>window.location.href='categories.php';</script>";
            die();
        }
    }
if(isset($_POST['submit'])){
    $cat=get_safe_val($conn,$_POST['categories']);
    $sql="SELECT * categories WHERE categories='$cat'";
    $query=mysqli_query($conn,$sql);
    $check=mysqli_num_rows($query);
    if($check>0){
        $msg="Categories already exist.";
    }
    else{
        if(isset($_GET['id']) && $_GET['id']!=''){
            $sql="UPDATE categories SET categories='$cat' WHERE id='$id'";
            mysqli_query($conn,$sql);
            }
        else{
            $sql="INSERT INTO categories(categories,status) VALUES ('$cat','1')";
            mysqli_query($conn, $sql);
            }
        echo "<script>window.location.href='categories.php';</script>";
            die();
    }
}
?>

<div class="content">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header"><strong>Category</strong><small> Form</small></div>
                    <form method="post">
                    <div class="card-body card-block">
                        <div class="form-group">
                            <label for="" class="form-control-label">Categories</label>
                            <input type="text" name="categories" placeholder="Enter Categories Name" class="form-control" value='<?php echo $cat; ?>'>
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
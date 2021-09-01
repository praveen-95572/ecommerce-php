
<?php 
include 'top.inc.php';
isAdmin();
$sql="SELECT * FROM categories ORDER BY categories ASC";
$query=mysqli_query($conn, $sql); 

if(isset($_GET['id']) && $_GET['id']!=''){
    $id=get_safe_val($conn,$_GET['id']);
    if($_GET['type']=='delete'){
        $sql="DELETE FROM categories WHERE id='$id'";
        mysqli_query($conn,$sql);
    }
     if($_GET['type']=='active'){
        $sql="UPDATE categories SET status=0 WHERE id='$id'";
        mysqli_query($conn,$sql);
    }
    if($_GET['type']=='deactive'){
        $sql="UPDATE categories SET status=1 WHERE id='$id'";
        mysqli_query($conn,$sql);
    }
    echo "<script>window.location.href='categories.php';</script>";
}
?>

      <div class="content">
                <div class="orders">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="box-title">Categories </h4>
                                    <h6 class="box-title active" style="font-size: .8em; text-decoration: underline;"><a href="manage_categories.php">Manage Categories</a> </h6>
                                </div>
                                <div class="card-body--">
                                    <div class="table-stats order-table ov-h">
                                        <table class="table ">
                                            <thead>
                                                <tr>
                                                    <th class="serial">#</th>
                                                    
                                                    <th>ID</th>
                                                    <th>Categories</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $x=1;  
                                                while ($row=mysqli_fetch_assoc($query)) {?>
                                                <tr>
                                                    <td class="serial"><?php echo $x++;; ?></td>
                                                    <td><?php echo $row['id']; ?></td>
                                                    <td><?php echo $row['categories']; ?></td>
                                                    <td><?php 
                                                        if($row['status']==1)
                                                            echo "<span class='badge badge-complete'><a href='?type=active&id=".$row['id']."'>Active</a></span>"; 
                                                        else
                                                            echo "<span class='badge badge-pending'><a href='?type=deactive&id=".$row['id']."'>Deactive</a></span>";
                                                        echo "&nbsp;<span class='badge badge-edit'><a href='manage_categories.php?id=".$row['id']."'>Edit</a></span>";
                                                        echo "&nbsp;<span class='badge badge-delete'><a href='?id=".$row['id']."&type=delete'>Delete</a></span>";
                                                        ?></td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div> <!-- /.table-stats -->
                                </div>
                            </div> <!-- /.card -->
                        </div>  <!-- /.col-lg-8 -->

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

<?php 
include 'top.inc.php';
isAdmin();
$sql="SELECT * FROM contact ORDER BY added_on DESC";
$query=mysqli_query($conn, $sql); 
if(isset($_GET['id']) && $_GET['id']!=''){
    $id=$_GET['id'];
    $sql="DELETE FROM contact WHERE id='$id'";
    if(mysqli_query($conn,$sql))
        echo "<script>alert('Data Deleted ');window.location.href='contact.php';</script>";
    else
        echo "<script>alert('Hacker attak :)  !');window.location.href='contact.php';</script>";


}
?>

      <div class="content">
                <div class="orders">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="box-title">Contacts </h4>
                                    
                                </div>
                                <div class="card-body--">
                                    <div class="table-stats order-table ov-h">
                                        <table class="table ">
                                            <thead>
                                                <tr>
                                                    <th class="serial">#</th>
                                                    
                                                    <th>ID</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Mobile</th>
                                                    <th>Query</th>
                                                    <th>Date</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $x=1;  
                                                while ($row=mysqli_fetch_assoc($query)) {?>
                                                <tr>
                                                    <td class="serial"><?php echo $x; ?></td>
                                                    <td><?php echo $row['id']; ?></td>
                                                    <td><?php echo $row['name']; ?></td>
                                                    <td><?php echo $row['email']; ?></td>
                                                    <td><?php echo $row['mobile']; ?></td>
                                                    <td><?php echo $row['comment']; ?></td>
                                                    <td><?php echo $row['added_on']; ?></td>
                                                    <td><?php
                                                        echo "&nbsp;<span class='badge badge-delete'><a href='?id=".$row['id']."'>Delete</a></span>";
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
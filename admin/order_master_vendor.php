
<?php 
include 'top.inc.php';
?>

      <div class="content">
                <div class="orders">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="box-title">Orders </h4>
                                    <h6 class="box-title active" style="font-size: .8em; text-decoration: underline;"><a href="add_categories.php">Manage Categories</a> </h6>
                                </div>
                                <div class="card-body--">
                                    <div class="table-stats order-table ov-h">
                                        <table  class="table ">
      <thead>
        <td class="serial">Order Id</td><td>Product</td><td>Address</td><td>Payment Type</td><td>Payment Status</td><td>Order Status</td>
      </thead>
      <tbody>
        <?php 
       // $sql="SELECT orders.*,order_status.order_status AS order_status_str FROM orders,order_status WHERE order_status.id=orders.order_status ORDER BY orders.id";
        $sql="SELECT order_detail.qty,product.name,orders.*,order_status.order_status AS order_status_str FROM orders,order_status,order_detail,product WHERE order_status.id=orders.order_status AND product.id=order_detail.p_id AND orders.id=order_detail.order_id AND product.added_by='".$_SESSION['ADMIN_ID']."'";
        
        $query=mysqli_query($conn,$sql);
      
        while($fetch=mysqli_fetch_assoc($query))
         {?><tr>
          <td class="serial"><?php echo "1234236".$fetch['id']; ?></td>
          <td><?php echo $fetch['name']; ?><br>qty :<?php echo $fetch['qty']; ?></td>
          <td><?php echo $fetch['address']."/".$fetch['city']."/".$fetch['state']; ?></td>
          <td><?php echo $fetch['pay_type']; ?></td>

          <td><?php if($fetch['pay_status'])  echo "Paid";
            else echo "Pending"; ?></td>
          <td><?php echo $fetch['order_status_str']; ?></td>
            <?php }
        ?>
      </tbody>
    </table>
                                    </div> <!-- /.table-stats -->
                                </div>
                            </div> <!-- /.card -->
                        </div>  <!-- /.col-lg-8 -->

        </div>
        <!-- /.content -->
    
<?php include 'footer.inc.php' ?>


<?php 
include 'top.inc.php';
isAdmin();
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
				<td class="serial">Order Id</td><td>Order Date</td><td>Address</td><td>Payment Type</td><td>Payment Status</td><td>Order Status</td><td>Shipment Details</td>
			</thead>
			<tbody>
				<?php 
				$sql="SELECT orders.*,order_status.order_status AS order_status_str FROM orders,order_status WHERE order_status.id=orders.order_status ORDER BY orders.id";
 				
				$query=mysqli_query($conn,$sql);
			
				while($fetch=mysqli_fetch_assoc($query))
				 {?><tr>
					<td class="serial"><a href="order_master_detail.php?id=<?php echo $fetch['id']; ?>"><?php echo "1234236".$fetch['id']; ?></a>
						<br>
						<a href="order_pdf.php?id=<?php echo $fetch['id']; ?>">invoice</a>
						
					</td>
					<td><?php echo $fetch['added_on']; ?></td>
					<td><?php echo $fetch['address']."/".$fetch['city']."/".$fetch['state']; ?></td>
					<td><?php echo $fetch['pay_type']; ?></td>
					<td><?php if($fetch['pay_status'])  echo "Paid";
            else echo "Pending"; ?></td>
					<td><?php echo $fetch['order_status_str']; ?></td>
					<td><?php echo "Order Id - ".$fetch['ship_order_id']."<br>";
						echo "Shipment Id - ".$fetch['ship_shipment_id']; ?></td></tr>
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

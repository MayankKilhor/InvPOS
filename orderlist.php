<?php
include_once'connectdb.php';
session_start();
if($_SESSION['useremail']==""){
    
    header('location:index.php');
}
if( $_SESSION['role']=="User"){
    include_once'headeruser.php';
    
}elseif($_SESSION['role']=="Admin"){
    include_once'header.php';
}

?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Order List
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
             <div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title">Order List</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            
            <div class="box-body">
            <div style="overflow-x:auto">
            <table id="orderlisttable" class="table table-striped">
                        <thead>
                            
                        <tr>
<!--                        <th>#</th>-->
                        <th>Invoice ID</th>
                        <th>Customer Name</th>
                        <th>Order Date</th>
                        <th>Total</th>
                        <th>Paid</th>
                        <th>Due</th>
                        <th>Payment Type</th>
                        <th>Print</th>
                        <th>Edit</th>
                        <th>Delete</th>
                        </tr>    
                            
                        </thead>
                        <tbody>
                            
                            <?php
                                $select=$pdo->prepare("select * from tbl_invoice order by invoice_id desc");
                                $select->execute();
                                while($row=$select->fetch(PDO::FETCH_OBJ)){
                                    
                                    echo '
                                    <tr>
                                  
                                    <td>'.$row->invoice_id.'</td>
                                    <td>'.$row->customer_name.'</td>
                                    <td>'.$row->order_date.'</td>
                                    <td>'.$row->total.'</td>
                                    <td>'.$row->paid.'</td>
                                    <td>'.$row->due.'</td>
                                    <td>'.$row->payment_type.'</td>
                                    <td>
                                     
                                    <a href="invoice_80mm.php?id='.$row->invoice_id.'" class="btn btn-warning" role="button" title="Print Invoice" target="_blank"><i style="color:#ffffff" data-toggle="tooltip" class="fa fa-print" ></i> <span></span></a>
                                    </td>
                                    <td>
                                     <a href="editorder.php?id='.$row->invoice_id.'" class="btn btn-info" role="button" title="Edit Order"><i style="color:#ffffff" data-toggle="tooltip" class="fa fa-edit" ></i> <span></span></a>
                                    
                                    </td>
                                    <td>
                                     <button id='.$row->invoice_id.' class="btn btn-danger btndelete" role="button" title="Delete Order"><i style="color:#ffffff" data-toggle="tooltip" class="fa fa-trash-o" ></i> <span></span></a>
                                    
                                    </td>
                                    ';
                                }
                            ?>
                            
                            
                        </tbody>
                      
                        </table>
                </div>
            
    <!-- /.content -->
  </div>
        </div>
</section>
        
</div>
  <!-- /.content-wrapper -->
<script>
  $(document).ready(function () {
    $('#orderlisttable').DataTable({
        "order":[[0,"desc"]]
    })
  })

</script>
<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    })


</script>

<script>
        $(document).ready(function(){
    
    $('.btndelete').click(function(){
        
        var tdh=$(this);
        var id=$(this).attr("id");
        
        swal({
              title: "Are you sure you want to delete this order?",
              text: "Once Order deleted, you will not be able to recover it!!",
              icon: "warning",
              buttons: true,
              dangerMode: true,
            })
            .then((willDelete) => {
              if (willDelete) {
                  
                  $.ajax({
                        url:'orderdelete.php',
                        type:'post',
                        data:{
                            iid:id
                        },
                        success:function(data){
                             tdh.parents('tr').hide();
                        }
                    })
                  
                swal("Your Order has been deleted!", {
                  icon: "success",
                });
              } else {
                swal("Your Order is safe!");
              }
            });
        
        
        
    });
    
});




</script>

 <?php

include_once'footer.php';

?>

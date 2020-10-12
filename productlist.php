
<?php
include_once'connectdb.php';
session_start();

error_reporting(0);
if($_SESSION['useremail']=="" OR $_SESSION['role']=="User"){
    
    header('location:index.php');
}
include_once'header.php';

?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Product List
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
             
      <!--------------------------
        | Your Page Content Here |
        -------------------------->
            <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Product List</h3>
            </div>
            <table id="tableproduct" class="table table-striped">
                        <thead>
                            
                        <tr>
<!--                        <th>#</th>-->
                        <th>Product Name</th>
                        <th>Category</th>
                        <th>Purchase Price</th>
                        <th>Sale Price</th>
                        <th>Stock</th>
                        <th>Description</th>
                        <th>Image</th>
                        <th>View</th>
                        <th>Edit</th>
                        <th>Delete</th>
                        </tr>    
                            
                        </thead>
                        <tbody>
                            
                            <?php
                                $select=$pdo->prepare("select * from tbl_product order by pid desc");
                                $select->execute();
                                while($row=$select->fetch(PDO::FETCH_OBJ)){
                                    
                                    echo '
                                    <tr>
                                  
                                    <td>'.$row->pname.'</td>
                                    <td>'.$row->pcategory.'</td>
                                    <td>'.$row->purchaseprice.'</td>
                                    <td>'.$row->saleprice.'</td>
                                    <td>'.$row->pstock.'</td>
                                    <td>'.$row->pdescription.'</td>
                                    <td><img src="productimages/'.$row->pimage.'" class="img-rounded" width="40px" height="40px" /></td>
                                    <td>
                                     <a href="viewproduct.php?id='.$row->pid.'" class="btn btn-success" role="button"><i style="color:#ffffff" data-toggle="tooltip" class="fa fa-eye"></i> <span>  View </span></a>
                                    
                                    </td>
                                    <td>
                                     <a href="editproduct.php?id='.$row->pid.'" class="btn btn-info" role="button"><i style="color:#ffffff" data-toggle="tooltip" class="fa fa-edit"></i> <span>  Edit </span></a>
                                    
                                    </td>
                                    <td>
                                     <button id='.$row->pid.' class="btn btn-danger btndelete" role="button"><i style="color:#ffffff" data-toggle="tooltip" class="fa fa-trash-o"></i> <span>  Delete</span></a>
                                    
                                    </td>
                                    ';
                                }
                            ?>
                            
                            
                        </tbody>
                      
                        </table>
            
        </div>     
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    })


</script>

<script>
  $(document).ready(function () {
    $('#tableproduct').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })

</script>

<script>

$(document).ready(function(){
    
    $('.btndelete').click(function(){
        
        var tdh=$(this);
        var id=$(this).attr("id");
        
        swal({
              title: "Are you sure you want to delete this product?",
              text: "Once Product deleted, you will not be able to recover it!!",
              icon: "warning",
              buttons: true,
              dangerMode: true,
            })
            .then((willDelete) => {
              if (willDelete) {
                  
                  $.ajax({
                        url:'productdelete.php',
                        type:'post',
                        data:{
                            productid:id
                        },
                        success:function(data){
                             tdh.parents('tr').hide();
                        }
                    })
                  
                swal("Your Product has been deleted!", {
                  icon: "success",
                });
              } else {
                swal("Your Product is safe!");
              }
            });
        
        
        
    });
    
});




</script>


 <?php

include_once'footer.php';

?>

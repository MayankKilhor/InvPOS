

<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- Login JS-->
<script src="login/form.js"></script>
<!--<script src="bower_components/sweetalert/sweetalert.js"></script>-->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<!-- DataTables -->
<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

<?php
include_once'connectdb.php';

session_start();

//error_reporting(0);

if($_SESSION['useremail']=="" OR $_SESSION['role']=="User"){
    
    header('location:index.php');
}
if(isset($_POST['btnsave'])){
    
    $category=$_POST['txt_category'];
    
    if(empty($category)){
        
       $error='<script type="text/javascript">
         
         jQuery(function validation(){
         
            swal({
            title: "Field is Empty",
            text: "Your Category is not Added!!",
            icon: "warning",
            button: "Ok!",
            }); 
         
         });
        
         </script>'; 
        echo $error;
    }
    
    if(!isset($error)){
        
         $insert=$pdo->prepare("insert into tbl_category(category) values(:cat)");
    
    $insert->bindParam(':cat',$category);
    
        
        if($insert->execute()){
        echo '<script type="text/javascript">
         
         jQuery(function validation(){
         
            swal({
            title: "Good job!'.$_SESSION['username'].'",
            text: "Your Category is Added!!",
            icon: "success",
            button: "Ok!",
            }); 
         
         });
        
         </script>';
    }else{
            echo '<script type="text/javascript">
         
         jQuery(function validation(){
         
            swal({
            title: "Try Again",
            text: "Category not Added!!",
            icon: "warning",
            button: "Ok!",
            }); 
         
         });
        
         </script>';
    }
        
    }
   
}

if(isset($_POST['btnupdate'])){
    $category=$_POST['txt_category'];
    $id=$_POST['txt_id'];
    
    if(empty($category)){
        $errorupdate='<script type="text/javascript">
         
         jQuery(function validation(){
         
            swal({
            title: "Field is Empty",
            text: "Your Category is not Updated!!",
            icon: "warning",
            button: "Ok!",
            }); 
         
         });
        
         </script>'; 
        echo $errorupdate;
    }
    if(!isset($error)){
        $update=$pdo->prepare("update tbl_category set category=:category where catid=".$id);
        $update->bindParam(':category',$category);
        if($update->execute()){
        echo '<script type="text/javascript">
         
         jQuery(function validation(){
         
            swal({
            title: "Good job!'.$_SESSION['username'].'",
            text: "Your Category is Update!!",
            icon: "success",
            button: "Ok!",
            }); 
         
         });
        
         </script>';
    }else{
            echo '<script type="text/javascript">
         
         jQuery(function validation(){
         
            swal({
            title: "Try Again",
            text: "Your Category not Updated!!",
            icon: "warning",
            button: "Ok!",
            }); 
         
         });
        
         </script>';
    }
    }

}
//
//if(isset($_POST['btndelete'])){
//    $delete=$pdo->prepare("delete from tbl_category  where catid=".$_POST['btndelete']);
//    
//    if($delete->execute()){
//        echo '<script type="text/javascript">
//         
//         jQuery(function validation(){
//         
//            swal({
//            title: "Good job!'.$_SESSION['username'].'",
//            text: "Your Category is Deleted!!",
//            icon: "success",
//            button: "Ok!",
//            }); 
//         
//         });
//        
//         </script>';
//    }else{
//        e
//    }
//}

include_once'header.php';

?>
<!-- DataTables -->
  <link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Category
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
              <h3 class="box-title">Category Form</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            
              <div class="box-body">
                  <form role="form" action="" method="post">
                  
                      <?php
                      
                      if(isset($_POST['btnedit'])){
                          $select=$pdo->prepare("select * from tbl_category where catid=".$_POST['btnedit'] );
    
                            $select->execute();
                          if($select){
                              
                              $row=$select->fetch(PDO::FETCH_OBJ);
                              echo ' <div class="col-md-4">
                    
                                <div class="form-group">
                                    <label >Category</label>
                                    <input type="hidden" class="form-control" value="'.$row->catid.'" name="txt_id" >
                                    <input type="text" class="form-control" value="'.$row->category.'" name="txt_category" required>
                                </div>
                     
                   
                                <div class="box-footer">
                                    <button type="submit" class="btn btn-info" name="btnupdate">Update</button>
                                </div>
                        </div>';
                          
                          }
                          
                      }else{
                          echo ' <div class="col-md-4">
                    
                      <div class="form-group">
                            <label >Category</label>
                            <input type="text" class="form-control" name="txt_category" placeholder="Enter Category" required>
                        </div>
                     
                   
                        <div class="box-footer">
                        <button type="submit" class="btn btn-warning" name="btnsave">Save</button>
                        </div>
                  </div>';
                          
                      }
                      
                      ?>
                      
                      
                      
                      
                  <div class="col-md-8">
                  
                        <table id="tablecategory" class="table table-bordered table-striped" >
                        <thead>
                            
                        <tr>
<!--                        <th>#</th>-->
                        <th>CATEGORY</th>
                        <th>EDIT</th>
                        <th>DELETE</th>
                        
                        </tr>    
                            
                        </thead>
                        <tbody>
                            <?php
                                $select=$pdo->prepare("select * from tbl_category order by catid desc");
                                $select->execute();
                                while($row=$select->fetch(PDO::FETCH_OBJ)){
                                    
                                    echo '
                                    <tr>
                                  
                                    <td>'.$row->category.'</td>
                                    <td>
                                     <button type="submit" value="'.$row->catid.'"class="btn btn-success" name="btnedit"><i class="fa fa-edit"></i> <span>Edit</span></button>
                                    
                                    </td>
                                    
                                    <td>
                                     <button id='.$row->catid.' class="btn btn-danger btndelete" role="button"><i  class="fa fa-trash-o"></i> <span>  Delete</span></a>
                                    
                                    </td>
                                    ';
                                }
                            ?>
                         
                            
                            
                        </tbody>
                      
                        </table>
                  
                  
                  
                  
                  </div>
                      </form>
              </div>
              <!-- /.box-body -->

              
            
          </div>
      <!--------------------------
        | Your Page Content Here |
        -------------------------->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
    
<script>
      
 <script>
  $(document).ready(function () {
    $('#tablecategory').DataTable({
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
              title: "Are you sure you want to delete this Category?",
              text: "Once Category deleted, you will not be able to recover it!!",
              icon: "warning",
              buttons: true,
              dangerMode: true,
            })
            .then((willDelete) => {
              if (willDelete) {
                  
                  $.ajax({
                        url:'categorydelete.php',
                        type:'post',
                        data:{
                            categoryid:id
                        },
                        success:function(data){
                             tdh.parents('tr').hide();
                        }
                    })
                  
                swal("Your Category has been deleted!", {
                  icon: "success",
                });
              } else {
                swal("Your Category is safe!");
              }
            });
        
        
        
    });
    
});


</script>

 <?php

include_once'footer.php';

?>

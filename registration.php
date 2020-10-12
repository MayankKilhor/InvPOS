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



<?php
include_once'connectdb.php';
session_start();

error_reporting(0);
if($_SESSION['useremail']=="" OR $_SESSION['role']=="User"){
    
    header('location:index.php');
}


if(isset($_POST['btnsave'])){
    
    $username=$_POST['txt_name'];
    $userrole=$_POST['select_option'];
    $useremail=$_POST['txt_email'];
    $password=$_POST['txt_password'];
    $confpassword=$_POST['txt_confpassword'];
    
    if(isset($_POST['txt_email'])){
        
        $select=$pdo->prepare("select useremail from tbl_user where useremail='$useremail'");
        $select->execute();
        
        if($select->rowCount()>0){
             echo '<script type="text/javascript">
         
         jQuery(function validation(){
         
            swal({
            title: "Wrong Entry",
            text: "Email already exist! Please Try Again with different email Id",
            icon: "error",
            button: "Ok!",
            }); 
         
         });
        
         </script>';
            
        }else{
             $insert=$pdo->prepare("insert into tbl_user(username,useremail,password,role) values(:name,:email,:pass,:role)");
    
    $insert->bindParam(':name',$username);
    $insert->bindParam(':role',$userrole);
    $insert->bindParam(':email',$useremail);
    $insert->bindParam(':pass',$password);
    
    if($password==$confpassword){
        
        if($insert->execute()){
             echo '<script type="text/javascript">
         
         jQuery(function validation(){
         
            swal({
            title: "Good job!'.$_SESSION['username'].'",
            text: "Registration is completed!!",
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
            text: "Registration not completed!!",
            icon: "warning",
            button: "Ok!",
            }); 
         
         });
        
         </script>';
        }
    }else{
        echo '<script type="text/javascript">
         
         jQuery(function validation(){
         
            swal({
            title: "Wrong Entry",
            text: "Confirm password is different from password",
            icon: "error",
            button: "Ok!",
            }); 
         
         });
        
         </script>';
    }
            
        }
        
    }
   

}

include_once'header.php';

?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Registration
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
        
        <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Registration Form</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="" method="post">
              <div class="box-body">
                  
                  <div class="col-md-4">
                    
                      <div class="form-group">
                            <label >Name</label>
                            <input type="text" class="form-control" name="txt_name" placeholder="Enter Username" required>
                        </div>
                      <div class="form-group">
                            <label for="exampleInputEmail1">Email address</label>
                            <input type="email" class="form-control" name="txt_email" placeholder="Enter email" required>
                        </div>
                      <div class="form-group">
                            <label for="exampleInputPassword1">Password</label>
                            <input type="password" class="form-control" name="txt_password" placeholder="Password">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Confirm Password</label>
                            <input type="password" class="form-control" name="txt_confpassword" placeholder="Confirm Password">
                        </div>
                        <div class="form-group">
                            <label>Role</label>
                            <select class="form-control" name="select_option" required>
                            <option value="" disabled selected>Select role</option>
                            <option>Admin</option>
                            <option>User</option>
                            </select>
                        </div>
                        <div class="box-footer">
                        <button type="submit" class="btn btn-info" name="btnsave">Submit</button>
                        </div>
                  </div>
                  <div class="col-md-8">
                  
                        <table class="table table-striped">
                        <thead>
                            
                        <tr>
<!--                        <th>#</th>-->
                        <th>Name</th>
                        <th>Email</th>
                        <th>Password</th>
                        <th>Role</th>
                        <th>DELETE</th>
                        </tr>    
                            
                        </thead>
                        <tbody>
                            
                            <?php
                                $select=$pdo->prepare("select * from tbl_user order by userid desc");
                                $select->execute();
                                while($row=$select->fetch(PDO::FETCH_OBJ)){
                                    
                                    echo '
                                    <tr>
                                  
                                    <td>'.$row->username.'</td>
                                    <td>'.$row->useremail.'</td>
                                    <td>'.$row->password.'</td>
                                    <td>'.$row->role.'</td>
                                    <td>
                                     <button id='.$row->userid.' class="btn btn-danger btndelete" role="button"><i class="fa fa-trash-o"></i> <span>  Delete</span></a>
                                    
                                    </td>
                                  
                                    ';
                                }
                            ?>

                            
                        </tbody>
                      
                        </table>
                  
                  
                  
                  
                  </div>

              </div>
              <!-- /.box-body -->

              
            </form>
          </div>
      <!--------------------------
        | Your Page Content Here |
        -------------------------->
        
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<script>

$(document).ready(function(){
    
    $('.btndelete').click(function(){
        
        var tdh=$(this);
        var id=$(this).attr("id");
        
        swal({
              title: "Are you sure you want to delete this User?",
              text: "Once User credentials deleted, you will not be able to recover it!!",
              icon: "warning",
              buttons: true,
              dangerMode: true,
            })
            .then((willDelete) => {
              if (willDelete) {
                  
                  $.ajax({
                        url:'userdelete.php',
                        type:'post',
                        data:{
                            userid:id
                        },
                        success:function(data){
                             tdh.parents('tr').hide();
                        }
                    })
                  
                swal("Your User Data has been deleted!", {
                  icon: "success",
                });
              } else {
                swal("Your User Data is safe!");
              }
            });
        
        
        
    });
    
});




</script>




 <?php

include_once'footer.php';

?>

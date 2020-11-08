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


if(isset($_POST['btnupdate'])){
    
    $oldpassword=$_POST['txt_oldpass'];
    $newpassword=$_POST['txt_newpass'];
    $confpassword=$_POST['txt_confirmpass'];
    
    
    
    $email=$_SESSION['useremail'];
    
    $select=$pdo->prepare("select * from tbl_user where useremail='$email' ");
     $select->execute();
    
    $row=$select->fetch(PDO::FETCH_ASSOC);
    
    $password_db=$row['password'];
    $useremail_db=$row['useremail'];
    
    if($oldpassword==$password_db){
        
        if($newpassword==$confpassword){
            
            $update=$pdo->prepare("update tbl_user set password=:pass where useremail=:email");
            
            $update->bindParam(':pass',$confpassword);
            $update->bindParam(':email',$email);
            
            if($update->execute()){
                 echo '<script type="text/javascript">
         
         jQuery(function validation(){
         
            swal({
            title: "Good job!'.$_SESSION['username'].'",
            text: " New Password is changed!!",
            icon: "success",
            button: "Ok!",
            }); 
         
         });
        
         </script>';
            }else{
                 echo '<script type="text/javascript">
         
         jQuery(function validation(){
         
            swal({
            title: "Network Issue",
            text: "Password not changed!!",
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
            title: "Username Or Phone are different!",
            text: "Password not changed!!",
            icon: "error",
            button: "Ok!",
            }); 
         
         });
        
         </script>';
        }
        
    }else{
     
        echo '<script type="text/javascript">
         
         jQuery(function validation(){
         
            swal({
            title: "Old password is not correct!",
            text: "Password not changed!!",
            icon: "error",
            button: "Ok!",
            }); 
         
         });
        
         </script>';
    
    }
    
}

if($_SESSION['useremail']==""){
    header('location:index.php');
}
if($_SESSION['role']=='Admin'){
    include_once'header.php';
}else{
    include_once'headeruser.php';
}


?>
    <link rel="stylesheet" href="changepassword/change.css"> 
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Change Password
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
        <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Change password form</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            
            <div class="box-body">
              <form role="form" action="#" method="post">
                <div class="row">
                  <input type="text" placeholder="Password" name="txt_oldpass"/>
                    <label for="fancy-text">Old Password</label>
                </div>
                
                <div class="row">
                  
                  <input type="password" id="fancy-password" placeholder="Password" name="txt_newpass"/>
                    <label for="fancy-text">New Password</label>
                </div>
                
                  <div class="row">
                  
                  <input type="password" class="form-control"  placeholder="Password" name="txt_confirmpass"/>
                      <label for="fancy-text">Confirm Password</label>
                </div>
                
              <!-- /.box-body -->

              
                  <button type="submit" tabindex="0" name="btnupdate"><p style="padding= '10px 15em;'">Update</p></button>
              
            </form>
          </div>

      <!--------------------------
        | Your Page Content Here |
        -------------------------->
        </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

 <?php

include_once'footer.php';

?>

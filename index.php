 <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="login/form.js"></script>
<?php
include_once'connectdb.php';
session_start();
error_reporting(0);
if(isset($_POST['btn_login'])){
    
    $useremail=$_POST['txt_email'];
    $password=$_POST['txt_password'];
    
    $select=$pdo->prepare("select * from tbl_user where useremail='$useremail' AND password='$password' ");
    
    $select->execute();
    
    $row=$select->fetch(PDO::FETCH_ASSOC);
    
    if($row['useremail']==$useremail AND $row['password']==$password ){
         if($row['role']=='Admin'){
             
              $_SESSION['userid']=$row['userid'];
         $_SESSION['username']=$row['username'];
         $_SESSION['useremail']=$row['useremail'];
         $_SESSION['role']=$row['role'];
        
        
        echo '<script type="text/javascript">
         
         jQuery(function validation(){
         
            swal({
            title: "Good job!'.$_SESSION['username'].'",
            text: "Your Details Matched",
            icon: "success",
            button: "Ok!",
            }); 
         
         });
        
//         </script>';
        header('refresh:1;dashboard.php'); 
             
         }else if($row['role']=='User'){
             
             $_SESSION['userid']=$row['userid'];
         $_SESSION['username']=$row['username'];
         $_SESSION['useremail']=$row['useremail'];
         $_SESSION['role']=$row['role'];
        
//        
         echo '<script type="text/javascript">
         
         jQuery(function validation(){
         
            swal({
            title: "Good job!'.$_SESSION['username'].'",
            text: "Your Deatils Matched!",
            icon: "success",
            button: "Ok!",
            }); 
         
         });
        
         </script>';
        header('refresh:1;user.php');
         }
        
          
       
    }else{
        echo '<script type="text/javascript">
         
         jQuery(function validation(){
         
            swal({
            title: "Try Again!",
            text: "Username or Password is wrong!",
            icon: "error",
            button: "Ok!",
            }); 
         
         });
        </script>';
        
//        header('refresh:1;index.php');
    }
    
}
    

?>



<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 3 | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
    
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="login/form.js"></script>
    
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
<!--  <link rel="stylesheet" href="dist/css/adminlte.min.css">-->
  <!-- Own CSS-->
  <link rel="stylesheet" href="login/form.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body>
<div class="materialContainer">
   <form action="" method="post">
    <div class="box">

      <div class="title"><a href="#"><b>Inv</b>POS</a></<br></div>

      <div class="input">
         <label for="name">Email</label>
         <input type="email" name="txt_email" id="name" required>
         <span class="spin"></span>
      </div>

      <div class="input">
         <label for="pass">Password</label>
         <input type="password" name="txt_password" id="pass" required>
         <span class="spin"></span>
      </div>

      <div class="button login">
         <button  name="btn_login"><span>Login</span> <i class="fa fa-check"></i></button>
      </div>

      <a href="#" class="pass-forgot" onclick="swal('To Get New Password','Please contact to Admin or service provider','warning');">Forgot your password?</a>

   </div>
    </form>
</div>

</body>
</html>
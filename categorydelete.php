<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>


<?php

include_once'connectdb.php';
session_start();
if($_SESSION['useremail']=="" OR $_SESSION['role']=="User"){
    
    header('location:index.php');
}

$id=$_POST['categoryid'];

$sql="delete from tbl_category where catid=$id";

$delete=$pdo->prepare($sql);

if($delete->execute()){
    
}else{
    
   echo'Error is deleting Category';
}

error_reporting(0);
include_once'header.php';


?>
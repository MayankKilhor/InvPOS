<?php

include_once'connectdb.php';
session_start();
if($_SESSION['useremail']=="" OR $_SESSION['role']=="User"){
    
    header('location:index.php');
}

$id=$_POST['userid'];

$sql="delete from tbl_user where userid=$id";

$delete=$pdo->prepare($sql);

if($delete->execute()){
    
}else{
    
    echo'Error is deleting User';
}

error_reporting(0);
include_once'header.php';


?>
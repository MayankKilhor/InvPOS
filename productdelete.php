<?php

include_once'connectdb.php';
session_start();
if($_SESSION['useremail']=="" OR $_SESSION['role']=="User"){
    
    header('location:index.php');
}

$id=$_POST['productid'];

$sql="delete from tbl_product where pid=$id";

$delete=$pdo->prepare($sql);

if($delete->execute()){
    
}else{
    
    echo'Error is deleting product';
}

error_reporting(0);
include_once'header.php';


?>
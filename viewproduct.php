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
        View Product
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
                      <h3 class="box-title"><a href="productlist.php" class="btn btn-primary" role="button">Back to Product List</a></h3>
                    </div>
            <!-- /.box-header -->
            <!-- form start -->
            
              <div class="box-body">
                  <?php 
                  $id=$_GET['id'];
                   $select=$pdo->prepare("select * from tbl_product where pid=$id");
                    $select->execute();
                   while($row=$select->fetch(PDO::FETCH_OBJ)){
                    
                       echo '
                            <div class="col-md-6">
                                <ul class="list-group">
                                <center><p class="list-group-item list-group-item-success"><b>Product Details</b><p></center>
                                  <li class="list-group-item "><b> Product Name </b><span class="badge badge-primary badge-pill">'.$row->pname.'</span></li>
                                  <li class="list-group-item"><b>Category </b><span class="badge">'.$row->pcategory.'</span></li>
                                  <li class="list-group-item"><b>Purchase Price </b><span class="badge">'.$row->purchaseprice.'</span></li>
                                  <li class="list-group-item"><b>SalePrice </b><span class="badge">'.$row->saleprice.'</span></li>
                                  <li class="list-group-item"><b>Profit </b><span class="badge">'.($row->saleprice - $row->purchaseprice ).'</span></li>
                                  <li class="list-group-item"><b>Product Stock </b><span class="badge">'.$row->pstock.'</span></li>
                                  <li class="list-group-item"><b>Description:- </b><br><div class="container"><span >'.$row->pdescription.'</span></div></li>
                                </ul>
                            </div>
                            
                             <div class="col-md-6">
                                <ul class="list-group">
                                 <center><p class="list-group-item list-group-item-success"><b>Product Image</b><p></center>
                
                                 <img src="productimages/'.$row->pimage.'" class="img-responsive"  />
                                </ul>
                            </div>
                       ';
                    
                   }
                  
                  ?>
                  
                 </div>
        </div>
      <!--------------------------
        | Your Page Content Here |
        -------------------------->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

 <?php

include_once'footer.php';

?>

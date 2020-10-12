 <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<?php
include_once'connectdb.php';
session_start();

if($_SESSION['useremail']=="" OR $_SESSION['role']=="User"){
    
    header('location:index.php');
}
error_reporting(0);  

if($_SESSION['useremail']=="" OR $_SESSION['role']=="User"){
    
    header('location:index.php');
}
$id=$_GET['id'];
$select=$pdo->prepare("select * from tbl_product where pid=$id");
$select->execute();
$row=$select->fetch(PDO::FETCH_ASSOC);

$id_db=$row['id'];

$productname_db=$row['pname'];
$category_db=$row['pcategory'];
$purchaseprice_db=$row['purchaseprice'];
$saleprice_db=$row['saleprice'];
$pstock_db=$row['pstock'];
$pdescription_db=$row['pdescription'];
$pimage_db=$row['pimage'];

if(isset($_POST['btnupdate'])){
    
    $productname_txt=$_POST['txt_name'];
    $category_txt=$_POST['select_option'];
    $purchaseprice_txt=$_POST['txt_pur_price'];
    $saleprice_txt=$_POST['txt_sale_price'];
    $stock_txt=$_POST['txt_stock'];
    $description_txt=$_POST['txt_description'];
    
    $f_name=$_FILES['myfile']['name'];
    
    
if(!empty($f_name)){
                    $f_tmp=$_FILES['myfile']['tmp_name'];
                    $f_size=$_FILES['myfile']['size'];
                    $f_extension=explode('.',$f_name);
                    $f_extension=strtolower(end($f_extension));

                    $f_newfile=uniqid().'.'.$f_extension;

                    $store="productimages/".$f_newfile;

                if($f_extension=='jpg'||$f_extension=='jpeg' || $f_extension=='png'||$f_extenssion=='gif'){

                                if($f_size>=1000000){

                                            $error='<script type="text/javascript">

                                                  jQuery(function validation(){

                                                    swal({
                                                    title: "Try Again!",
                                                    text: "Max file should be 1MB",
                                                    icon: "warning",
                                                    button: "Ok!",
                                                    }); 

                                                 });
                                                </script>';
                                            echo $error;

                                }else{
                                            if(move_uploaded_file($f_tmp,$store)){
                                                    
                                                        if(!isset($error)){

                                                                        $update=$pdo->prepare("update tbl_product set pname=:pname, pcategory=:pcategory, purchaseprice=:pprice, saleprice=:sprice, pstock=:pstock, pdescription=:pdescription, pimage=:pimage where pid=$id");

                                                                        $update->bindParam(':pname',$productname_txt);
                                                                        $update->bindParam(':pcategory',$category_txt);
                                                                        $update->bindParam(':pprice',$purchaseprice_txt);
                                                                        $update->bindParam(':sprice',$saleprice_txt);
                                                                        $update->bindParam(':pstock',$stock_txt);
                                                                        $update->bindParam(':pdescription',$description_txt);
                                                                        $update->bindParam(':pimage',$f_newfile);

                                                                        if($update->execute()){
                                                                                          
                                                                                echo '<script type="text/javascript">

                                                                                             jQuery(function validation(){

                                                                                                swal({
                                                                                                title: "Updated",
                                                                                                text: "Your Prdouct is  Updated!!",
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
                                                                                                text: "Your Prdouct is not Updated!!",
                                                                                                icon: "warning",
                                                                                                button: "Ok!",
                                                                                                }); 

                                                                                             });

                                                                                             </script>';
                                                                        }


                                                    }
                                            }else{
                                echo '<script type="text/javascript">

                                         jQuery(function validation(){

                                            swal({
                                            title: "FUCK YOU",
                                            text: "Your Prdouct is not added!!",
                                            icon: "warning",
                                            button: "Ok!",
                                            }); 

                                         });

                                         </script>';
                }
                                }
                }else{
                            $error='<script type="text/javascript">

                                  jQuery(function validation(){

                                    swal({
                                    title: "Try Again!",
                                    text: "Only jpg,jpeg,png and gif file can be uploaded!!",
                                    icon: "warning",
                                    button: "Ok!",
                                    }); 

                                 });
                                </script>';
                            echo $error;
                }


    
        
}else{
        
    $update=$pdo->prepare("update tbl_product set pname=:pname, pcategory=:pcategory, purchaseprice=:pprice, saleprice=:sprice, pstock=:pstock, pdescription=:pdescription, pimage=:pimage where pid=$id");
    
        $update->bindParam(':pname',$productname_txt);
        $update->bindParam(':pcategory',$category_txt);
        $update->bindParam(':pprice',$purchaseprice_txt);
        $update->bindParam(':sprice',$saleprice_txt);
        $update->bindParam(':pstock',$stock_txt);
        $update->bindParam(':pdescription',$description_txt);
        $update->bindParam(':pimage',$pimage_db);
        
                    if($update->execute()){
                                    echo '<script type="text/javascript">

                                         jQuery(function validation(){

                                            swal({
                                            title: "Updated",
                                            text: "Your Prdouct is  Updated!!",
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
                                            text: "Your Prdouct is not Updated!!",
                                            icon: "warning",
                                            button: "Ok!",
                                            }); 

                                         });

                                         </script>';
                                }
        
    }
        
        


}


$id=$_GET['id'];
$select=$pdo->prepare("select * from tbl_product where pid=$id");
$select->execute();
$row=$select->fetch(PDO::FETCH_ASSOC);

$id_db=$row['id'];

$productname_db=$row['pname'];
$category_db=$row['pcategory'];
$purchaseprice_db=$row['purchaseprice'];
$saleprice_db=$row['saleprice'];
$pstock_db=$row['pstock'];
$pdescription_db=$row['pdescription'];
$pimage_db=$row['pimage'];


                          
include_once'header.php';

?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Edit Product 
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
              <h3 class="box-title"><a href="productlist.php" class="btn btn-primary" role="button">Back to Product List</a></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="" method="post" name="formproduct" enctype="multipart/form-data">
              <div class="box-body">
                  
                  <div class="col-md-6">
                            <div class="form-group">
                            <label>Product Name</label>
                            <input type="text" class="form-control" name="txt_name" value="<?php echo $productname_db;?>" placeholder="Enter Product Name" required>
                        
                      <div class="form-group">
                            <label>Category</label>
                            <select class="form-control" value="<?php echo $category_db;?>" name="select_option" required>
                            <option value="" disabled selected>Select role</option>
                            
                                <?php
                                     $select=$pdo->prepare("select * from tbl_category order by catid desc");
                                    $select->execute();
                                    while($row=$select->fetch(PDO::FETCH_ASSOC)){
                                        extract($row)
                                    ?>
                                    <option <?php if($row['category']==$category_db){ ?>
                                            
                                             selected="selected"
                                            <?php } ?> >
                                            <?php echo $row['category'];?></option>
                                    <?php
                                            
                                            
                                    }
                                ?>

                            </select>
                        </div>
                      <div class="form-group">
                            <label>Purchase Price</label>
                            <input type="number" min="1" step="1" class="form-control" value="<?php echo $purchaseprice_db;?>" name="txt_pur_price" placeholder="Enter Purchase Price" required>
                        </div>
                      <div class="form-group">
                            <label>Sale Price</label>
                            <input type="number" min="1" step="1" class="form-control" value="<?php echo $saleprice_db;?>"  name="txt_sale_price" placeholder="Enter Sale Price" required>
                        </div>
                      
                      </div>
                            
                      </div>
                      <div class="col-md-6">
                            <div class="form-group">
                            <label>Stock</label>
                            <input type="number" min="1" step="1" class="form-control" value="<?php echo $pstock_db;?>" name="txt_stock" placeholder="Enter Stock of Product" required>
                            </div>
                            
                            <div class="form-group">
                            <label>Description</label>
                            <textarea name="txt_description" class="form-control" placeholder="Enter ......" rows="4"><?php echo $pdescription_db;?></textarea>
                            </div>
                          
                            <div class="form-group">
                                <label>Product Image</label>
                                <img src="productimages/<?php echo $pimage_db; ?>" class="img-responsive" width="60px" height="60px" />
                            <input type="file" class="input-group"  name="myfile" >
                            <p>Upload Product Image</p>
                            </div>
                      </div>
                  
                 </div>
                     <div class="box-footer">
                    
                    
                    <button type="submit" class="btn btn-warning" name="btnupdate">Update Product</button>
                </div>
                 </form>
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

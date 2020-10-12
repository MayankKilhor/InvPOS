 <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


<?php
include_once'connectdb.php';
session_start();

error_reporting(0);
if($_SESSION['useremail']=="" OR $_SESSION['role']=="User"){
    
    header('location:index.php');
}

include_once'header.php';

if(isset($_POST['btnaddproduct'])){
    
    $productname=$_POST['txt_name'];
    $category=$_POST['select_option'];
    $purchaseprice=$_POST['txt_pur_price'];
    $saleprice=$_POST['txt_sale_price'];
    $stock=$_POST['txt_stock'];
    $description=$_POST['txt_description'];
    
    //$f_name=$_FILES['myfile']['name'];
    //$_tmp=$_FILES['myfile']['tmp_name'];
    
    //$f_size=$_FILES['myfile']['size'];
    
    //$f_extension=explode('.',$f_name);
    //$f_extension=strtolower(end($f_extension));
    
    //$f_newfile=uniqid().'.'.$f_extension;
    
    //$store="productimages/".$f_newfile;
    
    $f_name=$_FILES['myfile']['name'];
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
                    $productimage=$f_newfile;
                        if(!isset($error)){
        
                                $insert=$pdo->prepare("insert into tbl_product(pname,pcategory,purchaseprice,saleprice,pstock,pdescription,pimage) values(:pname,:pcategory,:purchaseprice,:saleprice,:pstock,:pdescription,:pimage)");

                                $insert->bindParam(':pname',$productname);
                                $insert->bindParam(':pcategory',$category);
                                $insert->bindParam(':purchaseprice',$purchaseprice);
                                $insert->bindParam(':saleprice',$saleprice);
                                $insert->bindParam(':pstock',$stock);
                                $insert->bindParam(':pdescription',$description);
                                $insert->bindParam(':pimage',$f_newfile);

                                if($insert->execute()){
                                    echo '<script type="text/javascript">

                                         jQuery(function validation(){

                                            swal({
                                            title: "Good job!'.$_SESSION['username'].'",
                                            text: "Your Prdouct is  added!!",
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
                                            text: "Your Prdouct is not added!!",
                                            icon: "warning",
                                            button: "Ok!",
                                            }); 

                                         });

                                         </script>';
                                }
                            }
                    
                    
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
    

    

}



?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) --> 
    <section class="content-header">
      <h1>
        Add Product
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
                    <h3 class="box-title"><a href="productlist.php" class="btn btn-primary" role="button">Back to Product List</a></h3>
                </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form  action="" method="post" name="formproduct" enctype="multipart/form-data">
              <div class="box-body">
                  
                      <div class="col-md-6">
                            <div class="form-group">
                            <label>Product Name</label>
                            <input type="text" class="form-control" name="txt_name" placeholder="Enter Product Name" required>
                        
                      <div class="form-group">
                            <label>Category</label>
                            <select class="form-control" name="select_option" required>
                            <option value="" disabled selected>Select role</option>
                            
                                <?php
                                     $select=$pdo->prepare("select * from tbl_category order by catid desc");
                                    $select->execute();
                                    while($row=$select->fetch(PDO::FETCH_ASSOC)){
                                        extract($row)
                                    ?>
                                    <option><?php echo $row['category'];?></option>
                                    <?php
                                            
                                            
                                    }
                                ?>

                            </select>
                        </div>
                      <div class="form-group">
                            <label>Purchase Price</label>
                            <input type="number" min="1" step="1" class="form-control" name="txt_pur_price" placeholder="Enter Purchase Price" required>
                        </div>
                      <div class="form-group">
                            <label>Sale Price</label>
                            <input type="number" min="1" step="1" class="form-control" name="txt_sale_price" placeholder="Enter Sale Price" required>
                        </div>
                      
                      </div>
                            
                      </div>
                      <div class="col-md-6">
                            <div class="form-group">
                            <label>Stock</label>
                            <input type="number" min="1" step="1" class="form-control" name="txt_stock" placeholder="Enter Stock of Product" required>
                            </div>
                            
                            <div class="form-group">
                            <label>Description</label>
                            <textarea name="txt_description" class="form-control" placeholder="Enter ......" rows="4"></textarea>
                            </div>
                          
                            <div class="form-group">
                            <label>Product Image</label>
                            <input type="file" class="input-group" name="myfile">
                            <p>Upload Product Image</p>
                            </div>
                      </div>
            
                  
                </div>
                <div class="box-footer">
                    
                    
                    <button type="submit" class="btn btn-info" name="btnaddproduct">Add Product</button>
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

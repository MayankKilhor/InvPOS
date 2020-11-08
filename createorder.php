 <link rel="stylesheet" href="bower_components/select2/dist/css/select2.min.css">
 <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<?php
include_once'connectdb.php';
session_start();
error_reporting(0);
if($_SESSION['useremail']=="" ){
    
    header('location:index.php');
}
function fill_product($pdo){
    $output='';
    
    $select=$pdo->prepare("select * from tbl_product order by pname asc"); 
    $select->execute();
    
    $result=$select->fetchAll();
    
    foreach($result as $row){
        $output.='<option value="'.$row["pid"].'">'.$row["pname"].'</option>';
    }
    return $output;
}

if(isset($_POST['btn-saveorder'])){
    $customer_name=$_POST['txt_name'];
    $order_date=date('Y-m-d',strtotime($_POST['orderdate']));
    $subtotal=$_POST['txt_subtotal'];
    $tax=$_POST['txt_tax'];
    $discount=$_POST['txt_discount'];
    $total=$_POST['txt_total'];
    $paid=$_POST['txt_paid'];
    $due=$_POST['txt_due'];
    $payment_type=$_POST['rb'];
    
    $arr_productname=$_POST['productname'];
    $arr_productid=$_POST['productid'];
    $arr_stock=$_POST['stock'];
    $arr_qty=$_POST['quantity'];
    $arr_price=$_POST['price'];
    $arr_total=$_POST['total'];
    
        $insert=$pdo->prepare("insert into tbl_invoice(customer_name,order_date,subtotal,tax,discount,total,paid,due,payment_type) values(:cust,:orderdate,:stotal,:tax,:disc,:total,:paid,:due,:ptype)");
    $insert->bindParam(':cust',$customer_name);
    $insert->bindParam(':orderdate',$order_date);
    $insert->bindParam(':stotal',$subtotal);
    $insert->bindParam(':tax',$tax);
    $insert->bindParam(':disc',$discount);
    $insert->bindParam(':total',$total);
    $insert->bindParam(':paid',$paid);
    $insert->bindParam(':due',$due);
    $insert->bindParam(':ptype',$payment_type);
    
     if($insert->execute()){
             echo '<script type="text/javascript">
         
         jQuery(function validation(){
         
            swal({
            title: "Good job!",
            text: "Order is placed!!",
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
            text: "Order not completed!!",
            icon: "warning",
            button: "Ok!",
            }); 
         
         });
        
         </script>';
        }
    
    $invoice_id=$pdo->lastInsertId();
    if($invoice_id!=null){
        for($i=0; $i<count($arr_productname);$i++){
            
            $rem_qty =$arr_stock[$i]-$arr_qty[$i];
            
            if($rem_qty<0){
                
            }else{
                $update=$pdo->prepare("update tbl_product SET pstock='$rem_qty' where pid='".$arr_productid[$i]."' ");
                $update->execute();
            }
            
            
            
            $insert=$pdo->prepare("insert into tbl_invoice_details(invoice_id,product_id,product_name,quantity,price,order_date) values(:invid,:pid,:pname,:qty,:price,:orderdate)");
            $insert->bindParam(':invid',$invoice_id);
            $insert->bindParam(':pid',$arr_productid[$i]);
            $insert->bindParam(':pname',$arr_productname[$i]);
            $insert->bindParam(':qty',$arr_qty[$i]);
            $insert->bindParam(':price',$arr_price[$i]);
           $insert->bindParam(':orderdate',$order_date);
            
            $insert->execute();

        }
        
        header('location:orderlist.php');
    }
    

}
if( $_SESSION['role']=="User"){
    include_once'headeruser.php';
    
}elseif($_SESSION['role']=="Admin"){
    include_once'header.php';
}


?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Create Order
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
              <h3 class="box-title">New Order</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
    <form  action="" method="post" name="formproduct" enctype="multipart/form-data">
 
            <div class="box-body"><!-- customer form -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Customer Name</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-user"></i>
                              </div>
                        <input type="text" class="form-control" name="txt_name" placeholder="Enter Product Name" required>
                    </div> 
                    </div>    
                
                </div>   
                <div class="col-md-6">
                   
                     <div class="form-group">
                <label>Date:</label>

                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right" id="datepicker" name="orderdate" value="<?php echo date("Y-m-d");?>" data-date-format="yyyy-mm-dd">
                </div>
                <!-- /.input group -->
              </div>  
                </div>
            </div>
                 
            <div class="box-body"><!-- table -->
                <div class="col-md-12">
                    <div style="overflow-x:auto;">
                    <table id="tableproduct" class="table table-striped">
                        <thead>
                            
                        <tr>
<!--                        <th>#</th>-->
                        <th>#</th>
                        <th>Search Product</th>
                        <th>Stock</th>
                        <th>Price</th>
                        <th>Enter Quantity</th>
                        <th>Total</th>
                        <th>
                            <center><button type="button" name="add" class="btn btn-success btn-sm btnadd"><span class="glyphicon glyphicon-plus"></span></button></center>
                            
                        </th>
                        </tr>    
                            
                        </thead> 
                    </table>
        </div>
                
                </div>
            </div>
            <div class="box-body"><!-- discount extra -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Sub Total</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-inr"></i>
                              </div>
                        <input type="text" class="form-control" name="txt_subtotal" id="txt_subtotal" required readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Tax (8%)</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-inr"></i>
                              </div>
                        <input type="text" class="form-control" name="txt_tax" id="txt_tax" required readonly>
                    </div>
                    </div>
                    <div class="form-group">
                        <label>Discount</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-inr"></i>
                              </div>
                        <input type="text" class="form-control" name="txt_discount" id="txt_discount" required>
                    </div>
                    </div>
                
                </div>                                
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Total</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-inr"></i>
                              </div>
                        <input type="text" class="form-control" name="txt_total" id="txt_total" required readonly>
                    </div>
                    </div>
                    <div class="form-group">
                        <label>Paid</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-inr"></i>
                              </div>
                        <input type="text" class="form-control" name="txt_paid" id="txt_paid" required >
                    </div>
                    </div>
                    <div class="form-group">
                        <label>Due</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-inr"></i>
                              </div>
                        <input type="text" class="form-control" name="txt_due" id="txt_due" required readonly>
                    </div>
                    </div>
                    <!-- radio -->
              <div class="form-group">
                <label>
                  <input type="radio" name="rb" class="minimal-red" value="Card" checked> CARD
                </label>
                <label>
                  <input type="radio" name="rb" class="minimal-red" value="Cash"> CASH
                </label>
                <label>
                  <input type="radio" name="rb" class="minimal-red" value="Check"> CHECK
                </label>
              </div>
                </div>

            </div>
        
            <hr>
            <div align="center">
                <input type="submit" name="btn-saveorder" value="Save Order" class="btn btn-info">
        
            </div>
            <br>
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
        
     
        //Date picker
        $('#datepicker').datepicker({
          autoclose: true
        })
        $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
      checkboxClass: 'icheckbox_minimal-red',
      radioClass   : 'iradio_minimal-red'
    })
        
        $(document).ready(function(){
           
            $(document).on('click','.btnadd',function(){
                var html='';
                html+='<tr>';
                html+='<td><input type="hidden" class="form-control pname" name="productname[]" readonly></td>';
                html+='<td><select  class="form-control  productid select2" name="productid[]"><option value="">Select Option</option><?php echo fill_product($pdo); ?></select></td>';
                html+='<td><input type="text" class="form-control stock" name="stock[]" readonly></td>';
                html+='<td><input type="text" class="form-control price" name="price[]" readonly></td>';
                html+='<td><input type="number" min="1" class="form-control quantity" name="quantity[]" required></td>';
                html+='<td><input type="text" class="form-control total" name="total[]" readonly></td>';
                html+='<td><center><button type="button" name="remove" class="btn btn-danger btn-sm btnremove"><span class="glyphicon glyphicon-remove"></span></button></center></td>';
                $('#tableproduct').append(html);
                       //Initialize Select2 Elements
                $(function(){
                     $('.select2').select2()
                })
                
                $(".productid").on('change',function(e){
                    var productid=this.value;
                    var tr=$(this).parent().parent();
                    $.ajax({
                        url:"getproduct.php",
                        methods:"get",
                        data:{id:productid},
                        success:function(data){
                            tr.find(".pname").val(data["pname"]);
                            tr.find(".stock").val(data["pstock"]);
                            tr.find(".price").val(data["saleprice"]);
                            tr.find(".quantity").val(1);
                            tr.find(".total").val(tr.find(".quantity").val() * tr.find(".price").val());
                            calculate(0,0);
                        }
                        
                    })
                })
                
            })
            
            $(document).on('click','.btnremove',function(){
            $(this).closest('tr').remove();
                calculate(0,0);
                $("#txt_paid").val(0);
        });
            $("#tableproduct").delegate(".quantity","keyup change ",function(){
                var quant =$(this);
                var zero=0;
                var tr=$(this).parent().parent();
                if((quant.val()-0)>(tr.find(".stock").val()-0)){
                   swal("WARNING!","This much of quantity not available","warning");
                    quant.val(1);
                    tr.find(".total").val(quant.val() * tr.find(".price").val());
                    calculate(0,0);
                   }else{
                       if((quant.val()-0)>=0){
                         tr.find(".total").val(quant.val() * tr.find(".price").val()); 
                           calculate(0,0);
                       }
                       else{
                           swal("WARNING!","You cannot input Negative value","warning");
                            quant.val(1);
                            tr.find(".total").val(quant.val() * tr.find(".price").val());
                           calculate(0,0);
                       }
                   }
                       
            })
            function calculate(dis,paid){
                var subtotal=0;
                var tax=0;
                var discount=dis;
                var net_total=0;
                var paid_amt=paid;
                var due=0;
                
                $(".total").each(function(){
                    subtotal =subtotal +($(this).val()*1);
                })
                tax=0.08*subtotal; 
                net_total=tax+subtotal;
                net_total=net_total-discount;
                due=net_total-paid_amt;
                
                $("#txt_subtotal").val(subtotal.toFixed(2));
                $("#txt_tax").val(tax.toFixed(2));
                $("#txt_total").val(net_total.toFixed(2));
                $("#txt_discount").val(discount);
                $("#txt_due").val(due.toFixed(2));
                
                $("#txt_discount").keyup(function(){
                    var discount=$(this).val();
//                    if(discount>(tax+subtotal)){
//                   swal("WARNING!","Discount can not be more than total amount","warning");
//                        calculate(0,0);
//                   }else{
                    calculate(discount,0);
                   //}
                })
                
                $("#txt_paid").keyup(function(){
                    var paid=$(this).val();
                    var discount=$("#txt_discount").val();
                    calculate(discount,paid);
                })
            }
            
        });
        
    
        
    </script>


 <?php

include_once'footer.php';

?>

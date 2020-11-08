<?php
include_once'connectdb.php';
session_start();
error_reporting(0);
if($_SESSION['useremail']=="" ){
    
    header('location:index.php');
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
        Graph Report
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
                 <form action="" method="post" name="">
            <div class="box-header with-border">
              <h3 class="box-title">From: <?php echo $_POST['date_1']?> -- To : <?php echo $_POST['date_2'] ?></h3>
            </div>
 
            <!-- /.box-header -->
            <!-- form start -->
            <!-- form  -->
                 
                 
            <div class="box-body">
                         <div class="row">
                
                    <div class="col-md-5">
                            <div class="input-group date">
                              <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                              </div>
                              <input type="text" class="form-control pull-right" id="datepicker1" name="date_1" data-date-format="yyyy-mm-dd">
                            </div>
                </div>
                    
                    <div class="col-md-5">
                    
                        <div class="input-group date">
                          <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                          </div>
                          <input type="text" class="form-control pull-right" id="datepicker2" name="date_2"  data-date-format="yyyy-mm-dd">
                        </div>
                    
                    </div>
                    
                    <div class="col-md-2">
                        
                        <div align="left">
                            <input type="submit" name="btnupdatefilter" value="Filter By Date" class="btn btn-success">

                        </div>
                    
                    </div>
                </div>
                <br>
                <br>
                    <?php
                                $select=$pdo->prepare("select order_date, sum(total) as price from tbl_invoice where order_date between :fromdate AND :todate group by order_date");
                                $select->bindParam(':fromdate',$_POST['date_1']);
                                $select->bindParam(':todate',$_POST['date_2']);
                                $select->execute();
                                $total=[];
                                $date=[];
                                while($row=$select->fetch(PDO::FETCH_ASSOC)){
                                    extract($row);
                                    $total[]=$price;
                                    $date[]=$order_date;
                                }
                  ?>
                <?php
                                $select_pdt=$pdo->prepare("select product_name, sum(quantity) as q from tbl_invoice_details where order_date between :fromdate AND :todate group by product_id");
                                $select_pdt->bindParam(':fromdate',$_POST['date_1']);
                                $select_pdt->bindParam(':todate',$_POST['date_2']);
                                $select_pdt->execute();
                                $pname=[];
                                $qty=[];
                                while($row_pdt=$select_pdt->fetch(PDO::FETCH_ASSOC)){
                                    extract($row_pdt);
                                    $pname[]=$product_name;
                                    $qty[]=$q;
                                }
                    ?>
                <div class="chart">
                         <canvas id="salesgraph" style="height:250px;"></canvas>
                    <br>
                    <br>
                </div>
                
                

                   <div class="chart">
                         <canvas id="bestsellingproduct" style="height:250px;"></canvas>
                </div>
        
        
            </div><!-- table -->
                 </form>
        </div>    
                 
           

    

</section>
</div>
    <script>
          //Date picker
        $('#datepicker1').datepicker({
          autoclose: true
        })
     
        //Date picker
        $('#datepicker2').datepicker({
          autoclose: true
        })
</script>
<script>
    var ctx = document.getElementById('salesgraph').getContext('2d');
var chart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'bar',

    // The data for our dataset
    data: {
        labels: <?php echo json_encode($date); ?>,
        datasets: [{
            label: 'Total earning',
            backgroundColor: 'rgb(255, 99, 132)',
            borderColor: 'rgb(255, 99, 132)',
            data: <?php echo json_encode($total); ?>
        }]
    },

    // Configuration options go here
    options: {}
});
</script>
<script>
    var ctx2 = document.getElementById('bestsellingproduct').getContext('2d');
var chart2 = new Chart(ctx2, {
    // The type of chart we want to create
    type: 'line',

    // The data for our dataset
    data: {
        labels: <?php echo json_encode($pname); ?>,
        datasets: [{
            label: 'Quantity Sold',
            backgroundColor: 'rgb(102, 255, 102)',
            borderColor: 'rgb(0, 102, 0)',
            data: <?php echo json_encode($qty); ?>
        }]
    },

    // Configuration options go here
    options: {}
});
</script>
  <!-- /.content-wrapper -->

 <?php

include_once'footer.php';

?>

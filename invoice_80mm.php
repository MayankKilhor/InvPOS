<?php 

//call the FPDF library
include_once'connectdb.php';
require('fpdf/fpdf.php');

//A4 width: 219mm
//default margin : 10mm each side
//writable horizonttal : 219-(10*2)=189mm

//create pdf object

$pdf = new FPDF('p','mm',array(80,200));

$id=$_GET['id'];
//$id=10;
$select=$pdo->prepare("select * from tbl_invoice where invoice_id=$id");
$select->execute();
$row=$select->fetch(PDO::FETCH_OBJ);

//string orientation (P or L) - portrait or landscape
//String unit (pt,mm,cm an in) - measure unit
//Mixed format (A3, A4, A5, Letter and Legal) - format of pages

//add new page
$pdf->AddPage();


//$pdf->SetFillColor(123,255,234);
$pdf->SetFont('Arial','B',16);
$pdf->Cell(60,8,'InvPOS',1,1,'C');

$pdf->SetFont('Arial','B',8);

$pdf->Cell(60,5,'Address : VIT University, Vellore',0,1,'C');
$pdf->Cell(60,5,'Phone Number : 012-3456-7890',0,1,'C');
$pdf->Cell(60,5,'E-mail Address : mayankkilhor@gmail.com',0,1,'C');
$pdf->Cell(60,5,'Website : invpos.org',0,1,'C');

$pdf->Line(7,38,72,38);
$pdf->Ln(1);

$pdf->SetFont('Arial','BI','8');
$pdf->Cell(20,4,'Bill To:',0,0,'');

$pdf->SetFont('Courier','BI','8');
$pdf->Cell(40,4,$row->customer_name,0,1,'');

$pdf->SetFont('Arial','BI','8');
$pdf->Cell(20,4,'Invoice No.:',0,0,'');

$pdf->SetFont('Courier','BI','8');
$pdf->Cell(40,4,$row->invoice_id,0,1,'');

$pdf->SetFont('Arial','BI','8');
$pdf->Cell(20,4,'Date:',0,0,'');

$pdf->SetFont('Courier','BI','8');
$pdf->Cell(40,4,$row->order_date,0,1,'');

////////
///////Product Table

$pdf->SetX(7);
$pdf->SetFont('Courier','B','8');
$pdf->Cell(34,5,'PRODUCT',1,0,'C');
$pdf->Cell(8,5,'QTY',1,0,'C');
$pdf->Cell(11,5,'PRICE',1,0,'C');
$pdf->Cell(12,5,'TOTAL',1,1,'C');

$select=$pdo->prepare("select *  from tbl_invoice_details where invoice_id=$id");
$select->execute();

while($item=$select->fetch(PDO::FETCH_OBJ)){
    $pdf->SetX(7);
    $pdf->SetFont('Arial','B','8');
    $pdf->Cell(34,5,$item->product_name,1,0,'L');
    $pdf->Cell(8,5,$item->quantity,1,0,'C');
    $pdf->Cell(11,5,$item->price,1,0,'C');
    $pdf->Cell(12,5,$item->quantity * $item->price,1,1,'C');
    
}

///////

$pdf->SetX(7);
$pdf->SetFont('courier','B','8');
$pdf->Cell(20,5,'',0,0,'L');
$pdf->Cell(25,5,'SUBTOTAL',1,0,'C');
$pdf->Cell(20,5,$row->subtotal,1,1,'C');


$pdf->SetX(7);
$pdf->SetFont('courier','B','8');
$pdf->Cell(20,5,'',0,0,'L');
$pdf->Cell(25,5,'DISCOUNT',1,0,'C');
$pdf->Cell(20,5,$row->discount,1,1,'C');

$pdf->SetX(7);
$pdf->SetFont('courier','B','8');
$pdf->Cell(20,5,'',0,0,'L');
$pdf->Cell(25,5,'TAX(8%)',1,0,'C');
$pdf->Cell(20,5,$row->tax,1,1,'C');

$pdf->SetX(7);
$pdf->SetFont('courier','B','10');
$pdf->Cell(20,5,'',0,0,'L');
$pdf->Cell(25,5,'TOTAL',1,0,'C');
$pdf->Cell(20,5,$row->total,1,1,'C');

$pdf->SetX(7);
$pdf->SetFont('courier','B','8');
$pdf->Cell(20,5,'',0,0,'L');
$pdf->Cell(25,5,'PAID',1,0,'C');
$pdf->Cell(20,5,$row->paid,1,1,'C');

$pdf->SetX(7);
$pdf->SetFont('courier','B','8');
$pdf->Cell(20,5,'',0,0,'L');
$pdf->Cell(25,5,'DUE',1,0,'C');
$pdf->Cell(20,5,$row->due,1,1,'C');

$pdf->SetX(7);
$pdf->SetFont('courier','B','8');
$pdf->Cell(20,5,'',0,0,'L');
$pdf->Cell(25,5,'PAYMNET TYPE',1,0,'C');
$pdf->Cell(20,5,$row->payment_type,1,1,'C');



$pdf->Cell(20,5,'',0,1,'');

$pdf->SetX(7);
$pdf->SetFont('Courier','B','8');
$pdf->Cell(25,5,'Important Notice:',0,1,'');

$pdf->SetX(7);
$pdf->SetFont('Arial','','5');
$pdf->Cell(75,5,'No item will be replaced or refunded if you dont have invoice with you. ',0,2,'');

$pdf->SetX(7);
$pdf->SetFont('Arial','','5');
$pdf->Cell(75,5,' You can refund within 2 days of purchase.',0,1,'');




$pdf->Output();


?>
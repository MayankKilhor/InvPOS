<?php 

//call the FPDF library
include_once'connectdb.php';
require('fpdf/fpdf.php');

//A4 width: 219mm
//default margin : 10mm each side
//writable horizonttal : 219-(10*2)=189mm

//create pdf object

$pdf = new FPDF('p','mm','A4');

$id=$_GET['id'];

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
$pdf->Cell(80,10,'InvPOS',0,0,'');

$pdf->SetFont('Arial','',12);
$pdf->Cell(112,10,'INVOICE',0,1,'C');

$pdf->SetFont('Arial','',8);
$pdf->Cell(80,5,'Address : VIT University, Vellore',0,0,'');

$pdf->SetFont('Arial','',12);
$pdf->Cell(112,5,'Invoice : '.$row->invoice_id.'',0,1,'C');

$pdf->SetFont('Arial','',8);
$pdf->Cell(80,5,'Phone Number : 012-3456-7890',0,0,'');

$pdf->SetFont('Arial','',12);
$pdf->Cell(112,5,'Date : 25-12-2020',0,1,'C');

$pdf->SetFont('Arial','',8);
$pdf->Cell(80,5,'E-mail Address : mayankkilhor@gmail.com',0,1,'');
$pdf->Cell(80,5,'Website : invpos.org',0,1,'');

$pdf->Line(5,45,205,45);
$pdf->Line(6,46,204,46);

$pdf->Ln(10);//Line Break

$pdf->SetFont('Arial','BI','12');
$pdf->Cell(20,10,'Bill To:',0,0,'');

$pdf->SetFont('Arial','BI','14');
$pdf->Cell(50,10,$row->customer_name,0,1,'');

$pdf->Cell(50,5,'',0,1,'');

$pdf->SetFont('Arial','B','12');
$pdf->SetFillColor(208,208,208);
$pdf->Cell(90,8,'PRODUCT',1,0,'C',true);
$pdf->Cell(30,8,'QUANTITY',1,0,'C',true);
$pdf->Cell(30,8,'PRICE',1,0,'C',true);
$pdf->Cell(40,8,'TOTAL',1,1,'C',true);

$select=$pdo->prepare("select *  from tbl_invoice_details where invoice_id=$id");
$select->execute();

while($item=$select->fetch(PDO::FETCH_OBJ)){
    $pdf->SetFont('Arial','B','12');
    $pdf->Cell(90,8,$item->product_name,1,0,'L');
    $pdf->Cell(30,8,$item->quantity,1,0,'C');
    $pdf->Cell(30,8,$item->price,1,0,'C');
    $pdf->Cell(40,8,$item->quantity * $item->price,1,1,'C');
    
}




$pdf->SetFont('Arial','B','12');
$pdf->Cell(90,8,'',0,0,'L');
$pdf->Cell(30,8,'',0,0,'C');
$pdf->Cell(30,8,'SubTotal',1,0,'C',true);
$pdf->Cell(40,8,$row->subtotal,1,1,'C');

$pdf->SetFont('Arial','B','12');
$pdf->Cell(90,8,'',0,0,'L');
$pdf->Cell(30,8,'',0,0,'C');
$pdf->Cell(30,8,'Discount',1,0,'C',true);
$pdf->Cell(40,8,$row->discount,1,1,'C');

$pdf->SetFont('Arial','B','12');
$pdf->Cell(90,8,'',0,0,'L');
$pdf->Cell(30,8,'',0,0,'C');
$pdf->Cell(30,8,'Tax',1,0,'C',true);
$pdf->Cell(40,8,$row->tax,1,1,'C');

$pdf->SetFont('Arial','B','14');
$pdf->Cell(90,8,'',0,0,'L');
$pdf->Cell(30,8,'',0,0,'C');
$pdf->Cell(30,8,'Total',1,0,'C',true);
$pdf->Cell(40,8,$row->total,1,1,'C');

$pdf->SetFont('Arial','B','12');
$pdf->Cell(90,8,'',0,0,'L');
$pdf->Cell(30,8,'',0,0,'C');
$pdf->Cell(30,8,'Paid',1,0,'C',true);
$pdf->Cell(40,8,$row->paid,1,1,'C');

$pdf->SetFont('Arial','B','12');
$pdf->Cell(90,8,'',0,0,'L');
$pdf->Cell(30,8,'',0,0,'C');
$pdf->Cell(30,8,'Due',1,0,'C',true);
$pdf->Cell(40,8,$row->due,1,1,'C');

$pdf->SetFont('Arial','B','10');
$pdf->Cell(90,8,'',0,0,'L');
$pdf->Cell(30,8,'',0,0,'C');
$pdf->Cell(30,8,'Payment Type',1,0,'C',true);
$pdf->Cell(40,8,$row->payment_type,1,1,'C');

$pdf->Cell(50,10,'',0,1,'');

$pdf->SetFont('Arial','B','10');
$pdf->Cell(32,10,'Important Notice:',0,0,'',true);

$pdf->SetFont('Arial','','8');
$pdf->Cell(148,10,'No item will be replaced or refunded if you dont have invoice with you. You can refund within 2 days of purchase.',0,0,'',true);
//output the result
$pdf->Output();

?>

<?php
include_once'connectdb.php';
session_start();

$id=$_GET["id"];
$select=$pdo->prepare("select * from tbl_product where pid =:ppid");
$select->bindParam(":ppid",$id);
$select->execute();
$row=$select->fetch(PDO::FETCH_ASSOC);

$response=$row;

header('Content-Type: application/json');

echo json_encode($response);




?>
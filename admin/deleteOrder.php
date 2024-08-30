<?php
require_once("../php/database/sql_connection.php");
$database = new SQLConnect();
$query = $database->connect();
$input = file_get_contents('php://input');
$data = json_decode($input, true);
if (isset($_POST['orderID'])) {
    $order_id = $_POST['orderID'];
    $deleteAction = $query->prepare("DELETE FROM `hoá đơn` WHERE `Mã hoá đơn` = '$order_id'");
    if($deleteAction->execute()){
        echo json_encode("success");
        exit();
    }
    else{
        echo json_encode("error sql");
    }
}
else{
    echo json_encode("error request");
}
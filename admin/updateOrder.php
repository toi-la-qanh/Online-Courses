<?php
require_once("../php/database/sql_connection.php");
$database = new SQLConnect();
$query = $database->connect();
$input = file_get_contents('php://input');
$data = json_decode($input, true);
if (isset($_POST['orderID']) && isset($_POST['status'])) {
    $order_id = $_POST['orderID'];
    $status = $_POST['status'];
    $updateOrder = $query->prepare("UPDATE `hoá đơn` SET `Tình trạng` = '$status' 
    WHERE `Mã hoá đơn` = '$order_id'");
    $updateOrder->execute();
    if ($query->exec("UPDATE `thông báo` SET `Đếm thứ ba` = `Đếm thứ ba` + 1")) {
        echo json_encode("success");
        exit();
    } else {
        echo json_encode("cant update notifi");
    }

} else {
    echo json_encode("error request");
}
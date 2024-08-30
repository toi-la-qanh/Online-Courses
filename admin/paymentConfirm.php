<?php
// header('Content-Type: application/json');
require_once("../php/database/sql_connection.php");
$database = new SQLConnect();
$query = $database->connect();
$input = file_get_contents('php://input');
$data = json_decode($input, true);
if (isset($data['user_id']) && isset($data['course_id'])) {
    $user_id = $data['user_id'];
    $course_id = $data['course_id'];
    $check = $query->prepare("SELECT * FROM `hoá đơn` WHERE `Mã người dùng` = '$user_id' 
    AND `Mã khoá học` = '$course_id'");
    $check->execute();
    if ($check->rowCount() > 0) {
        echo json_encode('order had been inserted, please wait !');
        exit();
    }
    $insertInvoice = $query->prepare("INSERT INTO `hoá đơn`(`Mã người dùng`, `Mã khoá học`) VALUES( 
    :user, :course)");
    $insertInvoice->bindParam(':user', $user_id);
    $insertInvoice->bindParam(':course', $course_id);
    if ($insertInvoice->execute()) {
        echo json_encode('successfull');
        $query->exec("UPDATE `thông báo` SET `Đếm thứ nhất` = `Đếm thứ nhất` + 1");
        exit();
    } else {
        echo json_encode('fail to insert payment');
    }
} else {
    echo json_encode('no input found');
}
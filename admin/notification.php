<?php
header('Content-Type: application/json');
require_once("../php/database/sql_connection.php");
$database = new SQLConnect();
$query = $database->connect();
$getNotification = $query->prepare("SELECT * FROM `thông báo`");
$getNotification->execute();
if ($getNotification->rowCount() > 0) {
    $notify = $getNotification->fetch();
    $response['countFirst'] = $notify['Đếm thứ nhất'];
    $response['countSecond'] = $notify['Đếm thứ hai'];
    echo json_encode($response);
    if($notify['Đếm thứ hai'] < $notify['Đếm thứ nhất']){
        $query->exec("UPDATE `thông báo` SET `Đếm thứ hai` = `Đếm thứ nhất`");
    }
}
else{
    echo json_encode('error');
}
<?php
header('Content-Type: application/json');
require_once("../database/sql_connection.php");
$database = new SQLConnect();
$query = $database->connect();
$getNotification = $query->prepare("SELECT * FROM `thông báo`");
$getNotification->execute();
if ($getNotification->rowCount() > 0) {
    $notify = $getNotification->fetch();
    $response['countThird'] = $notify['Đếm thứ ba'];
    $response['countFourth'] = $notify['Đếm thứ tư'];
    echo json_encode($response);
    if($notify['Đếm thứ tư'] < $notify['Đếm thứ ba']){
        $query->exec("UPDATE `thông báo` SET `Đếm thứ tư` = `Đếm thứ ba`");
    }
}
else{
    echo json_encode('error');
}
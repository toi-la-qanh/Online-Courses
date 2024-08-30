<?php
require_once("sql_connection.php");
$database = new SQLConnect();
$query = $database->connect();
$input = file_get_contents('php://input');
$data = json_decode($input, true);
if(isset($data['userID'])&&isset($data['courseID'])&&isset($data['progress'])){
    $course_id = $data['courseID'];
    $user_id = $data['userID'];
    $progress = $data['progress'];
    $updateProgress = $query->prepare("UPDATE `khoá học đã mua` SET `Tiến trình` = '$progress'
    WHERE `Mã người dùng` = '$user_id' AND `Mã khoá học` = '$course_id'");
    if($updateProgress->execute()){
        echo json_encode("success");
    }
    else{
        echo json_encode("error sql");
    }
}
else{
    echo json_encode("error request");
}
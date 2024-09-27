<?php
require_once("sql_connection.php");
$database = new SQLConnect();
$query = $database->connect();
$input = file_get_contents('php://input');
$data = json_decode($input, true);
if (isset($data['star']) && isset($data['comment']) && $data['user_id'] && $data['course_id']) {
    $star = $data['star'];
    $comment = $data['comment'];
    $user_id = $data['user_id'];
    $course_id = $data['course_id'];
    $insertComment = $query->prepare("INSERT INTO `bình luận`
    (`Mã người dùng`, `Mã khoá học`,`Nội dung`, `Số sao`) VALUES(:user,:course,:comment, :star)");
    $insertComment->bindParam(':user', $user_id);
    $insertComment->bindParam(':course', $course_id);
    $insertComment->bindParam(':comment', $comment);
    $insertComment->bindParam(':star', $star);
    // $insertComment->execute();
    if ($insertComment->execute()) {
        echo json_encode("success");
        exit();
    } else
        echo json_encode("error sql");
} else {
    echo json_encode("error method data");
}
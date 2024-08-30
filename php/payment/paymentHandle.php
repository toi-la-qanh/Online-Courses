<?php
require_once("../database/sql_connection.php");
$database = new SQLConnect();
$query = $database->connect();
$input = file_get_contents('php://input');
$data = json_decode($input, true);
if (isset($data['courseID'])) {
    $courseID = $data['courseID'];
    $getCourses = $query->prepare("SELECT * FROM `khoá học` WHERE `Mã khoá học` = '$courseID'");
    $getCourses->execute();

    while ($courses = $getCourses->fetch()) {
        $categories = $courses['Mã phân loại'];
        $getCategories = $query->prepare("SELECT * FROM `phân loại` WHERE `Mã phân loại` = '$categories'");
        $getCategories->execute();
        $category = $getCategories->fetch();
        $info = array();
        $info['name'] = $courses['Tiêu đề'];
        $info['price'] = $courses['Đơn giá'];
        $info['category'] = $category['Tên'];
        $info['image'] = $courses['Hình ảnh'];
        $info['id'] = $courses['Mã khoá học'];
        echo json_encode($info);
    }
}
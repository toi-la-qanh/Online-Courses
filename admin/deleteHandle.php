<?php
// Xoá sản phẩm
require_once("../php/database/sql_connection.php");
$database = new SQLConnect();
$query = $database->connect();
$input = file_get_contents('php://input');
$data = json_decode($input, true);
if (isset($_POST['courseID'])) {
    $productId = $_POST['courseID'];
	$deleteProduct = $query->prepare("DELETE FROM `khoá học` WHERE `Mã khoá học` = :product_id");
	$deleteProduct->bindParam(':product_id', $productId);
	if ($deleteProduct->execute()) {
		echo json_encode("success delete");
		// exit();
	} else {
		echo json_encode("delete fail");
	}
}
else{
    echo json_encode("error request method");
}
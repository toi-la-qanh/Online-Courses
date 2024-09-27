<?php
require_once("sql_connection.php");
$database = new SQLConnect();
$query = $database->connect();

// Get data from POST request
if (isset($_POST['userID']) && isset($_POST['name']) && isset($_POST['phone']) && isset($_POST['email']) && isset($_POST['address'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $user_id = $_POST['userID'];

    // Prepare and execute the SQL query
    $saveInfo = $query->prepare("UPDATE `người dùng` SET `Tên` = :name, `Email` = :email, `Số điện thoại` = :phone, `Địa chỉ` = :address WHERE `Mã người dùng` = :userID");
    $saveInfo->bindParam(':name', $name);
    $saveInfo->bindParam(':email', $email);
    $saveInfo->bindParam(':phone', $phone);
    $saveInfo->bindParam(':address', $address);
    $saveInfo->bindParam(':userID', $user_id);

    if ($saveInfo->execute()) {
        echo json_encode("success");
    } else {
        echo json_encode("error sql");
    }
} else {
    echo json_encode("error method request !");
}
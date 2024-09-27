<?php
require_once("../../database/sql_connection.php");
$database = new SQLConnect();
$query = $database->connect();
$error = array();
$status = 400;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = $_POST['email'];
  $checkEmail = $query->prepare("SELECT * FROM `người dùng` WHERE `Email` = :email");
  $checkEmail->bindParam(':email', $email);
  $checkEmail->execute();
  if ($checkEmail->rowCount() == 0) {
    $error['email'] = "Email không tồn tại !";
    $status = 422;
  } else {
    $user = $checkEmail->fetch();
    if (!password_verify($_POST['password'], $user['Mật khẩu'])) {
      $error['password'] = "Mật khẩu không đúng !";
      $status = 422;
    }
  }
  if (!$error) {
    session_start();
    $_SESSION['user_id'] = $user['Mã người dùng'];
    $status = 200;
    if ($user['Phân loại'] == "Quản trị viên")
      $error['account'] = 'admin';
  }
  header('Content-Type: application/json');
  $response = ['status' => $status, 'errors' => $error];
  echo json_encode($response);
}
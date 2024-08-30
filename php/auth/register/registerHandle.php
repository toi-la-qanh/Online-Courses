<?php
require_once("../../database/sql_connection.php");
$database = new SQLConnect();
$query = $database->connect();
$error = array();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = $_POST['email'];
  $name = $_POST['name'];
  $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

  if (!preg_match('/^[\p{L}\s]+$/u', $name)) {
    $error['name'] = "Tên không hợp lệ !";
    $status = 422;
  }
  if (!preg_match('/^[^\s@]+@[^\s@]+\.[^\s@]+$/', $email)) {
    $error['email'] = "Email không hợp lệ !";
    $status = 422;
  }
  if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/', $_POST['password'])) {
    $error['password'] = "Mật khẩu không hợp lệ !";
    $status = 422;
  }
  if ($_POST['password'] != $_POST['Cpassword']) {
    $error['Cpassword'] = "Mật khẩu nhập lại không trùng khớp !";
    $status = 422;
  }
  $check = $query->prepare("SELECT * FROM `người dùng` WHERE `Email` = :email");
  $check->bindParam(':email', $email);
  $check->execute();
  if ($check->rowCount() > 0) {
    $error['email'] = "Email này đã được đăng ký !";
    $status = 422;
  }
  $insert = $query->prepare("INSERT INTO `người dùng`(`Tên`, `Email`, `Mật khẩu`) VALUES(:name, :email, :password)");
  $insert->bindParam(':name', $name);
  $insert->bindParam(':email', $email);
  $insert->bindParam(':password', $password);
  if (!$error) {
    $insert->execute();
    $status = 200;
  }
  $response = array('status' => $status, 'errors' => $error);
  header('Content-Type: application/json');
  echo json_encode($response);
}
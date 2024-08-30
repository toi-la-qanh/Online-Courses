<?php
require_once("../php/database/sql_connection.php");
session_start();
$user_id = $_SESSION['user_id'];
$database = new SQLConnect();
$query = $database->connect();
$check = $query->prepare("SELECT * FROM `người dùng` WHERE `Mã người dùng` = '$user_id' AND`Phân loại` = 'Quản trị viên'");
$check->execute();
if($check->rowCount()==0) {
	session_unset();
	session_destroy();
	header("location:../php/index.php");
}
if ($_SERVER["REQUEST_METHOD"] == "POST"){
	session_unset();
	session_destroy();
	header("location:../php/index.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Quản trị viên</title>
    <link rel="stylesheet" type="text/css" href="css/admin.css">
	<link rel="stylesheet" href="../css/style.css">
</head>
<body>
<div id="message"></div>
	<header>
		<img src="../images/logo.png" alt="Logo" id="logo">
		<h1>Quản Trị Viên</h1>
	</header>
	<nav>
		<ul>
			<li><a href="admin1.php" onclick="showProductsManagement()">Quản lý mặt hàng</a></li>
			<li><a href="admin2.php" onclick="showOrdersManagement()">Quản lý đơn hàng</a></li>
			<li><a href="admin3.php" onclick="showInstructionsManagement()">Hướng dẫn cho quản trị viên</a></li>
		</ul>
	</nav>
	
	<div id="content">
		<h2>Chào mừng bạn đến với trang Quản Trị Viên!</h2>
		<p>Vui lòng chọn một trong các tùy chọn trên để bắt đầu quản lý.</p>
	</div>
	<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

	<button>Đăng xuất</button></form>
    <script src="js/admin.js"></script>
</body>
</html>
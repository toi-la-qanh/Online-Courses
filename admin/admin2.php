<?php
require_once("../php/database/sql_connection.php");
session_start();
$user_id = $_SESSION['user_id'];
$database = new SQLConnect();
$query = $database->connect();
$check = $query->prepare("SELECT * FROM `người dùng` WHERE `Mã người dùng` = '$user_id' 
AND `Phân loại` = 'Quản trị viên'");
$check->execute();
if ($check->rowCount() == 0) {
	session_unset();
	session_destroy();
	header("location:../php/index.php");
}
if ($_SERVER['REQUEST_METHOD'] === "POST") {
	$order_id = $_POST['order-id'];
	$course_name = $_POST['course-name'];
	$email = $_POST['email'];
	$order_status = $_POST['edit-order-status'];
	$getCourse = $query->prepare("SELECT * FROM `khoá học` WHERE `Tiêu đề` = '$course_name'");
	$getCourse->execute();
	$course = $getCourse->fetch();
	$course_id = $course['Mã khoá học'];
	$getUser = $query->prepare("SELECT * FROM `người dùng` WHERE `Email` = '$email'");
	$getUser->execute();
	$user = $getUser->fetch();
	$user_id = $user['Mã người dùng'];
	$query->exec("UPDATE `hoá đơn` SET `Tình trạng` = '$order_status' WHERE `Mã hoá đơn` = '$order_id' AND 
	`Mã người dùng` = '$user_id' AND `Mã khoá học` = '$course_id'");
	if ($order_status == 'Đã thanh toán') {
		$query->exec("INSERT INTO `khoá học đã mua`(`Mã người dùng`, `Mã khoá học`) 
	VALUES('$user_id', '$course_id')");
	}
}
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Quản lý đơn hàng</title>
	<link rel="stylesheet" type="text/css" href="css/admin.css">
	<link rel="stylesheet" href="../fontawesome-free-6.6.0-web/css/all.css">
	<script src="https://code.jquery.com/jquery-3.4.1.js"></script>
	<script src="js/admin.js"></script>
	<script src="js/admin2.js"></script>
</head>

<body>
	<div id="message"></div>
	<header>
		<img src="../images/logo.png" alt="Logo" id="logo">
		<h1>Quản lý đơn hàng</h1>
	</header>
	<nav>
		<ul>
			<li><a href="admin1.php">Quản lý mặt hàng</a></li>
			<li><a href="admin.php">Trang chủ</a></li>
			<li><a href="admin3.php">Hướng dẫn cho quản trị viên</a></li>
		</ul>
	</nav>
	<h2>Danh sách đơn hàng</h2>

	<table id="order-table">
		<thead>
			<tr>
				<th>Mã đơn hàng</th>
				<th>Tên khoá học</th>
				<th>Tên khách hàng</th>
				<th>E-mail</th>
				<th>Tình trạng đơn hàng</th>
				<th>Chỉnh sửa</th>
			</tr>
		</thead>
		<tbody id="order-list">
			<?php
			$getInvoice = $query->prepare("SELECT * FROM `hoá đơn` ORDER BY CASE 
			WHEN `Tình trạng` = 'Chưa thanh toán' THEN 0 ELSE 1 END ASC");
			$getInvoice->execute();
			?>

			<?php
			if ($getInvoice->rowCount() > 0) {
				while ($invoices = $getInvoice->fetch()) {
					$userInvoice = $invoices['Mã người dùng'];
					$getUser = $query->prepare("SELECT * FROM `người dùng` WHERE 
					`Mã người dùng` = '$userInvoice'");
					$getUser->execute();
					$user = $getUser->fetch();
					$courseInvoice = $invoices['Mã khoá học'];
					$getCourse = $query->prepare("SELECT * FROM `khoá học` WHERE 
					`Mã khoá học` = '$courseInvoice'");
					$getCourse->execute();
					$course = $getCourse->fetch();
					?>
					<tr>
						<td><?php echo $invoices['Mã hoá đơn']; ?></td>
						<td><?php echo $course['Tiêu đề']; ?></td>
						<td><?php echo $user['Tên']; ?></td>
						<td><?php echo $user['Email']; ?></td>
						<td><?php echo $invoices['Tình trạng']; ?></td>
						<td>
							<button class="edit-btn" invoice-id="<?php echo $invoices['Mã hoá đơn']; ?>"
								onclick="editOrder(this)">Sửa</button>
							<button class="delete-btn" invoice-id="<?php echo $invoices['Mã hoá đơn']; ?>"
								onclick="DeleteOrder(this)">Xoá</button>
						</td>
					</tr>
				<?php }
			} else {
				?>
				<td>Chưa có đơn hàng nào để hiển thị</td>
			<?php } ?>

		</tbody>
	</table>

	<!-- Popup box -->
	<!-- <div class="popup_box" id="popup_box">
		<i class="fas fa-exclamation"></i>
		<br />
		<h1>Bạn chắc muốn xoá đơn hàng này!</h1>
		<br />
		<label>Bạn có chắc chắn tiếp tục không?</label>
		<div class="btns">
			<a href="#" id="btn1" class="btn1">Không</a>
			<a href="#" id="btn2" class="btn2">Xoá</a>
		</div>
	</div> -->

	<div class="popup_box_tt" id="popup_box_tt">
		<i class="fas fa-exclamation tt"></i>
		<br />
		<h1>Mã đơn hàng đã tồn tại!</h1>
		<br />
		<label>Vui lòng nhập mã đơn hàng khác!</label>
		<div class="btns">
			<a href="#" id="ok-btn" class="btn2">Đồng ý</a>
		</div>
	</div>

	<div class="edit-dialog" id="edit-dialog">
		<h1>Chỉnh sửa đơn hàng</h1>
		<form method="post">
			<label for="edit-order-id">Mã đơn hàng:</label>
			<input type="text" id="edit-order-id" name="order-id"><br><br>
			<label for="edit-customer-name">Tên khoá học:</label>
			<input type="text" id="edit-course-name" name="course-name"><br><br>
			<label for="edit-customer-name">Tên khách hàng:</label>
			<input type="text" id="edit-customer-name" name="edit-customer-name"><br><br>
			<label for="edit-email">E-mail:</label>
			<input type="email" id="edit-email" name="email"><br><br>
			<label for="edit-order-status">Tình trạng đơn hàng:</label>
			<select id="edit-order-status" name="edit-order-status">
				<option>Cập nhật tình trạng</option>
				<option value="Chưa thanh toán">Chưa thanh toán</option>
				<option value="Đã thanh toán">Đã thanh toán</option>
			</select><br><br>
			<button id="save-edit-btn" onclick="SaveChange()">Lưu thay đổi</button>

		</form>
		<button id="cancel-edit-btn" onclick="Cancel()">Hủy</button>
	</div>

	<!-- <div id="add-order-form">
		<h3>Thêm đơn hàng mới:</h3>
		<form>
			<label for="order-id">Mã đơn hàng:</label>
			<input type="text" id="order-id" name="order-id"><br><br>
			<label for="customer-name">Tên khách hàng:</label>
			<input type="text" id="customer-name" name="customer-name"><br><br>
			<label for="phone-number">Số điện thoại:</label>
			<input type="text" id="phone-number" name="phone-number"><br><br>
			<label for="email">E-mail:</label>
			<input type="email" id="email" name="email"><br><br>
			<label for="order-status">Tình trạng đơn hàng:</label>
			<select id="order-status" name="order-status">
				<option value="chua-thanh-toan">Chưa thanh toán</option>
				<option value="da-thanh-toan">Đã thanh toán</option>
			</select><br><br>
			<button type="submit" id="add-order-btn">Thêm đơn hàng mới</button>
		</form>
	</div> -->
</body>

</html>
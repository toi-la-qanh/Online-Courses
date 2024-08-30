<?php
require_once("../php/database/sql_connection.php");
session_start();

$user_id = $_SESSION['user_id'];
$database = new SQLConnect();
$query = $database->connect();

$check = $query->prepare("SELECT * FROM `người dùng` WHERE `Mã người dùng` = :user_id AND `Phân loại` = 'Quản trị viên'");
$check->bindParam(':user_id', $user_id);
$check->execute();

if ($check->rowCount() == 0) {
	session_unset();
	session_destroy();
	header("location:../php/index.php");
	exit();
}

// Thêm sản phẩm mới
if (isset($_POST['add-product'])) {
	$productName = $_POST['product-name'];
	$categoryName = $_POST['category-name'];
	$productPrice = $_POST['product-price'];

	try {
		// Kiểm tra mã sản phẩm đã tồn tại hay chưa
		// $checkProduct = $query->prepare("SELECT * FROM `khoá học` WHERE `Mã khoá học` = :product_id");
		// $checkProduct->bindParam(':product_id', $productId);
		// $checkProduct->execute();

		// if ($checkProduct->fetchColumn() > 0) {
		// 	echo "duplicate";
		// 	exit();
		// }
		$getCategories = $query->prepare("SELECT * FROM `phân loại` WHERE `Tên` = '$categoryName'");
		$getCategories->execute();
		$category = $getCategories->fetch();
		$categoryID = $category['Mã phân loại'];
		$productName = $_POST['product-name'];
		$productPrice = $_POST['product-price'];
		$description = $_POST['product-description'];
		$duration = $_POST['product-duration'];
		$introLink = $_POST['product-intro-link'];
		$courselink = $_POST['product-course-link'];
		$images = $_FILES['product-image'];
		$filename = $images['name'];
		$filetemp = $images['tmp_name'];

		// Thực hiện thêm sản phẩm
		$addProduct = $query->prepare("INSERT INTO `khoá học` (`Tiêu đề`, `Hình ảnh`, `Đơn giá`, `Mã phân loại`, `Mô tả`, `Thời lượng`, `Đường dẫn giới thiệu khoá học`, `Đường dẫn khoá học`) VALUES (:product_name, '$filename', :product_price, :category_id, :product_description, :product_duration, :product_intro_link, :product_course_link)");
		$addProduct->bindParam(':product_name', $productName);
		$folder = "../images/";

		if (move_uploaded_file($filetemp, $folder . $filename)) {
			echo "thanh cong";
		} else {
			print_r($_FILES);
		}


		$addProduct->bindParam(':category_id', $categoryID);
		$addProduct->bindParam(':product_price', $productPrice);
		$addProduct->bindParam(':product_description', $description);
		$addProduct->bindParam(':product_duration', $duration);
		$addProduct->bindParam(':product_intro_link', $introLink);
		$addProduct->bindParam(':product_course_link', $courselink);
		$addProduct->execute();

		// if () {
		//     echo "success";
		// } else {
		//     echo "error";
		// }
	} catch (PDOException $e) {
		echo "error" . $e;
	}
	exit();
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Quản lý khoá học</title>
	<link rel="stylesheet" type="text/css" href="css/admin.css">
	<link rel="stylesheet" href="../fontawesome-free-6.6.0-web/css/all.css">
	<script src="../js/jquery.js"></script>
	<script src="js/admin.js"></script>
</head>

<body>
	<div id="message"></div>
	<header>
		<img src="../images/logo.png" alt="Logo" id="logo">
		<h1>Quản lý khoá học</h1>
	</header>
	<nav>
		<ul>
			<li><a href="admin2.php">Quản lý đơn hàng</a></li>
			<li><a href="admin.php">Trang chủ</a></li>
			<li><a href="admin3.php">Hướng dẫn cho quản trị viên</a></li>
		</ul>
	</nav>

	<h2>Danh sách khoá học</h2>
	<button onclick="showInsert()">Thêm sản phẩm</button>
	<table id="product-table">
		<thead>
			<tr>
				<th>Phân loại</th>
				<th>Mã sản phẩm</th>
				<th>Tên sản phẩm</th>
				<th>Hình ảnh</th>
				<th>Giá sản phẩm</th>
				<th>Lượt mua</th>
				<th>Mô tả</th>
				<th>Thời lượng</th>
				<th>Đường dẫn giới thiệu khoá học</th>
				<th>Đường dẫn khoá học</th>
				<th>Ngày tạo</th>
				<th>Ngày cập nhật</th>
				<th>Chỉnh sửa</th>
			</tr>
		</thead>
		<tbody id="product-list">
			<?php
			$stmt = $query->prepare("SELECT * FROM `khoá học`");
			$stmt->execute();
			if ($stmt->rowCount() > 0) {
				while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
					$categoryID = $row['Mã phân loại'];
					$getCategories = $query->prepare("SELECT * FROM `phân loại` WHERE `Mã phân loại` = '$categoryID'");
					$getCategories->execute();
					$categories = $getCategories->fetch();
					echo "<tr>";
					echo "<td>" . $categories['Tên'] . "</td>";
					// echo "<td data-code='{$row['Mã khoá học']}'></td>";
					echo "<td>{$row['Mã khoá học']}</td>";
					echo "<td>{$row['Tiêu đề']}</td>";
					echo "<td><img src='../images/" . $row['Hình ảnh'] . "'></td>";
					echo "<td>" . number_format($row['Đơn giá'], 0, '.', '.') . ' đồng' . "</td>";
					echo "<td>{$row['Lượt mua']}</td>";
					echo "<td>{$row['Mô tả']}</td>";
					echo "<td>{$row['Thời lượng']}</td>";
					echo "<td>{$row['Đường dẫn giới thiệu khoá học']}</td>";
					echo "<td>{$row['Đường dẫn khoá học']}</td>";
					echo "<td>{$row['Ngày tạo']}</td>";
					echo "<td>{$row['Ngày cập nhật']}</td>";
					echo "<td>
                        <button class='edit-btn' id='update-course' course-id='{$row['Mã khoá học']}'>Sửa</button>
                        <button class='delete-btn' id='delete-course' course-id='{$row['Mã khoá học']}' onclick='DeleteCourse(this)'>Xoá</button>
                      </td>";
					echo "</tr>";
				}
			} else {
				echo "noo";
			}
			?>
		</tbody>
	</table>

	<!-- Popup box -->
	<div class="popup_box" id="popup_box">
		<i class="fas fa-exclamation"></i>
		<br />
		<h1>Bạn chắc muốn xoá khoá học này!</h1>
		<br />
		<label>Bạn có chắc chắn tiếp tục không?</label>
		<div class="btns">
			<a href="#" id="btn1" class="btn1">Không</a>
			<a href="#" id="btn2" class="btn2">Xoá</a>
		</div>
	</div>

	<div class="popup_box_tt" id="popup_box_tt">
		<i class="fas fa-exclamation tt"></i>
		<br />
		<h1>Mã sản phẩm đã tồn tại!</h1>
		<br />
		<label>Vui lòng nhập mã sản phẩm khác!</label>
		<div class="btns">
			<a href="#" id="ok-btn" class="btn2">Đồng ý</a>
		</div>
	</div>

	<!-- Chỉnh sửa sản phẩm -->
	<div class="edit-dialog" id="edit-dialog">
		<h1>Chỉnh sửa sản phẩm</h1>
		<form method="post" enctype="multipart/form-data" id="edit-product-form">
			<input type="hidden" id="edit-product-id" name="edit-product-id">
			<label for="edit-product-name">Tên sản phẩm:</label>
			<input type="text" id="edit-product-name" name="edit-product-name"><br><br>

			<label for="edit-product-price">Giá sản phẩm:</label>
			<input type="number" id="edit-product-price" name="edit-product-price" min="0"><br><br>

			<label for="edit-product-category">Phân loại:</label>
			<input type="text" id="edit-product-category" name="edit-product-category"><br><br>

			<label for="edit-product-image">Hình ảnh:</label>
			<input type="file" id="product-image" name="product-image" accept="images/*"><br><br>

			<label for="edit-product-description">Mô tả:</label>
			<input type="text" id="edit-product-description" name="edit-product-description"></input><br><br>

			<label for="edit-product-duration">Thời lượng:</label>
			<input type="text" id="edit-product-duration" name="edit-product-duration"><br><br>

			<label for="edit-product-intro-link">Đường dẫn giới thiệu:</label>
			<input type="text" id="edit-product-intro-link" name="edit-product-intro-link"><br><br>

			<label for="edit-product-course-link">Đường dẫn khoá học:</label>
			<input type="text" id="edit-product-course-link" name="edit-product-course-link"><br><br>
			
			<button id="save-edit-btn">Lưu thay đổi</button>
		</form>
		<button id="cancel-edit-btn" onclick="Cancel()">Hủy</button>
	</div>

	<div class="add-dialog" id="add-dialog">
		<h3>Thêm khoá học mới:</h3>
		<form id="add-product-form" method="post" enctype="multipart/form-data">
			<label for="product-name">Tên sản phẩm:</label>
			<input type="text" id="product-name" name="product-name"><br><br>

			<label for="category-name">Tên phân loại:</label>
			<input type="text" id="category-name" name="category-name"><br><br>

			<label for="product-image">Hình ảnh:</label>
			<input type="file" id="product-image" name="product-image" accept="images/*"><br><br>

			<label for="product-price">Giá sản phẩm:</label>
			<input type="number" id="product-price" name="product-price" min="0"><br><br>

			<label for="product-description">Mô tả:</label>
			<input type="text" id="product-description" name="product-description"></input><br><br>

			<label for="product-duration">Thời lượng:</label>
			<input type="text" id="product-duration" name="product-duration"><br><br>

			<label for="product-intro-link">Đường dẫn giới thiệu khoá học:</label>
			<input type="text" id="product-intro-link" name="product-intro-link"><br><br>

			<label for="product-course-link">Đường dẫn khoá học:</label>
			<input type="text" id="product-course-link" name="product-course-link"><br><br>

			<button type="submit" name="add-product">Thêm sản phẩm mới</button>
			
		</form>
		<button type="submit" name="cancel-add-product"  onclick="Cancel()">Huỷ</button>
	</div>
	<script src="js/admin1.js"></script>
</body>

</html>
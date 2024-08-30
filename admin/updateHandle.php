<?php
// Xoá sản phẩm
require_once("../php/database/sql_connection.php");
$database = new SQLConnect();
$query = $database->connect();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate input
    $productId = filter_input(INPUT_POST, 'edit-product-id', FILTER_SANITIZE_NUMBER_INT);
    $productName = filter_input(INPUT_POST, 'edit-product-name', FILTER_SANITIZE_STRING);
    $productPrice = filter_input(INPUT_POST, 'edit-product-price', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $categoryName = filter_input(INPUT_POST, 'edit-product-category', FILTER_SANITIZE_STRING);
    $description = filter_input(INPUT_POST, 'edit-product-description', FILTER_SANITIZE_STRING);
    $duration = filter_input(INPUT_POST, 'edit-product-duration', FILTER_SANITIZE_STRING);
    $introLink = filter_input(INPUT_POST, 'edit-product-intro-link', FILTER_SANITIZE_URL);
    $courseLink = filter_input(INPUT_POST, 'edit-product-course-link', FILTER_SANITIZE_URL);
    
    // Handle file upload
    if (isset($_FILES['product-image']) && $_FILES['product-image']['error'] === UPLOAD_ERR_OK) {
        $images = $_FILES['product-image'];
        $filename = basename($images['name']); // Use basename to avoid directory traversal attacks
        $filetemp = $images['tmp_name'];
        $folder = "../images/";
        
        // Validate the file
        $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif']; // Define allowed MIME types
        if (!in_array($images['type'], $allowedMimeTypes)) {
            echo json_encode("Invalid file type");
            exit();
        }
        
        // Move uploaded file
        if (!move_uploaded_file($filetemp, $folder . $filename)) {
            echo json_encode("Failed to move image");
            exit();
        }
    } else {
        // Handle the case when no file is uploaded or an error occurs
        $filename = null; // or handle it based on your application needs
    }

    try {
        // Prepare SQL statement with placeholders for values
        $edit = $query->prepare("UPDATE `khoá học` SET 
            `Tiêu đề` = :product_name, 
            `Đơn giá` = :product_price, 
            `Mô tả` = :product_description, 
            `Thời lượng` = :product_duration, 
            `Đường dẫn giới thiệu khoá học` = :product_intro_link, 
            `Đường dẫn khoá học` = :product_course_link, 
            `Hình ảnh` = :filename  
            WHERE `Mã khoá học` = :product_id");
            // `Phân Loại` = :category_name, 
		
		$getCategory = $query->prepare("SELECT * FROM `khoá học` WHERE `Mã khoá học` = '$productId'");
		$getCategory->execute();
		$category = $getCategory->fetch();
		$categoryID = $category['Mã phân loại'];
		$updateCategory = $query->prepare("UPDATE `phân loại` SET `Tên` = '$categoryName' 
		WHERE `Mã phân loại` = '$categoryID'");
        // Bind parameters
        $edit->bindParam(':product_id', $productId, PDO::PARAM_INT);
        $edit->bindParam(':product_name', $productName);
        $edit->bindParam(':product_price', $productPrice, PDO::PARAM_STR);
        $edit->bindParam(':product_description', $description);
        $edit->bindParam(':product_duration', $duration);
        $edit->bindParam(':product_intro_link', $introLink);
        $edit->bindParam(':product_course_link', $courseLink);
        $edit->bindParam(':filename', $filename);
		$updateCategory->execute();
        // Execute the query
        if ($edit->execute()) {
            echo json_encode("Success");
        } else {
            echo json_encode("SQL error");
        }
    } catch (PDOException $e) {
        // Catch and display SQL errors
        echo json_encode("Database error: " . $e->getMessage());
    }
} else {
    echo json_encode('Invalid request method');
}

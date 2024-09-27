<?php
require_once("../database/sql_connection.php");
$database = new SQLConnect();
$query = $database->connect();
$search = $_POST['search'];
$getCourses = $query->prepare("SELECT * FROM `khoá học` WHERE `Tiêu đề` LIKE '%" . $search . "%' LIMIT 3");
$getCourses->execute();
if ($getCourses->rowCount() > 0) {
    while ($courses = $getCourses->fetch()) {
        echo '<div class="data">';
        echo '<a href="detail.php?title=' . urlencode($courses['Tiêu đề']) . '">';
        echo '<img src="../../images/' . $courses['Hình ảnh'] . '">';
        echo '<div class="info">';
        echo '<p>' . $courses['Tiêu đề'] . '</p>';
        echo '<p>' . number_format($courses['Đơn giá'], 0, '.', '.') . ' đồng' . '</p>';
        echo '</div>';
        echo '</a>';
        echo '</div>';
    }
} else {
    echo "<div class = 'not-found'>Không tìm thấy khoá học</div>";
}
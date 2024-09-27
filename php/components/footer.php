<?php
// require_once ("sql_connection.php");
// $database = new SQLConnect();
// $query = $database->connect();
$getCategories = $query->prepare("SELECT * FROM `phân loại`");
$getCategories->execute();
?>

<div class="row">
  <div class="column">
    <h4>Khoá học</h4>
    <ul>
      <?php if ($getCategories->rowCount() > 0) {
        while ($categories = $getCategories->fetch()) { ?>
          <li><a href="../pages/home.php#category-<?php echo $categories['Mã phân loại']; ?>"><?php echo $categories['Tên']; ?></a></li>
        <?php }
      } ?>
    </ul>
  </div>
  <div class="column">
    <h4>Giới thiệu</h4>
    <ul>
      <li><a href="../pages/about.php">Về trang web</a></li>
    </ul>
  </div>
  <div class="column">
    <h4>Câu hỏi thường gặp</h4>
    <ul>
      <li><a href="#">Hướng dẫn cách mua hàng</a></li>
      <li><a href="#">Hướng dẫn chỉnh sửa trang cá nhân</a></li>
    </ul>
  </div>
  <div class="column">
    <h4>Liên hệ</h4>
    <ul>
      <li><a href="#">Email góp ý</a></li>
      <li><a href="#">Hotline hỗ trợ</a></li>
    </ul>
  </div>
</div>
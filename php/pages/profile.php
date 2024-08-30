<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Trang cá nhân</title>
  <link rel="stylesheet" href="../../css/style.css" />
  <link rel="stylesheet" href="../../css/profile.css" />
  <link rel="stylesheet" href="../../fontawesome-free-6.6.0-web/css/all.css" />
</head>

<body>
  <!-- Thanh điều hướng -->
  <?php require_once("../component/navbar.php"); ?>
  <!-- phần thân sau navbar -->
  <?php
  require_once("../database/sql_connection.php");
  // session_start();
  if (!isset($_SESSION['user_id'])) {
    echo '<script>window.location.href="../../index.php"</script>';
  }
  $user_id = $_SESSION['user_id'];
  $database = new SQLConnect();
  $query = $database->connect();
  $getInfo = $query->prepare("SELECT * FROM `người dùng` WHERE `Mã người dùng` = '$user_id'");
  $getInfo->execute();
  ?>
  <a href="home.php">
    <button class="return-button">
      <i class="fa-solid fa-chevron-left"></i>Quay về trang chủ
    </button>
  </a>
  <div class="body-profile">
    <div class="title">Quản lý hồ sơ</div>
    <?php if ($getInfo->rowCount() > 0) {
      while ($info = $getInfo->fetch()) { ?>
        <div class="profile">
          <div class="row">
            <div class="column">
              <div class="image">
                <img src="images/<?php
                if ($info['Hình đại diện'] != NULL) {
                  echo $info['Hình đại diện'];
                } else {
                  echo 'default-avatar.png';
                }
                ?>" alt="" />
              </div>
              <input type="hidden" id="userID" value="<?php echo $user_id; ?>" />
            </div>
            <div class="column">
              <div class="input-box">
                <span>Họ và tên: </span>
                <input type="text" name="name" id="name" value="<?php echo $info['Tên']; ?>" readonly />
              </div>
              <div class="input-box">
                <span>Email: </span>
                <input type="text" name="email" id="email" value="<?php echo $info['Email']; ?>" readonly />
              </div>
              <div class="input-box">
                <span>Số điện thoại: </span>
                <input type="text" name="phone" id="phone" value="<?php
                if ($info['Số điện thoại'] != NULL) {
                  echo $info['Số điện thoại'];
                } else {
                  echo 'Chưa có số điện thoại mặc định';
                }
                ?>" readonly />
              </div>
              <div class="input-box">
                <span>Địa chỉ: </span>
                <input type="text" name="address" id="address" value="<?php
                if ($info['Địa chỉ'] != NULL) {
                  echo $info['Địa chỉ'];
                } else {
                  echo 'Chưa có địa chỉ mặc định';
                }
                ?>" readonly />
              </div>
              <div class="input-box">
                <span>Ngày tạo tài khoản: </span>
                <input type="text" value="<?php echo $info['Ngày tạo']; ?>" readonly />
              </div>
              <button class="edit-button" onclick="editButton()">
                Chỉnh sửa
              </button>
              <span class="after-edit">
                <button class="save-button" onclick="saveButton()" name="submit">Lưu</button>
                <button class="cancel-button" onclick="cancelButton()">
                  Huỷ bỏ
                </button>
              </span>
            </div>
          </div>
        </div>
      <?php }
    } ?>
    <div class="purchasedCourses">
      <div class="title">
        Khoá học đã mua
      </div>
      <?php
      $getPaidCourses = $query->prepare("SELECT * FROM `khoá học đã mua` WHERE `Mã người dùng` = '$user_id'");
      $getPaidCourses->execute();
      if ($getPaidCourses->rowCount() > 0) {
        while ($getIDCourses = $getPaidCourses->fetch()) {
          $course_id = $getIDCourses['Mã khoá học'];
          $getCourses = $query->prepare("SELECT * FROM `khoá học` WHERE `Mã khoá học` = '$course_id'");
          $getCourses->execute();
          $course = $getCourses->fetch();
          $categoryID = $course['Mã phân loại'];
          $getCategories = $query->prepare("SELECT * FROM `phân loại` WHERE `Mã phân loại` = '$categoryID'");
          $getCategories->execute();
          $category = $getCategories->fetch();
          ?>
          <div class="image-container">
            <img src="images/<?php echo $course['Hình ảnh']; ?>">
            <div class="content">
              <p><?php echo $course['Tiêu đề']; ?></p>
              <p>Phân loại: <?php echo $category['Tên']; ?></p>
              <p>Thời lượng: <?php echo $course['Thời lượng']; ?></p>
              <p>Ngày mua: <?php echo $getIDCourses['Ngày mua']; ?></p>
              <p>Tiến trình đã lưu: <?php echo $getIDCourses['Tiến trình'] !== '' ? $getIDCourses['Tiến trình'] : 'Bạn chưa lưu tiến trình'; ?></p>
            </div>
            <a href="purchasedDetail.php?title=<?php echo urlencode($course['Tiêu đề']); ?>">
              Vào học thôi >>
            </a>
          </div>
        <?php }
      } else {
        echo "<h4>Bạn chưa mua khoá học nào</h4>";
      }
      ?>
    </div>
    <!-- Nút mũi tên bên phải màn hình -->
    <?php require_once("../component/sidebar.php"); ?>
    <script src="../../js/profile.js"></script>
  </div>
</body>
<!-- Phần chân -->
<footer><?php require_once("../component/footer.php"); ?></footer>

</html>
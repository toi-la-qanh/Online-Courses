<?php
require_once("../database/sql_connection.php");
session_start();
$user_id = '';
if (isset($_SESSION['user_id'])) {
  $user_id = $_SESSION['user_id'];
}
$database = new SQLConnect();
$query = $database->connect();
$getCategories = $query->prepare("SELECT * FROM `phân loại`");
$getCategories->execute();
$getUser = $query->prepare("SELECT * FROM `người dùng` WHERE `Mã người dùng` = '$user_id'");
$getUser->execute();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../../css/login.css" />
  <link rel="stylesheet" href="../../css/register.css" />
  <link rel="stylesheet" href="../../css/payment.css" />
</head>

<body>
  <div class="navbar">
    <div class="logo">
      <a href="home.php"><img src="../../images/logo.png" alt="Logo" /></a>
    </div>
    <!-- Các khoá học -->
    <div class="navbar-courses">
      <button>Các khoá học<i class="fa-solid fa-chevron-down"></i></button>
      <ul>
        <?php if ($getCategories->rowCount() > 0) {
          while ($categories = $getCategories->fetch()) { ?>
            <li><a href="home.php#category-<?php echo $categories['Mã phân loại']; ?>"><?php echo $categories['Tên']; ?></a>
            </li>
          <?php }
        } ?>
      </ul>
    </div>
    <!-- Thanh tìm kiếm -->
    <div class="search-bar">
      <span><i class="fa-solid fa-search"></i></span>
      <form action="">
        <input type="text" id="search" placeholder="Tìm kiếm khoá học hay gì đó ..." />
      </form>
    </div>
    <!-- Phần đăng nhập/đăng xuất và hiện tên người dùng nếu đã đăng nhập -->
    <div class="<?php echo isset($_SESSION['user_id']) && $_SESSION['user_id'] ? 'isAuth' : 'auth-navbar'; ?>">
      <span><?php
      while ($user = $getUser->fetch()) {
        echo 'Chào ' . $user['Tên'];
      } ?>
        <i class="fa-solid fa-chevron-down"></i>
      </span>
      <ul>
        <li><a href="profile.php">Trang cá nhân</a></li>
        <li>
          <form method="GET" action="logout.php"><button name="logout" class="logout">Đăng xuất</button></form>
        </li>
      </ul>
      <button class="register" onclick="Register()">Đăng ký</button>
      <button class="login" onclick="Login()">Đăng nhập</button>
    </div>
    <div class="container-result">
      <div id="results"></div>
    </div>
  </div>
</body>

</html>
<div class="get-width">
  <div class="show-notification">
    <div id="notification"></div>
    <button onclick="Reload()">Ấn vào đây để tải lại trang</button>
  </div>
</div>
<?php require_once "../modals/register.php"; ?>
<?php require_once "../modals/login.php"; ?>
<?php require_once "../modals/payment.php"; ?>
<script src="../../js/jquery.js"></script>
<script src="../../js/script.js"></script>
<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Trang chủ</title>
  <link rel="stylesheet" href="../../css/style.css" />
  <link rel="stylesheet" href="../../fontawesome-free-6.6.0-web/css/all.css" />
</head>

<body>
  <!-- Thanh điều hướng -->
  <?php require_once("../components/navbar.php"); ?>
  <!-- Nút mũi tên bên phải màn hình -->
  <?php require_once("../components/sidebar.php"); ?>
  <!-- phần thân sau thanh điều hướng -->
  <div class="body-container">
    <?php
    require_once("../database/sql_connection.php");
    $database = new SQLConnect();
    $query = $database->connect();
    $getCategories = $query->prepare("SELECT * FROM `phân loại`");
    $getCategories->execute();
    if (isset($_SESSION['user_id'])) {
      $user_id = $_SESSION['user_id'];
    }
    ?>
    <div class="title">Các khoá học</div>
    <div class="courses-data">
      <!-- Phân loại -->
      <?php if ($getCategories->rowCount() > 0) {
        while ($categories = $getCategories->fetch()) { ?>
          <div class="category">
            <!-- Tên loại -->
            <div class="category-name" id="category-<?php echo $categories['Mã phân loại']; ?>">
              <?php echo $categories['Tên']; ?>
            </div>
            <!-- Sản phẩm -->
            <div class="box-container">
              <?php
              $category = $categories['Mã phân loại'];
              $getCourses = $query->prepare("SELECT * FROM `khoá học` WHERE `Mã phân loại` = '$category' ");
              $getCourses->execute();

              if ($getCourses->rowCount() > 0) {
                while ($courses = $getCourses->fetch()) {
                  $coursesID = $courses['Mã khoá học'];
                  $getPaidCourses = $query->prepare("SELECT * FROM `khoá học đã mua` 
                WHERE `Mã khoá học` = '$coursesID' AND `Mã người dùng` = '$user_id'");
                  $getPaidCourses->execute();
                  ?>
                  <div class="box">
                    <?php if ($getPaidCourses->rowCount() > 0 || $courses['Đơn giá'] == 0): ?>
                      <a href="purchasedDetail.php?title=<?php echo urlencode($courses['Tiêu đề']); ?>">
                        <img src="../../images/<?php echo $courses['Hình ảnh']; ?>" alt="" />
                      </a>
                    <?php else: ?>
                      <a href="detail.php?title=<?php echo urlencode($courses['Tiêu đề']); ?>">
                        <img src="../../images/<?php echo $courses['Hình ảnh']; ?>" alt="" />
                      </a>
                    <?php endif; ?>
                    <h3><?php echo $courses['Tiêu đề']; ?></h3>
                    <p>
                      <?php echo ($courses['Đơn giá'] == 0) ? 'Miễn phí'
                        : number_format($courses['Đơn giá'], 0, '.', '.') . ' đồng'; ?>
                    </p>
                    <p><i class="fa-solid fa-user-group"></i>
                      <?php echo ($courses['Đơn giá'] == 0) ? $courses['Lượt mua'] . ' người đã học thử'
                        : $courses['Lượt mua'] . ' người đã mua'; ?>
                    </p>
                    <div class="button-container">
                      <?php
                      if ($courses['Đơn giá'] == 0) {
                        ?>
                        <a href="purchasedDetail.php?title=<?php echo urlencode($courses['Tiêu đề']); ?>">
                          <button class="purchase-button">
                            Học thử
                          </button>
                        </a>
                      <?php } else { ?>
                        <?php if (!isset($_SESSION['user_id'])) { ?>
                          <button class="purchase-button" onclick="goToLogin()">
                            Mua ngay
                          </button>
                          <a href="detail.php?title=<?php echo urlencode($courses['Tiêu đề']); ?>">
                            <button class="view-detail-button">
                              Xem chi tiết <i class="fa-solid fa-arrow-right"></i>
                            </button>
                          </a>
                        <?php } else {
                          if ($getPaidCourses->rowCount() == 0) {
                            ?>
                            <button class="purchase-button" data-courses-id="<?php echo $coursesID; ?>" onclick="Payment(this)">
                              Mua ngay
                            </button>
                            <a href="detail.php?title=<?php echo urlencode($courses['Tiêu đề']); ?>">
                              <button class="view-detail-button">
                                Xem chi tiết <i class="fa-solid fa-arrow-right"></i>
                              </button>
                            </a>
                            <?php
                          } else {
                            ?>
                            <a href="purchasedDetail.php?title=<?php echo urlencode($courses['Tiêu đề']); ?>">
                              <button class="purchase-button">
                                Học ngay
                              </button>
                            </a>
                            <?php
                          }
                        }
                      } ?>
                    </div>
                  </div>
                  <?php
                }
              } ?>
            </div>
          </div>
        <?php }
      } ?>
    </div>
  </div>

</body>
<!-- Phần chân -->
<footer><?php require_once("../components/footer.php"); ?></footer>

</html>
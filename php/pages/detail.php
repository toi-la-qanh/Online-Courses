<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>
    <?php
    require_once("../database/sql_connection.php");
    $database = new SQLConnect();
    $query = $database->connect();
    $title = '';
    $courseId = '';
    if (isset($_GET['title'])) {
      $title = $_GET['title'];
      $getCourses = $query->prepare("SELECT * FROM `khoá học` WHERE `Tiêu đề` = '$title'");
      $getCourses->execute();
      if ($getCourses->rowCount() > 0) {
        $courses = $getCourses->fetch();
        echo $courses['Tiêu đề'];
      }
    }
    ?>
  </title>
  <link rel="stylesheet" href="../../css/detail.css" />
  <link rel="stylesheet" href="../../css/style.css" />
  <link rel="stylesheet" href="../../fontawesome-free-6.6.0-web/css/all.css" />
</head>

<body>
  <!-- Thanh điều hướng -->
  <?php require_once("../components/navbar.php"); ?>
  <!-- Nút mũi tên bên phải màn hình -->
  <?php require_once("../components/sidebar.php"); ?>
  <!-- Phần thân sau navbar -->
  <div class="body-detail">
    <div class="return-button">
      <a href="home.php"><button>
          <i class="fa-solid fa-arrow-left"></i> Quay về trang chủ
        </button></a>
    </div>
    <div class="title">Chi tiết khoá học</div>
    <div class="detail">
      <?php
      $getCourses = $query->prepare("SELECT * FROM `khoá học` WHERE `Tiêu đề` = '$title'");
      $getCourses->execute();
      $courses = $getCourses->fetch();
      $courseId = $courses['Mã khoá học'];

      if (isset($_SESSION['user_id'])) {
        $userId = $_SESSION['user_id'];

        $checkIfCourseIsPaid = $query->prepare("SELECT * from `khoá học đã mua` WHERE `Mã khoá học` = '$courseId'
      AND `Mã người dùng` = '$userId'");
        $checkIfCourseIsPaid->execute();

        if ($checkIfCourseIsPaid->rowCount() > 0) {
          echo '<script>window.location.href="purchasedDetail.php?title=' . urlencode($title) . '";</script>';
        }
      }

      $categoryID = $courses['Mã phân loại'];
      $getCategories = $query->prepare("SELECT * FROM `phân loại` WHERE `Mã phân loại` = '$categoryID'");
      $getCategories->execute();
      $categoryName = $getCategories->fetch();
      ?>
      <iframe src="<?php echo $courses['Đường dẫn giới thiệu khoá học']; ?>" title="YouTube video player"
        frameborder="0"
        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
        referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
      <div class="content">
        <h1 class="name"><?php echo $courses['Tiêu đề']; ?></h1>
        <div class="price"><?php echo ($courses['Đơn giá'] == 0) ? '<span>Miễn phí</span>'
          : number_format($courses['Đơn giá'], 0, '.', '.') . ' <span>đồng</span>'; ?></div>
        <h3 class="category">Phân loại: <?php echo $categoryName['Tên']; ?></h3>
        <div class="buttons">
          <?php if (!isset($_SESSION['user_id'])): ?>
            <button class="purchase-button" onclick="Login()">
              Đăng ký học ngay >>
            </button>
          <?php else: ?>
            <button class="purchase-button" data-courses-id="<?php echo $courseId; ?>" onclick="PaymentInDetail(this)">
              Đăng ký học ngay >>
            </button>
          <?php endif; ?>
        </div>
        <div class="description">
          <?php echo $courses['Mô tả']; ?>
        </div>
        <div class="duration">
          Thời lượng: ~<?php echo $courses['Thời lượng']; ?>
        </div>
        <div class="number-of-people">
          <i class="fa-solid fa-user-group"></i> <?php echo $courses['Lượt mua'] . ' người đã mua khoá học này'; ?>
        </div>
      </div>
      <?php
      if (isset($_POST['add-to-cart'])) {
        array_push($_SESSION['cart'], $courseId);
      }
      ?>
    </div>
    <div class="comment">
      <div class="title">
        <h3>HỌC VIÊN NÓI GÌ VỀ KHOÁ HỌC NÀY ?</h3>
      </div>
      <div class="display">
        <div class="content">
          <div class="profile">
            <img src="../../images/default-avatar.png" alt="">
            <div class="info-user">
              <strong>Anh</strong>
              <div class="review">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
              </div>
            </div>
          </div>
          <div class="user-comment">
            Mình mê tít cái khóa học này luôn ấy! Những kiến thức cơ bản cứ thế thấm vào đầu mình lúc nào không hay. Các
            bài tập thực hành cũng hay ho nữa, giúp mình tự tin hơn hẳn khi viết code.
          </div>
        </div>
        <div class="content">
          <div class="profile">
            <img src="../../images/default-avatar.png" alt="">
            <div class="info-user">
              <strong>Nam</strong>
              <div class="review">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
              </div>
            </div>
          </div>
          <div class="user-comment">
            Nội dung khóa học rất hay, nhưng mình thấy phần về làm việc với cơ sở dữ liệu còn hơi ít. Mong rằng trong
            các phiên bản sau, khóa học sẽ bổ sung thêm phần này.
          </div>
        </div>
        <div class="content">
          <div class="profile">
            <img src="../../images/default-avatar.png" alt="">
            <div class="info-user">
              <strong>Lan</strong>
              <div class="review">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
              </div>
            </div>
          </div>
          <div class="user-comment">
            Cộng đồng học viên của khóa học rất sôi động. Mình đã được giải đáp rất nhiều thắc mắc và học hỏi được nhiều
            điều từ các bạn học khác. Việc cùng nhau làm dự án cũng giúp mình tăng cường kỹ năng làm việc nhóm.
          </div>
        </div>
        <div class="content">
          <div class="profile">
            <img src="../../images/default-avatar.png" alt="">
            <div class="info-user">
              <strong>Quốc</strong>
              <div class="review">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
              </div>
            </div>
          </div>
          <div class="user-comment">
            Khóa học này đã giúp mình rất nhiều trong việc chuyển đổi nghề nghiệp. Nhờ khóa học, mình đã có thể tự tin
            xây dựng các dự án nhỏ và tìm được một công việc lập trình viên. Mình đặc biệt ấn tượng với phần hướng dẫn
            phỏng vấn và tìm việc.
          </div>
        </div>
      </div>
    </div>
    <div class="related-courses">
      <h3>CÁC KHOÁ HỌC LIÊN QUAN</h3>
      <?php
      $getRelatedCourses = $query->prepare("SELECT * FROM `khoá học` WHERE `Tiêu đề` != '$title' 
      ORDER BY RAND() LIMIT 10");
      $getRelatedCourses->execute();
      ?>
      <div class="container">
        <?php if ($getRelatedCourses->rowCount() > 0) {
          while ($relatedCourses = $getRelatedCourses->fetch()) {
            ?>
            <div class="box">
              <a href="detail.php?title=<?php echo urlencode($relatedCourses['Tiêu đề']); ?>"><img
                  src="../../images/<?php echo $relatedCourses['Hình ảnh']; ?>" alt=""></a>
              <p class="title-box"><?php echo $relatedCourses['Tiêu đề']; ?></p>
              <p class="price"><?php echo ($relatedCourses['Đơn giá'] == 0) ? '<span>Miễn phí</span>'
                : number_format($relatedCourses['Đơn giá'], 0, '.', '.') . ' <span>đồng</span>'; ?></p>
              <span class="view-detail"><a href="detail.php?title=<?php echo urlencode($relatedCourses['Tiêu đề']); ?>">Xem chi tiết
                  >></a></span>
            </div>
          <?php }
        } ?>
      </div>
      <div class="slide-button">
        <button id="prev"><i class="fa-solid fa-circle-chevron-left"></i></button>
        <button id="next"><i class="fa-solid fa-circle-chevron-right"></i></button>
      </div>
    </div>

  </div>
  <script src="../../js/script.js"></script>
  <script src="../../js/detail.js"></script>
</body>
<!-- Phần chân -->
<footer><?php require_once("../components/footer.php"); ?></footer>

</html>
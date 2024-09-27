<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>
    <?php
    require_once("../database/sql_connection.php");
    // session_start();
    $database = new SQLConnect();
    $query = $database->connect();
    $title = '';
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
  <link rel="stylesheet" href="../../css/purchasedDetail.css" />
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
    <?php
    $getCourses = $query->prepare("SELECT * FROM `khoá học` WHERE `Tiêu đề` = '$title'");
    $getCourses->execute();
    $courses = $getCourses->fetch();
    $courseId = $courses['Mã khoá học'];
    // session_start(); 
    // echo $_SESSION['user_id'];
    if ($courses['Đơn giá'] > 0) {
      if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        $checkCourse = $query->prepare("SELECT * FROM `khoá học đã mua` WHERE `Mã khoá học` = '$courseId'
        AND `Mã người dùng` = '$user_id'");
        $checkCourse->execute();
        if ($checkCourse->rowCount() == 0) {
          header("location:index.php");
        }
      } else {
        header("location:index.php");
      }
    }
    ?>
    <div class="title"><?php echo $courses['Tiêu đề']; ?></div>
    <div class="lesson">
      <button onclick="showLesson1()">
        Bài học số 1
        <span class="arrow-down" id="down1"><i class="fa-solid fa-chevron-down"></i></span>
        <span class="arrow-up" id="up1"><i class="fa-solid fa-chevron-up"></i></span>
      </button>
      <div class="video" id="video1">
        <iframe src="<?php echo $courses['Đường dẫn khoá học']; ?>" title="YouTube video player" frameborder="0" allow="accelerometer; clipboard-write; encrypted-media; gyroscope; 
picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen id="video">
        </iframe>
      </div>
      <button onclick="showLesson2()">
        Bài học số 2
        <span class="arrow-down" id="down2"><i class="fa-solid fa-chevron-down"></i></span>
        <span class="arrow-up" id="up2"><i class="fa-solid fa-chevron-up"></i></span>
      </button>
      <div class="video" id="video2">
        <iframe src="https://www.youtube.com/embed/vLnPwxZdW4Y?si=hvXq1aIb7uUcs-Ud" title="YouTube video player" frameborder="0" allow="accelerometer; clipboard-write; encrypted-media; gyroscope; 
picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen id="video">
        </iframe>
      </div>
      <button onclick="showLesson3()">
        Bài học số 3
        <span class="arrow-down" id="down3"><i class="fa-solid fa-chevron-down"></i></span>
        <span class="arrow-up" id="up3"><i class="fa-solid fa-chevron-up"></i></span>
      </button>
      <div class="video" id="video3">
        <iframe src="https://www.youtube.com/embed/ZzaPdXTrSb8?si=TDM5O7mmA5bQ9B5d" title="YouTube video player" frameborder="0" allow="accelerometer; clipboard-write; encrypted-media; gyroscope; 
picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen id="video">
        </iframe>
      </div>
    </div>
    <?php if (isset($_SESSION['user_id'])) { ?>
      <div class="save-progress">
        Lưu tiến độ học tập: <input type="text" id="progress" placeholder="Thời gian bạn đã học"><button
          onclick="saveProgress()">Lưu</button>
        <input type="hidden" id="courseIDInProgress" value="<?php echo $courseId; ?>">
      </div>
    <?php } ?>
    <div class="theory">
      <div class="title">NỘI DUNG BÀI HỌC</div>
      <?php
      $getContent = $query->prepare("SELECT * FROM `nội dung` WHERE `Mã khoá học` = '$courseId'");
      $getContent->execute();
      while ($content = $getContent->fetch()) {
        ?>
        <div class="topic">
          <span><?php echo $content['Đề mục']; ?></span>
        </div>
        <div class="content">
          <?php echo $content['Nội dung']; ?>
        </div>
        <?php
      }
      ?>
    </div>
    <div class="your-comment">
      <h3>HÃY ĐỂ LẠI ĐÁNH GIÁ CỦA BẠN SAU KHI HOÀN THÀNH KHOÁ HỌC NÀY</h3>
      <div class="rating">
        <input type="radio" name="rate" id="rate-5">
        <label for="rate-5" class="fas fa-star"></label>
        <input type="radio" name="rate" id="rate-4">
        <label for="rate-4" class="fas fa-star"></label>
        <input type="radio" name="rate" id="rate-3">
        <label for="rate-3" class="fas fa-star"></label>
        <input type="radio" name="rate" id="rate-2">
        <label for="rate-2" class="fas fa-star"></label>
        <input type="radio" name="rate" id="rate-1">
        <label for="rate-1" class="fas fa-star"></label>
      </div>
      <input id="comment" type="text" placeholder="Bạn nghĩ gì về khoá học này ?">
      <div class="post-container">
        <?php if (!isset($_SESSION['user_id'])): ?>
          <button onclick="Login()">Đăng</button>
        <?php else: ?>
          <button onclick="CommentHandle()">Đăng</button>
          <input type="hidden" value="<?php echo $courseId; ?>" id="courseID">
          <input type="hidden" value="<?php echo $user_id; ?>" id="userID">
          <input type="hidden" value="" id="rating-value">
        <?php endif; ?>
      </div>
      <div class="people-comment">
        <?php
        $getComment = $query->prepare("SELECT * FROM `bình luận` WHERE `Mã khoá học` = '$courseId'");
        $getComment->execute();
        if ($getComment->rowCount() > 0) {
          while ($comment = $getComment->fetch()) {
            $userComment = $comment['Mã người dùng'];
            $getUser = $query->prepare("SELECT * FROM `người dùng` WHERE `Mã người dùng` = '$userComment'");
            $getUser->execute();
            $userInfo = $getUser->fetch();
            ?>
            <div class="each-comment">
              <img src="images/<?php echo $userInfo['Hình đại diện']; ?>">
              <div class="content">
                <p><?php echo $userInfo['Tên']; ?></p>
                <p>
                  <?php
                  $numberOfStars = $comment['Số sao'];
                  for ($i = 0; $i < $numberOfStars; $i++) {
                    echo "<i class='fas fa-star'></i>";
                  }
                  ?>
                </p>
                <p class="text"><?php echo $comment['Nội dung'] ?></p>
              </div>
            </div>
            <?php
          }
        } else {
          echo "<h4>Chưa có bình luận cho khoá học này!";
        }
        ?>
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
              <span class="view-detail"><a href="detail.php?title=<?php echo $relatedCourses['Tiêu đề']; ?>">Xem chi tiết
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
</body>
<script src="../../js/detail.js"></script>
<!-- Phần chân -->
<footer><?php require_once("../components/footer.php"); ?></footer>

</html>
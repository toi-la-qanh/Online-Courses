<?php
// require_once ("sql_connection.php");
// session_start();
// if(isset($_SESSION['user_id'])){
//   $user_id = $_SESSION['user_id'];
// }
?>
<div class="icon-bar-and-arrow">
  <!-- Mũi tên phải ở thanh công cụ -->
  <div class="right-arrow">
    <button class="button" onclick="handleRightArrow()">
      <i class="fa-solid fa-arrow-right"></i>
    </button>
  </div>
  <!-- thanh icon -->
  <div class="icon-bar">
    <ul>
      <li>
        <button class="button">
          <a href="home.php"><span class="icon"><i class="fa-solid fa-house"></i></span></a>
        </button>
      </li>
      <li>
        <button class="button">
        <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id']): ?>
          <a href="profile.php"><span class="icon"><i class="fa-solid fa-user"></i></span></a>
        <?php else: ?>
          <button onclick="Login()"><span class="icon"><i class="fa-solid fa-user"></i></span></button>
          <?php endif;?>
        </button>
      </li>
      <!-- Menu thanh công cụ -->
      <li>
        <button class="button" onclick="showMoreElement()">
          <span class="icon"><i class="fa-solid fa-ellipsis"> </i></span>
        </button>
      </li>
      <li class="login-icon">
        <button>
          <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id']): ?>
            <form method="get" action="../auth/logout/logout.php">
              <button name="logout" class="logoutButton">
                <span class="icon">
                  <i class="fa-solid fa-right-from-bracket">
                    <input type="hidden" name="logout">
                  </i>
                </span>
              </button>
            </form>
          <?php else: ?>
            <button onclick="Login()"><span class="icon"><i class="fa-solid fa-right-to-bracket"></i></span></button>
          <?php endif; ?>
        </button>
      </li>
      <li class="question-icon">
        <button class="button">
          <a href="about.php"><span class="icon"><i class="fa-solid fa-circle-question"></i></span></a>
        </button>
      </li>
    </ul>
  </div>
</div>
<!-- Mũi tên trái ở thanh công cụ -->
<div class="left-arrow">
  <button onclick="handleLeftArrow()">
    <i class="fa-solid fa-arrow-left"></i>
  </button>
</div>
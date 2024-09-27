<div class="body-login">
<!-- Đăng nhập -->  
  <div class="form-login">
    <ul>
      <button class="delete-button" onclick="cancelLoginButton()"><i class="fa-regular fa-circle-xmark"></i></button>
      <li class="title">Đăng nhập tài khoản của bạn</li>
      <form method="post" id="loginForm">
        <li>
          <span>
            <i class="fa-solid fa-envelope"></i>
            <input type="text" autocomplete="on" placeholder="Nhập email..." name="email" />
          </span>
          <p id="errorLoginEmail"></p>
        </li>
        <li>
          <span>
            <i class="fa-solid fa-lock"></i>
            <input type="password" autocomplete="on" placeholder="Nhập mật khẩu..." name="password" />
          </span>
          <p id="errorLoginPassword"></p>
        </li>
        <li>
          <button>Đăng nhập</button>
        </li>
      </form>
      <li>
        <span class="under-button"><small class="question">Chưa có tài khoản?</small>
          <button onclick="goToRegister()" class="register-link"><small>Đăng ký ngay</small></button>
        </span>
      </li>
    </ul>
  </div>
</div>
<div class="body-register">
<!-- Đăng ký -->  
  <div class="form-login">
    <ul>
      <button class="delete-button" onclick="cancelLoginButton()"><i class="fa-regular fa-circle-xmark"></i></button>
      <li class="title">Đăng ký tài khoản</li>
      <form method="post" id="registerForm">
        <li>
          <span class="user-input">
            <i class="fa-regular fa-user"></i>
            <input type="text" placeholder="Nhập tên..." name="name" autocomplete="on" />
          </span>
          <p id="errorName"></p>
        </li>
        <li>
          <span class="user-input">
            <i class="fa-regular fa-envelope"></i>
            <input type="text" placeholder="Nhập email..." name="email" autocomplete="on" />
          </span>
          <p id="errorEmail"></p>
        </li>
        <li>
          <span class="user-input">
            <i class="fa-solid fa-lock"></i>
            <input type="password" placeholder="Nhập mật khẩu..." name="password" autocomplete="on"/>
          </span>
          <p id="errorPassword"></p>
        </li>
        <li>
          <span class="user-input">
            <i class="fa-solid fa-lock"></i>
            <input type="password" placeholder="Nhập lại mật khẩu..." name="Cpassword" autocomplete="on"/>
          </span>
          <p id="errorPassword2"></p>
        </li>
        <li>
          <button>Đăng ký</button>
        </li>
      </form>
      <li>
        <span class="under-button"><small class="question">Đã có tài khoản?</small>
          <button onclick="goToLogin()" class="register-link"><small>Đăng nhập ngay</small></button>
        </span>
      </li>
    </ul>
  </div>
</div>
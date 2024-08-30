<!-- Phần thân sau navbar -->
<input type="hidden" value="<?php echo isset($_SESSION['user_id']) ? $_SESSION['user_id']: ''; ?>" id="user">
<input type="hidden" id="courseID" value="">
<div class="body-payment">
  <div class="form-payment">
    <button class="delete-button" onclick="cancelLoginButton()"><i class="fa-regular fa-circle-xmark"></i></button>
    <div class="row">
      <div class="column">
        <h3 class="title">Thông tin chuyển khoản</h3>
        <div class="payment-content">
          <span>
            <h4>Số tài khoản</h4>
            <p class="textfield">0982920731</p>
          </span>
          <span>
            <h4>Tên tài khoản</h4>
            <p class="textfield">NGUYỄN QUỐC ANH</p>
          </span>
          <span>
            <h4>Nội dung</h4>
            <p class="textfield">"Tên người chuyển" - "Tên khoá học"</p>
          </span>
          <span>
            <h4>Chi nhánh</h4>
            <p class="textfield">MB Bank Hóc Môn</p>
          </span>
        </div>
      </div>
      <div class="column">
        <h3 class="title">Thông tin đơn hàng</h3>
        <div class="input-box">
          <span class="image-container"><img id="image" src="" alt="" />
            <p>
              <span id="name"></span>
              <span class="category"><small>Phân loại:</small> <span id="category"></span></span>
            </p>
          </span>
        </div>
        <div class="money">
          <span>Số tiền cần phải chuyển: <div id="price"></div></span>
        </div>
        <div class="guide">
          <h4>Hướng dẫn:</h4>
          Chuyển khoản tiền theo thông tin bên, sau đó ấn gửi yêu cầu thanh toán để xác nhận thanh toán
        </div>
        <button class="paid-button" onclick="paidButton()">
          Gửi yêu cầu thanh toán
        </button>
      </div>
      <div class="notice">
        <h4>Lưu ý</h4>
        Trong vòng 5 - 15 phút, hệ thống sẽ kiểm tra và xác nhận hoá đơn thanh toán của bạn. Nếu có vấn đề phát sinh,
        hãy liên hệ:
        <div class="contact">
          <span><i class="fa-solid fa-phone"></i> 0982920731</span>
          <span><i class="fa-solid fa-envelope"></i> quocanh2003vn427@gmail.com</span>
        </div>
      </div>
    </div>
  </div>
</div>
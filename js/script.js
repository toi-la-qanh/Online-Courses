// Xử lý nút ... ở thanh công cụ icon
var count = 0;
function showMoreElement() {
  document.querySelector(
    ".icon-bar-and-arrow .icon-bar ul .login-icon"
  ).style.display = "flex";
  document.querySelector(
    ".icon-bar-and-arrow .icon-bar ul .question-icon"
  ).style.display = "flex";
  count += 1;
  if (count == 2) {
    document.querySelector(
      ".icon-bar-and-arrow .icon-bar ul .login-icon"
    ).style.display = "none";
    document.querySelector(
      ".icon-bar-and-arrow .icon-bar ul .question-icon"
    ).style.display = "none";
    count = 0;
  }
}
// Xử lý nút mũi tên
function handleRightArrow() {
  document.querySelector(".icon-bar-and-arrow").style.display = "none";
  document.querySelector(".left-arrow button").style.display = "flex";
}
function handleLeftArrow() {
  document.querySelector(".icon-bar-and-arrow").style.display = "flex";
  document.querySelector(".left-arrow button").style.display = "none";
}
//Xử lý tìm kiếm
document.addEventListener("DOMContentLoaded", () => {
  const searchInput = document.getElementById("search");
  const resultsDiv = document.getElementById("results");
  searchInput.addEventListener("keyup", () => {
    const searchTerm = searchInput.value.trim();
    if (searchTerm !== "") {
      // $.ajax({
      //   url: "search.php",
      //   method: "POST",
      //   data: { search: searchTerm },
      //   success: function (data) {
      //     $("#results").html(data);
      //   },
      // });
      const xhr = new XMLHttpRequest();
      xhr.open("POST", "../component/search.php");
      xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xhr.onload = () => {
        if (xhr.status === 200) {
          resultsDiv.innerHTML = xhr.responseText;
          resultsDiv.style.display = "flex";
        }
      };
      xhr.send(`search=${searchTerm}`);
      // document.getElementById("results").style.display = "flex";
    } else {
      // $("#results").html("");
      // document.getElementById("results").style.display = "none";
      resultsDiv.innerHTML = "";
      resultsDiv.style.display = "none";
    }
  });
});
//Mở form đăng ký
function Register() {
  document.querySelector(".body-register").style.display = "flex";
  document.body.style.overflow = "hidden";
}
//Mở form đăng nhập
function Login() {
  document.querySelector(".body-login").style.display = "flex";
  document.body.style.overflow = "hidden";
}
//Format tiền 
const formatter = new Intl.NumberFormat("vi-VN", {
  style: "currency",
  currency: "VND",
  minimumFractionDigits: 0, 
  maximumFractionDigits: 0, 
});
//Mở form thanh toán theo từng sản phẩm
function Payment(button) {
  // Open payment section
  document.querySelector(".body-payment").style.display = "flex";
  document.body.style.overflow = "hidden";
  document.getElementById("name").textContent = "";
  document.getElementById("price").textContent = "";
  document.getElementById("category").textContent = "";
  document.getElementById("image").src = "";
  // Get course ID from button data attribute
  const courseID = button.getAttribute("data-courses-id");
  const data = { courseID: courseID };
  // Có thể dùng ajax hoặc fetch
  // $.post("paymentHandle.php", data)
  //   .done(function (response) {
  //     const value = JSON.parse(response);
  //     $("#name").text(value.name);
  //     $("#price").text(formatter.format(value.price));
  //     $("#category").text(value.category);
  //     document.getElementById("courseID").value = value.id;
  //     const imageURL = `images/${value.image}`;
  //     document.getElementById("image").src = imageURL;
  //   })
  //   .fail(function (error) {
  //     console.error("Error sending payment data:", error);
  //   });
  fetch("../payment/paymentHandle.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(data),
    processData: false,
    contentType: false,
  })
    .then((response) => response.json())
    .then((response) => {
      document.getElementById("name").textContent = response.name;
      document.getElementById("price").textContent = formatter.format(
        response.price
      );
      document.getElementById("category").textContent = response.category;
      document.getElementById("image").src = `images/${response.image}`;
      document.getElementById("courseID").value = courseID;
    })
    .catch((error) => {
      console.error("Error sending payment data:", error);
    });
}
// Ấn bất kỳ đâu trên web ngoài form, sẽ ẩn form 
document.body.addEventListener("click", (event) => {
  if (event.target.classList.contains("body-register")) {
    document.querySelector(".body-register").style.display = "none";
    document.body.style.overflow = "auto";
  }
  if (event.target.classList.contains("body-login")) {
    document.querySelector(".body-login").style.display = "none";
    document.body.style.overflow = "auto";
  }
  if (event.target.classList.contains("body-payment")) {
    document.querySelector(".body-payment").style.display = "none";
    document.body.style.overflow = "auto";
  }
});
//Xử lý khi ấn nút đăng ký
document.getElementById("registerForm").addEventListener("submit", (event) => {
  event.preventDefault();

  document.getElementById("errorName").textContent = "";
  document.getElementById("errorEmail").textContent = "";
  document.getElementById("errorPassword").textContent = "";
  document.getElementById("errorPassword2").textContent = "";

  const formData = new FormData(document.getElementById("registerForm"));

  // $.ajax({
  //   type: "POST",
  //   url: "registerHandle.php",
  //   data: formData,
  //   processData: false,
  //   contentType: false,
  //   dataType: "json",
  //   success: function (response) {
  //     console.log(response);
  //     if (response.status == 422) {
  //       const errorName = JSON.stringify(response.errors.name);
  //       const errorEmail = JSON.stringify(response.errors.email);
  //       const errorPassword = JSON.stringify(response.errors.password);
  //       const errorPassword2 = JSON.stringify(response.errors.Cpassword);
  //       $("#errorName").text(errorName);
  //       $("#errorEmail").text(errorEmail);
  //       $("#errorPassword").text(errorPassword);
  //       $("#errorPassword2").text(errorPassword2);
  //     } else if (response.status == 200) {
  //       // sleep(2);
  //       document.querySelector(".body-register").style.display = "none";
  //       document.querySelector(".body-login").style.display = "flex";
  //     }
  //   },
  // });
  fetch("../auth/register/registerHandle.php", {
    method: "POST",
    body: formData,
    processData: false,
    contentType: false,
  })
    .then((response) => response.json())
    .then((response) => {
      console.log(response);
      if (response.status === 422) {
        const errorName = JSON.stringify(response.errors.name);
        const errorEmail = JSON.stringify(response.errors.email);
        const errorPassword = JSON.stringify(response.errors.password);
        const errorPassword2 = JSON.stringify(response.errors.Cpassword);

        document.getElementById("errorName").textContent = errorName;
        document.getElementById("errorEmail").textContent = errorEmail;
        document.getElementById("errorPassword").textContent = errorPassword;
        document.getElementById("errorPassword2").textContent = errorPassword2;
      } else if (response.status === 200) {
        // Assuming classes for register and login sections
        document.querySelector(".body-register").style.display = "none";
        document.querySelector(".body-login").style.display = "flex";
      }
    })
    .catch((error) => {
      console.error("Error:", error);
      // Handle errors appropriately, e.g., display an error message to the user
    });
});
//Xử lý khi ấn nút đăng nhập
document.getElementById("loginForm").addEventListener("submit", (event) => {
  event.preventDefault();

  document.getElementById("errorLoginEmail").textContent = "";
  document.getElementById("errorLoginPassword").textContent = "";

  const formData = new FormData(document.getElementById("loginForm"));

  // $.ajax({
  //   type: "POST",
  //   url: "loginHandle.php",
  //   data: formData,
  //   processData: false,
  //   contentType: false,
  //   dataType: "json",
  //   success: function (response) {
  //     console.log(response);
  //     if (response.status == 422) {
  //       const errorEmail = JSON.stringify(response.errors.email);
  //       const errorPassword = JSON.stringify(response.errors.password);
  //       $("#errorLoginEmail").text(errorEmail);
  //       $("#errorLoginPassword").text(errorPassword);
  //     } else if (response.status == 200) {
  //       if (response.errors.account === "admin") {
  //         window.location.href = "admin/admin.php";
  //       } else {
  //         document.querySelector(".body-login").style.display = "none";
  //         location.reload();
  //       }
  //     }
  //   },
  //   error: function () {
  //     console.log("ERROR with ajax request  !!!");
  //   },
  // });
  fetch("../auth/login/loginHandle.php", {
    method: "POST",
    body: formData,
    processData: false,
    contentType: false,
  })
    .then((response) => response.json())
    .then((response) => {
      console.log(response);
      if (response.status === 422) {
        const errorEmail = response.errors?.email
          ? JSON.stringify(response.errors.email)
          : "";
        const errorPassword = response.errors?.password
          ? JSON.stringify(response.errors.password)
          : "";

        document.getElementById("errorLoginEmail").textContent = errorEmail;
        document.getElementById("errorLoginPassword").textContent =
          errorPassword;
      } else if (response.status === 200) {
        if (response.errors?.account === "admin") {
          window.location.href = "../../admin/admin.php";
        } else {
          document.querySelector(".body-login").style.display = "none";
          location.reload();
        }
      }
    })
    .catch((error) => {
      console.error("ERROR with ajax request!", error);
    });
});
// Nút X trên form đăng nhập, tắt form
function cancelLoginButton() {
  document.querySelector(".body-login").style.display = "none";
  document.querySelector(".body-register").style.display = "none";
  document.querySelector(".body-payment").style.display = "none";
  document.body.style.overflow = "auto";
}
// Mở form đăng nhập, tắt form đăng ký, khi đang mở form đăng ký 
function goToLogin() {
  document.querySelector(".body-login").style.display = "flex";
  document.querySelector(".body-register").style.display = "none";
  document.body.style.overflow = "hidden";
}
// Mở form đăng ký, tắt form đăng nhập, khi đang mở form đăng nhập 
function goToRegister() {
  document.querySelector(".body-login").style.display = "none";
  document.querySelector(".body-register").style.display = "flex";
  document.body.style.overflow = "hidden";
}
// Xử lý khi ấn nút thanh toán, chuyển hoá đơn đến trang admin
function paidButton() {
  const userID = document.getElementById("user").value;
  const courseID = document.getElementById("courseID").value;

  const data = { course_id: courseID, user_id: userID };
  // $.post("./admin/paymentConfirm.php", data)
  //   .done(function (response) {
  //     console.log("Payment data sent successfully:", response);
  //   })
  //   .fail(function (error) {
  //     console.error("Error sending payment data:", error);
  //   });
  fetch("../../admin/paymentConfirm.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(data),
  })
    .then((response) => response.json())
    .then((response) => {
      console.log("Payment data sent:", response);
    })
    .catch((error) => {
      console.error("Error sending payment data:", error);
    });
}
// Thông báo khi đơn hàng thanh toán thành công
function notifyPayment() {
  const xhr = new XMLHttpRequest();
  xhr.open("POST", "../payment/notification.php");
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  xhr.onload = function () {
    if (xhr.status === 200) {
      const response = JSON.parse(xhr.responseText);
      if (response.countThird > response.countFourth) {
        document.querySelector(".show-notification").style.display = "flex";
        const messageElement = document.getElementById("notification");
        // messageElement.style.display = 'flex';
        messageElement.textContent =
          "Đơn hàng thanh toán thành công";
      }
    } else {
      console.error("Error fetching data:", xhr.statusText);
    }
  };

  xhr.send();
  setTimeout(notifyPayment, 60000);// waiting for request
}
document.addEventListener("DOMContentLoaded", notifyPayment); // Fetch data on page load
function Reload() {
  location.reload();
}
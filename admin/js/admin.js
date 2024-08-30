// // admin.js
// function loadContent(url) {
//   $.get(url, function(data) {
//       $('#content').html(data);

//       // Gọi các hàm khởi tạo dựa trên nội dung đã tải
//       if (url == "admin1.php") {
//           initProductManagement(); // Khởi tạo chức năng quản lý sản phẩm
//       } else if (url == "admin2.php") {
//           initOrderManagement(); // Khởi tạo chức năng quản lý đơn hàng
//       }
//   }).fail(function() {
//       alert('Có lỗi xảy ra khi tải nội dung, vui lòng thử lại.');
//   });
// }

// function showProductsManagement() {
//   loadContent("admin1.php");
// }

// function showOrdersManagement() {
//   loadContent("admin2.php");
// }

// function showInstructionsManagement() {
//   loadContent("admin3.php");
// }

// $(document).ready(function() {
//   showProductsManagement(); // Tải quản lý sản phẩm theo mặc định
// });

// admin1.js
// $(document).ready(function() {
//   // Tải sản phẩm khi trang tải xong
//   loadProducts();

//   // Xử lý việc gửi biểu mẫu để thêm sản phẩm
//   $('#add-product-form').submit(function(event) {
//       event.preventDefault();
//       var formData = $(this).serializeArray();
//       var postData = {};
//       $.each(formData, function(index, field) {
//           postData[field.name] = $.trim(field.value);
//       });
//       postData['add-product'] = true;

//       $.ajax({
//           url: 'admin1.php',
//           type: 'POST',
//           data: postData,
//           success: function(response) {
//               if (response.trim() == 'success') {
//                   $('#add-product-form')[0].reset();
//                   loadProducts();
//               } else if (response.trim() == 'duplicate') {
//                   $('#popup_box_tt').show();
//               } else {
//                   alert('Có lỗi xảy ra khi thêm sản phẩm.');
//               }
//           },
//           error: function() {
//               alert('Có lỗi xảy ra khi gửi yêu cầu.');
//           }
//       });
//   });

//   // Ẩn popup box bật lên trùng lặp
//   $('#ok-btn').click(function() {
//       $('#popup_box_tt').hide();
//   });

// Xử lý nhấp vào nút chỉnh sửa
//   // Lưu sản phẩm đã chỉnh sửa
//   $('#save-edit-btn').click(function() {
//       var productId = $('#edit-product-code').val();
//       var productName = $('#edit-product-name').val();
//       var productPrice = $('#edit-product-price').val();

//       $.ajax({
//           url: 'admin1.php',
//           type: 'POST',
//           data: {
//               'edit-product-id': productId,
//               'edit-product-name': productName,
//               'edit-product-price': productPrice
//           },
//           success: function(response) {
//               if (response.trim() == 'success') {
//                   $('#edit-dialog').hide();
//                   loadProducts();
//               } else {
//                   alert('Có lỗi xảy ra khi chỉnh sửa sản phẩm.');
//               }
//           },
//           error: function() {
//               alert('Có lỗi xảy ra khi gửi yêu cầu.');
//           }
//       });
//   });

// Hủy popup box chỉnh sửa
function Cancel() {
  document.getElementById("edit-dialog").style.display = "none";
  document.getElementById("add-dialog").style.display = "none";
}

//   // Xử lý nhấp vào nút xóa
//   $(document).on('click', '.delete-btn', function() {
//       var row = $(this).closest('tr');
//       var productId = row.find('td').eq(0).text();
//       $('#popup_box').show();

//       $('#btn2').off('click').on('click', function() {
//           $.ajax({
//               url: 'admin1.php',
//               type: 'POST',
//               data: {
//                   'delete-product-id': productId
//               },
//               success: function(response) {
//                   if (response.trim() == 'success') {
//                       $('#popup_box').hide();
//                       loadProducts();
//                   } else {
//                       alert('Có lỗi xảy ra khi xoá sản phẩm.');
//                   }
//               },
//               error: function() {
//                   alert('Có lỗi xảy ra khi gửi yêu cầu.');
//               }
//           });
//       });
//   });

//   // Ẩn popup box
//   $('#btn1').click(function() {
//       $('#popup_box').hide();
//   });

//   // Ẩn popup box bật lên trùng lặp
//   $('#ok-btn').click(function() {
//       $('#popup_box_tt').hide();
//   });

//   // Tải sản phẩm
//   function loadProducts() {
//       $.ajax({
//           url: 'admin1.php',
//           type: 'GET',
//           data: { action: 'fetch-products' },
//           success: function(response) {
//               $('#product-list').html(response);
//           },
//           error: function() {
//               alert('Có lỗi xảy ra khi tải danh sách sản phẩm.');
//           }
//       });
//   }
// });
//Thông báo đơn hàng
function fetchData() {
  const xhr = new XMLHttpRequest();
  xhr.open("POST", "notification.php");
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  xhr.onload = function () {
    if (xhr.status === 200) {
      const response = JSON.parse(xhr.responseText);
      if (response.countFirst > response.countSecond) {
        const messageElement = document.getElementById("message");
        messageElement.style.display = "flex";
        messageElement.textContent = "Có đơn hàng mới, hãy tải lại trang !";
      }
    } else {
      console.error("Error fetching data:", xhr.statusText);
    }
  };

  xhr.send();
  setTimeout(fetchData, 60000);
}

document.addEventListener("DOMContentLoaded", fetchData); // Fetch data on page load
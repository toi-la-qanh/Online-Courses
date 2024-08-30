// Nút sửa
function editButton() {
  document.querySelector(
    ".body-profile .profile .row .column .edit-button"
  ).style.display = "none";
  document.querySelector(
    ".body-profile .profile .row .column .save-button"
  ).style.display = "block";
  document.querySelector(
    ".body-profile .profile .row .column .cancel-button"
  ).style.display = "block";
  // document.getElementById("profile-image").type = "file";
  // Sửa tên
  document.getElementById("name").readOnly = false;
  // Sửa email
  document.getElementById("email").readOnly = false;
  // Sửa số điện thoại
  document.getElementById("phone").readOnly = false;
  document.getElementById("phone").value = "";
  // Sửa địa chỉ
  document.getElementById("address").readOnly = false;
  document.getElementById("address").value = "";
}
// Nút huỷ
function cancelButton() {
  location.reload();
}
// Nút lưu
function saveButton() {
  const name = document.getElementById("name").value;
  const email = document.getElementById("email").value;
  const phone = document.getElementById("phone").value;
  const address = document.getElementById("address").value;
  const userID = document.getElementById("userID").value;
  const xhr = new XMLHttpRequest();
  xhr.open("POST", "profileHandle.php");
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  xhr.onload = function () {
    if (xhr.status === 200) {
      const response = JSON.parse(xhr.responseText);
      if (response === 'success') {
        location.reload();
      }
      else{
        console.log(response);
      }
    } else {
      console.error("Error fetching data:", xhr.statusText);
    }
  };

  xhr.send(`userID=${userID}&name=${name}&email=${email}&phone=${phone}&address=${address}`);
}
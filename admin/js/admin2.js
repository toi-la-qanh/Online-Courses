document.addEventListener("click", function (event) {
  // Check if the clicked element has the class 'edit-btn'
  if (event.target.classList.contains("edit-btn")) {
    // Find the closest 'tr' ancestor of the clicked button
    var row = event.target.closest("tr");

    // Extract text content from the specific table cells
    var cells = row.getElementsByTagName("td");
    var productId = cells[0].textContent.trim();
    var productName = cells[1].textContent.trim();
    var customerName = cells[2].textContent.trim();
    var email = cells[3].textContent.trim();

    // Set the values of the input fields and show the dialog
    document.getElementById("edit-order-id").value = productId;
    document.getElementById("edit-course-name").value = productName;
    document.getElementById("edit-customer-name").value = customerName;
    document.getElementById("edit-email").value = email;
    document.getElementById("edit-dialog").style.display = "block";
  }
});
function SaveChange() {
  const orderID = document.getElementById("edit-order-id").value;
  const orderStatus = document.getElementById("edit-order-status").value;
  const xhr = new XMLHttpRequest();
  xhr.open("POST", "updateOrder.php");
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  xhr.onload = function () {
    if (xhr.status === 200) {
      if (xhr.response === "success") {
        location.reload();
      } else {
        console.log(xhr.response);
      }
    } else {
      console.error("Error fetching data:", xhr.statusText);
    }
  };

  xhr.send(`orderID=${orderID}&status=${orderStatus}`);
}
function DeleteOrder(button) {
  const orderID = button.getAttribute("invoice-id");
  console.log(orderID);
  if (confirm("Bạn có thực sự muốn xoá khoá học này?")) {
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "deleteOrder.php");
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onload = function () {
      if (xhr.status === 200) {
        // if (xhr.response === "success") {
          location.reload();
        // } 
        // else {
        //   console.log(xhr.response);
        // }
      } else {
        console.error("Error fetching data:", xhr.statusText);
      }
    };

    xhr.send(`orderID=${orderID}`);
  }
}

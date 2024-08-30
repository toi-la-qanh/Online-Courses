function showInsert() {
  document.getElementById("add-dialog").style.display = "flex";
}
document.addEventListener("click", function (event) {
  // Check if the clicked element has the class 'edit-btn'
  if (event.target.classList.contains("edit-btn")) {
    // Find the closest 'tr' ancestor of the clicked button
    var row = event.target.closest("tr");

    // Extract text content from the specific table cells
    var cells = row.getElementsByTagName("td");
    var category = cells[0].textContent.trim();
    var productID = cells[1].textContent.trim();
    var productName = cells[2].textContent.trim();
    var image = cells[3].textContent.trim();
    var price = cells[4].textContent.trim();
    var description = cells[6].textContent.trim();
    var duration = cells[7].textContent.trim();
    var introLink = cells[8].textContent.trim();
    var courseLink = cells[9].textContent.trim();

    // Set the values of the input fields and show the dialog
    document.getElementById("edit-product-id").value = productID;

    document.getElementById("edit-product-name").value = productName;

    document.getElementById("edit-product-price").value = parseFloat(
      price.replace(/[^0-9.,]/g, "").replace(",", ".")
    );

    document.getElementById("edit-product-category").value = category;

    document.getElementById("edit-product-description").value = description;

    document.getElementById("edit-product-duration").value = duration;

    document.getElementById("edit-product-intro-link").value = introLink;

    document.getElementById("edit-product-course-link").value = courseLink;

    document.getElementById("product-image").value = image;

    document.getElementById("edit-dialog").style.display = "block";
  }
});
// document
//   .getElementById("edit-product-form")
//   .addEventListener("submit", (event) => {
//     event.preventDefault();
//     // const productID = document.getElementById("edit-product-id").value;

//     // const productName = document.getElementById("edit-product-name").value;

//     // const price = document.getElementById("edit-product-price").value;

//     // const category = document.getElementById("edit-product-category").value;

//     // const description = document.getElementById(
//     //   "edit-product-description"
//     // ).value;

//     // const duration = document.getElementById("edit-product-duration").value;

//     // const introLink = document.getElementById("edit-product-intro-link").value;

//     // const courseLink = document.getElementById(
//     //   "edit-product-course-link"
//     // ).value;

//     // const image = document.getElementById("product-image").files[0];

//     // console.log(image);
//     const formData = new FormData(document.getElementById("edit-product-form"));
//     const xhr = new XMLHttpRequest();
//     xhr.open("POST", "updateHandle.php");
//     xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

//     xhr.onload = function () {
//       if (xhr.status === 200) {
//         if (xhr.response === "success") {
//           location.reload();
//         } else {
//           console.log(xhr.response);
//         }
//       } else {
//         console.error("Error fetching data:", xhr.statusText);
//       }
//     };

//     //   xhr.send(`productID=${productID}&productName=${productName}&price=${price}&category=${category}
//     // &description=${description}&duration=${duration}&introLink=${introLink}&courseLink=${courseLink}
//     // &image=${image}`);
//     xhr.send(formData);
//   });
document
  .getElementById("edit-product-form")
  .addEventListener("submit", (event) => {
    event.preventDefault();

    const formData = new FormData(document.getElementById("edit-product-form"));

    fetch("updateHandle.php", {
      method: "POST",
      body: formData,
      processData: false,
      contentType: false,
    })
      .then((response) => response.json())
      .then((response) => {
        if (response === "Success") {
          location.reload();
        } else {
          console.log(response);
        }
      })
      .catch((error) => {
        console.error("ERROR with ajax request!", error);
      });
  });
function DeleteCourse(button) {
  const courseID = button.getAttribute("course-id");
  if (confirm("Bạn có thực sự muốn xoá khoá học này?")) {
    console.log(courseID);
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "deleteHandle.php");
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onload = function () {
      if (xhr.status === 200) {
        // if (xhr.response === "success delete") {
        //   console.log(xhr.response);
          location.reload();
        // } else {
        //   console.log(xhr.response);
        // }
      } else {
        console.error("Error fetching data:", xhr.statusText);
      }
    };

    xhr.send(`courseID=${courseID}`);
  }
  else{
    console.log("Deletion canceled");
  }
}

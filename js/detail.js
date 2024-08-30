document.getElementById("next").onclick = function () {
  const width = document.querySelector(
    ".body-detail .related-courses .container .box img"
  ).offsetWidth;
  document.querySelector(
    ".body-detail .related-courses .container"
  ).scrollLeft += width;
};
document.getElementById("prev").onclick = function () {
  const width = document.querySelector(
    ".body-detail .related-courses .container .box img"
  ).offsetWidth;
  document.querySelector(
    ".body-detail .related-courses .container"
  ).scrollLeft -= width;
};
const comment = document.getElementById("comment");
const button = document.querySelector(
  ".body-detail .your-comment .post-container button"
);
comment.addEventListener("input", () => {
  if (comment.value === "") {
    button.disabled = true;
  } else {
    button.disabled = false;
  }
});
comment.addEventListener("click", () => {
  button.disabled = true;
  document.querySelector(
    ".body-detail .your-comment .post-container"
  ).style.display = "flex";
});
const ratingLabels = document.querySelectorAll(".rating label");

ratingLabels.forEach((label) => {
  label.addEventListener("click", () => {
    button.disabled = false;
    const rateId = label.getAttribute("for");
    const countStar = parseInt(rateId.split("-")[1], 10);
    document.getElementById("rating-value").value = countStar;
  });
});
function CommentHandle() {
  var star = document.getElementById("rating-value").value;
  var comment = document.getElementById("comment").value;
  var userID = document.getElementById("userID").value;
  var courseID = document.getElementById("courseID").value;
  const data = {
    star: star,
    comment: comment,
    user_id: userID,
    course_id: courseID,
  };
  fetch("comment.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(data),
  })
    .then((response) => response.json())
    .then((response) => {
      console.log("Payment data sent:", response);
      if (response === "success") {
        location.reload();
      }
    })
    .catch((error) => {
      console.error("Error sending payment data:", error);
    });
}
// startTime = new Date();
// function ping() {
//   const endTime = new Date();
//   const xhr = new XMLHttpRequest();
//   xhr.open("POST", "tracker.php");
//   xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

//   const durationInSeconds = endTime - startTime;
//   const duration = durationInSeconds / 3600000;
//   console.log(duration);
//   const urlParams = new URLSearchParams(window.location.search);
//   const courseTitle = urlParams.get("title");

//   // console.log(courseTitle);

//   xhr.send(`duration=${duration}&title=${courseTitle}`);
//   setTimeout(ping, 60000);
// }
function PaymentInDetail(button) {
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
  fetch("paymentHandle.php", {
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
var count = 0;
function showLesson1() {
  document.getElementById("video1").style.display = "flex";
  document.getElementById("up1").style.display = "flex";
  document.getElementById("down1").style.display = "none";
  count++;
  if (count == 2) {
    document.getElementById("video1").style.display = "none";
    document.getElementById("down1").style.display = "flex";
    document.getElementById("up1").style.display = "none";
    count = 0;
  }
}
function showLesson2() {
  document.getElementById("video2").style.display = "flex";
  document.getElementById("up2").style.display = "flex";
  document.getElementById("down2").style.display = "none";
  count++;
  if (count == 2) {
    document.getElementById("video2").style.display = "none";
    document.getElementById("down2").style.display = "flex";
    document.getElementById("up2").style.display = "none";
    count = 0;
  }
}
function showLesson3() {
  document.getElementById("video3").style.display = "flex";
  document.getElementById("up3").style.display = "flex";
  document.getElementById("down3").style.display = "none";
  count++;
  if (count == 2) {
    document.getElementById("video3").style.display = "none";
    document.getElementById("down3").style.display = "flex";
    document.getElementById("up3").style.display = "none";
    count = 0;
  }
}
function saveProgress() {
  const progress = document.getElementById("progress").value;
  const courseID = document.getElementById("courseIDInProgress").value;
  const userID = document.getElementById("userID").value;

  const data = { courseID: courseID, userID: userID, progress: progress };
  fetch("saveProgress.php", {
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
      if(response === 'success'){
        location.reload();
      }
      else{
        console.log(response);
      }
    })
    .catch((error) => {
      console.error("Error sending payment data:", error);
    });
}

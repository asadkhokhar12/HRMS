const video = document.getElementById("video");
// Get the base URL
const baseUrl = document
  .querySelector('meta[name="base_url"]')
  .getAttribute("content");
// Get the CSRF token
const csrfToken = document
  .querySelector('meta[name="csrf-token"]')
  .getAttribute("content");
const loadingMsg = document.getElementById("loading-msg");

if (loadingMsg) {
  loadingMsg.innerText = "Loading Models...";
} 

// if (typeof faceapi !== 'undefined') {

Promise.all([
  faceapi.nets.ssdMobilenetv1.loadFromUri("../models"),
  faceapi.nets.faceRecognitionNet.loadFromUri("../models"),
  faceapi.nets.faceLandmark68Net.loadFromUri("../models"),
])
  .then(() => {
    if (video) {
      loadingMsg.innerText = "Models loaded. Starting webcam...";
      return startWebcam();
    }else{
      console.log("video id not found");
    }
  })
  .then(() => {
    loadingMsg.style.display = "none";
    if (video) {
      faceRecognition();
    }else{
      console.log("video id not found");
    }
  });
// }
function startWebcam() {
  navigator.mediaDevices
    .getUserMedia({
      video: true,
      audio: false,
    })
    .then((stream) => {
      video.srcObject = stream;
    })
    .catch((error) => {
      console.error(error);
    });
}

function getLabeledFaceDescriptions(labels) {
  return Promise.all(
    labels.map(async (label) => {
      console.log("label");
      console.log(label);
      const descriptions = [];
      for (let i = 1; i <= 1; i++) {
        const img = await faceapi.fetchImage(label.path);
        const detections = await faceapi
          .detectSingleFace(img)
          .withFaceLandmarks()
          .withFaceDescriptor();
        descriptions.push(detections.descriptor);
      }
      const employeeID = label.user_id;
      const employeeName = label.name;
      const employeeIDStr =
        employeeName.toString() + " # " + employeeID.toString(); //
      return new faceapi.LabeledFaceDescriptors(employeeIDStr, descriptions);
    })
  );
}

async function faceRecognition() {
  const response = await fetch(baseUrl + "/faceattendance/employees");
  const labels = await response.json();
  console.log(labels);
  const labeledFaceDescriptors = await getLabeledFaceDescriptions(labels);
  const faceMatcher = new faceapi.FaceMatcher(labeledFaceDescriptors);

  video.addEventListener("playing", () => {
    location.reload();
  });

  const canvas = faceapi.createCanvasFromMedia(video);
  document.body.append(canvas);

  const displaySize = { width: video.width, height: video.height };
  faceapi.matchDimensions(canvas, displaySize);
  let lastAttendanceCallTime = 0; // Initialize variable to track last attendance call time

  setInterval(async () => {
    const detections = await faceapi
      .detectAllFaces(video)
      .withFaceLandmarks()
      .withFaceDescriptors();

    const resizedDetections = faceapi.resizeResults(detections, displaySize);

    canvas.getContext("2d").clearRect(0, 0, canvas.width, canvas.height);

    const results = resizedDetections.map((d) => {
      return faceMatcher.findBestMatch(d.descriptor);
    });

    results.forEach((result, i) => {
      const box = resizedDetections[i].detection.box;
      const drawBox = new faceapi.draw.DrawBox(box, {
        label: result,
      });
      drawBox.draw(canvas);
      const button = document.getElementById("checkINbtn");

      if (result.label !== "unknown") {
        const now = Date.now();
        if (now - lastAttendanceCallTime >= 30000) {
          // Check if 30 seconds have passed since the last call
          const labelParts = result.label.split("#");
          console.log("labelParts");
          console.log(labelParts[1]); 

          $("#matchID").val(labelParts[1]);
          button.innerHTML = "Check In";
          $("#checkINbtn").removeClass("text-danger").addClass("text-success");
        } else {
          console.log(
            "Not enough time has passed since the last attendance call."
          );
        }
      } else { 
        $("#matchID").val("");
        button.innerHTML = "Wait...";
        $("#checkINbtn").addClass("text-danger").removeClass("text-success");
      }
    });
  }, 100);
}

function checkIN() {
  $.ajaxSetup({
    headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") },
  });
  const matchID = $("#matchID").val();

  // Check if matchID is empty
  if (matchID ==null) {
    alert("Face detection failed");
    $("#checkINbtn")
      .text("Wait...")
      .removeClass("text-success")
      .addClass("text-danger");
    return false;
  }

  // Update check-in button text
  $("#checkINbtn")
    .text("Check In")
    .removeClass("text-danger")
    .addClass("text-success");

  // Call the checkin API
  $.ajax({
    type: "POST",
    url: baseUrl + "/faceattendance/checkin",
    data: {
      matchID,
      _token: csrfToken,
    },
    success: function (data) {
      console.log(data.url);
      if (data.status == "success") {
        toastr.success('You have successfully checked In!', 'Success');
        window.location.href = data.url;
      } else {
        toastr.error('Something went wrong!', 'Error');
        $("#checkINbtn")
          .text("Wait...")
          .removeClass("btn-success")
          .addClass("btn-danger");
      }
    },
    error: function (error) {
      console.log(error);
      toastr.error('Something went wrong!', 'Error');
      $("#checkINbtn")
        .text("Wait...")
        .removeClass("btn-success")
        .addClass("btn-danger");
    },
  });
}

$("#checkINbtn").on("click", function () {
  checkIN();
});

$(document).ready(function () {
  $("#image-upload-form").submit(function (event) {
    event.preventDefault();

    const imageInput1 = $("#image1");
    const imageInput2 = $("#image2");
    const nameInput = $("#EmployeeId");
    const name = nameInput.val().trim();

    const errorMessages = [];

    // Validate image files
    if (!imageInput1.val()) {
      errorMessages.push("Please select Image 01 file");
    } else if (!/\.(jpg)$/i.test(imageInput1.val())) {
      errorMessages.push(
        "Invalid file type. Please select a JPG file for Image 01."
      );
    }

    if (!imageInput2.val()) {
      errorMessages.push("Please select Image 02 file");
    } else if (!/\.(jpg)$/i.test(imageInput2.val())) {
      errorMessages.push(
        "Invalid file type. Please select a JPG file for Image 02."
      );
    }

    // Validate name
    if (!name) {
      errorMessages.push("Please select an employee");
    }

    // Display error messages
    const errorMessageContainer = $("#error-message-container");
    errorMessageContainer.empty();
    if (errorMessages.length > 0) {
      errorMessages.forEach((message) => {
        const errorMessageElement = $("<div></div>").text(message);
        errorMessageContainer.append(errorMessageElement);
      });
    } else {
      this.submit();
    }
  });
});

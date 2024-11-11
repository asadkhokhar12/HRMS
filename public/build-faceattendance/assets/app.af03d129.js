const n = document.getElementById("video"),
  f = document.querySelector('meta[name="base_url"]').getAttribute("content"),
  b = document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
  h = document.getElementById("loading-msg");
h.innerText = "Loading models...";
Promise.all([
  faceapi.nets.ssdMobilenetv1.loadFromUri("../../face/models"),
  faceapi.nets.faceRecognitionNet.loadFromUri("../../face/models"),
  faceapi.nets.faceLandmark68Net.loadFromUri("../../face/models"),
])
  .then(() => ((h.innerText = "Models loaded. Starting webcam..."), w()))
  .then(() => {
    (h.style.display = "none"), y();
  });
function w() {
  navigator.mediaDevices
    .getUserMedia({ video: !0, audio: !1 })
    .then((t) => {
      n.srcObject = t;
    })
    .catch((t) => {
      console.error(t);
    });
}
function k(t) {
  return Promise.all(
    t.map(async (e) => {
      console.log(e);
      const s = [];
      for (let i = 1; i <= 1; i++) {
        const d = await faceapi.fetchImage(e.path),
          r = await faceapi
            .detectSingleFace(d)
            .withFaceLandmarks()
            .withFaceDescriptor();
        s.push(r.descriptor);
      }
      const l = e.id,
        o = e.name.toString() + " # " + l.toString();
      return new faceapi.LabeledFaceDescriptors(o, s);
    })
  );
}
async function y() {
  const e = await (await fetch(f + "/faceattendance/employees")).json();
  console.log(e);
  const s = await k(e),
    l = new faceapi.FaceMatcher(s);
  n.addEventListener("playing", () => {
    location.reload();
  });
  const a = faceapi.createCanvasFromMedia(n);
  document.body.append(a);
  const o = { width: n.width, height: n.height };
  faceapi.matchDimensions(a, o);
  let i = 0;
  setInterval(async () => {
    const d = await faceapi
        .detectAllFaces(n)
        .withFaceLandmarks()
        .withFaceDescriptors(),
      r = faceapi.resizeResults(d, o);
    a.getContext("2d").clearRect(0, 0, a.width, a.height),
      r
        .map((c) => l.findBestMatch(c.descriptor))
        .forEach((c, p) => {
          const g = r[p].detection.box;
          new faceapi.draw.DrawBox(g, { label: c }).draw(a);
          const u = document.getElementById("checkINbtn");
          if (c.label !== "unknown")
            if (Date.now() - i >= 3e4) {
              const m = c.label.split("#");
              $("#EmployeeName").text(m[0]),
                $("#EmployeeID").text(m[1]),
                $("#matchID").val(m[1]),
                (u.innerHTML = "Check In"),
                $("#checkINbtn")
                  .removeClass("btn-danger")
                  .addClass("btn-success");
            } else
              console.log(
                "Not enough time has passed since the last attendance call."
              );
          else
            $("#EmployeeName").text("Unknown"),
              $("#EmployeeID").text("NULL"),
              $("#matchID").val(""),
              (u.innerHTML = "Wait..."),
              $("#checkINbtn")
                .addClass("btn-danger")
                .removeClass("btn-success");
        });
  }, 100);
}
function I() {
  $.ajaxSetup({
    headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") },
  });
  const t = $("#matchID").val();
  if (!t)
    return (
      alert("Face detection failed"),
      $("#checkINbtn")
        .text("Wait...")
        .removeClass("btn-success")
        .addClass("btn-danger"),
      !1
    );
  $("#checkINbtn")
    .text("Check In")
    .removeClass("btn-danger")
    .addClass("btn-success"),
    $.ajax({
      type: "POST",
      url: f + "/faceattendance/checkin",
      data: { matchID: t, _token: b },
      success: function (e) {
        console.log(e),
          e === "true"
            ? alert("You have successfully checked in")
            : (alert("You have not checked in"),
              $("#checkINbtn")
                .text("Wait...")
                .removeClass("btn-success")
                .addClass("btn-danger"));
      },
      error: function (e) {
        console.log(e),
          alert("Error occurred while checking in. Please try again."),
          $("#checkINbtn")
            .text("Wait...")
            .removeClass("btn-success")
            .addClass("btn-danger");
      },
    });
}
$("#checkINbtn").on("click", function () {
  I();
});

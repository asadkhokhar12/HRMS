"use strict";

// theme mode change
const body = document.querySelector("body");
const theme_mode = document.querySelectorAll("input[name='theme_mode']");
const themeMode = localStorage.getItem("theme_mode");

if (isRTL) {
  body.classList.add("rtl");
  body.setAttribute("dir", "rtl");
}

if (theme_mode.length > 0 && themeMode) {
  body.classList.add(themeMode);
  theme_mode.forEach(function (item) {
    if (item.value == themeMode) {
      item.checked = true;
    }
  });
} else {
  body.classList.add("default-theme");
  localStorage.setItem("theme_mode", "default-theme");
}

theme_mode.forEach(function (item) {
  item.addEventListener("change", function () {
    body.classList.remove("default-theme");
    body.classList.remove("dark-theme");
    body.classList.add(item.value);
    localStorage.setItem("theme_mode", item.value);
  });
});

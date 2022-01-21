const toggleBtn = document.querySelector(".sidebar-toggle");

const sidebar = document.querySelector(".sidebar ");

const closeBtn = document.querySelector(".close-btn");

const html = document.querySelector("html");

toggleBtn.addEventListener("click", function () {
  sidebar.classList.toggle("show-sidebar");
  html.classList.toggle("html-active");
});

closeBtn.addEventListener("click", function () {
  sidebar.classList.remove("show-sidebar");
  html.classList.remove("html-active");
});





$(document).ready(function() {
  $('#show-hidden-menu30').click(function() {
    $('.hidden-menu30').slideToggle("slow");
    // Alternative animation for example
    // slideToggle("fast");
  });
});
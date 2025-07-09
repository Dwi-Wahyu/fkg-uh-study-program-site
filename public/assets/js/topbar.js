document.addEventListener("DOMContentLoaded", () => {
  const menuBtn = document.getElementById("mobile-menu-btn");
  const sidebar = document.getElementById("mobile-sidebar");

  const sidebarToggleBTN = document.getElementById("sidebar-toggle-btn");

  menuBtn.addEventListener("click", () => {
    sidebar.classList.toggle("active");
  });

  sidebarToggleBTN.addEventListener("click", () => {
    sidebar.classList.toggle("active");
  });
});

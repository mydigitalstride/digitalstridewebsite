// js/menu-toggle.js
document.addEventListener('DOMContentLoaded', function () {
  const toggleButton = document.querySelector('.menu-toggle');
  const megaMenu = document.querySelector('.mega-menu');

  if (toggleButton && megaMenu) {
    toggleButton.addEventListener('click', function () {
      megaMenu.classList.toggle('is-open');
    });
  }
});

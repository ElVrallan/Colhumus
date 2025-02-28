// navbarJS.js

document.addEventListener('DOMContentLoaded', function () {
    var toggler = document.getElementById('navbar-toggler');
    var collapse = document.getElementById('navbarToggleExternalContent');
  
    toggler.addEventListener('click', function () {
      collapse.classList.toggle('show');
    });
  });
  
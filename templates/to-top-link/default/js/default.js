document.addEventListener('DOMContentLoaded', function () {
  const scrollToTopBtn = document.getElementById('iw-to-top-link');

  if (scrollToTopBtn) {
    scrollToTopBtn.addEventListener('click', function (e) {
      e.preventDefault();
      window.scrollTo({
        top: 0,
        behavior: 'smooth'
      });
    });
  }
});
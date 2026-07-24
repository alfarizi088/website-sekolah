document.addEventListener('DOMContentLoaded', function () {

  // Toggle menu mobile
  var navToggle = document.getElementById('navToggle');
  var navMenu = document.getElementById('navMenu');
  if (navToggle && navMenu) {
    navToggle.addEventListener('click', function () {
      var isOpen = navMenu.classList.toggle('open');
      navToggle.setAttribute('aria-expanded', isOpen);
    });
  }

  // Slider artikel & blog (tombol prev/next)
  var track = document.getElementById('artikelTrack');
  var prevBtn = document.getElementById('sliderPrev');
  var nextBtn = document.getElementById('sliderNext');
  if (track && prevBtn && nextBtn) {
    var scrollAmount = function () {
      var card = track.querySelector('.artikel-card');
      return card ? card.offsetWidth + 20 : 300;
    };
    prevBtn.addEventListener('click', function () {
      track.scrollBy({ left: -scrollAmount(), behavior: 'smooth' });
    });
    nextBtn.addEventListener('click', function () {
      track.scrollBy({ left: scrollAmount(), behavior: 'smooth' });
    });
  }

});

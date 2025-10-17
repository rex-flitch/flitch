document.addEventListener('DOMContentLoaded', function () {
  const sliderEl = document.querySelector('.mobile-slider-wrapper');
  if (!sliderEl) return;

  const swiper = new Swiper('.swiper', {
    slidesPerView: 'auto',
    centeredSlides: true,
    spaceBetween: 20,
    loop: false,
    autoplay: {
      delay: 4000,
      disableOnInteraction: false,
    },
    on: {
      init: function (swiper) {
        updateProgressAndCounter(swiper);
      },
      slideChange: function (swiper) {
        updateProgressAndCounter(swiper);
      }
    }
  });

  // Run once on load (in case Swiper is already initialized)
  updateProgressAndCounter(swiper);

  function updateProgressAndCounter(swiper) {
    const currentSlide = swiper.realIndex + 1;
    const totalSlides = swiper.slides.length;

    // Update progress bar
    const progress = (currentSlide / totalSlides) * 100;
    const progressBar = document.querySelector('.progress-indicator');
    if (progressBar) {
      progressBar.style.width = `${progress}%`;
    }

    // Update slide counter
    const currentEl = document.querySelector('.current-slide');
    const totalEl = document.querySelector('.total-slides');
    if (currentEl && totalEl) {
      currentEl.textContent = String(currentSlide).padStart(2, '0');
      totalEl.textContent = String(totalSlides).padStart(2, '0');
    }
  }
});

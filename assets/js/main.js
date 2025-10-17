/**
 * Main Javascript.
 */

if (navigator.userAgent.match(/IEMobile\/10\.0/)) {
  var msViewportStyle = document.createElement('style')
  msViewportStyle.appendChild(
    document.createTextNode(
      '@-ms-viewport{width:auto!important}'
    )
  )
  document.querySelector('head').appendChild(msViewportStyle)
}


jQuery(function($){
	$( '.hamburger' ).click(function(){
		$('.hamburger').toggleClass('is-active');
	})

// 	// MODIFY this code to the class of a specific parent menu item you want
// 	// to still be clickable --- Is this still needed for Bootstrap 4? idk yet
// 	$('.the-class-or-id-you-want').click(function(){
// 	    if ($( window ).width() >= 768) {
// 	        window.location.replace($(this).find('a').attr('href'));
// 	    }
// 	})
})

jQuery(document).ready(function($) {
  let slides = $(".slides li");
  let index = 0;

  function showNextSlide() {
      slides.eq(index).removeClass("active");
      index = (index + 1) % slides.length;
      slides.eq(index).addClass("active");
  }

  slides.eq(index).addClass("active"); // Show first slide
  setInterval(showNextSlide, 4000); // Change slide every 4 seconds
});

jQuery(document).ready(function ($) {
  $('.filter-checkbox').change(function () {
      var selectedCategories = [];
      
      $('.filter-checkbox:checked').each(function () {
          selectedCategories.push($(this).val());
      });

      $.ajax({
          type: 'POST',
          url: ajaxurl, // WordPress AJAX URL
          data: {
              action: 'filter_packages',
              categories: selectedCategories
          },
          beforeSend: function () {
              $('#packages-list').html('<p>Loading...</p>');
          },
          success: function (response) {
              $('#packages-list').html(response);
          }
      });
  });
});

jQuery(function($){
  $('.menu-icon').on('click', function() {
      $('.hamburger-menu').toggleClass('active');
  });

  // Close menu when clicking outside
  $('.menu-overlay').on('click', function() {
      $('.hamburger-menu').removeClass('active');
      $('.submenu').removeClass('active').css('transform', 'translateX(100%)'); // Reset submenus
  });

  // Handle submenu sliding
  $('#menu-mobile .has-children > a').on('click', function(e) {
      e.preventDefault();
      const submenu = $(this).next('.submenu');

      if (submenu.hasClass('active')) {
          submenu.removeClass('active').css('transform', 'translateX(100%)');
      } else {
          $('.submenu').removeClass('active').css('transform', 'translateX(100%)');
          submenu.addClass('active').css('transform', 'translateX(0)');
      }
  });

  // Back button inside submenus
  $('.submenu').prepend('<li class="back"><a href="#">Back</a></li>');
  $('.submenu .back a').on('click', function(e) {
      e.preventDefault();
      $(this).parent().parent().removeClass('active').css('transform', 'translateX(100%)');
  });
});

jQuery(document).ready(function($) {
    function initGallery() {
        $('.custom-gallery').justifiedGallery({
            rowHeight: 200, // Adjust row height
            margins: 5, // Space between images
            lastRow: 'justify' // Justify last row
        });
    }

    initGallery(); // Initialize on page load

    $('.filter-btn').on('click', function() {
        let filter = $(this).attr('data-filter');
        $('.gallery-item').show().filter(function() {
            return filter !== 'all' && $(this).data('category') !== filter;
        }).hide();

        // Reinitialize the justified gallery after filtering
        $('.custom-gallery').justifiedGallery('norewind');
    });
});

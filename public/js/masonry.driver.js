var $grid = $('.masonry-grid').imagesLoaded( function() {
    $grid.masonry({
        itemSelector: '.grid-item',
        percentPosition: true,
        columnWidth: '.grid-sizer'
    });
});
// Make all images that link to images into a lightbox
jQuery("a[href$='.jpg'],a[href$='.png'],a[href$='.gif'],a[href$='.jpeg']").fancybox();

// Make all images within a Wordpress gallery that link to an image into a lightbox gallery
jQuery(".gallery a[href$='.jpg'],.gallery a[href$='.png'],.gallery a[href$='.gif'],.gallery a[href$='.jpeg']").attr('rel','gallery');

// Make all items with a class fancybox into a lightbox
jQuery(".fancybox").fancybox();

// For Videos
jQuery(".video").fancybox({
	maxWidth		: 800,
	maxHeight		: 600,
	fitToView		: false,
	width			: '70%',
	height			: '70%',
	autoSize		: false,
	closeClick		: false,
	openEffect		: 'none',
	closeEffect		: 'none'
});
jQuery(document).ready(function( $ ) {
	
	$('.loop-layout-floorplanslider').slick({
		infinite: true,
		slidesToShow: 3,
		slidesToScroll: 3,
		dots: true,
		arrows: false,
		responsive: [
		    {
				breakpoint: 1000,
				settings: {
					slidesToShow: 2,
					slidesToScroll: 2,
					centerPadding: '40px',
					centerMode: true,
					arrows: false,
				}
		    },
		    {
				breakpoint: 600,
				settings: {
					centerMode: true,
					centerPadding: '40px',
					slidesToShow: 1,
					slidesToScroll: 1,
					dots: false,
				}
		    }
		]
	});
	
});
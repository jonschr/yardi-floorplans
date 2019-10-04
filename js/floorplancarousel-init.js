jQuery(document).ready(function ($) {

	$('.loop-layout-floorplancarousel, .loop-layout-floorplancarousel-detailed').slick({
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
					arrows: false,
					infinite: true,
				}
			},
			{
				breakpoint: 600,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1,
					dots: true,
					infinite: true,
				}
			}
		]
	});

});
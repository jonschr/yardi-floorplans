<?php

//* Output floorplancarousel before both the normal and detailed views
add_action( 'before_loop_layout_floorplancarousel', 'rb_floorplancarousel_before' );
add_action( 'before_loop_layout_floorplancarousel-detailed', 'rb_floorplancarousel_before' );
function rb_floorplancarousel_before( $args ) {

	// Enqueue slick
	wp_enqueue_style( 'floorplan-slick-main-style' );
	wp_enqueue_style( 'floorplan-slick-main-theme' );
	wp_enqueue_script( 'floorplan-slick-main-load' );

	wp_enqueue_script( 'floorplan-slick-carousel-init' );

}

//* Output floorplancarousel before just the detailed view
add_action( 'before_loop_layout_floorplancarousel-detailed', 'rb_floorplancarousel_before_detailed_only' );
function rb_floorplancarousel_before_detailed_only() {

	// Enqueue featherlight
	wp_enqueue_script( 'floorplan-featherlight-main' );
	wp_enqueue_style( 'floorplan-featherlight-style' );

	$terms = get_terms( 'sizes', array(
	    'hide_empty' => true,
	) );

	//* Bail if nothing found
	if ( !$terms )
		return;

	echo '<p class="align-center floorplanlinks">';

		echo '<a href="#" class="button button-small viewalllink">All</a>';

		foreach ( $terms as $term ) {
			$name = $term->name;
			$slug = $term->slug;

			printf( '<a href="#" class="button button-small inactive floorplanlink %s" floorplans="%s">%s</a>', $slug, $slug, $name );
		}

	echo '</p>';

	$currentfloorplans = htmlspecialchars($_GET["plan"]);

	?>
	<script>
		jQuery(document).ready(function( $ ) {
	
			var filtered = false;

			//* Initial load
			var currentitems = '<?php echo $currentfloorplans; ?>';
			if ( currentitems )
				setTimeout( function() { updateFloorplans( currentitems ) }, 2000);
			
			//* Clicking a specific link
			$( '.floorplanlink' ).click( function() {
				event.preventDefault();
				var currentitems = $(this).attr( 'floorplans' );

				updateFloorplans( currentitems );
			});

			//* Clicking "view all"
			$( '.viewalllink' ).click( function() {
				event.preventDefault();
				resetFloorplans();
			});

			function updateFloorplans( currentitems ) {

				//* Buttons
				classofcurrentlink = '.floorplanlink.' + currentitems;

				$( '.floorplanlink' ).addClass( 'inactive' );
				$( classofcurrentlink ).removeClass( 'inactive' );
				$( '.viewalllink' ).addClass( 'inactive' );

				//* Floorplans
				classofcurrentitems = '.sizes-' + currentitems;
				$('.loop-layout-floorplancarousel-detailed').slick('slickUnfilter');
				$( '.loop-layout-floorplancarousel-detailed' ).slick( 'slickFilter', classofcurrentitems );
			    filtered = true;

			}

			function resetFloorplans() {

				//* Buttons
				$( '.floorplanlink' ).addClass( 'inactive' );
				$( '.viewalllink' ).removeClass( 'inactive' );

				//* Floorplans
				$('.loop-layout-floorplancarousel-detailed').slick('slickUnfilter');
			    filtered = false;

			}
		});
	</script>
	<?php
}

//* Output each floorplancarousel
add_action( 'add_loop_layout_floorplancarousel', 'rb_floorplan_standard_each' );
add_action( 'add_loop_layout_floorplancarousel-detailed', 'rb_floorplan_standard_each' );
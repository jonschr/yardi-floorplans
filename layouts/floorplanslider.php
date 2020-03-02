<?php

//* Output floorplanslider before both the normal and detailed views
add_action( 'before_loop_layout_floorplanslider', 'rb_floorplanslider_before' );
add_action( 'before_loop_layout_floorplanslider-detailed', 'rb_floorplanslider_before' );
function rb_floorplanslider_before( $args ) {

	// Enqueue slick
	wp_enqueue_style( 'floorplan-slick-main-style' );
	wp_enqueue_style( 'floorplan-slick-main-theme' );
	wp_enqueue_script( 'floorplan-slick-main-load' );

	wp_enqueue_script( 'floorplan-slick-slider-init' );

	wp_enqueue_style( 'dashicons' );

	// Enqueue featherlight
	wp_enqueue_script( 'floorplan-featherlight-main' );
	wp_enqueue_style( 'floorplan-featherlight-style' );

}

//* Output floorplanslider before just the detailed view
add_action( 'before_loop_layout_floorplanslider-detailed', 'rb_floorplanslider_before_detailed_only' );
function rb_floorplanslider_before_detailed_only( $args ) {

	$datasource = get_floorplan_data_source( $args );
	$terms = get_floorplan_terms( $args );

	echo '<p class="align-center floorplanlinks">';

		echo '<a href="#" class="button button-small viewalllink">All</a>';

		foreach ( $terms as $term ) {
			
			// Wordpress uses an object to hold this information
			if ( $datasource == 'wordpress' ) {
				$name = $term->name;
				$slug = $term->slug;
			}

			// The API will use an array to hold this inormation
			if ( $datasource != 'wordpress' ) {
				
				// Inherit the slug from the term
				$slug = $term;
				
				if ( $term == 'studio' ) $name = 'Studio';
				if ( $term == 'one-bedroom' ) $name = 'One Bedroom';
				if ( $term == 'two-bedroom' ) $name = 'Two Bedroom';
				if ( $term == 'three-bedroom' ) $name = 'Three Bedroom';
				if ( $term == 'four-bedroom' ) $name = 'Four Bedroom';
				if ( $term == 'five-bedroom' ) $name = 'Five Bedroom';
				if ( $term == 'six-bedroom' ) $name = 'Six Bedroom';
			}

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
				$('.loop-layout-floorplanslider-detailed').slick('slickUnfilter');
				$( '.loop-layout-floorplanslider-detailed' ).slick( 'slickFilter', classofcurrentitems );
			    filtered = true;

			}

			function resetFloorplans() {

				//* Buttons
				$( '.floorplanlink' ).addClass( 'inactive' );
				$( '.viewalllink' ).removeClass( 'inactive' );

				//* Floorplans
				$('.loop-layout-floorplanslider-detailed').slick('slickUnfilter');
			    filtered = false;

			}
		});
	</script>
	<?php
}

//* Output each floorplanslider
add_action( 'add_loop_layout_floorplanslider', 'floorplans_default_internal_each' );
add_action( 'add_loop_layout_floorplanslider-detailed', 'floorplans_default_internal_each' );
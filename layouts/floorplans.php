<?php

//* Output floorplans before (only detailed view)
add_action( 'before_loop_layout_floorplans', 'floorplans_default_before' );
add_action( 'before_loop_layout_floorplans-detailed', 'floorplans_default_before' );
function floorplans_default_before( $args ) {

	wp_enqueue_script( 'floorplan-featherlight-main' );
	wp_enqueue_style( 'floorplan-featherlight-style' );

	// Figure out what the data source is (can be either 'wordpress' or 'rentcafe')
	// $datasource = get_floorplan_data_source( $args );	

	$terms = get_floorplan_terms( $args );
	$datasource = get_floorplan_data_source( $args );

	// echo '<pre style="text-align: left; font-size: 13px;">';
	// 	print_r ( $args[0] );
	// echo '</pre>';

	if ( doing_action( 'before_loop_layout_floorplans-detailed' ) ) {

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
	}

	// define var to avoid php error just in case there isn't one
	$currentfloorplans = null;

	if ( isset($_GET["plan"]) )
		$currentfloorplans = htmlspecialchars($_GET["plan"]);

	?>
	<script>
	jQuery(document).ready(function( $ ) {
		$('.button-floorplan').featherlight({});
	});	
	</script>

	<script>
	jQuery(document).ready(function( $ ) {

		//* Initial load
		var currentitems = '<?php echo $currentfloorplans; ?>';
		if ( currentitems )
			updateFloorplans( currentitems );
		
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

			classofcurrentlink = '.floorplanlink.' + currentitems;

			//* Buttons
			$( '.floorplanlink' ).addClass( 'inactive' );
			$( classofcurrentlink ).removeClass( 'inactive' );
			$( '.viewalllink' ).addClass( 'inactive' );

			//* Floorplans
			$( '.loop-layout-floorplans-detailed .floorplans' ).hide();
			$( '.loop-layout-floorplans-detailed .sizes-' + currentitems ).show( "medium" );
		}

		function resetFloorplans() {

			//* Buttons
			$( '.floorplanlink' ).addClass( 'inactive' );
			$( '.viewalllink' ).removeClass( 'inactive' );

			//* Floorplans
			$( '.loop-layout-floorplans-detailed .floorplans' ).hide();
			$( '.loop-layout-floorplans-detailed .floorplans' ).show( "medium" );

		}
	});
	</script>
	<?php
	
}

//* Output each floorplan
add_action( 'add_loop_layout_floorplans', 'floorplans_default_internal_each' );
add_action( 'add_loop_layout_floorplans-detailed', 'floorplans_default_internal_each' );

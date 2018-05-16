<?php

//* Output floorplangrid before (only detailed view)
add_action( 'before_loop_layout_floorplangrid-detailed', 'rb_floorplangrid_before' );
function rb_floorplangrid_before( $args ) {

	wp_enqueue_script( 'floorplan-featherlight-main' );
	wp_enqueue_style( 'floorplan-featherlight-style' );

	$terms = get_terms( 'sizes', array(
	    'hide_empty' => true,
	) );

	//* Bail if nothing found
	if ( !$terms )
		return;

	echo '<p class="align-center">';

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
			$( '.loop-layout-floorplangrid-detailed .floorplans' ).hide();
			$( '.loop-layout-floorplangrid-detailed .sizes-' + currentitems ).show( "medium" );
		}

		function resetFloorplans() {

			//* Buttons
			$( '.floorplanlink' ).addClass( 'inactive' );
			$( '.viewalllink' ).removeClass( 'inactive' );

			//* Floorplans
			$( '.loop-layout-floorplangrid-detailed .floorplans' ).hide();
			$( '.loop-layout-floorplangrid-detailed .floorplans' ).show( "medium" );

		}
	});
	</script>
	<?php
	
}

//* Output each floorplan_grid
add_action( 'add_loop_layout_floorplangrid', 'rb_floorplan_standard_each' );
add_action( 'add_loop_layout_floorplangrid-detailed', 'rb_floorplan_standard_each' );
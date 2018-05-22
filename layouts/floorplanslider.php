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

}

//* Output floorplanslider before just the detailed view
add_action( 'before_loop_layout_floorplanslider-detailed', 'rb_floorplanslider_before_detailed_only' );
function rb_floorplanslider_before_detailed_only() {

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
add_action( 'add_loop_layout_floorplanslider', 'rb_floorplan_each' );
add_action( 'add_loop_layout_floorplanslider-detailed', 'rb_floorplan_each' );
function rb_floorplan_each() {
	
	//* Global vars
	global $post;
	$id = get_the_ID();

	//* Vars
	$title = get_the_title();
	$imagelarge = get_the_post_thumbnail_url( $id, 'large' );
	$excerpt = apply_filters( 'the_content', get_the_excerpt() );
	$bedsbathsmarkup = get_beds_baths_markup( $id );
	$squarefeet = get_post_meta( $id, 'squarefootage', true );

	$lightboxmarkup = sprintf( "<h2>%s</h2>%s<img src='%s' />", $title, $excerpt, $imagelarge );

	//* Markup
    if ( $title || $excerpt ) {
    	echo '<div class="info"><div class="info-container">';
   
			if ( $title )
				printf( '<h3>%s</h3>', $title );

			if ( $excerpt )
				echo $excerpt;

			if ( $squarefeet )
				printf( '<p class="squarefeet">%s square feet</p>', $squarefeet ); 

			if ( $bedsbathsmarkup )
				printf( '<p class="bedsbaths">%s</p>', $bedsbathsmarkup );

			echo '<div class="arrows"></div>';

			if ( current_user_can( 'edit_posts' ) )
				edit_post_link( 'Edit floorplan', '<div class="edit-floorplans"><small>', '</small></div>', $id, 'post-edit-link' );				


		echo '</div></div>'; // .info-container, .info
    }

	if ( has_post_thumbnail() ) {
		echo '<div class="featured-image">';
			the_post_thumbnail( 'large' );
		echo '</div>';
	}
}
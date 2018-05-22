<?php

/**
 * Used for showing the internal part of each of the standard floorplans
 */
function rb_floorplan_standard_each() {

	//* Global vars
	global $post;
	$id = get_the_ID();

	//* Vars
	$title = get_the_title();
	$imagelarge = get_the_post_thumbnail_url( $id, 'large' );
	$excerpt = apply_filters( 'the_content', get_the_excerpt() );
	$bedsbathsmarkup = get_beds_baths_markup( $id );
	$squarefeet = get_post_meta( $id, 'squarefootage', true );

	$leasingurl = get_field('leasing_url', 'option');

	$lightboxmarkup = sprintf( "<h2>%s</h2>%s<img src='%s' />", $title, $excerpt, $imagelarge );

	//* Markup
	if ( has_post_thumbnail() ) 
        printf( '<div class="featured-image" style="background-image:url( %s )"></div>', $imagelarge );

    if ( $title || $excerpt ) 
    	echo '<div class="info"><div class="info-container">';
   
			if ( $title )
				printf( '<h3>%s</h3>', $title );

			if ( $bedsbathsmarkup )
				printf( '<p class="bedsbaths">%s</p>', $bedsbathsmarkup );

			if ( $squarefeet )
				printf( '<p class="squarefeet">%s square feet</p>', $squarefeet ); 

			if ( $excerpt )
				echo $excerpt;

			echo '<div class="buttonswrap">';

				//* Only do the Zoom button if we're on the detailed view
				if ( doing_action( 'add_loop_layout_floorplancarousel-detailed' ) || doing_action( 'add_loop_layout_floorplangrid-detailed' ) )
					printf( '<a class="button button-clear button-small button-floorplan" href="#" data-featherlight="%s">Zoom in</a>', $imagelarge );

				if ( $leasingurl )
					printf( '<a href="%s" target="_blank" class="button button-small">Lease now</a>', $leasingurl );

			echo '</div>'; // .buttonswrap

			if ( current_user_can( 'edit_posts' ) )
				edit_post_link( 'Edit floorplan', '<div class="edit-floorplans"><small>', '</small></div>', $id, 'post-edit-link' );				


	if ( $title || $excerpt ) 
		echo '</div></div>'; // .info-container, .info
    
}
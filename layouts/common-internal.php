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
	$squarefeet = get_post_meta( $id, 'squarefootage', true );
	$rentrange = get_post_meta( $id, 'rent_range', true );
	$beds = get_post_meta( $id, 'bedrooms', true );
	$baths = get_post_meta( $id, 'bathrooms', true );

	$leasingurl = get_field('leasing_url', 'option');

	if ( $baths == 1 )
		$baths = 'one';

	if ( $baths == 2 )
		$baths = 'two';

	if ( $baths == 3 )
		$baths = 'three';

	if ( $baths == 4 )
		$baths = 'four';

	if ( $baths == 5 )
		$baths = 'five';


	//* Markup
	if ( has_post_thumbnail() ) 
		printf( '<div class="featured-image" style="background-image:url( %s )"></div>', $imagelarge );
		
	echo '<div class="buttonswrap">';
		
		if ( $leasingurl)	
			printf( '<a href="%s" target="_blank" class="button button-small">Lease now</a>', $leasingurl );
		
		printf( '<a class="button button-clear button-small button-floorplan" href="#" data-featherlight="%s">Detailed view</a>', $imagelarge );
		
	echo '</div>';

	if ( $title )
		printf( '<h3>%s</h3>', $title );

	echo '<div class="bedsbathswrap">';

		if ( $beds == 0 || !$beds )
			$beds = 'studio';

		if ( $beds == 1 )
			$beds = 'one';

		if ( $beds == 2 )
			$beds = 'two';

		if ( $beds == 3 )
			$beds = 'three';

		if ( $beds == 4 )
			$beds = 'four';

		if ( $beds == 5 )
			$beds = 'five';

		if ( $beds ) {
			echo '<div class="bedswrap">';
				echo '<h4>Beds</h4>';
				printf( '<p class="bed">%s</p>', $beds );
			echo '</div>';
		}

		if ( $baths ) {
			echo '<div class="bathswrap">';
				echo '<h4>baths</h4>';
				printf( '<p class="baths">%s</p>', $baths );
			echo '</div>';
		}

		if ( $squarefeet ) {
			echo '<div class="squarefeetwrap">';
				echo '<h4>Square feet</h4>';
				printf( '<p class="squarefeet">%s</p>', $squarefeet ); 
			echo '</div>';
		}

		if ( $rentrange ) {
			echo '<div class="rentwrap">';
				echo '<h4>Rent</h4>';
				printf( '<p class="rentrange">$%s</p>', $rentrange );
			echo '</div>';
		}

	echo '</div>';

	// if ( $excerpt )
	// 	echo $excerpt;

	if ( current_user_can( 'edit_posts' ) )
		edit_post_link( 'Edit floorplan', '<div class="edit-floorplans"><small>', '</small></div>', $id, 'post-edit-link' );				
    
}
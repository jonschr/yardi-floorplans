<?php

function floorplans_default_internal_each( $floorplan_from_api ) {

	// echo '<pre style="text-align:left; font-size: 13px;">';
	// 	print_r( $floorplan_from_api );
	// echo '</pre>';

	$datasource = get_floorplan_data_source_single( $floorplan_from_api );

	if ( $datasource == 'wordpress' ) {
		
		//* Global vars
		global $post;
		$id = get_the_ID();

		//* WordPress post variables
		$title = get_the_title();
		$imagelarge = get_the_post_thumbnail_url( $id, 'large' );
		$excerpt = apply_filters( 'the_content', get_the_excerpt() );
		$beds = get_post_meta( $id, 'bedrooms', true );
		$baths = get_post_meta( $id, 'bathrooms', true );
		$squarefeet = get_post_meta( $id, 'squarefootage', true );
		$leasingurl = get_field('leasing_url', 'option');

	}

	if ( $datasource == 'rentcafe' ) {
		
		// API post variables
		$title = $floorplan_from_api['FloorplanName'];
		$excerpt = null; // there is no excerpt if from the API
		$beds = $floorplan_from_api['Beds'];
		$baths = $floorplan_from_api['Baths'];
		$squarefeet = floorplan_range( $floorplan_from_api['MinimumSQFT'], $floorplan_from_api['MaximumSQFT'] );
		$rent = floorplan_price_range( $floorplan_from_api['MinimumRent'], $floorplan_from_api['MaximumRent'] );
		$leasingurl = $floorplan_from_api['AvailabilityURL'];
		$availableunits = $floorplan_from_api['AvailableUnitsCount'];

		// Process the image
		$image_url_full = $floorplan_from_api['FloorplanImageURL'];
		$image_name = $floorplan_from_api['FloorplanImageName'];

		// Replace the image name in the main string with the encoded version (because the image names may contain spaces)
		$image_name_encoded = rawurlencode( $image_name );
		$imagelarge = str_replace( $image_name, $image_name_encoded, $image_url_full );

	}

	$lightboxmarkup = sprintf( "<h2>%s</h2>%s<img src='%s' />", $title, $excerpt, $imagelarge );

	if ( $beds == 0 ) $beds = 'studio';
	if ( $beds == 1 ) $beds = 'one';
	if ( $beds == 2 ) $beds = 'two';
	if ( $beds == 3 ) $beds = 'three';
	if ( $beds == 4 ) $beds = 'four';

	if ( $baths == 1 ) $baths = 'one';
	if ( $baths == 2 ) $baths = 'two';
	if ( $baths == 3 ) $baths = 'three';
	if ( $baths == 4 ) $baths = 'four';

	//* Markup
	if ( $imagelarge ) 
        printf( '<div class="featured-image" style="background-image:url( %s )"></div>', $imagelarge );

    if ( $title || $excerpt ) 
    	echo '<div class="info"><div class="info-container">';
   
			if ( $title )
				printf( '<h3>%s</h3>', $title );

			echo '<div class="info-wrap">';
				
				if ( $beds )
					printf( '<div class="beds column"><div class="label">Beds</div><div class="data">%s</div></div>', $beds );

				if ( $baths )
					printf( '<div class="baths column"><div class="label">Baths</div><div class="data">%s</div></div>', $baths );

				if ( $squarefeet )
					printf( '<div class="squarefeet column"><div class="label">Square Feet</div><div class="data">%s</div></div>', $squarefeet );

				if ( $datasource != 'wordpress' ) {
					if ( $rent )
						printf( '<div class="rent column"><div class="label">Rent</div><div class="data">%s</div></div>', $rent );
				}

			echo '</div>'; // .bedsbathssqrft

			echo '<div class="buttonswrap">';

				//* Only do the Zoom button if we're on the detailed view
				// if ( doing_action( 'add_loop_layout_floorplancarousel-detailed' ) || doing_action( 'add_loop_layout_floorplangrid-detailed' ) )
					printf( '<a class="button button-small" href="#" data-featherlight="%s">View</a>', $imagelarge );

				if ( $leasingurl && $datasource == 'wordpress' )
					printf( '<a href="%s" target="_blank" class="button button-small">Lease now</a>', $leasingurl );

				if ( $datasource == 'rentcafe' ) {
					
					if ( $availableunits >= 1 )
						printf( '<a href="%s" target="_blank" class="button button-small">Lease now</a>', $leasingurl );

					if ( $availableunits == 0 )
						printf( '<a href="#" target="_blank" class="button button-small disabled">Unavailable</a>' );

				}

			echo '</div>'; // .buttonswrap

			if ( current_user_can( 'edit_posts' ) && $datasource == 'wordpress' )
				edit_post_link( 'Edit floorplan', '<div class="edit-floorplans"><small>', '</small></div>', $id, 'post-edit-link' );				


	if ( $title || $excerpt ) 
		echo '</div></div>'; // .info-container, .info
    
}
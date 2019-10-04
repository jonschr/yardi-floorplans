<?php

add_shortcode( 'floorplans', 'do_shortcode_api_loop' );
function do_shortcode_api_loop( $atts ) {

	// We need all the same styles we'd have been using if this was a WordPress loop
	wp_enqueue_style( 'gsq-styles' );

	$atts = shortcode_atts( array(
		'columns' => 1,
		'layout' => 'blank',
		'posts_per_page' => '-1',
		'api_key' => get_field('rentcafeapikey', 'option'),
		'property_code' => get_field('rentcafepropertycode', 'option'),
	), $atts );

	// Default class for the loop container
	$classes = array( 'loop-container' );

	// Add the layout class to the loop container
	array_push( $classes, 'loop-layout-' . $atts['layout'] );

	// Collapse the loop container classes into a string
	$classes = implode( $classes, ' ' );

	// Do the API request
	$url = sprintf( 'https://api.rentcafe.com/rentcafeapi.aspx?requestType=floorplan&apiToken=%s&VoyagerPropertyCode=%s', $atts['api_key'], $atts['property_code'] ); // path to your JSON file
	$data = file_get_contents( $url ); // put the contents of the file into a variable
	$floorplans = json_decode( $data, true ); // decode the JSON feed

	ob_start();
		
		//* Show ALL floorplan data
		// echo '<pre style="text-align: left; font-size: 16px;">';
		// 	print_r( $floorplans );
		// echo '</pre>';
		
		// Error messages
		if ( !$atts['api_key'] )
			echo 'Missing API key, please <a target="_blank" href="/wp-admin/edit.php?post_type=floorplans&page=acf-options-settings">update that here</a>.<br/>';

		if ( !$atts['property_code'] )
			echo 'Missing property code, please <a target="blank" href="/wp-admin/edit.php?post_type=floorplans&page=acf-options-settings">update that here</a>.<br/>';

		// Scripts and styles before the loop
		do_action( 'before_loop_layout_' . $atts['layout'], $floorplans );

		// Do the loop container
		printf( '<div class="%s">', $classes );

			$count = 0;

			foreach( $floorplans as $floorplan ) {

				if ( $count >= $atts['posts_per_page'] && $atts['posts_per_page'] != '-1' )
					break;

				// Default classes for the post
				$floorplanclass = array( 'floorplans', 'type-floorplans', 'status-publish', 'entry' );

				// Get the value for beds for each floorplan
				$beds = $floorplan['Beds'];

				if ( $beds == 0 ) $bedclass = 'sizes-studio';
				if ( $beds == 1 ) $bedclass = 'sizes-one-bedroom';
				if ( $beds == 2 ) $bedclass = 'sizes-two-bedroom';
				if ( $beds == 3 ) $bedclass = 'sizes-three-bedroom';
				if ( $beds == 4 ) $bedclass = 'sizes-four-bedroom';

				// Add the bed class
				array_push( $floorplanclass, $bedclass );

				// Add a thumbnail class
				if ( $floorplan['FloorplanImageURL'] )
					array_push( $floorplanclass, 'has-post-thumbnail' );

				// Collapse the classes into a string
				$floorplanclass = implode( $floorplanclass, ' ' );

				// Article markup
				printf( '<article class="%s">', $floorplanclass );

					echo '<div class="loop-item-inner">';

						// Do the layout
						do_action( 'add_loop_layout_' . $atts['layout'], $floorplan );

					echo '</div>';

				echo '</article>';

				$count++;

				//* Echo details for testing
				// echo '<pre style="text-align: left; font-size: 12px;">';
				// 	print_r( $floorplan );
				// echo '</pre>';

			}

		echo '</div>';

	return ob_get_clean();
}
<?php

function get_floorplan_terms( $args ) {

	$datasource = get_floorplan_data_source( $args );

	// Get the terms the wordpress way
	if ( $datasource == 'wordpress' ) {

		$terms = get_terms( 'sizes', array(
		    'hide_empty' => true,
		) );
	}

	// Get the terms if rentcafe is our datasource
	if ( $datasource == 'rentcafe' ) {

		// Preset our terms var as an array
		$terms = array();

		// Loop through each of the floorplans
		foreach ( $args as $floorplan ) {

			// Get the value for beds for each floorplan
			$beds = $floorplan['Beds'];

			if ( $beds == 0 ) $beds = 'studio';
			if ( $beds == 1 ) $beds = 'one-bedroom';
			if ( $beds == 2 ) $beds = 'two-bedroom';
			if ( $beds == 3 ) $beds = 'three-bedroom';
			if ( $beds == 4 ) $beds = 'four-bedroom';

			// Add the number of beds from the current floorplan to an array
			array_push( $terms, $beds );
		}

		// Our final list of terms is each unique term that appeared
		$terms = array_unique( $terms );
		
	}

	return $terms;

}

/**
 * Take in the min and max, return the range or the value
 */
function floorplan_range( $min, $max ) {

	if ( !$min && !$max )
		return;

	if ( $min && !$max )
		$value = $min;

	if ( !$min && $max )
		$value = $max;

	if ( $min && $max ) {
		
		if ( $min == $max )
			$value = $min;

		if ( $min != $max )
			$value = sprintf( '%s-%s', $min, $max );

	}

	return $value;
}


/**
 * Take in the min and max, return the range or the value
 */
function floorplan_price_range( $min, $max ) {

	if ( !$min && !$max )
		return;

	if ( $min && !$max )
		$value = '$' . $min;

	if ( !$min && $max )
		$value = '$' . $max;

	if ( $min && $max ) {
		
		if ( $min == $max )
			$value = '$' . $min;

		if ( $min != $max )
			$value = sprintf( '$%s-%s', $min, $max );

	}

	return $value;
}
<?php

function get_floorplan_terms( $floorplans ) {

	//* Output the floorplans data for testing
	// echo '<pre style="font-size: 15px;">';
	// 	print_r( $floorplans );
	// echo '</pre>'; 

	$datasource = get_floorplan_data_source( $floorplans );

	// Get the terms the wordpress way
	if ( $datasource == 'wordpress' ) {
		
		$terms = get_terms( 'sizes', array(
		    'hide_empty' => true,
		) );

		return $terms;
	}

	// Get the terms if rentcafe is our datasource
	if ( $datasource == 'rentcafe' ) {

		// Preset our terms var as an array
		$terms = array();
		$termsnamed = array();

		//* Loop through each of the floorplans
		foreach ( $floorplans as $floorplan ) {

			// Get the value for beds for each floorplan
			$beds = $floorplan['Beds'];

			// Add the number of beds from the current floorplan to an array
			array_push( $terms, $beds );
		
		}

		//* Ensure a consistent order
		sort( $terms );

		//* Go through the array again, this time making a new array with names instead of numbers
		foreach ( $terms as $term ) {

			// Get the value for beds for each floorplan
			// $beds = $term['Beds'];

			if ( $term == 0 ) $beds = 'studio';

			if ( $term == 1 ) $beds = 'one-bedroom';

			if ( $term == 2 ) $beds = 'two-bedroom';

			if ( $term == 3 ) $beds = 'three-bedroom';
			
			if ( $term == 4 ) $beds = 'four-bedroom';

			if ( $term == 5 ) $beds = 'five-bedroom';

			if ( $term == 6 ) $beds = 'six-bedroom';

			// Add the number of beds from the current floorplan to an array
			array_push( $termsnamed, $beds );
		}

		// Our final list of terms is each unique term that appeared
		$termsnamed = array_unique( $termsnamed );
		
		return $termsnamed;
	}

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
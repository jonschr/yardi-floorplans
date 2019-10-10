<?php

/**
 * Return the datasource if we have a loop
 * @param  array $args
 * @return string $datasource
 */
function get_floorplan_data_source( $floorplans ) {
	
	// Default datasource is wordpress
	$datasource = 'wordpress';

	//* Output the floorplan data for testing
	// echo '<pre>';
	// print_r( $floorplans );
	// echo '</pre>';

	foreach ( $floorplans as $floorplan ) {
		if ( isset( $floorplan['PropertyId'] ) )
			$datasource = 'rentcafe';
	}

	return $datasource;
}

/**
 * Return the datasource if we have a single item
 * @param  array $args
 * @return string $datasource
 */
function get_floorplan_data_source_single( $floorplan_from_api ) {
	
	// Default datasource is wordpress
	$datasource = 'wordpress';

	// Prevent an undefined offset error
	if ( isset( $floorplan_from_api ) ) {

		// If we have RentCafe data, our source is rentcafe
		if ( $floorplan_from_api['FloorplanName'] )
			$datasource = 'rentcafe';

	}

	return $datasource;
}


<?php
/**
 * Post Types
 *
 * This file registers any custom post types
 *
 * @package      Core_Functionality
 * @since        1.0.0
 * @author       Jon Schroeder <jon@redblue.us>
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */

function floorplans_register_post_types() {

	//* Floorplans
	$name_plural = 'Floorplans';
	$name_singular = 'Floorplan';
	$post_type = 'floorplans';
	$slug = 'floorplans';
	$icon = 'location-alt'; //* https://developer.wordpress.org/resource/dashicons/
	$supports = array( 'title', 'excerpt', 'thumbnail' );

	$labels = array(
		'name' => $name_plural,
		'singular_name' => $name_singular,
		'add_new' => 'Add new',
		'add_new_item' => 'Add new ' . $name_singular,
		'edit_item' => 'Edit ' . $name_singular,
		'new_item' => 'New ' . $name_singular,
		'view_item' => 'View ' . $name_singular,
		'search_items' => 'Search ' . $name_plural,
		'not_found' =>  'No ' . $name_plural . ' found',
		'not_found_in_trash' => 'No ' . $name_plural . ' found in trash',
		'parent_item_colon' => '',
		'menu_name' => $name_plural,
	);

	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'query_var' => true,
		'rewrite' => true,
		'capability_type' => 'post',
		'rewrite' => array( 'slug' => $slug ),
		'has_archive' => false,
		'hierarchical' => false,
		'menu_position' => null,
		'menu_icon' => 'dashicons-' . $icon,
		'supports' => $supports,
	);

	register_post_type( $post_type, $args );
}

add_action( 'init', 'floorplans_register_post_types' );


//* Redirect single resources to the commissioners' resource page
add_action( 'template_redirect', 'elodin_redirect_floorplans' );
function elodin_redirect_floorplans() {
    if ( !is_singular( 'floorplans' ) || is_admin() )
        return;

    wp_redirect( home_url() . '/floor-plans/', 301 );

    exit;
}

//* Helper function for all of the layouts
function get_beds_baths_markup( $id ) {

	//* Get the vars
	$beds = get_post_meta( $id, 'bedrooms', true );
	$baths = get_post_meta( $id, 'bathrooms', true );

	//* Bail if there aren't any
	if ( !$beds && !$baths )
		return;

	//* Figure out the numbers
	if ( $beds == 1 )
		$beds = '1 bedroom';

	if ( $beds > 1 )
		$beds = $beds . ' ' . 'bedrooms';

	if ( $baths == 1 )
		$baths = '1 bathroom';

	if ( $baths > 1 )
		$baths = $baths . ' ' . 'bathrooms';

	//* Figure out what we return
	if ( $beds && $baths )
		return $beds . ', ' . $baths;

	if ( $beds && !$baths )
		return $beds;

	if ( !$beds && $baths )
		return $baths;

}
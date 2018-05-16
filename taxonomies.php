<?php
/**
 * Taxonomies
 *
 * This file registers any custom taxonomies
 *
 * @package      Core_Functionality
 * @since        1.0.0
 * @link         https://github.com/billerickson/Core-Functionality
 * @author       Bill Erickson <bill@billerickson.net>
 * @copyright    Copyright (c) 2011, Bill Erickson
 * @license      http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */


/**
 * Create Location Taxonomy
 *
 * @since 1.0.0
 * @link http://codex.wordpress.org/Function_Reference/register_taxonomy
 */

function rb_register_core_taxonomies() {
	
	//* Sizes
	$labels = array(
		'name' => 'Sizes',
		'singular_name' => 'Size',
		'search_items' =>  'Search Sizes',
		'all_items' => 'All Sizes',
		'parent_item' => 'Parent Size',
		'parent_item_colon' => 'Parent Size:',
		'edit_item' => 'Edit Size',
		'update_item' => 'Update Size',
		'add_new_item' => 'Add New Size',
		'new_item_name' => 'New Size',
		'menu_name' => 'Sizes'
	);

	register_taxonomy( 'sizes', array( 'floorplans' ),
		array(
			'hierarchical' => true,
			'labels' => $labels,
			'show_ui' => true,
			'show_admin_column' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => 'sizes' ),
		)
	);
}

add_action( 'init', 'rb_register_core_taxonomies' );

//* Disable "featured" submenu page
add_action( 'admin_menu', 'remove_custom_tax_wp_menu', 999 );
function remove_custom_tax_wp_menu() {
	remove_submenu_page( 'edit.php', 'edit-tags.php?taxonomy=featured' );
	remove_submenu_page( 'edit.php?post_type=page', 'edit-tags.php?taxonomy=featured' );
	/* See reference: http://codex.wordpress.org/remove_submenu_page#Examples */
}
<?php
/*
    Plugin Name: Floorplans: Yardi
    Plugin URI: https://github.com/jonschr/yardi-floorplans
    Description: Just another Floorplans plugin
    Version: 3.1.4
    Author: Brindle Digital
    Author URI: https://www.brindledigital.com/

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
    GNU General Public License for more details.
*/

/////////////////
// BASIC SETUP //
/////////////////

// Plugin directory
define( 'YARDI_FLOORPLANS', dirname( __FILE__ ) );

// Define the version of the plugin
define ( 'YARDI_FLOORPLANS_VERSION', '3.1.4' );


//* If we don't have Genesis running, let's bail out right there
$theme = wp_get_theme(); // gets the current theme
if ( 'genesis' != $theme['Template'] )
    return;

/**
 * Add a notification if ACF isn't installed and active
 */
add_action( 'admin_notices', 'floorplans_error_notice_ACF' );
function floorplans_error_notice_ACF() {

    if( !class_exists( 'acf' ) ) {
        echo '<div class="error notice"><p>Please install and activate the <a target="_blank" href="https://www.advancedcustomfields.com/pro/">Advanced Custom Fields Pro</a> plugin. Without it, the Floorplans plugin won\'t work properly.</p></div>';
    }

    //* Testing to see whether we have the Pro version of ACF installed
    if( class_exists( 'acf' ) && !class_exists( 'acf_pro_updates' ) ) {
        echo '<div class="error notice"><p>It looks like you\'ve installed the free version of Advanced Custom Fields. To work properly, the Floorplans plugin requires <a target="_blank" href="https://www.advancedcustomfields.com/pro/">the Pro version</a> instead.</p></div>';
    }
}

// Updater
require 'vendor/plugin-update-checker/plugin-update-checker.php';
$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
	'https://github.com/jonschr/yardi-floorplans',
	__FILE__,
	'yardi-floorplans'
);

// Optional: Set the branch that contains the stable release.
$myUpdateChecker->setBranch('master');


//////////////////////////
// PLUGIN CUSTOMIZATION //
//////////////////////////

// Register the API shortcode
require_once( 'shortcode_api/floorplans_shortcode.php' );

// Register options page
require_once 'floorplan-options.php';

// Register post types
require_once 'post_types.php';

// Register taxonomies
require_once 'taxonomies.php';

// Get common layout components
require_once 'layouts/common-functions.php';
require_once 'layouts/common-before.php';
require_once 'layouts/common-internal.php';

// Get other functions
require_once( 'shortcode_api/data-source-detection.php' );

// Register layouts
require_once 'layouts/floorplancarousel.php';
require_once 'layouts/floorplanslider.php';
require_once 'layouts/floorplans.php';

// Register fields
require_once 'fields.php';

///////////////////////////////////
// STYLE AND SCRIPT REGISTRATION //
///////////////////////////////////

add_action( 'wp_enqueue_scripts', 'floorplans_enqueue' );
add_action( 'enqueue_block_assets', 'floorplans_enqueue' );
/**
 * Enqueues scripts and styles.
 *
 * @since 1.0.0
 */
function floorplans_enqueue() {

    // Plugin styles
    wp_enqueue_style( 'floorplan-styles', plugin_dir_url( __FILE__ ) . 'css/floorplan.css', array(), YARDI_FLOORPLANS_VERSION );

    // Slick general
    wp_register_style( 'floorplan-slick-main-style', plugin_dir_url( __FILE__ ) . 'slick/slick.css', array(), YARDI_FLOORPLANS_VERSION );
    wp_register_style( 'floorplan-slick-main-theme', plugin_dir_url( __FILE__ ) . 'slick/slick-theme.css', array(), YARDI_FLOORPLANS_VERSION );
    wp_register_script( 'floorplan-slick-main-load', plugin_dir_url( __FILE__ ) . 'slick/slick.min.js', array( 'jquery' ), YARDI_FLOORPLANS_VERSION, true );
    
    

    // Carousel only
    wp_register_script( 'floorplan-slick-carousel-init', plugin_dir_url( __FILE__ ) . 'js/floorplancarousel-init.js', array( 'floorplan-slick-main-load' ), YARDI_FLOORPLANS_VERSION, true );

    // Slider only
    wp_register_script( 'floorplan-slick-slider-init', plugin_dir_url( __FILE__ ) . 'js/floorplanslider-init.js', array( 'floorplan-slick-main-load' ), YARDI_FLOORPLANS_VERSION, true );

    // Featherlight general
    wp_register_style( 'floorplan-featherlight-style', plugin_dir_url( __FILE__ ) . 'featherlight/release/featherlight.min.css', array(), YARDI_FLOORPLANS_VERSION );
    wp_register_script( 'floorplan-featherlight-main', plugin_dir_url( __FILE__ ) . 'featherlight/release/featherlight.min.js', array( 'jquery' ), YARDI_FLOORPLANS_VERSION, true );   
    wp_register_style( 'floorplan-featherlight-style', plugin_dir_url( __FILE__ ) . 'featherlight/release/featherlight.min.css', array(), YARDI_FLOORPLANS_VERSION );

}


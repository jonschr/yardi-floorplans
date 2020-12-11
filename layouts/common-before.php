<?php

add_action( 'before_loop_layout_floorplans', 'floorplans_add_gform_lightbox' );
add_action( 'before_loop_layout_floorplans-detailed', 'floorplans_add_gform_lightbox' );
add_action( 'before_loop_layout_floorplancarousel', 'floorplans_add_gform_lightbox' );
add_action( 'before_loop_layout_floorplancarousel-detailed', 'floorplans_add_gform_lightbox' );
add_action( 'before_loop_layout_floorplanslider', 'floorplans_add_gform_lightbox' );
add_action( 'before_loop_layout_floorplanslider-detailed', 'floorplans_add_gform_lightbox' );
function floorplans_add_gform_lightbox() {
            
    $gform_id = get_field('gform_id', 'option' );
    
    if ( !$gform_id )
        return;
        
    echo '<div id="floorplans-gform-lightbox" class="floorplans-gform-lightbox">';
        echo do_shortcode( '[gravityform id=2 title=true description=true ajax=true tabindex=49]' );
    echo '</div>';
        
}
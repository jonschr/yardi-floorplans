<?php

add_action( 'admin_menu', 'floorplan_options' );
function floorplan_options() {

	//* Create the settings subpage
	if( function_exists('acf_add_options_page') ) {
		acf_add_options_sub_page(array(
			'page_title' 	=> 'Floorplan Options',
			'menu_title'	=> 'Settings',
			'parent_slug'	=> 'edit.php?post_type=floorplans',
		));
	}

	//* Register the fields
	if( function_exists('acf_add_local_field_group') ):

		acf_add_local_field_group(array(
			'key' => 'group_5b046dc4f0a0c',
			'title' => 'Floorplan Global Settings',
			'fields' => array(
				array(
					'key' => 'field_5b046dd51dc52',
					'label' => 'Leasing URL',
					'name' => 'leasing_url',
					'type' => 'url',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
				),
				array(
					'key' => 'field_5b046dd51dc523',
					'label' => 'RentCafe API key',
					'name' => 'rentcafeapikey',
					'type' => 'text',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'default_value' => '',
					'placeholder' => '',
				),
				array(
					'key' => 'field_5b046dd51dc524',
					'label' => 'RentCafe Property Code',
					'name' => 'rentcafepropertycode',
					'type' => 'text',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'default_value' => '',
					'placeholder' => '',
				),
			),
			'location' => array(
				array(
					array(
						'param' => 'options_page',
						'operator' => '==',
						'value' => 'acf-options-settings',
					),
				),
			),
			'menu_order' => 0,
			'position' => 'normal',
			'style' => 'seamless',
			'label_placement' => 'top',
			'instruction_placement' => 'label',
			'hide_on_screen' => '',
			'active' => 1,
			'description' => '',
		));

		endif;
}
<?php
/* Date & Time Picker support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'nelson_date_time_picker_field_theme_setup9' ) ) {
	add_action( 'after_setup_theme', 'nelson_date_time_picker_field_theme_setup9', 9 );
	function nelson_date_time_picker_field_theme_setup9() {
		if ( is_admin() ) {
			add_filter( 'nelson_filter_tgmpa_required_plugins', 'nelson_date_time_picker_field_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( ! function_exists( 'nelson_date_time_picker_field_tgmpa_required_plugins' ) ) {
		function nelson_date_time_picker_field_tgmpa_required_plugins( $list = array() ) {
		if ( nelson_storage_isset( 'required_plugins', 'date-time-picker-field' ) && nelson_storage_get_array( 'required_plugins', 'date-time-picker-field', 'install' ) !== false ) {
			$list[] = array(
				'name'     => nelson_storage_get_array( 'required_plugins', 'date-time-picker-field', 'title' ),
				'slug'     => 'date-time-picker-field',
				'required' => false,
			);
		}
		return $list;
	}
}

// Check if this plugin installed and activated
if ( ! function_exists( 'nelson_exists_date_time_picker_field' ) ) {
	function nelson_exists_date_time_picker_field() {
		return class_exists( 'CMoreira\\Plugins\\DateTimePicker\\Init' );
	}
}

// Set plugin's specific importer options
if ( !function_exists( 'nelson_date_time_picker_field_importer_set_options' ) ) {
	add_filter( 'trx_addons_filter_importer_options',	'nelson_date_time_picker_field_importer_set_options' );
	function nelson_date_time_picker_field_importer_set_options($options=array()) {
		if ( nelson_exists_date_time_picker_field() && in_array('date-time-picker-field', $options['required_plugins']) ) {
			if (is_array($options)) {
				$options['additional_options'][] = 'dtpicker';
			}
		}
		return $options;
	}
}
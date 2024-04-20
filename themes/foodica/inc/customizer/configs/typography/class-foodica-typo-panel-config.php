<?php
/**
 * Foodica Lite: Adds settings, sections, controls to Customizer
 *
 * @package Foodica
 * @subpackage Foodica_Lite
 * @since Foodica 1.2.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * PHP Class for Registering Customizer Confugration
 *
 * @since 1.2.3
 */
class Foodica_Typo_Panel_Config {
	/**
	 * Configurations
	 *
	 * @since 1.2.3 Store configurations to class method.
	 * @return array
	 */
	public static function config() {
		return array(
			'panel' => array(
				'id'   => 'foodica_typography_panel',
				'args' => array(
					'priority'   => 40,
					'capability' => 'edit_theme_options',
					'title'      => esc_html__( 'Typography', 'foodica' ),
				),
			),
		);
	}
}

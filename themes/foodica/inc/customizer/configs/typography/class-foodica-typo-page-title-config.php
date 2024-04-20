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
class Foodica_Typo_Page_Title_Config {
	/**
	 * Configurations
	 *
	 * @since 1.2.3 Store configurations to class method.
	 *
	 * @param WP_Customize_Manager $wp_customize instance of WP_Customize_Manager.
	 * @return array
	 */
	public static function config( $wp_customize ) {
		return array(
			'section' => array(
				'id'   => 'foodica_typography_section_page_title',
				'args' => array(
					'title' => __( 'Single Page Title', 'foodica' ),
					'panel' => 'foodica_typography_panel',
				),
			),
			'setting' => array(
				array(
					'id'   => 'page-title-font-family',
					'args' => array(
						'transport'         => 'postMessage',
						'sanitize_callback' => 'sanitize_text_field',
						'default'           => "'Inter', sans-serif",
					),
				),
				array(
					'id'   => 'page-title-font-variant',
					'args' => array(
						'transport'         => 'postMessage',
						'sanitize_callback' => 'foodica_sanitize_font_variant',
						'default'           => '600',
					),
				),
				array(
					'id'   => 'page-title-font-size',
					'args' => array(
						'default'           => 38,
						'transport'         => 'postMessage',
						'sanitize_callback' => 'foodica_sanitize_integer',
					),
				),
				array(
					'id'   => 'page-title-font-weight',
					'args' => array(
						'default'           => '600',
						'transport'         => 'postMessage',
						'sanitize_callback' => 'foodica_sanitize_font_weight',
					),
				),
				array(
					'id'   => 'page-title-text-transform',
					'args' => array(
						'default'           => '',
						'transport'         => 'postMessage',
						'sanitize_callback' => 'foodica_sanitize_choices',
					),
				),
				array(
					'id'   => 'page-title-line-height',
					'args' => array(
						'default'           => 1.4,
						'transport'         => 'postMessage',
						'sanitize_callback' => 'foodica_sanitize_float',
					),
				),
			),
			'control' => array(
				array(
					'id'           => 'page-title-font-family',
					'control_type' => 'Foodica_Customize_Typography_Control',
					'args'         => array(
						'label'   => __( 'Font Family', 'foodica' ),
						'section' => 'foodica_typography_section_page_title',
						'connect' => 'page-title-font-weight',
						'variant' => 'page-title-font-variant',
					),
				),
				array(
					'id'           => 'page-title-font-variant',
					'control_type' => 'Foodica_Customize_Font_Variant_Control',
					'args'         => array(
						'label'       => __( 'Variants', 'foodica' ),
						'description' => __( 'Only selected Font Variants will be loaded from Google Fonts.', 'foodica' ),
						'section'     => 'foodica_typography_section_page_title',
						'connect'     => 'page-title-font-family',
					),
				),
				array(
					'id'           => 'page-title-font-size',
					'control_type' => 'Foodica_Customize_Range_Control',
					'args'         => array(
						'label'       => __( 'Font Size (px)', 'foodica' ),
						'section'     => 'foodica_typography_section_page_title',
						'input_attrs' => array(
							'min'  => 14,
							'max'  => 100,
							'step' => 1,
						),
					),
				),
				array(
					'id'               => 'page-title-font-weight',
					'args'             => array(
						'label'   => __( 'Font Weight', 'foodica' ),
						'section' => 'foodica_typography_section_page_title',
						'type'    => 'select',
						'choices' => array(),
					),
					'callable_choices' => array(
						array( 'Foodica_Font_Family_Manager', 'get_font_family_weight' ),
						array( 'page-title-font-family', $wp_customize ),
					),
				),
				array(
					'id'   => 'page-title-text-transform',
					'args' => array(
						'label'   => __( 'Text Transform', 'foodica' ),
						'section' => 'foodica_typography_section_page_title',
						'type'    => 'select',
						'choices' => array(
							''           => _x( 'Inherit', 'text transform', 'foodica' ),
							'none'       => _x( 'None', 'text transform', 'foodica' ),
							'capitalize' => __( 'Capitalize', 'foodica' ),
							'uppercase'  => __( 'Uppercase', 'foodica' ),
							'lowercase'  => __( 'Lowercase', 'foodica' ),
						),
					),
				),
				array(
					'id'           => 'page-title-line-height',
					'control_type' => 'Foodica_Customize_Range_Control',
					'args'         => array(
						'label'       => __( 'Line Height', 'foodica' ),
						'section'     => 'foodica_typography_section_page_title',
						'input_attrs' => array(
							'min'  => 1,
							'max'  => 2,
							'step' => 0.1,
						),
					),
				),
			),
		);
	}
}

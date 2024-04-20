<?php
/**
 * Generate inline css based on Customizer settings value
 *
 * @package Foodica
 * @subpackage Foodica_Lite
 * @since Foodica 1.2.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

add_filter( 'foodica/dynamic_theme_css/selectors', 'foodica_selector_widgets' );

if ( ! function_exists( 'foodica_selector_widgets' ) ) {
	/**
	 * Set HTML selector for Widgets Title
	 *
	 * @param array $selectors HTML selectors.
	 * @return array The array with HTML selectors.
	 */
	function foodica_selector_widgets( $selectors ) {
		$selectors['typo-widget-title']            = '.widget h3.title';
		$selectors['widget-title-font-size-media'] = '@media screen and (min-width: 782px)';
		return $selectors;
	}
}

add_filter( 'foodica/dynamic_theme_css', 'foodica_dynamic_theme_css_widgets' );

/**
 * Typography -> Widgets Title
 *
 * @param string $dynamic_css Dynamic CSS from Customizer.
 * @return string Generated dynamic CSS for Widgets Title.
 */
function foodica_dynamic_theme_css_widgets( $dynamic_css ) {
	

	$widgets_title_font_family    = foodica_get_font_stacks( foodica_get_theme_mod( 'widget-title-font-family' ) );
	$widgets_title_font_size      = foodica_get_theme_mod( 'widget-title-font-size' );
	$widgets_title_font_weight    = foodica_get_theme_mod( 'widget-title-font-weight' );
	$widgets_title_text_transform = foodica_get_theme_mod( 'widget-title-text-transform' );
	$widgets_title_line_height    = foodica_get_theme_mod( 'widget-title-line-height' );
	$selectors   = apply_filters( 'foodica/dynamic_theme_css/selectors', array() );
	$selector    = foodica_get_prop( $selectors, 'typo-widget-title' );
	$media_query = foodica_get_prop( $selectors, 'widget-title-font-size-media' );

	$dynamic_css .= "{$selector} {\n";
	if ( ! empty( $widgets_title_font_family ) && 'inherit' !== $widgets_title_font_family ) {
		$dynamic_css .= "font-family: {$widgets_title_font_family};\n";
	}
	if ( ! empty( $widgets_title_font_weight ) && 'inherit' !== $widgets_title_font_weight ) {
		$dynamic_css .= "font-weight: {$widgets_title_font_weight};\n";
	}
	if ( ! empty( $widgets_title_text_transform ) && 'inherit' !== $widgets_title_text_transform ) {
		$dynamic_css .= "text-transform: {$widgets_title_text_transform};\n";
	}
	$dynamic_css .= "}\n";

	$dynamic_css .= "{$media_query} {\n";
	$dynamic_css .= "{$selector} {\n";
	if ( absint( $widgets_title_font_size ) >= 12 && absint( $widgets_title_font_size ) <= 36 ) {
		$dynamic_css .= "font-size: {$widgets_title_font_size}px;\n";
	}
	if ( ! empty( $widgets_title_line_height ) && 'inherit' !== $widgets_title_line_height ) {
		$dynamic_css .= "line-height: {$widgets_title_line_height};\n";
	}
	$dynamic_css .= "} }\n";

	return $dynamic_css;
}

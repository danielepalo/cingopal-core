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

add_filter( 'foodica/dynamic_theme_css/selectors', 'foodica_selector_top_menu' );

if ( ! function_exists( 'foodica_selector_top_menu' ) ) {
	/**
	 * Set HTML selector for Top Menu
	 *
	 * @param array $selectors HTML selectors.
	 * @return array The array with HTML selectors.
	 */
	function foodica_selector_top_menu( $selectors ) {
		$selectors['typo-topmenu']            = '.top-navbar a';
		$selectors['topmenu-font-size-media'] = '@media screen and (min-width: 782px)';
		return $selectors;
	}
}

add_filter( 'foodica/dynamic_theme_css', 'foodica_dynamic_theme_css_top_menu' );

/**
 * Typography -> Top Menu
 *
 * @param string $dynamic_css Dynamic CSS from Customizer.
 * @return string Generated dynamic CSS for Top Menu.
 */
function foodica_dynamic_theme_css_top_menu( $dynamic_css ) {
	

	$top_menu_font_family    = foodica_get_font_stacks( foodica_get_theme_mod( 'topmenu-font-family' ) );
	$top_menu_font_size      = foodica_get_theme_mod( 'topmenu-font-size' );
	$top_menu_font_weight    = foodica_get_theme_mod( 'topmenu-font-weight' );
	$top_menu_text_transform = foodica_get_theme_mod( 'topmenu-text-transform' );
	$top_menu_line_height    = foodica_get_theme_mod( 'topmenu-line-height' );
	$selectors   = apply_filters( 'foodica/dynamic_theme_css/selectors', array() );
	$selector    = foodica_get_prop( $selectors, 'typo-topmenu' );
	$media_query = foodica_get_prop( $selectors, 'topmenu-font-size-media' );

	$dynamic_css .= "{$selector} {\n";
	if ( ! empty( $top_menu_font_family ) && 'inherit' !== $top_menu_font_family ) {
		$dynamic_css .= "font-family: {$top_menu_font_family};\n";
	}
	if ( ! empty( $top_menu_font_weight ) && 'inherit' !== $top_menu_font_weight ) {
		$dynamic_css .= "font-weight: {$top_menu_font_weight};\n";
	}
	if ( ! empty( $top_menu_text_transform ) && 'inherit' !== $top_menu_text_transform ) {
		$dynamic_css .= "text-transform: {$top_menu_text_transform};\n";
	}
	$dynamic_css .= "}\n";

	$dynamic_css .= "{$media_query} {\n";
	$dynamic_css .= "{$selector} {\n";
	if ( absint( $top_menu_font_size ) >= 12 && absint( $top_menu_font_size ) <= 36 ) {
		$dynamic_css .= "font-size: {$top_menu_font_size}px;\n";
	}
	if ( ! empty( $top_menu_line_height ) && 'inherit' !== $top_menu_line_height ) {
		$dynamic_css .= "line-height: {$top_menu_line_height};\n";
	}
	$dynamic_css .= "} }\n";

	return $dynamic_css;
}

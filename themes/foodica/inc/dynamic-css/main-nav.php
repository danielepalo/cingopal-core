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

add_filter( 'foodica/dynamic_theme_css/selectors', 'foodica_selector_main_nav' );

if ( ! function_exists( 'foodica_selector_main_nav' ) ) {
	/**
	 * Set HTML selector for Main Navigation
	 *
	 * @param array $selectors HTML selectors.
	 * @return array The array with HTML selectors.
	 */
	function foodica_selector_main_nav( $selectors ) {
		$selectors['typo-mainmenu']            = '.main-navbar a';
		$selectors['mainmenu-font-size-media'] = '@media screen and (min-width: 782px)';
		return $selectors;
	}
}

add_filter( 'foodica/dynamic_theme_css', 'foodica_dynamic_theme_css_main_nav' );

/**
 * Typography -> Main Navigation
 *
 * @param string $dynamic_css Dynamic CSS from Customizer.
 * @return string Generated dynamic CSS for Main Navigation.
 */
function foodica_dynamic_theme_css_main_nav( $dynamic_css ) {
	

	$main_nav_font_family    = foodica_get_font_stacks( foodica_get_theme_mod( 'mainmenu-font-family' ) );
	$main_nav_font_size      = foodica_get_theme_mod( 'mainmenu-font-size' );
	$main_nav_font_weight    = foodica_get_theme_mod( 'mainmenu-font-weight' );
	$main_nav_text_transform = foodica_get_theme_mod( 'mainmenu-text-transform' );
	$main_nav_line_height    = foodica_get_theme_mod( 'mainmenu-line-height' );
	$selectors   = apply_filters( 'foodica/dynamic_theme_css/selectors', array() );
	$selector    = foodica_get_prop( $selectors, 'typo-mainmenu' );
	$media_query = foodica_get_prop( $selectors, 'mainmenu-font-size-media' );

	$dynamic_css .= "{$selector} {\n";
	if ( ! empty( $main_nav_font_family ) && 'inherit' !== $main_nav_font_family ) {
		$dynamic_css .= "font-family: {$main_nav_font_family};\n";
	}
	if ( ! empty( $main_nav_font_weight ) && 'inherit' !== $main_nav_font_weight ) {
		$dynamic_css .= "font-weight: {$main_nav_font_weight};\n";
	}
	if ( ! empty( $main_nav_text_transform ) && 'inherit' !== $main_nav_text_transform ) {
		$dynamic_css .= "text-transform: {$main_nav_text_transform};\n";
	}
	$dynamic_css .= "}\n";

	$dynamic_css .= "{$media_query} {\n";
	$dynamic_css .= "{$selector} {\n";
	if ( absint( $main_nav_font_size ) >= 12 && absint( $main_nav_font_size ) <= 36 ) {
		$dynamic_css .= "font-size: {$main_nav_font_size}px;\n";
	}
	if ( ! empty( $main_nav_line_height ) && 'inherit' !== $main_nav_line_height ) {
		$dynamic_css .= "line-height: {$main_nav_line_height};\n";
	}
	$dynamic_css .= "} }\n";

	return $dynamic_css;
}

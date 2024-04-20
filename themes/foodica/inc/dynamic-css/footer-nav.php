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

add_filter( 'foodica/dynamic_theme_css/selectors', 'foodica_selector_footer_nav' );

if ( ! function_exists( 'foodica_selector_footer_nav' ) ) {
	/**
	 * Set HTML selector for Main Navigation
	 *
	 * @param array $selectors HTML selectors.
	 * @return array The array with HTML selectors.
	 */
	function foodica_selector_footer_nav( $selectors ) {
		$selectors['typo-footer-menu']            = '.footer-menu ul li';
		$selectors['footer-menu-font-size-media'] = '@media screen and (min-width: 782px)';
		return $selectors;
	}
}

add_filter( 'foodica/dynamic_theme_css', 'foodica_dynamic_theme_css_footer_nav' );

/**
 * Typography -> Main Navigation
 *
 * @param string $dynamic_css Dynamic CSS from Customizer.
 * @return string Generated dynamic CSS for Main Navigation.
 */
function foodica_dynamic_theme_css_footer_nav( $dynamic_css ) {
	

	$footer_nav_font_family    = foodica_get_font_stacks( foodica_get_theme_mod( 'footer-menu-font-family' ) );
	$footer_nav_font_size      = foodica_get_theme_mod( 'footer-menu-font-size' );
	$footer_nav_font_weight    = foodica_get_theme_mod( 'footer-menu-font-weight' );
	$footer_nav_text_transform = foodica_get_theme_mod( 'footer-menu-text-transform' );
	$footer_nav_line_height    = foodica_get_theme_mod( 'footer-menu-line-height' );
	$selectors   = apply_filters( 'foodica/dynamic_theme_css/selectors', array() );
	$selector    = foodica_get_prop( $selectors, 'typo-footer-menu' );
	$media_query = foodica_get_prop( $selectors, 'footer-menu-font-size-media' );

	$dynamic_css .= "{$selector} {\n";
	if ( ! empty( $footer_nav_font_family ) && 'inherit' !== $footer_nav_font_family ) {
		$dynamic_css .= "font-family: {$footer_nav_font_family};\n";
	}
	if ( ! empty( $footer_nav_font_weight ) && 'inherit' !== $footer_nav_font_weight ) {
		$dynamic_css .= "font-weight: {$footer_nav_font_weight};\n";
	}
	if ( ! empty( $footer_nav_text_transform ) && 'inherit' !== $footer_nav_text_transform ) {
		$dynamic_css .= "text-transform: {$footer_nav_text_transform};\n";
	}
	$dynamic_css .= "}\n";

	$dynamic_css .= "{$media_query} {\n";
	$dynamic_css .= "{$selector} {\n";
	if ( absint( $footer_nav_font_size ) >= 12 && absint( $footer_nav_font_size ) <= 36 ) {
		$dynamic_css .= "font-size: {$footer_nav_font_size}px;\n";
	}
	if ( ! empty( $footer_nav_line_height ) && 'inherit' !== $footer_nav_line_height ) {
		$dynamic_css .= "line-height: {$footer_nav_line_height};\n";
	}
	$dynamic_css .= "} }\n";

	return $dynamic_css;
}

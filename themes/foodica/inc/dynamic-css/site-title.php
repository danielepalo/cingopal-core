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

add_filter( 'foodica/dynamic_theme_css/selectors', 'foodica_selector_site_title' );

if ( ! function_exists( 'foodica_selector_site_title' ) ) {
	/**
	 * Set HTML selector for Site Title
	 *
	 * @param array $selectors HTML selectors.
	 * @return array The array with HTML selectors.
	 */
	function foodica_selector_site_title( $selectors ) {
		$selectors['typo-title']            = '.navbar-brand-wpz h2';
		$selectors['title-font-size-media'] = '@media screen and (min-width: 782px)';
		return $selectors;
	}
}

add_filter( 'foodica/dynamic_theme_css', 'foodica_dynamic_theme_css_site_title' );

/**
 * Typography -> Site Title
 *
 * @param string $dynamic_css Dynamic CSS from Customizer.
 * @return string Generated dynamic CSS for Site Title.
 */
function foodica_dynamic_theme_css_site_title( $dynamic_css ) {
	

	$site_title_font_family    = foodica_get_font_stacks( foodica_get_theme_mod( 'title-font-family' ) );
	$site_title_font_size      = foodica_get_theme_mod( 'title-font-size' );
	$site_title_font_weight    = foodica_get_theme_mod( 'title-font-weight' );
	$site_title_text_transform = foodica_get_theme_mod( 'title-text-transform' );
	$site_title_line_height    = foodica_get_theme_mod( 'title-line-height' );
	$selectors   = apply_filters( 'foodica/dynamic_theme_css/selectors', array() );
	$selector    = foodica_get_prop( $selectors, 'typo-title' );
	$media_query = foodica_get_prop( $selectors, 'title-font-size-media' );

	$dynamic_css .= "{$selector} {\n";
	if ( ! empty( $site_title_font_family ) && 'inherit' !== $site_title_font_family ) {
		$dynamic_css .= "font-family: {$site_title_font_family};\n";
	}
	if ( ! empty( $site_title_font_weight ) && 'inherit' !== $site_title_font_weight ) {
		$dynamic_css .= "font-weight: {$site_title_font_weight};\n";
	}
	if ( ! empty( $site_title_text_transform ) && 'inherit' !== $site_title_text_transform ) {
		$dynamic_css .= "text-transform: {$site_title_text_transform};\n";
	}
	$dynamic_css .= "}\n";

	$dynamic_css .= "{$media_query} {\n";
	$dynamic_css .= "{$selector} {\n";
	if ( absint( $site_title_font_size ) >= 12 && absint( $site_title_font_size ) <= 36 ) {
		$dynamic_css .= "font-size: {$site_title_font_size}px;\n";
	}
	if ( ! empty( $site_title_line_height ) && 'inherit' !== $site_title_line_height ) {
		$dynamic_css .= "line-height: {$site_title_line_height};\n";
	}
	$dynamic_css .= "} }\n";

	return $dynamic_css;
}

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

add_filter( 'foodica/dynamic_theme_css/selectors', 'foodica_selector_site_description' );

if ( ! function_exists( 'foodica_selector_site_description' ) ) {
	/**
	 * Set HTML selector for Site Description
	 *
	 * @param array $selectors HTML selectors.
	 * @return array The array with HTML selectors.
	 */
	function foodica_selector_site_description( $selectors ) {
		$selectors['typo-description']            = '.navbar-brand-wpz .site-description';
		$selectors['description-font-size-media'] = '@media screen and (min-width: 782px)';
		return $selectors;
	}
}

add_filter( 'foodica/dynamic_theme_css', 'foodica_dynamic_theme_css_site_description' );

/**
 * Typography -> Site Description
 *
 * @param string $dynamic_css Dynamic CSS from Customizer.
 * @return string Generated dynamic CSS for Site Description.
 */
function foodica_dynamic_theme_css_site_description( $dynamic_css ) {
	

	$site_description_font_family    = foodica_get_font_stacks( foodica_get_theme_mod( 'description-font-family' ) );
	$site_description_font_size      = foodica_get_theme_mod( 'description-font-size' );
	$site_description_font_weight    = foodica_get_theme_mod( 'description-font-weight' );
	$site_description_text_transform = foodica_get_theme_mod( 'description-text-transform' );
	$site_description_line_height    = foodica_get_theme_mod( 'description-line-height' );
	$selectors   = apply_filters( 'foodica/dynamic_theme_css/selectors', array() );
	$selector    = foodica_get_prop( $selectors, 'typo-description' );
	$media_query = foodica_get_prop( $selectors, 'description-font-size-media' );

	$dynamic_css .= "{$selector} {\n";
	if ( ! empty( $site_description_font_family ) && 'inherit' !== $site_description_font_family ) {
		$dynamic_css .= "font-family: {$site_description_font_family};\n";
	}
	if ( ! empty( $site_description_font_weight ) && 'inherit' !== $site_description_font_weight ) {
		$dynamic_css .= "font-weight: {$site_description_font_weight};\n";
	}
	if ( ! empty( $site_description_text_transform ) && 'inherit' !== $site_description_text_transform ) {
		$dynamic_css .= "text-transform: {$site_description_text_transform};\n";
	}
	$dynamic_css .= "}\n";

	$dynamic_css .= "{$media_query} {\n";
	$dynamic_css .= "{$selector} {\n";
	if ( absint( $site_description_font_size ) >= 12 && absint( $site_description_font_size ) <= 36 ) {
		$dynamic_css .= "font-size: {$site_description_font_size}px;\n";
	}
	if ( ! empty( $site_description_line_height ) && 'inherit' !== $site_description_line_height ) {
		$dynamic_css .= "line-height: {$site_description_line_height};\n";
	}
	$dynamic_css .= "} }\n";

	return $dynamic_css;
}

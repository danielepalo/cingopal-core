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

add_filter( 'foodica/dynamic_theme_css/selectors', 'foodica_selector_single_page_title' );

if ( ! function_exists( 'foodica_selector_single_page_title' ) ) {
	/**
	 * Set HTML selector for Site Title
	 *
	 * @param array $selectors HTML selectors.
	 * @return array The array with HTML selectors.
	 */
	function foodica_selector_single_page_title( $selectors ) {
		$selectors['typo-page-title']            = '.page h1.entry-title';
		$selectors['page-title-font-size-media'] = '@media screen and (min-width: 782px)';
		return $selectors;
	}
}

add_filter( 'foodica/dynamic_theme_css', 'foodica_dynamic_theme_css_single_page_title' );

/**
 * Typography -> Site Title
 *
 * @param string $dynamic_css Dynamic CSS from Customizer.
 * @return string Generated dynamic CSS for Site Title.
 */
function foodica_dynamic_theme_css_single_page_title( $dynamic_css ) {
	

	$page_title_font_family    = foodica_get_font_stacks( foodica_get_theme_mod( 'page-title-font-family' ) );
	$page_title_font_size      = foodica_get_theme_mod( 'page-title-font-size' );
	$page_title_font_weight    = foodica_get_theme_mod( 'page-title-font-weight' );
	$page_title_text_transform = foodica_get_theme_mod( 'page-title-text-transform' );
	$page_title_line_height    = foodica_get_theme_mod( 'page-title-line-height' );
	$selectors   = apply_filters( 'foodica/dynamic_theme_css/selectors', array() );
	$selector    = foodica_get_prop( $selectors, 'typo-page-title' );
	$media_query = foodica_get_prop( $selectors, 'page-title-font-size-media' );

	$dynamic_css .= "{$selector} {\n";
	if ( ! empty( $page_title_font_family ) && 'inherit' !== $page_title_font_family ) {
		$dynamic_css .= "font-family: {$page_title_font_family};\n";
	}
	if ( ! empty( $page_title_font_weight ) && 'inherit' !== $page_title_font_weight ) {
		$dynamic_css .= "font-weight: {$page_title_font_weight};\n";
	}
	if ( ! empty( $page_title_text_transform ) && 'inherit' !== $page_title_text_transform ) {
		$dynamic_css .= "text-transform: {$page_title_text_transform};\n";
	}
	$dynamic_css .= "}\n";

	$dynamic_css .= "{$media_query} {\n";
	$dynamic_css .= "{$selector} {\n";
	if ( absint( $page_title_font_size ) >= 12 && absint( $page_title_font_size ) <= 36 ) {
		$dynamic_css .= "font-size: {$page_title_font_size}px;\n";
	}
	if ( ! empty( $page_title_line_height ) && 'inherit' !== $page_title_line_height ) {
		$dynamic_css .= "line-height: {$page_title_line_height};\n";
	}
	$dynamic_css .= "} }\n";

	return $dynamic_css;
}

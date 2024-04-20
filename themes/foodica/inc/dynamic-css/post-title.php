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

add_filter( 'foodica/dynamic_theme_css/selectors', 'foodica_selector_single_post_title' );

if ( ! function_exists( 'foodica_selector_single_post_title' ) ) {
	/**
	 * Set HTML selector for Site Title
	 *
	 * @param array $selectors HTML selectors.
	 * @return array The array with HTML selectors.
	 */
	function foodica_selector_single_post_title( $selectors ) {
		$selectors['typo-post-title']            = '.single h1.entry-title';
		$selectors['post-title-font-size-media'] = '@media screen and (min-width: 782px)';
		return $selectors;
	}
}

add_filter( 'foodica/dynamic_theme_css', 'foodica_dynamic_theme_css_single_post_title' );

/**
 * Typography -> Site Title
 *
 * @param string $dynamic_css Dynamic CSS from Customizer.
 * @return string Generated dynamic CSS for Site Title.
 */
function foodica_dynamic_theme_css_single_post_title( $dynamic_css ) {
	

	$post_title_font_family    = foodica_get_font_stacks( foodica_get_theme_mod( 'post-title-font-family' ) );
	$post_title_font_size      = foodica_get_theme_mod( 'post-title-font-size' );
	$post_title_font_weight    = foodica_get_theme_mod( 'post-title-font-weight' );
	$post_title_text_transform = foodica_get_theme_mod( 'post-title-text-transform' );
	$post_title_line_height    = foodica_get_theme_mod( 'post-title-line-height' );
	$selectors   = apply_filters( 'foodica/dynamic_theme_css/selectors', array() );
	$selector    = foodica_get_prop( $selectors, 'typo-post-title' );
	$media_query = foodica_get_prop( $selectors, 'post-title-font-size-media' );

	$dynamic_css .= "{$selector} {\n";
	if ( ! empty( $post_title_font_family ) && 'inherit' !== $post_title_font_family ) {
		$dynamic_css .= "font-family: {$post_title_font_family};\n";
	}
	if ( ! empty( $post_title_font_weight ) && 'inherit' !== $post_title_font_weight ) {
		$dynamic_css .= "font-weight: {$post_title_font_weight};\n";
	}
	if ( ! empty( $post_title_text_transform ) && 'inherit' !== $post_title_text_transform ) {
		$dynamic_css .= "text-transform: {$post_title_text_transform};\n";
	}
	$dynamic_css .= "}\n";

	$dynamic_css .= "{$media_query} {\n";
	$dynamic_css .= "{$selector} {\n";
	if ( absint( $post_title_font_size ) >= 12 && absint( $post_title_font_size ) <= 36 ) {
		$dynamic_css .= "font-size: {$post_title_font_size}px;\n";
	}
	if ( ! empty( $post_title_line_height ) && 'inherit' !== $post_title_line_height ) {
		$dynamic_css .= "line-height: {$post_title_line_height};\n";
	}
	$dynamic_css .= "} }\n";

	return $dynamic_css;
}

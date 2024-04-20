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

add_filter( 'foodica/dynamic_theme_css/selectors', 'foodica_selector_post_content' );

if ( ! function_exists( 'foodica_selector_post_content' ) ) {
	/**
	 * Set HTML selector for Site Title
	 *
	 * @param array $selectors HTML selectors.
	 * @return array The array with HTML selectors.
	 */
	function foodica_selector_post_content( $selectors ) {
		$selectors['typo-post-content-archives']            = '.recent-posts .entry-content';
		$selectors['post-content-archives-font-size-media'] = '@media screen and (min-width: 782px)';
		return $selectors;
	}
}

add_filter( 'foodica/dynamic_theme_css', 'foodica_dynamic_theme_css_post_content' );

/**
 * Typography -> Site Title
 *
 * @param string $dynamic_css Dynamic CSS from Customizer.
 * @return string Generated dynamic CSS for Site Title.
 */
function foodica_dynamic_theme_css_post_content( $dynamic_css ) {
	

	$post_content_font_family    = foodica_get_font_stacks( foodica_get_theme_mod( 'post-content-archives-font-family' ) );
	$post_content_font_size      = foodica_get_theme_mod( 'post-content-archives-font-size' );
	$post_content_font_weight    = foodica_get_theme_mod( 'post-content-archives-font-weight' );
	$post_content_text_transform = foodica_get_theme_mod( 'post-content-archives-text-transform' );
	$post_content_line_height    = foodica_get_theme_mod( 'post-content-archives-line-height' );
	$selectors   = apply_filters( 'foodica/dynamic_theme_css/selectors', array() );
	$selector    = foodica_get_prop( $selectors, 'typo-post-content-archives' );
	$media_query = foodica_get_prop( $selectors, 'post-content-archives-font-size-media' );

	$dynamic_css .= "{$selector} {\n";
	if ( ! empty( $post_content_font_family ) && 'inherit' !== $post_content_font_family ) {
		$dynamic_css .= "font-family: {$post_content_font_family};\n";
	}
	if ( ! empty( $post_content_font_weight ) && 'inherit' !== $post_content_font_weight ) {
		$dynamic_css .= "font-weight: {$post_content_font_weight};\n";
	}
	if ( ! empty( $post_content_text_transform ) && 'inherit' !== $post_content_text_transform ) {
		$dynamic_css .= "text-transform: {$post_content_text_transform};\n";
	}
	$dynamic_css .= "}\n";

	$dynamic_css .= "{$media_query} {\n";
	$dynamic_css .= "{$selector} {\n";
	if ( absint( $post_content_font_size ) >= 12 && absint( $post_content_font_size ) <= 36 ) {
		$dynamic_css .= "font-size: {$post_content_font_size}px;\n";
	}
	if ( ! empty( $post_content_line_height ) && 'inherit' !== $post_content_line_height ) {
		$dynamic_css .= "line-height: {$post_content_line_height};\n";
	}
	$dynamic_css .= "} }\n";

	return $dynamic_css;
}

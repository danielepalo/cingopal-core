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

add_filter( 'foodica/dynamic_theme_css/selectors', 'foodica_selector_slider' );

if ( ! function_exists( 'foodica_selector_slider' ) ) {
	/**
	 * Set HTML selector for Slider Title
	 *
	 * @param array $selectors HTML selectors.
	 * @return array The array with HTML selectors.
	 */
	function foodica_selector_slider( $selectors ) {
		$selectors['typo-slider-title']            = '.slides li h3 a';
		$selectors['slider-title-font-size-media'] = '@media screen and (min-width: 782px)';
		return $selectors;
	}
}

add_filter( 'foodica/dynamic_theme_css', 'foodica_dynamic_theme_css_slider' );

/**
 * Typography -> Slider Title
 *
 * @param string $dynamic_css Dynamic CSS from Customizer.
 * @return string Generated dynamic CSS for Slider Title
 */
function foodica_dynamic_theme_css_slider( $dynamic_css ) {
	

	$slider_title_font_family    = foodica_get_font_stacks( foodica_get_theme_mod( 'slider-title-font-family' ) );
	$slider_title_font_size      = foodica_get_theme_mod( 'slider-title-font-size' );
	$slider_title_font_weight    = foodica_get_theme_mod( 'slider-title-font-weight' );
	$slider_title_text_transform = foodica_get_theme_mod( 'slider-title-text-transform' );
	$slider_title_line_height    = foodica_get_theme_mod( 'slider-title-line-height' );
	$selectors   = apply_filters( 'foodica/dynamic_theme_css/selectors', array() );
	$selector    = foodica_get_prop( $selectors, 'typo-slider-title' );
	$media_query = foodica_get_prop( $selectors, 'slider-title-font-size-media' );

	$dynamic_css .= "{$selector} {\n";
	if ( ! empty( $slider_title_font_family ) && 'inherit' !== $slider_title_font_family ) {
		$dynamic_css .= "font-family: {$slider_title_font_family};\n";
	}
	if ( ! empty( $slider_title_font_weight ) && 'inherit' !== $slider_title_font_weight ) {
		$dynamic_css .= "font-weight: {$slider_title_font_weight};\n";
	}
	if ( ! empty( $slider_title_text_transform ) && 'inherit' !== $slider_title_text_transform ) {
		$dynamic_css .= "text-transform: {$slider_title_text_transform};\n";
	}
	$dynamic_css .= "}\n";

	$dynamic_css .= "{$media_query} {\n";
	$dynamic_css .= "{$selector} {\n";
	if ( absint( $slider_title_font_size ) >= 12 && absint( $slider_title_font_size ) <= 36 ) {
		$dynamic_css .= "font-size: {$slider_title_font_size}px;\n";
	}
	if ( ! empty( $slider_title_line_height ) && 'inherit' !== $slider_title_line_height ) {
		$dynamic_css .= "line-height: {$slider_title_line_height};\n";
	}
	$dynamic_css .= "} }\n";

	return $dynamic_css;
}

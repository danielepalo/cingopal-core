<?php
/**
 * Inspiro Lite: Customizer Controls.
 *
 * @package Foodica
 * @subpackage Foodica_Lite
 * @since Foodica 1.2.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$control_dir = FOODICA_THEME_DIR . 'inc/customizer/custom-controls';

// phpcs:disable WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound
require $control_dir . '/font-presets/class-foodica-customize-font-presets-control.php';
require $control_dir . '/title/class-foodica-customize-title-control.php';
require $control_dir . '/range/class-foodica-customize-range-control.php';
require $control_dir . '/typography/class-foodica-customize-typography-control.php';
require $control_dir . '/font-variant/class-foodica-customize-font-variant-control.php';
// phpcs:enable WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound

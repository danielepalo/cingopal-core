<?php
/**
 * Customize Font Presets Control class.
 *
 * @package Foodica
 * @since Foodica 1.2.3
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( class_exists( 'WP_Customize_Control' ) ) {

	/**
	 * Font presets control.
	 */
	class Foodica_Customize_Font_Presets_Control extends WP_Customize_Control {
		/**
		 * Type.
		 *
		 * @var string
		 */
		public $type = 'foodica-font-presets';

		/**
		 * Render the content of the font presets control.
		 */
		public function render_content() {
			$presets   = apply_filters( 'foodica_font_presets', array() );
			$imagepath = FOODICA_THEME_ASSETS_URI . '/images/font-presets/';
			?>

			<h4 class="foodica-customize-section-title"><?php esc_html_e( 'Presets', 'foodica' ); ?></h4>
			<p class="customize-control-description"><?php esc_html_e( 'Choosing a preset will override all the font settings.', 'foodica' ); ?></p>

			<div class="foodica-preset-panel">
				<h3 class="foodica-preset-panel-title">
					<button type="button" class="foodica-preset-panel-toggle" aria-expanded="false">
					<?php esc_html_e( 'View Presets', 'foodica' ); ?>
					<span class="toggle-indicator" aria-hidden="true"></span>
					</button>
				</h3>
				<div class="foodica-preset-list">
					<?php foreach ( $presets as $item ) { ?>
						<div class="foodica-preset-item" tabindex="0" role="button" aria-label="<?php echo esc_attr( $item['name'] ); ?>" data-value="<?php echo esc_attr( $item['name'] ); ?>">
							<img src="<?php echo esc_url( $imagepath . $item['image'] ); ?>" alt="<?php echo esc_html( $item['name'] ); ?>"/>
						</div>
					<?php } ?>
				</div>
			</div>
			<?php
		}
	}
}

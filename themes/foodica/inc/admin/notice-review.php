<?php
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

class Foodica_Notice_Review extends Foodica_Notices {

	public function __construct() {

		add_action( 'wp_loaded', array( $this, 'review_notice' ), 20 );
		add_action( 'wp_loaded', array( $this, 'hide_notices' ), 15 );

		$this->current_user_id       = get_current_user_id();

	}

	public function review_notice() {

		if ( ! get_option( 'foodica_theme_installed_time' ) ) {
			update_option( 'foodica_theme_installed_time', time() );
		}

		$this_notice_was_dismissed = $this->get_notice_status('review-user-' . $this->current_user_id);

		if ( !$this_notice_was_dismissed ) {
			add_action( 'admin_notices', array( $this, 'review_notice_markup' ) ); // Display this notice.
		}

	}

	/**
	 * Show HTML markup if conditions meet.
	 */
	public function review_notice_markup() {

		$dismiss_url = wp_nonce_url(
			remove_query_arg( array( 'activated' ), add_query_arg( 'foodica-hide-notice', 'review-user-' . $this->current_user_id ) ),
			'foodica_hide_notices_nonce',
			'_foodica_notice_nonce'
		);

		$theme_data	 	= wp_get_theme();
		$current_user 	= wp_get_current_user();

		if ( ( get_option( 'foodica_theme_installed_time' ) > strtotime( '-5 day' ) ) ) {
			return;
		}

		?>
		<div id="message" class="notice notice-success foodica-notice foodica-review-notice">
			<a class="foodica-message-close notice-dismiss" href="<?php echo esc_url( $dismiss_url ); ?>"></a>
			<div class="foodica-message-content">

				<div class="foodica-message-image">
					<a href="<?php echo esc_url( admin_url( 'themes.php?page=foodica-doc' ) ); ?>"><img class="foodica-screenshot" src="<?php echo esc_url( get_template_directory_uri() ); ?>/screenshot.png" alt="<?php esc_attr_e( 'foodica', 'foodica' ); ?>" /></a>
				</div><!-- ws fix
				--><div class="foodica-message-text">

					<p>
						<?php
						printf(
							/* Translators: %1$s current user display name. */
							esc_html__(
								'Dear %1$s! We hope you are happy with everything that the %2$s has to offer. %3$sIf you can spare a moment, please consider adding a rating for %4$s on WordPress.org. %3$sIt helps us continue providing updates and support for this theme.',
								'foodica'
							),
							'<strong>' . esc_html( $current_user->display_name ) . '</strong>',
							'<a href="' . esc_url( admin_url( 'themes.php?page=foodica' ) ) . '"><strong>' . esc_html( $theme_data->Name ) . ' Theme</strong></a>',
							'<br>',
							esc_html( $theme_data->Name )
						);
						?>
					</p>

					<p class="notice-buttons"><a href="https://wordpress.org/support/theme/foodica/reviews/?rate=5#new-post" class="btn button button-primary foodica-button" target="_blank"><span class="dashicons dashicons-awards"></span> <?php esc_html_e( 'Add a Rating for Foodica', 'foodica' ); ?></a>
					<a href="<?php echo esc_url( $dismiss_url ); ?>" class="btn button button-secondary"><?php esc_html_e( 'Hide this notice', 'foodica' ); ?></a>
					</a></p>

				</div><!-- .foodica-message-text -->

			</div><!-- .foodica-message-content -->

		</div><!-- #message -->
		<?php
	}
}

new Foodica_Notice_Review();
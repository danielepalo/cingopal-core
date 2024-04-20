<?php

if (!defined('ABSPATH')) {
	exit;
}

/*
 * Welcome Notice after Theme Activation
 */

if (!function_exists('foodica_admin_notice')) {
	function foodica_admin_notice() {
		global $pagenow, $foodica_version;
		if (current_user_can('edit_theme_options') && 'index.php' === $pagenow && !get_option('foodica_notice_welcome') || current_user_can('edit_theme_options') && 'themes.php' === $pagenow && isset($_GET['activated']) && !get_option('foodica_notice_welcome')) {
			wp_enqueue_style('foodica-admin-notice', get_template_directory_uri() . '/inc/admin/admin-notice.css', array(), $foodica_version);
			foodica_welcome_notice();
		}
	}
}
add_action('admin_notices', 'foodica_admin_notice');


/*
 * Hide Welcome Notice in WordPress Dashboard ***
 */

if (!function_exists('foodica_hide_notice')) {
	function foodica_hide_notice() {
		if (isset($_GET['foodica-hide-notice']) && isset($_GET['_foodica_notice_nonce'])) {
			if (!wp_verify_nonce($_GET['_foodica_notice_nonce'], 'foodica_hide_notices_nonce')) {
				wp_die(esc_html__('Action failed. Please refresh the page and retry.', 'foodica'));
			}
			if (!current_user_can('edit_theme_options')) {
				wp_die(esc_html__('You do not have the necessary permission to perform this action.', 'foodica'));
			}
			$hide_notice = sanitize_text_field($_GET['foodica-hide-notice']);
			update_option('foodica_notice_' . $hide_notice, 1);
		}
	}
}
add_action('wp_loaded', 'foodica_hide_notice');

/*
 * Content of Welcome Notice in WordPress Dashboard
 */

if (!function_exists('foodica_welcome_notice')) {
	function foodica_welcome_notice() {
		global $foodica_data; ?>
		<div class="notice notice-success wpz-welcome-notice">
			<a class="notice-dismiss wpz-welcome-notice-hide" href="<?php echo esc_url(wp_nonce_url(remove_query_arg(array('activated'), add_query_arg('foodica-hide-notice', 'welcome')), 'foodica_hide_notices_nonce', '_foodica_notice_nonce')); ?>">
				<span class="screen-reader-text">
					<?php echo esc_html__('Dismiss this notice.', 'foodica'); ?>
				</span>
			</a>
			<p><?php printf(esc_html__('Thanks for using %1$s! To get started please make sure you visit our %2$swelcome page%3$s.', 'foodica'), $foodica_data['Name'], '<a href="' . esc_url(admin_url('themes.php?page=foodica')) . '">', '</a>'); ?></p>
			<p class="wpz-welcome-notice-button">
				<a class="button-secondary" href="<?php echo esc_url(admin_url('themes.php?page=foodica')); ?>">
					<?php printf(esc_html__('Get Started with %s', 'foodica'), $foodica_data['Name']); ?>
				</a>
				<a class="button-primary" href="<?php echo esc_url(__('https://www.wpzoom.com/wordpress-food-themes/foodica-pro/', 'foodica')); ?>" target="_blank">
					<?php esc_html_e('Upgrade to Foodica PRO', 'foodica'); ?>
				</a>
			</p>
		</div><?php
	}
}

/*
 * About Theme Page
 */

if (!function_exists('foodica_theme_info_page')) {
	function foodica_theme_info_page() {
		add_theme_page(esc_html__('Welcome to Foodica Theme', 'foodica'), esc_html__('About Foodica', 'foodica'), 'edit_theme_options', 'foodica', 'foodica_display_theme_page');
	}
}
add_action('admin_menu', 'foodica_theme_info_page');

if (!function_exists('foodica_display_theme_page')) {
	function foodica_display_theme_page() {
		global $foodica_data; ?>
		<div class="theme-info-wrap">

			<div class="wpz-row theme-intro wpz-clearfix">


				<div class="wpz-col-1-4">
					<img class="theme-screenshot"
					     src="<?php echo esc_url( get_template_directory_uri() . '/screenshot.png' ); ?>"
					     alt="<?php esc_attr_e( 'Theme Screenshot', 'foodica' ); ?>"/>
				</div>
				<div class="wpz-col-3-4 theme-description">

                    <h1>
                        <?php printf(esc_html__('Welcome to %1$1s %2$2s', 'foodica'), $foodica_data['Name'], $foodica_data['Version']); ?>
                    </h1>


                    <?php esc_html_e('Foodica is perfect for creating food based blogs and recipe websites. A beautiful featured slider and WooCommerce integration mean Foodica is packed with features to help you stand out.', 'foodica'); ?>

                    <div class="theme-links wpz-clearfix">
                        <p>
                            <a href="<?php echo esc_url(__('https://www.wpzoom.com/wordpress-food-themes/foodica-pro/', 'foodica')); ?>" class="button button-primary" target="_blank">
                                <?php esc_html_e('About Foodica', 'foodica'); ?>
                            </a>
                            <a href="<?php echo esc_url(__('https://www.wpzoom.com/documentation/foodica-lite/','foodica')); ?>" target="_blank">
                                <?php esc_html_e('Documentation', 'foodica'); ?>
                            </a>
                            <a href="<?php echo esc_url(__('https://www.wpzoom.com/showcase/theme/foodica/', 'foodica')); ?>" target="_blank">
                                <?php esc_html_e('Foodica Showcase', 'foodica'); ?>
                            </a>
                        </p>
                    </div>

                </div>

			</div>
			<hr>
			<div id="getting-started">
				<h3>
					<?php printf(esc_html__('Get Started with %s', 'foodica'), $foodica_data['Name']); ?>
				</h3>
				<div class="wpz-row wpz-clearfix">
					<div class="wpz-col-1-2">
						<div class="section">
							<h4>
								<span class="dashicons dashicons-editor-help"></span>
								<?php esc_html_e('Theme Documentation', 'foodica'); ?>
							</h4>
							<p class="about">
								<?php printf(esc_html__('Need help configuring %s? In the documentation you can find all theme related information that is needed to get your site up and running in no time.', 'foodica'), $foodica_data['Name']); ?>
							</p>
							<p>
								<a href="<?php echo esc_url(__('https://www.wpzoom.com/documentation/foodica-lite/', 'foodica')); ?>" target="_blank" class="button button-primary">
									<?php esc_html_e('Theme Documentation', 'foodica'); ?>
								</a>
								<a href="<?php echo esc_url(__('https://wordpress.org/support/theme/foodica', 'foodica')); ?>" target="_blank" class="button button-secondary">
                                    <?php esc_html_e('Support Forum', 'foodica'); ?>
 								</a>
							</p>
						</div>

                        <hr /><br/>
						<div class="section">
							<h4>
								<span class="dashicons dashicons-admin-plugins"></span>
								<?php esc_html_e('Recommended Plugins', 'foodica'); ?>
							</h4>
							<p class="about">
                                <?php esc_html_e('In order to enable all theme features, it\'s necessary to install a few recommended plugins.', 'foodica'); ?>
							</p>
							<p>
								<a href="<?php echo esc_url(admin_url('themes.php?page=tgmpa-install-plugins')); ?>" class="button button-secondary">
                                    <?php esc_html_e('Recommended Plugins', 'foodica'); ?>
 								</a>
							</p>
						</div>
					</div>
					<div class="wpz-col-1-2">
						<div class="section">
							<h4>
								<span class="dashicons dashicons-cart"></span>
								<?php esc_html_e('Foodica Pro', 'foodica'); ?>
							</h4>
							<p class="about">
								<?php esc_html_e('If you like the free version of this theme, you will LOVE the full version of Foodica which includes unique custom widgets, additional features and more useful options to customize your website.', 'foodica'); ?>
							</p>
							<p>
								<a href="<?php echo esc_url(__('https://www.wpzoom.com/wordpress-food-themes/foodica-pro/', 'foodica')); ?>" target="_blank" class="button button-primary">
									<?php esc_html_e('Upgrade to Foodica PRO', 'foodica'); ?>
								</a>
							</p>
						</div><hr /><br/>
						<div class="section">
							<h4>
								<span class="dashicons dashicons-star-filled"></span>
								<?php esc_html_e('Why Upgrade?', 'foodica'); ?>
							</h4>
							<p class="about">
								<?php esc_html_e('Upgrading to Foodica PRO you will unlock a dozen of unique features that will take your food blog to the next level. See in the table below just a few of the features included in the PRO version.', 'foodica'); ?>
							</p>
							<p>
								<a href="<?php echo esc_url(__('http://demo.wpzoom.com/?theme=foodica', 'foodica')); ?>" target="_blank" class="button button-primary">
									<?php esc_html_e('View Foodica PRO Demo', 'foodica'); ?>
								</a>
							</p>
						</div>
					</div>
				</div>
			</div>
			<hr>
			<div class="theme-comparison">
				<h3 class="theme-comparison-intro">
					<?php esc_html_e('Foodica Lite vs. Foodica PRO', 'foodica'); ?>
				</h3>
				<table>
					<thead class="theme-comparison-header">
						<tr>
							<th class="table-feature-title"><h3><?php esc_html_e('Features', 'foodica'); ?></h3></th>
							<th><h3><?php esc_html_e('Foodica Lite', 'foodica'); ?></h3></th>
							<th><h3><?php esc_html_e('Foodica PRO', 'foodica'); ?></h3></th>
						</tr>
					</thead>
					<tbody>
                        <tr>
                            <td><h3><?php esc_html_e('Custom Widgets', 'foodica'); ?></h3></td>
                            <td><?php esc_html_e('1', 'foodica'); ?></td>
                            <td><?php esc_html_e('6 (Featured Categories, Carousel, Author Bio, Image Box)', 'foodica'); ?></td>
                        </tr>
                        <tr>
                            <td><h3><?php esc_html_e('Widget Areas', 'foodica'); ?></h3></td>
                            <td><?php esc_html_e('6', 'foodica'); ?></td>
                            <td><?php esc_html_e('15 (5 on Homepage)', 'foodica'); ?></td>
                        </tr>
						<tr>
							<td><h3><?php esc_html_e('Responsive Layout', 'foodica'); ?></h3></td>
							<td><span class="dashicons dashicons-yes"></span></td>
							<td><span class="dashicons dashicons-yes"></span></td>
						</tr>
                        <tr>
                            <td><h3><?php esc_html_e('Magazine Layout', 'foodica'); ?></h3></td>
                            <td><span class="dashicons dashicons-no"></span></td>
                            <td><span class="dashicons dashicons-yes"></span></td>
                        </tr>
                        <tr>
                            <td><h3><?php esc_html_e('Demo Content Importer', 'foodica'); ?></h3></td>
                            <td><span class="dashicons dashicons-no"></span></td>
                            <td><span class="dashicons dashicons-yes"></span></td>
                        </tr>
                        <tr>
                            <td><h3><?php esc_html_e('Recipe Index', 'foodica'); ?></h3></td>
                            <td><span class="dashicons dashicons-no"></span></td>
                            <td><span class="dashicons dashicons-yes"></span></td>
                        </tr>
                        <tr>
                            <td><h3><?php esc_html_e('Recipe Shortcodes', 'foodica'); ?></h3></td>
                            <td><span class="dashicons dashicons-no"></span></td>
                            <td><span class="dashicons dashicons-yes"></span></td>
                        </tr>
						<tr>
							<td><h3><?php esc_html_e('10 Color Schemes', 'foodica'); ?></h3></td>
							<td><span class="dashicons dashicons-no"></span></td>
							<td><span class="dashicons dashicons-yes"></span></td>
						</tr>
						<tr>
							<td><h3><?php esc_html_e('3 Slider Styles', 'foodica'); ?></h3></td>
							<td><span class="dashicons dashicons-no"></span></td>
							<td><span class="dashicons dashicons-yes"></span></td>
						</tr>
                        <tr>
                            <td><h3><?php esc_html_e('Multiple Posts Layouts', 'foodica'); ?></h3></td>
                            <td><span class="dashicons dashicons-no"></span></td>
                            <td><span class="dashicons dashicons-yes"></span></td>
                        </tr>
						<tr>
							<td><h3><?php esc_html_e('Built-in Social Buttons', 'foodica'); ?></h3></td>
							<td><span class="dashicons dashicons-no"></span></td>
							<td><span class="dashicons dashicons-yes"></span></td>
						</tr>
						<tr>
							<td><h3><?php esc_html_e('Extended WooCommerce Integration', 'foodica'); ?></h3></td>
							<td><span class="dashicons dashicons-no"></span></td>
							<td><span class="dashicons dashicons-yes"></span></td>
						</tr>
						<tr>
							<td><h3><?php esc_html_e('Advertising Options', 'foodica'); ?></h3></td>
							<td><span class="dashicons dashicons-no"></span></td>
							<td><span class="dashicons dashicons-yes"></span></td>
						</tr>
						<tr>
							<td><h3><?php esc_html_e('Theme Options', 'foodica'); ?></h3></td>
                            <td><span class="dashicons dashicons-no"></span></td>
							<td><span class="dashicons dashicons-yes"></span></td>
						</tr>
                        <tr>
                            <td><h3><?php esc_html_e('Carousel Widget', 'foodica'); ?></h3></td>
                            <td><span class="dashicons dashicons-no"></span></td>
                            <td><span class="dashicons dashicons-yes"></span></td>
                        </tr>
						<tr>
							<td><h3><?php esc_html_e('100+ Color Options', 'foodica'); ?></h3></td>
							<td><span class="dashicons dashicons-no"></span></td>
							<td><span class="dashicons dashicons-yes"></span></td>
						</tr>
						<tr>
							<td><h3><?php esc_html_e('600+ Google Fonts', 'foodica'); ?></h3></td>
							<td><span class="dashicons dashicons-no"></span></td>
							<td><span class="dashicons dashicons-yes"></span></td>
						</tr>
						<tr>
							<td><h3><?php esc_html_e('Typography Options', 'foodica'); ?></h3></td>
							<td><span class="dashicons dashicons-no"></span></td>
							<td><span class="dashicons dashicons-yes"></span></td>
						</tr>
						<tr>
							<td><h3><?php esc_html_e('Instagram Bar in the Footer', 'foodica'); ?></h3></td>
							<td><span class="dashicons dashicons-no"></span></td>
							<td><span class="dashicons dashicons-yes"></span></td>
						</tr>
						<tr>
							<td><h3><?php esc_html_e('Support', 'foodica'); ?></h3></td>
							<td><?php esc_html_e('Support Forum', 'foodica'); ?></td>
							<td><?php esc_html_e('Fast & Friendly Email Support', 'foodica'); ?></td>
						</tr>
						<tr>
							<td></td>
							<td></td>
							<td>
								<a href="<?php echo esc_url(__('https://www.wpzoom.com/wordpress-food-themes/foodica-pro/', 'foodica')); ?>" target="_blank" class="upgrade-button">
									<?php esc_html_e('Upgrade to Foodica PRO', 'foodica'); ?>
								</a>
							</td>
						</tr>
					</tbody>
				</table>
			</div>

		</div><?php
	}
}

?>
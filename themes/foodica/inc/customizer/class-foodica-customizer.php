<?php
/**
 * Foodica Lite: Customizer Class
 *
 * @package Foodica
 * @subpackage Foodica_Lite
 * @since Foodica 1.2.3
 */

if ( ! class_exists( 'Foodica_Customizer' ) ) {

	/**
	 * Help class for Customizer
	 */
	class Foodica_Customizer {
		/**
		 * Store all customizer data
		 *
		 * @since 1.2.3
		 * @var array
		 */
		public static $customizer_data = array();

		/**
		 * Store all configuration class names
		 *
		 * @since 1.2.3
		 *
		 * @var array
		 */
		public $config_class_names = array();

		/**
		 * Instance
		 *
		 * @access private
		 * @var object
		 */
		private static $instance;

		/**
		 * Initiator
		 */
		public static function get_instance() {
			if ( ! isset( self::$instance ) ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		/**
		 * Constructor
		 */
		public function __construct() {
			add_action( 'init', array( $this, 'store_customizer_data' ), 1 );

			add_action( 'customize_preview_init', array( $this, 'customize_preview_js' ) );

			add_action( 'customize_register', array( $this, 'register_control_types' ), 2 );
			add_action( 'customize_register', array( $this, 'autoload_configuration_files' ), 3 );
			add_action( 'customize_register', array( $this, 'register_configurations' ), 10 );

			add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_control_scripts' ) );

			add_action( 'customize_controls_print_footer_scripts', array( $this, 'print_footer_scripts' ) );
		}

		/**
		 * Set customizer data
		 *
		 * @since 1.2.3
		 *
		 * @param string $setting_id Customizer setting id.
		 * @param array  $setting_args Customizer setting args.
		 * @return boolean
		 */
		public function set_customizer_data( $setting_id, $setting_args ) {
			if ( ! $setting_id || ! $setting_args ) {
				return false;
			}

			if ( ! isset( self::$customizer_data[ $setting_id ] ) ) {
				self::$customizer_data[ $setting_id ] = $setting_args;
			}

			return true;
		}

		/**
		 * Retrieves theme modification default value for the passed theme modification name.
		 *
		 * @since 1.2.3
		 *
		 * @param string $name Theme modification name.
		 * @return mixed
		 */
		public static function get_theme_mod_default_value( $name ) {
			if ( ! isset( self::$customizer_data[ $name ] ) ) {
				return false;
			}
			$default = foodica_get_prop( self::$customizer_data[ $name ], 'default' );
			return $default;
		}

		/**
		 * All configuration files
		 *
		 * @since 1.2.3 Moved to class method all configuration files.
		 *
		 * @return array
		 */
		public static function configuration_files() {
			return array(
				'typography'     => array(
					'typo-panel',
					'typo-body',
					'typo-site-title',
					'typo-site-description',
					'typo-top-menulinks',
					'typo-nav',
					'typo-nav-mobile',
					'typo-slider',
					'typo-slider-button',
					'typo-widgets',
					'typo-post-title',
					'typo-archive-post-content',
					'typo-single-post-title',
					'typo-single-post-content',
					'typo-page-title',
					'typo-footer-menu'
				),
			);
		}

		/**
		 * Register custom control types.
		 *
		 * @since 1.2.3
		 *
		 * @param WP_Customize_Manager $wp_customize instance of WP_Customize_Manager.
		 */
		public function register_control_types( $wp_customize ) {
			// phpcs:disable WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound
			require FOODICA_THEME_DIR . 'inc/customizer/customizer-controls.php';
			// phpcs:enable WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound

			/**
			 * Register sections
			 */

			Foodica_Customizer_Control_Base::register_custom_control(
				'foodica-range',
				array(
					'callback' => 'Foodica_Customize_Range_Control',
				)
			);

			Foodica_Customizer_Control_Base::register_custom_control(
				'foodica-title',
				array(
					'callback' => 'Foodica_Customize_Title_Control',
				)
			);

			Foodica_Customizer_Control_Base::register_custom_control(
				'foodica-typography',
				array(
					'callback'          => 'Foodica_Customize_Typography_Control',
					'sanitize_callback' => 'sanitize_text_field',
				)
			);

			Foodica_Customizer_Control_Base::register_custom_control(
				'foodica-font-variant',
				array(
					'callback'          => 'Foodica_Customize_Font_Variant_Control',
					'sanitize_callback' => 'sanitize_text_field',
				)
			);
		}

		/**
		 * Register all configurations for Theme Customizer.
		 *
		 * @param WP_Customize_Manager $wp_customize instance of WP_Customize_Manager.
		 */
		public function register_configurations( $wp_customize ) {

			// Change transport type for Header Text color.
			$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

			/**
			 * Fires to register all customizer custom panels, settings and controls
			 *
			 * @since 1.3.0
			 */
			do_action( 'foodica/customize_register', $wp_customize, $this->config_class_names );
		}

		/**
		 * Autoload all customizer configuration files
		 *
		 * @since 1.2.3
		 * @param WP_Customize_Manager $wp_customize instance of WP_Customize_Manager.
		 * @return void
		 */
		public function autoload_configuration_files( $wp_customize ) {
			$configuration_files = self::configuration_files();
			// phpcs:disable WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound
			foreach ( $configuration_files as $folder_name => $files ) {
				foreach ( $files as $file_name ) {
					$class_name = str_replace( '-', '_', ucwords( "foodica-{$file_name}-config", '-' ) ); // phpcs:ignore PHPCompatibility.FunctionUse.NewFunctionParameters.ucwords_delimitersFound

					if ( ! class_exists( $class_name ) ) {
						if ( file_exists( FOODICA_THEME_DIR . "inc/customizer/configs/{$folder_name}/class-foodica-{$file_name}-config.php" ) ) {
							require FOODICA_THEME_DIR . "inc/customizer/configs/{$folder_name}/class-foodica-{$file_name}-config.php";

							if ( method_exists( $class_name, 'config' ) && ! isset( $this->config_class_names[ $class_name ] ) ) {
								$this->config_class_names[ $class_name ] = (object) call_user_func_array( array( $class_name, 'config' ), array( $wp_customize ) ); // Call a callback with an array of parameters.
							}
						}
					}
				}
			}
			// phpcs:enable WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound

			/**
			 * Fires after all customizer configuration files are loaded.
			 * Pass array with configuration class names.
			 *
			 * @since 1.2.3
			 */
			do_action( 'foodica/configuration-files-loaded', $this->config_class_names );
		}

		/**
		 * Store customizer data to static class variable
		 *
		 * @since 1.2.3
		 * @return array Array of customizer data.
		 */
		public function store_customizer_data() {
			global $wp_customize;

			// Only the execution of the action 'foodica/configuration-files-loaded' is not fired.
			if ( 0 === did_action( 'foodica/configuration-files-loaded' ) ) {
				$this->autoload_configuration_files( $wp_customize );
			}

			if ( ! is_array( $this->config_class_names ) || empty( $this->config_class_names ) ) {
				return;
			}

			foreach ( $this->config_class_names as $class_name => $configs ) {
				$setting = isset( $configs->setting ) ? $configs->setting : false;

				if ( ! $setting ) {
					continue;
				}

				$setting_id   = foodica_get_prop( $setting, 'id' );
				$setting_args = foodica_get_prop( $setting, 'args' );

				if ( $setting_id && $setting_args ) {
					$this->set_customizer_data( $setting_id, $setting_args );
				} else {
					foreach ( $setting as $_setting ) {
						$setting_id   = foodica_get_prop( $_setting, 'id' );
						$setting_args = foodica_get_prop( $_setting, 'args' );
						$this->set_customizer_data( $setting_id, $setting_args );
					}
				}
			}

			return apply_filters( 'foodica/store_customizer_data', self::$customizer_data );
		}

		/**
		 * Bind JS handlers to instantly live-preview changes.
		 *
		 * @return void
		 */
		public function customize_preview_js() {
			wp_enqueue_script(
				'foodica-customize-preview',
				foodica_get_assets_uri( 'customize-preview', 'js' ),
				array( 'customize-preview' ),
				FOODICA_THEME_VERSION,
				true
			);

			$selectors      = apply_filters( 'foodica/dynamic_theme_css/selectors', array() );
			$localize_array = array(
				'googleFonts' => Foodica_Font_Family_Manager::get_google_fonts(),
				'systemFonts' => Foodica_Font_Family_Manager::get_system_fonts(),
				'selectors'   => $selectors,
			);

			wp_localize_script( 'foodica-customize-preview', 'foodicaCustomizePreview', $localize_array );
		}

		/**
		 * Load dynamic logic for the customizer controls area.
		 *
		 * @return void
		 */
		public function enqueue_control_scripts() {
			wp_enqueue_script(
				'foodica-customize-controls',
				foodica_get_assets_uri( 'customize-controls', 'js' ),
				array( 'customize-controls' ),
				FOODICA_THEME_VERSION,
				true
			);

			wp_enqueue_style(
				'foodica-customize-controls',
				foodica_get_assets_uri( 'customize-controls', 'css' ),
				array(),
				FOODICA_THEME_VERSION
			);

			wp_localize_script(
				'foodica-customize-controls',
				'foodicaCustomControl',
				apply_filters(
					'foodica/customizer/js_localize',
					array(
						'customizer'  => array(
							'settings' => array(
								'google_fonts' => $this->generate_font_dropdown(),
							),
						),
						'font_weight' => Foodica_Font_Family_Manager::get_all_font_weight(),
						'strings'     => array(
							'inherit' => __( 'Inherit', 'foodica' ),
						),
					)
				)
			);
		}

		/**
		 * Generates HTML for font dropdown
		 *
		 * @link https://github.com/brainstormforce/astra/blob/663761d3419f25640af9b59e64384bd07f810bc4/inc/customizer/class-astra-customizer.php#L1265
		 *
		 * @return string
		 */
		public function generate_font_dropdown() {
			ob_start();

			?>

			<option value="inherit"><?php esc_html_e( 'Default System Font', 'foodica' ); ?></option>
			<optgroup label="<?php esc_attr_e( 'System Fonts', 'foodica' ); ?>">

			<?php

			$system_fonts = Foodica_Font_Family_Manager::get_system_fonts();
			$google_fonts = Foodica_Font_Family_Manager::get_google_fonts();

			foreach ( $system_fonts as $name => $variants ) {
				?>

				<option value="<?php echo esc_attr( $name ); ?>" ><?php echo esc_html( $name ); ?></option>
				<?php
			}

			?>
			<optgroup label="Google">

			<?php
			foreach ( $google_fonts as $name => $single_font ) {
				$variants = isset( $single_font[0] ) ? $single_font[0] : null;
				$category = isset( $single_font[1] ) ? $single_font[1] : null;

				?>
				<option value="<?php echo "'" . esc_attr( $name ) . "', " . esc_attr( $category ); ?>"><?php echo esc_html( $name ); ?></option>

				<?php
			}

			return ob_get_clean();
		}

		/**
		 * Print Footer Scripts
		 *
		 * @link https://github.com/brainstormforce/astra/blob/663761d3419f25640af9b59e64384bd07f810bc4/inc/customizer/class-astra-customizer.php#L286
		 *
		 * @since 1.3.0
		 * @return void
		 */
		public function print_footer_scripts() {
			$output  = '<script type="text/javascript">';
			$output .= Foodica_Fonts_Manager::js();
			$output .= '</script>';

			echo $output; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}

	}

}

/**
 *  Kicking this off by calling 'get_instance()' method
 */
Foodica_Customizer::get_instance();

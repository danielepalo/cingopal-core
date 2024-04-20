<?php
/**
 * Helper class for load google fonts to front-end
 *
 * @package Foodica
 * @since Foodica 1.2.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'Foodica_Fonts_Manager' ) ) {

	/**
	 * Fonts class manager
	 */
	class Foodica_Fonts_Manager {

		/**
		 * Fonts to load
		 *
		 * @var array
		 */
		public static $fonts = array();

		/**
		 * Google Font URL
		 *
		 * @var string
		 */
		public static $google_font_url = '';

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
			add_action( 'init', array( $this, 'add_theme_fonts' ) );
		}

		/**
		 * Localize Fonts
		 */
		public static function js() {
			$system = wp_json_encode( Foodica_Font_Family_Manager::get_system_fonts() );
			$google = wp_json_encode( Foodica_Font_Family_Manager::get_google_fonts() );

			return 'var FoodicaFontFamilies = { system: ' . $system . ', google: ' . $google . ' };';
		}

		/**
		 * Register all Fonts
		 *
		 * @return void
		 */
		public function add_theme_fonts() {
			/**
			 * Body
			 */
			$body_font_family   = foodica_get_theme_mod( 'body-font-family' );
			$body_font_variants = foodica_get_theme_mod( 'body-font-variant' );
			self::add_font( $body_font_family, $body_font_variants );

			/**
			 * Site Title
			 */
			$site_title_font_family   = foodica_get_theme_mod( 'title-font-family' );
			$site_title_font_variants = foodica_get_theme_mod( 'title-font-variant' );
			self::add_font( $site_title_font_family, $site_title_font_variants );

			/**
			 * Site Description
			 */
			$site_description_font_family   = foodica_get_theme_mod( 'description-font-family' );
			$site_description_font_variants = foodica_get_theme_mod( 'description-font-variant' );
			self::add_font( $site_description_font_family, $site_description_font_variants );

			/**
			 * Top Menu
			 */
			$top_menu_font_family   = foodica_get_theme_mod( 'topmenu-font-family' );
			$top_menu_font_variants = foodica_get_theme_mod( 'topmenu-font-variant' );
			self::add_font( $top_menu_font_family, $top_menu_font_variants );

			/**
			 * Main Navigation
			 */
			$main_nav_font_family   = foodica_get_theme_mod( 'mainmenu-font-family' );
			$main_nav_font_variants = foodica_get_theme_mod( 'mainmenu-font-variant' );
			self::add_font( $main_nav_font_family, $main_nav_font_variants );

			/**
			 * Main Navigation (Mobile)
			 */
			$main_nav_mobile_font_family   = foodica_get_theme_mod( 'mainmenu-mobile-font-family' );
			$main_nav_mobile_font_variants = foodica_get_theme_mod( 'mainmenu-mobile-font-variant' );
			self::add_font( $main_nav_mobile_font_family, $main_nav_mobile_font_variants );

			/**
			 * Slider Title
			 */
			$slider_title_font_family   = foodica_get_theme_mod( 'slider-title-font-family' );
			$slider_title_font_variants = foodica_get_theme_mod( 'slider-title-font-variant' );
			self::add_font( $slider_title_font_family, $slider_title_font_variants );

			/**
			 * Slider Button
			 */
			$slider_button_font_family   = foodica_get_theme_mod( 'slider-button-font-family' );
			$slider_button_font_variants = foodica_get_theme_mod( 'slider-button-font-variant' );
			self::add_font( $slider_button_font_family, $slider_button_font_variants );

			/**
			 * Widgets Title
			 */
			$widgets_title_font_family   = foodica_get_theme_mod( 'widget-title-font-family' );
			$widgets_title_font_variants = foodica_get_theme_mod( 'widget-title-font-variant' );
			self::add_font( $widgets_title_font_family, $widgets_title_font_variants );

			/**
			 * Blog Post Title
			 */
			$post_title_font_family   = foodica_get_theme_mod( 'blog-title-font-family' );
			$post_title_font_variants = foodica_get_theme_mod( 'blog-title-font-variant' );
			self::add_font( $post_title_font_family, $post_title_font_variants );

			/**
			 * Blog Post Content
			 */
			$post_content_font_family   = foodica_get_theme_mod( 'post-content-archives-font-family' );
			$post_content_font_variants = foodica_get_theme_mod( 'post-content-archives-font-variant' );
			self::add_font( $post_content_font_family, $post_content_font_variants );

			/**
			 * Single Post Title
			 */
			$single_post_title_font_family   = foodica_get_theme_mod( 'post-title-font-family' );
			$single_post_title_font_variants = foodica_get_theme_mod( 'post-title-font-variant' );
			self::add_font( $single_post_title_font_family, $single_post_title_font_variants );

			/**
			 * Single Post Content
			 */
			$single_post_content_font_family   = foodica_get_theme_mod( 'post-content-font-family' );
			$single_post_content_font_variants = foodica_get_theme_mod( 'post-content-font-variant' );
			self::add_font( $single_post_content_font_family, $single_post_content_font_variants );

			/**
			 * Single Page Title
			 */
			$single_page_title_font_family   = foodica_get_theme_mod( 'page-title-font-family' );
			$single_page_title_font_variants = foodica_get_theme_mod( 'page-title-font-variant' );
			self::add_font( $single_page_title_font_family, $single_page_title_font_variants );

			/**
			 * Footer Menu
			 */
			$footer_nav_font_family   = foodica_get_theme_mod( 'footer-menu-font-family' );
			$footer_nav_font_variants = foodica_get_theme_mod( 'footer-menu-font-variant' );
			self::add_font( $footer_nav_font_family, $footer_nav_font_variants );

			/**
			 * Other Font Variants
			 */

			$other_font_family   = array( "'Inter', sans-serif", "'Montserrat', sans-serif" );
			$other_font_variants = array( '200,300,500,600', '700' );

			foreach ( $other_font_family as $key => $font_name ) {
				self::add_font( $font_name, foodica_get_prop( $other_font_variants, $key ) );
			}
		}

		/**
		 * Adds data to the $fonts array for a font to be rendered.
		 *
		 * @since 1.2.3
		 * @param string $name The name key of the font to add.
		 * @param array  $variants An array of weight variants.
		 * @return void
		 */
		public static function add_font( $name, $variants = array() ) {
			if ( 'inherit' == $name ) {
				return;
			}
			if ( ! is_array( $variants ) ) {
				// For multiple variant selectons for fonts.
				$variants = explode( ',', str_replace( 'italic', 'i', $variants ) );
			}

			if ( is_array( $variants ) ) {
				$key = array_search( 'inherit', $variants );
				if ( false !== $key ) {
					unset( $variants[ $key ] );

					if ( ! in_array( 400, $variants ) ) {
						$variants[] = 400;
					}
				}
			} elseif ( 'inherit' == $variants ) {
				$variants = 400;
			}

			if ( isset( self::$fonts[ $name ] ) ) {
				foreach ( (array) $variants as $variant ) {
					if ( ! in_array( $variant, self::$fonts[ $name ]['variants'] ) ) {
						self::$fonts[ $name ]['variants'][] = $variant;
					}
				}
			} else {
				self::$fonts[ $name ] = array(
					'variants' => (array) $variants,
				);
			}
		}

		/**
		 * Get fonts
		 *
		 * @return array
		 */
		public static function get_fonts() {
			do_action( 'foodica/get_fonts' );
			return apply_filters( 'foodica/add_fonts', self::$fonts );
		}

		/**
		 * Get google font url
		 *
		 * @return string
		 */
		public static function get_google_font_url() {
			return self::$google_font_url;
		}

		/**
		 * Renders the <link> tag for all fonts in the $fonts array.
		 *
		 * @since 1.3.0
		 * @return void
		 */
		public static function render_fonts() {

			global $wp_customizer;

			$enable_local_google_fonts = apply_filters( 'foodica/local_google_fonts', true );

			$font_list = apply_filters( 'foodica/render_fonts', self::get_fonts() );

			$google_fonts = array();
			$font_subset  = array();

			$system_fonts = Foodica_Font_Family_Manager::get_system_fonts();

			foreach ( $font_list as $name => $font ) {
				if ( ! empty( $name ) && ! isset( $system_fonts[ $name ] ) ) {

					// Add font variants.
					$google_fonts[ $name ] = $font['variants'];

					// Add Subset.
					$subset = apply_filters( 'foodica/font_subset', '', $name );
					if ( ! empty( $subset ) ) {
						$font_subset[] = $subset;
					}
				}
			}

			require_once get_theme_file_path( 'inc/classes/class-foodica-wptt-webfont-loader.php' );

			self::$google_font_url = self::google_fonts_url( $google_fonts, $font_subset );
			$local_google_fonts_url = wptt_get_webfont_url( self::$google_font_url );

			if( $enable_local_google_fonts && ! $wp_customizer ) {
				wp_enqueue_style( 'foodica-google-fonts', $local_google_fonts_url, array(), FOODICA_THEME_VERSION, 'all' );
			}
			else {
				wp_enqueue_style( 'foodica-google-fonts', self::$google_font_url, array(), FOODICA_THEME_VERSION, 'all' );
			}

			
		}

		/**
		 * Google Font URL
		 * Combine multiple google font in one URL
		 *
		 * @link https://shellcreeper.com/?p=1476
		 * @param array $fonts      Google Fonts array.
		 * @param array $subsets    Font's Subsets array.
		 *
		 * @return string
		 */
		public static function google_fonts_url( $fonts, $subsets = array() ) {

			/* URL */
			$base_url  = 'https://fonts.googleapis.com/css';
			$font_args = array();
			$family    = array();

			$fonts = apply_filters( 'foodica/google_fonts_selected', $fonts );

			/* Format Each Font Family in Array */
			foreach ( $fonts as $font_name => $font_weight ) {
				$font_name = str_replace( ' ', '+', $font_name );
				if ( ! empty( $font_weight ) ) {
					if ( is_array( $font_weight ) ) {
						$font_weight = implode( ',', $font_weight );
					}
					$font_family = explode( ',', $font_name );
					$font_family = str_replace( "'", '', foodica_get_prop( $font_family, 0 ) );
					$family[]    = trim( $font_family . ':' . rawurlencode( trim( $font_weight ) ) );
				} else {
					$family[] = trim( $font_name );
				}
			}

			/* Only return URL if font family defined. */
			if ( ! empty( $family ) ) {

				/* Make Font Family a String */
				$family = implode( '|', $family );

				/* Add font family in args */
				$font_args['family'] = $family;

				/* Add font subsets in args */
				if ( ! empty( $subsets ) ) {

					/* format subsets to string */
					if ( is_array( $subsets ) ) {
						$subsets = implode( ',', $subsets );
					}

					$font_args['subset'] = rawurlencode( trim( $subsets ) );
				}

				$font_args['display'] = 'swap';

				$args = add_query_arg( $font_args, $base_url );

				return $args;
			}

			return '';
		}

	}

}

/**
 *  Kicking this off by calling 'get_instance()' method
 */
Foodica_Fonts_Manager::get_instance();

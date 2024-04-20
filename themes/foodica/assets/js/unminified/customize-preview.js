/* global foodicaCustomizePreview, jQuery */

/**
 * File customize-preview.js.
 *
 * Instantly live-update customizer settings in the preview for improved user experience.
 */

/**
 * Build <style> tag.
 *
 * @since 1.2.3
 *
 * @param {wp.customize} control The WordPress Customize API control.
 * @param {string} value The control value.
 * @param {string} cssProperty The CSS property.
 */
function foodicaBuildStyleTag( control, value, cssProperty ) {
	let style = '';
	let selector = '';
	let hasMediaQuery = false;

	let fakeControl = control.replace( '-' + cssProperty, '' );
	fakeControl = 'typo-' + fakeControl;

	const mediaQuery = control + '-media';
	if ( mediaQuery in foodicaCustomizePreview.selectors ) {
		hasMediaQuery = true;
	}

	if ( fakeControl in foodicaCustomizePreview.selectors ) {
		if ( hasMediaQuery ) {
			selector += foodicaCustomizePreview.selectors[ mediaQuery ] + '{';
		}
		selector += foodicaCustomizePreview.selectors[ fakeControl ];

		if ( cssProperty === 'font-size' ) {
			value += 'px';
		}

		// Build <style>.
		style =
			'<style id="' +
			control +
			'-' +
			cssProperty +
			'">' +
			selector +
			' { ' +
			cssProperty +
			': ' +
			value +
			' }' +
			( hasMediaQuery ? ' }' : '' ) +
			'</style>';
	}

	return style;
}

( function ( $ ) {
	// Site title and description.
	wp.customize( 'header_site_title', function ( value ) {
		value.bind( function ( to ) {
			$( '.site-title a' ).text( to );
		} );
	} );
	wp.customize( 'header_site_description', function ( value ) {
		value.bind( function ( to ) {
			$( '.site-description' ).text( to );
		} );
	} );
	wp.customize( 'custom_logo_text', function ( value ) {
		value.bind( function ( to ) {
			$( '.site-header .custom-logo-text' ).text( to );
		} );
	} );
	wp.customize( 'header_button_title', function ( value ) {
		value.bind( function ( to ) {
			if ( to === '' ) {
				$( '.custom-header-button' ).css( 'display', 'none' );
			} else {
				$( '.custom-header-button' )
					.css( 'display', 'inline-block' )
					.text( to );
			}
		} );
	} );

	wp.customize( 'header_search_show', function ( value ) {
		value.bind( function ( to ) {
			if ( to === true ) {
				$( '.sb-search' ).css( 'display', 'block' );
			} else if ( to === false ) {
				$( '.sb-search' ).css( 'display', 'none' );
			}
		} );
	} );

	wp.customize( 'hero_enable', function ( value ) {
		value.bind( function ( to ) {
			if ( to === true ) {
				$( '.custom-header' ).css( 'display', 'block' );
				$( document.body ).addClass( 'has-header-image' );
			} else if ( to === false ) {
				$( '.custom-header' ).css( 'display', 'none' );
				$( document.body ).removeClass( 'has-header-image' );
			}
		} );
	} );

	wp.customize( 'overlay_show', function ( value ) {
		value.bind( function ( to ) {
			if ( to === true ) {
				$(
					'.has-header-image .custom-header-media, .has-header-video .custom-header-media'
				).removeClass( 'hide_overlay' );
			} else if ( to === false ) {
				$(
					'.has-header-image .custom-header-media, .has-header-video .custom-header-media'
				).addClass( 'hide_overlay' );
			}
		} );
	} );

	// Header text color.
	wp.customize( 'header_textcolor', function ( value ) {
		value.bind( function ( to ) {
			if ( 'blank' === to ) {
				$( '.site-title, .site-description' ).css( {
					clip: 'rect(1px, 1px, 1px, 1px)',
					position: 'absolute',
				} );
				// Add class for different logo styles if title and description are hidden.
				$( 'body' ).addClass( 'title-tagline-hidden' );
			} else {
				// Check if the text color has been removed and use default colors in theme stylesheet.
				if ( ! to.length ) {
					$( '#foodica-custom-header-styles' ).remove();
				}
				$( '.site-title, .site-description' ).css( {
					clip: 'auto',
					position: 'relative',
				} );
				$(
					'.site-branding-text, .site-branding-text a, .site-description, .site-description a'
				).css( {
					color: to,
				} );
				// Add class for different logo styles if title and description are visible.
				$( 'body' ).removeClass( 'title-tagline-hidden' );
			}
		} );
	} );

	// Header button text color
	wp.customize( 'header_button_textcolor', function ( value ) {
		value.bind( function ( to ) {
			if ( 'blank' === to ) {
				$( '.custom-header-button' ).css( {
					color: '#ffffff',
				} );
			} else {
				$( '.custom-header-button' ).css( {
					color: to,
				} );
			}
		} );
	} );

    // Menu background
    wp.customize( 'color_menu_background', function ( value ) {
        value.bind( function ( to ) {
            if ( 'blank' === to ) {
                $( '.navbar' ).css( {
                    color: '#101010',
                } );
            } else {
                $( '.navbar' ).css( {
                    color: to,
                } );
            }
        } );
    } );

    // Footer backgorund
    wp.customize( 'color_footer_background', function ( value ) {
        value.bind( function ( to ) {
            if ( 'blank' === to ) {
                $( '.site-footer' ).css( {
                    background: '#101010',
                } );
            } else {
                $( '.site-footer' ).css( {
                    background: to,
                } );
            }
        } );
    } );

    // Footer text color
    wp.customize( 'color_footer_text', function ( value ) {
        value.bind( function ( to ) {
            if ( 'blank' === to ) {
                $( '.site-footer' ).css( {
                    color: '#78787f',
                } );
            } else {
                $( '.site-footer' ).css( {
                    color: to,
                } );
            }
        } );
    } );

	// Sticky Menu background Color
	wp.customize( 'color-menu-background-scroll', function ( value ) {
		value.bind( function ( to ) {
			if ( 'blank' === to ) {
				$( '.headroom--not-top .navbar' ).css( {
					background: 'rgba(0,0,0,.9)',
				} );
			} else {
				$( '.headroom--not-top .navbar' ).css( {
					background: to,
				} );
			}
		} );
	} );

	// Color scheme
	wp.customize( 'colorscheme', function ( value ) {
		value.bind( function ( to ) {
			// Update color body class.
			$( 'body' )
				.removeClass( 'colors-light colors-dark colors-custom' )
				.addClass( 'colors-' + to );
		} );
	} );

	// Custom color hex.
	wp.customize( 'colorscheme_hex', function ( value ) {
		value.bind( function ( to ) {
			// Update custom color CSS.
			const style = $( '#custom-theme-colors' );
			const hex = style.data( 'hex' );
			let css = style.html();

			css = css.replaceAll( hex, to );
			style.html( css ).data( 'hex', to );
		} );
	} );

	// Whether a header image is available.
	function hasHeaderImage() {
		const image = wp.customize( 'header_image' )();
		return '' !== image && 'remove-header' !== image;
	}

	// Whether a header video is available.
	function hasHeaderVideo() {
		const externalVideo = wp.customize( 'external_header_video' )(),
			video = wp.customize( 'header_video' )();

		return '' !== externalVideo || ( 0 !== video && '' !== video );
	}

	// Toggle a body class if a custom header exists.
	$.each(
		[ 'external_header_video', 'header_image', 'header_video' ],
		function ( index, settingId ) {
			wp.customize( settingId, function ( setting ) {
				setting.bind( function () {
					if ( hasHeaderImage() ) {
						$( document.body ).addClass( 'has-header-image' );
					} else {
						$( document.body ).removeClass( 'has-header-image' );
					}

					if ( ! hasHeaderVideo() ) {
						$( document.body ).removeClass( 'has-header-video' );
					}
				} );
			} );
		}
	);

	$.each(
		[
			'body-font-family',
			'title-font-family',
			'description-font-family',
			'topmenu-font-family',
			'mainmenu-font-family',
			'mainmenu-mobile-font-family',
			'slider-title-font-family',
			'slider-button-font-family',
			'widget-title-font-family',
			'blog-title-font-family',
			'post-content-archives-font-family',
			'post-title-font-family',
			'post-content-font-family',
			'page-title-font-family',
			'footer-menu-font-family'
			
		],
		function ( __, control ) {
			/**
			 * Generate Font Family CSS
			 *
			 * @since 1.3.0
			 * @see https://github.com/brainstormforce/astra/blob/663761d3419f25640af9b59e64384bd07f810bc4/assets/js/unminified/customizer-preview.js#L369
			 */
			wp.customize( control, function ( value ) {

				value.bind( function ( newValue ) {
					if( newValue in foodicaCustomizePreview.systemFonts ) {
						newValue = foodicaCustomizePreview.systemFonts[newValue].stack;
					}

					const cssProperty = 'font-family';
					const style = foodicaBuildStyleTag(
						control,
						newValue,
						cssProperty
					);
					let link = '';

					let fontName = newValue.split( ',' )[ 0 ];
					// Replace ' character with space, necessary to separate out font prop value.
					fontName = fontName.replace( /'/g, '' );

					// Remove <style> first!
					$( 'style#' + control + '-' + cssProperty ).remove();

					if ( fontName in foodicaCustomizePreview.googleFonts ) {
						fontName = fontName.split( ' ' ).join( '+' );

						// Remove old.
						$( 'link#' + control ).remove();
						link =
							'<link id="' +
							control +
							'" href="https://fonts.googleapis.com/css?family=' +
							fontName +
							'" rel="stylesheet">';
					}

					// Concat and append new <style> and <link>.
					$( 'head' ).append( style + link );
				} );
			} );
		}
	);

	$.each(
		[
			'body-font-weight',
			'title-font-weight',
			'description-font-weight',
			'topmenu-font-weight',
			'mainmenu-font-weight',
			'mainmenu-mobile-font-weight',
			'slider-title-font-weight',
			'slider-button-font-weight',
			'widget-title-font-weight',
			'blog-title-font-weight',
			'post-content-archives-font-weight',
			'post-title-font-weight',
			'post-content-font-weight',
			'page-title-font-weight',
			'footer-menu-font-weight'
		],
		function ( __, control ) {
			/**
			 * Generate Font Weight CSS
			 *
			 * @since 1.3.0
			 * @see https://github.com/brainstormforce/astra/blob/663761d3419f25640af9b59e64384bd07f810bc4/assets/js/unminified/customizer-preview.js#L409
			 */
			wp.customize( control, function ( value ) {
				value.bind( function ( newValue ) {
					const cssProperty = 'font-weight';
					const style = foodicaBuildStyleTag(
						control,
						newValue,
						cssProperty
					);
					const fontControl = control.replace(
						'font-weight',
						'font-family'
					);
					let link = '';

					if ( newValue ) {
						let fontName =
							wp.customize._value[ fontControl ]._value;
						fontName = fontName.split( ',' );
						fontName = fontName[ 0 ].replace( /'/g, '' );

						// Remove old.
						$( 'style#' + control + '-' + cssProperty ).remove();

						if ( fontName in foodicaCustomizePreview.googleFonts ) {
							// Remove old.
							$( '#' + fontControl ).remove();

							if ( newValue === 'inherit' ) {
								link =
									'<link id="' +
									fontControl +
									'" href="https://fonts.googleapis.com/css?family=' +
									fontName +
									'"  rel="stylesheet">';
							} else {
								link =
									'<link id="' +
									fontControl +
									'" href="https://fonts.googleapis.com/css?family=' +
									fontName +
									'%3A' +
									newValue +
									'"  rel="stylesheet">';
							}
						}

						// Concat and append new <style> and <link>.
						$( 'head' ).append( style + link );
					} else {
						// Remove old.
						$( 'style#' + control ).remove();
					}
				} );
			} );
		}
	);

	$.each(
		[
			'body-font-size',
			'title-font-size',
			'description-font-size',
			'topmenu-font-size',
			'mainmenu-font-size',
			'mainmenu-mobile-font-size',
			'slider-title-font-size',
			'slider-button-font-size',
			'widget-title-font-size',
			'blog-title-font-size',
			'post-content-archives-font-size',
			'post-title-font-size',
			'post-content-font-size',
			'page-title-font-size',
			'footer-menu-font-size'
			
		],
		function ( __, control ) {
			/**
			 * Generate Font Size CSS
			 *
			 * @since 1.3.0
			 */
			wp.customize( control, function ( value ) {
				value.bind( function ( newValue ) {
					const cssProperty = 'font-size';
					const style = foodicaBuildStyleTag(
						control,
						newValue,
						cssProperty
					);
					// Remove old.
					$( 'style#' + control + '-' + cssProperty ).remove();

					$( 'head' ).append( style );
				} );
			} );
		}
	);

	$.each(
		[
			'body-text-transform',
			'title-text-transform',
			'description-text-transform',
			'topmenu-text-transform',
			'mainmenu-text-transform',
			'mainmenu-mobile-text-transform',
			'slider-title-text-transform',
			'slider-button-text-transform',
			'widget-title-text-transform',
			'blog-title-text-transform',
			'post-content-archives-text-transform',
			'post-title-text-transform',
			'post-content-text-transform',
			'page-title-text-transform',
			'footer-menu-text-transform'
		],
		function ( __, control ) {
			/**
			 * Generate Text Transform CSS
			 *
			 * @since 1.3.0
			 */
			wp.customize( control, function ( value ) {
				value.bind( function ( newValue ) {
					const cssProperty = 'text-transform';
					const style = foodicaBuildStyleTag(
						control,
						newValue,
						cssProperty
					);
					// Remove old.
					$( 'style#' + control + '-' + cssProperty ).remove();

					$( 'head' ).append( style );
				} );
			} );
		}
	);

	$.each(
		[
			'body-line-height',
			'title-line-height',
			'description-line-height',
			'topmenu-line-height',
			'mainmenu-line-height',
			'mainmenu-mobile-line-height',
			'slider-title-line-height',
			'slider-button-line-height',
			'widget-title-line-height',
			'blog-title-line-height',
			'post-content-archives-line-height',
			'post-title-line-height',
			'post-content-line-height',
			'page-title-line-height',
			'footer-menu-line-height'
		],
		function ( __, control ) {
			/**
			 * Generate Line Height CSS
			 *
			 * @since 1.3.0
			 */
			wp.customize( control, function ( value ) {
				value.bind( function ( newValue ) {
					const cssProperty = 'line-height';
					const style = foodicaBuildStyleTag(
						control,
						newValue,
						cssProperty
					);
					// Remove old.
					$( 'style#' + control + '-' + cssProperty ).remove();

					$( 'head' ).append( style );
				} );
			} );
		}
	);
} )( jQuery );
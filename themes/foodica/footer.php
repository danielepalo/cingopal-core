<?php
/**
 * The template for displaying the footer
 *
 */


$widgets_areas = get_theme_mod( 'footer-layout', '4' );

$has_active_sidebar = false;
if ( $widgets_areas > 0 ) {
    $i = 1;

    while ( $i <= $widgets_areas ) {
        if ( is_active_sidebar( 'footer_' . $i ) ) {
            $has_active_sidebar = true;
            break;
        }

        $i++;
    }
}

?>

    </div><!-- ./inner-wrap -->

    <footer id="colophon" class="site-footer" role="contentinfo">

        <?php if ( $has_active_sidebar ) : ?>

            <div class="inner-wrap">

                <div class="footer-widgets widgets widget-columns-<?php echo esc_attr( $widgets_areas ); ?>">
                    <?php for ( $i = 1; $i <= $widgets_areas; $i ++ ) : ?>

                        <div class="column">
                            <?php dynamic_sidebar( 'footer_' . $i ); ?>
                        </div><!-- .column -->

                    <?php endfor; ?>

                    <div class="clear"></div>
                </div><!-- .footer-widgets -->

            </div>


        <?php endif; ?>

        <?php if ( has_nav_menu( 'tertiary' ) ) { ?>

            <div class="footer-menu">
                <?php wp_nav_menu( array( 'sort_column' => 'menu_order', 'container_class' => 'menu-footer', 'theme_location' => 'tertiary', 'depth' => '1' ) ); ?>
            </div>

        <?php } ?>

        <div class="site-info">

            <span class="copyright">

                <?php
                    /* translators: 1: poweredby, 2: link, 3: span tag closed  */
                    printf( esc_html__( ' %1$sPowered by %2$s%3$s', 'foodica' ), '<span>', '<a href="'. esc_url( __( 'https://wordpress.org/', 'foodica' ) ) .'" target="_blank">WordPress.</a>', '</span>' );
                    /* translators: 1: designedby, 2: link, 3: span tag closed  */
                    printf( esc_html__( ' %1$sFoodica WordPress Theme by %2$s%3$s', 'foodica' ), '<span>', '<a href="'. esc_url( __( 'https://www.wpzoom.com/', 'foodica' ) ) .'" rel="nofollow" target="_blank">WPZOOM.</a>', '</span>' );
                ?>
            </span>

        </div><!-- .site-info -->
    </footer><!-- #colophon -->

</div>
<?php wp_footer(); ?>

</body>
</html>
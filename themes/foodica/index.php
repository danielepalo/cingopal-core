<?php
/**
 * The main template file.
 */

get_header();

$front_page_layout = get_theme_mod( 'front-page-layout', 'right-sidebar' );

$content_classes = "content-area";
$content_classes .= 'full-width' === $front_page_layout ? " full-layout" : '';
?>

<?php if ( is_front_page() && $paged < 2) : ?>

    <?php get_template_part( 'wpzoom-slider' ); ?>

<?php endif; ?>

<main id="main" class="site-main" role="main">

    <?php if ( 'left-sidebar' === $front_page_layout ): ?>
        <?php get_sidebar(); ?>
    <?php endif ?>

    <section class="<?php echo esc_attr( $content_classes ); ?>">

            <h2 class="section-title"><?php esc_html_e('Latest Posts', 'foodica'); ?></h2>

            <?php if ( have_posts() ) : ?>

                <section id="recent-posts" class="recent-posts">

                    <?php  while ( have_posts() ) : the_post();  ?>

                        <?php if ( is_sticky() && $paged < 2 ) {

                            get_template_part( 'content', 'sticky' );

                        } else {

                            get_template_part( 'content', get_post_format() );
                        } ?>

                    <?php endwhile; ?>

                </section>

                <?php get_template_part( 'pagination' ); ?>

            <?php else: ?>

                <?php get_template_part( 'content', 'none' ); ?>

            <?php endif; ?>

        <div class="clear"></div>

    </section><!-- .content-area -->

    <?php if ( 'right-sidebar' === $front_page_layout ): ?>
        <?php get_sidebar(); ?>
    <?php endif ?>

</main><!-- .site-main -->

<?php
get_footer();
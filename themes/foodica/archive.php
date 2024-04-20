<?php
/**
 * The main template file.
 */

get_header();

$archives_page_layout = get_theme_mod( 'archives-layout', 'full-width' );

$content_classes = "content-area";
$content_classes .= 'full-width' === $archives_page_layout ? " full-layout" : '';
?>

<main id="main" class="site-main" role="main">

    <?php if ( 'left-sidebar' === $archives_page_layout ): ?>
        <?php get_sidebar(); ?>
    <?php endif ?>

    <section class="<?php echo esc_attr( $content_classes ); ?>">

        <?php the_archive_title( '<h2 class="section-title">', '</h2>' ); ?>

        <?php if (is_category() ) { ?><div class="category_description"><?php echo category_description(); ?></div><?php } ?>

        <?php if ( have_posts() ) : ?>

            <section id="recent-posts" class="recent-posts">

                <?php while ( have_posts() ) : the_post();  ?>

                    <?php get_template_part( 'content', get_post_format() ); ?>

                <?php endwhile; ?>

            </section>

            <?php get_template_part( 'pagination' ); ?>

        <?php else: ?>

            <?php get_template_part( 'content', 'none' ); ?>

        <?php endif; ?>

        <div class="clear"></div>

    </section><!-- .content-area -->

    <?php if ( 'right-sidebar' === $archives_page_layout ): ?>
        <?php get_sidebar(); ?>
    <?php endif ?>

</main><!-- .site-main -->

<?php
get_footer();
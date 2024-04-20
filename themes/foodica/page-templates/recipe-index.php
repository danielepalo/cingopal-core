<?php
/*
Template Name: Recipe Index (Infinite Scroll)
*/
?>
<?php get_header();

$front_page_layout = get_theme_mod( 'front-page-layout', 'right-sidebar' );

$content_classes = "content-area";
$content_classes .= 'full-width' === $front_page_layout ? " full-layout" : '';
?>

<main id="main" class="site-main food-index-main" role="main">

    <?php if ( 'left-sidebar' === $front_page_layout ): ?>
        <?php get_sidebar(); ?>
    <?php endif ?>

    <section class="<?php echo esc_attr( $content_classes ); ?>">

        <?php get_template_part( 'recipe-index-start' ); ?>

        <?php
            $paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;

            $args = array(
                'paged' => $paged,
                'post_type' => 'post',
                'posts_per_page' => 12,
                'ignore_sticky_posts' => true
            );

            /* Exclude categories */

            $wp_query = new WP_Query( $args );

            if ( $wp_query->have_posts() ) : ?>

            <script type="text/javascript">
                var wpz_currPage = <?php echo $paged; ?>,
                    wpz_maxPages = <?php echo $wp_query->max_num_pages; ?>,
                    wpz_pagingURL = '<?php the_permalink(); ?>page/';
            </script>

            <section id="recent-posts" class="foodica-index">

                <?php while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>

                    <?php get_template_part('content-index'); ?>

                <?php endwhile; ?>

            </section>

            <?php get_template_part( 'pagination' ); ?>

        <?php else: ?>

            <?php get_template_part( 'content', 'none' ); ?>

        <?php endif; ?>

    </section><!-- .content-area -->

    <?php if ( 'right-sidebar' === $front_page_layout ): ?>
        <?php get_sidebar(); ?>
    <?php endif ?>

</main><!-- .site-main -->

<?php
get_footer();

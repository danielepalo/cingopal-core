<?php get_header(); ?>

<main id="main" class="site-main" role="main">

   <h2 class="section-title"><?php esc_html_e('Search Results for','foodica');?> <strong>"<?php the_search_query(); ?>"</strong></h2>

    <section class="content-area full-layout">

        <?php if ( have_posts() ) : ?>

            <section id="recent-posts" class="recent-posts">

                <?php while ( have_posts() ) : the_post(); ?>

                    <?php get_template_part( 'content', get_post_format() ); ?>

                <?php endwhile; ?>

            </section><!-- .recent-posts -->

            <?php get_template_part( 'pagination' ); ?>

        <?php else: ?>

            <?php get_template_part( 'content', 'none' ); ?>

        <?php endif; ?>

    </section><!-- .content-area -->

</main><!-- .site-main -->

<?php
get_footer();

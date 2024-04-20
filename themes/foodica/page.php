<?php
/**
 * The Template for displaying all single posts.
 */


get_header(); ?>

    <main id="main" class="site-main" role="main">

        <?php while ( have_posts() ) : the_post(); ?>

            <div class="content-area">

                <?php get_template_part( 'content', 'page' ); ?>

                <?php comments_template(); ?>

            </div>

        <?php endwhile; // end of the loop. ?>

        <?php get_sidebar(); ?>

    </main><!-- #main -->

<?php get_footer(); ?>
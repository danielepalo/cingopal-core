<?php
/*
Template Name: Full-width Page
*/

get_header(); ?>

    <main id="main" class="site-main full-width-page" role="main">

        <?php while ( have_posts() ) : the_post(); ?>

            <?php get_template_part( 'content', 'page' ); ?>

            <?php comments_template(); ?>

        <?php endwhile; // end of the loop. ?>

    </main><!-- #main -->

<?php get_footer(); ?>
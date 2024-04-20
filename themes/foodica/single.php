<?php
/**
 * The Template for displaying all single posts.
 */

$post_layout = get_post_meta( get_the_ID(), '_foodica_post_layout', true );

get_header(); ?>

    <main id="main" class="site-main<?php if ($post_layout == 'column-full') { echo ' full-width'; } ?>" role="main">

        <?php while ( have_posts() ) : the_post(); ?>

            <div class="content-area">

                <?php get_template_part( 'content', 'single' ); ?>

                <?php comments_template(); ?>

            </div>

        <?php endwhile; // end of the loop. ?>

        <?php if ($post_layout != 'column-full') { ?>

            <?php get_sidebar(); ?>

        <?php } else { echo "<div class=\"clear\"></div>"; } ?>

    </main><!-- #main -->

<?php get_footer(); ?>
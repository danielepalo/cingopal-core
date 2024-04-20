<?php get_header(); ?>

<main id="main" class="site-main" role="main">

    <section class="content-area">

        <header class="page-header">

            <h1 class="entry-title"><?php esc_html_e('Error 404', 'foodica'); ?></h1>

        </header><!-- .page-header -->

        <?php get_template_part( 'content', 'none' ); ?>

    </section><!-- .content-area -->

    <?php get_sidebar(); ?>

</main><!-- .site-main -->

<?php
get_footer();

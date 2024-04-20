<?php
/**
 * The template part for displaying a message that posts cannot be found.
 */
?>


<div class="entry-content">

    <h3><?php esc_html_e( 'Nothing Found', 'foodica' ); ?></h3>

    <?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

        <?php /* translators: %s: link to new post page */ ?>
        <p><?php printf( esc_html__( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'foodica' ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>

    <?php elseif ( is_search() ) : ?>

        <p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'foodica' ); ?></p>
        <?php get_search_form(); ?>

    <?php else : ?>

        <p><?php esc_html_e( 'It seems that we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'foodica' ); ?></p>
        <?php get_search_form(); ?>

    <?php endif; ?>
</div><!-- .entry-content -->

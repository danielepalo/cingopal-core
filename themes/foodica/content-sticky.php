<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <?php if ( has_post_thumbnail() ) : ?>
        <div class="post-thumb"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
            <?php the_post_thumbnail('foodica-loop-sticky'); ?>
        </a></div>
    <?php endif;  ?>

    <section class="entry-body">

        <span class="cat-links"><?php echo get_the_category_list( ', ' ); ?></span>

        <?php the_title( sprintf( '<h3 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' ); ?>

        <div class="entry-meta">
            <?php printf( '<span class="entry-date"><time class="entry-date" datetime="%1$s">%2$s</time></span>', esc_attr( get_the_date( 'c' ) ), esc_html( get_the_date() ) ); ?>
            <?php printf( '<span class="entry-author">%s ', __( 'by', 'foodica' ) ); the_author_posts_link(); print('</span>'); ?>

            <?php

            if ( ! post_password_required() && ( comments_open() || 0 != get_comments_number() ) ) :
                echo '<span class="comments-link">';
                comments_popup_link( __('0 comments', 'foodica'), __('1 comment', 'foodica'), __('% comments', 'foodica'), '', __('Comments are Disabled', 'foodica'));

                echo '</span>';
            endif; ?>

            <?php edit_post_link( __( 'Edit', 'foodica' ), '<span class="edit-link">', '</span>' ); ?>
        </div>

        <div class="entry-content">
            <?php the_excerpt(); ?>
        </div>

        <div class="readmore_button">
            <?php /* translators: %s: post title */ ?>
            <a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'foodica' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php esc_html_e('Read More', 'foodica'); ?></a>
        </div>

    </section>

    <div class="clearfix"></div>
</div><!-- #post-<?php the_ID(); ?> -->
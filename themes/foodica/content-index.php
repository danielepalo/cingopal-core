<article id="post-<?php the_ID(); ?>" <?php post_class('regular-post'); ?>>

    <?php
        if ( has_post_thumbnail() ) : ?>
            <div class="post-thumb"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                <?php the_post_thumbnail('foodica-loop-portrait'); ?>
            </a></div>
    <?php endif; ?>

    <section class="entry-body">

        <?php printf( '<span class="cat-links">%s</span>', get_the_category_list( ', ' ) ); ?>

        <?php the_title( sprintf( '<h3 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' ); ?>

    </section>

    <div class="clearfix"></div>
</article><!-- #post-<?php the_ID(); ?> -->
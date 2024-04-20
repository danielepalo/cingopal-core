<div class="navigation"><?php
    the_posts_pagination(
        array(
            'prev_text'          => __( '&larr; Previous', 'foodica' ),
            'next_text'          => __( 'Next &rarr;', 'foodica' ),
            'mid_size'           => 1
        )
    ); ?>
</div>
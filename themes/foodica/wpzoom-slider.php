<?php
// Get our Featured Content posts
$slider = foodica_get_featured_content();

// If we have no posts, our work is done here
if ( empty( $slider ) )
    return;

?>

<div id="slider" class="style-1">

	<ul class="slides clearfix">

		<?php foreach ( $slider as $post ) : setup_postdata( $post ); ?>

            <?php

            $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'foodica-loop-sticky');

            $style = ' style="background-image:url(\'' . $large_image_url[0] . '\')"';

            ?>

            <li class="slide">

                <div class="slide-overlay">

                    <div class="slide-header">

                       <?php printf( '<span class="cat-links">%s</span>', get_the_category_list( ', ' ) ); ?>

                        <?php the_title( sprintf( '<h3><a href="%s">', esc_url( get_permalink() ) ), '</a></h3>' ); ?>

                        <div class="entry-meta">
                            <?php printf( '<span class="entry-date"><time class="entry-date" datetime="%1$s">%2$s</time></span>', esc_attr( get_the_date( 'c' ) ), esc_html( get_the_date() ) ); ?>
                            <span class="comments-link"><?php comments_popup_link( __('0 comments', 'foodica'), __('1 comment', 'foodica'), __('% comments', 'foodica'), '', __('Comments are Disabled', 'foodica')); ?></span>
                        </div>

                        <div class="slide_button">
                            <?php /* translators: %s: link to the post */ ?>
                            <a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'foodica' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php esc_html_e('Read More', 'foodica'); ?></a>
                        </div>

                    </div>

                </div>

                <div class="slide-background" <?php echo $style; ?>>
                </div>
            </li>
        <?php endforeach; ?>

	</ul>

</div>

<?php wp_reset_postdata(); ?>
<?php
/**
 * @package Foodica
 */

if ( post_password_required() )
    return;
?>

<div id="comments">

    <?php if ( have_comments() ) : ?>

        <h3><?php comments_number( __( 'Leave a comment', 'foodica' ) ); ?></h3>

        <ol class="commentlist">
            <?php wp_list_comments( 'avatar_size=80' ); ?>
        </ol>

        <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
        <nav id="comment-nav-below" class="navigation clearfix">
            <h1 class="assistive-text"><?php _e( 'Comment navigation', 'foodica' ); ?></h1>
            <span class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'foodica' ) ); ?></span>
            <span class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'foodica' ) ); ?></span>
        </nav>
        <?php endif; // check for comment navigation

    endif;

    // If comments are closed and there are comments, let's leave a little note, shall we?
    if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>

        <p class="nocomments"><?php _e( 'Comments are closed.', 'foodica' ); ?></p>

    <?php
    endif;

    comment_form(); ?>

</div><!-- #comments -->
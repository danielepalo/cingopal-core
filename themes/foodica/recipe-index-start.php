<?php
    if ( function_exists('yoast_breadcrumb') ) {
      yoast_breadcrumb( '<div class="wpz_breadcrumbs">','</div>' );
    }
?>

<div class="foodica-index-search"><?php get_search_form(); ?></div>

<div class="food_index_menu">
    <?php if ( has_nav_menu( 'index' ) ) { ?>

        <?php wp_nav_menu( array( 'sort_column' => 'menu_order', 'container_class' => 'menu-index', 'theme_location' => 'index', 'depth' => '1' ) ); ?>

    <?php } ?>

</div>

<h2 class="entry-title"><?php the_title(); ?></h2>

<?php
    global $post;
    $content = $post->post_content;

echo '<div class="recipe_description_top">'.$content.'</div>'; ?>

<div class="clear"></div>
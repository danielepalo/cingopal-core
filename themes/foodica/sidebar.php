<?php
/**
 * The sidebar.
 */
?>

<div id="sidebar" class="site-sidebar">

    <?php if ( ! dynamic_sidebar( 'sidebar-1' ) ) : ?>

        <?php
            the_widget('WP_Widget_Recent_Posts', 'title=' . esc_html__('Recent Posts', 'foodica') , 'before_title=<h3 class="title"><span>&after_title=</span></h3>&before_widget=<div class="widget">&after_widget=</div>');
        ?>

        <?php
            the_widget( 'WP_Widget_Categories', 'title=' . esc_html__('Categories', 'foodica'), 'before_title=<h3 class="title"><span>&after_title=</span></h3>&before_widget=<div class="widget">&after_widget=</div>');
        ?>

        <div id="tag_cloud" class="widget">
            <h3 class="title"><?php esc_html_e( 'Popular Tags', 'foodica' ); ?></h3>
            <div class="tagcloud">
                <?php wp_tag_cloud( 'show_count=1&smallest=8&largest=22&number=12' ); ?>
            </div>
        </div>


        <div id="meta" class="widget">
            <h3 class="title"><?php esc_html_e( 'Meta', 'foodica' ); ?></h3>
            <ul>
                <?php wp_register(); ?>
                <li><?php wp_loginout(); ?></li>
                <?php wp_meta(); ?>
            </ul>
        </div>

    <?php endif; // end sidebar widget area ?>

</div><!-- end .site-sidebar -->
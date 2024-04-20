<?php
/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see         http://docs.woothemes.com/document/template-structure/
 * @author      WooThemes
 * @package     WooCommerce/Templates
 * @version     1.6.4
 */

get_header('shop'); ?>

	<main id="main" class="site-main" role="main">

 		<?php woocommerce_breadcrumb(); ?>

 		<div class="shop-wrapper">

			<div class="entry-content">

				<?php do_action('woocommerce_output_content_wrapper'); ?>

					<?php while ( have_posts() ) : the_post(); ?>

						<?php wc_get_template_part( 'content', 'single-product' ); ?>

					<?php endwhile; // end of the loop. ?>

				<div class="cleaner">&nbsp;</div>

			</div><!-- / .entry -->

		</div><!-- / .shop-wrapper -->

	</main><!-- /#main -->

<?php get_footer('shop'); ?>
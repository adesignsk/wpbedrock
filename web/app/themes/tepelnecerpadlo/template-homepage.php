<?php
/**
 * The template for displaying the homepage.
 *
 * This page template will display any functions hooked into the `homepage` action.
 * By default this includes a variety of product displays and the page content itself. To change the order or toggle these components
 * use the Homepage Control plugin.
 * https://wordpress.org/plugins/homepage-control/
 *
 * Template name: Homepage
 *
 * @package hydra
 */

get_header(); ?>

	</div>


	<?php
	/**
	 * Functions hooked in to fullwidth-homepage-before action
	 *
	 * @hooked hydra_content_block_homepage() - 10
	 * @hooked hydra_recent_post_homepage()   - 20
	 * @hooked hydra_wc_featured_homepage()   - 30
	 * @hooked hydra_text_block_homepage()    - 40
	 */
	do_action( 'fullwidth-homepage-before' ); ?>


	<div class="col-full">

		<div id="primary" class="content-area">
			<main id="main" class="site-main" role="main">

			<?php
			/**
			 * Functions hooked in to homepage action
			 *
			 * @hooked hydra_homepage_content         - 10
			 * @hooked hydra_product_categories       - 20
			 * @hooked hydra_recent_products          - 30
			 * @hooked hydra_featured_products        - 40
			 * @hooked hydra_popular_products         - 50
			 * @hooked hydra_on_sale_products         - 60
			 * @hooked hydra_best_selling_products    - 70
			 */
			do_action( 'homepage' ); ?>

		</main><!-- #main -->
	</div><!-- #primary -->
<?php
get_footer();

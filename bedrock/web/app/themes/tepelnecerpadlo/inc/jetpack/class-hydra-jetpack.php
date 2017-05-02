<?php
/**
 * hydra Jetpack Class
 *
 * @package  hydra
 * @author   WooThemes
 * @since    2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'hydra_Jetpack' ) ) :

	/**
	 * The hydra Jetpack integration class
	 */
	class hydra_Jetpack {

		/**
		 * Setup class.
		 *
		 * @since 1.0
		 */
		public function __construct() {
			add_action( 'after_setup_theme', 	array( $this, 'jetpack_setup' ) );
			add_action( 'wp_enqueue_scripts', 	array( $this, 'jetpack_scripts' ), 	10 );
		}

		/**
		 * Add theme support for Infinite Scroll.
		 * See: http://jetpack.me/support/infinite-scroll/
		 */
		public function jetpack_setup() {
			add_theme_support( 'infinite-scroll', apply_filters( 'hydra_jetpack_infinite_scroll_args', array(
				'container'      => 'main',
				'footer'         => 'page',
				'type'           => 'click',
				'posts_per_page' => '12',
				'render'         => array( $this, 'jetpack_infinite_scroll_loop' ),
				'footer_widgets' => array(
										'footer-1',
										'footer-2',
										'footer-3',
										'footer-4',
									),
			) ) );
		}

		/**
		 * A loop used to display content appended using Jetpack inifinte scroll
		 * @return void
		 */
		public function jetpack_infinite_scroll_loop() {
			if ( hydra_is_product_archive() ) {
				woocommerce_product_loop_start();
			}

			while ( have_posts() ) : the_post();
				if ( hydra_is_product_archive() ) {
					wc_get_template_part( 'content', 'product' );
				} else {
					get_template_part( 'content', get_post_format() );
				}
			endwhile; // end of the loop.

			if ( hydra_is_product_archive() ) {
				woocommerce_product_loop_end();
			}
		}

		/**
		 * Enqueue jetpack styles.
		 *
		 * @since  1.6.1
		 */
		public function jetpack_scripts() {
			global $hydra_version;

			wp_enqueue_style( 'hydra-jetpack-style', get_template_directory_uri() . '/assets/sass/jetpack/jetpack.css', '', $hydra_version );
			wp_style_add_data( 'hydra-jetpack-style', 'rtl', 'replace' );
		}
	}

endif;

return new hydra_Jetpack();

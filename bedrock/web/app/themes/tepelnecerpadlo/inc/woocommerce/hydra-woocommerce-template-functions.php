<?php
/**
 * WooCommerce Template Functions.
 *
 * @package hydra
 */

if ( ! function_exists( 'hydra_before_content' ) ) {
	/**
	 * Before Content
	 * Wraps all WooCommerce content in wrappers which match the theme markup
	 *
	 * @since   1.0.0
	 * @return  void
	 */
	function hydra_before_content() {
		?>
		<div id="primary" class="content-area">
			<main id="main" class="site-main" role="main">
		<?php
	}
}

if ( ! function_exists( 'hydra_after_content' ) ) {
	/**
	 * After Content
	 * Closes the wrapping divs
	 *
	 * @since   1.0.0
	 * @return  void
	 */
	function hydra_after_content() {
		?>
			</main><!-- #main -->
		</div><!-- #primary -->

		<?php do_action( 'hydra_sidebar' );
	}
}

if ( ! function_exists( 'hydra_cart_link_fragment' ) ) {
	/**
	 * Cart Fragments
	 * Ensure cart contents update when products are added to the cart via AJAX
	 *
	 * @param  array $fragments Fragments to refresh via AJAX.
	 * @return array            Fragments to refresh via AJAX
	 */
	function hydra_cart_link_fragment( $fragments ) {
		global $woocommerce;

		ob_start();
		hydra_cart_link();
		$fragments['a.cart-contents'] = ob_get_clean();

		ob_start();
		hydra_handheld_footer_bar_cart_link();
		$fragments['a.footer-cart-contents'] = ob_get_clean();

		return $fragments;
	}
}

if ( ! function_exists( 'hydra_cart_link' ) ) {
	/**
	 * Cart Link
	 * Displayed a link to the cart including the number of items present and the cart total
	 *
	 * @return void
	 * @since  1.0.0
	 */
	function hydra_cart_link() {
		?>
			<a class="cart-contents" href="<?php echo esc_url( WC()->cart->get_cart_url() ); ?>" title="<?php esc_attr_e( 'View your shopping cart', 'hydra' ); ?>">
				<span class="amount"><?php echo wp_kses_data( WC()->cart->get_cart_subtotal() ); ?></span> <span class="count"><?php echo wp_kses_data( sprintf( _n( '%d item', '%d items', WC()->cart->get_cart_contents_count(), 'hydra' ), WC()->cart->get_cart_contents_count() ) );?></span>
			</a>
		<?php
	}
}

if ( ! function_exists( 'hydra_product_search' ) ) {
	/**
	 * Display Product Search
	 *
	 * @since  1.0.0
	 * @uses  hydra_is_woocommerce_activated() check if WooCommerce is activated
	 * @return void
	 */
	function hydra_product_search() {
		if ( hydra_is_woocommerce_activated() ) { ?>
				<div id="site-search" class="site-search">
					<div id="close-search">×</div>
					<?php //the_widget( 'WC_Widget_Product_Search', 'title=' ); ?>
					<?php get_search_form( $echo = true ); ?>
				</div>
		<?php
		}
	}
}

if ( ! function_exists( 'hydra_header_cart' ) ) {
	/**
	 * Display Header Cart
	 *
	 * @since  1.0.0
	 * @uses  hydra_is_woocommerce_activated() check if WooCommerce is activated
	 * @return void
	 */
	function hydra_header_cart() {
		if ( hydra_is_woocommerce_activated() ) {
			if ( is_cart() ) {
				$class = 'current-menu-item';
			} else {
				$class = '';
			}
		?>
		<ul id="site-header-cart" class="site-header-cart menu">
			<li class="<?php echo esc_attr( $class ); ?>">
				<?php hydra_cart_link(); ?>
			</li>
			<li>
				<?php the_widget( 'WC_Widget_Cart', 'title=' ); ?>
			</li>
		</ul>
		<?php
		}
	}
}

if ( ! function_exists( 'hydra_upsell_display' ) ) {
	/**
	 * Upsells
	 * Replace the default upsell function with our own which displays the correct number product columns
	 *
	 * @since   1.0.0
	 * @return  void
	 * @uses    woocommerce_upsell_display()
	 */
	function hydra_upsell_display() {
		woocommerce_upsell_display( -1, 4 );
	}
}

if ( ! function_exists( 'hydra_sorting_wrapper' ) ) {
	/**
	 * Sorting wrapper
	 *
	 * @since   1.4.3
	 * @return  void
	 */
	function hydra_sorting_wrapper() {
		echo '<div class="hydra-sorting">';
	}
}

if ( ! function_exists( 'hydra_sorting_wrapper_close' ) ) {
	/**
	 * Sorting wrapper close
	 *
	 * @since   1.4.3
	 * @return  void
	 */
	function hydra_sorting_wrapper_close() {
		echo '</div>';
	}
}

if ( ! function_exists( 'hydra_shop_messages' ) ) {
	/**
	 * hydra shop messages
	 *
	 * @since   1.4.4
	 * @uses    hydra_do_shortcode
	 */
	function hydra_shop_messages() {
		if ( ! is_checkout() ) {
			echo wp_kses_post( hydra_do_shortcode( 'woocommerce_messages' ) );
		}
	}
}

if ( ! function_exists( 'hydra_woocommerce_pagination' ) ) {
	/**
	 * hydra WooCommerce Pagination
	 * WooCommerce disables the product pagination inside the woocommerce_product_subcategories() function
	 * but since hydra adds pagination before that function is excuted we need a separate function to
	 * determine whether or not to display the pagination.
	 *
	 * @since 1.4.4
	 */
	function hydra_woocommerce_pagination() {
		if ( woocommerce_products_will_display() ) {
			woocommerce_pagination();
		}
	}
}

if ( ! function_exists( 'hydra_promoted_products' ) ) {
	/**
	 * Featured and On-Sale Products
	 * Check for featured products then on-sale products and use the appropiate shortcode.
	 * If neither exist, it can fallback to show recently added products.
	 *
	 * @since  1.5.1
	 * @param integer $per_page total products to display.
	 * @param integer $columns columns to arrange products in to.
	 * @param boolean $recent_fallback Should the function display recent products as a fallback when there are no featured or on-sale products?.
	 * @uses  hydra_is_woocommerce_activated()
	 * @uses  wc_get_featured_product_ids()
	 * @uses  wc_get_product_ids_on_sale()
	 * @uses  hydra_do_shortcode()
	 * @return void
	 */
	function hydra_promoted_products( $per_page = '2', $columns = '2', $recent_fallback = true ) {
		if ( hydra_is_woocommerce_activated() ) {

			if ( wc_get_featured_product_ids() ) {

				echo '<h2>' . esc_html__( 'Featured Products', 'hydra' ) . '</h2>';

				echo hydra_do_shortcode( 'featured_products', array(
											'per_page' => $per_page,
											'columns'  => $columns,
				) );
			} elseif ( wc_get_product_ids_on_sale() ) {

				echo '<h2>' . esc_html__( 'On Sale Now', 'hydra' ) . '</h2>';

				echo hydra_do_shortcode( 'sale_products', array(
											'per_page' => $per_page,
											'columns'  => $columns,
				) );
			} elseif ( $recent_fallback ) {

				echo '<h2>' . esc_html__( 'New In Store', 'hydra' ) . '</h2>';

				echo hydra_do_shortcode( 'recent_products', array(
											'per_page' => $per_page,
											'columns'  => $columns,
				) );
			}
		}
	}
}

if ( ! function_exists( 'hydra_handheld_footer_bar' ) ) {
	/**
	 * Display a menu intended for use on handheld devices
	 *
	 * @since 2.0.0
	 */
	function hydra_handheld_footer_bar() {
		$links = array(
			'my-account' => array(
				'priority' => 10,
				'callback' => 'hydra_handheld_footer_bar_account_link',
			),
			'search'     => array(
				'priority' => 20,
				'callback' => 'hydra_handheld_footer_bar_search',
			),
			'cart'       => array(
				'priority' => 30,
				'callback' => 'hydra_handheld_footer_bar_cart_link',
			),
		);

		if ( wc_get_page_id( 'myaccount' ) === -1 ) {
			unset( $links['my-account'] );
		}

		if ( wc_get_page_id( 'cart' ) === -1 ) {
			unset( $links['cart'] );
		}

		$links = apply_filters( 'hydra_handheld_footer_bar_links', $links );
		?>
		<div class="hydra-handheld-footer-bar">
			<ul class="columns-<?php echo count( $links ); ?>">
				<?php foreach ( $links as $key => $link ) : ?>
					<li class="<?php echo esc_attr( $key ); ?>">
						<?php
						if ( $link['callback'] ) {
							call_user_func( $link['callback'], $key, $link );
						}
						?>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
		<?php
	}
}

if ( ! function_exists( 'hydra_handheld_footer_bar_search' ) ) {
	/**
	 * The search callback function for the handheld footer bar
	 *
	 * @since 2.0.0
	 */
	function hydra_handheld_footer_bar_search() {
		echo '<a class="iconsearch" href="">' . esc_attr__( 'Search', 'hydra' ) . '</a>';
		//hydra_product_search();
	}
}

if ( ! function_exists( 'hydra_handheld_footer_bar_cart_link' ) ) {
	/**
	 * The cart callback function for the handheld footer bar
	 *
	 * @since 2.0.0
	 */
	function hydra_handheld_footer_bar_cart_link() {
		?>
			<a class="footer-cart-contents" href="<?php echo esc_url( WC()->cart->get_cart_url() ); ?>" title="<?php esc_attr_e( 'View your shopping cart', 'hydra' ); ?>">
				<span class="count"><?php echo wp_kses_data( WC()->cart->get_cart_contents_count() );?></span>
			</a>
		<?php
	}
}

if ( ! function_exists( 'hydra_handheld_footer_bar_account_link' ) ) {
	/**
	 * The account callback function for the handheld footer bar
	 *
	 * @since 2.0.0
	 */
	function hydra_handheld_footer_bar_account_link() {
		echo '<a href="' . esc_url( get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) ) . '">' . esc_attr__( 'My Account', 'hydra' ) . '</a>';
	}
}

if ( ! function_exists( 'hydra_woocommerce_init_structured_data' ) ) {
	/**
	 * WARNING: This function will be deprecated in hydra v2.2.
	 *
	 * Generates product category structured data.
	 *
	 * Hooked into `woocommerce_before_shop_loop_item` action hook.
	 */
	function hydra_woocommerce_init_structured_data() {
		if ( ! is_product_category() ) {
			return;
		}

		global $product;

		$json['@type']             = 'Product';
		$json['@id']               = 'product-' . get_the_ID();
		$json['name']              = get_the_title();
		$json['image']             = wp_get_attachment_url( $product->get_image_id() );
		$json['description']       = get_the_excerpt();
		$json['url']               = get_the_permalink();
		$json['sku']               = $product->get_sku();

		if ( $product->get_rating_count() ) {
			$json['aggregateRating'] = array(
				'@type'                => 'AggregateRating',
				'ratingValue'          => $product->get_average_rating(),
				'ratingCount'          => $product->get_rating_count(),
				'reviewCount'          => $product->get_review_count(),
			);
		}

		$json['offers'] = array(
			'@type'                  => 'Offer',
			'priceCurrency'          => get_woocommerce_currency(),
			'price'                  => $product->get_price(),
			'itemCondition'          => 'http://schema.org/NewCondition',
			'availability'           => 'http://schema.org/' . $stock = ( $product->is_in_stock() ? 'InStock' : 'OutOfStock' ),
			'seller'                 => array(
				'@type'                => 'Organization',
				'name'                 => get_bloginfo( 'name' ),
			),
		);

		if ( ! isset( $json ) ) {
			return;
		}

		hydra::set_structured_data( apply_filters( 'hydra_woocommerce_structured_data', $json ) );
	}
}

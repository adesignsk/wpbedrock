<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package hydra
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<!-- Google Tag Manager -->
<!-- End Google Tag Manager -->
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.5">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="alternate" href="<?php echo get_permalink(); ?>" hreflang="sk-SK">
<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php endif; ?>

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<!-- Google Tag Manager (noscript) -->
<!-- End Google Tag Manager (noscript) -->
<div id="page" class="hfeed site<?php if ( get_field('skryt_titulok_stranky' ) or ( is_woocommerce_activated() and is_shop() ) ) echo ' hide_title'; ?>">
	<?php
	do_action( 'hydra_before_header' ); ?>

	<header id="masthead" class="site-header" role="banner" style="<?php hydra_header_styles(); ?>">
		<div class="col-full">

			<?php
			/**
			 * Functions hooked into hydra_header action
			 *
			 * @hooked hydra_skip_links                       - 0
			 * @hooked hydra_social_icons                     - 10
			 * @hooked hydra_site_branding                    - 20
			 * @hooked hydra_secondary_navigation             - 30
			 * @hooked hydra_product_search                   - 40
			 * @hooked hydra_primary_navigation_wrapper       - 42
			 * @hooked hydra_primary_navigation               - 50
			 * @hooked hydra_header_cart                      - 60
			 * @hooked hydra_primary_navigation_wrapper_close - 68
			 */
			do_action( 'hydra_header' ); ?>

		</div>
	</header><!-- #masthead -->

	<?php
	/**
	 * Functions hooked in to hydra_before_content
	 *
	 * @hooked hydra_header_widget_region - 10
	 */
	do_action( 'hydra_before_content' ); ?>

	<div id="content" class="site-content" tabindex="-1">

		<?php
		/* Sliders in Header */
		$queried_object = get_queried_object();
		$ssliderid = get_field('slajder_v_hlavicke', $queried_object);
		if ( shortcode_exists('smartslider3') ) { echo do_shortcode('[smartslider3 slider='.$ssliderid.']'); }
		$sasliders = get_field('carousel_v_hlavicke', $queried_object);
		if ( $sasliders ) foreach ($sasliders as $saslider) echo do_shortcode( '[slide-anything id="'.$saslider.'"]' );
		?>

		<?php
		$woofshortcode = do_shortcode( '[woof sid="produkty"]' );
		if ( ( $woofshortcode != '[woof sid="produkty"]' ) ) { echo $woofshortcode; }
		?>

		<div class="col-full">



		<?php
		/**
		 * Functions hooked in to hydra_content_top
		 *
		 * @hooked woocommerce_breadcrumb - 10
		 */
		do_action( 'hydra_content_top' );

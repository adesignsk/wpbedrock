<?php
/**
 * hydra hooks
 *
 * @package hydra
 */

/**
 * General
 *
 * @see  hydra_header_widget_region()
 * @see  hydra_get_sidebar()
 */
add_action( 'hydra_before_content', 'hydra_header_widget_region', 10 );
add_action( 'hydra_sidebar',        'hydra_get_sidebar',          10 );

/**
 * Header
 *
 * @see  hydra_skip_links()
 * @see  hydra_secondary_navigation()
 * @see  hydra_site_branding()
 * @see  hydra_primary_navigation()
 */
add_action( 'hydra_header', 'hydra_skip_links',                       0 );
add_action( 'hydra_header', 'hydra_site_branding',                    20 );
add_action( 'hydra_header', 'hydra_secondary_navigation',             30 );
add_action( 'hydra_header', 'hydra_primary_navigation_wrapper',       42 );
add_action( 'hydra_header', 'hydra_primary_navigation',               50 );
add_action( 'hydra_header', 'hydra_primary_navigation_wrapper_close', 68 );

/**
 * Footer
 *
 * @see  hydra_footer_widgets()
 * @see  hydra_credit()
 */
add_action( 'hydra_footer', 'hydra_footer_widgets', 10 );
add_action( 'hydra_footer', 'hydra_credit',         20 );

/**
 * Homepage Fullwidth Content
 *
 * @see hydra_homepage_content()  - 5
 * @see hydra_content_block_homepage()  - 10
 * @see hydra_recent_post_homepage()    - 20
 * @see hydra_wc_featured_homepage()    - 30
 * @see hydra_text_block_homepage()     - 40
 */
add_action( 'fullwidth-homepage-before', 'hydra_homepage_content',      5 );
add_action( 'fullwidth-homepage-before', 'hydra_content_block_homepage', 10 );
add_action( 'fullwidth-homepage-before', 'hydra_recent_post_homepage',   20 );
add_action( 'fullwidth-homepage-before', 'hydra_wc_featured_homepage',   30 );
add_action( 'fullwidth-homepage-before', 'hydra_text_block_homepage',    40 );

/**
 * Homepage
 *
 * @see  hydra_product_categories()
 * @see  hydra_recent_products()
 * @see  hydra_featured_products()
 * @see  hydra_popular_products()
 * @see  hydra_on_sale_products()
 * @see  hydra_best_selling_products()
 */
add_action( 'homepage', 'hydra_product_categories',    20 );
add_action( 'homepage', 'hydra_recent_products',       30 );
add_action( 'homepage', 'hydra_featured_products',     40 );
add_action( 'homepage', 'hydra_popular_products',      50 );
add_action( 'homepage', 'hydra_on_sale_products',      60 );
add_action( 'homepage', 'hydra_best_selling_products', 70 );

/**
 * Posts
 *
 * @see  hydra_post_header()
 * @see  hydra_post_meta()
 * @see  hydra_post_content()
 * @see  hydra_init_structured_data()
 * @see  hydra_paging_nav()
 * @see  hydra_single_post_header()
 * @see  hydra_post_nav()
 * @see  hydra_related_posts()
 * @see  hydra_display_comments()
 */
add_action( 'hydra_loop_post',           'hydra_post_header',          10 );
add_action( 'hydra_loop_post',           'hydra_post_meta',            20 );
add_action( 'hydra_loop_post',           'hydra_loop_content',         30 );
add_action( 'hydra_loop_post',           'hydra_init_structured_data', 40 );
add_action( 'hydra_loop_after',          'hydra_paging_nav',           10 );
add_action( 'hydra_single_post',         'hydra_post_header',          10 );
add_action( 'hydra_single_post',         'hydra_post_meta',            20 );
add_action( 'hydra_single_post',         'hydra_post_content',         30 );
add_action( 'hydra_single_post',         'hydra_init_structured_data', 40 );
add_action( 'hydra_single_post_bottom',  'hydra_related_posts',        10 );
add_action( 'hydra_single_post_bottom',  'hydra_post_nav',             20 );
add_action( 'hydra_single_post_bottom',  'hydra_display_comments',     30 );
add_action( 'hydra_post_content_before', 'hydra_post_thumbnail',       10 );
add_action( 'hydra_loop_content_before', 'hydra_loop_thumbnail',       10 );

/**
 * Pages
 *
 * @see  hydra_page_header()
 * @see  hydra_page_content()
 * @see  hydra_init_structured_data()
 * @see  hydra_display_comments()
 */
add_action( 'hydra_page',       'hydra_page_header',          10 );
add_action( 'hydra_page',       'hydra_page_content',         20 );
add_action( 'hydra_page',       'hydra_init_structured_data', 30 );
add_action( 'hydra_page_after', 'hydra_display_comments',     10 );

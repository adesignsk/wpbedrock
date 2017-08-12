<?php

// add custom admin scripts
add_action('admin_enqueue_scripts','mywp_admin_script');
function mywp_admin_script( $hook ){
    wp_enqueue_script( 'mywp_script', get_template_directory_uri().'/assets/js/admin/admin-scripts.js', array('jquery'),false,true );
}
//**************************



// some css to administration area
function admin_style() {
    wp_enqueue_style('admin-styles', get_template_directory_uri().'/css/admin.css');
}
add_action('admin_enqueue_scripts', 'admin_style');
//**************************



// Related posts persistent cache layer
add_filter( 'related_posts_by_taxonomy_cache', '__return_true' );
// test if cache works
//add_filter( 'related_posts_by_taxonomy_display_cache_log', '__return_true' );
//**************************



// disable url field in comments
function disable_comment_url($fields) {
    unset($fields['url']);
    return $fields;
}
add_filter('comment_form_default_fields','disable_comment_url');
//**************************



// excerpt
function my_excerpt($limit=10) {
    $excerpt = explode(' ', get_the_excerpt(), $limit);
    if (count($excerpt)>=$limit) {
        array_pop($excerpt);
        $excerpt = implode(" ",$excerpt).'...';
    }
    else {
        $excerpt = implode(" ",$excerpt);
    }
    $excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
    return $excerpt;
}
//**************************



// content
function my_content($limit=20) {
    $content = explode(' ', get_the_content(), $limit);
    if (count($content)>=$limit) {
        array_pop($content);
        $content = implode(" ",$content).'...';
    }
    else {
        $content = implode(" ",$content);
    }

    $content = preg_replace('/\[.+\]/','', $content);
    $content = apply_filters('the_content', $content);
    $content = str_replace(']]>', ']]&gt;', $content);
    return strip_tags($content);
}
//***************************




// my excerpt more
if ( ! function_exists( 'my_excerpt_more' ) && ! is_admin() ) :
    /**
     * Replaces "[...]" (appended to automatically generated excerpts) with ... and
     * a 'Continue reading' link.
     * @return string 'Continue reading' link prepended with an ellipsis.
     */
    function my_excerpt_more() {
        $link = sprintf( '<a href="%1$s" class="more-link">%2$s</a>',
            esc_url( get_permalink( get_the_ID() ) ),
            /* translators: %s: Name of current post */
            sprintf( __( '<span class="screen-reader-text"> "%s"</span>', 'hydra' ), get_the_title( get_the_ID() ) )
        );
        return ' &hellip; ' . $link;
    }
    add_filter( 'excerpt_more', 'my_excerpt_more' );
endif;
//***************************




// Enable the use of shortcodes in text widgets.
add_filter( 'widget_text', 'do_shortcode' );
//***************************




// Remove tax term from title
add_filter( 'get_the_archive_title', function ($title) {
    if ( is_category() or is_tax() or is_archive() ) { $title = single_cat_title( '', false ); }
    elseif ( is_tag() ) { $title = single_tag_title( '', false ); }
    elseif ( is_author() ) { $title = '<span class="vcard">' . get_the_author() . '</span>'; }
    return $title;
});
//***************************




// Custom login form style
function my_login_logo_url() { return home_url(); }
add_filter( 'login_headerurl', 'my_login_logo_url' );

function my_login_logo_url_title() { return 'Admin login'; }
add_filter( 'login_headertitle', 'my_login_logo_url_title' );
//***************************




// Custom logo in login form
function my_login_logo() { ?>
    <style type="text/css">
        body.login div#login h1 a {
            background-image: url(<?php echo get_template_directory_uri() ?>/img/logo.png);
            padding-bottom: 5px; width:150px; height:150px; background-size: 100%;
        }
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'my_login_logo' );
//**************************




// change administration panel footer
function change_footer_admin() {
    echo __('Technická podpora: 0905 693 833 alebo email <a href="mailto:info@adesign.sk">mailto:info@adesign.sk</a>','rookie');
}
add_filter('admin_footer_text', 'change_footer_admin');
//**************************




// remove administration page header logo
function remove_admin_logo() {
    echo '<style>#wp-admin-bar-wp-logo { display: none; }</style>';
}
add_action('admin_head', 'remove_admin_logo');
//**************************




// Override theme default specification for product # per row
function loop_columns() {
    return 4; // num of products per row
}
add_filter('loop_shop_columns', 'loop_columns', 999);
//***************************



// Theme customizer homepage
add_action( 'customize_register', 'my_customize_register' );

function my_customize_register($wp_customize) {

    /**
     * Multiple checkbox customize control class.
     * URL: http://wpsites.org/multiple-checkbox-customizer-control-10868/
     *
     */
    class Customize_Control_Checkbox_Multiple extends WP_Customize_Control {

        /**
         * The type of customize control being rendered.
         *
         * @since  1.0.0
         * @access public
         * @var    string
         */
        public $type = 'checkbox-multiple';

        /**
         * Enqueue scripts/styles.
         *
         * @since  1.0.0
         * @access public
         * @return void
         */
        public function enqueue() {
            //wp_enqueue_script( 'pfun-customize-controls', trailingslashit( get_template_directory_uri() ) . 'assets/js/custom-control.js', array( 'jquery' ), null, true );
        }

        /**
         * Displays the control content.
         *
         * @since  1.0.0
         * @access public
         * @return void
         */
        public function render_content() {

            if ( empty( $this->choices ) )
                return; ?>

            <?php if ( !empty( $this->label ) ) : ?>
                <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
            <?php endif; ?>

            <?php if ( !empty( $this->description ) ) : ?>
                <span class="description customize-control-description"><?php echo $this->description; ?></span>
            <?php endif; ?>

            <?php $multi_values = !is_array( $this->value() ) ? explode( ',', $this->value() ) : $this->value(); ?>

            <ul>
                <?php foreach ( $this->choices as $value => $label ) : ?>

                    <li>
                        <label>
                            <input type="checkbox" value="<?php echo esc_attr( $value ); ?>" <?php checked( in_array( $value, $multi_values ) ); ?> />
                            <?php echo esc_html( $label ); ?>
                        </label>
                    </li>

                <?php endforeach; ?>
            </ul>

            <input type="hidden" <?php $this->link(); ?> value="<?php echo esc_attr( implode( ',', $multi_values ) ); ?>" />
        <?php }

    }

    /**
     * Sanitize the Multiple checkbox values.
     *
     * @param string $values Values.
     * @return array Checked values.
     */
    function sanitize_multiple_checkbox( $values ) {
        $multi_values = ! is_array( $values ) ? explode( ',', $values ) : $values;
        return !empty( $multi_values ) ? array_map( 'sanitize_text_field', $multi_values ) : array();
    }

}
//***************************




// Get the content of homepage
function hydra_get_homepage_items() {

    $homepage_items = get_theme_mod( 'hydra_moje' );
    return $homepage_items;

}
//***************************




// add items to TinyMCE
if ( ! function_exists( 'wpex_style_select' ) ) {
    function wpex_style_select( $buttons ) {
        array_push( $buttons, 'styleselect' );
        array_unshift( $buttons, 'cut,copy,paste' );
        return $buttons;
    }
}
add_filter( 'mce_buttons', 'wpex_style_select' );
//**************************



// add GM API key
function my_acf_google_map_api( $api ){
    $api['key'] = 'AIzaSyB8koBfUtGYoHVfxExmXhOolSmX0UYlreU';
    return $api;
}
add_filter('acf/fields/google_map/api', 'my_acf_google_map_api');
//***************************



// enqueue GM scripts
function gmaps_load_scripts() {
    wp_register_script('googlemaps', 'https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyB8koBfUtGYoHVfxExmXhOolSmX0UYlreU',null,null,true);
    wp_enqueue_script('googlemaps');
}
add_action( 'wp_enqueue_scripts', 'gmaps_load_scripts' );
//***************************



/**
 * Custom post type for this theme.
 */
//require get_template_directory() . '/inc/search-acf.php';
//***************************



/* SubCategories of current Category in sidebar */
function sub_category_list() {
    if ( ( is_category() or is_single() ) and !is_product()  ) {

        $current_cat_id = '';
        if ( is_category() ) {
            $current_cat = get_queried_object();
            $current_cat_id = $current_cat->term_id;
        }
        else {
            $post_categories = get_the_category();
            if ( !empty( $post_categories ) ) {
                $current_cat_id = $post_categories[0]->term_id;
            }
        }

        $args = array(
            'child_of'     => $current_cat_id,
            'orderby'      => 'name',
            'order'        => 'ASC',
            'hide_empty'   => 0,
            'hierarchical' => true
        );
        $categories = get_categories( $args );

        if ( !empty($categories) and $current_cat_id ) {
            echo '<div id="posts_categories" class="widget widget_posts_categories">';
            echo '<span class="gamma widget-title">' . __( 'KATEGÓRIE', 'hydra' ) . '</span>';
            echo '<ul class="list-posts-categories">';

            foreach($categories as $category) {

                //var_dump($category);
                echo '<li class="cat-item cat-item-'.$category->term_id.'">';
                echo '<a href="' . get_category_link( $category->term_id ) . '" title="' . sprintf( __( 'Zobraziť všetky články v %s', 'hydra' ), $category->name ) . '" ' . '>' . $category->name.'</a>';
                //echo ' ('. $category->count .')<br>';
                if ( $category->description ) echo '<p>'. $category->description . '</p>';
                echo '</li>';


            }
            echo '</ul></div>';
        }

    }
}
//***************************



/*******************************************/
/* WooCommerce - check if is WC activated
/*******************************************/

if ( ! function_exists( 'is_woocommerce_activated' ) ) {

    function is_woocommerce_activated() {
        if ( class_exists( 'woocommerce' ) ) {
            return true;
        }
        else {
            return false;
        }
    }

}

/* Woocommerce - customizing */

if ( is_woocommerce_activated() ) {


    // Change columns number
    add_filter( 'loop_shop_columns', 'tm_product_columns', 5);
    function tm_product_columns($columns) {
        if ( is_shop() || is_product_category() || is_product_tag() ) {
            $columns = 5;
            return $columns;
        }
    }
    //***************************



    // Modify body css class
    add_filter('body_class', function ($classes) {
        if ( is_product_category() or is_shop() or is_product() or is_product_taxonomy() ) {
            return array_merge($classes, array('columns-' . loop_columns()));
        }
        else return $classes;
    });
    //**************************



    // remove default sorting dropdown
    add_action('init', 'remove_catalog_ordering');
    function remove_catalog_ordering() {
        remove_action('woocommerce_after_shop_loop', 'woocommerce_catalog_ordering', 10);
        remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 10);
    }



    // disable woocommerce purchase functionality
        add_filter('woocommerce_is_purchasable', '__return_false', 10, 2);


    // Woocommerce - sort item price
        function remove_loop_button()
        {
            remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
        }

        add_action('init', 'remove_loop_button');
    //***************************


    // Woocommerce - hide the 'Free!' price notice
        add_filter('woocommerce_variable_free_price_html', 'hide_free_price_notice');
        add_filter('woocommerce_free_price_html', 'hide_free_price_notice');
        add_filter('woocommerce_variation_free_price_html', 'hide_free_price_notice');
        function hide_free_price_notice($price) {
            return '';
        }
    //***************************


    // Woocommerce - Remove add to cart button from the product loop
        remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10, 2); // remove if using my custom checkout form
    //***************************


    // Woocommerce - Remove add to cart button from the simple product page
        remove_action('woocommerce_before_add_to_cart_form', 'woocommerce_template_single_product_add_to_cart', 10, 2); // remove if using my custom checkout form
    //***************************


    // Woocommerce - Disabled actions (add to cart, checkout and pay)
        remove_action('init', 'woocommerce_add_to_cart_action', 10); // remove if using my custom checkout form
        remove_action('init', 'woocommerce_checkout_action', 10);
        remove_action('init', 'woocommerce_pay_action', 10);
    //***************************


    // deregister grid/list css
    add_action( 'wp_print_styles', 'pac_pdc_deregister_styles', 100 );
    function pac_pdc_deregister_styles() {
        wp_deregister_style( 'berocket_lgv_style' );
    }
    //***************************


}


// REMOVE EMOJI SCRIPT FROM HEAD TAG IN WORDPRESS
function disable_wp_emojicons() {
    // all actions related to emojis
    remove_action( 'admin_print_styles', 'print_emoji_styles' );
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
    remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
    remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
}
add_action( 'init', 'disable_wp_emojicons' );
add_filter( 'emoji_svg_url', '__return_false' );








/* Doplnkove linky pre produkty v kategorii */
add_filter( 'woocommerce_shop_loop_item_title', 'link_button_in_loop' );
function link_button_in_loop() {

    global $product;

    $eshop_prod_link = get_field('eshop_product_link', get_the_ID());
    $otazka_na_produkt = get_field('otazka_na_produkt', get_the_ID());

    if ( $eshop_prod_link ) {
        if ( !$otazka_na_produkt ) { $eshop_prod_link_fullwidth = ' prod_link_fullwidth'; }
        echo '<a target="_blank" class="eshop_product_link' . $eshop_prod_link_fullwidth . ' btn button" href="' . $eshop_prod_link . '">';
        echo 'ESHOP';
        echo '</a>';
    }

    if ( $otazka_na_produkt ) {
        echo ' <a class="otazka_na_produkt btn button" href="' . get_permalink( get_the_ID() ) . '#otazka_na_produkt">OTÁZKA</a>';
    }

}


/* Formular "Otazka" pre single produkt */
add_filter( 'woocommerce_share', 'link_button_in_product' );
function link_button_in_product() {

    global $product;
    $otazka_na_produkt = get_field('otazka_na_produkt', get_the_ID());

    if ( $otazka_na_produkt ) {
        echo '<div class="otazka_produkt">';
        echo '<span id="otazka_na_produkt"></span>';
        echo '<h4>' . __( 'OTÁZKA K TOMUTO PRODUKTU', 'hydra' ) . '</h4>';
        echo do_shortcode( '[caldera_form id="CF5884f7b3e04dc"]' );
        echo '</div>';
    }

}

/* Button "Otazka" pre produktovu kategoriu */
add_filter( 'woocommerce_product_meta_start', 'ask_button_in_product_loop' );
function ask_button_in_product_loop() {

    $otazka_na_produkt = get_field('otazka_na_produkt', get_the_ID());

    if ( $otazka_na_produkt and !is_product() ) {
        global $product;
        echo '<span id="otazka_na_produkt"></span>';
        echo ' <a class="otazka_na_produkt btn button" href="' . get_permalink( get_the_ID() ) . '#otazka_na_produkt">MÁM OTÁZKU</a>';
    }

}

/* Linka na eshop pre single produkt */
add_filter( 'woocommerce_product_meta_start', 'ask_button_in_product', 50 );

function ask_button_in_product() {

    global $product;
    $eshop_prod_link = get_field( 'eshop_product_link', get_the_ID() );

    if ( $eshop_prod_link ) {
        if ( !$otazka_na_produkt ) { $eshop_prod_link_fullwidth = ' prod_link_fullwidth'; }
        echo '<a target="_blank" class="eshop_product_link' . $eshop_prod_link_fullwidth . ' btn button" href="' . $eshop_prod_link . '">';
        echo __( 'CHCEM KÚPIŤ', 'hydra' );
        echo '</a>';
    }

}



/* Move product meta under main image */
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
add_action( 'woocommerce_product_thumbnails', 'woocommerce_template_single_meta', 40 );



/* Remove related products - clear the query arguments for related products so none show. */
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

<?php
/**
 * hydra template functions.
 *
 * @package hydra
 */

if ( ! function_exists( 'hydra_display_comments' ) ) {
	/**
	 * hydra display comments
	 *
	 * @since  1.0.0
	 */
	function hydra_display_comments() {
		// If comments are open or we have at least one comment, load up the comment template.
		if ( comments_open() || '0' != get_comments_number() ) :
			comments_template();
		endif;
	}
}

if ( ! function_exists( 'hydra_comment' ) ) {
	/**
	 * hydra comment template
	 *
	 * @param array $comment the comment array.
	 * @param array $args the comment args.
	 * @param int   $depth the comment depth.
	 * @since 1.0.0
	 */
	function hydra_comment( $comment, $args, $depth ) {
		if ( 'div' == $args['style'] ) {
			$tag = 'div';
			$add_below = 'comment';
		} else {
			$tag = 'li';
			$add_below = 'div-comment';
		}
		?>
		<<?php echo esc_attr( $tag ); ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ) ?> id="comment-<?php comment_ID() ?>">
		<div class="comment-body">
		<div class="comment-meta commentmetadata">
			<div class="comment-author vcard">
			<?php echo get_avatar( $comment, 128 ); ?>
			<?php printf( wp_kses_post( '<cite class="fn">%s</cite>', 'hydra' ), get_comment_author_link() ); ?>
			</div>
			<?php if ( '0' == $comment->comment_approved ) : ?>
				<em class="comment-awaiting-moderation"><?php esc_attr_e( 'Your comment is awaiting moderation.', 'hydra' ); ?></em>
				<br />
			<?php endif; ?>

			<a href="<?php echo esc_url( htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ); ?>" class="comment-date">
				<?php echo '<time datetime="' . get_comment_date( 'c' ) . '">' . get_comment_date() . '</time>'; ?>
			</a>
		</div>
		<?php if ( 'div' != $args['style'] ) : ?>
		<div id="div-comment-<?php comment_ID() ?>" class="comment-content">
		<?php endif; ?>
		<div class="comment-text">
		<?php comment_text(); ?>
		</div>
		<div class="reply">
		<?php comment_reply_link( array_merge( $args, array( 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
		<?php edit_comment_link( __( 'Edit', 'hydra' ), '  ', '' ); ?>
		</div>
		</div>
		<?php if ( 'div' != $args['style'] ) : ?>
		</div>
		<?php endif; ?>
	<?php
	}
}

if ( ! function_exists( 'hydra_footer_widgets' ) ) {
	/**
	 * Display the footer widget regions
	 *
	 * @since  1.0.0
	 * @return  void
	 */
	function hydra_footer_widgets() {
		if ( is_active_sidebar( 'footer-4' ) ) {
			$widget_columns = apply_filters( 'hydra_footer_widget_regions', 4 );
		} elseif ( is_active_sidebar( 'footer-3' ) ) {
			$widget_columns = apply_filters( 'hydra_footer_widget_regions', 3 );
		} elseif ( is_active_sidebar( 'footer-2' ) ) {
			$widget_columns = apply_filters( 'hydra_footer_widget_regions', 2 );
		} elseif ( is_active_sidebar( 'footer-1' ) ) {
			$widget_columns = apply_filters( 'hydra_footer_widget_regions', 1 );
		} else {
			$widget_columns = apply_filters( 'hydra_footer_widget_regions', 0 );
		}

		if ( $widget_columns > 0 ) : ?>

			<div class="footer-widgets col-<?php echo intval( $widget_columns ); ?> fix">

				<?php
				$i = 0;
				while ( $i < $widget_columns ) : $i++;
					if ( is_active_sidebar( 'footer-' . $i ) ) : ?>

						<div class="block footer-widget-<?php echo intval( $i ); ?>">
							<?php dynamic_sidebar( 'footer-' . intval( $i ) ); ?>
						</div>

					<?php endif;
				endwhile; ?>

			</div><!-- /.footer-widgets  -->

		<?php endif;
	}
}

if ( ! function_exists( 'hydra_credit' ) ) {
	/**
	 * Display the theme credit
	 *
	 * @since  1.0.0
	 * @return void
	 */
	function hydra_credit() {
		?>
		<div class="site-info">
			<?php echo esc_html( apply_filters( 'hydra_copyright_text', $content = '&copy; ' . get_bloginfo( 'name' ) . ' ' . date( 'Y' ) ) ); ?>
			<?php if ( apply_filters( 'hydra_credit_link', true ) ) { ?>
			<br /> <?php printf( esc_attr__( 'Pripravil %2$s', 'hydra' ), '', '<a href="http://www.adesign.sk" title="ADESIGN" rel="author">ADESIGN</a>' ); ?>
			<?php } ?>
		</div><!-- .site-info -->
		<?php
	}
}

if ( ! function_exists( 'hydra_header_widget_region' ) ) {
	/**
	 * Display header widget region
	 *
	 * @since  1.0.0
	 */
	function hydra_header_widget_region() {
		if ( is_active_sidebar( 'header-1' ) ) {
		?>
		<div class="header-widget-region" role="complementary">
			<div class="col-full">
				<?php dynamic_sidebar( 'header-1' ); ?>
			</div>
		</div>
		<?php
		}
	}
}

if ( ! function_exists( 'hydra_site_branding' ) ) {
	/**
	 * Site branding wrapper and display
	 *
	 * @since  1.0.0
	 * @return void
	 */
	function hydra_site_branding() {
		?>
		<div class="site-branding row middle-xs">
			<?php hydra_site_title_or_logo(); ?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'hydra_site_title_or_logo' ) ) {
	/**
	 * Display the site title or logo
	 *
	 * @since 2.1.0
	 * @param bool $echo Echo the string or return it.
	 * @return string
	 */
	function hydra_site_title_or_logo( $echo = true ) {
		if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) {
			$logo = get_custom_logo();
			//$html = is_home() ? '<h1 class="logo">' . $logo . '</h1>' : $logo;


			$tag = is_home() ? 'h1' : 'div';
			$html = '<div class="logo">' . $logo . '</div>';
			$html .= '<' . esc_attr( $tag ) . ' class="beta site-title"><a href="' . esc_url( home_url( '/' ) ) . '" rel="home">' . esc_html( get_bloginfo( 'name' ) ) . '</a></' . esc_attr( $tag ) .'>';

			if ( '' !== get_bloginfo( 'description' ) ) {
				$html .= '<p class="site-description">' . esc_html( get_bloginfo( 'description', 'display' ) ) . '</p>';
			}


		} elseif ( function_exists( 'jetpack_has_site_logo' ) && jetpack_has_site_logo() ) {
			// Copied from jetpack_the_site_logo() function.
			$logo    = site_logo()->logo;
			$logo_id = get_theme_mod( 'custom_logo' ); // Check for WP 4.5 Site Logo
			$logo_id = $logo_id ? $logo_id : $logo['id']; // Use WP Core logo if present, otherwise use Jetpack's.
			$size    = site_logo()->theme_size();
			$html    = sprintf( '<a href="%1$s" class="site-logo-link" rel="home" itemprop="url">%2$s</a>',
				esc_url( home_url( '/' ) ),
				wp_get_attachment_image(
					$logo_id,
					$size,
					false,
					array(
						'class'     => 'site-logo attachment-' . $size,
						'data-size' => $size,
						'itemprop'  => 'logo'
					)
				)
			);

			$html = apply_filters( 'jetpack_the_site_logo', $html, $logo, $size );
		} else {
			$tag = is_home() ? 'h1' : 'div';

			$html = '<' . esc_attr( $tag ) . ' class="beta site-title"><a href="' . esc_url( home_url( '/' ) ) . '" rel="home">' . esc_html( get_bloginfo( 'name' ) ) . '</a></' . esc_attr( $tag ) .'>';

			if ( '' !== get_bloginfo( 'description' ) ) {
				$html .= '<p class="site-description">' . esc_html( get_bloginfo( 'description', 'display' ) ) . '</p>';
			}
		}

		if ( ! $echo ) {
			return $html;
		}

		echo $html;
	}
}

if ( ! function_exists( 'hydra_primary_navigation' ) ) {
	/**
	 * Display Primary Navigation
	 *
	 * @since  1.0.0
	 * @return void
	 */
	function hydra_primary_navigation() {
		?>
		<nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_html_e( 'Primary Navigation', 'hydra' ); ?>">
		<button class="menu-toggle" aria-controls="site-navigation" aria-expanded="false"><span><?php echo esc_attr( apply_filters( 'hydra_menu_toggle_text', __( 'Menu', 'hydra' ) ) ); ?></span></button>
			<?php
			wp_nav_menu(
				array(
					'theme_location'	=> 'primary',
					'container_class'	=> 'primary-navigation',
					)
			);

			wp_nav_menu(
				array(
					'theme_location'	=> 'handheld',
					'container_class'	=> 'handheld-navigation',
					)
			);
			?>
		</nav><!-- #site-navigation -->
		<?php
	}
}

if ( ! function_exists( 'hydra_secondary_navigation' ) ) {
	/**
	 * Display Secondary Navigation
	 *
	 * @since  1.0.0
	 * @return void
	 */
	function hydra_secondary_navigation() {
	    if ( has_nav_menu( 'secondary' ) ) {
		    ?>
		    <nav class="secondary-navigation" role="navigation" aria-label="<?php esc_html_e( 'Secondary Navigation', 'hydra' ); ?>">
			    <?php
				    wp_nav_menu(
					    array(
						    'theme_location'	=> 'secondary',
						    'fallback_cb'		=> '',
					    )
				    );
			    ?>
		    </nav><!-- #site-navigation -->
		    <?php
		}
	}
}

if ( ! function_exists( 'hydra_skip_links' ) ) {
	/**
	 * Skip links
	 *
	 * @since  1.4.1
	 * @return void
	 */
	function hydra_skip_links() {
		?>
		<a class="skip-link screen-reader-text" href="#site-navigation"><?php esc_attr_e( 'Skip to navigation', 'hydra' ); ?></a>
		<a class="skip-link screen-reader-text" href="#content"><?php esc_attr_e( 'Skip to content', 'hydra' ); ?></a>
		<?php
	}
}

if ( ! function_exists( 'hydra_page_header' ) ) {
	/**
	 * Display the post header with a link to the single post
	 *
	 * @since 1.0.0
	 */
	function hydra_page_header() {
		?>
		<header class="entry-header">
			<?php
			hydra_post_thumbnail( 'full' );
			the_title( '<h1 class="entry-title">', '</h1>' );
			?>
		</header><!-- .entry-header -->
		<?php
	}
}

if ( ! function_exists( 'hydra_page_content' ) ) {
	/**
	 * Display the post content with a link to the single post
	 *
	 * @since 1.0.0
	 */
	function hydra_page_content() {
		?>
		<div class="entry-content">
			<?php the_content(); ?>

			<?php
			// google maps
			$location = get_field('google_mapa', get_the_ID());
			if( !empty($location) ) {
				echo '<div class="post-google-map">';
				echo '<h5 style="text-align:center">'. $location['address'] .'</h5>';
				?>
				<div id="map" style="width:100%;height:350px;margin-bottom:4em;">
					<div class="marker" data-lat="<?php echo $location['lat']; ?>" data-lng="<?php echo $location['lng']; ?>">
						<div style="text-align:center">
							<b><?php echo $location['address']; ?></b><br>
							<a target="new" class="directions" href="https://www.google.sk/maps?saddr=&daddr=<?php echo $location['lat'] . ',' . $location['lng']; ?>"><?php _e('ZÍSKAŤ TRASU','hydra'); ?></a>
						</div>
					</div>
				</div>
				<?php
				echo '</div>';
			}
			// end google maps
			?>

			<?php
				wp_link_pages( array(
					'before' => '<div class="page-links">' . __( 'Pages:', 'hydra' ),
					'after'  => '</div>',
				) );
			?>
		</div><!-- .entry-content -->
		<?php
	}
}

if ( ! function_exists( 'hydra_post_header' ) ) {
	/**
	 * Display the post header with a link to the single post
	 *
	 * @since 1.0.0
	 */
	function hydra_post_header() {
		?>
		<header class="entry-header">
		<?php
		if ( is_single() ) {
			//hydra_posted_on();
			the_title( '<h1 class="entry-title">', '</h1>' );
		} else {
			if ( 'post' == get_post_type() ) {
				//hydra_posted_on();
			}

			the_title( sprintf( '<h2 class="alpha entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
		}
		?>
		</header><!-- .entry-header -->
		<?php
	}
}

if ( ! function_exists( 'hydra_post_content' ) ) {
	/**
	 * Display the post content with a link to the single post
	 *
	 * @since 1.0.0
	 */
	function hydra_post_content() {
		?>
		<div class="entry-content">
		<?php

		/**
		 * Functions hooked in to hydra_post_content_before action.
		 *
		 * @hooked hydra_post_thumbnail - 10
		 */
		do_action( 'hydra_post_content_before' );

		the_content(
			sprintf(
				__( 'Continue reading %s', 'hydra' ),
				'<span class="screen-reader-text">' . get_the_title() . '</span>'
			)
		);


		// google maps
		$location = get_field('google_mapa', get_the_ID());
		if( !empty($location) ) {
			echo '<div class="post-google-map">';
			echo '<h5 style="text-align:center">'. $location['address'] .'</h5>';
			?>
			<div id="map" style="width:100%;height:350px;margin-bottom:4em;">
				<div class="marker" data-lat="<?php echo $location['lat']; ?>" data-lng="<?php echo $location['lng']; ?>">
					<div style="text-align:center">
						<b><?php echo $location['address']; ?></b><br>
						<a target="new" class="directions" href="https://www.google.sk/maps?saddr=&daddr=<?php echo $location['lat'] . ',' . $location['lng']; ?>"><?php _e('ZÍSKAŤ TRASU','hydra'); ?></a>
					</div>
				</div>
			</div>
			<?php
			echo '</div>';
		}
		// end google maps


		do_action( 'hydra_post_content_after' );

		wp_link_pages( array(
			'before' => '<div class="page-links">' . __( 'Pages:', 'hydra' ),
			'after'  => '</div>',
		) );
		?>
		</div><!-- .entry-content -->
		<?php
	}
}

if ( ! function_exists( 'hydra_loop_content' ) ) {
	/**
	 * Display the post content with a link to the post archive loop
	 *
	 * @since 1.0.0
	 */
	function hydra_loop_content() {
		?>
		<div class="entry-content">
			<?php

			/**
			 * Functions hooked in to hydra_loop_content_before action.
			 *
			 * @hooked hydra_post_thumbnail - 10
			 */

			echo '<a href="'.esc_url( get_permalink() ).'">';

			do_action( 'hydra_loop_content_before' );
			echo my_excerpt(35);
			do_action( 'hydra_post_content_after' );

			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'hydra' ),
				'after'  => '</div>',
			) );

			echo '</a>';
			?>
		</div><!-- .entry-content -->
		<?php
	}
}

if ( ! function_exists( 'hydra_post_meta' ) ) {
	/**
	 * Display the post meta
	 *
	 * @since 1.0.0
	 */
	function hydra_post_meta() {
		?>
		<aside class="entry-meta">
			<?php if ( 'post' == get_post_type() ) : // Hide category and tag text for pages on Search.

			?>

			<div class="posted-on">
				<?php hydra_posted_on(); ?>
			</div>


			<div class="hide author">
				<?php
					echo get_avatar( get_the_author_meta( 'ID' ), 128 );
					echo '<div class="label">' . esc_attr( __( 'Written by', 'hydra' ) ) . '</div>';
					the_author_posts_link();
				?>
			</div>
			<?php
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( __( ', ', 'hydra' ) );

			if ( $categories_list ) : ?>
				<div class="cat-links">
					<?php
					echo '<div class="label">' . esc_attr( __( 'Posted in', 'hydra' ) ) . '</div>';
					echo wp_kses_post( $categories_list );
					?>
				</div>
			<?php endif; // End if categories. ?>

			<?php
			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', __( ', ', 'hydra' ) );

			if ( $tags_list ) : ?>
				<div class="tags-links">
					<?php
					echo '<div class="label">' . esc_attr( __( 'Tagged', 'hydra' ) ) . '</div>';
					echo wp_kses_post( $tags_list );
					?>
				</div>
			<?php endif; // End if $tags_list. ?>

		<?php endif; // End if 'post' == get_post_type(). ?>

			<?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
				<div class="comments-link">
					<?php echo '<div class="label">' . esc_attr( __( 'Comments', 'hydra' ) ) . '</div>'; ?>
					<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'hydra' ), __( '1 Comment', 'hydra' ), __( '% Comments', 'hydra' ) ); ?></span>
				</div>
			<?php endif; ?>
		</aside>
		<?php
	}
}

if ( ! function_exists( 'hydra_paging_nav' ) ) {
	/**
	 * Display navigation to next/previous set of posts when applicable.
	 */
	function hydra_paging_nav() {
		global $wp_query;

		$args = array(
			'type' 	    => 'list',
			'next_text' => _x( 'Next', 'Next post', 'hydra' ),
			'prev_text' => _x( 'Previous', 'Previous post', 'hydra' ),
			);

		the_posts_pagination( $args );
	}
}

if ( ! function_exists( 'hydra_post_nav' ) ) {
	/**
	 * Display navigation to next/previous post when applicable.
	 */
	function hydra_post_nav() {
		$args = array(
			'next_text' => '%title',
			'prev_text' => '%title',
			);
		the_post_navigation( $args );
	}
}

if ( ! function_exists( 'hydra_related_posts' ) ) {
	/**
	 * Display related posts at bottom of post.
	 */
	function hydra_related_posts() {
		echo do_shortcode( '[related_posts_by_tax posts_per_page="6" columns="3" post_types="post" before_shortcode="<div class=\'related-posts\'><hr>" after_shortcode="<hr></div>" title="" format="thumbnails" image_size="loopthumbnail" limit_posts="100"]' );
	}
}

if ( ! function_exists( 'hydra_posted_on' ) ) {
	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 */
	function hydra_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time> <time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
			_x( 'Posted on %s', 'post date', 'hydra' ),
			': <a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		echo wp_kses( apply_filters( 'hydra_single_post_posted_on_html', '<span class="posted-on">' . $posted_on . '</span>', $posted_on ), array(
			'span' => array(
				'class'  => array(),
			),
			'a'    => array(
				'href'  => array(),
				'title' => array(),
				'rel'   => array(),
			),
			'time' => array(
				'datetime' => array(),
				'class'    => array(),
			),
		) );
	}
}

if ( ! function_exists( 'hydra_product_categories' ) ) {
	/**
	 * Display Product Categories
	 * Hooked into the `homepage` action in the homepage template
	 *
	 * @since  1.0.0
	 * @param array $args the product section args.
	 * @return void
	 */
	function hydra_product_categories( $args ) {

		if ( hydra_is_woocommerce_activated() and in_array( 'kategorie' , hydra_get_homepage_items() ) ) {

			$args = apply_filters( 'hydra_product_categories_args', array(
				'limit' 			=> 3,
				'columns' 			=> 3,
				'child_categories' 	=> 0,
				'orderby' 			=> 'name',
				'title'				=> __( 'Shop by Category', 'hydra' ),
			) );

			echo '<section class="hydra-product-section hydra-product-categories" aria-label="Product Categories">';

			do_action( 'hydra_homepage_before_product_categories' );

			echo '<h2 class="section-title">' . wp_kses_post( $args['title'] ) . '</h2>';

			do_action( 'hydra_homepage_after_product_categories_title' );

			echo hydra_do_shortcode( 'product_categories', array(
				'number'  => intval( $args['limit'] ),
				'columns' => intval( $args['columns'] ),
				'orderby' => esc_attr( $args['orderby'] ),
				'parent'  => esc_attr( $args['child_categories'] ),
			) );

			do_action( 'hydra_homepage_after_product_categories' );

			echo '</section>';
		}
	}
}

if ( ! function_exists( 'hydra_recent_products' ) ) {
	/**
	 * Display Recent Products
	 * Hooked into the `homepage` action in the homepage template
	 *
	 * @since  1.0.0
	 * @param array $args the product section args.
	 * @return void
	 */
	function hydra_recent_products( $args ) {

		if ( hydra_is_woocommerce_activated() and in_array( 'novinky' , hydra_get_homepage_items() ) ) {

			$args = apply_filters( 'hydra_recent_products_args', array(
				'limit' 			=> 4,
				'columns' 			=> 4,
				'title'				=> __( 'New In', 'hydra' ),
			) );

			echo '<section class="hydra-product-section hydra-recent-products" aria-label="Recent Products">';

			do_action( 'hydra_homepage_before_recent_products' );

			echo '<h2 class="section-title">' . wp_kses_post( $args['title'] ) . '</h2>';

			do_action( 'hydra_homepage_after_recent_products_title' );

			echo hydra_do_shortcode( 'recent_products', array(
				'per_page' => intval( $args['limit'] ),
				'columns'  => intval( $args['columns'] ),
			) );

			do_action( 'hydra_homepage_after_recent_products' );

			echo '</section>';
		}
	}
}

if ( ! function_exists( 'hydra_featured_products' ) ) {
	/**
	 * Display Featured Products
	 * Hooked into the `homepage` action in the homepage template
	 *
	 * @since  1.0.0
	 * @param array $args the product section args.
	 * @return void
	 */
	function hydra_featured_products( $args ) {

		if ( hydra_is_woocommerce_activated() and in_array( 'doporucujeme' , hydra_get_homepage_items() ) ) {

			$args = apply_filters( 'hydra_featured_products_args', array(
				'limit'   => 4,
				'columns' => 4,
				'orderby' => 'date',
				'order'   => 'desc',
				'title'   => __( 'We Recommend', 'hydra' ),
			) );

			echo '<section class="hydra-product-section hydra-featured-products" aria-label="Featured Products">';

			do_action( 'hydra_homepage_before_featured_products' );

			echo '<h2 class="section-title">' . wp_kses_post( $args['title'] ) . '</h2>';

			do_action( 'hydra_homepage_after_featured_products_title' );

			echo hydra_do_shortcode( 'featured_products', array(
				'per_page' => intval( $args['limit'] ),
				'columns'  => intval( $args['columns'] ),
				'orderby'  => esc_attr( $args['orderby'] ),
				'order'    => esc_attr( $args['order'] ),
			) );

			do_action( 'hydra_homepage_after_featured_products' );

			echo '</section>';
		}
	}
}

if ( ! function_exists( 'hydra_popular_products' ) ) {
	/**
	 * Display Popular Products
	 * Hooked into the `homepage` action in the homepage template
	 *
	 * @since  1.0.0
	 * @param array $args the product section args.
	 * @return void
	 */
	function hydra_popular_products( $args ) {

		if ( hydra_is_woocommerce_activated() and in_array( 'oblubene' , hydra_get_homepage_items() ) ) {

			$args = apply_filters( 'hydra_popular_products_args', array(
				'limit'   => 4,
				'columns' => 4,
				'title'   => __( 'Fan Favorites', 'hydra' ),
			) );

			echo '<section class="hydra-product-section hydra-popular-products" aria-label="Popular Products">';

			do_action( 'hydra_homepage_before_popular_products' );

			echo '<h2 class="section-title">' . wp_kses_post( $args['title'] ) . '</h2>';

			do_action( 'hydra_homepage_after_popular_products_title' );

			echo hydra_do_shortcode( 'top_rated_products', array(
				'per_page' => intval( $args['limit'] ),
				'columns'  => intval( $args['columns'] ),
			) );

			do_action( 'hydra_homepage_after_popular_products' );

			echo '</section>';
		}
	}
}

if ( ! function_exists( 'hydra_on_sale_products' ) ) {
	/**
	 * Display On Sale Products
	 * Hooked into the `homepage` action in the homepage template
	 *
	 * @param array $args the product section args.
	 * @since  1.0.0
	 * @return void
	 */
	function hydra_on_sale_products( $args ) {

		if ( hydra_is_woocommerce_activated() and in_array( 'zlava' , hydra_get_homepage_items() ) ) {

			$args = apply_filters( 'hydra_on_sale_products_args', array(
				'limit'   => 4,
				'columns' => 4,
				'title'   => __( 'On Sale', 'hydra' ),
			) );

			echo '<section class="hydra-product-section hydra-on-sale-products" aria-label="On Sale Products">';

			do_action( 'hydra_homepage_before_on_sale_products' );

			echo '<h2 class="section-title">' . wp_kses_post( $args['title'] ) . '</h2>';

			do_action( 'hydra_homepage_after_on_sale_products_title' );

			echo hydra_do_shortcode( 'sale_products', array(
				'per_page' => intval( $args['limit'] ),
				'columns'  => intval( $args['columns'] ),
			) );

			do_action( 'hydra_homepage_after_on_sale_products' );

			echo '</section>';
		}
	}
}

if ( ! function_exists( 'hydra_best_selling_products' ) ) {
	/**
	 * Display Best Selling Products
	 * Hooked into the `homepage` action in the homepage template
	 *
	 * @since 2.0.0
	 * @param array $args the product section args.
	 * @return void
	 */
	function hydra_best_selling_products( $args ) {
		if ( hydra_is_woocommerce_activated() and in_array( 'najpredavanejsie' , hydra_get_homepage_items() ) ) {
			$args = apply_filters( 'hydra_best_selling_products_args', array(
				'limit'   => 4,
				'columns' => 4,
				'title'	  => esc_attr__( 'Best Sellers', 'hydra' ),
			) );
			echo '<section class="hydra-product-section hydra-best-selling-products" aria-label="Best Selling Products">';
			do_action( 'hydra_homepage_before_best_selling_products' );
			echo '<h2 class="section-title">' . wp_kses_post( $args['title'] ) . '</h2>';
			do_action( 'hydra_homepage_after_best_selling_products_title' );
			echo hydra_do_shortcode( 'best_selling_products', array(
				'per_page' => intval( $args['limit'] ),
				'columns'  => intval( $args['columns'] ),
			) );
			do_action( 'hydra_homepage_after_best_selling_products' );
			echo '</section>';
		}
	}
}

if ( ! function_exists( 'hydra_homepage_content' ) ) {
	/**
	 * Display homepage content
	 * Hooked into the `homepage` action in the homepage template
	 *
	 * @since  1.0.0
	 * @return  void
	 */
	function hydra_homepage_content() {
		while ( have_posts() ) {
			echo '<div class="fullwidth-homepage-area no-bottom-padding">';
			echo '<div class="col-full center-xs">';
			the_post();

			get_template_part( 'content', 'page' );
			echo '</div>';
			echo '</div>';

		} // end of the loop.
	}
}

if ( ! function_exists( 'hydra_social_icons' ) ) {
	/**
	 * Display social icons
	 * If the subscribe and connect plugin is active, display the icons.
	 *
	 * @link http://wordpress.org/plugins/subscribe-and-connect/
	 * @since 1.0.0
	 */
	function hydra_social_icons() {
		if ( class_exists( 'Subscribe_And_Connect' ) ) {
			echo '<div class="subscribe-and-connect-connect">';
			subscribe_and_connect_connect();
			echo '</div>';
		}
	}
}

if ( ! function_exists( 'hydra_get_sidebar' ) ) {
	/**
	 * Display hydra sidebar
	 *
	 * @uses get_sidebar()
	 * @since 1.0.0
	 */
	function hydra_get_sidebar() {
		get_sidebar();
	}
}

if ( ! function_exists( 'hydra_post_thumbnail' ) ) {
	/**
	 * Display post thumbnail
	 *
	 * @var $size thumbnail size. thumbnail|medium|large|full|$custom
	 * @uses has_post_thumbnail()
	 * @uses the_post_thumbnail
	 * @param string $size the post thumbnail size.
	 * @since 1.5.0
	 */
	function hydra_post_thumbnail( $size = 'large' ) {
		if ( has_post_thumbnail() ) {
			the_post_thumbnail( 'large' );
		}
	}
}

if ( ! function_exists( 'hydra_loop_thumbnail' ) ) {
	/**
	 * Display loop thumbnail
	 *
	 * @var $size loop thumbnail size. thumbnail|medium|large|full|$custom
	 * @uses has_post_thumbnail()
	 * @uses the_post_thumbnail
	 * @param string $size the post thumbnail size.
	 * @since 1.5.0
	 */
	function hydra_loop_thumbnail( $size = 'loopthumbnail' ) {
		if ( has_post_thumbnail() ) {
			the_post_thumbnail( 'loopthumbnail' );
		}
	}
}

if ( ! function_exists( 'hydra_primary_navigation_wrapper' ) ) {
	/**
	 * The primary navigation wrapper
	 */
	function hydra_primary_navigation_wrapper() {
		echo '<div class="hydra-primary-navigation">';
	}
}

if ( ! function_exists( 'hydra_primary_navigation_wrapper_close' ) ) {
	/**
	 * The primary navigation wrapper close
	 */
	function hydra_primary_navigation_wrapper_close() {
		echo '</div>';
	}
}

if ( ! function_exists( 'hydra_init_structured_data' ) ) {
	/**
	 * Generates structured data.
	 *
	 * Hooked into the following action hooks:
	 *
	 * - `hydra_loop_post`
	 * - `hydra_single_post`
	 * - `hydra_page`
	 *
	 * Applies `hydra_structured_data` filter hook for structured data customization :)
	 */
	function hydra_init_structured_data() {

		// Post's structured data.
		if ( is_home() || is_category() || is_date() || is_search() || is_single() && ( hydra_is_woocommerce_activated() && ! is_woocommerce() ) ) {
			$image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'normal' );
			$logo  = wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ), 'full' );

			$json['@type']            = 'BlogPosting';

			$json['mainEntityOfPage'] = array(
				'@type'                 => 'webpage',
				'@id'                   => get_the_permalink(),
			);

			$json['publisher']        = array(
				'@type'                 => 'organization',
				'name'                  => get_bloginfo( 'name' ),
				'logo'                  => array(
					'@type'               => 'ImageObject',
					'url'                 => $logo[0],
					'width'               => $logo[1],
					'height'              => $logo[2],
				),
			);

			$json['author']           = array(
				'@type'                 => 'person',
				'name'                  => get_the_author(),
			);

			if ( $image ) {
				$json['image']            = array(
					'@type'                 => 'ImageObject',
					'url'                   => $image[0],
					'width'                 => $image[1],
					'height'                => $image[2],
				);
			}

			$json['datePublished']    = get_post_time( 'c' );
			$json['dateModified']     = get_the_modified_date( 'c' );
			$json['name']             = get_the_title();
			$json['headline']         = $json['name'];
			$json['description']      = get_the_excerpt();

		// Page's structured data.
		} elseif ( is_page() ) {
			$json['@type']            = 'WebPage';
			$json['url']              = get_the_permalink();
			$json['name']             = get_the_title();
			$json['description']      = get_the_excerpt();
		}

		if ( isset( $json ) ) {
			hydra::set_structured_data( apply_filters( 'hydra_structured_data', $json ) );
		}
	}
}



if ( ! function_exists( 'hydra_recent_post_homepage' ) ) {
	/**
	 * The 3 recent posts on homepage
	 */
	function hydra_recent_post_homepage() {

		$home_recent_posts = get_field('najnovsie_prispevky_home');
		if ( !$home_recent_posts ) $home_recent_posts = -2;

		$args = array(
			'showposts' => 3,
			'category__in' => $home_recent_posts,
			'orderby' => 'post_date',
			'order' => 'DESC',
			'post_type' => 'post',
			'post_status' => 'publish'
		);

		$the_query = new WP_Query( $args );

		if( $the_query->have_posts() ):

			echo '<div class="fullwidth-homepage-area fullwidth-homepage-area--green">';
			echo '<div class="col-full">';
			echo '<div class="recent_post_home recent_post_home--centered">';
			echo '<h2 class="recent_post_home__main-title clearfix">'. esc_attr( __("ČO SA PRÁVE UDIALO", "hydra") ) .'</h2>';
			echo '<div class="recent_post_home__wrapper row">';

			while ( $the_query->have_posts()) : $the_query->the_post();
				echo '<a class="recent_post_home__item col-xs-12 col-sm-6 col-md-4 col-lg-4" href="'.get_the_permalink().'">';
				echo '<div class="recent_post_home__thumbnail">'.get_the_post_thumbnail( $post = null, $size = 'loopthumbnail' ).'</div>';
				echo '<h3 class="recent_post_home__title">'.get_the_title().'</h3>';
				echo '<p class="recent_post_home__content">'.my_excerpt(20).'</p>';
				echo '</a>';
			endwhile;

			echo '</div>';
			echo '</div>';
			echo '</div>';
			echo '</div>';

		endif;

		wp_reset_query();


	}
}




if ( ! function_exists( 'hydra_content_block_homepage' ) ) {
	/**
	 * The bonuses content block on homepage
	 */
	function hydra_content_block_homepage()	{

		if (is_front_page()) {

			// fullwidth block of homepage content
			if ((!@get_field('block_content_home'))) {
				echo '<div class="fullwidth-homepage-area fullwidth-homepage-area--white no-top-padding">';
				echo '<div class="col-full">';
				echo '<div class="home-content-block">';
				echo '<div class="row">';

				$max_num_items = 3;
				$numofitems = array();

				for ($x = 1; $x <= $max_num_items; $x++) {
					if ($hmpg_midtxt1 = @get_field($x . '_homepage_mid_text1')) $numofitems[] = $x;
				}
				$columnum = 12 / count($numofitems);
				$columnummed = 6;

				for ($x = 0; $x < count($numofitems); $x++) {

					if (count($numofitems) == 3 and $x == 2) {
						$columnummed = 12;
					}

					$hmpg_midimg = @get_field($numofitems[$x] . '_homepage_mid_img');
					$hmpg_midtxt1 = @get_field($numofitems[$x] . '_homepage_mid_text1');
					$hmpg_midtxt2 = @get_field($numofitems[$x] . '_homepage_mid_text2');
					$hmpg_midlink = @get_field($numofitems[$x] . '_homepage_mid_link');

					echo '<div class="home-content-block__item column col-xs-12 col-sm-' . $columnummed . ' col-md-' . $columnum . ' col-lg-' . $columnum . '">';
					if ($hmpg_midimg['url']) echo '<img alt="' . $hmpg_midimg['alt'] . '" src="' . $hmpg_midimg['url'] . '" width="' . $hmpg_midimg['width'] . '" height="' . $hmpg_midimg['height'] . '">';
					if ($hmpg_midtxt1) echo '<div class="home-content-block__midtxt1">' . $hmpg_midtxt1 . '</div>';
					if ($hmpg_midtxt2) echo '<div class="home-content-block__midtxt2">' . $hmpg_midtxt2 . '</div>';
					if ($hmpg_midlink) echo '<a href="' . $hmpg_midlink . '" class="button add_to_cart_button home-content-block__midlink">viac</a>';

					echo '</div>';

				}

				echo '</div>';
				echo '</div>';
				echo '</div>';
				echo '</div>';


				unset($numofitems, $columnum, $max_num_items);
			}
		}

	}
}







if ( ! function_exists( 'hydra_text_block_homepage' ) ) {
	/**
	 * The text block on homepage
	 */
	function hydra_text_block_homepage()	{

		if (is_front_page()) {

			// fullwidth block of homepage content
			echo '<div class="fullwidth-homepage-area fullwidth-homepage-area--dark">';
			echo '<div class="col-full">';
			echo '<div class="home-text-block">';
			echo '<div class="row">';


			if (get_field('obrazok_textoveho_bloku')) $obrazok_textoveho_bloku = @get_field( 'obrazok_textoveho_bloku' );
			if (get_field('titulok_textoveho_bloku')) $titulok_textoveho_bloku = @get_field( 'titulok_textoveho_bloku' );
			if (get_field('obsah_textoveho_bloku')) $obsah_textoveho_bloku = @get_field( 'obsah_textoveho_bloku' );
			if (get_field('link_textoveho_bloku')) $link_textoveho_bloku = @get_field( 'link_textoveho_bloku' );

			echo '<div class="home-text-block__item column col-xs-12 col-sm-12 col-md-12 col-lg-12">';
			if ($obrazok_textoveho_bloku['url']) echo '<img alt="' . $obrazok_textoveho_bloku['alt'] . '" src="' . $obrazok_textoveho_bloku['url'] . '" width="' . $obrazok_textoveho_bloku['width'] . '" height="' . $obrazok_textoveho_bloku['height'] . '">';
			if ($titulok_textoveho_bloku) echo '<h2 class="home-text-block__title">' . $titulok_textoveho_bloku . '</h2>';
			if ($obsah_textoveho_bloku) echo '<div class="home-text-block__content">' . $obsah_textoveho_bloku . '</div>';
			if ($link_textoveho_bloku) echo '<a href="' . $link_textoveho_bloku . '" class="button add_to_cart_button home-text-block__link">viac</a>';

			echo '</div>';



			echo '</div>';
			echo '</div>';
			echo '</div>';
			echo '</div>';


			unset($numofitems, $columnum, $max_num_items);

		}

	}
}








if ( ! function_exists( 'hydra_wc_featured_homepage' ) ) {
	/**
	 * The featured products block on homepage
	 */
	function hydra_wc_featured_homepage() {

		if ( hydra_is_woocommerce_activated() and in_array( 'fantastickatrojka' , hydra_get_homepage_items() ) ) {
			if (is_front_page()) {

				echo '<div class="fullwidth-homepage-area fullwidth-homepage-area--white">';
				echo '<div class="col-full">';
				echo '<div class="featured_products_home featured_products_home--centered">';
				echo '<h2 class="featured_products_home__main-title">' . esc_attr(__("TRI FANTASTICKÉ KNIHY NA TENTO MESIAC", "hydra")) . '</h2>';
				echo '<div class="featured_products_home__wrapper row">';

				$args = array(
					'post_type' => array('product', 'product_variation'),
					'meta_key' => '_featured',
					'meta_value' => 'yes',
					'posts_per_page' => 3,
					'orderby'     => 'date',
					'order'       => 'DESC' ,
					'showposts'   => 3
				);

				$featured_query = new WP_Query($args);

				if ($featured_query->have_posts()) :

					while ($featured_query->have_posts()) :

						$featured_query->the_post();
						//$product = wc_get_product( $featured_query->post->ID );

						echo '<div class="featured_products_home__item col-xs-12 col-sm-6 col-md-4 col-lg-4">';

						echo '<a href="' . get_the_permalink() . '">';
						echo '<div class="featured_products_home__thumbnail">' . get_the_post_thumbnail($post = null, $size = 'shop_catalog') . '</div>';
						echo '<h3 class="featured_products_home__title">' . get_the_title() . '</h3>';
						echo '<p class="featured_products_home__content">' . get_the_excerpt(20) . '</p>';
						//echo '<p class="featured_products_home__content">' . $product->get_price_html() . '</p>';
						echo '</a>';
						//woocommerce_template_loop_add_to_cart( $product );

						echo '</div>';

					endwhile;
				endif;

				wp_reset_query();

				echo '</div>';
				echo '</div>';
				echo '</div>';
				echo '</div>';

			}
		}

	}
}
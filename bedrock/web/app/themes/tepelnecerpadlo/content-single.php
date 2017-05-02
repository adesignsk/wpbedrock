<?php
/**
 * Template used to display post content on single pages.
 *
 * @package hydra
 */

?>

<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php
	do_action( 'hydra_single_post_top' );

	/**
	 * Functions hooked into hydra_single_post add_action
	 *
	 * @hooked hydra_post_header          - 10
	 * @hooked hydra_post_meta            - 20
	 * @hooked hydra_post_content         - 30
	 * @hooked hydra_init_structured_data - 40
	 */
	do_action( 'hydra_single_post' );

	/**
	 * Functions hooked in to hydra_single_post_bottom action
	 *
	 * @hooked hydra_post_nav         - 10
	 * @hooked hydra_display_comments - 20
	 */
	do_action( 'hydra_single_post_bottom' );
	?>

</div><!-- #post-## -->

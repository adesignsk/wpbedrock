<?php
/**
 * Template used to display post content.
 *
 * @package hydra
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php
	/**
	 * Functions hooked in to hydra_loop_post action.
	 *
	 * @hooked hydra_post_header          - 10
	 * @hooked hydra_post_meta            - 20
	 * @hooked hydra_post_content         - 30
	 * @hooked hydra_init_structured_data - 40
	 */
	do_action( 'hydra_loop_post' );
	?>

</article><!-- #post-## -->

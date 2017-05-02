<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package hydra
 */

?>

<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php
	/**
	 * Functions hooked in to hydra_page add_action
	 *
	 * @hooked hydra_page_header          - 10
	 * @hooked hydra_page_content         - 20
	 * @hooked hydra_init_structured_data - 30
	 */
	do_action( 'hydra_page' );
	?>
</div><!-- #post-## -->

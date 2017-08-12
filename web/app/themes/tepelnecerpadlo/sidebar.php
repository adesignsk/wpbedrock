<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package hydra
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {	return; }
?>

<div id="secondary" class="widget-area" role="complementary">

	<?php sub_category_list(); ?>

	<?php dynamic_sidebar( 'sidebar-1' ); ?>

</div><!-- #secondary -->

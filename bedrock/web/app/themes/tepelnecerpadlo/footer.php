<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package hydra
 */

?>

		</div><!-- .col-full -->
	</div><!-- #content -->

	<?php do_action( 'hydra_before_footer' ); ?>

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="col-full">

			<?php
			/**
			 * Functions hooked in to hydra_footer action
			 *
			 * @hooked hydra_footer_widgets - 10
			 * @hooked hydra_credit         - 20
			 */
			do_action( 'hydra_footer' ); ?>

		</div><!-- .col-full -->
	</footer><!-- #colophon -->
	<span class="sampleclass"></span>

	<?php do_action( 'hydra_after_footer' ); ?>

</div><!-- #page -->

<?php wp_footer(); ?>

<div id="back-top" style="display: block;"><a href="#top"><span >▲</span></a></div>

<script id="__bs_script__">//<![CDATA[
	document.write("<script async src='http://HOST:3000/browser-sync/browser-sync-client.2.12.10.js'><\/script>".replace("HOST", location.hostname));
	//]]>
</script>


</body>
</html>

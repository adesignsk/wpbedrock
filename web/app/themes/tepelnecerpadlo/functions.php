<?php
/**
 * hydra engine room
 *
 * @package hydra
 */

/**
 * Assign the hydra version to a var
 */
$theme = wp_get_theme( 'hydra' );
$hydra_version = $theme['Version'];

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 980; /* pixels */
}

$hydra = (object) array(
	'version' => $hydra_version,

	/**
	 * Initialize all the things.
	 */
	'main'       => require 'inc/class-hydra.php',
    'custom'     => require 'inc/myfunc.php',
    'customizer' => require 'inc/customizer/class-hydra-customizer.php',

);

require 'inc/hydra-functions.php';
require 'inc/hydra-template-hooks.php';
require 'inc/hydra-template-functions.php';

if ( class_exists( 'Jetpack' ) ) {
	$hydra->jetpack = require 'inc/jetpack/class-hydra-jetpack.php';
}

if ( hydra_is_woocommerce_activated() ) {
	$hydra->woocommerce = require 'inc/woocommerce/class-hydra-woocommerce.php';

	require 'inc/woocommerce/hydra-woocommerce-template-hooks.php';
	require 'inc/woocommerce/hydra-woocommerce-template-functions.php';
}

if ( is_admin() ) {
	$hydra->admin = require 'inc/admin/class-hydra-admin.php';
}

/**
 * Note: Do not add any custom code here. Please use a custom plugin so that your customizations aren't lost during updates.
 * https://github.com/woocommerce/theme-customisations
 */
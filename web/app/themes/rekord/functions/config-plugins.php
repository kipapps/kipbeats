<?php
/**
 * This file represents an example of the code that themes would use to register
 * the required plugins.
 *
 * It is expected that theme authors would copy and paste this code into their
 * functions.php file, and amend to suit.
 *
 * @see http://tgmpluginactivation.com/configuration/ for detailed documentation.
 *
 * @package    TGM-Plugin-Activation
 * @subpackage Example
 * @version    2.6.1 for parent theme Rekord for publication on ThemeForest
 * @author     Thomas Griffin, Gary Jones, Juliette Reinders Folmer
 * @copyright  Copyright (c) 2011, Thomas Griffin
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       https://github.com/TGMPA/TGM-Plugin-Activation
 */

/**
 * Include the TGM_Plugin_Activation class.
 *
 * Depending on your implementation, you may want to change the include call:
 *
 * Parent Theme:
 * require_once get_template_directory() . '/path/to/class-tgm-plugin-activation.php';
 *
 * Child Theme:
 * require_once get_stylesheet_directory() . '/path/to/class-tgm-plugin-activation.php';
 *
 * Plugin:
 * require_once dirname( __FILE__ ) . '/path/to/class-tgm-plugin-activation.php';
 */
require_once get_template_directory() . '/inc/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'rekord_register_required_plugins' );

/**
 * Register the required plugins for this theme.
 *
 * In this example, we register five plugins:
 * - one included with the TGMPA library
 * - two from an external source, one from an arbitrary source, one from a GitHub repository
 * - two from the .org repo, where one demonstrates the use of the `is_callable` argument
 *
 * The variables passed to the `tgmpa()` function should be:
 * - an array of plugin arrays;
 * - optionally a configuration array.
 * If you are not changing anything in the configuration array, you can remove the array and remove the
 * variable from the function call: `tgmpa( $plugins );`.
 * In that case, the TGMPA default settings will be used.
 *
 * This function is hooked into `tgmpa_register`, which is fired on the WP `init` action on priority 10.
 */
function rekord_register_required_plugins() {
	/*
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(
        	array(
			'name' 				=> 'Elementor Page Builder', // The plugin name
			'slug' 				=> 'elementor', // The plugin slug (typically the folder name)
			'required' 			=> true, // If false, the plugin is only 'recommended' instead of required
			'force_activation' 	=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation'=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
		),
		array(
			'name' 				=> 'Kirki', // The plugin name
			'slug' 				=> 'kirki', // The plugin slug (typically the folder name)
			'required' 			=> true, // If false, the plugin is only 'recommended' instead of required
			'force_activation' 	=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation'=> true, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
		),
		array(
			'name' 				=> 'Rekord Theme Essential', // The plugin name
			'slug' 				=> 'rekord-theme-essential', // The plugin slug (typically the folder name)
			'required' 			=> true, // If false, the plugin is only 'recommended' instead of required
			'version'			=> '1.3.8',
			'source'   			=> 'https://github.com/naumanahmed19/rekord-theme-essential/archive/master.zip',
			'force_activation' 	=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation'=> true, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
		),
		array(
			'name' 				=> 'Favorites', // The plugin name
			'slug' 				=> 'favorites', // The plugin slug (typically the folder name)
			'required' 			=> true, // If false, the plugin is only 'recommended' instead of required
			'force_activation' 	=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation'=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
		),

		array(
			'name' 				=> 'WooCommerce', // The plugin name
			'slug' 				=> 'woocommerce', // The plugin slug (typically the folder name)
			'required' 			=> false, // If false, the plugin is only 'recommended' instead of required
			'force_activation' 	=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation'=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
		),
		array(
			'name' 				=> 'One Click Demo Import', // The plugin name
			'slug' 				=> 'one-click-demo-import', // The plugin slug (typically the folder name)
			'required' 			=> true, // If false, the plugin is only 'recommended' instead of required
			'force_activation' 	=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation'=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
		),
		
		array(
			'name' 				=> 'Advance Custom Fields', // The plugin name
			'slug' 				=> 'advanced-custom-fields-pro', // The plugin slug (typically the folder name)
			'required' 			=> true, // If false, the plugin is only 'recommended' instead of required
			'source'   			=> get_stylesheet_directory() . '/inc/plugins/advanced-custom-fields-pro.zip', // The plugin source
			'force_activation' 	=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation'=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
		),

		array(
			'name' 				=> 'Paid Memberships Pro', // The plugin name
			'slug' 				=> 'paid-memberships-pro', // The plugin slug (typically the folder name)
			'required' 			=> false, // If false, the plugin is only 'recommended' instead of required
			'force_activation' 	=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation'=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
		),

		array(
			'name' 				=> 'Paid Memberships Pro – Register Helper Add On', // The plugin name
			'slug' 				=> 'pmpro-register-helper', // The plugin slug (typically the folder name)
			'required' 			=> false, // If false, the plugin is only 'recommended' instead of required
			'force_activation' 	=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation'=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
		),

		array(
			'name' 				=> 'Rekord Paid Memberships Addon', // The plugin name
			'slug' 				=> 'rekord-paid-memberships-pro', // The plugin slug (typically the folder name)
			'required' 			=> true, // If false, the plugin is only 'recommended' instead of required
			'source'   			=> 'https://github.com/naumanahmed19/rekord-paid-memberships-pro/archive/master.zip', // The plugin source
			'force_activation' 	=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation'=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
		),

		array(
			'name' 				=> 'Envato Market', // The plugin name
			'slug' 				=> 'envato-market', // The plugin slug (typically the folder name)
			'required' 			=> true, // If false, the plugin is only 'recommended' instead of required
			'source'   			=> get_stylesheet_directory() . '/inc/plugins/envato-market.zip', // The plugin source
			'force_activation' 	=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation'=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
		),



	);

	/*
	 * Array of configuration settings. Amend each line as needed.
	 *
	 * TGMPA will start providing localized text strings soon. If you already have translations of our standard
	 * strings available, please help us make TGMPA even better by giving us access to these translations or by
	 * sending in a pull-request with .po file(s) with the translations.
	 *
	 * Only uncomment the strings in the config array if you want to customize the strings.
	 */
	$config = array(
		'id'           => 'rekord',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.

	);

	tgmpa( $plugins, $config );
}

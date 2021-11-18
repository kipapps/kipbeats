<?php

/*
Plugin Name: KipBeats Plugin
Plugin URI: http://kipsoft.x10.mx
Description: Allows functions to work for wordpress.
Author: KipSoft
Version: 1.0
Author URI: http://kipsoft.x10.mx
*/
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {exit;}

if ( ! class_exists( 'KipBeats' ) ) :

final class KipBeats {
	private $kipbeats_options;
    private $kipbeats_sf = array(
	'youtube_channel_id' => 'text',
	'youtube_api_key' => 'text'
    );
    //@var string ////////////////////////
	public $version = '1.0.0';
    public $app_nicename = 'kipbeats';
    public $app_name = 'KipBeats';
	protected static $_instance = null;
	public $query = null;
	public $assets = null;
	public $global = null;

	/**
	 * Main EstimateGadget Instance
	 *
	 * Ensures only one instance of EstimateGadget is loaded or can be loaded.
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	
    /// EstimateGadget Constructor.
	public function __construct() {
		$this->define_constants();
		$this->includes();
		$this->init_hooks();
		//$this->tables = self::get_tables();
		//do_action( 'kipbeats_loaded' );
	}

////	 * Define EG Constants
	private function define_constants() {
		$upload_dir = wp_upload_dir();

		$this->define( 'KB_PLUGIN_FILE', '__FILE__'   );
		$this->define( 'KB_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
		$this->define( 'KB_VERSION', $this->version );
		
	}
    // * Include required core files used in admin and on the frontend.
    public function includes() {
		//include_once( 'includes/class-autoloader.php' );
		include_once( 'includes/core-functions.php' );
		//include_once( 'includes/eg-widget-functions.php' );
		//include_once( 'includes/class-install.php' );
        //include_once( 'includes/class-global.php' ); 
		//include_once( 'includes/session.php' );

		if ( $this->is_request( 'admin' ) ) {
			include_once( 'includes/base64.php' );
            //include_once( 'includes/media-hooks.php' );
            include_once( 'includes/paypal-button.php' );
		}

		if ( $this->is_request( 'ajax' ) ) {
			//$this->ajax_includes();
            include_once( 'includes/ajax/main.php' );
		}

		if ( $this->is_request( 'frontend' ) ) {
			//$this->frontend_includes();
            include_once( 'includes/base64-front.php' );
		}

		if ( $this->is_request( 'cron' ) && 'yes' === get_option( 'kipbeats_allow_tracking', 'no' ) ) {
			//include_once( 'includes/class-eg-tracker.php' );
		}

		//$this->query = include( 'includes/class-query.php' );
		//$this->assets = include( 'assets/class-assets.php' );   	// The main query class
		//$this->settings = include( 'includes/class-settings.php' );
        //$this->mail = include( 'includes/class-mail.php' );  
		//$this->api   = include( 'includes/class-eg-api.php' );                // API Class

		//include_once( 'assets/assets.php' );  

	}
    
	// * Hook into actions and filters
    private function init_hooks() {
		//add_action( 'init', array( 'KB_Shortcodes', 'init' ) );
		register_activation_hook( __FILE__, array( 'KB_Install', 'install' ) );
		//add_action( 'after_setup_theme', array( $this, 'setup_environment' ) );
		//add_action( 'after_setup_theme', array( $this, 'include_template_functions' ), 11 );
		add_action( 'init', array( $this, 'init' ), 0 );
		//add_action( 'init', array( 'KB_Shortcodes', 'init' ) );
		//add_action( 'init', array( 'KB_Emails', 'init_transactional_emails' ) );
        add_action( 'admin_menu', array( $this, 'kipbeats_add_plugin_page' ) );
		add_action( 'admin_init', array( $this, 'kipbeats_page_init' ) );
	}
   
	public static function before_init() {
		global $wp;
		//if dependent plugin is not active
		if (!class_exists( 'ManagementGadget' ) ) {
			//$wp->deactivate_plugins(plugin_basename(__FILE__));die('ManagementGadget Must Be Instlled and Activated');
		}
		
	}
    /**
	 * Init EstimateGadget when WordPress Initialises.
	 */
	public function init() {
		add_action( 'before_kipbeats_init', array( __CLASS__, 'before_init' ) );
		// Before init action
		do_action( 'before_kipbeats_init' );

		// Set up localisation
		//$this->load_plugin_textdomain();

		// Classes/actions loaded for the frontend and for ajax requests
		if ( $this->is_request( 'frontend' ) ) {
			// Session class, handles session data for users - can be overwritten if custom handler is needed
			//$session_class = apply_filters( 'estimategadget_session_handler', 'KB_Session_Handler' );
			
		}
		// Class instances
		//$this->global   = new KB_Global();
		//$this->query  = new KB_Query();
        //$this->settings  = new KB_Settings();
		
		// Init action
		do_action( 'kipbeats_init' );
	}
    private function is_request( $type ) {
		switch ( $type ) {
			case 'admin' :
				return is_admin();
			case 'ajax' :
				return defined( 'DOING_AJAX' );
			case 'cron' :
				return defined( 'DOING_CRON' );
			case 'frontend' :
				return ( ! is_admin() || defined( 'DOING_AJAX' ) ) && ! defined( 'DOING_CRON' );
		}
	}
    	/**
	 * Define constant if not already set
	 * @param  string $name
	 * @param  string|bool $value
	 */
	private function define( $name, $value ) {
		if ( ! defined( $name ) ) {
			define( $name, $value );
		}
	}
    
    public function icon_url() {return plugins_url( '/', __FILE__ ).'assets/images/icon.png';}
	public function plugin_url($f='') {return plugins_url( '/', __FILE__ ).$f;}
	public function plugin_path($f='') {return untrailingslashit( plugin_dir_path( __FILE__ ) ).'/';}
    public function plugin_js_path($f='') {return  plugins_url('/', __FILE__ ) .'assets/js/'.$f;}
    public function plugin_ajax_path($f='') {return  plugins_url('/', __FILE__ ) .'includes/ajax/'.$f;}
    public function template_path() {return apply_filters( 'estimategadget_template_path', 'estimategadget/' );}
    
    public function get_paypal_button($id) {return get_paypal_button($id);}
    
    
    //////////////////////////////////////////////
    
	public function kipbeats_add_plugin_page() {
		add_options_page(
			'KipBeats', // page_title
			'KipBeats', // menu_title
			'manage_options', // capability
			'kipbeats', // menu_slug
			function() {
                $this->kipbeats_options = get_option( 'kipbeats_options_' ); ?>

                <div class="wrap">
                    <h2>KipBeats</h2>
                    <p>KipBeats Options</p>
                    <?php settings_errors(); ?>

                    <form method="post" action="options.php">
                        <?php
                            settings_fields( 'kipbeats_option_group' );
                            do_settings_sections( 'kipbeats-admin' );
                            submit_button();
                        ?>
                    </form>
                </div>
            <?php }  // function
		);
	}


	public function kipbeats_page_init() {
		register_setting(
			'kipbeats_option_group', // option_group
			'kipbeats_options_', // option_name
			array( $this, 'kipbeats_sanitize' ) // sanitize_callback
		);

		add_settings_section(
			'kipbeats_setting_section', // id
			'Settings', // title
			function() {
                echo 'section';
            }, // callback
			'kipbeats-admin' // page
		);
        //print_r($kipbeats_sf);exit;
        foreach ( $this->kipbeats_sf as $name => $type ) {
            $title = str_replace("_", " ", $name);
            //$args[] = $name;
            add_settings_field(
                $name, // id
                ucwords($title), // title
                function() use ($name,$type) {
                    switch ( $type ) {
                        case 'text' :
                            printf(
                                '<input class="regular-text" type="text" name="kipbeats_options_['.$name.']" id="'.$name.'" value="%s">',
                                isset( $this->kipbeats_options[$name] ) ? esc_attr( $this->kipbeats_options[$name]) : ''
                            );
                        case 'ajax' :
                            
                        case 'cron' :
                            
                        case 'frontend' :
                            
                    }
                    
                    
                }, // callback
                'kipbeats-admin', // page
                'kipbeats_setting_section' // section
            );
        }

	}

	public function kipbeats_sanitize($input) {
		$sanitary_values = array();
        foreach ( $this->kipbeats_sf as $name => $type ) {
            if ( isset( $input[$name] ) ) {
                $sanitary_values[$name] = sanitize_text_field( $input[$name] );
            }
        }
		return $sanitary_values;
	}
}

endif;

//if ( is_admin() ) $kipbeats = new KipBeats();

function _KB() {
	return KipBeats::instance();
}

// Global for backwards compatibility.
$GLOBALS['kipbeats'] = _KB();

/* 
 * Retrieve this value with:
 * $kipbeats_options = get_option( 'kipbeats_options_' ); // Array of All Options
 * $youtube_channel_id_0 = $kipbeats_options['youtube_channel_id_0']; // Youtube Channel ID
 * $youtube_api_key_1 = $kipbeats_options['youtube_api_key_1']; // Youtube API Key
 */

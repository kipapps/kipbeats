<?php
/**
 * WooCommerce Admin.
 *
 * @class       KB_Admin
 * @author      WooThemes
 * @category    Admin
 * @package     WooCommerce/Admin
 * @version     2.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * KB_Admin class.
 */
class KB_Admin {
	//use Theme;
	/**
	 * @var KB_Query $query
	 */
	
	public function nav_menu_structure() {
		return array(
			'Projects'	=> 'projects',
			'Clients'	=> 'admin clients',
			'Item List'			 => 'settings items',
            'Email Templates'	 => 'settings email templates',
            'Follow Up Campaigns'=> 'settings follow ups',
            'Company Info'		 => 'settings company',
            'Document Templates' => 'settings document templates',
            'Employees'			 => '',
			'Settings'	=> array(
				//'Employees'		 => '',
				'Item List'			 => 'settings items',
				//'Item Templates'	 => '',
				'Email Templates'	 => 'settings email templates',
				'Follow Up Campaigns'=> 'settings follow ups',
				'divider'			 => '',
				'Company Info'		 => 'settings company',
				'Document Templates' => 'settings document templates',
				//'Employees'			 => '',
				'Employees'			 => ''
			)
		);
	}

	/**
	 * @var KB_Product_Factory $product_factory
	 */
	public $_menu_hooks = null;

	public $theme = null;

	/**
	 * Constructor
	 */
	public function __construct() {
		
		add_action( 'init', array( $this, 'includes' ) );
		add_action( 'current_screen', array( $this, 'conditonal_includes' ) );
		//add_action( 'admin_init', array( $this, 'prevent_admin_access' ) );
		//add_filter('set-screen-option', function($status, $option, $value) {
		//		return $value;
		//	}, 10, 3
		//);
		add_filter( 'set-screen-option', array( $this, 'set_screen' ), 10, 3 );
		self::admin_menus();
		
		//add_action( 'admin_footer', 'eg_print_js', 25 );
		add_filter( 'admin_footer_text', array( $this, 'admin_footer_text' ), 1 );
	}
	public static function set_screen( $status, $option, $value ) {
		return $value;
	}
	/**
	 * Include any classes we need within admin.
	 */
	public function includes() {
		// Functions
		include_once( 'admin-functions.php' );
		//include_once( 'admin-theme.php' );
		//include_once( 'class-list-table.php' );
        //include_once( 'class-user-settings.php' );
		// Classes we only need during non-ajax requests
		//if ( ! is_ajax() ) {
			//include_once( 'class-admin-menus.php' );
			//include_once( 'class-admin-welcome.php' );
			
			// Help
			if ( apply_filters( 'kipbeats_enable_admin_help_tab', true ) ) {
				//include_once( 'class-eg-admin-help.php' );
			}
		//}
		
	}

	/**
	 * Include admin files conditionally
	 */
	public function conditonal_includes() {

		$screen = get_current_screen();

		switch ( $screen->id ) {
			case 'dashboard' :
				include( 'class-admin-dashboard.php' );
			break;
			case 'options-permalink' :
				include( 'class-eg-admin-permalink-settings.php' );
			break;
			case 'users' :
			case 'user' :
			case 'profile' :
			case 'user-edit' :
				include( 'class-admin-profile.php' );
			break;
		}
	}

	/**
	 * Prevent any user who cannot 'edit_posts' (subscribers, customers etc) from accessing admin
	 */
	public function prevent_admin_access() {

		$prevent_access = false;

		$prevent_access = apply_filters( 'kipbeats_prevent_admin_access', $prevent_access );

		if ( $prevent_access ) {
			wp_safe_redirect( eg_get_page_permalink( 'myaccount' ) );
			exit;
		}
	}

	/**
	 * Prevent any user who cannot 'edit_posts' (subscribers, customers etc) from accessing admin
	 */
	public function admin_menus() {
		add_action( 'admin_menu', array( $this, 'admin_menu' ), 9 );
        //add_action( 'admin_menu', array( $this, 'projects_menu' ), 20 );
		add_action( 'admin_menu', array( $this, 'process_admin_nav_menu' ) );
		//self::admin_nav_menu();
		
	}

	/**
	 * Add menu items
	 */
	public function admin_menu() {
		global $menu;
		$app_slug=_KB()->app_nicename;
		if ( current_user_can( 'manage_kipbeats' ) ) {
			$menu[] = array( '', 'read', 'separator-kipbeats', '', 'wp-menu-separator kipbeats' );
		}
		
		add_menu_page( 'KipBeats', __( 'KipBeats', 'Projects' ), 'manage_kipbeats', $app_slug , array( $this, 'projects_page' ), _KB()->icon_url(), 4.1);
		//add_submenu_page( null, 'Clients', 'Clients', 'manage_options', 'quick-estimate-clients', array( $this, implode('_',explode(' ','clients')).'_page' ));
		add_submenu_page(null, 'Project', 'Project', 'manage_options', implode('-',explode(' ','project')) , array( $this, implode('_',explode(' ','project')).'_page' ));
		//add_submenu_page( 'edit.php?post_type=product', __( 'Shipping Classes', 'kipbeats' ), __( 'Shipping Classes', 'kipbeats' ), 'manage_product_terms', 'edit-tags.php?taxonomy=product_shipping_class&post_type=product' );
		//add_submenu_page(__( 'KipBeats', 'Projects' ), 'Custom', 'Custom', 'manage_options', 'client-edit', array( $this, 'admin_client_edit_page' ));
		//add_submenu_page(__FILE__, 'Custom', 'Custom', 'manage_options', '/custom', 'admin_clients_page');
		//add_submenu_page( 'edit.php?post_type=product', __( 'Attributes', 'kipbeats' ), __( 'Attributes', 'kipbeats' ), 'manage_product_terms', 'product_attributes', array( $this, 'attributes_page' ) );
	}
	public function admin_menu_hooks($a=null) {
		if(is_null($a)){return $this->_menu_hooks;}
		else{$this->_menu_hooks = $a;return true;}
	}

	public function get_nav_menu_array() {
		global $_nav_menu_structure;
		$_ = array();
		$app_slug=_KB()->app_nicename;
		foreach((array) KB_Admin::nav_menu_structure() as $top => $slug ) {
			if(!empty($slug)){
				if(is_array($slug)){
					foreach((array) $slug as $t => $s ) {
						if(!empty($s)){
							$_[$top][$t]='admin.php?page='.implode('-',explode(' ',$s));
						}else{$_[$top][$t]='';}
					}
				}else{
					$_[$top]='admin.php?page='.implode('-',explode(' ',$slug));
				}
			}
		}
		return $_;
	}
	/**
	 * Add menu items
	 */
	public function process_admin_nav_menu() {
		global $menu;
		$_ = array();
		$app_slug=_KB()->app_nicename;
		$temp;
		foreach((array) KB_Admin::nav_menu_structure() as $top => $slug ) {
			if(!empty($slug)){
				if(is_array($slug)){
					foreach((array) $slug as $t => $s ) {
						if(!empty($s)){
							//add_submenu_page( null, __( $t , $app_slug ), __( $t , $app_slug ), 'manage_options', 'project', array( $this, implode('_',explode(' ','project')).'_page' ));
							$temp = add_submenu_page( null, __( $t , $app_slug ), __( $t , $app_slug ), 'manage_options', implode('-',explode(' ',$s)) , array( $this, implode('_',explode(' ',$s)).'_page' ) );
							$_[$top][$t]=$temp;
						}else{$_[$top][$t]='';}
					}
				}else{
					//print_r($slug);exit;
					$temp = add_submenu_page( $app_slug, __( $top , $app_slug ), __( $top , $app_slug ), 'manage_options', implode('-',explode(' ',$slug)) , array( $this, implode('_',explode(' ',$slug)).'_page' ) );
					add_action( "load-$temp", array( $this, implode('_',explode(' ',$slug)).'_options' ) );
					$_[$top]=$temp;
				}
			}
		}
		return $this->admin_menu_hooks($_);
		//$admin_nav_menu=$_;
		//print_r($admin_nav_menu);
	}
	 /**
	 * Add menu item
	 */
	public function projects_menu() {
		if ( current_user_can( 'manage_kipbeats' ) ) {
			$project_page = add_submenu_page( 'kipbeats', __( 'Projects', 'kipbeats' ),  __( 'Projects', 'kipbeats' ) , 'view_kipbeats_reports', 'eg-projects', array( $this, 'projects_page' ) );
        } else {
			add_menu_page( __( 'Sales Projects', 'kipbeats' ),  __( 'Sales Projects', 'kipbeats' ) , 'view_kipbeats_projects', 'eg-projects', array( $this, 'projects_page' ), null, '55.6' );
		}
	}

	
	public function projects_page() {
		global $current_section, $current_tab,$menu,$submenu;
		
		//_KB()->session->clear_session();
		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
		do_action( 'kipbeats_settings_start' );
		//wp_enqueue_script( 'kipbeats_settings', _KB()->plugin_url() . '/assets/js/admin/settings' . $suffix . '.js', array( 'jquery', 'jquery-ui-datepicker', 'jquery-ui-sortable', 'iris', 'select2' ), _KB()->version, true );
		wp_localize_script( 'kipbeats_settings', 'kipbeats_settings_params', array(
			'i18n_nav_warning' => __( 'The changes you made will be lost if you navigate away from this page.', 'kipbeats' )
		) );
		//_KB()->assets->init();
		echo "<script type='text/javascript'>//<![CDATA[
					var base_url = '".plugin_dir_url( __FILE__ )."';
				//]]></script>";
		//$_estimates=_KB()->query->get_all_estimates();
		$_nicename = _KB()->app_nicename;
		//print_r($_estimates);exit;
		//$_=getprojectvars($qe_id);extract($_);
		//include 'views/html-admin-projects.php';
		//include 'views/html-admin-projects.php';
		//$_theme = new KB_Admin_Theme();
		
		//print_r($this->admin_menu_hooks());exit;
		include_once('page-settings.php' );
		//KB_ASSETS::print_script('assets/js/script/estimates_script.js', $ver = false, $in_footer = false );
	}
	public function projects_options() {
		//add_screen_option('layout_columns', ['default' => 1]);
		add_screen_option( 'per_page', array(
         'label' => 'KipBeats',
         'default' => 6,
         'option' => 'books_per_page'
         ));
		 function pippin_set_screen_option($status, $option, $value) {
			if ( 'pippin_per_page' == $option ) return $value;
		}
		add_filter('set-screen-option', 'pippin_set_screen_option', 10, 3);
		add_filter( 'set-screen-option', array( $this, 'filter_screen_option'), 10, 3 );
	}

	/**
	 * Add menu item
	 */
	public function project_page() {
		global $menu,$submenu;
		_KB()->assets->init();
		echo "<script type='text/javascript'>//<![CDATA[
					var base_url = '".plugin_dir_url( __FILE__ )."';
				//]]></script>";
		//KB_ASSETS::print_script('assets/js/libraries/featherlight.min.js', $ver = false, $in_footer = false );
		
		$e_id=_KB()->session->get_id();
		//$_project=_KB()->query->get_project_vars($e_id);
		extract(_KB()->query->get_project_vars($e_id));
		//print_r($_project);exit;
		include_once('page-project.php' );
		KB_ASSETS::print_script('assets/js/script/project_script.js', $ver = false, $in_footer = false );
	}
	 /**
	 * Add menu item
	 */
	public function admin_clients_page() {
		global $submenu;
        _KB()->assets->init();
        $_clients=_KB()->query->get_all_clients();
		
		$hook = $this->admin_menu_hooks()[Clients];
		//print_r($submenu[_KB()->app_nicename]);exit;
		
		include_once('admin/clients/new-clients.php' );
		//include_once('admin/clients/index.php' );
		
	}
	public function admin_clients_options() {
		//add_screen_option('layout_columns', ['default' => 1]);
		add_screen_option( 'per_page', array(
         'label' => 'Clients',
         'default' => 4,
         'option' => 'clients_per_page'
         ));
		 //function pippin_set_screen_option($status, $option, $value) {
		//	if ( 'pippin_per_page' == $option ) return $value;
		//}
		

		//add_filter( 'set-screen-option', array( $this, 'filter_screen_option'), 10, 3 );
		//add_action('admin-clients', function() {
		//	add_screen_option('layout_columns', ['default' => 2]);
		//});
	}
	public function admin_client_edit_page() {
		_KB()->assets->init();
		$_clients=_KB()->query->get_all_clients();
		echo "<script type='text/javascript'>//<![CDATA[
				var base_url = '".plugin_dir_url( __FILE__ )."';
		//]]></script>";
		include_once('admin/clients/edit.php' );
		
	}

	public function settings_items_page() {
		global $wpdb;
		_KB()->assets->init();
		
		$e_id=_KB()->session->get_id();
		//$_project=_KB()->query->get_project_vars($e_id);
		$my_plugin_url = plugin_dir_url( __FILE__ );
		extract(_KB()->query->get_project_vars($e_id));
		include_once('settings/items/index.php' );
		//KB_ASSETS::print_script('assets/js/script/project_script.js', $ver = false, $in_footer = false );
	}

	public function settings_company_page() {
		_KB()->assets->init();
		
		$e_id=_KB()->session->get_id();
		//$_project=_KB()->query->get_project_vars($e_id);
		$my_plugin_url = plugin_dir_url( __FILE__ );
		extract(_KB()->query->get_project_vars($e_id));
		include_once('settings/company/index.php' );
		//KB_ASSETS::print_script('assets/js/script/project_script.js', $ver = false, $in_footer = false );
	}
    
    public function settings_follow_ups_page() {
		_KB()->assets->init();
		
		$e_id=_KB()->session->get_id();
		//$_project=_KB()->query->get_project_vars($e_id);
		$my_plugin_url = plugin_dir_url( __FILE__ );
		extract(_KB()->query->get_project_vars($e_id));
		include_once('settings/follow_ups/index.php' );
		//KB_ASSETS::print_script('assets/js/script/project_script.js', $ver = false, $in_footer = false );
	}
    
	public function settings_document_templates_page() {
		_KB()->assets->init();
		
		$e_id=_KB()->session->get_id();
		//$_project=_KB()->query->get_project_vars($e_id);
		$my_plugin_url = plugin_dir_url( __FILE__ );
		extract(_KB()->query->get_project_vars($e_id));
		include_once('settings/document_templates/index.php' );
		//KB_ASSETS::print_script('assets/js/script/project_script.js', $ver = false, $in_footer = false );
	}

	public function settings_email_templates_page() {
		_KB()->assets->init();
		
		$e_id=_KB()->session->get_id();
		//$_project=_KB()->query->get_project_vars($e_id);
		$my_plugin_url = plugin_dir_url( __FILE__ );
		extract(_KB()->query->get_project_vars($e_id));
		include_once('settings/email_templates/index.php' );
		//KB_ASSETS::print_script('assets/js/script/project_script.js', $ver = false, $in_footer = false );
	}

	/**
	 * Change the admin footer text on WooCommerce admin pages
	 *
	 * @since  2.3
	 * @param  string $footer_text
	 * @return string
	 */
	public function admin_footer_text( $footer_text ) {
		$current_screen = get_current_screen();
		
		if ( function_exists( 'eg_get_screen_ids' ) ) {
			$eg_pages = eg_get_screen_ids();
		} else {
			$eg_pages = array();
		}

		// Set only wc pages
		$eg_pages = array_flip( $eg_pages );
		if ( isset( $eg_pages['profile'] ) ) {
			unset( $eg_pages['profile'] );
		}
		if ( isset( $eg_pages['user-edit'] ) ) {
			unset( $eg_pages['user-edit'] );
		}
		$eg_pages = array_flip( $eg_pages );

		// Add the dashboard pages
		$eg_pages[] = 'dashboard_page_eg-about';
		$eg_pages[] = 'dashboard_page_eg-credits';
		$eg_pages[] = 'dashboard_page_eg-translators';

		// Check to make sure we're on a WooCommerce admin page
		if ( isset( $current_screen->id ) && current_user_can( 'manage_kipbeats' ) && apply_filters( 'kipbeats_display_admin_footer_text', in_array( $current_screen->id, $eg_pages ) ) ) {
			// Change the footer text
			if ( ! get_option( 'kipbeats_admin_footer_text_rated' ) ) {
				$footer_text = sprintf( __( 'If you like <strong>WooCommerce</strong> please leave us a %s&#9733;&#9733;&#9733;&#9733;&#9733;%s rating. A huge thank you from WooThemes in advance!', 'kipbeats' ), '<a href="https://wordpress.org/support/view/plugin-reviews/kipbeats?filter=5#postform" target="_blank" class="eg-rating-link" data-rated="' . __( 'Thanks :)', 'kipbeats' ) . '">', '</a>' );
				eg_enqueue_js( "
					jQuery( 'a.eg-rating-link' ).click( function() {
						jQuery.post( '" . _KB()->ajax_url() . "', { action: 'kipbeats_rated' } );
						jQuery( this ).parent().text( jQuery( this ).data( 'rated' ) );
					});
				" );
			} else {
				$footer_text = __( 'Thank you for selling with WooCommerce.', 'kipbeats' );
			}
		}

		return $footer_text;
	}

}

return new KB_Admin();

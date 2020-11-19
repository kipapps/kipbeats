<?php
/**
 * EstimateGadget Admin Settings Class.
 *
 * @author      WooThemes
 * @category    Admin
 * @package     EstimateGadget/Admin
 * @version     2.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'KB_Settings' ) ) :

/**
 * KB_Admin_Settings
 */
class KB_Settings {

	private static $settings = array();
	private static $errors   = array();
	private static $messages = array();
    
    public function __construct() {
		
		$this->defaults = self::get_defaults();
		
	}
    
    private function get_defaults() {
		return array(
            '_set_name' => '_kb_settings',
            //'_set_table' => 'qe_work_list'
        );
	}
    
    /** @public array Unfiltered product ids (before layered nav etc) */
	public $default_e 	= array(
		'todo' 				=> 'a:0:{}',
		'line_items' 	    => 'a:0:{}',
		'measurements' 		=> 'a:0:{}',
		'attachments' 		=> 'a:0:{}',
		'email_history'		=> 'a:0:{}',
		'contract_signature'=> 'a:0:{}',
		'status' 			=> 'estimate'
	);
    
    public function default_structure() {
		return array(
			'work_terms'	=> 'projects',
			'work_schedule'	=> 'admin schedule',
			'tax'	        => '10',
			'markup'	    => '25',
            'profit'	         => '10',
            'deposit'	         => '25',
            'co_name'	         => '',
            'co_number'	         => '',
            'co_address'	     => '',
            'co_email'	         => '',
            'co_logo'	         => '',
			'document_templates' => array(
				//'Employees'		 => '',
				'Item List'			 => 'settings items',
				//'Item Templates'	 => '',
				'Employees'			 => ''
			)
		);
	}

	/**
	 * Save admin fields.
	 *
	 * Loops though the kipbeats options array and outputs each field.
	 *
	 * @param array $options Opens array to output
	 * @return bool
	 */
	public static function save_fields( $options ) {
		if ( empty( $_POST ) ) {
			return false;
		}

		// Options to update will be stored here
		$update_options = array();

		// Loop options and get values to save
		foreach ( $options as $value ) {
			if ( ! isset( $value['id'] ) || ! isset( $value['type'] ) ) {
				continue;
			}

			// Get posted value
			if ( strstr( $value['id'], '[' ) ) {
				parse_str( $value['id'], $option_name_array );

				$option_name  = current( array_keys( $option_name_array ) );
				$setting_name = key( $option_name_array[ $option_name ] );

				$option_value = isset( $_POST[ $option_name ][ $setting_name ] ) ? wp_unslash( $_POST[ $option_name ][ $setting_name ] ) : null;
			} else {
				$option_name  = $value['id'];
				$setting_name = '';
				$option_value = isset( $_POST[ $value['id'] ] ) ? wp_unslash( $_POST[ $value['id'] ] ) : null;
			}

			// Format value
			switch ( sanitize_title( $value['type'] ) ) {
				case 'checkbox' :
					$option_value = is_null( $option_value ) ? 'no' : 'yes';
					break;
				case 'textarea' :
					$option_value = wp_kses_post( trim( $option_value ) );
					break;
				case 'text' :
				case 'email':
				case 'number':
				case 'select' :
				case 'color' :
				case 'password' :
				case 'single_select_page' :
				case 'single_select_country' :
				case 'radio' :
					if ( in_array( $value['id'], array( 'kipbeats_price_thousand_sep', 'kipbeats_price_decimal_sep' ) ) ) {
						$option_value = wp_kses_post( $option_value );

					} elseif ( 'kipbeats_price_num_decimals' == $value['id'] ) {
						$option_value = is_null( $option_value ) ? 2 : absint( $option_value );

					} elseif ( 'kipbeats_hold_stock_minutes' == $value['id'] ) {
						$option_value = ! empty( $option_value ) ? absint( $option_value ) : ''; // Allow > 0 or set to ''

						wp_clear_scheduled_hook( 'kipbeats_cancel_unpaid_orders' );

						if ( '' !== $option_value ) {
							wp_schedule_single_event( time() + ( absint( $option_value ) * 60 ), 'kipbeats_cancel_unpaid_orders' );
						}

					} else {
						$option_value = kb_clean( $option_value );
					}
					break;
				case 'multiselect' :
				case 'multi_select_countries' :
					$option_value = array_filter( array_map( 'kb_clean', (array) $option_value ) );
					break;
				case 'image_width' :
					if ( isset( $option_value['width'] ) ) {
						$update_options[ $value['id'] ]['width']  = kb_clean( $option_value['width'] );
						$update_options[ $value['id'] ]['height'] = kb_clean( $option_value['height'] );
						$update_options[ $value['id'] ]['crop']   = isset( $option_value['crop'] ) ? 1 : 0;
					} else {
						$update_options[ $value['id'] ]['width']  = $value['default']['width'];
						$update_options[ $value['id'] ]['height'] = $value['default']['height'];
						$update_options[ $value['id'] ]['crop']   = $value['default']['crop'];
					}
					break;
				default :
					do_action( 'kipbeats_update_option_' . sanitize_title( $value['type'] ), $value );
					break;
			}

			if ( ! is_null( $option_value ) ) {
				// Check if option is an array
				if ( $option_name && $setting_name ) {
					// Get old option value
					if ( ! isset( $update_options[ $option_name ] ) ) {
						$update_options[ $option_name ] = get_option( $option_name, array() );
					}

					if ( ! is_array( $update_options[ $option_name ] ) ) {
						$update_options[ $option_name ] = array();
					}

					$update_options[ $option_name ][ $setting_name ] = $option_value;

				// Single value
				} else {
					$update_options[ $option_name ] = $option_value;
				}
			}

			// Custom handling
			do_action( 'kipbeats_update_option', $value );
		}

		// Now save the options
		foreach ( $update_options as $name => $value ) {
			update_option( $name, $value );
		}

		return true;
	}

	
}

endif;

return new KB_Settings();

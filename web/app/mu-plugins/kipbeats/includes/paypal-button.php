<?php
if ( ! function_exists( 'encode_db_array' ) ) :
	
	function encode_db_array($a) {
		return EG()->query->encode_db_array($a);
	}
endif;




/**
 * Register a meta box using a class.
 */
class PayPal_Meta_Box {
 
    /**
     * Constructor.
     */
    public function __construct() {
        if ( is_admin() ) {
            add_action( 'load-post.php',     array( $this, 'init_metabox' ) );
            add_action( 'load-post-new.php', array( $this, 'init_metabox' ) );
        }
        add_action ( 'the_content', function ( $content ) {
            //$paypalitem = get_post_meta( get_the_ID(), '_paypal_digital_', true );
            //print_r($paypalitem);exit;
            $before = '<p>This content will go before WordPress posts</p>';
            $after = '<p>This content will go after WordPress posts</p>'; 
            //modify the incoming content 
            //$content = $before . $content . $after;

            //return $content; 
        });
        
    }

    /**
     * Meta box initialization.
     */
    public function init_metabox() {
        add_action( 'add_meta_boxes', array( $this, 'add_metabox'  )        );
        add_action( 'save_post',      array( $this, 'save_metabox' ), 10, 2 );
    }
 
    /**
     * Adds the meta box.
     */
    public function add_metabox() {
        add_meta_box(
            'paypal-meta-box',
            __( 'PayPal Digital Meta Box', 'textdomain' ),
            function () {
                $paypalitem = get_post_meta( get_the_ID(), '_paypal_digital_', true );
                @extract($paypalitem);
                // Add nonce for security and authentication.
                print_r($paypalitem);
                wp_nonce_field( 'paypal_nonce_action', 'paypal_nonce' ); ?>
                <div class="form-row">    
                      <div class="form-group">
                        <label for="_paypal_digital_enabled">Enable Button</label>
                        <input class="form-control form-control-lg" type="checkbox" placeholder="" name="_paypal_digital_[enabled]" value="1" <?= ($enabled ? 'checked="checked"' : ''); ?> >
                        
                      </div> 
                </div> 
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="_paypal_digital_name">Item Name</label>
                        <input type="text" class="form-control" id="_paypal_digital_name" aria-describedby="_paypal_digital_name_Help" placeholder="Item Name" name="_paypal_digital_[name]" value="<?= $name ?>">
                        <small id="_paypal_digital_name_Help" class="form-text text-muted">
                            Name of paypal product.
                        </small>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="_paypal_digital_price">Price</label>
                        <input type="text" class="form-control" id="_paypal_digital_price" aria-describedby="_paypal_digital_price_Help" placeholder="9.00" name="_paypal_digital_[price]" value="<?= $price ?>">
                        <small id="_paypal_digital_price_Help" class="form-text text-muted">
                            Price of paypal product.
                        </small>
                    </div>
                    <div class="form-group col-md-7">
                        <label for="_paypal_digital_url">Download URL</label>
                        <input type="text" class="form-control" id="_paypal_digital_url" aria-describedby="_paypal_digital_url_Help" placeholder="" name="_paypal_digital_[url]" value="<?= $url ?>">
                        <small id="_paypal_digital_url_Help" class="form-text text-muted">
                            URL of digital product for download after payment.
                        </small>
                    </div>
                </div>
                
            <?php
                
            },
            array('post','video'),
            'advanced',
            'default'
        );
 
    }
 
    /**
     * Handles saving the meta box.
     *
     * @param int     $post_id Post ID.
     * @param WP_Post $post    Post object.
     * @return null
     */
    public function save_metabox( $post_id, $post ) {
        // Add nonce for security and authentication.
        $nonce_name   = isset( $_POST['paypal_nonce'] ) ? $_POST['paypal_nonce'] : '';
        $nonce_action = 'paypal_nonce_action';
 
        // Check if nonce is valid.
        if ( ! wp_verify_nonce( $nonce_name, $nonce_action ) ) {
            return;
        }
 
        // Check if user has permissions to save data.
        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }
 
        // Check if not an autosave.
        if ( wp_is_post_autosave( $post_id ) ) {
            return;
        }
 
        // Check if not a revision.
        if ( wp_is_post_revision( $post_id ) ) {
            return;
        }
        // Sanitize the user input.
        $mydata = $_POST['_paypal_digital_'] ;
        //$mydata = sanitize_text_field( $mydata );
 
        // Update the meta field.
        update_post_meta( $post_id, '_paypal_digital_', $mydata );
        //print_r($mydata);exit;
        
    }
    
    
}


 
new PayPal_Meta_Box();








?>
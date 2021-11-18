<?php
/**
 * Register a meta box using a class.
 */
class Base64_Meta_Box {
    private $_nicename = 'wp_attachment_image_base64';
    private $_name;
    //private $_nicename;
 
    /**
     * Constructor.
     */
    public function __construct() {
        //$this->_nicename = '';
        $this->_name = '_' . $this->_nicename . '_';
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
        add_action( 'add_meta_boxes_attachment', array( $this, 'add_metabox'  )        );
        add_action( 'edit_attachment',      array( $this, 'save_metabox' ), 10, 2 );
    }
 
    /**
     * Adds the meta box.
     */
    //base64-meta-box
    public function add_metabox() {
        add_meta_box('attachment_meta_box',
            __( 'Base64 Image', 'textdomain' ),
            function ($post) {
                $metaitems = $this->processimg();
                @extract($metaitems);
                // Add nonce for security and authentication.
                wp_nonce_field( $this->_nicename.'_nonce_action', $this->_nicename.'_nonce' ); ?>
                <div class="form-row">
                    <div class="form-group col-md-10">
                        <label for="<?=$this->_name ?>str">String</label>
                        <input type="text" class="form-control disabled" id="<?=$this->_name ?>str" aria-describedby="<?=$this->_name ?>str_Help" placeholder="" name="<?=$this->_name ?>[str]" value="<?= $str ?>">
                        <small id="<?=$this->_name ?>str_Help" class="form-text text-muted">
                            URL of digital product for download after payment.
                        </small>
                    </div>
                   <?php //<button type="submit" class="btn btn-primary mb-2">Restore image</button> ?>
                </div>
                
            <?php
                
            },
            array('attachment'),
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
    public function save_metabox( $post_id ) {
        // Add nonce for security and authentication.
        $nonce_name   = isset( $_POST[ $this->_nicename . '_nonce' ] ) ? $_POST[ $this->_nicename . '_nonce' ] : '';
        $nonce_action = $this->_nicename . '_nonce_action';
        
        // Check if nonce is valid.
        if ( ! wp_verify_nonce( $nonce_name, $nonce_action ) ) {return;}
 
        // Check if user has permissions to save data.
        if ( ! current_user_can( 'edit_post', $post_id ) ) {return;}
 
        // Check if not an autosave.
        if ( wp_is_post_autosave( $post_id ) ) {return;}
 
        // Check if not a revision.
        if ( wp_is_post_revision( $post_id ) ) {return;}
        
        // Sanitize the user input.
        $mydata = $_POST[$this->_name] ;
        //$mydata = sanitize_text_field( $mydata );
 
        // Update the meta field.
        update_post_meta( $post_id, $this->_name , $mydata );
        
        
    }
    
    public function processimg() {
        global $post;
        $items = ( get_post_meta( get_the_ID(), $this->_name, true ) ? get_post_meta( get_the_ID(), $this->_name, true ) : ['str'=>'']);
        $file = WP_CONTENT_DIR . '/uploads/'. get_post_meta( get_the_ID(), '_wp_attached_file' , true );
        $isfile = @file_get_contents($file);
        if ( ! $isfile && ! empty($items['str']) ) {
            print_r('File Did not Exisit. Creating new');
            $base64 = explode(';base64,', $items['str'])[1];
            $upload_file = file_put_contents( $file, base64_decode( $base64 ) );
        }
        
        if ( ! empty($items['str']) ) { return $items;}
        
        $image = file_get_contents($post->guid);
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $type  = $finfo->buffer($image);
        $items['data'] = $type;
        $items['charset'] = 'utf-8';
        //$items['base64'] = ''.base64_encode($image).'';
        $items['str'] = "data:".$type.";charset=utf-8;base64,".base64_encode($image);
        //print_r($items);exit;
        return $items;
    }
    
    
}


 
new Base64_Meta_Box();








?>
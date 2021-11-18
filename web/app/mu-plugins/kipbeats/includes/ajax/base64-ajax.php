<?php

function restore_base64() {
    
    extract($_POST);
    $file = WP_CONTENT_DIR . '/uploads/'. get_post_meta( $post_id, '_wp_attached_file' , true );
    $_meta = get_post_meta($post_id, '_wp_attachment_metadata', true);
    $base64 = get_post_meta($post_id, $_name, true);
    if ( !is_file($file) && $base64 ) {
        
        $base64 = explode(';base64,', $base64)[1];
        $upload_file = file_put_contents( $file, base64_decode( $base64 ) );
        foreach($_meta['sizes'] as $size) {
            $editor = wp_get_image_editor( $file, array() );
            if (is_wp_error($editor)) {// handle the problem however you deem necessary.
            }
            $result = $editor->resize($size['width'], $size['height'], true);
            //wp_insert_attachment(array('ID'=>$post_id),$file);
            if (!is_wp_error($result)) {
              $editor->save($editor->generate_filename());
            }
            print_r($size);
        }
    }
       
}
    
add_action('wp_ajax_restore_base64', 'restore_base64');


   
?>
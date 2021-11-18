<?php
wp_enqueue_script('main', _KB()->plugin_js_path('wp-base64.js'), array('jquery'), '', true);
wp_localize_script('main', 'AjaxVar', array( 'ajaxurl' => admin_url('admin-ajax.php') ));


add_filter( 'add_attachment', function ( $id ) { 
    $post = get_post( $id );
    if ( explode('/', $post->post_mime_type)[0] == 'image' ) {
        $image = file_get_contents($post->guid);
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $type  = $finfo->buffer($image);
        $base64 = "data:".$type.";charset=utf-8;base64,".base64_encode($image);
        update_post_meta( $id, '_wp_attachment_base64' , $base64 );
    }

});

function add_custom_text_field_to_attachment_fields_to_edit( $form_fields, $post ) {
    $_name = '_wp_attachment_base64';
    $base64 = get_post_meta($post->ID, $_name, true);
    $file = WP_CONTENT_DIR . '/uploads/'. get_post_meta( $post->ID, '_wp_attached_file' , true );
    if ( $base64 && !is_file($file) ) {
        
        $form_fields['button_field'] = array(
            'label' => 'Base64 info',
            'input' => 'html',
            'html' => '<input type="button" data-post-id="'.$post->ID.'" name="restore_base64" data-att-name="'.$_name.'" value="Restore Image"/> ',
            'value' => 'Restore Image',
            'helps' => 'File is missing from media library click here to restores it'
        );
        return $form_fields;
    }else {return array();}
    
}
add_filter('attachment_fields_to_edit', 'add_custom_text_field_to_attachment_fields_to_edit', null, 2); 
 


?>
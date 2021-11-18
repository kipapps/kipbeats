<?php

add_filter( 'post_thumbnail_html', function ( $html ) {
    if (!$html) {return $html;}
    $id = get_post_thumbnail_id();
    $dom = new DOMDocument();$dom->loadXML($html);
    $img = $dom->childNodes[0];$src= $img->getAttribute('src');
    $base64 = ( get_post_meta( $id, '_wp_attachment_base64', true ) ? get_post_meta( $id, '_wp_attachment_base64', true ) : null);
    $file = WP_CONTENT_DIR . '/uploads/'. get_post_meta( $id, '_wp_attached_file' , true );
    if ( ! is_file($file) && $base64) {
        //if ( true ) { recreate file }
        
        return str_replace($src, $base64, $html);;
    }
    //$img->setAttribute('src','Test IMG');
    return $html;
});


?>
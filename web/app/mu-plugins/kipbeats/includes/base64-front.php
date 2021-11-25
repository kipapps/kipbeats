<?php

/*add_filter( 'post_thumbnail_html', function ( $html ) {
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
});*/
function check_image_url( $image, $attachment_id, $size, $icon ){
    $id = $attachment_id;$src = $image[0];
    $base64 = ( get_post_meta( $id, '_wp_attachment_base64', true ) ? get_post_meta( $id, '_wp_attachment_base64', true ) : null);
    $file = WP_CONTENT_DIR . '/uploads/'. get_post_meta( $id, '_wp_attached_file' , true );
    $tfile = dirname($file).'/'.basename($src);
    if ( ! is_file($tfile) && $base64) {
        if (! is_file($file)) {file_put_contents( $file, base64_decode( explode(';base64,', $base64)[1] ) );}
        $editor = wp_get_image_editor( $file, array() );
        $result = $editor->resize($image[1],$image[2], true);
        $editor->save($editor->generate_filename());
        
    }
    return $image;
}
add_filter( 'wp_get_attachment_image_src', 'check_image_url', 10, 4 );



?>
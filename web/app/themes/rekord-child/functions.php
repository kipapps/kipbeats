<?php
/**
 *  Rekord functions and definitions
 *
 *  @author    xvelopers
 *  @package   rekord-child
 *  @version   1.0.0
 *  @since     1.0.0
 */


add_action( 'wp_enqueue_scripts', 'rekord_child_enqueue_styles' );
function rekord_child_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array('parent-style')
    );
}

/* Hook into the 'init' action so that the function
* Containing our post type registration is not 
* unnecessarily executed. 
*/
add_action( 'init', function () {
    $args = array(
        'supports' => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'custom-fields', ),
        // This is where we add taxonomies to our CPT
        'taxonomies' => array( 'category' ),
    );
    // Registering your Custom Post Type
    register_post_type( 'video', $args );
}, 0 );

function get_youtube_cover_img($args) {
    extract($args);
    if (!$url)return;
    $video_id=explode('=',$url)[1];
    
    echo '
    <img width="470" height="263" src="https://i.ytimg.com/vi/'.$video_id.'/maxresdefault.jpg" class="img-fluid wp-post-image" alt="" loading="lazy" srcset="https://i.ytimg.com/vi/'.$video_id.'/maxresdefault.jpg 470w, https://i.ytimg.com/vi/'.$video_id.'/maxresdefault.jpg 300w, https://i.ytimg.com/vi/'.$video_id.'/maxresdefault.jpg 207w" sizes="(max-width: 470px) 100vw, 470px">
    ';
}


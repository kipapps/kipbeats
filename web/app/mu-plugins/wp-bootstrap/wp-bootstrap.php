<?php
/*
Plugin Name: Bootstrap Plugin
Plugin URI: https://getbootstrap.com/
Description: Allows functions to work for wordpress.
Author: KipSoft
Version: 4.0
Author URI: http://kipsoft.x10.mx
*/

//________________________________** INITIALIZE VARIABLES      **_________________________________//

$wp_wpdm_options = array(
	//'user'				=>	'',
	//'channels'			=>	array(),
	//'access_level'			=>	'level_10',
	//'author'			=>	1,
	//'display_meta'			=>	1,
	//'words'				=>	20,
	//'publish'			=>	1,
	//'rss'				=>	0,
	//'videos'			=>	array(),
	//'channelname'			=>	'KipBeats',
	//'max-results'			=>	1,
	//'twitter_user'		=>	'',
	//'twitter_password'		=>	'',
	//0'twitter_text'		=>	'I have posted a new video here: %twitter_link%',
	//'limit'				=>	4,
	//'pages'				=>	0,
	//'dims'				=>	array(506,304),
	//'related'			=>	1,
	//'inlist'			=>	0,
	//'cron'				=>	6,
	//'last_import'			=>	'',
	//'is_importing'			=>	false,
	'version'			=>	''
);


//function my_ffmpeg_func($ID) {
//$post = get_post($ID);
//	if ($post->post_type=="post"){
	
//	}
//}
//add_action('save_post','my_ffmpeg_func');
//unset($l,$k,$v);
//                                *******************************                                 //
//________________________________** CHECK DIRECTORIES         **_________________________________//
//////////////////////////////////**                           **///////////////////////////////////
//                                **                           **                                 //
//                                *******************************                                 //

//                                *******************************                                 //
//________________________________** INITIALIZE PLUGIN         **_________________________________//
//////////////////////////////////**                           **///////////////////////////////////
//                                **                           **                                 //
//                                *******************************                                 //

//                                *******************************                                 //
//________________________________** ADD EVENTS                **_________________________________//
//////////////////////////////////**                           **///////////////////////////////////
//                                **                           **                                 //
//                                *******************************                                 //
add_action('admin_menu','WP_Bootstrap_menu');

//                                *******************************                                 //
//________________________________** MENUS                     **_________________________________//
//////////////////////////////////**                           **///////////////////////////////////
//                                **                           **                                 //
//                                *******************************                                 //
function WP_Bootstrap_menu() {
	if(function_exists('add_menu_page')) {
		//add_options_page('KipBeats Settings','KipBeats',10,'kipbeats-settings','WP_kipbeats_settings');
		//add_media_page('Kipbeats Youtube Settings','Youtube Settings','Settings',10,'kipbeats-settings-youtube','WP_kipbeats_settings_youtube');
        //add_media_page(__( 'Youtube Media Settings', 'textdomain' ),__( 'Youtube', 'textdomain' ),10,'kipbeats-settings-youtube','WP_kipbeats_settings_youtube');
		//add_submenu_page('kipbeats-settings','Channels/Playlists','Channels/Playlists',10,'kipbeats-channels','WP_kipbeats_channels');
		//add_submenu_page('kipbeats-settings','Import Videos','Import Videos',10,'kipbeats-import-videos','WP_kipbeats_import_videos');
		//add_submenu_page('kipbeats-settings','Video Posts','Video Posts',10,'kipbeats-video-posts','WP_kipbeats_video_posts');
		//add_submenu_page('kipbeats-settings','Reset Settings','Reset Settings',10,'kipbeats-reset','WP_kipbeats_reset');
	}
}


//add_action('init','WP_kipbeats_init',0);
//function WP_kipbeats_init() {
	//global $getWP,$wp_import_youtube_post_defaults;
	//$o = getOption('wp_import_youtube',$wp_import_youtube_options);
	
//}


add_action('admin_init', 'wp_bootstrap_css' ); 
add_action('admin_init', 'wp_bootstrap_js' );  
//wp_dequeue_script('jquery');
function wp_bootstrap_css()
{ 

wp_enqueue_style( 'wp-bootstrap-css', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css', 99);
//echo "<link rel='stylesheet' href='".plugin_dir_url( __FILE__ )."assets/css/jquery.alerts.css' type='text/css' />";

  
} 

function wp_bootstrap_js ()
{ 
    
    //wp_enqueue_script( 'wp-bootstrap-jquery', 'https://code.jquery.com/jquery-3.2.1.slim.min.js', array(),'', true );
    wp_enqueue_script( 'wp-bootstrap-popper', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js', array(),'' , true );
    wp_enqueue_script( 'wp-bootstrap-js', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js', array(),'' , true );
}


//require_once("admin/kipbeats-admin.php");
//require_once("admin/kipbeats-youtube.php");

?>
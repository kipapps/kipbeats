<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @author    xvelopers
 * @package   rekord
 * @version   1.4.4
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> <?php if(get_theme_mod('layout_rtl'))  echo 'dir="rtl"'; ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <div id="app" class="<?php echo (get_theme_mod('theme_skin') != '#0c101b') ? 'theme-light' : 'theme-dark'; ?>">
    

        <!--Preloader-->
        <?php get_template_part('templates/global/pre', 'loader'); ?>


        <?php if(!is_page_template('templates/template-blank.php')): ?>
           
        
            <!--Nav-->
        
            <?php 
                if(get_theme_mod('rekord_top_menu')){ 
                    get_template_part('templates/headers/header', 'menu');
                }else{
                    get_sidebar('nav') ;
                }      
            ?>

            <!--Menu-->
            <?php get_template_part('templates/headers/header', 'playerbar'); ?>

            <!--Playlist Sidebar-->
            <?php  
            if(class_exists('ACF') ):
                get_template_part('templates/global/sidebar','playlist') ; 
            endif;
            ?>

            <?php
                $classes = 'height-full ';
                if(!get_theme_mod('rekord_top_menu')){
                    $classes .= 'has-sidebar ' ;
                    if(get_theme_mod('rekord_sidebar_menu_style') == 'full')
                        $classes .= 'has-sidebar-full';
                }
    
            ?>

            <!--Page Content-->
            <div id="pageContent" class="<?php echo $classes ?>  ">

        <?php else: ?>  
            <div id="pageContent">
        <?php endif;?>
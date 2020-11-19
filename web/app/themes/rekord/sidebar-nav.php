<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @author    xvelopers
 * @package   rekord
 * @version   1.0.0
 */
?>

<?php if ( has_nav_menu('main-menu') ) : ?>
<aside class="main-sidebar fixed offcanvas shadow" data-toggle='offcanvas'>
<div class="sidebar">
   <!-- <div class="p-3">
   <img class="mini-logo" src="<?php // site_icon_url(40); ?>" alt="" />
           <div class="sidebar-logo">
            <?php
                // if(!get_theme_mod('rekord_top_menu')){   
                //     set_query_var( 'logo_classes', 'd-none d-lg-block' );
                //     get_template_part('templates/headers/header', 'logo');
                // } 
            ?>
           </div>
   </div> -->
        
        <ul class="sidebar-menu">
            <li class="mb-3 b-0 ml-2">
                <?php get_template_part('templates/global/skin', 'toggler'); ?>
            </li>
            
            <?php do_action('rekord_nav_item'); ?>
            <?php
                wp_nav_menu(
                    array(
                        'theme_location' => 'main-menu',
                        'menu'           => 'nav navbar-nav',
                        'container'      => 'false',
                        'items_wrap' => '%3$s',
                        'menu_class'     => 'sidebar-menu',
                        'fallback_cb'    => '',
                        'menu_id'        =>  'main-menu',
                        'depth'          => 2,
                    )
                );
                ?>

                        
        </ul>
    </div>
</aside>
<?php endif; ?>
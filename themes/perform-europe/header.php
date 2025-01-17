<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package bopper
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
    <link href="https://performeurope.eu/wp-content/uploads/2023/11/perform-europe-fav.png" rel="shortcut icon" type="image/x-icon" />
	<?php wp_head(); ?>
</head>
<?php if ( is_404() ) {
?>
    <body <?php body_class( 'site-wrapper no-js pe-body pe-body--red' ); ?>>
<?php    
}
else
{
?>
    <!-- <body <?php //body_class( 'site-wrapper no-js pe-body' ); ?>> -->


    <body <?php body_class(); ?>>
<?php    
}
?>
	<?php wp_body_open(); ?>
     <nav class="nav__cont">
        <div class="navbar-wrp--difference">
            <div id="menu-open" class="navbar-block left" hoverstagger="link">
                <div hoverstagger="text" class="txt-link txt-white">Menu</div>
                <div hoverstagger="text" class="txt-link txt-white is-2">Menu</div>
            </div>
            <div class="navbar-block" hoverstagger="link">
                <a href="/" hoverstagger="text" class="txt-link txt-white">Perform Europe</a>
                <a href="/" hoverstagger="text" class="txt-link txt-white is-2">Perform Europe</a>
            </div><?php 
            $login_menu_hide = get_field('login_menu_hide', 'option'); 
            if($login_menu_hide != 1)
            { ?>
                <div class="navbar-block right" hoverstagger="link">
                    <?php if (is_user_logged_in()) { ?>
                        <a href="<?php echo home_url('user/dashboard') ?>" hoverstagger="text" class="txt-link txt-white">My Account</a>
                        <a href="<?php echo home_url('user/dashboard') ?>" hoverstagger="text" class="txt-link txt-white is-2">My Account</a>
                    <?php }else{ ?>
                        <a href="<?php echo home_url('login') ?>" hoverstagger="text" class="txt-link txt-white">Login</a>
                        <a href="<?php echo home_url('login') ?>" hoverstagger="text" class="txt-link txt-white is-2">Login</a>
                    <?php } ?>                
                </div><?php 
            } ?>            
        </div>
        <div class="nav">
            <div class="menu">
                <div class="navbar-wrp">
                    <div id="menu-close" class="navbar-block left" hoverstagger="link">
                        <div hoverstagger="text" class="txt-link txt-white">Close</div>
                        <div hoverstagger="text" class="txt-link txt-white is-2">Close</div>
                    </div>
                    <div class="navbar-block" hoverstagger="link">
                        <a href="/" hoverstagger="text" class="txt-link txt-white">Perform Europe</a>
                        <a href="/" hoverstagger="text" class="txt-link txt-white is-2">Perform Europe</a>
                    </div><?php                     
                    if($login_menu_hide != 1){  
                        if (is_user_logged_in()) { ?>                        
                        <div class="navbar-block right" hoverstagger="link">
                            <a href="<?php echo home_url('user/dashboard') ?>" hoverstagger="text" class="txt-link txt-white">My Account</a>
                            <a href="<?php echo home_url('user/dashboard') ?>" hoverstagger="text" class="txt-link txt-white is-2">My Account</a>
                        </div><?php 
                        }
                        else{ ?>
                            <div class="navbar-block right" hoverstagger="link">
                                <a href="<?php echo home_url('login') ?>" hoverstagger="text" class="txt-link txt-white">Login</a>
                                <a href="<?php echo home_url('login') ?>" hoverstagger="text" class="txt-link txt-white is-2">Login</a></div><?php 
                        } 
                     } ?>       
                </div>
                <div class="menu-links-wrp">
                    <div class="menu-link-cont">
                        <div class="menu-link-block">
                            <div class="menu__link__txt-wrp"><a href="/" class="menu__link w-inline-block">
                                    <div class="txt--4rem">Home</div>
                                </a>
                                <div class="menu__link__line"></div>
                            </div>
                        </div>
                        <div class="menu-link-block">
                            <div class="menu__link__txt-wrp"><a href="/about-us" class="menu__link w-inline-block">
                                    <div class="txt--4rem">About Us</div>
                                </a>
                                <div class="menu__link__line"></div>
                            </div>
                            <div class="menu__sub-links"><a href="/about#who-we-are" class="menu__link">who we are</a><a
                                    href="/about#timeline" class="menu__link">Timeline</a><a href="/about#teams"
                                    class="menu__link">Teams</a><a href="/about#consortium-partners"
                                    class="menu__link">Consortium partners</a></div>
                        </div>
                        <div class="menu-link-block">
                            <div class="menu__link__txt-wrp">
                                <a href="/activities" class="menu__link w-inline-block">
                                    <div class="txt--4rem">Activities</div>
                                </a>
                                <div class="menu__link__line"></div>
                            </div><?php
                            $categories = get_categories( array(
                                'orderby' => 'name',
                                'parent'  => 0,
                                'hide_empty' => true,
                            ) ); ?>
                            <div class="menu__sub-links"><?php
                                foreach( $categories as $category ) { 
                                    $category_link = get_category_link( $category->term_id ); ?>
                                    <a href="<?php echo $category_link; ?>" class="menu__link"><?php echo $category->name; ?></a><?php
                                } ?> 
                            </div>
                        </div>
                    </div>
                    <div class="menu-link-cont"><?php      
                        $hide_menu = get_field('hide_menu', 'option');                    
                        if($hide_menu != 1)
                        {  ?>
                            <div class="menu-link-block">
                                <div class="menu__link__txt-wrp">
                                    <a href="/open-call" class="menu__link w-inline-block">
                                        <div class="txt--4rem">The open Call</div>
                                    </a>
                                    <div class="menu__link__line"></div>
                                </div>
                            </div><?php
                        } ?>   
                        <a href="/selected-projects" class="menu-link-block m-l-i">
                            <div class="menu__link__txt-wrp">
                                <div class="menu__link w-inline-block">
                                    <div class="txt--4rem">Selected Projects</div>
                                </div>
                                <div class="menu__link__line"></div>
                            </div>
                            <div class="menu__sub-img-wrp w-inline-block">

                                <?php
                            $args = array(
                                'post_type' => 'project',
                                'post_status'   => 'publish',
                                'orderby' => 'rand',                                
                                'posts_per_page' =>1,
                                'meta_query'    => array(
                                    array(
                                        'key'       => 'edition',
                                        'value'     => array('2024-2026'),
                                        'compare'   => 'IN',
                                    ),
                                ),
                            );
                            $project_list = get_posts( $args ); 
                            if(!empty($project_list)){ 
                                foreach ( $project_list as $post ) {
                                    $image = wp_get_attachment_url( get_post_thumbnail_id($post->ID, 'full'));  
                                    if(!empty($image)){ ?>
                                        
                                            <img src="<?php echo $image; ?>" loading="eager" sizes="100vw" alt="<?php echo get_the_title($post->ID); ?>" class="menu__sub-img">
                                       <?php
                                    } 
                                } wp_reset_postdata();
                            }
                            else
                               {
                                         $args = array(
                                                'post_type' => 'project',
                                                'post_status'   => 'publish',
                                                'orderby' => 'rand',                                
                                                'posts_per_page' =>1,
                                                'meta_query'    => array(
                                                    array(
                                                        'key'       => 'edition',
                                                        'value'     => array('2021-2022'),
                                                        'compare'   => 'IN',
                                                    ),
                                                ),
                                            );
                                            $project_list = get_posts( $args ); 
                                            if(!empty($project_list)){ 
                                                foreach ( $project_list as $post ) {
                                                    $image = wp_get_attachment_url( get_post_thumbnail_id($post->ID, 'full'));  
                                                    if(!empty($image)){ ?>                                                        
                                                            <img src="<?php echo $image; ?>" loading="eager" sizes="100vw" alt="<?php echo get_the_title($post->ID); ?>" class="menu__sub-img">
                                                        <?php
                                                    } 
                                                } wp_reset_postdata();
                                            }
                               } 
                             ?>                            
                            </div>
                        </a>
                        <?php    
                        $touring_programme_menu_hide = get_field('touring_programme_menu_hide', 'option');                        
                        if($touring_programme_menu_hide != 1)
                        {  ?>
                            <div class="menu-link-block">
                                <div class="menu__link__txt-wrp"><a href="/find-a-performance" class="menu__link w-inline-block">
                                        <div class="txt--4rem">Find a Performance</div>
                                    </a>
                                    <div class="menu__link__line"></div>
                                </div>
                            </div><?php
                        } ?>   
                    </div>
                </div>    
                 <?php                     
                if($login_menu_hide != 1)
                {   ?>
                    <div class="login--moblie"><?php 
                        if (is_user_logged_in()) { ?>
                            <a href="<?php echo home_url('user/dashboard') ?>" class="btn-transparent--magenta w-inline-block"><div class="txt-block--1rem">My Account</div></a><?php 
                        }
                        else{ ?>
                            <a href="<?php echo home_url('login') ?>" class="btn-transparent--magenta w-inline-block"><div class="txt-block--1rem">login</div></a><?php 
                        } ?>
                    </div><?php
                } ?>   
            </div>
        </div>
    </nav>
<div id="smooth-wrapper"><?php 
if ( is_404() ) { ?>
    <main class="page-wrp--404" id="smooth-content"><?php    
}
else
{ ?>
    <main class="page-wrp" id="smooth-content"><?php    
} ?>

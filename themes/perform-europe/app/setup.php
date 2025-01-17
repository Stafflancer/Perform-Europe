<?php

/**
 * Theme setup.
 */

namespace App;

add_filter('wp_mail_content_type', function( $content_type ) {
    return 'text/html';
});

add_action('after_setup_theme', function () {

    add_theme_support('civiadmin');

}, 20);

if ( ! function_exists( 'isUserLoggedIn' ) ) {
    function isUserLoggedIn() {
        if ( is_user_logged_in() ) {
            wp_safe_redirect('/user/dashboard');
            exit;
        }
    }
}

if ( ! function_exists( 'mustBeLoggedIn' ) ) {
    function mustBeLoggedIn() {
        if ( ! is_user_logged_in() ) {
            wp_logout();
            wp_safe_redirect('/login');
            exit;
        }
    }
}

add_action('init', function() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
});

add_action('init', function() {
    $url_path = trim(parse_url(add_query_arg(array()), PHP_URL_PATH), '/');

    if ( $url_path === 'user/create-account' ) {
        \App\isUserLoggedIn();
        include_once plugin_dir_path(dirname(__FILE__)) . 'civicrm/create-account.php';
        exit;
    }

    if ( $url_path === 'user/create-account-form' ) {
        \App\isUserLoggedIn();
        include_once plugin_dir_path(dirname(__FILE__)) . 'civicrm/create-account-form.php';
        unset($_SESSION['civicrm_theme_notices']);
        unset($_SESSION['muyadev_feedback']);        
        exit;
    }

    if ( $url_path === 'user/open-call' ) {
        include_once plugin_dir_path(dirname(__FILE__)) . 'civicrm/open-call.php';
        exit;
    }

    if ( $url_path === 'user/partners' ) {
        \App\mustBeLoggedIn();
        include_once plugin_dir_path(dirname(__FILE__)) . 'civicrm/partners.php';
        unset($_SESSION['civicrm_theme_notices']);
        unset($_SESSION['muyadev_feedback']);
        exit;        
    }

    if ( $url_path === 'user/proposals' ) {
        \App\mustBeLoggedIn();
        include_once plugin_dir_path(dirname(__FILE__)) . 'civicrm/proposals.php';
        unset($_SESSION['civicrm_theme_notices']);
        unset($_SESSION['muyadev_feedback']);
        exit;        
    }

    if ( $url_path === 'user/submit-proposal' ) {
        \App\mustBeLoggedIn();
        include_once plugin_dir_path(dirname(__FILE__)) . 'civicrm/submit-proposal.php';
        unset($_SESSION['civicrm_theme_notices']);
        unset($_SESSION['muyadev_feedback']);
        exit;        
    }

    if ( $url_path === 'user/logout' ) {
        wp_logout();
        wp_safe_redirect('/login');
        exit;
    }

    if ( $url_path === 'user/login' ) {        
        \App\isUserLoggedIn();
        include_once plugin_dir_path(dirname(__FILE__)) . 'civicrm/login.php';
        unset($_SESSION['civicrm_theme_notices']);
        unset($_SESSION['muyadev_feedback']);
        exit;
    }

    if ( $url_path === 'user/forgot-password' ) {
        \App\isUserLoggedIn();
        include_once plugin_dir_path(dirname(__FILE__)) . 'civicrm/forgot-password.php';
        unset($_SESSION['civicrm_theme_notices']);
        unset($_SESSION['muyadev_feedback']);
        exit;
    }

    if ( $url_path === 'user/change-password' ) {

        if (isset($_GET['acct']) && $_GET['acct']) {
            $saveparner = new \App\Core\Forms();
            $saveparner->verifyResetCode($_GET['acct']);            
        }

        include_once plugin_dir_path(dirname(__FILE__)) . 'civicrm/change-password.php';
        unset($_SESSION['civicrm_theme_notices']);
        unset($_SESSION['muyadev_feedback']);
        exit;
    }

    if ( $url_path === 'user/dashboard' ) {
        \App\mustBeLoggedIn();
        include_once plugin_dir_path(dirname(__FILE__)) . 'civicrm/account.php';
        unset($_SESSION['civicrm_theme_notices']);
        unset($_SESSION['muyadev_feedback']);
        exit;
    }

    if ( $url_path === 'user/profile' ) {
        \App\mustBeLoggedIn();
        include_once plugin_dir_path(dirname(__FILE__)) . 'civicrm/profile.php';
        unset($_SESSION['civicrm_theme_notices']);
        unset($_SESSION['muyadev_feedback']);
        exit;
    }

    if ( $url_path === 'user/edit' ) {
        \App\mustBeLoggedIn();
        include_once plugin_dir_path(dirname(__FILE__)) . 'civicrm/edit.php';
        unset($_SESSION['civicrm_theme_notices']);
        unset($_SESSION['muyadev_feedback']);
        exit;
    }

});


add_action('admin_init', function (){
    if ( ! current_user_can( 'manage_options' ) ) {
        show_admin_bar( false );
    }

    if (!is_user_logged_in()) {
        return null;
    }

    // if (!current_user_can('administrator') && is_admin()) {
    //     if (!(isset($_GET['action']) && $_GET['action'] == 'edit')) {
    //          wp_redirect(home_url());
    //          exit;
    //     }
    // }
});


add_action('after_setup_theme', function () {
    if (!current_user_can('administrator') && !is_admin()) {
      show_admin_bar(false);
    }
});
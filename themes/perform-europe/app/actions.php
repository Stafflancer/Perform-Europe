<?php

/**
 * Theme Actions
 */

namespace App;

use App\Core\Forms;


add_action( 'admin_post_muyadev_save_partner', function() {
    $saveparner = new Forms();
    $saveparner->saveUser($_POST);
});

add_action( 'admin_post_muyadev_edit_partner', function() {
    $saveparner = new Forms();
    $saveparner->editUser($_POST);
});

add_action( 'admin_post_muyadev_delete_partner', function() {
    $saveparner = new Forms();
    $saveparner->deletePartner($_POST);
});

add_action( 'admin_post_nopriv_muyadev_save_partner_front', function() {
    $saveparner = new Forms();
    $saveparner->saveUser($_POST);
});

add_action( 'admin_post_muyadev_edit_user_front', function() {
    $saveparner = new Forms();
    $saveparner->editUser($_POST);
});

add_action( 'admin_post_nopriv_muyadev_login_user', function() {
    $saveparner = new Forms();
    $saveparner->logInUser($_POST);
});

add_action( 'admin_post_nopriv_muyadev_forgotpass_user', function() {
    $saveparner = new Forms();
    $saveparner->forgetPassword($_POST);
});

add_action( 'admin_post_nopriv_muyadev_changepass_user', function() {
    $saveparner = new Forms();
    $saveparner->changePassword($_POST);
});		

add_action( 'admin_post_muyadev_change_email_profile', function() {
    $saveparner = new Forms();
    $saveparner->changeEmailProfile($_POST);
});


add_action( 'admin_post_muyadev_change_password_profile', function() {
    $saveparner = new Forms();
    $saveparner->changePasswordProfile($_POST);
});

add_action( 'admin_post_muyadev_submit_pages_for_review', function() {
    $review = new Forms();
    $review->submitPagesForReview($_POST);
});

add_action( 'admin_post_muyadev_approve_partner', function() {
    $review = new Forms();
    $review->approvePartner($_POST);
});

add_action( 'admin_post_muyadev_disapprove_partner', function() {
    $review = new Forms();
    $review->disaapprovePartner($_POST);
});

add_action( 'admin_post_muyadev_search_partner', function() {
    $searchpartner = new Forms();
    $searchpartner->searchPartner($_POST);
});

add_action( 'admin_post_muyadev_search_school', function() {
    $searchpartner = new Forms();
    $searchpartner->searchSchool($_POST);
});
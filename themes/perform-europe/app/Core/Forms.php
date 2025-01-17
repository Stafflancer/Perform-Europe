<?php
/**
 * Callbacks for Settings API
 *
 */
namespace App\Core;

class Forms
{
    public function saveUser($post)
    {
        $redirectfront = '/user/create-account-form';
        //Validate inputs
        if (!(isset($post['email']) && $post['email'])) {
            $_SESSION['civicrm_theme_notices'] = [
                'type' => 'error',
                'message' => 'Email address is required'
            ];
            wp_safe_redirect($redirectfront);
            exit;
        }

        if (!(isset($post['first_name']) && $post['first_name'])) {
            $_SESSION['civicrm_theme_notices'] = [
                'type' => 'error',
                'message' => 'First name is required'
            ];
            wp_safe_redirect($redirectfront);
            exit;
        }

        if (!(isset($post['last_name']) && $post['last_name'])) {
            $_SESSION['civicrm_theme_notices'] = [
                'type' => 'error',
                'message' => 'Last name is required'
            ];
            wp_safe_redirect($redirectfront);
            exit;
        }

        if (!(isset($post['jobtitle']) && $post['jobtitle'])) {
            $_SESSION['civicrm_theme_notices'] = [
                'type' => 'error',
                'message' => 'Job title is required'
            ];
            wp_safe_redirect($redirectfront);
            exit;
        }

        if (!(isset($post['confirmemail']) && $post['confirmemail'])) {
            $_SESSION['civicrm_theme_notices'] = [
                'type' => 'error',
                'message' => 'Confirm email is required'
            ];
            wp_safe_redirect($redirectfront);
            exit;
        }

        if (!(isset($post['password']) && $post['password'])) {
            $_SESSION['civicrm_theme_notices'] = [
                'type' => 'error',
                'message' => 'Password is required'
            ];
            wp_safe_redirect($redirectfront);
            exit;
        }

        if (!(isset($post['confirmpassword']) && $post['confirmpassword'])) {
            $_SESSION['civicrm_theme_notices'] = [
                'type' => 'error',
                'message' => 'Confirm password is required'
            ];
            wp_safe_redirect($redirectfront);
            exit;
        }

        if (!(isset($post['accounttype']) && $post['accounttype'])) {
            $_SESSION['civicrm_theme_notices'] = [
                'type' => 'error',
                'message' => 'Account type is required'
            ];
            wp_safe_redirect($redirectfront);
            exit;
        }

        if (!(isset($post['orgname']) && $post['orgname'])) {
            $_SESSION['civicrm_theme_notices'] = [
                'type' => 'error',
                'message' => 'Organisation name is required'
            ];
            wp_safe_redirect($redirectfront);
            exit;
        }

        if (!(isset($post['country']) && $post['country'])) {
            $_SESSION['civicrm_theme_notices'] = [
                'type' => 'error',
                'message' => 'Country is required'
            ];
            wp_safe_redirect($redirectfront);
            exit;
        }

        if (!(isset($post['city']) && $post['city'])) {
            $_SESSION['civicrm_theme_notices'] = [
                'type' => 'error',
                'message' => 'City is required'
            ];
            wp_safe_redirect($redirectfront);
            exit;
        }

        if (!(isset($post['shortdesc']) && $post['shortdesc'])) {
            $_SESSION['civicrm_theme_notices'] = [
                'type' => 'error',
                'message' => 'Short description is required'
            ];
            wp_safe_redirect($redirectfront);
            exit;
        }

        if (!(isset($post['youroffer']) && $post['youroffer'])) {
            $_SESSION['civicrm_theme_notices'] = [
                'type' => 'error',
                'message' => 'Your offer is required'
            ];
            wp_safe_redirect($redirectfront);
            exit;
        }

        if ( ! function_exists( 'wp_handle_upload' ) ) {
            require_once( ABSPATH . 'wp-admin/includes/file.php' );
        }

        $uniqueUsername = $this->generate_unique_username($post['first_name']);

        if ( false == email_exists( $post['confirmemail'] ) ) {

            $userdata = [
                'user_pass'				=> $post['confirmpassword'],
                'user_email' 			=> $post['confirmemail'],
                'first_name' 			=> $post['first_name'],
                'last_name' 			=> $post['last_name'],
                'user_login'            => $uniqueUsername
            ];

            $user_id = wp_insert_user( $userdata);

            if (isset($user_id->errors) && $user_id->errors) {

                if (isset($user_id->errors['existing_user_login'][0]) && $user_id->errors['existing_user_login'][0]) {
                    $error = $user_id->errors['existing_user_login'][0];
                } else {
                    $error = 'Unknown error';
                }

                $_SESSION['civicrm_theme_notices'] = [
                    'type' => 'error',
                    'message' => $error
                ];
                wp_safe_redirect($redirectfront);
                exit;
            }

            $user = get_user_by( 'id', $user_id );

            if (!$user) {
                $_SESSION['civicrm_theme_notices'] = [
                    'type' => 'error',
                    'message' => $error
                ];
                wp_safe_redirect($redirectfront);
                exit;
            }

            try {
                $result = civicrm_api3('Contact', 'getsingle', array(
                    'email' => $user->user_email,
                ));
            
                if (isset($result['contact_id']) && $result['contact_id']) {
                    civicrm_api3('Contact', 'create', array(
                        'id' => $result['contact_id'],
                        'job_title' => $post['jobtitle'],
                        'nick_name' => $uniqueUsername,
                        'contact_type' => 'Individual',
                        'custom_2' => $post['accounttype'], // Contact type
                        'custom_3' => $post['orgname'], // Organisation
                        'custom_5' => $post['city'], // City
                        'custom_6' => $post['shortdesc'], // Short description
                        'custom_7' => $post['youroffer'], // Your offer
                        'custom_11' => $post['yourneeds'], // Your offer
                        'custom_12' => (int) $post['country'] // Country
                    ));
                }else {
                    $_SESSION['civicrm_theme_notices'] = [
                        'type' => 'error',
                        'message' => 'Contact ID not fount in CIVICRM'
                    ];
                    wp_safe_redirect($redirectfront);
                    exit;
                }
            } catch (\Throwable $th) { }            

        } else {
            $_SESSION['civicrm_theme_notices'] = [
                'type' => 'error',
                'message' => 'User already exists'
            ];
            wp_safe_redirect($redirectfront);
            exit;
        }

        // Upload file
        if (isset($_FILES['cover']['size']) && $_FILES['cover']['size'] != 0) {
            try {
                try {
                    civicrm_api3('Attachment', 'create', [
                        'name' => $_FILES['cover']['name'],
                        'mime_type' => $_FILES['cover']['type'],
                        'entity_id' => $result['contact_id'],
                        'field_name' => 'custom_8',
                        'options' => [ 'move-file' => $_FILES['cover']['tmp_name'] ]
                    ]);
                } catch (\Throwable $th) {
                    $_SESSION['civicrm_theme_notices'] = [
                        'type' => 'error',
                        'message' => $th->getMessage()
                    ];
                    wp_safe_redirect($redirectfront);
                    exit;
                }
            } catch (\Throwable $th) {}
        }

        //Register success
        wp_set_current_user( $user->ID, $user->user_login );
        wp_set_auth_cookie( $user->ID );
        do_action( 'wp_login', $user->user_login, $user );
        
        wp_safe_redirect('/user/account');
        exit;
    }


    public function editUser($post)
    {
        $redirectfront = '/user/edit';
        //Validate inputs
        if (!(isset($post['wordpressid']) && $post['wordpressid'])) {
            $_SESSION['civicrm_theme_notices'] = [
                'type' => 'error',
                'message' => 'Wordpress ID  is required'
            ];
            wp_safe_redirect($redirectfront);
            exit;
        }

        //Remove when CRM is defined
        if (function_exists('civicrm_api3')) {
            if (!(isset($post['civicrmid']) && $post['civicrmid'])) {
                $_SESSION['civicrm_theme_notices'] = [
                    'type' => 'error',
                ];
                wp_safe_redirect($redirectfront);
                exit;
            }

            if (!(isset($post['jobtitle']) && $post['jobtitle'])) {
                $_SESSION['civicrm_theme_notices'] = [
                    'type' => 'error',
                    'message' => 'Job title is required'
                ];
                wp_safe_redirect($redirectfront);
                exit;
            }
    
            if (!(isset($post['accounttype']) && $post['accounttype'])) {
                $_SESSION['civicrm_theme_notices'] = [
                    'type' => 'error',
                    'message' => 'Account type is required'
                ];
                wp_safe_redirect($redirectfront);
                exit;
            }
    
            if (!(isset($post['orgname']) && $post['orgname'])) {
                $_SESSION['civicrm_theme_notices'] = [
                    'type' => 'error',
                    'message' => 'Organisation name is required'
                ];
                wp_safe_redirect($redirectfront);
                exit;
            }
    
            if (!(isset($post['country']) && $post['country'])) {
                $_SESSION['civicrm_theme_notices'] = [
                    'type' => 'error',
                    'message' => 'Country is required'
                ];
                wp_safe_redirect($redirectfront);
                exit;
            }
    
            if (!(isset($post['city']) && $post['city'])) {
                $_SESSION['civicrm_theme_notices'] = [
                    'type' => 'error',
                    'message' => 'City is required'
                ];
                wp_safe_redirect($redirectfront);
                exit;
            }
    
            if (!(isset($post['shortdesc']) && $post['shortdesc'])) {
                $_SESSION['civicrm_theme_notices'] = [
                    'type' => 'error',
                    'message' => 'Short description is required'
                ];
                wp_safe_redirect($redirectfront);
                exit;
            }
    
            if (!(isset($post['youroffer']) && $post['youroffer'])) {
                $_SESSION['civicrm_theme_notices'] = [
                    'type' => 'error',
                    'message' => 'Your offer is required'
                ];
                wp_safe_redirect($redirectfront);
                exit;
            }
        }        

        if (!(isset($post['first_name']) && $post['first_name'])) {
            $_SESSION['civicrm_theme_notices'] = [
                'type' => 'error',
                'message' => 'First name is required'
            ];
            wp_safe_redirect($redirectfront);
            exit;
        }

        if (!(isset($post['last_name']) && $post['last_name'])) {
            $_SESSION['civicrm_theme_notices'] = [
                'type' => 'error',
                'message' => 'Last name is required'
            ];
            wp_safe_redirect($redirectfront);
            exit;
        }

        if ( ! function_exists( 'wp_handle_upload' ) ) {
            require_once( ABSPATH . 'wp-admin/includes/file.php' );
        }

        $userdata = wp_update_user( array(
            'ID' => $post['wordpressid'],
            'first_name' => $post['first_name'],
            'last_name' => $post['last_name'],
        ));

        if ( is_wp_error( $userdata ) ) {
            $_SESSION['civicrm_theme_notices'] = [
                'type' => 'error',
                'message' => 'Was not able to update'
            ];
            wp_safe_redirect($redirectfront);
            exit;
        } else {
            // Success!
            $user = get_user_by( 'id', $post['wordpressid'] );

            if (!$user) {
                $_SESSION['civicrm_theme_notices'] = [
                    'type' => 'error',
                    'message' => $error
                ];
                wp_safe_redirect($redirectfront);
                exit;
            }

            try {
                $result = civicrm_api3('Contact', 'getsingle', array(
                    'email' => $user->user_email,
                ));
            
                if (isset($result['contact_id']) && $result['contact_id']) {
                    civicrm_api3('Contact', 'create', array(
                        'id' => $result['contact_id'],
                        'job_title' => $post['jobtitle'],
                        'nick_name' => $uniqueUsername,
                        'contact_type' => 'Individual',
                        'custom_2' => $post['accounttype'], // Contact type
                        'custom_3' => $post['orgname'], // Organisation
                        'custom_5' => $post['city'], // City
                        'custom_6' => $post['shortdesc'], // Short description
                        'custom_7' => $post['youroffer'], // Your offer
                        'custom_11' => $post['yourneeds'], // Your offer
                        'custom_12' => (int) $post['country'] // Country
                    ));
                }else {
                    $_SESSION['civicrm_theme_notices'] = [
                        'type' => 'error',
                        'message' => 'Contact ID not fount in CIVICRM'
                    ];
                    wp_safe_redirect($redirectfront);
                    exit;
                }
            } catch (\Throwable $th) { }   
        }

        // Upload file
        if (isset($_FILES['cover']['size']) && $_FILES['cover']['size'] != 0) {
            try {
                try {
                    civicrm_api3('Attachment', 'create', [
                        'name' => $_FILES['cover']['name'],
                        'mime_type' => $_FILES['cover']['type'],
                        'entity_id' => $result['contact_id'],
                        'field_name' => 'custom_8',
                        'options' => [ 'move-file' => $_FILES['cover']['tmp_name'] ]
                    ]);
                } catch (\Throwable $th) {
                    $_SESSION['civicrm_theme_notices'] = [
                        'type' => 'error',
                        'message' => $th->getMessage()
                    ];
                    wp_safe_redirect($redirectfront);
                    exit;
                }
            } catch (\Throwable $th) {}
        }

        //Register success
        
        wp_safe_redirect('/user/account');
        exit;
    }

    public function forgetPassword($post)
    {
        if (false == email_exists( $post['email'] )) {
            $_SESSION['civicrm_theme_notices'] = [
                'type' => 'error',
                'message' => 'Email does not exist'
            ];
            wp_safe_redirect('/user/forgot-password');
            exit;            
        }

        $user_info = get_user_by('email', $post['email']);

        $code = md5(time());
        $string = array('id'=>$user_info->ID, 'code'=>$code);
        update_user_meta($user_info->ID, 'activation_code', $code);

        $url = home_url() . '/user/change-password?acct='.base64_encode( serialize($string));
        $html = 'Dear '. $user_info->first_name .',<br/><br/>';
        $html .= 'Click the link below to reset your password.<br/><br/>';
        $html .= 'This link is active for 24 hours from when it was sent.<br/><br/>';
        $html .= '<a href="'.$url.'">'.$url.'</a> <br/><br/>';
        $html .= 'Thanks <br/><br/>';
        $html .= 'Your team';

        wp_mail( $user_info->user_email, __('Forgotten password email', 'sage') , $html);

        $_SESSION['civicrm_theme_notices'] = [
            'type' => 'success',
            'message' => 'We have emailed you a reset password link'
        ];
        wp_safe_redirect('/user/forgot-password');
        exit;
    }

    public function verifyResetCode($resetcode)
    {
        try {
            $data = unserialize(base64_decode($resetcode));
            $code = get_user_meta($data['id'], 'activation_code', true);
            
            if($code != $data['code']){
                $_SESSION['civicrm_theme_notices'] = [
                    'type' => 'error',
                    'message' => 'Reset code invalid, try again'
                ];
        
                wp_safe_redirect('/user/forgot-password');
                exit;
            }
        } catch (\Throwable $th) {
            $_SESSION['civicrm_theme_notices'] = [
                'type' => 'error',
                'message' => 'Reset code invalid :'.$th->getMessage()
            ];

            wp_safe_redirect('/user/forgot-password');
            exit;
        }       
        
    }

    public function changePassword($post)
    {        
        wp_set_password( $post['confirmpassword'], $post['userID'] );
        wp_safe_redirect('/user/login');
        exit;
    }

    public function logInUser($post)
    {
        $user = wp_authenticate($post['email'], $post['password']);
        if(!is_wp_error($user)) {
            wp_set_current_user( $user->ID, $user->user_login );
            wp_set_auth_cookie( $user->ID );
            do_action( 'wp_login', $user->user_login, $user );
            if (is_user_logged_in()) {
                wp_safe_redirect('/user/account');
                exit;
            }
        } else {
            $_SESSION['civicrm_theme_notices'] = [
                'type' => 'error',
                'message' => 'Login invalid'
            ];
            wp_safe_redirect('/user/login');
            exit;
        }
    }

    public function changeEmailProfile($post)
    {
        $current_user = wp_get_current_user();
        $user = wp_authenticate($current_user->user_login, $post['password']);
        if(!is_wp_error($user)) {
            $user_data = wp_update_user( array( 'ID' => $current_user->ID, 'user_email' => $post['email'] ) );
            if ( !is_wp_error( $user_data ) ) {
                $_SESSION['civicrm_theme_notices'] = [
                    'type' => 'success',
                    'message' => 'Email was changed successfully'
                ];
                wp_safe_redirect('/user/account');
                exit;
            }
        }
        $_SESSION['civicrm_theme_notices'] = [
            'type' => 'error',
            'message' => 'Invalid password'
        ];
        wp_safe_redirect('/user/account');
        exit;
    }

    public function changePasswordProfile($post)
    {
        $current_user = wp_get_current_user();
        $user = wp_authenticate($current_user->user_login, $post['password']);
        if(!is_wp_error($user)) {
            $user_data = wp_update_user( array( 'ID' => $current_user->ID, 'user_pass' => $post['confirm_password'] ) );
            if ( !is_wp_error( $user_data ) ) {
                $_SESSION['civicrm_theme_notices'] = [
                    'type' => 'success',
                    'message' => 'Password was changed successfully'
                ];
                wp_safe_redirect('/user/account');
                exit;
            }
        }
        $_SESSION['civicrm_theme_notices'] = [
            'type' => 'error',
            'message' => 'Current password not valid'
        ];
        wp_safe_redirect('/user/account');
        exit;
    }

    private function generate_unique_username( $username ) {

        static $i;
        if ( null === $i ) {
            $i = 1;
        } else {
            $i++;
        }
    
        if ( ! username_exists( $username ) ) {
            return $username;
        }
    
        $new_username = sprintf( '%s-%s', $username, $i );
    
        if ( ! username_exists( $new_username ) ) {
            return $new_username;
        } else {
            return call_user_func( __FUNCTION__, $username );
        }
    }
}
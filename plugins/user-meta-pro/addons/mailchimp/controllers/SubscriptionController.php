<?php
namespace UserMeta\MailChimp;

/**
 * Manage subscription
 *
 * @since 2.5
 * @author khaled Hossain
 */
class SubscriptionController
{

    function __construct(){

        add_action('user_meta_after_user_register', array(
            $this,
            'SubscribeOnRegistration'
        ));

        add_action('delete_user', array(
            $this,
            'deleteUserFunction'
        ));

        add_action('user_meta_after_user_update', array(
            $this,
            'profileUpdateFunction'
        ));
    }

    public function SubscribeOnRegistration($response)
    {
        $userID = $response->ID;
        $field = Base::getData();
        $user = get_userdata($userID);

        if(empty($field['subscription_on_registration'])){
            return;
        }

        if(!empty($field['permission_field'])){
            if(empty($user->{$field['permission_field']})){
                return;
            }
        }
        (new McFunctions())->subscribe($field, $user);
    }

    public function deleteUserFunction($userID){
        $field = Base::getData();
        if(!isset($field['user_delete_action']) || $field['user_delete_action'] == 'no'){
            return;
        }
        $user = get_userdata($userID);
        $email = $user->user_email;

        if( $field['user_delete_action'] == 'remove'){
            (new McFunctions())->delete($email);
        }
        if( $field['user_delete_action'] == 'unsub'){
            (new McFunctions())->unsubscribe($email);
        }
    }

    public function profileUpdateFunction($userdata){
        $field = Base::getData();
        if(empty($field['subscription_on_profile'])){
            return;
        }

        $user = get_userdata($userdata->ID);
        $field = Base::getData();

        (new McFunctions())->subscribe($field, $user, false);
    }

}
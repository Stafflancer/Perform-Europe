<?php

namespace UserMeta\AuthorBox;

use UserMeta\Html\Html;

/**
 * Controller for Meta Box in post/page editor
 *
 * @since 2.4
 * @author Sourov Amin
 */
class MetaBoxController
{

    public $context;

    public function __construct()
    {
        $field = Base::getData();
        $context = [];
        if (! empty($field['set_posts']) && $field['set_posts'] != 'no'){
            array_push($context, 'post');
        }
        if (! empty($field['set_pages']) && $field['set_pages'] == 'yes'){
            array_push($context, 'page');
        }
        if (!empty($context)) {
            /**
             * Add action to add metabox in post editor
             */
            add_action('add_meta_boxes', [
                $this,
                'visibilityMetaBox'
            ]);


            add_action('save_post', [
                $this,
                'metaBoxSave'
            ], 10, 2);
        }
        $this->context = $context;
    }
    
    /**
    * Adding meta box
    */
    function visibilityMetaBox() {

        add_meta_box(
            'um_author_box_visibility',
            __('UMP Author Box', 'user-meta'),
            [$this,'metaBoxContent'],
            $this->context,
            'normal',
            'default'
        );
        
    }
    
    /**
    * Setup meta box
    */
    function metaBoxContent(){
        global $userMeta;
        global $post;
        $value = get_post_meta( $post->ID, 'um_author_box_visibility', true );
        $html = null;
       
        $choice = [
            'yes' => __('Yes', 'user-meta'),
            'no' => __('No', 'user-meta'),
        ];

        $html .=  '<p>'.Html::select(isset($value) ? $value : 'no', [
            'name' => 'um_author_box_visibility',
            'label' => __('Show Author Box', 'user-meta')
        ], $choice).'</p>';

        echo $html;
        wp_nonce_field( 'um_author_metabox_nonce', 'um_author_metabox_process' );
    }

    /**
     * Save meta box data
     */
    function metaBoxSave( $post_id, $post ){

		if ( !isset( $_POST['um_author_metabox_process'] ) ) return;

        if ( !isset($_POST['um_author_box_visibility']) ) return;

		if ( !wp_verify_nonce( $_POST['um_author_metabox_process'], 'um_author_metabox_nonce' ) ) {
			return;
		}

		if ( !current_user_can( 'edit_post', $post->ID )) {
			return;
		}

        if ( !isset( $_POST['um_author_box_visibility'] ) ) {
			return;
		}
        
        $sanitized = wp_filter_post_kses( $_POST['um_author_box_visibility'] );

		update_post_meta( $post->ID, 'um_author_box_visibility', $sanitized );
    }
    
}
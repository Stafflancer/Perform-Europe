<?php
namespace UserMeta\AuthorBox;

/**
 * Controller for Author Box
 *
 * @since 2.4
 * @author Sourov Amin
 */
class AuthorBoxController
{

    public function __construct()
    {
        /**
         * Add filter to display author data box in post
         */
        add_filter('the_content', [
            $this,
            'authorBoxFrontEnd'
        ]);
        
    }

    /**
     * function to display author data box in post
     */
    public function authorBoxFrontEnd($content)
    {
        global $post;
        $data= (new AuthorData())->getAuthorData();
        $visibility= get_post_meta( $post->ID, 'um_author_box_visibility', true );
        
        /**
        * AUthor boxtheme selection
        */
        switch($data['position']){
            case 'plain':
                $box= (new DisplayBox())->stylePlain();
                break;
            default:
                $box= (new DisplayBox())->stylePlain();
        }
        
        /**
        * Attaching author box to the content
        */
        if( $data['in_page']== 'yes' && is_page() && $visibility!= 'no' ){
            ($data['position']== 'after') ? $content= $content.$box : $content= $box.$content;
        }
        
        if( $data['in_post']== 'yes' && is_single() && $visibility!= 'no' ){
            ($data['position']== 'after') ? $content= $content.$box : $content= $box.$content;
        }
        
        return $content;   
    }

}
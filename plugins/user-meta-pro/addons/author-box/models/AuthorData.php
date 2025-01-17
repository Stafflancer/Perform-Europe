<?php
namespace UserMeta\AuthorBox;

/**
 *
 * @since 2.4
 * @author Sourov Amin
 */
class AuthorData
{
    /**
    * To fetch author data
    */    
    public function getAuthorData(){
        $field = Base::getData();
        $data = [
        'id'=> get_the_author_meta('ID'),
        'email'=> get_the_author_meta('user_email'),
        'display_name' => get_the_author_meta('display_name'),
        'full_name' => get_the_author_meta('first_name').' '.get_the_author_meta('last_name') ,
        'avatar' => get_avatar( get_the_author_meta( 'ID' ), 110 ),
        'author_page' => get_author_posts_url( get_the_author_meta('ID') ),
        'bio' => isset($field['description']) ? get_the_author_meta($field['description']) : '',
        'designation' => isset($field['designation']) ? get_the_author_meta($field['designation']) : '',
        'contact_no' => isset($field['contact_no']) ? get_the_author_meta($field['contact_no']) : '',
        'portfolio' => isset($field['portfolio']) ? get_the_author_meta($field['portfolio']) : '',
        'facebook' => isset($field['facebook']) ? get_the_author_meta($field['facebook']) : '',
        'linkedin' => isset($field['linkedin']) ? get_the_author_meta($field['linkedin']) : '',
        'twitter' => isset($field['twitter']) ? get_the_author_meta($field['twitter']) : '',
        'theme' => isset($field['theme']) ? $field['theme'] : 'plain',
        'position' => isset($field['position']) ? $field['position'] : 'after',
        'name_type' => isset($field['name_type']) ? $field['name_type'] : 'display_name',
        'in_post' => isset($field['set_posts']) ? $field['set_posts'] : 'yes',
        'in_page' => isset($field['set_pages']) ? $field['set_pages'] : 'no',
        'recent_post' => isset($field['show_recent_post']) ? $field['show_recent_post'] : 'yes',
        'show_email' => isset($field['show_email']) ? $field['show_email'] : 'no',
        'show_number' => isset($field['show_contact_no']) ? $field['show_contact_no'] : 'no',
        'show_portfolio' => isset($field['show_portfolio']) ? $field['show_portfolio'] : 'yes',
        'show_facebook' => isset($field['show_facebook']) ? $field['show_facebook'] : 'yes',
        'show_linkedin' => isset($field['show_linkedin']) ? $field['show_linkedin'] : 'yes',
        'show_twitter' => isset($field['show_twitter']) ? $field['show_twitter'] : 'yes',
        ];
        
        return $data; 
    }
}
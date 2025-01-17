<?php
namespace UserMeta\AuthorBox;

/**
 * Display author box to front-end
 *
 * @since 2.4
 * @author Sourov Amin
 */
class DisplayBox
{   
    /*
     * Fetch data and initiate filter hook
     */
    public function fetchAuthorData(){
        $data = (new AuthorData())->getAuthorData();
        /*
         * Possible added data: $data[start, before_avatar, after_avatar, before_title, after_title, before_description, after_description, before_buttons, after_buttons, before_footer, after_footer, before_social, after_social, end] 
         */
        return apply_filters( 'user_meta_addon_author_box_display_data', $data );;
    }
    
    /*
    * Plain theme author box
    */
    public function stylePlain(){
        Base::enqueScript('plainBox.css');
        wp_enqueue_style('dashicons');
        $data = $this->fetchAuthorData();
       
        $html = null;

        /**
        * HTML to display Plain Author Box
        */
        $html .= '<div class="um-ab-style-box-plain">';
        
            $html .= '<div class="um-ab-body">';
                
                $html .= !empty( $data['start'] ) ? '<div>'.$data['start'].'</div>' : '';
                
                $html .='<span class="um-ab-avatar">';
                    $html .= !empty( $data['before_avatar'] ) ? '<div>'.$data['before_avatar'].'</div>' : '';
                    $html .= $data['avatar'];
                    $html .= !empty( $data['after_avatar'] ) ? '<div>'.$data['after_avatar'].'</div>' : '';
                $html .= '</span>';
                
                $html .='<span class="um-ab-description-body">';
                    $html .= '<div class="um-ab-title-designation">';
                        $html .= !empty( $data['before_title'] ) ? '<div>'.$data['before_title'].'</div>' : '';
                        $html .= ( $data['name_type'] == 'display_name' ) ? '<span class="um-ab-name">'.$data['display_name'].'</span>' : '<span class="um-ab-name">'.$data["full_name"].'</span>';
                        $html .= !empty( $data['designation'] ) ? '<span class="um-ab-designation">'.$data['designation'].'</span>' : '';
                        $html .= !empty( $data['after_title'] ) ? '<div>'.$data['after_title'].'</div>' : '';
                    $html .= '</div>';
                    $html .= '<div class="um-ab-description">';
                        $html .= !empty( $data['before_description'] ) ? '<div>'.$data['before_description'].'</div>' : '';
                        $html .= !empty( $data['bio'] ) ? $data['bio'] : '';
                        $html .= !empty( $data['after_description'] ) ? '<div>'.$data['after_description'].'</div>' : '';
                    $html .= '</div>';
                    if( $data['show_portfolio'] == 'yes' || $data['recent_post'] == 'yes' ){
                        $html .= '<div class="um-ab-portfolio-post">';
                            $html .= !empty( $data['before_buttons'] ) ? $data['before_buttons'] : '';
                            $html .= ( $data['show_portfolio'] == 'yes' ) ? !empty( $data['portfolio'] ) ? '<span class="um-ab-portfolio"><a href="'.$data['portfolio'].'" target="_parent"><button>Portfolio</button></a></span>' : '' : '';
                            $html .= ( $data['recent_post'] == 'yes' ) ? '<span class="um-ab-recent_post"><a href="'.$data['author_page'].'"><button>Author\'s Posts</button></a></span>' : '';
                            $html .= !empty( $data['after_buttons'] ) ? $data['after_buttons'] : '';
                        $html .= '</div>';
                    }
                $html .='</span>';
            $html .= '</div>';
            
            $html .= '<div class="um-ab-footer">';
                $html .= !empty( $data['before_footer'] ) ? $data['before_footer'] : '';
                if( $data['show_facebook'] == 'yes' || $data['show_linkedin'] == 'yes' || $data['show_twitter'] == 'yes' ){
                    $html .= '<span class="um-ab-social-link">';
                        $html .= !empty( $data['before_social'] ) ? $data['before_social'] : '';
                        $html .= ( $data['show_facebook'] == 'yes' ) ? !empty( $data['facebook'] ) ? '<span class="um-ab-social-icon"><a href="'.$data['facebook'].'"><span class="dashicons dashicons-facebook-alt"></span></a></span>' : '' : '';
                        $html .= ( $data['show_twitter'] == 'yes' ) ? !empty( $data['twitter'] ) ? '<span class="um-ab-social-icon"><a href="'.$data['twitter'].'"><span class="dashicons dashicons-twitter"></span></a></span>' : '' : '';
                        $html .= ( $data['show_linkedin'] == 'yes' ) ? !empty( $data['linkedin'] ) ? '<span class="um-ab-social-icon"><a href="'.$data['linkedin'].'"><span class="dashicons dashicons-linkedin"></span></a></span>' : '' : '';
                        $html .= !empty( $data['after_social'] ) ? $data['after_social'] : '';
                    $html .= '</span>';
                }
                $html .= ( $data['show_email'] == 'yes' ) ? !empty( $data['email'] ) ? '<span class="um-ab-email"><span class="um-ab-social-icon"><span class="dashicons dashicons-email-alt"></span></span><a href="mailto:'.$data['email'].'">'.$data['email'].'</a></span>' : '' : '';
                $html .= ( $data['show_number'] == 'yes' ) ? !empty( $data['contact_no'] ) ? '<span class="um-ab-number"><span class="um-ab-social-icon"><span class="dashicons dashicons-phone"></span></span>'.$data['contact_no'].'</span>' : '' : '';
                $html .= !empty( $data['after_footer'] ) ? $data['after_footer'] : '';
            $html.= '</div>';
            
            $html .= !empty( $data['start'] ) ? '<div>'.$data['end'].'</div>' : '';
            
        $html .= '</div>';
        
        return $html;
    }
}
<?php
namespace UserMeta\UserList;

/**
 * Display user list to frontend
 *
 * @since 2.1
 * @author Sourov Amin
 */
class DisplayList
{   
    /**
    * Get user data from the database
    */   
    private function userData($roles)
    {        
        if($roles == 'all'){
            return get_users();
        }
        
        $role_user = [];
        $role = explode(",", $roles);
        foreach($role as $role){
            $role_user = array_merge($role_user,get_users("role=$role"));
        }
        
        return $role_user;
        
    }
    
    /**
    * Return selected public profile page link
    */  
    private function getPageLink(){
        $data = Base::getData();
        return !empty($data['public_profile_page']) ? esc_url(get_permalink($data['public_profile_page'])) : '';
    }
    
    /*
     * Fetch extra columns and initiate filter hook
     */
    public function fetchExtraColumn(){
        $extra = [];
        /*
         * Apply filter to add extra column to the table
         * $extra[metekey] = 'Column Title'
         */
        return apply_filters( 'user_meta_addon_user_list_extra_columns', $extra );
    }
    
    /*
     * Get formatted fields data
     * Match shortcode fields id with available shared field id
     * Works for both fields and link-field options
     * Return value like $fields[$metaKey] = $fieldTitle
     */
    private function getFieldsData( $IDs ){
        if( empty($IDs) )
            return [];
        
        global $userMeta;
        $fieldsAvailable = $userMeta->getData('fields');
        $fieldIDs = explode(",", $IDs);
        $fields = [];
        foreach( $fieldIDs as $key => $id ){
            if ( empty($fieldsAvailable[$id]) )
                continue;
            $val = $fieldsAvailable[$id];
            $metaKey = !empty($val['meta_key']) ? $val['meta_key'] : $val['field_type'];
            $fieldTitle = ! empty($val['field_title']) ? $val['field_title'] : '';
            $fields[$metaKey] = $fieldTitle;  
        }
        return $fields;
    }
    
    /*
    * Display user data to the frontennd
    */ 
    public function displayAllUser( $caption, $roles, $fieldsID, $linkField ){
        /*
         * datatable JQuery plugin used for better table display
         * https://datatables.net/
         * Enque datatables jquery plugin's CSS
         */
        Base::enqueScript('datatables.min.css');
        
        global $userMeta;
        $pageLink = $this->getPageLink();
        $users = $this->userData($roles);
        $selectedFields = $this->getFieldsData($fieldsID);
        $extra = $this->fetchExtraColumn();
        $fields = $extra + $selectedFields;
        $linkMeta = $this->getFieldsData($linkField);
        $html = null;
        
        $html .= '<div style="overflow-x:auto;">';
            $html .= '<table class="um_addon_user_list_table" class="display">';
                if(!empty($caption)){$html .= '<caption style="text-align: center; font-size:25px; font-weight: bold; font-style: italic;">'.$caption.'</caption>';}
                if( empty($fields) ){
                    $html .= '<thead><tr>';
                        $html .= '<th>'.__('Avatar', $userMeta->name).'</th>';
                        $html .= '<th>'.__('User', $userMeta->name).'</th>';
                        $html .= '<th>'.__('First Name', $userMeta->name).'</th>';
                        $html .= '<th>'.__('Last Name', $userMeta->name).'</th>';
                        if( !empty($extra) ){
                            foreach($extra as $key => $title){
                                $html .= '<th>'.$title.'</th>';
                            }
                        }
                        
                    $html .= '</tr></thead>';
                    $html .= '<tbody>';
                    foreach($users as $user){
                        $html .= '</tr>';
                            $html .= '<td>'.get_avatar( $user->ID, 90 ).'</td>';
                            $html .= '<td><a href="'.$pageLink.'?user_id='.$user->ID.'">'.$user->display_name.'</a></td>';
                            $html .= '<td>'.$user->user_firstname.'</td>';
                            $html .= '<td>'.$user->user_lastname.'</td>';
                            if( !empty($extra) ){
                                foreach($extra as $key => $title){
                                    $html .= '<td>'.get_user_meta( $user->ID, $key, true ).'</td>';
                                }
                            }
                        $html .= '</tr>';
                    }
                    $html .= '<tbody>';
                }
                else{
                    
                    $html .= '<thead><tr>';
                        if( !empty($fields) ){
                            foreach($fields as $key => $title){
                                $html .= '<th>'.$title.'</th>';
                            }
                        }  
                    $html .= '</tr></thead>';
                    $html .= '<tbody>';
                    foreach($users as $user){
                        $html .= '</tr>';
                            if( !empty($fields) ){
                                foreach($fields as $key => $title){
                                    if( $key == 'user_avatar'){
                                        $content = get_avatar( $user->ID, 90 );
                                    }
                                    else{
                                        $content = $user->$key;
                                        if( is_array( $content ) ){
                                            $content = implode( ',', $content );
                                        }
                                    }
                                    
                                    if( !empty($linkMeta) ){
                                        if( array_key_exists($key, $linkMeta) ){
                                            $content = '<a href="'.$pageLink.'?user_id='.$user->ID.'">'.$content.'</a>';
                                        }
                                    }
                                    
                                    $html .= '<td>'.$content.'</td>';
                                }
                            }
                        $html .= '</tr>';
                    }
                    $html .= '<tbody>';   
                }
            $html .= '</table>';
        $html .= '</div>';
        
        Base::enqueScript('datatables.min.js');
        Base::enqueScript('implement-ul-table.js');

        return $html;
         
    }
       
}
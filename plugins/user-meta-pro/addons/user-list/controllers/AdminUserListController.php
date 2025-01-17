<?php
namespace UserMeta\UserList;

/**
 * Controller for backend admin user listing
 *
 * @since 2.1
 * @author Sourov Amin
 */
class AdminUserListController
{

    public function __construct()
    {
        add_filter('manage_users_columns', [
            $this,
            'modifyBackendUserTable'
        ]);
        
        add_filter('manage_users_custom_column', [
            $this,
            'modifyBackendUserTableRow'
        ], 10, 3);
        
        add_filter('manage_users_sortable_columns', [
            $this,
            'modifyBackendUserTableSortable'
        ]);

        add_action('pre_get_users', [
            $this,
            'modifyBackendUserTableOrder'
        ]);

        /* Removed temporarily from 2.4 as search function tends to break
        add_action('pre_user_query', [
            $this,
            'backendUserSearch'
        ]);
        */
        
    }
    
    private $defaultSearchColumns = [ 'user_login', 'user_url', 'user_email', 'user_nicename', 'display_name' ];
    
    /*
     * Get list of columns to be added
     */
    private function getAddColumnField(){
        global $userMeta;
        $fieldsAvailable = $userMeta->getData('fields');
        $data = Base::getData();
        $addFields = !empty( $data['backend_add_column'] ) ? $data['backend_add_column'] : [] ;
        
        return (new UMPFields())->getFormattedFields( $fieldsAvailable,$addFields );
    }
    
    /*
     * Get formatted list to search by added columns
     */
    private function searchByValues(){
        $data = [];
        $fields = $this->getAddColumnField();
        foreach ( $fields as $key => $val ){
            $mod = $key.'.meta_value';
            array_push( $data, $mod );
        }
        return $data;
    }
    
    /*
     * Get the list of default columns to be excludes
     */
    private function getExcludedColumns(){
        $data = Base::getData();
        return !empty( $data['backend_exclude_column']) ? $data['backend_exclude_column']: [];
    }
    
    /*
     * Add extra columns to user backend list
     */
    public function modifyBackendUserTable( $column ) {
        $fields = $this->getAddColumnField();
        $column = array_diff( $column, $this->getExcludedColumns() );
        return array_merge( $column, $fields);
    }
    
    /*
     * Add extra columns data to user backend list
     */
    public function modifyBackendUserTableRow( $value, $column_name, $user_id ) {
        $fields = $this->getAddColumnField();
        foreach( $fields as $key => $val ){
            if( $key == $column_name ){
                $content = get_the_author_meta( $key, $user_id );
                if( is_array( $content ) ){
                    $content = implode( ',', $content );
                }
                return $content;
            }
        }
        return $value;
    }
    
    /*
     * Make extra columns data sortable
     */
    public function modifyBackendUserTableSortable( $column ) {
        $fields = $this->getAddColumnField();
        $column = array_diff( $column, $this->getExcludedColumns() );
        return array_merge( $column, $fields);
    }

    /*
     * Make column sortable in a correct order
     * Added from 2.4
     */
    public function modifyBackendUserTableOrder( $query ){
        $fields = $this->getAddColumnField();
        foreach ( $fields as $key => $val ){
            if ( $val == $query->get( 'orderby' ) ) {
                $query->set( 'orderby', 'meta_value' );
                $query->set( 'meta_key', $key );
            }
        }
    }
        
    /*
     * Make extra columns data searchable
     * Removed temporarily from 2.4 as search function tends to break
    function backendUserSearch( $query ){
        $fields = $this->getAddColumnField();
        
        if ( $query->query_vars['search'] ){
            $search_query = trim( $query->query_vars['search'], '*' );
            if ( sanitize_key( $_REQUEST['s'] ) == strtolower( $search_query ) ){
                global $wpdb;
     
                foreach( $fields as $key => $val ){
                    $query->query_from .= " JOIN {$wpdb->usermeta} {$key} ON {$key}.user_id = {$wpdb->users}.ID AND {$key}.meta_key = '{$key}' ";
                }
                
                $search_by = array_merge( $this->defaultSearchColumns, $this->searchByValues() );

                $query->query_where = 'WHERE 1=1' . $query->get_search_sql( $search_query, $search_by, 'both' );
            }
        }
    }
    */
    
}
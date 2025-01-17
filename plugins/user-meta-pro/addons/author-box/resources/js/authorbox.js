/*
* JS for author box addon
* @since 2.4
* @author Sourov Amin
*/

jQuery(function() {
    umHideShowAuthorBoxField( 'show_contact_no', {
        yes : '#um_addon_author_box_contact_no'    
    } );
    umHideShowAuthorBoxField( 'show_portfolio', {
        yes : '#um_addon_author_box_portfolio'    
    } );
    umHideShowAuthorBoxField( 'show_facebook', {
        yes : '#um_addon_author_box_facebook'    
    } );
    umHideShowAuthorBoxField( 'show_linkedin', {
        yes : '#um_addon_author_box_linkedin'    
    } );
    umHideShowAuthorBoxField( 'show_twitter', {
        yes : '#um_addon_author_box_twitter'    
    } );
            
});
        
function umHideShowAuthorBoxField(fieldParent, fieldChild) {
    var fieldValue = jQuery('[name="' + fieldParent + '"]').val();
    jQuery.each( fieldChild, function( key, value ) {
        if( fieldValue == key ){
            jQuery(value).closest('p').show();
        }
        else{
            jQuery(value).closest('p').hide();
        }
    });
}
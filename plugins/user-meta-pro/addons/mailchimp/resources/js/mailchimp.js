/*
* JS for mailchimp addon
* @since 3.0
* @author Sourov Amin
*/

jQuery(function() {
    if(jQuery('#um_addon_mialchimp_list_selection_method').val() == 'field') {
        jQuery('#um_addon_mialchimp_list_selection_text').closest('p').hide();
    } else {
        jQuery('#um_addon_mialchimp_list_selection_field').closest('p').hide();
    }

    if(jQuery('#um_addon_mialchimp_tag_selection_method').val() == 'no') {
        jQuery('#um_addon_mialchimp_tag_selection_text').closest('p').hide();
        jQuery('#um_addon_mialchimp_tag_selection_field').closest('p').hide();
    } else if (jQuery('#um_addon_mialchimp_tag_selection_method').val() == 'field') {
        jQuery('#um_addon_mialchimp_tag_selection_text').closest('p').hide();
    } else {
        jQuery('#um_addon_mialchimp_tag_selection_field').closest('p').hide();
    }

    jQuery('#um_addon_mialchimp_list_selection_method').change(function(){
        if(jQuery('#um_addon_mialchimp_list_selection_method').val() == 'field') {
            jQuery('#um_addon_mialchimp_list_selection_field').closest('p').show();
            jQuery('#um_addon_mialchimp_list_selection_text').closest('p').hide();
        } else {
            jQuery('#um_addon_mialchimp_list_selection_field').closest('p').hide();
            jQuery('#um_addon_mialchimp_list_selection_text').closest('p').show();
        }
    });

    jQuery('#um_addon_mialchimp_tag_selection_method').change(function(){
        if(jQuery('#um_addon_mialchimp_tag_selection_method').val() == 'no') {
            jQuery('#um_addon_mialchimp_tag_selection_field').closest('p').hide();
            jQuery('#um_addon_mialchimp_tag_selection_text').closest('p').hide();
        } else if (jQuery('#um_addon_mialchimp_tag_selection_method').val() == 'field') {
            jQuery('#um_addon_mialchimp_tag_selection_field').closest('p').show();
            jQuery('#um_addon_mialchimp_tag_selection_text').closest('p').hide();
        } else {
            jQuery('#um_addon_mialchimp_tag_selection_field').closest('p').hide();
            jQuery('#um_addon_mialchimp_tag_selection_text').closest('p').show();
        }
    });

});
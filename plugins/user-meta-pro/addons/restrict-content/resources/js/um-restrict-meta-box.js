(function($){
    var userMetaAddon = userMetaAddon || {};

    userMetaAddon.restrictContent = {
        hideShowRestrictField: function() {
            var fieldValue = $('[name=um_restrict_content_display]').val();
            if (fieldValue == 'loggedin') {
                $('.um_restrict_content_roles_field').show();
            } else {
                $('.um_restrict_content_roles_field').hide();
            }
        }
    }

    $(function() {
        $('.um_restrict_content_field').multiselect({
            includeSelectAllOption: true,
            enableClickableOptGroups: true
        });
        userMetaAddon.restrictContent.umHideShowRestrictField();
    });
})(jQuery);
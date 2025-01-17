(function($){
    var userMetaAddon = userMetaAddon || {};

    userMetaAddon.sample = {
        init: function() {
            console.log("Hello from the sample addon");
            userMetaAddon.sample.exampleMethod();
        },
        exampleMethod: function() {
            console.log("Another log from the sample addon");
            // $('.example_class').show();
        }
    }

    $(function() {
        userMetaAddon.sample.init();
        // jQuery `$` notation  can be use here:
        // $('.example_class').show();
    });
})(jQuery);
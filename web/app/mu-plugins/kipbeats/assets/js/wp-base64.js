jQuery(document).on('click', '.compat-attachment-fields input[name=restore_base64]', function(e){
    var $id = jQuery(this).data('post-id');
    var $name = jQuery(this).data('att-name');
    //jQuery('.some-other-element').show();
    console.log($id);
    if (confirm('Are you sure you want to restore '+$id+' from base64?')) {
        jQuery.ajax({
            method: 'post',
            url: AjaxVar.ajaxurl,
            data: {
                post_id: $id,
                _name: $name,
                action: 'restore_base64', // add_action('wp_ajax_my_function', 'my_function');
            },
            success: function(data, textStatus) {
                console.log(data);
            }
        }).done(function(msg) {
            // Do something when done
            location.reload();
        });
    }
    e.preventDefault();
});


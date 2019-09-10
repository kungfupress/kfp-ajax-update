jQuery(document).ready(function($){
    $('.auto-update').blur(function(event){
        $.post(ajax_object.ajax_url, 
            {
                action:'kfp_ajax_update', 
                post_id:$(this).parents('tr').data('post_id'),
                post_excerpt: $(this).val(),
                nonce: ajax_object.ajax_nonce
            }, 
            function(response) {
                return true;
            });
        return false;
    });
});
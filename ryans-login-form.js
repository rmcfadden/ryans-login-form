jQuery(document).ready(function($) {
    $('ryans-login-form').on('submit', function(e){
        
        //$('form#login p.status').show().html(login_object.loadingmessage);
        
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajax_login_object.ajaxurl,
            data: { 
                'action': 'ryans-form-login',
                'username': $('ryans-login-form #username').val(), 
                'password': $('ryans-login-form #password').val(), 
                'nonce': $('ryans-login-form #nonce').val() },
            success: function(data){
                //$('form#login p.status').html(data.message);
                if (data.loggedin == true){
                    document.location.href = login_object.redirecturl;
                }
            }
        });
        e.preventDefault();
    });

});
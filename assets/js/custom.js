jQuery('#frmRegister').on('submit', function (e) {
    // alert("Hello! I am an alert box!!");
    jQuery('#email_error').html('');
    jQuery('#register_submit').attr('disabled', true);
    jQuery('#form_msg').html('Please Wait ...');
    jQuery.ajax({
        url: FRONT_SITE_PATH + 'login_register_submit',
        type: 'post',
        data: jQuery('#frmRegister').serialize(),
        success: function (result) {
            jQuery('#register_submit').attr('disabled', false);
            jQuery('#form_msg').html('');
            var data = jQuery.parseJSON(result);
            if (data.status == 'error') {
                jQuery('#' + data.field).html(data.msg);
            }
            if (data.status == 'success') {
                jQuery('#' + data.field).html(data.msg);
                jQuery('#frmRegister')[0].reset();
            }
        }
    });
    e.preventDefault();
});

jQuery('#frmLogin').on('submit', function (e) {
    // alert("Hello! I am an alert box!!");
    jQuery('#login_submit').attr('disabled', true);
    jQuery('#form_login_msg').html('Please Wait ...');
    jQuery.ajax({
        url: FRONT_SITE_PATH + 'login_register_submit',
        type: 'post',
        data: jQuery('#frmLogin').serialize(),
        success: function (result) {
            jQuery('#form_login_msg').html('');
            jQuery('#login_submit').attr('disabled', false);
            var data = jQuery.parseJSON(result);
            if (data.status == 'error') {
                jQuery('#form_login_msg').css("color", "#e02c2b");
                jQuery('#form_login_msg').html(data.msg);
            }
            if (data.status == 'success') {
                // jQuery('#form_login_msg').html(data.msg);
                window.location.href = 'shop';
            }
        }
    });
    e.preventDefault();
});

jQuery('#frmForgotPassword').on('submit', function (e) {
    jQuery('#forgot_submit').attr('disabled', true);
    jQuery('#form_forgot_msg').html('Please wait...');
    jQuery.ajax({
        url: FRONT_SITE_PATH + 'login_register_submit',
        type: 'post',
        data: jQuery('#frmForgotPassword').serialize(),
        success: function (result) {
            jQuery('#form_forgot_msg').html('');
            jQuery('#forgot_submit').attr('disabled', false);
            var data = jQuery.parseJSON(result);
            if (data.status == 'error') {
                jQuery('#form_forgot_msg').html(data.msg);
            }
            if (data.status == 'success') {
                jQuery('#form_forgot_msg').html(data.msg);
                //window.location.href='shop.php';
            }
        }

    });
    e.preventDefault();
});
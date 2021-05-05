jQuery(document).ready(function ($) {
    $('#book_settings').submit(function () {
        $('#submit').attr('disabled', true);
        $('#loading').show();
        data = {
            aad_nonce: aad_vars.aad_nonce
        };
        $.post(ajaxurl, data, function (response) {
            $('#loading').hide();
            $('#submit').attr('disabled', false);
        });
        return false;
    });
});
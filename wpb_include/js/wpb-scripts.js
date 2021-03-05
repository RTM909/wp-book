jQuery(document).ready(function ($) {
    $('input[type="text"]').on('input', function () {
        var c = this.selectionStart,
            r = /[^a-z0-9\s]/gi,
            v = $(this).val();
        if (r.test(v)) {
            $(this).val(v.replace(r, ''));
            c--;
        }
        this.setSelectionRange(c, c);
    });
});
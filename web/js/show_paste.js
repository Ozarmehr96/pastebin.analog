$(document).ready(function () {
    showPaste(paste, errors);
});
function showPaste(paste, errors) {
    if(errors.length !== 0)
    {
        window.location.href = "site/error"
    }
    else
    {
        $('#expiration_time').val(paste.expiration_time);

        $('#access_id').val(paste.access_id);
        $('#short_title').val(paste.short_title);
        $('#paste_text').val(paste.paste_text);
    }
}

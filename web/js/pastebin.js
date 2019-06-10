/**
 * Метод добавления пасты
 * @param short_title - короткое название пасты
 * @param paste_text - текст пасты
 * @param expiration_time - время действительности пасты
 * @param access_id - ИД ограничение доступа
 * После успешного добавления перенаправляет страницу на созданные URL пасты
 */
function addPaste(short_title, paste_text, expiration_time,access_id) {
    $.ajax({
        url: "pastebin/add-paste",
        type: 'POST',
        data : {
            short_title: short_title,
            paste_text: paste_text,
            expiration_time: expiration_time,
            access_id: access_id
        },
        success: function(result)
        {
            if(result.errors.length === 0)
            {
                window.location.href = '/'+ result.url;
            }
            else
            {
                alert(result.errors);
            }
        }
    });
}
$('#add_paste_button').click(function () {
    expiration_time = $('#expiration_time').val();
    access_id =  $('#access_id').val();
    short_title = $('#short_title').val();
    paste_text = $('#paste_text').val();
    addPaste(short_title, paste_text, expiration_time,access_id);
});
<?php

/* @var $this yii\web\View */

$this->title = 'Pastebin.Analog';
$this->registerJsVar('accesses', $accesses);
$this->registerJsVar('public_href_pastes', $public_href_pastes);
?>
<div class="site-index">
    <div class="container">
        <div class="col-md-4">
            <h2>Создание пасты</h2>
            <form>
                <div class="form-group" >
                    <label for="short_title">Короткое название пасты:</label>
                    <input type="text" class="form-control" placeholder="Введите название" name = "short_title" id = "short_title">
                    <label for="paste_text">Текст пасты:</label>
                    <textarea class="form-control" rows="5" id="paste_text" cols="50" style="max-width: 100%; max-height: 40%" ></textarea>
                    <label for="expiration_time">Время действительности:</label>
                    <select class="form-control" id="expiration_time">
                        <option value="10 minutes">10 мин</option>
                        <option value="1 hours">1 час</option>
                        <option value="3 hours">3 часа</option>
                        <option value="1 days">1 день часа</option>
                        <option value="1 week">1 неделя</option>
                        <option value="1 month">1 месяц</option>
                        <option value="-">Без ограничения</option>
                    </select>
                    <label for="access_id">Ограничение доступа:</label>
                    <select class="form-control" id="access_id">
                        <?php foreach ($accesses as $access) : ?>
                            <option value="<?php echo $access['id']; ?>"><?php echo $access['title_rus']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <button type="button" id="add_paste_button" class="btn btn-primary btn-block" style="margin-top: 10px">Создать</button>
                </div>
            </form>
        </div>
       <?php require_once __DIR__.'/last_pastes.php'; ?>
    </div>
</div>
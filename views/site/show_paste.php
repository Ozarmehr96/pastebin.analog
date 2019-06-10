<?php

/* @var $this yii\web\View */

$this->title = 'Просмотр пасты';
$this->registerJsVar('paste', $paste);
$this->registerJsVar('errors', $errors);
?>
<div class="site-index">

    <div class="container">
        <div class="col-md-4">
            <h2>Просмотр пасты</h2>
            <form>
                <div class="form-group" >
                    <label for="short_title">Короткое название пасты:</label>
                    <input type="text" class="form-control" placeholder="Введите название" name = "short_title" id = "short_title" readonly="readonly">
                    <label for="paste_text">Текст пасты:</label>
                    <textarea class="form-control" rows="5" id="paste_text" cols="50" style="max-width: 100%; max-height: 40%" readonly="readonly"></textarea>
                    <label for="expiration_time">Время действительности:</label>
                    <select class="form-control" id="expiration_time" readonly="readonly">
                        <option value="10 minutes">10 мин</option>
                        <option value="1 hours">1 час</option>
                        <option value="3 hours">3 часа</option>
                        <option value="1 days">1 день часа</option>
                        <option value="1 week">1 неделя</option>
                        <option value="1 month">1 месяц</option>
                        <option value="-">Без ограничения</option>
                    </select>
                    <label for="access_id">Ограничение доступа:</label>
                    <select class="form-control" id="access_id" readonly="readonly">
                        <?php foreach ($accesses as $access) : ?>
                            <option value="<?php echo $access['id']; ?>"><?php echo $access['title_rus']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </form>
        </div>
        <?php require_once __DIR__.'/last_pastes.php'; ?>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script>
    <?php echo require_once __DIR__."/../../web/js/show_paste.js";?>
</script>
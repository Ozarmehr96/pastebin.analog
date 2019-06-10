<?php
/**
 * Created by PhpStorm.
 * User: Озармехр
 * Date: 08.06.2019
 * Time: 14:32
 */

namespace app\controllers;
ob_start();
use Yii;
use app\models\Paste;
use yii\web\Controller;
use yii\web\Response;

class PastebinController extends Controller
{
    use Assistant;

    /**
     * Метод добавления пасты.
     * Метод добавляет пасту, и после добавляет доступ/ограничения для пасты.
     * @param $paste_text - текст пасты.
     * @param $short_title - короткое название для пасты.
     * @param $expiration_time - время действиетльности.
     * @return array - возвращает массив данных (возможные ошибки и ИД добавленных данных)
     */
    public function addPaste($paste_text, $short_title, $expiration_time, $access_id)
    {
        $errors = array();
        /**
         * Перед созданием пасты сгенерируем url для пасты
         * После генерации utl для пасты, проверяем БД, если такой url,
         * если такой utl уже сущетвует то, еще раз запусти метод герации url, до тех пор
         * пока не создается не существующий url в БД
         */
        $paste_basic = new PasteBasic();
        $url_paste = '';
        $is_create_hash = false;
        while ($is_create_hash == false)
        {
            $url_paste = $paste_basic->generatePasteUrl($short_title);
            $check_paste_url = Paste::findOne(['url' => $url_paste]);
            if(!$check_paste_url)
            {
                $is_create_hash = true;
            }
        }

        /**
         * Добавляем пасту в БД
         */
        $create_past_result = $paste_basic->AddPaste($short_title, $paste_text, $expiration_time, $url_paste);
        $paste_id = $create_past_result['paste_id'];
        $errors = $create_past_result['errors'];
        /**
         * Ограничение доступа пасты. Добавляем доступ/ограничения для пасты в БД
         */
        $paste_access_id = -1;
        if($paste_id !== -1)
        {
            $paste_access = (new PasteAccessBasic())->add($paste_id, $access_id);
            $errors = array_merge($errors, $paste_access['errors']);
            $paste_access_id = $paste_access['paste_access_id'];
        }
        else
        {
            $errors[] = "Ошибка создания пасты";
        }
        return array(
            'errors' => $errors,
            'paste_id' => $create_past_result['paste_id'],
            'paste_access_id' => $paste_access_id,
            'paste_url' => $url_paste
        );
    }

    /**
     * Метод добавления пасты по HTTP запросу
     */
    public function actionAddPaste()
    {
        $errors = array();
        $short_title = 'Без названия ';
        $expiration_time = '9999-12-12';
        $access_id = 1;
        $paste_url = '';
        $post = Yii::$app->request->post();
        if(isset($post['paste_text']) && $post['paste_text'] != "")
        {
            $paste_text = $post['paste_text'];
            if(isset($post['short_title']) && $post['short_title'] != '') $short_title = $post['short_title'];
            if(isset($post['expiration_time']) && $post['expiration_time'] != '') $expiration_time = $post['expiration_time'];
            if(isset($post['access_id']) && $post['access_id'] != '') $access_id = $post['access_id'];
            if($expiration_time == '-')
            {
                $expiration_time = '9999-12-12';
            }
            else
            {
                $expiration_time = $this->dateAdd($expiration_time);
            }
            $paste_add_res = $this->addPaste($paste_text, $short_title, $expiration_time, $access_id);
            $errors = $paste_add_res['errors'];
            $paste_url = $paste_add_res['paste_url'];
        }
        else
        {
            $errors[] = "Текст пасты не передан";
        }
        $result = array('errors' => $errors, 'url' => $paste_url);
        Yii::$app->response->format = Response::FORMAT_JSON;
        Yii::$app->response->data = $result;

    }

}
<?php
/**
 * Created by PhpStorm.
 * User: Озармехр
 * Date: 08.06.2019
 * Time: 15:04
 */

namespace app\controllers;
use app\models\Paste;
use yii\db\Query;

/**
 * Базовый класс по работе пастами в БД
 * Этот класс создан для того, чтобы при перегенерации модели, методы не удалялись.
 * Методы по дабавлению/редактирования пасты реализуются в этом классе.
 * При работе с пастой в части БД, вызываются эти базовые методы
 * Class PasteBasic
 * @package app\controllers
 */
class PasteBasic
{
    /**
     * Метод добавления пасты в таблицу paste.
     * @param $short_title - короткое название пасты
     * @param $paste_text - текст пасты
     * @param $expiration_time - время действительности пасты
     * @param $url - сгенерированный url пасты
     * @param int $status - статус пасты. Используется при выборке. По умолчанию 1
     * @return array|int
     */
    public function AddPaste($short_title, $paste_text, $expiration_time, $url, $status = 1, $date_time = 1)
    {
        $errors = [];
        $paste_id = -1;
        if($date_time === 1)
        {
            $date_time = date("Y-m-d H:i:s");
        }
        $paste = new Paste();
        $paste->short_title = $short_title;
        $paste->paste_text = $paste_text;
        $paste->paste_text = $paste_text;
        $paste->expiration_time = $expiration_time;
        $paste->status = $status;
        $paste->url = $url;
        $paste->date_create = $date_time;

        if($paste->save())
        {
            $paste_id = $paste->id;
        }
        else
        {
            $errors[] = "Ошибка сохранения пасты";
            $errors[] = $paste->errors;
        }
        return array('errors' => $errors, 'paste_id' => $paste_id);
    }

    /**
     * Метод генерирования хэша для пасты
     * @param $paste_short_title - короткое название пасты
     * @return string - созданный хэш/url
     */
    public function generatePasteUrl($paste_short_title)
    {
        $length = rand(10, 20);
        $symbols = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $symbols_len =  strlen($symbols);
        $random_hash_str = '';
        for($index = 0; $index < $length; $index++)
        {
            $random_key = rand(0,$symbols_len -1);
            $random_hash_str .= $symbols[$random_key];
        }
        return $random_hash_str;
    }

    /**
     * Метод получения пасты по Url
     * @param $url - хэш пасты
     * @return array|bool - массив данных
     */
    public static function getPasteByUrl($url)
    {
        $paste = (new Query())
            ->select([
                'paste_id',
                'short_title',
                'paste_text',
                'expiration_time',
                'url',
                'access_id'
            ])
            ->from('view_pastes')
            ->where(['url' => $url])
            ->one();
        return $paste;
    }
}
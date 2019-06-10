<?php
/**
 * Created by PhpStorm.
 * User: Озармехр
 * Date: 08.06.2019
 * Time: 19:16
 */

namespace app\controllers;

use app\models\PasteAccess;

class PasteAccessBasic
{
    /**
     * Базовый метод добавления доступа/ограничения для пасты в БД
     * @param $paste_id - внешний ключ пасты
     * @param $access_id - внешний ключ доступа/ограничения
     * @return array возвращает массив данных и ИД нового добавленного PasteAccess
     */
    public function add($paste_id, $access_id)
    {
        $errors = array();
        $paste_access_id = -1;
        $paste_access = new PasteAccess();
        $paste_access->paste_id = $paste_id;
        $paste_access->access_id = $access_id;
        if($paste_access->save())
        {
            $paste_access->refresh();
            $paste_access_id = $paste_access->id;
        }
        else
        {
            $errors[] = "Ошибка добавления ограничение доступа для пасты";
        }
        return array('errors' => $errors, 'paste_access_id' => $paste_access_id);
    }
}
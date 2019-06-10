<?php
/**
 * Created by PhpStorm.
 * User: Озармехр
 * Date: 08.06.2019
 * Time: 16:25
 */

namespace app\controllers;


use app\models\Access;

class AccessBasic
{
    /**
     * Метод добавление ограничения доступа
     * @param $title - название ограничени/доступа
     * @return array - массив данных
     */
    public function add($title)
    {
        $errors = array();
        $access_id = array();
        $access = new Access();
        $access->title = $title;
        if($access->save())
        {
            $access_id = $access->id;
        }
        else
        {
            $errors[] = "Ошибка сохранения ограничения доступа";
            $errors[] = $access->errors;
        }
        return array('errors' => $errors, 'access_id' => $access_id);
    }
}
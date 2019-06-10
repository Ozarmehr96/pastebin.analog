<?php
/**
 * Created by PhpStorm.
 * User: Озармехр
 * Date: 10.06.2019
 * Time: 9:21
 */

namespace app\controllers;

/**
 * Trait Assistant - для использования удобных функций
 * @package app\controllers
 */
trait Assistant
{
    /**
     * Метод вывода массива на экран. Испоьзуется для тестирования
     * @param $array
     * @param bool $die
     */
    public static function PrintR($array, $die = false)
    {
        echo '<pre>';
        print_r($array);
        echo '</pre>';
        if($die)
        {
            die("Остановил выполнения метода");
        }
    }

    /**
     * Метод получения Url без '/'. Метод находит последнего входжаемого слешаю,
     * и возвращает все что после него. Наппример '/user/paste/sdfd78sd7fsdf45' -> sdfd78sd7fsdf45
     * @return string полученная строка из url
     * @throws \yii\base\InvalidConfigException
     */
    public function getUrl()
    {
        $url = \Yii::$app->request->getUrl();
        $url = trim(mb_strrichr($url, '/'), '/');
        return $url;
    }

    /**
     * Метод добавления времени/дня/года/минуты в тек.дату
     * @param $time - дата и время
     * @return false|string возвращает новую дату
     */
    public function dateAdd($time)
    {
        date_default_timezone_set('Asia/Novokuznetsk');
        $date = date_create(date("Y-m-d H:i:s"));
        date_add($date, date_interval_create_from_date_string($time));
        return date_format($date, 'Y-m-d H:i:s');
    }

    /**
     * Метод возврата разницы 2 дат
     * @param $date_end - дата окончания
     * @param $date_start - дата начало
     * @return string - возвращает результат разницы дат в виде '1 days', '1 week' и тд
     */
    public function dateDiff($date_end , $date_start)
    {
        $datetime1 = date_create($date_end);
        $datetime2 = date_create($date_start);

        $interval = date_diff($datetime1, $datetime2);
        $years = $interval->y;
        $month = $interval->m;
        $days = $interval->days;
        $hours = $interval->h;
        $minutes = $interval->i;
        if ($years != 0)
        {
            if($years > 100)
            {
                return "-";
            }
        }
        if ($month != 0) return $month." month";
        if ($days != 0) return $days." days";
        if ($hours != 0) return $hours." hours";
        if ($minutes != 0) return $minutes." minutes";
    }
}
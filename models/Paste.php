<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "paste".
 *
 * @property int $id
 * @property string $short_title Короткое название
 * @property string $paste_text
 * @property string $date_create
 * @property int $status Статус пасты
 * @property string $expiration_time Время действительности
 * @property string $url URL пасты
 */
class Paste extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'paste';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['short_title', 'paste_text', 'date_create', 'expiration_time', 'url'], 'required'],
            [['paste_text'], 'string'],
            [['date_create', 'expiration_time'], 'safe'],
            [['status'], 'integer'],
            [['short_title', 'url'], 'string', 'max' => 255],
            [['url'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'short_title' => 'Короткое название',
            'paste_text' => 'Paste Text',
            'date_create' => 'Date Create',
            'status' => 'Статус пасты',
            'expiration_time' => 'Время действительности',
            'url' => 'URL пасты',
        ];
    }
}

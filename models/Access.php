<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "access".
 *
 * @property int $id
 * @property string $title Название
 *
 * @property PasteAccess[] $pasteAccesses
 * @property Paste[] $pastes
 */
class Access extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'access';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title'], 'string', 'max' => 255],
            [['title'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPasteAccesses()
    {
        return $this->hasMany(PasteAccess::className(), ['access_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPastes()
    {
        return $this->hasMany(Paste::className(), ['id' => 'paste_id'])->viaTable('paste_access', ['access_id' => 'id']);
    }
}

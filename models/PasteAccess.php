<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "paste_access".
 *
 * @property int $id
 * @property int $paste_id
 * @property int $access_id
 *
 * @property Access $access
 * @property Paste $paste
 */
class PasteAccess extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'paste_access';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['paste_id', 'access_id'], 'required'],
            [['paste_id', 'access_id'], 'integer'],
            [['paste_id', 'access_id'], 'unique', 'targetAttribute' => ['paste_id', 'access_id']],
            [['access_id'], 'exist', 'skipOnError' => true, 'targetClass' => Access::className(), 'targetAttribute' => ['access_id' => 'id']],
            [['paste_id'], 'exist', 'skipOnError' => true, 'targetClass' => Paste::className(), 'targetAttribute' => ['paste_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'paste_id' => 'Paste ID',
            'access_id' => 'Access ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccess()
    {
        return $this->hasOne(Access::className(), ['id' => 'access_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPaste()
    {
        return $this->hasOne(Paste::className(), ['id' => 'paste_id']);
    }
}

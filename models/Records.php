<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "records".
 *
 * @property int $id
 * @property int $form_id
 * @property int $user_id
 * @property string $create_at
 * @property string $update_at
 */
class Records extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'records';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['form_id', 'user_id'], 'required'],
            [['form_id', 'user_id'], 'integer'],
            [['create_at', 'update_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'form_id' => 'Form ID',
            'user_id' => 'User ID',
            'create_at' => 'Create At',
            'update_at' => 'Update At',
        ];
    }

    /**
     * {@inheritdoc}
     * @return RecordsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new RecordsQuery(get_called_class());
    }
}

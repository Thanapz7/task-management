<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "forms".
 *
 * @property int $id
 * @property int $user_id
 * @property string $form_name ชื่อแฟ้ม
 * @property string $create_at เวลาที่สร้าง
 * @property string $update_at เวลาที่อัปเดต
 */
class Forms extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'forms';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'form_name'], 'required'],
            [['user_id'], 'integer'],
            [['create_at', 'update_at'], 'safe'],
            [['form_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'form_name' => 'Form Name',
            'create_at' => 'Create At',
            'update_at' => 'Update At',
        ];
    }

    /**
     * {@inheritdoc}
     * @return FormsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new FormsQuery(get_called_class());
    }

    public function getRecords()
    {
        return $this->hasMany(Records::className(), ['form_id' => 'id']);
    }

    public function getFields()
    {
        return $this->hasMany(Fields::className(), ['form_id' => 'id']);
    }

    public function getUsers()
    {
        return $this-> hasOne(User::className(), ['id' => 'user_id']);
    }
}

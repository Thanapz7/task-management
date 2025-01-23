<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "field_filters".
 *
 * @property int $id
 * @property int $user_id
 * @property int $field_id
 * @property int $is_visible 1 = แสดง , 0 = ซ่อน
 */
class FieldFilters extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'field_filters';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'field_id', 'is_visible'], 'required'],
            [['user_id', 'field_id', 'is_visible'], 'integer'],
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
            'field_id' => 'Field ID',
            'is_visible' => 'Is Visible',
        ];
    }

    /**
     * {@inheritdoc}
     * @return FieldFiltersQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new FieldFiltersQuery(get_called_class());
    }
}

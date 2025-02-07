<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "field_filters".
 *
 * @property int $id
 * @property int $form_id
 * @property int $user_id
 * @property string $field_name
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
            [['user_id', 'is_visible', 'form_id'], 'required'],
            [['user_id', 'is_visible', 'form_id'], 'integer'],
            [['field_name'], 'string', 'max' => 255],
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
            'field_name' => 'Field Name',
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

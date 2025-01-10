<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "field_values".
 *
 * @property int $id
 * @property int $record_id
 * @property int $field_id
 * @property string $value ข้อมูลที่อยู่ในฟิลด์
 * @property string $create_at
 * @property string $update_at
 */
class FieldValues extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'field_values';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['record_id', 'field_id', 'value'], 'required'],
            [['record_id', 'field_id'], 'integer'],
            [['value'], 'string'],
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
            'record_id' => 'Record ID',
            'field_id' => 'Field ID',
            'value' => 'Value',
            'create_at' => 'Create At',
            'update_at' => 'Update At',
        ];
    }

    /**
     * {@inheritdoc}
     * @return FieldValuesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new FieldValuesQuery(get_called_class());
    }
}

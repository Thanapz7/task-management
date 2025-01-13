<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "fields".
 *
 * @property int $id
 * @property int $form_id
 * @property string $field_name ชื่อหัวตาราง
 * @property string|null $field_type  "date", "vachar", "text", "single_select", "muli_select", "image", "file", ...
 * @property string $create_at
 * @property string $update_at
 */
class Fields extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'fields';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['form_id', 'field_name'], 'required'],
            [['form_id'], 'integer'],
            [['create_at', 'update_at'], 'safe'],
            [['field_name', 'field_type'], 'string', 'max' => 255],
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
            'field_name' => 'Field Name',
            'field_type' => 'Field Type',
            'create_at' => 'Create At',
            'update_at' => 'Update At',
        ];
    }

    /**
     * {@inheritdoc}
     * @return FieldsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new FieldsQuery(get_called_class());
    }

    public function getFieldValues()
    {
        return $this->hasMany(FieldValues::className(), ['field_id' => 'id']);
    }
}

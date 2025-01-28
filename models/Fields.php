<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "fields".
 *
 * @property int $id
 * @property int $form_id
 * @property string $field_name ชื่อหัวตาราง
 * @property string|null $field_type  "date", "varchar", "text", "single_select", "muli_select", "image", "file", ...
 * @property string|null $options
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
            [['form_id', 'field_name', 'field_type', 'options'], 'required'],
            [['form_id', 'is_visible'], 'integer'],
            [['field_name', 'field_type'], 'string', 'max' => 255],
            [['options'], 'safe'],
            [['is_visible'], 'default', 'value' => 1],
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
            'options' => 'Options',
            'create_at' => 'Create At',
            'update_at' => 'Update At',
            'is_visible' => 'Is Visible',
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if(is_array($this->options)) {
                $this->options = json_encode($this->options);
            }
            return true;
        }
        return false;
    }

    public function afterFind()
    {
        parent::afterFind();
        $this->options = json_decode($this->options, true);
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
        return $this->hasOne(FieldValues::className(), ['field_id' => 'id']);
    }

    public function getForm()
    {
        return $this->hasOne(Forms::className(), ['id' => 'form_id']);
    }

}

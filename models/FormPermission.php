<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "form_permission".
 *
 * @property int $id
 * @property int $form_id
 * @property int $department_id
 * @property int $can_adddata 0=สามารถกรอกฟอร์มได้ ,1=กรอกฟอร์มไม่ได้
 */
class FormPermission extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'form_permission';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['form_id', 'department_id', 'can_adddata'], 'required'],
            [['form_id', 'department_id', 'can_adddata'], 'integer'],
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
            'department_id' => 'Department ID',
            'can_adddata' => 'Can Adddata',
        ];
    }

    /**
     * {@inheritdoc}
     * @return FormPermissionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new FormPermissionQuery(get_called_class());
    }
}

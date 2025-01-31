<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "form_view_permissions".
 *
 * @property int $id
 * @property int $form_id
 * @property int|null $department_id
 * @property int|null $user_id
 * @property string $allow_type
 * @property int|null $can_view
 *
 * @property Department $department
 * @property Forms $form
 * @property Users $user
 */
class FormViewPermissions extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'form_view_permissions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['form_id', 'allow_type'], 'required'],
            [['form_id', 'department_id', 'user_id', 'can_view'], 'integer'],
            [['allow_type'], 'string'],
            [['form_id'], 'exist', 'skipOnError' => true, 'targetClass' => Forms::class, 'targetAttribute' => ['form_id' => 'id']],
            [['department_id'], 'exist', 'skipOnError' => true, 'targetClass' => Department::class, 'targetAttribute' => ['department_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['user_id' => 'id']],
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
            'user_id' => 'User ID',
            'allow_type' => 'Allow Type',
            'can_view' => 'Can View',
        ];
    }

    /**
     * Gets query for [[Department]].
     *
     * @return \yii\db\ActiveQuery|DepartmentQuery
     */
    public function getDepartment()
    {
        return $this->hasOne(Department::class, ['id' => 'department_id']);
    }

    /**
     * Gets query for [[Form]].
     *
     * @return \yii\db\ActiveQuery|yii\db\ActiveQuery
     */
    public function getForm()
    {
        return $this->hasOne(Forms::class, ['id' => 'form_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery|UsersQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::class, ['id' => 'user_id']);
    }

    /**
     * {@inheritdoc}
     * @return FormViewPermissionsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new FormViewPermissionsQuery(get_called_class());
    }
}

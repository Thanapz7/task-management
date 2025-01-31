<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "department_submission_permissions".
 *
 * @property int $id
 * @property int $form_id
 * @property int $department_id
 * @property int|null $can_submit
 * @property string $create_at
 * @property string $update_at
 *
 * @property Department $department
 * @property Forms $form
 */
class DepartmentSubmissionPermissions extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'department_submission_permissions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['form_id', 'department_id'], 'required'],
            [['form_id', 'department_id', 'can_submit'], 'integer'],
            [['create_at', 'update_at'], 'safe'],
            [['form_id'], 'exist', 'skipOnError' => true, 'targetClass' => Forms::class, 'targetAttribute' => ['form_id' => 'id']],
            [['department_id'], 'exist', 'skipOnError' => true, 'targetClass' => Department::class, 'targetAttribute' => ['department_id' => 'id']],
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
            'can_submit' => 'Can Submit',
            'create_at' => 'Create At',
            'update_at' => 'Update At',
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
     * @return \yii\db\ActiveQuery|FormsQuery
     */
    public function getForm()
    {
        return $this->hasOne(Forms::class, ['id' => 'form_id']);
    }

    /**
     * {@inheritdoc}
     * @return DepartmentSubmissionPermissionsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new DepartmentSubmissionPermissionsQuery(get_called_class());
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->update_at = date('Y-m-d H:i:s');
            if ($this->isNewRecord) {
                $this->create_at = date('Y-m-d H:i:s');
            }
            return true;
        }
        return false;
    }

}

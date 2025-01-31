<?php
namespace app\models;

use Yii;
use yii\db\Query;
use yii\data\ActiveDataProvider;

class Forms extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'forms';
    }

    public function rules()
    {
        return [
            [['user_id', 'form_name'], 'required'],
            [['user_id'], 'integer'],
            [['create_at', 'update_at'], 'safe'],
            [['form_name'], 'string', 'max' => 255],
        ];
    }

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

    public function getUsers()
    {
        return $this->hasOne(Users::class, ['id' => 'user_id']);
    }

    public function getDepartment()
    {
        return $this->hasOne(Department::class, ['id' => 'department_id'])
            ->via('user'); // เชื่อมผ่าน user
    }

    public function getFields()
    {
        return $this->hasMany(Fields::class, ['form_id' => 'id']);
    }

    public function getDepartmentPermissions()
    {
        return $this->hasMany(DepartmentSubmissionPermissions::class, ['form_id' => 'id']);
    }

    public static function getFormsWithDepartments($departmentId)
    {
        return (new Query())
            ->select([
                'forms.id',
                'forms.form_name',
                'department.department_name', // ตรวจสอบว่าชื่อฟิลด์นี้ตรงกับฐานข้อมูล
            ])
            ->from('forms')
            ->innerJoin('department_submission_permissions', 'department_submission_permissions.form_id = forms.id')
            ->innerJoin('department', 'department.id = department_submission_permissions.department_id')
            ->where([
                'department_submission_permissions.department_id' => $departmentId,
                'department_submission_permissions.can_submit' => 1
            ])
            ->all();
    }

    public static function getFormWithUserAndDepartmentById($formId)
    {
        return (new Query())
            ->select([
                'forms.id',
                'forms.form_name',
                'department.department_name'
            ])
            ->from('forms')
            ->innerJoin('users', 'forms.user_id = users.id')
            ->innerJoin('department', 'users.department = department.id')
            ->where(['forms.id' => $formId]) // ใช้ where สำหรับฟิลด์ form_id
            ->one(); // เพราะว่า id จะต้องไม่ซ้ำกัน ใช้ one() เพื่อดึงแค่ 1 แถว
    }

    public function getViewPermissions()
    {
        return $this->hasMany(FormViewPermissions::class, ['form_id' => 'id']);
    }

    public function getViewDepartmentsPermissions()
    {
        return $this->hasMany(FormViewPermissions::class, ['form_id' => 'id'])->andWhere(['allow_type' => 'department']);
    }

    public static function getAccessibleForms($userId, $departmentId)
    {
        return (new Query())
            ->select(['forms.id', 'forms.form_name', 'department.department_name'])
            ->from('forms')
            ->innerJoin('form_view_permissions', 'forms.id = form_view_permissions.form_id')
            ->innerJoin('users', 'form_view_permissions.user_id = users.id')
            ->innerJoin('department', 'users.department = department.id')
            ->where(['or',
                ['users.id' => $userId],
                ['form_view_permissions.department_id' => $departmentId]
            ])
            ->all();
    }



}


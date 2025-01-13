<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $name ชื่อสมาชิก
 * @property string $lastname นามสกุล
 * @property string $username ชื่อผู้ใช้
 * @property string $password_hash รหัสผ่าน
 * @property int $department_id ไอดีแผนก
 * @property string|null $auth_key
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'lastname', 'username', 'password_hash', 'department_id'], 'required'],
            [['department_id'], 'integer'],
            [['name', 'lastname', 'password_hash', 'auth_key'], 'string', 'max' => 255],
            [['username'], 'string', 'max' => 150],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'lastname' => 'Lastname',
            'username' => 'Username',
            'password_hash' => 'Password Hash',
            'department_id' => 'Department ID',
            'auth_key' => 'Auth Key',
        ];
    }

    /**
     * {@inheritdoc}
     * @return UsersQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UsersQuery(get_called_class());
    }
    public function getDepartment()
    {
        return $this->hasOne(Department::class, ['id' => 'department_id']);
    }
}

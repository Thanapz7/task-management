<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $name ชื่อสมาชิก
 * @property string $lastname นามสกุล
 * @property string $username ชื่อผู้ใช้
 * @property string $password_hash รหัสผ่าน
 * @property int $department ไอดีแผนก
 * @property string|null $role admin, user
 * @property string|null $auth_key
 * @property string|null $access_token
 */
class Users extends \yii\db\ActiveRecord implements IdentityInterface
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
            [['name', 'lastname', 'username', 'password_hash', 'department'], 'required'],
            [['department'], 'integer'],
            [['name', 'lastname', 'password_hash', 'role', 'auth_key', 'access_token'], 'string', 'max' => 255],
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
            'department' => 'Department',
            'role' => 'Role',
            'auth_key' => 'Auth Key',
            'access_token' => 'Access Token',
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

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                // สร้าง auth_key อัตโนมัติ
                $this->auth_key = Yii::$app->security->generateRandomString();
            }
            // แฮชรหัสผ่านถ้าถูกแก้ไข
            if (!empty($this->password_hash)) {
                $this->password_hash = Yii::$app->security->generatePasswordHash($this->password_hash);
            }
            return true;
        }
        return false;
    }

    /**
     * Authentication methods
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

//    public function getDepartmentName()
//    {
//        return $this->hasOne(Department::class, ['id' => 'department']);
//    }

    public function getDepartment()
    {
        return $this->hasOne(Department::class, ['id' => 'department']);
    }


    public function getDepartmentRelation()
    {
        return $this->hasOne(Department::class, ['id' => 'department']);
    }

    public function getForms()
    {
        return $this->hasMany(Forms::class, ['user_id' => 'id']);
    }

    public function getFieldFilters()
    {
        return $this->hasMany(FieldFilters::class, ['user_id' => 'id']);
    }
}
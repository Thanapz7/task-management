<?php
namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface
{
    public static function tableName()
    {
        return 'users';
    }

    public function rules()
    {
        return [
            [['username', 'role'], 'required'],
            ['username', 'unique'],
            ['username', 'string', 'max' => 255],
            ['password_hash', 'string', 'max' => 255],
            ['role', 'string', 'max' => 255],
            ['password', 'string', 'min' => 6], // รหัสผ่านต้องมีอย่างน้อย 6 ตัวอักษร
        ];
    }


    public function attributeLabels()
    {
        return [
            'username' => 'Username',
            'password_hash' => 'Password',
            'role' => 'Role', // เพิ่มข้อความแสดงผลสำหรับ role
            'auth_key' => 'Auth Key',
            'department' => 'Department',
        ];
    }


    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    public function validatePassword($password)
    {
        return Yii::$app->getSecurity()->validatePassword($password, $this->password_hash);
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
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if (!empty($this->_password)) {
                $this->password_hash = Yii::$app->security->generatePasswordHash($this->_password);
            }
            if ($this->isNewRecord && empty($this->role)) {
                $this->role = 'user'; // กำหนดค่าเริ่มต้น
            }
            return true;
        }
        return false;
    }


    private $_password; // เก็บรหัสผ่านที่ยังไม่ถูกเข้ารหัส

    public function setPassword($password)
    {
        $this->_password = $password;
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    public function getPassword()
    {
        return $this->_password;
    }

    public function getDepartment()
    {
        return $this->hasOne(Department::className(), ['id' => 'department']);
    }

    public function getRecords()
    {
        return $this->hasMany(Records::className(), ['user_id' => 'id']);
    }

    public function getForms()
    {
        return $this->hasMany(Forms::className(), ['user_id' => 'id']);
    }

    public function getDepartmentRelation()
    {
        return $this->hasOne(Department::class, ['id' => 'department']);  // สมมติ department เป็น foreign key
    }
}


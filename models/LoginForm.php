<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\User;  // ใช้ User model สำหรับการดึงข้อมูลจากฐานข้อมูล

class LoginForm extends Model
{
    public $username;
    public $password;

    private $_user = false;

    // กฎการตรวจสอบข้อมูลที่กรอก
    public function rules()
    {
        return [
            [['username', 'password'], 'required'],  // ต้องกรอก username และ password
            ['password', 'validatePassword'],  // ตรวจสอบรหัสผ่าน
        ];
    }

    // ตรวจสอบรหัสผ่าน
    public function validatePassword($attribute)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !Yii::$app->security->validatePassword($this->password, $user->password_hash)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    // ค้นหาผู้ใช้จากฐานข้อมูล
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findOne(['username' => $this->username]);
        }

        return $this->_user;
    }

    // ฟังก์ชันล็อกอิน
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser());
        }
        return false;
    }
}

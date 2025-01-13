<?php

namespace app\controllers;

use app\models\Forms;
use app\models\LoginForm;
use app\models\User;
use Yii;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;

class HomeController extends Controller
{
    public function actionHome()
    {
        return $this->render('home');
    }

    public function actionWork()
    {
        $this->layout = 'layout';

        // ตรวจสอบว่าผู้ใช้ล็อกอินหรือไม่
        $user = Yii::$app->user->identity;
        $departmentName = $user->department;

        // ดึงข้อมูลของผู้ใช้ที่ล็อกอิน พร้อมข้อมูล Forms และ Department ที่เกี่ยวข้อง
        $data = User::find()
            ->joinWith(['forms', 'department']) // ความสัมพันธ์ต้องกำหนดในโมเดล User
            ->select(['users.id', 'forms.form_name', 'department.department_name']) // เลือกเฉพาะฟิลด์ที่ต้องการ
            ->where(['department.id' => $departmentName])
            ->asArray()
            ->all();

        return $this->render('work', ['data' => $data]);
    }

    public function actionEachWorkList()
    {
        $this->layout = 'layout';
        return $this->render('each-work-list');
    }

    public function actionEachWorkGallery()
    {
        $this->layout = 'layout';
        return $this->render('each-work-gallery');
    }

    public function actionEachWorkCalendar()
    {
        $this->layout = 'layout';
        return $this->render('each-work-calendar');
    }

    public function actionAddForm()
    {
        $this->layout = 'layout';
        return $this->render('add-form');
    }

    public function actionIndex()
    {
        $this->layout = 'blank';
        $model = new LoginForm();

        // ตรวจสอบการกรอกข้อมูลจากฟอร์ม
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            // ถ้าล็อกอินสำเร็จ, ไปที่หน้า home/home
            return $this->redirect(['home/work']);
        }

        // หากไม่สำเร็จ, กลับไปที่หน้า login
        return $this->render('login2', [
            'model' => $model,
        ]);
    }

    public function actionEachWork()
    {
        $this->layout = 'layout';
        return $this->render('each-work');
    }

    public function actionCreateForm()
    {
        $this->layout = 'blank_page';
        return $this->render('create-form');
    }

    public function actionFormSetting()
    {
        $this->layout = 'blank_page';
        return $this->render('form-setting');
    }

    public function actionLogin()
    {
        $model = new LoginForm();

        // ตรวจสอบการกรอกข้อมูลจากฟอร์ม
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            // ถ้าล็อกอินสำเร็จ, ไปที่หน้า home/home
            return $this->redirect(['home/work']);
        }

        // หากไม่สำเร็จ, กลับไปที่หน้า login
        return $this->render('login', [
            'model' => $model,
        ]);
    }

}

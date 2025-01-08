<?php

namespace app\controllers;

use app\models\LoginForm;
use Yii;
use yii\web\Controller;

class HomeController extends Controller
{
    public function actionHome()
    {
        return $this->render('home');
    }

    public function actionWork()
    {
        $this->layout = 'layout';
        return $this->render('work');
    }

    public function actionAddForm()
    {
        $this->layout = 'layout';
        return $this->render('add-form');
    }

    public function actionLogin2()
    {
        $this->layout = 'blank';
        return $this->render('login2');
    }

    public function actionEachWork()
    {
        $this->layout = 'layout';
        return $this->render('each-work');
    }

    public function actionIndex()
    {
        $model = new LoginForm();
        // ตรวจสอบการกรอกข้อมูลจากฟอร์ม
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            // ถ้าล็อกอินสำเร็จ, ไปที่หน้า home/work
            return $this->redirect(['home/work']);
        }
        // หากไม่สำเร็จ, กลับไปที่หน้า login
        return $this->render('login', [
            'model' => $model,
        ]);
    }

}

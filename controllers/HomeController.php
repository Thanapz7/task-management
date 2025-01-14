<?php

namespace app\controllers;

use app\models\Forms;
use app\models\LoginForm;
use app\models\User;
use Yii;
use yii\db\Query;
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

        return $this->render('work', [
            'data' => $data
        ]);
    }

    public function actionWorkDetail($id)
    {
        $this->layout = 'layout';

        $form = Forms::findOne($id);

        $query = (new Query())
            ->select([
                'records.id',
                'records.user_id',
                'fields.form_id',
                'fields.field_name',
                'field_values.value'
            ])
            ->from('records')
            ->innerJoin('fields', 'records.id = fields.form_id')
            ->innerJoin('field_values', 'field_values.id = fields.id')
            ->where(['records.id' => $id]);

        $result = $query->all();

        return $this->render('work-detail', [
            'form' => $form,
            'result' => $result,
        ]);
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

    public function actionPreviewTemplate()
    {
        $this->layout = 'layout';
        return $this->render('preview-template');
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

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->redirect(['./home']);
    }

}

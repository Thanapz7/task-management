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

    public function actionWorkDetailPreview() //id
    {
        $this->layout = 'blank_page';
        return $this->render('work-detail-preview', [

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
        if (Yii::$app->request->isPost) {
            // สร้างฟอร์มใหม่
            $model = new Forms();
            $model->form_name = 'form1'; // ชื่อฟอร์มค่าเริ่มต้น
            $model->user_id = Yii::$app->user->id; // ID ผู้ใช้ปัจจุบัน
            $model->create_at = date('Y-m-d H:i:s'); // เวลาที่สร้าง
            $model->update_at = date('Y-m-d H:i:s'); // เวลาที่อัปเดต

            // บันทึกฟอร์มใหม่
            if ($model->save()) {
                // รีไดเรกต์ไปยังหน้า create-form พร้อม id
                return $this->redirect(['home/create-form', 'id' => $model->id]);
            }

            // หากบันทึกไม่สำเร็จ ให้แสดงข้อความผิดพลาด
            Yii::$app->session->setFlash('error', 'ไม่สามารถสร้างฟอร์มได้');
            return $this->redirect(Yii::$app->request->referrer);
        }

        // โหลดฟอร์มที่มีอยู่
        $forms = Forms::find()
            ->select(['forms.*', 'users.department'])
            ->joinWith('users')
            ->where(['forms.id' => [1, 2, 3]])
            ->all();

        $this->layout = 'layout';

        return $this->render('add-form', [
            'forms' => $forms,
        ]);
    }


    public function actionCreateForm($id)
    {
        $form = Forms::findOne($id);

        if (!$form) {
            throw new \yii\web\NotFoundHttpException('Form not found.');
        }

        $this->layout = 'blank_page';
        return $this->render('create-form', [
            'form' => $form,
        ]);
    }

    public function actionDeleteForm($id)
    {
        $form = Forms::findOne($id);

        if (!$form) {
            throw new \yii\web\NotFoundHttpException('Form not found.');
        }
        if($form->delete()){
            Yii::$app->session->setFlash('success', 'ลบฟอร์มเรียบร้อย');
        } else {
            Yii::$app->session->setFlash('error', 'ไม่สามารถลบฟอร์มได้');
        }
        return $this->redirect(['home/add-form']);
    }

    //Login
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



    public function actionFormSetting()
    {
        $this->layout = 'blank_page';
        return $this->render('form-setting');
    }

    public function actionAssigned()
    {
        $this->layout = 'layout';

        $user = Yii::$app->user->identity;

        return $this->render('assigned',[
            'user' => $user]);
    }

    public function actionAssignment()
    {
        $this->layout = 'layout';
        return $this->render('assignment');
    }

    public function actionAssignmentForm()
    {
        $this->layout = 'layout';
        return $this->render('assignment-form',[

        ]);
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

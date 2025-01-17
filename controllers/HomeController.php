<?php

namespace app\controllers;

use app\models\Forms;
use app\models\LoginForm;
use app\models\Records;
use app\models\Users;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\View;

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
        $data = Users::find()
            ->joinWith(['forms', 'department']) // ความสัมพันธ์ต้องกำหนดในโมเดล User
            ->select(['users.id', 'forms.form_name', 'department.department_name']) // เลือกเฉพาะฟิลด์ที่ต้องการ
            ->where(['department.id' => $departmentName])
            ->asArray()
            ->all();

        return $this->render('work', ['data' => $data]);
    }

    public function actionWorkDetail($id, $viewType = 'table')
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
            'viewType' => $viewType,
        ]);
    }

    public function actionWorkDetailPreview() //id
    {
        $this->layout = 'blank_page';
        return $this->render('work-detail-preview', [

        ]);
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
            ->where(['forms.id' => [23, 24, 25]])
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

    public function actionFormSetting()
    {
        $this->layout = 'blank_page';
        return $this->render('form-setting');
    }

    public function actionAssigned()
    {
        $this->layout = 'layout';
        $user = Yii::$app->user->identity;
        $userId = Yii::$app->user->id;

        $query = Records::find()
            ->select([
                'records.create_at AS record_created_at',
                'records.id',
                'department.department_name',
                'forms.form_name',
            ])
            ->innerJoin('users', 'records.user_id = users.id')
            ->innerJoin('department', 'users.department = department.id')
            ->innerJoin('forms', 'records.form_id = forms.id')
            ->where(['records.user_id' => $userId])
            ->asArray();

        // ตรวจสอบว่า $query เป็น ActiveQuery
        if (!$query instanceof yii\db\ActiveQuery) {
            throw new \yii\base\InvalidConfigException('Query must be an instance of yii\db\ActiveQuery.');
        }

        // ใช้ ActiveDataProvider อย่างถูกต้อง
        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'attributes' => [
                    'record_created_at',
                    'department_name',
                    'form_name',
                ],
            ],
        ]);

        return $this->render('assigned',[
            'user' => $user,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionAssignedPreview($id)
    {
        $this->layout = 'layout';
        return $this->render('assigned-preview');
    }

    public function actionAssignment()
    {
        $this->layout = 'layout';
        $forms = Forms::getFormsWithDepartments();
        return $this->render('assignment',[
            'forms' => $forms,
        ]);
    }

    public function actionAssignmentForm($id)
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

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->redirect(['./home']);
    }

}

<?php

namespace app\controllers;

use app\models\Forms;
use app\models\LoginForm;
use app\models\Records;
use app\models\Users;
use Yii;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use app\widgets\DataDisplayWidget;
use yii\db\Query;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\View;
use Mpdf\Mpdf;

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
        // รับค่าจาก dropdown (ค่าเริ่มต้นเป็น 'table')
        $viewType = Yii::$app->request->get('viewType', 'table');
        // ค้นหาข้อมูลฟอร์มตาม ID
        $form = Forms::findOne($id);
        // การคิวรีข้อมูลที่เกี่ยวข้อง
        $query = (new \yii\db\Query())
            ->select([
                'fields.field_name',
                'field_values.value',
                'records.id AS record_id',
            ])
            ->from('forms')
            ->innerJoin('fields', 'forms.id = fields.form_id')
            ->innerJoin('records', 'forms.id = records.form_id')
            ->innerJoin('field_values', 'fields.id = field_values.field_id')
            ->where(['forms.id' => $id])
            ->andWhere('records.id = field_values.record_id')
            ->all();
//
//        $queryCal = (new \yii\db\Query())
//            ->select([
//                'records.id AS record_id',
//                'records.create_at',
//                'fields.id AS field_id',
//                'fields.field_name',
//                'records.form_id',
//                'field_values.value'
//            ])
//            ->from('records')
//            ->innerJoin('field_values', 'field_values.record_id = records.id')
//            ->innerJoin('fields', 'fields.id = field_values.field_id');
//
//        $results = $queryCal->all();

        if (empty($query)) {
            $formattedData = []; // ไม่มีข้อมูล ส่ง array ว่างไปแสดงผล
            $events = []; // กำหนดให้ events เป็น array ว่าง
        } else {
            // Pivot Data
            $pivotData = [];
            foreach ($query as $row) {
                $pivotData[$row['field_name']][] = $row['value'];
                // ตรวจสอบว่า record_id ถูกดึงมาถูกต้องหรือไม่
                if (isset($row['record_id'])) {
                    $recordIds[] = $row['record_id'];
                }
            }

            $maxRows = !empty($pivotData) ? max(array_map('count', $pivotData)) : 0;

            for ($i = 0; $i < $maxRows; $i++) {
                $row = [];
                foreach ($pivotData as $field => $values) {
                    $row[$field] = $values[$i] ?? null;  // ใช้ null หากไม่มีข้อมูล
                }
                $row['record_id'] = $recordIds[$i] ?? null;  // ใช้คีย์ record_id ปกติ
                $formattedData[] = $row;
            }

            // ตัวอย่างการสร้างข้อมูลเหตุการณ์ที่ส่งไปยัง FullCalendar
            $events = [];
            foreach ($formattedData as $data) {
                $startDate = null;
                if (!empty($data['event_start'])) {
                    $startDate = DateTime::createFromFormat('d/m/Y', $data['event_start']);
                    if (!$startDate) {
                        $startDate = DateTime::createFromFormat('m-d-Y', $data['event_start']);
                    }
                    if (!$startDate) {
                        $startDate = DateTime::createFromFormat('Y/m/d', $data['event_start']);
                    }
                    if ($startDate) {
                        $startDate = $startDate->format('Y-m-d\TH:i:s');
                    }
                }
                $endDate = null;
                if (!empty($data['event_end'])) {
                    $endDate = DateTime::createFromFormat('d/m/Y', $data['event_end']);
                    if (!$endDate) {
                        $endDate = DateTime::createFromFormat('m-d-Y', $data['event_end']);
                    }
                    if (!$endDate) {
                        $endDate = DateTime::createFromFormat('Y/m/d', $data['event_end']);
                    }
                    if ($endDate) {
                        $endDate = $endDate->format('Y-m-d\TH:i:s');
                    }
                }
                if (!$startDate) {
                    $startDate = date('Y-m-d\TH:i:s');
                }
                if (!$endDate) {
                    $endDate = date('Y-m-d\TH:i:s', strtotime('+1 hour'));
                }
                if (!empty($startDate) && !empty($endDate)) {
                    $events[] = [
                        'title' => $data['event_title'] ?? 'งานที่เข้ามา',
                        'start' => $startDate,
                        'end' => $endDate,
                    ];
                }
            }
        }
        // สร้าง data provider
        $dataProvider = new ArrayDataProvider([
            'allModels' => $formattedData,
            'pagination' => false,
        ]);
        // ส่งข้อมูลไปที่ view
        return $this->render('work-detail', [
            'form' => $form,
            'dataProvider' => $dataProvider,
//            'results' => $results,
            'viewType' => $viewType,
            'events' => $events,
        ]);
    }


// Action สำหรับดาวน์โหลด PDF
    public function actionDownloadPdf($record_id)
    {
        $record = Records::findOne($record_id);
        if (!$record) {
            throw new \yii\web\NotFoundHttpException('Record not found.');
        }

        // ดึงข้อมูลฟิลด์ที่เกี่ยวข้อง
        $data = (new \yii\db\Query())
            ->select(['fields.field_name', 'field_values.value'])
            ->from('field_values')
            ->innerJoin('fields', 'fields.id = field_values.field_id')
            ->where(['field_values.record_id' => $record_id])
            ->all();

        // แปลงข้อมูลให้อยู่ในรูปแบบที่อ่านง่าย
        $content = "<h2>Record Detail</h2><table border='1' cellpadding='5' cellspacing='0'>";
        $content .= "<tr><th>Field Name</th><th>Value</th></tr>";
        foreach ($data as $row) {
            $content .= "<tr>";
            $content .= "<td>" . Html::encode($row['field_name']) . "</td>";
            $content .= "<td>" . Html::encode($row['value']) . "</td>";
            $content .= "</tr>";
        }
        $content .= "</table>";

        // สร้างเอกสาร PDF ด้วย mPDF
        $mpdf = new Mpdf();
        $mpdf->WriteHTML($content);

        // ตั้งชื่อไฟล์ PDF
        $filename = "record_{$record_id}.pdf";

        // ส่งไฟล์ PDF ไปยังผู้ใช้
        return $mpdf->Output($filename, 'D');  // 'D' = force download
    }



    // Action สำหรับแสดงรายละเอียด
    public function actionViewDetails($id)
    {
        // แสดงรายละเอียดของ model
        $model = Forms::findOne($id);

        if ($model === null) {
            throw new \yii\web\NotFoundHttpException('The requested page does not exist.');
        }

        return $this->render('view-details', [
            'model' => $model,
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

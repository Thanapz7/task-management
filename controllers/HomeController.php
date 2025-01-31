<?php

namespace app\controllers;

use app\models\Department;
use app\models\DepartmentSubmissionPermissions;
use app\models\FieldValues;
use app\models\Fields;
use app\models\Forms;
use app\models\FormViewPermissions;
use app\models\LoginForm;
use app\models\Records;
use app\models\Users;
use DateTime;
use Yii;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use app\widgets\DataDisplayWidget;
use yii\db\Query;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\View;
use yii\web\Response;
use Mpdf\Mpdf;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;

class HomeController extends Controller
{

    public function actionHome()
    {
        return $this->render('home');
    }

    public function actionWork()
    {
        $this->layout = 'layout';
        $user = Yii::$app->user->identity; // ผู้ใช้ที่ล็อกอิน

        $data = (new \yii\db\Query())
            ->select([
                'forms.id',
                'forms.form_name',
                'department.department_name' // ดึงแผนกของผู้สร้างฟอร์ม
            ])
            ->from('forms')
            ->innerJoin('form_view_permissions', 'forms.id = form_view_permissions.form_id') // ตรวจสอบสิทธิ์
            ->leftJoin('users AS perm_user', 'form_view_permissions.user_id = perm_user.id') // ดึง user ที่ได้รับสิทธิ์
            ->leftJoin('department AS perm_dept', 'form_view_permissions.department_id = perm_dept.id') // ดึง department ที่ได้รับสิทธิ์
            ->innerJoin('users AS owner', 'forms.user_id = owner.id') // เชื่อม forms กับ users เพื่อดึงแผนกของฟอร์ม
            ->innerJoin('department', 'owner.department = department.id') // ดึงแผนกของผู้สร้างฟอร์ม
            ->where(['or',
                ['form_view_permissions.user_id' => $user->id], // เปรียบเทียบ user ที่ได้รับสิทธิ์
                ['form_view_permissions.department_id' => $user->department] // เปรียบเทียบ department ที่ได้รับสิทธิ์
            ])
            ->groupBy(['forms.id', 'department.department_name']) // ป้องกันข้อมูลซ้ำ
            ->all();


        // จัดข้อมูลในรูปแบบที่เหมาะสม
        $formattedData = [];
        foreach ($data as $item) {
            $formattedData[] = [
                'forms' => [
                    [
                        'id' => $item['id'],
                        'form_name' => $item['form_name'],
                    ]
                ],
                'department_name' => $item['department_name']
            ];
        }

        // ส่งข้อมูลไปยัง view
        return $this->render('work', ['data' => $formattedData]);
    }

    public function actionWorkDetail($id, $viewType = 'table')
    {
        $this->layout = 'layout';
        // รับค่าจาก dropdown (ค่าเริ่มต้นเป็น 'table')
        $viewType = Yii::$app->request->get('viewType', 'table');
        // ค้นหาข้อมูลฟอร์มตาม ID
        $form = Forms::findOne($id);

        // คิวรีข้อมูลฟิลด์ที่เกี่ยวข้อง
        $fields = (new \yii\db\Query())
            ->select(['field_name'])
            ->from('fields')
            ->innerJoin('forms', 'forms.id = fields.form_id') // เชื่อมกับตาราง forms
            ->where(['forms.id' => $id]) // กรองข้อมูลโดยใช้ form_id
            ->all();

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

        $queryRecordIds = (new \yii\db\Query())
            ->select(['records.id AS record_id'])
            ->from('forms')
            ->innerJoin('records', 'forms.id = records.form_id')
            ->where(['forms.id' => $id])
            ->orderBy(['records.id' => SORT_ASC])  // เรียงลำดับ record_id ให้ตรง
            ->all();

        $queryCal = (new \yii\db\Query())
            ->select(['fields.field_name', 'records.create_at', 'field_values.value'])
            ->from('forms')
            ->innerJoin('records', 'forms.id = records.form_id')
            ->innerJoin('field_values', 'records.id = field_values.record_id')
            ->innerJoin('fields', 'field_values.field_id = fields.id')
            ->where(['forms.id' => $id])
            ->groupBy(['field_values.record_id']) // เลือกค่าตัวแรกของแต่ละชุด
            ->orderBy(['field_values.record_id' => SORT_ASC]);

        $results = $queryCal->all();

        if (empty($query)) {
            $formattedData = []; // ไม่มีข้อมูล ส่ง array ว่างไปแสดงผล
            $events = []; // กำหนดให้ events เป็น array ว่าง
        } else {
            $recordIds = [];
            $pivotData = [];

            // Loop เพื่อจัดกลุ่มข้อมูลตาม record_id
            foreach ($query as $row) {
                // ตรวจสอบว่า row มี record_id และ field_name หรือไม่
                if (!isset($row['record_id']) || !isset($row['field_name'])) {
                    continue; // ข้ามกรณีที่ไม่มี record_id หรือ field_name
                }
                // การแปลงค่า value ถ้าเป็นสตริง
                if (isset($row['value']) && is_string($row['value'])) {
                    $row['value'] = str_replace(["\r", "\n"], '', $row['value']);  // ลบการขึ้นบรรทัดใหม่
                }
                // ตรวจสอบว่า pivotData[$row['record_id']] ถูกสร้างหรือยัง
                if (!isset($pivotData[$row['record_id']])) {
                    $pivotData[$row['record_id']] = [];
                }
                // ตรวจสอบชื่อฟิลด์ซ้ำ
                $fieldName = $row['field_name'];
                $originalFieldName = $fieldName;  // เก็บชื่อฟิลด์ต้นฉบับ
                // ตรวจสอบว่าฟิลด์มีชื่อซ้ำหรือไม่
                $count = 1;
                while (isset($pivotData[$row['record_id']][$fieldName])) {
                    // ถ้ามีชื่อซ้ำ ให้เพิ่มตัวเลขหรืออักษร
                    $fieldName = $originalFieldName . $count;
                    $count++;
                }
                // การแปลงค่า value ในกรณีที่เป็น JSON string
                $value = $row['value'];
                if (is_string($value)) {
                    $decodedValue = json_decode($value, true);
                    if (json_last_error() === JSON_ERROR_NONE && is_array($decodedValue)) {
                        // ถ้า value เป็น array จาก JSON จะทำการแปลงให้เป็น string ด้วย comma
                        $value = implode(', ', array_map(function ($item) {
                            return json_decode('"' . $item . '"');  // แปลงให้เป็น string ที่ถูกต้อง
                        }, $decodedValue));
                    } else {
                        // ถ้าเป็น string ธรรมดา แต่ไม่ใช่ JSON array ให้แปลงเป็น JSON string
                        $value = json_decode('"' . $value . '"') ?: $value;
                    }
                }
                // เพิ่มข้อมูลลงใน pivotData
                $pivotData[$row['record_id']][$fieldName] = $value;
                // เก็บ record_id
                $recordIds[] = $row['record_id'];
            }
            // คำนวณจำนวนแถวสูงสุดจาก pivotData
            $maxRows = !empty($pivotData) ? count($pivotData) : 0;
            // สร้าง formattedData โดยรวมข้อมูลจาก pivotData
            $formattedData = [];
            foreach ($pivotData as $recordId => $fields) {
                $row = [];
                // ตรวจสอบว่า fields เป็นอาร์เรย์หรือไม่ก่อนการเข้าถึง
                if (is_array($fields)) {
                    // นำข้อมูลจากแต่ละ field_name มาแสดง
                    foreach ($fields as $field => $value) {
                        $row[$field] = $value;
                    }
                }
                // เพิ่ม record_id ลงในแต่ละแถว
                $row['record_id'] = $recordId;

                // เพิ่ม row เข้าไปใน formattedData
                $formattedData[] = $row;
            }
            $events = [];
            foreach ($results as $data) {
                // ตรวจสอบว่า 'event_start' และ 'event_end' มีข้อมูลเป็น timestamp หรือ datetime
                // ตรวจสอบว่า 'event_start' และ 'event_end' เป็นรูปแบบ text ที่เก็บข้อมูลวันเดือนปี

                // การแปลง 'event_start' จากรูปแบบ 'DD/MM/YYYY' หรืออื่นๆ เป็น 'Y-m-d\TH:i:s'
                $startDate = null;
                $endDate = null;
                // กำหนดฟิลด์สำหรับวันที่เริ่มต้น
                $eventStartField = 'create_at'; // ใช้ create_at เป็นวันที่เริ่มต้น
                // จัดการวันที่เริ่มต้น
                if (!empty($data[$eventStartField])) {
                    $startDate = DateTime::createFromFormat('Y-m-d H:i:s', $data[$eventStartField]);
                    if ($startDate) {
                        $startDate = $startDate->format('Y-m-d\TH:i:s');
                    }
                }
                // การแปลง 'event_end' จากรูปแบบ 'DD/MM/YYYY' หรืออื่นๆ เป็น 'Y-m-d\TH:i:s'
                // กำหนดค่าเริ่มต้นหากไม่มี start
                if (!$startDate) {
                    $startDate = date('Y-m-d\TH:i:s');
                }
                // หากไม่มี endDate ให้กำหนดเป็น startDate + 1 ชั่วโมง
                $endDate = date('Y-m-d\TH:i:s', strtotime($startDate . ' +1 hour'));
                // เพิ่มข้อมูลใน events array
                $events[] = [
                    'title' => $data['value'] ?? 'งานที่เข้ามา',
                    'start' => $startDate,
                    'end' => $endDate,
                ];
            }

        }

        // สร้าง data provider
        $dataProvider = new ArrayDataProvider([
            'allModels' => $formattedData,
            'pagination' => [
                'pageSize' => 8,
            ],
        ]);
        // ส่งข้อมูลไปที่ view
        return $this->render('work-detail', [
            'form' => $form,
            'dataProvider' => $dataProvider,
            'results' => $results,
            'viewType' => $viewType,
            'events' => $events,
            'fields' => $fields,
        ]);
    }

        public function actionUpdateDepartment()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $data = Yii::$app->request->post();

        if (!isset($data['form_id']) || !isset($data['department_id'])) {
            return ['success' => false, 'message' => 'ข้อมูลไม่ครบถ้วน'];
        }

        $form = Forms::findOne($data['form_id']);
        if (!$form) {
            return ['success' => false, 'message' => 'ไม่พบฟอร์ม'];
        }

        $form->department_id = $data['department_id'];
        if ($form->save()) {
            return ['success' => true];
        } else {
            return ['success' => false, 'message' => 'ไม่สามารถอัปเดตข้อมูลได้'];
        }
    }


    public function actionWorkDetailPreview($id)
    {
        Yii::debug('Received ID from request: record_id ' . $id);

        $this->layout = 'blank_page';

        $queryinfo = (new \yii\db\Query())
            ->select(['records.create_at', 'users.username', 'users.name', 'users.lastname','users.department', 'department.department_name'])
            ->from('records')
            ->innerJoin('users', 'records.user_id = users.id')
            ->innerJoin('department', 'users.department = department.id')
            ->where(['records.id' => $id]);
        $resultsinfo = $queryinfo->all();


        $data = (new \yii\db\Query())
            ->select(['forms.form_name', 'fields.field_name', 'field_values.value', 'users.name AS user_name'])
            ->from('forms')
            ->innerJoin('records', 'forms.id = records.form_id')
            ->innerJoin('users', 'records.user_id = users.id')
            ->innerJoin('field_values', 'records.id = field_values.record_id')
            ->innerJoin('fields', 'field_values.field_id = fields.id')
            ->where(['field_values.record_id' => $id])
            ->all();

        if (empty($data)) {
            Yii::debug('No data found for record_id: ' . $id);
        }

        return $this->render('work-detail-preview', [
            'resultsinfo' => $resultsinfo,
            'data' => $data,
        ]);
    }

    public function actionAddForm()
    {
        if (Yii::$app->request->isPost) {
            $model = new Forms();
            $model->form_name = 'form1';
            $model->user_id = Yii::$app->user->id;
            $model->create_at = date('Y-m-d H:i:s');
            $model->update_at = date('Y-m-d H:i:s');

            if ($model->save()) {
                return $this->redirect(['home/create-form', 'id' => $model->id]);
            }

            Yii::$app->session->setFlash('error', 'ไม่สามารถสร้างฟอร์มได้');
            return $this->redirect(Yii::$app->request->referrer);
        }

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
            'formId' => $id,
        ]);
    }

    public function actionDeleteForm($id)
    {
        $form = Forms::findOne($id);

        if (!$form) {
            throw new \yii\web\NotFoundHttpException('Form not found.');
        }
        if ($form->delete()) {
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

    public function actionFormSetting($id)
    {
        $model = Forms::findOne($id);

        if (!$model) {
            throw new \yii\web\NotFoundHttpException('Form not found.');
        }

        $fields = Fields::find()->where(['form_id' => $id])->all();
        $departments = Department::find()->all();
        $users = Users::find()->all();

        $selectedDepartments = Yii::$app->request->post('departments', []);
        $selectAllDepartments = Yii::$app->request->post('departments_all', 0) == 1;
        $selectedViewDepartments = Yii::$app->request->post('view_departments', []);
        $selectedViewUsers = Yii::$app->request->post('view_users', []);

        if ($selectAllDepartments) {
            $selectedDepartments = array_column($departments, 'id');
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            // ลบข้อมูลเก่าก่อนเพื่อป้องกันข้อมูลซ้ำ
            DepartmentSubmissionPermissions::deleteAll(['form_id' => $model->id]);
            FormViewPermissions::deleteAll(['form_id' => $model->id]);

            // บันทึกสิทธิ์การกรอกข้อมูล (แผนก)
            foreach ($selectedDepartments as $departmentId) {
                $permission = new DepartmentSubmissionPermissions([
                    'form_id' => $model->id,
                    'department_id' => $departmentId,
                    'can_submit' => 1,
                ]);
                if (!$permission->save()) {
                    Yii::error($permission->errors);
                    Yii::$app->session->setFlash('error', 'ไม่สามารถบันทึกสิทธิ์การกรอกข้อมูลได้: ' . json_encode($permission->errors));
                }
            }

            // บันทึกสิทธิ์การดูข้อมูล (แผนกและผู้ใช้)
            foreach ($selectedViewDepartments as $departmentId) {
                $viewPermission = new FormViewPermissions([
                    'form_id' => $model->id,
                    'department_id' => $departmentId,
                    'allow_type' => 'department',
                    'can_view' => 1,
                ]);
                if (!$viewPermission->save()) {
                    Yii::error($viewPermission->errors);
                    Yii::$app->session->setFlash('error', 'ไม่สามารถบันทึกสิทธิ์การดูข้อมูลแผนกได้: ' . json_encode($viewPermission->errors));
                }
            }

            foreach ($selectedViewUsers as $userId) {
                $viewPermission = new FormViewPermissions([
                    'form_id' => $model->id,
                    'user_id' => $userId,
                    'allow_type' => 'user',
                    'can_view' => 1,
                ]);
                if (!$viewPermission->save()) {
                    Yii::error($viewPermission->errors);
                    Yii::$app->session->setFlash('error', 'ไม่สามารถบันทึกสิทธิ์การดูข้อมูลผู้ใช้ได้: ' . json_encode($viewPermission->errors));
                }
            }

            Yii::$app->session->setFlash('success', 'บันทึกข้อมูลสำเร็จ');
            return $this->redirect(['home/work']);
        } else {
            Yii::$app->session->setFlash('error', 'เกิดข้อผิดพลาด: ' . json_encode($model->getErrors()));
        }

        $this->layout = 'blank_page';

        return $this->render('form-setting', [
            'model' => $model,
            'form_id' => $id,
            'fields' => $fields,
            'departments' => $departments,
            'users' => $users,
            'selectedDepartments' => array_column($model->departmentPermissions, 'department_id'),
            'selectedViewUsers' => array_column($model->viewPermissions, 'user_id'),
            'selectedViewDepartments' => array_column($model->viewDepartmentsPermissions, 'department_id'),
        ]);
    }


    public function actionGetFields($id)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return Fields::find()
            ->where(['form_id' => $id])
            ->with('form')
            ->asArray()
            ->all();
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
                'creator_department.department_name AS creator_department_name', // department ของผู้สร้าง forms
                'department.department_name AS user_department_name', // department ของ user (records)
                'forms.form_name',
            ])
            ->innerJoin('users', 'records.user_id = users.id') // users ที่เชื่อมกับ records
            ->innerJoin('department', 'users.department = department.id') // department ของ user
            ->innerJoin('forms', 'records.form_id = forms.id') // เชื่อม forms กับ records
            ->innerJoin('users AS form_creator', 'forms.user_id = form_creator.id') // users ที่เป็นผู้สร้าง forms
            ->innerJoin('department AS creator_department', 'form_creator.department = creator_department.id') // department ของ form_creator
            ->where(['records.user_id' => $userId]) // เงื่อนไขการดึงข้อมูล
            ->asArray();


        // ตรวจสอบว่า $query เป็น ActiveQuery
        if (!$query instanceof yii\db\ActiveQuery) {
            throw new \yii\base\InvalidConfigException('Query must be an instance of yii\db\ActiveQuery.');
        }

        // ใช้ ActiveDataProvider อย่างถูกต้อง
        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 8,
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
        $user = Yii::$app->user->identity;
        $this->layout = 'layout';
        $query = (new \yii\db\Query())
            ->select([
                'fields.field_name',
                'field_values.value',
                'records.user_id'
            ])
            ->from('records')
            ->innerJoin('field_values', 'records.id = field_values.record_id')
            ->innerJoin('fields', 'field_values.field_id = fields.id')
            ->where(['records.id' => $id]);

        $queryinfo = (new \yii\db\Query())
            ->select([
                'forms.create_at',
                'forms.form_name',
                'department.department_name',
                'records.create_at AS created_at',
            ])
            ->from('records')
            ->innerJoin('forms', 'records.form_id = forms.id')
            ->innerJoin('users', 'forms.user_id = users.id')
            ->innerJoin('department', 'users.department = department.id')
            ->where(['records.id' => $id]);

        $results_info = $queryinfo->all();

        $results = $query->all();
        return $this->render('assigned-preview',[
            'user' => $user,
            'results' => $results,
            'results_info' => $results_info,
        ]);
    }

    public function actionAssignment()
    {
        $this->layout = 'layout';
        $userDepartmentId = Yii::$app->user->identity->department;

        // ดึงฟอร์มทั้งหมดที่สามารถส่งได้สำหรับแผนกของผู้ใช้
        $forms = Forms::getFormsWithDepartments($userDepartmentId);

        // เพิ่มข้อมูลแผนกในแต่ละฟอร์ม
        foreach ($forms as &$form) {
            // ส่ง formId ไปยังฟังก์ชันเพื่อดึงข้อมูลแผนก
            $departmentInfo = Forms::getFormWithUserAndDepartmentById($form['id']);
            // เพิ่มข้อมูลแผนกลงในฟอร์ม
            $form['department_name'] = $departmentInfo ? $departmentInfo['department_name'] : null;
        }

        // ส่งค่าฟอร์มที่มีข้อมูลแผนกไปยัง View
        return $this->render('assignment', [
            'forms' => $forms,
        ]);
    }

    public function actionAssignmentForm($id)
    {
        $this->layout = 'layout';

        // show form
        $form = Forms::find()
            ->select(['form_name', 'department.department_name'])
            ->innerJoinWith('users.department')
            ->where(['forms.id' => $id])
            ->asArray()
            ->one();

        // query fields
        $query = (new \yii\db\Query())
            ->select(['fields.id', 'fields.field_name', 'fields.field_type', 'fields.options'])
            ->from('forms')
            ->innerJoin('fields', 'forms.id = fields.form_id')
            ->where(['forms.id' => $id]);
        $fields = $query->all();

        if (Yii::$app->request->isPost) {
            // get form data
            $formData = Yii::$app->request->post('DynamicForm');

            // create new record
            $records = new Records();
            $records->form_id = $id;
            $records->user_id = Yii::$app->user->id;
            if (!$records->save()) {
                Yii::$app->session->setFlash('error', 'ไม่สามารถบันทึกข้อมูล Record ได้');
                return $this->redirect(['home/assignment']);
            }

            // save field values
            foreach ($fields as $field) {
                $fieldValue = new FieldValues();
                $fieldValue->record_id = $records->id;

                // ensure field_id exists
                if (!isset($field['id']) || empty($field['id'])) {
                    Yii::error("ไม่พบ field_id สำหรับฟิลด์ {$field['field_name']}", 'field-value-errors');
                    continue;
                }

                $fieldValue->field_id = $field['id'];

                // handle file upload fields
                if ($field['field_type'] === 'file') {
                    $file = UploadedFile::getInstanceByName("DynamicForm[{$field['id']}]");
                    if ($file) {
                        // upload the file
                        $filePath = $fieldValue->uploadFile($file, $records->id);
                        if ($filePath) {
                            $fieldValue->value = $filePath; // store the file path
                        } else {
                            Yii::error("ไม่สามารถบันทึกไฟล์สำหรับฟิลด์ {$field['field_name']}", 'file-upload');
                            continue;
                        }
                    }
                } else {
                    // save non-file data
                    if (isset($formData[$field['id']])) {
                        $fieldValue->value = is_array($formData[$field['id']])
                            ? json_encode($formData[$field['id']])  // handle array data (for checkboxes, multiple selections, etc.)
                            : $formData[$field['id']];  // for simple text, dropdown, etc.
                    } else {
                        Yii::$app->session->setFlash('error', "ฟิลด์ {$field['field_name']} ไม่มีข้อมูล");
                        continue;
                    }
                }

                // save the field value
                if (!$fieldValue->save()) {
                    Yii::debug($fieldValue->getErrors(), 'field-value-errors');
                    Yii::$app->session->setFlash('error', "เกิดข้อผิดพลาดในการบันทึกข้อมูลสำหรับฟิลด์ {$field['field_name']}");
                    return $this->redirect(['home/assignment']);
                }
            }

            // success message
            Yii::$app->session->setFlash('success', 'บันทึกข้อมูลสำเร็จ');
            return $this->redirect(['home/assigned']);
        }

        return $this->render('assignment-form', [
            'form' => $form,
            'fields' => $fields,
        ]);
    }


    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->redirect(['./home']);
    }

    public function actionField($id = null) {
        $this->layout='blank_page';
        if ($id === null) {
            $id = Yii::$app->request->post('id');
        }

        if (!$id || !($form = Forms::findOne($id))) {
            throw new \yii\web\NotFoundHttpException('Form not found.');
        }

        if (Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;


            $postDataRaw = Yii::$app->request->post('fields', '');
            Yii::debug($postDataRaw, 'debug_raw_fields');

            $postData = json_decode($postDataRaw, true);

            if (!is_array($postData)) {
                return [
                    'success' => false,
                    'message' => 'Invalid JSON format',
                    'debug' => $postDataRaw
                ];
            }

            if (empty($postData)) {
                return [
                    'success' => false,
                    'message' => 'No valid field data provided.',
                    'debug' => $postData
                ];
            }

            Yii::debug($postData, 'debug_postData');

            foreach ($postData as $field) {
                if (!is_array($field) || !isset($field['label'], $field['type'])) {
                    return [
                        'success' => false,
                        'message' => 'Invalid field data provided.',
                        'debug' => $field
                    ];
                }

                $model = new Fields();
                $model->form_id = $id;
                $model->field_name = $field['label'];
                $model->field_type = $field['type'];
                $model->options = isset($field['options']) ? json_encode($field['options']) : null;

                if (!$model->save()) {
                    return ['success' => false, 'errors' => $model->errors];
                }
            }

            return $this->redirect(['home/form-setting', 'id' => $id]);
        }

        return $this->render('create-form', ['form' => $form, 'formId' => $id]);
    }

//    public function actionUpdateForms($id)
//    {
//        $model = Forms::findOne($id);
//
//
//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            Yii::$app->session->setFlash('success', 'บันทึกข้อมูลสำเร็จ!');
//        }
//
//        return $this->render('form-setting', [
//            'model' => $model,
//        ]);
//    }

}

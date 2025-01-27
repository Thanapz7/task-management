<?php

namespace app\controllers;

use app\models\FieldValues;
use app\models\Forms;
use app\models\Records;
use app\models\Users;
use Yii;
use yii\web\Controller;
use yii\web\UploadedFile;

class JobController extends Controller
{
    public function actionAssignment()
    {
        $this->layout = 'layout';
        $forms = Forms::getFormsWithDepartments();
        return $this->render('assignment',[
            'forms' => $forms
        ]);
    }

    public function actionAssignmentForm($id) // form_id
    {
        $this->layout = 'layout';
        // ค้นหาฟอร์ม
        $form = Forms::find()
            ->select(['form_name', 'department.department_name'])
            ->innerJoinWith('users.department')
            ->where(['forms.id' => $id])
            ->asArray()
            ->one();

        if (!$form) {
            Yii::$app->session->setFlash('error', 'ไม่พบฟอร์มที่ต้องการ');
            return $this->redirect(['home/index']);
        }

        // ค้นหา fields ที่เกี่ยวข้องกับฟอร์ม
        $fields = (new \yii\db\Query())
            ->select(['fields.id', 'fields.field_name', 'fields.field_type', 'fields.options'])
            ->from('forms')
            ->innerJoin('fields', 'forms.id = fields.form_id')
            ->where(['forms.id' => $id])
            ->all();
        if (Yii::$app->request->isPost) {
            $formData = Yii::$app->request->post('DynamicForm');

            // เริ่ม transaction
            $transaction = Yii::$app->db->beginTransaction();

            try {
                // สร้างผู้ใช้ภายนอกในตาราง users
                $user = new Users();
                $user->name = 'Guest'; // ใช้ default value
                $user->lastname = 'Guest'; // ใช้ default value
                $user->username = 'Guest';
                $user->password_hash = Yii::$app->security->generatePasswordHash(Yii::$app->security->generateRandomString());
                $user->department = 99; // ไม่มี department
                $user->role = 'guest'; // ระบุ role เป็น guest
                $user->auth_key = Yii::$app->security->generateRandomString(); // สร้างโค้ดแบบสุ่ม
                $user->access_token = null; // ไม่จำเป็นสำหรับ guest

                if (!$user->save()) {
                    var_dump($user->errors);
                    throw new \Exception('ไม่สามารถบันทึกข้อมูลผู้ใช้ภายนอก');
                }
                // สร้าง record ในตาราง records
                $records = new Records();
                $records->form_id = $id;
                $records->user_id = $user->id; // อ้างอิง user_id ของผู้ใช้ภายนอก

                if (!$records->save()) {
                    throw new \Exception('ไม่สามารถบันทึกข้อมูล Records');
                }

                foreach ($fields as $field) {
                    // ตรวจสอบว่ามีค่าของฟิลด์นั้นใน $formData หรือไม่
                    if (isset($formData[$field['id']]) && !empty($formData[$field['id']])) {
                        $fieldValue = new FieldValues();
                        $fieldValue->record_id = $records->id;
                        $fieldValue->field_id = $field['id'];

                        // ตรวจสอบว่าเป็นฟิลด์ประเภทไฟล์
                        if ($field['field_type'] === 'file') {
                            // จัดการไฟล์
                            $file = UploadedFile::getInstanceByName("DynamicForm[{$field['id']}]");
                            if ($file) {
                                $filePath = 'uploads/' . uniqid() . '_' . $file->baseName . '.' . $file->extension;
                                $uploadPath = Yii::getAlias('@webroot/uploads');

                                if (!is_dir($uploadPath)) {
                                    \yii\helpers\FileHelper::createDirectory($uploadPath, 0775, true);
                                }

                                if ($file->saveAs(Yii::getAlias('@webroot/') . $filePath)) {
                                    $fieldValue->value = $filePath;
                                } else {
                                    // ถ้ามีข้อผิดพลาดในการอัปโหลดไฟล์ ให้ข้ามการบันทึกไฟล์นั้น
                                    continue;
                                }
                            }
                        } else {
                            // สำหรับฟิลด์ที่ไม่ใช่ไฟล์
                            $fieldValue->value = is_array($formData[$field['id']])
                                ? json_encode($formData[$field['id']])
                                : $formData[$field['id']];
                        }

                        // บันทึก FieldValues
                        if (!$fieldValue->save()) {
                            // ถ้าบันทึกไม่สำเร็จ ให้ข้ามไปไม่ให้ล้มเหลวทั้งหมด
                            Yii::$app->session->setFlash('error', 'ไม่สามารถบันทึกข้อมูล Field Values');
                            continue;
                        }
                    }
                }


                $transaction->commit();
                Yii::$app->session->setFlash('authKey', $user->auth_key);
                Yii::$app->session->setFlash('success', 'บันทึกข้อมูลสำเร็จ');
                return $this->render('assignment-form', [
                    'form' => $form,
                    'fields' => $fields,
                    'id' => $id,
                ]);
//                return $this->render('job/assigned', [
//                    'externalCode' => $user->auth_key, // ส่ง auth_key ให้ผู้ใช้
//                ]);
            } catch (\Exception $e) {
                $transaction->rollBack();
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('assignment-form', [
            'form' => $form,
            'fields' => $fields,
            'id' => $id,
        ]);
    }

    public function actionAssigned()
    {
        $this->layout = 'layout';

        $authKey = Yii::$app->request->get('auth_key');
        $record = null;

        if($authKey) {
            $user = Users::find()
                ->where(['auth_key' => $authKey])
                ->one();

            if($user){
                $query = (new \yii\db\Query())
                    ->select([
                        'fields.field_name',
                        'field_values.value',
                        'records.user_id',
                    ])
                    ->from('records')
                    ->innerJoin('field_values', 'records.id = field_values.record_id')
                    ->innerJoin('fields', 'field_values.field_id = fields.id')
                    ->where(['records.user_id' => $user->id]);

                $record = $query->all();
            }else{
                Yii::$app->session->setFlash('error', 'ไม่พบข้อมูลที่ตรงกับ คีย ที่ระบุ');
            }
        }

        return $this->render('assigned',[
            'authKey' => $authKey,
            'record' => $record,
        ]);
    }

    public function actionLogout()
    {
        return $this->redirect(['./home']);
    }
}
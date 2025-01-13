<?php

namespace app\controllers;

use app\models\Department;
use app\models\Users;
use app\models\UsersSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UsersController implements the CRUD actions for Users model.
 */
class UsersController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Users models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new UsersSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Users model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Users model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Users();
        $departments = Department::find()
            ->select(['id', 'department_name'])
            ->orderBy(['department_name' => SORT_ASC]) // จัดเรียงชื่อ
            ->asArray()
            ->all();

        if ($model->load(Yii::$app->request->post())) {
            $model->password_hash = Yii::$app->security->generatePasswordHash($model->password_hash); // แปลงรหัสผ่านเป็น hash
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                Yii::$app->session->setFlash('error', 'Failed to save user.');
                Yii::error('Failed to save user: ' . json_encode($model->errors));
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'departments' => $departments,
        ]);
    }
    /**
     * Updates an existing Users model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $departments = Department::find()
            ->select(['id', 'department_name'])
            ->orderBy(['department_name' => SORT_ASC])
            ->asArray()
            ->all();

        // เก็บค่ารหัสผ่านเดิมก่อนโหลดข้อมูลใหม่
        $originalPasswordHash = $model->password_hash;

        if ($model->load(Yii::$app->request->post())) {
            // ตรวจสอบว่าผู้ใช้กรอกรหัสผ่านใหม่หรือไม่
            if (!empty($model->password_hash)) {
                // แปลงรหัสผ่านใหม่เป็น hash
                $model->password_hash = Yii::$app->security->generatePasswordHash($model->password_hash);
            } else {
                // หากไม่มีการแก้ไขรหัสผ่าน ใช้ค่ารหัสผ่านเดิม
                $model->password_hash = $originalPasswordHash;
            }
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                Yii::$app->session->setFlash('error', 'Failed to update user.');
            }
        }
        return $this->render('update', [
            'model' => $model,
            'departments' => $departments, // ส่งตัวแปรไปยัง View
        ]);
    }


    /**
     * Deletes an existing Users model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Users model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Users the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Users::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

<?php
namespace app\controllers;

use app\models\UserSearch;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use app\models\User;
use yii\web\NotFoundHttpException;

class UserController extends Controller
{
    public function actionCreate()
    {
        $model = new User();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'User created successfully.');
            return $this->redirect(['home/index']);
        }

        return $this->render('create', ['model' => $model]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            // ตรวจสอบว่ามีการกรอกรหัสผ่านใหม่หรือไม่
            $password = Yii::$app->request->post('User')['password'] ?? null;
            if (!empty($password)) {
                // ตั้งค่ารหัสผ่านใหม่และเข้ารหัสผ่าน setPassword()
                $model->setPassword($password);
            }

            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'User updated successfully.');
                return $this->redirect(['user/index']);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }


    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionIndex()
    {
        // ใช้ ActiveDataProvider สำหรับ GridView
        $dataProvider = new ActiveDataProvider([
            'query' => User::find(),
            'pagination' => [
                'pageSize' => 10, // จำนวนรายการต่อหน้า
            ],
            'sort' => [
                'attributes' => ['id', 'username', 'role'], // คอลัมน์ที่สามารถจัดเรียงได้
            ],
        ]);

        return $this->render('view-all', [
            'dataProvider' => $dataProvider,
        ]);
    }
}

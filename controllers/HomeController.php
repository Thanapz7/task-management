<?php

namespace app\controllers;

use yii\web\Controller;

class HomeController extends Controller
{
    public function actionIndex()
    {
        return $this->render('login');
    }

    public function actionHome()
    {
        return $this->render('home');
    }
}

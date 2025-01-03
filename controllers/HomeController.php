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
}

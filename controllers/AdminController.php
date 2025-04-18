<?php

namespace app\controllers;

use yii\web\Controller;

class AdminController extends Controller
{
    public $layout = 'admin';

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionDashboard()
    {
        return $this->render('dashboard');
    }
} 
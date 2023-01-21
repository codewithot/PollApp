<?php


namespace app\controllers;


use yii\web\Controller;

class TestController extends Controller
{
    public function actionAbout()
    {
        $this->view->params['sharedVariable'] = 'i am shared';
       return $this->render('about', [
           'a' => 1,
           'b' => 2
       ]);
    }
}
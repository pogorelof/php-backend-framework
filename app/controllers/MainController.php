<?php

namespace app\controllers;
use watch\App;

class MainController extends AppController
{
    public function indexAction()
    {
        $this->setMeta(App::$app->getProperty('shop_name'), 'Главная страница сайта', 'HTML, PHP, main, page');
        $name = 'Vladimir';
        $age = 21;
        $this->set(compact('name', 'age'));
    }
}
<?php

namespace app\controllers;
use watch\App;

class MainController extends AppController
{
    public function indexAction()
    {
        $this->setMeta(App::$app->getProperty('shop_name'), 'Главная страница сайта', 'HTML, PHP, main, page');

        $posts = \R::findAll('test');
        $this->set(compact('posts'));
    }
}
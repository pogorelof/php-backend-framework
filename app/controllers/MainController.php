<?php

namespace app\controllers;
use watch\App;
use watch\Cache;

class MainController extends AppController
{
    public function indexAction()
    {
        $this->setMeta(App::$app->getProperty('shop_name'), 'Главная страница сайта', 'HTML, PHP, main, page');

        $posts = \R::findAll('test');
        $this->set(compact('posts'));

        $names = ['Vladimir', 'Malika'];

        $cache = Cache::instance();
//        $cache->set('test', $names);
//        $cache->delete('test');
        $data = $cache->get('test');
        debug($data);
    }
}
<?php

namespace app\controllers;

use app\models\AppModel;
use watch\base\Controller;

//Основной класс контроллера наследуемый от абстрактного класса Controller в vendor/watch/core
class AppController extends Controller
{
    //Все остальные контроллеры наследуются от этого, поэтому общий функционал всех контроллеров задается
    //в этом конструкторе
    public function __construct($route)
    {
        //Запуск родительского конструктор
        parent::__construct($route);
        //Инициализация бд
        new AppModel();
    }
}
<?php

namespace watch;

//инициализирующий класс
class App
{
    public static $app;

    public function __construct()
    {
        //получение подстроки адреса
        $query = trim($_SERVER['QUERY_STRING'], '/');
        //включение сессии
        session_start();
        //получаем параметры из окружение, сначала получаем объект класса Реестр(Registry)
        self::$app = Registry::instance();
        //затем с помощью нижеизложенного метода получаем параметры из файла
        $this->getParams();
        //вызываем обработчик ошибок
        new ErrorHandler();
        //передаем строку на проверку и обработку в Router
        Router::dispatch($query);
    }

    //функция получающая параметры и записывающая из в статическую переменную app
    protected function getParams()
    {
        $params = require_once CONF . '/params.php';
        if (!empty($params)) {
            foreach ($params as $key => $value) {
                self::$app->setProperty($key, $value);
            }
        }
    }
}

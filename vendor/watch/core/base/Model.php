<?php

namespace watch\base;

use watch\Db;

abstract class Model
{
    public $attributes = [];
    public $errors = [];
    public $rules = [];

    public function __construct()
    {
        //Запуск БД или вернет уже созданный экземпляр
        Db::instance();
    }
}
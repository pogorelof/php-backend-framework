<?php

namespace watch\base;

abstract class Controller
{
    public $route;
    public $controller;
    public $view;
    public $model;
    public $prefix;
    public $layout;
    public $data = []; //Данные для передачи из контроллера в view
    public $meta = [
        'title' => '',
        'desc' => '',
        'keywords' => '',
    ]; //Метаданные

    public function __construct($route)
    {
        $this->route = $route;
        $this->controller = $route['controller'];
        $this->view = $route['action'];//View имеет то же имя что и экшен
        $this->prefix = $route['prefix'];

        $this->model = $route['controller'];//Модель имеет то же имя что и контроллен
    }

    //Метод создающий объект view и его метод render, формирующий страницу
    public function getView()
    {
        $viewObject = new View($this->route, $this->layout, $this->view, $this->meta);
        $viewObject->render($this->data);
    }

    public function set($data)
    {
        $this->data = $data;
    }

    public function setMeta($title = '', $desc = '', $keywords = '')
    {
        $this->meta['title'] = $title;
        $this->meta['desc'] = $desc;
        $this->meta['keywords'] = $keywords;
    }
}
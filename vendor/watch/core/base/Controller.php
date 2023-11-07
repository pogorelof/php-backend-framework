<?php

namespace watch\base;

abstract class Controller
{
    public $route; //Маршрут в виде словаря, содержащий controller, action и prefix
    public $controller;
    public $view;//Имеет название аналогичное action
    public $model;//Отвечает за БД. Имеет название аналогичное controller
    public $prefix;//То, что идет в строке перед контроллером
    public $layout;//Шаблон вида
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

    //Метод создающий объект view и вызывает его метод render, формирующий страницу
    public function getView()
    {
        $viewObject = new View($this->route, $this->layout, $this->view, $this->meta);
        $viewObject->render($this->data);
    }

    //Метод, добавляющий в массив данные, для отображения во view
    public function set($data)
    {
        $this->data = $data;
    }

    //Метод, формирующий метаданные
    public function setMeta($title = '', $desc = '', $keywords = '')
    {
        $this->meta['title'] = $title;
        $this->meta['desc'] = $desc;
        $this->meta['keywords'] = $keywords;
    }
}
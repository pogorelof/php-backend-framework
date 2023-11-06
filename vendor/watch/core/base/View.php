<?php

namespace watch\base;

class View
{
    public $route;
    public $controller;
    public $view;
    public $model;
    public $prefix;
    public $data = []; //Данные для передачи из контроллера в view
    public $meta = []; //Метаданные
    public $layout;

    public function __construct($route, $layout = '', $view = '', $meta)
    {
        $this->route = $route;
        $this->controller = $route['controller'];
        $this->view = $view;//View имеет то же имя что и экшен
        $this->prefix = $route['prefix'];
        $this->model = $route['controller'];//Модель имеет то же имя что и контроллер

        $this->meta = $meta;

        if ($layout === false) {
            $this->layout = false;
        } else {
            $this->layout = $layout ?: LAYOUT; //LAYOUT значение константы в init
        }
    }

    //Метод формирующий страницу
    public function render($data)
    {
        //Извлекаем данные из массива, которые запишуться в переменные
        //Которые затем можем использовать в шаблоне по названию переменной
        //Благодаря функции extract
        if(is_array($data)) extract($data);
        $viewFile = APP . "/views/{$this->prefix}{$this->controller}/{$this->view}.php";
        if (is_file($viewFile)) {
            ob_start(); //включение буферизации
            require_once $viewFile;
            $content = ob_get_clean(); //Сохранение вывода в переменную и очистка буфера
        } else {
            throw new \Exception("Не найден вид {$viewFile}", 500);
        }

        if ($this->layout !== false) {
            $layoutFile = APP . "/views/layouts/{$this->layout}.php";
            if (is_file($layoutFile)) {
                require_once $layoutFile;
            } else {
                throw new \Exception("Не найден шаблон {$layoutFile}", 500);
            }
        }
    }

    //Метод для получение метатегов в html файле
    public function getMeta()
    {
        return "<title>{$this->meta['title']}</title><meta name='description' content='{$this->meta['desc']}'><meta name='keywords' content='{$this->meta['keywords']}'>";
    }
}
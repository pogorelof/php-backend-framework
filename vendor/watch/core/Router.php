<?php

namespace watch;

use http\Params;

class Router
{
    //Все возможные маршруты
    protected static $routes = [];
    //Нынешний маршрут для проверки и обработки
    protected static $route = [];

    //Добавление маршрута: добавляется в файле config/router.php
    public static function add($regexp, $route = [])
    {
        //В ключ записывается регулярное выражение и если в маршрутах есть соответствие введенной строке, то вызывается ключ
        //Значение которого содержит определение контроллера, экшена, префикс и тд
        self::$routes[$regexp] = $route;
    }
    //Геттер маршрутов
    public static function getRoutes()
    {
        return self::$routes;
    }
    //Геттер введенного маршрута
    public static function getRoute()
    {
        return self::$route;
    }

    //Вызывает контроллер, либо возвращает ошибку 404(в зависимости от результата matchRoute)
    public static function dispatch($url)
    {
        $url = self::removeQueryString($url);
        //Если функция нашла маршрут в списке маршрутов метод обрабатывает их
        if (self::matchRoute($url)) {
            //путь к контроллеру
            $controller = 'app\controllers\\' . self::$route['prefix']
                . self::$route['controller'] . 'Controller'; //Controller - postfix чтобы не вызвать случайно ненужный класс, т.к. все нужные контроллеры имеют окончание Controller
            //Проверка на существование контроллера(а точнее класса)
            if(class_exists($controller)){
                //создается объект контроллера
                $controllerObject = new $controller(self::$route);
                //Экшен приводится в camelCase с первым символом в нижнем регистре
                $action = self::lowerCamelCase(self::$route['action']) . 'Action';//Action - postfix по аналогии с контроллером
                //проверка на существование метода в классе
                if(method_exists($controllerObject, $action)){
                    //Если существует - вызов метода:
                    $controllerObject->$action();
                    //Вызов метода вызывающего view
                    $controllerObject->getView();
                } else{
                    //Если экшена не существует - вызов ошибки
                    throw new \Exception("Метод {$action} в контроллере {$controller} не найден", 404);
                }
            } else{
                //Если контроллера не сущетсвует - вызов ошибки
                throw new \Exception("Контроллер {$controller} не найден", 404);
            }
        } else {
            //Если пути не сущетсвует - вызов ошибки
            throw new \Exception("Page not found", 404);
        }
    }

    //Проверяет наличие маршрута
    //Возвращает булевое значение
    public static function matchRoute($url)
    {
        //цикл по всем маршрутам
        foreach (self::$routes as $pattern => $route) {
            //Если url соответствует паттерну, тогда в переменную $matches записывается route
            if (preg_match("#{$pattern}#", $url, $matches)) {
                //Далее $matches перезаписываем переменную $route
                foreach ($matches as $k => $v) {
                    if(is_string($k)){
                        $route[$k] = $v;
                    }
                }
                //Если экшен пустой, ему присваивается значение index
                if(empty($route['action'])){
                    $route['action'] = 'index';
                }
                //Если префикс пустой, ему присваивается пустое значение
                if(!isset($route['prefix'])){
                    $route['prefix'] = '';
                } else{ //Если префикс есть, то в конец добавляется слэш /
                    $route['prefix'] .= '\\';
                }

                //Т.к. классы именуются в CamelCase - приводим ввод строки в нужный нам вид
                $route['controller'] = self::upperCamelCase($route['controller']);
                //записываем маршрут уже в статичную переменную класса $route
                self::$route = $route;

//                debug(self::$route);
                //Сообщаем что маршрут найден
                return true;
            }
        }
        //Сообщаем что маршрут не был найден
        return false;
    }

    //Функция приводящая имя controller в допустимый формат: CamelCase
    protected static function upperCamelCase($name){
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $name)));
    }

    //Функция приводящая имя action в допустимый формат: camelCase
    protected static function lowerCamelCase($name){
        return lcfirst(self::upperCamelCase($name));
    }

    //Для работы с GET запросами
    protected static function removeQueryString($url){
        if($url){
            $params = explode('&', $url, 2);
            if(strpos($params[0], '=') === false){
                return $params[0];
            }else{
                return '';
            }
        }
    }
}
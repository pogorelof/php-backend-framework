<?php

namespace watch;

//класс обработки ошибок
class ErrorHandler
{
    //конструктор
    public function __construct()
    {
        //Включение показа ошибок на странице
        if(DEBUG){
            //Включить показ ошибок
            error_reporting(-1);
        } else{
            //Отключить показ ошибок
            error_reporting(0);
        }
        //Функция обработки исключений
        set_exception_handler([$this, 'exceptionHandler']);//Указываем обработчик ошибок - метод, в этом классе
    }

    //метод обработки ошибок
    public function exceptionHandler($error)//В аргументы поступает ошибка класса Error
    {
        //все методы в аргументах относятся к классу Error
        $this->logErrors($error->getMessage(), $error->getFile(), $error->getLine());//вызов метода логирования
        $this->displayErrors('Исключение', $error->getMessage(), $error->getFile(), $error->getLine(), $error->getCode());//вызов метода вывода ошибки на страницу
    }

    protected function logErrors($message='', $file='', $line='')
    {
        //Логирование с помощью функции error_log в папку tmp
        error_log('[' . date('Y-m-d H-i-s') . "] Текст ошибки: $message | Файл: $file | Строка: $line \n ============= \n",
        3, ROOT . '/tmp/errors.log');
    }

    protected function displayErrors($errno, $errstr, $errfile, $errline, $response='404')
    {
        http_response_code($response);
        if($response == 404 && !DEBUG)
        {//если 404 и дебаг отключен, вызов красивой страницы для пользователя
            require WWW . "/errors/404.php";
        }else if(DEBUG)
        {//если дебаг включен, вывод ошибки для разработчика
            require WWW . "/errors/dev.php";
        } else{//если дебаг отключен и ошибка не 404, сообщение об ошибке без подробностей
            require WWW . "/errors/prod.php";
        }
        die;
    }
}
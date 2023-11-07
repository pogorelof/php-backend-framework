<?php

namespace watch;

//Для упрощения вызова RedBean через \R
class_alias('\RedBeanPHP\R', '\R');


class Db
{
    //Трейт, для использования шаблона Синглтон
    use TSingleton;
    //Следовательно, у этого класса есть только один подключенный экземпляр к БД

    protected function __construct()
    {
        //Получаем данные конфигурации
        $db = require_once CONF . '/config_db.php';
        //Устанавливаем конфигурацию в RedBean
        \R::setup($db['dsn'], $db['user'], $db['pass']);
        //Проверяем соединение с БД
        if(!\R::testConnection()){
            throw new \Exception('Нет соединения с БД', 500);
        }
        //Блокировка схемы базы данных
        \R::freeze(true);
        //Вывод ошибки в зависимости от режима работы приложения
        if(DEBUG){
            \R::debug(true, 1);
        }
    }


}
<?php 

namespace watch;

//Трэйт реализующий шаблон Синглтон
trait TSingleton
{
    //переменная содержащая единственный экземпляр класса
	private static $instance;

    //публичный метод получение экземпляра
	public static function instance()
	{
        //Если экземпляра нет, ему присваивается новоиспеченный экземпляр класса
		if(self::$instance === null)
		{
			self::$instance = new self;
		}
        //Если экземпляр существует, он и вернется
		return self::$instance;
	}
}
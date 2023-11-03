<?php 

namespace watch;

class Registry
{
    //Трейт синглотона
    //Теперь у класса будет только один объект
	use TSingleton;
    //Сюда будут складываться параметры
	private static $properties = [];

    //Сеттер
	public function setProperty($key, $value)
	{
		self::$properties[$key] = $value;
	}
    //Геттер
	public  function getProperty($key)
	{
		if(isset(self::$properties[$key]))
		{
			return self::$properties[$key];
		}
		return null;
	}

    //Метод получения всех параметров
	public function getProperties()
	{
		return self::$properties;
	}
}
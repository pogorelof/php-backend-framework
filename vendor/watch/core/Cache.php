<?php

namespace watch;

class Cache
{
    use TSingleton;

    /*
     * key - ключ, по которому будут доступны данные(имя файла)
     * data - сами данные
     * seconds - на какое время кешируются данные
     * */
    public function set($key, $data, $seconds = 3600)
    {
        //Если мы не хотим кешировать данные, то мы в параметр seconds передаем 0
        //в целях тестирования - на практике это не понадобится
        if($seconds){
            $content['data'] = $data;
            $content['end_time'] = time() + $seconds;
            //ключ шифруется, чтобы в случае если пользователь вставит запрещенный символ, он не сработал
            if(file_put_contents(CACHE . '/' . md5($key) . '.txt', serialize($content))){
                return true;
            }
            return false;
        }
    }


    public function get($key)
    {
        $file = CACHE . '/' . md5($key) . '.txt';
        if(file_exists($file)){
            $content = unserialize(file_get_contents($file));
            if($content['end_time'] >= time()){
                return $content;
            }
            unlink($file);
        }
        return false;
    }

    public function delete($key)
    {
        $file = CACHE . '/' . md5($key) . '.txt';
        if(file_exists($file)){
            unlink($file);
        }
    }

}
<?php

/**
 * Created by PhpStorm.
 * User: maruichao
 * Date: 2018/3/5
 * Time: 9:40
 */
class YcDispatcher
{
    private static $dir = 'blog';
    private static $ctrl = 'Index';
    private static $method = 'index';

    public static function cli() {}

    public static function dispatcher()
    {
        //获取uri
        $uri    = str_replace(array('$', '(', ')', '%28', '%29', '..'), array('&#36;', '&#40;', '&#41;', '&#40;', '&#41;', ''), $_SERVER['REQUEST_URI']);
        $uri    = parse_url($uri, PHP_URL_PATH);
        $uriArr = explode('/', trim($uri, '/'));

        if (count($uriArr)) {
            if (isset($uriArr[0])) {
                self::$ctrl = ucfirst($uriArr[0]);
            }

            if (isset($uriArr[1])) {
                self::$method = ucfirst($uriArr[1]);
            }

            $file = APP_PATH . DS . 'controller' . DS . CTRL_PRE .self::$ctrl . '.class.php';
            if (is_file($file)) {
                include $file;

                $controller = CTRL_PRE . self::$ctrl;
                $obj    = new $controller;
                $method = self::$method;
                $obj->$method();
            } else {
                dump('Error-'.$file.' is not found');
            }
        }
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/5
 * Time: 21:48
 */
define('CTRL_PRE', 'Controller_');

class Yc
{
    protected static $instance = array(); //单例容器

    public static function initError($msg, $code = 10000)
    {
        return dump($msg, $code);
    }

    public static function run()
    {
        spl_autoload_register(array('Yc', 'autoload'), true, true);

        if (strripos(php_sapi_name(), 'cli') !== false) {
            YcDispatcher::cli();
        } else {
            YcDispatcher::dispatcher();
        }
    }

    public static function autoload($class)
    {
        if (class_exists($class, false) || interface_exists($class, false)) {
            return;
        }

        //引入命名空间
        if (strpos($class, '\\') !== false) {
            $class_file = ROOT_PATH . '/' . str_replace('\\', '/', $class) . '.class.php';
            if (is_file($class_file)) {
                require_once($class_file);
            }
        } else {
            //自动包含文件的目录配置
            $path = array(
                '/core/bootstrap/',  //脚手架
                '/core/controller/', //controller层
                '/core/service/',    //service层
                '/core/dao/',        //DAO层
                '/core/view/',       //view层
                '/core/util/',       //核心工具
                '/library/',         //扩展类库
            );
            foreach ($path as $p) {
                if (file_exists(ROOT_PATH . $p . $class . '.class.php')) {
                    include(ROOT_PATH . $p . $class . '.class.php');
                    break;
                }

                if (file_exists(ROOT_PATH . $p . $class . '.php')) {
                    include(ROOT_PATH . $p . $class . '.php');
                    break;
                }
            }
        }
    }
}
<?php
/**
 * ycphp0.1 入口文件
 *
 * @author mrc <admin@muyebar.com>
 */
header("Content-Type:text/html; charset=utf-8");
date_default_timezone_set('Asia/Shanghai');

// 入口 定义常量 引入函数库 自动加载类 启动框架
// 路由解析 加载控制器 返回结果

//定义常量
define('DEBUG', true);
define('DS', DIRECTORY_SEPARATOR);

define('ROOT_PATH', dirname(__DIR__));
define('APP_PATH', ROOT_PATH . DS . 'app' . DS . 'api');

//加载函数库
include ROOT_PATH. DS . 'vendor/autoload.php';

if (DEBUG) {
    ini_set('display_errors', 1);

    $whoops = new \Whoops\Run();
    $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler());
    $whoops->register();

} else {
    ini_set('display_errors', 0);
}

require_once ROOT_PATH . '/core/bootstrap/Yc.class.php';
Yc::run();
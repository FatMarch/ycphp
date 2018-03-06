<?php

/**
 * Created by PhpStorm.
 * User: maruichao
 * Date: 2018/3/5
 * Time: 9:39
 */
class YcCore
{

    protected static $instance = array(); //单例容器
    private $bootPath = array(
        'd' => '/core/dao/', //DAO层
        's' => '/core/service/', //service层
        'c' => '/core/controller/', //controller层
        'v' => '/core/view/', //view层
        'u' => '/core/util/', //核心工具
        'l' => '/library/', //扩展类库
    );

    /**
     * 初始化
     */
    public function __construct() {

    }

    /**
     * 框架核心加载-框架的所有类都需要通过该函数出去
     * 1. 单例模式
     * 2. 可以加载-Controller，Service，View，Dao，Util，Library中的类文件
     * 3. 框架加载核心函数
     * 使用方法：$this->load($className, $type)
     * @param string $className 类名称
     * @param string $type 类别
     *
     * @return mixed
     */
    public function load($className, $type) {
        $classPath = $this->getClassPath($className, $type);
        if (!file_exists($classPath)) {
            return Yc::initError('file '. $className . '.php is not exist!');
        }

        if (!isset(self::$instance['yc'][$type][$className])) {
            require_once($classPath);
            if (!class_exists($className)) {
                Yc::initError('class' . $className . ' is not exist!');
            }

            $init_class = new $className;
            self::$instance['yc'][$type][$className] = $init_class;
        }

        return self::$instance['yc'][$type][$className];
    }

    /**
     *	系统获取library下面的类
     *  1. 通过$this->getLibrary($class) 就可以加载Library下面的类
     *  2. 单例模式-通过load核心函数加载
     *  全局使用方法：$this->getLibrary($class)
     *  @param  string  $className  类名称
     *  @return object
     */
    public function getLibrary($class) {
        return $this->load($class, 'l');
    }

    /**
     *	系统获取Util类函数
     *  1. 通过$this->getUtil($class) 就可以加载Util下面的类
     *  2. 单例模式-通过load核心函数加载
     *  全局使用方法：$this->getUtil($class)
     *  @param  string  $className  类名称
     *  @return object
     */
    public function getUtil($class) {
        return $this->load($class, 'u');
    }

    /**
     * 获取缓存对象
     * 全局使用方法：$this->getCache()->
     * @return cacheInit
     */
    public function getCache() {
        if (self::$instance['initphp_cache'] == NULL) {
            $dao = $this->load('dao', 'd'); //导入D
            self::$instance['initphp_cache'] = $dao->run_cache(); //初始化cahce
        }
        return self::$instance['initphp_cache'];
    }

    /**
     * 获取NOSQL对象
     * 全局使用方法：$this->getNosql()->
     * @return nosqlInit
     */
    public function getNosql() {
        if (self::$instance['initphp_nosql'] == NULL) {
            $dao = $this->load('dao', 'd'); //导入D
            self::$instance['initphp_nosql'] = $dao->run_nosql(); //初始化nosql
        }
        return self::$instance['initphp_nosql'];
    }

    /**
     * 获取NOSQL对象中的Mongo
     * 全局使用方法：$this->getMongo()->
     * 使用Mongo，你的服务器端需要安装Mongo
     * 需要在配置文件中配置$InitPHP_conf['mongo'][服务器server]
     * 如果多个mongo分布，则直接可以改变$server就可以切换
     * @return mongoInit
     */
    public function getMongo($server = 'default') {
        $instance_name = 'initphp_mongo_' . $server;
        if (self::$instance[$instance_name] == NULL) {
            self::$instance[$instance_name] = $this->getNosql()->init('MONGO', $server);
        }
        return self::$instance[$instance_name];
    }

    /**
     * 获取NOSQL对象中的Redis
     * 全局使用方法：$this->getRedis()->
     * 使用Redis，你的服务器端需要安装Redis
     * 需要在配置文件中配置$InitPHP_conf['redis'][服务器server]
     * 如果多个redis分布，则直接可以改变$server就可以切换
     * @return redisInit
     */
    public function getRedis($server = 'default') {
        $instance_name = 'initphp_redis_' . $server;
        if (self::$instance[$instance_name] == NULL) {
            self::$instance[$instance_name] = $this->getNosql()->init('REDIS', $server);
        }
        return self::$instance[$instance_name];
    }

    /**
     * 获取m
     * 全局使用方法：$this->getM()
     * @return
     */
    public static function getM() {
        $InitPHP_conf = InitPHP::getConfig();
        if ($InitPHP_conf['ismodule'] === false) return '';
        if ($_GET['m'] == '') return $InitPHP_conf['controller']['default_module'];
        return $_GET['m'];
    }

    /**
     * 获取c
     * 全局使用方法：$this->getC()
     * @return
     */
    public static function getC() {
        $InitPHP_conf = InitPHP::getConfig();
        if ($_GET['c'] == '') return $InitPHP_conf['controller']['default_controller'];
        return $_GET['c'];
    }

    /**
     * 获取a
     * 全局使用方法：$this->getA()
     * @return
     */
    public static function getA() {
        $InitPHP_conf = InitPHP::getConfig();
        if ($_GET['a'] == '') return $InitPHP_conf['controller']['default_action'];
        return $_GET['a'];
    }

    /**
     * 注册到框架全局可用变量
     * @param string $name 变量名称
     * @param val $value   变量值
     */
    public function register_global($name, $value) {
        self::$instance['global'][$name] = $value;
        $this->$name = $value;
    }

    /**
     *	获取系统类文件路径
     *  @param  string  $className  类名称
     *  @param  string  $type       类所属类型
     *  @return string
     */
    private function getClassPath($className, $type) {
        $classPath = $this->bootPath[$type] . $className . '.class.php';
        $classPath = ROOT_PATH . $classPath;
        return $classPath;
    }
}
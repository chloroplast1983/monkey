<?php
/**
 * core 核心文件 *
 * @author  chloroplast1983
 * @version 1.0.20131007
 */

namespace Marmot;

//默认访问程序路径,请勿修改
define('S_ROOT', dirname(__FILE__).DIRECTORY_SEPARATOR);
//内核部分文件夹路径
define('SYS_ROOT', S_ROOT.'System'.DIRECTORY_SEPARATOR);

/**
 * 文件核心类
 *
 * @author  chloroplast1983
 * @version 1.0.20130916
 */
class Core
{
    private static $instance;

    //框架内的容器,这里暂时使用的是第三方的PHP-DI容器
    public static $container;

    //缓存驱动
    public static $cacheDriver;

    //mongo驱动
    public static $mongoDriver;

    //核心文件映射关系数组
    private $classMaps;

    //上一次错误
    private static $lastError;

    private $global;
    
    private function __construct()
    {
    }

    /**
     * 使用单例封装全局函数的core调用
     */
    public static function &getInstance()
    {
        if (!self::$instance instanceof self) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    /**
     * 网站正常启动流程
     */
    public function init()
    {
        //autoload
        self::initAutoload();
        self::initContainer();//引入容器
        self::initCache();//初始化缓存使用
        self::initEnv();//初始化环境
        // self::initMongo();
        self::initUser();
        self::initError();
        self::initRoute();
    }

    /**
     * 单元测试专用启动路程,用于引导phpunit,bootstrap的路由文件进入.
     * 在这里我们要实现如下功能:
     * 1. 自动加载
     * 2. 初始化容器
     * 3. 初始化缓存
     * 4. 初始化测试持久层存储,用于测试数据库和程序分离
     */
    public function initTest()
    {
        self::initAutoload();//autoload
        self::initContainer();//引入容器
        self::initCache();//初始化缓存使用
        self::initEnv();//初始化环境
        self::initTestEnv();//初始化测试环境
        // self::initMongo();
        self::initError();
    }
    
    /**
     * cli模式专用启动路程,用于引导操作框架的一些操作.
     * 在这里我们要实现如下功能:
     * 1. 自动加载
     * 2. 初始化容器
     * 3. 初始化缓存
     * 4. 初始化测试持久层存储
     */
    public function initCli()
    {

        self::initAutoload();//autoload
        self::initContainer();//引入容器
        self::initCache();//初始化缓存使用
        self::initEnv();//初始化环境
        // self::initMongo();
        self::initError();
    }
    
    /**
     * 自动加载方法,这里分为2个部分.这里的借鉴了yii框架的自动加载
     * 符合PSR4自动加载规范
     *
     * 1. 加载第三方的autoload,主要是composer管理的第三方依赖
     * 2. 核心框架自己的autoload
     *    2.1 核心文件主要是通过映射关系载入的,原来使用的是淘宝的一套开源的autoload,
     *        但是考虑其功能过于繁重,这里改为用文件映射
     *    2.2 应用文件(Application)主要是通过命名规则映射
     */
    private function initAutoload()
    {

        //加载第三方的composer的autoload
        include 'vendor/autoload.php';
        //加载System核心框架内的映射关系 -- 开始
        $this->classMaps = include SYS_ROOT.'/classMaps.php';
        //加载System核心框架内的映射关系 -- 结束

        //加载框架Application文件的autoload,匿名函数 -- 开始
        spl_autoload_register(
            function ($className) {

                if (isset($this->classMaps[$className])) {
                    $classFile = $this->classMaps[$className];
                } else {
                    $classFile = str_replace('\\', '/', $className) . '.class.php';
                    $classFile = S_ROOT.'Application/'.$classFile;
                }

                if (file_exists($classFile)) {
                      include_once $classFile;
                }
            }
        );
        //加载ut测试文件
        spl_autoload_register(
            function ($className) {

                $unitTestFile = str_replace('\\', '/', $className) . '.php';
                $unitTestFile = S_ROOT.'tests/UnitTest/Application/'.$unitTestFile;

                if (file_exists($unitTestFile)) {
                    include_once $unitTestFile;
                }
            }
        );
        //加载框架Application文件的autoload,匿名函数 -- 开始
    }

    /**
     * 初始化网站运行环境的一些全局变量
     *
     * @author  chloroplast1983
     * @version 1.0.20131016
     */
    private function initEnv()
    {
        session_start();
        Core::$container->set('time', time());
        //加载应用配置文件
        include S_ROOT.'Application/config.php';
        include S_ROOT.'Application/widgetRules.php';
    }

    private function initTestEnv()
    {
        $_ENV['APP_ENV'] = 'test';
    }

    /**
     * 初始化错误信息
     */
    private function initError()
    {
        include S_ROOT.'Application/commonErrorConfig.php';
        include S_ROOT.'Application/errorConfig.php';

        self::setLastError(ERROR_NOT_DEFINED);
    }

    public static function setLastError(int $errorCode = 0)
    {

        if ($errorCode <= COMMON_ERROR_LIMIT) {
            $errorDescriptions = include 'Application/commonErrorDescriptionConfig.php';
        } else {
            $errorDescriptions = include 'Application/errorDescriptionConfig.php';
        }

        if (!isset($errorDescriptions[$errorCode])) {
            return false;
        }

        self::$lastError  = new \System\Classes\Error(
            $errorCode,
            $errorDescriptions[$errorCode]['link'],
            $errorDescriptions[$errorCode]['status'],
            $errorDescriptions[$errorCode]['code'],
            $errorDescriptions[$errorCode]['title'],
            $errorDescriptions[$errorCode]['detail'],
            $errorDescriptions[$errorCode]['source'],
            $errorDescriptions[$errorCode]['meta']
        );
    }

    public static function getLastError() : \System\Classes\Error
    {
        return self::$lastError ;
    }

    /**
     * 创建容器
     *
     * @author  chloroplast1983
     * @version 1.0.20160215
     */
    private function initContainer()
    {
        //初始化容器
        $containerBuilder = new \DI\ContainerBuilder();
        //这里我们需要使用annotation,所以开启了此功能
        $containerBuilder->useAnnotations(true);
        //为容器设置缓存
        $containerCache = new \Doctrine\Common\Cache\ArrayCache();
        $containerCache->setNamespace('phpcore');
        $containerBuilder->setDefinitionCache($containerCache);

        $containerBuilder->writeProxiesToFile(true, S_ROOT.'Cache/proxies');
        //为容器设置配置文件
        $containerBuilder->addDefinitions(S_ROOT.'config.'.$_ENV['APP_ENV'].'.php');
        //创建容器
        self::$container = $containerBuilder->build();
    }
    
    /**
     * 路由,需要解决以前随意由个人设置路由的习惯,
     * 而希望能用统一的路由风格来解决这个问题.
     *
     * @version 1.0.20160204
     */
    private function initRoute()
    {
        //创建路由规则,如果对外提供接口考虑token用于验证
        $dispatcher = \FastRoute\cachedDispatcher(
            function (\FastRoute\RouteCollector $r) {
                //添加默认首页路由 -- 开始
                $r->addRoute('GET', '/', ['Home\Controller\IndexController','index']);

                //获取配置好的路由规则
                $routeRules = include S_ROOT.'/Application/routeRules.php';
                foreach ($routeRules as $route) {
                    $r->addRoute($route['method'], $route['rule'], $route['controller']);
                }
            },
            [
                'cacheFile' => S_ROOT. 'Cache/route.cache',
                'cacheDisabled' => Core::$container->get('cache.route.disable'),
            ]
        );

        $httpMethod = $_SERVER['REQUEST_METHOD'];
        $uri = rawurldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
        $routeInfo = $dispatcher->dispatch($httpMethod, $uri);

        $controller = ['Home\Controller\IndexController','notfound'];
        $parameters = [];

        switch ($routeInfo[0]) {
            case \FastRoute\Dispatcher::NOT_FOUND:
                self::setLastError(ROUTE_NOT_EXIST);
                break;
            case \FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
                // $allowedMethods = $routeInfo[1];
                self::setLastError(METHOD_NOT_ALLOWED);
                break;
            case \FastRoute\Dispatcher::FOUND:
                $controller = $routeInfo[1];
                $parameters = $routeInfo[2];
                break;
        }
        self::$container->call($controller, $parameters);
    }

    private function initUser()
    {
        //获取cookie
        $cookie = new \System\Classes\Cookie();
        $cookie->name = Core::$container->get('cookie.name');
        $cookie->get();
        $uid = $cookie->value;
        if (!empty($uid)) {
            $command = new \Member\Command\User\AuthUserCommand($uid);
            $commandBus = new \System\Classes\CommandBus(new \Member\CommandHandler\User\UserCommandHandlerFactory());
            return $commandBus->send($command);
        }
    }

    /**
     * 初始化 MongoDB 数据库
     */
    private function initMongo()
    {
        $mongoHost = self::$container->get('mongo.host');

        if (!empty($mongoHost)) {
            self::$mongoDriver = new \MongoDB\Client($mongoHost);
        }
    }

    /**
     * 初始化cache,在框架内暂时把缓存规划为如下几部分:
     * 1. Row cache: 行缓存,针对数据库一行为一段缓存::memcached
     * 2. Vector cache: 关系型缓存,针对关系做缓存处理,
     *    需要考虑不同数据库事务上的支持,
     *    需要额外考虑mysql和redis存储同样的关系怎么保证一致性,
     *    存储为数字对应数字::redis
     * 3. Fragment cache: 片段缓存,用于缓存页面中的一个片段.类似widget的页面内容::memcached
     * 4. Page cache(暂时不考虑处理): 页面缓存,有如下思路:大内容例如产品详情页等,
     *    采用分布式文件系统(淘宝有开源的),存储成静态文件.因为考虑内容
     *    可能超过2MB,超过memcached限制.
     *    主要这部分缓存暂时不想在PHP部分实现,想在后端服务中去实现.
     * @todo
     * 1. 需要优化在使用到memcached的情况下在连接memcached,减少无用的连接.
     *    比如场景为调取一个静态数据,则不需要连接memcached.
     * 2. 这里需要处理如果memcached失效的情况,做的应急处理.
     *
     * @version 1.0.20160204
     */
    private function initCache()
    {
        //初始化memcached缓存 -- 开始
        $memcached = new \Memcached();
        $memcached->addServers(self::$container->get('memcached.serevice'));

        self::$cacheDriver = new \Doctrine\Common\Cache\MemcachedCache();
        self::$cacheDriver->setMemcached($memcached);
        self::$cacheDriver->setNamespace('phpcore');
        //初始化memcached缓存 -- 结束
    }
}

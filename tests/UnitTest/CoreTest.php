<?php
namespace tests\UnitTest;

use Marmot\Core;
use PHPUnit\Framework\TestCase;

/**
 * 测试框架核心类
 * @author chloroplast
 * @version 1.0.20160218
 */
class CoreTest extends TestCase
{

    
    /**
     * 测试自动加载,需要测试如下:
     * 1.测试系统文件自动加载知否正常并且包含全部文件
     * 2.测试Application下的文件是否自动加载正常
     */
    public function testAutoLoad()
    {
        $result = $this->readAllFiles(S_ROOT.'/System');
        $filesCount = sizeof($result['files']);

        //计算文件总数 -- 结束
        //测试是否classMaps.php中的sizeof(array)等于文件总数
        $classMaps = include S_ROOT.'System/classMaps.php';
        $filesCount = --$filesCount; //减去classMaps
        $this->assertEquals(
            sizeof($classMaps),
            $filesCount,
            'System file counts: '.$filesCount.' not equal sizeof classMaps: '.sizeof($classMaps)
        );
        
        //测试classMaps中的class是否自动加载正确
        foreach ($classMaps as $className => $classPath) {
            $this->assertTrue(
                class_exists($className)||interface_exists($className)||trait_exists($className),
                $className.' not autoload by '.$classPath
            );
        }

        //测试Application加载文件,HomeController
        $homeController = new \Home\Controller\IndexController();
        $this->assertTrue($homeController instanceof \Home\Controller\IndexController, 'Application not autoload');
    }

    private function readAllFiles($root = '.')
    {
        $files  = array('files'=>array(), 'dirs'=>array());
        $directories  = array();
        $last_letter  = $root[strlen($root)-1];
        $root  = ($last_letter == '\\' || $last_letter == '/') ? $root : $root.DIRECTORY_SEPARATOR;

        $directories[]  = $root;

        while (sizeof($directories)) {
            $dir  = array_pop($directories);
            if ($handle = opendir($dir)) {
                while (false !== ($file = readdir($handle))) {
                    if ($file == '.' || $file == '..') {
                        continue;
                    }
                    $file  = $dir.$file;
                    if (is_dir($file)) {
                        $directory_path = $file.DIRECTORY_SEPARATOR;
                        array_push($directories, $directory_path);
                        $files['dirs'][]  = $directory_path;
                    } elseif (is_file($file)) {
                        $files['files'][]  = $file;
                    }
                }
                closedir($handle);
            }
        }

        return $files;
    }

    /**
     * 测试是否初始化了容器
     */
    public function testInitContainer()
    {
        //测试容器已经被初始化了
        $this->assertTrue(is_object(Core::$container) && Core::$container instanceof \DI\Container);
    }

    /**
     * 测试是否初始化了缓存驱动
     */
    public function testInitCache()
    {
        $this->assertTrue(
            is_object(Core::$cacheDriver) &&
            Core::$cacheDriver instanceof \Doctrine\Common\Cache\MemcachedCache
        );
    }
}

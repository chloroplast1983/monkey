<?php
namespace System\Adapter\Restful\Adapter\CacheResponse\Query\Persistence;

use PHPUnit\Framework\TestCase;
use Marmot\Core;

class CacheResponseCacheTest extends TestCase
{
    private $cache;

    public function setUp()
    {
        $this->cache = new CacheResponseCache();
    }

    /**
     * 测试该文件是否正确的继承cache类
     */
    public function testCorrectInstanceExtendsCache()
    {
        $this->assertInstanceof('System\Classes\Cache', $this->cache);
    }
}

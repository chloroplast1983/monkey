<?php
namespace Member\Cache\Persistence;

use PHPUnit\Framework\TestCase;

class UserCacheTest extends TestCase
{
    private $stub;

    public function setUp()
    {
        $this->stub = new UserCache();
    }

    public function tearDown()
    {
        unset($this->stub);
    }

    public function testExtendsCache()
    {
        $this->assertInstanceof('System\Classes\Cache', $this->stub);
    }
}

<?php
namespace Member\Cache;

use PHPUnit\Framework\TestCase;

use Member\Repository\User\UserRepository;

use System\Adapter\ConcurrentAdapter;
use Prophecy\Argument;

class LatestUsersFragmentCacheTest extends TestCase
{
    private $stub;

    public function setUp()
    {
        $this->stub = new LatestUsersFragmentCache();
    }

    public function tearDown()
    {
        unset($this->stub);
    }

    public function testExtendsFragmentCacheQuery()
    {
        $this->assertInstanceof('System\Query\FragmentCacheQuery', $this->stub);
    }
}

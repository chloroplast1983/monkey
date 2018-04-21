<?php
namespace tests\UnitTest\Application;
 
use PHPUnit\Framework\TestCase;

class RouteRulesTest extends TestCase
{
    public function testRouteRulers()
    {
        $classRouteRulers = include S_ROOT.'/Application/routeRules.php';
        $result = count($classRouteRulers)>0;
        $this->assertTrue($result);
    }
}

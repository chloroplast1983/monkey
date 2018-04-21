<?php
namespace System\Classes;

use PHPUnit\Framework\TestCase;
use Marmot\Core;
use System\Classes\Request;
use System\Classes\Response;

class ControllerTest extends TestCase
{
    private $stub;
    private $childStub;

    public function setUp()
    {
        $this->stub = $this->getMockBuilder('System\Classes\Controller')
            ->setMethods(['getRequest','getResponse'])
            ->getMockForAbstractClass();
        $this->childStub = new class extends Controller
        {
            public function getRequest() :Request
            {
                return parent::getRequest();
            }
            public function getResponse() : Response
            {
                return parent::getResponse();
            }
        };
    }

    public function tearDown()
    {
        unset($this->stub);
        unset($this->childStub);
    }

    public function testGetRequest()
    {
        $this->assertInstanceOf(
            'System\Classes\Request',
            $this->childStub->getRequest()
        );
    }

    public function testGetResponse()
    {
        $this->assertInstanceOf(
            'System\Classes\Response',
            $this->childStub->getResponse()
        );
    }
}

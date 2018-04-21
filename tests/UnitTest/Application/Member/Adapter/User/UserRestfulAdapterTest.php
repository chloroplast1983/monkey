<?php
namespace Member\Adapter\User;

use PHPUnit\Framework\TestCase;

use System\Classes\Translator;

class UserRestfulAdapterTest extends TestCase
{
    private $stub;
    private $childStub;

    public function setUp()
    {
         $this->stub = $this->getMockBuilder(UserRestfulAdapter::class)
            ->setMethods(
                ['fetchOneAction','isSuccess','post','patch','translateToObject','getTranslator']
            )->getMock();
        $this->childStub = new class extends UserRestfulAdapter
        {
            public function getTranslator() : Translator
            {
                return parent::getTranslator();
            }
        };
    }

    public function tearDown()
    {
        unset($this->stub);
        unset($this->childStub);
    }

    public function testGetTranslator()
    {
        $this->assertInstanceOf(
            'Member\Translator\UserRestfulTranslator',
            $this->childStub->getTranslator()
        );
    }
}

<?php
namespace System\Classes;

use PHPUnit\Framework\TestCase;

use Marmot\Core;
use System\Classes\CommandBus;
use System\Interfaces\ICommandHandlerFactory;
use System\Interfaces\ICommand;
use System\Interfaces\INull;
use System\Interfaces\ICommandHandler;
use System\Classes\NullCommandHandler;

use Prophecy\Argument;

class CommandBusTest extends TestCase
{
    private $commandBus;
    private $commandHandler;
    private $command;
    private $transaction;
    private $childCommandBus;

    public function setUp()
    {
        $this->commandHandlerFactory = $this->prophesize(ICommandHandlerFactory::class);
        $this->command = $this->prophesize(ICommand::class);
        $this->transaction = $this->prophesize(Transaction::class);
        // $this->childCommandBus = new class extends CommandBus
        // {
        //     public function getCommandHandlerFactory() : ICommandHandlerFactory
        //     {
        //         return parent::getCommandHandlerFactory();
        //     }
        // };
    }

    public function tearDown()
    {
        unset($this->commandBus);
        unset($this->commandHandlerFactory);
        unset($this->command);
        unset($this->transaction);
        unset($this->childCommandBus);
    }

    // public function testGetCommandHandlerFactory()
    // {
    //     $this->assertInstanceOf(
    //         'System\Interfaces\ICommandHandlerFactory',
    //         $this->childCommandBus->getCommandHandlerFactory()
    //     );
    // }
    
    /**
     * 1. getTransaction() 需要调用一次
     * 2. getCommandHandlerFactory() 需要调用一次
     * 3. transaction->beginTransaction() 调用一次
     * 4. commandHandher->execute() 假设调用失败
     * 5. transaction->commit() 不调用
     * 6. transaction->rollBack() 调用一次
     */
    public function testCommandExcuteFailure()
    {
        $commandHandler = $this->prophesize(ICommandHandler::class);
        $commandHandler->execute(
            Argument::exact($this->command)
        )->shouldBeCalledTimes(1)->willReturn(false);

        $this->commandHandlerFactory->getHandler(
            Argument::exact($this->command)
        )->shouldBeCalledTimes(1)
         ->willReturn($commandHandler->reveal());

        $this->commandBus= $this->getMockBuilder(CommandBus::class)
                                ->setMethods(['getTransaction', 'getCommandHandlerFactory'])
                                ->setConstructorArgs([$this->commandHandlerFactory->reveal()])
                                ->getMock();
        $this->commandBus->expects($this->once())
                         ->method('getCommandHandlerFactory')
                         ->willReturn($this->commandHandlerFactory->reveal());
      
        
        $result = $this->commandBus->send($this->command->reveal());

        $this->assertFalse($result);
        $this->assertEquals(ERROR_NOT_DEFINED, Core::getLastError()->getId());
    }

    /**
     * 1. getTransaction() 需要调用一次
     * 2. getCommandHandlerFactory() 需要调用一次
     * 3. transaction->beginTransaction() 调用一次
     * 4. commandHandher->execute() 调用一次成功
     * 5. transaction->commit() 调用一次, 假设失败
     * 6. transaction->rollBack() 调用一次
     */
    public function testCommitFailure()
    {

        $commandHandler = $this->prophesize(ICommandHandler::class);
        $commandHandler->execute(
            Argument::exact($this->command)
        )->shouldBeCalledTimes(1)->willReturn(true);

        $this->commandHandlerFactory->getHandler(
            Argument::exact($this->command)
        )->shouldBeCalledTimes(1)
         ->willReturn($commandHandler->reveal());

        $this->commandBus= $this->getMockBuilder(CommandBus::class)
                                ->setMethods(['getTransaction', 'getCommandHandlerFactory'])
                                ->setConstructorArgs([$this->commandHandlerFactory->reveal()])
                                ->getMock();
        $this->commandBus->expects($this->once())
                         ->method('getCommandHandlerFactory')
                         ->willReturn($this->commandHandlerFactory->reveal());
        
        $result = $this->commandBus->send($this->command->reveal());

        $this->assertTrue($result);
        $this->assertEquals(ERROR_NOT_DEFINED, Core::getLastError()->getId());
    }

    public function testNullCommandHandler()
    {
        $commandHandler = $this->getMockBuilder(NullCommandHandler::class)
                               ->getMock();

        $this->commandHandlerFactory->getHandler(
            Argument::exact($this->command)
        )->shouldBeCalledTimes(1)
         ->willReturn($commandHandler);

        $this->commandBus= $this->getMockBuilder(CommandBus::class)
                         ->setMethods(['getTransaction', 'getCommandHandlerFactory'])
                         ->setConstructorArgs([$this->commandHandlerFactory->reveal()])
                         ->getMock();

        $this->commandBus->expects($this->once())
                         ->method('getCommandHandlerFactory')
                         ->willReturn($this->commandHandlerFactory->reveal());
        
        $this->commandBus->expects($this->exactly(0))
                         ->method('getTransaction');

        $result = $this->commandBus->send($this->command->reveal());
        $this->assertFalse($result);
        $this->assertEquals(COMMAND_HANDLER_NOT_EXIST, Core::getLastError()->getId());
    }

    /**
     * 1. 调用getTransaction()一次
     * 2. 调用getCommandHandlerFactory()一次
     * 3. 调用transaction->beginTransaction() 一次
     * 4. 调用transaction->commit() 一次, 返回true
     * 6. 调用commandHander->execute() 一次,返回true
     * 7. 调用transaction->rollBack() 不调用
     * 8. 期望结果返回true
     */
    public function testSendSuccess()
    {
        $commandHandler = $this->prophesize(ICommandHandler::class);
        $commandHandler->execute(
            Argument::exact($this->command)
        )->shouldBeCalledTimes(1)->willReturn(true);

        $this->commandHandlerFactory->getHandler(
            Argument::exact($this->command)
        )->shouldBeCalledTimes(1)
         ->willReturn($commandHandler->reveal());

        $this->commandBus= $this->getMockBuilder(CommandBus::class)
                                ->setMethods(['getTransaction', 'getCommandHandlerFactory'])
                                ->setConstructorArgs([$this->commandHandlerFactory->reveal()])
                                ->getMock();
        $this->commandBus->expects($this->once())
                         ->method('getCommandHandlerFactory')
                         ->willReturn($this->commandHandlerFactory->reveal());
        
        $result = $this->commandBus->send($this->command->reveal());
        
        $this->assertTrue($result);
    }
}

<?php

return [
    //core class
    'System\Classes\Cache' => S_ROOT.'System/Classes/Cache.class.php',
    'System\Classes\CommandBus' => S_ROOT.'System/Classes/CommandBus.class.php',
    'System\Classes\Controller' => S_ROOT.'System/Classes/Controller.class.php',
    'System\Classes\Cookie' => S_ROOT.'System/Classes/Cookie.class.php',
    'System\Classes\Filter' => S_ROOT.'System/Classes/Filter.class.php',
    'System\Classes\Request' => S_ROOT.'System/Classes/Request.class.php',
    'System\Classes\Response' => S_ROOT.'System/Classes/Response.class.php',
    'System\Classes\Error' => S_ROOT.'System/Classes/Error.class.php',
    'System\Classes\Event' => S_ROOT.'System/Classes/Event.class.php',
    'System\Classes\Session' => S_ROOT.'System/Classes/Session.class.php',
    'System\Classes\Server' => S_ROOT.'System/Classes/Server.class.php',
    'System\Classes\Translator' => S_ROOT.'System/Classes/Translator.class.php',
    'System\Classes\ValidateStrategy' => S_ROOT.'System/Classes/ValidateStrategy.class.php',
    'System\Classes\NullCommandHandler' => S_ROOT.'System/Classes/NullCommandHandler.class.php',
    'System\Adapter\ConcurrentAdapter' => S_ROOT.'System/Adapter/ConcurrentAdapter.class.php',
    'System\Adapter\Restful\GuzzleConcurrentAdapter' =>
    S_ROOT.'System/Adapter/Restful/GuzzleConcurrentAdapter.class.php',
    'System\Adapter\Restful\GuzzleAdapter' => S_ROOT.'System/Adapter/Restful/GuzzleAdapter.class.php',
    'System\Adapter\Restful\NullResponse' => S_ROOT.'System/Adapter/Restful/NullResponse.class.php',

    //command
    'System\Command\Cache\SaveCacheCommand' => S_ROOT.'System/Command/Cache/SaveCacheCommand.class.php',
    'System\Command\Cache\DelCacheCommand' => S_ROOT.'System/Command/Cache/DelCacheCommand.class.php',

    //strategy
    'System\Strategy\Validate\IntStrategy' => S_ROOT.'System/Strategy/Validate/IntStrategy.class.php',
    'System\Strategy\Validate\FloatStrategy' => S_ROOT.'System/Strategy/Validate/FloatStrategy.class.php',
    'System\Strategy\Validate\StringStrategy' => S_ROOT.'System/Strategy/Validate/StringStrategy.class.php',
    'System\Strategy\Validate\DateStrategy' => S_ROOT.'System/Strategy/Validate/DateStrategy.class.php',
    'System\Strategy\Validate\EmailStrategy' => S_ROOT.'System/Strategy/Validate/EmailStrategy.class.php',

    //interfaces
    'System\Interfaces\Command' => S_ROOT.'System/Interfaces/Command.class.php',
    'System\Interfaces\Observer' => S_ROOT.'System/Interfaces/Observer.class.php',
    'System\Interfaces\Subject' => S_ROOT.'System/Interfaces/Subject.class.php',
    'System\Interfaces\CacheLayer' => S_ROOT.'System/Interfaces/CacheLayer.class.php',
    'System\Interfaces\IAsyncAdapter' => S_ROOT.'System/Interfaces/IAsyncAdapter.class.php',
    'System\Interfaces\ICommand' => S_ROOT.'System/Interfaces/ICommand.class.php',
    'System\Interfaces\ICommandHandler' => S_ROOT.'System/Interfaces/ICommandHandler.class.php',
    'System\Interfaces\ICommandHandlerFactory' => S_ROOT.'System/Interfaces/ICommandHandlerFactory.class.php',
    'System\Interfaces\INull' => S_ROOT.'System/Interfaces/INull.class.php',
    'System\Interfaces\IRepository' => S_ROOT.'System/Interfaces/IRepository.class.php',
    'System\Interfaces\IResponseFormatter' => S_ROOT.'System/Interfaces/IResponseFormatter.class.php',
    'System\Interfaces\IValidateStrategy' => S_ROOT.'System/Interfaces/IValidateStrategy.class.php',

    //core observer
    'System\Observer\CacheObserver' => S_ROOT.'System/Observer/CacheObserver.class.php',
    'System\Observer\Subject' => S_ROOT.'System/Observer/Subject.class.php',

    //Query
    'System\Query\FragmentCacheQuery' => S_ROOT.'System/Query/FragmentCacheQuery.class.php',
    'System\Query\DataCacheQuery' => S_ROOT.'System/Query/DataCacheQuery.class.php',
];

<?php

return [
    //core class
    'System\Classes\Cache' => S_ROOT.'System/Classes/Cache.class.php',
    'System\Classes\CommandBus' => S_ROOT.'System/Classes/CommandBus.class.php',
    'System\Classes\Controller' => S_ROOT.'System/Classes/Controller.class.php',
    'System\Classes\Cookie' => S_ROOT.'System/Classes/Cookie.class.php',
    'System\Classes\Error' => S_ROOT.'System/Classes/Error.class.php',
    'System\Classes\Event' => S_ROOT.'System/Classes/Event.class.php',
    'System\Classes\Filter' => S_ROOT.'System/Classes/Filter.class.php',
    'System\Classes\NullCommandHandler' => S_ROOT.'System/Classes/NullCommandHandler.class.php',
    'System\Classes\Request' => S_ROOT.'System/Classes/Request.class.php',
    'System\Classes\Response' => S_ROOT.'System/Classes/Response.class.php',
    'System\Classes\Server' => S_ROOT.'System/Classes/Server.class.php',
    'System\Classes\Session' => S_ROOT.'System/Classes/Session.class.php',
    'System\Classes\Translator' => S_ROOT.'System/Classes/Translator.class.php',

    //adapter
    'System\Adapter\ConcurrentAdapter' => S_ROOT.'System/Adapter/ConcurrentAdapter.class.php',
    'System\Adapter\Restful\GuzzleConcurrentAdapter' =>
    S_ROOT.'System/Adapter/Restful/GuzzleConcurrentAdapter.class.php',
    'System\Adapter\Restful\GuzzleAdapter' => S_ROOT.'System/Adapter/Restful/GuzzleAdapter.class.php',
    'System\Adapter\Restful\NullResponse' => S_ROOT.'System/Adapter/Restful/NullResponse.class.php',
    'System\Adapter\Restful\CacheResponse' => S_ROOT.'System/Adapter/Restful/CacheResponse.class.php',
    //adapter.adapter
    'System\Adapter\Restful\Adapter\CacheResponse\ICacheResponseAdapter' =>
    S_ROOT.'System/Adapter/Restful/Adapter/CacheResponse/ICacheResponseAdapter.class.php',
    'System\Adapter\Restful\Adapter\CacheResponse\Query\CacheResponseDataCacheQuery' =>
    S_ROOT.'System/Adapter/Restful/Adapter/CacheResponse/Query/CacheResponseDataCacheQuery.class.php',
    'System\Adapter\Restful\Adapter\CacheResponse\Query\Persistence\CacheResponseCache' =>
    S_ROOT.'System/Adapter/Restful/Adapter/CacheResponse/Query/Persistence/CacheResponseCache.class.php',
    'System\Adapter\Restful\Adapter\CacheResponse\CacheResponseCacheAdapter' =>
    S_ROOT.'System/Adapter/Restful/Adapter/CacheResponse/CacheResponseCacheAdapter.class.php',
    //adapter.translator
    'System\Adapter\Restful\Translator\CacheResponseTranslator' =>
    S_ROOT.'System/Adapter/Restful/Translator/CacheResponseTranslator.class.php',
    //adapter.respository
    'System\Adapter\Restful\Repository\CacheResponseRepository' =>
    S_ROOT.'System/Adapter/Restful/Repository/CacheResponseRepository.class.php',
    //adapter.strategy
    'System\Adapter\Restful\Strategy\PeriodCacheStrategy' =>
    S_ROOT.'System/Adapter/Restful/Strategy/PeriodCacheStrategy.class.php',
    'System\Adapter\Restful\Strategy\EtagCacheStrategy' =>
    S_ROOT.'System/Adapter/Restful/Strategy/EtagCacheStrategy.class.php',

    //command
    'System\Command\Cache\SaveCacheCommand' => S_ROOT.'System/Command/Cache/SaveCacheCommand.class.php',
    'System\Command\Cache\DelCacheCommand' => S_ROOT.'System/Command/Cache/DelCacheCommand.class.php',

    //interfaces
    'System\Interfaces\CacheLayer' => S_ROOT.'System/Interfaces/CacheLayer.class.php',
    'System\Interfaces\Command' => S_ROOT.'System/Interfaces/Command.class.php',
    'System\Interfaces\IAsyncAdapter' => S_ROOT.'System/Interfaces/IAsyncAdapter.class.php',
    'System\Interfaces\ICommand' => S_ROOT.'System/Interfaces/ICommand.class.php',
    'System\Interfaces\ICommandHandler' => S_ROOT.'System/Interfaces/ICommandHandler.class.php',
    'System\Interfaces\ICommandHandlerFactory' => S_ROOT.'System/Interfaces/ICommandHandlerFactory.class.php',
    'System\Interfaces\INull' => S_ROOT.'System/Interfaces/INull.class.php',
    'System\Interfaces\IRepository' => S_ROOT.'System/Interfaces/IRepository.class.php',
    'System\Interfaces\Observer' => S_ROOT.'System/Interfaces/Observer.class.php',
    'System\Interfaces\Subject' => S_ROOT.'System/Interfaces/Subject.class.php',
    'System\Interfaces\IView' => S_ROOT.'System/Interfaces/IView.class.php',

    //view
    'System\View\TemplateView' => S_ROOT.'System/View/TemplateView.class.php',
    'System\View\ErrorTemplateView' => S_ROOT.'System/View/ErrorTemplateView.class.php',
    'System\View\ErrorJsonView' => S_ROOT.'System/View/ErrorJsonView.class.php',
    'System\View\SuccessTemplateView' => S_ROOT.'System/View/SuccessTemplateView.class.php',
    'System\View\SuccessJsonView' => S_ROOT.'System/View/SuccessJsonView.class.php',
    'System\View\JsonView' => S_ROOT.'System/View/JsonView.class.php',
    'System\View\Smarty' => S_ROOT.'System/View/Smarty.class.php',

    //Query
    'System\Query\FragmentCacheQuery' => S_ROOT.'System/Query/FragmentCacheQuery.class.php',
    'System\Query\DataCacheQuery' => S_ROOT.'System/Query/DataCacheQuery.class.php',

    //extension
    'System\Extension\Monolog\FluentdHandler' => S_ROOT.'System/Extension/Monolog/FluentdHandler.class.php',
];

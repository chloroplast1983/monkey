<?php
namespace Member\Adapter\User;

use Marmot\Core;

use Member\Model\User;
use Member\Model\NullUser;
use Member\Adapter\User\Query\UserSessionDataCacheQuery;
use Member\Translator\UserSessionTranslator;

class UserSessionAdapter
{
    private $session;
    private $translator;

    public function __construct()
    {
        $this->session = new UserSessionDataCacheQuery();
        $this->translator = new UserSessionTranslator();
    }

    protected function getTTL() : int
    {
        return Core::$container->has('cache.session.ttl') ? Core::$container->get('cache.session.ttl') : 300;
    }

    protected function getSession() : UserSessionDataCacheQuery
    {
        return $this->session;
    }

    protected function getTranslator() : UserSessionTranslator
    {
        return $this->translator;
    }

    public function get(int $id) : User
    {
        $info = $this->getSession()->get($id);

        return empty($info) ? new NullUser() : $this->getTranslator()->arrayToObject($info);
    }

    public function add(User $user) : bool
    {
        $info = $this->getTranslator()->objectToArray($user);

        return $this->getSession()->save($user->getId(), $info, $this->getTTL());
    }

    public function del(int $id) : bool
    {
        return $this->getSession()->del($id);
    }
}

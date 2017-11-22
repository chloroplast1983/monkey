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

    const SESSION_LIVE_TIME = 300;

    public function __construct()
    {
        $this->session = new UserSessionDataCacheQuery();
        $this->translator = new UserSessionTranslator();
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

        return $this->getSession()->save($user->getId(), $info, self::SESSION_LIVE_TIME);
    }

    public function del(int $id) : bool
    {
        return $this->getSession()->del($id);
    }
}

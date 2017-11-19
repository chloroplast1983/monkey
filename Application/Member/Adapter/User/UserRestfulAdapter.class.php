<?php
namespace Member\Adapter\User;

use System\Adapter\Restful\GuzzleAdapter;
use System\Interfaces\IAsyncAdapter;

use Marmot\Core;
use Member\Translator\UserRestfulTranslator;
use Member\Model\User;
use Member\Model\NullUser;

/**
 * User 默认适配器,默认为内部MicroService
 */
class UserRestfulAdapter extends GuzzleAdapter implements IUserAdapter, IAsyncAdapter
{
    private $translator;

    private const SCENARIOS = [
        'USERNAME'=>[
            'fields'=>['users'=>'userName']
        ]
    ];
    
    public function __construct()
    {
        parent::__construct(
            Core::$container->get('services.user.url')
        );
        $this->translator = new UserRestfulTranslator();
        $this->scenario = array();
    }

    public function scenario($scenario) : void
    {
        $this->scenario = isset(self::SCENARIOS[$scenario]) ? self::SCENARIOS[$scenario] : array();
    }

    protected function getTranslator()
    {
        return $this->translator;
    }

    public function fetchOne(int $id) : User
    {
        $this->get(
            'users/'.$id
        );

        return $this->isSuccess() ? $this->translate()[$id] : new NullUser();
    }

    public function fetchList(array $ids) : array
    {
        $this->get(
            'users/'.implode(',', $ids)
        );

        return $this->isSuccess() ? $this->translate() : array();
    }

    public function search(
        array $filter = array(),
        array $sort = array(),
        int $number = 0,
        int $size = 20
    ) : array {
    
        $this->get(
            'users',
            array(
                'filter'=>$filter,
                'sort'=>$sort,
                'page'=>array('size'=>$size, 'number'=>$number)
            )
        );

        return $this->isSuccess() ? $this->translate() : array();
    }

    public function fetchOneAsync(int $id)
    {
        return $this->getAsync(
            'users/'.$id
        );
    }

    public function fetchListAsync(array $ids)
    {
        return $this->getAsync(
            'users/'.implode(',', $ids)
        );
    }

    public function searchAsync(
        array $filter = array(),
        array $sort = array(),
        int $number = 0,
        int $size = 20
    ) {
        return $this->getAsync(
            'users',
            array(
                'filter'=>$filter,
                'sort'=>$sort,
                'page'=>array('size'=>$size, 'number'=>$number)
            )
        );
    }

    protected function translate()
    {
        return $this->getTranslator()->arrayToObject($this->getContents());
    }

    public function signUp(User $user) : User
    {
        $data = $this->getTranslator()->objectToArray(
            $user,
            array(
                'cellPhone',
                'password'
            )
        );
        
        $this->post(
            'users',
            $data
        );

        return $this->isSuccess() ? current($this->translate()) : NullUser();
    }

    public function updatePassword(User $user) : bool
    {
    }
}

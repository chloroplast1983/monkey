<?php
namespace Member\Adapter;

use Marmot\Core;
use GuzzleHttp;
use Member\Translator\ApplicationTranslator;
use Member\Model\User;

/**
 * User 默认适配器,默认为内部MicroService
 */
class UserAdapter implements IUserAdapter
{

    private $client;
    private $translator;
    

    public function __construct()
    {
        $this->client = new GuzzleHttp\Client(
            ['base_uri' => Core::$container->get('services.user.url').'/users']
        );
        $this->translator = new ApplicationTranslator();
    }

    public function getOne(int $id)
    {
        if (!empty($id)) {
            $response = $this->client->request(
                'GET',
                $id,
                [
                'haders'=>['Content-Type' => 'application/vnd.api+json'],
                ]
            );
            if ($response->getStatusCode() != '200') {
                return false;
            }
            $body = $response->getBody();
            
            $data = json_decode($body->getContents(), true);
            $data = $data['data'];
            if (empty($data)) {
                return false;
            }

            $user = $this->translator->arrayToObject($data['attributes']);
            if ($user instanceof User) {
                return $user;
            }
        }
        return false;
    }

    public function getList(string $ids)
    {
        if (!empty($id)) {
            $response = $this->client->request(
                'GET',
                $ids,
                [
                'haders'=>['Content-Type' => 'application/vnd.api+json'],
                ]
            );

            $statusCode = $response->getStatusCode();
            $body = $response->getBody();

            $userList = array();
            //200 返回成功有数据
            //204 返回成功但是无数据
            //links? 分页数据操作
            if (in_array($statusCode, array('200', '204'))) {
                $dataList = json_decode($body->getContents(), true);
                $dataList = $dataList['data'];
                if (!empty($dataList)) {
                    foreach ($dataList as $data) {
                        $userList[] = $this->translator->arrayToObject($data['attributes']);
                    }
                }
            }
            return $userList;
        }
        return false;
    }

    public function signUp(User $user, array $keys = array())
    {

        $data = $this->translator->objectToArray($user, $keys);

        $response = $this->client->request(
            'POST',
            '',
            [
            'haders'=>['Content-Type' => 'application/vnd.api+json'],
            'json' => $data
            ]
        );
        if ($response->getStatusCode() != '201') {
            return false;
        }
        $body = $response->getBody();
        
        $data = json_decode($body->getContents(), true);
        $data = $data['data'];
        if (empty($data)) {
            return false;
        }

        $user = $this->translator->arrayToObject($data['attributes']);
        if ($user instanceof User) {
            return $user;
        }
        
        return false;
    }
}

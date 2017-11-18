<?php
namespace Home\Controller;

use System\Classes\Controller;
use Common\Controller\CaptchaTrait;
use Marmot\Core;

use Member\Repository\User\UserRepository;

class IndexController extends Controller
{
    use CaptchaTrait;

    public function index()
    {

        var_dump($this->validateCaptcha('wkxc11'));
        exit();
        //var_dump($_SESSION['phrase']);exit();
        //exit();
//        if ($this->getRequest()->isAjax())
//        {
//
//        echo $this->getRequest()->getHeader('X-CSRF-TOKEN');
//        exit();
//        }
        //var_dump(Core::$container->get('user'));
        //exit();
        //var_dump(\Common\Utils\Mask::mask('1234142114',2,3));exit();
//        $latestUsersCache = new \Member\Cache\LatestUsersFragmentCache();
 //       $data = $latestUsersCache->get();
        $repository = new UserRepository();
        $data = $repository->scenario(UserRepository::LIST_MODEL_UN)->fetchOne(1);

        //$adapter = new UserRestfulAdapter();
      //  $userOne = $adapter->fetchList(array(2,3));
//        echo '<pre>';
//        $userOne = $repository->fetchOne(2);
//        var_dump($data);
//        var_dump($userOne);
//
        $this->getResponse()->view()->display('Home/index.tpl');
        return true;
    }
}

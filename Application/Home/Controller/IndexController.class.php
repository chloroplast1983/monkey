<?php
namespace Home\Controller;

use System\Classes\Controller;
use Common\Controller\CaptchaTrait;
use Marmot\Core;

use Member\Repository\User\UserRepository;

use Common\Controller\CsrfTokenTrait;

class IndexController extends Controller
{
    use CaptchaTrait;
    use CsrfTokenTrait;

    public function index()
    {
        //$this->test(1);
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
        //echo '<pre>';
       // $latestUsersCache->refresh();
        //var_dump($latestUsersCache->get());
        //exit();
 //       $data = $latestUsersCache->get();
//        $repository = new UserRepository();
 //       $data = $repository->fetchOne(1);
  //      var_dump($data);

        //$adapter = new UserRestfulAdapter();
      //  $userOne = $adapter->fetchList(array(2,3));
//        echo '<pre>';
       //$userOne = $repository->scenario(UserRepository::LIST_MODEL_UN)->fetchOne(1);
//        var_dump($data);
        //var_dump($userOne);
        //exit();
//
        $this->getResponse()->view()->display('Home/index.tpl');
        return true;
    }

    /**
     * 没有路由的widget
     */
    public function test(int $a)
    {
        $this->getResponse()->view()->assign('a', $a);
        $this->getResponse()->view()->display('Home/test.tpl');
    }
}

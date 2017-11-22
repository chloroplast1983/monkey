<?php
//powered by chloroplast
namespace System\Classes;

use Marmot\Core;
use System\Interfaces\IView;

/**
 * 应用层服务父类,控制应用服务层的 Request 和 Reponse
 */
abstract class Controller
{

    /**
     * @var Request $request 请求对象
     */
    private $request;

    /**
     * @var Response $response 响应对象
     */
    private $response;

    /**
     * 构造函数,请求初始化 请求对象 和 响应对象
     */
    public function __construct()
    {
        $this->request = new Request();
        $this->response = new Response();
    }

    /**
     * 析构函数
     */
    public function __destruct()
    {
        unset($this->request);
        unset($this->response);
    }

    /**
     * 获取 request 对象
     */
    protected function getRequest() : Request
    {
        return $this->request;
    }

    /**
     * 获取 response 对象
     */
    protected function getResponse() : Response
    {
        return $this->response;
    }

   /**
     * 渲染输出内容
     * @var array|string 输出源内容
     */
    public function render($data = '')
    {
        $this->getResponse()->data = $data;
        return $this->getResponse()->send();
    }

    public function displayError()
    {
    }

    public function error()
    {
        header('HTTP/1.1 500 Internal Server Error');
    }

    public function notFound()
    {
        header('HTTP/1.1 404 Not Found');
    }
}

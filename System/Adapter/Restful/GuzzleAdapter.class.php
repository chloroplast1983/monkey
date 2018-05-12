<?php
namespace System\Adapter\Restful;

use System\Classes\Server;
use System\Classes\Translator;

use GuzzleHttp;
use GuzzleHttp\Exception\RequestException;

use Marmot\Core;

abstract class GuzzleAdapter
{
    private $client;

    protected $scenario;

    protected $statusCode;

    protected $contents;

    protected $responseHeaders;

    protected $requestHeaders;

    public function __construct(string $baseurl)
    {
        $this->client = new GuzzleHttp\Client(
            [
             'base_uri'=>$baseurl,
             'http_errors'=>false,
             'timeout'=>5
            ]
        );

        $this->requstHeaders = [
            'Accept-Encoding' => 'gzip',
            'Accept'=>'application/vnd.api+json',
            'Request-Id'=>Server::get('REQUEST_ID', '')
        ];
    }

    public function __destruct()
    {
        unset($this->client);
        unset($this->requstHeaders);
        unset($this->responseHeaders);
    }

    abstract protected function getTranslator() : Translator;

    abstract public function scenario($scenario) : void;

    protected function getClient()
    {
        return $this->client;
    }

    protected function setStatusCode(int $statusCode) : void
    {
        $this->statusCode = $statusCode;
    }

    protected function getStatusCode() : int
    {
        return $this->statusCode;
    }

    protected function setContents(string $contents) : void
    {
        $this->contents = $contents;
    }

    protected function getContents() : array
    {
        $contents = '';

        if (!empty($this->contents)) {
            $contents = json_decode($this->contents, true);
        }
        return is_array($contents) ? $contents : array();
    }

    protected function setRequestHeaders(array $requestHeaders) : void
    {
        $this->requstHeaders = $requestHeaders;
    }

    protected function getRequestHeaders() : array
    {
        return $this->requstHeaders;
    }

    protected function setResponseHeaders(array $responseHeaders) : void
    {
        $this->responseHeaders = $responseHeaders;
    }

    protected function getResponseHeaders(array $responseHeaders) : array
    {
        return $this->getRequestHeaders();
    }

    protected function get(string $url, array $query = array(), array $requestHeaders = array())
    {
        $requestHeaders = array_merge($requestHeaders, $this->getRequestHeaders());
        $query = array_merge($this->getScenario(), $query);

        $this->clearScenario();

        try {
            $response = $this->getClient()->get(
                $url,
                [
                    'headers'=>$requestHeaders,
                    'query'=>$query
                ]
            );
        } catch (RequestException $e) {
            //log
            $response = new NullResponse();
        }
        $this->formatResponse($response);
    }

    protected function getAsync(string $url, array $query = array(), array $requestHeaders = array())
    {
        $requestHeaders = array_merge($requestHeaders, $this->getRequestHeaders());
        $query = array_merge($this->getScenario(), $query);

        $this->clearScenario();

        return $this->getClient()->getAsync(
            $url,
            [
                'headers'=>$requestHeaders,
                'query'=>$query
            ]
        );
    }

    protected function put(string $url, array $data = array(), array $requestHeaders = array())
    {
        $requestHeaders = array_merge($requestHeaders, $this->getRequestHeaders());

        try {
            $response = $this->getClient()->put(
                $url,
                [
                    'headers'=>$requestHeaders,
                    'json'=>$data
                ]
            );
        } catch (RequestException $e) {
            //log
            $response = new NullResponse();
        }
        $this->formatResponse($response);
    }

    protected function patch(string $url, array $data = array(), array $requestHeaders = array())
    {
        $requestHeaders = array_merge($requestHeaders, $this->getRequestHeaders());

        try {
            $response = $this->getClient()->patch(
                $url,
                [
                    'headers'=>$requestHeaders,
                    'json'=>$data
                ]
            );
        } catch (RequestException $e) {
            //log
            $response = new NullResponse();
        }
        $this->formatResponse($response);
    }

    protected function post(string $url, array $data = array(), array $requestHeaders = array())
    {
        $contentTypeHeader = ['Content-Type' => 'application/vnd.api+json'];
        $requestHeaders = array_merge_recursive($requestHeaders, $this->getRequestHeaders(), $contentTypeHeader);

        try {
            $response = $this->getClient()->post(
                $url,
                [
                    'headers'=>$requestHeaders,
                    'json'=>$data
                ]
            );
        } catch (RequestException $e) {
            //log
            $response = new NullResponse();
        }
        $this->formatResponse($response);
    }

    protected function delete(string $url, array $requestHeaders = array())
    {
        $requestHeaders = array_merge($requestHeaders, $this->getRequestHeaders());

        try {
            $response = $this->getClient()->delete(
                $url,
                [
                    'headers'=>$requestHeaders
                ]
            );
        } catch (RequestException $e) {
            //log
            $response = new NullResponse();
        }
        $this->formatResponse($response);
    }

    protected function isSuccess() : bool
    {
        if ($this->getStatusCode() >= 200 && $this->getStatusCode() < 300) {
            return true;
        }
        $this->translatError();
        return false;
    }

    protected function translatError()
    {
        $id = $this->getErrorId();
        $apiErrors = include_once S_ROOT.'Application/apiErrorConfig.php';
        if (isset($apiErrors[$id])) {
            Core::setLastError($apiErrors[$id]);
        }
    }

    private function getErrorId()
    {
        $contents = $this->getContents();

        return isset($contents['errors']) ? $contents['errors'][0]['id'] : 0;
    }

    protected function isCached() : bool
    {
        return $this->getStatusCode() == 304;
    }

    protected function isRequestError() : bool
    {
        return ($this->getStatusCode() >= 400 && $this->getStatusCode() < 500);
    }

    protected function isResponseError() : bool
    {
        return ($this->getStatusCode() >= 500 && $this->getStatusCode() <= 599);
    }

    protected function formatResponse($response) : void
    {
        $this->setStatusCode($response->getStatusCode());
        $this->setContents($response->getBody()->getContents());
        $this->setResponseHeaders($response->getHeaders());
    }

    protected function translateToObject($object = null)
    {
        return $this->getTranslator()->arrayToObject($this->getContents(), $object);
    }

    protected function translateToObjects()
    {
        return $this->getTranslator()->arrayToObjects($this->getContents());
    }

    protected function getScenario() : array
    {
        return $this->scenario;
    }

    private function clearScenario() : void
    {
        $this->scenario = array();
    }

    public function handleAsync($statusCode, $contents, $responseHeaders)
    {
        $this->setStatusCode($statusCode);
        $this->setContents($contents);
        $this->setResponseHeaders($responseHeaders);

        if ($this->isSuccess()) {
            return $this->translateToObjects();
        }
        return '';
    }
}

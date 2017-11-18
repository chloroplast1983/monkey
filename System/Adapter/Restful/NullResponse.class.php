<?php
namespace System\Adapter\Restful;

use GuzzleHttp\Psr7\Response;

class NullResponse extends Response
{
    public function getStatusCode()
    {
        return 504;
    }
}

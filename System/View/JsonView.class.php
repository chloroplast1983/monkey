<?php
namespace System\View;

abstract class JsonView
{
    const STATUS_SUCCESS = 1;
    const STATUS_FAILURE = 0;

    private $status;
    private $result;

    public function __construct()
    {
        $this->status = self::STATUS_SUCCESS;
        $this->result = array(
            'status' => $this->status,
            'data' => array()
        );
    }

    public function success() : self
    {
        $this->result['status'] = self::STATUS_SUCCESS;
        return $this;
    }

    public function failure() : self
    {
        $this->result['status'] = self::STATUS_FAILURE;
        return $this;
    }

    protected function getData()
    {
        return $this->data;
    }

    protected function getResult() : array
    {
        return $this->result;
    }

    protected function encode(array $data) : void
    {
        $this->result['data'] = $data;

        echo json_encode($this->getResult());
    }
}

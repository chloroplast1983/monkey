<?php
namespace System\Classes;

abstract class Session
{
    private $key;

    protected function __construct(string $key)
    {
        $this->key = $key;
    }

    protected function getKey() : string
    {
        return $this->key;
    }

    public function save($id, $data)
    {
        $key = $this->formatKey($id);

        $_SESSION[$key] = $data;

        return true;
    }

    public function get($id, $defaultValue = '')
    {
        $key = $this->formatKey($id);

        return isset($_SESSION[$key]) ? $_SESSION[$key] : $defaultValue;
    }

    public function del($id)
    {
        $key = $this->formatKey($id);

        unset($_SESSION[$key]);
    }

    private function formatKey($id) : string
    {
        return $this->getKey().'.'.$id;
    }
}

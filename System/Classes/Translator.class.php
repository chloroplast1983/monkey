<?php
namespace System\Classes;

abstract class Translator
{
    abstract public function arrayToObjects(array $expression) : array;
    abstract public function arrayToObject(array $expression, $object = null);
    abstract public function objectToArray($object);
}

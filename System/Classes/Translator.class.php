<?php
namespace System\Classes;

abstract class Translator
{
    abstract public function arrayToObject(array $expression);
    abstract public function objectToArray($object);
}

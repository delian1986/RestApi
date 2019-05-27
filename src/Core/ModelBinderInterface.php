<?php


namespace Src\Core;


interface ModelBinderInterface
{
    public function bind(array $from,$className);
}
<?php


namespace talismanfr\geocode\exeptions;


class ProxyConfException extends \Exception
{

    public function getName(){
        return 'Proxy Config Exception';
    }

    public function __toString()
    {
        return parent::__toString();
    }
}
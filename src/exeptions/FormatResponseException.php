<?php


namespace talismanfr\geocode\exeptions;


class FormatResponseException extends \Exception
{
    public function getName(){
        return 'Error Format Response';
    }

    public function __toString()
    {
        parent::__toString();
    }
}
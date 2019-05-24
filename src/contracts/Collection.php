<?php


namespace talismanfr\geocode\contracts;


interface Collection
{
    public function get($query):array;

    public function one($query);

}
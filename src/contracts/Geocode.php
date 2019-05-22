<?php


namespace talismanfr\geocode\contracts;


interface Geocode
{
    public function get($query,$params=[]);

}
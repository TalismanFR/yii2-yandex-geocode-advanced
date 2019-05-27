<?php


namespace talismanfr\geocode\decorators;


use talismanfr\geocode\contracts\Geocode;
use yii\caching\CacheInterface;

class GeocodeCache implements Geocode
{
    /** @var Geocode  */
    private $geocode;

    /** @var \yii\caching\CacheInterface */
    private $cache;

    public $duration=null;

    public $dependency=null;

    public function __construct(Geocode $geocode,CacheInterface $cache)
    {
        $this->geocode=$geocode;
        $this->cache=$cache;
    }

    public function get($query, $params = [])
    {
        return $this->cache->getOrSet($query,function ()use($query){
            return $this->geocode->get($query);
        },$this->duration,$this->dependency);
    }
}
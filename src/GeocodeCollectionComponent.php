<?php


namespace talismanfr\geocode;


use talismanfr\geocode\contracts\Collection;
use yii\base\Component;

class GeocodeCollectionComponent extends Component implements Collection
{
    public $apikey;

    public $useProxy = false;

    public $proxyConf = [
        'url' => '127.0.0.1',
        'port' => '3128',
        'login' => null,
        'password' => null
    ];

    private $geocode;

    /** @var Collection */
    private $collection;

    public function init()
    {
        parent::init();

        if(\Yii::$container->has(\talismanfr\geocode\contracts\Geocode::class)){
            $this->geocode=\Yii::$container->get(\talismanfr\geocode\contracts\Geocode::class);
        }else{
            $geocode=new Geocode();
            $geocode->apikey=$this->apikey;
            $geocode->useProxy=$this->useProxy;
            $geocode->proxyConf=$this->proxyConf;
            $this->geocode=$geocode;
        }

        $this->collection=new GeocodeCollection($this->geocode);
    }

    public function get($query): array
    {
        return $this->collection->get($query);
    }

    public function one($query)
    {
        return $this->collection->one($query);
    }
}
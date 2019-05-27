<?php

class GeocodeCollectionTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    /** @var \talismanfr\geocode\contracts\Geocode */
    private $geocode;



    protected function _before()
    {
        $this->geocode=new \talismanfr\geocode\Geocode();
    }

    private function getBadResponseFormat(){
        return $this->makeEmpty(\talismanfr\geocode\contracts\Geocode::class,
            ['get'=>'{"bad_format":"response"}']);
    }

    private function getBadJsonFormat(){
        return $this->makeEmpty(\talismanfr\geocode\contracts\Geocode::class,
            ['get'=>[]]);
    }

    protected function _after()
    {
    }

    // tests
    public function testGet()
    {
        $collection=new \talismanfr\geocode\GeocodeCollection($this->geocode);
        $all=$collection->get('Novokuznetsk');
        $geo=array_shift($all);

        $this->tester->assertInstanceOf(\talismanfr\geocode\entity\Geo::class,$geo);

        //bad query string
        $geos=$collection->get('asdf asdf');
        $this->tester->assertEquals([],$geos);

        //test bad response format from geocode
        $collection=new \talismanfr\geocode\GeocodeCollection($this->getBadResponseFormat());
        $this->tester->expectException(\talismanfr\geocode\exeptions\FormatResponseException::class,
            function()use($collection){
                $collection->get('Новокузнецк');
            });

        //test bad response JSON format from geocode
        $collection=new \talismanfr\geocode\GeocodeCollection($this->getBadJsonFormat());
        $this->tester->expectException(\talismanfr\geocode\exeptions\FormatResponseException::class,
            function()use($collection){
                $collection->get('Moscow');
            });


    }

    public function testOne(){
        $collection=new \talismanfr\geocode\GeocodeCollection($this->geocode);
        $geo=$collection->one('Новокузнецк');
        $this->tester->assertInstanceOf(\talismanfr\geocode\entity\Geo::class,$geo);
        $this->tester->assertNotEmpty($geo->getAddress()->getKindName('locality'));
        $this->tester->assertNotEmpty($geo->getAddressDetails()->getCountryName());

        $geo=$collection->one('qqwerrt');
        $this->tester->assertNull($geo);
    }
}

class BadGeocode implements \talismanfr\geocode\contracts\Geocode {

    public function get($query, $params = [])
    {
        return '{"bad_format":"response"}';
    }
}
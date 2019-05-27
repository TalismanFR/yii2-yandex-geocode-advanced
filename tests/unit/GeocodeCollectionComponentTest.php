<?php

class GeocodeCollectionComponentTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    
    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function testCreateComponent()
    {
        $collection=Yii::createObject(['class'=>\talismanfr\geocode\GeocodeCollectionComponent::class]);

        $this->tester->assertInstanceOf(\talismanfr\geocode\GeocodeCollectionComponent::class,$collection);
    }

    public function testGet(){

//        $collection=Yii::createObject(['class'=>\talismanfr\geocode\GeocodeCollectionComponent::class]);

        $collection=new \talismanfr\geocode\GeocodeCollectionComponent();
        $geos=$collection->get('Moscow');

        $this->assertArrayHasKey(0,$geos);

        $geo=$geos[0];

        $this->assertInstanceOf(\talismanfr\geocode\entity\Geo::class,$geo);
    }

    public function testOne(){
        $collection=Yii::createObject(['class'=>\talismanfr\geocode\GeocodeCollectionComponent::class]);

        $geo=$collection->one('Moscow');

        $this->assertInstanceOf(\talismanfr\geocode\entity\Geo::class,$geo);
    }
}
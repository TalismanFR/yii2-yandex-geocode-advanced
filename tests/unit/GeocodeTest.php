<?php

class GeocodeTest extends \Codeception\Test\Unit
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
    public function testGet()
    {
        $geo=new \talismanfr\geocode\Geocode();


        $result=$geo->get('Новокузнецк');
        $this->tester->assertStringStartsWith('{"response":',$result,'Response not valid');

        //with proxy
        $geo->useProxy=true;

        //exception if url proxy is empty
        $this->tester->expectException(\talismanfr\geocode\exeptions\ProxyConfException::class,function ()use($geo){
            $geo->proxyConf=[
                'url'=>'',
                'port'=>'37837'
            ];
            $geo->get('Новокузнецк');
        });



//        $geo->proxyConf=[
//            'url'=>'195.123.228.201',
//            'port'=>'3128',
//        ];
//
//        $result=$geo->get('moscow');
//        $this->tester->assertStringStartsWith('{"response":',$result,'Response not valid');
    }
}
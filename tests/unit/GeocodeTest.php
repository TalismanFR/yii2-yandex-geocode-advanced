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

//        //error api key
//        $geo->apikey='invalid_api_key';
//        $result=$geo->get('Moscow');
//        $this->tester->assertStringStartsWith('{"error":',$result,'Response not valid');

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



        $geo->proxyConf=[
            'url'=>'88.82.73.242',
            'port'=>'37837'
        ];

        $result=$geo->get('Новокузнецк');

        $this->tester->assertStringStartsWith('{"response":',$result,'Response not valid');
    }
}
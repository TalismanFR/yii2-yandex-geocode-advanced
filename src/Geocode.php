<?php


namespace talismanfr\geocode;


use talismanfr\geocode\exeptions\ProxyConfException;
use yii\db\Exception;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

class Geocode implements \talismanfr\geocode\contracts\Geocode
{

    public $url = 'https://geocode-maps.yandex.ru/1.x/';

    public $apikey = null;

    public $useProxy = false;

    public $proxyConf = [
        'schema' => 'tcp',
        'url' => '127.0.0.1',
        'port' => '3128',
        'login' => null,
        'password' => null
    ];

    /**
     * @param $query
     * @param array $params
     * @return string
     * @throws ProxyConfException
     */
    public function get($query, $params = []):string
    {
        $params['geocode'] = $query;

        $url = $this->buildUrl($params);

        $curl = curl_init();
        curl_setopt(CURLOPT_URL,$url);

        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => true,
            // CURLOPT_ENCODING => "deflate,gzip,none",
            CURLOPT_HEADER => false,
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_VERBOSE => false,
            CURLOPT_PROXY=>$proxy,
            CURLOPT_PROXYPORT=>$port,
            CURLOPT_PROXYUSERPWD=>\Yii::$app->params['proxy_login'].':'.\Yii::$app->params['proxy_password']
        ]);

        return $response;
    }

    /**
     * @return resource A stream context resource.
     * @throws ProxyConfException
     */
    private function getCurlConf():array
    {
        $conf=[
            CURLOPT_RETURNTRANSFER=>true,
            CURLOPT_HEADER=>false,
            CURLOPT_FOLLOWLOCATION=>false,
            CURLOPT_VERBOSE=>false,
        ];

        if($this->useProxy){

        }
    }

    /**
     * Build array conf proxy for stream context
     * @return array
     * @throws ProxyConfException
     */
    private function buildProxyConf(): array
    {
        $schema = ArrayHelper::getValue($this->proxyConf, 'schema', 'tcp');
        $url = ArrayHelper::getValue($this->proxyConf, 'url');

        if (empty($url)) {
            throw new ProxyConfException('url param is empty');
        }

        $port = ArrayHelper::getValue($this->proxyConf, 'port', '3128');

        $conf = ['proxy' => $schema . '://' . $url . ':' . $port, 'request_fulluri' => true];

        $login = ArrayHelper::getValue($this->proxyConf, 'login');
        $password = ArrayHelper::getValue($this->proxyConf, 'password');

        if (!empty($login)) {
            $auth = base64_encode($login . ':' . $password);

            $conf['header'] = "Proxy-Authorization: Basic $auth";
        }

        return $conf;
    }

    /**
     * Generate Url
     * @param $params
     * @return string
     */
    private function buildUrl(array $params)
    {
        $params['format'] = 'json';

        if (!empty($this->apikey)) {
            $params['apikey'] = $this->apikey;
        }

        return $this->url . '?' . http_build_query($params);
    }
}
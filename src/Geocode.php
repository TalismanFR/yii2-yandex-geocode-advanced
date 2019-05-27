<?php


namespace talismanfr\geocode;


use talismanfr\geocode\exeptions\ProxyConfException;
use yii\helpers\ArrayHelper;

class Geocode implements \talismanfr\geocode\contracts\Geocode
{

    public $url = 'https://geocode-maps.yandex.ru/1.x/';

    public $apikey = null;

    public $useProxy = false;

    public $format = 'json';

    public $proxyConf = [
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
    public function get($query, $params = []): string
    {
        $params['geocode'] = $query;

        $url = $this->buildUrl($params);

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);

        curl_setopt_array($curl, $this->getCurlConf());

        $response = curl_exec($curl);

        return (string)$response;
    }

    /**
     * @return resource A stream context resource.
     * @throws ProxyConfException
     */
    private function getCurlConf(): array
    {
        $conf = [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => false,
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_VERBOSE => false,
        ];

        if ($this->useProxy) {

            $conf = ArrayHelper::merge($conf, $this->buildProxyConf());
        }

        return $conf;
    }

    /**
     * Build array conf proxy for stream context
     * @return array
     * @throws ProxyConfException
     */
    private function buildProxyConf(): array
    {
        $url = ArrayHelper::getValue($this->proxyConf, 'url');
        if (empty($url)) {
            throw new ProxyConfException('url param is empty');
        }
        $port = ArrayHelper::getValue($this->proxyConf, 'port', '3128');

        $conf = [CURLOPT_PROXY => $url, CURLOPT_PROXYPORT => $port];

        $login = ArrayHelper::getValue($this->proxyConf, 'login');
        $password = ArrayHelper::getValue($this->proxyConf, 'password');

        if (!empty($login)) {
            $conf[CURLOPT_PROXYUSERNAME] = $login;
            $conf[CURLOPT_PROXYPASSWORD] = $password;
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
        $params['format'] = $this->format;

        if (!empty($this->apikey)) {
            $params['apikey'] = $this->apikey;
        }

        return $this->url . '?' . http_build_query($params);
    }
}
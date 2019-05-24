<?php


namespace talismanfr\geocode;


use talismanfr\geocode\contracts\Collection;
use talismanfr\geocode\contracts\Geocode;
use talismanfr\geocode\entity\Address;
use talismanfr\geocode\entity\AddressDetails;
use talismanfr\geocode\entity\Geo;
use talismanfr\geocode\entity\Point;
use talismanfr\geocode\exeptions\FormatResponseException;
use yii\helpers\ArrayHelper;

class GeocodeCollection implements Collection
{
    private $geocode;

    public function __construct(Geocode $geocode)
    {
        $this->geocode = $geocode;
    }

    /**
     * Get array Geo entity
     * @param $query
     * @param array $params params fro url to yandex geocode service
     * @return array
     * @throws FormatResponseException
     */
    public function get($query, $params = []): array
    {
        return $this->find($query, $params);
    }

    /**
     * @param $query
     * @param array $params
     * @return Geo
     * @throws FormatResponseException
     */
    public function one($query,$params=[])
    {
        $params['results']=1;
        $geos=$this->find($query,$params);

        if(count($geos)>0){
            return array_shift($geos);
        }
    }

    /**
     * @param $query
     * @param array $params
     * @return array
     * @throws FormatResponseException
     */
    private function find($query, $params = []): array
    {
        $geo_result = $this->geocode->get($query, $params);

        try {
            $geo_result = json_decode((string)$geo_result, true);
        } catch (\Exception $e) {
            return [];
        }

        $data = ArrayHelper::getValue($geo_result, 'response.GeoObjectCollection.featureMember');

        if (!$data) {
            throw new FormatResponseException('Error format response from query ' . $query);
        }

        $geos = [];
        foreach ($data as $datum) {
            $geos[] = $this->mapsGeo($datum);
        }

        return $geos;

    }

    /**
     * @param array $data Data from response yandex geocode service
     * @return Geo
     */
    private function mapsGeo(array $data): Geo
    {
        $data = ArrayHelper::getValue($data, 'GeoObject');
        $name = ArrayHelper::getValue($data, 'name');
        $description = ArrayHelper::getValue($data, 'description');
        $meta = ArrayHelper::getValue($data, 'metaDataProperty.GeocoderMetaData');

        $kind = ArrayHelper::getValue($meta, 'kind');
        $text = ArrayHelper::getValue($meta, 'text');

        $address = Address::fromState(ArrayHelper::getValue($meta, 'Address'));
        $addressDetails = AddressDetails::fromState(ArrayHelper::getValue($meta, 'AddressDetails'));

        $point = new Point(ArrayHelper::getValue($data, 'Point.pos'));

        $geo = new Geo($address, $addressDetails, $point, $name, $description, $kind, $text);

        return $geo;
    }


}
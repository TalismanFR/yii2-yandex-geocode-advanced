Yii2 extension for use yandex geocode.
======================================
In addition to working with the service, the extension can cache or save queries to the database to optimize access to the API.

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist talismanfr/yii2-yandex-geocode-advanced "*"
```

or add

```
"talismanfr/yii2-yandex-geocode-advanced": "*"
```

to the require section of your `composer.json` file.

Usage as a Yii2 component collection
-----
Add to config:
```php
'compoennts'=>[
'geocodeCollection'=>[
            'class'=>'\talismanfr\geocode\GeocodeCollectionComponent',
            'apikey' => 'you_api_key'
        ],
        ...
]
```
and use

```php
//for find all
$all=\Yii::$app->geocodeCollection->get('Moscow');

foreach($all as $geo){
    echo $geo->getAddressDetails()->getCountryName();
}

/for find only one
$one=\Yii::$app->geocodeCollection->one('Moscow');

echo $one->getAddressDetails()->getCountryName();
```

Usage with DI container
-----

Add dependency to your DI container configuration:

```php
'talismanfr\geocode\contracts\Geocode'=>[
    'class'=>'talismanfr\geocode\Geocode',
    'apikey' => 'you_apikey_this'
]
```
If you want to use only the geocoder adapter itself:
```php
$geocode=Yii:container->get('talismanfr\geocode\contracts\Geocode');
$json_string_response=$geocode->get('Moscow',['results'=>1]);
```
This is a **string** variable with the text of the response from the Yandex Geocode service (JSON or XML).

If you want use Geocode Entity Collection
(see ```talismanfr\geocode\entity\Geo```):
```php
$collection=\Yii::$container->get(talismanfr\geocode\GeocodeCollection::class);

//for find all
$all=$collection->get('Moscow');

foreach($all as $geo){
    echo $geo->getAddressDetails()->getCountryName();
}

//for find only one record
$one=$collection->one('Moscow');

echo $geo->getAddressDetails()->getCountryName();
```


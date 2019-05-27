Yii2 extension for use yandex geocode.
======================================
In addition to working with the service, the extension can cache or save queries to the database to optimize access to the API.

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/TalismanFR/yii2-yandex-geocode-advanced/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/TalismanFR/yii2-yandex-geocode-advanced/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/TalismanFR/yii2-yandex-geocode-advanced/badges/build.png?b=master)](https://scrutinizer-ci.com/g/TalismanFR/yii2-yandex-geocode-advanced/build-status/master)
[![Code Intelligence Status](https://scrutinizer-ci.com/g/TalismanFR/yii2-yandex-geocode-advanced/badges/code-intelligence.svg?b=master)](https://scrutinizer-ci.com/code-intelligence)

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
(see `talismanfr\geocode\entity\Geo`):

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

Caching
------
You can use a special decorator `'talismanfr\geocode\decorators\GeocodeCache`.
All requests will go through the cache.

Setup example using DI

```php
[
    'geocode'=>['class'=>'talismanfr\geocode\Geocode','apikey' => 'api_key'],
    'talismanfr\geocode\contracts\Geocode'=>[
        ['class'=>'talismanfr\geocode\decorators\GeocodeCache','duration' => 10],
        [\yii\di\Instance::of('geocode')]
    ],
    'yii\caching\CacheInterface'=>function(){ return Yii::$app->cache;}
]
```
DataBase 
-----
In work...
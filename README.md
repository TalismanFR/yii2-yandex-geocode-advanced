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


Usage
-----

Once the extension is installed, simply use it in your code by  :

```php
<?= \talismanfr\geocode\AutoloadExample::widget(); ?>```
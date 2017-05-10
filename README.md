Yii2 Payments Environment
=========================
Simple payment environment for Yii2. It includes Transfer, Paypal and Credit Card systems

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist macklus/yii2-payments "*"
```

or add

```
"macklus/yii2-payments": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :

```php
<?= \macklus\payments\AutoloadExample::widget(); ?>```
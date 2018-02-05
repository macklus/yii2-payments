## Installation

Install of macklus/yii2-payments consists of two steps:

### Step 1: Install through composer

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist macklus/yii2-payments "*"
```

or add

```
"macklus/yii2-payments": "~1.0"
```

to the require section of your `composer.json` file.

### Step 2: run migrations

You need to install required tables, by running, from your framework directory:

```
php yii migrate/up --migrationPath=@vendor/macklus/yii2-payments/migrations/
```

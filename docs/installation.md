## Installation

Install of macklus/yii2-payments consists of two steps:

### Step 1: Install through composer

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist macklus/yii2-payments "~2.0"
```

or add

```
"macklus/yii2-payments": "~2.0"
```

to the require section of your `composer.json` file.

### Step 2: configure

You need to configure your app before running migrations, otherwise migrate hangs
(because it cannot find table names).

You can configure your app reading [Configuration](configuration.md), and be sure 
of configure **web.php** and **console.php** files.


### Step 3: run migrations

You need to install required tables, by running, from your framework directory:

```
php yii migrate/up --migrationPath=@vendor/macklus/yii2-payments/migrations/
```

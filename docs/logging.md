# Logging

**IMPORTANT:**

Previous to 2.0 version, logging was just php file_put_contents functions, using config variables logDir and logDirPerms.

From 2.0, we use integrated [Yii2 loggin](https://www.yiiframework.com/doc/guide/2.0/en/runtime-logging), this change allow
you to define and use multiple loggers, and fine tunning your log info, thats why is so important to implement it. Even that, this
changes break backwards compatibily, so we move version to 2.0.

**This file explain how you should config loggin from version 2.0.**

You should configure your web and console files, using Yii log component. We use **macklus\payments** loggin category, so 
you can log all from this plugin by using:

```php
'log' => [
    'flushInterval' => 1,
    'targets' => [
        [
            'class' => 'yii\log\FileTarget',
            'levels' => ['error', 'warning', 'info', 'trace'],
            'logFile' => '@runtime/logs/payments-redsys-trace.log',
            'categories' => ['macklus\payments\RedsysController'],
        ],
        [
            'class' => 'yii\log\FileTarget',
            'levels' => ['error', 'warning', 'info', 'trace'],
            'logFile' => '@runtime/logs/payments-trace.log',
            'categories' => ['macklus\payments\*'],
        ],
        [
            'class' => 'yii\log\FileTarget',
            'levels' => ['error', 'warning', 'info', 'trace'],
        ],
    ],
],

```

- First array define loggin of all RedsysController events
- Second array define loggin of all other events

Usually, you always use somthing like array 2, but you can personalice it as you need.


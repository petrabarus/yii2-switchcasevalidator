# Yii2 Switch Case Validator

Validator that will run on switch-case-like conditional

[![Latest Stable Version](https://poser.pugx.org/petrabarus/yii2-switchcasevalidator/v/stable.svg)](https://packagist.org/packages/petrabarus/yii2-switchcasevalidator)
[![Total Downloads](https://poser.pugx.org/petrabarus/yii2-switchcasevalidator/downloads.svg)](https://packagist.org/packages/petrabarus/yii2-switchcasevalidator)
[![Latest Unstable Version](https://poser.pugx.org/petrabarus/yii2-switchcasevalidator/v/unstable.svg)](https://packagist.org/packages/petrabarus/yii2-switchcasevalidator)
[![Build Status](https://travis-ci.org/petrabarus/yii2-switchcasevalidator.svg?branch=add-travis-ci)](https://travis-ci.org/petrabarus/yii2-switchcasevalidator)

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist petrabarus/yii2-switchcasevalidator "*"
```

or add

```
"petrabarus/yii2-switchcasevalidator": "*"
```

to the require section of your `composer.json` file.

## Requirement

This package require

- Latest Yii2
- PHP 5.4 or later

## Usage

Add something like this in the model `rules()`.

```php
    //Assuming the model has attribute case, field1, and field2.
    //Each rule group will be validated when the case attribute match the cases.
    public function rules() {
        ['case', PetraBarus\Yii2\SwitchCaseValidator\Validator::class,
            //For PHP 5.4, you can use PetraBarus\Yii2\SwitchCaseValidator\Validator::className() or
            // string 'PetraBarus\Yii2\SwitchCaseValidator\Validator'
            'cases' => [
                1 => [
                    ['field1', 'required'],
                ],
                2 => [
                    ['field1', 'compare', 'compareValue' => 'Test']
                ],
                3 => [
                    ['field1', 'compare', 'compareValue' => 'Value 1'],
                    ['field2', 'email']
                ]
            ]
        ]
    }
```

Or see the test files.

## Test

To run test, execute

```
  $ phpunit
```

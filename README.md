# Laravel Identifiable
[![Build Status](https://travis-ci.org/halfpetal/laravel-module-identifiable.svg?branch=master)](https://travis-ci.org/halfpetal/laravel-module-identifiable)
[![Total Downloads](https://poser.pugx.org/halfpetal/laravel-identifiable/downloads)](https://packagist.org/packages/halfpetal/laravel-identifiable)
[![Latest Stable Version](https://poser.pugx.org/halfpetal/laravel-identifiable/version)](https://packagist.org/packages/halfpetal/laravel-identifiable)
[![License](https://poser.pugx.org/halfpetal/laravel-identifiable/license)](https://packagist.org/packages/halfpetal/laravel-identifiable)

## Supported Versions
| Laravel Version 	| Tested            	| Working           	|
|-----------------	|-------------------	|-------------------	|
| v5.5            	| :heavy_check_mark: 	| :heavy_check_mark: 	|

## About
Laravel Identifiable is a package that allows you to add an `Identifiable` trait to any model and will create unique identifiers for it. It also provides automatic route-key binding with the identifier system. 

## Installation
```php
composer require halfpetal/laravel-identifiable
```

If you use Laravel 5.5+, you have nothing else to do. If not, add our service provider to `config/app.php`
```php
'providers' => [
    ...
    Halfpetal\Laravel\Identifiable\IdentifiableServiceProdiver::class,
    ...
];
```

Once that is done, just publish the migrations!
```php
php artisan vendor:publish --provider="Halfpetal\Laravel\Identifiable\IdentifiableServiceProdiver" --tag="migrations"
```

Then you migrate when ready.
```php
php artisan migrate
```

## Setting Up Models
It's simple, just add the `Identifiable` trait to the model you want to use the identifier system on.

```php
use Halfpetal\Laravel\Identifiable\Traits\Identifiable;

class User extends Model
{
  use Identifiable;
  ...
}
```

## How to Use
You don't need to know how to do anything! It just works right out of the box. Instead of exposing the model's id, it will now show the unique identifier generated for it.

## Customization/Configuration
### Identifier Length
If you would like to set different identifier length you can do that by adding the following to your model:
```php
protected static $idLength = 12; // This will generate identifiers with a length of 12 characters
```

### Disable Auto-generation of Identifiers
If for some strange reason you would like to have more control over the process (**and in turn also breaking route binding functionality if you don't generate the identifiers**) you can do that by setting the following variable:
```php
protected static $idNoAutoGenerate = true;
```

This can be helpful in some cases where you want to allow custom identifiers; just remember though that each identifier **must be** unique to the model.

### Unique Identifiers
Each identifier is unique based off of the type and the value. So for example...you have a comment and a post both with the same slug...

| Value       	| Type        	|                          	|
|-------------	|-------------	|--------------------------	|
| wow-amazing 	| App\Post    	| :heavy_check_mark:       	|
| wow-amazing 	| App\Comment 	| :heavy_check_mark:       	|
| wow-amazing 	| App\Post    	| :heavy_multiplication_x: 	|

The third one fails because it's not unique to `App\Post`. However, if it were say `App\Video`, or something else, it would work just fine. 

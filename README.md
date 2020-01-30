# An easy way to use bencoding with Laravel.

[![Latest Stable Version](https://poser.pugx.org/cornford/bencoded/version.png)](https://packagist.org/packages/cornford/Bencoded)
[![Total Downloads](https://poser.pugx.org/cornford/bencoded/d/total.png)](https://packagist.org/packages/cornford/Bencoded)
[![Build Status](https://travis-ci.org/bradcornford/Bencoded.svg?branch=master)](https://travis-ci.org/bradcornford/Bencoded)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/bradcornford/Bencoded/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/bradcornford/Bencoded/?branch=master)

### For Laravel 5.x, check [version 2.0.0](https://github.com/bradcornford/Bencoded/tree/v2.0.0)

### For Laravel 4.x, check [version 1.0.0](https://github.com/bradcornford/Bencoded/tree/v1.0.0)

Think of Bencoded as an easy way to use bencoding with Laravel. These include:

- `Bencoded::encode`
- `Bencoded::decode`

## Installation

Begin by installing this package through Composer. Edit your project's `composer.json` file to require `cornford/bencoded`.

    "require": {
        "cornford/bencoded": "2.*"
    }

Next, update Composer from the Terminal:

    composer update

Once this operation completes, the next step is to add the service provider. Open `app/config/app.php`, and add a new item to the providers array.

    'Cornford\Bencoded\Providers\BencodedServiceProvider',

The final step is to introduce the facade. Open `app/config/app.php`, and add a new item to the aliases array.

    'Bencoded'         => 'Cornford\Bencoded\Facades\BencodedFacade',

That's it! You're all set to go.

## Usage

It's really as simple as using the Bencoded class in any Controller / Model / File you see fit with:

`Bencoded::`

This will give you access to

- [Encode](#encode)
- [Decode](#decode)

### Encode

The `encode` method encodes an item into a bencoding format.

    Bencoded::encode([['name' => 'tom'], ['name' => 'jerry']]);

### Decode

The `decode` method decodes a bencoding string into PHP types.

    Bencoded::decode('ld4:name3:tomed4:name5:jerryee);

### License

Bencoded is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
<?php namespace Cornford\Bencoded\Facades;

use Illuminate\Support\Facades\Facade;

class Bencoded extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'bencoded';
    }
}

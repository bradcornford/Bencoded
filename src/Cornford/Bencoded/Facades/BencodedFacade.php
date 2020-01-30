<?php namespace Cornford\Bencoded\Facades;

use Illuminate\Support\Facades\Facade;

class BencodedFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'bencoded';
    }
}

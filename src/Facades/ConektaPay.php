<?php

namespace ApsCreativas\ConektaPay\Facades;

use Illuminate\Support\Facades\Facade;

class ConektaPay extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'conekta';
    }
}
<?php

namespace Elite\StrowalletLaravel;

use Illuminate\Support\Facades\Facade;

class StrowalletFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Strowallet::class;
    }
}

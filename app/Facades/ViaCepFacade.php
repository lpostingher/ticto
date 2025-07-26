<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class ViaCepFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'via-cep';
    }
}

<?php


namespace App\Token;


use Illuminate\Support\Facades\Facade;

class TokenFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'Token';
    }
}

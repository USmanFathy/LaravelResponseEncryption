<?php

namespace UsmanAhmed\LaravelResponseEncryption\Facades;
use Illuminate\Support\Facades\Facade;

/**
 * @method static string encrypt($data)
 * @method static void disable()
 * @method static void enable()
 * @method static bool isDisabled()
 */
class ResponseEncryption extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'response.encryption';
    }
}
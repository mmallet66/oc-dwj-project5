<?php

namespace Occazou;

abstract class Autoloader
{
    public static function register()
    {
        spl_autoload_register(array(__CLASS__, 'autoload'));
    }

    private static function autoload($class)
    {
        $class = str_replace(__NAMESPACE__.'\\', '', $class);
        $class = explode('\\',$class);

        foreach($class as $key => $value) {
            ($key == count($class)-1) || $class[$key] =    strtolower($value).'/';
        }

        $class = implode($class);
        require_once $class .'.php';
    }
}

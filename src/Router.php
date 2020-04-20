<?php

namespace Occazou\Src;

class Router
{
    private static $views = ['connection', 'search'];

    public static function routeRequest()
    {
        try
        {
            if(isset($_GET['action'])):
                if(in_array($_GET['action'], self::$views)):
                    $controller = new Controller\Controller();
                    $method = 'get'.ucfirst($_GET['action']);

                    (method_exists($controller,$method))? $controller->$method($_GET['req']) : $controller->getView($_GET['action']);
                else:
                    throw new \Exception("Désolé cette page n'existe pas.");
                endif;
            else:
                $controller = new Controller\Controller();
                $controller->getView('home');
            endif;
        }
        catch (\Exception $e)
        {
            $errorMessage = $e->getMessage();
            $controller = new Controller\Controller();
            $controller->getView('error', ['errorMessage'=>$errorMessage]);
        }
    }
}
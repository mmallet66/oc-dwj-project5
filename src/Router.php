<?php

namespace Occazou\Src;

class Router
{
    private static $views = ['connection', 'connect-user', 'search', 'disconnect-user', 'registration', 'new-user', 'create-announce', 'new-announce', 'user-account', 'update-user', 'update-password', 'user-announces', 'delete-announce', 'announce'];
    private static $adminActions = [];

    public static function routeRequest()
    {
        try
        {
            if(isset($_GET['role']) && $_GET['role'] == 'admin'):
                self::adminRoute();
            else:
                self::userRoute();
            endif;
        }
        catch (\Exception $e)
        {
            $errorMessage = $e->getMessage();
            $controller = new Controller\Controller();
            $controller->getView('error', ['errorMessage'=>$errorMessage]);
        }
    }

    public static function adminRoute()
    {
        $controller = new Controller\AdminController();
        if($controller->checkIfAdmin()):
            if(!empty($_GET['action'])):
                if(in_array($_GET['action'], self::$adminActions)):
                    $method = self::defineMethodName($_GET['action']);

                    $controller->$method($_GET['req']);
                else:
                    throw new \Exception("Désolé cette page n'existe pas.");
                endif;
            else:
                $controller->getAdmin();
            endif;
        else:
            throw new \Exception('Vous n\'êtes pas administrateur !');
        endif;
    }

    public static function userRoute()
    {
        if(isset($_GET['action'])):
            if(in_array($_GET['action'], self::$views)):
                $controller = new Controller\Controller();
                $method = self::defineMethodName($_GET['action']);

                (method_exists($controller,$method))? $controller->$method($_GET['req']) : $controller->getView($_GET['action']);
            else:
                throw new \Exception("Désolé cette page n'existe pas.");
            endif;
        else:
            $controller = new Controller\Controller();
            $controller->getView('home');
        endif;
    }

    private static function defineMethodName(string $methodName)
    {
        $methodName = explode('-', $methodName);
        foreach($methodName AS $key => $value):
            $methodName[$key] = ($key == 0)? $value : ucfirst($value);
        endforeach;
        $methodName = implode('', $methodName);

        return $methodName;
    }
}
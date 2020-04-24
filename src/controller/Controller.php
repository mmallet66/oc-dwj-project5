<?php

namespace Occazou\Src\Controller;

/**
 * Class Controller
 */
class Controller
{
    /**
     * Generate a view
     * 
     * @param string $view View's name
     * @param array $data=null
     */
    public function getView(string $view, array $data=null)
    {
        $view = new \Occazou\Src\View\View($view);
        $view->generate($data);
    }

    public function newUser()
    {
        $userController = new UserController();
        $userController->new();
    }

    public function connectUser()
    {
        $userController = new UserController();
        $userController->connect();
    }

    public function disconnectUser()
    {
        $this->getSession();
        $userController = new UserController();
        $userController->disconnect();
    }

    public function getSession()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }
}
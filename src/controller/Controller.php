<?php

namespace Occazou\Src\Controller;

/**
 * Class Controller
 */
class Controller
{
    public function __construct()
    {
        $this->getSession();
    }

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
        $userController->checkPassword();
    }
    
    public function disconnectUser()
    {
        $userController = new UserController();
        $userController->disconnect();
    }

    public function updateUser()
    {
        $userController = new UserController();
        $userController->updateUser();
    }

    public function updatePassword()
    {
        $userController = new UserController();
        $userController->updatePassword();
    }

    public function userAccount()
    {
        $userController = new UserController();
        $userController->getUserAccount();
    }

    public function newAnnounce()
    {
        $announceController = new AnnounceController();
        $announceController->new();
    }

    public function userAnnounces()
    {
        $announceController = new AnnounceController();
        $announceController->getUserAnnounces();
    }

    public function getSession()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }
}
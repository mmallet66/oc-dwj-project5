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

    public function userAccount()
    {
        $userController = new UserController();
        $userController->getUserAccount();
    }

    public function newAnnounce()
    {
        $user = new \Occazou\Src\Model\User();
        $userModel = new \Occazou\Src\Model\UserModel();
        $user->hydrate($userModel->getUser($_SESSION['username']));

        $announceController = new AnnounceController();
        $announceController->new([
            'authorId'=>$user->getId(),
            'authorUsername'=>$user->getUsername(),
            'city'=>$user->getCityName(),
        ]);
    }

    public function getSession()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }
}
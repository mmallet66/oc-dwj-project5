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
        if(!empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['email'])):
            $user = new \Occazou\Src\Model\User();
            $user->hydrate($_POST);

            $userModel = new \Occazou\Src\Model\UserModel();
            if($userModel->isNotFree($user->getUsername())):
                echo 0;
            else:
                $userModel->addUser($user);
                echo 1;
            endif;
        endif;
    }

    /**
     * Creates the session when a user tries to connect
     */
    public function connectUser()
    {
        if(!empty($_POST['username']) && !empty($_POST['password'])):

            $userModel = new \Occazou\Src\Model\UserModel();
            $user = new \Occazou\Src\Model\User();
            $user->hydrate($userModel->getUser($_POST['username']));

            if(password_verify($_POST['password'], $user->getPassword())):
                session_start();
                $_SESSION['username'] = $user->getUsername();
                echo 'true';
            else:
                echo 'false';
            endif;

        endif;
    }

    public function disconnectUser()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if(!empty($_SESSION['username'])):
            session_unset();
            header('Location:/');
        else:
            throw new \Exception('');
        endif;
    }
}
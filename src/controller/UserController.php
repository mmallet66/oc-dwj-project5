<?php

namespace Occazou\Src\Controller;

/**
 * Class Controller
 */
class UserController
{


    public function new()
    {
        if(!empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['email']) && !empty($_POST['city_name'])):
            $user = new \Occazou\Src\Model\User();
            $user->hydrate($_POST);

            $userModel = new \Occazou\Src\Model\UserModel();
            if($userModel->isNotFree($user->getUsername())):
                echo 'Le nom d\'utilisateur est déjà pris.';
            else:
                $cityModel = new \Occazou\Src\Model\CityModel();
                $user->city->setId($cityModel->getCityId($user->city));
                $userModel->addUser($user);
                echo 1;
            endif;
        else:
            echo 'Veuillez remplir tous les champs nécessaires.';
        endif;
    }

    /**
     * Creates the session when a user tries to connect
     */
    public function connect()
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

    public function disconnect()
    {
        if(!empty($_SESSION['username'])):
            session_unset();
            header('Location:/');
        else:
            throw new \Exception('');
        endif;
    }
}
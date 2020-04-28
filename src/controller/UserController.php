<?php

namespace Occazou\Src\Controller;

/**
 * Class Controller
 */
class UserController
{
    public $userModel;
    public $user;

    public function __construct()
    {
        $this->userModel = new \Occazou\Src\Model\UserModel();
        $this->user = new \Occazou\Src\Model\User();
    }

    public function new()
    {
        if(!empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['email']) && !empty($_POST['city_name'])):
            $this->user->hydrate($_POST);

            if($this->userModel->isNotFree($this->user->getUsername())):
                echo 'Le nom d\'utilisateur est déjà pris.';
            else:
                $cityModel = new \Occazou\Src\Model\CityModel();
                $this->user->city->setId($cityModel->getCityId($this->user->city));
                echo ($this->userModel->addUser($this->user))? 1 : 'Une erreur s\'est produite, veuillez réessayer';
            endif;
        else:
            echo 'Veuillez remplir tous les champs nécessaires.';
        endif;
    }

    /**
     * Creates the session when a user tries to connect
     */
    public function checkPassword()
    {
        if(!empty($_POST['username']) && !empty($_POST['password'])):

            $this->user->hydrate($this->userModel->getUser($_POST['username']));

            if(password_verify($_POST['password'], $this->user->getPassword())):
                $_SESSION['username'] = $this->user->getUsername();
                $_SESSION['id'] = $this->user->getId();
                echo 1;
            else:
                echo 0;
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

    public function getUserAccount()
    {
        (!empty($_SESSION['username']))&& $this->user->hydrate($this->userModel->getUser($_SESSION['username']));
        $view = new \Occazou\Src\View\View('userAccount');
        $view->generate(['user'=>$this->user]);
    }

    public function updateUser()
    {
        if(!empty($_POST['username']) && !empty($_POST['email']) && !empty($_POST['city_name'])):
            $this->user->hydrate($_POST);
            $this->user->setId($_SESSION['id']);
            $cityModel = new \Occazou\Src\Model\CityModel();
            $this->user->getcity()->setId($cityModel->getCityId($this->user->getcity()));
            echo ($this->userModel->updateUser($this->user))? true : 'Une erreur s\'est produite, veuillez réessayer';
        else:
            echo 'Veuillez remplir tous les champs nécessaires !';
        endif;
    }

    public function updatePassword()
    {
        $passwordChanged = (isset($_POST['passwordChanged']))? $_POST['passwordChanged']:0;
        if($passwordChanged && !empty($_POST['password'])):
            $this->user->setUsername($_SESSION['username']);
            $this->user->setId($_SESSION['id']);
            $this->user->setPassword($_POST['password']);
            echo ($this->userModel->updateUserPassword($this->user))? true : 'Une erreur s\'est produite, le mot de passe n\'a pas été modifié';
        endif;
    }
}